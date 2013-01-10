<?php
/**
 * Model for Umpire administration
 *
 * Created: 01/11/2013
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
	
 
	public function update($row)
	{
		$this->db->where('tournamentId', $row['tournamentId']);
		return $this->db->update('tournaments', $row);
	}
	
	public function delete()
	{
		
	}
}