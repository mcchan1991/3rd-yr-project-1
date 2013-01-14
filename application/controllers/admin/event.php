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
			$data['tournament'] = $this->input->post('tournament');
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
					'regStart' => DateTime::createFromFormat($dateFormat, $this->input->post('regStart'))->format('Y-m-d'),
					'regEnd' => DateTime::createFromFormat($dateFormat, $this->input->post('regEnd'))->format('Y-m-d'),
					'maxEntries' => $this->input->post('maxEntries'),
					'minEntries' => $this->input->post('minEntries'),
					'start' => DateTime::createFromFormat($dateFormat, $this->input->post('start'))->format('Y-m-d'),
					'end' => DateTime::createFromFormat($dateFormat, $this->input->post('end'))->format('Y-m-d'),	
					'sportId' => $this->input->post('sport'),						
				);
				$id = $this->Event_model->create($postdata);
				
				echo "successfully addedd id: " . $id;
			}
			else
			{
				$postdata = array(
					'eventId'	=> $id,
					'tournamentId' => $this->input->post('tournament'),
					'name'	=> $this->input->post('name'),
					'regStart' => DateTime::createFromFormat($dateFormat, $this->input->post('regStart'))->format('Y-m-d'),
					'regEnd' => DateTime::createFromFormat($dateFormat, $this->input->post('regEnd'))->format('Y-m-d'),
					'maxEntries' => $this->input->post('maxEntries'),
					'minEntries' => $this->input->post('minEntries'),
					'start' => DateTime::createFromFormat($dateFormat, $this->input->post('start'))->format('Y-m-d'),
					'end' => DateTime::createFromFormat($dateFormat, $this->input->post('end'))->format('Y-m-d'),	
					'sportId' => $this->input->post('sport'),					
				);
				
				$this->Event_model->update($postdata);
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
		$data['tournament'] = $tournament;
		
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
		$data['tournament'] = $event['tournamentId'];
		$data['id'] = $id;
		
		$this->template->write_view('content','admin/event/create',$data);
		$this->template->render();
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
}	
