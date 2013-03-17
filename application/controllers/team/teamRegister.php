<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class teamRegister extends My_Public_Controller {
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Athlete_model');
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Tournament_model');	
		
	}
	
	public function index()
	{
		$this->register($eventId);
	}
	
	function register($eventId,$prefill = NULL)
	{
		$this->load->helper('form');
		$event = $this->Event_model->getEvent($eventId);
		//$event = $this->Event_model->getId($eventId);
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		if ($prefill != NULL)
		{
			$data['nwaId'] = $prefill['nwaId'];
			$data['name'] =  $prefill['name'];
			$data['contactFirstName'] =  $prefill['contactFirstName'];
			$data['contactSurname'] =  $prefill['contactSurname'];
			$data['firstName'] =  $prefill['firstName'];
			$data['surname'] =  $prefill['surname'];
			$data['num'] =  $prefill['num'];
			$data['email'] = $prefill['email'];
		}
		else
		{
			$data['nwaId'] = "";
			$data['name'] =  "";
			$data['contactFirstName'] =  "";
			$data['contactSurname'] =  "";
			$data['email'] =  "";
		}
		$data['password'] = "";
		$data['cpassword'] = "";
		$data['eventId'] = "";
		$data['event']=$event;
		$data['tournament'] = $this->Tournament_model->getTournamentId($data['event']['tournamentId']);
		//$this->template->write_view('nav_top','topnav');
		$sideData['sport'] = $event['sportId'];
		$sideData['event'] = $event;
		/*if ($registration != false)
		{
			$registration=true;
		}
		$data['registration'] = $registration;*/
		
		$dateFormat = "Y-m-d";
		$currentDate = new DateTime();
		$regStart = DateTime::createFromFormat($dateFormat, $event['regStart']);
		$regEnd = DateTime::createFromFormat($dateFormat, $event['regEnd']);
		
		$data['registrationError'] = 0; // no error by default
		
		if ($currentDate > $regEnd)
		{
			$data['registrationError'] = 1;
		}
		else if ($currentDate<$regStart)
		{
			$data['registrationError'] = 2;
		}
		else if ($this->Event_model->getEventRegistrationsCount($eventId) >= $event['maxEntries'])
		{
			$data['registrationError'] = 3;
		}
		
		$this->template->write_view('nav_side','navside_event', $sideData);
		$this->template->write_view('content','team/NewTeam',$data);
		$this->template->render();
	}
	
	public function add($eventId)
	{
		
		$this->load->library('form_validation');
		$this->load->model('team/Team_model');
		
		$this->form_validation->set_rules('nwaId', 'nwaId', 'required|trim|callback_checkUniqueNWAID');
		$this->form_validation->set_rules('name', 'name', 'required|trim|callback_checkUniqueTeamName|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|callback_checkUniqueEmail');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[50]');
		$this->form_validation->set_rules('cpassword', 'cpassword', 'required|trim|matches[password]');
		$this->form_validation->set_rules('contactFirstName', 'Contact First Name', 'required|trim');
		$this->form_validation->set_rules('contactSurname', 'Contact Surname', 'required|trim');
		$this->form_validation->set_rules('firstName[]', 'First Name', 'required|trim');
		$this->form_validation->set_rules('surname[]', 'Surname', 'required|trim');
		$this->form_validation->set_rules('num[]', 'Shirt Number', 'required|trim');
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		if (isset ( $_FILES['userfile']['name']))
		{
			$name = $_FILES['userfile']['name']; // get file name from form
			$fileNameParts   = explode( '.', $name ); // explode file name to two part
			$fileExtension   = end( $fileNameParts ); // give extension
			$fileExtension   = strtolower( $fileExtension ); // convert to lower case
			$encripted_pic_name   = md5($this->input->post('nwaId')).'.'.$fileExtension;  // new file name
			$config['file_name'] = $encripted_pic_name; //set file name
		}
		
		$this->load->library('upload', $config);
		
		if($this->form_validation->run()==false)
		{
			$prefill = array(
			'nwaId' => $this->input->post('nwaId'),
			'name' => $this->input->post('name'),
			'contactFirstName' => $this->input->post('contactFirstName'),
			'contactSurname' => $this->input->post('contactSurname'),
			'email' => $this->input->post('email'),
			'firstName' => $this->input->post('firstName'),
			'surname' => $this->input->post('surname'),
			'num' => $this->input->post('num'),
			);
			$this->register($eventId,$prefill);
		}
		else
		{
			$this->upload->do_upload("userfile");
			$data = array('upload_data' => $this->upload->data());
			if ($this->upload->display_errors() != "You did not select a file to upload." && $this->upload->display_errors() != NULL)
			{
				$this->register($eventId);
			}
			$data = array(
			'nwaId' => $this->input->post('nwaId'),
			'name' => $this->input->post('name'),
			'contactFirstName' => $this->input->post('contactFirstName'),
			'contactSurname' => $this->input->post('contactSurname'),
			'email' => $this->input->post('email'),
			'password' => sha1($this->input->post('password')),
			);
			$this->Team_model->create($data);
			$data1 = array(
			'eventRegsId' =>NULL,
			'eventId'=>$eventId,
			'nwaId' => $this->input->post('nwaId'),
			'athleteId' => NULL
			);
			$this->Team_model->createTeamReg($data1);
			
			$firstName = $this->input->post('firstName');
			$surname = $this->input->post('surname');
			$num = $this->input->post('num');
			
			for ($i = 0; $i < 10; $i++)
			{
				$data = array (
				'nwaId' => $this->input->post('nwaId'),
				'shirtNo' => $num[$i],
				'firstName' => $firstName[$i],
				'surname' => $surname[$i]
				);
				$this->Team_model->createPlayer($data);
			}
			redirect('', 'refresh');
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

