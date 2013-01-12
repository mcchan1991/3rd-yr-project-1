<?php

class Athlete extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Athlete_model');
	}

	function index()
	{
		//will do this after we have templating working and such
	}
	
	function create($male = TRUE)
	{
		$this->load->helper('form');
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['firstName'] = "";
		$data['surname'] = "";
		$data['email'] = "";
		$data['password'] = "";
		$data['dob'] = "";
		$data['gender'] = ($male ? 'male' : 'female');
		$this->template->write_view('content','athlete/create',$data);
		$this->template->render();
	}
	
	function login()
	{
	
	}
	
	function VerifyLogin()
	{
	
	}
	
	function update()
	{

	}
	
	
	function delete()
	{

	}
}
