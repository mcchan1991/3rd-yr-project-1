<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Staff_model');
	}
	function index()
	{
		$this->Staff_model->logout();
	}
}
