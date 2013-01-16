<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for Location administration
 *
 * Created: 11/01/2013
 * @author	Jonathan Val <jdv2@hw.ac.uk>
 */
class Location extends My_Admin_Controller 
{
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin/Location_model');
		$this->load->helper('form');
		
	}
	
	// should be a list of all the location with pagination etc
	public function index($page = 1)
	{
		$this->load->helper('url');
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/admin/location/index/";
		$config['total_rows'] = $this->Location_model->countLocations();
		$config['per_page'] = 10; 
		$config['uri_segment'] = 4;
		// for styling with bootstrap: http://www.smipple.net/snippet/Rufhausen/Twitter%20Bootstrap%2BCodeigniter%20Pagination
	    $config['full_tag_open'] = '<div class="pagination"><ul>';
	    $config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Previous';
	    $config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		
		$data['locations'] = $this->Location_model->getPagination($config["per_page"], $page);
		$data['links'] = $this->pagination->create_links();
		
		$this->template->write_view('content','admin/location/index',$data);
		$this->template->render();
	}
	
	public function save($id = false)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules("name", "Name", "required|min_length[3]|max_length[50]");
		$this->form_validation->set_rules("capacity", "Capacity", "required|numeric|max_length[5]");

		// if input is not valid, show the form again (and send the post-date to the view so it can be re-populated)
		if ($this->form_validation->run() == FALSE)
		{
		
			$data['name'] = $this->input->post('name');
			$data['capacity'] = $this->input->post('capacity');
			$data['lights'] = $this->input->post('lights',TRUE)==null ? 0 : 1;
			
			$this->template->write_view('content','admin/location/create',$data);
			$this->template->render();
		}
		else
		{
			$this->load->helper('url');			
			
			$dateFormat = "d/m/Y";
			$dobObject = DateTime::createFromFormat($dateFormat, $this->input->post('dob'));
			
			if ($id == false)
			{

				$postdata = array(
					'name'	=> $this->input->post('name'),
					'capacity' => $this->input->post('capacity'),
					'lights' => ($this->input->post('lights',TRUE)==null ? 0 : 1),				
				);
				$id = $this->Location_model->create($postdata);
				
				echo "successfully addedd id: " . $id;
			}
			else
			{
				$postdata = array(
					'locationId'	=> $id,
					'name'	=> $this->input->post('name'),
					'capacity' => $this->input->post('capacity'),
					'lights' => ($this->input->post('lights',TRUE)==null ? 0 : 1),					
				);
				
				$this->Location_model->update($postdata);
			}
			redirect( "/admin/location" );
		}
	}
	
	public function add()
	{
		// need to set these as null to make sure no warnings come up (prepolation the form if validation error or edit)
		$data['name'] = "";
		$data['capacity'] = "";
		$data['lights'] = "";
		
		$this->template->write_view('content','admin/location/create',$data);
		$this->template->render();
	}
	
	/**
  	 * View so admin can edit a specific location.
	 * @param id	the ID of the location to be edited.
     */
	public function edit($id)
	{
		// form validations used to set variables.
		$this->load->library('form_validation');
		
		// get the id
		$location = $this->Location_model->getLocation($id);
		
		$data['name'] = $location['name'];
		$data['capacity'] = $location['capacity'];
		$data['lights'] = $location['lights'];
		$data['id'] = $id;
		
		$this->template->write_view('content','admin/location/create',$data);
		$this->template->render();
	}
	
}	
