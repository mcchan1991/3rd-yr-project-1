<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller public view of events
 *
 * Created: 18/03/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Match extends My_Public_Controller {
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Sport_model');
		$this->load->model('admin/Match_model');
		$this->load->model('admin/Location_model');
		$this->load->model('admin/Umpire_model');
		$this->load->model('team/Team_model');
		
	}
	
	public function view($id)
	{
		$match = $this->Match_model->get($id);
		$event = $this->Event_model->getEvent($match['eventId']);
		$data['event'] = $event;
		$tournament = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['tournament'] = $tournament;
		$data['sport'] = $event['sportId'];
		$result = $this->Match_model->getFinalResult($id);
		$result = $result[0];
		$data['result'] = $result;
		
		$team1 = $this->Team_model->getTeam($result['team1Id']);
		$team2 = $this->Team_model->getTeam($result['team2Id']);
		
		$data['team1'] = $team1;
		$data['team2'] = $team2;
		
		$resultEvents = $this->Match_model->getExtendedResults($id);
		
		// get assist names
		for($i = 0; $i < count($resultEvents); $i++)
		{
			$currentEvent = $resultEvents[$i];
			if ($currentEvent['assist'] == NULL)
			{
				$currentEvent['assistShirtNo'] = NULL;
				$currentEvent['assistSurname'] = NULL;
			}
			else
			{
				$assist = $this->Team_model->getPlayer($currentEvent['assist']);
				$currentEvent['assistShirtNo'] = $assist['shirtNo'];
				$currentEvent['assistSurname'] = $assist['surname'];
			}
			 $resultEvents[$i] = $currentEvent;
		}
		
		$data['resultEvents'] = $resultEvents;
		$umpire = $this->Umpire_model->getUmpire($match['umpireId']);
		$data['umpire'] = $umpire['firstName'] . " " . $umpire['surname'];
		$location = $this->Location_model->getLocation($match['locationId']);
		$data['location'] = $location['name'];

		$this->template->write_view('nav_side','navside_event', $data);
		$this->template->write_view('content','view_match',$data);
		$this->template->render();

	}
}