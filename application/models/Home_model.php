<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Home_model extends CI_Model
{
	protected $asign_menus="assign_menus";
	protected $asign_submenus="asign_submenus";
	protected $menu_table="menus";
	protected $submenu_table="sub_menus";
	

	
		// $this->db->where('users.id',$user_id);
		// $this->db->join($this->role_table,'roles.id=users.role_id');
		// $query=$this->db->get();

	public function get_menus($role_id){
		$this->db->select('ass.menu_id as menu_id,ass.role_id as role_id,m.name as name,m.name_alias as name_alias,m.controller as controller');
		//$this->db->distinct('asign_menus.menu_id');
		$this->db->from('assign_menus ass');
		//$this->db->where('ass.role_id',$role_id);
		$this->db->where('ass.role_id',$role_id);
		$this->db->join('menus m','m.id=ass.menu_id');
		//$this->db->group_by(array('asign_menus.role_id','asign_menus.menu_id'));
		$query=$this->db->get();
		$menus= $query->result();
		$sub_menus=[];
		$data='';
		//var_dump($menus);
		 
		foreach ($query->result()as $menu) {
			$data.= '<li class="dropdown">
			<a class="menu-toggle nav-link has-dropdown" href=" '.base_url($menu->controller.'/'.$menu->name).'">
			<i data-feather="grid"></i> <span >'.$menu->name_alias.'</span>
			</a>';
				foreach ($this->get_submenus($menu->role_id,$menu->menu_id) as $sub_menu) {
					$data.='<ul class="dropdown-menu">
					<li>
					<a class="nav-link" href="'. base_url($sub_menu->controller.'/'.$sub_menu->name).'">'.
					$sub_menu->name_alias.
					'</a>
                     </li>
                     </ul>
					';

				}
                        
            $data.='</li>';
		}
		return $data;
		//var_dump($this->get_submenus(1,1));
		
		//return array("menus"=>$menus,"sub_menus"=>$sub_menus);
	}
	public function get_submenus($role_id,$menu_id){
		//echo $menu_id;
		$this->db->select('*')->from($this->asign_submenus);
		$this->db->where(array('asign_submenus.role_id'=>$role_id,'asign_submenus.menu_id'=>$menu_id));
		$this->db->join($this->submenu_table,'sub_menus.id=asign_submenus.sub_menu_id');
		$query=$this->db->get();
		return $query->result();
	}

}

?>