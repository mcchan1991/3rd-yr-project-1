<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends My_Public_Controller {

   function Page()
   {
      parent::Controller();
   }
   
   function index()
   {
		$this->template->write('content', "Shut'yo mouth!", TRUE);
		$this->template->render();
   }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */