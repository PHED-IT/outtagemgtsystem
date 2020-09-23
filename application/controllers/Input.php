<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
//this is controller for log entry
class Input extends My_Controller
{
	
	//this is for log entry
	public function index(){
		
		//$this->input_model->insert_bot();
		
		// $data['ts_data']=$this->input_model->get_transmissions();
		// $data['iss_data']=$this->input_model->get_iss();
		$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		$data['user']=$user;
		//check if user is a dso or transmission dso
		if ($user->role_id==8) {
			#dso
			$data['station']=$this->input_model->get_station($user);
		} elseif($user->role_id==35) {
			# transminssion dso
			$data['station']=$this->input_model->get_transmission_by_user($user);
		}
		
		
		
		//$data['feeders']=$this->input_model->get_feeder_station($data['user']);
		//$data['last_reading']=$this->input_model->get_last_reading(array("user_id"=>$this->session->userdata('USER_ID'),"type"=>"log"));
		$data['title']="Log entry sheet";
		//$data['summary']=$this->input_model->get_ibc_summary();
		$this->load->view('Layouts/header',$data);
		$this->load->view('inputs/log',$data);
		$this->load->view('Layouts/footer');
		//echo $this->session->userdata('USER_ID');
	
	}
	//this is custom function for dispatch log entry
	public function index_new(){
		
		//$this->input_model->insert_bot();
		
		 $data['ts_data']=$this->input_model->get_transmission_stations();
		
		$data['title']="Log entry sheet";
		//$data['summary']=$this->input_model->get_ibc_summary();
		$this->load->view('Layouts/header',$data);
		$this->load->view('inputs/log_new',$data);
		$this->load->view('Layouts/footer');
		//echo $this->session->userdata('USER_ID');
	
	}

//this function stores log  and returns json
	public function store_log(){
		if ($this->input->post('voltage_level')=="11kv") {
			$transformer=$this->input->post('transformer_iss');
		} else {
			$transformer=$this->input->post('transformer');
		}
		
		$insert_data=array("feeders"=>$this->input->post('feeders'),'readings'=>$this->input->post('readings'),'load_mvr'=>$this->input->post('load_mvr'),'voltage'=>$this->input->post('voltage'),'pf'=>$this->input->post('pf'),'current'=>$this->input->post('current'),'load_mw_in'=>$this->input->post('load_mw_in'),'load_mvr_in'=>$this->input->post('load_mvr_in'),'pf_in'=>$this->input->post('pf_in'),'voltage_in'=>$this->input->post('voltage_in'),'current_in'=>$this->input->post('current_in'),'frequency'=>$this->input->post('frequency'),'hour'=>$this->input->post('hour'),'created_by'=>$this->session->userdata('USER_ID'),'remarks'=>$this->input->post('remarks'),'station_id'=>$this->input->post('station_id'),'voltage_level'=>$this->input->post('voltage_level'),'captured_date'=>$this->input->post('captured_date'),'status'=>$this->input->post('status'),'isIncommer'=>$this->input->post('isIncommer'),"transformer"=>$transformer);
		
		$result=$this->input_model->store_log($insert_data);
		echo json_encode($result);
	}
	public function store_log_new(){
		if ($this->input->post('isIncommer')=="true") {
			$feeder=$this->input->post('transformer');
		} else {
			$feeder=$this->input->post('feeder');
		}
		
		$insert_data=array("feeder"=>$feeder,'readings'=>$this->input->post('readings'),'load_mvr'=>$this->input->post('load_mvr'),'voltage'=>$this->input->post('voltage'),'pf'=>$this->input->post('pf'),'current'=>$this->input->post('current'),'load_mw_in'=>$this->input->post('load_mw_in'),'load_mvr_in'=>$this->input->post('load_mvr_in'),'pf_in'=>$this->input->post('pf_in'),'voltage_in'=>$this->input->post('voltage_in'),'current_in'=>$this->input->post('current_in'),'frequency'=>$this->input->post('frequency'),'hour'=>$this->input->post('hour'),'created_by'=>$this->session->userdata('USER_ID'),'remarks'=>$this->input->post('remarks'),'station_id'=>$this->input->post('station_id'),'voltage_level'=>$this->input->post('voltage_level'),'captured_date'=>$this->input->post('captured_date'),'status'=>$this->input->post('status'),'isIncommer'=>$this->input->post('isIncommer'),"transformer"=>$this->input->post('transformer'));
		
		$result=$this->input_model->store_log_new($insert_data);
		echo json_encode($result);
	}

