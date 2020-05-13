<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * this is controller for planned outages
 */
class Forced extends MY_Controller
{
	public function capture(){
		$this->form_validation->set_rules('asset_name','ASSET NAME',"trim|required");
		//$this->form_validation->set_rules('fault','FAULT INDICATOR',"required");
		$this->form_validation->set_rules('date_fault','Date of fault',"trim|required");
		
		if ($this->form_validation->run()==FALSE) {
			$data['ts_data']=$this->input_model->get_transmission_stations();
			$data['iss_data']=$this->input_model->get_iss();
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			$data['station']=$this->input_model->get_station($data['user']);
			//$data['feeders']=$this->input_model->get_feeder_station($data['user']);
			$data['faults']=$this->forced_model->get_fault_inidcators_by_id(NULL);
			$data['components']=$this->forced_model->get_components();
			//$data['trippings']=$this->forced_model->get_trippings(0);
			$data['title']="Capture Fault";
			$this->load->view('Layouts/header',$data);
			$this->load->view('forced_outages/capture_outage',$data);
			$this->load->view('Layouts/footer');
		}else{
			$component_id=$this->input->post('asset_type')=='ISS'?$this->input->post('component_id'):NULL;
			$fault_id=$this->input->post('asset_type')=='ISS'?$this->input->post('fault_ind_iss'):$this->input->post('fault_ind_feeder');
			$insert_data=array("asset_name"=>$this->input->post('asset_name'),"fault_ind_id"=>$fault_id,'date_fault'=>$this->input->post('date_fault'),'remark'=>$this->input->post('remark'),'asset_id'=>$this->input->post('asset_id'),'asset_type'=>$this->input->post('asset_type'),'component_id'=>$component_id,'captured_by'=>$this->session->userdata('USER_ID'));

			$result=$this->forced_model->capture_fault($insert_data);
			if ($result['status']) {
				$this->session->set_flashdata('success',$result['message']);
				redirect('tripping/capture_fault');
			} else {
				$this->session->set_flashdata('error',$result['message']);
				redirect('tripping/capture_fault');
			}
		}

		
	}
	public function edit_fault($tripping_id){
		$this->form_validation->set_rules('asset_name','ASSET NAME',"trim|required");
		$this->form_validation->set_rules('fault','Fault',"required");
		$this->form_validation->set_rules('time','Time of fault',"trim|required");
		if ($this->form_validation->run()==FALSE) {
			$data['ts_data']=$this->input_model->get_transmission_stations();
			$data['iss_data']=$this->input_model->get_iss();
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			$data['station']=$this->input_model->get_station($data['user']);
			//$data['feeders']=$this->input_model->get_feeder_station($data['user']);
			$data['faults']=$this->forced_model->get_fault_inidcators_by_id(NULL);
			$data['components']=$this->forced_model->get_components();
			$data['tripping']=$this->forced_model->get_tripping_id($tripping_id);
			$data['trippings']=$this->forced_model->get_trippings(0);
			$data['title']="Edit fault";
			$this->load->view('Layouts/header',$data);
			$this->load->view('trippings/capture_fault',$data);
			$this->load->view('Layouts/footer');
		}else{
			
			$insert_data=array("asset_name"=>$this->input->post('asset_name'),"fault_id"=>$this->input->post('fault'),'time_fault'=>$this->input->post('time'),'remark'=>$this->input->post('remark'),'asset_id'=>$this->input->post('asset_id'));

			$result=$this->forced_model->update_fault($tripping_id,$insert_data);
			if ($result['status']) {
				$this->session->set_flashdata('success',$result['message']);
				redirect('tripping/edit_fault/'.$tripping_id);
			} else {
				$this->session->set_flashdata('error',$result['message']);
				redirect('tripping/edit_fault/'.$tripping_id);
			}
		}
	}

	public function view_faults(){
		
		$data['trippings']=$this->forced_model->get_trippings(1);
		$data['title']="View trippings/faults";
		$this->load->view('Layouts/header',$data);
		$this->load->view('trippings/view_fault',$data);
		$this->load->view('Layouts/footer');
	}

