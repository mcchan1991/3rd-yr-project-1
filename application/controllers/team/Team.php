<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		//$this->load->model('team/Team_model');
	}
	
	public function index()
	{
		$this->load->view('team/TeamLogin');
	}
	
	public function team_validation()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('TeamName', 'TeamName', 'required|trim');
		$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'confirm Password', 'required|trim|matches[password]');
		$this->form_validation->set_rules('CFname', 'Contact First Name', 'required|trim');
		$this->form_validation->set_rules('CSname', 'Contact Surname', 'required|trim');
		
		if($this->form_validation->run())
		{
			echo "You have registered";
			$data = array(
			'NWAID' => NULL,
			'email' => $this->input->post('email'),
			'TeamName' => $this->input->post('TeamName'),
			'password' => sha1($this->input->post('password')),
			'CFname' => $this->input->post('CFname'),
			'CSname' => $this->input->post('CSname')
			);
		$this->db->insert('test2', $data);
		}
		else
		{
			//echo "please enter correct details";
			$this->load->view('Team/NewTeam');
		}
	}
	
	public function check_team_login()
	{
	$this->load->model('team/Team_model');
	
	$this->Team_model->teamlogin_validation();
	
	}
	
	public function team_register()
	{
	$this->load->view('team/NewTeam');
	}
	
	

}
