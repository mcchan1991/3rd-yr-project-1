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
		$this->template->write_view('nav_side','navside_event', $sideData);
		$this->template->write_view('content','event',$data);
		$this->template->render();

	}
	
	public function schedule($id)
	{
	
	
	}
	
}