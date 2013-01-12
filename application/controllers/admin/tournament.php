<?php 
/**
 * Controller for tournament administration
 *
 * Created: 01/11/2012
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Tournament extends CI_Controller {

	private $_startDate;
	private $_endDate;
	
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Tournament_model');
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
		
		$this->pagination->initialize($config);
		
		$data['tournaments'] = $this->Tournament_model->getFutureTournaments($config["per_page"], $page);
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
		$this->load->helper('form');
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