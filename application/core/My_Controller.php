<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Base controller to extend all the admin pages, for automatic logged in check and navigation
 *
 * Created: 12/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class My_Admin_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			redirect( "/admin/login" );
		}
		$this->load->helper('url');
		$data['segment'] = $this->uri->segment(2);
		if (empty($data['segment']))
		{
			$data['segment'] = "home";
		}
		$this->template->write_view('nav_top','admin/topnav', $data);
		
		// if not overwritten loads default a list of active tournaments
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Event_model');
		$sideData['tournaments'] = $this->Tournament_model->getFutureTournaments(5, 1);
		$sideData['events'] = array();
		foreach($sideData['tournaments'] as $tournament)
		{
			$sideData['events'][$tournament['tournamentId']] = $this->Event_model->getPaginationByTournamentId($tournament['tournamentId'],10, 1);
		}
		//getPaginationByTournamentId($id,$per_page, $offset)
		$this->template->write_view('nav_side','admin/navside_standard',$sideData);
		
	}
}

class My_Public_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$data['segment'] = $this->uri->segment(1);
		if (empty($data['segment']))
		{
			$data['segment'] = "home";
		}
		if ($this->session->userdata('nwaId')!= NULL)
		{
			$this->load->model('/team/Team_model');
			$team = $this->Team_model->getTeam($this->session->userdata('nwaId'));
			$data['team'] = $team['name'];
		}
		$this->template->write_view('nav_top','topnav', $data);
		
		// if not overwritten loads default a list of active tournaments
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Event_model');
		$sideData['tournaments'] = $this->Tournament_model->getFutureTournaments(5, 1);
		$sideData['events'] = array();
		foreach($sideData['tournaments'] as $tournament)
		{
			$sideData['events'][$tournament['tournamentId']] = $this->Event_model->getPaginationByTournamentId($tournament['tournamentId'],10, 1);
		}
		
		$sideData['pastTournaments'] = $this->Tournament_model->getPastTournament(5, 1);
		$sideData['pastEvents'] = array();
		foreach($sideData['pastTournaments'] as $tournament)
		{
			$sideData['pastEvents'][$tournament['tournamentId']] = $this->Event_model->getPaginationByTournamentId($tournament['tournamentId'],10, 1);
		}
		$this->template->write_view('nav_side','navside',$sideData, true);
		//$this->template->write_view('nav_side','admin/navside_standard',$sideData);
		
	}
}