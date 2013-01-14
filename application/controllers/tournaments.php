<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller public view of tournaments
 *
 * Created: 14/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Tournaments extends My_Public_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Sport_model');
	}
	
	public function index($page = 1)
	{
		$this->load->helper('url');
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/tournaments/index/";
		$config['total_rows'] = $this->Tournament_model->countAllFutureTournamentsWithEvents();
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
		
		$data['sports'] = $this->Sport_model->getAll();
		$data['tournaments'] = $this->Tournament_model->getFutureTournamentsWithEvents($config["per_page"], $page);
		$data['events'] = array();
		$data['totalEventCount'] = array();
		foreach($data['tournaments'] as $tournament )
		{
			$data['events'][$tournament['tournamentId']] = $this->Event_model->getPaginationByTournamentId($tournament['tournamentId'], 5, 1);
			$data['totalEventCount'][$tournament['tournamentId']] = $this->Event_model->countEventsByTournamentId($tournament['tournamentId']);
		}		
	
		$data['links'] = $this->pagination->create_links();
		
		$this->template->write_view('content','tournaments',$data);
		$this->template->render();
	}
}