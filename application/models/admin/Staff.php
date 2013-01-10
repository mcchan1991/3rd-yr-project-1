<?php
class Staff extends CI_Model
{
	function login($username, $password)
	{
		$this -> db -> select('staffid, username, password,manager');
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
}