<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getcountryCodes() {
        $this->db->group_by('phonecode');
        $this->db->order_by('id');
        return $this->db->get('country_codes')->result();
    }
    function getdepartment()
    {
        return $this->db->get('department')->result();
    }
    function addnewpatient($data)
    {
         // $data['hospital_id']
        if($data['support_input']==1)
        {
            $arr = array('img_url'=>$data['img_url'],
            'name'=>$data['name'],
            'email'=>$data['email'],
            'address'=>$data['address'],
            'phone'=>$data['phone'],
            'department'=>'',
            'doctor_type'=>$data['doc_type'],
            'profile'=>$data['sex'],
            'x'=>'',
            'y'=>'',
            'ion_user_id'=>$data['ion_user_id'],
            'hospital_id'=>$data['hospital_id'],
            'identitydoc' => $data['identitydoc'],
            'doctor_lic_doc' => $data['doctor_lic_doc'],
            'country' => $data['country'],
            'city' => $data['city'],
            'timezone' => @$data['zone'] ? $data['zone'] : '+0000',
            'is_approved'=> 0
            );
            if($this->db->insert('doctor',$arr))
            {
                return 2;
            }
            else
            {
                return 0;
            }
        }
        else
        {
            $arr = array('img_url'=>$data['img_url'],
            'name'=>$data['name'],
            'email'=>$data['email'],
            'address'=>$data['address'],
            'phone'=>$data['phone'],
            'sex'=>$data['sex'],
            'birthdate'=>$data['birthdate'],
            'ion_user_id'=>$data['ion_user_id'],
            'patient_id'=>$data['patient_id'],
            'hospital_id'=>$data['hospital_id'],
            'add_date'=> date('m/d/y'),
            'registration_time'=> strtotime(date('H:i')),
            'account_status'=>'1',
            'identitydoc' => $data['identitydoc']
            );
            if($this->db->insert('patient',$arr))
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }
    
    function checkemail_i($email,$phone)
    {
        $condition_w = "email='$email' OR phone='$phone'";
        $query = $this->db->select('*')
		                  ->where($condition_w)
		                  ->limit(1)
		    			  ->order_by('id', 'desc')
		                  ->get('users');
		return $query->num_rows();
    } 
    function checkphone_i($email,$phone)
    {
        $query = $this->db->select('*')
		                  ->where('email',$email)
		                  ->limit(1)
		    			  ->order_by('id', 'desc')
		                  ->get('users');
		$email_num =  $query->num_rows();
		
		$query2 = $this->db->select('*')
		                  ->where('phone',$phone)
		                  ->limit(1)
		    			  ->order_by('id', 'desc')
		                  ->get('users');
		$phone_num =  $query2->num_rows();
		return [$email_num,$phone_num];
    } 

    function checkemail_api($email)
    {
        $query = $this->db->select('*')
                          ->where('email',$email)
                          ->limit(1)
                          ->order_by('id', 'desc')
                          ->get('users');
        return $email_num =  $query->num_rows();
    }

    function checkphoneIndb($phonenumber)
    {
        $query2 = $this->db->select('*')
                          ->where('phone',$phonenumber)
                          ->limit(1)
                          ->order_by('id', 'desc')
                          ->get('users');
       return $phone_num =  $query2->num_rows();
    }
    
    function getSpeciality()
    {
        return $this->db->get("specialities")->result();
    }
	
    function getCountry()
    {
		$this->db->order_by("country", "asc");
        return $this->db->get("country_currency")->result();
    }

    function verifyemailidhere($id)
    {
        $data = array('email_active'=>1);
        $this->db->where('id',$id);
        $this->db->update('users',$data);
        return TRUE;
    }

}