	public function allocate_fault(){
		
		$data['trippings']=$this->forced_model->get_unallocated_trippings();
		$data['title']="Allocate trippings/faults";
		$this->load->view('Layouts/header',$data);
		$this->load->view('trippings/allocate_fault',$data);
		$this->load->view('Layouts/footer');
	}

	public function allocate_tripping($tripping_id){
		$this->form_validation->set_rules('name','Name',"required");
		$this->form_validation->set_rules('phone','Phone number',"required");
		if ($this->form_validation->run()==FALSE){
			redirect('tripping/allocate_fault');	
		}else{
			$insert_data=array("tripping_id"=>$tripping_id,"name"=>$this->input->post('name'),"phone"=>$this->input->post("phone"),"remarks"=>$this->input->post('remarks'),"allocated_by"=>$this->session->userdata('USER_ID'));

			$result=$this->forced_model->allocate_tripping($insert_data);
			if ($result['status']) {
				$this->session->set_flashdata('success',$result['message']);
				redirect('tripping/allocate_fault');
			} else {
				$this->session->set_flashdata('error',$result['message']);
				redirect('tripping/allocate_fault');
			}

		}
	}

	public function close_fault(){
		
		$data['trippings']=$this->forced_model->get_open_trippings();
		$data['title']="Close trippings/faults";
		$this->load->view('Layouts/header',$data);
		$this->load->view('trippings/close_fault',$data);
		$this->load->view('Layouts/footer');
	}
	public function closure_tripping($tripping_id){
		$insert_data=array("tripping_id"=>$tripping_id,"remarks"=>$this->input->post('remarks'),"personnel"=>$this->input->post('personnel'),"materials"=>$this->input->post('materials'),"completed_at"=>$this->input->post('completed_at'),"hours_interruption"=>$this->input->post('hours_interruption'),"closed_by"=>$this->session->userdata('USER_ID'));

		$result=$this->forced_model->close_tripping($insert_data);
		if ($result['status']) {
			$this->session->set_flashdata('success',$result['message']);
			redirect('tripping/close_fault');
		} else {
			$this->session->set_flashdata('error',$result['message']);
			redirect('tripping/close_fault');
		}	
	}

	public function closure_nm_post($tripping_id){
		$insert_data=array("tripping_id"=>$tripping_id,"remarks"=>$this->input->post('remarks'),"work_done"=>$this->input->post('work_done'),"date_completed"=>$this->input->post('completed_at'),"closed_by"=>$this->session->userdata('USER_ID'));

		$result=$this->forced_model->closure_nm_post($insert_data);
		if ($result['status']) {
			$data=array("phone"=>"+23408105175548","text"=>"Hi, You have a forced outage to close");
			$this->sendSMS($data);
			$this->session->set_flashdata('success',$result['message']);
			redirect('tripping/close_nm');
		} else {
			$this->session->set_flashdata('error',$result['message']);
			redirect('tripping/close_nm');
		}	
	}
	public function closure_nso_post($tripping_id){
		$insert_data=array("tripping_id"=>$tripping_id,"remarks_op"=>$this->input->post('remarks_op'),"serial_number"=>$this->input->post('serial_number'),"done_by"=>$this->session->userdata('USER_ID'));

		$result=$this->forced_model->closure_nso_post($insert_data);
		if ($result['status']) {
			$this->session->set_flashdata('success',$result['message']);
			redirect('tripping/close_nso');
		} else {
			$this->session->set_flashdata('error',$result['message']);
			redirect('tripping/close_nso');
		}	
	}
	public function acknowlege_dso_post($tripping_id){
		$insert_data=array("tripping_id"=>$tripping_id,"dso_remarks"=>$this->input->post('dso_remarks'),"acknowledge"=>1,"dso_id"=>$this->session->userdata('USER_ID'));

		$result=$this->forced_model->acknowledge_dso_post($insert_data);
		if ($result['status']) {
			$this->session->set_flashdata('success',$result['message']);
			redirect('tripping/close_dso');
		} else {
			$this->session->set_flashdata('error',$result['message']);
			redirect('tripping/close_dso');
		}	
	}
	public function close_nm(){
		$data['trippings']=$this->forced_model->get_trippings_nm();
		$data['title']="Closure By Network Managers";
		$this->load->view('Layouts/header',$data);
		$this->load->view('trippings/close_nm',$data);
		$this->load->view('Layouts/footer');
	}
	public function close_nso(){
		$data['trippings']=$this->forced_model->get_trippings_nso();
		$data['title']="Closure By Network System Operations";
		$this->load->view('Layouts/header',$data);
		$this->load->view('trippings/close_nso',$data);
		$this->load->view('Layouts/footer');
	}
	public function close_dso(){
		$data['trippings']=$this->forced_model->get_trippings_dso();
		$data['title']="Acknowledgement By DSO";
		$this->load->view('Layouts/header',$data);
		$this->load->view('trippings/close_dso',$data);
		$this->load->view('Layouts/footer');
	}
	public function cause(){
		
		$data['trippings']=$this->forced_model->get_cause_trippings();
		$data['title']="Cause of Faults";
		$data['faults']=$this->forced_model->get_fault_causes();
		$this->load->view('Layouts/header',$data);
		$this->load->view('trippings/cause_fault',$data);
		$this->load->view('Layouts/footer');
	}
	public function cause_insert($tripping_id){
	
		$insert_data=array("cause_remark"=>$this->input->post('remarks'),"fault_cause_id"=>$this->input->post('fault_id'),"expected_res_date"=>$this->input->post('expected_res_date'),"caused"=>1);

		$result=$this->forced_model->update_fault($tripping_id,$insert_data);
		if ($result['status']) {
			$this->session->set_flashdata('success',"Cause of fault Successful!");
			redirect('tripping/cause');
		} else {
			$this->session->set_flashdata('error',$result['message']);
			redirect('tripping/cause');
		}	
	}
	// public function report(){
		
