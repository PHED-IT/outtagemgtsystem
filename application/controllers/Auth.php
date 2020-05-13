<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login(){
		$this->form_validation->set_rules('staff_id','Staff ID',"required");
		$this->form_validation->set_rules('password','Password',"required");

		if ($this->form_validation->run()==FALSE) {
			# failed
			//$data['title']="Create Role";
			$data['title']="Login";
			//$this->load->view('Layouts/header_auth',$data);
			$this->load->view('login');
			//$this->load->view('Layouts/footer_auth');
		} else {
			$this->load->model('auth_model');
			$insert_data=array('staff_id'=>$this->input->post('staff_id'),'password'=>$this->input->post('password'));

			$result=$this->auth_model->login($insert_data);
			if (!empty($result) && $result['status']==true) {
				
				$session_array=array('USER_ID'=>$result['data']->id,'IS_ACTIVE'=>true,'ROLE_ID'=>$result['data']->role_id);

				$this->session->set_userdata($session_array);
				//$this->session->set_flashdata('success',"User created successfully");
				redirect('/');
			} else {
				$this->session->set_flashdata('error',"Invalid staff Id/password ");
				redirect('login');
			}
			

		}
	
	}

	public function block(){
		if (empty($this->session->userdata('USER_ID'))) {
			redirect('login');
		}
		$data['title']="OOps you are blocked";
		$this->load->view('Layouts/header_auth',$data);
			$this->load->view('block');
			$this->load->view('Layouts/footer_auth');
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
