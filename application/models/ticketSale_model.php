<?php
class ticketSale_model extends CI_Model
{
	function create($row)
	{
		$this->db->insert('ticketsales', $row);
		return $this->db->insert_id();
	}
	
	function findSale($id)
	{
		$this->db->select('*');
		$this->db->join('tickets','ticketsales.ticketId = tickets.ticketId');		
		$this->db->where('tickets.tournamentId', $id);
		$query = $this-> db-> get("ticketsales");
		return $query->result_array();
	}
}

