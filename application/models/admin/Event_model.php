<?php
class Event_model extends CI_Model
{
	private $table_name = "events";

	public function __construct()
	{
		$this->load->database();
	}
	
	/**
  	 * Creates a new event
  	 * 
	 * @param row	the row with the information to insert in the database
	 * @return 		The id the of staff that have been created
     */
	public function create($row)
	{
		$this->db->insert($this->table_name, $row);
		return $this->db->insert_id();
	}
	
	/**
	 * count all the events by tournament id
	 * 
	 * @param id	the of the tournament
	 * @return total number of events for a tournament
     */
	public function countEventsByTournamentId($id)
	{
		$this->db->where('tournamentId', $id);
		return $this->db->count_all_results($this->table_name);
	}
	
	/**
	 * Get a list of events with pagination
	 *
	 * @param id		the id of the tournament
     * @param per_page	number of items per page
     * @param offset	the current page number / offse
	 * @return			A list of staff given the above restraints.
	 */
	public function getPaginationByTournamentId($id,$per_page, $offset)
	{
		if ($offset == 1)
		{
			$offset = 0;
		}
		$this->db->limit($per_page, $offset);
		$this->db->where('tournamentId', $id);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	/**
  	 * Gets a specific event
  	 * 
	 * @param  id	The id of the specific event
	 * @return 		row with the specific event information
     */
	public function getEvent($id)
	{
		$query = $this->db->get_where($this->table_name, array('eventId' => $id));
		return $query->row_array();
	}
	
	/**
  	 * Updates a given event
	 *
	 * @param row	the row to be updated
     */
	public function update($row)
	{
		$this->db->where('eventId', $row['eventId']);
		return $this->db->update($this->table_name, $row);
	}
	
}