<?php 
class Login extends CI_Controller {
	
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		session_start();
		parent::__construct();
	}
	
	/**
	 * Index should probably be a list of all tournaments for admins, but make it later
	 */
	public function index()
	{
		if($this->session->userdata('logged_in')){
			redirect( "/admin" );
		}
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['username'] = "";
		$data['password'] = "";
		$this->load->view('admin/login', $data);
	}
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */