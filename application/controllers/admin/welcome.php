<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if(!$this->session->userdata('logged_in')){
			redirect( "/admin/login" );
		}
		$this->load->view('admin/welcome');
	}
	
	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		redirect('admin/login', 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/admin/welcome.php */