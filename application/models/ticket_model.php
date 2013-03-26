<?php
class ticket_model extends CI_Model
{
	function getallbyE_id($E_id)
	{
		$this->db->select('tournaments.name, tickets.ticketType, tickets.noTickets, tickets.ticketId,tickets.price');
		$this->db->join('tournaments', 'tournaments.tournamentId = tickets.tournamentId');		
		$this->db->where('tournaments.tournamentId', $E_id);
		$query = $this-> db-> get("tickets");
		return $query->result_array();
	}
	
	function create($row)
	{
		$this->db->insert('tickets', $row);
		return $this->db->insert_id();
	}
	
	function checkTotalTicket($id)
	{
		$this->db->select('noTickets');
		$this->db->where('tournamentId', $id);
		$query = $this->db->get('tickets');
		return $query->result_array();
	}
	
	function countTournamentTicket($id)
	{
		$this->db->where('tournamentId', $id);
		$query = $this->db->get('tickets');
		return $this->db->count_all_results();
	}
	
	public function getPagination($per_page, $offset,$id)
	{
		if ($offset == 1)
		{
			$offset = 0;
		}
		$this->db->limit($per_page, $offset);
		$this->db->where('tournamentId', $id);
		$query = $this->db->get("tickets");
		return $query->result_array();
	}
	
	public function getTicketById($id)
	{
		$this->db->where('ticketId', $id);
		$query = $this->db->get("tickets");
		return $query->result_array();
	}
	
	
	public function getTicketTypeById($id)
	{
		$this->db->select('ticketType');
		$this->db->distinct('ticketType');
		$this->db->where('tournamentId', $id);
		$query = $this->db->get("tickets");
		return $query->result_array();
	}
	
	public function getEventDatebyTicketId($id)
	{
		$this->db->select('matchDetails.date');
		$this->db->where('tickets.ticketId', $id);
		$this->db->join('events', 'events.tournamentId = tickets.tournamentId');
		$this->db->join('matchDetails', 'events.eventId = matchDetails.eventId');
		$query = $this->db->get("tickets");
		return $query->result_array();
	}
}
