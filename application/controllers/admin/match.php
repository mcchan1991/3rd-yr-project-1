<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for matches
 *
 * Created: 16/03/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Match extends My_Admin_Controller 
{
	
	private $minusOne = false;
	
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Sport_model');
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Match_model');
		$this->load->model('team/Team_model');
		
		$this->load->helper('form');
		
	}
	
	public function enterResults($id)
	{
		
		$match = $this->Match_model->get($id);
		$event = $this->Event_model->getEvent($match['eventId']);
		$data['event'] = $event;
		$tournament = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['tournament'] = $tournament;
		// get teams
		$data['team1'] = $this->Team_model->getTeam($match['team1Id']); 
		$data['team2'] = $this->Team_model->getTeam($match['team2Id']);

		$data['team1Players'] = $this->Team_model->getTeamPlayers($match['team1Id']);
		$data['team2Players'] = $this->Team_model->getTeamPlayers($match['team2Id']);
		$data['matchId'] = $id;
		
		$results = $this->Match_model->getResults($id);
		
		$data['player'] = array();
		$data['assist'] = array();
		$data['type'] = array();
		$data['minute'] = array();
		$data['resultId'] = array();
		
		if (count($results) != 0)
		{
			foreach ($results as $curResult)
			{
				array_push($data['player'], $curResult['playerId']);
				array_push($data['assist'], $curResult['assist']);
				array_push($data['minute'], $curResult['minute']);
				array_push($data['resultId'],$curResult['resultId']);
				if ($curResult['goal'] != NULL)
				{
					array_push($data['type'], "goal");
				}
				if ($curResult['yellowCard'] != null)
				{
					array_push($data['type'], "yellowCard");
				}
				if ($curResult['redCard'] != null)
				{
					array_push($data['type'], "redCard");
				}
			}
		}


		$this->template->write_view('nav_side','admin/event/navside',$data, true);
		$this->template->write_view('content','admin/event/addMatchResults',$data);
		$this->template->render();
	}
	
	public function saveMatchResults($id)
	{
		$this->load->library('form_validation');
		$match = $this->Match_model->get($id);
		//$this->form_validation->set_rules("team1[]", "Event time", "callback_minusOne|callback_teamCheck");
		
		$this->form_validation->set_rules("player[]", "Player", "callback_minusOne");
		$this->form_validation->set_rules("assist[]", "Assist", "callback_checkAssist");
		$this->form_validation->set_rules("minute[]", "Time", "is_natural_no_zero|max_length[3]");
		$this->form_validation->set_rules("type[]", "Type", "required");
		
		if ($this->form_validation->run() == FALSE)
		{
			$match = $this->Match_model->get($id);
			$event = $this->Event_model->getEvent($match['eventId']);
			$data['event'] = $event;
			$tournament = $this->Tournament_model->getTournamentId($event['tournamentId']);
			$data['tournament'] = $tournament;
			// get teams
			$data['team1'] = $this->Team_model->getTeam($match['team1Id']); 
			$data['team2'] = $this->Team_model->getTeam($match['team2Id']);

			$data['team1Players'] = $this->Team_model->getTeamPlayers($match['team1Id']);
			$data['team2Players'] = $this->Team_model->getTeamPlayers($match['team2Id']);
			$data['matchId'] = $id;
			
			$data['player'] = $this->input->post("player");
			$data['assist'] = $this->input->post("assist");
			$data['time'] = $this->input->post("time");
			$data['type'] = $this->input->post("type");
			$data['minute'] = $this->input->post("minute");
			$data['resultId'] = $this->input->post("resultId");
			
			$this->template->write_view('nav_side','admin/event/navside',$data, true);
			$this->template->write_view('content','admin/event/addMatchResults',$data);
			$this->template->render();
		}
		else
		{
			$player = $this->input->post("player");
			$assist = $this->input->post("assist");
			$time = $this->input->post("time");
			$type = $this->input->post("type");
			$minute = $this->input->post("minute");
			$resultId = $this->input->post("resultId");

			for ($i = 0; $i < count($player); $i++)
			{
				
				$curAssist = NULL;
				$goal = NULL;
				$yellowCard = NULL;
				$redCard = NULL;
				
				if ($type[$i] == "goal")
				{
					$goal = 1;
					if ($assist[$i] != -1)
					{
						$curAssist = $assist[$i];
					}
				}
				else if ($type[$i] == "owngoal")
				{
					$goal = -1;
				}
				else if ($type[$i] == "yellowCard")
				{
					$yellowCard = 1;
				}
				else
				{
					$redCard = 1;
				}
				if ($resultId[$i] == -1)
				{
					// insert into database:
					$postdata = array(
						'matchId' => $id,
						'playerId' => $player[$i],	
						'minute' => $minute[$i],	
						'goal' => $goal,	
						'assist' => $curAssist,	
						'yellowCard' => $yellowCard,	
						'redCard' => $redCard,	
					);
					$this->Match_model->addResult($postdata);
				}
				else
				{
					$postdata = array(
						'resultId' => $resultId[$i],
						'matchId' => $id,
						'playerId' => $player[$i],	
						'minute' => $minute[$i],	
						'goal' => $goal,	
						'assist' => $curAssist,	
						'yellowCard' => $yellowCard,	
						'redCard' => $redCard,
					);
					$this->Match_model->updateResult($postdata);
				}
			}
			$this->Match_model->setMatchAsFinished($id);
			redirect("http://localhost:8888/groupproject/index.php/admin/event/viewMatches/" . $match['eventId']);
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
			$this->form_validation->set_message('minusOne', "A player must be selected");
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function checkAssist($value)
	{
		$players = $this->input->post("player");
		$assists = $this->input->post("assist");
		
		for ($i = 0; $i < count($players); $i++)
		{
			if ($assists[$i] != -1 && $players[$i] != -1)
			{
				$playerTeam = $this->Team_model->getPlayerTeam($players[$i]);
				$assistTeam = $this->Team_model->getPlayerTeam($assists[$i]);
				if ($playerTeam != $assistTeam)
				{
					$this->form_validation->set_message('checkAssist', "A player and the assist must be on the same team.");
					return false;
				}
			}
		}
		return true;
	}
	
}