	// 	//$this->form_validation->set_rules('asset_name','Name',"required");
	// 	$this->form_validation->set_rules('asset_type','Type',"required");
	// 	$this->form_validation->set_rules('date','Date',"required");
	// 	//$data['trippings']=$this->forced_model->get_interupted_trippings();
	// 	if ($this->form_validation->run()==FALSE){
	// 	$data['title']="Report";
	// 	//$data['feeders']=$this->forced_model->get_all_feeders();
	// 	$data['faults']=$this->forced_model->get_fault_interrupt();
	// 	$this->load->view('Layouts/header',$data);
	// 	$this->load->view('trippings/report',$data);
	// 	$this->load->view('Layouts/footer');
	// 	}else{
	// 		list($start_date,$end_date)=explode(" - ", $this->input->post('date'));
	// 		$insert_data=array("asset_id"=>$this->input->post('asset_name'),"start_date"=>date("Y-m-d",strtotime($start_date)),"end_date"=>date("Y-m-d",strtotime($end_date)),"fault_id"=>$this->input->post('fault_id'),'type'=>$this->input->post('asset_type'));
	// 		$result=$this->forced_model->report($insert_data);
	// 		if ($this->input->post('asset_name')=='') {
	// 			$data['title']="Fault report for ".$this->input->post('asset_type')."  between ".$start_date." and ".$end_date;
	// 		}else{
	// 			$data['title']="Fault report for ".$this->input->post('asset_name')."  between ".$start_date." and ".$end_date;
	// 		}
			
	// 		$data['faults']=$this->forced_model->get_fault_interrupt();
	// 		$data['report']=$result;
	// 		$this->load->view('Layouts/header',$data);
	// 		$this->load->view('trippings/report',$data);
	// 		$this->load->view('Layouts/footer');
			
	// 	}

	// }

	// public function interruption_report(){
		
