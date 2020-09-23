<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Mis_model extends MY_Model
// class Mis_model extends CI_Model
{
	protected $ibc_table_name="feederIbc";
	protected $log_sheet_table="log_sheet";
	protected $energy_log_sheet_table="energy_log_sheet";
	protected $transmission_table="transmission_stations";
	protected $feeder_hiarachy_table="feeder_hiarachy";
	protected $fault_cause_table="fault_causes";
	protected $fault_indicator_table="fault_indicators";
	
	//protected $transmission_transformer_table="transmission_transformer";     
	
	public function get_log_sheet($data){
		//var_dump($data);
		 list($month,$year)=$this->substr_date($data['date']);
		$type=strtolower($data['type']);
		// $this->db->select_max($type,"peak");
		// $this->db->select_avg($type,"average");
		$this->db->select(array($type,'hour','captured_at','status'));
		// $this->db->select(array($type,'hour','captured_at','status',"Max($type) as peak" ,"AVG($type) as average"));
		if ($data['dt']=="month") {
			$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		} else {
			$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		}
		// $this->db->where(array('MONTH(created_at)'=>$month,'YEAR(created_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		 $this->db->join("feeders",'feeders.id = log_sheet.feeder_id');
		$query=$this->db->get($this->log_sheet_table);
		return $query->result();
		// $dif=$this->get_reading_first-
		
	}

	protected function get_num_feeder_status_log($data,$status){
		//var_dump($data);
		 list($month,$year)=$this->substr_date($data['date']);
		$type=strtolower($data['type']);
		$this->db->select('*');
		if ($data['dt']=="month") {
			$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id'],"status"=>$status,"isIncommer"=>0));
		} else {
			$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"status"=>$status,"isIncommer"=>0));
		}
		// $this->db->where(array('MONTH(created_at)'=>$month,'YEAR(created_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		
		$query=$this->db->get($this->log_sheet_table);
		return $query->num_rows();
		// $dif=$this->get_reading_first-
		
	}
	public function show_feeder_status($data){
		$out="";
		$status=$this->get_feeder_status();
		foreach ($status as $key => $value) {
         
          $out.= '<span ><span class="text-info font-weight-bold">'.$value->names. ':</span> <span class="font-weight-bold">'.$this->get_num_feeder_status_log($data,$value->abbr).'</span> <span class="text-warning"> | </span></span>';
         
        }
        return $out;
	}

		public function get_energy_log_sheet($data){
		//var_dump($data);
		 list($month,$year)=$this->substr_date($data['date']);
		
		$this->db->select(array("energy",'hourly_comsumption','hour','captured_at'));
				if ($data['dt']=="month") {
			$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		} else {
			$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		}
		// $this->db->where(array('MONTH(created_at)'=>$month,'YEAR(created_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		 $this->db->join("feeders",'feeders.id = energy_log_sheet.feeder_id');
		$query=$this->db->get($this->energy_log_sheet_table);
		return $query->result();
		// $dif=$this->get_reading_first-
		
	}

	public function get_feeders_by_zone_voltage($data){
		if ($data['voltage_level']=="33kv") {
			$this->db->select("feeders_33kv.*,transmissions.zone_id ");
		$this->db->from("transmissions");
		$this->db->join("fault_responses ","fault_responses.station_id=transmissions.id and fault_responses.voltage_level='33kv'");
		$this->db->join("zones ","zones.id=transmissions.zone_id");
		$this->db->join("feeders_33kv ","feeders_33kv.id=fault_responses.equipment_id");
		$this->db->where(["zones.id"=>$data['zone_id'],'fault_responses.date_closed'=>null]);
		$this->db->group_by("fault_responses.equipment_id");
		$query=$this->db->get();
		return $query->result();
		}else{
			//11kv violage
			$this->db->select("feeders_11kv.*,feeder33kv_iss.zone_id ");
		$this->db->from("feeder33kv_iss");
		$this->db->join("fault_responses ","fault_responses.station_id=feeder33kv_iss.iss_id and voltage_level='11kv'");
		$this->db->join("feeders_11kv ","feeders_11kv.id=fault_responses.equipment_id");
		$this->db->where(["feeder33kv_iss.zone_id"=>$data['zone_id'],'fault_responses.date_closed'=>null]);
		$this->db->group_by("fault_responses.equipment_id");
		$query=$this->db->get();
		return $query->result();
		}
	}
		public function get_energy_consumption_log_sheet($data){
		//var_dump($data);
		 list($month,$year)=$this->substr_date($data['date']);
		
		$this->db->select(array("hourly_comsumption",'hour','captured_at'));
				if ($data['dt']=="month") {
			$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		} else {
			$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		}
		// $this->db->where(array('MONTH(created_at)'=>$month,'YEAR(created_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		 $this->db->join("feeders",'feeders.id = energy_log_sheet.feeder_id');
		$query=$this->db->get($this->energy_log_sheet_table);
		return $query->result();
		// $dif=$this->get_reading_first-
		
	}
	public function get_reading_avg($data){
		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d H:i:s",strtotime($custom_date));
		$type=strtolower($data['type']);
		list($month,$year)=$this->substr_date($data['date']);
		
		$this->db->select_avg($data['type']);

		if ($data['dt']=="month") {
			$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id'],'isIncommer'=>0));
		} else {
			$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],'isIncommer'=>0));
		}
		if ($data['type']=="energy") {
			$query=$this->db->get($this->energy_log_sheet_table);
		} else {
			$query=$this->db->get($this->log_sheet_table);
		}
		
		// $this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		//$this->db->group_by("feeder_name");
		

		return $query->row();
	}
	public function get_reading_max($data,$weather=""){
		//var_dump($data);
		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d H:i:s",strtotime($custom_date));
		list($month,$year)=$this->substr_date($data['date']);
		
		$type=$data['type'];
		if ($data['type']=="energy") {
			$this->db->select(array($data['type'],'captured_at',"hour",'hourly_comsumption'));
			$table=$this->energy_log_sheet_table;
		} else {
			$this->db->select(array($data['type'],'hour','captured_at'));
			$table=$this->log_sheet_table;
		}

		if ($data['dt']=="month") {
			//$this->db->select(array($data['type'],'captured_at',"hour"));
			
			if ($weather=="day") {

				if (isset($data['incommer'])) {
					$incommer=$data['incommer'];
				$this->db->where("{$type}=(SELECT MAX({$type}) from log_sheet where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and isIncommer=$incommer and feeder_id='".$data['feeder_id']."' AND hour >=".$data['day_start']." AND hour<=".$data['day_end'].")");
				} else {
					//feeder
				$this->db->where("{$type}=(SELECT MAX({$type}) from log_sheet where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}'  and feeder_id='".$data['feeder_id']."' AND hour >=".$data['day_start']." AND hour<=".$data['day_end'].")");
				}
				
				
				
			}elseif ($weather=="night") {
				if (isset($data['incommer'])) {
					$incommer=$data['incommer'];
					$this->db->where("{$type}=(SELECT MAX({$type}) from log_sheet where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and isIncommer=$incommer and feeder_id='".$data['feeder_id']."' AND hour >=".$data['night_start']." AND hour<=".$data['night_end'].")");
				} else {
					# feeder
			$this->db->where("{$type}=(SELECT MAX({$type}) from log_sheet where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and feeder_id='".$data['feeder_id']."' AND hour >=".$data['night_start']." AND hour<=".$data['night_end'].")");
				}
			}else{
				//feeder
				$this->db->where("{$type}=(SELECT MAX({$type}) from $table where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and feeder_id='".$data['feeder_id']."')");
			}
		} else {
			//day
			
			$this->db->where("{$type}=(SELECT MAX({$type}) from $table where captured_at='".$data['date']."' and feeder_id='".$data['feeder_id']."')");
			}
		
		// $this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		//$this->db->group_by("feeder_name");
		if ($data['type']=="energy") {
			$query=$this->db->get($this->energy_log_sheet_table);
		} else {
			$query=$this->db->get($this->log_sheet_table);
		}
		return $query->row();
	}
	public function get_reading_min($data){
		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d H:i:s",strtotime($custom_date));
		list($month,$year)=$this->substr_date($data['date']);
		$type=$data['type'];
		if ($data['type']=="energy") {
			$this->db->select(array($data['type'],'captured_at',"hour",'hourly_comsumption'));
			$table=$this->energy_log_sheet_table;
		} else {

			$this->db->select(array($data['type'],'captured_at',"hour"));
			$table=$this->log_sheet_table;
		}
		if ($data['dt']=="month") {
			
			$this->db->where("$type=(SELECT MIN($type) from $table where MONTH(captured_at)='".$month."' AND YEAR(captured_at)='".$year."' and feeder_id='".$data['feeder_id']."')");
			$this->db->where(array("MONTH(captured_at)"=>$month,"YEAR(captured_at)"=>$year,"feeder_id"=>$data['feeder_id']));
		} else {
			//day
			//$this->db->select(array($data['type'],'hour'));
			$this->db->where("$type=(SELECT MIN($type) from $table where captured_at='".$data['date']."' and feeder_id='".$data['feeder_id']."')");
			$this->db->where(array("captured_at"=>$data['date'],"feeder_id"=>$data['feeder_id']));
			}
		if ($data['type']=="energy") {
			$query=$this->db->get($this->energy_log_sheet_table);
		} else {
			$query=$this->db->get($this->log_sheet_table);
		}
		return $query->row();
	}

	public function get_reading_mode($data){

		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d H:i:s",strtotime($custom_date));
		list($month,$year)=$this->substr_date($data['date']);
		$type=$data['type'];
		$this->db->select($type.' as mode');	
		if ($data['dt']=="month") {
			$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id']));
		} else {
			$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id']));
		}
		$this->db->group_by($type);
		$this->db->order_by("count(*) DESC");
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}

	//get the latest hours entry entered for a day
	public function get_latest_hour_logged($data){
		$this->db->select(["hour","created_at"]);
		$this->db->where(array('voltage_level'=>$data["voltage_level"]));
		$this->db->order_by("id DESC");
		return $this->db->get("log_sheet")->row();

	}

	public function latest_entry_status(){
		$this->db->select('log_sheet.*,transmissions.tsname as tsname,iss_tables.iss_names as iss,transformers.names_trans as transformer,users.first_name as first_name,users.last_name as last_name,feeders.feeder_name as feeder')->from($this->log_sheet_table);
		
		$this->db->join("transmissions","transmissions.id=log_sheet.station_id and log_sheet.voltage_level='33kv'",'left',FALSE);
		$this->db->join("iss_tables","iss_tables.id=log_sheet.station_id and log_sheet.voltage_level='11kv'",'left',FALSE);
		$this->db->join("transformers","transformers.id=log_sheet.feeder_id and log_sheet.isIncommer=1" );
		$this->db->join("feeders","feeders.id=log_sheet.feeder_id");
		
		$this->db->join("users","users.id=log_sheet.created_by");
		//$this->db->group_by("transformers.id");
		//$this->db->where('log_sheet.isIncommer',0);
		$this->db->limit(20);
		$this->db->order_by("log_sheet.captured_at DESC");
		$query=$this->db->get();
		return $query->result();
	}
	public function latest_entry_status_station(){
		$this->db->select('log_sheet.station_id,log_sheet.captured_at,iss_tables.iss_names as iss,')->from($this->log_sheet_table);
		
		
		$this->db->join("iss_tables","iss_tables.id=log_sheet.station_id and log_sheet.voltage_level='11kv'");
	$this->db->group_by("station_id");
		//$this->db->where('log_sheet.isIncommer',0);
		// $this->db->limit(20);
		// $this->db->order_by("log_sheet.captured_at DESC");
		$query=$this->db->get();
		return $query->result();
	}
	
	// public function get_feeders(){
	// 	$this->db->select(array('feeder_id'));
	// 	$this->db->group_by('feeder_id');
	// 	$query=$this->db->get($this->log_sheet_table);

	// 	return $query->result();
	// }
	public function get_33kvfeeders_by_zone($zone_id){
		$this->db->from("feeders_33kv");
		//$query=$this->db->get("feeders_33kv");
		$this->db->join("feeder33_zones fed","fed.feeder_id=feeders_33kv.id and zone_id=$zone_id");
		$query=$this->db->get();
		return $query->result();
	}

	public function get_feeder_status(){
		$this->db->select(array('abbr','names'));
		$query=$this->db->get("feeder_status");
		return $query->result();
	}
	//this gets fault that are not transmission
	public function get_station_fault(){
		$this->db->select(array('abbr','names'));
		$this->db->where('trx',0);
		$query=$this->db->get("feeder_status");
		return $query->result();
	}

	
	
	
	public function get_station_type($type){
		if ($type=="TS") {
			return $this->get_transmission_stations();
		} else {
			return $this->get_iss();
		}
		
		// $this->db->distinct('feeder_name');
		// $this->db->select('feeder_name');
		// $this->db->where('station_type',$type);
		// $query=$this->db->get("log_sheet");
		// //$query=$this->db->group_by("feeder_name");
		// return $query->result();
	}
	public function get_iss_id($iss_id){
		$this->db->select('ISS');
		$this->db->where('ISS_ID',$iss_id);
		$query=$this->db->get($this->feeder_hiarachy_table);
		return $query->row();
	}
	public function get_all_customers(){
		$this->db->select(['feeder_name','Customer_Coord','feederID']);
		$this->db->where('Customer_Coord !=', null);
		$query=$this->db->get('customers_by_feeders');
		
		return $query->result();
	}
	public function get_ts_id($ts_id){
		$this->db->select('tsname');
		$this->db->where('tsid',$ts_id);
		$query=$this->db->get($this->transmission_table);
		return $query->row();
	}

	public function get_open_faults(){
		$this->db->select('fed.enum_id');
		$this->db->from("fault_responses");
		$this->db->join("feeders_11kv fed","fed.id=fault_responses.equipment_id and fault_responses.voltage_level=11");
		$this->db->where('fault_responses.date_closed IS NULL',null, false);
		
		
		$query=$this->db->get();
		
		return $query->result();

	}
	public function get_fualt_feeder_by_iss($station_id){
		$this->db->select('*');
		$this->db->from("fault_responses");
		
		$this->db->where(['station_id'=>$station_id,"voltage_level"=>"11kv","status <"=>7]);
		
		
		$query=$this->db->get();
		
		return $query->num_rows();

	}
	public function get_iss_on_fault(){
		$this->db->select('DISTINCT(station_id)');
		$this->db->from("fault_responses");
		$this->db->where(["voltage_level"=>"11kv","status <"=>7]);
		$query=$this->db->get();
		return $query->result();

	}
	// this convert result to array
	public function get_log_sheet_array($data){
		 list($month,$year)=$this->substr_date($data['date']);
		$type=strtolower($data['type']);
		$this->db->select(array($type,'hour','captured_at'));
		if ($data['dt']=="month") {
			$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		} else {
			$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		}
		$this->db->order_by("hour ASC");
		$query=$this->db->get($this->log_sheet_table);
		 return $query->result_array();
	}

	public function get_energy_sheet_array($data){
		 list($month,$year)=$this->substr_date($data['date']);
		
		$this->db->select(array('energy','hourly_comsumption','hour','captured_at'));
		if ($data['dt']=="month") {
			$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id']));
		} else {
			$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id']));
		}
		$this->db->order_by("hour ASC");
		$query=$this->db->get($this->energy_log_sheet_table);
		return $query->result_array();
	}

	private function get_sum_daily_consumption($data,$day){
		list($month,$year)=$this->substr_date($data['date']);
		$this->db->select_sum("hourly_comsumption",'sum');
		$this->db->where(array("feeder_id"=>$data['feeder_id'],"captured_at"=>date("Y-m-d",strtotime($year.'-'.$month.'-'.$day))));
		return $this->db->get($this->energy_log_sheet_table)->row_array();
		// return date("Y-m-d",strtotime($year.'-'.$month.'-'.$day));
	}
	//this is for month year subsr date function
	private function substr_date($date){
		$month=substr($date, 0,2);
		$year=substr($date, 3,6);
		return array($month,$year);
	}
	private function get_reading_day_last($data,$day){
		list($month,$year)=$this->substr_date($data['date']);
		//$day=$day+1;
		$this->db->select($data['type']);
		$this->db->where(array("feeder_id"=>$data['feeder_id'],"hour"=>0,"captured_at"=>$year.'-'.$month.'-'.$day));
		return $this->db->get("log_sheet")->row_array();
	}

	public function get_energy_consumption_chart_data($data){
		//$array=array();
		$type=$data['type'];
		$array_result=$this->get_energy_sheet_array($data);
		$size=sizeof($array_result);
		if ($size<2) {
			return [];
		}
		if ($data['dt']=="day") {
			for ($i=0; $i <$size ; $i++) { 
			// $diff=$array_result[$i+1][$type]-$array_result[$i][$type];
			// $arr[]=["label"=>$i+1,"y"=>$diff];
				
			$arr[]=["x"=>(int)$array_result[$i]["hour"],"y"=>(float)$array_result[$i]["hourly_comsumption"]];
		}
		return $arr;
		} elseif($data['dt']=="month") {
			
		for ($d=1; $d <sizeof($this->get_day_date($data['date'])); $d++) { 
			// $diff=$this->get_reading_day_first($data,$d)[$data['type']]-$this->get_reading_day_last($data,$d)[$data['type']];
		
			$arr[]=["x"=>(int)$d,"y"=>(float)$this->get_sum_daily_consumption($data,$d)['sum']];
			
		}
		
		}
		return $arr;
	}
	private function sum_daily_reading($data,$day){
		list($month,$year)=$this->substr_date($data['date']);
		//$day=$day+1;
		if ($data['type']=="energy") {
			$this->db->select_avg($data['type'],'sum');
		} else {
			$this->db->select_sum($data['type'],'sum');
		}
		
		
		$this->db->where(array("isIncommer"=>0,"feeder_id"=>$data['feeder_id'],"captured_at"=>$year.'-'.$month.'-'.$day));
		return $this->db->get("log_sheet")->row_array();
	}

	private function peak_daily_reading($data,$day){
		list($month,$year)=$this->substr_date($data['date']);
		//$day=$day+1;
		if ($data['type']=="energy") {
			$this->db->select_avg($data['type'],'sum');
		} else {
			$this->db->select_max($data['type'],'peak');
		}
		$this->db->where(array("isIncommer"=>0,"feeder_id"=>$data['feeder_id'],"captured_at"=>$year.'-'.$month.'-'.$day));
		return $this->db->get("log_sheet")->row_array();
	}

	//this is for load maximum
	public function getTransformerByTS($transid){
		$this->db->select("id as assetid,names_trans as name,1 as incommer ");
		$this->db->where(array('trans_id' => $transid));
		$query1=$this->db->get_compiled_select("transformers",FALSE);
		//$this->db->union_push('transformers');
		$this->db->reset_query();

		$this->db->select("id as assetid ,feeder_name as name,0 as incommer");
		$this->db->where(array('station_id' => $transid,"voltage_level"=>"33kv"));
		
		$query2=$this->db->get_compiled_select("feeders",FALSE);
		$this->db->reset_query();
		$query = $this->db->query("$query1 UNION $query2");
		return $query->result();	
	}

	 public function getFeederByTransformer($transid){
		$this->db->select("id as assetid,feeder_name as name,0 as incommer ");
		$this->db->where(array('transformer_id' => $transid));
		$query=$this->db->get("feeders_33kv");
	
		return $query->result();	
	 }
	// public function getTransformerByTS($transid){
	// 	$this->db->select("id as assetid,names_trans as name,1 as incommer ");
	// 	$this->db->where(array('trans_id' => $transid));
	// 	$query1=$this->db->get_compiled_select("transformers",FALSE);
	// 	//$this->db->union_push('transformers');
	// 	$this->db->reset_query();

	// 	$this->db->select("id as assetid ,feeder_name as name,0 as incommer");
	// 	$this->db->where(array('station_id' => $transid));
		
	// 	$query2=$this->db->get_compiled_select("feeders_33kv",FALSE);
	// 	$this->db->reset_query();
	// 	$query = $this->db->query("$query1 UNION $query2");
	// 	return $query->result();	
	// }

	public function get_transmission($trans_id){
		$this->db->from("transmissions");
		//$this->db->join("users oro","oro.id=fault_responses.lines_man_id");
		$this->db->where('id',$trans_id);
		$query=$this->db->get();	
		return $query->row();
	}
	public function get_substation($iss_id){
		$this->db->from("iss_tables");
		//$this->db->join("users oro","oro.id=fault_responses.lines_man_id");
		$this->db->where('id',$iss_id);
		$query=$this->db->get();	
		return $query->row();
	}
	// public function load_maximum($data){
	// 	$out='';
	// 	$out='<thead>
 //                            <th>Name of feeder</th>
 //                            <th>Day Peak(0.00-17:00)</th>
 //                            <th>Night Peak(18.00-23:00)</th>
 //                            <th>Month max</th>

 //                        </thead>';
	// 	$out.="<tbody>";
	// 	foreach ($this->getTransformerByTS($data['trans_st']) as $key => $value) {
	// 		$dayPeak=$this->get_reading_max(["date"=>$data['date'],"feeder_id"=>$value->assetid,"dt"=>"month","type"=>"load_reading","incommer"=>$value->incommer],$weather="day");
	// 		//var_dump($value);
	// 		$nightPeak=$this->get_reading_max(["date"=>$data['date'],"feeder_id"=>$value->assetid,"dt"=>"month","type"=>"load_reading","incommer"=>$value->incommer],$weather="night");
	// 		$out.="<tr>";

	// 		$out.="<td>";
	// 		if ($value->incommer==1) {
	// 			$out.="<span class='font-weight-bold'>".$value->name."</span>";
	// 		} else {
	// 			$out.=$value->name;
	// 		}
			
			
	// 		$out.="</td>";
	// 		$out.="<td>";
	// 		$out.=(isset($dayPeak)&&!empty($dayPeak))?'<span class="text-success">'.$dayPeak->load_reading."</span> | ".$dayPeak->hour.":00 |<span class='text-info'>".$dayPeak->captured_at."</span>":'-';
	// 		$out.="</td>";
	// 		$out.="<td>";
	// 		$out.=(isset($nightPeak)&&!empty($nightPeak))?'<span class="text-success">'.$nightPeak->load_reading."</span> | ".$nightPeak->hour.":00 |<span class='text-info'>".$nightPeak->captured_at."</span>":'-';
	// 		$out.="</td>";
	// 		$out.="<td style='background:#033999;color:#ffffff'>";
	// 		if (isset($nightPeak)&&!empty($nightPeak)) {
	// 			if ($nightPeak->load_reading>$dayPeak->load_reading) {
	// 				$out.=$nightPeak->load_reading;
	// 			} else {
	// 				$out.=$dayPeak->load_reading;
	// 			}
				
	// 		}else{
	// 			$out.="-";
	// 		}
	// 		$out.="</td>";
	// 		$out.="</tr>";
	// 	}
	// 	$out.="</tbody>";
	// 	return $out;
	// }
	//this function returns total load feeder wise / transformer wise by month
	public function get_total_load_feeder($data){
		list($month,$year)=$this->substr_date($data['date']);
		$this->db->select_sum('load_reading');
		$this->db->from($this->log_sheet_table);
		
		$this->db->where(['isIncommer'=>0,'MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year]);
		$query=$this->db->get();	
		return $query->row();
	}

public function get_total_load_transformer($data){
		list($month,$year)=$this->substr_date($data['date']);
		$this->db->select_sum('load_reading');
		$this->db->from($this->log_sheet_table);
		
		$this->db->where(['isIncommer'=>1,'MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year]);
		$query=$this->db->get();	
		return $query->row();
	}
	public function total_load($data){
		$out='';
		$out.='<tr>';
		$out.='<td style="background-color: #6777ef;color: #fff">';
		$out.=$this->get_total_load_transformer($data)->load_reading;
		$out.='</td>';
		$out.='<td style="background-color: #6777ef;color: #fff">';
		$out.=$this->get_total_load_feeder($data)->load_reading;
		$out.='</td>';
		$out.='</tr>';
		return $out;
	}
	
	
	public function load_maximum($data){
		$transformer_sum=0;
		$feeder_sum=0;
		$out='';
		$out='<tr>
		
		<th rowspan="4">TRX S/S  132/33/11KV T/S</th>
                            <th ></th>
                            
                            <th colspan="7"><center>MAXIMUM LOAD</center></th>
                            
                            <td></td>
</tr>
<tr>

<th rowspan="3" ><center>NAME</center></th>
<th rowspan="3" ><center>Type</center></th>
<th colspan="3"><center>Day Peak('. $this->format_hour($data['day_start']).'-'.$this->format_hour($data['day_end']).')</center></th>
<th colspan="3"><center>Night Peak('. $this->format_hour($data['night_start']).'-'.$this->format_hour($data['night_end']).')</center></th>

<td></td>

                            
</tr/>
<th>LOAD</th>
<th>TIME</th>
<th>DATE(DAY)</th>
<th style=" text-align: right;">LOAD</th>
<th>TIME</th>
<th>DATE(DAY)</th>
<th>MAX LOAD</th>
<tr>

</tr>
                        </thead>';
		$out.="<tbody>";
		foreach ($this->get_transmission_stations() as $key => $station) {
			$out.='<tr>';
			$span=count($this->getTransformerByTS($station->id))+1;
			$out.='<th rowspan="'.$span.'" style="text-align:center">'.$station->tsname.'</th>';
		
		foreach ($this->getTransformerByTS($station->id) as $key => $value) {
			$dayPeak=$this->get_reading_max(["date"=>$data['date'],"feeder_id"=>$value->assetid,"dt"=>"month","type"=>"load_reading","incommer"=>$value->incommer,"day_start"=>$data['day_start'],"day_end"=>$data['day_end'],"night_start"=>$data['night_start'],"night_end"=>$data['night_end']],$weather="day");
			//var_dump($value);
			$nightPeak=$this->get_reading_max(["date"=>$data['date'],"feeder_id"=>$value->assetid,"dt"=>"month","type"=>"load_reading","incommer"=>$value->incommer,"day_start"=>$data['day_start'],"day_end"=>$data['day_end'],"night_start"=>$data['night_start'],"night_end"=>$data['night_end']],$weather="night");
			$out.="<tr>";

			
			if ($value->incommer==1) {
				$out.='<td style="background-color: #6777ef;color: #fff;text-align: right;">';
				$out.="<span class='font-weight-bold;text-align: right;'>".$value->name."</span>";
				$out.="</td>";
			} else {
				$out.="<td style='text-align: right;'>";
				$out.=$value->name;
				$out.="</td>";
			}
			
			
			
				if ($value->incommer==1) {
					$out.='<td style="background-color: #6777ef;color: #fff;text-align: right;">';
				$out.="<span class='font-weight-bold;text-align: right; '>Transformer</span>";
				$out.="</td>";
			} else {
				$out.="<td style='text-align: right;'>";
				$out.="Feeder";
				$out.="</td>";
			}
			
			if ($value->incommer==1) {

			$out.='<td style="background-color: #6777ef;color: #fff; text-align: right;">';
			$out.=(isset($dayPeak)&&!empty($dayPeak))?$this->format_load($dayPeak->load_reading):'-';
			$out.="</td>";
		}else{
			$out.='<td style=" text-align: right;">';
			$out.=(isset($dayPeak)&&!empty($dayPeak))?$this->format_load($dayPeak->load_reading):'-';
			$out.="</td>";
		}

		if ($value->incommer==1) {

			$out.='<td style="background-color: #6777ef;color: #fff;text-align: right;">';
			$out.=(isset($dayPeak)&&!empty($dayPeak))?$this->format_hour($dayPeak->hour):'-';
			$out.="</td>";
		}
			else{
				$out.='<td  style="text-align: right;">';
			$out.=(isset($dayPeak)&&!empty($dayPeak))?$this->format_hour($dayPeak->hour):'-';
			$out.="</td>";
			}
			if ($value->incommer==1) {
			$out.='<td style="background-color: #6777ef;color: #fff;text-align:right">';
			$out.=(isset($dayPeak)&&!empty($dayPeak))?substr($dayPeak->captured_at, 8):'-';
			$out.="</td>";
		}else{
			$out.='<td style="text-align: right;">';
			$out.=(isset($dayPeak)&&!empty($dayPeak))?substr($dayPeak->captured_at, 8):'-';
			$out.="</td>";
		}
		if ($value->incommer==1) {
			$out.='<td style="background-color: #6777ef;color: #fff; text-align: right;">';
			$out.=(isset($nightPeak)&&!empty($nightPeak))?$this->format_load($nightPeak->load_reading):'-';
			$out.="</td>";
		}else{
			$out.='<td style=" text-align: right;">';
			$out.=(isset($nightPeak)&&!empty($nightPeak))?$this->format_load($nightPeak->load_reading):'-';
			$out.="</td>";
		}
			if ($value->incommer==1) {
			$out.='<td style="background-color: #6777ef;color: #fff;text-align: right;">';
			$out.=(isset($nightPeak)&&!empty($nightPeak))?$this->format_hour($nightPeak->hour):'-';
			$out.="</td>";
		}else{
			$out.='<td style="text-align: right;" >';
			$out.=(isset($nightPeak)&&!empty($nightPeak))?$this->format_hour($nightPeak->hour):'-';
			$out.="</td>";
		}

		if ($value->incommer==1) {
			$out.='<td style="background-color: #6777ef;color: #fff;text-align: right;">';
			$out.=(isset($nightPeak)&&!empty($nightPeak))? substr($nightPeak->captured_at, 8):'-';
			$out.="</td>";
		}else{
			$out.='<td style="text-align: right;">';
			$out.=(isset($nightPeak)&&!empty($nightPeak))? substr($nightPeak->captured_at, 8):'-';
			$out.="</td>";
		}

			$out.="<td style='background:#033999;color:#ffffff;text-align: right;'>";
			if (isset($nightPeak)&&!empty($nightPeak)) {
				if ($nightPeak->load_reading>$dayPeak->load_reading) {
					$out.=$nightPeak->load_reading;
					if ($value->incommer==1) {
					$transformer_sum+=$nightPeak->load_reading;
				}else{
					$feeder_sum+=$nightPeak->load_reading;
				}
				} else {
					$out.=$dayPeak->load_reading;
					if ($value->incommer==1) {
					$transformer_sum+=$nightPeak->load_reading;
				}else{
					$feeder_sum+=$nightPeak->load_reading;
				}
				}
				
			}else{
				$out.="-";
			}
			$out.="</td>";
			$out.="</tr>";
		}
		$out.='</tr>';
		}
		$out.='<tr>';
		$out.='<td colspan="5" style="background-color:#13cfd5;color:#ffffff;font-weight:bold">Total Transformer Load: '.$transformer_sum.'MW</td>';
		$out.='<td colspan="5" style="background-color:#13cfd5;text-align:right;color:#ffffff;font-weight:bold">Total Feeder Load:'.$feeder_sum.'MW</td>';
		$out.='</tr>';
		$out.="</tbody>";

	
		return $out;
	}
	//COINCINDENTAL LOAD

	

	private function get_transmission_by_state($state){ 
		 $this->db->where("state",$state);
		 return $this->db->get("transmissions")->result();
	}
	private function transformer_by_ts($ts_id){ 
		 $this->db->where(array("trans_id"=>$ts_id,"asset_type"=>"TS"));
		 return $this->db->get("transformers")->result();
	}

	private function getzonal_dayorNightPeakByTransmission($data,$weather,$transmission){
		list($month,$year)=$this->substr_date($data['date']);
		$type=$data['type'];
		$this->db->select_sum($type,'sum');
		
		if ($weather=="day") {
		$this->db->where("{$type}=(SELECT MAX({$type}) from log_sheet where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and station_id=$transmission AND isIncommer=1 AND hour >=0 AND hour<=17)");
			//$this->db->where("{$type}=(SELECT MAX({$type}) from log_sheet where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and staion_id=$transmission AND hour >=0 AND hour<=17)");
		} else {
		$this->db->where("{$type}=(SELECT MAX({$type}) from log_sheet where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and station_id=$transmission AND isIncommer=1 AND hour >=18 AND hour<=23)");
		}	
		return $this->db->get($this->log_sheet_table)->row();
	}
	//get the  day peak of all incommer by transmission for a month
	private function getDayorNightPeakByTransmission($data,$hour,$day,$transmission){
		list($month,$year)=$this->substr_date($data['date']);
		$type=$data['type'];
		$this->db->select_sum($type,'peak');
		$this->db->where(array("MONTH(captured_at)"=>$month,"YEAR(captured_at)"=>$year,"DAY(captured_at)"=>$day,"hour"=>$hour,"station_id"=>$transmission,'isIncommer'=>0,"voltage_level"=>"33kv"));
		// if ($weather=="day") {
			
		// 	$this->db->where("hour >=",0);
		// 	$this->db->where("hour <=",17);
		// 	//$this->db->where("{$type}=(SELECT MAX({$type}) from log_sheet where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and staion_id=$transmission AND hour >=0 AND hour<=17)");
		// } else {
		// 	$this->db->where("hour >=",18);
		// 	$this->db->where("hour <=",23);
		// }	
		return $this->db->get($this->log_sheet_table)->row();
	}

	public function get_coincendental_peak_chart($data){
		//$array=array();
		$sumDay=0;
		$sumNight=0;
		foreach ($this->get_states() as $key => $state) {

			foreach ($this->get_transmission_by_state($state->id) as $key => $transmission) {
			$dayPeak=$this->getDayorNightPeakByTransmission($data,"day",$transmission->id)->peak;
           	$nightPeak=$this->getDayorNightPeakByTransmission($data,"night",$transmission->id)->peak;
           	$sumDay+=$dayPeak;
           	//$zonal_day+=$dayPeak;
           	$sumNight+=$nightPeak;
           	
           
            
           }
            $day[]=["label"=>$state->name,"y"=>$sumDay];
            $night[]=["label"=>$state->name,"y"=>$sumNight];
            $sumDay=0;
            $sumNight=0;
		}

		
		
		return [$day,$night];
		
		
	}
	public function coincindental_summary_report($data){
		$dataX=$this->phed_total_load($data);
		//echo $dataX['maxNightDate']; 
		$maxDay=$dataX['maxDay'];
		$maxNight=$dataX['maxNight'];
		$maxDay=$dataX['maxDay'];
		$maxDayHour=$dataX['maxDayHour'];
		$maxDayDate=$dataX['maxDayDate'];
		$maxNightHour=$dataX['maxNightHour'];
		$maxNightDate=$dataX['maxNightDate'];

		// echo $maxDayHour;
		// return;
		$date=$this->day_date("month",$data['month'],$data['year']);
		//var_dump($date);

		//$summary=$this->get_reading_max_by_transmission($data);
		//$out=' <table id="myTable" class="table table-bordered table-responsive" data-toggle="datatables">';
		$zonal_day=0;
		$zonal_night=0;
		$out='';
		 $out.='<tr><th rowspan="2">TRX S/S 132/33/11KV T/S</th>';
		 $out.='<th rowspan="2"><center>POWER  TRANSFORMER RATING/CAPACITY</center></th>';
		 $out.='<th colspan="2"><center>COINCIDENTAL PEAK LOAD(MW)</center></th>';
		 //$out.='<th>NIGHT PEAK LOAD (MW)</th></tr>';
		// $out.='<th rowspan="2">PHED DAY PEAK</th><th rowspan="2">PHED NIGHT PEAK</th>';
		 $out.='<tr>';
		 //$out.='<th rowspan="2"></th>';
		 $out.='<th>DAY PEAK LOAD (MW)- (<small style="color:blue">HOUR: '.$maxDayHour.':00 | DAY: '.$maxDayDate.' | LOAD:'.$maxDay.'</small>)</th>';
		 $out.='<th>NIGHT PEAK LOAD (MW)- (<small style="color:blue">HOUR: '.$maxNightHour.':00 | DAY: '.$maxNightDate.' | LOAD:'.$maxNight.'</small>)</th></tr>';
            $out.="<tbody>";
            
            $sumDay=0;
            $sumNight=0;
          foreach ($this->get_states() as $key => $state) {
             //$out.="<tr>";
             $out.="<tr>";
           $out.='<td colspan="4" class="font-weight-bold"><center>'.$state->name .'</center></td>';
           $out.='</tr>';
             
           foreach ($this->get_transmission_by_state($state->id) as $key => $transmission) {
           	$out.='<tr>';
           	$out.='<td class="font-weight-bold">'.$transmission->tsname.'</td>';
          	 
           	$out.='<td style="text-align:right">';
           	foreach ($this->transformer_by_ts($transmission->id) as $key => $transformer) {
           		$out.=$transformer->names_trans.'<br />';
           	}
           	$out.='</td>';
           	$dayPeak=$this->getDayorNightPeakByTransmission($data,$dataX['maxDayHour'],$dataX['maxDayDate'],$transmission->id)->peak;
           	$nightPeak=$this->getDayorNightPeakByTransmission($data,$dataX['maxNightHour'],$dataX['maxNightDate'],$transmission->id)->peak;
           	$sumDay+=$dayPeak;
           	$zonal_day+=$dayPeak;
           	$sumNight+=$nightPeak;
           	$zonal_night+=$nightPeak;
           	$out.='<td style="text-align:right">'.$dayPeak.'</td>';
           	$out.='<td style="text-align:right">'.$nightPeak.'</td>';
           	$out.='</tr>';
           }
           $out.='<tr style="background:#6777ef;color:#ffffff" class="font-weight-bold">';
           $out.='<td colspan="2">SUB TOTAL '.$state->name.'</td>';
          	$out.='<td>'.$sumDay.'</td>';
           	$out.='<td>'.$sumNight.'</td>';
           $out.='</tr>';
           //$out.="</tr>";
            $sumDay=0;
            $sumNight=0;
         }   
         $out.='<tr style="background:#6777ef;color:#ffffff" class="font-weight-bold">';
           $out.='<td colspan="2">ZONAL PEAK </td>';
          	$out.='<td>'.$zonal_day.'</td>';
           	$out.='<td>'.$zonal_night.'</td>';
           $out.='</tr>';        
         
	$out.="</tbody>";
	return $out;
		
	}

	public function get_reading_max_by_transmission($data,$day,$hour){
		$type=$data['type'];
		list($month,$year)=$this->substr_date($data['date']);
		
		$this->db->select(array("load_reading",'captured_at',"hour","status"));

		$this->db->where("load_reading=(SELECT MAX($type) from log_sheet where MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and hour='".$hour."' and DAY(captured_at)='".$day."' and voltage_level='33kv' and isIncommer=1 and station_id='".$data['trans_id']."' )");
		$this->db->where("MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and hour='".$hour."' and DAY(captured_at)='".$day."' and voltage_level='33kv' and isIncommer=1 and station_id='".$data['trans_id']."' ");
		$query=$this->db->get($this->log_sheet_table);
		
		return $query->row();
	}

	public function get_reading_sum_by_transmission($data,$day,$hour){
		$type=$data['type'];
		list($month,$year)=$this->substr_date($data['date']);
		
		$this->db->select_sum("load_reading");

		$this->db->where(" MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and hour='".$hour."' and DAY(captured_at)='".$day."' and voltage_level='33kv' and isIncommer=0 and station_id='".$data['trans_id']."'");
		
		$query=$this->db->get($this->log_sheet_table);
		
		return $query->row();
	}
	public function phed_total_ts_load($data,$day,$hour){
		//this function 
		$type=$data['type'];
		list($month,$year)=$this->substr_date($data['date']);
		
		$this->db->select_sum("load_reading");

		$this->db->where(" MONTH(captured_at)='{$month}' AND YEAR(captured_at)='{$year}' and hour='".$hour."' and DAY(captured_at)='".$day."' and voltage_level='33kv' and isIncommer=0 ");
		
		$query=$this->db->get($this->log_sheet_table);
		
		return $query->row();
	}

	//GET THE SUMMATION OF ALL FEEDER LOAD FOR TX
	public function summation_transmission_load($data){
		$date=$this->day_date("month",$data['month'],$data['year']);
		//var_dump($date);
		$out='';
		//$summary=$this->get_reading_max_by_transmission($data);
		//$out=' <table id="myTable" class="table table-bordered table-striped table-responsive" data-toggle="datatables">';
		 $out.='<thead><tr><th>Hour</th>';
            
          foreach ($date as $key => $day) {
             
           $out.='<th>'.$day .'</th>';
            
         }           
         $out.= '</tr>
          </thead>';
         $out.='<tbody>';
            for ($hour=0; $hour <=23 ; $hour++) { 
        $out.='<tr><td style="background: #556080;color: #ffffff"><strong>';
        $out.= $this->format_hour($hour);
        $out.='</strong> </td>';

        foreach ($date as $key =>  $day) {
            
        $out.="<td>";
            
        $report=$this->get_reading_sum_by_transmission($data,$key+1,$hour);
                        //if is monthly
           
                       if (isset($report)) {
                       	 $out.= $report->load_reading;
                      
                       } else {
                       	$out.='-';
                       }
                         
               $out.="</td>";
                }
                
                //for hourly peak
              
               
                         
               $out.="</tr>";       
	}
	$out.="</tbody>";
	return $out;  	
	}


	//get phed total for all transmission station
	public function phed_total_load($data){
		$date=$this->day_date("month",$data['month'],$data['year']);
		//var_dump($date);
		$out='';
		//$summary=$this->get_reading_max_by_transmission($data);
		//$out=' <table id="myTable" class="table table-bordered table-striped table-responsive" data-toggle="datatables">';
		$maxDay=0;
		$maxNight=0;
		$maxDayHour;
		$maxDayDate;

		$maxNight=0;
		
		$maxNightHour;
		$maxNightDate;
		 $out.='<thead><tr><th>Hour</th>';
            
          foreach ($date as $key => $day) {
             
           $out.='<th>'.$day .'</th>';
            
         }           
         $out.= '</tr>
          </thead>';
         $out.='<tbody>';
            for ($hour=0; $hour <=23 ; $hour++) { 
        $out.='<tr><td style="background: #556080;color: #ffffff"><strong>';
        $out.= $this->format_hour($hour);
        $out.='</strong> </td>';

        foreach ($date as $key =>  $day) {
            
        $out.="<td>";
         
        $report=$this->phed_total_ts_load($data,$key+1,$hour);
                        //if is monthly
           		if ($report->load_reading>=$maxDay && $hour>=0 && $hour<=17) {
           			$maxDay=$report->load_reading;
           			$maxDayHour=$hour;
           			$maxDayDate=$key+1;
           		}

           		if ($report->load_reading>=$maxNight && $hour>=18 && $hour<=23) {
           			$maxNight=$report->load_reading;
           			$maxNightHour=$hour;
           			$maxNightDate=$key+1;
           		}
                       if (isset($report)) {
                       //	if ($maxDay==$report->load_reading) {
                       		$out.= '<span style="colour:green;font-weight:bold">'.$report->load_reading.'</span>';
                       	// }elseif($maxNight==$report->load_reading) {
                       	// 	$out.= '<span style="colour:green;font-weight:bold">'.$report->load_reading.'</span>';
                       	// }
                       	// else{

                       	//  $out.= '<span style="font-weight:normal">'.$report->load_reading.'</span>';
                       	// }

                      
                       } else {
                       	$out.='-';
                       }
                         
               $out.="</td>";
                }
                
                //for hourly peak
              
               
                         
               $out.="</tr>";       
	}
	$out.="</tbody>";
	$out.='<tfoot><tr><th>Hour</th>';
            
          foreach ($date as $key => $day) {
             
           $out.='<th>'.$day .'</th>';
            
         }           
         $out.= '</tr>
          </tfoot>';
	return array("table_data"=>$out,"maxDay"=>$maxDay,"maxDayHour"=>$maxDayHour,"maxDayDate"=>$maxDayDate,"maxNight"=>$maxNight,"maxNightHour"=>$maxNightHour,"maxNightDate"=>$maxNightDate);
	}

	public function feederTransformerByStation($data){
		
		if ($data['voltage_level']=="33kv") {
			$this->db->select('transformers.id as transformer_id,transformers.names_trans,feeders_33kv.*');
		$this->db->from('transformers');
			$this->db->join('feeders_33kv','feeders_33kv.transformer_id=transformers.id',"left",false);
		
		$this->db->where(['feeders_33kv.station_id'=>$data['station_id']]);
		} else {
			$this->db->select('transformers.id as transformer_id,transformers.names_trans,feeders.*');
		$this->db->from('transformers');
			$this->db->join('feeders_11kv','feeders_11kv.transformer_id=transformers.id',"left",false);
		
		$this->db->where(['feeders_11kv.station_id'=>$data['station_id']]);
		}
		
		
		$query=$this->db->get();
		//print_r($query->result());
		return $query->result();


	}
	public function feederTransformerByVoltage($data){
		$this->db->select('transformers.id as transformer_id,transformers.names_trans,feeders.*');
		$this->db->from('transformers');
		$this->db->join('feeders','feeders.transformer_id=transformers.id',"left",false);
		
		$this->db->where(['feeders.voltage_level'=>$data['voltage_level']]);
		$query=$this->db->get();
		//print_r($query->result());
		return $query->result();
	}

	//get all day peak for a month for a feeder

	public function logSheetTable($data,$month,$year,$dt){
		$date=$this->day_date($dt,$month,$year);
		//var_dump($date);
		$type=$data['type'];
		$summary=$this->get_log_sheet($data);
		$out=' <table id="myTable" class=" table-bordered table-striped table-responsive" data-toggle="datatables">';
		 $out.='<thead><tr><th>Hour</th>';
            
          foreach ($date as $key => $day) {
             
           $out.='<th>'.$day .'</th>';
            
         }           
         $out.= '<th>Hourly Peak</th><th>Hourly Average</th></tr>
          </thead>';
         $out.='<tbody>';
            for ($hour=0; $hour <=23 ; $hour++) { 
        $out.='<tr><td style="background: #556080;color: #ffffff"><strong>';
        $out.= $hour==0?'00':$hour;
        $out.='</strong> </td>';

        foreach ($date as $key =>  $day) {
            
        $out.="<td>";
            
        foreach ($summary as $report) {
                   
          if ($dt=="month") {
                        //if is monthly
            if ($report->hour==$hour && date("d",strtotime($report->captured_at))==$key+1) {
                       
              $out.= ($report->status=="on")?$report->$type:"<span class='text-info'>".$report->status."</span></strong> ";
                      
                    } 
                    } else {
                        //is a day
                       if ($report->hour==$hour && date("d",strtotime($report->captured_at))==substr($day, 4)) {
                       
                       $out.= ($report->status=="on")?$report->$type:"<span class='text-info font-weight-bold'>".$report->status."</span></strong> ";
                    } 
                    }  
                     
                   }
                   
               $out.="</td>";
                }
                
                //for hourly peak
               $out.='<td style="background: #556080;color: #ffffff">';
              
              
                   
              if ($dt=="month") {
                        //if is monthly
            
                       
                      $out.= "<span class='text-success'>".$this->hourly_peak_reading($data,$hour)['peak']."</span>";
                     
                    } else {
                        //is a day
                      $out.= "-";         
                    } 
                        
               $out.="</td>";
               //for avg
               $out.='<td style="background: #556080;color: #ffffff">';
              
                   
              if ($dt=="month") {
                        //if is monthly
              
                       
                      $out.= "<span class='text-success'>".round($this->hourly_avg_reading($data,$hour)['avg'],2)."</span>";
                    
                    } else {
                        //is a day
                      $out.= "-";         
                    } 
                         
               $out.="</td></tr>";
                 
         
	}
	$out.="</tbody></table>";
	return $out;
	}

	public function day_date($dt,$month,$year){
	$start_date = "01-".$month."-".$year;
	$start_time = strtotime($start_date);

	$end_time = strtotime("+1 ".$dt, $start_time);

	for($i=$start_time; $i<$end_time; $i+=86400)
		{
		   $list[] = date('D-d', $i);
		}
		return $list;
}

	public function hourly_peak_reading($data,$hour="",$weather=""){
		list($month,$year)=$this->substr_date($data['date']);
		//$day=$day+1;
		$this->db->select_max($data['type'],'peak');
		if ($weather=="day") {
			$this->db->where(array("feeder_id"=>$data['feeder_id'],'MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'isIncommer'=>0));
			$this->db->where("hour >=",0);
			$this->db->where("hour <=",17);
		}elseif ($weather=="night") {
			$this->db->where(array("feeder_id"=>$data['feeder_id'],'MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'isIncommer'=>0));
			$this->db->where("hour >=",18);
			$this->db->where("hour <=",23);
		}elseif (isset($data['isIncommer'])&&$data['isIncommer']==1) {
			$this->db->where(array("station_id"=>$data['trans_id'],'MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,"hour"=>$hour,"isIncommer"=>1,"voltage_level"=>"33kv"));
		} else {
			$this->db->where(array("feeder_id"=>$data['feeder_id'],'MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,"hour"=>$hour,'isIncommer'=>0));
		}	
		return $this->db->get("log_sheet")->row_array();
	}

	public function hourly_avg_reading($data,$hour="",$weather=""){
		list($month,$year)=$this->substr_date($data['date']);
		//$day=$day+1;
		$this->db->select_avg($data['type'],'avg');
		if ($weather=="day") {
			$this->db->where(array("feeder_id"=>$data['feeder_id'],'MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'isIncommer'=>0));
			$this->db->where("hour >=",0);
			$this->db->where("hour <=",17);
		}elseif ($weather=="night") {
			$this->db->where(array("feeder_id"=>$data['feeder_id'],'MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'isIncommer'=>0));
			$this->db->where("hour >=",18);
			$this->db->where("hour <=",23);
		} else {
			$this->db->where(array("feeder_id"=>$data['feeder_id'],'MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,"hour"=>$hour,'isIncommer'=>0));
		}	
		return $this->db->get("log_sheet")->row_array();
	}
	


	private function min_daily_reading($data,$day){
		list($month,$year)=$this->substr_date($data['date']);
		//$day=$day+1;
		if ($data['type']=="energy") {
			$this->db->select_avg($data['type'],'sum');
		} else {
			$this->db->select_min($data['type'],'min');
		}
		
		
		$this->db->where(array("feeder_id"=>$data['feeder_id'],"captured_at"=>$year.'-'.$month.'-'.$day));
		return $this->db->get("log_sheet")->row_array();
	}

	private function avg_daily_reading($data,$day){
		list($month,$year)=$this->substr_date($data['date']);
		//$day=$day+1;
		if ($data['type']=="energy") {
			$this->db->select_avg($data['type'],'sum');
		} else {
			$this->db->select_avg($data['type'],'avg');
		}
		
		
		$this->db->where(array("feeder_id"=>$data['feeder_id'],"captured_at"=>$year.'-'.$month.'-'.$day));
		return $this->db->get("log_sheet")->row_array();
	}

	

	public function get_hourly_chart_data($data){
		//$array=array();
		$type=$data['type'];
		$arr=array();
		$array_result=$this->get_log_sheet_array($data);
		//var_dump($array_result);
		$size=sizeof($array_result);
		if ($data['dt']=="day") {
			for ($i=0; $i <$size ; $i++) { 
			$recx=$array_result[$i][$type];
			$arr[]=["x"=>(int)$array_result[$i]["hour"],"y"=>(float)$recx];
		}
	
		}
		return $arr;
		//  elseif($data['dt']=="month") {
			
		// 	for ($d=1; $d <sizeof($this->get_day_date($data['date']))+1; $d++) { 
		// 	$recx=$this->sum_daily_reading($data,$d)['sum'];
		// 	$arr[]=["y"=>(float)$recx];
		// }
		// }
		
	}

	public function get_sum_monthly_chart_data($data){
		//$array=array();
		$type=$data['type'];
		$array_result=(array)$this->get_log_sheet($data);
		$size=sizeof($array_result);
		
		if($data['dt']=="month") {
			
			for ($d=1; $d <sizeof($this->get_day_date($data['date']))+1; $d++) { 
			$recx=$this->sum_daily_reading($data,$d)['sum'];
			$arr[]=["y"=>(float)$recx];
		}
		return $arr;
		}else{
			return [];
		}
		
	}

	public function get_peak_chart_data($data){
		//$array=array();
		$type=$data['type'];
		$array_result=(array)$this->get_log_sheet($data);
		$size=sizeof($array_result);
		
		if($data['dt']=="month") {
			
			for ($d=1; $d <sizeof($this->get_day_date($data['date']))+1; $d++) { 
			$recx=$this->peak_daily_reading($data,$d)['peak'];
			$arr[]=["x"=>$d,"y"=>(float)$recx];
		}
		return $arr;
		}else{
			return [];
		}
		
	}

	public function get_hourly_peak_chart_data($data){
		//$array=array();
		$type=$data['type'];
		$array_result=(array)$this->get_log_sheet($data);
		$size=sizeof($array_result);
		
		if($data['dt']=="month") {

			for ($h=0; $h <24 ; $h++) { 
			 
			$recx=$this->hourly_peak_reading($data,$h)['peak'];
			$arr[]=["x"=>$h,"y"=>(float)$recx];
			
		}
			
		return $arr;
		}else{
			return [];
		}	
	}

	public function get_hourly_avg_chart_data($data){
		//$array=array();
		$type=$data['type'];
		$array_result=(array)$this->get_log_sheet($data);
		$size=sizeof($array_result);
		
		if($data['dt']=="month") {

			for ($h=0; $h <24 ; $h++) { 
			 
			$recx=$this->hourly_avg_reading($data,$h)['avg'];
			$arr[]=["x"=>$h,"y"=>(float)$recx];
			
		}
			
		return $arr;
		}else{
			return [];
		}	
	}


		public function get_min_chart_data($data){
		//$array=array();
		$type=$data['type'];
		$array_result=(array)$this->get_log_sheet($data);
		$size=sizeof($array_result);
		
		if($data['dt']=="month") {
			
			for ($d=1; $d <sizeof($this->get_day_date($data['date']))+1; $d++) { 
			$recx=$this->min_daily_reading($data,$d)['min'];
			$arr[]=["x"=>$d,"y"=>(float)$recx];
		}
		return $arr;
		}else{
			return [];
		}
		
	}
	public function get_avg_chart_data($data){
		//$array=array();
		$type=$data['type'];
		$array_result=(array)$this->get_log_sheet($data);
		$size=sizeof($array_result);
		
		if($data['dt']=="month") {
			
			for ($d=1; $d <sizeof($this->get_day_date($data['date']))+1; $d++) { 
			$recx=$this->avg_daily_reading($data,$d)['avg'];
			$arr[]=["x"=>$d,"y"=>(float)$recx];
		}
		return $arr;
		}else{
			return [];
		}
		
	}

	public function get_chat_data($data){
		if ($data['type']=="energy") {
			return ["daily_consumption"=>$this->get_energy_consumption_chart_data($data)];
		} else {
			return ["hourly_peak"=>$this->get_hourly_peak_chart_data($data),"hourly_avg"=>$this->get_hourly_avg_chart_data($data),"daily_reading_chart"=>$this->get_hourly_chart_data($data),"peak"=>$this->get_peak_chart_data($data),"min"=>$this->get_min_chart_data($data),"average"=>$this->get_avg_chart_data($data)];
		}
		
		
	}
	//this function returns array of day in a month
	public function get_day_date($date){
		list($month,$year)=$this->substr_date($date);
		// $month=substr($date, 0,2);
		// $year=substr($date, 3,6);
		$start_date = "01-".$month."-".$year;
		$start_time = strtotime($start_date);

		$end_time = strtotime("+1 month", $start_time);

		for($i=$start_time; $i<$end_time; $i+=86400)
			{
			   $list[] = date('d', $i);
			}
		return $list;
	}

	public function get_fault_indicators(){
		
		return $this->db->get("fault_indicators")->result();
	}


	public function get_cause_fault(){
		//check if is an ISS or Feeder
		$this->db->select(array('id','name'));
		
		return $this->db->get($this->fault_cause_table)->result();
	}

	public function get_count_fault_cause($indx,$cause_id,$data){
		//$asset_name=$data['asset_name'];
		$this->db->select('COUNT(asset_name) as num');
		$this->db->from($this->tripping_table);
		$this->db->where(array('fault_ind_id'=>$indx,'fault_cause_id'=>$cause_id,'asset_name'=>$data['asset_name'],'DATE(created_at) BETWEEN '.$data['start_date']. ' and '.$data['end_date'] ));
		return $this->db->get()->row();
	}

	public function get_fault_cause_report($input){
		//var_dump($data);
		$data='<thead><tr>';
		$data.='<th></th>';
		foreach ($this->get_fault_indicators($input) as $key => $indx) {
			$data.='<th><div>';
			$data.=$indx->indicator;
			$data.='</div></th>';
		}

		$data.='</tr></thead><tbody>';
		//get feeders
		foreach ($this->get_cause_fault() as $key => $cause) {
			$data.='<tr>';
			$data.='<td>'.$cause->name.'</td>';
			
			foreach ($this->get_fault_indicators($input) as $key => $indx) {
				$data.='<td>';
				//get the number of faults for a feeder
				$data.=$this->get_count_fault_cause($indx->id,$cause->id,$input)->num;
				$data.='</td>';
			}
			$data.='</tr>';	
		}
		$data.='</tbody>';

		return $data;
	}


	public function get_all_fault_equipments($data,$zone_id){
		if ($data['voltage_level']=="33kv") {
			
		$this->db->select("equipment_id,category,fd.feeder_name as feeder_name,fault_responses.station_id,fault_responses.transformer_id,fault_responses.voltage_level,fault_responses.created_at,COUNT(equipment_id) as total");
		$this->db->from("fault_responses");
		$this->db->group_by('equipment_id');

		
		$this->db->join("feeders_33kv fd","fault_responses.equipment_id=fd.id and fault_responses.category='Feeder' ");
		 $this->db->join(" transmissions transmN","fd.station_id=transmN.id");
		 $this->db->join(" zones zn","zn.id=transmN.zone_id and zn.id=$zone_id");
		

		  $this->db->where(array('MONTH(fault_responses.created_at)'=>$data['month'],'YEAR(fault_responses.created_at)'=>$data['year'],"fault_responses.voltage_level"=>$data['voltage_level']));
		$this->db->order_by('fault_responses.id','DESC');
		$query=$this->db->get();
		//var_dump($query->result());
		return $query->result();
		} else {
			//11kv

		$this->db->select("equipment_id,category,fd.feeder_name as feeder_name,fault_responses.station_id,fault_responses.transformer_id,fault_responses.voltage_level,fault_responses.created_at,COUNT(equipment_id) as total");
		$this->db->from("fault_responses");
		$this->db->group_by('equipment_id');

		
		$this->db->join("feeders_11kv fd","fault_responses.equipment_id=fd.id and fault_responses.category='Feeder' ");
		 $this->db->join(" feeder33kv_iss feeder_iss","fd.station_id=feeder_iss.iss_id");
		 $this->db->join(" zones zn","zn.id=feeder_iss.zone_id and zn.id=$zone_id");
		

		  $this->db->where(array('MONTH(fault_responses.created_at)'=>$data['month'],'YEAR(fault_responses.created_at)'=>$data['year'],"fault_responses.voltage_level"=>$data['voltage_level']));
		$this->db->order_by('fault_responses.id','DESC');
		$query=$this->db->get();
		//var_dump($query->result());
		return $query->result();
			
		}
		

	}
	public function get_all_fault_feeder_hourly_reading($data,$zone_id){
		if ($data['voltage_level']=="33kv") {
			
		$this->db->select("log_sheet.feeder_id,fd.feeder_name as feeder_name,log_sheet.station_id,log_sheet.transformer_id,log_sheet.voltage_level,log_sheet.captured_at,COUNT(feeder_id) as total");
		$this->db->from("log_sheet");
		$this->db->group_by('log_sheet.feeder_id');

		
		$this->db->join("feeders_33kv fd","log_sheet.feeder_id=fd.id and log_sheet.voltage_level='33kv' ");
		 $this->db->join(" transmissions transmN","fd.station_id=transmN.id");
		 $this->db->join(" zones zn","zn.id=transmN.zone_id and zn.id=$zone_id");
		

		  $this->db->where(array('MONTH(log_sheet.captured_at)'=>$data['month'],'YEAR(log_sheet.captured_at)'=>$data['year'],"log_sheet.voltage_level"=>$data['voltage_level']));
		$this->db->order_by('log_sheet.id','DESC');
		$query=$this->db->get();
		//var_dump($query->result());
		return $query->result();
		} else {
			//11kv

		$this->db->select("log_sheet.feeder_id,fd.feeder_name as feeder_name,log_sheet.station_id,log_sheet.transformer_id,log_sheet.voltage_level,log_sheet.captured_at,COUNT(feeder_id) as total");
		$this->db->from("log_sheet");
		$this->db->group_by('log_sheet.feeder_id');

		
		$this->db->join("feeders_11kv fd","log_sheet.feeder_id=fd.id and log_sheet.voltage_level='11kv' ");
		 $this->db->join(" feeder33kv_iss feeder_iss","fd.station_id=feeder_iss.iss_id");
		 $this->db->join(" zones zn","zn.id=feeder_iss.zone_id and zn.id=$zone_id");
		

		  $this->db->where(array('MONTH(log_sheet.created_at)'=>$data['month'],'YEAR(log_sheet.created_at)'=>$data['year'],"log_sheet.voltage_level"=>$data['voltage_level']));
		$this->db->order_by('log_sheet.id','DESC');
		$query=$this->db->get();
		//var_dump($query->result());
		return $query->result();
			
		}
		

	}



// public function get_fault_report($data){
// 		$this->db->select("fault_responses.*,fa.indicator as indicator,transm.tsname as transmission,iss.iss_names as iss_name,trans.names_trans as transformer,fd.feeder_name as feeder_name,transmN.tsname as transmissionN,issN.iss_names as iss_nameN,transfN.names_trans as transformerN,fault_c.name as fault_cause");
// 		$this->db->from("fault_responses");
// 		$this->db->join("fault_indicators fa","fa.id=fault_responses.reason_id");
// 		//$this->db->join("users oro","oro.id=fault_responses.created_by");
// 		//$this->db->join("users ph","ph.id=fault_responses.permit_holder_id");
// 		$this->db->join("transmissions transm","fault_responses.equipment_id=transm.id and fault_responses.category='Transmission station'", 'left',FALSE);
// 		$this->db->join("iss_tables iss","fault_responses.equipment_id=iss.id and fault_responses.category='Injection substation'", 'left',FALSE);
// 		$this->db->join("transformers trans","fault_responses.equipment_id=trans.id and fault_responses.category='Transformer'", 'left',FALSE);
// 		$this->db->join("feeders fd","fault_responses.equipment_id=fd.id and fault_responses.category='Feeder' ", 'left',FALSE);
// 		 $this->db->join(" transmissions transmN","fault_responses.station_id=transmN.id and fault_responses.voltage_level='33kv'", 'left',FALSE);
// 		 $this->db->join(" transformers transfN","fault_responses.transformer_id=transfN.id and fault_responses.transformer_id !='' ", 'left',FALSE);
// 		 $this->db->join(" iss_tables issN","fault_responses.station_id=issN.id and fault_responses.voltage_level !='33kv' ", 'left',FALSE);
// 		 $this->db->join(" fault_causes fault_c","fault_responses.fault_cause=fault_c.id  ", 'left',FALSE);
		 
// 		 $this->db->where(array('MONTH(fault_responses.created_at)'=>$data['month'],'YEAR(fault_responses.created_at)'=>$data['year']));
// 		$this->db->order_by('id','DESC');
// 		$query=$this->db->get();
// 		return $query->result();
// 	}



	
	public function get_programme_sheet($input){
		//var_dump($data);
		$data='<thead><tr>';
		$data.='<th style="border:1px solid #000;color:#000;background-color:#ddd;font-weight:bold">ZONE</th>';
		$data.='<th style="border:1px solid #ddd;color:#000;background-color:#e5e5e5;font-weight:bold">FEEDER</th>';
		foreach ($this->get_cause_fault() as $key => $indx) {
			$data.='<th ><div>';
			$data.=$indx->name;
			$data.='</div></th>';
		}

		$data.='</tr></thead><tbody>';
		//get zones
		foreach ($this->get_zones() as $key => $zone) {
			//var_dump($this->get_all_fault_equipments($input,$zone->id));
			$data.='<tr>';
			$data.='<tr>';
			$count=count($this->get_all_fault_equipments($input,$zone->id))+1;
			$data.='<td style="border:1px solid #000;color:#000;background-color:#ddd;font-weight:bold" rowspan="'. $count .'">';
			$data.=$zone->name;
              $data.='</td>';
              $data.='</tr>';
		
		foreach ($this->get_all_fault_equipments($input,$zone->id) as $key => $asset) {
			//$data.='<tr>';
			$data.='<td style="border:1px solid #ddd;color:#000;background-color:#e5e5e5;font-weight:bold">';
			$data.=$asset->feeder_name;
              $data.='</td>';
			
			foreach ($this->get_cause_fault() as $key => $indx) {
				$data.='<td>';
//fault_id,$equipment_id,$date,$countX
				//get the number of fault_indxs for a feeder
				$count=$this->count_asset_fault($indx->id,$asset->equipment_id,$input['date'],"cause")->num;
				if ($count>0) {
					$data.='<span class="text-success font-weight-bold ">'.$count.'</span>';
				} else {
					$data.=$count;
				}
				
				$data.='</td>';
			}
			$data.='</tr>';	
		}
	}
		$data.='</tbody>';

		return $data;
	}

	//summary report
	public function get_fault_report($data){
		if ($data['voltage_level']=="33kv") {
			# 33kv
			$this->db->select("fault_responses.*,oro.first_name as oro_f,oro.last_name as oro_l,fa.indicator as indicator,transm.tsname as transmission,trans.names_trans as transformer,fd_33.feeder_name as feeder_name,transmN.tsname as transmissionN,transfN.names_trans as transformerN,fault_c.name as fault_cause");
		} else {
			# 11kv
			$this->db->select("fault_responses.*,oro.first_name as oro_f,oro.last_name as oro_l,fa.indicator as indicator,iss.iss_names as iss_name,trans.names_trans as transformer,fd_11.feeder_name as feeder_name,issN.iss_names as iss_nameN,transfN.names_trans as transformerN,fault_c.name as fault_cause");

		}
		
		$this->db->from("fault_responses");
		$this->db->join("fault_indicators fa","fa.id=fault_responses.reason_id");
		//check if user is a zonal manager or feeder manager and display

		if ($data['role']==24 || $data['role']==14) {
			# zonal head and Network managers
			if ($data['voltage_level']=="33kv") {
				# 33kv
				$this->db->join("zones zn","zones.id=transmissions.zonal_id ");
			$this->db->join("transmissions trans_m","trans_m.id=feeder_33.station_id ");
			$this->db->join("feeder_33kv fd","fault_responses.equipment_id=fd.id and fault_responses.category='Feeder' and fault_responses.voltage_level='33kv' ");

			$this->db->join("transmissions transm","fault_responses.equipment_id=transm.id and fault_responses.category='Transmission station'", 'left',FALSE);
		
		$this->db->join("transformers trans","fault_responses.equipment_id=trans.id and fault_responses.category='Transformer' and fault_responses.voltage_level='33kv'", 'left',FALSE);
		
		 $this->db->join(" transmissions transmN","fault_responses.station_id=transmN.id and fault_responses.voltage_level='33kv'", 'left',FALSE);
		 $this->db->join(" transformers transfN","fault_responses.transformer_id=transfN.id and fault_responses.transformer_id !='' and fault_responses.voltage_level='33kv'", 'left',FALSE);
			} else {
				# 11kv
				$this->db->join("zones zn","zones.id=transmissions.zonal_id ");
			$this->db->join("transmissions trans_m","trans_m.id=feeder_33.station_id ");
			$this->db->join("feeder33kv_iss fd_zone","fd_zone.iss_id=iss_tables.id ");
			$this->db->join("feeder_33kv fdz","fdz.id=feeder33kv_iss.feeder_33 ");
			$this->db->join("feeder_33kv fd","fault_responses.equipment_id=fd.id and fault_responses.category='Feeder' and voltage_level='33kv' ");

			$this->db->join("iss_tables iss","fault_responses.equipment_id=iss.id and fault_responses.category='Injection substation'", 'left',FALSE);
			}
			
			
		}elseif ($data['role']==12) {
			# feeder manager
			if ($data['voltage_level']=="33kv") {
				$this->db->join("feeders_33kv fd_33","fault_responses.equipment_id=fd_33.id and fault_responses.category='Feeder' and fault_responses.voltage_level='33kv' ", 'left',FALSE);
				$this->db->join("transmissions transm","fault_responses.equipment_id=transm.id and fault_responses.category='Transmission station'", 'left',FALSE);
				 $this->db->join(" transmissions transmN","fault_responses.station_id=transmN.id and fault_responses.voltage_level='33kv'", 'left',FALSE);
			} else {
				$this->db->join("feeders_11kv fd_11","fault_responses.equipment_id=fd_11.id and fault_responses.category='Feeder' and fault_responses.voltage_level='11kv' ",'left',FALSE);

				$this->db->join(" feeder33kv_iss iss_fd","iss_fd.iss_id=fault_responses.station_id");
				$this->db->join(" feeder33kv_iss fd33","fd33.feeder33=fault_responses.equipment_id and  fault_responses.categor='Feeder' ");


				$this->db->join(" iss_tables issN","fault_responses.station_id=issN.id and fault_responses.voltage_level !='33kv' ", 'left',FALSE);
				$this->db->join("iss_tables iss","fault_responses.equipment_id=iss.id and fault_responses.category='Injection substation'", 'left',FALSE);
			}
			
			 $this->db->where(['feeder_id'=>$data['feeder33kv_id']]);
		}elseif ($data['role']==8) {
			//dso	
			$this->db->join(" iss_tables issN","fault_responses.station_id=issN.id and fault_responses.voltage_level !='33kv' ", 'left',FALSE);
			$this->db->join("iss_tables iss","fault_responses.equipment_id=iss.id and fault_responses.category='Injection substation'", 'left',FALSE);
			$this->db->join("feeders_11kv fd_11","fault_responses.equipment_id=fd_11.id and fault_responses.category='Feeder' and fault_responses.voltage_level='11kv' ");
			$this->db->join("transformers transFM","fault_responses.equipment_id=transFM.id and fault_responses.category='Transformer'", 'left',FALSE);
			 $this->db->where(['fault_responses.station_id'=>$data['station_id']]);
		}else{
			//admin,hso,dispatch
			if ($data['voltage_level']=="33kv") {
				#33kv
				$this->db->join("feeders_33kv fd_33","fault_responses.equipment_id=fd_33.id and fault_responses.category='Feeder' and fault_responses.voltage_level='33kv' ", 'left',FALSE);
				$this->db->join("transmissions transm","fault_responses.equipment_id=transm.id and fault_responses.category='Transmission station'", 'left',FALSE);
				 $this->db->join(" transmissions transmN","fault_responses.station_id=transmN.id and fault_responses.voltage_level='33kv'", 'left',FALSE);

			} else {
				# 11kv
				$this->db->join("feeders_11kv fd_11","fault_responses.equipment_id=fd_11.id and fault_responses.category='Feeder' and fault_responses.voltage_level='11kv' ",'left',FALSE);
				$this->db->join(" iss_tables issN","fault_responses.station_id=issN.id and fault_responses.voltage_level !='33kv' ", 'left',FALSE);
				$this->db->join("iss_tables iss","fault_responses.equipment_id=iss.id and fault_responses.category='Injection substation'", 'left',FALSE);
			}
				}
				$this->db->join("users oro","oro.id=fault_responses.created_by");
		
		$this->db->join("transformers trans","fault_responses.equipment_id=trans.id and fault_responses.category='Transformer'", 'left',FALSE);
		
		
		 $this->db->join(" transformers transfN","fault_responses.transformer_id=transfN.id and fault_responses.transformer_id !='' ", 'left',FALSE);
		 
		 $this->db->join(" fault_causes fault_c","fault_responses.fault_cause=fault_c.id  ", 'left',FALSE);
		 


		//$this->db->join("users oro","oro.id=fault_responses.created_by");
		//$this->db->join("users ph","ph.id=fault_responses.permit_holder_id");
		 //var_dump($data);
	
		 if ($data['status']=="all") {
		 	$this->db->where(array('MONTH(fault_responses.created_at)'=>$data['month'],'YEAR(fault_responses.created_at)'=>$data['year'],"fault_responses.voltage_level"=>$data['voltage_level']));
		 }elseif ($data['status']=="opened") {
		 	$this->db->where(array('MONTH(fault_responses.created_at)'=>$data['month'],'YEAR(fault_responses.created_at)'=>$data['year'],"fault_responses.voltage_level"=>$data['voltage_level'],"fault_responses.status <"=>8));
		 }
		  else {
		 	# closed
		 	$this->db->where(array('MONTH(fault_responses.created_at)'=>$data['month'],'YEAR(fault_responses.created_at)'=>$data['year'],"fault_responses.voltage_level"=>$data['voltage_level'],"fault_responses.status >="=>8));
		 }
		 
		 
		 //$this->db->where(array("fault_responses.voltage_level"=>"33kv"));
		$this->db->order_by('id','DESC');
		$query=$this->db->get();
		return $query->result();
	}


	public function count_asset_fault($fault_id,$equipment_id,$date,$countX){
		list($month,$year)=$this->substr_date($date);
		$this->db->select('COUNT(equipment_id) as num');
		$this->db->from("fault_responses");
		if ($countX=="indication") {
			$this->db->where(array('reason_id'=>$fault_id,'equipment_id'=>$equipment_id,'MONTH(created_at) '=>$month,'YEAR(created_at) '=>$year ));
		}else{
			//indication
			$this->db->where(array('fault_cause'=>$fault_id,'equipment_id'=>$equipment_id,'MONTH(created_at) '=>$month,'YEAR(created_at) '=>$year ));
		}
		
		return $this->db->get()->row();
	}
	public function count_interruption_fault($status,$feeder_id,$start_date,$end_date,$voltage_level){
		//list($month,$year)=$this->substr_date($date);
		$this->db->select(['COUNT(feeder_id)','groupid']);
		$this->db->from("interruption_report");
		
		$this->db->where("status='$status' and feeder_id=$feeder_id and Date(captured_at) BETWEEN '$start_date' and '$end_date' and voltage_level='$voltage_level'");
		$this->db->group_by('groupid'); 
		$query=$this->db->get();
		return $query->num_rows();
	}

	public function count_trx_limit($feeder_id,$start_date,$end_date,$voltage_level){
		//list($month,$year)=$this->substr_date($date);
		$this->db->select(['COUNT(feeder_id)','groupid']);
		$this->db->from("interruption_report");
		
		$this->db->where("status in (SELECT abbr from feeder_status where trx=1) and feeder_id=$feeder_id and Date(captured_at) BETWEEN '$start_date' and '$end_date' and voltage_level='$voltage_level'");
		$this->db->group_by('groupid'); 
		$query=$this->db->get();
		return $query->num_rows();
	}

	

	public function get_fault_indication_frequency($input){
		//var_dump($data);
		$data='<thead style="background-color:blue;color:white"><tr>';
		$data.='<th style="border:1px solid #000">ZONE</th>';
		$data.='<th>FEEDER</th>';
		foreach ($this->get_station_fault() as $key => $indx) {
			$data.='<th><div>';
			$data.=$indx->names;
			$data.='</div></th>';
		}
		$data.='<th>TX LIMIT</th>';
		$data.='</tr></thead><tbody>';
		foreach ($this->get_zones() as $key => $zone) {
			//var_dump($this->get_all_fault_equipments($input,$zone->id));
			$data.='<tr>';
			$data.='<tr>';
			$count=count($this->get_33kvfeeders_by_zone($zone->id))+1;
			$data.='<td style="border:1px solid #000;color:#000;background-color:#278acd;font-weight:bold" rowspan="'.$count.'">';
			$data.=$zone->name;
              $data.='</td>';
              $data.='</tr>';
		foreach ($this->get_33kvfeeders_by_zone($zone->id) as $key => $asset) {
			$data.='<tr>';
			$data.='<td style="border:1px solid #ddd;color:#000;background-color:#f2642a;font-weight:bold">';
			$data.=$asset->feeder_name;
              $data.='</td>';
			
			foreach ($this->get_station_fault() as $key => $indx) {
				
//fault_id,$equipment_id,$date,$countX
				//get the number of fault_indxs for a feeder
				
				$count_ind=$this->count_interruption_fault($indx->abbr,$asset->feeder_id,$input['start_date'],$input['end_date'],$input['voltage_level']);
				if ($count_ind>0) {
					$data.='<td style="background-color:#df0100;text-align:right;color:#ffffff">';
					$data.=$count_ind;
					$data.='</td>';

				} else {
					$data.='<td style="background-color:#d0d0d0;text-align:right">';
					$data.=$count_ind;
					$data.='</td>';
				}	
				
			}

			$count_indx=$this->count_trx_limit($asset->feeder_id,$input['start_date'],$input['end_date'],$input['voltage_level']);
				if ($count_indx>0) {
					$data.='<td style="background-color:#df0100;text-align:right;color:#ffffff">';
					$data.=$count_indx;
					$data.='</td>';

				} else {
					$data.='<td style="background-color:#d0d0d0;text-align:right">';
					$data.=$count_indx;
					$data.='</td>';
				}	

			// $data.='<td style="background-color:#d0d0d0;text-align:right">55</td>';
			// $data.='</tr>';	
		}
		$data.='</tr>';
	}
		$data.='</tbody>';

		return $data;
	}

}



?>