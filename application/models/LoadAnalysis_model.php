<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * this is model for load analysis entry and report
 */
class LoadAnalysis_model extends MY_Model
{

	protected $log_sheet_table="log_sheet";

	public function get_hourly_daily_load_by_feeder($data){
		$this->db->select(array("load_reading",'hour','captured_at','status'));
		
		
			$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"isIncommer"=>0,"hour"=>$data['hour']));
		if ($data['voltage_level']=="33kv") {
			$this->db->join("feeders_33kv",'feeders_33kv.id = log_sheet.feeder_id');
			$query=$this->db->get($this->log_sheet_table);
		} else {
			
			$this->db->join("feeders_11kv",'feeders_11kv.id = log_sheet.feeder_id');
			$query=$this->db->get($this->log_sheet_table);
		}
		
		 
		return $query->row();
	}

	public function get_daily_avg_by_feeder($data){
		//this gets average for on hour
		$this->db->select_avg("load_reading",'avg');
		$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"isIncommer"=>0,"status"=>"on"));
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}

	public function get_monthly_avg_by_feeder($data){
		//this gets average for on hour y-m-d
		$date=explode('-', $data['date']);
			list($year,$month,$day)=$date;
		
		$this->db->select_avg("load_reading",'avg');
		$this->db->where(array('MONTH(captured_at)'=>$month,'YEAR(captured_at)'=>$year,'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}

	public function get_daily_forced_duration($data){
		//this gets average for on hour
		$this->db->select("COUNT(*) as count");
		$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		$this->db->where_in("status",["EF","OC","IMB","EMG"]);
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}
	public function get_total_tx_duration_daily($data){
		//this gets average for on hour
		$this->db->select("COUNT(*) as count");
		$this->db->where(array('captured_at'=>$data['date'],"isIncommer"=>0));
		$this->db->where_in("status",["OFF","OUT","NS","BF","OS"]);
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}
	public function get_total_tx_aff_feeder_daily($data){
		//this gets average for on hour
		$this->db->select("COUNT(feeder_id) as count");
		$this->db->where(array('captured_at'=>$data['date'],"isIncommer"=>0,"voltage_level"=>"33kv"));
		$this->db->where_in("status",["OFF","OUT","NS","BF","OS"]);
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}
	public function get_total_forced_duration_daily($data){
		//this gets average for on hour
		$this->db->select("COUNT(*) as count");
		$this->db->where(array('captured_at'=>$data['date'],"isIncommer"=>0,"voltage_level"=>"33kv"));
		$this->db->where_in("status",["EF","OC","IMB","EMG"]);
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}
	public function get_total_forced_feeder_daily($data){
		//this gets average for on hour
		$this->db->select("COUNT(feeder_id) as count");
		$this->db->where(array('captured_at'=>$data['date'],"isIncommer"=>0));
		$this->db->where_in("status",["EF","OC","IMB","EMG"]);
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}
	public function get_daily_tx_duration($data){
		//this gets average for on hour
		$this->db->select("COUNT(*) as count");
		$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		$this->db->where_in("status",["OFF","OUT","NS","BF","OS"]);
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}
	public function get_daily_tx_feeder($data){
		//this gets average for on hour
		$this->db->select("COUNT(feeder) as count");
		$this->db->where(array('captured_at'=>$data['date'],'feeder_id'=>$data['feeder_id'],"isIncommer"=>0));
		$this->db->where_in("status",["OFF","OUT","NS","BF","OS"]);
		$query=$this->db->get($this->log_sheet_table);
		return $query->row();
	}
	
	public function get_analysis_daily_hour_data($data){
		
		$this->db->where(array('captured_at'=>$data['date'],"hour"=>$data['hour']));
		
		$query=$this->db->get("load_analysis");
		return $query->row();
	}

	//this gets sum of nlng and epcl load for a day and hour
	public function get_total_ecl_nlng_load($data){
		//epcl
		$epcl_id=244;
		$nlng_id=243;
		$this->db->where(array('captured_at'=>$data['date'],"hour"=>$data['hour'],"feeder_id"=>$epcl_id,"voltage_level"=>"33kv"));
		
		$queryE=$this->db->get("log_sheet");
		//var_dump($queryE->row());

		$epcl_load_mw= ($queryE->row())?$queryE->row()->load_reading:0;

		//nlng

		$this->db->where(array('captured_at'=>$data['date'],"hour"=>$data['hour'],"feeder_id"=>$nlng_id,"voltage_level"=>"33kv"));
		
		$queryNLN=$this->db->get("log_sheet");
		$nlng_load_mw= ($queryNLN->row())?$queryNLN->row()->load_reading:0;

		$sum=$epcl_load_mw+$nlng_load_mw;
		return $sum;
	}

	//this gets sum of ph and bayelsa load by day and hour
	public function get_sum_ph_bayelsa_load_daily($data){
		//this gets average for on hour
		$this->db->select_sum("load_reading","sum");
		$this->db->from("log_sheet");
		$this->db->join("transmissions","log_sheet.station_id=transmissions.id ");
		$this->db->where(array('captured_at'=>$data['date'],"isIncommer"=>0,"hour"=>$data["hour"],"voltage_level"=>"33kv"));
		$this->db->where_in("transmissions.state",[1,2]);
		$query=$this->db->get();
		return $query->row();
	}

	public function get_sum_state_load_daily($data){
		//this get sum state wise load for hour and day
		$this->db->select_sum("load_reading","sum");
		$this->db->from("log_sheet");
		$this->db->join("transmissions","log_sheet.station_id=transmissions.id ");
		$this->db->where(array('captured_at'=>$data['date'],"isIncommer"=>0,"hour"=>$data["hour"],"voltage_level"=>"33kv"));
		$this->db->where_in("transmissions.state",[$data['state_id']]);
		$query=$this->db->get();
		return $query->row();
	}

	public function get_avg_state_load_daily($data){
		//this get sum state wise load for hour and day
		$this->db->select_avg("load_reading","avg");
		$this->db->from("log_sheet");
		$this->db->join("transmissions","log_sheet.station_id=transmissions.id ");
		$this->db->where(array('captured_at'=>$data['date'],"isIncommer"=>0,"voltage_level"=>"33kv"));
		$this->db->where_in("transmissions.state",[$data['state_id']]);
		$query=$this->db->get();
		return $query->row();
	}

	//this gets sum of uyo,itu,ekim,calabar,eket and bayelsa load by day and hour
	public function get_sum_transmission_load_daily($data){
		//this gets average for on hour
		$this->db->select_sum("load_reading","sum");
		$this->db->from("log_sheet");
		
		$this->db->where(array('captured_at'=>$data['date'],"isIncommer"=>0,"hour"=>$data["hour"],"voltage_level"=>"33kv"));
		$this->db->where_in("station_id",[8,7,22,3,4]);
		$query=$this->db->get();
		return $query->row();
	}

	public function daily_load_analysis_report($input){
		$data='<thead style="background-color:#278acd;color:white"><tr>';
		$data.='<th class="fixed-side" scope="col" style="border:1px solid #000;color:#fff">HOURS</th>';
		//$data.='<th>FEEDER</th>';
		
		$data.="<th style='color:#fff'>MYTO ALLOCATION(MW)</th>";
		$data.="<th style='color:#fff'>EMBEDED LOAD  (EPCL+TRANS AMADI)(MW)</th>";
		$data.="<th style='color:#fff'>ALLOCATION (MYTO ALLOCATION +EMBEDED LOAD)(MW)(A)</th>";
		
		$data.="<th style='color:#fff'>CONSUMPTION FROM PORT HARCOURT AND BAYELSA (MW)</th>";
		$data.="<th style='color:#fff'>CONSUMPTION FROM EMBEDED  (MW)</th>";
		$data.="<th style='color:#fff'>CONSUMPTION FROM ITU,CALABAR,UYO,EKET(MW)</th>";
		$data.="<th style='color:#fff'>ACTUAL DISPATCHED (MW)(B)</th>";
		$data.="<th style='color:#fff'>DIFFERENCE (MW)(A-B)</th>";
		$data.="<th style='color:#fff'>FORCASTED LOAD (MW)</th>";
		
		$data.='</tr></thead><tbody>';
		$total_myto_allocaton_mw=0;
		$total_myto_allocaton_a=0;
		$total_epcl_nlng=0;
		$total_consumption_embeded=0;
		$total_sum_ph_bayelsa=0;
		$total_cons_itu_cal=0;
		$total_actual_dispatch=0;
		$total_difference=0;
		$total_forecasted=0;
		$count=0;
		//$total_myto_allocaton_mw=0;
		for ($hour=0; $hour <=23 ; $hour++) { 
			$data.="<tr>";
			$data.="<th class='fixed-side'>".$this->format_hour($hour)."</th>";
		$load_analysis=$this->get_analysis_daily_hour_data(["date"=>$input["date"],"hour"=>$hour]);
		if (isset($load_analysis)) {
			$total_myto_allocaton_mw+=$load_analysis->myto_allocaton_mw;
			$total_myto_allocaton_a+=$load_analysis->myto_allocaton_a;
			$total_consumption_embeded+=$load_analysis->consumption_embeded;
			$total_forecasted+=$load_analysis->forecasted_load;
			$count++;
			//$total_myto_allocaton_mw+=$load_analysis->myto_allocaton_mw;
		} else {
			# code...
		}
		
		$data.="<td>".(isset($load_analysis)?$load_analysis->myto_allocaton_mw:0)."</td>";
		//epcl + nlng load reading for each hour
		$epcl_nlng=$this->get_total_ecl_nlng_load(["date"=>$input['date'],"hour"=>$hour]);
		$total_epcl_nlng+=$epcl_nlng;
		$data.="<td>".$epcl_nlng."</td>";
		$data.="<td>".(isset($load_analysis)?$load_analysis->myto_allocaton_a:0)."</td>";
		//portharcourt and bayelsa sum load reading
		$sum_ph_bayelsa=$this->get_sum_ph_bayelsa_load_daily(["date"=>$input['date'],"hour"=>$hour]);
		$total_sum_ph_bayelsa+=$sum_ph_bayelsa->sum;
		$data.='<td>'.$sum_ph_bayelsa->sum.'</td>';
		$data.='<td>'.(isset($load_analysis)?$load_analysis->consumption_embeded:0).'</td>';
		
		$cons_itu=$this->get_sum_transmission_load_daily(["date"=>$input['date'],"hour"=>$hour]);
		if (isset($cons_itu)) {
			$cons_itu_cal=$cons_itu->sum;
			$total_cons_itu_cal+=$cons_itu->sum;
		} else {
			$cons_itu_cal=0;
			
		}
		$data.='<td>'.$cons_itu_cal.'</td>';
		
		
		if (isset($load_analysis)) {
			$actual_dispatch=$sum_ph_bayelsa->sum+$load_analysis->consumption_embeded+$cons_itu_cal;
			$total_actual_dispatch+=$actual_dispatch;
		$data.='<td style="background-color:#fcae02;color:#fff">'.$actual_dispatch.'</td>';
			$difference=$load_analysis->myto_allocaton_a-$actual_dispatch;
			$total_difference+=$difference;
		} else {
			$data.='<td style="background-color:#fcae02;color:#fff">0</td>';
			$difference=0;
		}
		
		
		$data.='<td style="background-color:#13cfd5;color:#fff">'.$difference.'</td>';
		$data.='<td>'.(isset($load_analysis)?$load_analysis->forecasted_load:0).'</td>';
			$data.="</tr>";
		}
		$data.="<tr>";
		$data.="<th class='fixed-side'>AVG TOTAL</th>";
		if ($total_myto_allocaton_mw==0 || empty(total_myto_allocaton_mw)) {
			$data.="<td class=''>0</td>";
		$data.="<td class=''>0</td>";
		$data.="<td class=''>0</td>";
		$data.="<td class=''>0</td>";
		$data.="<td class=''>0</td>";
		$data.="<td class=''>0</td>";
		$data.="<td class=''>0</td>";
		$data.="<td class=''>0</td>";
		$data.="<td class=''>0</td>";
		} else {
			$data.="<td class=''>".(round(($total_myto_allocaton_mw/$count),2))."</td>";
		$data.="<td class=''>".(round(($total_epcl_nlng/$count),2))."</td>";
		$data.="<td class=''>".(round(($total_myto_allocaton_a/$count),2))."</td>";
		$data.="<td class=''>".(round(($total_sum_ph_bayelsa/$count),2))."</td>";
		$data.="<td class=''>".(round(($total_consumption_embeded/$count),2))."</td>";
		$data.="<td class=''>".(round(($total_cons_itu_cal/$count),2))."</td>";
		$data.="<td class=''>".(round(($total_actual_dispatch/$count),2))."</td>";
		$data.="<td class=''>".(round(($total_difference/$count),2))."</td>";
		$data.="<td class=''>".(round(($total_forecasted/$count),2))."</td>";
		}
		
		

		$data.="</tr>";

		$data.="</tbody>";

		return $data;

	}

	public function grid_modelx_report($input){
		$data='<thead style="background-color:#278acd;color:white"><tr>';
		$data.='<th class="fixed-side" scope="col" style="border:1px solid #000;color:#fff">FEEDER/HOURS</th>';
		//$data.='<th>FEEDER</th>';
		$feeders=$this->get_feeders(["voltage_level"=>"33kv"]);
		foreach ($feeders as $key => $feeder) {
			$data.='<th style="font-size:12px;color:#fff">';
			$data.=$feeder->feeder_name;
			$data.='</th>';
		}
		
		$data.="<th style='color:#fff'>TOTAL</th>";
		//get states
		$states=$this->get_states();
		foreach ($states as $key => $state) {
			$data.="<th style='color:#fff'>";
			$data.=$state->name;
			$data.="</th>";
		}
		$data.='</tr></thead><tbody>';
		$total_column_reading=0;
		$total_state_load=0;
		for ($hour=0; $hour <=23 ; $hour++) { 
			$data.="<tr>";
			$data.="<th class='fixed-side'>".$this->format_hour($hour)."</th>";
			$total_row_reading=0;
			foreach ($feeders as $key => $feeder) {
			$data.='<td>';
			$reading=$this->get_hourly_daily_load_by_feeder(["date"=>$input['date'],"feeder_id"=>$feeder->id,"hour"=>$hour,"voltage_level"=>"33kv"]);
			if (isset($reading)) {
				$data.=($reading->status=="on")?$reading->load_reading:$reading->status;
				$total_row_reading+=$reading->load_reading;
				//$total_column_reading+=$reading->load_reading;
			} else {
				$data.='-';
			}
			
			$data.='</td>';
			
			
		}
		$data.='<td>'.$total_row_reading.'</td>';
		$total_row_reading=0;
		//state wise
		foreach ($states as $key => $state) {
			$data.="<td style='background-color:#fcae02;color:#fff'>";
			$state_load=$this->get_sum_state_load_daily(["date"=>$input['date'],"state_id"=>$state->id,"hour"=>$hour]);
			$data.=$state_load->sum;
			$total_state_load+=$state_load->sum;
			$data.="</td>";
		}
		
		
			$data.="</tr>";
		}

		$data.="<tr>";
		
		$data.="<th style='border:1px solid #333;background-color:#d0d0d0'>DAILY AVG</th>";
		$sum_average=0;
		foreach ($feeders as $key => $feeder) {
			$data.='<td >';
			$avg=$this->get_daily_avg_by_feeder(["feeder_id"=>$feeder->id,"date"=>$input["date"]]);
			$average=$avg->avg;
			$sum_average+=$average;
			$data.=round($avg->avg,2);
			$data.='</td>';
		}
		$data.="<td>".round($sum_average,2)."</td>";
		
		//get daily avg for state
		foreach ($states as $key => $state) {
			$data.="<td style='background-color:#fcae02;color:#fff'>";
			$state_load=$this->get_avg_state_load_daily(["date"=>$input['date'],"state_id"=>$state->id]);
			$data.=round($state_load->avg,2);
			//$total_state_load+=$state_load->sum;
			$data.="</td>";
		}

		$data.="</tr>";	
		$data.="<tr>";
		$data.="<th style='border:1px solid #333;background-color:#d0d0d0'>FORCED DUR.</th>";
		$sum_duration=0;
		foreach ($feeders as $key => $feeder) {
			$data.='<td >';
			$duration=$this->get_daily_forced_duration(["feeder_id"=>$feeder->id,"date"=>$input["date"]]);
			$forced_duration=$duration->count;
			$data.=$duration->count;
			$sum_duration+=$forced_duration;
			$data.='</td>';
		}
		$data.="<td>".$sum_duration."</td>";
		$data.="</tr>";	
		$data.="<tr>";
		$data.="<th style='border:1px solid #333;background-color:#d0d0d0'>FORCED ENG LOST</th>";
		$foced_lost=0;
		foreach ($feeders as $key => $feeder) {
			$data.='<td >';
			$duration=$this->get_daily_forced_duration(["feeder_id"=>$feeder->id,"date"=>$input["date"]]);
			$forced_duration=$duration->count;
			$avg=$this->get_daily_avg_by_feeder(["feeder_id"=>$feeder->id,"date"=>$input["date"]]);
			$average=$avg->avg;
			$mult=$average*$forced_duration;
			$data.=round($average*$forced_duration,2);
			$foced_lost+=$mult;
			$data.='</td>';
		}
		$data.="<td>".round($foced_lost,2)."</td>";

		$data.="</tr>";	
		$data.="<tr>";
		$data.="<th style='border:1px solid #333;background-color:#d0d0d0'>TRX FAULT DUR</th>";
		$sum_duration_tx=0;
		foreach ($feeders as $key => $feeder) {
			$data.='<td >';
			$duration=$this->get_daily_tx_duration(["feeder_id"=>$feeder->id,"date"=>$input["date"]]);
			$forced_duration=$duration->count;
			$data.=$duration->count;
			$sum_duration_tx+=$forced_duration;
			$data.='</td>';
		}
		$data.="<td>".$sum_duration_tx."</td>";
		$data.="</tr>";	
		$data.="<tr>";
		$data.="<th style='border:1px solid #333;background-color:#d0d0d0'>TRX FAULT ENG LOST</th>";
		$foced_lost_tx=0;
		foreach ($feeders as $key => $feeder) {
			$data.='<td >';
			$duration=$this->get_daily_tx_duration(["feeder_id"=>$feeder->id,"date"=>$input["date"]]);
			$forced_duration_tx=$duration->count;
			if ($forced_duration_tx==24) {
				$average_load_month=$this->get_monthly_avg_by_feeder(["feeder_id"=>$feeder->id,"date"=>$input["date"]]);
				$load_loss_tx=$average_load_month->avg*$forced_duration_tx;
			} else {
				$avg=$this->get_daily_avg_by_feeder(["feeder_id"=>$feeder->id,"date"=>$input["date"]]);
			$average=$avg->avg;
			$load_loss_tx=$average*$forced_duration_tx;
			}
			
			
			$data.=round($load_loss_tx,2);
			$foced_lost_tx+=$load_loss_tx;
			$data.='</td>';
		}
		$data.="<td>".round($foced_lost_tx,2)."</td>";
		$data.="</tr>";
		$total_column_reading=0;
		$data.="</tbody>";

		return $data;

	}

	//get latest reading for load analysis entry by transformer id
	public function get_last_reading($data){
		if ($data['isFeeder']) {
			$this->db->where(array('feeder_id'=>$data['feeder_id']));
		}else{
			$this->db->where(array('transformer_id'=>$data['station_id'],"voltage_level"=>$data['voltage_level']));
		}
		
		$this->db->order_by('ID','DESC');
	
			return $this->db->get("load_analysis")->row();
		
	}

	public function store($data){
		
			$prev=date('Y-m-d',strtotime("-1 days"));
		$this->db->select('myto_allocaton_mw');
		$this->db->where('captured_at',$prev);
		$prev_record=$this->db->get("load_analysis")->result();
		//check if reading is completed the previous date
		if ($prev_record>0 && count($prev_record)<24) {
			//return ['status'=>false,"data"=>"You must complete the reading of previous day"];
		}
		


			
			$count_myto_allocaton_a=count($data['myto_allocaton_a']);
			
		for ($i=0; $i <$count_myto_allocaton_a ; $i++) { 
			//$reading=$data['readings'][$i];
			//return ['status'=>false,"data"=>$i];
			$myto_allocaton_a=$data['myto_allocaton_a'][$i];
			
			
			if(empty($data['captured_date'])){
				return ['status'=>false,"data"=>"Captured date must be selected"];
			}
			if(empty($data['voltage_level'])){
				return ['status'=>false,"data"=>"Please Select Transformer"];
			}
			$myto_allocaton_mw=$data['myto_allocaton_mw'][$i];
			$consumption_embeded=$data['consumption_embeded'][$i];
			$hour=$data['hour'][$i];
			//$hour=$data['hour'][$i];
			
				
				//if current value is entered then continue
				 //return ['status'=>false,"data"=>$current];
			if ($consumption_embeded != "0.00" && $consumption_embeded!="" ) {
				 $this->db->where(array('feeder_id'=>$data['feeder'],'hour'=>$hour,'captured_at'=>$data['captured_date'],'voltage_level'=>$data['voltage_level']));
			$q=$this->db->get("load_analysis");

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
		for ($i=0; $i <$count_myto_allocaton_a ; $i++) { 
			
			//$feeder=$data['feeders'][$i];
			$myto_allocaton_a=$data['myto_allocaton_a'][$i];
			$hour=$data['hour'][$i];
			$myto_allocaton_mw=$data['myto_allocaton_mw'][$i];
			$consumption_embeded=$data['consumption_embeded'][$i];
			$forecasted_load=$data['forecasted_load'][$i];
			
				if ($consumption_embeded != "0.00" && $consumption_embeded!="" ) {
					
				$result=$this->db->insert("load_analysis",array('voltage_level'=>$data['voltage_level'],'station_id'=>$data['station_id'],'feeder_id'=>$data['feeder'],'myto_allocaton_a'=>$myto_allocaton_a,'myto_allocaton_mw'=>$myto_allocaton_mw,'consumption_embeded'=>$consumption_embeded,'forecasted_load'=>$forecasted_load,'created_by'=>$data['created_by'],'hour'=>$hour,'captured_at'=>$data['captured_date'],"transformer_id"=>$data['transformer']));

				}			

		}

		if ($result) {
			return [
					'status'=>true,
					'data'=>"Reading Stored Successfully."
				];
		} else {
			return [
					'status'=>false,
					'data'=>$this->db->error
				];
		}
	
		
	}


}