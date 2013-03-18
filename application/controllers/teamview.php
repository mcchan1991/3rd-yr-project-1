<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class teamview extends My_Public_Controller {
function __construct()
	{
		parent::__construct();
		
		$this->load->model('team/Team_model');
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Tournament_model');	
		
	}
	
	public function index()
	{
		$this->register($eventId);
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
		
		$this->template->write_view('content','team/view',$data);
		$this->template->render();
	}
}

