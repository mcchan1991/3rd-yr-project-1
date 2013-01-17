<?php
/**
 * Model for tournament administration
 *
 * Created: 01/11/2012
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
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
	 * Convenience function for getting a count of all future tournaments.
	 *
	 * @return 			count of all future tournaments
	 */
	public function tournamentCountFuture()
	{
		$date = new DateTime();
		return $this->tournamentCount($date->format("Y-m-d"));
	}
	
	/**
	 * Convenience function for getting a count of all past tournaments.
	 *
	 * @return 			count of all past tournaments
	 */
	public function tournamentCountPast()
	{
		$date = new DateTime();
		return $this->tournamentCount($date->format("Y-m-d"), true);
	}
	/**
	 * Dunction for getting the count of tournaments (past and/or future not all)
	 * If date is NOT set it will get count of all tournaments
	 * If date is set and past is false (or not set) it will get all tournaments after the set date
	 * if past is set to true it will find all tournaments before the specified date
	 *
	 * @param date		The date to filter by
	 * @param past		If true filter by tournaments before the set date
	 * @return 			A count of tournaments
	 */
	private function tournamentCount($date = false, $past = false)
	{
		if ($date != false)
		{
			if ($past == false)
			{
				$logic_operator = ">=";
			}
			else
			{
				$logic_operator = "<";
			}
			$this->db->where("end {$logic_operator}", $date);
		}
		return $this->db->count_all_results("tournaments");
	}

	/**
	 * Convenience function for getting a tournament with a specific ID.
	 *
	 * @param id		id of the tournament
	 * @return 			the fetched tournament
	 */
	public function getTournamentId($id)
	{
		return $this->getTournament($id, $limit = false, $start = false);
	}
	
	/**
	 * Convenience function for getting a list of tournaments (past and future) with pagination
	 *
	 * @param limit		how many records should be fetched
	 * @param start		page off-set.
	 * @return 			A list of future tournaments
	 */
	
	public function getTournamentListLimit($limit, $start)
	{
		return $this->getTournament(false, $limit, $start);
	}
	
	/**
	 * Convenience function for getting a list of future tournaments with pagination
	 *
	 * @param limit		how many records should be fetched
	 * @param start		page off-set.
	 * @return 			A list of future tournaments
	 */
	public function getFutureTournaments($limit, $start)
	{
		$date = new DateTime();
		return $this->getTournament(false, $limit, $start, $date->format("Y-m-d"));
	}
	
	/**
	 * Convenience function for getting a list of all past tournaments with pagination
	 *
	 * @param limit		how many records should be fetched
	 * @param start		page off-set.
	 * @return 			A list of finished tournaments
	 */
	public function getPastTournament($limit, $start)
	{
		$date = new DateTime();
		return $this->getTournament(false, $limit, $start, $date->format("Y-m-d"), true);
	}
	
	/**
  	 * Gets either a specific tournament or all of them depending on whether the $id param have been set.
	 * Limits can be set for pageination support, date can be set as filter.
	 *
	 * @param id	The id to be fetched
	 * @param limit	items per page
	 * @param start	page number
	 * @param date	gets only tournaments that ends before or after this date (depending on the next input)
	 * @param past	if date is set, get tournaments which end date if BEFORE today (old tournaments)
     */
	private function getTournament($id = false, $limit = false, $start = false, $date = false, $past = false)
	{
		if ($id === FALSE)
		{
			if ($date != false)
			{
				if ($past == false)
				{
					$logic_operator = ">=";
				}
				else
				{
					$logic_operator = "<";
				}
				$this->db->where("end {$logic_operator}", $date);
			}
			
			if ($limit != false && $start != false)
			{
				if ($start == 1)
				{
					$start = 0;
				}
				$this->db->limit($limit, $start);
			}
			$query = $this->db->get('tournaments');
			return $query->result_array();
		}

		$query = $this->db->get_where('tournaments', array('tournamentId' => $id));
		return $query->row_array();
	}
	/**
	 * Get a list of tournament that have events assosiated with them. 
	 * These can either be future or past tournaments (use convience function)
	 * @param per_page		number of items to show per page (pagination)
	 * @param offset		the current page number
	 * @param date			which date to use for filtering
	 * @param past			should be set to true if getting past tournaments
	 * @return 				A list of tournament with events 
	 */ 
	private function getTournamentsWithEvents($per_page, $offset, $date = false, $past = false)
	{
		/**
		 * SELECT tournaments.*, COUNT(events.eventId)
		 * FROM tournaments, 
		 * events WHERE tournaments.tournamentId = events.tournamentId AND tournaments.tournamentId = 2
		 *GROUP BY tournaments.tournamentId
		*/
		
		if ($offset == 1)
		{
			$offset = 0;
		}
		
		if ($date != false)
		{
			if ($past == false)
			{
				$logic_operator = ">=";
			}
			else
			{
				$logic_operator = "<";
			}
			$this->db->where("tournaments.end {$logic_operator}", $date);
		}
		
		$this->db->select('tournaments.*, COUNT(events.eventId)');
		$this->db->limit($per_page, $offset);
		$this->db->where("tournaments.tournamentId = events.tournamentId");
		$this->db->group_by("tournaments.tournamentId"); 
		$query = $this->db->get('tournaments, events');
		
		return $query->result_array();
	}
	
	/**
	 * Convience fucntion for get all future tournaments that have any number of events assosiated to it
	 * 
	 * @param per_page		number of items to show per page (pagination)
	 * @param offset		the current page number
	 * @return 				A list of tournament with events 
	 */
	public function getFutureTournamentsWithEvents($per_page, $offset)
	{
		$date = new DateTime();
		return $this->getTournamentsWithEvents($per_page, $offset, $date->format("Y-m-d"));
	}
	
	/**
	 * Convience fucntion for get all past tournaments that have any number of events assosiated to it
	 * 
	 * @param per_page		number of items to show per page (pagination)
	 * @param offset		the current page number
	 * @return 				A list of tournament with events 
	 */
	public function getPastTournamentsWithEvents($per_page, $offset)
	{
		$date = new DateTime();
		return $this->getTournamentsWithEvents($per_page, $offset, $date->format("Y-m-d"), true);
	}
	
	/**
	 * Get the count of tournament with events (optional future or past, otherwise all)
	 * 
	 * @param date			The date to use for filtering, count all if not set
	 * @param past 			Will count past tournaments if set to true
	 * @return 				A count of tournament with events.
	 */
	private function countAllTournamentsWithEvents($date = false, $past = false)
	{
		$this->db->select('tournaments.*, COUNT(events.eventId)');
		$this->db->where("tournaments.tournamentId = events.tournamentId");
		$this->db->group_by("tournaments.tournamentId"); 
		if ($date != false)
		{
			if ($past == false)
			{
				$logic_operator = ">=";
			}
			else
			{
				$logic_operator = "<";
			}
			$this->db->where("tournaments.end {$logic_operator}", $date);
		}
		
		$query = $this->db->get('tournaments, events');
		
		return $this->db->count_all_results();
	}
	
	/**
	 *	Convience function for getting a list of all future tournaments that have one or more events assosiated.
	 *
	 * @return 				A count of future tournament with events.
	 */
	public function countAllFutureTournamentsWithEvents()
	{
		$date = new DateTime();
		return $this->countAllTournamentsWithEvents($date->format("Y-m-d"));
	}
	
	/**
	 *	Convience function for getting a list of all past tournaments that have one or more events assosiated.
	 *
	 * @return 				A count of past tournament with events.
	 */
	public function countAllPastTournamentsWithEvents()
	{
		$date = new DateTime();
		return $this->countAllTournamentsWithEvents($date->format("Y-m-d"), true);
	}
	
	/**
	 * 	Get count of how many teams/atheletes have registered
	 *  for a specific tournament
	 * 
	 * @param id	Id of the event
	 * @return		the count of event registrations
	 */ 
	public function getTournamentRegistrationsCount($id)
	{
		/**
		 * SELECT eventRegs.* FROM eventRegs, tournaments, events 
		 * WHERE tournaments.tournamentId = events.tournamentId AND 
		 * events.eventId = eventRegs.eventId 
		 * AND tournaments.tournamentId = 5
		*/
		$this->db->select('COUNT(eventRegs.eventId)');
		$this->db->from("eventRegs, tournaments, events");
		$this->db->where('tournaments.tournamentId = events.tournamentId AND 
		 				  events.eventId = eventRegs.eventId AND tournaments.tournamentId=' . $id);
		/*$this->db->where("tournaments.tournamentId", "events.tournamentId");
		$this->db->where("events.eventId", "eventRegs.eventId");
		$this->db->where("tournaments.tournamentId={$id}");*/
		$query = $this->db->get();
		
		$result = $query->row_array();
		return $result['COUNT(eventRegs.eventId)'];
	}
 	
	/**
  	 * Updates a given tournament
	 *
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