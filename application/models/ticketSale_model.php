<?php
class ticketSale_model extends CI_Model
{
	function create($row)
	{
		$this->db->insert('ticketsales', $row);
		return $this->db->insert_id();
	}
}

