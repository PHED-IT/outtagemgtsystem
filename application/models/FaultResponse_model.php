<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * this is model for planned outages
 */
class FaultResponse_model extends CI_Model
{
	protected $fault_response_table="fault_responses";
	protected $boq_table="boq";
	

	
	public function request_outage($data){
		$result=$this->db->insert($this->fault_response_table,$data);
			if ($result) {
			return [
					'status'=>true,
					'message'=>"Captured successfully..."
				];
		} else {
			return [
					'status'=>false,
					'message'=>$this->db->error
				];
		}
	}
	public function get_outage_userid($data){
		$this->db->select("fault_responses.*,tr.transformer as transformer");
		$this->db->from($this->fault_response_table);
		$this->db->join("transmission_transformer tr","tr.id=fault_responses.transformer");
		$this->db->where('created_by',$data['user_id']);
		
		$this->db->order_by('id','DESC');
		$query=$this->db->get();
		
		return $query->result();
	}

	public function get_latest_fault(){

		$this->db->from($this->fault_response_table);
		//$this->db->join("transmission_transformer tr","tr.id=fault_responses.transformer");
		$this->db->where(['voltage_level'=>"11kv","date_closed"=>null]);
		
		$this->db->order_by('id','DESC');
		$query=$this->db->get();
		
		return $query->row();
	}
	public function get_outages($data){
		$this->db->select("fault_responses.*,fa.indicator as indicator,transm.tsname as transmission,iss.iss_names as iss_name,trans.names_trans as transformer,fd.feeder_name as feeder_name,fd_33.feeder_name as feeder33_name,fd_11.feeder_name as feeder11_name,transmN.tsname as transmissionN,issN.iss_names as iss_nameN,transfN.names_trans as transformerN");
		$this->db->from("fault_responses");
		$this->db->join("fault_indicators fa","fa.id=fault_responses.reason_id");
		//$this->db->join("users oro","oro.id=fault_responses.created_by");
		//$this->db->join("users ph","ph.id=fault_responses.permit_holder_id");
		$this->db->join("transmissions transm","fault_responses.equipment_id=transm.id and fault_responses.category='Transmission station'", 'left',FALSE);
		$this->db->join("iss_tables iss","fault_responses.equipment_id=iss.id and fault_responses.category='Injection substation'", 'left',FALSE);
		$this->db->join("transformers trans","fault_responses.equipment_id=trans.id and fault_responses.category='Transformer'", 'left',FALSE);
		$this->db->join("feeders fd","fault_responses.equipment_id=fd.id and fault_responses.category='Feeder' ", 'left',FALSE);
		$this->db->join("feeders_11kv fd_11","fault_responses.equipment_id=fd_11.id and fault_responses.category='Feeder' and fault_responses.voltage_level='11kv' ", 'left',FALSE);
		$this->db->join("feeders_33kv fd_33","fault_responses.equipment_id=fd_33.id and fault_responses.category='Feeder' and fault_responses.voltage_level='33kv' ", 'left',FALSE);
		 $this->db->join(" transmissions transmN","fault_responses.station_id=transmN.id and fault_responses.voltage_level='33kv'", 'left',FALSE);
		 $this->db->join(" transformers transfN","fault_responses.transformer_id=transfN.id and fault_responses.transformer_id !='' ", 'left',FALSE);
		 $this->db->join(" iss_tables issN","fault_responses.station_id=issN.id and fault_responses.voltage_level !='33kv' ", 'left',FALSE);
		 // $this->db->join(" feeders fdN","planned_outages.feeder_id=fd.id and planned_outages.voltage_level !='11kv' ", 'left',FALSE);

		// if ($data['type']=="tsm") {
		// 	$this->db->where('request_from',"ibc");
		// }
		// if (isset($data['request_from'])) {
		// 	$this->db->where('request_from',"hq");
		// }
		 $this->db->where($data);
		$this->db->order_by('id','DESC');
		$query=$this->db->get();
		return $query->result();
	}

	public function get_search_materials($data){
		//$this->db->select(array('ISS','ISS_ID'));
		$this->db->like('name',$data['search'],"both");
		$this->db->from('materials');
		$this->db->order_by('id');
		return $this->db->get()->result();
	}

	public function get_outage($outage_id){
		$this->db->from($this->fault_response_table);
		$this->db->where('outage_id',$outage_id);
		$query=$this->db->get();
		return $query->row();
	}
	public function get_outage_report($outage_id){
		
		$this->db->from($this->fault_response_table);
		$this->db->join("users oro","oro.id=fault_responses.lines_man_id");
		$this->db->where('outage_id',$outage_id);
	
	
		$query=$this->db->get();
		
		return $query->row();
	}

	public function get_fault_indicators(){
		
		return $this->db->get("fault_indicators")->result();
	}

	public function get_boq($outage_id){
			$this->db->select("m.id as id,b.id as bid,m.name as name,m.cost as cost,b.available as available,b.quantity as quantity ,b.aval_quantity as aval_quantity,b.unit as unit,b.remark as remark");
			$this->db->from("boq b");
			$this->db->join("materials m ","m.name=b.item");
			$this->db->where('outage_id',$outage_id);
		
		
		$query=$this->db->get();
		
		return $query->result();
	}
	public function materials(){
		
		$this->db->from("materials");
			
		$query=$this->db->get();
		
		return $query->result();
	}
	
