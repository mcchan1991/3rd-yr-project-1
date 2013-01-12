<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Staff extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			redirect( "/admin/login" );
		}
		
		$this->load->model('admin/Staff_model');
	}

	function index()
	{
		//will do this after we have templating working and such
	}
	
	function create()
	{
		$data = array(
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content')
		);
		
		$this->Staff_model->add_record($data);
		$this->index();
	}
	
	function update()
	{
		$data = array(
			'title' => 'My Freshly UPDATED Title',
			'content' => 'Content should go here; it is updated.'	
		);
		
		$this->Staff_model->update_record($data);
	}
	
	
	function delete()
	{
		$this->Staff_model->delete_row();
		$this->index();
	}
}
