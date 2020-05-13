<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * this is model for planned outages
 */
class Planned_model extends CI_Model
{
	protected $planned_outages_table="planned_outages";
	protected $fault_cause_table="fault_causes";
	protected $fault_interrupt_table="fault_interrupts";
	//protected $allocate_table="allocate_trippings";
	//protected $close_table="closed_trippings";

	
	public function request_outage($data){
		$result=$this->db->insert($this->planned_outages_table,$data);
			if ($result) {
			return [
					'status'=>true,
					'message'=>"Planned outage requested is successfully..."
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
		}
	}
	// public function allocate_tripping($data){
	// 	$result=$this->db->insert($this->allocate_table,$data);
	// 		if ($result) {
	// 			$this->db->where('id',$data['tripping_id']);
	// 			$this->db->update($this->planned_outages_table,array('allocated'=>1));
	// 		return [
	// 				'status'=>true,
	// 				'message'=>"Allocaction is successful!"
	// 			];
	// 	} else {
	// 		return [
	// 				'status'=>false,
	// 				'message'=>$this->db->error
	// 			];
	// 	}
	// }
	// public function closure_nm_post($data){
	// $result=$this->db->insert("close_network_maintainace",$data);
	// 		if ($result) {
	// 			 $this->db->where('id',$data['tripping_id']);
	// 			 $this->db->update($this->planned_outages_table,array('status'=>1));
	// 		return [
	// 				'status'=>true,
	// 				'message'=>"Successfull!"
	// 			];
	// 	} else {
	// 		return [
	// 				'status'=>false,
	// 				'message'=>$this->db->error
	// 			];
	// 	}
	// }
	
	
	public function get_outage_reasons(){
		$this->db->from("reason_outages");
		$query=$this->db->get();
		return $query->result();
	}
	public function get_fault_causes(){
		$this->db->from("fault_causes");
		$query=$this->db->get();
		
		return $query->result();
	}

	public function get_outage_oro($data){
		$this->db->select("planned_outages.*,oro.first_name as oro_f,oro.last_name as oro_l,ph.first_name as ph_f,ph.last_name as ph_l,oro.designation as oro_desig,transm.tsname as transmission,iss.iss_names as iss_name,trans.names_trans as transformer,fd.feeder_name as feeder_name,transmN.tsname as transmissionN,issN.iss_names as iss_nameN,transfN.names_trans as transformerN,reason.name as reason");
		$this->db->from($this->planned_outages_table);
		//$this->db->join("fault_indicators fa","fa.id=planned_outages.fault_indicator");
		$this->db->join("users oro","oro.id=planned_outages.created_by");
		$this->db->join("users ph","ph.id=planned_outages.permit_holder_id");
		$this->db->join("transmissions transm","planned_outages.equipment_id=transm.id and planned_outages.category='Transmission station'", 'left',FALSE);
		$this->db->join("reason_outages reason","planned_outages.reason=reason.id ");
		$this->db->join("iss_tables iss","planned_outages.equipment_id=iss.id and planned_outages.category='Injection substation'", 'left',FALSE);
		$this->db->join("transformers trans","planned_outages.equipment_id=trans.id and planned_outages.category='Transformer'", 'left',FALSE);
		$this->db->join("feeders fd","planned_outages.equipment_id=fd.id and planned_outages.category='Feeder' ", 'left',FALSE);
		 $this->db->join(" transmissions transmN","planned_outages.station_id=transmN.id and planned_outages.voltage_level='33kv'", 'left',FALSE);
		 $this->db->join(" transformers transfN","planned_outages.transformer_id=transfN.id and planned_outages.transformer_id !='' ", 'left',FALSE);
		 $this->db->join(" iss_tables issN","planned_outages.station_id=issN.id and planned_outages.voltage_level ='11kv' ", 'left',FALSE);
		 // $this->db->join(" feeders fdN","planned_outages.feeder_id=fd.id and planned_outages.voltage_level !='11kv' ", 'left',FALSE);

		// if ($data['type']=="tsm") {
		// 	$this->db->where('request_from',"ibc");
		// }
		// if (isset($data['request_from'])) {
		// 	$this->db->where('request_from',"hq");
		// }
		 $this->db->where('planned_outages.created_by',$data['user_id']);
		$this->db->order_by('id','DESC');
		$query=$this->db->get();
		return $query->result();
	}
	public function get_outage_all($data){
		$this->db->select("planned_outages.*,oro.first_name as oro_f,oro.last_name as oro_l,ph.first_name as ph_f,ph.last_name as ph_l,oro.designation as oro_desig,transm.tsname as transmission,iss.iss_names as iss_name,trans.names_trans as transformer,fd.feeder_name as feeder_name,transmN.tsname as transmissionN,issN.iss_names as iss_nameN,transfN.names_trans as transformerN,reason.name as reason");
		$this->db->from($this->planned_outages_table);
		//$this->db->join("fault_indicators fa","fa.id=planned_outages.fault_indicator");
		$this->db->join("users oro","oro.id=planned_outages.created_by");
		$this->db->join("users ph","ph.id=planned_outages.permit_holder_id");
		$this->db->join("transmissions transm","planned_outages.equipment_id=transm.id and planned_outages.category='Transmission station'", 'left',FALSE);
		$this->db->join("reason_outages reason","planned_outages.reason=reason.id ");
		$this->db->join("iss_tables iss","planned_outages.equipment_id=iss.id and planned_outages.category='Injection substation'", 'left',FALSE);
		$this->db->join("transformers trans","planned_outages.equipment_id=trans.id and planned_outages.category='Transformer'", 'left',FALSE);
		$this->db->join("feeders fd","planned_outages.equipment_id=fd.id and planned_outages.category='Feeder' ", 'left',FALSE);
		 $this->db->join(" transmissions transmN","planned_outages.station_id=transmN.id and planned_outages.voltage_level='33kv'", 'left',FALSE);
		 $this->db->join(" transformers transfN","planned_outages.transformer_id=transfN.id and planned_outages.transformer_id !='' ", 'left',FALSE);
		 $this->db->join(" iss_tables issN","planned_outages.station_id=issN.id and planned_outages.voltage_level ='11kv' ", 'left',FALSE);
		 // $this->db->join(" feeders fdN","planned_outages.feeder_id=fd.id and planned_outages.voltage_level !='11kv' ", 'left',FALSE);

		$this->db->where($data);
		// if (isset($data['request_from'])) {
		// 	$this->db->where('request_from',"hq");
		// }
		$this->db->order_by('id','DESC');
		$query=$this->db->get();
		return $query->result();
	}

	//get all details from outage request
	public function get_outage($outage_id){
		
			$this->db->select('planned_outages.*,oro.first_name as oro_fname,oro.last_name oro_lname,oro.email as oro_email,dispatch.first_name as dispatch_fname,dispatch.last_name dispatch_lname,dso.first_name as dso_fname,dso.last_name dso_lname,permit_holder.first_name as permit_holder_fname,permit_holder.last_name as permit_holder_lname,tsm.first_name as tsm_fname,tsm.last_name as tsm_lname,rea.name as reason, feeder_manager.first_name as fd_fname,feeder_manager.last_name as fdlname,hso.first_name as hso_fname,hso.last_name as hsolname,htsup.first_name as hts_fname,htsup.last_name as hts_lname,htcor.first_name as htcor_fname,htcor.last_name as htcor_lname, transm.tsname as transmission,iss.iss_names as iss_name,rejected.first_name as reject_fname,rejected.last_name as reject_lname,trans.names_trans as transformer,fd.feeder_name as feeder_name,transmN.tsname as transmissionN,issN.iss_names as iss_nameN,transfN.names_trans as transformerN ');
			$this->db->from($this->planned_outages_table);
			$this->db->join("reason_outages rea","rea.id=planned_outages.reason");
			//joined users table
			$this->db->join("users oro","oro.id=planned_outages.created_by");
			$this->db->join("users permit_holder","permit_holder.id=planned_outages.permit_holder_id");

			$this->db->join("users tsm","tsm.id=planned_outages.tsm_id",'left',false);
			$this->db->join("users feeder_manager","feeder_manager.id=planned_outages.hibc_id",'left',false);
			$this->db->join("users dispatch","dispatch.id=planned_outages.cd_id",'left',false);
			$this->db->join("users hso","hso.id=planned_outages.hso_id",'left',false);
			$this->db->join("users dso","dso.id=planned_outages.tso_id",'left',false);
			$this->db->join("users htsup","htsup.id=planned_outages.ht_sup_id",'left',false);
			$this->db->join("users htcor","htcor.id=planned_outages.ht_cord_id",'left',false);
			$this->db->join("users rejected","rejected.id=planned_outages.reject_by_id",'left',false);
			$this->db->join("transmissions transm","planned_outages.equipment_id=transm.id and planned_outages.category='Transmission station'", 'left',FALSE);
		//$this->db->join("reason_outages reason","planned_outages.reason=reason.id ");
		$this->db->join("iss_tables iss","planned_outages.equipment_id=iss.id and planned_outages.category='Injection substation'", 'left',FALSE);
		$this->db->join("transformers trans","planned_outages.equipment_id=trans.id and planned_outages.category='Transformer'", 'left',FALSE);
		$this->db->join("feeders fd","planned_outages.equipment_id=fd.id and planned_outages.category='Feeder' ", 'left',FALSE);
		 $this->db->join(" transmissions transmN","planned_outages.station_id=transmN.id and planned_outages.voltage_level='33kv'", 'left',FALSE);
		 $this->db->join(" transformers transfN","planned_outages.transformer_id=transfN.id and planned_outages.transformer_id !='' ", 'left',FALSE);
		 $this->db->join(" iss_tables issN","planned_outages.station_id=issN.id and planned_outages.voltage_level ='11kv' ", 'left',FALSE);

			$this->db->where('outage_id',$outage_id);	
			$query=$this->db->get();
		
		return $query->row();
	}
	public function outage($outage_id){
		$this->db->where('outage_id',$outage_id);	
		$query=$this->db->get($this->planned_outages_table);
		return $query->row();
	}
	
	
	public function acknowled_plan_out_tsm($outage_id,$data){
		$this->db->where('outage_id',$outage_id);
		$result=$this->db->update($this->planned_outages_table,$data);
		if ($result) {
			return [
					'status'=>true,
					'message'=>"Acknowlegment is successful... Notification sent to HIBC"
				];
		} else {
			return [
					'status'=>false,
					'message'=>"oops! something went wrong"
				];
		}
		
	}
	public function approve_plan_out_hibc($outage_id,$data){
		$this->db->where('outage_id',$outage_id);
		$result=$this->db->update($this->planned_outages_table,$data);
		if ($result) {
			return [
					'status'=>true,
					'message'=>"Approval is successful... Notification sent to Central Dispactch"
				];
		} else {
			return [
					'status'=>false,
					'message'=>"oops! something went wrong"
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
	


	
}
