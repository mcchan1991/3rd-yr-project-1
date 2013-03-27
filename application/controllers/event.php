<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller public view of events
 *
 * Created: 15/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Event extends My_Public_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Sport_model');
		$this->load->model('admin/Match_model');
		$this->load->model('team/Team_model');
	}
	
	public function view($id, $registration=false)
	{
		
		$event = $this->Event_model->getEvent($id);

		$sideData['sport'] = $event['sportId'];
		$sideData['event'] = $event;
		$data['event'] = $event;
		$data['tournament'] = $this->Tournament_model->getTournamentId($event['tournamentId']);
		if ($registration != false)
		{
			$registration=true;
		}
		$data['registration'] = $registration;
		$this->template->write_view('nav_side','navside_event', $sideData, TRUE);
		$this->template->write_view('content','event',$data);
		$this->template->render();

	}
	
	public function schedule($id, $page = 1, $results = 0)
	{
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('pagination');

			$config['base_url'] = base_url() . "index.php/event/schedule/";
			$config['total_rows'] = $this->Match_model->countEventMatches($id);
			$config['per_page'] = 10; 
			$config['uri_segment'] = 4;

			// for styling with bootstrap: http://www.smipple.net/snippet/Rufhausen/Twitter%20Bootstrap%2BCodeigniter%20Pagination
		    $config['full_tag_open'] = '<div class="pagination"><ul>';
		    $config['full_tag_close'] = '</ul></div>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&larr; Previous';
		    $config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = 'Next &rarr;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] =  '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';

			$this->pagination->initialize($config);

			if ($results == 0)
			{
				$data['matches'] = $this->Match_model->getPaginationEvent($id, $config["per_page"], $page);
			}
			else
			{
				$data['matches'] = $this->Match_model->getPaginationEvent($id, $config["per_page"], $page, 1);
			}

			$event = $this->Event_model->getEvent($id);
			$tournament = $this->Tournament_model->getTournamentId($event['tournamentId']);
			$data['sport'] = $event['sportId'];
			$data['tournament'] = $tournament;
			$data['event'] = $event;
			$data['links'] = $this->pagination->create_links();

			if ($config['total_rows'] == 0) 
			{
				$data['scheduled'] = 0;
			}
			else
			{
				$data['scheduled'] = 1;
			}
			
			$data['status'] = "";

			$startDate = DateTime::createFromFormat("Y-m-d", $event['start']);
			$today = new DateTime();

			$data['allowAutomatic'] = 0;
			
			$data['public'] = true;


			$this->template->write_view('content','admin/event/match_list',$data);
			$this->template->write_view('nav_side','navside_event', $data, TRUE);
			$this->template->render();
	
	}
	
	public function showRankings($id)
	{
		$event = $this->Event_model->getEvent($id);
		$tournament = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['sport'] = $event['sportId'];
		$data['tournament'] = $tournament;
		$data['event'] = $event;
		$eventRegs = $this->Event_model->getEventRegistrations($id, $this->Event_model->getEventRegistrationsCount($id), 1);
		
		$i = 0;
		$teamResults = array();
		$teams = array();
		foreach($eventRegs as $eventReg)
		{
			$eventReg=$this->Team_model->getEventReg($eventReg['nwaId']);
			if (count($eventReg) > 0)
			{
				$teams[$eventReg['nwaId']] = $eventReg;
				$teamResults[$eventReg['nwaId']] = array("points" => 0, "goalsScored" => 0, "goalsAgainst" => 0, "matches" => 0, "won" => 0, "draw" => 0, "lost" => 0, "teamId" => $eventReg['nwaId']);
			}				
			$i++;
		}
		
		$data['teams'] = $teams;
		//print_r($registrations);
		
		$allResults = $this->Event_model->findMatchResults($id);
		foreach($allResults as $currentResult)
		{
			$team1 = $teamResults[$currentResult['team1Id']];
			$team2 = $teamResults[$currentResult['team2Id']];
			
			$team1['teamId'] = $currentResult['team1Id'];
			$team2['teamId'] = $currentResult['team2Id'];
			$team1['matches'] += 1;
			$team2['matches'] += 1;
			
			$team1['goalsScored'] += $currentResult['team1Goals'];
			$team1['goalsAgainst'] += $currentResult['team2Goals'];
			$team2['goalsScored'] += $currentResult['team2Goals'];
			$team2['goalsAgainst'] += $currentResult['team1Goals'];
			// team draw
			if ($currentResult['team1Goals'] == $currentResult['team2Goals'])
			{
				$team1['points'] += 1;
				$team2['points'] += 1;
				$team1['draw'] += 1;
				$team2['draw'] += 1;
			}
			// team 1 wins
			else if ($currentResult['team1Goals'] > $currentResult['team2Goals'])
			{
				$team1['points'] += 3;
				$team1['won'] += 1;
				$team2['lost'] += 1;
			}
			// team 2 wins
			else
			{
				$team2['points'] += 3;
				$team2['won'] += 1;
				$team1['lost'] += 1;
			}
			// put them back into the array (php seems to be doing some weird referencing....)
			$teamResults[$currentResult['team1Id']] = $team1;
			$teamResults[$currentResult['team2Id']] = $team2;
		}
		// sort the teams after points then goal score
		usort($teamResults, array('Event', 'compareResults'));
		// get more stats
		$data['topScores'] = $this->Event_model->getTopscores($id);
		$data['mostAssists'] = $this->Event_model->getMostAssists($id);
		$data['mostYellowCards'] = $this->Event_model->getMostYellowCards($id);
		$data['mostRedCards'] = $this->Event_model->getMostRedCards($id);
		$data['teamResults'] = $teamResults;
		//print_r($mostYellowCards);
		
		$this->template->write_view('content','rankings',$data);
		$this->template->write_view('nav_side','navside_event', $data, TRUE);
		$this->template->render();
	}
	
	static function compareResults($team1, $team2)
	{
		if ($team1['points'] != $team2['points'])
		{
			return ($team1['points'] > $team2['points']) ? -1 : 1;
		}
		else
		{
			$team1GoalScore = $team1['goalsScored'] - $team1['goalsAgainst'];
			$team2GoalScore = $team1['goalsScored'] - $team1['goalsAgainst'];
			if ($team1GoalScore != $team2GoalScore)
			{
				return ($team1GoalScore > $team2GoalScore) ? -1 : 1;
			}
			else
			{
				// should probably find matches between the two and see who won these, if equal I don't know what to do.
				// could be implemented if more time on hands sometime
			}
		}
	}
}
