<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for logging administrators out
 *
 * Created: 12/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
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
