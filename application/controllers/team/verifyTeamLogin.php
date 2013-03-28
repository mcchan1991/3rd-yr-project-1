<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class verifyTeamLogin extends My_Public_Controller{

	function __construct()
	{
		session_start();
		parent::__construct();
		$this->load->model('team/team_model');
		$this->load->model('Athlete_model');
		$this->load->model('admin/Event_model');
		$this->load->model('admin/Tournament_model');
	}

	function index()
	{
		$this->teamLogin();
	}
	
	function teamLogin($eventId = NULL)
	{
		$this->load->helper('form');
		if($this->session->userdata('login_state')==false)
		{
				//This method will have the credentials validation
				$this->load->library('form_validation');
				$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

				if($this->form_validation->run() == FALSE)
				{
					//Field validation failed.  User redirected to login page
				$data['email'] = "";
				$data['password'] = "";
				if ($eventId != NULL)
				{
					$data['eventId'] = $eventId;
					$event = $this->Event_model->getEvent($eventId);
					$data['event'] = $this->Event_model->getEvent($eventId);
					$data['sport'] = $event['sportId'];
					$this->template->write_view('nav_side','navside_event', $data, TRUE);
				}
				$this->template->write_view('content','team/TeamLogin',$data);
				
				$this->template->render();
				}
				else
				{
					if ($eventId != NULL)
					{
						redirect('team/teamRegister/register/' . $eventId, 'refresh');
					}
					else
					{
						redirect('team/welcome', 'refresh');
					}
				}
		}
		else
		{
			if ($eventId != NULL)
			{
				redirect('team/teamRegister/register/' . $eventId, 'refresh');
			}
			else
			{
				redirect('team/welcome', 'refresh');
			}
		}
	}

	function check_database($password)
	{
		$this->load->model('team/team_model');
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('email');

		//query the database
		$result = $this->team_model->login($username, $password);

		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				//$sess_array = array(
				//'nwaId' => $row->nwaId;
				//'email' => $row->email
				//'name' => $row->name
				//);
				$this->session->set_userdata('nwaId', $row->nwaId);
			}
			$this->session->set_userdata('login_state',true);
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
}
