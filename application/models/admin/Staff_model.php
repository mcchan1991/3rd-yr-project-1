<?php
class Staff_model extends CI_Model
{
	function login($username, $password)
	{
		$this -> db -> select('staffid, username, password,manager');
		$this -> db -> from('staff');
		$this -> db -> where('username = ' . "'" . $username . "'");
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
	
	function logout()
	{
		$this->session->sess_destroy();
	}
	
	function get_records()
	{
		$query = $this->db->get('staff');
		return $query->result();
	}
	
	function get_record($id)
	{
		$this->db->where('staffid', $id);
		$query = $this->db->get('staff');
		return $query->result();
	}
	
	function add_record($data) 
	{
		$this->db->insert('staff', $data);
		return;
	}
	
	function update_record($id,$data) 
	{
		$this->db->where('staffid', $id);
		$this->db->update('staff', $data);
	}
	
	function delete_row($id)
	{
		$this->db->where('staffid', $id);
		$this->db->delete('staff');
	}
	
	
}