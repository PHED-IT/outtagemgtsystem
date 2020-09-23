<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Mis extends MY_Controller
{
	public function index(){

	}
	//this is for load report
	public function load_report(){
		//$this->form_validation->set_rules('captured_date','DATE',"required");
		$this->form_validation->set_rules('dt','CHOOSE DATE TYPE',"required");
		
		if ($this->form_validation->run()==FALSE){
			//$data['ts_data']=$this->input_model->get_transmissions();
		//$data['iss_data']=$this->input_model->get_iss();
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		$data['station']=$this->input_model->get_station($data['user']);
			$data['title']="Load(MW) Report";
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/load_report',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=!empty($this->input->post('captured_month_date'))?$this->input->post('captured_month_date'):$this->input->post('captured_daily_date');
			$dt=$this->input->post('dt');
			
			$asset_type=$this->input->post('asset_type');
			//check if user wantsto view all feeder or a feeder 
			if ($asset_type=="TS" && empty($this->input->post('feeder_name'))) {
				//user choose transmission only
				$station_id=$this->input->post('trans_st');
				$insert_data=array("station_id"=>$station_id,"voltage_level"=>"33kv");
				$data['feeder_wise']=false;
				$data['station_id']=$station_id;
				$summary=$this->mis_model->feederTransformerByStation($insert_data);
				$transmission_station=$this->mis_model->get_transmission($station_id);
				$title=$this->format_date("day",$date,"Load(MW)",$transmission_station->tsname)['title'];
			}elseif ($asset_type=="ISS" && empty($this->input->post('feeder_name'))) {
				//user chooses iss only

				$station_id=$this->input->post('iss_name');
				$insert_data=array("station_id"=>$station_id,"voltage_level"=>"11kv");
				$data['feeder_wise']=false;
				$data['station_id']=$station_id;
				$sub_station=$this->mis_model->get_substation($station_id);
				$title=$this->format_date("day",$date,"Load(MW)",$sub_station->iss_names)['title'];
				$summary=$this->mis_model->feederTransformerByStation($insert_data);
			}

			 else {
			 	//user chooses feeder only
			 	$feeder_name=$this->input_model->getFeeder($this->input->post('feeder_name'))->feeder_name;
				$insert_data=array("feeder_id"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"load_reading","dt"=>$dt,"day_start"=>0,"day_end"=>17,"night_start"=>18,"night_end"=>23);
				$data['feeder_wise']=true;
				$format_date=$this->format_date($dt,$date,"LOAD(M/W)",$feeder_name);
			$month=$format_date['month'];
			$year=$format_date['year'];
			$data['search_params']=array("feeder_id"=>$this->input->post('feeder_name'),"feeder_name"=>$feeder_name,"date"=>$date,'dt'=>$dt);
			$data['feeder_status']=$this->mis_model->show_feeder_status($insert_data);
			$data['average']=$this->mis_model->get_reading_avg($insert_data);
			$data['min']=$this->mis_model->get_reading_min($insert_data);
			$data['max']=$this->mis_model->get_reading_max($insert_data);
			$data['asset_type']=$asset_type;
			$data['month']=$month;
			$data['year']=$year;
			$data['dt']=$dt;
			$data['dayPeak']=$this->mis_model->get_reading_max($insert_data,"day");
			$data['nightPeak']=$this->mis_model->get_reading_max($insert_data,"night");
			$data['dayAverage']=$this->mis_model->hourly_avg_reading($insert_data,"","night");
			$data['nightAverage']=$this->mis_model->hourly_avg_reading($insert_data,"","night");
			// $data['dayAverage']=$dt;
			// $data['nightAverage']=$dt;

			$title=$format_date['title'];
				$summary=$this->mis_model->logSheetTable($insert_data,$month,$year,$dt);

			}
			//var_dump($station_id);
			//$this->input->post('trans_id');
			//$feeder_name=$this->input_model->getFeeder($this->input->post('feeder_name'))->feeder_name;
			
			//$insert_data=array("station_id"=>$this->input->post('trans_st'),"voltage_level"=>"33kv");
			
			
			// $format_date=$this->format_date($dt,$date,"LOAD(M/W)",$feeder_name);
			// $month=$format_date['month'];
			// $year=$format_date['year'];
			
			//$data['search_params']=array("feeder_id"=>$this->input->post('feeder_name'),"feeder_name"=>$feeder_name,"date"=>$date,'dt'=>$dt);
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			
			$data['date']=$date;
			$data['controller']=$this;
			$data['station']=$this->input_model->get_station($data['user']);
			$data['summary']=$summary;
			

			$data['title']=$title;
			// $data['date']=$date;
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/load_report',$data);
			$this->load->view('Layouts/footer');
		}
		
	}

	public function get_latest_fault(){
		$outage=$this->FaultResponse_model->get_latest_fault();
		//var_dump($outage);
		//get the enumeration code.. per asset
		$assetId="";
		$assetType="";
		if ($outage->category=="Feeder") {
			if ($outage->voltage_level=="33kv") {
				$assetId=$this->admin_model->get_feeder33kv_by_id($outage->equipment_id)->enum_id;
				$assetId=($assetId==0)?"":$assetId;
				$assetType="FEEDER33ID";
			}else {
				//http://localhost:8084/nomsapiwslim/v1/getCustomersByAssets
			# 11kv
			$assetId=$this->admin_model->get_feeder11kv_by_id($outage->equipment_id)->enum_id;
			$assetId=($assetId==0)?"":$assetId;
			$assetType="FEEDER11ID";
		}
		} elseif ($outage->category=="Transformer") {
			$assetType="INJID";
			
		}elseif ($outage->category="Injection substation") {
			# iss
			$assetType="DTRID";
		}else{
			//transmission
		}

		echo json_encode(["status"=>true,"assetType"=>$assetType,"assetId"=>1115]);


	}

	public function get_all_customers(){
		$customers=$this->mis_model->get_all_customers();
		$faults=$this->mis_model->get_open_faults();
		//var_dump($faults);
		echo json_encode(["status"=>true,"customers"=>$customers,"faults"=>$faults]);

	}
	public function get_iss_enumeration(){
		$iss=$this->admin_model->get_iss_enumeration();
		//$faults=$this->mis_model->get_open_faults();
		//var_dump($faults);
		echo json_encode(["status"=>true,"iss"=>$iss]);

	}

	public function planned_outage(){
		
		$this->form_validation->set_rules('zone','Choose Zone',"required");
		$this->form_validation->set_rules('status','Choose status',"required");
		$this->form_validation->set_rules('outage_date','Choose outage date',"required");
		
		if ($this->form_validation->run()==FALSE){
		$data['outages']=$this->planned_model->get_outage_all(["planned_outages.voltage_level"=>"33kv"],'33kv');
		$data['outages_11kv']=$this->planned_model->get_outage_all(["planned_outages.voltage_level"=>"11kv"],'11kv');
		
		$data['title']="Planned Outage Report";
		$data['zones']=$this->admin_model->get_zones();
		$this->load->view('Layouts/header',$data);
		$this->load->view('mis/planned_outage',$data);
		$this->load->view('Layouts/footer');
	}else{

		$outage_date=explode('-', $this->input->post('outage_date'));
		list($start_date,$end_date)=$outage_date;
		$start_date=date("Y-m-d",strtotime($start_date));
		$end_date=date("Y-m-d",strtotime($end_date));
		//var_dump($end_date);
		$zone=$this->input->post('zone');
		$data['title_report']='Planned Outage Report Between '.$start_date.' To '.$end_date;
		if ($this->input->post('zone')=="all" && $this->input->post('status')=="all") {
			$data['outages']=$this->planned_model->get_outage_all("planned_outages.voltage_level='33kv' and Date(outage_request_date) BETWEEN '$start_date' and '$end_date'",'33kv');
		$data['outages_11kv']=$this->planned_model->get_outage_all("planned_outages.voltage_level='11kv' and Date(outage_request_date) BETWEEN '$start_date' and '$end_date'",'11kv');
		

		}elseif ($this->input->post('zone')!="all" && $this->input->post('status')=="all") {
			
			$data['outages']=$this->planned_model->get_outage_all("planned_outages.voltage_level='33kv' and Date(outage_request_date) BETWEEN '$start_date' and '$end_date' and planned_outages.request_from =$zone",'33kv');
		$data['outages_11kv']=$this->planned_model->get_outage_all("planned_outages.voltage_level='11kv' and Date(outage_request_date) BETWEEN '$start_date' and '$end_date' and planned_outages.request_from =$zone",'11kv');
		//$title='Planned Outage Report For ';
		}elseif ($this->input->post('zone')=="all" && $this->input->post('status')!="all") {
			$data['outages']=$this->planned_model->get_outage_all("planned_outages.voltage_level='33kv' and Date(outage_request_date) BETWEEN '$start_date' and '$end_date' and planned_outages.status >=5",'33kv');
		$data['outages_11kv']=$this->planned_model->get_outage_all("planned_outages.voltage_level='11kv' and Date(outage_request_date) BETWEEN '$start_date' and '$end_date' and planned_outages.status >=5",'11kv');
		}else{

			$data['outages']=$this->planned_model->get_outage_all("planned_outages.voltage_level='33kv' and Date(outage_request_date) BETWEEN '$start_date' and '$end_date' and planned_outages.status >=5 and planned_outages.request_from =$zone",'33kv');
		$data['outages_11kv']=$this->planned_model->get_outage_all("planned_outages.voltage_level='11kv' and Date(outage_request_date) BETWEEN '$start_date' and '$end_date' and planned_outages.status >=5 and planned_outages.request_from =$zone",'11kv');

		}
		

		
		
		$data['title']="Planned Outage Report";
		$data['zones']=$this->admin_model->get_zones();
		$this->load->view('Layouts/header',$data);
		$this->load->view('mis/planned_outage',$data);
		$this->load->view('Layouts/footer');
	}
				
	}

	public function get_iss_by_state(){
		$state=$this->input->post('state');
		//var_dump($state);
		 $iss=$this->admin_model->get_iss_by_state($state);
		$iss_faults=$this->mis_model->get_iss_on_fault();
		// //var_dump($faults);
		 echo json_encode(["status"=>true,"iss"=>$iss,"iss_faults"=>$iss_faults]);

	}
	public function get_fualt_feeder_by_iss(){
		$iss=$this->input->post('iss');
		//var_dump($iss);
		 $num=$this->mis_model->get_fualt_feeder_by_iss($iss);
		// //$faults=$this->mis_model->get_open_faults();
		// //var_dump($faults);
		 echo json_encode(["status"=>true,"num"=>$num]);

	}

	public function getReadingByFeeder($data){
	 	return $this->input_model->getReadingByFeeder($data);
	 }


	public function load_summary_report(){
		//$this->form_validation->set_rules('station_id','STATION',"required");
		$this->form_validation->set_rules('report_type','REPORT TYPE',"required");
		$this->form_validation->set_rules('date','DATE',"required");
		if ($this->form_validation->run()==FALSE){
			$data['title']="Load Summary";
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			//this gets users station(transmision or injection sub station)
			$data['station']=$this->input_model->get_station($data['user']);
			$data['transmision']=$this->mis_model->get_transmission_stations();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/load_summary',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('date');
			$report_type=$this->input->post('report_type');
			
			
			if ($report_type=="load_maximum") {
				$day_start=$this->input->post('day_start');
				$day_end=$this->input->post('day_end');
				$night_start=$this->input->post('night_start');
				$night_end=$this->input->post('night_end');

				$data['total_load']=$this->mis_model->total_load(["date"=>$date]);
				$data['summary']=$this->mis_model->load_maximum(["date"=>$date,"day_start"=>$day_start,"day_end"=>$day_end,"night_start"=>$night_start,"night_end"=>$night_end]);
			$title=$this->format_date("month",$date," MAXIMUM LOAD(MW) - ","TRANSMISSION STATIONS")['title'];
			}elseif ($report_type=="summation_transmission") {
				//this is to get the summation of transmission load mw
				$station_id=$this->input->post('station_id');
				$transmission_station=$this->mis_model->get_transmission($station_id);
				$format_date=$this->format_date("month",$date,"LOAD(MW) SUMMATION ",$transmission_station->tsname);
				$month=$format_date['month'];
				$year=$format_date['year'];
				$data['summary']=$this->mis_model->summation_transmission_load(["trans_id"=>$station_id,"date"=>$date,"dt"=>"month","month"=>$month,"year"=>$year,"isIncommer"=>0,"type"=>"load_reading"]);
				$title=$format_date['title'];
				$data['report_t']="summation_transmission";
			}elseif ($report_type=="phed_total") {
				//this is to get the sum of all  load mw
				$station_id=$this->input->post('station_id');
				//$transmission_station=$this->mis_model->get_transmission($station_id);
				$format_date=$this->format_date("month",$date,"PHED TOTAL(MW) ","");
				$month=$format_date['month'];
				$year=$format_date['year'];
				$data['summary']=$this->mis_model->phed_total_load(["trans_id"=>$station_id,"date"=>$date,"dt"=>"month","month"=>$month,"year"=>$year,"isIncommer"=>0,"type"=>"load_reading"])['table_data'];
				$title=$format_date['title'];
				$data['report_t']="phed_total";
			}elseif ($report_type=="summary") {
				$format_date=$this->format_date("month",$date,"COINCIDENTAL PEAK LOAD(MW)","");
		$month=$format_date['month'];
			$year=$format_date['year'];
			$data['summary']=$this->mis_model->coincindental_summary_report(["date"=>$date,"dt"=>"month","month"=>$month,"year"=>$year,"type"=>"load_reading"]);
			$title=$format_date['title'];
			$data['date']=$date;
			$data['dt']="month";
			$data['month']=$month;
			$data['year']=$year;
			$data['report_type']="coincendetal_peak_summary";
			$data['report_t']="coincidental";
			}
			
			//var_dump($date);
		
		
		$data['title']=$title;
		$data['transmision']=$this->mis_model->get_transmission_stations();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/load_summary',$data);
			$this->load->view('Layouts/footer');

		}
	}

	public function load_summary_report_old(){
		//$this->form_validation->set_rules('station_id','STATION',"required");
		$this->form_validation->set_rules('report_type','REPORT TYPE',"required");
		$this->form_validation->set_rules('date','DATE',"required");
		if ($this->form_validation->run()==FALSE){
			$data['title']="Load Summary";
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			//this gets users station(transmision or injection sub station)
			$data['station']=$this->input_model->get_station($data['user']);
			$data['transmision']=$this->mis_model->get_transmission_stations();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/load_summary',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('date');
			$report_type=$this->input->post('report_type');
			
			
			if ($report_type=="load_maximum") {
				$day_start=$this->input->post('day_start');
				$day_end=$this->input->post('day_end');
				$night_start=$this->input->post('night_start');
				$night_end=$this->input->post('night_end');

				$data['total_load']=$this->mis_model->total_load(["date"=>$date]);
				$data['summary']=$this->mis_model->load_maximum(["date"=>$date,"day_start"=>$day_start,"day_end"=>$day_end,"night_start"=>$night_start,"night_end"=>$night_end]);
			$title=$this->format_date("month",$date," MAXIMUM LOAD(MW) - ","TRANSMISSION STATIONS")['title'];
			}elseif ($report_type=="coincidental") {
				$station_id=$this->input->post('station_id');
				$transmission_station=$this->mis_model->get_transmission($station_id);
				$format_date=$this->format_date("month",$date,"COINCINDENTAL LOAD(MW)",$transmission_station->tsname);
		$month=$format_date['month'];
			$year=$format_date['year'];
				$data['summary']=$this->mis_model->coincindental_report(["trans_id"=>$station_id,"date"=>$date,"dt"=>"month","month"=>$month,"year"=>$year,"isIncommer"=>1,"type"=>"load_reading"]);
				$title=$format_date['title'];
				$data['report_t']="coincidental";
			}elseif ($report_type=="summary") {
				$format_date=$this->format_date("month",$date,"COINCIDENTAL PEAK LOAD(MW)","");
		$month=$format_date['month'];
			$year=$format_date['year'];
			$data['summary']=$this->mis_model->coincindental_summary_report(["date"=>$date,"dt"=>"month","month"=>$month,"year"=>$year,"type"=>"load_reading"]);
			$title=$format_date['title'];
			$data['date']=$date;
			$data['dt']="month";
			$data['month']=$month;
			$data['year']=$year;
			$data['report_type']="coincendetal_peak_summary";
			$data['report_t']="coincidental";
			}
			
			//var_dump($date);
		
		
		$data['title']=$title;
		$data['transmision']=$this->mis_model->get_transmission_stations();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/load_summary',$data);
			$this->load->view('Layouts/footer');

		}
	}

	//this functions fetches data for chart
	public function get_coincendal_peak_chart_data(){
		//type=loadmw,loadmvr,energy,pf ...
		//dt=date type"=month or day
		//$type=$this->input->post('type');
		$data=$this->mis_model->get_coincendental_peak_chart(array("month"=>$this->input->post('month'),"date"=>$this->input->post('date'),"dt"=>$this->input->post('dt'),'year'=>$this->input->post('year'),"type"=>"load_reading"));
		echo json_encode($data);
	}


	public function load_mvr_report(){
		//$this->form_validation->set_rules('captured_date','DATE',"required");
		$this->form_validation->set_rules('feeder_name','FEEDER NAME',"required");
		
		if ($this->form_validation->run()==FALSE){
			$data['title']="Load(MVR) Report";
			$data['feeders']=$this->mis_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/load_mvr_report',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('captured_month_date')?$this->input->post('captured_month_date'):$this->input->post('captured_daily_date');
			$dt=$this->input->post('dt');
			$insert_data=array("feeder_id"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"load_mvr","dt"=>$dt,"day_start"=>0,"day_end"=>17,"night_start"=>18,"night_end"=>23);
			//$insert_data=array("feeder_name"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"load_mvr","dt"=>$dt);
			
			
			$format_date=$this->format_date($dt,$date,"LOAD(MVR)",$this->input->post('feeder_name'));
			$month=$format_date['month'];
			$year=$format_date['year'];
			
			$data['search_params']=array("feeder_name"=>$this->input->post('feeder_name'),"date"=>$date,'dt'=>$dt);

			$data['summary']=$this->mis_model->get_log_sheet($insert_data);
			$data['average']=$this->mis_model->get_reading_avg($insert_data);
			$data['min']=$this->mis_model->get_reading_min($insert_data);
			$data['max']=$this->mis_model->get_reading_max($insert_data);
			//$data['mode']=$this->mis_model->get_reading_mode($insert_data);
			$data['month']=$month;
			$data['year']=$year;
			$data['dt']=$dt;
			$data['title']=$format_date['title'];
			$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/load_mvr_report',$data);
			$this->load->view('Layouts/footer');
		}
		
	}
	public function latest_entry_status(){
		$data['title']="Feeder wise latest entry status";
		$data['latest_hour_33']=$this->mis_model->get_latest_hour_logged(["voltage_level"=>"33kv"]);
		$data['latest_hour_11']=$this->mis_model->get_latest_hour_logged(["voltage_level"=>"11kv"]);
		$data['reports']=$this->mis_model->latest_entry_status();
		$this->load->view('Layouts/header',$data);
			$this->load->view('mis/latest_entry_status',$data);
			$this->load->view('Layouts/footer');
	}
	public function latest_entry_status_station(){
		$data['title']="Location Fault Summary";
		//$data['latest_hour_33']=$this->mis_model->get_latest_hour_logged(["voltage_level"=>"33kv"]);
		//$data['latest_hour_11']=$this->mis_model->get_latest_hour_logged(["voltage_level"=>"11kv"]);
		$data['reports']=$this->mis_model->latest_entry_status_station();
		$this->load->view('Layouts/header',$data);
			$this->load->view('mis/latest_entry_status_fault',$data);
			$this->load->view('Layouts/footer');
	}
	public function current_report(){
		//$this->form_validation->set_rules('captured_date','DATE',"required");
		$this->form_validation->set_rules('feeder_name','FEEDER NAME',"required");
		
		if ($this->form_validation->run()==FALSE){
			//$data['ts_data']=$this->input_model->get_transmissions();
		//$data['iss_data']=$this->input_model->get_iss();
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		$data['station']=$this->input_model->get_station($data['user']);
			$data['title']="Current Report";
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/current_report',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=!empty($this->input->post('captured_month_date'))?$this->input->post('captured_month_date'):$this->input->post('captured_daily_date');
			$dt=$this->input->post('dt');
			//$this->input->post('trans_id');
			$feeder_name=$this->input_model->getFeeder($this->input->post('feeder_name'))->feeder_name;
			$insert_data=array("feeder_id"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"current_reading","dt"=>$dt);
			
			
			$format_date=$this->format_date($dt,$date,"CURRENT",$feeder_name);
			$month=$format_date['month'];
			$year=$format_date['year'];
			
			$data['search_params']=array("feeder_id"=>$this->input->post('feeder_name'),"feeder_name"=>$feeder_name,"date"=>$date,'dt'=>$dt);
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		$data['station']=$this->input_model->get_station($data['user']);
			$data['summary']=$this->mis_model->logSheetTable($insert_data,$month,$year,$dt);
			$data['feeder_status']=$this->mis_model->show_feeder_status($insert_data);
			$data['average']=$this->mis_model->get_reading_avg($insert_data);
			$data['min']=$this->mis_model->get_reading_min($insert_data);
			$data['max']=$this->mis_model->get_reading_max($insert_data);
			//$data['mode']=$this->mis_model->get_reading_mode($insert_data);
			$data['trans_st']=$this->input->post('trans_st');
			$data['asset_type']=$this->input->post('asset_type');
			$data['month']=$month;
			$data['year']=$year;
			$data['dt']=$dt;
			$data['dayPeak']=$this->mis_model->get_reading_max($insert_data,"day");
			$data['nightPeak']=$this->mis_model->get_reading_max($insert_data,"night");
			$data['dayAverage']=$this->mis_model->hourly_avg_reading($insert_data,"","night");
			$data['nightAverage']=$this->mis_model->hourly_avg_reading($insert_data,"","night");
			// $data['dayAverage']=$dt;
			// $data['nightAverage']=$dt;

			$data['title']=$format_date['title'];
			$data['date']=$date;
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/current_report',$data);
			$this->load->view('Layouts/footer');
		}
	}

	public function fault_map_view(){
		$data['zones']=$this->admin_model->get_zones();
		$data['fault_summary']=$this->FaultResponse_model->get_outages(["status <"=>8]);
		//$data['iss_data']=$this->admin_model->get_iss_enumeration();

		$data['title']='Fault on map';
		$this->load->view('Layouts/header',$data);
			$this->load->view('mis/fault_map_view',$data);
			$this->load->view('Layouts/footer');	
	} 

	public function pf_report(){
		//$this->form_validation->set_rules('captured_date','DATE',"required");
		$this->form_validation->set_rules('feeder_name','FEEDER NAME',"required");
		
		if ($this->form_validation->run()==FALSE){
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		$data['station']=$this->input_model->get_station($data['user']);
			$data['title']="Hourly Power Factor Report";
			$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/pf_report',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('captured_month_date')?$this->input->post('captured_month_date'):$this->input->post('captured_daily_date');
			$dt=$this->input->post('dt');
			
			$insert_data=array("feeder_name"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"pf","dt"=>$dt);
			$format_date=$this->format_date($dt,$date,"POWER FACTOR",$this->input->post('feeder_name'));
			$month=$format_date['month'];
			$year=$format_date['year'];
			$data['search_params']=array("feeder_name"=>$this->input->post('feeder_name'),"date"=>$date,'dt'=>$dt);

			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		$data['station']=$this->input_model->get_station($data['user']);
			$data['summary']=$this->mis_model->get_log_sheet($insert_data);
			$data['average']=$this->mis_model->get_reading_avg($insert_data);
			$data['min']=$this->mis_model->get_reading_min($insert_data);
			$data['max']=$this->mis_model->get_reading_max($insert_data);
			//$data['mode']=$this->mis_model->get_reading_mode($insert_data);
			$data['month']=$month;
			$data['year']=$year;
			$data['dt']=$dt;
			$data['title']=$format_date['title'];
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/pf_report',$data);
			$this->load->view('Layouts/footer');
			

		}
		
	}
	public function frequency(){
		//$this->form_validation->set_rules('captured_date','DATE',"required");
		$this->form_validation->set_rules('feeder_name','FEEDER NAME',"required");
		
		if ($this->form_validation->run()==FALSE){
			$data['title']="Frequency Report";
			$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/frequency_report',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('captured_month_date')?$this->input->post('captured_month_date'):$this->input->post('captured_daily_date');
			$dt=$this->input->post('dt');
			
			$insert_data=array("feeder_name"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"frequency","dt"=>$dt);
			$format_date=$this->format_date($dt,$date,"LOAD(M/W)",$this->input->post('feeder_name'));
			$month=$format_date['month'];
			$year=$format_date['year'];
			$data['search_params']=array("feeder_name"=>$this->input->post('feeder_name'),"date"=>$date,'dt'=>$dt);


			$data['summary']=$this->mis_model->get_log_sheet($insert_data);
			$data['average']=$this->mis_model->get_reading_avg($insert_data);
			$data['min']=$this->mis_model->get_reading_min($insert_data);
			$data['max']=$this->mis_model->get_reading_max($insert_data);
			//$data['mode']=$this->mis_model->get_reading_mode($insert_data);
			$data['month']=$month;
			$data['year']=$year;
			$data['dt']=$dt;
			$data['title']=$format_date['title'];
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/frequency_report',$data);
			$this->load->view('Layouts/footer');
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
			$title=$param." REPORT FOR ".$feeder." FOR THE MONTH OF <br/>".strtoupper($date_title);
			}
			return ["month"=>$month,"year"=>$year,"title"=>$title];
	}
	public function energy_report(){
		//$this->form_validation->set_rules('captured_date','DATE',"required");
		$this->form_validation->set_rules('feeder_name','FEEDER NAME',"required");
		
		if ($this->form_validation->run()==FALSE){
			$data['title']="Energy Report";
			//$data['feeders']=$this->input_model->get_feeders();
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		//fetches the iss user belongs if set.
		$data['station']=$this->input_model->get_station($data['user']);
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/energy_report',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('captured_month_date')?$this->input->post('captured_month_date'):$this->input->post('captured_daily_date');
			$dt=$this->input->post('dt');
			$feeder_name=$this->input_model->getFeeder($this->input->post('feeder_name'))->feeder_name;
			$insert_data=array("feeder_id"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"energy","dt"=>$dt);
			$format_date=$this->format_date($dt,$date,"ENERGY",$feeder_name);
			$month=$format_date['month'];
			$year=$format_date['year'];
			
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		$data['station']=$this->input_model->get_station($data['user']);
			$data['search_params']=array("feeder_id"=>$this->input->post('feeder_name'),"feeder_name"=>$feeder_name,"date"=>$date,'dt'=>$dt);
			$data['summary']=$this->mis_model->get_energy_log_sheet($insert_data);
			//$data['consumptions']=$this->mis_model->get_energy_consumption_log_sheet($insert_data);
			$data['average']=$this->mis_model->get_reading_avg($insert_data);
			$data['min']=$this->mis_model->get_reading_min($insert_data);
			$data['max']=$this->mis_model->get_reading_max($insert_data);
			
			$data['month']=$month;
			$data['year']=$year;
			$data['dt']=$dt;
			$data['title']=$format_date['title'];
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/energy_report',$data);
			$this->load->view('Layouts/footer');
			

		}	
	}
	
	//get transmisions or iss base on type =ts or iss
	public function get_station_type(){
		$type=$this->input->post('type');
		$stations=$this->mis_model->get_station_type($type);
		echo json_encode($stations);
	}

	//this functions fetches data for chart
	public function get_chart_data(){
		//type=loadmw,loadmvr,energy,pf ...
		//dt=date type"=month or day
		$type=$this->input->post('type');
		$data=$this->mis_model->get_chat_data(array("feeder_id"=>$this->input->post('feeder_id'),"date"=>$this->input->post('date'),"dt"=>$this->input->post('dt'),'type'=>$this->input->post('type')));
		echo json_encode($data);
	}
	//this functions fetches feeder by zones and voltage
	public function get_feeders_by_zone_voltage(){
		$voltage_level=$this->input->post('voltage_level');
		$zone_id=$this->input->post('zone_id');
	
		$data=$this->mis_model->get_feeders_by_zone_voltage(array("voltage_level"=>$voltage_level,"zone_id"=>$zone_id));
		echo json_encode($data);
	}


	public function interruption_report(){
		
		//$this->form_validation->set_rules('date','ASSET NAME',"required");
		$this->form_validation->set_rules('date','Date',"required");
		$this->form_validation->set_rules('voltage_level','Voltage Level',"required");
		//$data['trippings']=$this->tripping_model->get_interupted_trippings();
		if ($this->form_validation->run()==FALSE){
		$data['title']="INTERRUPTION REPORT";
		//$data['feeders']=$this->tripping_model->get_all_feeders();
		//$data['faults']=$this->tripping_model->get_fault_interrupt();
		$this->load->view('Layouts/header',$data);
		$this->load->view('mis/interruption_report',$data);
		$this->load->view('Layouts/footer');
		}else{
			
			$date=explode('-', $this->input->post('date'));
			list($start_date,$end_date)=$date;
			$start_date=date("Y-m-d",strtotime($start_date));
			$end_date=date("Y-m-d",strtotime($end_date));
			//$insert_data=;
			$result=$this->mis_model->get_fault_indication_frequency(array("start_date"=>$start_date,"end_date"=>$end_date,"date"=>$date,"voltage_level"=>$this->input->post('voltage_level')));

			//$result_11kv=$this->mis_model->get_fault_indication_frequency(array("month"=>$month,"year"=>$year,"date"=>$date,"voltage_level"=>"11kv"));

			//$result_11kv=$this->mis_model->get_programme_sheet(array("month"=>$month,"year"=>$year,"date"=>$date,"voltage_level"=>"11kv"));
			//$result_cause=$this->mis_model->get_fault_cause_frequency($insert_data);
				//$data['title']="";
				//$data['report_11kv']=$result_11kv;
				$data['title']='INTERRUPTION REPORT FOR '.$this->input->post('voltage_level').' BETWEEN '.$start_date.' TO '.$end_date;
			
			
			
			
			$data['report']=$result;
			//$data['user']=$user;
			
			
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/interruption_report',$data);
			$this->load->view('Layouts/footer');
			
		}
	}

	public function fault_report(){
		$this->form_validation->set_rules('report_type','REPORT TYPE',"required");
		//$this->form_validation->set_rules('date','ASSET NAME',"required");
		$this->form_validation->set_rules('date','Date',"required");
		//$data['trippings']=$this->tripping_model->get_interupted_trippings();
		if ($this->form_validation->run()==FALSE){
		$data['title']="FAULT REPORT";
		//$data['feeders']=$this->tripping_model->get_all_feeders();
		//$data['faults']=$this->tripping_model->get_fault_interrupt();
		$this->load->view('Layouts/header',$data);
		$this->load->view('mis/fault_report',$data);
		$this->load->view('Layouts/footer');
		}else{
			$report_type=$this->input->post('report_type');
			$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			$date=$this->input->post('date');
			//$result=$this->mis_model->get_fault_cause_report($insert_data);
			if ($report_type=='Summary') {
				$status=$this->input->post('status');
				//var_dump($status);
				$format_date=$this->format_date("month",$date,"FAULT SUMMAEY","");
			$month=$format_date['month'];
			$year=$format_date['year'];
				//$insert_data=array("month"=>$month,"year"=>$year);

				if ($user->role_id==8) {
					# dso
					
					
					$insert_data=array("month"=>$month,"year"=>$year,"station_id"=>$user->iss,"voltage_level"=>"11kv","role"=>$user->role_id,"status"=>$status);
					$result=$this->mis_model->get_fault_report($insert_data);
					//var_dump($report_11kv);
					//$data['report_11kv']=$report_11kv;
				}elseif ($user->role_id==24 || $user->role_id==14) {
					//zone head and network managers
					//get the zonal id
					//join zonal id and trans statio 33kv feeder and iss
					$insert_data=array("month"=>$month,"year"=>$year,""=>$user->iss);
				}elseif ($user->role_id==12) {
					# feeder manager
					$request_33kv=array("month"=>$month,"year"=>$year,"voltage_level"=>"33kv","role"=>$user->role_id,"feeder33kv_id"=>$user->feeder33kv_id,"status"=>$status);
					$request_11kv=array("month"=>$month,"year"=>$year,"voltage_level"=>"11kv","role"=>$user->role_id,"feeder33kv_id"=>$user->feeder33kv_id,"status"=>$status);

					$result=$this->mis_model->get_fault_report($request_33kv);

					$result_11kv=$this->mis_model->get_fault_report($request_11kv);
					$data['report_11kv']=$result_11kv;

				}
				 else {
					# admin,hso,dispatch and others
					$request_33kv=array("month"=>$month,"year"=>$year,"voltage_level"=>"33kv","role"=>$user->role_id,"status"=>$status);
					//33kv
					$result=$this->mis_model->get_fault_report($request_33kv);

					//11kv
					$result_11kv=$this->mis_model->get_fault_report(array("month"=>$month,"year"=>$year,"voltage_level"=>"11kv","role"=>$user->role_id,"status"=>$status));
					$data['report_11kv']=$result_11kv;
				}
				
			
				$data['title']=$format_date['title'];
			}elseif ($report_type=="programe_sheet") {
				$format_date=$this->format_date("month",$date,"PROGRAMME SHEET","");
			$month=$format_date['month'];
			$year=$format_date['year'];
			//$insert_data=;
			$result=$this->mis_model->get_programme_sheet(array("month"=>$month,"year"=>$year,"date"=>$date,"voltage_level"=>"33kv"));

			$result_11kv=$this->mis_model->get_programme_sheet(array("month"=>$month,"year"=>$year,"date"=>$date,"voltage_level"=>"11kv"));
			//$result_cause=$this->mis_model->get_fault_cause_frequency($insert_data);
				$data['title']=$format_date['title'];
				$data['report_11kv']=$result_11kv;
				
			}elseif ($report_type=="interruption") {
				$format_date=$this->format_date("month",$date,"ÌNERRUPTON","");
			$month=$format_date['month'];
			$year=$format_date['year'];
			//$insert_data=;
			$result=$this->mis_model->get_fault_indication_frequency(array("month"=>$month,"year"=>$year,"date"=>$date,"voltage_level"=>"33kv"));

			$result_11kv=$this->mis_model->get_fault_indication_frequency(array("month"=>$month,"year"=>$year,"date"=>$date,"voltage_level"=>"11kv"));

			//$result_11kv=$this->mis_model->get_programme_sheet(array("month"=>$month,"year"=>$year,"date"=>$date,"voltage_level"=>"11kv"));
			//$result_cause=$this->mis_model->get_fault_cause_frequency($insert_data);
				$data['title']=$format_date['title'];
				$data['report_11kv']=$result_11kv;
				
			}
			else{
				
				$format_date=$this->format_date("month",$date,"FAULT","");
			$month=$format_date['month'];
			$year=$format_date['year'];
			$insert_data=array("month"=>$month,"year"=>$year,"date"=>$date);
			$result=$this->mis_model->get_fault_indication_frequency($insert_data);
			$result_cause=$this->mis_model->get_fault_cause_frequency($insert_data);
				$data['title']=$format_date['title'];
				$data['report_cause']=$result_cause;
			}
			
			
			$data['report']=$result;
			$data['user']=$user;
			
			$data['report_type']=$report_type;
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/fault_report',$data);
			$this->load->view('Layouts/footer');
			
		}
	}


	public function fault_report_call_center(){
		$this->form_validation->set_rules('report_type','REPORT TYPE',"required");
		//$this->form_validation->set_rules('date','ASSET NAME',"required");
		$this->form_validation->set_rules('date','Date',"required");
		//$data['trippings']=$this->tripping_model->get_interupted_trippings();
		if ($this->form_validation->run()==FALSE){
		$data['title']="FAULT REPORT";
		//$data['feeders']=$this->tripping_model->get_all_feeders();
		//$data['faults']=$this->tripping_model->get_fault_interrupt();
		$this->load->view('Layouts/header',$data);
		$this->load->view('mis/fault_report_call_center',$data);
		$this->load->view('Layouts/footer');
		}else{
			$report_type=$this->input->post('report_type');
			$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			$date=$this->input->post('date');
			//$result=$this->mis_model->get_fault_cause_report($insert_data);
			if ($report_type=='Summary') {
				$status=$this->input->post('status');
				//var_dump($status);
				$format_date=$this->format_date("month",$date,"FAULT SUMMAEY","");
			$month=$format_date['month'];
			$year=$format_date['year'];
				//$insert_data=array("month"=>$month,"year"=>$year);

				 
					$request_33kv=array("month"=>$month,"year"=>$year,"voltage_level"=>"33kv","role"=>$user->role_id,"status"=>$status);
					//33kv
					$result=$this->mis_model->get_fault_report($request_33kv);

					//11kv
					$result_11kv=$this->mis_model->get_fault_report(array("month"=>$month,"year"=>$year,"voltage_level"=>"11kv","role"=>$user->role_id,"status"=>$status));
					$data['report_11kv']=$result_11kv;
				
				
			
				$data['title']=$format_date['title'];
			}
			
			
			$data['report']=$result;
			$data['user']=$user;
			
			$data['report_type']=$report_type;
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/fault_report_call_center',$data);
			$this->load->view('Layouts/footer');
			
		}
	}




	public function cause_asset_report(){
		$this->form_validation->set_rules('asset_type','ASSET TYPE',"required");
		//$this->form_validation->set_rules('asset_name','ASSET NAME',"required");
		$this->form_validation->set_rules('date','Date',"required");
		//$data['trippings']=$this->tripping_model->get_interupted_trippings();
		if ($this->form_validation->run()==FALSE){
		$data['title']="CAUSE OF FAULT BY ASSET REPORT";
		//$data['feeders']=$this->tripping_model->get_all_feeders();
		//$data['faults']=$this->tripping_model->get_fault_interrupt();
		$this->load->view('Layouts/header',$data);
		$this->load->view('mis/cause_asset_report',$data);
		$this->load->view('Layouts/footer');
		}else{
			list($start_date,$end_date)=explode(" - ", $this->input->post('date'));
			$insert_data=array("asset_name"=>$this->input->post('asset_name'),"start_date"=>date("Y-m-d",strtotime($start_date)),"end_date"=>date("Y-m-d",strtotime($end_date)),'asset_type'=>$this->input->post('asset_type'));
			$result=$this->mis_model->get_cause_asset_report($insert_data);
			if ($this->input->post('asset_name')=='') {
				$data['title']="CAUSE OF FAULT REPORT FOR ".$this->input->post('asset_type')."  BETWEEN ".$start_date." AND ".$end_date;
			}else{
				$data['title']="CAUSE OF FAULT REPORT FOR ".$this->input->post('asset_name')."  BETWEEN ".$start_date." AND ".$end_date;
			}
			$data['report']=$result;
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/cause_asset_report',$data);
			$this->load->view('Layouts/footer');
			
		}
	}
	public function indication_asset_report(){
		$this->form_validation->set_rules('asset_type','ASSET TYPE',"required");
		//$this->form_validation->set_rules('asset_name','ASSET NAME',"required");
		$this->form_validation->set_rules('date','Date',"required");
		//$data['trippings']=$this->tripping_model->get_interupted_trippings();
		if ($this->form_validation->run()==FALSE){
		$data['title']=" FAULT INDICATION BY ASSET REPORT";
		//$data['feeders']=$this->tripping_model->get_all_feeders();
		//$data['faults']=$this->tripping_model->get_fault_interrupt();
		$this->load->view('Layouts/header',$data);
		$this->load->view('mis/indication_asset_report',$data);
		$this->load->view('Layouts/footer');
		}else{
			list($start_date,$end_date)=explode(" - ", $this->input->post('date'));
			$insert_data=array("asset_name"=>$this->input->post('asset_name'),"start_date"=>date("Y-m-d",strtotime($start_date)),"end_date"=>date("Y-m-d",strtotime($end_date)),'asset_type'=>$this->input->post('asset_type'));
			$result=$this->mis_model->get_indication_asset_report($insert_data);
			if ($this->input->post('asset_name')=='') {
				$data['title']="FAULT INIDICATION REPORT FOR  ".$this->input->post('asset_type')."  BETWEEN ".$start_date." AND ".$end_date;
			}else{
				$data['title']="FAULT INIDICATION REPORT FOR ".$this->input->post('asset_name')."  BETWEEN ".$start_date." AND ".$end_date;
			}
			
			
			$data['report']=$result;
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/fault_cause',$data);
			$this->load->view('Layouts/footer');
			
		}
	}
	// public function report(){
		
	// 	//$this->form_validation->set_rules('asset_name','Name',"required");
	// 	$this->form_validation->set_rules('asset_type','Type',"required");
	// 	$this->form_validation->set_rules('date','Date',"required");
	// 	//$data['trippings']=$this->tripping_model->get_interupted_trippings();
	// 	if ($this->form_validation->run()==FALSE){
	// 	$data['title']="Report";
	// 	//$data['feeders']=$this->tripping_model->get_all_feeders();
	// 	$data['faults']=$this->tripping_model->get_fault_interrupt();
	// 	$this->load->view('Layouts/header',$data);
	// 	$this->load->view('trippings/report',$data);
	// 	$this->load->view('Layouts/footer');
	// 	}else{
	// 		list($start_date,$end_date)=explode(" - ", $this->input->post('date'));
	// 		$insert_data=array("asset_id"=>$this->input->post('asset_name'),"start_date"=>date("Y-m-d",strtotime($start_date)),"end_date"=>date("Y-m-d",strtotime($end_date)),"fault_id"=>$this->input->post('fault_id'),'type'=>$this->input->post('asset_type'));
	// 		$result=$this->tripping_model->report($insert_data);
	// 		if ($this->input->post('asset_name')=='') {
	// 			$data['title']="Fault report for ".$this->input->post('asset_type')."  between ".$start_date." and ".$end_date;
	// 		}else{
	// 			$data['title']="Fault report for ".$this->input->post('asset_name')."  between ".$start_date." and ".$end_date;
	// 		}
			
	// 		$data['faults']=$this->tripping_model->get_fault_interrupt();
	// 		$data['report']=$result;
	// 		$this->load->view('Layouts/header',$data);
	// 		$this->load->view('trippings/report',$data);
	// 		$this->load->view('Layouts/footer');
			
	// 	}

	// }
}