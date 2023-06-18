<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  ==============================================================================
 *  Author	: Mahfuzur Rahman
 *  Email	: mahfuzak08@gmail.com
 *  Mobile SMS sending
 *  ==============================================================================
 */

class Mobilemsg {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function log($to, $msg, $logid=0) {
        if($logid == 0){
            if(! $this->CI->db->insert("smslog", array("mobile_to"=>$to, "body"=>$msg, "status"=>"sending"))){
                file_put_contents('log/mobilemsg_log_at_'.date('Y_m_d_H_i_s').'.txt', $this->CI->db->error());
                return 0;
            }
            return $this->CI->db->insert_id();
        }
        elseif($logid > 0){
            $this->CI->db->where("id", $logid);
            if(! $this->CI->db->update("smslog", array("status"=>$to, "CamID"=>$msg))){
                file_put_contents('log/mobilemsg_log_at_'.date('Y_m_d_H_i_s').'.txt', $this->CI->db->error());
                return false;
            }
            return true;
        }
    }

    public function send($to, $message) {
        $logid = $this->log($to, $message, 0);
        $post_url = 'http://portal.quickbd.net/smsapi';
        $post_values = array( 
            'api_key' => 'c5b76da3e608d34edb07244cd9b875ee8690632876f6d27dbea3b7a9375020f4e2f9a08b',
            'type' => 'text',  // unicode or text
            'senderid' => '8809612446150',
            'contacts' => $to,
            'msg' => $message,
            'method' => 'api'
        );
        
        $post_string = "";
        foreach( $post_values as $key => $value )
            { $post_string .= "$key=" . urlencode( $value ) . "&"; }
            $post_string = rtrim( $post_string, "& " );
            
            
        $request = curl_init($post_url);  
            curl_setopt($request, CURLOPT_HEADER, 0);  
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);  
            curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); 
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);  
            $post_response = curl_exec($request);  
            curl_close ($request);  
            
        $responses=array();  		
        $array =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true );   
        
        if($array){ 
            if(! $this->log($array['status'], $array['CamID'], $logid)){
                file_put_contents('log/mobilemsg_log_at_'.date('Y_m_d_H_i_s').'.txt', "Something wrong...");
            }
            return true;
        }
    }	
}