	// 	//$this->form_validation->set_rules('asset_name','Name',"required");
	// 	$this->form_validation->set_rules('asset_type','Type',"required");
	// 	$this->form_validation->set_rules('date','Date',"required");
	// 	//$data['trippingstrippingsset_rulesset_rules('date','Date',"required");
	// 	//$data['trippings']=$this->forced_model->get_interupted_trippings();
	// 	if ($this->form_validation->run()==FALSE){
	// 	$data['title']="Report";
	// 	$data['faults']=$this->forced_model->get_fault_reasons();
	// 	$this->load->view('Layouts/header',$data);
	// 	$this->load->view('trippings/report',$data);
	// 	$this->load->view('Layouts/footer');
	// 	}else{
	// 		list($start_date,$end_date)=explode(" - ", $this->input->post('date'));
	// 		$insert_data=array("asset_id"=>$this->input->post('asset_name'),"start_date"=>date("Y-m-d",strtotime($start_date)),"end_date"=>date("Y-m-d",strtotime($end_date)),"fault_id"=>$this->input->post('fault_id'),'type'=>$this->input->post('asset_type'));
	// 		$result=$this->forced_model->interruption_report($insert_data);
	// 		if ($this->input->post('asset_name')=='') {
	// 			$data['title']="Power interruption report for ".$this->input->post('asset_type')."  between ".$start_date." and ".$end_date;
	// 		}else{
	// 			$data['title']="Power interruption report for ".$this->input->post('asset_name')."  between ".$start_date." and ".$end_date;
	// 		}
	// 		$data['faults']=$this->forced_model->get_fault_reasons();
	// 		$data['report']=$result;
	// 		$this->load->view('Layouts/header',$data);
	// 		$this->load->view('trippings/report',$data);
	// 		$this->load->view('Layouts/footer');
			
	// 	}

	// }	
	//this method gets data based on iss,tss ,feeder 11 ,feeder 33 or dtr
	public function auto_complete(){
		//if (isset($_GET['term'])) {
		$term=$this->input->post('term');
		switch ($this->input->post('type')) {
			case 'ISS':
				$result=$this->forced_model->get_search_iss(array("term"=>$term));
				//var_dump($result);
				if (count($result)>0) {
					foreach ($result as $key => $value) {
						$arr_result[]=array('label'=>$value->ISS,'id'=>$value->ISS_ID);
					}
					echo json_encode($arr_result);
				}
				break;
			case 'TS':
				$result=$this->forced_model->get_search_ts(array("term"=>$term));
				//var_dump($result);
				if (count($result)>0) {
					foreach ($result as $key => $value) {
						$arr_result[]=array('label'=>$value->tsname,'id'=>$value->tsid);
					}
					echo json_encode($arr_result);	
				}
				break;
			case 'dtr':
				$result=$this->forced_model->get_search_dtr(array("term"=>$term));
				//var_dump($result);
				if (count($result)>0) {
					foreach ($result as $key => $value) {
						$arr_result[]=array('label'=>$value->transformer_name,'id'=>$value->DTRId);
					}
					echo json_encode($arr_result);
				}
				break;
			case 'feeder_11':
				$result=$this->forced_model->get_search_feeder(array("term"=>$term,"type"=>"feeder_11"));
				//var_dump($result);
				if (count($result)>0) {
					foreach ($result as $key => $value) {
						$arr_result[]=array('label'=>$value->feeder_name,'id'=>$value->feeder_id);
					}
					echo json_encode($arr_result);
				}
				break;
			case 'feeder_33':
				$result=$this->forced_model->get_search_feeder(array("term"=>$term,"type"=>"feeder_33"));
				//var_dump($result);
				if (count($result)>0) {
					foreach ($result as $key => $value) {
						$arr_result[]=array('label'=>$value->feeder_name,'id'=>$value->feeder_id);
					}
					echo json_encode($arr_result);
				}
				break;
		}
			// $result=$this->forced_model->get_search_iss(array("term"=>$term));
			// 	//var_dump($result);
			// 	if (count($result)>0) {
			// 		foreach ($result as $key => $value) {
			// 			$arr_result[]=array('label'=>$value->ISS,'id'=>$value->ISS_ID);
			// 		}
			// 		echo json_encode($arr_result);
			// 	}
		//}
	}
	public function get_asset_type(){
		$type=$this->input->post('type');
		
		$result=$this->forced_model->get_assets_type($type);
		
		echo json_encode($result);
	}
	public function get_fault_inidcators_by_id(){
		$component_id=$this->input->post('component_id');
		
		$result=$this->forced_model->get_fault_inidcators_by_id($component_id);
		
		echo json_encode($result);
	}
}



