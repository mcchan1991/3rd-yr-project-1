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
  	 * Gets a specific match
  	 * 
	 * @param  id	The id of the specific event
	 * @return 		row with the specific event information
     */
	public function get($id)
	{
		$query = $this->db->get_where($this->table_name, array('matchId' => $id));
		return $query->row_array();
	}
	
	/**
	 * Get a list of location with pagination
	 *
     * @param per_page	number of items per page
     * @param offset	the current page number / offse
	 * @return			A list of location given the above restraints.
	 */
	public function getPaginationEvent($event_id,$per_page, $offset, $finished = 0)
	{
		if ($offset == 1)
		{
			$offset = 0;
		}
		$sql = "SELECT
		(select sum(goal) from matchResults
		INNER JOIN players on matchResults.playerId = players.playerId
		where players.nwaId = matchDetails.team1Id AND matchDetails.matchId = matchResults.matchId) as team1Goals
		,
		(select sum(goal) from matchResults
		INNER JOIN players on matchResults.playerId = players.playerId
		where players.nwaId = matchDetails.team2Id AND matchDetails.matchId = matchResults.matchId) as team2Goals
		,
		matchDetails.* , team1.name as team1Name, team2.name as team2Name, locations.name as locationName, CONCAT(umpires.firstName ,' ', umpires.surname) as umpireName
		FROM matchDetails
		INNER JOIN (teams AS team1) JOIN (teams AS team2) ON matchDetails.team1Id = team1.nwaID AND matchDetails.team2Id = team2.nwaId
		INNER JOIN locations on matchDetails.locationId = locations.locationId
		INNER JOIN umpires on matchDetails.umpireId = umpires.umpireId
		WHERE matchDetails.eventId = {$event_id}";
		if ($finished == 1)
		{
			$sql .= " AND matchDetails.status = \"finished\"";
		}
		$sql .= " ORDER BY `date`,`time` ASC LIMIT " . $offset . "," . $per_page;
		
		$query = $this->db->query($sql);
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
	
	public function addResult($data)
	{
		$this->db->insert("matchResults", $data);
		return $this->db->insert_id();
	}
	
	public function updateResult($data)
	{
		$this->db->where('resultId', $data['resultId']);
		return $this->db->update("matchResults", $data);
	}
	
	public function getResults($matchId)
	{
		$this->db->select('*');
		$this->db->where('matchId', $matchId);
		$query = $this->db->get("matchResults");
		return $query->result_array();
	}
	
	public function getExtendedResults($matchId)
	{
		$query = $this->db->query("SELECT matchResults.*,players.nwaId, players.shirtNo, players.surname FROM matchResults, players WHERE matchId = {$matchId} AND matchResults.playerId = players.playerId ORDER BY matchResults.minute ASC");
		return $query->result_array();
	}
	
	public function setMatchAsFinished($matchId)
	{
		$data = array(
			"status" => "finished"
		);
		$this->db->where('matchId', $matchId);
		$this->db->update($this->table_name, $data);
	}
	
	public function getFinalResult($matchId)
	{
		$this->db->select('*');
		$this->db->where('matchId', $matchId);
		$query = $this->db->get("matchResultsView");
		return $query->result_array();
	}
	
}

// END