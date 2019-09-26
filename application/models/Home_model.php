<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Home_model extends CI_Model
{
	protected $asign_menus="asign_menus";
	protected $asign_submenus="asign_submenus";
	protected $menu_table="menus";
	protected $submenu_table="sub_menus";
	

	
		// $this->db->where('users.id',$user_id);
		// $this->db->join($this->role_table,'roles.id=users.role_id');
		// $query=$this->db->get();

	public function get_menus($role_id){
		$this->db->select('menu_id,role_id,name,name_alias,controller')->from($this->asign_menus);
		//$this->db->distinct('asign_menus.menu_id');
		$this->db->where('asign_menus.role_id',$role_id);
		$this->db->join($this->menu_table,'menus.id=asign_menus.menu_id');
		//$this->db->group_by(array('asign_menus.role_id','asign_menus.menu_id'));
		$query=$this->db->get();
		$menus= $query->result();
		$sub_menus=[];
		$data='';
		//var_dump($menus);
		foreach ($query->result()as $menu) {
			$data.= '<li class="current-page menu-item">
			<a href=" '.base_url($menu->controller.'/'.$menu->name).'">
			<i class="list-icon fa fa-circle-o"></i> <span class="hide-menu">'.$menu->name_alias.'</span>
			</a>';
				foreach ($this->get_submenus($menu->role_id,$menu->menu_id) as $sub_menu) {
					$data.='<ul class="list-unstyled sub-menu">
					<li>
					<a style="color:#d0d0d0" href="'. base_url($sub_menu->controller.'/'.$sub_menu->name).'">'.
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