<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ticket extends My_Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Tournament_model');
		$this->load->model('admin/Event_model');
		$this->load->helper('form');
		$this->load->model('ticket_model');
		$this->load->model('ticketSale_model');
	}
	
	public function index($id,$page = 1)
	{
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/ticket/index/";
		$config['total_rows'] = $this->ticket_model->countTournamentTicket($id);
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
		$data['id']=$id;
		$data['tickets'] = $this->ticket_model->getPagination($config["per_page"], $page,$id);

		$this->template->write_view('content','ticket/adminTicketView',$data);
		$this->template->render();
		
		
	}
	
	public function register($id)
	{
		$data['tournamentId']=$id;
		$data['tournament'] = $this->Tournament_model->getTournamentId($id);
		if (empty($data['tournament']))
		{
			echo "No tournament with the specified ID exists. <br />";
			exit();
		}
		$data['ticketType']='';
		$data['noTickets']='';
		$data['price']='';
		$this->template->write_view('content','ticket/adminTicket',$data);
		$this->template->render();
	}
	
	public function addTicket()
	{
		$this->load->library('form_validation');
		//validate the input
		$this->form_validation->set_rules("noTickets", "Number of Tickets", "required|numeric|callback_checkTicketNo");
		$this->form_validation->set_rules("ticketType", "Ticket Type", "required");
		$this->form_validation->set_rules("price", "Price", "required|numeric");
		//if does not valid then go to register agin
		//otherwise pass data to database
		if ($this->form_validation->run() == FALSE)
		{
			$this->register($this->input->post('id'));
		}
		else
		{
			$postdata = array(
				'ticketId'=> NULL,
				'tournamentId'	=> $this->input->post('id'),
				'ticketType' => $this->input->post('ticketType'),
				'noTickets' => $this->input->post('noTickets'),
				'price' => $this->input->post('price'),
				);
			$this->ticket_model->create($postdata);
			redirect("admin/tournament/view/{$this->input->post('id')}", 'refresh');
		}
	}
	
	public function ticketSale($id)
	{
		$sortType=$this->ticket_model->getTicketTypeById($id);
		$typeData=array();
		$type=array();
		$i=0;
		foreach($sortType as $item)
		{
			$type[$i]=$item;
			$typeResult=$this->ticketSale_model->findTicketTypeSale($id,$item['ticketType']);
			$typeData[$item['ticketType']]=$typeResult;
			$i++;
		}
		$result=$this->ticketSale_model->findSale($id);
		$data['types']=$type;
		$data['ticketsinfo']=$result;
		$data['typeData']=$typeData;
		
		$this->template->write_view('content','ticket/adminTicketSaleView',$data);
		$this->template->render();
	}
	
	
	//this is the function for check validation
	//sales of ticket number does not exceed the total number of ticket 
	public function checkTicketNo()
	{
		$ticketNumber=$this->input->post('noTickets');
		$id=$this->input->post('id');
		$Ttotal=$this->Tournament_model->checkTournamentTickets($id);
		$checkTotal=$this->ticket_model->checkTotalTicket($id);
		$total=0;
		$total1=0;
		foreach($checkTotal as $item)
		{
			foreach($item as $value)
			{
				$total=$total+$value;
			}
		}
		
		foreach($Ttotal as $value)
		{
			$total1=$total1+$value;
		}
		
		$total=$total+$ticketNumber;
		if($total>$total1)
		{
			$this->form_validation->set_message('checkTicketNo', "the total of ticket have reached {$total1}");	
			$result=false;
		}
		else
		{
			$result= true;
		}
		
		return $result;
			

	}
}
