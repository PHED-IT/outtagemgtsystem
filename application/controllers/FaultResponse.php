<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * this is controller for planned outages
 */
class FaultResponse extends MY_Controller
{
	//central dispatch
	public function central_dispatch(){
		
		$data['outages']=$this->FaultResponse_model->get_outages(["status <"=>8]);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Fault Responses";
		$data['faults']=$this->planned_model->get_fault_causes();
		$this->load->view('Layouts/header',$data);
		$this->load->view('faultresponse/list_faults',$data);
		$this->load->view('Layouts/footer');
				
	}
	public function capture_fault(){
		
		$data['outages']=$this->FaultResponse_model->get_outages(["created_by"=>$this->session->userdata('USER_ID'),"status <"=>8]);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Fault Responses";
		$this->load->view('Layouts/header',$data);
		$this->load->view('faultresponse/list_faults',$data);
		$this->load->view('Layouts/footer');
				
	}

	// public function tso_page(){
		
	// 	$data['outages']=$this->FaultResponse_model->get_outages();
	// 	//$data['trippings']=$this->planned_model->get_trippings(0);
	// 	$data['title']="Fault Response TSO";
	// 	$this->load->view('Layouts/header',$data);
	// 	$this->load->view('faultresponse/tso_page',$data);
	// 	$this->load->view('Layouts/footer');
				
	// }
	public function agm_nm_page(){
		
		$data['outages']=$this->FaultResponse_model->get_outages(["status <"=>8]);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Fault Response AGM NM";
		$this->load->view('Layouts/header',$data);
		$this->load->view('faultresponse/agm_nm_page',$data);
		$this->load->view('Layouts/footer');
				
	}
	public function store_manager(){
		
		$data['outages']=$this->FaultResponse_model->get_outages(["status <"=>8]);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Fault Response Store Manager";
		$this->load->view('Layouts/header',$data);
		$this->load->view('faultresponse/store_manager',$data);
		$this->load->view('Layouts/footer');	
	}
	public function gm_technical(){
		
		$data['outages']=$this->FaultResponse_model->get_outages(["status <"=>8]);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Fault Response";
		$this->load->view('Layouts/header',$data);
		$this->load->view('faultresponse/gm_technical',$data);
		$this->load->view('Layouts/footer');	
	}
	public function dso_page(){
		$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		$data['outages']=$this->FaultResponse_model->get_outages(["fault_responses.voltage_level"=>"11kv","fault_responses.station_id"=>$user->iss,"status <"=>8]);
		$data['faults']=$this->planned_model->get_fault_causes();
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Fault Response DSO";
		$this->load->view('Layouts/header',$data);
		$this->load->view('faultresponse/dso_page',$data);
		$this->load->view('Layouts/footer');
				
	}

	public function lines_man(){
		$user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
		$data['user']=$user;
		
		$data['faults']=$this->planned_model->get_fault_causes();
		$data['outages']=$this->FaultResponse_model->get_outages(["fault_responses.department"=>$user->role_id,"status <"=>8]);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Fault Response Coordinitor";
		$this->load->view('Layouts/header',$data);
		$this->load->view('faultresponse/lines_man',$data);
		$this->load->view('Layouts/footer');
				
	}
		

	public function view_outage($outage_id){
		
		$data['outage']=$this->planned_model->get_outage($outage_id);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Outages";
		
		$this->load->view('planned_outages/view_outage',$data);		
	}
	public function prepare_boq($outage_id){
		
		$data['outage']=$this->FaultResponse_model->get_outage($outage_id);
		$data['materials']=$this->FaultResponse_model->materials();
		$data['title']="Prepare BOQ";
		
		$this->load->view('faultresponse/prepare_boq',$data);		
	}

	public function edit_boq($outage_id){
		
		$data['outage']=$this->FaultResponse_model->get_outage($outage_id);
		$data['boqs']=$this->FaultResponse_model->get_boq($outage_id);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Edit BOQ";
		
		$this->load->view('faultresponse/edit_boq',$data);		
	}

