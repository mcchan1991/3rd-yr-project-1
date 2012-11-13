<?php 
class Tournament extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Tournament_model');
	}
	/**
	 * Index should probably be a list of all tournaments for admins, but make it later
	 */
	public function index()
	{
		//$this->load->view('welcome_message');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules("name", "Tournament name", "required|min_length[5]|max_length[50]|xss_clean");
		$this->form_validation->set_rules("end_date", "End Date", "required|callback_date_check|xss_clean");
		$this->form_validation->set_rules("no_tickets", "No. tickets", "required|numeric|xss_clean");
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/tournament/create');
		}
		$get = $this->input->get(NULL, TRUE); 
	}
	
	public function add()
	{
		$this->load->helper('form');
		$this->load->view('admin/tournament/create');
		
		// load view
		
	}
	
	public function edit()
	{
		
	}
	
	/**
	 *	Not sure if this is needed in a controller? Find out later
	 *
	 */
	public function delete()
	{
		
	}
	
	public function date_check($end_date_input)
	{
		$start_input = $this->input->post('start_date');
		$end_input = $this->input->post('end_date');

		// validate first date format
		$dateFormat = "d/m/Y";
		$start_date = DateTime::createFromFormat($dateFormat, $start_input);
		
		$date_errors = DateTime::getLastErrors();
		$errors = array();
		if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) 
		{
			array_push($errors, "Start date invalid");
		}
		// remember to reset date_errors otherwise they might be carried down
		$date_errors = null;
		// validate second date format
		$end_date = DateTime::createFromFormat($dateFormat, $end_input);
		$date_errors = DateTime::getLastErrors();
		if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) 
		{
			array_push($errors, "End date invalid");
		}
		// make sure the start_date is not later than end_date
		if ( empty($errors) && $start_date > $end_date)
		{
			array_push($errors, "End date must be after start date");
		}
		
		if (empty($errors))
		{
			return TRUE;
		}
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
			$this->form_validation->set_message('date_check', $error_output);
			return FALSE;
		}
 	}
}

/* End of file tournament.php */
/* Location: ./application/controllers/admin/tournament.php */