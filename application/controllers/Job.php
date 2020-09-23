<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Job extends CI_Controller
{

	    protected function sendSMS($data) {
        //var_dump($data['message']);
        $url="http://www.smslive247.com/http/index.aspx?cmd=sendmsg&sessionid=".urlencode('1289881f-ee0d-4474-8281-c643c2feb35a')."&message=".urlencode($data['message'])."&sender=NOMS&sendto=".urlencode($data['phone'])."&msgtype=0";
        //var_dump($url);
        //$header = array("Accept: application/json");
         try {
        $ch = curl_init();
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//   'APIKEY: 1289881f-ee0d-4474-8281-c643c2feb35',
//   'Content-Type: application/json',
//    ));
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);      //  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch,CURLOPT_HEADER, false); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');

        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        //var_dump(curl_getinfo($ch));
    } catch (Exception $e) {
        return $e;
    }
    // $this->log("url");
    // $this->log($url);
    // $this->log("fields");
    // $this->log($fields);
    curl_close($ch);
    if ($result)
        return $result;
    else
        return $result;
    } 
    protected function sendEmail($to,$subject,$message){
        $this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        // $to = $this->input->post('to');
        // $subject = $this->input->post('subject');
        // $message = $this->input->post('message');

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
        //$this->email->print_debugger();
    }
	
public function cronNotify(){
	$jobs=$this->job_model->getJobs();
    if ($jobs) {
        
    
	foreach ($jobs as $key => $value) {
		$this->sendEmail($value->email,"PHED NOMS NOTIFICATION",'Dear '.$value->name.', <br/>'.$value->message);
		$this->sendSMS(array("phone"=>$value->phone,"message"=>$value->message));

		$this->job_model->deleteFromJob($value->id);
	}
}


}

}