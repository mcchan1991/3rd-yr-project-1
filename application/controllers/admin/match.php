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

		$this->template->write_view('nav_side','admin/event/navside',$data, true);
		$this->template->write_view('content','admin/event/addMatchResults',$data);
		$this->template->render();
	}
	
}