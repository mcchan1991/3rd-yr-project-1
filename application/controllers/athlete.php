<?php

class Athlete extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Athlete_model');
	}

	function index()
	{
		//will do this after we have templating working and such
	}
	
	function register($gender = 1)
	{
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['firstName'] = "";
		$data['surname'] = "";
		$data['email'] = "";
		$data['password'] = "";
		$data['dob'] = "";
		$data['gender'] = (($gender == 1) ? 'male' : 'female');
		$this->template->write_view('content','athlete/create',$data);
		$this->template->render();
	}
	
	function login()
	{
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['email'] = "";
		$data['password'] = "";
		$this->template->write_view('content','athlete/login', $data);
		$this->template->render();
	}
	
	function VerifyLogin()
	{
		//This method will have the credentials validation
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

		if($this->form_validation->run() == FALSE)
		{
			//Field validation failed.  User redirected to login page
			$data['email'] = "";
			$data['password'] = "";
			$this->template->write_view('content','athlete/login', $data);
			$this->template->render();
		}
		else
		{
			//Go somewhere?
		}
	
	}
	
	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		//query the database
		$result = $this->Athlete_model->login($username, $password);

		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
				'athleteid' => $row->athleteid,
				'email' => $row->email
				);
				$this->session->set_userdata('athlete_logged_in', $sess_array);
			}
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
	
	
	function add()
	{
	
	}
	
	function update()
	{

	}
	
	
	function delete()
	{

	}
}
