<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends My_Public_Controller {

	function __construct()
	{
		session_start();
		parent::__construct();
	}

	public function index()
	{
		if($this->session->userdata('login_state',true)){
		//echo $this->session->userdata('login_state');
		$this->template->write_view('content','team/welcome1');
		$this->template->render();
		}
		else
		{
			redirect('team/verifyTeamLogin', 'refresh');
		}
		
	}

	
	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('login_state');
		$this->session->unset_userdata('nwaId');
		redirect('', 'refresh');
	}
}
