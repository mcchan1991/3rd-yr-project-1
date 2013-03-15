<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Controller for Scheduling
*
* Created: 11/01/2013
* @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
*/
class Scheduler extends My_Admin_Controller 
{
	private $minusOne = false;
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/Event_model');
		$this->load->model('admin/Location_model');
		$this->load->model('admin/Umpire_model');
		$this->load->model('team/Team_model');
		$this->load->model('admin/Match_model');
		$this->load->model('admin/Tournament_model');
	}
	
	public function index($id)
	{
		$event = $this->Event_model->getEvent($id);
		if ($event['sportId'] == 1)
		{
			$this->scheduleWattball($event);
		}
		else
		{
			$this->scheduleHurdling($event);
		}
	}
	
	public function manualWattball($id)
	{
		$event = $this->Event_model->getEvent($id);
		$eventRegs = $this->Event_model->getEventRegistrations($id, $this->Event_model->getEventRegistrationsCount($id), 0);
		$data['teams'] = $eventRegs;
		$data['totalGames'] = (count($data['teams'])/2)*(count($data['teams'])-1);
		$data['event'] = $event;
		$data['tournament'] = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['matches'] = $this->Match_model->getPaginationEvent($id, $this->Match_model->countEventMatches($id), 0);
		
		$teams = array();
		foreach($eventRegs as $currentReg)
		{
			$team = $this->Team_model->getTeamName($currentReg['nwaId']);
			$teams[$currentReg['nwaId']] = $team;
		}
		$data['teamNames'] = $teams;
		$data['umpires'] = $this->Umpire_model->getUmpiresForTournamentAndSport($event['tournamentId'], $event['sportId']);
		$data['locations'] = $this->Location_model->getLocationsForSport($event['sportId']);
		$data['retry'] = -1;
		
		$data['team1'] = array();
		$data['team2'] = array();
		$data['umpire'] = array();
		$data['location'] = array();
		$data['date'] = array();
		$data['eventTime'] = array();
		$data['id'] = array();
		
		if (count($data['teams']) < 2)
		{
			// not enough teams
			redirect("/admin/event/viewMatches/{$id}/1/2");
			exit();
		}
		
		$this->load->helper('form');
		$this->template->write_view('content','admin/event/scheduleWattball',$data);
		$this->template->write_view('nav_side','admin/event/navside',$data, true);
		$this->template->render();
	}
	
	public function saveWattball($id)
	{
		$event = $this->Event_model->getEvent($id);
		$eventRegs = $this->Event_model->getEventRegistrations($id, $this->Event_model->getEventRegistrationsCount($id), 0);
		
		$this->load->library('form_validation');
		
		/*$this->form_validation->set_rules("firstName", "First Name", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("surname", "Surname", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("password", "password", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("dob", "Date of birth", "required|min_length[3]|max_length[50]|callback_dobCheck");
		$this->form_validation->set_rules("email", "E-mail", "required|min_length[3]|max_length[50]|valid_email|callback_uniqueEmail");*/
		
		$this->form_validation->set_rules("team1[]", "Event time", "callback_minusOne");
		$this->form_validation->set_rules("team2[]", "Event time", "callback_minusOne");
		$this->form_validation->set_rules("umpire[]", "Event time", "callback_minusOne");
		$this->form_validation->set_rules("location[]", "Event time", "callback_minusOne");

		$this->form_validation->set_rules("date[]", "Date", "required|callback_checkDateFormat");
		$this->form_validation->set_rules("eventTime[]", "Event time", "required|callback_timeCheck");
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['teams'] = $eventRegs;
			$data['totalGames'] = (count($data['teams'])/2)*(count($data['teams'])-1);
			$data['event'] = $event;
			$data['tournament'] = $this->Tournament_model->getTournamentId($event['tournamentId']);
			$data['matches'] = $this->Match_model->getPaginationEvent($id, $this->Match_model->countEventMatches($id), 0);

			$teams = array();
			foreach($eventRegs as $currentReg)
			{
				$team = $this->Team_model->getTeamName($currentReg['nwaId']);
				$teams[$currentReg['nwaId']] = $team;
			}
			$data['teamNames'] = $teams;
			$data['umpires'] = $this->Umpire_model->getUmpiresForTournamentAndSport($event['tournamentId'], $event['sportId']);
			$data['locations'] = $this->Location_model->getLocationsForSport($event['sportId']);
			
			$data['retry'] = 1;
			$data['team1'] = $this->input->post("team1");
			$data['team2'] = $this->input->post("team2");
			$data['umpire'] = $this->input->post("umpire");
			$data['location'] = $this->input->post("location");
			$data['date'] = $this->input->post("date");
			$data['eventTime'] = $this->input->post("eventTime");
			$data['id'] = $this->input->post("id");
			
			$this->load->helper('form');
			$this->template->write_view('content','admin/event/scheduleWattball',$data);
			$this->template->write_view('nav_side','admin/event/navside',$data, true);
			$this->template->render();
		}
		else
		{
			$team1 = $this->input->post("team1");
			$team2 = $this->input->post("team2");
			$umpire = $this->input->post("umpire");
			$location = $this->input->post("location");
			$date = $this->input->post("date");
			$eventTime = $this->input->post("eventTime");
			$ids = $this->input->post("id");

			for ($i = 0; $i < count($ids); $i++)
			{
				$dateFormat = "Y-m-d";
				$curDate = DateTime::createFromFormat("d/m/Y",$date[$i]);
				// new row
				if ($ids[$i] == -1)
				{
					
					// insert into database:
					$postdata = array(
						'eventId' => $id,	
						'locationId' => $location[$i],					
						'umpireId' => $umpire[$i],					
						'date' => $curDate->format($dateFormat),					
						'time' => $eventTime[$i],			
						'team1Id' => $team1[$i],	
						'team2Id' => $team2[$i],
						'status' => "scheduled",	
						'round' => -1	
					);
					$this->Match_model->create($postdata);
				}
				// update current
				else
				{
					$postdata = array(
						'matchId' => $ids[$i],
						'eventId' => $id,	
						'locationId' => $location[$i],					
						'umpireId' => $umpire[$i],					
						'date' => $curDate->format($dateFormat),					
						'time' => $eventTime[$i],			
						'team1Id' => $team1[$i],	
						'team2Id' => $team2[$i],
						'status' => "scheduled",	
						'round' => -1	
					);
					$this->Match_model->create($postdata);
				}
			}
			
			/*$dateFormat = "d/m/Y";
			$dob = DateTime::createFromFormat($dateFormat, $this->input->post("dob"));
			$postdata = array(
				'firstName' => $this->input->post("firstName"),	
				'surname' => $this->input->post("surname"),					
				'email' => $this->input->post("email"),					
				'password' => sha1($this->input->post("password")),					
				'dob' => $dob->format('Y-m-d'),			
				'gender' => $this->input->post("gender"),	
				'fastest' => $this->input->post("fastest")						
			);
			$this->Athlete_model->add_record($postdata);
			
			$id = $this->Athlete_model->getByEmail($this->input->post("email"));
			$id = $id[0];
			$id = $id['athleteId'];
			
			$eventRegsId = $this->Athlete_model->registerAthleteForEvent($eventId, $id);
			
			redirect("/admin/event/viewRegistrations/{$eventId}");*/
		}
	}

	private function scheduleWattball($event)
	{
		$id = $event['eventId'];
		// get event and registrations
		$event = $this->Event_model->getEvent($id);
		$teams = $this->Event_model->getEventRegistrations($id, $this->Event_model->getEventRegistrationsCount($id), 0);
		
		if (count($teams) < 2)
		{
			// not enough teams
			redirect("/admin/event/viewMatches/{$id}/1/2");
			exit();
		}
		
		if ($this->Match_model->countEventMatches($id) > 0) 
		{
			$this->Match_model->deleteMatchesForEvent($id); 
		}
		
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
		$totalEventDays = $eventStart->diff($eventEnd)->days +1;
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
								echo "loop {$l}: prevDay: " . $prevDay->format($dateFormat) . " nextDay: " . $nextDay->format($dateFormat) . " <br />";
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
							'date' => $finalDay->format($dateFormat),					
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
						// schedule impossible
						redirect("/admin/event/viewMatches/{$id}/1/3");
					}
				}
				
			}
			$teamIds = $this->nextRound($teamIds);
		}
		// schedule succeeded with no errors.
		redirect("/admin/event/viewMatches/{$id}/1/1");
		
	}

	private function scheduleHurdling($id)
	{

	}
	
	private function getMatchDetails($event, $day, $eventTimes, $duration) {
		for ($k = 0; $k < count($eventTimes); $k++)
		{
			$array = $eventTimes[$k];
			$curTime = $array['start'];
			$umpire = $this->Umpire_model->getFreeUmpireForEvent($event['eventId'], $day->format("Y-m-d"), $curTime, $duration);
			$location = $this->Location_model->getFreeLocation($event['sportId'], $day->format("Y-m-d"), $curTime, $duration);
			
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
	
	public function timeCheck($time)
	{
		if (preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $time))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('timeCheck', "Start time of matches must be in the format HH:MM and all matches must have a time specified.");
			return false;
		}
	}
	
	public function minusOne($value)
	{
		// make sure the message isn't shwon more than once.
		if ($this->minusOne == true)
		{
			return true;
		}
		if ($value == -1)
		{
			$this->minusOne = true;
			$this->form_validation->set_message('minusOne', "Teams, umpires and locations must be entered correctly for all matches.");
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function checkDateFormat($date)
	{
		$dateFormat = "d/m/Y";
		$date = DateTime::createFromFormat($dateFormat, $date);
		$date_errors = DateTime::getLastErrors();
		if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) 
		{
			if ($this->minusOne == false)
			{
				$this->minusOne = true;
				$this->form_validation->set_message('checkDateFormat', "Please ensure all dates are formattet correctly using the format dd/mm/yyyy");
			}
			return false;
		}
		else
		{
			return true;
		}
	}
}