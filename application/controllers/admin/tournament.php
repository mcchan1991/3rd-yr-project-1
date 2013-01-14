<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for tournament administration
 *
 * Created: 01/11/2012
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Tournament extends My_Admin_Controller {

	private $_startDate;
	private $_endDate;
	private $_tournamentId;
	
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Event_model');
		$this->load->helper('form');
		$this->load->model('admin/Sport_model');
	}
	
	/**
	 * Index should probably be a list of all tournaments for admins, but make it later
	 */
	public function index($page = 1)
	{
		$this->load->helper('url');
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/admin/tournament/index/";
		$config['total_rows'] = $this->Tournament_model->tournamentCountFuture();
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
		
		$data['tournaments'] = $this->Tournament_model->getFutureTournaments($config["per_page"], $page);
		$data['eventCount'] = array();
		foreach($data['tournaments'] as $tournament )
		{
			$data['eventCount'][$tournament['tournamentId']] = $this->Event_model->countEventsByTournamentId($tournament['tournamentId']);
		}
		
	
		$data['links'] = $this->pagination->create_links();
		
		$this->template->write_view('content','admin/tournament/list',$data);
		$this->template->render();
	}
	
	/**
  	 * This method will show the specific tournament details
	 * @param id	The id of the tournament that will be shown
     */
	public function view($id = null)
	{
		if ($id == null)
		{
			echo "Error! No id selected!";
			exit();
		}
		$data['tournament'] = $this->Tournament_model->getTournamentId($id);
		if (empty($data['tournament']))
		{
			echo "No tournament with the specified ID exists. <br />";
			exit();
		}
		$data['noEvents'] = $this->Event_model->countEventsByTournamentId($id);
		// empty the nav_side region as we need to overwrite it:
		$this->template->empty_region('nav_side');
		$this->template->write_view('nav_side','admin/tournament/navbar_side', $data);
		$this->template->write_view('content','admin/tournament/view',$data);
		
		$this->template->render();
		/*echo print_r($data['tournament']);
		echo $id;*/
	}
	
	/**
  	 * Validates the input and saves a tournament if OK.
     */
	public function save($id = FALSE)
	{
		$this->load->library('form_validation');
		//validate the input
		$this->form_validation->set_rules("name", "Tournament name", "required|min_length[5]|max_length[50]");
		$this->form_validation->set_rules("startDate", "Start Date", "required");
		$this->form_validation->set_rules("endDate", "End Date", "required|callback_dateCheck");
		$this->form_validation->set_rules("noTickets", "No. tickets", "required|numeric");
	
		// if input is not valid, show the form again (and send the post-date to the view so it can be re-populated)
		if ($this->form_validation->run() == FALSE)
		{
			$data['name'] = $this->input->post('name');
			$data['startDate'] = $this->input->post('startDate');
			$data['endDate'] = $this->input->post('endDate');
			$data['noTickets'] = $this->input->post('noTickets');
			
			$this->template->write_view('content','admin/tournament/create',$data);
			$this->template->render();
			
		}
		// if everything is ok
		else
		{
			$this->load->helper('url');			
			// get the data
			// use the create method in the controller
			if ($id == FALSE)
			{
				$postdata = array(
					'name'	=> $this->input->post('name'),
					'start' => $this->_startDate->format('Y-m-d'),
					'end' => $this->_endDate->format('Y-m-d'),
					'noTickets' => $this->input->post('noTickets')
				);
				$id = $this->Tournament_model->create($postdata);
			}
			else
			{
				$postdata = array(
					'tournamentId'	=> $id,
					'name'	=> $this->input->post('name'),
					'start' => $this->_startDate->format('Y-m-d'),
					'end' => $this->_endDate->format('Y-m-d'),
					'noTickets' => $this->input->post('noTickets')
				);
				$this->Tournament_model->update($postdata);
			}

			// placeholder echo.
			//echo "Tournament id : {$id} added/edited correctly. This is a placeholder. User should be redirected to list of tournaments.";
			redirect( "/admin/tournament" );
		}

	}
	
	/**
  	 * View for admins to create a new Tournament
     */
	public function add()
	{
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['name'] = "";
		$data['startDate'] = "";
		$data['endDate'] = "";
		$data['noTickets'] = "";
		$this->template->write_view('content','admin/tournament/create',$data);
		$this->template->render();
		
		// load view
		
	}
	
	/**
  	 * View so admin can edit a specific tournament.
	 * @param id	the ID of the tournament to added.
     */
	public function edit($id)
	{
		// form validations used to set variables.
		$this->load->library('form_validation');
		
		// get the id
		$tournament = $this->Tournament_model->getTournamentId($id);
		
		$start_date = $tournament['start'];
		$end_date = $tournament['end'];
		
		// format it correctly
		$dateFormat = "Y-m-d";
		$start_dateTime = DateTime::createFromFormat($dateFormat, $start_date);
		$end_dateTime = DateTime::createFromFormat($dateFormat, $end_date);
		
		$data['name'] = $tournament['name'];
		$data['startDate'] = $start_dateTime->format('d/m/Y');
		$data['endDate'] =  $end_dateTime->format('d/m/Y');
		$data['noTickets'] = $tournament['noTickets'];
		$data['id'] = $id;
		
		if (empty($tournament))
		{
			echo "Invalid ID placeholder : {$id}";
			exit;
		}
		$sideData['tournament'] = $tournament;
		$this->template->write_view('nav_side','admin/tournament/navbar_side',$sideData, true);
		$this->template->write_view('content','admin/tournament/create',$data);
		$this->template->render();
	}
	
	/**
	 *	Not sure if this is needed in a controller? Find out later
	 *
	 */
	public function delete()
	{
		
	}
	
	
	public function viewEvents($id,$page=1)
	{
		$this->load->helper('url');
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/admin/tournament/viewEvents/";
		$config['total_rows'] = $this->Event_model->countEventsByTournamentId($id);
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
		
		$data['events'] = $this->Event_model->getPaginationByTournamentId($id,$config["per_page"], $page);
		$data['links'] = $this->pagination->create_links();
		$data['sports'] = $this->Sport_model->getAll();
		$data['tournament'] = $this->Tournament_model->getTournamentId($id);
		
		$this->template->write_view('content','admin/tournament/event_list',$data);
		$this->template->render();
		
	}
	
	
	/**
	 * Function that allows the user to add a umpire to a tournament
	 * 
	 * @param id		the id of the tournament the umpire should be added to.
	 */
	public function addUmpire($id)
	{
		$this->load->library('form_validation');
		$this->load->model('admin/Umpire_model');
		$this->load->model('admin/Sport_model');
		
		$data['tournament'] = $this->Tournament_model->getTournamentId($id);
		$data['umpires']  = $this->Umpire_model->getAll();
		$data['sports'] = $this->Sport_model->getAll();
		
		$data['id'] = "";
		$data['date'] = "";
		$data['availableFrom'] = "";
		$data['availableTo'] = "";
		$data['checked'] = false;
		
		$sideData['tournament'] = $data['tournament'];
		$this->template->write_view('nav_side','admin/tournament/navbar_side',$sideData, true);
		$this->template->write_view('content','admin/tournament/add_umpire',$data);
		$this->template->render();
	}
	
	/**
	 *	Function used to validate input and save an umpire.
	 *  @param tournamentId		the tournament the umpire is being saved to
	 *  @param umpireId			the umpireId is set if editing
	 */ 
	public function saveUmpire($tournamentId, $umpireId = false)
	{
		$this->load->library('form_validation');
		$this->load->model('admin/Umpire_model');
		$this->load->model('admin/Sport_model');
		
		//validate the input
		$this->form_validation->set_rules("umpire", "Umpire", "required");
		$this->form_validation->set_rules("date", "Date", "required|callback_umpireDateCheck");
		$this->form_validation->set_rules("from", "Available From", "callback_umpireRequiredFields|callback_umpireTimeCheck");
		$this->_tournamentId = $tournamentId;
		
		$umpire = $this->input->post('umpire');
		$date = $this->input->post('date');
		$to = $this->input->post('to');
		$from = $this->input->post('from');
		$allDay = $this->input->post('allDay');
						
		if ($this->form_validation->run() == FALSE)
		{
			if ($umpireId == false)
			{
				$data['id'] = "";
			}
			else
			{
				$data['id'] = $umpireId;
				
			}
			$data['date'] = $date;
			$data['availableFrom'] = $from;
			$data['availableTo'] = $to;
			if ($allDay == 1)
			{
				$data['checked'] = true;			
			}
			else
			{
				$data['checked'] = false;
			}
			
			$data['tournament'] = $this->Tournament_model->getTournamentId($tournamentId);
			$data['umpires']  = $this->Umpire_model->getAll();
			$data['sports'] = $this->Sport_model->getAll();
			
			$sideData['tournament'] = $data['tournament'];
			$this->template->write_view('nav_side','admin/tournament/navbar_side',$sideData, true);
			$this->template->write_view('content','admin/tournament/add_umpire',$data);
			$this->template->render();
		}
		else
		{
			if ($umpireId == false)
			{
				$dateFormat = "d/m/Y";
				$dateObject = DateTime::createFromFormat($dateFormat, $date);
				
				if ($allDay == 1)
				{
					$from = "00:00";
					$to = "23:59";
				}
				$dateFormat = "H:i";
				$fromObject = DateTime::createFromFormat($dateFormat, $from);
				$toObject = DateTime::createFromFormat($dateFormat, $to);
				
				$dateFormat = "Y-m-d H:i:s";
								
				$postdata = array(
					'umpireId' => $umpire,
					'tournamentId' => $tournamentId,
					'date' => $dateObject->format('Y-m-d'),
					'availableFrom' => $fromObject->format($dateFormat),
					'availableTo' => $toObject->format($dateFormat),
				);
				$this->Umpire_model->createUmpireAvailability($postdata);
			}

			
			redirect( "/admin/tournament/umpireList/{$tournamentId}" );
		}
	}
	
	/**
	 * Callback function to check that all fields are entered as required
	 * either all day needs to be checked OR availableFrom AND availableTo needs to be entered
	 * 
	 */
	public function umpireRequiredFields()
	{
		$to = $this->input->post('to');
		$from = $this->input->post('from');
		$allDay = $this->input->post('allDay');
		
		if ($allDay == 1)
		{
			return true;
		}
		else if (!empty($from) && !empty($to))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('umpireRequiredFields', "You must fields \"Available From\" AND \"Available To\" OR \"All day\"");
			return false;
		}

	}
	/**
	 * Callback function to check that the entered date is valid 
	 * and whether the it is within the tournament dates
	 * 
	 * @return		true or false
	 */ 
	public function umpireDateCheck()
	{
		$date = $this->input->post('date');
		$dateFormat = "d/m/Y";
		$dateObject = DateTime::createFromFormat($dateFormat, $date);
		
		$date_errors = DateTime::getLastErrors();
		$errors = array();
		// push any errors to the errors array
		if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) 
		{
			array_push($errors, "Invalid date");
		}
		
		// check date os within the tournament date:
		$tournament = $this->Tournament_model->getTournamentId($this->_tournamentId);
		$start = $tournament['start'];
		$end = $tournament['end'];
		
		$dateFormat = "Y-m-d";
		$startObject = DateTime::createFromFormat($dateFormat, $start);
		$endObject = DateTime::createFromFormat($dateFormat, $end);
		
		//echo "start: " . $startObject->format($dateFormat) . " end: " . $endObject->format($dateFormat) . " date: " . $dateObject->format($dateFormat);
				
		if ($dateObject < $startObject || $dateObject > $endObject)
		{
			array_push($errors, "The date must be within the tournament start and end dates.");
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
			$this->form_validation->set_message('umpireDateCheck', $error_output);
			return FALSE;
		}
	}
	/**
	 * 	callback function used to check whether the from time is before the to time.
	 * 
	 * @return	true if from time is less than to time.
	 */ 
	public function umpireTimeCheck()
	{
		$to = $this->input->post('to');
		$from = $this->input->post('from');
		
		$dateFormat = "H:i";
		$fromObject = DateTime::createFromFormat($dateFormat, $from);
		$toObject = DateTime::createFromFormat($dateFormat, $to);
		
		if ($fromObject > $toObject)
		{
			$this->form_validation->set_message('umpireTimeCheck', '"Available from" must be less than "Available to"');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * Shows a list of umpires registered for a given tournament.
	 * 
	 * @param id	id of the tournament
	 * @param page	the page number of the pagination
	 */
	public function umpireList($id, $page = 1)
	{
		$this->load->model('admin/Umpire_model');
		$this->load->model('admin/Sport_model');
		
		$this->load->helper('url');
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/admin/tournament/umpireList/{$id}/";
		$config['total_rows'] = $this->Umpire_model->countUmpireAtTournament($id);
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
		
		//echo print_r($umpires);
		
		$this->pagination->initialize($config);
		
		$data['umpires'] = $this->Umpire_model->getUmpireAtTournament($id, $config["per_page"], $page);
		$data['links'] = $this->pagination->create_links();
		$data['tournament'] = $this->Tournament_model->getTournamentId($id);
		$data['sports'] = $this->Sport_model->getAll();
		
		$sideData['tournament'] = $data['tournament'];
 		$this->template->write_view('nav_side','admin/tournament/navbar_side',$sideData, true);
		$this->template->write_view('content','admin/tournament/umpire_list',$data);
		$this->template->render();
	}
	
	/**
  	 *  A custom validation function that makes sure the end date if after the start date.
     */
	public function dateCheck()
	{
		// get the inputs
		$start_input = $this->input->post('startDate');
		$end_input = $this->input->post('endDate');

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
		
		// make sure the start_date is not later than end_date, only run if the format of the dates are valid
		if ( empty($errors) && $this->_startDate > $this->_endDate)
		{
			array_push($errors, "End date must be after start date");
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

/* End of file tournament.php */
/* Location: ./application/controllers/admin/tournament.php */