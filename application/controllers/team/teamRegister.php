<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class teamRegister extends CI_Controller {

	
	public function index()
	{
		
		$this->template->write_view('content','team/TeamLogin',$data);
		$this->template->render();
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
		
		$this->form_validation->set_rules('nwaId', 'nwaId', 'required|trim');
		$this->form_validation->set_rules('name', 'name', 'required|trim');
		$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'cpassword', 'required|trim|matches[password]');
		$this->form_validation->set_rules('contactFirstName', 'Contact First Name', 'required|trim');
		$this->form_validation->set_rules('contactSurname', 'Contact Surname', 'required|trim');
		
		if($this->form_validation->run())
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
		else
		{
			redirect('team/teamRegister/register', 'refresh');
		}
	}
	
	
	public function team_update()
	{
	$this->load->model('team/Team_model');
	$this->load->library('form_validation');
		
	$this->form_validation->set_rules('name', 'namee', 'required|trim');
	$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email');
	$this->form_validation->set_rules('contactFirstName', 'contactFirstName', 'required|trim');
	$this->form_validation->set_rules('contactSurname', 'Contact Surname', 'required|trim');
	$this->form_validation->set_rules('password', 'Password', 'required|trim');
	$this->form_validation->set_rules('cpassword', 'cpassword', 'required|trim|matches[password]');
	
	if($this->form_validation->run()==false)
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
		}
	else
		{
			echo "You have updated";
			echo $this->session->userdata('nwaId');
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
}

