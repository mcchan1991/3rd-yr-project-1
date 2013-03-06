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
		$event = $this->Event_model->getEvent($id);
		$teams = $this->Event_model->getEventRegistrations($id, 10000, 0);
		$dateFormat = "Y-m-d";
		$eventStart = DateTime::createFromFormat($dateFormat, $event['start']);
		$eventEnd = DateTime::createFromFormat($dateFormat, $event['end']);
		//print_r($teams);
		shuffle($teams); // shuffle the teams
		//$this->printRegistrations($teams);
		$teamIds = $this->idsOnly($teams);
		//print_r($teamIds); echo "<br />";
		$umpires = $this->Umpire_model->getUmpiresForEvent($id);
		//print_r($umpires);
		echo "<br />";
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
		//echo $this->Location_model->getFreeLocation(1, "2013-05-22", "17:00:00", $duration);
		//echo $this->Umpire_model->getFreeUmpireForEvent($id, "2013-05-22", "17:00:00", $duration);
		$totalGames = (count($teams)/2)*(count($teams)-1);
		$totalEventDays = $eventStart->diff($eventEnd)->format("%d")+1;

		$gamesPerDay = $totalGames/$totalEventDays;
		$gameEvery = $totalEventDays / $totalGames;

		echo $gamesPerDay;
		if ($gamesPerDay < 1)
		{
			$gamesPerDay = 1;
		}
		else {
			$gamesPerDay = ceil($gamesPerDay);
		}
		if ($gameEvery == 1)
		{
			$skipDayAfter = -1;
		}
		else 
		{
			$skipDayAfter = pow($gameEvery-floor($gameEvery), -1);
		}
		if ($gameEvery < 1)
		{
			$gameEvery = 1;
		}
		else
		{
			$gameEvery = floor($gameEvery);
		}

		//echo $gameEvery;
		
		$rounds = count($teams);
		// if even substract one round
		if ($rounds % 2 == 0)
		{
			$rounds--;
		} 
		if (count($teams) % 2 != 0)
		{
			array_push($teams, -1);
		}
		$dayInc = 0;
		$currentDayCount = 0;
		$eventTimes = $this->Event_model->getEvent($id);
		$matchCount = 1;
		echo "total games: " . $totalGames . " total rounds: " . $rounds . " games every: " . $gameEvery . " games per day: " . $gamesPerDay . " event days: " . $totalEventDays . " break after: " . $skipDayAfter . "<br />";
		echo "event start: " . $eventStart->format("y-m-d") . " event end: " . $eventEnd->format("y-m-d") . "<br />";
		
		/*$umpire = $this->Umpire_model->getFreeUmpireForEvent($id, "2013-05-22", "15:00:00", $duration);
		echo $umpire;*/
		
		for ($i = 0; $i < $rounds; $i++)
		{
			echo "---- ROUND " . ($i+1) . "---- <br />";
			// games per round:
			$day;
			for ($j = 0; $j<count($teams)/2; $j++)
			{
				if ($dayInc == 0)
				{
					$day = clone $eventStart;
					$dayInc++;
				}
				//echo "currentDayCount: " . $currentDayCount .  " dayInc: " . $dayInc . "<br />";
				if ($currentDayCount == $gamesPerDay & $totalEventDays > $dayInc)
				{
					$currentDayCount = 0;
					$dayInc++;
					$day = $day->add(new DateInterval('P' . $gameEvery . "D"));
					if ($skipDayAfter != -1)
					{
						if ($dayInc % $skipDayAfter == 0 && is_int($skipDayAfter))
						{
							$day = $day->add(new DateInterval('P' . $gameEvery . "D"));
						}
					}
				}
				if ($day > $eventEnd)
				{
					break;
				}
				//echo "initial day: " . $day->format("Y-m-d") . "<br />";
				// select teams:
				$team1 = $teamIds[$j];
				$team2 = $teamIds[(count($teamIds)-1) - $j];
				// if either team is the dummy we skip the match
				if ($team1 != -1 || $team2 != -1)
				{
					
					// get event times
					$eventTimes = $this->Event_model->getEventTimes($id);
					//print_r($eventTimes);
					$ok = false;
					// lets shuffle event times so we don't get the same time all the time
					shuffle($eventTimes);
					$umpire = null;
					$location = null;
					$curTime = null;
					
					while ($ok == false) 
					{
						$impossible = false;
						for ($k = 0; $k < count($eventTimes); $k++)
						{
							$array = $eventTimes[$k];
							$curTime = $array['start'];
							//echo $curTime . "<br />";
							$umpire = $this->Umpire_model->getFreeUmpireForEvent($id, $day->format("Y-m-d"), $curTime, $duration);
							$location = $this->Location_model->getFreeLocation($event['sportId'], $day->format("Y-m-d"), $curTime, $duration);
							
							if ($umpire != false && $location != false)
							{
								//echo "ok start";
								$finalDay = $day;
								$ok = true;
								break;
							}
						}
						
						if ($ok == false)
						{
							// bruteforce and see if we can find a day that's ok
							for ($l=1; $l <= $totalEventDays; $l++)
							{
								$dateInterval = new DateInterval("P" . $l . "D");
								$prevDay = (clone $day);
								$prevDay->sub($dateInterval);
								$nextDay = (clone $day);
								$nextDay->add($dateInterval);
								//echo "prevDay: " . $prevDay->format("Y-m-d") . " nextDay: " . $nextDay->format("Y-m-d") . "<br />";
								if ($prevDay < $eventStart && $nextDay > $eventEnd)
								{
									$impossible = true;
									break;
								}
								else
								{
									//echo $prevDay->format("Y-m-d") . ">=" . $eventStart->format("Y-m-d") . "<br />";
									if ($prevDay >= $eventStart)
									{
										//echo "this never happens or does it?";
										for ($k = 0; $k < count($eventTimes); $k++)
										{
											$curTime = $array['start'];
											$umpire = $this->Umpire_model->getFreeUmpireForEvent($id, $prevDay->format("Y-m-d"), $curTime, $duration);
											$location = $this->Location_model->getFreeLocation($event['sportId'], $prevDay->format("Y-m-d"), $curTime, $duration);
											
											if ($umpire != false && $location != false)
											{
												//echo "OK";
												$finalDay = $prevDay;
												$ok = true;
											}
										}
									}
									else if ($nextDay <= $eventEnd && $ok == false)
									{
										for ($k = 0; $k < count($eventTimes); $k++)
										{
											$curTime = $array['start'];
											$umpire = $this->Umpire_model->getFreeUmpireForEvent($id, $nextDay->format("y-m-d"), $curTime, $duration);
											$location = $this->Location_model->getFreeLocation($event['sportId'], $nextDay->format("y-m-d"), $curTime, $duration);
											
											if ($umpire != false && $location != false)
											{
												//echo "OK";
												$finalDay = $nextDay;
												$ok = true;
											}
										}
									}
								}
							}
						}
						
						if ($ok == true || $impossible = true)
						{
							break;
						}
						//$ok = true; // TODO: DUMMMY REMOVE
					}
					if ($ok == true)
					{
						echo "{$team1} vs {$team2} on: " . $finalDay->format("Y-m-d") . " at: " . $curTime . " location: " . $location . " umpire: " . $umpire;
						$currentDayCount++;
						echo "<br >";
						$matchCount++;
						
						// insert into database:
						$postdata = array(
							'eventId' => $id,	
							'locationId' => $location,					
							'umpireId' => $umpire,					
							'date' => $finalDay->format("Y-m-d"),					
							'time' => $curTime,			
							'team1Id' => $team1,	
							'team2Id' => $team2,
							'status' => "scheduled",	
							'round' => $i+1	
						);
						$this->Match_model->create($postdata);
					}
					else
					{
						echo "schedule impossible";
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

	private function printRegistrations($regs)
	{
		// athletes
		if (!empty($regs[0]['athleteId']))
		{
			echo "WRONG!";
		}
		// watball
		else
		{
			for ($i = 0; $i<count($regs); $i++)
			{
				echo $this->Team_model->getTeamName($regs[$i]['nwaId']) . "<br />";
			}
		}
	}

	function array_cartesian($arrays) {
		$result = array();
		$keys = array_keys($arrays);
		$reverse_keys = array_reverse($keys);
		$size = intval(count($arrays) > 0);
		foreach ($arrays as $array) {
			$size *= count($array);
		}
		for ($i = 0; $i < $size; $i ++) {
			$result[$i] = array();
			foreach ($keys as $j) {
				$result[$i][$j] = current($arrays[$j]);
			}
			foreach ($reverse_keys as $j) {
				if (next($arrays[$j])) {
					break;
				}
				elseif (isset ($arrays[$j])) {
					reset($arrays[$j]);
				}
			}
		}
		return $result;
	}
	
	function idsOnly($teams)
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