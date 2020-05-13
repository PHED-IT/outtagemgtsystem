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
				$insert_data=array("feeder_id"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"load_reading","dt"=>$dt);
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

	public function getReadingByFeeder($data){
	 	return $this->input_model->getReadingByFeeder($data);
	 }

	// public function load_reportold(){
	// 	//$this->form_validation->set_rules('captured_date','DATE',"required");
	// 	$this->form_validation->set_rules('feeder_name','FEEDER NAME',"required");
		
	// 	if ($this->form_validation->run()==FALSE){
	// 		//$data['ts_data']=$this->input_model->get_transmissions();
	// 	//$data['iss_data']=$this->input_model->get_iss();
	// 		$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
	// 	$data['station']=$this->input_model->get_station($data['user']);
	// 		$data['title']="Load(MW) Report";
	// 		//$data['feeders']=$this->input_model->get_feeders();
	// 		$this->load->view('Layouts/header',$data);
	// 		$this->load->view('mis/load_report',$data);
	// 		$this->load->view('Layouts/footer');
	// 	}else{
	// 		$date=!empty($this->input->post('captured_month_date'))?$this->input->post('captured_month_date'):$this->input->post('captured_daily_date');
	// 		$dt=$this->input->post('dt');
	// 		$transmision_id=$this->input->post('trans_st');
	// 		$asset_type=$this->input->post('asset_type');
	// 		//$this->input->post('trans_id');
	// 		$feeder_name=$this->input_model->getFeeder($this->input->post('feeder_name'))->feeder_name;
	// 		$insert_data=array("feeder_id"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"load_reading","dt"=>$dt);
			
			
	// 		$format_date=$this->format_date($dt,$date,"LOAD(M/W)",$feeder_name);
	// 		$month=$format_date['month'];
	// 		$year=$format_date['year'];
			
	// 		$data['search_params']=array("feeder_id"=>$this->input->post('feeder_name'),"feeder_name"=>$feeder_name,"date"=>$date,'dt'=>$dt);
	// 		$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
	// 	$data['station']=$this->input_model->get_station($data['user']);
	// 		$data['summary']=$this->mis_model->logSheetTable($insert_data,$month,$year,$dt);
	// 		$data['feeder_status']=$this->mis_model->show_feeder_status($insert_data);
	// 		$data['average']=$this->mis_model->get_reading_avg($insert_data);
	// 		$data['min']=$this->mis_model->get_reading_min($insert_data);
	// 		$data['max']=$this->mis_model->get_reading_max($insert_data);
	// 		//$data['mode']=$this->mis_model->get_reading_mode($insert_data);
	// 		$data['trans_st']=$transmision_id;
	// 		$data['asset_type']=$asset_type;
	// 		$data['month']=$month;
	// 		$data['year']=$year;
	// 		$data['dt']=$dt;
	// 		$data['dayPeak']=$this->mis_model->get_reading_max($insert_data,"day");
	// 		$data['nightPeak']=$this->mis_model->get_reading_max($insert_data,"night");
	// 		$data['dayAverage']=$this->mis_model->hourly_avg_reading($insert_data,"","night");
	// 		$data['nightAverage']=$this->mis_model->hourly_avg_reading($insert_data,"","night");
	// 		// $data['dayAverage']=$dt;
	// 		// $data['nightAverage']=$dt;

	// 		$data['title']=$format_date['title'];
	// 		$data['date']=$date;
	// 		//$data['feeders']=$this->input_model->get_feeders();
	// 		$this->load->view('Layouts/header',$data);
	// 		$this->load->view('mis/load_report',$data);
	// 		$this->load->view('Layouts/footer');
	// 	}
		
	// }

	// public function load_maximum($trans_id){
		
	// 		$date=$this->input->get('date');
	// 		$data['summary']=$this->mis_model->load_maximum(["trans_st"=>$trans_id,"date"=>$date]);
	// 		//var_dump($date);
	// 	$transmission_station=$this->mis_model->get_transmission($trans_id);
	// 	$title=$this->format_date("month",$date,"LOAD MAXIMUM",$transmission_station->tsname)['title'];
	// 	$data['title']=$title;

	// 	$this->load->view('mis/load_maximum_report',$data);
	// }

	public function load_summary_report(){
		$this->form_validation->set_rules('station_id','STATION',"required");
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
			$station_id=$this->input->post('station_id');
			$transmission_station=$this->mis_model->get_transmission($station_id);
			if ($report_type=="load_maximum") {
				$data['summary']=$this->mis_model->load_maximum(["trans_st"=>$station_id,"date"=>$date]);
			$title=$this->format_date("month",$date," MAXIMUM LOAD RECORD - ","TRANSMISSION SUBSTATIONS")['title'];
			}elseif ($report_type=="coincidental") {
				$format_date=$this->format_date("month",$date,"COINCINDENTAL",$transmission_station->tsname);
		$month=$format_date['month'];
			$year=$format_date['year'];
				$data['summary']=$this->mis_model->coincindental_report(["trans_id"=>$station_id,"date"=>$date,"dt"=>"month","month"=>$month,"year"=>$year,"isIncommer"=>1,"type"=>"load_reading"]);
				$title=$format_date['title'];
			}elseif ($report_type=="summary") {
				$format_date=$this->format_date("month",$date,""," COINCIDENTAL PEAK LOAD");
		$month=$format_date['month'];
			$year=$format_date['year'];
			$data['summary']=$this->mis_model->coincindental_summary_report(["date"=>$date,"dt"=>"month","month"=>$month,"year"=>$year,"type"=>"load_reading"]);
			$title=$format_date['title'];
			$data['date']=$date;
			$data['dt']="month";
			$data['month']=$month;
			$data['year']=$year;
			$data['report_type']="coincendetal_peak_summary";
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



	//this shows coincidental report for 33kv
	// public function coincidental_report($trans_id){
		
	// 		$date=$this->input->get('date');
			
	// 		//var_dump($date);
	// 	$transmission_station=$this->mis_model->get_transmission($trans_id);
	// 	$format_date=$this->format_date("month",$date,"COINCINDENTAL",$transmission_station->tsname);
	// 	$month=$format_date['month'];
	// 		$year=$format_date['year'];
	// 		$data['summary']=$this->mis_model->coincindental_report(["trans_id"=>$trans_id,"date"=>$date,"dt"=>"month","month"=>$month,"year"=>$year,"isIncommer"=>1,"type"=>"load_reading"]);
	// 	$data['title']=$format_date['title'];
	// 	$this->load->view('mis/coincidental_report',$data);
	// }
	// public function coincidental_summary_report($trans_id){
		
	// 		$date=$this->input->get('date');
			
	// 		//var_dump($date);
	// 	$transmission_station=$this->mis_model->get_transmission($trans_id);
	// 	$format_date=$this->format_date("month",$date,"MONTHLY"," COINCIDENTAL PEAK LOAD");
	// 	$month=$format_date['month'];
	// 		$year=$format_date['year'];
	// 		$data['summary']=$this->mis_model->coincindental_summary_report(["date"=>$date,"dt"=>"month","month"=>$month,"year"=>$year,"type"=>"load_reading"]);
	// 	$data['title']=$format_date['title'];
	// 	$this->load->view('mis/load_summary',$data);
	// }

	public function load_mvr_report(){
		//$this->form_validation->set_rules('captured_date','DATE',"required");
		$this->form_validation->set_rules('feeder_name','FEEDER NAME',"required");
		
		if ($this->form_validation->run()==FALSE){
			$data['title']="Load(MVR) Report";
			$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/load_mvr_report',$data);
			$this->load->view('Layouts/footer');
		}else{
			$date=$this->input->post('captured_month_date')?$this->input->post('captured_month_date'):$this->input->post('captured_daily_date');
			$dt=$this->input->post('dt');
			
			$insert_data=array("feeder_name"=>$this->input->post('feeder_name'),"date"=>$date,'type'=>"load_mvr","dt"=>$dt);
			
			
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
			$date=$this->input->post('date');
			//$result=$this->mis_model->get_fault_cause_report($insert_data);
			if ($report_type=='Summary') {
				$format_date=$this->format_date("month",$date,"FAULT","");
			$month=$format_date['month'];
			$year=$format_date['year'];
				$insert_data=array("month"=>$month,"year"=>$year);
			$result=$this->mis_model->get_fault_report($insert_data);
				$data['title']=$format_date['title'];
			}else{
				
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
			
			$data['report_type']=$report_type;
			$this->load->view('Layouts/header',$data);
			$this->load->view('mis/fault_report',$data);
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