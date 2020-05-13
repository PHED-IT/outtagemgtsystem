<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * this is model for planned outages
 */
class Forced_model extends CI_Model
{
	protected $planned_outages_table="planned_outages";
	protected $fault_cause_table="fault_causes";
	protected $fault_interrupt_table="fault_interrupts";
	protected $allocate_table="allocate_trippings";
	protected $close_table="closed_trippings";

	
	public function capture($data){
		$result=$this->db->insert($this->planned_outages_table,$data);
			if ($result) {
			return [
					'status'=>true,
					'message'=>"Planned outage has been entered successfully"
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
		}
	}
	public function allocate_tripping($data){
		$result=$this->db->insert($this->allocate_table,$data);
			if ($result) {
				$this->db->where('id',$data['tripping_id']);
				$this->db->update($this->planned_outages_table,array('allocated'=>1));
			return [
					'status'=>true,
					'message'=>"Allocaction is successful!"
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
		}
	}
	public function closure_nm_post($data){
	$result=$this->db->insert("close_network_maintainace",$data);
			if ($result) {
				 $this->db->where('id',$data['tripping_id']);
				 $this->db->update($this->planned_outages_table,array('status'=>1));
			return [
					'status'=>true,
					'message'=>"Successfull!"
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
		}
	}
	public function acknowledge_dso_post($data){
	$result=$this->db->insert("forced_close_dso",$data);
			if ($result) {
				 $this->db->where('id',$data['tripping_id']);
				 $this->db->update($this->planned_outages_table,array('status'=>2));
			return [
					'status'=>true,
					'message'=>"Successfull!"
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
		}
	}
	public function closure_nso_post($data){
	$result=$this->db->insert("forced_close_system_op",$data);
			if ($result) {
				 $this->db->where('id',$data['tripping_id']);
				 $this->db->update($this->planned_outages_table,array('status'=>3));
			return [
					'status'=>true,
					'message'=>"Successfull!"
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
		}
	}
	public function get_trippings($closed){
		if ($closed==0) {
			$this->db->select('t.id as tripping_id,f.*,t.*,c.name as component_name');
			$this->db->from('trippings t');
			$this->db->join("components c","c.id=t.component_id",'left');
			$this->db->join("fault_indicators f","f.id=t.fault_ind_id");
			
			$this->db->where('t.closed',$closed);
		} else {
			$this->db->select('t.id as tripping_id,t.*,f.*,a.name as al_name,a.phone as phone,a.remarks as al_remarks,a.created_at as al_created,c.personnel,c.materials,c.completed_at,c.remarks as c_remarks,fa.name as cause_fault,com.name as component_name');
			$this->db->from('trippings t');
			$this->db->join("components com","com.id=t.component_id",'left');
			$this->db->join("fault_indicators f","f.id=t.fault_ind_id");
			$this->db->join("fault_causes fa","fa.id=t.fault_cause_id","left");
			$this->db->join("allocate_trippings a","a.tripping_id=t.id","left");
			$this->db->join("closed_trippings c","c.tripping_id=t.id","left");

		}		
		$this->db->order_by('t.id','DESC');
		$query=$this->db->get();
		
		return $query->result();
	}
	public function get_unallocated_trippings(){
		$this->db->select('t.id as tripping_id,t.*,f.*,c.name as component_name');
		$this->db->from('trippings t');
		$this->db->join("components c","c.id=t.component_id",'left');
		//$this->db->join("feeder_stations fs","fs.feeder_id=t.feeder_id");
		$this->db->join("fault_indicators f","f.id=t.fault_ind_id");
		$this->db->where("t.allocated",0);
		$query=$this->db->get();
		return $query->result();
		
	}

	//this gets trippings that causes of fault has not been entered.
	public function get_cause_trippings(){
		$this->db->select('t.id as tripping_id,t.*,f.*,c.name as component_name');
		$this->db->from('trippings t');
		$this->db->join("components c","c.id=t.component_id",'left');
		//$this->db->join("feeder_stations fs","fs.feeder_id=t.feeder_id");
		$this->db->join("fault_indicators f","f.id=t.fault_ind_id");
		$this->db->order_by("t.id","DESC");
		$this->db->where(array("t.caused"=>0,"t.closed"=>0));
		
		$query=$this->db->get();
		return $query->result();
	}
	public function get_open_trippings(){
	$this->db->select('t.id as tripping_id,t.*,f.*,c.name as component_name,fa.name as cause_fault');
	$this->db->from('trippings t');
	$this->db->join("components c","c.id=t.component_id",'left');
	//$this->db->join("feeder_stations fs","fs.feeder_id=t.feeder_id");
	$this->db->join("fault_indicators f","f.id=t.fault_ind_id");
	$this->db->join("fault_causes fa","fa.id=t.fault_cause_id",'left');
	$this->db->where("t.closed",0);
	$this->db->order_by("t.id","DESC");
	$query=$this->db->get();
	return $query->result();
	
	}

	public function get_trippings_nm(){
	$this->db->select('t.id as tripping_id,t.*,f.*,c.name as component_name,fa.name as cause_fault');
	$this->db->from('trippings t');
	$this->db->join("components c","c.id=t.component_id",'left');
	//$this->db->join("feeder_stations fs","fs.feeder_id=t.feeder_id");
	$this->db->join("fault_indicators f","f.id=t.fault_ind_id");
	$this->db->join("fault_causes fa","fa.id=t.fault_cause_id",'left');
	$this->db->where("t.id not in (select tripping_id from close_network_maintainace)",null,false);
	$this->db->order_by("t.id","DESC");
	$query=$this->db->get();
	return $query->result();
	
	}
	public function get_trippings_nso(){
	$this->db->select('t.id as tripping_id,t.*,f.*,c.name as component_name,fa.name as cause_fault,nm.*');
	$this->db->from('trippings t');
	$this->db->join("components c","c.id=t.component_id",'left');
	//$this->db->join("feeder_stations fs","fs.feeder_id=t.feeder_id");
	$this->db->join("fault_indicators f","f.id=t.fault_ind_id");
	$this->db->join("fault_causes fa","fa.id=t.fault_cause_id",'left');
	$this->db->join("close_network_maintainace nm","nm.tripping_id=t.id");
	$this->db->where("t.status",2);
	$this->db->order_by("t.id","DESC");
	$query=$this->db->get();
	return $query->result();
	
	}
	public function get_trippings_dso(){
	$this->db->select('t.id as tripping_id,t.*,f.*,c.name as component_name,fa.name as cause_fault,nm.*');
	$this->db->from('trippings t');
	$this->db->join("components c","c.id=t.component_id",'left');
	//$this->db->join("feeder_stations fs","fs.feeder_id=t.feeder_id");
	$this->db->join("fault_indicators f","f.id=t.fault_ind_id");
	$this->db->join("fault_causes fa","fa.id=t.fault_cause_id",'left');
	$this->db->join("close_network_maintainace nm","nm.tripping_id=t.id");
	$this->db->where("t.id in (select tripping_id from close_network_maintainace) and t.id not in (select tripping_id from forced_close_dso)",null,false);
	$this->db->order_by("t.id","DESC");
	$query=$this->db->get();
	return $query->result();
	
	}
	public function get_tripping_id($tripping_id){
		$this->db->where('id',$tripping_id);
		$query=$this->db->get($this->planned_outages_table);
		return $query->row();
	}
	public function update_fault($tripping_id,$data){
		$this->db->where('id',$tripping_id);
		$result=$this->db->update($this->planned_outages_table,$data);
		if ($result) {
			return [
					'status'=>true,
					'message'=>"Fault/tripping has been edited"
				];
		} else {
			return [
					'status'=>false,
					'message'=>"oops! unable to edited"
				];
		}
		
	}
	

	public function get_feeder_id($feeder_id){
		$this->db->select('*');
		$this->db->from('feeder_stations');
		if ($feeder_id!="all") {
			$this->db->where('feeder_id',$feeder_id);
			// $query=$this->db->get();
			// return $query->result();
		// }else{
		// 	$this->db->where('feeder_id',$feeder_id);
		// 	$query=$this->db->get();
		// 	return $query->result();
		// }
		}
		$query=$this->db->get();
		return $query->result();
	}
	public function get_assets($type,$asset_id){
		switch ($type) {
			case 'TS':
				if ($asset_id=="") {
					$this->db->select("tsname as name");
					$this->db->from("transmission_stations");
				}else{
					$this->db->distinct();
					$this->db->select("asset_name as name");
					
					$this->db->from("trippings");
					$this->db->where("asset_name",$asset_id);
				}
				break;
			case 'ISS':
				if ($asset_id=="") {
					$this->db->select("ISS as name");
					$this->db->from("feeder_hiarachy");
				}else{
					$this->db->distinct();
					$this->db->select("asset_name as name");
					
					$this->db->from("trippings");
					$this->db->where("asset_name",$asset_id);
				}
				
				break;
			case 'feeder_11':
				if ($asset_id=="") {
					$this->db->select("feeder_name as name");
					$this->db->from("feeder_stations");
					$this->db->where("station_type","ISS");
				}else{
					$this->db->distinct();	
					$this->db->select("asset_name as name");	
					$this->db->from("trippings");
					$this->db->where("asset_name",$asset_id);
				}
				break;
			case 'feeder_33':
				if ($asset_id=="") {
					$this->db->select("feeder_name as name");
					$this->db->from("feeder_stations");
					$this->db->where("station_type","TS");
				}else{
					$this->db->distinct();	
					$this->db->select("asset_name as name");	
					$this->db->from("trippings");
					$this->db->where("asset_name",$asset_id);
				}
				break;
			case 'dtr':
				if ($asset_id=="") {
					$this->db->select("transformer_name as name");
					$this->db->from("dtr_records");
					
				}else{
					$this->db->distinct();	
					$this->db->select("asset_name as name");	
					$this->db->from("trippings");
					$this->db->where("asset_name",$asset_id);
				}
				break;
			default:
				# code...
				break;
		}
		$query=$this->db->get();
		return $query->result();
		
	}
	public function get_all_feeders(){
		$this->db->select('*');
		$this->db->from('feeder_stations');
		$query=$this->db->get();
		return $query->result();
	}

	// public function get_number_fault($fault_id,$feeder_id,$start_date,$end_date){
	// 	$this->db->select('COUNT(feeder_id) as num_feeder');
	// 	$this->db->from($this->planned_outages_table);
	// 	$this->db->where(array('fault_id'=>$fault_id,'feeder_id'=>$feeder_id,'DATE(created_at) BETWEEN '.$start_date. ' and '.$end_date ));
	// 	return $this->db->get()->row();
	// }
	public function get_number_fault($fault_id,$name,$start_date,$end_date){
		$this->db->select('COUNT(asset_name) as num_feeder');
		$this->db->from($this->planned_outages_table);
		$this->db->where(array('fault_id'=>$fault_id,'asset_name'=>$name,'DATE(created_at) BETWEEN '.$start_date. ' and '.$end_date ));
		return $this->db->get()->row();
	}
	public function get_number_interrupt_fault($fault_id,$name,$start_date,$end_date){
		$this->db->select('COUNT(asset_name) as num_feeder');
		$this->db->from($this->planned_outages_table);
		$this->db->where(array('power_interruption_id'=>$fault_id,'asset_name'=>$name,'DATE(created_at) BETWEEN '.$start_date. ' and '.$end_date ));
		return $this->db->get()->row();
	}


	// public function report($input){
	// 	//var_dump($data);
	// 	$data='<thead><tr>';
	// 	$data.='<th>Feeder</th>';
	// 	foreach ($this->get_fault_reasons() as $key => $reason) {
	// 		$data.='<th>';
	// 		$data.=$reason->name;
	// 		$data.='</th>';
	// 	}

	// 	$data.='</tr></thead><tbody>';
	// 	//get feeders
	// 	foreach ($this->get_feeder_id($input['feeder_id']) as $key => $feeder) {
	// 		$data.='<tr>';
	// 		$data.='<td>'.$feeder->feeder_name.'</td>';
			
	// 		foreach ($this->get_fault_reasons() as $key => $reason) {
	// 			$data.='<td>';
	// 			//get the number of fault_causes for a feeder
	// 			$data.=$this->get_number_fault($reason->id,$feeder->feeder_id,$input['start_date'],$input['end_date'])->num_feeder;
	// 			$data.='</td>';
	// 		}
	// 		$data.='</tr>';	
	// 	}
	// 	$data.='</tbody>';

	// 	return $data;
	// }
	public function report($input){
		//var_dump($data);
		$data='<thead><tr>';
		$data.='<th><div>Name</div></th>';
		foreach ($this->get_fault_interrupt($input['fault_id']) as $key => $reason) {
			$data.='<th><div>';
			$data.=$reason->name;
			$data.='</div></th>';
		}

		$data.='</tr></thead><tbody>';
		//get feeders
		foreach ($this->get_assets($input['type'],$input['asset_id']) as $key => $asset) {
			$data.='<tr>';
			$data.='<td>'.$asset->name.'</td>';
			
			foreach ($this->get_fault_interrupt($input['fault_id']) as $key => $reason) {
				$data.='<td>';
				//get the number of fault_causes for a feeder
				$data.=$this->get_number_fault($reason->id,$asset->name,$input['start_date'],$input['end_date'])->num_feeder;
				$data.='</td>';
			}
			$data.='</tr>';	
		}
		$data.='</tbody>';

		return $data;
	}

	public function interruption_report($input){
		//var_dump($data);
		$data='<thead><tr>';
		$data.='<th>Name</th>';
		foreach ($this->get_fault_reasons($input['fault_id']) as $key => $reason) {
			$data.='<th>';
			$data.=$reason->name;
			$data.='</th>';
		}

		$data.='</tr></thead><tbody>';
		//get feeders
		foreach ($this->get_assets($input['type'],$input['asset_id']) as $key => $asset) {
			$data.='<tr>';
			$data.='<td>'.$asset->name.'</td>';
			foreach ($this->get_fault_reasons($input['fault_id']) as $key => $reason) {
				$data.='<td>';
				//get the number of fault_causes for a feeder
				$data.=$this->get_number_interrupt_fault($reason->id,$asset->name,$input['start_date'],$input['end_date'])->num_feeder;
				$data.='</td>';
			}
			$data.='</tr>';	
		}
		$data.='</tbody>';

		return $data;
	}

	public function get_search_iss($data){
		$this->db->select(array('ISS','ISS_ID'));
		$this->db->like('ISS',$data['term'],"both");
		$this->db->from('feeder_hiarachy');
		$this->db->order_by('ISS');
		return $this->db->get()->result();
	}
	public function get_search_ts($data){
		$this->db->select(array('tsname','tsid'));
		$this->db->like('tsname',$data['term'],"both");
		$this->db->from('transmission_stations');
		$this->db->order_by('tsname');
		return $this->db->get()->result();
	}
	public function get_search_dtr($data){
		$this->db->select(array('transformer_name','DTRId'));
		$this->db->like('transformer_name',$data['term'],"both");
		$this->db->from('dtr_records');
		$this->db->order_by('transformer_name');
		return $this->db->get()->result();
	}
	public function get_assets_type($type){
		if ($type=="ISS") {
			$this->db->select('ISS as name');
			$this->db->from('feeder_hiarachy');
		} elseif($type=="TS") {
			$this->db->select('tsname as name');
			$this->db->from('transmission_stations');
		}elseif ($type=="feeder_11") {
			$this->db->select('feeder_name as name');
			$this->db->from('feeder_stations');
			$this->db->where('station_type','ISS');
		}elseif ($type=="feeder_33") {
			$this->db->select('feeder_name as name');
			$this->db->from('feeder_stations');
			$this->db->where('station_type','TS');
		}elseif ($type=="dtr") {
			$this->db->select('transformer_name as name');
			$this->db->from('dtr_records');
			
		}
		return $this->db->get()->result();
	}
	public function get_search_feeder($data){
		$this->db->select(array('feeder_name','feeder_id'));
		$this->db->like('feeder_name',$data['term']);
		if ($data['type']=="feeder_11") {
			$this->db->where('station_type',"ISS");
		}elseif ($data['type']=="feeder_33") {
			$this->db->where('station_type',"TS");
		}
		
		$this->db->from('feeder_stations');
		return $this->db->get()->result();
	}
	public function get_components(){
		$this->db->from('components');
		return $this->db->get()->result();
	}
	public function get_fault_inidcators_by_id($component_id){
		$this->db->from('fault_indicators');
		$this->db->where('component_id',$component_id);
		return $this->db->get()->result();
	}
	
}