	//stores energy reading
	public function store_energy_log(){
		//check if voltage is 11kv
		if ($this->input->post('voltage_level')=="11kv") {
			//get transformer from iss
			$transformer=$this->input->post('transformer_iss');
		} else {
			//get transformer for ts
			$transformer=$this->input->post('transformer');
		}
		$insert_data=array("feeders"=>$this->input->post('feeders'),'energy'=>$this->input->post('energy'),'energy_in'=>$this->input->post('energy_in'),'hour'=>$this->input->post('hour'),'created_by'=>$this->session->userdata('USER_ID'),'remarks'=>$this->input->post('remarks'),'station_id'=>$this->input->post('station_id'),'voltage_level'=>$this->input->post('voltage_level'),'captured_date'=>$this->input->post('captured_date'),'isIncommer'=>$this->input->post('isIncommer'),"transformer"=>$transformer);

		$result=$this->input_model->store_energy($insert_data);
		echo json_encode($result);
	}

	//this shows page for energy input
	public function energy(){
		// $this->form_validation->set_rules('captured_date','Captured Date',"required");
		// $this->form_validation->set_rules('hour','Captured Hour',"required");
		// $this->form_validation->set_rules('energy[]','Reading',"required|numeric");
		// if ($this->form_validation->run()==FALSE) {
		// $data['ts_data']=$this->input_model->get_transmissions();
		// $data['iss_data']=$this->input_model->get_iss();

		$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		$data['user']=$user;
		//check if user is a dso or transmission dso
		if ($user->role_id==8) {
			#dso
			$data['station']=$this->input_model->get_station($user);
		} elseif($user->role_id==35) {
			# transminssion dso
			$data['station']=$this->input_model->get_transmission_by_user($user);
		}
		//$data['last_reading']=$this->input_model->get_last_reading(array("user_id"=>$this->session->userdata('USER_ID'),"type"=>"energy"));
		//$data['station']=$this->input_model->get_station($data['user']);
		//$data['feeders']=$this->input_model->get_feeder_station($data['user']);
		$data['title']="Energy log sheet";
		//$data['summary']=$this->input_model->get_ibc_summary();
		$this->load->view('Layouts/header',$data);
		$this->load->view('inputs/energy',$data);
		$this->load->view('Layouts/footer');
		//echo $this->session->userdata('USER_ID');
	
	}


	
	//this fnction get 33kv feeder by transformer id
	public function get_feeders_ts(){
		//var_dump($this->input->post('logType'));
		$trans_st=$this->input->post('trans_st');
		if (!empty($this->input->post('logType'))) {
			$logType=$this->input->post('logType');
			$last_reading=$this->input_model->get_last_reading(array("voltage_level"=>"33kv","station_id"=>$trans_st,"type"=>$logType,"isFeeder"=>false));
			//var_dump($last_reading);
		$feaders=$this->input_model->get_feeders_ts($trans_st);
		$data=array("record"=>$feaders,"last_reading"=>$last_reading);
			echo json_encode($data);
		} else {
			$feaders=$this->input_model->get_feeders_ts($trans_st);
			echo json_encode($feaders);
		}
		
		
	}

	public function getLatestFeederReading(){

		$last_reading=$this->input_model->get_last_reading(array("voltage_level"=>"33kv","feeder_id"=>$this->input->post('feeder_id'),"type"=>"load","isFeeder"=>true));
		echo json_encode($last_reading);
	}
	//this gets all transformer by transmission station id
	public function get_transformer_ts(){
		$trans_st=$this->input->post('trans_st');
		//$logType=$this->input->post('logType');
		$transformer=$this->admin_model->get_transformer_ts(array("st_id"=>$trans_st,"asset_type"=>"TS"));
		
			echo json_encode($transformer);	
	}
	//this function gets all feeders and transformer by transmission
	public function get_feeders_by_transmission(){

		$trans_st=$this->input->post('trans_st');
		//$logType=$this->input->post('logType');
		$feeders=$this->admin_model->get_feeders_by_transmission(array("st_id"=>$trans_st,"voltage_level"=>"33kv"));
		$last_reading=$this->input_model->get_last_reading_by_transmission(array("voltage_level"=>"33kv","station_id"=>$trans_st));
		$data=array("record"=>$feeders,"last_reading"=>$last_reading);
			echo json_encode($data);	
	}
	//this gets all transformer by iss id
	public function get_transformer_iss(){
		//$logType=$this->input->post('logType');
		$iss_id=$this->input->post('iss_id');
		$transformer=$this->admin_model->get_transformer_iss(array("st_id"=>$iss_id));
		echo json_encode($transformer);
	}

