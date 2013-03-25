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
	
	public function createSportAtLocation($row)
	{
		$this->db->insert('sportAtLocations', $row);
	}
	
	public function clearSportsAtLocation($id)
	{
		$this->db->delete('sportAtLocations', array('locationId' => $id)); 
	}
	
	public function getLocationSports($id)
	{
		$this->db->select('sportId');
		$query = $this->db->get_where('sportAtLocations', array('locationId' => $id));
		return $query->result_array();
	}
	
	public function getLocationsForSport($sportId)
	{
		/*
		 * SELECT locations.* FROM locations, sportAtLocations 
		   WHERE sportAtLocations.locationId = locations.locationId 
		   AND sportAtLocations.sportId = 1 */
		$this->db->select("locations.*");
		$this->db->from("locations, sportAtLocations");
		$this->db->where("sportAtLocations.locationId = locations.locationId");
		$this->db->where("sportAtLocations.sportId = {$sportId}");
		$query = $this->db->get();
		return $query->result_array();
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
	
	
	public function getFreeLocation($sport, $date, $time, $duration)
	{
		$locationForSport = $this->getLocationsForSport($sport);


			// loop over the locations
			foreach($locationForSport as $location)
			{
				if ($sport == 1)
				{
				// find if any match use that location at that date
				$this->db->select("date, time");
				$this->db->from("matchDetails");
				$this->db->where("date", $date);
				$this->db->where("locationId", $location['locationId']);
				$query = $this->db->get();
				$result = $query->result_array();
				// if no matches at that location the given day it's free
				if (count($result) == 0)
				{
					return $location['locationId'];
				} 
				else
				{
					$ok = true;
					foreach($result as $match)
					{
						$dateFormat = "H:i:s";
						$timeObject = DateTime::createFromFormat($dateFormat, $time);
						$currentTime = DateTime::createFromFormat($dateFormat, $match['time']);
						// have to cast it to minutes as PHP doesn't have coparrision of interval objects.....
						$diff = $timeObject->diff($currentTime);
						$minutesDifference = ($diff->format("%H")*60) + $diff->format("%M");
						$durationMin = ($duration->format("%H")*60) + $duration->format("%M");
						//echo $minutesDifference . " duration min: " . $durationMin;
						if ($minutesDifference < $durationMin)
						{
							$ok = false;
						}						
					}
					if ($ok == true)
					{
						return $location['locationId'];
					}
					// free location not found that day - dont think it's needed should just return null
					/*if ($ok == false)
					{
						return false;
					}*/
				}
			}
			// do it later
			else if ($sport == 2)
			{

			}
		}
		// return false if we haven't found anything
		return false;

	}

}