	public function view_boq($outage_id){
		
		$data['outage']=$this->FaultResponse_model->get_outage($outage_id);
		$data['boqs']=$this->FaultResponse_model->get_boq($outage_id);
		//$data['total_amount']=$this->FaultResponse_model->total_price($outage_id);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="View BOQ";
		
		$this->load->view('faultresponse/view_boq',$data);		
	}
	public function view_report($outage_id){
		
		$data['outage']=$this->FaultResponse_model->get_outage_report($outage_id);
		//$data['boqs']=$this->FaultResponse_model->get_boq($outage_id);
		//$data['total_amount']=$this->FaultResponse_model->total_price($outage_id);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="View Report";
		
		$this->load->view('faultresponse/view_report',$data);		
	}
	public function approve_material($outage_id){
		
		$data['outage']=$this->FaultResponse_model->get_outage($outage_id);
		$data['boqs']=$this->FaultResponse_model->get_boq($outage_id);
		//$data['total_amount']=$this->FaultResponse_model->total_price($outage_id);
		//$data['trippings']=$this->planned_model->get_trippings(0);
		$data['title']="Approve BOQ Material";
		
		$this->load->view('faultresponse/approve_material',$data);		
	}


	public function outage_form(){
		
			$data['title']="Fault Entry";
			$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
			//get injection substation for login user
			$data['station']=$this->input_model->get_station($data['user']);
			$data['indicators']=$this->FaultResponse_model->get_fault_indicators();
			//$data['feeders']=$this->input_model->get_feeders();
			$this->load->view('Layouts/header',$data);
			$this->load->view('faultresponse/outage_form',$data);

			$this->load->view('Layouts/footer');
		
	}
	// public function transmission_fault_entry(){
		
	// 		$data['title']="Transmission Fault Entry";
	// 		$data['user']=$this->admin_model->get_user($this->session->userdata('USER_ID'));
	// 		$data['station']=$this->input_model->get_station($data['user']);
	// 		$data['indicators']=$this->FaultResponse_model->get_fault_indicators();
	// 		//$data['feeders']=$this->input_model->get_feeders();
	// 		$this->load->view('Layouts/header',$data);
	// 		$this->load->view('faultresponse/transmission_fault_entry',$data);

	// 		$this->load->view('Layouts/footer');
		
	// }
	
	public function test(){
		$data=array();
		$tsm_users=$this->admin_model->get_users_by_role(8);
		foreach ($tsm_users as $key => $value) {
			array_push($data, ["email"=>$value->email,"phone"=>$value->phone]);

		}
			//var_dump($data);
		foreach ($data as $key => $value) {
			var_dump($data[$key]['phone']);
		}

	}

