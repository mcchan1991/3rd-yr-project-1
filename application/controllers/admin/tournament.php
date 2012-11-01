<?php 
class Tournament extends CI_Controller {

	/**
	 * Index should probably be a list of all tournaments for admins, but make it later
	 */
	public function index()
	{
		//$this->load->view('welcome_message');
	}
	
	public function add($name, $start, $end, $noTickets)
	{
		// load view
	}
	
	public function edit()
	{
		
	}
	
	/**
	 *	Not sure if this is needed in a controller? Find out later
	 *
	 */
	public function delete()
	{
		
	}
}

/* End of file tournament.php */
/* Location: ./application/controllers/admin/tournament.php */