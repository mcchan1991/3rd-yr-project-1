<?php
/**
 * Model for Umpire administration
 *
 * Created: 10/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Umpire_model extends CI_Model
{
	private $table_name = "umpires";
	
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
		$this->db->insert($this->table_name, $row);
		return $this->db->insert_id();
	}
	
	/**
	 * count all the umpires
	 * 
	 * @return total number of umpires
     */
	public function countUmpires()
	{
		return $this->db->count_all_results($this->table_name);
	}
	
	/**
	 * Get all the umpires
	 * 
	 * @return total number of umpires
     */
	public function getAll()
	{
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	/**
	 * Get a list of umpires with pagination
	 *
     * @param per_page	number of items per page
     * @param offset	the current page number / offse
	 * @return			A list of umpires given the above restraints.
	 */
	public function getPagination($per_page, $offset)
	{
		if ($offset == 1)
		{
			$offset = 0;
		}
		$this->db->limit($per_page, $offset);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	/**
  	 * Gets a specific umpire
  	 * 
	 * @param  id	The id of the specific umpire
	 * @return 		row with the specific umpires information
     */
	public function getUmpire($id)
	{
		$query = $this->db->get_where($this->table_name, array('umpireId' => $id));
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
		return $this->db->update($this->table_name, $row);
	}
	
	/**
  	 * Checks whether an email is already in use by an registered umpire.
	 *
	 * @param email		the email to check for
	 * @return			true if email is not used, false otherwise
     */
	public function checkUniqueEmail($email)
	{
		$query = $this->db->get_where($this->table_name, array('email' => $email));
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
}