	public function store_fault_response_request(){
		$department=$this->input->post("department");
		//asset name can be Transmission station or injection sub station
		if ($this->input->post('asset_name')=="TS") {

				//transmission station selected
				$station_id=$this->input->post('trans_st');
				$voltage_level="33kv";
				$status_message="Waiting for ".$department." acknowledgement...";
				$message="You have a Fault response acknowledgement.Please go to noms platform for acknowledgement and BOQ preparation... ";
				$status=2;
				if ($this->input->post('transmission_fault')==1) {
					//is  a transmission fault so set status=8,which means
					$status=7;
					$status_message="Waiting fault to be closed by dispatch...";
				} 
				
				
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
				$status_message="Waiting for docx upload...";
				$status=1;
				$message="You have Fault response request... ";
				if ($this->input->post('transmission_fault')==1) {
					//is  a transmission fault so set status=8,which means
					$status=7;
					$status_message="Waiting for fault to be closed by DSO...";
				} 

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
			
			if ($department=="PC&M") {
				$department="18";
			}elseif ($department=="Lines man") {
				$department="16";
			}elseif ($department=="S/S") {
				$department="20";
			}
			if ($this->input->post("type_response")==1) {
				$response="Fault";
			}else{
				$response="Rapid";
			}
			$outage_id=$this->uniqueId();
			$insert_data=array("station_id"=>$station_id,"transformer_id"=>$transformer,"feeder_id"=>$this->input->post('feeder_id'),'remarks'=>trim($this->input->post('remarks')),'voltage_level'=>$voltage_level,"created_by"=>$this->session->userdata('USER_ID'),"outage_id"=>$outage_id,"status_message"=>$status_message,"status"=>$status,"type_response"=>$this->input->post("type_response"),"reason_id"=>$this->input->post("reason_id"),"duration"=>$this->input->post("duration"),"department"=>$department,"outage_date"=>$this->input->post("outage_date"),"transmission_fault"=>$this->input->post("transmission_fault"),"category"=>$category,"equipment_id"=>$equipment,"end_date"=>$end_date);
			//var_dump($insert_data);

			$result=$this->FaultResponse_model->request_outage($insert_data);
			if ($result['status']) {
				$dataX=array();
				//$sms_users = array();
				$this->session->set_flashdata('success',$result['message']);
				$outage=$this->FaultResponse_model->get_outage($outage_id);
				//get name of equipment
					//get name of equipment
				$item=$this->getEquipmentName($outage->category,$outage->equipment_id);

				
					//check if fault is a transmission fault or not
					//is a transmission fault
					if ($this->input->post("transmission_fault")==1) {
						$message="There is a fault on ".$item." ".$outage->category.". Please go to ".base_url()." for more info...";
						//this is a transmission fault
						if ($category=="Feeder") {
							//check voltage level
							if ($voltage_level=="33kv") {
								$feeder=$this->admin_model->get_feeder33_by_zone_id($outage->equipment_id);
								
							} else {
								$feeder=$this->admin_model->get_feeder_by_zone_id($outage->equipment_id);
							}
							if ($feeder) {
								$zone_id=$feeder->zone_id;
								//get all tsm
							$tsm_users=$this->admin_model->get_users_by_zone_role($zone_id,14);
							//get feeder manager
							$feeder_manager_users=$this->admin_model->get_users_by_zone_role($zone_id,12);	
							}

						

							
							//var_dump($zone_id);
							
							if(isset($tsm_users)){
								foreach ($tsm_users as $key => $user) { 
									array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
							//$this->sendEmail($user->email,"PHED NOMS NOTIFICATION",'Dear '.$user->last_name.', <br/>'.$message);
							//array_push($sms_users, $user->phone);
								}
							}
							if(isset($feeder_manager_users)){
								foreach ($feeder_manager_users as $key => $user) { 
							//$this->sendEmail($user->email,"PHED NOMS NOTIFICATION",'Dear '.$user->last_name.', <br/>'.$message);

							array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);

							//array_push($sms_users, $user->phone);
						}
							}
						// if(count($sms_users)>0){
						// 	$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>$message));
						// }
						
						}
						
						
					} else {
						#not a transmission fault

						if ($category=="Feeder") {
							$message="There is a fault on ".$item." ".$outage->category.". Please go to ".base_url()." for more info...";
							//check voltage level
							if ($voltage_level=="33kv") {
								$feeder=$this->admin_model->get_feeder33_by_zone_id($outage->equipment_id);
								
							} else {
								$feeder=$this->admin_model->get_feeder_by_zone_id($outage->equipment_id);
							}
							if ($feeder) {
								$zone_id=$feeder->zone_id;
								//get all tsm
							$tsm_users=$this->admin_model->get_users_by_zone_role($zone_id,14);
							//get feeder manager
							$feeder_manager_users=$this->admin_model->get_users_by_zone_role($zone_id,12);	
							}
							
							//var_dump($zone_id);
							$sms_new=array();
							if(isset($tsm_users)){
								foreach ($tsm_users as $key => $user) { 
							//$this->sendEmail($user->email,"PHED NOMS NOTIFICATION",'Dear '.$user->last_name.', <br/>'.$message);
							//array_push($sms_new, $user->phone);
									array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
								}
							}
							if(isset($feeder_manager_users)){
								foreach ($feeder_manager_users as $key => $user) { 
							//$this->sendEmail($user->email,"PHED NOMS NOTIFICATION",'Dear '.$user->last_name.', <br/>'.$message);
							//array_push($sms_new, $user->phone);
									array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
						}
							}
						// if(count($sms_new)>0){
						// 	$this->sendSMS(array("phone"=>implode(',', $sms_new),"message"=>$message));
						// }
						
						}
						//send email notification to coordinator responsible
					//get user by role
					$message="You have a fault request to attend to on ".$item." ".$outage->category.". Please go to ".base_url()."  to acknowledge...";
					$users=$this->admin_model->get_users_by_role($department);
					//var_dump($users);
					foreach ($users as $key => $user) { 
							 //$this->sendEmail($user->email,"PHED NOMS NOTIFICATION",'Dear '.$user->last_name.', <br/>'.$message);
							//array_push($sms_users, $user->phone);
						array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
						}
						//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>$message));
					}
					$message="There is a fault  on ".$item." ".$outage->category.". Please go to ".base_url()." for more info...";
					//get hso
					$hso=$this->admin_model->get_users_by_role(11);
					//get coodinator dispatch
					$corrd_dispatch=$this->admin_model->get_users_by_role(22);
					$dispatch=$this->admin_model->get_users_by_role(17);
					foreach ($hso as $key => $user) { 
							
						array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
						}
						foreach ($corrd_dispatch as $key => $user) { 
							
						array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
						}
						foreach ($dispatch as $key => $user) { 
							
						array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
						}
					
					//send email notification
				//var_dump($this->session->session_id);
					if(count($dataX)>0){
							$this->job_model->addToJob($dataX);
							//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>$message));
						}
					echo json_encode(["status"=>true,"outage_id"=>$outage_id]);	
			} else {
				echo json_encode($result);
			}
	}

	
	//dso or dispatch upload docx and acknowledge
	public function acknowled_fault_resp_dso(){
		$dataX=array();
		$images=array();
		if($_FILES["files"]["name"] != '')  
           {  
           	$config["upload_path"] = './docx/';
		   $config["allowed_types"] = 'gif|jpg|png';
		   $this->load->library('upload', $config);
		   $this->upload->initialize($config);
		   //var_dump($_FILES["files"]["name"]);
           	for ($count = 0; $count<count($_FILES["files"]["name"]); $count++) {
           		# code...
           	
                $_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
			    $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
			    $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
			    $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
			    $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
			   // var_dump($_FILES["file"]);
                if($this->upload->do_upload('file'))  
                {  
                     $data = $this->upload->data();  
                     array_push($images, base_url().'docx/'.$data["file_name"]);
                     //$images[]=;
                }  
               
           }  

		$outage_id=$this->input->post('outage_id');
		$outage=$this->FaultResponse_model->get_outage($outage_id);
		if ($department=="18") {
				$department="PCM";
			}elseif ($department=="16") {
				$department="Lines man";
			}elseif ($department=="20") {
				$department=="S/S";
			}
		//$type_response=$this->input->post('type_response');
		$status_message="Waiting ". $department." Coordnitor acknowledgement and BOQ preparation";
		
		

		
		$result=$this->FaultResponse_model->acknowledge($outage_id,['tso_id'=>$this->session->userdata('USER_ID'),'status'=>2,"status_message"=>$status_message,'tso_ack_date'=>date("Y-m-d H:i:s"),"images"=>implode(',', $images)]);
		if ($result['status']) {
			$sms_users = array();
			$outage=$this->FaultResponse_model->get_outage($outage_id);
			if ($outage->type_response==1) {
			$response="Fault";
		
		} else {
			//$status_message="Waiting"" Coordnitor acknowledgement and BOQ";
			$response="Rapid";
		}
			//get name of equipment
				$item=$this->getEquipmentName($outage->category,$outage->equipment_id);
			$message='You have an awaiting '.$response.' response acknowledgement and BOQ preparation on '.$item.'... Please go to '.base_url().' to continue';
			//get coordinators of the requested department
			$users=$this->admin_model->get_users_by_role($outage->department);
			# get email and phone using feeder id to get ibc first then get all users in the ibc
			foreach ($users as $key => $user) {
				array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' '.$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
				//$this->sendEmail($user->email,"PHED NOMS NOTIFICATION",'Dear '.$user->last_name.'<br/>'.'You have an awaiting '.$response.' response acknowledgement and BOQ preparation... Please go to the platform to continue');
				//array_push($sms_users, $user->phone);	
			}
			//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>'You have a $response response notification... Please go to the platform to continue'));


			//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>'You have an awaiting '.$response.' response acknowledgement and BOQ preparation... Please go to the platform to continue.'));
			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
							//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>$message));
			}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
}




		public function auto_complete_materials(){
		//if (isset($_GET['term'])) {
		$search=$this->input->post('search');
		
				$result=$this->FaultResponse_model->get_search_materials(array("search"=>$search));
				//var_dump($result);
				if (count($result)>0) {
					foreach ($result as $key => $value) {
						$arr_result[]=array('label'=>$value->name,'other'=>$value->other);
					}
					echo json_encode($arr_result);
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

	public function acknowle_boq_agm(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->FaultResponse_model->acknowledge($outage_id,['agm_id'=>$this->session->userdata('USER_ID'),'status'=>5,"status_message"=>"AGM acknowledged BOQ...Waiting for Store Manager... ",'agm_ack_date'=>date("Y-m-d H:i:s")]);
		if ($result['status']) {
			//send mail to store manager

			$dataX = array();
			// $outage=$this->FaultResponse_model->get_outage($outage_id);
			// if ($outage->type_response==1) {
			// 	$response="Fault";
			// } else {
			// 	$response="Rapid";
			// }
			$message='You have a request to approve available materials BOQ ... Please go to '.base_url().' to continue';
			
			//get store managers details
			$users=$this->admin_model->get_users_by_role(13);
						# get email and phone using feeder id to get ibc first then get all users in the ibc
						foreach ($users as $key => $user) {
							array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>'Dear '.$user->last_name.' '.$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
							//$this->sendEmail($user->email,"PHED NOTIFICATION",'Dear '.$user->last_name.'<br/>'.'You have a request to approve available materials BOQ ... Please go to the platform to continue');
							//array_push($sms_users, $user->phone);
							// $this->sendSMS(array("phone"=>$user->phone,"message"=>'Dear '.$user->last_name.', '.'You have a Fault response notification... Please go to the platform to continue'));
						}


			//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>'You have a request to approve available materials BOQ ... Please go to the platform to continue'));
			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
		public function getEquipmentName($category,$equipment_id){
		if ($category=="Feeder") {
					$item=$this->admin_model->get_feeder_by_id($equipment_id)->feeder_name;
				}elseif ($category=="Transformer") {
					$item=$this->input_model->get_transformer_by_id($equipment_id)->names_trans;
				}elseif ($category=="Injection substation") {
					$item=$this->input_model->get_iss_id($equipment_id)->iss_names;
				}elseif ($outage->category=="Transmission station") {
					$item=$this->input_model->get_transmission_id($equipment_id)->tsname;
				}
				return $item;
	}
	public function approve_boq_gm(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->FaultResponse_model->acknowledge($outage_id,['gm_id'=>$this->session->userdata('USER_ID'),'status'=>7,"status_message"=>"Approved...waiting fault to be closed",'gm_ack_date'=>date("Y-m-d H:i:s")]);
		if ($result['status']) {
			$dataX=array();
				//send mail to coordinator
			$outage=$this->FaultResponse_model->get_outage($outage_id);
			$user=$this->admin_model->get_user_by_id($outage->lines_man_id);
						
			$message='Dear '.$user->last_name.'<br/>'.'BOQ is approved by General manager technical..You can continue,Awaiting you to close request when work is complete';
			array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
							//$this->sendEmail($user->email,"PHED NOTIFICATION",'Dear '.$user->last_name.'<br/>'.'BOQ is approved by General manager technical..You can continue,Awaiting you to close request when work is complete');
							


			//$this->sendSMS(array("phone"=>$user->phone,"message"=>'BOQ is approved by General manager technical..You can continue,Awaiting you to close request when work is complete'));
			if(count($dataX)>0){
				$this->job_model->addToJob($dataX);
			}
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	//acknowledgment for coordinator ht,pc/m and s/s
	public function acknowled_fault_resp_linesman(){
		$outage_id=$this->input->post('outage_id');
		
		$result=$this->FaultResponse_model->acknowledge($outage_id,['lines_man_id'=>$this->session->userdata('USER_ID'),'status'=>3,"status_message"=>"Awaiting BOQ  ",'lines_ack_date'=>date("Y-m-d H:i:s")]);
		if ($result['status']) {
			//
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	public function submit_report_lines_man(){
		$outage_id=$this->input->post('outage_id');
		if (empty($this->input->post('content'))) {
			echo json_encode(["status"=>false,"message"=>"Content must not be empty"]);
		} else {
					
		$result=$this->FaultResponse_model->acknowledge($outage_id,['status'=>8,"status_message"=>"Work complete",'report_date'=>date("Y-m-d H:i:s"),"fault_cause"=>$this->input->post('fault_cause'),"report"=>$this->input->post('content'),"location"=>$this->input->post('location'),"date_closed"=>$this->input->post('date_closed')]);
		if ($result['status']) {
			//send mail to GM Technical
			$outage=$this->FaultResponse_model->get_outage($outage_id);
				//get name of equipment
				$item=$this->getEquipmentName($outage->category,$outage->equipment_id);

			
			$dso=$this->admin_model->get_user_by_id($outage->tso_id);
			$central_dispatch=$users=$this->admin_model->get_users_by_role(17);
			$message="Work done on ".$item.' '.$outage->category." is complete...";
			$dataX=array();
			if ($outage->category=="Feeder") {
							//check voltage level
							if ($outage->voltage_level=="33kv") {
								$feeder=$this->admin_model->get_feeder33_by_zone_id($outage->equipment_id);
								
							} else {
								$feeder=$this->admin_model->get_feeder_by_zone_id($outage->equipment_id);
							}
							if ($feeder) {
								$zone_id=$feeder->zone_id;
								//get all tsm
							$tsm_users=$this->admin_model->get_users_by_zone_role($zone_id,14);
							//get feeder manager
							$feeder_manager_users=$this->admin_model->get_users_by_zone_role($zone_id,12);	
							}

						

							
							//var_dump($zone_id);
							
							if(isset($tsm_users)){
								foreach ($tsm_users as $key => $user) { 
									array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);
							//$this->sendEmail($user->email,"PHED NOMS NOTIFICATION",'Dear '.$user->last_name.', <br/>'.$message);
							//array_push($sms_users, $user->phone);
								}
							}
							if(isset($feeder_manager_users)){
								foreach ($feeder_manager_users as $key => $user) { 
							//$this->sendEmail($user->email,"PHED NOMS NOTIFICATION",'Dear '.$user->last_name.', <br/>'.$message);

							array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);

							//array_push($sms_users, $user->phone);
						}
							}
						// if(count($sms_users)>0){
						// 	$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>$message));
						// }
						
						}
			// if ($dso) {
			// 	array_push($sms_users, $dso->phone);
			// 	$this->sendEmail($dso->email,"PHED NOMS NOTIFICATION",'Dear '.$dso->last_name.'<br/>'.'Work done on fault is complete and report has been sent ');
							
			// }
			if ($central_dispatch) {
				foreach ($central_dispatch as $key => $user) {
					array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);			
					//$this->sendEmail($dispatch->email,"PHED NOMS NOTIFICATION",'Dear '.$dispatch->last_name.'<br/>'.'Work done on fault is complete ');
					//array_push($sms_users, $dispatch->phone);
				}
			}
			
			
							
				if(count($dataX)>0){
							$this->job_model->addToJob($dataX);
							//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>$message));
						}			

			

			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
		}
	}
	public function acknowled_fault_resp_closure(){
		$outage_id=$this->input->post('outage_id');
				
		$result=$this->FaultResponse_model->acknowledge($outage_id,['status'=>9,"status_message"=>"Fault Request completed successfully",'closure_appr_date'=>date("Y-m-d H:i:s"),"closure_appr_id"=>$this->session->userdata('USER_ID')]);
		if ($result['status']) {
			//send mail to GM Technical


			$outage=$this->FaultResponse_model->get_outage($outage_id);
			//$dso=$this->admin_model->get_user_by_id($outage->tso_id);
			//$coordinator=$this->admin_model->get_user_by_id($outage->lines_man_id);
			
						# get email and phone using feeder id to get ibc first then get all users in the ibc
						//var_dump($user);
			// $sms_users=array();
			// array_push($sms_users, $dso->phone);
			// array_push($sms_users, $coordinator->phone);
			
			// 				$this->sendEmail($dso->email,"PHED NOMS NOTIFICATION",'Dear '.$dso->last_name.'<br/>'.'Work done has been acknowledged..Feeder can now be open. ');
			// 				$this->sendEmail($coordinator->email,"PHED NOMS NOTIFICATION",'Dear '.$coordinator->last_name.'<br/>'.'Work done has been acknowledged...');
							

			// $this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>'Work done has been acknowledged..Feeder can now be open.'));

			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
		
	}
	public function store_boq(){
		//$outage_id=$this->input->post('outage_id');
		
		$result=$this->FaultResponse_model->store_boq(['created_by'=>$this->session->userdata('USER_ID'),'outage_id'=>$this->input->post('outage_id'),"item"=>$this->input->post('item'),"unit"=>$this->input->post('unit'),"remark"=>$this->input->post('remark'),"quantity"=>$this->input->post('quantity')]);
		if ($result['status']) {
			//send mail to agm nm

			$dataX = array();
			// $outage=$this->FaultResponse_model->get_outage($outage_id);
			// if ($outage->type_response==1) {
			// 	$response="Fault";
			// } else {
			// 	$response="Rapid";
			// }
			//get agm nm
			$users=$this->admin_model->get_users_by_role(10);
			$message='You have a request to approve BOQ ... Please go to '.base_url().' to continue';
						
						foreach ($users as $key => $user) {
							array_push($dataX, ["email"=>$user->email,"phone"=>$user->phone,"message"=>$message,"subject"=>"PHED NOMS NOTIFICATION","status"=>"pending","name"=>$user->last_name]);		
							//$this->sendEmail($user->email,"PHED NOTIFICATION",'Dear '.$user->last_name.'<br/>'.'You have a request to approve BOQ ... Please go to the platform to continue');
							//array_push($sms_users, $user->phone);
							// $this->sendSMS(array("phone"=>$user->phone,"message"=>'Dear '.$user->last_name.', '.'You have a Fault response notification... Please go to the platform to continue'));
						}

						//var_dump($sms_users);
			// $this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>'You have a request to approve BOQ ... Please go to the platform to continue'));
if(count($dataX)>0){
							$this->job_model->addToJob($dataX);
							//$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>$message));
						}	

			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	public function approve_boq_material(){
		//$outage_id=$this->input->post('outage_id');
		
		$result=$this->FaultResponse_model->approve_boq_material(['store_manager_id'=>$this->session->userdata('USER_ID'),'outage_id'=>$this->input->post('outage_id'),'boq_id'=>$this->input->post('boq_id'),"quantity"=>$this->input->post('quantity')]);
		if ($result['status']) {
			//send mail to agm nm and gm tech that available materials is approve by store manager
			$sms_users = array();
			// $outage=$this->FaultResponse_model->get_outage($outage_id);
			// if ($outage->type_response==1) {
			// 	$response="Fault";
			// } else {
			// 	$response="Rapid";
			// }
			
			//send notification to gm tecnical
			$users=$this->admin_model->get_users_by_role(9);
						# get email and phone using feeder id to get ibc first then get all users in the ibc
						foreach ($users as $key => $user) {
							$this->sendEmail($user->email,"PHED NOTIFICATION",'Dear '.$user->last_name.'<br/>'.'You have a request to approve BOQ ... Please go to the platform to continue');
							array_push($sms_users, $user->phone);
							// $this->sendSMS(array("phone"=>$user->phone,"message"=>'Dear '.$user->last_name.', '.'You have a Fault response notification... Please go to the platform to continue'));
						}


			$this->sendSMS(array("phone"=>implode(',', $sms_users),"message"=>'You have a request to approve BOQ ... Please go to the platform to continue'));
			echo json_encode($result);
		}else{
			echo json_encode($result);
		}
	}
	public function update_boq(){
		$boq_id=$this->input->post('boq_id');
		
		$result=$this->FaultResponse_model->update_boq($boq_id,['item'=> strtoupper($this->input->post('item')),'remark'=>$this->input->post('remark'),'unit'=>$this->input->post('unit'),'quantity'=>$this->input->post('quantity')]);
		if ($result['status']) {
			//
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
}



