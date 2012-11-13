<?php 
class Tournament extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Tournament_model');
	}
	/**
	 * Index should probably be a list of all tournaments for admins, but make it later
	 */
	public function index()
	{
		//$this->load->view('welcome_message');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
	}
	
	public function add()
	{
		$this->load->helper('form');
		$this->load->view('admin/tournament/create');
		
		// load view
		
	}
	
	public function edit()
	{
		
	}
	
	/**
	 *	Not sure if this is needed in a controller? Find out later
	 *
	 */
	public function delete()
	{
		
	}
}

/* End of file tournament.php */
/* Location: ./application/controllers/admin/tournament.php */