<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * this is controller for planned outages
 */
class Planned extends MY_Controller
{
	public function outage_req_officer(){
		
		$data['outages']=$this->planned_model->get_outage_all(["created_by"=>$this->session->userdata('USER_ID'),"outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day")),"planned_outages.voltage_level"=>"33kv"],'33kv');
		$data['outages_11kv']=$this->planned_model->get_outage_all(["created_by"=>$this->session->userdata('USER_ID'),"outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day")),"planned_outages.voltage_level"=>"11kv"],'11kv');
		
		$data['title']="Planned Outages";
		
		$this->load->view('Layouts/header',$data);
		$this->load->view('planned_outages/outage_req_officer',$data);
		$this->load->view('Layouts/footer');
				
	}

	//network manager
	public function tsm_planned_outage(){
		$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		$data['outages']=$this->planned_model->get_outage_all(["planned_outages.voltage_level"=>"33kv"],'33kv');
		$data['outages_11kv']=$this->planned_model->get_outage_all(["planned_outages.voltage_level"=>"11kv"],'11kv');
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Plan Outages";
		$this->load->view('Layouts/header',$data);
		$this->load->view('planned_outages/tsm_planned_outage',$data);
		$this->load->view('Layouts/footer');
				
	}

	// public function tsm_planned_outage(){
	// 	$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
	// 	$data['outages']=$this->planned_model->get_outage_all(["planned_outages.voltage_level"=>"33kv","outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day"))],'33kv');
	// 	$data['outages_11kv']=$this->planned_model->get_outage_all(["planned_outages.voltage_level"=>"11kv","outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day"))],'11kv');
	// 	//$data['trippings']=$this->planned_model->get_trippings(0);
	// 	$data['title']="Plan Outages";
	// 	$this->load->view('Layouts/header',$data);
	// 	$this->load->view('planned_outages/tsm_planned_outage',$data);
	// 	$this->load->view('Layouts/footer');
				
	// }
	// public function ht_supervisor(){
	// 	$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
	// 	$data['outages']=$this->planned_model->get_outage_all(["outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day"))]);
	// 	$data['title']="Outages";
	// 	$this->load->view('Layouts/header',$data);
	// 	$this->load->view('planned_outages/ht_supervisor',$data);
	// 	$this->load->view('Layouts/footer');			
	// }
	public function ht_coordinator(){
		$data['outages']=$this->planned_model->get_outage_all(["created_by"=>$this->session->userdata('USER_ID'),"outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day")),"planned_outages.voltage_level"=>"33kv"],'33kv');
		$data['outages_11kv']=$this->planned_model->get_outage_all(["created_by"=>$this->session->userdata('USER_ID'),"outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day")),"planned_outages.voltage_level"=>"11kv"],'11kv');
		
		$data['title']="Planned Outages";
		//$data['title']="Outages";
		$this->load->view('Layouts/header',$data);
		$this->load->view('planned_outages/ht_coordinator',$data);
		$this->load->view('Layouts/footer');		
	}


	//feeder manager
	public function hibc_planned_outage(){
		$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));

		$data['outages']=$this->planned_model->get_outage_all(["planned_outages.equipment_id"=>$user->feeder33kv_id,"planned_outages.voltage_level"=>"33kv"],'33kv');

		$data['outages_11kv']=$this->planned_model->get_outage_all(["fediss.feeder33"=>$user->feeder33kv_id],'11kv','feeder_manager');
		
		$data['title']="Planned Outages";
		$this->load->view('Layouts/header',$data);
		$this->load->view('planned_outages/hibc_planned_outage',$data);
		$this->load->view('Layouts/footer');
				
	}
	//dso
	public function tso_planned_outage(){
		$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		$data['outages']=$this->planned_model->get_outage_all(["planned_outages.voltage_level"=>"11kv","planned_outages.voltage_level"=>"11kv","planned_outages.station_id"=>$user->iss],"11kv");
		$data['faults']=$this->planned_model->get_fault_causes();
		$data['title']="DSO Outages";
		$this->load->view('Layouts/header',$data);
		$this->load->view('planned_outages/tso_planned_outage',$data);
		$this->load->view('Layouts/footer');
				
	}
	public function central_dispatch_planned_outage(){
		
		$data['outages']=$this->planned_model->get_outage_all(["outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day")),"planned_outages.voltage_level"=>"33kv"],"33kv");
		$data['outages_11kv']=$this->planned_model->get_outage_all(["outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day")),"planned_outages.voltage_level"=>"11kv"],"11kv");
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Outages";
		$this->load->view('Layouts/header',$data);
		$this->load->view('planned_outages/central_dispatch',$data);
		$this->load->view('Layouts/footer');
				
	}
	public function hso_planned_outage(){
		
		$data['outages']=$this->planned_model->get_outage_all(["status"=>4,"planned_outages.voltage_level"=>"33kv"],"33kv");
		$data['outages_11kv']=$this->planned_model->get_outage_all(["status"=>4,"planned_outages.voltage_level"=>"11kv"],"11kv");
		
		$data['title']="Planned Outages";
		$this->load->view('Layouts/header',$data);
		$this->load->view('planned_outages/hso_planned_outage',$data);
		$this->load->view('Layouts/footer');
				
	}

	public function zonal_head(){
		$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		$data['outages']=$this->planned_model->get_outage_all(["outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day")),"planned_outages.voltage_level"=>"33kv","request_from"=>$user->zone_id],"33kv");
		$data['outages_11kv']=$this->planned_model->get_outage_all(["outage_request_date >="=>date("Y-m-d H:i:s",strtotime("-1 day")),"planned_outages.voltage_level"=>"11kv","request_from"=>$user->zone_id],"11kv");
		
		$data['title']="Planned Outages";
		$this->load->view('Layouts/header',$data);
		$this->load->view('planned_outages/zone_head_outage',$data);
		$this->load->view('Layouts/footer');
				
	}

	public function view_outage($outage_id){
		
		$data['outage']=$this->planned_model->get_outage($outage_id);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="view outage";
		
		$this->load->view('planned_outages/view_outage',$data);			
	}


	public function outage_request_form(){
	
		$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		
		$data['station']=$this->input_model->get_station($data['user']);
		// 	$data['ts_data']=$this->input_model->get_transmissions();
		// $data['iss_data']=$this->input_model->get_iss();
			$data['title']="Outage Request Form";
			$data['reasons']=$this->planned_model->get_outage_reasons();
			$data['users']=$this->admin_model->get_users();
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('planned_outages/outage_request_form',$data);
			$this->load->view('Layouts/footer');
		
	}

	//this function stores outage request

	public function store_plan_outage_request(){
		$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		//var_dump($user);
		$department=$this->input->post("department");
		//check if it transmission station station or injection substation
		if ($this->input->post('asset_name')=="TS") {

				//transmission station selected
				$station_id=$this->input->post('trans_st');
				$voltage_level="33kv";
				
				//$status=1;
				$transformer=$this->input->post('transformer');
				//check if transformer is empty
				if (empty($this->input->post('transformer'))) {
					# outage equipment is transmission statation
					$category="Transmission station";
					$equipment=$this->input->post('trans_st');
				} elseif(empty($this->input->post('feeder_id')))  {
					
						$category="Transformer";
						$equipment=$this->input->post('transformer');
					
				}else{
					$category="Feeder";
					$equipment=$this->input->post('feeder_id');
				}
		
			} else {
				$station_id=$this->input->post('iss_name');
				$voltage_level="11kv";
				//$status_message="Waiting for docx upload...";
				//$status=1;
				$transformer=$this->input->post('transformer_iss');
				if (empty($this->input->post('transformer_iss'))) {
					# outage equipment is iss statation
					$category="Injection substation";
					$equipment=$this->input->post('iss_name');
				} elseif(empty($this->input->post('feeder_id')))  {
					
						$category="Transformer";
						$equipment=$this->input->post('transformer_iss');
				}else{
					$category="Feeder";
					$equipment=$this->input->post('feeder_id');
				}

			}
			
			$plan_date=strtotime($this->input->post('outage_date'));
			$end_date=date('Y-m-d H:i:s',strtotime('+'.$this->input->post('duration').' minutes',$plan_date));
			
			if ($voltage_level=="33kv") {
					//get  zone by transmission
					$zone_id=$this->mis_model->get_transmission($station_id)->zone_id;

									

					//get feeder manager

					$feeder_manager=$this->admin_model->get_feeder_manager($equipment,"33kv");
				} else {
					//11kv

					//get zone by iss
					$zone_id=$this->admin_model->get_zone_by_iss($station_id)->zone_id;

					//get feeder manager
					$feeder_manager=$this->admin_model->get_feeder_manager($equipment,"11kv");

					//get network manager
					
					}
					$image="";
					//upload supporting files.
					 $config['upload_path']="./assets/uploads";
        $config['allowed_types']='gif|jpg|png|pdf';
        $config['encrypt_name'] = TRUE;
         
        $this->load->library('upload',$config);
        if ($_FILES['support_docx']['error'] !== 4){
        	//image is not empty
        	if($this->upload->do_upload("support_docx")){
            $data = array('upload_data' => $this->upload->data());
 
            
            $image= $data['upload_data']['file_name']; 

        }else{
        	//error in image
        	echo json_encode(["status"=>false,"message"=>"Image format not correct"]);
        	return;

        }
        }else{
        	//image is empty
        	$image="";


        }
        // if($this->upload->do_upload("support_docx")){
        //     $data = array('upload_data' => $this->upload->data());
 
            
        //     $image= $data['upload_data']['file_name']; 
			$outage_id=$this->uniqueId();
			$insert_data=array("station_id"=>$station_id,"transformer_id"=>$transformer,"feeder_id"=>$this->input->post('feeder_id'),"duration"=>$this->input->post('duration'),"outage_request_date"=>$this->input->post('outage_date'),'permit_holder_id'=>$this->input->post('permit'),'reason'=>$this->input->post('reason'),'remark'=>$this->input->post('remark'),'voltage_level'=>$voltage_level,"created_by"=>$this->session->userdata('USER_ID'),"outage_id"=>$this->uniqueId(),"status_message"=>"Waiting Feeder manager approval","location"=>$this->input->post('location'),"ptw_type"=>$this->input->post('ptw_type'),"request_from"=>$zone_id,"end_date"=>$end_date,"equipment_id"=>$equipment,"category"=>$category,'oro_desig'=>$user->role_name,"support_docx"=>$image);
			//var_dump($insert_data);

			$result=$this->planned_model->request_outage($insert_data);
			if ($result['status']) {
				$dataX = array();
				$others_users=array();
				$this->session->set_flashdata('success',$result['message']);
				

					//send email notification to coordinator responsible
					//get user by role
					//1st param ibc,2nd role
				
				$ht_coord_users=$this->admin_model->get_users_by_role(16);

				

					

				//get name of equipment
			$item=$this->getEquipmentName($category,$equipment);

				if(isset($feeder_manager)){

				//foreach ($feeder_manager as $key => $user) {
					foreach ($feeder_manager as $key => $user) {
						array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.', <br/>'.'You have a planned outage acknowledgement request for '.$item.' '.$category.'... Please go to  '.base_url().' to acknowledge',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
					}
					
	
						
					}
					
					if ($ht_coord_users) {
						foreach ($ht_coord_users as $key => $user) {
							array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'There is planned outage  request for '.$item.' '.$category.' on '.$end_date ,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);	
						}
						//$this->sendSMS(array("phone"=>implode(',', $others_users),"message"=>'There is planned outage  request for '.$item.' '.$category.' on '.$end_date ));
					}
					
					if(count($dataX)>0){
							$this->job_model->addToJob($dataX);
							
					echo json_encode(["status"=>true,"outage_id"=>$outage_id]);	
			} else {
				echo json_encode($result);
			}
		}
	// }else{
	// 	echo json_encode(["status"=>false,"message"=>"Image format not correct"]);	
	// }
}

	
	public function getEquipmentName($category,$equipment_id){
		if ($category=="Feeder") {
					$item=$this->admin_model->get_feeder_by_id($equipment_id)->feeder_name;
				}elseif ($category=="Transformer") {
					$item=$this->admin_model->get_transformer_by_id($equipment_id)->names_trans;
				}elseif ($category=="Injection substation") {
					$item=$this->input_model->get_iss_id($equipment_id)->iss_names;
				}elseif ($category=="Transmission station") {
					$item=$this->input_model->get_transmission_id($equipment_id)->tsname;
				}
				return $item;
	}

	//network manager
	public function acknowled_plan_out_tsm(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->acknowled_plan_out_tsm($outage_id,['tsm_id'=>$this->session->userdata('USER_ID'),'status'=>4,"status_message"=>"Waiting HSO approval... ",'tsm_ack_date'=>date("Y-m-d H:i:s")]);
		if ($result['status']) {
			$dataX = array();
			//send mail to coordinator dispatch
			
			$outage=$this->planned_model->outage($outage_id);
			//request officer
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			
			//$ht_coord_users=$this->admin_model->get_users_by_role(16);
			//get name of equipment
				$item=$this->getEquipmentName($outage->category,$outage->equipment_id);

			//get coodinator dispatch
				$coordinator_dispatch=$this->admin_model->get_users_by_role(22);
				//central dispatch
				$dispatch=$this->admin_model->get_users_by_role(17);

				//get hso
			$hso=$this->admin_model->get_users_by_role(11);
			//
			
			foreach ($hso as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' You have a planned outage approval request on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to approve',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}
			foreach ($coordinator_dispatch as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' There is an outage request on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}
			foreach ($dispatch as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' There is an outage request on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}
			// foreach ($ht_coord_users as $key => $user) {
			// 	array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Outage request is approved by Network manager...Waiting HSO  approval',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			// }
			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Outage request is approved by Network manager...Waiting HSO  approval',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$oro->last_name]);
			if(count($dataX)>0){
							$this->job_model->addToJob($dataX);
							//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>$message));
						}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	public function confirm_work_done_plan(){
		$outage_id=$this->input->post('outage_id');
		$result=$this->planned_model->acknowled_plan_out_tsm($outage_id,['report_id'=>$this->session->userdata('USER_ID'),'status'=>7,"status_message"=>"Work Complete",'report_date'=>date("Y-m-d H:i:s"),"fault_cause"=>$this->input->post('fault_cause'),"report"=>$this->input->post('content')]);
		if ($result['status']) {
			// 
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	public function acknowled_plan_out_ht_supervisor(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->acknowled_plan_out_tsm($outage_id,['ht_sup_id'=>$this->session->userdata('USER_ID'),'status'=>2,"status_message"=>"Waiting HT coordinator acknowledgement... ",'ht_sup_ack_date'=>date("Y-m-d H:i:s")]);
		if ($result['status']) {
			//send mail to ht coordinator
			$sms_users = array();
			$st_users=$this->admin_model->get_users_by_role(16);

			foreach ($st_users as $key => $s_user) {
				$this->sendEmail($s_user->email,"PHED NOMS NOTIFICATION",'Dear '.$s_user->last_name.', <br/>'.'You have a planned outage acknowledgement request... Please go to  the platform to acknowledge');
				array_push($sms_users, $s_user->phone);	
			}
			//var_dump($sms_users);
			$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>'You have a planned outage acknowledgement request... Please go to  the platform to acknowledge'));
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	public function acknowled_plan_out_ht_coordinator(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->acknowled_plan_out_tsm($outage_id,['ht_cord_id'=>$this->session->userdata('USER_ID'),'status'=>4,"status_message"=>"Waiting HSO approval... ",'ht_cord_ack_date'=>date("Y-m-d H:i:s")]);
		if ($result['status']) {

			$outage=$this->planned_model->outage($outage_id);
			
			$dataX = array();
			
			
			//get name of equipment
				$item=$this->getEquipmentName($outage->category,$outage->equipment_id);

			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			$hso=$this->admin_model->get_users_by_role(11);

			
			foreach ($hso as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' You have a planned outage approval request on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to approve',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}
			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Outage request is approved by HT Coordinator...Waiting HSO approval',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			if(count($dataX)>0){
							$this->job_model->addToJob($dataX);
							//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>$message));
						}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	// public function acknowled_plan_out_cd(){
	// 	$outage_id=$this->input->post('outage_id');
		
	// 	$result=$this->planned_model->acknowled_plan_out_tsm($outage_id,['cd_id'=>$this->session->userdata('USER_ID'),'status'=>4,"status_message"=>"Central Dispatch Acknowledged... ",'cd_ack_date'=>date("Y-m-d H:i:s")]);
	// 	if ($result['status']) {
	// 		//send mail to hso
	// 		echo json_encode($result);
	// 	}else{
	// 		echo json_encode($result);
	// 	}
	// }

//feeder manager
	public function approve_plan_out_hibc(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->approve_plan_out_hibc($outage_id,['hibc_id'=>$this->session->userdata('USER_ID'),'status'=>3,"status_message"=>"Waiting Network manager approval... ",'hibc_approve_date'=>date("Y-m-d H:i:s")]);
		if ($result['status']) {
			//send mail to central dispatch
			$dataX = array();
			$outage=$this->planned_model->outage($outage_id);
			$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			//
			$tsm=$this->admin_model->get_users_by_zone_role($outage->request_from,14);
			//$st_users=$this->admin_model->get_users_by_role(22);
			//$ht_coord_users=$this->admin_model->get_users_by_role(16);
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			//send to network manager notification
			foreach ($tsm as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' You have a planned outage approval request on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to approve',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
						}

				// 		foreach ($ht_coord_users as $key => $user) {
				// array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Outage request is approved by Feeder manager...Waiting Network manager approval',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
				// 		}
				//$this->sendEmail($user->email,"PHED NOMS NOTIFICATION",'Dear '.$user->last_name.', <br/>'.'You have a planned outage approval request... Please go to  the platform to approve');
				//array_push($sms_users, $user->phone);	
			
			//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>'You have a planned outage approval request... Please go to  the platform to approve'));
			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Outage request is approved by Feeder manager...Waiting Network manager approval',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			//$this->sendSMS(array("phone"=>implode(',', $oro->phone),"message"=>'Outage request is approved by Feeder manager...Waiting coordinator dispatch approval'));
			if(count($dataX)>0){
			$this->job_model->addToJob($dataX);
			}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	//approve plan outage function dispatch cordinator
	public function approve_plan_out_cd(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->approve_plan_out_hibc($outage_id,['cd_id'=>$this->session->userdata('USER_ID'),'status'=>4,"status_message"=>"Waiting HSO approval ",'cd_ack_date'=>date("Y-m-d H:i:s")]);
		if ($result['status']) {
			$outage=$this->planned_model->outage($outage_id);
			$dataX = array();
			
			$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			//request officer
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			//send mail to hso
			$sms_users = array();
			$ht_coord_users=$this->admin_model->get_users_by_role(16);
			//get hso
			$hso=$this->admin_model->get_users_by_role(11);
			foreach ($hso as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' You have a planned outage approval request on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to approve',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}
			foreach ($ht_coord_users as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Outage request for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' is approved by Coordinator dispatch...Waiting HSO approval',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}
			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Outage request is approved by Coordinator dispatch...Waiting HSO approval',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$oro->last_name]);
			//$this->sendSMS(array("phone"=>implode(',', $oro->phone),"message"=>'Outage request is approved by Feeder manager...Waiting coordinator dispatch approval'));
			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}



	public function approve_plan_out_hso(){
		$outage_id=$this->input->post('outage_id');
		$outage=$this->planned_model->outage($outage_id);
		$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			//$permit_holder=$this->admin_model->get_user_by_id($outage->permit_holder_id);
			$planed_date=$outage->outage_request_date;
			//get dso if 11k or central dispatch if 33kv
			$voltage_level=$outage->voltage_level;
			$dataX = array();
				if ($voltage_level=="11kv") {
				//get dso
				$status_message="Waiting DSO approval...";
				$dso=$this->admin_model->get_user_by_iss($outage->station_id);
				foreach ($dso as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' You have a planned outage approval request on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to approve',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}
			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Outage on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' request is approved by HSO...Waiting DSO approval...',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);

			// $dispatch_cordinator=$this->admin_model->get_users_by_role(22);
			// foreach ($dispatch_cordinator as $key => $user) {
			// 	array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Outage on '.$item.' '.$outage->category.' approved by HSO... waiting DSO approval ' .$outage->outage_request_date.' Please go to '.base_url().'',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			// }
			// 	$dispatch=$this->admin_model->get_users_by_role(17);
			// 	foreach ($dispatch as $key => $user) {
			// 	array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Outage on '.$item.' '.$outage->category.' approved by HSO... waiting DSO approval ' .$outage->outage_request_date.' Please go to '.base_url().'',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			// }
			} else {
				//33kv 
				//get central dispatch;
				//$status_message="Outage on ".$item." ".$outage->category." on ".$outage->outage_request_date." is approved by HSO...Go to Noms to start the outage when due";
				//$dispatch_cordinator=$this->admin_model->get_users_by_role(22);
			// 	foreach ($dispatch_cordinator as $key => $user) {
			// 	array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Outage on '.$item.' '.$outage->category.' approve by HSO... waiting to start outage on ' .$outage->outage_request_date.' Please go to '.base_url().'',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			// }
				//oro
				array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Outage on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' request is approved by HSO...Please go to '.base_url().' to print outage form...',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$oro->last_name]);
			}
		
		$result=$this->planned_model->approve_plan_out_hibc($outage_id,['hso_id'=>$this->session->userdata('USER_ID'),'status'=>5,"status_message"=>$status_message,'hso_approve_date'=>date("Y-m-d H:i:s")]);
		if ($result['status']) {
			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	//dso
	public function approve_plan_out_tso(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->approve_plan_out_hibc($outage_id,['tso_id'=>$this->session->userdata('USER_ID'),'status'=>6,"status_message"=>"Outage approved by DSO waiting to start outage",'tso_approve_date'=>date("Y-m-d H:i:s"),"ptw_number"=>$this->input->post('ptw_number')]);
		if ($result['status']) {
			
			$outage=$this->planned_model->outage($outage_id);
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			//$started_by=$this->admin_model->get_user_by_id($outage->tso_id);
			
			$dataX = array();
			$planed_date=$outage->outage_request_date;
			$item=$this->getEquipmentName($outage->category,$outage->equipment_id);

			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Outage on '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' request is approved by DSO...Please go to '.base_url().' to print outage form...',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$oro->last_name]);
			//array_push($sms_users, $oro->phone);
			//central dispatch
			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}

			//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>'Planned outage for '.$planed_date.' started ..Go to the platform for more info.'));
			echo json_encode($result);

		}else{
			echo json_encode($result);
		}
	}
	//feeder manager 
	public function hibc_reject_plan_out(){
		$outage_id=$this->input->post('outage_id');
		$reason=$this->input->post('reason_rejection_hibc');
		$result=$this->planned_model->approve_plan_out_hibc($outage_id,['reject_by_id'=>$this->session->userdata('USER_ID'),'status'=>0,"status_message"=>"HIBC rejects... ","reject_by"=>"FEEDER MANAGER",'rejection_date'=>date("Y-m-d H:i:s"),"rejection_reason"=>trim($reason)]);
		if ($result['status']) {
			//send mail to oro,tsm
			$dataX = array();
			$outage=$this->planned_model->outage($outage_id);
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			//$tsm=$this->admin_model->get_user_by_id($outage->tsm_id);
			$planed_date=$outage->outage_request_date;

			$cord_dispatch=$this->admin_model->get_users_by_role(22);
			
			$hso=$this->admin_model->get_users_by_role(11);
			$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			foreach ($hso as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Planned outage is rejected by Feeder manager for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}

			foreach ($cord_dispatch as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Planned outage is rejected by Feeder manager for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}

			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Dear '.$oro->last_name.' Planned outage is rejected by Feeder manager for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$oro->last_name]);

			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	public function reject_plan_out_dso(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->approve_plan_out_hibc($outage_id,['reject_by_id'=>$this->session->userdata('USER_ID'),'status'=>0,"status_message"=>"DSO rejects... ","reject_by"=>"DSO",'rejection_date'=>date("Y-m-d H:i:s"),"rejection_reason"=>trim($this->input->post('reason_rejection'))]);
		if ($result['status']) {
			//send mail to oro,tsm
			$outage=$this->planned_model->outage($outage_id);
			$dataX = array();
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			//$tsm=$this->admin_model->get_user_by_id($outage->tsm_id);
			//$sub_zone_id=$this->admin_model->get_user_by_id($outage->created_by)->sub_zone_id;
			
			//$hibc=$this->admin_model->get_users_by_sub_zone_role($sub_zone_id,12);
			$dispatch_cordinator=$this->admin_model->get_users_by_role(22);
			$planed_date=$outage->outage_request_date;
			$sms_users=array();
			$cord_dispatch=$this->admin_model->get_users_by_role(22);
			
			$hso=$this->admin_model->get_users_by_role(11);
			$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			foreach ($hso as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Planned outage is rejected by Feeder manager for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}

			foreach ($cord_dispatch as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Planned outage is rejected by Feeder manager for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}

			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Dear '.$oro->last_name.' Planned outage is rejected by Feeder manager for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$oro->last_name]);

			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}

			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	public function tsm_reject_plan_out(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->approve_plan_out_hibc($outage_id,['reject_by_id'=>$this->session->userdata('USER_ID'),'status'=>0,"status_message"=>"TSM rejects... ","reject_by"=>"TSM",'rejection_date'=>date("Y-m-d H:i:s"),"rejection_reason"=>trim($this->input->post('reason_rejection_tsm'))]);
		if ($result['status']) {
			//send mail to oro,tsm
			$outage=$this->planned_model->outage($outage_id);
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			$feeder_managers=$this->admin_model->get_user_by_id($outage->hibc_id);
			//$tsm=$this->admin_model->get_user_by_id($outage->tsm_id);
			$planed_date=$outage->outage_request_date;
			$cord_dispatch=$this->admin_model->get_users_by_role(22);
			
			$hso=$this->admin_model->get_users_by_role(11);
			$dataX=array();
			$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			foreach ($hso as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Planned outage is rejected by Network Managers for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}

			foreach ($cord_dispatch as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Planned outage is rejected by Network Managers  for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}
			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Dear '.$oro->last_name.' Planned outage is rejected by Network Managers for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$oro->last_name]);

			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}

			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	public function cd_reject_plan_out(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->approve_plan_out_hibc($outage_id,['reject_by_id'=>$this->session->userdata('USER_ID'),'status'=>0,"status_message"=>"Central dispatch rejects... ","reject_by"=>"Central dispatch",'rejection_date'=>date("Y-m-d H:i:s"),"rejection_reason"=>trim($this->input->post('reason_rejection'))]);
		if ($result['status']) {
			//send mail to all
			$dataX=array();

			$outage=$this->planned_model->outage($outage_id);
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			if (empty($outage->request_from) || $outage->request_from==7)  {
				# request from hq
				$tsm=$this->admin_model->get_user_by_id($outage->ht_cord_id);

			} else {
				# from zones
				$tsm=$this->admin_model->get_user_by_id($outage->tsm_id);
				$feeder_managers=$this->admin_model->get_user_by_id($outage->hibc_id);
				array_push($dataX, ["email"=>$tsm->email,"phone"=>$tsm->phone,"message"=>'Dear '.$tsm->last_name.' Planned outage is rejected by Coordinator Dispatch for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$tsm->last_name]);
			
			array_push($dataX, ["email"=>$feeder_managers->email,"phone"=>$feeder_managers->phone,"message"=>'Dear '.$feeder_managers->last_name.' Planned outage is rejected by Coordinator Dispatch for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$feeder_managers->last_name]);
			}
			
			$cord_dispatch=$this->admin_model->get_users_by_role(22);
			
			$hso=$this->admin_model->get_users_by_role(11);
			
			$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			foreach ($hso as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Planned outage is rejected by Coordinator Dispatch for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}

			
			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Dear '.$oro->last_name.' Planned outage is rejected by Coordinator Dispatch for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$oro->last_name]);


			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}

			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}

	// public function cd_approve_date_plan_out(){
	// 	$outage_id=$this->input->post('outage_id');
		
	// 	$result=$this->planned_model->approve_plan_out_hibc($outage_id,['cd_id'=>$this->session->userdata('USER_ID'),'status'=>4,"status_message"=>"Central dispatch approves date... ",'cd_ack_date'=>date("Y-m-d H:i:s"),"approved_date_time"=>trim($this->input->post('outage_approved_date'))]);
	// 	if ($result['status']) {
	// 		//send mail to hso,tsm and oro
	// 		echo json_encode($result);
	// 	}else{
	// 		echo json_encode($result);
	// 	}
	// }
	public function hso_reject_plan_out(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->planned_model->approve_plan_out_hibc($outage_id,['reject_by_id'=>$this->session->userdata('USER_ID'),'status'=>0,"status_message"=>"HSO rejects... ","reject_by"=>"HSO",'rejection_date'=>date("Y-m-d H:i:s"),"rejection_reason"=>trim($this->input->post('reason_rejection'))]);
		if ($result['status']) {
			//send mail to oro,tsm and central dispatch
			$dataX=array();
			$outage=$this->planned_model->outage($outage_id);
			$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			$oro=$this->admin_model->get_user_by_id($outage->created_by);
			$cord_dispatch=$this->admin_model->get_users_by_role(22);
			if (empty($outage->request_from) || $outage->request_from==7)  {
				# request from hq
				$tsm=$this->admin_model->get_user_by_id($outage->ht_cord_id);
				$feeder_managers=$this->admin_model->get_user_by_id($outage->hibc_id);
				array_push($dataX, ["email"=>$tsm->email,"phone"=>$tsm->phone,"message"=>'Dear '.$tsm->last_name.' Planned outage is rejected by HSO for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$tsm->last_name]);
			} else {
				# from zones
				$tsm=$this->admin_model->get_user_by_id($outage->tsm_id);
				$feeder_managers=$this->admin_model->get_user_by_id($outage->hibc_id);
				array_push($dataX, ["email"=>$tsm->email,"phone"=>$tsm->phone,"message"=>'Dear '.$tsm->last_name.' Planned outage is rejected by HSO for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$tsm->last_name]);
			
			array_push($dataX, ["email"=>$feeder_managers->email,"phone"=>$feeder_managers->phone,"message"=>'Dear '.$feeder_managers->last_name.' Planned outage is rejected by HSO for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$feeder_managers->last_name]);
			}
			foreach ($cord_dispatch as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' Planned outage is rejected by HSO  for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
			}
			array_push($dataX, ["email"=>$oro->email,"phone"=>$oro->phone,"message"=>'Dear '.$oro->last_name.' Planned outage is rejected by HSO for '.$item.' '.$outage->category.' on ' .$outage->outage_request_date.' Please go to '.base_url().' to view more',"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$oro->last_name]);
			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	// public function dso_reject_plan_out(){
	// 	$outage_id=$this->input->post('outage_id');
		
	// 	$result=$this->planned_model->approve_plan_out_hibc($outage_id,['tso_id'=>$this->session->userdata('USER_ID'),'status'=>11,"status_message"=>"DSO rejects... ",'tso_approve_date'=>date("Y-m-d H:i:s"),"reason_rejection_tso"=>trim($this->input->post('reason_rejection_tso'))]);
	// 	if ($result['status']) {
	// 		//send mail to oro,tsm
	// 		echo json_encode($result);
	// 	}else{
	// 		echo json_encode($result);
	// 	}
	// }
}



