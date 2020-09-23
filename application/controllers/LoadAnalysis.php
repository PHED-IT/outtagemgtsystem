<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * this is controller for planned outages
 */
class LoadAnalysis extends MY_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('LoadAnalysis_model');
	}

	public function index(){
		//$this->form_validation->set_rules('date','ASSET NAME',"required");
		$this->form_validation->set_rules('date','Date',"required");
		//$this->form_validation->set_rules('voltage_level','Voltage Level',"required");
		//$data['trippings']=$this->tripping_model->get_interupted_trippings();
		if ($this->form_validation->run()==FALSE){
		$data['title']="LOAD ANALYSIS REPORT";
		
		$this->load->view('Layouts/header',$data);
		$this->load->view('load_analysis/daily_load_analysis',$data);
		$this->load->view('Layouts/footer');
		}else{
			
			
			$result=$this->LoadAnalysis_model->daily_load_analysis_report(array("date"=>$this->input->post('date')));
			
			$data['title']='LOAD ANALYSIS REPORT FOR '.date('F d, Y',strtotime($this->input->post('date'))) ;
			
			
			$data['report']=$result;
			
			$this->load->view('Layouts/header',$data);
			$this->load->view('load_analysis/daily_load_analysis',$data);
			$this->load->view('Layouts/footer');
			
		}
	}

	public function gridModelxReport(){
		//$this->form_validation->set_rules('date','ASSET NAME',"required");
		$this->form_validation->set_rules('date','Date',"required");
		//$this->form_validation->set_rules('voltage_level','Voltage Level',"required");
		//$data['trippings']=$this->tripping_model->get_interupted_trippings();
		if ($this->form_validation->run()==FALSE){
		$data['title']="GRID MODELX REPORT";
		//$data['feeders']=$this->tripping_model->get_all_feeders();
		//$data['faults']=$this->tripping_model->get_fault_interrupt();
		$this->load->view('Layouts/header',$data);
		$this->load->view('load_analysis/grid_modelx',$data);
		$this->load->view('Layouts/footer');
		}else{
			
			
			$result=$this->LoadAnalysis_model->grid_modelx_report(array("date"=>$this->input->post('date')));
			$total_affected_tx_feeders=$this->LoadAnalysis_model->get_total_tx_aff_feeder_daily(array("date"=>$this->input->post('date')));
			$total_tx_duration=$this->LoadAnalysis_model->get_total_tx_duration_daily(array("date"=>$this->input->post('date')));

			
			$total_forced_duration=$this->LoadAnalysis_model->get_total_forced_duration_daily(array("date"=>$this->input->post('date')));


			$data["total_affected_tx_feeders"]=$total_affected_tx_feeders->count;
			$data["total_tx_duration"]=$total_tx_duration->count;

			//$data["total_affected_tx_feeders"]=$total_affected_tx_feeders->count;
			$data["total_forced_duration"]=$total_forced_duration->count;

			$data['title']='GRID MODELX REPORT '.date('F d, Y',strtotime($this->input->post('date')));
			
			
			
			
			$data['report']=$result;
			//$data['user']=$user;
			
			
			$this->load->view('Layouts/header',$data);
			$this->load->view('load_analysis/grid_modelx',$data);
			$this->load->view('Layouts/footer');
			
		}
	}

	public function input(){
		$data['ts_data']=$this->LoadAnalysis_model->get_transmission_stations();
		
		$data['title']="Myto Allocation sheet";
		//$data['summary']=$this->input_model->get_ibc_summary();
		$this->load->view('Layouts/header',$data);
		$this->load->view('load_analysis/input',$data);
		$this->load->view('Layouts/footer');
	}

	public function store(){
		if ($this->input->post('isIncommer')=="true") {
			$feeder=$this->input->post('transformer');
		} else {
			$feeder=$this->input->post('feeder');
		}
		
		$insert_data=array("feeder"=>$feeder,'myto_allocaton_mw'=>$this->input->post('myto_allocaton_mw'),'myto_allocaton_a'=>$this->input->post('myto_allocaton_a'),'consumption_embeded'=>$this->input->post('consumption_embeded'),'forecasted_load'=>$this->input->post('forecasted_load'),'hour'=>$this->input->post('hour'),'created_by'=>$this->session->userdata('USER_ID'),'station_id'=>$this->input->post('station_id'),'voltage_level'=>$this->input->post('voltage_level'),'captured_date'=>$this->input->post('captured_date'),'status'=>$this->input->post('status'),'isIncommer'=>$this->input->post('isIncommer'),"transformer"=>$this->input->post('transformer'));
		
		$result=$this->LoadAnalysis_model->store($insert_data);
		echo json_encode($result);
	}

	public function getLatestFeederReading(){

		$last_reading=$this->LoadAnalysis_model->get_last_reading(array("voltage_level"=>"33kv","feeder_id"=>$this->input->post('feeder_id'),"isFeeder"=>true));
		echo json_encode($last_reading);
	}


}