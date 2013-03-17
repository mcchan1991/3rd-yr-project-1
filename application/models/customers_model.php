<?php
class customers_model extends CI_Model
{
	function create($row)
	{
		$this->db->insert('customers', $row);
		return $this->db->insert_id();
	}
}
