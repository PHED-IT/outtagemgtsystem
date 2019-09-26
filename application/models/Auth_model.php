<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Auth_model extends CI_Model
{
	protected $user_table="users";
	
	
	public function login($data){
		//check email exist
		$query=$this->db->get_where($this->user_table,array('email'=>$data['email']));
		if ($this->db->affected_rows()>0) {
			//email exist

			$password=$query->row('password');
			if (password_verify($data['password'], $password)===true) {
				return[
					'status'=>true,
					'data'=>$query->row()
				];
			} else {
				return [
					'status'=>false,
					'data'=>false
				];
			}
			

		} else {
			//email do not exist
			return [
					'status'=>false,
					'data'=>false
				];
		}
		
	}
}

?>