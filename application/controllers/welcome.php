<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends My_Public_Controller {

   function Page()
   {
      parent::Controller();
   }
   
   function index()
   {
		$this->template->write('content', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", TRUE);
		$this->template->render();
   }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */