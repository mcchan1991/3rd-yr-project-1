<?php
class Team_model extends CI_Model {
	
	public function __construct()
	{
		$this->load->database();
		
	}
	public function teamlogin_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		
		if($this->form_validation->run())
		{
			$this->db->where('email', $this->input->post('email'));
			$this->db->where('password', sha1($this->input->post('password')));
			$query =$this->db->get('test2');
			
			if($query->num_rows() ==1)
			{
				$this->load->view('team/Logout');
				
			}
			else
			{
				//echo "please enter correct details";
				$this->load->view('team/TeamLogin');
			}
		}
		else
		{
			//echo "please enter all correct the detail";
			$this->load->view('team/TeamLogin');
		}
		
	}
	
	//change contact name or add or email or password
	public function update()
	{
		
	}
	//count how many team may use in  team sechduling?
	public function count()
	{
		
	}

	
}
