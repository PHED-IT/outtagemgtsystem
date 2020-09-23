<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * this is model holds reusable public functions
 */
class MY_Model extends CI_Model
{

	public function get_feeders($data){
		if ($data['voltage_level']=="33kv") {
			$query=$this->db->get("feeders_33kv");
		} else {
			$query=$this->db->get("feeders_11kv");
		}
		
		return $query->result();
	}

	public function format_hour($hour){
		if (strlen($hour)==1) {
			return '0'.$hour.':00';
		} else {
			return $hour.':00';
		}
		
	}

	public function format_load($load){
		if (strlen($load)<=4) {
			return '0'.$load;
		} else {
			return $load;
		}
		
	}

	public function get_iss(){
		$this->db->select(array('iss_names','id'));
		$query=$this->db->get("iss_tables");
		return $query->result();
	}



	public function get_transmission_stations(){
		
		$this->db->select("tsname,id,zone_id");
		$query=$this->db->get("transmissions");
		return $query->result();
	}

	public function get_zones(){
		$query=$this->db->get("zones");
		return $query->result();
	}

	public function get_states(){
		 
		// $this->db->group_by("state");
		 return $this->db->get("states")->result();
	}


}