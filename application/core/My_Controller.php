<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Base controller to extend all the admin pages, for automatic logged in check and navigation
 *
 * Created: 12/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
class My_Admin_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			redirect( "/admin/login" );
		}
		$this->load->helper('url');
		$data['segment'] = $this->uri->segment(2);
		if (empty($data['segment']))
		{
			$data['segment'] = "home";
		}
		$this->template->write_view('nav_top','admin/topnav', $data);
		
		// if not overwritten loads default a list of active tournaments
		$this->load->model('admin/Tournament_model');
		$sideData['tournaments'] = $this->Tournament_model->getFutureTournaments(5, 1);
		$this->template->write_view('nav_side','admin/navside_standard',$sideData);
		
	}
}