	//this returns all feeder by transformer id and voltage level and also returns latest reading
	public function get_feeder_iss(){
		$transformer_id=$this->input->post('transformer_id');
		if (!empty($this->input->post('logType'))) {
			$logType=$this->input->post('logType');
			$last_reading=$this->input_model->get_last_reading(array("voltage_level"=>"11kv","station_id"=>$transformer_id,"type"=>$logType,"isFeeder"=>false));
			//var_dump($last_reading);
		$feaders=$this->input_model->get_feeder_iss($transformer_id);
		$data=array("record"=>$feaders,"last_reading"=>$last_reading);
			echo json_encode($data);
		} else {
		$feaders=$this->input_model->get_feeder_iss($transformer_id);
		echo json_encode($feaders);
	}
	}

	protected function format_date($dt,$date,$param,$feeder){
		if ($dt=="day") {
				$month=substr($date, 5,7);
				$year=substr($date, 0,4);
				//$month_dt=str_replace("/", "-", "2/".$date);
			$date_title=date("l, jS F Y",strtotime($date));
			$title=$param." REPORT FOR ".$feeder." FOR <br/>".$date_title;
			} elseif($dt=="month") {
				$month=substr($date, 0,2);
				$year=substr($date, 3,6);
				$month_dt=str_replace("/", "-", "2/".$date);
			$date_title=date("F Y",strtotime($month_dt));
			$title=strtoupper($param)." REPORT FOR ".$feeder." FOR THE MONTH OF".strtoupper($date_title);
			}
			return ["month"=>$month,"year"=>$year,"title"=>$title];
	}

	public function show_all_feeder_reading(){
		$this->form_validation->set_rules('date','DATE',"required");
		$this->form_validation->set_rules('voltage_level','VOLTAGE LEVEL',"required");
		// $this->form_validation->set_rules('log_type','LOG TYPE',"required");
		if ($this->form_validation->run()==FALSE){
			//$data['station']=$this->input_model->get_station($data['user']);
			$data['tile']="Show Reading";
			$this->load->view('Layouts/header',$data);
			$this->load->view('inputs/all_feeder_reading',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('date');
			$report_type=$this->input->post('report_type');
			//$insert_data=array("date"=>$station_id,"voltage_level"=>$voltage_level);
			$feeders=$this->admin_model->get_feeders(["voltage_level"=>$this->input->post('voltage_level')]);
			if ($report_type=="current_reading") {
				$type="Current(AMP)";
			} else if($report_type=="load_reading") {
				$type="Load(MW)";
				# code...
			}else{
				$type="Energy";
			}
			
			$title=$this->format_date("day",$date,$type,$this->input->post('voltage_level')." Feeders")['title'];
			$data['feeders']=$feeders;
			$data['title']=$title;
			$data['date']=$date;
			$data['report_type']=$report_type;
			$data['controller']=$this;
			$this->load->view('Layouts/header',$data);
			$this->load->view('inputs/all_feeder_reading',$data);
			$this->load->view('Layouts/footer');

		}
	}

	//show the view for edit for 33kv energy for now
	public function edit_log_new(){
		$this->form_validation->set_rules('captured_date','DATE',"required");
		$this->form_validation->set_rules('station_id','STATION',"required");
		$this->form_validation->set_rules('log_type','LOG TYPE',"required");
		if ($this->form_validation->run()==FALSE){
			$data['title']="Edit Log";
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			//this gets users station(transmision or injection sub station)
			$data['station']=$this->input_model->get_station($data['user']);
			$data['transmision']=$this->mis_model->get_transmission_stations();
			$this->load->view('Layouts/header',$data);
			$this->load->view('inputs/edit_log_sheet_new',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('captured_date');
			$log_type=$this->input->post('log_type');
			
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			$data['station']=$this->input_model->get_station($data['user']);
			$data['transmision']=$this->mis_model->get_transmission_stations();
			$trans_id=$this->input->post('station_id');
			$insert_data=array("station_id"=>$trans_id,"date"=>$this->input->post('captured_date'),"log_type"=>$this->input->post('log_type'));
			$month=substr($date, 0,2);
			$year=substr($date, 3,6);

			$data['status']=$this->mis_model->get_feeder_status();
			$data['transformers']=$this->admin_model->get_transformer_ts(["voltage_level"=>"33kv","st_id"=>$trans_id]);
		// 	$data['summary']=$this->input_model->getReadingByFeeder(['feeder_id'=>]);
			
		// 	//$feeder_name=$this->input_model->getFeeder($this->input->post('feeders'))->feeder_name;
		// 	//$data['feeder_name']=$feeder_name;
			$data['month']=$month;
			$data['year']=$year;
			$data['dt']="month";
			if ($log_type=="load_reading") {
				$log_type_title="Load (MW)";
			}elseif ($log_type=="load_mvr") {
				$log_type_title="Load(MVR)";
			}elseif ($log_type=="current_reading") {
				$log_type_title="CURRENT(AMP)";
			}elseif ($log_type=="pf") {
				$log_type_title="Power Factor";
			}  else {
				$log_type_title=$log_type;
			}
			$data['log_type']=$log_type;
			$transmission_station=$this->mis_model->get_transmission($trans_id);
			$title=$this->format_date("month",$date,$log_type_title,$transmission_station->tsname)['title'];
			$data['title']=$title;
			$data['controller']=$this;
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('inputs/edit_log_sheet_new',$data);
			$this->load->view('Layouts/footer');
		}
		
	 }
	 public function get_feeder_transformer($transformer_id){
	 	return $this->admin_model->get_feeder_transformer($transformer_id);
	 }
	 public function getReadingByFeeder($data){
	 	return $this->input_model->getReadingByFeeder($data);
	 }
	// //show the view for edit
	 //this is the main edit just change it to edit_log
	public function edit_hourly_log(){
		$this->form_validation->set_rules('captured_date','DATE',"required");
		$this->form_validation->set_rules('feeders','FEEDER NAME',"required");
		$this->form_validation->set_rules('log_type','LOG TYPE',"required");
		if ($this->form_validation->run()==FALSE){
			$data['title']="Edit Log";
			$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		$data['user']=$user;
		//check if user is a dso or transmission dso
		if ($user->role_id==8) {
			#dso
			$data['station']=$this->input_model->get_station($user);
		} elseif($user->role_id==35) {
			# transminssion dso
			$data['station']=$this->input_model->get_transmission_by_user($user);
		}
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('inputs/edit_log_sheet',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('captured_date');
			$log_type=$this->input->post('log_type');
			
			$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		$data['user']=$user;
		//check if user is a dso or transmission dso
		if ($user->role_id==8) {
			#dso
			$data['station']=$this->input_model->get_station($user);
		} elseif($user->role_id==35) {
			# transminssion dso
			$data['station']=$this->input_model->get_transmission_by_user($user);
		}
			
			$insert_data=array("feeder_id"=>$this->input->post('feeders'),"date"=>$this->input->post('captured_date'),"log_type"=>$this->input->post('log_type'));
			$month=substr($date, 0,2);
			$year=substr($date, 3,6);

			$data['status']=$this->mis_model->get_feeder_status();
			$data['summary']=$this->input_model->get_reading_feeder_date($insert_data);
			
			$feeder_name=$this->input_model->getFeeder($this->input->post('feeders'))->feeder_name;
			$data['feeder_id']=$this->input->post('feeders');
			$data['feeder_name']=$feeder_name;
			$data['month']=$month;
			$data['year']=$year;
			$data['dt']="month";
			if ($log_type=="load_reading") {
				$log_type_title="Load (MW)";
			}elseif ($log_type=="load_mvr") {
				$log_type_title="Load(MVR)";
			}elseif ($log_type=="current_reading") {
				$log_type_title="CURRENT(AMP)";
			}elseif ($log_type=="pf") {
				$log_type_title="Power Factor";
			}  else {
				$log_type_title=$log_type;
			}
			$data['log_type']=$log_type;
			$data['title']=strtoupper($log_type_title)."  FOR ".$feeder_name." ".$date;
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('inputs/edit_log_sheet',$data);
			$this->load->view('Layouts/footer');
		}
		
	}

	
	//this shows all selected reading by day and hour for edit
	public function edit_log(){
		$this->form_validation->set_rules('captured_date','DATE',"required");
		// $this->form_validation->set_rules('station_id','STATION',"required");
		$this->form_validation->set_rules('log_type','LOG TYPE',"required");
		if ($this->form_validation->run()==FALSE){
			$data['title']="Edit Log";
			$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			$data['user']=$user;
			//this gets users station(transmision or injection sub station)
			if ($user->role_id==8) {
			#dso
			$data['station']=$this->input_model->get_station($user);
			} elseif($user->role_id==35) {
				# transminssion dso
				$data['station']=$this->input_model->get_transmission_by_user($user);
			}

			
			$data['transmision']=$this->mis_model->get_transmission_stations();
			$this->load->view('Layouts/header',$data);
			$this->load->view('inputs/edit_hourly_log_sheet_new',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('captured_date');
			$log_type=$this->input->post('log_type');
			
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			$data['user']=$user;
			//this gets users station(transmision or injection sub station)
			if ($user->role_id==8) {
			#dso
			$data['station']=$this->input_model->get_station($user);
			} elseif($user->role_id==35) {
				# transminssion dso
				$data['station']=$this->input_model->get_transmission_by_user($user);
			}
			//$data['station']=$this->input_model->get_station($data['user']);
			$data['transmision']=$this->mis_model->get_transmission_stations();
			
			//$insert_data=array("station_id"=>$trans_id,"date"=>$this->input->post('captured_date'),"log_type"=>$this->input->post('log_type'));
			// $month=substr($date, 0,2);
			// $year=substr($date, 3,6);

			 $data['status']=$this->mis_model->get_feeder_status();
			 
			
		// 	$data['summary']=$this->input_model->getReadingByFeeder(['feeder_id'=>]);
			
		// 	//$feeder_name=$this->input_model->getFeeder($this->input->post('feeders'))->feeder_name;
		// 	//$data['feeder_name']=$feeder_name;
			// $data['month']=$month;
			// $data['year']=$year;
			$data['dt']="day";
			$data['captured_at']=$date;
			if ($log_type=="load_reading") {
				$log_type_title="Load (MW)";
			}elseif ($log_type=="load_mvr") {
				$log_type_title="Load(MVR)";
			}elseif ($log_type=="current_reading") {
				$log_type_title="CURRENT(AMP)";
			}elseif ($log_type=="pf") {
				$log_type_title="Power Factor";
			}  else {
				$log_type_title=$log_type;
			}
			$data['log_type']=$log_type;
			if (null !==$this->input->post('asset_type')) {
					if ($this->input->post('asset_type')=="TS") {
			 	//voltage_level==33kv
			 	$trans_id=$this->input->post('transmission_id');
			 	$data['transformers']=$this->admin_model->get_transformer_ts(["voltage_level"=>"33kv","st_id"=>$trans_id]);
			 	$transmission_station=$this->mis_model->get_transmission($trans_id);
			$title=$this->format_date("day",$date,$log_type_title,$transmission_station->tsname)['title'];
			 } else {
			 	//voltage_level==11kv
			 	$trans_id=$this->input->post('substation_id');
			 	$data['transformers']=$this->admin_model->get_transformer_iss(["voltage_level"=>"11kv","st_id"=>$trans_id]);
			 	$substation_station=$this->mis_model->get_substation($trans_id);
			$title=$this->format_date("day",$date,$log_type_title,$substation_station->iss_names)['title'];
			 }
			 
			} else {
				$trans_id=$this->input->post('transmission_id');
			 	$data['transformers']=$this->admin_model->get_transformer_ts(["voltage_level"=>"33kv","st_id"=>$trans_id]);
			 	$transmission_station=$this->mis_model->get_transmission($trans_id);
			$title=$this->format_date("day",$date,$log_type_title,$transmission_station->tsname)['title'];
			}
			
		
			
			$data['title']=$title;
			$data['controller']=$this;
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('inputs/edit_hourly_log_sheet_new',$data);
			$this->load->view('Layouts/footer');
		}
		
	 }
	// 
	public function get_reading_date(){
		$day=$this->input->post('day');
		$month=$this->input->post('month');
		$year=$this->input->post('year');

		$record=$this->input_model->get_reading_date($day,$month,$year);
		echo json_encode($record);
	}

	public function update_reading(){
		$insert_data=array("status"=>$this->input->post('status'),"day"=>$this->input->post('day'),"reading"=>$this->input->post('reading'),"reading_id"=>$this->input->post('reading_id'),'type'=>$this->input->post('type'),'feeder_id'=>$this->input->post('feeder_id'),"isIncommer"=>$this->input->post('isIncommer'));
		$result=$this->input_model->update_reading($insert_data);
			 //echo $result;
		echo json_encode($result);
	}
	public function delete_reading(){
		$insert_data=array("reading_id"=>$this->input->post('reading_id'),'type'=>$this->input->post('type'));
		$result=$this->input_model->delete_reading($insert_data);
			 //echo $result;
		echo json_encode($result);
	}

	//this gets either transmission stations or iss depends on the code(TS or ISS)

	public function get_stations(){
		$type=$this->input->post('station_type');
		if ($type=="TS") {
			$result=$this->input_model->get_transmission_stations();
		} else {
			$result=$this->input_model->get_iss();
		}
		echo json_encode($result);	
	}

}

?>