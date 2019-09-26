<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Admin_model extends CI_Model
{
	
	protected $user_table="users";
	protected $role_table="roles";
	protected $menu_table="menus";
	protected $sub_menu_table="sub_menus";
	protected $asign_menu_table="asign_menus";
	protected $asign_sub_menu_table="asign_submenus";

	public function create_user($data){
		$query=$this->db->get_where($this->user_table,array('email'=>$data['email']));
		
		if ($this->db->affected_rows()>0)
		{
			return [
					'status'=>false,
					'data'=>"a user with this email already exist"
				];
		}else{
			$result=$this->db->insert($this->user_table,$data);
			if ($result) {
			return [
					'status'=>true,
					'data'=>"a user with this mail already exist"
				];
		} else {
			return [
					'status'=>false,
					'data'=>$this->db->error
				];
		}

		}
		
		
	}

	

	public function create_role($data){
		$role=$this->db->get_where($this->role_table,array('role_name'=>$data['role_name']));
		if ($this->db->affected_rows()>0) {
			# role already exist
			return ['status'=>false,'message'=>"Role already exist"];
		} else {
			$result=$this->db->insert($this->role_table,$data);
			if ($result) {
			return ['status'=>true,'message'=>"Role created successfully"];
		} else {
			
			return ['status'=>false,'message'=>$this->db->error];
		}
		}	
		
	}

	public function create_role_menu($data){
		$role=$this->db->get_where($this->asign_menu_table,array('role_id'=>$data['role_id'],'menu_id'=>$data['menu_id']));
		if ($this->db->affected_rows()>0) {
			# role already exist
			return ['status'=>false,'message'=>"You have already asign this role to this menu"];
		} else {
			$result=$this->db->insert($this->asign_menu_table,$data);
			if ($result) {
			return ['status'=>true,'message'=>"Role created successfully"];
		} else {
			
			return ['status'=>false,'message'=>$this->db->error];
		}
		}
		
		
	}

	public function create_sub_menu($data){
		$this->db->get_where($this->asign_sub_menu_table,array('role_id'=>$data['role_id'],'menu_id'=>$data['menu_id'],'sub_menu_id'=>$data['sub_menu_id']));
		if ($this->db->affected_rows()>0) {
			# role already exist
			return ['status'=>false,'message'=>"You have already asign this sub menu to this menu and role"];
		} else {
			$result=$this->db->insert($this->asign_sub_menu_table,$data);
			if ($result) {
			return ['status'=>true,'message'=>"sub menu created successfully"];
		} else {
			
			return ['status'=>false,'message'=>$this->db->error];
		}
		}
		
		
	}

		public function update_role($role_id,$data){
		$this->db->where('id',$role_id);
		$result=$this->db->update($this->role_table,$data);
		
		if ($result) {
			return ['status'=>true,'message'=>"Role updated successfully"];
		} else {
			return ['status'=>false,'message'=>$this->db->error];
		}
				
		
	}

	public function delete_role($role_id){
		$this->db->where('id',$role_id);
		$result=$this->db->delete($this->role_table);
		
		if ($this->db->affected_rows()>0) {
			return ['status'=>true,'message'=>"Role deleted successfully"];
		} else {
			return ['status'=>false,'message'=>$this->db->error];
		}	
	}

	public function delete_user($user_id){
		$this->db->where('id',$user_id);
		$result=$this->db->delete($this->user_table);
		
		if ($this->db->affected_rows()>0) {
			return ['status'=>true,'message'=>"User deleted successfully"];
		} else {
			return ['status'=>false,'message'=>$this->db->error];
		}	
	}
	public function update_user($user_id,$data){
		$this->db->where('id',$user_id);
		$result=$this->db->update($this->user_table,$data);
		
		if ($result) {
			return ['status'=>true,'message'=>"User updated successfully"];
		} else {
			return ['status'=>false,'message'=>$this->db->error];
		}
				
		
	}

	public function update_menu($role_id,$menu_id,$data){
		$this->db->get_where($this->asign_menu_table,array('role_id'=>$role_id,'menu_id'=>$data['menu_id']));
		if ($this->db->affected_rows()>0) {
			# role already exist
			return ['status'=>false,'message'=>"You have already asign this role to this menu"];
		} 
		$this->db->where(array('role_id'=>$role_id,'menu_id'=>$menu_id));
		$result=$this->db->update($this->asign_menu_table,$data);
		
		if ($result) {
			return ['status'=>true,'message'=>"menu updated successfully"];
		} else {
			return ['status'=>false,'message'=>$this->db->error];
		}
				
		
	}
	public function update_sub_menu($role_id,$menu_id,$sub_menu_id,$data){
		$this->db->get_where($this->asign_sub_menu_table,array('role_id'=>$role_id,'menu_id'=>$data['menu_id'],'sub_menu_id'=>$data['sub_menu_id']));
		if ($this->db->affected_rows()>0) {
			# role already exist
			return ['status'=>false,'message'=>"You have already asign this sub menu to this role and menu"];
		} 
		$this->db->where(array('role_id'=>$role_id,'menu_id'=>$menu_id));
		$result=$this->db->update($this->asign_sub_menu_table,$data);
		
		if ($result) {
			return ['status'=>true,'message'=>"sub menu updated successfully"];
		} else {
			return ['status'=>false,'message'=>$this->db->error];
		}
				
		
	}
	
	

	public function get_roles(){
		$query=$this->db->get($this->role_table);
		return $query->result();
	}

	public function get_menus(){
		$query=$this->db->get($this->menu_table);
		return $query->result();
	}
	public function get_sub_menus(){
		$query=$this->db->get($this->sub_menu_table);
		return $query->result();
	}

	public function get_users(){
		$this->db->select('users.*,roles.role_name as role_name,roles.id as role_id');
		$this->db->from($this->user_table);
		$this->db->join($this->role_table,'roles.id = users.role_id');
		$query=$this->db->get();
		return $query->result();
	}


	//get menus ,role and sub menu in a table
	public function get_menus_roles(){

		$this->db->select('roles.id as role_id,roles.role_name as role_name,asign_menus.menu_id as menu_id');
		$this->db->from($this->role_table);
		//$this->db->group_by('asign_menus.role_id');
		$this->db->join($this->asign_menu_table,'asign_menus.role_id = roles.id','left');

		$query=$this->db->get();
		$data='';
		foreach ($query->result() as  $role) {
			$data.='<tr>';
			$data.='<td>'.$role->role_name.'</td>';
			$data.='<td>';
			foreach ($this->get_menus_role_id($role->role_id) as $menus) {
				$data.='<a title="Edit menu" style="margin-right:7px;text-decoration:underline" href="'.base_url('admin/edit_menu').'/'.$role->role_id.'/'.$menus->menu_id.'">'.$menus->name_alias.'</a>';
			}
			$data.='</td>';
			$data.='<td>';
			foreach ($this->get_sub_menus_role_id($role->role_id,$role->menu_id) as $sub_menus) {
				$data.='<a title="Edit sub menus" style="margin-right:7px;text-decoration:underline" href="'.base_url('admin/edit_submenu').'/'.$role->role_id.'/'.$role->menu_id.'/'.$sub_menus->sub_menu_id.'">'.$sub_menus->name_alias.'</a>';
			}
			$data.='</td>';
			

		}
		return $data;
	}
	// public function get_menus_role_id

	public function get_user($user_id){
		
		$this->db->select('*')->from($this->user_table);
		$this->db->where('users.id',$user_id);
		$this->db->join($this->role_table,'roles.id=users.role_id');
		$query=$this->db->get();
		//print_r($query);
		return $query->row();
	}

	public function get_role_id($role_id){
		$query=$this->db->get_where($this->role_table,array('id'=>$role_id));
		return $query->row();
	}
	public function get_menu_id($menu_id){
		$query=$this->db->get_where($this->menu_table,array('id'=>$menu_id));
		return $query->row();
	}

	public function get_submenu_id($sub_menu_id){
		$query=$this->db->get_where($this->sub_menu_table,array('id'=>$sub_menu_id));
		return $query->row();
	}

	public function get_role($role_id){
		$query=$this->db->get_where($this->role_table,array('id'=>$role_id));
		return $query->row();
	}

	//get menus by role id
	public function get_menus_role_id($role_id){
		$this->db->select('asign_menus.role_id as role_id,menus.name as name,menus.name_alias as name_alias,menus.id as menu_id')->from($this->asign_menu_table);
		$this->db->where('asign_menus.role_id',$role_id);
		$this->db->join($this->menu_table,'menus.id=asign_menus.menu_id');
		$query=$this->db->get();
		return $query->result();
	}

	//get sub menus by roleid and menu id
	public function get_sub_menus_role_id($role_id,$menu_id){
		$this->db->select('sub_menus.id as sub_menu_id,sub_menus.name as name,sub_menus.name_alias as name_alias')->from($this->asign_sub_menu_table);
		$this->db->where(array('asign_submenus.role_id'=>$role_id,'asign_submenus.menu_id'=>$menu_id));
		$this->db->join($this->sub_menu_table,'sub_menus.id=asign_submenus.sub_menu_id');
		$query=$this->db->get();
		return $query->result();
	}
}



?>