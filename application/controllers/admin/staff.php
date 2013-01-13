<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for Staff administration
 *
 * Created: 13/01/2013
 * @author	Jonathan Val <jdv2@hw.ac.uk>
 */
class Staff extends My_Admin_Controller 
{
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin/Staff_model');
	}
	
	// should be a list of all the staff with pagination etc
	public function index($page = 1)
	{
		$this->load->helper('url');
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/admin/staff/index/";
		$config['total_rows'] = $this->Staff_model->countStaff();
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
		
		$data['staff'] = $this->Staff_model->getPagination($config["per_page"], $page);
		$data['links'] = $this->pagination->create_links();
		
		$this->template->write_view('content','admin/staff/index',$data);
		$this->template->render();
	}
	
	public function save($id = false)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules("firstname", "First Name", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("surname", "Surname", "required|min_length[2]|max_length[50]");
		
		if ($id == false)
		{
			$this->form_validation->set_rules("email", "E-mail", "required|valid_email|max_length[50]|callback_checkUniqueEmail");
			$this->form_validation->set_rules("username", "Username", "required|max_length[50]|callback_checkUniqueUser");
			$this->form_validation->set_rules("password", "Password", "required|min_length[6]|max_length[50]");
		}
		else
		{
			$this->form_validation->set_rules("email", "E-mail", "required|valid_email|max_length[50]");
			$this->form_validation->set_rules("username", "Username", "required|max_length[50]");
			$this->form_validation->set_rules("password", "Password", "min_length[6]|max_length[50]");
		}


		// if input is not valid, show the form again (and send the post-date to the view so it can be re-populated)
		if ($this->form_validation->run() == FALSE)
		{
			$data['firstname'] = $this->input->post('firstname');
			$data['surname'] = $this->input->post('surname');
			$data['email'] = $this->input->post('email');
			$data['username'] = $this->input->post('username');
			$data['manager'] = $this->input->post('manager');
			
			$this->load->view('admin/staff/create',$data);
		}
		else
		{
			$this->load->helper('url');			
			
			if ($id == false)
			{

				$postdata = array(
					'firstname'	=> $this->input->post('firstname'),
					'surname' => $this->input->post('surname'),
					'email' => $this->input->post('email'),		
					'username' => $this->input->post('username'),		
					'password' => SHA1($this->input->post('password')),
					'manager' => $this->input->post('manager')
				);
				$id = $this->Staff_model->create($postdata);
				
				echo "successfully addedd id: " . $id;
			}
			else
			{
				$postdata = array(
					'staffId'	=> $id,
					'firstname'	=> $this->input->post('firstname'),
					'surname' => $this->input->post('surname'),
					'email' => $this->input->post('email'),		
					'username' => $this->input->post('username'),		
					'password' => SHA1($this->input->post('password')),
					'manager' => $this->input->post('manager')		
				);
				
				$this->Staff_model->update($postdata);
			}
			redirect( "/admin/staff" );
		}
	}
	
	public function add()
	{
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['username'] = "";
		$data['firstname'] = "";
		$data['surname'] = "";
		$data['email'] = "";
		$data['password'] = "";
		$data['manager'] = "";
		
		$this->template->write_view('content','admin/staff/create',$data);
		$this->template->render();
	}
	
	/**
  	 * View so admin can edit a specific staff.
	 * @param id	the ID of the tournament to be edited.
     */
	public function edit($id)
	{
		// form validations used to set variables.
		$this->load->library('form_validation');
		
		// get the id
		$staff = $this->Staff_model->getStaff($id);
		
		$data['username'] = $staff['username'];
		//$data['password'] = $staff['password'];
		$data['password'] = "";
		$data['firstname'] = $staff['firstname'];
		$data['surname'] = $staff['surname'];
		$data['email'] = $staff['email'];
		$data['manager'] = $staff['manager'];
		$data['id'] = $id;
		
		$this->template->write_view('content','admin/staff/create',$data);
		$this->template->render();
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
		$result = $this->Staff_model->checkUniqueEmail($email);
		
		if ($result == false)
		{
			$this->form_validation->set_message('checkUniqueEmail', "This e-mail is already registered to a staff member.");	
		}
		
		return $result;
	}
	
	public function checkUniqueUser()
	{
		$username = $this->input->post('username');
		$result = $this->Staff_model->checkUniqueUser($username);
		
		if ($result == false)
		{
			$this->form_validation->set_message('checkUniqueUser', "This username is already registered to a staff member.");	
		}
		
		return $result;
	}
	
	
}	
