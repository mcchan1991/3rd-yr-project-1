<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for ticket
 *
 * Created: 01/03/2013
 * @author	mcc
 */
class ticket extends My_Public_Controller {

	private $_startDate;
	private $_endDate;
	private $_tournamentId;
	
	/**
  	 * Constructor of the controller. Needs to call the parrent, and also loads the model. 
     */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/tournament_model');
		$this->load->model('admin/Event_model');
		$this->load->model('ticket_model');
		$this->load->helper('form');
		$this->load->model('admin/Sport_model');
		$this->load->model('customers_model');
		$this->load->model('ticketSale_model');
		$this->load->model('admin/event_model');
	}
	
	/**
	 * Index should probably be a list of all tournaments for admins, but make it later
	 */
	public function index($page = 1)
	{
		$this->load->helper('url');
		$this->load->library('pagination');
		
		$config['base_url'] = base_url() . "index.php/ticket/index/";
		$config['total_rows'] = $this->Tournament_model->tournamentCountFuture();
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
		
		$data['sports'] = $this->Sport_model->getAll();
		$data['tournaments'] = $this->Tournament_model->getFutureTournamentsWithEvents($config["per_page"], $page);
		$data['events'] = array();
		$data['totalEventCount'] = array();
		foreach($data['tournaments'] as $tournament )
		{
			$data['events'][$tournament['tournamentId']] = $this->Event_model->getPaginationByTournamentId($tournament['tournamentId'], 5, 1);
			$data['totalEventCount'][$tournament['tournamentId']] = $this->Event_model->countEventsByTournamentId($tournament['tournamentId']);
		}		
	
		$data['links'] = $this->pagination->create_links();
		
		$this->template->write_view('content','ticket/ticketView',$data);
		$this->template->render();
	}
	
	public function tournamentTicket($E_id)
	{
		$id=$E_id;
		$data['TournamentId']=$id;
		$data['tickets'] = $this->ticket_model->getallbyE_id($id);
		$data['something']=array();
		$this->template->write_view('content','ticket/buyticketView',$data);
		$this->template->render();
	}
	
	public function buyticket($id)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('TicketId', 'TicketId', 'required|numeric|max_length[5]');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
		$this->form_validation->set_rules('ticketType', 'Type of ticket', 'required');
		$this->form_validation->set_rules('Price', 'Price for each', 'required');
		$this->form_validation->set_rules('Date', 'Date', 'required|callback_checkAvailableDate');
		if($this->form_validation->run()==false)
		{
			$this->add($id);
		}
		else
		{
		$postdata = array(
                'id'      => $this->input->post('TicketId'),
                'qty'     =>  $this->input->post('quantity'),
                'price'   =>  $this->input->post('Price'),
                'tName'  => $this->input->post('TournamentName'),
                'name'  => $this->input->post('ticketType'),
                'date' =>$this->input->post('Date')
             );
		$this->cart->insert($postdata);
		$data['ID']=$id;
		$data['firstName']='';
		$data['surName']='';
		$data['addr1']='';
		$data['addr2']='';
		$data['postcode']='';
		$data['city']='';
		$data['email']='';
		$this->template->write_view('content','ticket/customer_info',$data);
		$this->template->render();
	}
	}
	
	
	
	public function customer($id)
	{
		$data['ID']=$id;
		$data['firstName']='';
		$data['surName']='';
		$data['addr1']='';
		$data['addr2']='';
		$data['postcode']='';
		$data['city']='';
		$data['email']='';
		$this->template->write_view('content','ticket/customer_info',$data);
		$this->template->render();
	}	
	public function add($id)
	{
		$result=$this->ticket_model->getTicketById($id);
		$data['ticket']=$result;

		foreach($result as $item)
		{
			$tId=$item['tournamentId'];
			$ticketPirce=$item['price'];
			$T_id=$item['tournamentId'];
			
		}
		$dateResult=$this->event_model->geStartEndTimes($T_id);
		$Tresult=$this->tournament_model->getTournamentnameById($T_id);
		
		$dateAv=array();
		$i=0;
		foreach($dateResult as $item)
		{
		$data['date']=$item['start'];
		$data['end']=$item['end'];
		$s_dte=$item['start'];
		$s_dte2=strtotime("-1 day", strtotime($s_dte));
		$s=date("Y-m-d",$s_dte2);
		$e_dte=$item['end'];
		$diff = abs(strtotime($e_dte) - strtotime($s)); 
		$yrs = floor($diff / (365*60*60*24)); 
		$mnth = floor(($diff - $yrs * 365*60*60*24) / (30*60*60*24)); 
		$days = floor(($diff - $yrs * 365*60*60*24 - $mnth*30*60*60*24)/ (60*60*24));
		$t=1;


		while($t <= $days){
		$dateAv[$i][$t]= $s;
		$date = strtotime("+1 day", strtotime($s));
		$s=date("Y-m-d", $date);
		$t++;
		}
		$i++;
		}
		$result11=array();
		foreach($dateAv as $item)
		{
			$result11=$result11+$item;
		}
		$data['Alength'] =count($result11);
		$data['Tname']=$Tresult['name'];
		$data['date111']=$result11;
		$data['startDate']='';
		$data['endDate']='';
		$data['Date']='';
		$data['pValue']=$ticketPirce;
		$data['quantity']='';
		
		$this->template->write_view('content','ticket/buyTicket',$data);
		$this->template->render();		
	}
	
	public function addInfo($id)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('firstName', 'First Name', 'required');
		$this->form_validation->set_rules('surName', 'Surname', 'required');
		$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
		$this->form_validation->set_rules('addr1', 'Address 1', 'required');
		$this->form_validation->set_rules('addr2', 'Address 2', 'required');
		$this->form_validation->set_rules('postcode', 'Postcode', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		
		if($this->form_validation->run()==false)
		{
			$this->customer($id);
		}
		else
		{
				$data['postdata'] = array(
				'customerId' => NULL,
                'firstName'      => $this->input->post('firstName'),
                'surName'     =>  $this->input->post('surName'),
                'email'   =>  $this->input->post('email'),
                'addr1'   =>  $this->input->post('addr1'),
                'addr2'  => $this->input->post('addr2'),
                'postcode'   =>  $this->input->post('postcode'),
                'city'  => $this->input->post('city')
             );
			//$this->customers_model->create($postdata);
			$data['cart']=$this->cart->contents();
            //print_r($this->cart->contents());
			$this->template->write_view('content','ticket/payment',$data);
			$this->template->render();	
		}
	
	}
	
	
	public function show()
	{	
		print_r($this->cart->contents());
	}
	
	public function destory()
	{	
		$this->cart->destroy();
	}
	
	public function update()
	{
		$i=1;
		foreach ($this->cart->contents() as $items)
		{
			$data =array(
			'rowid' => $this->input->post($i.'rowid'),
			'qty'     =>$this->input->post($i.'qty'),
			);
			$i++;
			$this->cart->update($data);
		}
		$data['postdata']=$this->input->post('postdata');
		$data['cart']=$this->cart->contents();
		$this->template->write_view('content','ticket/payment',$data);
		$this->template->render();	

	}
	
	public function confirm()
	{
		$result=$this->input->post('postdata');
		$data['addr1']=$result['addr1'];
		$data['addr2']=$result['addr2'];
		$data['city']=$result['city'];
		$data['postcode']=$result['postcode'];
		$customerId= $this->customers_model->create($result);

		foreach($this->cart->contents() as $items)
		{
			$postdata =array(
			'ticketId'=>$items['id'],
			'quantity' =>$items['qty'],
			'customerId'=>$customerId,
			'date'=>$items['date']
			);
			$this->ticketSale_model->create($postdata);
		}
		$data['total']=$this->cart->total();
		$this->cart->destroy();
		$this->template->write_view('content','ticket/receipt',$data);
		$this->template->render();	
	}
	
	public function checkAvailableDate()
	{
		$result=false;
		$dateAv=$this->input->post('checkdate');
		foreach($dateAv as $item)
		{
			if($item==$this->input->post('Date'))
			{
				$result=true;
			}
		}
		
		if ($result == false)
		{
			$this->form_validation->set_message('checkAvailableDate', "The Date is not available");	
		}
		
		return $result;
	}
}




