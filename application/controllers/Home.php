<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
		//$this->load->get_var('menus');
		$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		$data['title']="Network operation management system";
		$this->load->view('Layouts/header',$data);
		$this->load->view('home');
		$this->load->view('Layouts/footer');
		//print_r($this->session->userdata('USER_ID'));
	}

	


	public function change_password(){
		// if (empty($this->session->userdata('USER_ID'))) {
		// 	redirect('login');
		// }

		
		$this->form_validation->set_rules('password','Password',"trim|required");
		$this->form_validation->set_rules('cpassword','Confirm password',"trim|required");
		

		if ($this->form_validation->run()==FALSE) {
			# failed
			$data['title']="Change Password";
			
			$this->load->view('Layouts/header',$data);
			$this->load->view('change_password',$data);
			$this->load->view('Layouts/footer');
		} else {
			if ($this->input->post('password')!=$this->input->post('cpassword')) {
				$this->session->set_flashdata('error',"Password and Confirm password not the same");
				redirect('home/change_password');
			}
			$insert_data=array('password'=>password_hash($this->input->post('password'), PASSWORD_DEFAULT));
			

			$result=$this->admin_model->update_user($this->session->userdata('USER_ID'),$insert_data);
			if ($result['status']) {
				$this->session->set_flashdata('success',"Password change successfully");
				redirect('home/change_password');
			} else {
				$this->session->set_flashdata('error',$result['data']);
				redirect('home/change_password');
			}		

		}
		
	}
}
