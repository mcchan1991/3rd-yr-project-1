<?php 
class Login extends CI_Controller {
	
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		parent::__construct();
		session_start();
		if($this->session->userdata('logged_in')){
			redirect( "/admin" );
		}
	}
	
	/**
	 * Index should probably be a list of all tournaments for admins, but make it later
	 */
	public function index()
	{

		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['username'] = "";
		$data['password'] = "";
		$this->template->write_view('content','admin/login', $data);
		$this->template->render();
		
	}
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */