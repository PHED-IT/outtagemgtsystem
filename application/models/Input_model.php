<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Input_model extends CI_Model
{
	//protected $ibc_table_name="feederIbc";
	protected $log_sheet_table="log_sheet";
	protected $energy_sheet_table="energy_log_sheet";
	protected $transmission_table="transmissions";
	protected $feeder_hiarachy_table="feeder_hiarachy";
	protected $iss_tables="iss_tables";
	//protected $transmission_transformer_table="transmission_transformer";
	
	public function get_ibc_name(){
		$this->db->select("ibc_name");
		$query=$this->db->get($this->ibc_table_name);
		return $query->result();
	}

	// public function get_transmission_stations(){
	// 	$this->db->distinct("tsname");
	// 	$this->db->select("tsname,tsname as tsid");
	// 	$query=$this->db->get($this->transmission_transformer_table);
	// 	return $query->result();
	// }

	public function get_feeders_ibc($ibc_name){
		$this->db->select('feeder_name');
		$this->db->where('ibc_name',$ibc_name);
		$query=$this->db->get($this->ibc_table_name);
		return $query->result();
	}
	//get 33kv feeders by transformer id and voltage level
	public function get_feeders_ts($ts_id){
		$this->db->select(array('feeder_name','id'));
		$this->db->where(array("transformer_id"=>$ts_id,"voltage_level"=>"33kv"));
		$query=$this->db->get("feeders_33kv");
		return $query->result();
	}
	//get 33kv feeders by transformer id and voltage level
	public function get_33kvfeeders(){
		//$this->db->select(array('feeder_name','id'));
		//$this->db->where(array("transformer_id"=>$ts_id,"voltage_level"=>"33kv"));
		$query=$this->db->get("feeders_33kv");
		return $query->result();
	}

	//get 11kv feeders by transformer id and voltage level
	public function get_feeder_iss($transformer_id){
		$this->db->select(array('feeder_name','id'));
		$this->db->where(array('transformer_id'=>$transformer_id,"voltage_level"=>"11kv"));
		$query=$this->db->get("feeders_11kv");
		return $query->result();
	}
	// public function get_transformer_ts($transformer_id){
	// 	$this->db->distinct("transformer");
	// 	$this->db->select(array('transformer','transformer_id'));
	// 	$this->db->where('tsname',$transformer_id);
	// 	$query=$this->db->get($this->transmission_transformer_table);
	// 	return $query->result();
	// }
	// public function get_transformer_iss($iss_id){
	// 	//$this->db->distinct("transformer");
	// 	$this->db->select(array('names_trans','id'));
	// 	$this->db->where('ISS_ID',$iss_id);
	// 	$query=$this->db->get("transformers");
	// 	return $query->result();
	// }



	public function findDayDiff($date){
	   $param_date=date('d-m-Y',strtotime($date));
	   $response  = $param_date;
	   if($param_date==date('d-m-Y',strtotime("now"))){
	       $response = 'Today';
	   }else if($param_date==date('d-m-Y',strtotime("-1 days"))){
	       $response = 'Yesterday'; 
	   }
	   return $response;
	}

	//get latest reading for log entry by transformer id
	public function get_last_reading($data){
		if ($data['isFeeder']) {
			$this->db->where(array('feeder_id'=>$data['feeder_id']));
		}else{
			$this->db->where(array('transformer_id'=>$data['station_id'],"voltage_level"=>$data['voltage_level']));
		}
		
		$this->db->order_by('ID','DESC');
		if ($data['type']=="load") {
			return $this->db->get($this->log_sheet_table)->row();
		} else {
			return $this->db->get($this->energy_sheet_table)->row();
		}
	}

	//get last reading by transmission station
	public function get_last_reading_by_transmission($data){
		
		$this->db->where(array('station_id'=>$data['station_id'],"voltage_level"=>$data['voltage_level']));
		$this->db->order_by('ID','DESC');
		
		return $this->db->get($this->log_sheet_table)->row();
		
	}
	public function get_log_by_feeder_date($feeder,$date){
		$this->db->where(array('captured_at'=>$date,"feeder_name"=>$feeder));
		$this->db->order_by('ID','DESC');
		return $this->db->get($this->log_sheet_table)->row();
	}
	public function get_energy_by_feeder_date($feeder,$voltage_level){
		$this->db->where(array("feeder_id"=>$feeder,"voltage_level"=>$voltage_level));
		$this->db->order_by('ID','DESC');
		return $this->db->get($this->energy_sheet_table)->row();
	}

	

	public function store_log($data){
		//append date to time captured
		// $date=date("Y-m-d");
		// $captured_date=date("Y-m-d H:i:s",strtotime($data['captured_date'],strtotime($date)));
		//check if date is today
		//if ($this->findDayDiff($data['captured_date'])=='Today') {
			$prev=date('Y-m-d',strtotime("-1 days"));
		$this->db->select('load_reading');
		$this->db->where('captured_at',$prev);
		$prev_record=$this->db->get($this->log_sheet_table)->result();
		//check if reading is completed the previous date
		if ($prev_record>0 && count($prev_record)<24) {
			//return ['status'=>false,"data"=>"You must complete the reading of previous day"];
		}
		
		
		//$record=$this->get_last_reading($data['captured_date']);


			//yes everything is correct insert
			$count_feeders=count($data['feeders']);
		for ($i=0; $i <$count_feeders ; $i++) { 
			//$reading=$data['readings'][$i];
			
			$feeder=$data['feeders'][$i];
			$remark=$data['remarks'][$i];
			$status=$data['status'][$i];
			
			//$load_mvr_in=$data['load_mvr_in'];
			//$load_mw_in=$data['load_mw_in'];
			//$current_in=floatval($data['current_in']);
			//$pf_in=floatval($data['pf_in']);
			//$voltage_in=floatval($data['voltage_in']);
			
			
			if(empty($data['captured_date'])){
				return ['status'=>false,"data"=>"Captured date must be selected"];
			}
			if(empty($data['voltage_level'])){
				return ['status'=>false,"data"=>"Please Select Transformer"];
			}
			if($data['hour']==" "){
				return ['status'=>false,"data"=>"Hour must be selected"];
			}

			$this->db->where(array('feeder_id'=>$feeder,'hour'=>$data['hour'],'captured_at'=>$data['captured_date'],'voltage_level'=>$data['voltage_level']));
			$q=$this->db->get($this->log_sheet_table);

			if ($status==="on") {
				// if ($i==2) {
				// 	return ['status'=>false,"data"=>$i]; 
				// }
				
				//feeder is on
				$pf=floatval($data['pf'][$i]);
			$current=floatval($data['current'][$i]);
			$frequency=$data['frequency'][$i];
			$voltage=floatval($data['voltage'][$i]);
			$load_mvr=$data['load_mvr'][$i];
			$isIncommer=isset($data['isIncommer'][$i])&&$data['isIncommer'][$i]=="true"?1:0;

				if($pf<0 && $pf>1){
				return ['status'=>false,"data"=>" Power Factor is invalid"];
			}
			if(empty($voltage)){
				return ['status'=>false,"data"=>"All Voltage must be entered"];
			}
			if(empty($current)){
				return ['status'=>false,"data"=>"All Current must be entered"];
			}
			if(empty($load_mvr)){
				$load_mvr=0;
				//return ['status'=>false,"data"=>"All Load(MVR) must be entered"];
			}				
			if ($q->num_rows()>0) {
				//reading has already been entered
				return [
					'status'=>false,
					'data'=>"Log has been entered for this hour and date"
				];
			}else{
				//var_dump(expression)
				// $reading=(sqrt(3)*$voltage*$current*$pf)/1000;
				//$load_mw_in=sqrt(3)*$voltage_in*$current_in*$pf_in;
				//var_dump($reading.' '.$load_mw_in);
				// return [
				// 	'status'=>false,
				// 	'data'=>$reading
				// ];
				// $result=$this->db->insert($this->log_sheet_table,array('voltage_level'=>$data['voltage_level'],'station_id'=>$data['station_id'],'feeder_id'=>$feeder,'load_reading'=>$reading,'pf'=>$pf,'voltage'=>$voltage,'current_reading'=>$current,'frequency'=>$frequency,'load_mvr'=>$load_mvr,'load_mvr_in'=>$load_mvr_in,'load_mw_in'=>$load_mw_in,'pf_in'=>$pf_in,'current_in'=>$current_in,'voltage_in'=>$voltage_in,'created_by'=>$data['created_by'],'hour'=>$data['hour'],'captured_at'=>$data['captured_date'],'remarks'=>$remark,"status"=>$status,"isIncommer"=>$isIncommer));
				// $result=$this->db->insert($this->log_sheet_table,array('voltage_level'=>$data['voltage_level'],'station_id'=>$data['station_id'],'feeder_id'=>$feeder,'load_reading'=>$reading,'pf'=>$pf,'voltage'=>$voltage,'current_reading'=>$current,'frequency'=>$frequency,'load_mvr'=>$load_mvr,'created_by'=>$data['created_by'],'hour'=>$data['hour'],'captured_at'=>$data['captured_date'],'remarks'=>$remark,"status"=>$status,"isIncommer"=>$isIncommer,"transformer_id"=>$data['transformer']));
			}
			
			}else{
				//feeder is not on

				if ($q->num_rows()>0) {
				//reading has already been entered
				return [
					'status'=>false,
					//'data'=>"Log has been entered for ".($isIncommer==1)?'Incommer'$this->getFeeder($feeder)->feeder_name
					'data'=>"Log has been entered for this hour and date"
				];
			}
			// else{
			// 	$result=$this->db->insert($this->log_sheet_table,array('voltage_level'=>0,'station_id'=>$data['station_id'],'feeder_id'=>$feeder,'load_reading'=>0,'pf'=>0,'voltage'=>0,'current_reading'=>0,'frequency'=>0,'load_mvr'=>0,'created_by'=>$data['created_by'],'hour'=>$data['hour'],'captured_at'=>$data['captured_date'],'remarks'=>$remark,"status"=>$status,"isIncommer"=>$isIncommer,"transformer_id"=>$data['transformer']));
			// }
			}
			
			//get last feeder record
			// $record=$this->get_log_by_feeder_date($feeder,$data['captured_date']);
			// if ($record) {
			// 	# check if the hour entered for feeder is a consecutive number relative to the previous one
			// 	if($record->hour+1!=$data['hour']){
			// 		return ['status'=>false,"data"=>"Oops! You skip previous hour or feeder reading has already been logged"];
			// 	}
				
			// }
			

		}

		//this is for inserting to db
		for ($i=0; $i <$count_feeders ; $i++) { 
			
			$feeder=$data['feeders'][$i];
			$remark=$data['remarks'][$i];
			$status=$data['status'][$i];
			$isIncommer=isset($data['isIncommer'][$i])&&$data['isIncommer'][$i]=="true"?1:0;
			//$transformer_id=isset($data['isIncommer'][$i])&&$data['isIncommer'][$i]=="true"?$feeder:NULL
			if ($status=="on") {
				$pf=floatval($data['pf'][$i]);
				$current=floatval($data['current'][$i]);
				$frequency=$data['frequency'][$i];
				$voltage=floatval($data['voltage'][$i]);
				$load_mvr=$data['load_mvr'][$i];

				$reading=(sqrt(3)*$voltage*$current*$pf)/1000;
				$load_mvr=sqrt(3)*sqrt(1-($pf*$pf))*$voltage*$current;

				$result=$this->db->insert($this->log_sheet_table,array('voltage_level'=>$data['voltage_level'],'station_id'=>$data['station_id'],'feeder_id'=>$feeder,'load_reading'=>$reading,'pf'=>$pf,'voltage'=>$voltage,'current_reading'=>$current,'frequency'=>$frequency,'load_mvr'=>$load_mvr,'created_by'=>$data['created_by'],'hour'=>$data['hour'],'captured_at'=>$data['captured_date'],'remarks'=>$remark,"status"=>$status,"isIncommer"=>$isIncommer,"transformer_id"=>$data['transformer']));
			}else{
				$result=$this->db->insert($this->log_sheet_table,array('voltage_level'=>$data['voltage_level'],'station_id'=>$data['station_id'],'feeder_id'=>$feeder,'load_reading'=>0,'pf'=>0,'voltage'=>0,'current_reading'=>0,'frequency'=>0,'load_mvr'=>0,'created_by'=>$data['created_by'],'hour'=>$data['hour'],'captured_at'=>$data['captured_date'],'remarks'=>$remark,"status"=>$status,"isIncommer"=>$isIncommer,"transformer_id"=>$data['transformer']));
			}

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
			
		

		
		// }else{
		// 	//trying to copmlete last day reading
		// 	$count_feeders=count($data['feeders']);
		// for ($i=0; $i <$count_feeders ; $i++) { 
		// 	$reading=$data['readings'][$i];
		// 	$pf=$data['pf'][$i];
		// 	$current=$data['current'][$i];
		// 	$frequency=$data['frequency'][$i];
		// 	$voltage=$data['voltage'][$i];
		// 	//$load_mvr=$data['load_mvr'][$i];
		// 	$load_mvr_in=$data['load_mvr_in'];
		// 	$load_mw_in=$data['load_mw_in'];
		// 	$current_in=$data['current_in'];
		// 	$pf_in=$data['pf_in'];
		// 	$voltage_in=$data['voltage_in'];
		// 	$feeder=$data['feeders'][$i];
		// 	$remark=$data['remarks'][$i];
		// 	if(empty($data['station_type'])){
		// 		return ['status'=>false,"data"=>"Please Select Transformer"];
		// 	}
		// 	if(empty($data['captured_date'])){
		// 		return ['status'=>false,"data"=>"Captured date must be selected"];
		// 	}
		// 	if($data['hour']==" "){
		// 		return ['status'=>false,"data"=>"Hour must be selected"];
		// 	}
		// 	if(empty($reading)){
		// 		return ['status'=>false,"data"=>"All Load(MW) must be entered"];
		// 	}
		// 	if(empty($pf)){
		// 		return ['status'=>false,"data"=>"All Power Factor must be entered"];
		// 	}
		// 	if(empty($voltage)){
		// 		return ['status'=>false,"data"=>"All Voltage must be entered"];
		// 	}
		// 	if(empty($current)){
		// 		return ['status'=>false,"data"=>"All Current must be entered"];
		// 	}
		// 	if(empty($load_mvr)){
		// 		return ['status'=>false,"data"=>"All Load(MVR) must be entered"];
		// 	}
		// 	if($pf!=-1 && $pf!=1){
		// 		return ['status'=>false,"data"=>" Power Factor is invalid"];
		// 	}
		// 	$this->db->where(array('feeder_id'=>$feeder,'hour'=>$data['hour'],'captured_at'=>$data['captured_date']));
		// 	$q=$this->db->get($this->log_sheet_table);
		// 	if ($q->num_rows()>0) {
		// 		//reading has already been entered
		// 		return [
		// 			'status'=>false,
		// 			'data'=>"Reading has been entered for ".$feeder." for this hour "
		// 		];
		// 	}else{
		// 		$result=$this->db->insert($this->log_sheet_table,array('station_type'=>$data['station_type'],'station_id'=>$data['station_id'],'feeder_name'=>$feeder,'load_reading'=>$reading,'pf'=>$pf,'voltage'=>$voltage,'current_reading'=>$current,'frequency'=>$frequency,'load_mvr'=>$load_mvr,'load_mvr_in'=>$load_mvr_in,'load_mw_in'=>$load_mw_in,'pf_in'=>$pf_in,'current_in'=>$current_in,'voltage_in'=>$voltage_in,'created_by'=>$data['created_by'],'hour'=>$data['hour'],'captured_at'=>$data['captured_date'],'remarks'=>$remark));
		// 	}
			

		// }
		// if ($result) {
		// 	return [
		// 			'status'=>true,
		// 			'data'=>"Log created successfully"
		// 		];
		// } else {
		// 	return [
		// 			'status'=>false,
		// 			'data'=>$this->db->error
		// 		];
		// }
		// }
		//check if reading was entered completely for previous date
		
	}

	public function store_log_new($data){
		
			$prev=date('Y-m-d',strtotime("-1 days"));
		$this->db->select('load_reading');
		$this->db->where('captured_at',$prev);
		$prev_record=$this->db->get($this->log_sheet_table)->result();
		//check if reading is completed the previous date
		if ($prev_record>0 && count($prev_record)<24) {
			//return ['status'=>false,"data"=>"You must complete the reading of previous day"];
		}
		


			
			$count_current=count($data['current']);
			
		for ($i=0; $i <$count_current ; $i++) { 
			//$reading=$data['readings'][$i];
			//return ['status'=>false,"data"=>$i];
			$current=$data['current'][$i];
			
			
			if(empty($data['captured_date'])){
				return ['status'=>false,"data"=>"Captured date must be selected"];
			}
			if(empty($data['voltage_level'])){
				return ['status'=>false,"data"=>"Please Select Transformer"];
			}
			$remark=$data['remarks'][$i];
			$status=$data['status'][$i];
			$hour=$data['hour'][$i];
			//$hour=$data['hour'][$i];
			if ($status=="on") {
				if ($current != "0.00" && $current!="" ) {
				//if current value is entered then continue
				 //return ['status'=>false,"data"=>$current];
				 $this->db->where(array('feeder_id'=>$data['feeder'],'hour'=>$hour,'captured_at'=>$data['captured_date'],'voltage_level'=>$data['voltage_level']));
			$q=$this->db->get($this->log_sheet_table);

				if ($q->num_rows()>0) {
				//reading has already been entered
				return [
					'status'=>false,
					//'data'=>"Log has been entered for ".$this->getFeeder($feeder)->feeder_name
					'data'=>"Log has been entered for this hour ".$hour.".00 and date"
				];
			}
			} 
			}else{
				//feeder is not on
				$this->db->where(array('feeder_id'=>$data['feeder'],'hour'=>$hour,'captured_at'=>$data['captured_date'],'voltage_level'=>$data['voltage_level']));
			$q=$this->db->get($this->log_sheet_table);

				if ($q->num_rows()>0) {
				//reading has already been entered
				return [
					'status'=>false,
					//'data'=>"Log has been entered for ".$this->getFeeder($feeder)->feeder_name
					'data'=>"Log has been entered for this hour ".$hour.".00 and date"
				];
			}
			}
			

			
			}
	
		//this is for inserting to db
		for ($i=0; $i <$count_current ; $i++) { 
			
			//$feeder=$data['feeders'][$i];
			$remark=$data['remarks'][$i];
			$status=$data['status'][$i];
			$hour=$data['hour'][$i];
			$current=$data['current'][$i];
			$voltage=$data['voltage'][$i];
			$pf=floatval($data['pf'][$i]);
			$frequency=$data['frequency'][$i];
				$voltage=floatval($data['voltage'][$i]);
			$isIncommer=isset($data['isIncommer'])&&$data['isIncommer']=="true"?1:0;
			
			if ($status=="on") {
				if ($current != "0.00" && $current!="" ) {
					$reading=(sqrt(3)*$voltage*$current*$pf)/1000;
				$load_mvr=sqrt(3)*sqrt(1-($pf*$pf))*$voltage*$current;
				$result=$this->db->insert($this->log_sheet_table,array('voltage_level'=>$data['voltage_level'],'station_id'=>$data['station_id'],'feeder_id'=>$data['feeder'],'load_reading'=>$reading,'pf'=>$pf,'voltage'=>$voltage,'current_reading'=>$current,'frequency'=>$frequency,'load_mvr'=>$load_mvr,'created_by'=>$data['created_by'],'hour'=>$hour,'captured_at'=>$data['captured_date'],'remarks'=>$remark,"status"=>$status,"isIncommer"=>$isIncommer,"transformer_id"=>$data['transformer']));
				}
			}else{
				//feeder is not on 
				$result=$this->db->insert($this->log_sheet_table,array('voltage_level'=>$data['voltage_level'],'station_id'=>$data['station_id'],'feeder_id'=>$data['feeder'],'load_reading'=>0,'pf'=>0,'voltage'=>0,'current_reading'=>0,'frequency'=>0,'load_mvr'=>0,'created_by'=>$data['created_by'],'hour'=>$hour,'captured_at'=>$data['captured_date'],'remarks'=>$remark,"status"=>$status,"isIncommer"=>$isIncommer,"transformer_id"=>$data['transformer']));
			}
			

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

	public function getFeeder($feeder_id){
		$this->db->where(array('id'=>$feeder_id));
		return $this->db->get("feeders")->row();
	}

	public function store_energy($data){
		//append date to time captured
		// $date=date("Y-m-d");
		// $captured_date=date("Y-m-d H:i:s",strtotime($data['captured_date'],strtotime($date)));

		$count_feeders=count($data['feeders']);
		for ($i=0; $i <$count_feeders ; $i++) { 
			$energy=$data['energy'][$i];
			$feeder=$data['feeders'][$i];
			//$incommer=$data['energy_in'];
			$remark=$data['remarks'][$i];
			$isIncommer=isset($data['isIncommer'][$i])&&$data['isIncommer'][$i]=="true"?1:0;

			//return ['status'=>false,'data'=>$count_feeders];
			// if(empty($data['station_type'])){
			// 	return ['status'=>false,"data"=>"Please Select Transformer"];
			// }
			if (empty($energy)) {
				return ['status'=>false,'data'=>"Meter reading must not be empty"];
			}
			if(empty($data['captured_date'])){
				return ['status'=>false,"data"=>"Captured date must be selected"];
			}
			if($data['hour']==" "){
				return ['status'=>false,"data"=>"Hour must be selected"];
			}

			$this->db->where(array('feeder_id'=>$feeder,'hour'=>$data['hour'],'captured_at'=>$data['captured_date'],"voltage_level"=>$data["voltage_level"]));
			$q=$this->db->get($this->energy_sheet_table);
			//var_dump($q);
			if ($q->num_rows()>0) {
				//reading has already been entered
				$name=($isIncommer==0)?$this->getFeeder($feeder)->feeder_name:"Incommer";
				return [
					'status'=>false,
					'data'=>"Energy has been entered for this hour and date for ".$name
				];
			}else{

				$record=$this->get_energy_by_feeder_date($feeder,$data['voltage_level']);
				//var_dump($record);
			if ($record){
				# check if previous energy is greater than current energy
				if($record->energy>$energy){
					$name=($isIncommer==0)?$this->getFeeder($feeder)->feeder_name:"Incommer";
				//	return ['status'=>false,"data"=>"Oops! Energy must not be less than  previous reading({$record->energy}) for ".$name];
				}
			}
			
			}		

		}


		for ($i=0; $i <$count_feeders ; $i++) { 
			$energy=$data['energy'][$i];
			$feeder=$data['feeders'][$i];
			//$incommer=$data['energy_in'];
			$remark=$data['remarks'][$i];
			$isIncommer=isset($data['isIncommer'][$i])&&$data['isIncommer'][$i]=="true"?1:0;

			$record=$this->get_energy_by_feeder_date($feeder,$data['voltage_level']);
			$hourly_consump=($record)?$energy-$record->energy:0;
			
			
			$result=$this->db->insert($this->energy_sheet_table,array('voltage_level'=>$data['voltage_level'],'station_id'=>$data['station_id'],'feeder_id'=>$feeder,'energy'=>$energy,'created_by'=>$data['created_by'],'hour'=>$data['hour'],'captured_at'=>$data['captured_date'],'remarks'=>$remark,'hourly_comsumption'=>$hourly_consump,"isIncommer"=>$isIncommer,"transformer_id"=>$data['transformer']
			));

		}
		
		if ($result) {
			return [
					'status'=>true,
					'data'=>"Energy Log is successfull"
				];
		} else {
			return [
					'status'=>false,
					'data'=>$this->db->error
				];
		}
	}

	public function get_ibc_summary(){
		$this->db->select_sum('reading');
		$this->db->select(array('feeder_name','DATE(captured_at) as captured_at'));
		$this->db->group_by(array('DATE(captured_at)','feeder_name'));
		$this->db->where("created_at >= ( CURDATE() - INTERVAL 2 DAY )");
		//$this->db->query("GROUP BY MONTH('captured_at'), ibc_name");
		$query=$this->db->get($this->log_sheet_table);

		return $query->result();
	}

	public function get_inputs_feeder($feeder_name){
		$this->db->where('feeder_name',$feeder_name);
		//$this->db->group_by("feeder_name");
		$query=$this->db->get($this->log_sheet_table);

		return $query->result();
	}

	public function update_reading_ibc_feeader($data){
		$count_readings=count($data['readings']);
		for ($i=0; $i <$count_readings ; $i++) { 
			//get value of a reading
			$reading=$data['readings'][$i];
			$prev_reading=$data['prev_readings'][$i];
			$created_at=$data['created_at'][$i];
			//echo $data['feeder_name'];
			//$this->db->where("ibc_name",$data['ibc_name']);
			$result=$this->db->update($this->log_sheet_table,array("reading"=>$reading),array("ibc_name"=>$data['ibc_name'],"feeder_name"=>$data['feeder_name'],"reading"=>$prev_reading,"created_at"=>$created_at));
		}
		if ($result) {
			return ['status'=>true,'message'=>"reading updated successfully"];
		} else {
			return ['status'=>false,'message'=>$this->db->error];
		}
		
	}
	public function get_reading_feeder_date($data){
		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d",strtotime($data['date']));
		 $month=substr($data['date'], 0,2);
		$year=substr($data['date'], 3,6);
		//var_dump($month);
		// $this->db->where(array('captured_at'=>$date,'feeder_name'=>$data['feeder_name']));
		//$this->db->select(array($data['log_type'],'hour','captured_at','id'));
		if ($data['log_type']=="energy") {
			$this->db->select(array($data['log_type'],'hour','captured_at','id'));
		}else{
			$this->db->select(array($data['log_type'],'hour','captured_at','status','id'));
		}
		
		 $this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id'],'isIncommer'=>0));

		// $this->db->where(array('MONTH(created_at)'=>$month,'YEAR(created_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		//$this->db->group_by("feeder_name");
		 if ($data['log_type']=="energy") {
		 	$query=$this->db->get($this->energy_sheet_table);
		 } else {
		 	$query=$this->db->get($this->log_sheet_table);
		 }
		 
		return $query->result();
	}
	public function get_reading_feeder_date_new($data){
		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d",strtotime($data['date']));
		 $month=substr($data['date'], 0,2);
		$year=substr($data['date'], 3,6);
		$type=$data['log_type'];
		
		if ($type=="energy") {
			$this->db->select("energy_log_sheet.feeder_id,energy_log_sheet.$type,energy_log_sheet.hour,energy_log_sheet.captured_at,energy_log_sheet.id,energy_log_sheet.isIncommer,feeder.feeder_name as feeder_name,transformer.names_trans as incommer");
		 	$this->db->from($this->energy_sheet_table);
		 	$this->db->join("feeders feeder","feeder.id=energy_log_sheet.feeder_id and energy_log_sheet.isIncommer=0",'left',false);
		 	$this->db->join("transformers transformer","transformer.id=energy_log_sheet.feeder_id and isIncommer=1",'left',false);

		 	$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'energy_log_sheet.station_id'=>$data['station_id']));
		 	//$this->db->group_by('energy_log_sheet.feeder_id');
		 } else {
		 	$this->db->select("log_sheet.$type,log_sheet.hour,log_sheet.captured_at,log_sheet.status,log_sheet.id,log_sheet.isIncommer,feeder.feeder_name as feeder_name,transformer.names_trans as incommer");
		 	$query=$this->db->from($this->log_sheet_table);
		 	$this->db->join("feeders feeder","feeder.id=log_sheet.feeder_id and log_sheet.isIncommer=0",'left',false);
		 	$this->db->join("transformers transformer","transformer.id=log_sheet.feeder_id and log_sheet.isIncommer=1",'left',false);
		 	$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'log_sheet.station_id'=>$data['station_id']));
		 }
		
		$query=$this->db->get();
		
		//var_dump($query->result());

		return $query->result();
	}

	public function getReadingByFeeder($data){
		
		if ($data['log_type']=="energy") {
			if (isset($data['date_type'])) {
				//this is day
				$this->db->select(array($data['log_type'],'hour','captured_at','id'));
			 $this->db->where(array('captured_at'=>$data['captured_at'],'feeder_id'=>$data['feeder_id'],'isIncommer'=>$data['isIncommer']));
			 $query=$this->db->get($this->energy_sheet_table);
			} else {
				//month
				$this->db->select(array($data['log_type'],'hour','captured_at','id'));
			 $this->db->where(array('MONTH(captured_at)'=>$data['month'],'YEAR(captured_at)'=>$data['year'],'feeder_id'=>$data['feeder_id'],'isIncommer'=>$data['isIncommer'],'DAY(captured_at)'=>$data['day']));
			 $query=$this->db->get($this->energy_sheet_table);
			}
			
			
		}else{
			$this->db->select(array($data['log_type'],'hour','captured_at','status','id'));
			$this->db->where(array('captured_at'=>$data['captured_at'],'feeder_id'=>$data['feeder_id'],"hour"=>$data['hour']));
			$query=$this->db->get($this->log_sheet_table);
		}
		
		return $query->row();
	}
	public function get_reading_avg($data){
		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d H:i:s",strtotime($custom_date));
		$month=substr($data['date'], 0,2);
		$year=substr($data['date'], 3,6);
		$this->db->select_avg('reading');
		$this->db->where(array('MONTH(created_at)'=>$month,'YEAR(created_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		//$this->db->group_by("feeder_name");
		$query=$this->db->get($this->log_sheet_table);

		return $query->row();
	}
	public function get_reading_max($data){
		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d H:i:s",strtotime($custom_date));
		$month=substr($data['date'], 0,2);
		$year=substr($data['date'], 3,6);
		$this->db->select(array('reading','created_at'));
		
		$this->db->where('reading=(SELECT MAX(reading) from log_sheet where MONTH(created_at)="'.$month.'" AND YEAR(created_at)="'.$year.'" and feeder_name="'.$data['feeder_name'].'")');
		// $this->db->where(array('MONTH(created_at)'=>$month,'YEAR(created_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		//$this->db->group_by("feeder_name");
		$query=$this->db->get($this->log_sheet_table);

		return $query->row();
	}
	public function get_reading_min($data){
		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d H:i:s",strtotime($custom_date));
		$month=substr($data['date'], 0,2);
		$year=substr($data['date'], 3,6);
		$this->db->select(array('reading','created_at'));
		
		
		$this->db->where('reading=(SELECT MIN(reading) from log_sheet where MONTH(created_at)="'.$month.'" AND YEAR(created_at)="'.$year.'" and feeder_name="'.$data['feeder_name'].'")');
		$query=$this->db->get($this->log_sheet_table);

		return $query->row();
	}

	public function get_reading_mode($data){
		//$custom_date=$year.'-'.$month.'-'.$day;
		//$date=date("Y-m-d H:i:s",strtotime($custom_date));
		$month=substr($data['date'], 0,2);
		$year=substr($data['date'], 3,6);
		$this->db->select('reading as mode');	
		$this->db->where(array('MONTH(created_at)'=>$month,'YEAR(created_at)'=>$year,'feeder_name'=>$data['feeder_name']));
		$this->db->group_by('reading');
		$this->db->order_by("count(*) DESC");
		$query=$this->db->get($this->log_sheet_table);

		return $query->row();
	}

	public function delete_reading($data){
		$this->db->where('id',$data['reading_id']); // I change id with book_id
		if ($data['type']=="energy") {
  			$this->db->delete($this->energy_sheet_table);
		}else{
			$this->db->delete($this->log_sheet_table);
		}
		return ["status"=>true];

	}

	//get previous energy reading
	public function get_prev_reading($data){
		$this->db->select($data['type']);
		$this->db->where('energy !=',null);
		$this->db->order_by('id','DESC');
		$query=$this->db->get($this->log_sheet_table);
		$row= $query->row();
	}


	public function update_reading($data){
		$type=strtolower($data['type']);
		$isIncommer=strtolower($data['isIncommer']);
		
		if ($data['type']=="energy") {
				
		//$this->db->select($type);
		$this->db->where(array('id'=>$data['reading_id']));
		$query=$this->db->get($this->energy_sheet_table);
		$row= $query->row();
		//var_dump($row);
		//check if reading has been entered for a time ahead
		// $this->db->where(array('hour'=>$row->hour+1,"feeder_id"=>$row->feeder_id,'isIncommer'=>$isIncommer));
		// $queryCh1=$this->db->get($this->energy_sheet_table);
		// $rowX= $queryCh1->row();
		// //user cannot edit reading cos he has entered reading ahead
		// //unless he is a dispatch or admin
		// if ($rowX) {
		// 	return ['status'=>false,'message'=>"You cannot update this value now"];
		// }

		//get previous data
		if ($data['day']=="01") {
			# check if is the first day of the month
			//$hourly_consump=$data['reading']-$rowPrx->energy;
			$this->db->where('id',$data['reading_id']);
			$result=$this->db->update($this->energy_sheet_table,array($type=>$data['reading'],"updated_energy"=>$row->$type,"updated_at"=>date("Y-m-d H:i:s"),"hourly_comsumption"=>0));
		} else {
			$this->db->where(array("id <"=>$data['reading_id'],"isIncommer"=>$isIncommer));
			$this->db->order_by("id","DESC");
			$queryPrev=$this->db->get($this->energy_sheet_table);
			$rowPrx= $queryPrev->row();
		$type=$type;
		//if ($row->$type>$data['reading'] || $rowPrx->$type>$data['reading']) {
		if ( $rowPrx->$type>$data['reading']) {
			//updated reading is less than previous reading
			return ['status'=>false,'message'=>"Energy must not be less than previous  reading({$rowPrx->energy})"];
		} 

		$hourly_consump=$data['reading']-$rowPrx->energy;
			$this->db->where('id',$data['reading_id']);
			$result=$this->db->update($this->energy_sheet_table,array($type=>$data['reading'],"updated_energy"=>$row->$type,"updated_at"=>date("Y-m-d H:i:s"),"hourly_comsumption"=>$hourly_consump));
		}
		
		

		// $this->db->select($type);
		// $this->db->where(array('id <'=>$data['reading_id'],'isIncommer'=>0));
		// $this->db->order_by("ID","DESC");
		// $query=$this->db->get($this->energy_sheet_table);
		// $record= $query->row();

			
				//var_dump($record);
			//if ($record){
				# check if previous energy is greater than current energy
				// if($record->energy>$data['reading']){
				// 	return ['status'=>false,"message"=>"Oops! Energy must not be less than  previous reading({$record->energy})"];
				// }
					
			//}
			# update now
			//consumption
			
			if ($result) {
				return ['status'=>true,'message'=>$type." is updated",'reading'=>$data['reading'],'type'=>"energy"];
			} else {
				return ['status'=>fasle,'message'=>"cannot update"];
			}
			

		
		} else {
			//other parameters

			//$this->db->select($type);
		$this->db->where('id',$data['reading_id']);
		$query=$this->db->get($this->log_sheet_table);
		$row= $query->row();

		//var_dump($row);
		//check if reading has been entered for a time ahead
		$this->db->where(array('hour'=>$row->hour+1,"feeder_id"=>$row->feeder_id,'isIncommer'=>$isIncommer));
		$queryCh1=$this->db->get($this->log_sheet_table);
		$rowX= $queryCh1->row();
		//var_dump($rowX);
		//data has been entered ahead
		// if ($rowX) {
		// 	return ['status'=>false,'message'=>"You cannot update this value now"];
		// }

		if ($type=="current_reading") {
			//$type = (float)$type;
			$reading=(sqrt(3)*$row->voltage*$data['reading']*$row->pf)/1000;
			$load_mvr=sqrt(3)*sqrt(1-($row->pf*$row->pf))*$row->voltage*$data['reading'];
		}elseif ($type=="voltage") {
			//$type = (float)$type;
			$reading=(sqrt(3)*$data['reading']*$row->current_reading*$row->pf)/1000;
			$load_mvr=sqrt(3)*sqrt(1-($row->pf*$row->pf))*$data['reading']*$row->current_reading;
		}elseif ($type=="pf") {
			//$type = (float)$type;
			$reading=(sqrt(3)*$row->voltage*$row->current_reading*$data['reading'])/1000;
			$load_mvr=sqrt(3)*sqrt(1-($data['reading']*$data['reading']))*$row->voltage*$row->current_reading;
		}
		 else {
			$load_mvr=$row->load_mvr;
			$reading=$row->load_reading;
		}
		//var_dump($data);
		
		if ($data['status']=="on") {
			$this->db->where('id',$data['reading_id']);
			$result=$this->db->update($this->log_sheet_table,array($type=>$data['reading'],"load_reading"=>$reading,"load_mvr"=>$load_mvr,"updated_load_reading"=>$row->load_reading,"updated_current_reading"=>$row->current_reading,"updated_".$type=>$row->$type,"updated_at"=>date("Y-m-d H:i:s"),"status"=>$data['status']));
		} else {
			$this->db->where('id',$data['reading_id']);
			$result=$this->db->update($this->log_sheet_table,array($type=>$data['reading'],"load_reading"=>0,"load_mvr"=>0,"updated_load_reading"=>$row->load_reading,"updated_current_reading"=>$row->current_reading,"updated_".$type=>$row->$type,"updated_at"=>date("Y-m-d H:i:s"),"status"=>$data['status']));
		}
		

		
			if ($result) {
				return ['status'=>true,'message'=>str_replace('_', ' ', $type)." is updated",'reading'=>$data['reading'],"feeder_status"=>$data['status'],'type'=>"param"];
			} else {
				return ['status'=>fasle,'message'=>"cannot update"];
			}
		}
		
	
		
	}

	// public function update_reading($data){
	// 	$type=strtolower($data['type']);
		
	// 	if ($data['type']=="energy") {
				
	// 	//$this->db->select($type);
	// 	$this->db->where(array('id'=>$data['reading_id']));
	// 	$query=$this->db->get($this->energy_sheet_table);
	// 	$row= $query->row();
	// 	//var_dump($row);
	// 	//check if reading has been entered for a time ahead
	// 	$this->db->where(array('hour'=>$row->hour+1,"feeder_id"=>$row->feeder_id,'isIncommer'=>0));
	// 	$queryCh1=$this->db->get($this->energy_sheet_table);
	// 	$rowX= $queryCh1->row();
	// 	//user cannot edit reading cos he has entered reading ahead
	// 	//unless he is a dispatch or admin
	// 	if ($rowX) {
	// 		return ['status'=>false,'message'=>"You cannot update this value now"];
	// 	}

	// 	//get previous data
	// 	if ($row->hour==0) {
	// 		$hour=23;
	// 	} else {
	// 	   $hour=$row->hour-1;
	// 	}
		
	// 	$this->db->where(array('hour'=>$hour,"feeder_id"=>$row->feeder_id,"isIncommer"=>0));
	// 	$this->db->order_by("id","DESC");
	// 	$queryPrev=$this->db->get($this->energy_sheet_table);
	// 	$rowPrx= $queryPrev->row();

	// 	//,....

	// 	$type=$type;
	// 	//if ($row->$type>$data['reading'] || $rowPrx->$type>$data['reading']) {
	// 	if ( $rowPrx->$type>$data['reading']) {
	// 		//updated reading is less than previous reading
	// 		return ['status'=>false,'message'=>"Energy must not be less than previous  reading({$rowPrx->energy})"];
	// 	} 

	// 	// $this->db->select($type);
	// 	// $this->db->where(array('id <'=>$data['reading_id'],'isIncommer'=>0));
	// 	// $this->db->order_by("ID","DESC");
	// 	// $query=$this->db->get($this->energy_sheet_table);
	// 	// $record= $query->row();

			
	// 			//var_dump($record);
	// 		//if ($record){
	// 			# check if previous energy is greater than current energy
	// 			// if($record->energy>$data['reading']){
	// 			// 	return ['status'=>false,"message"=>"Oops! Energy must not be less than  previous reading({$record->energy})"];
	// 			// }
					
	// 		//}
	// 		# update now
	// 		//consumption
	// 		$hourly_consump=$data['reading']-$rowPrx->energy;
	// 		$this->db->where('id',$data['reading_id']);
	// 		$result=$this->db->update($this->energy_sheet_table,array($type=>$data['reading'],"remarks"=>$data['remarks'],"updated_energy"=>$row->$type,"updated_at"=>date("Y-m-d H:i:s"),"hourly_comsumption"=>$hourly_consump));
	// 		if ($result) {
	// 			return ['status'=>true,'message'=>$type." is updated",'reading'=>$data['reading'],'type'=>"energy"];
	// 		} else {
	// 			return ['status'=>fasle,'message'=>"cannot update"];
	// 		}
			

		
	// 	} else {
	// 		//other parameters

	// 		//$this->db->select($type);
	// 	$this->db->where('id',$data['reading_id']);
	// 	$query=$this->db->get($this->log_sheet_table);
	// 	$row= $query->row();

	// 	//var_dump($row);
	// 	//check if reading has been entered for a time ahead
	// 	$this->db->where(array('hour'=>$row->hour+1,"feeder_id"=>$row->feeder_id,'isIncommer'=>0));
	// 	$queryCh1=$this->db->get($this->log_sheet_table);
	// 	$rowX= $queryCh1->row();
	// 	//var_dump($rowX);
	// 	//data has been entered ahead
	// 	// if ($rowX) {
	// 	// 	return ['status'=>false,'message'=>"You cannot update this value now"];
	// 	// }

	// 	if ($type=="current_reading") {
	// 		//$type = (float)$type;
	// 		$reading=(sqrt(3)*$row->voltage*$data['reading']*$row->pf)/1000;
	// 		$load_mvr=sqrt(3)*sqrt(1-($row->pf*$row->pf))*$row->voltage*$data['reading'];
	// 	}elseif ($type=="voltage") {
	// 		//$type = (float)$type;
	// 		$reading=(sqrt(3)*$data['reading']*$row->current_reading*$row->pf)/1000;
	// 		$load_mvr=sqrt(3)*sqrt(1-($row->pf*$row->pf))*$data['reading']*$row->current_reading;
	// 	}elseif ($type=="pf") {
	// 		//$type = (float)$type;
	// 		$reading=(sqrt(3)*$row->voltage*$row->current_reading*$data['reading'])/1000;
	// 		$load_mvr=sqrt(3)*sqrt(1-($data['reading']*$data['reading']))*$row->voltage*$row->current_reading;
	// 	}
	// 	 else {
	// 		$load_mvr=$row->load_mvr;
	// 		$reading=$row->load_reading;
	// 	}
	// 	//var_dump($data);
		
	// 	if ($data['status']=="on") {
	// 		$this->db->where('id',$data['reading_id']);
	// 		$result=$this->db->update($this->log_sheet_table,array($type=>$data['reading'],"load_reading"=>$reading,"load_mvr"=>$load_mvr,"updated_load_reading"=>$row->load_reading,"updated_current_reading"=>$row->current_reading,"updated_".$type=>$row->$type,"updated_at"=>date("Y-m-d H:i:s"),"status"=>$data['status']));
	// 	} else {
	// 		$this->db->where('id',$data['reading_id']);
	// 		$result=$this->db->update($this->log_sheet_table,array($type=>$data['reading'],"load_reading"=>0,"load_mvr"=>0,"updated_load_reading"=>$row->load_reading,"updated_current_reading"=>$row->current_reading,"updated_".$type=>$row->$type,"updated_at"=>date("Y-m-d H:i:s"),"status"=>$data['status']));
	// 	}
		

		
	// 		if ($result) {
	// 			return ['status'=>true,'message'=>str_replace('_', ' ', $type)." is updated",'reading'=>$data['reading'],"feeder_status"=>$data['status'],'type'=>"param"];
	// 		} else {
	// 			return ['status'=>fasle,'message'=>"cannot update"];
	// 		}
	// 	}
		
	
		
	// }
	public function get_iss(){
		//$this->db->distinct('ISS');
		$this->db->select(array('id','iss_names'));
		$query=$this->db->get($this->iss_tables);
		return $query->result();
	}
	public function get_transmissions(){
		//$this->db->distinct('ISS');
		$this->db->select(array('id','tsname'));
		$query=$this->db->get($this->transmission_table);
		return $query->result();
	}
	public function get_iss_id($iss_id){
		// $this->db->select('iss_names');
		$this->db->where('id',$iss_id);
		$query=$this->db->get($this->iss_tables);
		return $query->row();
	}
	//get tra
	public function get_transmission_id($ts_id){
		$this->db->select(['tsname','id']);
		$this->db->where('id',$ts_id);
		$query=$this->db->get($this->transmission_table);
		return $query->row();
	}

	//get injection substation for a user
	public function get_station($user){
		return $this->get_iss_id($user->iss);
	}

	//get transmission station by user
	public function get_transmission_by_user($user){

		return $this->get_transmission_id($user->transmission_id);
		
	}

	public function get_feeder_station($user){
		if ($user->role_name!="admin") {
		if ($user->station_type=="TS") {
			return $this->get_feeders_ts($user->station_name);
		} elseif($user->station_type=="ISS") {
			return $this->get_feeder_iss($user->station_name);
		}
	}else{
		return;
	}
	}


	public function insert_bot(){
			
			for ($i=0; $i <24 ; $i++) { 
			$this->db->insert("log_sheet",["feeder_name"=>"ABULOMA","hour"=>$i,"load"=>($i+3)*3,"pf"=>$i*2+4,"current"=>$i*2+2,"voltage"=>$i*2+3,"frequency"=>$i*2+1,"captured_at"=>date("Y-m-d",strtotime("+ ".$d." days")),"created_by"=>1]);
		
		}
		
	}
}



?>