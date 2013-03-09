<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Controller for Event administration
*
* Created: 11/01/2013
* @author	Jontahan Val <jdv2@hw.ac.uk>
*/
class Scheduler extends CI_Controller // My_Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/Event_model');
		$this->load->model('admin/Location_model');
		$this->load->model('admin/Umpire_model');
		$this->load->model('team/Team_model');
		$this->load->model('admin/Match_model');
	}

	public function scheduleWattball($id)
	{
		// get event and registrations
		$event = $this->Event_model->getEvent($id);
		$teams = $this->Event_model->getEventRegistrations($id, 10000, 0);
		// set date format to be used
		$dateFormat = "Y-m-d";
		// get event times
		$eventStart = DateTime::createFromFormat($dateFormat, $event['start']);
		$eventEnd = DateTime::createFromFormat($dateFormat, $event['end']);
		// shuffle the teams
		shuffle($teams);
		// get a list of just the teams ids, we don't actually need anything else (should probably be done in the model / make another SQL statement...)
		$teamIds = $this->idsOnly($teams);
		// get duration in time interval
		$durationArray = explode(":", $event['duration']);
		// remove leading zeroes.
		for($i = 0; $i<count($durationArray); $i++)
		{
			if ($durationArray[$i] == "00")
			{
				$durationArray[$i] = "0";
			}
			else if ($durationArray[$i] != "00")
			{
				$durationArray[$i] = ltrim($durationArray[$i], '0');
			}
		}		
		// format the string properly
		$durationString = "P";
		if ($durationArray[0] != "0")
		{
			$durationString .=$durationArray[0] . "H";
		}
		if ($durationArray[1] != "0")
		{
			$durationString .= $durationArray[1] . "M";
		}
		$duration = new DateInterval($durationString);
		
		// get the total number of games, total event days, games per day, and how many days between each match
		$totalGames = (count($teams)/2)*(count($teams)-1);
		$totalEventDays = $eventStart->diff($eventEnd)->format("%d")+1;
		$gamesPerDay = $totalGames/$totalEventDays;
		$gameEvery = $totalEventDays / $totalGames;
		// if games per day is less than 1 we just set it to one
		if ($gamesPerDay < 1)
		{
			$gamesPerDay = 1;
		}
		// otherwise we round up
		else {
			$gamesPerDay = ceil($gamesPerDay);
		}
		// if we need the ocasional break in matches
		if ($gameEvery == 1)
		{
			$skipDayAfter = -1;
		}
		else 
		{
			$skipDayAfter = pow($gameEvery-floor($gameEvery), -1);
		}
		// set games rounds games every x days down or set it to 1
		if ($gameEvery < 1)
		{
			$gameEvery = 1;
		}
		else
		{
			$gameEvery = floor($gameEvery);
		}
		// if we need to have more games on some days than other
		if ($skipDayAfter == -1 || $skipDayAfter % 1 == 0) 
		{
			$minusOneMatch = -1;
		}
		else
		{
			$minusOneMatch = pow($skipDayAfter-floor($skipDayAfter), -1);
		}
		
		// get the number of rounds
		$rounds = count($teams);
		// if even substract we substract one round
		if ($rounds % 2 == 0)
		{
			$rounds--;
		} 
		// if uneven number of teams we put a dummy team in the array
		if (count($teams) % 2 != 0)
		{
			array_push($teams, -1);
		}
		// initial values
		$dayInc = 0;
		$currentDayCount = 0;
		$eventTimes = $this->Event_model->getEvent($id);
		$matchCount = 1;
		// loop over the number of rounds
		for ($i = 0; $i < $rounds; $i++)
		{
			// loop over games per round:
			$day;
			for ($j = 0; $j<count($teams)/2; $j++)
			{
				// if we need to have less games on this particualar day
				if ($minusOneMatch != -1 && $dayInc % $minusOneMatch != 0 && $dayInc != 0)
				{
					$currentDayCount++;
				}
				// if we're in the beginning of the loops
				if ($dayInc == 0)
				{
					$day = clone $eventStart;
					$dayInc++;
				}
				// we need to go to the next day
				if ($currentDayCount == $gamesPerDay & $totalEventDays > $dayInc)
				{
					// set variables
					$currentDayCount = 0;
					$dayInc++;
					// add the correct number of days
					$day->add(new DateInterval('P' . $gameEvery . "D"));
					// if we need to skip another day
					if ($skipDayAfter != -1)
					{
						if ($dayInc % $skipDayAfter == 0 && is_int($skipDayAfter))
						{
							$day->add(new DateInterval('P' . $gameEvery . "D")); // should this be one day and not "gameEvery" ? test probably needed
						}
					}
				}
				// if we overshoot we break, should never happen
				if ($day > $eventEnd)
				{
					break;
				}
				// select teams:
				$team1 = $teamIds[$j];
				$team2 = $teamIds[(count($teamIds)-1) - $j];
				// if either team is the dummy we skip the match
				if ($team1 != -1 || $team2 != -1)
				{
					// get event times
					$eventTimes = $this->Event_model->getEventTimes($id);
					// lets shuffle event times so we don't get the same time all the time
					shuffle($eventTimes);
					$umpire = null;
					$location = null;
					$curTime = null;
					$ok = false;
					// we need a while loop for checking umpire and location availability
					while ($ok == false) 
					{
						$impossible = false;
						// get the match details
						$matchDetails = $this->getMatchDetails($event, $day, $eventTimes, $duration);
						// if we couldn't schedule that day
						if ($matchDetails == false) 
						{
							$ok = false;
						}
						// if we could schedule that match day day
						else
						{
							$finalDay = $day;
							$ok = true;
						}
						// if the initial day failed we need to bruteforce
						if ($ok == false)
						{
							// bruteforce and see if we can find a day that's ok
							for ($l=1; $l <= $totalEventDays; $l++)
							{
								// date interval from the original date
								$dateInterval = new DateInterval("P" . $l . "D");
								// get the previous day and the next day
								$prevDay = (clone $day);
								$prevDay->sub($dateInterval);
								$nextDay = (clone $day);
								$nextDay->add($dateInterval);
								// if both overshoot event boundaries the schedule is impossible
								if ($prevDay < $eventStart && $nextDay > $eventEnd)
								{
									$impossible = true;
									break;
								}
								else
								{
									// make sure the day is in the range
									if ($prevDay >= $eventStart)
									{
										// get match details
										$matchDetails = $this->getMatchDetails($event, $prevDay, $eventTimes, $duration);
										if ($matchDetails == false) 
										{
											$ok = false;
										}
										else
										{
											$finalDay = $prevDay;
											$ok = true;
										}
									}
									// if the previous day don't work, we try the next day
									else if ($nextDay <= $eventEnd && $ok == false)
									{
										// get the match details
										$matchDetails = $this->getMatchDetails($event, $nextDay, $eventTimes, $duration);
										if ($matchDetails == false) 
										{
											$ok = false;
										}
										else
										{
											$finalDay = $nextDay;
											$ok = true;
										}
									}
								}
							}
						}
						// if we either found a match OR the schedule is impossible we should break out of the loops
						if ($ok == true || $impossible = true)
						{
							break;
						}
						//$ok = true; // TODO: DUMMMY REMOVE
					} 
					// if ok
					if ($ok == true)
					{
						//echo "{$team1} vs {$team2} on: " . $finalDay->format("Y-m-d") . " at: " . $matchDetails['time'] . " location: " . $matchDetails['location'] . " umpire: " . $matchDetails['umpire'];
						// increment counts
						$currentDayCount++;
						$matchCount++;
						
						// insert into database:
						$postdata = array(
							'eventId' => $id,	
							'locationId' => $matchDetails["location"],					
							'umpireId' => $matchDetails["umpire"],					
							'date' => $finalDay->format("Y-m-d"),					
							'time' => $matchDetails["time"],			
							'team1Id' => $team1,	
							'team2Id' => $team2,
							'status' => "scheduled",	
							'round' => $i+1	
						);
						$this->Match_model->create($postdata);
					}
					else
					{
						return false;
					}
				}
				
			}
			$teamIds = $this->nextRound($teamIds);
		}
		
	}

	public function scheduleHurdling($id)
	{

	}
	
	private function getMatchDetails($event, $day, $eventTimes, $duration) {
		for ($k = 0; $k < count($eventTimes); $k++)
		{
			$array = $eventTimes[$k];
			$curTime = $array['start'];
			$umpire = $this->Umpire_model->getFreeUmpireForEvent($event['eventId'], $day->format("y-m-d"), $curTime, $duration);
			$location = $this->Location_model->getFreeLocation($event['sportId'], $day->format("y-m-d"), $curTime, $duration);
			
			if ($umpire != false && $location != false)
			{
				$result = array();
				$result['time'] = $curTime;
				$result['umpire'] = $umpire;
				$result['location'] = $location;
				return $result;
			}
		}
		return false;
	}
	
	private function idsOnly($teams)
	{
		$teamIds = array();
		// athletes
		if (!empty($regs[0]['athleteId']))
		{
			echo "WRONG!";
		}
		// watball
		else
		{
			for ($i = 0; $i<count($teams); $i++)
			{
				$teamIds[$i] = $teams[$i]['nwaId'];
			}
		}
		return $teamIds;
	}
	
	private function nextRound($teams)
	{
		$newArray = array();
		$newArray[0] = $teams[0];
		for ($i = 1; $i < count($teams); $i++)
		{
			$oldIndex = ($i-1)%count($teams);
			if ($oldIndex == 0)
			{
				$oldIndex = count($teams)-1;
			}
			$newArray[$i] = $teams[$oldIndex];
		}
		return $newArray;
	}
}