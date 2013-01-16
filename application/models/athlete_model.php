<?php
class Athlete_model extends CI_Model
{
	function login($username, $password)
	{
		$this -> db -> select('athleteid, email, password');
		$this -> db -> from('athletes');
		$this -> db -> where('email = ' . "'" . $username . "'");
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
	
	function get_records()
	{
		$query = $this->db->get('athletes');
		return $query->result();
	}
	
	function get_record($id)
	{
		$this->db->where('athleteid', $id);
		$query = $this->db->get('athletes');
		return $query->result_array();
	}
	
	function add_record($data) 
	{
		return $this->db->insert('athletes', $data);
	}
	
	function update_record($id,$data) 
	{
		$this->db->where('athleteid', $id);
		$this->db->update('athletes', $data);
	}
	
	function delete_row($id)
	{
		$this->db->where('athleteid', $id);
		$this->db->delete('athletes');
	}
	
	function registerAthleteForEvent($eventId, $athleteId)
	{
		$data = array(
			'eventId' => $eventId,
			'athleteId' => $athleteId
		);
		return $this->db->insert('eventRegs', $data);
	}
	
	
}