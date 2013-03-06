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
	 * Gets a list of umpires registered for a given tournament
	 * @param id	the id of the tournament 
	 * @return		a list of all umpires registered for a tournament
	 */
	public function getUmpireAtTournament($id, $per_page = false, $offset = false)
	{
		$this->db->select('umpires.*, umpireAvailability.date, umpireAvailability.date, umpireAvailability.availableFrom, umpireAvailability.availableTo');
		$this->db->from('umpires, umpireAvailability, tournaments');
		$this->db->where("umpires.umpireId = umpireAvailability.umpireId AND 
		tournaments.tournamentId = umpireAvailability.tournamentId AND tournaments.tournamentId = {$id}");
		
		if ($per_page != false && $offset != false)
		{
			if ($offset == 1)
			{
				$offset = 0;
			}
			$this->db->limit($per_page, $offset);
		}
		
		$this->db->order_by("date", "asc"); 
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function countUmpireAtTournament($id)
	{
		$this->db->select('umpires.*, umpireAvailability.date, umpireAvailability.date, umpireAvailability.availableFrom, umpireAvailability.availableTo');
		$this->db->from('umpires, umpireAvailability, tournaments');
		$this->db->where("umpires.umpireId = umpireAvailability.umpireId AND 
		tournaments.tournamentId = umpireAvailability.tournamentId AND tournaments.tournamentId = {$id}");
		
		return $this->db->count_all_results();
	}
	
	public function createUmpireAvailability($row)
	{
		$this->db->insert("umpireAvailability", $row);
		return true;
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
	
	public function getUmpiresForEvent($id) 
	{
		$this->load->model('admin/Event_model');
		$event = $this->Event_model->getEvent($id);
		/*SELECT umpireAvailability.* FROM umpireAvailability, umpires
		WHERE umpireAvailability.date >= "2013-05-22" AND umpireAvailability.date <= "2013-05-24" 
		AND umpireAvailability.tournamentId = 5 AND umpireAvailability.umpireId = umpires.umpireId 
		AND umpires.sport = 1 group by umpireAvailability.date ASC*/
		$this->db->select("umpireAvailability.*");
		$this->db->from("umpireAvailability, umpires");
		$this->db->where("umpireAvailability.date >= \"{$event['start']}\" AND umpireAvailability.date <= \"{$event['end']}\"
		AND umpireAvailability.tournamentId = {$event['tournamentId']} AND umpireAvailability.umpireId = umpires.umpireId 
		AND umpires.sport = {$event['sportId']} group by umpireAvailability.date ASC");
		$query = $this->db->get();
		$result = $query->result_array();
		$newArray = array();
		foreach($result as $current) 
		{
			$key = $current['date'];
			if (empty($newArray['key']))
			{
				$newArray[$key] = array();
			}
			array_push($newArray[$key], $current);
		}
		return $newArray;
	}
	
	public function getFreeUmpireForEvent($id, $date, $time, $duration)
	{
		$this->load->model('admin/Event_model');
		$event = $this->Event_model->getEvent($id);
		if ($event['sportId'] == 1)
		{
			// actual statement needed:
		
			/*
			SELECT umpireAvailability . * , umpireCount.count
			FROM umpireAvailability
			LEFT JOIN umpireCount ON umpireCount.umpireId = umpireAvailability.umpireId AND umpireAvailability.tournamentId = umpireCount.tournamentId
			WHERE umpireAvailability.date = "2013-05-22" AND umpireAvailability.tournamentId = 5 GROUP BY umpireAvailability.umpireId
			ORDER BY umpireCount.count ASC
			*/

			$query = $this->db->query("SELECT umpireAvailability.* , umpireCount.count 
										FROM umpireAvailability 
										LEFT JOIN umpireCount ON umpireCount.umpireId = umpireAvailability.umpireId 
										AND umpireAvailability.tournamentId = umpireCount.tournamentId 
										WHERE umpireAvailability.date =  \"{$date}\" 
										AND umpireAvailability.tournamentId = 5 
										GROUP BY umpireAvailability.umpireId 
										ORDER BY umpireCount.count ASC");
			$result = $query->result_array();
			foreach($result as $current) 
			{
				// first lets check if time is OK
				$dateFormat = "H:i:s";
				$from = DateTime::createFromFormat($dateFormat, $current['availableFrom']);
				$to = DateTime::createFromFormat($dateFormat, $current['availableTo']);
				
				$currentTime = DateTime::createFromFormat($dateFormat, $time);
				
				if ($from < $currentTime && $currentTime < $to->add($duration)) 
				{
					// make sure umpire is not busy at that time
					$this->db->select("time");
					$this->db->from("matchDetails");
					$this->db->where("date = \"{$date}\" AND umpireId = {$current['umpireId']}");
					$query = $this->db->get();
					$result = $query->result_array();
					if (count($result) == 0)
					{
						return $current['umpireId'];
					}
					else
					{
						$ok = true;
						foreach($result as $match) 
						{
							$prevTime = DateTime::createFromFormat($dateFormat, $match['time']);
							
							$diff = $prevTime->diff($currentTime);
							$minutesDifference = ($diff->format("%H")*60) + $diff->format("%M");
							// umpires require at least a 60min break
							$durationMin = ($duration->format("%H")*60) + $duration->format("%M")+60;
							if ($minutesDifference <= $durationMin)
							{
								$ok = false;
							}
						}
						if ($ok == true)
						{
							return $current['umpireId'];
						}

					}
				}
				
			}
		}
		// return false if we haven't found anything
		return false;
	}
}
