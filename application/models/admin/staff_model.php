<?php
class Staff_model extends CI_Model
{
	private $table_name = "staff";

	public function __construct()
	{
		$this->load->database();
	}
	
	/**
  	 * Creates a new staff
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
  	 * Logs in staff
  	 * 
	 * @param username		The username of the staff to login
	 * @param password		The password of the staff ot login
	 * @return 				row containing staffId,username,password and maanger
     */
	
	function login($username, $password)
	{
		$this -> db -> select('staffId, username, password,manager');
		$this -> db -> from('staff');
		$this -> db -> where('username = ' . "'" . $username . "'");
		$this -> db -> where('password = ' . "'" . sha1($password) . "'");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	/**
  	 * Logs out staff
	 * Should perhaps be in controller
     */
	
	function logout()
	{
		$this->session->sess_destroy();
	}
	
	/**
	 * count all the staff
	 * 
	 * @return total number of staff
     */
	public function countStaff()
	{
		return $this->db->count_all_results($this->table_name);
	}
	
	/**
	 * Get all the staff
	 * 
	 * @return total number of staff
     */
	public function getAll()
	{
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	/**
	 * Get a list of staff with pagination
	 *
     * @param per_page	number of items per page
     * @param offset	the current page number / offse
	 * @return			A list of staff given the above restraints.
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
  	 * Gets a specific staff
  	 * 
	 * @param  id	The id of the specific staff
	 * @return 		row with the specific staff information
     */
	public function getStaff($id)
	{
		$query = $this->db->get_where($this->table_name, array('staffId' => $id));
		return $query->row_array();
	}
	
	/**
  	 * Updates a given staff
	 *
	 * @param row	the row to be updated
     */
	public function update($row)
	{
		$this->db->where('staffId', $row['staffId']);
		return $this->db->update($this->table_name, $row);
	}
	
	/**
  	 * Checks whether an email is already in use by an registered staff.
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
	/**
  	 * Checks whether a username is already in use by an registered staff.
	 *
	 * @param email		the email to check for
	 * @return			true if email is not used, false otherwise
     */
	public function checkUniqueUser($username)
	{
		$query = $this->db->get_where($this->table_name, array('username' => $username));
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
	
}