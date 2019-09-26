<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Admin extends MY_Controller
{
	
	// public function index(){
	// 	$this->load->get_var('menus');
	// 	$data['title']="Outage management system";
	// 	$this->load->view('Layouts/header',$data);
	// 	$this->load->view('home');
	// 	$this->load->view('Layouts/footer');
	// }

	
	

	public function create_user(){
				
		$this->form_validation->set_rules('first_name','First name',"required");
		$this->form_validation->set_rules('last_name','Last name',"required");
		$this->form_validation->set_rules('email','Email Id',"required|valid_email");
		$this->form_validation->set_rules('phone','Phone number',"trim|required|min_length[8]|is_natural");
		$this->form_validation->set_rules('role','Role',"required");

		if ($this->form_validation->run()==FALSE) {
			# failed
			//$this->load->get_var('menus');
			$data['title']="Create User";
			$data['roles']=$this->admin_model->get_roles();
			$this->load->view('Layouts/header',$data);
			$this->load->view('create_user',$data);
			$this->load->view('Layouts/footer');
		} else {
			//$this->load->model('admin_model');
			$insert_data=array('first_name'=>$this->input->post('first_name'),'last_name'=>$this->input->post('last_name'),'email'=>$this->input->post('email'),'role_id'=>$this->input->post('role'),'phone'=>$this->input->post('phone'),'password'=>password_hash("password", PASSWORD_DEFAULT));

			$result=$this->admin_model->create_user($insert_data);
			if ($result['status']) {
				$this->session->set_flashdata('success',"User created successfully");
				redirect('admin/create_user');
			} else {
				$this->session->set_flashdata('error',$result['data']);
				redirect('admin/create_user');
			}
			

		}

	}

	public function asign_role_menu(){
				
		$this->form_validation->set_rules('menu','Menu name',"required");
		$this->form_validation->set_rules('role','Role',"required");


		if ($this->form_validation->run()==FALSE) {
			# failed
			//echo "string";
			
			$data['title']="Asign menu to role";
			$data['roles']=$this->admin_model->get_roles();
			$data['all_menus']=$this->admin_model->get_menus();
			$data['sub_menus']=$this->admin_model->get_sub_menus();
			$this->load->view('Layouts/header',$data);
			$this->load->view('asign_role_menu',$data);
			$this->load->view('Layouts/footer');
		} else {
			//echo "string";
			
			$insert_data=array('role_id'=>$this->input->post('role'),'menu_id'=>$this->input->post('menu'));

			$result=$this->admin_model->create_role_menu($insert_data);
			if ($result['status']) {
				$this->session->set_flashdata('success',"Menu asign to role successfully");
				redirect('admin/asign_role_menu');
			} else {
				$this->session->set_flashdata('error',$result['message']);
				redirect('admin/asign_role_menu');
			}
			

		}

	}

	public function create_sub_menus(){
				
		$this->form_validation->set_rules('menu_id','Menu name',"required");
		$this->form_validation->set_rules('role_id','Role',"required");
		$this->form_validation->set_rules('sub_menu','Sub menus',"required");


		if ($this->form_validation->run()==FALSE) {
			# failed
			//echo "string";
			
			$data['title']="Asign menu to role";
			$data['roles']=$this->admin_model->get_roles();
			$data['all_menus']=$this->admin_model->get_menus();
			$data['sub_menus']=$this->admin_model->get_sub_menus();
			$this->load->view('Layouts/header',$data);
			$this->load->view('asign_role_menu',$data);
			$this->load->view('Layouts/footer');
		} else {
			//echo "string";
			
			$insert_data=array('role_id'=>$this->input->post('role_id'),'menu_id'=>$this->input->post('menu_id'),'sub_menu_id'=>$this->input->post('sub_menu'));

			$result=$this->admin_model->create_sub_menu($insert_data);
			if ($result['status']) {
				$this->session->set_flashdata('success',"Sub Menu asign to role successfully");
				redirect('admin/asign_role_menu');
			} else {
				$this->session->set_flashdata('error',$result['message']);
				redirect('admin/asign_role_menu');
			}
			

		}

	}


	public function edit_user($user_id){
		if (empty($this->session->userdata('USER_ID'))) {
			redirect('login');
		}


		
		$this->form_validation->set_rules('first_name','First name',"required");
		$this->form_validation->set_rules('last_name','Last name',"required");
		$this->form_validation->set_rules('email','Email Id',"required|valid_email");
		$this->form_validation->set_rules('phone','Phone number',"trim|required|min_length[8]|is_natural");
		$this->form_validation->set_rules('role','Role',"required");

		if ($this->form_validation->run()==FALSE) {
			# failed
			$data['title']="Edit User";
			$data['roles']=$this->admin_model->get_roles();
			$data['user']=$this->admin_model->get_user($user_id);
			$this->load->view('Layouts/header',$data);
			$this->load->view('create_user',$data);
			$this->load->view('Layouts/footer');
		} else {
			$this->load->model('admin_model');
			$insert_data=array('first_name'=>$this->input->post('first_name'),'last_name'=>$this->input->post('last_name'),'email'=>$this->input->post('email'),'role_id'=>$this->input->post('role'),'phone'=>$this->input->post('phone'));

			$result=$this->admin_model->update_user($user_id,$insert_data);
			if ($result['status']) {
				$this->session->set_flashdata('success',"User updated successfully");
				redirect('admin/view_users');
			} else {
				$this->session->set_flashdata('error',$result['data']);
				redirect('admin/edit_user');
			}
			

		}
		
	}



	public function block_user($user_id){
		if (empty($this->session->userdata('USER_ID'))) {
			redirect('login');
		}

		$data=array('blocked'=>1);
		$result=$this->admin_model->update_user($user_id,$data);
			
		if ($result['status']==true) {
			$this->session->set_flashdata('success',"User blocked successfully");
			redirect('admin/view_users');
		} else {
			$this->session->set_flashdata('error',$result['message']);
			redirect('admin/view_users');
		}
	}

	public function unblock_user($user_id){
		if (empty($this->session->userdata('USER_ID'))) {
			redirect('login');
		}
		$data=array('blocked'=>0);
		$result=$this->admin_model->update_user($user_id,$data);
			
		if ($result['status']==true) {
			$this->session->set_flashdata('success',"User unblocked successfully");
			redirect('admin/view_users');
		} else {
			$this->session->set_flashdata('error',$result['message']);
			redirect('admin/view_users');
		}
	}

	public function create_role(){
		if (empty($this->session->userdata('USER_ID'))) {
			redirect('login');
		}
		
		$this->form_validation->set_rules('role_name','Role name',"required");
		
		if ($this->form_validation->run()==FALSE) {
			$data['title']="Create Role";
			# failed
			$this->load->view('Layouts/header',$data);
			$this->load->view('create_role');
			$this->load->view('Layouts/footer');
		} else {
			//$this->load->model('admin_model');
			$insert_data=array('role_name'=>$this->input->post('role_name'));

			$result=$this->admin_model->create_role($insert_data);
			if ($result['status']==true) {
				$this->session->set_flashdata('success',"Role created successfully");
				redirect('admin/view_roles');
			} else {
				$this->session->set_flashdata('error',$result['message']);
				redirect('admin/create_role');
			}
			

		}
	}

	public function edit_role($role_id){
		// if (empty($this->session->userdata('USER_ID'))) {
		// 	redirect('login');
		// }

		
		$this->form_validation->set_rules('role_name','Role name',"required");
		
		if ($this->form_validation->run()==FALSE) {
			//echo $role_id;
			$data['title']="Edit Role";
			$data['role']=$this->admin_model->get_role($role_id);
			# failed
			$this->load->view('Layouts/header',$data);
			$this->load->view('create_role',$data);
			$this->load->view('Layouts/footer');
		} else {
			//$this->load->model('admin_model');
			$insert_data=array('role_name'=>$this->input->post('role_name'));
			$result=$this->admin_model->update_role($role_id,$insert_data);
			
			if ($result['status']==true) {
				$this->session->set_flashdata('success',"Role updated successfully");
				redirect('admin/view_roles');
			} else {
				$this->session->set_flashdata('error',$result['message']);
				redirect('admin/edit_role/'.$role_id);
			}
			

		}
	}

	public function edit_menu($role_id,$menu_id){
		// if (empty($this->session->userdata('USER_ID'))) {
		// 	redirect('login');
		// }

		
		$this->form_validation->set_rules('role_id','Role name',"required");
		
		if ($this->form_validation->run()==FALSE) {
			//echo $role_id;
			$data['title']="Edit Menu";
			$data['data_role']=$this->admin_model->get_role_id($role_id);
			$data['data_menu']=$this->admin_model->get_menu_id($menu_id);
			//$data['roles']=$this->admin_model->get_roles();
			$data['all_menus']=$this->admin_model->get_menus();
			# failed
			$this->load->view('Layouts/header',$data);
			$this->load->view('edit_menu',$data);
			$this->load->view('Layouts/footer');
		} else {
			//$this->load->model('admin_model');
			$insert_data=array('role_id'=>$this->input->post('role_id'),'menu_id'=>$this->input->post('menu_id'));
			$result=$this->admin_model->update_menu($role_id,$menu_id,$insert_data);
			
			if ($result['status']==true) {
				$this->session->set_flashdata('success',"Menu updated successfully");
				redirect('admin/view_menus');
			} else {
				$this->session->set_flashdata('error',$result['message']);
				redirect('admin/edit_menu/'.$role_id.'/'.$menu_id);
			}
			

		}
	}

	public function edit_submenu($role_id,$menu_id,$sub_menu_id){
		// if (empty($this->session->userdata('USER_ID'))) {
		// 	redirect('login');
		// }

		
		$this->form_validation->set_rules('role_id','Role name',"required");
		
		if ($this->form_validation->run()==FALSE) {
			//echo $role_id;
			$data['title']="Edit Menu";
			$data['data_role']=$this->admin_model->get_role_id($role_id);
			$data['data_menu']=$this->admin_model->get_menu_id($menu_id);
			$data['data_sub_menu']=$this->admin_model->get_submenu_id($sub_menu_id);
			$data['sub_menus']=$this->admin_model->get_sub_menus();
			# failed
			$this->load->view('Layouts/header',$data);
			$this->load->view('edit_submenu',$data);
			$this->load->view('Layouts/footer');
		} else {
			//$this->load->model('admin_model');
			$insert_data=array('role_id'=>$this->input->post('role_id'),'menu_id'=>$this->input->post('menu_id'),'sub_menu_id'=>$this->input->post('sub_menu_id'));
			$result=$this->admin_model->update_sub_menu($role_id,$menu_id,$sub_menu_id,$insert_data);
			
			if ($result['status']==true) {
				$this->session->set_flashdata('success',"sub menu updated successfully");
				redirect('admin/view_menus');
			} else {
				$this->session->set_flashdata('error',$result['message']);
				redirect('admin/edit_submenu/'.$role_id.'/'.$menu_id.'/'.$sub_menu_id);
			}
			

		}
	}

	public function delete_role($role_id){
		if (empty($this->session->userdata('USER_ID'))) {
			redirect('login');
		}
		$result=$this->admin_model->delete_role($role_id);
			
		if ($result['status']==true) {
			$this->session->set_flashdata('success',"Role deleted successfully");
			redirect('admin/view_roles');
		} else {
			$this->session->set_flashdata('error',$result['message']);
			redirect('admin/view_roles');
		}
	}

	

	public function view_roles(){
		// if (empty($this->session->userdata('USER_ID'))) {
		// 	redirect('login');
		// }
		$data['roles']=$this->admin_model->get_roles();
		$data['title']="Get all roles";
		$this->load->view('Layouts/header',$data);
		$this->load->view('view_roles',$data);
		$this->load->view('Layouts/footer');
	}

	public function view_users(){
		
		$data['users']=$this->admin_model->get_users();
		$data['title']="Get all users";
		$this->load->view('Layouts/header',$data);
		$this->load->view('view_users',$data);
		$this->load->view('Layouts/footer');
	}

	public function view_menus(){
		
		$data['menu_roles']=$this->admin_model->get_menus_roles();
		
		$data['title']="Get menus";
		$this->load->view('Layouts/header',$data);
		$this->load->view('view_asign_menus',$data);
		$this->load->view('Layouts/footer');
	}
	public function get_menus_role_id(){
		$role_id=$this->input->post('role_id');
		$menu_data=$this->admin_model->get_menus_role_id($role_id);
		echo json_encode($menu_data);
	}


	
}



?>