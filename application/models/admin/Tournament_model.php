<?php
class Tournament_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($row)
	{
		$this->db->insert('tournaments', $row);
		return $this->db->insert_id();
	}
	
	public function getId($id)
	{
		
	}
	
	public function getAll($id)
	{
		
	}
	
	public function udate()
	{
		
	}
	
	public function delete()
	{
		
	}
}