<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class teamview extends My_Public_Controller {
function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Sport_model');
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Match_model');
		$this->load->model('team/Team_model');
	}
	
	public function view($id)
	{
		$team = $this->Team_model->getTeam($id);
		$data = array();
		$data['teamName'] = $team['name'];
		if ($team['logo'] == 1)
		{
			$data['image'] = md5($team['nwaId']) . ".png";
		}
		$data['team'] = $team;
		$data['players'] = $this->Team_model->getPlayersWithStats($id);
		
		$this->template->write_view('content','team/view',$data);
		$this->template->render();
	}
	
	public function teamlist($id, $page=1)
	{
		$event = $this->Event_model->getEvent($id);
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/teamview/teamlist/";
		$config['total_rows'] = $this->Event_model->getEventRegistrationsCount($id);
		$config['per_page'] = 10; 
		$config['uri_segment'] = 5;
		
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
		
		$eventRegs = $this->Event_model->getEventRegistrations($id, $config['per_page'], $page);
		$data = array();
		$registrations = array();
		// wattball
		if ($event['sportId'] == 1)
		{
			$this->load->model('team/team_model');
			$i = 0;
			foreach($eventRegs as $eventReg)
			{
				$eventReg=$this->team_model->getEventReg($eventReg['nwaId']);
				if (count($eventReg) > 0)
				{
					$registrations[$i] = $eventReg;
				}				
				$i++;
			}
		$data['registrations'] = $registrations;
		$data['event'] = $event;
		$data['tournament'] = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['links'] = $this->pagination->create_links(); 
		$data['sport'] = $event['sportId'];
		}
		// hurdling
		else if ($event['sportId'] == 2)
		{
			$this->load->model('athlete_model');
			$i = 0;
			foreach($eventRegs as $eventReg)
			{
				$eventReg = $this->athlete_model->get_record($eventReg['athleteId']);
				if (count($eventReg) > 0)
				{
					$registrations[$i] = $eventReg[0];
				}
				//$registrations[$i] = $this->athlete_model->get_record($eventReg['athleteId'])[0];
				$i++;
			}
		$data['registrations'] = $registrations;
		$data['event'] = $event;
		$data['tournament'] = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['links'] = $this->pagination->create_links();
		}

		
		// load view etc...
		$this->template->write_view('nav_side','navside_event',$data, true);
		$this->template->write_view('content','team/index',$data);
		$this->template->render();
	}
	
}

