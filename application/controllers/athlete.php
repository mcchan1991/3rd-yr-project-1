<?php

class Athlete extends My_Public_Controller 
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
		$event = $this->Event_model->getEvent($eventId);
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['firstName'] = "";
		$data['surname'] = "";
		$data['email'] = "";
		$data['password'] = "";
		$data['dob'] = "";
		$data['fastest'] = "";
		$data['gender'] = (($gender == 1) ? 'male' : 'female');
		$data['event'] = $event;
		$data['tournament'] = $this->Tournament_model->getTournamentId($data['event']['tournamentId']);
		
		$dateFormat = "Y-m-d";
		$currentDate = new DateTime();
		$regStart = DateTime::createFromFormat($dateFormat, $event['regStart']);
		$regEnd = DateTime::createFromFormat($dateFormat, $event['regEnd']);
		
		if ($currentDate > $regEnd)
		{
			$data['registrationError'] = 1;
		}
		else if ($currentDate<$regStart)
		{
			$data['registrationError'] = 2;
		}
		else if ($this->Event_model->getEventRegistrationsCount($eventId) == $event['maxEntries'])
		{
			$data['registrationError'] = 3;
		}

		$sideData['sport'] = $event['sportId'];
		$sideData['event'] = $event;
		
		$this->template->write_view('content','athlete/create',$data);
		$this->template->write_view('nav_side','navside_event', $sideData);
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
		$this->form_validation->set_rules("dob", "Date of birth", "required|min_length[3]|max_length[50]|callback_dateCheck");
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
			
			$event = $this->Event_model->getEvent($id);

			$sideData['sport'] = $event['sportId'];
			$sideData['event'] = $event;
			
			$this->template->write_view('content','athlete/create',$data);
			$this->template->write_view('nav_side','navside_event', $sideData);
			$this->template->render();
		}
		else
		{
			$dateFormat = "d/m/Y";
			$dob = DateTime::createFromFormat($dateFormat, $this->input->post("dob"));
			$postdata = array(
				'firstName' => $this->input->post("firstName"),	
				'surname' => $this->input->post("surname"),					
				'email' => $this->input->post("email"),					
				'password' => sha1($this->input->post("password")),					
				'dob' => $dob->format('Y-m-d'),			
				'gender' => $this->input->post("gender"),	
				'fastest' => $this->input->post("fastest")						
			);
			$this->Athlete_model->add_record($postdata);
			
			$id = $this->Athlete_model->getByEmail($this->input->post("email"));
			$id = $id[0];
			$id =$id['athleteId'];
			
			$eventRegsId = $this->Athlete_model->registerAthleteForEvent($eventId, $id);
			
			redirect("/event/view/{$eventId}/1");
			//echo "added athlete {$id} for event {$eventId} as eventRegsId: {$eventRegsId}";
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
	
	public function dateCheck()
	{
		$dobInput = $this->input->post('dob');

		// validate first date format
		$dateFormat = "d/m/Y";
		$this->_startDate = DateTime::createFromFormat($dateFormat, $dobInput);

		$date_errors = DateTime::getLastErrors();
		$errors = array();
		// push any errors to the errors array
		if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) 
		{
			$this->form_validation->set_message('dateCheck', "The entered Date Of Birth is invalid. Use format mm/dd/yyyy");
			return false;	
		}
		else
		{
			return true;
		}
	}
	
	function update()
	{

	}
	
	
	function delete()
	{

	}
}
