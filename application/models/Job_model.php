<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**this model is for cron job
 * 
 */
class Job_model extends CI_Model
{

	public function addToJob($data){
		foreach ($data as $key => $value) {
			$result=$this->db->insert("jobs",array("name"=>$data[$key]['name'],"email"=>$data[$key]['email'],"phone"=>$data[$key]['phone'],"message"=>$data[$key]['message'],"subject"=>$data[$key]['subject'],"status"=>$data[$key]['status']));
			
		}

		if ($result) {
			return [
					'status'=>true,
					'data'=>"Log Created"
				];
		} else {
			return [
					'status'=>false,
					'data'=>$this->db->error
				];
		}
		
	}

	public function getJobs(){
		$this->db->where('status',"pending");
		$query=$this->db->get("jobs");
		return $query->result();
	}

	public function deleteFromJob($id){
		$this->db->where('id', $id);
		$this->db->delete("jobs");
	}

}