<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends My_Admin_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->template->write_view('content','admin/welcome');
		$this->template->render();
	}
	
	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		redirect('admin/login', 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/admin/welcome.php */