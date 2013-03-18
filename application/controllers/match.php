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
	}
	
	public function view($id)
	{
		$match = $this->Match_model->get($id);
		$event = $this->Event_model->getEvent($match['eventId']);
		$data['event'] = $event;
		$tournament = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['tournament'] = $tournament;
		$data['sport'] = $event['sportId'];
		$data['result'] = $this->Match_model->getFinalResult($id);
		print_r($data['result']);

		$this->template->write_view('nav_side','navside_event', $data);
		$this->template->write_view('content','view_match',$data);
		$this->template->render();

	}
}