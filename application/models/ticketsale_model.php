<?php
class ticketSale_model extends CI_Model
{
	function create($row)
	{
		$this->db->insert('ticketSales', $row);
		return $this->db->insert_id();
	}
	
	function findSale($id)
	{
		$this->db->select('*');
		$this->db->join('tickets','ticketSales.ticketId = tickets.ticketId');		
		$this->db->where('tickets.tournamentId', $id);
		$query = $this-> db-> get("ticketSales");
		return $query->result_array();
	}
	
	function findTicketTypeSale($id,$type)
	{
		$this->db->select('*');
		$this->db->join('ticketSales','ticketSales.ticketId = tickets.ticketId');		
		$this->db->where('tickets.tournamentId', $id);
		$this->db->where('tickets.ticketType', $type);
		$query = $this-> db-> get("tickets");
		return $query->result_array();
	}
	
}

