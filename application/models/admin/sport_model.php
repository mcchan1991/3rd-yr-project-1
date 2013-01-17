<?php
/**
 * Model for sport type administration
 *
 * Created: 11/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class Sport_model extends CI_Model {
	
	private $table_name = "sports";
	
	/**
	 * Contructor of the model, makes sure that the database is loaded into the instance.
	 */
	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * Gets all sports
	 * @return		A list of all sports
	 */
	public function getAll()
	{
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	/**
	  * Gets a name of a specific sport ID.
	  * @param	id		The if of the sport
	  * @return			The name of the sport with the given id
	  */
	public function getSportName($id)
	{
		$query = $this->db->get_where('tournaments', array('sportId' => $id));
		$array = $query->result_array();
		return $array['sportName'];
	}
}

/* End of file Sport_model.php */
/* Location: ./application/models/admin/Sport_model.php */