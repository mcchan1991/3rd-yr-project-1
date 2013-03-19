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
	
	public function createEventTimes($id, $times)
	{
		// to make it easy first clear any event times.
		$this->db->delete('eventTimes', array('eventId' => $id)); 
		
		$times = array_filter($times);	// get rid of empty inputs
		$postdata;
		for ($i = 0; $i<count($times); $i++)
		{
			$row = array(
					'eventId' => $id,	
					'start' => $times[$i] . ":00",	
				);
			$this->db->insert("eventTimes", $row);
		}
	}
	
	public function getEventTimes($id)
	{
		$this->db->where('eventId', $id);
		$this->db->select('start');

		$query = $this->db->get('eventTimes');
		return $query->result_array();
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
	
	/**
	 * 	Get count of how many teams/atheletes have registered
	 *  for a specific event.
	 * 
	 * @param id	Id of the event
	 * @return		the count of event registrations
	 */ 
	public function getEventRegistrationsCount($id)
	{
		$this->db->where('eventId', $id);
		return $this->db->count_all_results("eventRegs");
	}
	
	/**
	 * 	Get a list of event registrations.
	 * 
	 * @param id		Id of the event
	 * @param per_page	number of registrations to show per page.
	 * @param offset	current page
	 * @return			list of event registrations
	 */
	public function getEventRegistrations($id, $per_page, $offset)
	{
		$this->db->where('eventId', $id);
		if ($offset == 1)
		{
			$offset = 0;
		}
		$this->db->limit($per_page, $offset);
		$query = $this->db->get("eventRegs");
		return $query->result_array();

	}
	
	public function geStartEndTimes($tId)
	{
		$this->db->where('tournamentId', $tId);
		$this->db->select('start, end');

		$query = $this->db->get('events');
		return $query->result_array();
	}

	public function getTopScores($eventId)
	{
		$query = $this->db->query("SELECT matchResults.playerId, sum(goal) as goals, players.shirtNo, players.firstName, players.surName, teams.nwaId as nwaId, teams.name as teamName FROM matchResults, players, teams WHERE matchResults.matchId in
		(SELECT matchDetails.matchId FROM matchDetails WHERE matchDetails.eventId = {$eventId}) AND players.playerId = matchResults.playerId AND teams.nwaId = players.nwaId GROUP BY matchResults.playerId ORDER BY goals DESC LIMIT 8");
		return $query->result_array();
	}
	
	
	public function findMatchResults($eventId)
	{
		$query = $this->db->query("SELECT * FROM matchResultsView WHERE matchId IN (SELECT matchDetails.matchId FROM matchDetails WHERE matchDetails.eventId = {$eventId})");
		return $query->result_array();
	}
	
	public function getMostAssists($eventId)
	{
		$sql = "SELECT matchResults.assist as playerId, count( assist ) AS assists, players.shirtNo, players.firstName, players.surName, teams.nwaId AS nwaId, teams.name AS teamName";
		$sql .= " FROM matchResults, players, teams";
		$sql .= " WHERE matchResults.matchId";
		$sql .= " IN (SELECT matchDetails.matchId FROM matchDetails WHERE matchDetails.eventId = {$eventId})";
		$sql .= " AND players.playerId = matchResults.assist AND teams.nwaId = players.nwaId";
		$sql .= " GROUP BY matchResults.assist ORDER BY assists DESC LIMIT 8";
		
		$query = $this->db->query("$sql");
		return $query->result_array();
	}
	
	public function getMostRedCards($eventId)
	{
		$sql = "SELECT matchResults.playerId as playerId, count( redCard ) AS redCards, players.shirtNo, players.firstName, players.surName, teams.nwaId AS nwaId, teams.name AS teamName";
		$sql .= " FROM matchResults, players, teams";
		$sql .= " WHERE matchResults.matchId";
		$sql .= " IN (SELECT matchDetails.matchId FROM matchDetails WHERE matchDetails.eventId = {$eventId})";
		$sql .= " AND players.playerId = matchResults.playerId AND teams.nwaId = players.nwaId";
		$sql .= " GROUP BY matchResults.assist ORDER BY redCards DESC LIMIT 8";
		
		$query = $this->db->query("$sql");
		return $query->result_array();
	}
	
	public function getMostYellowCards($eventId)
	{
		$sql = "SELECT matchResults.playerId as playerId, count( yellowCard ) AS yellowCards, players.shirtNo, players.firstName, players.surName, teams.nwaId AS nwaId, teams.name AS teamName";
		$sql .= " FROM matchResults, players, teams";
		$sql .= " WHERE matchResults.matchId";
		$sql .= " IN (SELECT matchDetails.matchId FROM matchDetails WHERE matchDetails.eventId = {$eventId})";
		$sql .= " AND players.playerId = matchResults.playerId AND teams.nwaId = players.nwaId";
		$sql .= " GROUP BY matchResults.assist ORDER BY yellowCards DESC LIMIT 8";
		
		$query = $this->db->query("$sql");
		return $query->result_array();
	}
	
}
