<?php
class Tournament_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($row)
	{
		$this->db->insert('tournaments', $row);
		return $this->db->insert_id();
	}
	
	public function getTournament($id = false)
	{
		if ($id === FALSE)
		{
			$query = $this->db->get('tournaments');
			return $query->result_array();
		}

		$query = $this->db->get_where('tournaments', array('tournamentId' => $id));
		return $query->row_array();
	}
	
	public function update($row)
	{
		$this->db->where('tournamentId', $row['tournamentId']);
		return $this->db->update('tournaments', $row);
	}
	
	public function delete()
	{
		
	}
}