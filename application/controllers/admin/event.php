<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for Event administration
 *
 * Created: 11/01/2013
 * @author	Jontahan Val <jdv2@hw.ac.uk>
 */
class Event extends My_Admin_Controller 
{
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Sport_model');
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Match_model');
		$this->load->helper('form');
		
	}
	
	public function save($id = false)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules("name", "Event name", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("regStart", "Registration start", "required");
		$this->form_validation->set_rules("regEnd", "Registration end", "required");
		$this->form_validation->set_rules("maxEntries", "Maximum No. of entries", "required|numeric|max_length[5]");
		$this->form_validation->set_rules("minEntries", "Minimum No. of entries", "required|numeric|max_length[5]");
		$this->form_validation->set_rules("start", "Start date", "required");
		$this->form_validation->set_rules("end", "End date", "required|callback_dateCheck");
		$this->form_validation->set_rules("description", "Description", "required");
		$this->form_validation->set_rules("duration", "Duration", "required|callback_timeCheck");
		$this->form_validation->set_rules('eventTimes[]', 'Event times', 'callback_eventTimesCheck');
		if ($this->input->post('sport') == 2)
		{
			$this->form_validation->set_rules("gender", "Gender", "callback_requireGender");
		}

		// if input is not valid, show the form again (and send the post-date to the view so it can be re-populated)
		if ($this->form_validation->run() == FALSE)
		{
			$data['name'] = $this->input->post('name');
			$data['regStart'] = $this->input->post('regStart');
			$data['regEnd'] = $this->input->post('regEnd');
			$data['maxEntries'] = $this->input->post('maxEntries');
			$data['minEntries'] =$this->input->post('minEntries');
			$data['start'] =$this->input->post('start');
			$data['end'] =$this->input->post('end');
			$data['sport'] =$this->input->post('sport');
			$data['sports'] = $this->Sport_model->getAll();
			$data['tournament'] = $this->Tournament_model->getTournamentId($this->input->post('tournament'));
			$data['description'] = $this->input->post('description');
			$data['gender'] = $this->input->post('gender');
			$data['duration'] = $this->input->post('duration');
			$data['eventTimes'] = $this->input->post('eventTimes');
			
			if (!empty($id))
			{
				$data['id'] = $id;
			}
			
			$this->template->write_view('content','admin/event/create',$data);
			$this->template->render();
		}
		else
		{
			$this->load->helper('url');			
			$dateFormat = "d/m/Y";
			if ($id == false)
			{
				$postdata = array(
					'tournamentId' => $this->input->post('tournament'),
					'name'	=> $this->input->post('name'),
					'description' => $this->input->post('description'),
					'regStart' => DateTime::createFromFormat($dateFormat, $this->input->post('regStart'))->format('Y-m-d'),
					'regEnd' => DateTime::createFromFormat($dateFormat, $this->input->post('regEnd'))->format('Y-m-d'),
					'maxEntries' => $this->input->post('maxEntries'),
					'minEntries' => $this->input->post('minEntries'),
					'start' => DateTime::createFromFormat($dateFormat, $this->input->post('start'))->format('Y-m-d'),
					'end' => DateTime::createFromFormat($dateFormat, $this->input->post('end'))->format('Y-m-d'),	
					'sportId' => $this->input->post('sport'),		
					'gender' => $this->input->post('gender'),
					'duration'=> $this->input->post('duration'),
					'scheduleAproved' => 0			
				);
				$id = $this->Event_model->create($postdata);
				$id = $this->Event_model->createEventTimes($id, $this->input->post('eventTimes'));
				
				//echo "successfully addedd id: " . $id;
			}
			else
			{
				$postdata = array(
					'eventId'	=> $id,
					'tournamentId' => $this->input->post('tournament'),
					'description' => $this->input->post('description'),
					'name'	=> $this->input->post('name'),
					'regStart' => DateTime::createFromFormat($dateFormat, $this->input->post('regStart'))->format('Y-m-d'),
					'regEnd' => DateTime::createFromFormat($dateFormat, $this->input->post('regEnd'))->format('Y-m-d'),
					'maxEntries' => $this->input->post('maxEntries'),
					'minEntries' => $this->input->post('minEntries'),
					'start' => DateTime::createFromFormat($dateFormat, $this->input->post('start'))->format('Y-m-d'),
					'end' => DateTime::createFromFormat($dateFormat, $this->input->post('end'))->format('Y-m-d'),	
					'sportId' => $this->input->post('sport'),	
					'gender' => $this->input->post('gender'),
					'duration'=> $this->input->post('duration')							
				);
				
				$this->Event_model->update($postdata);
				$this->Event_model->createEventTimes($id, $this->input->post('eventTimes'));
			}
			redirect( "/admin/tournament/viewEvents/".$this->input->post('tournament') );
		}
	}
	
	public function add($tournament)
	{
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['name'] = "";
		$data['regStart'] = "";
		$data['regEnd'] = "";
		$data['maxEntries'] = "";
		$data['minEntries'] = "";
		$data['start'] = "";
		$data['end'] = "";
		$data['sport'] ="";
		$data['sports'] = $this->Sport_model->getAll();
		$data['tournament'] = $this->Tournament_model->getTournamentId($tournament);
		$data['description'] = "";
		$data['gender'] = "";
		$data['duration'] = "";
		$data['eventTimes'] = array();
		
		$this->template->write_view('content','admin/event/create',$data);
		$this->template->render();
	}
	
	/**
  	 * View so admin can edit a specific event.
	 * @param id	the ID of the tournament to be edited.
     */
	public function edit($id)
	{
		// form validations used to set variables.
		$this->load->library('form_validation');
		$dateFormat = "Y-m-d";
		// get the id
		$event = $this->Event_model->getEvent($id);
		
		$data['name'] = $event['name'];
		$data['regStart'] = DateTime::createFromFormat($dateFormat,$event['regStart'])->format('d/m/Y');
		$data['regEnd'] = DateTime::createFromFormat($dateFormat,$event['regEnd'])->format('d/m/Y');
		$data['maxEntries'] = $event['maxEntries'];
		$data['minEntries'] = $event['minEntries'];
		$data['start'] = DateTime::createFromFormat($dateFormat,$event['start'])->format('d/m/Y');
		$data['end'] = DateTime::createFromFormat($dateFormat,$event['end'])->format('d/m/Y');
		$data['sport'] =$event['sportId'];
		$data['sports'] = $this->Sport_model->getAll();
		$data['tournament'] = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['id'] = $id;
		$data['description'] = $event['description'];
		$data['gender'] = $event['gender'];
		$data['duration'] = $event['duration'];
		$data['eventTimes'] = $this->Event_model->getEventTimes($id);
		
		$this->template->write_view('content','admin/event/create',$data);
		$this->template->render();
	}
	
	public function view($id)
	{
		$event = $this->Event_model->getEvent($id);
		$data['event'] = $event;
		$data['tournament'] = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['sports'] = $this->Sport_model->getAll();
		$data['noParticipents'] = $this->Event_model->getEventRegistrationsCount($id);

		
		$this->template->write_view('nav_side','admin/event/navside',$data, true);
		$this->template->write_view('content','admin/event/view',$data);
		$this->template->render();
	}
	
	public function viewMatches($id, $page = 1, $status = 0)
	{
		$this->load->helper('url');
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/admin/event/viewMatches/";
		$config['total_rows'] = $this->Match_model->countEventMatches($id);
		$config['per_page'] = 10; 
		$config['uri_segment'] = 4;
		
		// for styling with bootstrap: http://www.smipple.net/snippet/Rufhausen/Twitter%20Bootstrap%2BCodeigniter%20Pagination
	    $config['full_tag_open'] = '<div class="pagination"><ul>';
	    $config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Previous';
	    $config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		
		$data['matches'] = $this->Match_model->getPaginationEvent($id, $config["per_page"], $page);
		
		$event = $this->Event_model->getEvent($id);
		$tournament = $this->Tournament_model->getTournamentId($event['tournamentId']);
		
		$data['tournament'] = $tournament;
		$data['event'] = $event;
		$data['links'] = $this->pagination->create_links();
		
		if ($config['total_rows'] == 0) 
		{
			$data['scheduled'] = 0;
		}
		else
		{
			$data['scheduled'] = 1;
		}
		$data['status'] = $status;
		
		$startDate = DateTime::createFromFormat("Y-m-d", $event['start']);
		$today = new DateTime();
		
		if ($startDate >= $today)
		{
			$data['allowAutomatic'] = 1;
		}
		else
		{
			$data['allowAutomatic'] = 0;
		}
		
		$this->template->write_view('content','admin/event/match_list',$data);
		$this->template->write_view('nav_side','admin/event/navside',$data, true);
		$this->template->render();
	
	}
	
	public function matchButtonHandler($id)
	{
		if ($this->input->post('submit') == "Edit schedule")
		{
			redirect("/admin/scheduler/manualWattball/{$id}");
		}
		else
		{
			redirect("/admin/scheduler/index/{$id}");
		}
	}
	
	public function viewRegistrations($id, $page=1)
	{
		$event = $this->Event_model->getEvent($id);
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/admin/event/viewRegistrations/2/";
		$config['total_rows'] = $this->Event_model->getEventRegistrationsCount($id);
		$config['per_page'] = 10; 
		$config['uri_segment'] = 5;
		
		// for styling with bootstrap: http://www.smipple.net/snippet/Rufhausen/Twitter%20Bootstrap%2BCodeigniter%20Pagination
	    $config['full_tag_open'] = '<div class="pagination"><ul>';
	    $config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Previous';
	    $config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		
		$eventRegs = $this->Event_model->getEventRegistrations($id, $config['per_page'], $page);
		
		$registrations = array();
		// wattball
		if ($event['sportId'] == 1)
		{
			$this->load->model('team/team_model');
			$i = 0;
			foreach($eventRegs as $eventReg)
			{
			$eventReg=$this->team_model->getEventReg($eventReg['nwaId']);
				if (count($eventReg) > 0)
				{
					$registrations[$i] = $eventReg;
				}
				//$registrations[$i] = $this->athlete_model->get_record($eventReg['athleteId'])[0];
				$i++;
			}
		$data['registrations'] = $registrations;
		$data['event'] = $event;
		$data['tournament'] = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['links'] = $this->pagination->create_links(); 
			// Do this one after team stuff have been sorted out...
		}
		// hurdling
		else if ($event['sportId'] == 2)
		{
			$this->load->model('athlete_model');
			$i = 0;
			foreach($eventRegs as $eventReg)
			{
				$eventReg = $this->athlete_model->get_record($eventReg['athleteId']);
				if (count($eventReg) > 0)
				{
					$registrations[$i] = $eventReg[0];
				}
				//$registrations[$i] = $this->athlete_model->get_record($eventReg['athleteId'])[0];
				$i++;
			}
		$data['registrations'] = $registrations;
		$data['event'] = $event;
		$data['tournament'] = $this->Tournament_model->getTournamentId($event['tournamentId']);
		$data['links'] = $this->pagination->create_links();
		}

		
		// load view etc...
		$this->template->write_view('nav_side','admin/event/navside',$data, true);
		$this->template->write_view('content','admin/event/registrations',$data);
		$this->template->render();
	}
	
	public function registerAthlete($eventId, $gender)
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

		$sideData['sport'] = $event['sportId'];
		$sideData['event'] = $event;
		
		if ($this->Event_model->getEventRegistrationsCount($eventId) == $event['maxEntries'])
		{
			$data['registrationError'] = 3;
		}
		
		$this->template->write_view('content','admin/event/register_athlete',$data);
		$this->template->write_view('nav_side','admin/event/navside',$data, true);
		$this->template->render();
	}
	
	public function saveAthlete($eventId)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules("firstName", "First Name", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("surname", "Surname", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("password", "password", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("dob", "Date of birth", "required|min_length[3]|max_length[50]|callback_dobCheck");
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
			
			$event = $this->Event_model->getEvent($eventId);

			$sideData['sport'] = $event['sportId'];
			$sideData['event'] = $event;
			
			$this->template->write_view('content','athlete/create',$data);
			$this->template->write_view('nav_side','admin/event/navside',$data, true);
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
			$id = $id['athleteId'];
			
			$eventRegsId = $this->Athlete_model->registerAthleteForEvent($eventId, $id);
			
			redirect("/admin/event/viewRegistrations/{$eventId}");
		}
	}
	
	public function requireGender()
	{
		$gender = $this->input->post('gender');
		if ($gender == "male" || $gender == "female")
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('requireGender', "You must specify a gender for this sport.");
			return false;
		}
	}
	
	public function dateCheck()
	{
		// get the inputs
		$start_input = $this->input->post('start');
		$end_input = $this->input->post('end');
		
		$regStart_input = $this->input->post('regStart');
		$regEnd_input = $this->input->post('regEnd');


		// validate first date format
		$dateFormat = "d/m/Y";
		$this->_startDate = DateTime::createFromFormat($dateFormat, $start_input);
		
		$date_errors = DateTime::getLastErrors();
		$errors = array();
		// push any errors to the errors array
		if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) 
		{
			array_push($errors, "Start date invalid");
		}
		
		// remember to reset date_errors otherwise they might be carried down
		$date_errors = null;
		
		// validate second date format
		$this->_endDate = DateTime::createFromFormat($dateFormat, $end_input);
		$date_errors = DateTime::getLastErrors();
		// push any errors to the errors array
		if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) 
		{
			array_push($errors, "End date invalid");
		}
		// remember to reset date_errors otherwise they might be carried down
		$date_errors = null;
		
		// validate third date format
		$this->_regStartDate = DateTime::createFromFormat($dateFormat, $regStart_input);
		$date_errors = DateTime::getLastErrors();
		// push any errors to the errors array
		if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) 
		{
			array_push($errors, "Registration start date invalid");
		}
		// remember to reset date_errors otherwise they might be carried down
		$date_errors = null;
		
		// validate third date format
		$this->_regEndDate = DateTime::createFromFormat($dateFormat, $regEnd_input);
		$date_errors = DateTime::getLastErrors();
		// push any errors to the errors array
		if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) 
		{
			array_push($errors, "Registration end date invalid");
		}
		
		// make sure the start_date is not later than end_date, only run if the format of the dates are valid
		if ( empty($errors) && $this->_startDate > $this->_endDate)
		{
			array_push($errors, "End date must be after start date");
		}
		
		// make sure the start_date is not later than end_date, only run if the format of the dates are valid
		if ( empty($errors) && $this->_regStartDate > $this->_regEndDate)
		{
			array_push($errors, "Registration end date must be after registration start date");
		}
		
		// make sure the registration end date is before
		if ( empty($errors) && $this->_startDate < $this->_regEndDate)
		{
			array_push($errors, "Registration end date must be before start date");
		}
		
		// return true if everything is ok
		if (empty($errors))
		{
			return TRUE;
		}
		// otherwise return an error message containing all the errors in the error array
		else
		{
			$error_output = "";
			for ($i = 0; $i<=count($errors); $i++)
			{
				if ($i != 0)
				{
					$error_output.="</p><p>";
				}
				$string = array_pop($errors);
				$error_output.=$string;
			}
			$this->form_validation->set_message('dateCheck', $error_output);
			return FALSE;
		}
 	}

	function uniqueEmail()
	{
		$this->load->model('Athlete_model');
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
	
	public function dobsCheck()
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
	
	public function timeCheck($time)
	{
		if (preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $time))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('timeCheck', "The duration is invalid");
			return false;
		}
	}
	
	public function eventTimesCheck()
	{
		// check if at least one time have been added
		$time = array_filter($this->input->post('eventTimes'));
		if (empty($time))
		{
			$this->form_validation->set_message('eventTimesCheck', "At least one event start time is required.");
			return false;
		}
		
		// check if they are all in valid format
		for ($i = 0; $i<count($time); $i++)
		{
				if (!preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $time[$i]))
				{
					$this->form_validation->set_message('eventTimesCheck', "The entered start times are invalid, please check the format (HH/MM)");
					return false;
					break;
				}
		}
		
		// filter the array (remove empty inputs)
		$counts = array_count_values($time);
		// check if they are all unique
		for ($i = 0; $i<count($counts); $i++)
		{
			$current = array_pop($counts);
			if ($current > 1)
			{
				$this->form_validation->set_message('eventTimesCheck', "The start times must be unique.");
				return false;
				break;
			}
		}
		
		return true;
	}
}	
