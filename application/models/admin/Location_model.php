<?php
/**
 * Model for Location administration
 *
 * Created: 10/01/2013
 * @author	Jonathan Val <jdv2@hw.ac.uk>
 */
class Location_Model extends CI_Model
{
	private $table_name = "locations";
	
	public function __construct()
	{
		$this->load->database();
	}
	
	/**
  	 * Creates a new location
  	 * 
	 * @param row	the row with the information to insert in the database
	 * @return 		The id the of location that have been created
     */
	public function create($row)
	{
		$this->db->insert($this->table_name, $row);
		return $this->db->insert_id();
	}
	
	/**
	 * count all the location
	 * 
	 * @return total number of location
     */
	public function countLocations()
	{
		return $this->db->count_all_results($this->table_name);
	}
	
	/**
  	 * Creates a new location
  	 * 
	 * @param row	the row with the information to insert in the database
     */
	public function createSportAtLocation($row)
	{
		$this->db->insert('sportatlocations', $row);
	}
	
	
	/**
	 * Get all the location
	 * 
	 * @return total number of location
     */
	public function getAll()
	{
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	/**
	 * Get a list of location with pagination
	 *
     * @param per_page	number of items per page
     * @param offset	the current page number / offse
	 * @return			A list of location given the above restraints.
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
  	 * Gets a specific location
  	 * 
	 * @param  id	The id of the specific location
	 * @return 		row with the specific location information
     */
	public function getLocation($id)
	{
		$query = $this->db->get_where($this->table_name, array('locationId' => $id));
		return $query->row_array();
	}
	
	/**
  	 * Updates a given umpire
	 *
	 * @param row	the row to be updated
     */
	public function update($row)
	{
		$this->db->where('locationId', $row['locationId']);
		return $this->db->update($this->table_name, $row);
	}

}
