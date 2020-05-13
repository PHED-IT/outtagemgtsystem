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
		$query=$this->db->get_where($this->user_table,array('staff_id'=>$data['staff_id']));
		
		if ($this->db->affected_rows()>0)
		{
			return [
					'status'=>false,
					'data'=>"a user with this Staff ID already exist"
				];
		}else{
			$result=$this->db->insert($this->user_table,$data);
			if ($result) {
			return [
					'status'=>true,
					'data'=>"Success"
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

		$row=$this->db->get_where('assign_menus',array('role_id'=>$data['role_id'],'menu_id'=>$data['menu_id']))->row();
			if (!$row){
				$this->db->insert('assign_menus',array("role_id"=>$data['role_id'],'menu_id'=>$data['menu_id']));
			}
		
		//var_dump($data['sub_menu_id']);
		$count=count($data['sub_menu_id']);
		//return ['status'=>false,'message'=>$count];
		for ($i=0; $i <$count ; $i++) { 
			$sub_menu_id=$data['sub_menu_id'][$i];
			//return ['status'=>false,'message'=>$i];
			if(isset($data['sub_menu_id'][$i])){
				//$sub_menu_id=$data['sub_menu_id'][$i];
				//return ['status'=>false,'message'=>$data['sub_menu_id'][$i]];
			$this->db->get_where($this->asign_sub_menu_table,array('role_id'=>$data['role_id'],'menu_id'=>$data['menu_id'],'sub_menu_id'=>$data['sub_menu_id'][$i]));
			if ($this->db->affected_rows()>0) {
			# role already exist
			return ['status'=>false,'message'=>"Menu added to role already"];
				} 


				$result=$this->db->insert($this->asign_sub_menu_table,array("role_id"=>$data['role_id'],'menu_id'=>$data['menu_id'],'sub_menu_id'=>$data['sub_menu_id'][$i]));
			}
		}
		if ($result) {
			
			return [
					'status'=>true,
					'message'=>"Menu created successfully!"
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
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
	
	public function add_feeder($data){
		//$this->db->where('outage_id',$outage_id);
		//var_dump($data['feeder']);
		$ibc=is_array($data['ibc_id'])?implode(',', $data['ibc_id']):$data['ibc_id'];
		$count_item=count($data['feeder']);
		for ($i=0; $i <$count_item ; $i++) { 
			$feeder=$data['feeder'][$i];
			
			
			if(!empty($feeder)){
				$result=$this->db->insert("feeders",array("feeder_name"=>strtoupper($feeder),"voltage_level"=>$data['voltage_level'],'ibc_id'=>$ibc,"station_id"=>$data['station_id'],"transformer_id"=>$data['transformer_id']));
			}
		}
		if ($result) {
			
			return [
					'status'=>true,
					'message'=>"Success!"
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
		}
		
	}
	public function add_feeder_zone($data){
		
		$count_item=count($data['feeder_id_11']);
		for ($i=0; $i <$count_item ; $i++) { 
			$feeder_id_11=$data['feeder_id_11'][$i];
			
				$result=$this->db->insert("feeder11_zones",array("feeder_id"=>$feeder_id_11,'zone_id'=>$data['zone_id'],'iss_id'=>$data['iss_id'],"sub_zone_id"=>$data['sub_zone_id'],"feeder_33kv_id"=>$data['feeder_id_33']));
			
		}
		if ($result) {
			
			return [
					'status'=>true,
					'message'=>"Success!"
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
		}
		
	}

	public function get_transformer_by_id($id){
		$query=$this->db->get_where("transformers",array("id"=>$id));
		return $query->row();
	}

	public function get_transformer($type){
		$query=$this->db->get_where("transformers",array("asset_type"=>$type));
		return $query->result();
	}
	public function get_ibc(){
		$query=$this->db->get("ibc");
		return $query->result();
	}
	public function get_zones(){
		$query=$this->db->get("zones");
		return $query->result();
	}
	public function get_sub_zones(){
		$query=$this->db->get("sub_zones");
		return $query->result();
	}
	public function get_feeders($data){
		$this->db->where($data);
		$query=$this->db->get("feeders");

		return $query->result();
	}
	public function get_transformer_iss($data){

		$query=$this->db->get_where("transformers",array("iss_id"=>$data["st_id"],"asset_type"=>$data["asset_type"]));
		return $query->result();
	}
	//this function gets all transformer for a transmission station
	public function get_transformer_ts($data){
		
		$query=$this->db->get_where("transformers",array("trans_id"=>$data["st_id"]));
		return $query->result();
	}

	public function get_feeders_by_transmission($data){
		$datax=array();
		$this->db->select('feeders.feeder_name as feeder_name,feeders.id as id')->from("feeders");
		$this->db->where(array("station_id"=>$data["st_id"],"voltage_level"=>$data["voltage_level"]));
		//$this->db->join("transformers","transformers.trans_id=".$data['st_id'],'left',FALSE);
		$query=$this->db->get();
		
		array_push($datax, $query->result());
		$this->db->select('transformers.names_trans as transformer,transformers.id as id')->from("transformers");
		$this->db->where(array("trans_id"=>$data["st_id"]));
		//$this->db->join("transformers","transformers.trans_id=".$data['st_id'],'left',FALSE);
		$query1=$this->db->get();
		array_push($datax, $query1->result());
		return $datax;
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
	public function get_user_by_iss_role($iss_id,$role){
		$this->db->where(array('iss'=>$iss_id,'role_id'=>$role));
		$query=$this->db->get($this->user_table);
		return $query->result();
	}

	public function get_users_by_ibc_role($ibc,$role){
		$this->db->where(array('ibc'=>$ibc,'role_id'=>$role));
		$query=$this->db->get($this->user_table);
		return $query->result();
	}

	public function get_users_by_sub_zone_role($sub_zone_id,$role){
		$this->db->where(array('sub_zone_id'=>$sub_zone_id,'role_id'=>$role));
		$query=$this->db->get($this->user_table);
		return $query->result();
	}
	public function get_users_by_zone_role($zone_id,$role){
		$this->db->where(array('zone_id'=>$zone_id,'role_id'=>$role));
		$query=$this->db->get($this->user_table);
		return $query->result();
	}
	public function get_users_by_role($role){
		$this->db->where(array('role_id'=>$role));
		$query=$this->db->get($this->user_table);
		return $query->result();
	}
	public function get_user_by_iss($iss){
		$this->db->where(array('iss'=>$iss));
		$query=$this->db->get($this->user_table);
		return $query->result();
	}

	// public function get_user_by_role($role){

	// }

	public function get_user_by_feeder_role($feeder_id,$role){
		//get ibc by feeder
		$this->db->select('ibc_id');
		$this->db->where('id',$feeder_id);
		$ibc=$this->db->get('feeders')->row();
		//var_dump($ibc);

		return $this->get_users_by_ibc_role($ibc->ibc_id,$role);
	}

	public function get_users(){
		$this->db->select('users.*,roles.role_name as role_name,roles.id as role_id,zones.name as zone,sub_zones.name as sub_zone,iss_tables.iss_names as iss');
		$this->db->from($this->user_table);
		$this->db->join($this->role_table,'roles.id = users.role_id');
		$this->db->join('zones','zones.id = users.zone_id','left',false);
		$this->db->join('sub_zones','sub_zones.id = users.sub_zone_id','left',false);
		$this->db->join('iss_tables','iss_tables.id = users.iss','left',false);
		$query=$this->db->get();
		return $query->result();
	}


	//get menus ,role and sub menu in a table
	public function get_menus_roles(){

		// $this->db->select('roles.id as role_id,roles.role_name as role_name,asign_menus.menu_id as menu_id');
		// $this->db->from($this->role_table);
		// //$this->db->group_by('asign_menus.role_id');
		// $this->db->join($this->asign_menu_table,'asign_menus.role_id = roles.id','left');

		// $query=$this->db->get();
		$data='';
		foreach ($this->get_roles() as  $role) {
			$data.='<tr>';
			$data.='<td>'.$role->role_name.'</td>';
			$data.='<td>';
			foreach ($this->get_menus_role_id($role->id) as $menus) {
				$data.='<button title="Remove menu" data-role="'.$role->id.'" data-type="menu" id="'.$menus->menu_id.'" class="delete_menu btn btn-sm btn-outline-primary my-1 ml-2">'.$menus->name_alias.'</button>';
			}
			$data.='</td>';
			$data.='<td>';
			foreach ($this->get_sub_menus_role_id($role->id) as $sub_menus) {
				$data.='<button data-role="'.$role->id.'" title="Remove sub menus" data-type="submenu" id="'.$sub_menus->sub_menu_id.'" class="delete_menu btn btn-sm btn-outline-default my-1 ml-2">'.$sub_menus->name_alias.'</button>';
			}
			$data.='</td>';
			

		}
		return $data;
	}
	public function get_feeder_by_id($feeder_id){

		$this->db->where('id',$feeder_id);
		 $feeder=$this->db->get('feeders')->row();
		 return $feeder;
	}
	public function get_feeder_by_zone_id($feeder_id){

		$this->db->where('feeder_id',$feeder_id);
		 $feeder=$this->db->get('feeder11_zones')->row();
		 return $feeder;
	}
	public function get_feeder33_by_zone_id($feeder_id){
		$this->db->where('feeder_33kv_id',$feeder_id);
		 $feeder=$this->db->get('feeder11_zones')->row();
		 return $feeder;
	}

	// public function get_menus_role_id

	// public function get_feeder_transformer($transformer_id){
	// 	$this->db->select(array('feeders.*','ibc.names as ibc'));
	// 	$this->db->from('feeders');
	// 	$this->db->join('ibc','feeders.ibc_id=ibc.id',"left",false);
	// 	$this->db->where('transformer_id',$transformer_id);
	// 	$query=$this->db->get();
	// 	//print_r($query);
	// 	return $query->result();
	// }
	public function get_feeder_transformer($transformer_id){
		$this->db->select(array('feeders.*'));
		$this->db->from('feeders');
		//$this->db->join('ibc','feeders.ibc_id=ibc.id',"left",false);
		$this->db->where('transformer_id',$transformer_id);
		$query=$this->db->get();
		//print_r($query);
		return $query->result();
	}
	public function get_ibc_by_feeder($feeder_id){
	
		$this->db->from('ibc');
		$this->db->join('feederibc','feederibc.ibc_id=ibc.id');
		$this->db->where('feeder_id',$feeder_id);
		$query=$this->db->get();
		
		return $query->result();
	}
	public function get_feeder33_transformer($transformer_id){
		$this->db->select(array('feeders.*','ibc.names as ibc'));
		$this->db->from('feeders');
		$this->db->join('feederic','feeders.id=feederibc.feeder_id',"left",false);
		$this->db->join('ibc','ibc.id=feederibc.ibc_id');
		$this->db->where('feeders.transformer_id',$transformer_id);
		$query=$this->db->get();
		//print_r($query);
		return $query->result();
	}

	public function show_feeder_11_hierachy(){
		$iss=$this->db->get('iss_tables')->result();
		$out='';
		foreach ($iss as $key => $iss_data) {
			$out.='<tr>';
			$out.='<td style="">'.$iss_data->iss_names.'</td>';
			$out.='<td><table>';
			foreach ($this->get_transformer_iss(["st_id"=>$iss_data->id,'asset_type'=>"ISS"]) as $key => $transformers) {
				$out.='<tr>';
				$out.='<td style="border:1px solid gray">'.$transformers->names_trans.'</td>';
				$out.='</tr>';
			}
			$out.='</table></td>';
			$out.='<td><table class="table-bordered">';
			foreach ($this->get_transformer_iss(["st_id"=>$iss_data->id,'asset_type'=>"ISS"]) as $key => $transformers) {
				$out.='<tr >';
				foreach ($this->get_feeder_transformer($transformers->id) as $key => $feeder) {
					
					$out.='<td >'.$feeder->feeder_name.'</td>';
					//$out.='<td>'.$feeder->ibc.'</td>';	
				}
				$out.='<tr>';
			}
			$out.='</table></td>';
			$out.='</tr>';
		}
		return $out;
	}
	public function show_feeder_33_hierachy(){
		$ts=$this->db->get('transmissions')->result();
		$out='';
		foreach ($ts as $key => $ts_data) {
			$out.='<tr>';
			$out.='<td style="">'.$ts_data->tsname.'</td>';
			$out.='<td><table>';
			foreach ($this->get_transformer_ts(["st_id"=>$ts_data->id,'asset_type'=>"TS"]) as $key => $transformers) {
				$out.='<tr>';
				$out.='<td style="border:1px solid gray">'.$transformers->names_trans.'</td>';
				$out.='</tr>';
			}
			$out.='</table></td>';
			$out.='<td><table class="table-bordered">';
			foreach ($this->get_transformer_ts(["st_id"=>$ts_data->id,'asset_type'=>"TS"]) as $key => $transformers) {
				$out.='<tr >';
				foreach ($this->get_feeder_transformer($transformers->id) as $key => $feeder) {
					
					$out.='<td >'.$feeder->feeder_name.'</td>';
					$out.='<td>';
					foreach ($this->get_ibc_by_feeder($feeder->id) as $key => $ibc) {
							$out.=$ibc->names.'<hr style="margin-top:0;margin-bottom:0"/>';
						}
						$out.="</td>";	
				}
				$out.='<tr>';
			}
			$out.='</table></td>';

			$out.='</tr>';
		}
		return $out;
	}

	// private function get_menu_by_role($role_id){
	// 	$this->db->join("menus ");
	// 	$query=$this->db->get_where("assign_menus",array("role_id"=>$role_id]));
	// 	return $query->result();
	// }
	private function get_submenu_by_role_menu($role_id,$menu_id){
		$query=$this->db->get_where("asign_submenus",array("role_id"=>$role_id,"menu_id"=>$menu_id));
		return $query->result();
	}



	public function get_sub_menus_role_menu_id($role_id,$menu_id){
		$this->db->select('sub_menus.id as sub_menu_id,sub_menus.name as name,sub_menus.name_alias as name_alias')->from($this->asign_sub_menu_table);
		$this->db->where(array('asign_submenus.role_id'=>$role_id,"menu_id"=>$menu_id));
		$this->db->join($this->sub_menu_table,'sub_menus.id=asign_submenus.sub_menu_id');
		$query=$this->db->get();
		return $query->result();
	}

	//show on the view menu and sub menu
	public function show_menu_submenu(){
		$roles=$this->db->get('roles')->result();
		$out='';
		foreach ($roles as $key => $role) {
			$out.='<tr>';
			$out.='<td style="">'.$role->role_name.'</td>';
			$out.='<td><table>';
			foreach ($this->get_menus_role_id($role->id) as $key => $menu) {
				$out.='<tr>';
				$out.='<td style="border:1px solid gray">'.$menu->name_alias.'</td>';
				$out.='</tr>';
			}
			$out.='</table></td>';
			$out.='<td><table class="table-bordered">';
			foreach ($this->get_menus_role_id($role->id) as $key => $menu) {
				$out.='<tr >';
				foreach ($this->get_sub_menus_role_menu_id($role->id,$menu->menu_id) as $key => $submenu) {
					
					$out.='<td >'.$submenu->name_alias.'</td>';
					
				}
				$out.='<tr>';
			}
			$out.='</table></td>';

			$out.='</tr>';
		}
		return $out;
	}

	public function get_user_by_id($user_id){
		
		$this->db->where('id',$user_id);
		
		$query=$this->db->get($this->user_table);
		//print_r($query);
		return $query->row();
	}
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
	}//get menus by role id
	public function get_submenus_menu_id($menuid){
		$controller=$this->get_menu_id($menuid)->controller;
		
		$this->db->where('controller',$controller);
		
		$query=$this->db->get('sub_menus');
		return $query->result();
	}

	//get sub menus by roleid and menu id
	public function get_sub_menus_role_id($role_id){
		$this->db->select('sub_menus.id as sub_menu_id,sub_menus.name as name,sub_menus.name_alias as name_alias')->from($this->asign_sub_menu_table);
		$this->db->where('asign_submenus.role_id',$role_id);
		$this->db->join($this->sub_menu_table,'sub_menus.id=asign_submenus.sub_menu_id');
		$query=$this->db->get();
		return $query->result();
	}
	public function delete_menu($data){
		
		if ($data['type']=="menu") {
			$this->db->where(array('menu_id'=>$data['id'],'role_id'=>$data['role_id']));
			$this->db->delete($this->asign_menu_table);
			if($this->db->affected_rows()>0){
				$this->db->where(array('menu_id'=>$data['id'],'role_id'=>$data['role_id']));
				$this->db->delete($this->asign_sub_menu_table);
			}
		} else {
			$this->db->where(array('sub_menu_id'=>$data['id'],'role_id'=>$data['role_id']));
			$this->db->delete($this->asign_sub_menu_table);
		}
		if ($this->db->affected_rows()>0) {
			return ['status'=>true,'message'=>"menu removed successfully"];
		} else {
			return ['status'=>false,'message'=>$this->db->error];
		}	
	}
	
}



?>