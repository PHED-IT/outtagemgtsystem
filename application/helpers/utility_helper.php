<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(! function_exists('asset_url()')){
function asset_url(){
	return base_url().'assets/';
}
}

function day_date($dt,$month,$year){
	$start_date = "01-".$month."-".$year;
	$start_time = strtotime($start_date);

	$end_time = strtotime("+1 ".$dt, $start_time);

	for($i=$start_time; $i<$end_time; $i+=86400)
		{
		   $list[] = date('D-d', $i);
		}
		return $list;
}


?>