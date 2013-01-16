<?php

class Athlete extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Athlete_model');
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Tournament_model');	
	}

	function index()
	{
		//will do this after we have templating working and such
	}
	
	function register($gender = 1, $eventId)
	{
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['firstName'] = "";
		$data['surname'] = "";
		$data['email'] = "";
		$data['password'] = "";
		$data['dob'] = "";
		$data['fastest'] = "";
		$data['gender'] = (($gender == 1) ? 'male' : 'female');
		$data['event'] = $this->Event_model->getEvent($eventId);
		$data['tournament'] = $this->Tournament_model->getTournamentId($data['event']['tournamentId']);
		
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
	
	
	function add($eventId)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules("firstName", "First Name", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("surname", "Surname", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("password", "password", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("dob", "Date of birth", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("email", "E-mail", "required|min_length[3]|max_length[50]|valid_email|callback_uniqueEmail");
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['firstName'] = $this->input->post("firstName");
			$data['surname'] = $this->input->post("surname");
			$data['email'] = $this->input->post("email");
			$data['password'] = $this->input->post("password");
			$data['dob'] = $this->input->post("dob");
			$data['gender'] = $this->input->post("gender");
			$data['fastest'] = $this->input->post("fastest");
			$data['event'] = $this->Event_model->getEvent($eventId);
			$data['tournament'] = $this->Tournament_model->getTournamentId($data['event']['tournamentId']);
			
			$this->template->write_view('content','athlete/create',$data);
			$this->template->render();
		}
		else
		{
			$postdata = array(
				'firstName' => $this->input->post("firstName"),	
				'surname' => $this->input->post("surname"),					
				'email' => $this->input->post("email"),					
				'password' => sha1($this->input->post("password")),					
				'dob' => $this->input->post("dob"),					
				'gender' => $this->input->post("gender"),	
				'fastest' => $this->input->post("fastest")						
			);
			$this->Athlete_model->add_record($postdata);
			
			$id = $this->Athlete_model->getByEmail($this->input->post("email"))[0]['athleteId'];
			
			$eventRegsId = $this->Athlete_model->registerAthleteForEvent($eventId, $id);
			
			echo "added athlete {$id} for event {$eventId} as eventRegsId: {$eventRegsId}";
		}
	}
	
	function uniqueEmail()
	{
		$result = $this->Athlete_model->getByEmail($this->input->post("email"));
		if (count($result) == 0)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('uniqueEmail', "The e-mail you entered have already been used for registration.");
			return false;
		}
	}
	
	function update()
	{

	}
	
	
	function delete()
	{

	}
}
