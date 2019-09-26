<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login(){
		$this->form_validation->set_rules('email','Email',"required");
		$this->form_validation->set_rules('password','Password',"required");

		if ($this->form_validation->run()==FALSE) {
			# failed
			//$data['title']="Create Role";
			$this->load->view('Layouts/header_auth');
			$this->load->view('login');
			$this->load->view('Layouts/footer_auth');
		} else {
			$this->load->model('auth_model');
			$insert_data=array('email'=>$this->input->post('email'),'password'=>$this->input->post('password'));

			$result=$this->auth_model->login($insert_data);
			if (!empty($result) && $result['status']==true) {
				$session_array=array('USER_ID'=>$result['data']->id,'IS_ACTIVE'=>true,'ROLE_ID'=>$result['data']->role_id);

				$this->session->set_userdata($session_array);
				//$this->session->set_flashdata('success',"User created successfully");
				redirect('/');
			} else {
				$this->session->set_flashdata('error',"Invalid email/password ");
				redirect('login');
			}
			

		}
	
	}

	

	public function logout() {

        /**
         * Remove Session Data
         */
        $remove_sessions = array('USER_ID', 'ROLE_ID','IS_ACTIVE');
        $this->session->unset_userdata($remove_sessions);

        redirect('login');
    }
}
