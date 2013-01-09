<?php
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
	
	public function tournamentCountFuture()
	{
		$date = new DateTime();
		return $this->tournamentCount($date->format("Y-m-d"));
	}
	
	public function tournamentCountPast()
	{
		$date = new DateTime();
		return $this->tournamentCount($date->format("Y-m-d"), true);
	}
	
	public function tournamentCount($date = false, $past = false)
	{
		if ($date != false)
		{
			if ($past == false)
			{
				$logic_operator = ">";
			}
			else
			{
				$logic_operator = "<";
			}
			$this->db->where("end {$logic_operator}", $date);
		}
		return $this->db->count_all_results("tournaments");
	}

	public function getTournamentId($id)
	{
		return $this->getTournament($id, $limit = false, $start = false);
	}
	
	public function getTournamentListLimit($limit, $start)
	{
		return $this->getTournament(false, $limit, $start);
	}
	
	public function getFutureTournaments($limit, $start)
	{
		$date = new DateTime();
		return $this->getTournament(false, $limit, $start, $date->format("Y-m-d"));
	}
	
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
					$logic_operator = ">";
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
  	 * Updates a given tournament.
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