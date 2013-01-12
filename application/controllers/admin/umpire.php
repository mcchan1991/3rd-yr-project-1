<?php

/**
 * Controller for Umpire administration
 *
 * Created: 11/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Umpire extends CI_Controller 
{
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		parent::__construct();
		
		if(!$this->session->userdata('logged_in')){
			redirect( "/admin/login" );
		}
		
		$this->load->model('admin/Umpire_model');
		$this->load->model('admin/Sport_model');
		
	}
	
	// should be a list of all the umpires with pagination etc
	public function index($page = 1)
	{
		$this->load->helper('url');
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/admin/umpire/index/";
		$config['total_rows'] = $this->Umpire_model->countUmpires();
		$config['per_page'] = 10; 
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['umpires'] = $this->Umpire_model->getPagination($config["per_page"], $page);
		$data['links'] = $this->pagination->create_links();
		$data['sports'] = $this->Sport_model->getAll();
		
		$this->load->view('admin/umpire/index', $data);
	}
	
	public function save($id = false)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules("firstName", "First Name", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("surname", "Surname", "required|min_length[5]|max_length[50]");
		$this->form_validation->set_rules("dob", "Date Of Birth", "required|callback_dateCheck|max_length[10]");
		if ($id == false)
		{
			$this->form_validation->set_rules("email", "E-mail", "required|valid_email|max_length[50]|callback_checkUniqueEmail");
		}
		else
		{
			$this->form_validation->set_rules("email", "E-mail", "required|valid_email|max_length[50]");
		}


		// if input is not valid, show the form again (and send the post-date to the view so it can be re-populated)
		if ($this->form_validation->run() == FALSE)
		{
			$data['firstName'] = $this->input->post('firstName');
			$data['surname'] = $this->input->post('surname');
			$data['DOB'] = $this->input->post('dob');
			$data['email'] = $this->input->post('email');
			$data['sport'] =$this->input->post('sport');
			$data['sports'] = $this->Sport_model->getAll();
			
			$this->load->view('admin/umpire/create',$data);
		}
		else
		{
			$this->load->helper('url');			
			
			$dateFormat = "d/m/Y";
			$dobObject = DateTime::createFromFormat($dateFormat, $this->input->post('dob'));
			
			if ($id == false)
			{

				$postdata = array(
					'firstName'	=> $this->input->post('firstName'),
					'surname' => $this->input->post('surname'),
					'DOB' => $dobObject->format('Y-m-d'),
					'email' => $this->input->post('email'),
					'sport' => $this->input->post('sport')					
				);
				$id = $this->Umpire_model->create($postdata);
				
				echo "successfully addedd id: " . $id;
			}
			else
			{
				$postdata = array(
					'umpireId'	=> $id,
					'firstName'	=> $this->input->post('firstName'),
					'surname' => $this->input->post('surname'),
					'DOB' => $dobObject->format('Y-m-d'),
					'email' => $this->input->post('email'),
					'sport' => $this->input->post('sport')					
				);
				
				$this->Umpire_model->update($postdata);
			}
			redirect( "/admin/umpire" );
		}
	}
	
	public function add()
	{
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['firstName'] = "";
		$data['surname'] = "";
		$data['DOB'] = "";
		$data['email'] = "";
		$data['sport'] ="";
		$data['sports'] = $this->Sport_model->getAll();
		
		$this->load->view('admin/umpire/create', $data);
	}
	
	/**
  	 * View so admin can edit a specific umpire.
	 * @param id	the ID of the tournament to be edited.
     */
	public function edit($id)
	{
		// form validations used to set variables.
		$this->load->library('form_validation');
		
		// get the id
		$umpire = $this->Umpire_model->getUmpire($id);
		
		$dateFormat = "Y-m-d";
		$dob = $umpire['DOB'];
		$dobObject = DateTime::createFromFormat($dateFormat, $dob);
		
		$data['firstName'] = $umpire['firstName'];
		$data['surname'] = $umpire['surname'];
		$data['DOB'] = $dobObject->format('d/m/Y');
		$data['email'] = $umpire['email'];
		$data['sport'] =$umpire['sport'];
		$data['sports'] = $this->Sport_model->getAll();
		$data['id'] = $id;
		
		$this->load->view('admin/umpire/create', $data);
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
			array_push($errors, "Date Of Birth invalid");
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
	
	public function checkUniqueEmail()
	{
		$email = $this->input->post('email');
		$result = $this->Umpire_model->checkUniqueEmail($email);
		
		if ($result == false)
		{
			$this->form_validation->set_message('checkUniqueEmail', "This e-mail is already registered to an umpire.");	
		}
		
		return $result;
	}
}	
?>