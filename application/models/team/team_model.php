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
		
	
	
	//change contact name or add or email or password etc
	public function update($id,$data1)
	{
		$this->db->from('teams');
		$this->db->where('nwaId', $id);
		$this->db->update('teams', $data1);
	}
	
	public function create($data)
	{
		$this->db->insert('teams', $data);
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

	public function checkUniqueEmail($email)
	{
		$query = $this->db->get_where('teams', array('email' => $email));
		$result = $query->result_array();
		if (count($result) == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function checkUniqueNWAID($nwaId)
	{
		$query = $this->db->get_where('teams', array('nwaId' => $nwaId));
		$result = $query->result_array();
		if (count($result) == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function checkUniqueTeamName($name)
	{
		$query = $this->db->get_where('teams', array('name' => $name));
		$result = $query->result_array();
		if (count($result) == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function UpdateCheckUniqueTeamName($name,$currentID)
	{
		$this->db->select('*');
		$this->db->where('name', $name);
		$this->db->where('nwaId != ', $currentID);
		$query = $this->db->get("teams");
		$result = $query->result_array();
		if (count($result) == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function UpdateCheckUniqueEmail($email,$currentID)
	{
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->where('nwaId != ', $currentID);
		$query = $this->db->get("teams");
		$result = $query->result_array();
		if (count($result) == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getEventReg($id)
	{
		$this->db->select('teams.nwaId ,teams.name');
		$this->db->from('teams');
		$this->db->where('teams.nwaId', $id);
		$query = $this-> db-> get();
		return $query->row_array();
	}
	
	public function getTeamName($id)
	{
		$this->db->select('teams.name');
		$this->db->from('teams');
		$this->db->where('teams.nwaId', $id);
		$query = $this->db->get();
		$row = $query->row_array();
		return $row['name'];
	}
	
}