	public function acknowledge($outage_id,$data){
		$this->db->where('outage_id',$outage_id);
		$result=$this->db->update($this->fault_response_table,$data);
		if ($result) {
			return [
					'status'=>true,
					'message'=>"Acknowlegment is successful..."
				];
		} else {
			return [
					'status'=>false,
					'message'=>"oops! something went wrong"
				];
		}
		
	}
	// public function store_boq($data){
	// 	//$this->db->where('outage_id',$outage_id);
	// 	$count_item=count($data['item']);
	// 	for ($i=0; $i <$count_item ; $i++) { 
	// 		$item=$data['item'][$i];
	// 		//$quantity=$data['quantity'][$i];
	// 		//$remark=$data['remark'][$i];
			
	// 		if(!empty($item)){
	// 			$result=$this->db->insert($this->boq_table,array("item"=>strtoupper($item),"created_by"=>$data['created_by'],"outage_id"=>$data['outage_id']));
	// 		}
	// 	}
	// 	if ($result) {
	// 		//update fault response table
	// 		$this->db->where('outage_id',$data['outage_id']);
	// 	$this->db->update($this->fault_response_table,["status"=>4,"status_message"=>"BOQ prepared...Waiting for AGM NM approval"]);

	// 		$this->db->insert("boq_remark",array("remark"=>$data['remark'],"outage_id"=>$data['outage_id']));
	// 		return [
	// 				'status'=>true,
	// 				'message'=>"Success!"
	// 			];
	// 	} else {
	// 		return [
	// 				'status'=>false,
	// 				'message'=>$this->db->error
	// 			];
	// 	}
		
	// }


	public function store_boq($data){
		//$this->db->where('outage_id',$outage_id);
		$count_item=count($data['item']);
		for ($i=0; $i <$count_item ; $i++) { 
			$item=$data['item'][$i];
			$quantity=$data['quantity'][$i];
			$unit=$data['unit'][$i];
			$remark=$data['remark'][$i];
			
			if(!empty($quantity)){
				$result=$this->db->insert($this->boq_table,array("item"=>$item,"unit"=>$unit,"quantity"=>$quantity,"remark"=>$remark,"created_by"=>$data['created_by'],"outage_id"=>$data['outage_id']));
			}
		}
		if ($result) {
			//update fault response table
			$this->db->where('outage_id',$data['outage_id']);
		$this->db->update($this->fault_response_table,["status"=>4,"status_message"=>"BOQ prepared...Waiting for AGM NM approval"]);

			//$this->db->insert("boq_remark",array("remark"=>$data['remark'],"outage_id"=>$data['outage_id']));
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

	public function approve_boq_material($data){
		//$this->db->where('outage_id',$outage_id);
		$count_item=count($data['quantity']);
		
		// if (!isset($data['available'])) {
		// 	return ["status"=>false,"message"=>"Select available materials"];
		// }
		//return ["status"=>false,"message"=>$count_item];
		for ($i=0; $i <$count_item ; $i++) { 
			$boq_id=$data['boq_id'][$i];
			$quantity=$data['quantity'][$i];
			//return ["status"=>false,"message"=>$boq_id];
			//if (in_array($boq_id, $data['available'])) {
				//return ["status"=>false,"message"=>"y"];
				//$available=$data['available'][$i];
				$this->db->where('id',$boq_id);
				$result=$this->db->update($this->boq_table,array("available"=>1,"aval_quantity"=>$quantity));
			//}
			//return ["status"=>false,"message"=>"n"];
			// else{
			// 	//$notavailable=$data['available'][$i];
			// 	$this->db->where('id',$boq_id);
			// 	$result=$this->db->update($this->boq_table,array("available"=>0));
			// }
			// return ["status"=>false,"message"=>"no"];
			// //$item=$data['item'][$i];
			// //$total_amount=$price*$quantity;
			// if (isset($data['available'][$i])) {
			// 	$boq_id=$data['boq_id'][$i];
			// 	$this->db->where('id',$boq_id);
			// 	$result=$this->db->update($this->boq_table,array("available"=>1));
			//  } 
			// 	//else {

			// 	$this->db->where('id',$boq_id);
			// 	$result=$this->db->update($this->boq_table,array("available"=>0));
			// }
			
			
			
		}
		if ($result) {
			//update fault response table
			$this->db->where('outage_id',$data['outage_id']);
		$this->db->update($this->fault_response_table,["status"=>6,"status_message"=>"BOQ Materials Approved...Waiting for GM Technical approval","store_manager_id"=>$data['store_manager_id'],"store_manager_ack_date"=>date('Y-m-d H:i:s')]);
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
	public function update_boq($boq_id,$data){
		
		//$this->db->where('outage_id',$outage_id);
	
		$this->db->where('id',$boq_id);
				$result=$this->db->update($this->boq_table,array("item"=>$data['item'],"quantity"=>$data['quantity'],"unit"=>$data['unit'],"remark"=>$data['remark']));
		if ($result) {
			//update fault response table
			

			// $this->db->insert("boq_remark",array("remark"=>$data['remark'],"outage_id"=>$data['outage_id']));
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

	public function total_price($outage_id){
		$this->db->select_sum('total_amount','total_amount');
		$this->db->where('outage_id',$outage_id);
		
		
		
		$query=$this->db->get($this->boq_table);
		
		return $query->row();
		
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
