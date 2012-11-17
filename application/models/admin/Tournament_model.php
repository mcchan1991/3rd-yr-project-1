<?php
class Tournament_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	/**
  	 * Creates a new tournament in the database
	 * @param row	the row to be inserted
     */
	public function create($row)
	{
		$this->db->insert('tournaments', $row);
		return $this->db->insert_id();
	}
	
	/**
  	 * Gets either a specific tournament or all of them depending on whether the $id param have been set.
	 * @param id	the row to be inserted
     */
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
	
	/**
  	 * Updates a given tournament.
	 * @param row	the row to be updated
     */
	public function update($row)
	{
		$this->db->where('tournamentId', $row['tournamentId']);
		return $this->db->update('tournaments', $row);
	}
	
	public function delete()
	{
		
	}
}