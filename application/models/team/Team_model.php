<?php
class Team_model extends CI_Model {
	
	public function __construct()
	{
		$this->load->database();
		
	}
	function login($email, $password)
	{
		$this -> db -> select('*');
		$this -> db -> from('teams');
		$this -> db -> where('email = ' . "'" . $email . "'");
		$this -> db -> where('password = ' . "'" . sha1($password) . "'");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
		
	
	
	//change contact name or add or email or password
	public function update($id,$data1)
	{
		$this->db->from('teams');
		$this->db->where('nwaId', $id);
		$this->db->update('teams', $data1);
	}
	//count how many team may use in  team sechduling?
	public function create($data)
	{
		$this->db->insert('teams', $data);
	}
	
	public function teamLogout()
	{
		$this->session->sess_destroy();
		$this->load->view('team/TeamLogin');
	}
	
	public function getEventID()
	{
		$this->db->select('eventId');
		$query = $this->db->get("events");
		return $query->result_array();
	}
	
	public function createTeamReg($row)
	{
		$this->db->insert('eventRegs', $row);
		return $this->db->insert_id();
	}
	
	public function getEvent($id)
	{
		$this->db->select('regStart,regEnd');
		$query = $this->db->get_where('events', array('eventId' => $id));
		return $query->row_array();
	}

	public function getEventRegs($id)
	{
		$this->db->select('eventId');
		$this->db->where('eventId', $id);
		$query = $this->db->get("eventRegs");
		return $query->result_array();
	}

	
}
