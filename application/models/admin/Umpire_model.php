<?php
/**
 * Model for Umpire administration
 *
 * Created: 10/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Umpire_model extends CI_Model
{
	$table_name = "umpires";
	
	public function __construct()
	{
		$this->load->database();
	}
	
	/**
  	 * Creates a new umpire
  	 * 
	 * @param row	the row with the information to insert in the database
	 * @return 		The id the of umpire that have been created
     */
	public function create($row)
	{
		$this->db->insert($table_name, $row);
		return $this->db->insert_id();
	}
	
	/**
	 * count all the umpires
	 * 
	 * @return total number of umpires
     */
	public function countUmpires()
	{
		return $this->db->count_all_results($table_name);
	}
	
	/**
  	 * Gets a specific umpire
  	 * 
	 * @param  id	The id of the specific umpire
	 * @return 		row with the specific umpires information
     */
	public function getUmpire($id)
	{
		$query = $this->db->get_where($table_name, array('umpireId' => $id));
		return $query->row_array();
	}
	
	/**
  	 * Updates a given umpire
	 *
	 * @param row	the row to be updated
     */
	public function update($row)
	{
		$this->db->where('umpireId', $row['umpireId']);
		return $this->db->update($table_name, $row);
	}
}
