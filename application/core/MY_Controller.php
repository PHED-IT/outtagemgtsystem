<?php
use Twilio\Rest\Client;

class MY_Controller extends CI_Controller {

     public function __construct() {
         parent::__construct();

         //get your data
         if (empty($this->session->userdata('USER_ID'))) {
			redirect('login');
		}
        $this->load->model('home_model');
        //$this->load->model('admin_model');
        $user=$this->admin_model->get_user($this->session->userdata('USER_ID'));
        if ($user->blocked) {
            redirect('block');
        }
         

         $global_data = array('menus'=>$this->home_model->get_menus($this->session->userdata('ROLE_ID')),'user_role'=>$user->role_name);

         //Send the data into the current view
         //http://ellislab.com/codeigniter/user-guide/libraries/loader.html
         $this->load->vars($global_data);

     }

    protected function sendSMS1($data) {
          // Your Account SID and Auth Token from twilio.com/console
            $sid = 'ACe8a45283ec88eae531456ccf5bdb6ca0';
            $token = '718ec2cefab935ab26811e85094a9ddd';
            $client = new Client($sid, $token);
            
            // Use the client to do fun stuff like send text messages!
             return $client->messages->create(
                // the number you'd like to send the message to
                $data['phone'],
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    "from" => "+12526775042",
                    // the body of the text message you'd like to send
                    'body' => $data['text']
                )
            );
    }
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
    protected function uniqueId(){
        return "NOMS".substr(hexdec(uniqid()),7,14);
    }
}

?>