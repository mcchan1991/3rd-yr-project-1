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
	
	/**
  	 * Updates a given match
	 *
	 * @param row	the row to be updated
     */
	public function update($row)
	{
		$this->db->where('matchId', $row['matchId']);
		return $this->db->update($this->table_name, $row);
	}
	
	/**
	 * Get a list of location with pagination
	 *
     * @param per_page	number of items per page
     * @param offset	the current page number / offse
	 * @return			A list of location given the above restraints.
	 */
	public function getPaginationEvent($event_id,$per_page, $offset)
	{
		if ($offset == 1)
		{
			$offset = 0;
		}
		//$this->db->limit($per_page, $offset);
		//$this->db->order_by("date", "asc"); 
		//$this->db->order_by("time", "asc"); 
		//$this->db->join('teams', 'comments.id = blogs.id');
		$query = $this->db->query("SELECT matchDetails.* , team1.name as team1Name, team2.name as team2Name, locations.name as locationName, CONCAT(umpires.firstName ,' ', umpires.surname) as umpireName
			FROM matchDetails
			INNER JOIN (teams AS team1) JOIN (teams AS team2) ON matchDetails.team1Id = team1.nwaID AND matchDetails.team2Id = team2.nwaId
			INNER JOIN locations on matchDetails.locationId = locations.locationId
			INNER JOIN umpires on matchDetails.umpireId = umpires.umpireId
			ORDER BY `date`,`time` ASC LIMIT " . $offset . "," . $per_page);
		return $query->result_array();
	}
	
	public function countEventMatches($event_id)
	{
		$this->db->where('eventId',$event_id);
		return $this->db->count_all_results($this->table_name);
	}
	
	public function deleteMatchesForEvent($eventId) 
	{
		$this->db->delete($this->table_name, array('eventId' => $eventId)); 
	}
	
}

// END