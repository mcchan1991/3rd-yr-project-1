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
	public function count()
	{
		
	}
	
	public function teamLogout()
	{
		$this->session->sess_destroy();
		$this->load->view('team/TeamLogin');
	}

	
}
