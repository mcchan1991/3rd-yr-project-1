<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class teamRegister extends CI_Controller {

	
	public function index()
	{
		$this->register();
	}
	
	function register()
	{
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['nwaId'] = "";
		$data['name'] = "";
		$data['contactFirstName'] = "";
		$data['contactSurname'] = "";
		$data['email'] = "";
		$data['password'] = "";
		$data['cpassword'] = "";
		$this->template->write_view('content','team/NewTeam',$data);
		$this->template->render();
	}
	
	public function add()
	{
		$this->load->library('form_validation');
		$this->load->model('team/Team_model');
		
		$this->form_validation->set_rules('nwaId', 'nwaId', 'required|trim|callback_checkUniqueNWAID');
		$this->form_validation->set_rules('name', 'name', 'required|trim|callback_checkUniqueTeamName|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|callback_checkUniqueEmail');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|max_length[50]');
		$this->form_validation->set_rules('cpassword', 'cpassword', 'required|trim|matches[password]');
		$this->form_validation->set_rules('contactFirstName', 'Contact First Name', 'required|trim');
		$this->form_validation->set_rules('contactSurname', 'Contact Surname', 'required|trim');
		
		if($this->form_validation->run()==false)
		{
			$this->register();
		}
		else
		{
			echo "You have registered";
			$data = array(
			'nwaId' => $this->input->post('nwaId'),
			'name' => $this->input->post('name'),
			'contactFirstName' => $this->input->post('contactFirstName'),
			'contactSurname' => $this->input->post('contactSurname'),
			'email' => $this->input->post('email'),
			'password' => sha1($this->input->post('password')),
			);
			$this->Team_model->create($data);
			redirect('team/welcome', 'refresh');
		}
	}
	
	
	public function team_update()
	{
	$this->load->model('team/Team_model');
	$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'name', 'required|trim|callback_UpdateCheckUniqueTeamName|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|callback_UpdateCheckUniqueEmail');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|max_length[50]');
		$this->form_validation->set_rules('cpassword', 'cpassword', 'required|trim|matches[password]');
		$this->form_validation->set_rules('contactFirstName', 'Contact First Name', 'required|trim');
		$this->form_validation->set_rules('contactSurname', 'Contact Surname', 'required|trim');
	
	if($this->form_validation->run()==false)
		{
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['nwaId'] = "";
		$data['name'] = "";
		$data['contactFirstName'] = "";
		$data['contactSurname'] = "";
		$data['email'] = "";
		$data['password'] = "";
		$data['cpassword'] = "";
		$this->template->write_view('content','team/update',$data);
		$this->template->render();
		}
	else
		{
			echo "You have updated";
			$data = array(
			'email' => $this->input->post('email'),
			'name' => $this->input->post('name'),
			'contactFirstName' => $this->input->post('contactFirstName'),
			'contactSurname' => $this->input->post('contactSurname'),
			'password' => sha1($this->input->post('password'))
			);
			$this->Team_model->update($this->session->userdata('nwaId'),$data);
			redirect('team/welcome', 'refresh');
			
		}
	
	}
	
	public function update()
	{
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		//$data['nwaId'] = "";
		$data['name'] = "";
		$data['contactFirstName'] = "";
		$data['contactSurname'] = "";
		$data['email'] = "";
		$data['password'] = "";
		$data['cpassword'] = "";
		$this->template->write_view('content','team/update',$data);
		$this->template->render();
		//$this->load->view('team/update');
	}
	
	public function checkUniqueEmail()
	{
		$email = $this->input->post('email');
		$result = $this->Team_model->checkUniqueEmail($email);
		
		if ($result == false)
		{
			$this->form_validation->set_message('checkUniqueEmail', "This e-mail is already registered.");	
		}
		
		return $result;
	}
	
	public function checkUniqueNWAID()
	{
		$Id = $this->input->post('nwaId');
		$result = $this->Team_model->checkUniqueNWAID($Id);
		
		if ($result == false)
		{
			$this->form_validation->set_message('checkUniqueNWAID', "This NWAID is already registered.");	
		}
		
		return $result;
	}
	
	public function checkUniqueTeamName()
	{
		$name = $this->input->post('name');
		$result = $this->Team_model->checkUniqueTeamName($name);
		
		if ($result == false)
		{
			$this->form_validation->set_message('checkUniqueTeamName', "This TeamName is already registered.");	
		}
		
		return $result;
	}
	
	public function UpdateCheckUniqueTeamName()
	{
		$currentID=$this->session->userdata('nwaId');
		$name = $this->input->post('name');
		$result = $this->Team_model->UpdateCheckUniqueTeamName($name,$currentID);
		
		if ($result == false)
		{
			$this->form_validation->set_message('UpdateCheckUniqueTeamName', "This team name is already registered.");	
		}
		
		return $result;
	}

	public function UpdateCheckUniqueEmail()
	{
		$currentID=$this->session->userdata('nwaId');
		$email = $this->input->post('email');
		$result = $this->Team_model->UpdateCheckUniqueEmail($email,$currentID);
		
		if ($result == false)
		{
			$this->form_validation->set_message('UpdateCheckUniqueEmail', "This email is already registered.");	
		}
		
		return $result;
	}
}

