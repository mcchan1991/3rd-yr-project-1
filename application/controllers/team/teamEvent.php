<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class teamEvent extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		//$this->load->model('team/team_model');
	}
	
	
	public function index()
	{
		$this->load->helper('form');
		$this->load->model('team/Team_model');
		//$result['A']=$this->Event_model->getEventID();
		$data['eventId'] ="";
		$this->template->write_view('content','team/team_event',$data);
		$this->template->render();
	}

	public function teamEvent1()
	{
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('team/Team_model');
		$this->form_validation->set_rules('eventId', 'eventId', 'required|trim|callback_check_eventId|callback_check_date');
		//$query=$this->Event_model->getEvent1($this->input->post('eventId'));
		
		if($this->form_validation->run()==false)
		{
		$this->load->helper('form');
		$this->load->model('team/Team_model');
		//$result['A']=$this->Event_model->getEventID();
		$data['eventId'] ="";
		$this->template->write_view('content','team/team_event',$data);
		$this->template->render();
		}
		else
		{		

				echo "You have registered";
				$data = array(
				'eventRegsId' =>NULL,
				'eventId' => $this->input->post('eventId'),
				'nwaId' => $this->session->userdata('nwaId'),
				'athleteId' => NULL
				);
				$this->Team_model->createTeamReg($data);
				redirect('team/welcome', 'refresh');
		}
		}
		
	
	
	public function check_eventId()
	{
	$this->load->model('team/Team_model');
	
	$eventId = $this->input->post('eventId');
	$regID=$this->Team_model->getEventRegs($eventId);
	$errors = array();
	if($eventId=$regID)
	{
		array_push($errors, "invalid, team already register the event");
	}
	
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
			$this->form_validation->set_message('check_eventId', $error_output);
			return FALSE;
		}
		 
	}
	
	public function check_date()
	{
		$this->load->model('team/Team_model');
		$query=$this->Team_model->getEvent($this->input->post('eventId'));
		$errors = array();
		$i=0;
		foreach($query as$value)
		{ 
		$start[$i]=$value;
		$i++;
		} 
		$a=strtotime($start[0]);
		$b=strtotime($start[1]);
		if($a>=strtotime(date('Y-m-d', time())))
		{
			array_push($errors, "invalid, registeration date not avilable");
		}

		if($b<=strtotime(date('Y-m-d', time())))
		{
			array_push($errors, "invalid, registeration date expire ");
		}
		
		
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
			$this->form_validation->set_message('check_date', $error_output);
			return FALSE;
		}
	}
}
