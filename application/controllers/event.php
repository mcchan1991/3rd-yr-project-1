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
	
	public function schedule($id, $page = 1, $results = 0)
	{
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->library('pagination');

			$config['base_url'] = base_url() . "index.php/admin/event/viewMatches/";
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
			$this->template->write_view('nav_side','navside_event', $data);
			$this->template->render();
	
	}
	
}