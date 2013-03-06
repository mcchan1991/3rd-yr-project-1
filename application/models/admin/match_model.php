<?php
class Match_model extends CI_Model
{
	private $table_name = "matchDetails";

	public function __construct()
	{
		$this->load->database();
	}
	
	/**
  	 * Creates a new match
  	 * 
	 * @param row	the row with the information to insert in the database
	 * @return 		The id the of staff that have been created
     */
	public function create($row)
	{
		$this->db->insert($this->table_name, $row);
		return $this->db->insert_id();
	}
	
}

// END