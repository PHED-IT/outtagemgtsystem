<?php

class MY_Controller extends CI_Controller {

     public function __construct() {
         parent::__construct();

         //get your data
         if (empty($this->session->userdata('USER_ID'))) {
			redirect('login');
		}
         $this->load->model('home_model');

         $global_data = array('menus'=>$this->home_model->get_menus($this->session->userdata('ROLE_ID')));

         //Send the data into the current view
         //http://ellislab.com/codeigniter/user-guide/libraries/loader.html
         $this->load->vars($global_data);

     }  
}

?>