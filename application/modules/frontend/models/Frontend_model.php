<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertPaymentLog($payload) {
        // file_put_contents('data.txt', json_encode($payload));
        $data = array(
            'trnxid' => $payload->id ? $payload->id : '',
            'currency' => $payload->currency,
            'amount' => $payload->amount,
            'discsount_amount' => $payload->discountAmount ? $payload->discountAmount : $payload->discsount_amount,
            'disc_percent' => $payload->discPercent ? $payload->discPercent : $payload->disc_percent,
            'name' => $payload->customerName ? $payload->customerName : $payload->name,
            'phone_no' => $payload->customerPhone ? $payload->customerPhone : $payload->phone_no,
            'email' => $payload->customerEmail ? $payload->customerEmail : $payload->email,
            'address' => $payload->customerAddress ? $payload->customerAddress : $payload->address,
            'city' => $payload->customerCity ? $payload->customerCity : $payload->city,
            'customer_order_id' => $payload->customer_order_id ? $payload->customer_order_id : '',
            'card_holder_name' => $payload->card_holder_name ? $payload->card_holder_name : '',
            'card_number' => $payload->card_number ? $payload->card_number : '',
            'bank_status' => $payload->bank_status ? $payload->bank_status : '',
            'invoice_no' => $payload->invoice_no ? $payload->invoice_no : '',
            'bank_trx_id' => $payload->bank_trx_id ? $payload->bank_trx_id : '',
            'usd_amt' => $payload->usd_amt ? $payload->usd_amt : 0.0,
            'usd_rate' => $payload->usd_rate ? $payload->usd_rate : 0.0,
            'received_amount' => $payload->received_amount ? $payload->received_amount : 0.0,
            'order_id' => $payload->order_id ? $payload->order_id : 0.0,
            'payable_amount' => $payload->payable_amount ? $payload->payable_amount : 0.0,
            'sp_code' => $payload->sp_code ? $payload->sp_code : 0,
            'sp_message' => $payload->sp_message ? $payload->sp_message : '',
            'transaction_status' => $payload->transaction_status ? $payload->transaction_status : '',
            'method' => $payload->method ? $payload->method : '',
            'date_time' => $payload->date_time ? $payload->date_time : date('Y-m-d H:i:s'),
            'shippingAddress' => $payload->shippingAddress ? $payload->shippingAddress : '',
            'shippingCity' => $payload->shippingCity ? $payload->shippingCity : '',
            'shippingCountry' => $payload->shippingCountry ? $payload->shippingCountry : '',
            'receivedPersonName' => $payload->receivedPersonName ? $payload->receivedPersonName : '',
            'shippingPhoneNumber' => $payload->shippingPhoneNumber ? $payload->shippingPhoneNumber : '',
            'value1' => $payload->value1,
            'value2' => $payload->value2,
            'value3' => $payload->value3,
            'value4' => $payload->value4
        );  

        if(! $this->db->insert('payment_log', $data)){
            // print_r($this->db->error(), true);
            file_put_contents('payment_log_at_'.date('Y_m_d_H_i_s').'.txt', $this->db->error());
        }
    }
    
    function insertAppointment($data) {
        $this->db->insert('appointment', $data);
    }



    function getSettings() {
        $query = $this->db->get('website_settings');
        return $query->row();
    }

    function updateSettings($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('website_settings', $data);
    }
    function getCounries()
    {
        $this->db->group_by('country');
        return $this->db->get('countries_and_cities')->result();
    }
    function getcitiesdata($countryName)
    {
        $this->db->where("country",$countryName);
        $this->db->order_by('city_ascii');
        return $this->db->get('countries_and_cities')->result();
    }
    function getSpeciality()
    {
        return $this->db->get('specialities')->result();
    }

    function getSpecialityFirst10Rows($limit, $start)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        return $this->db->get('specialities')->result();
    }

    function getSpecialitySecond10Rows($limit, $start)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        return $this->db->get('specialities')->result();
    }

    function getSpecialityTird10Rows($limit, $start)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        return $this->db->get('specialities')->result();
    }
    
    function getSpecialityFourth10Rows($limit, $start)
    {
        $this->db->select('*');
        $this->db->limit($limit, $start);
        return $this->db->get('specialities')->result();
    }
    
    function getdoctorslist($data)
    {
        $this->db->select("doctor.*, country_currency.country as country_name, country_currency.currency_code, country_currency.symbol");
        if(empty($data['city']) and empty($data['hospital']) and empty($data['by_name']) and empty($data['country']))
        {
			// $this->db->join("hospital", "hospital.id = doctor.hospital_id");
			$this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
            $this->db->where('is_approved',1);
            return $this->db->get("doctor")->result();
        }
        else
        {
            $this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
            $city = explode(',', $data['city']);
            if(!empty($data['city']))
            {
                $this->db->like('city', $city[0]);
            }
            // if(!empty($data['speciality_input']))
            // {
            //     $this->db->like('profile', $data['speciality_input']);
            // }
            if(!empty($data['hospital']))
            {
                $this->db->like('clinic_info', $data['hospital']);
                $this->db->or_like('experience', $data['hospital']);
            }
            if(!empty($data['by_name']))
            {
                $this->db->like('name', $data['by_name']);
            }
            // if(!empty($data['country'])){
            //     $this->db->like('country', $data['country']);
            // }
            $this->db->like('is_approved', 1);
            
            return $this->db->get("doctor")->result();
        }
        
    }

    function getdoctorslistByspiciality($data)
    {
		$this->db->select("doctor.*, country_currency.country as country_name, country_currency.currency_code, country_currency.symbol, hospital.name as hospital_name");
		$this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
		$this->db->join("hospital", "hospital.id = doctor.hospital_id");
        if(!empty($data['speciality']))
        {
            $this->db->like('profile', $data['speciality']);
        }
        $this->db->like('is_approved', 1);
        return $this->db->get("doctor")->result();
    }

    function getspecialityIcon($speciality)
    {
        $this->db->where('speciality',$speciality);
        $data = $this->db->get('specialities')->row_array();
        return $data['icon'];
    }
    
    function getAvailableSlotByDoctorByDate($date, $doctor) {
        //$newDate = date("m-d-Y", strtotime($date));
        $weekday = strftime("%A", $date);
        $this->db->where('date', $date);
        $this->db->where('doctor', $doctor);
        // $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $holiday = $this->db->get('holidays')->result();

        if (empty($holiday)) {
            $this->db->where('date', $date);
            $this->db->where('doctor', $doctor);
            // $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $query = $this->db->get('appointment')->result();

            // $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('doctor', $doctor);
            $this->db->where('weekday', $weekday);
            $this->db->order_by('s_time_key', 'asc');
            $query1 = $this->db->get('time_slot')->result();

            $availabletimeSlot = array();
            $bookedTimeSlot = array();

            foreach ($query1 as $timeslot) {
                $availabletimeSlot[] = $timeslot->s_time . ' To ' . $timeslot->e_time;
            }
            foreach ($query as $bookedTime) {
                if ($bookedTime->status != 'Cancelled') {
                    $bookedTimeSlot[] = $bookedTime->time_slot;
                }
            }

            $availableSlot = array_diff($availabletimeSlot, $bookedTimeSlot);
        } else {
            $availableSlot = array();
        }

        return $availableSlot;
    }
    
    function getAvailableSlotByDoctorByDate2($doctor)
    {
        $this->db->where("doctor",$doctor);
        return $this->db->get('time_slot')->result();
    }
    
    function checkBookedslot($data)
    {
        // $date = ;
        $date = strtotime($data[0]);
        $doctor = $data[1];
        $s_time = $data[2];
        $this->db->where(array('doctor'=>$doctor,'date'=>$date,'time_slot'=>$s_time));
        $query = $this->db->get('appointment')->result();
        return count($query);
    }
    
    function getbookedslots($data)
    {
        $this->db->where('date', strtotime($data['date']));
        $this->db->where('time_slot', $data['time']);
        $this->db->where('doctor', $data['docId']);
        $query = $this->db->get('appointment')->result();
        return count($query);
    }
    
    function getpatId($pat_auth_id)
    {
        $this->db->select('id');
        $this->db->where('ion_user_id',$pat_auth_id);
        return $this->db->get('patient')->row();
    }

    function getconultation_doctors($data)
    {
        // echo "<pre>";
        // print_r($data);
        // exit();
		$this->db->select("doctor.*, country_currency.country as country_name, country_currency.currency_code, country_currency.symbol, hospital.name as hospital_name");
		if(empty($data['city']) and empty($data['hospital_id']) and empty($data['profile']) and empty($data['speciality_input']) and empty($data['by_name']) and empty($data['country']))
        {
			$this->db->join("hospital", "hospital.id = doctor.hospital_id");
			$this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
            $this->db->where(array('urgent_care_status'=>1,'is_approved'=>1));
            return $this->db->get("doctor")->result();
        }
        else
        {
			$this->db->join("hospital", "hospital.id = doctor.hospital_id");
			$this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
            $city = explode(',', $data['city']);
            if(!empty($data['city']))
            {
                $this->db->like('city', $city[0]);
            }
            if(!empty($data['speciality_input']))
            {
                $this->db->like('profile', $data['speciality_input']);
            }
            if(!empty($data['hospital_id']))
            {
                $this->db->like('hospital_id', $data['hospital_id']);
            }
            if(!empty($data['by_name']))
            {
                $this->db->like('name', $data['by_name']);
            }
            if(!empty($data['country'])){
            $this->db->like('country', $data['country']);
            }
        }
        $this->db->like('urgent_care_status',1);
        $this->db->like('is_approved',1);        
        return $this->db->get('doctor')->result();
    }

    function get_home_visit_doctors($data)
    {
		$this->db->select("doctor.*, country_currency.country as country_name, country_currency.currency_code, country_currency.symbol, hospital.name as hospital_name");
        if(empty($data['city']) and empty($data['hospital_id']) and empty($data['profile']) and empty($data['speciality_input']) and empty($data['by_name']) and empty($data['country']))
        {
			$this->db->join("hospital", "hospital.id = doctor.hospital_id");
			$this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
            $this->db->where(array('home_visit_status'=>1,'is_approved'=>1));
            return $this->db->get("doctor")->result();
        }
        else
        {
			$this->db->join("hospital", "hospital.id = doctor.hospital_id");
			$this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
            $city = explode(',', $data['city']);
            if(!empty($data['city']))
            {
                $this->db->like('city', $city[0]);
            }
            if(!empty($data['speciality_input']))
            {
                $this->db->like('profile', $data['speciality_input']);
            }
            if(!empty($data['hospital_id']))
            {
                $this->db->like('hospital_id', $data['hospital_id']);
            }
            if(!empty($data['by_name']))
            {
                $this->db->like('name', $data['by_name']);
            }
            if(!empty($data['country'])){
            $this->db->like('country', $data['country']);
            }
        }
        $this->db->like('home_visit_status',1);
        $this->db->like('is_approved',1);
        // $this->db->where('home_visit_status',1);
        return $this->db->get('doctor')->result();
    }

    function getDoctordataByid($id)
    {
		$this->db->select("doctor.*, country_currency.country as country_name, country_currency.currency_code, country_currency.symbol");
		$this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
        $this->db->where('doctor.id',$id);
        return $this->db->get('doctor')->row();
    }

    function getpatiendatabyId($patient_ion_id)
    {
        $this->db->where('ion_user_id',$patient_ion_id);
        return $this->db->get('patient')->row();
    }

    function insert_urgent_consult_booking_data($data)
    {
        if($data['appointment_for']==1)
        {
            $data['full_name'] = $data['someone_full_name'];
            $data['email'] = $data['someone_email'];
            $data['phone'] = $data['someone_phone'];
        }
        $ucrdata = array(
			'dr_id'=>$data['doct_id'], 
			'patient_id'=>$data['pateint_id'], 
			'patient_name'=>$data['full_name'], 
			'reason'=>$data['reason'], 
			'birth_date'=>str_replace('/','-',$data['date_of_birth']), 
			'email'=>$data['email'], 
			'date'=>str_replace('/','-',$data['date']), 
			'phone'=>$data['phone'], 
			'status'=>0, 
			'appointment_for'=>$data['appointment_for'], 
			'consultation_type'=>$data['consult_type'], 
			'allergy_history'=>$data['allergy_history'],
			'address'=>$data['address']
		);
        $this->db->insert('urgent_care_requests',$ucrdata);
		
		$time_slot = $this->input->post('time_slot');
		$time_slot_explode = explode('To', $time_slot);

        $s_time = trim($time_slot_explode[0]);
        $e_time = trim($time_slot_explode[1]);
		$s_time_key = $this->getArrayKey($s_time);
		
		$room_id = '';
		$live_meeting_link = '';
		// $room_id = 'hms-meeting-' . $data['phone'] . '-' . rand(10000, 1000000) . '-' . $data['hospital_id'];
		// $live_meeting_link = 'https://meet.jit.si/' . $room_id;
		
		$adata = array(
			'patient' => $data['pateint_id'],
			'patientname' => $data['full_name'],
			'doctor' => $data['doct_id'],
			'doctorname' => $data['doct_name'],
			'date' => $data['date'],
			's_time' => $s_time,
			'e_time' => $e_time,
			'time_slot' => $time_slot,
			'reason' => $data['reason'],
			'remarks' => $data['reason'],
			//'add_date' => $add_date,
			'registration_time' => time(),
			'status' => 'Initiated',
			's_time_key' => $s_time_key,
			// 'user' => $user,
			// 'request' => $request,
			'room_id' => $room_id,
			'live_meeting_link' => $live_meeting_link,
			'hospital_id' => $data['hospital_id']
		);
		
        $this->db->insert('appointment', $adata);
		$appid = $this->db->insert_id();
        return $appid ? $appid : 0;
    }

    function insert_home_visit_booking_data($data)
    {
        if($data['appointment_for']==1)
        {
            $data['full_name'] = $data['someone_full_name'];
            $data['email'] = $data['someone_email'];
            $data['phone'] = $data['someone_phone'];
        }
        $data = array('dr_id'=>@$data['doct_id'], 'patient_id'=>$data['pateint_id'], 'patient_name'=>$data['full_name'], 'reason'=>$data['reason'], 'birth_date'=>date('M d, Y',strtotime(str_replace('/','-',$data['date_of_birth']))), 'email'=>$data['email'], 'date'=>date('d-m-Y',strtotime(str_replace('/','-',$data['date']))), 'phone'=>$data['phone'], 'status'=>0, 'preffered_time'=>$data['preffered_time'], 'hospital_id' => $data['hospital_id'], 'appointment_for'=>$data['appointment_for'], 'allergy_history'=>$data['allergy_history'],'address'=>$data['address'], 'pay_type'=>$data['radio']);
        $this->db->insert('home_visits',$data);
        return $this->db->insert_id();
    }
    
    function get_homve_invoice($id){
		$this->db->select("home_visits.*, home_visits.created_at as add_date, doctor.name as doctor_name, doctor.city as doctor_city, doctor.country as doctor_country, doctor.phone as doctor_phone, doctor.email as doctor_email, doctor.home_fee as amount, patient.name as patient_name, patient.address as patient_address, patient.phone as patient_phone, patient.email as patient_email, patient.sex as patient_gender");
		$this->db->join("doctor", "home_visits.dr_id = doctor.id");
		$this->db->join("patient", "home_visits.patient_id = patient.id");
		$this->db->where('home_visits.id', $id);
		return $this->db->get("home_visits")->result_array();
	}
	
	function get_app_invoice($id){
		$this->db->select("appointment.*, doctor.pricing as amount, doctor.name as doctor_name, doctor.city as doctor_city, doctor.country as doctor_country, doctor.phone as doctor_phone, doctor.email as doctor_email, patient.name as patient_name, patient.address as patient_address, patient.phone as patient_phone, patient.email as patient_email, patient.sex as patient_gender, card_transaction.last4");
		$this->db->join("doctor", "appointment.doctor = doctor.id");
		$this->db->join("patient", "appointment.patient = patient.id");
		$this->db->join("card_transaction", "appointment.card_tab_id = card_transaction.id", "left");
		$this->db->where('appointment.id', $id);
		return $this->db->get("appointment")->result_array();
	}

    function update_appointment($data){
        // file_put_contents('log/transaction_at_'.date('Y_m_d_H_i_s').'.txt', json_encode($data));
        if(! $this->db->insert('transaction', array(
            "method"=> 'by_shurjopay_'.$data->method,
            "order_type"=> 'appointment',
            "order_no"=> $data->value1,
            "user_from"=> $data->value2, // patient id
            "user_to"=> $data->value3, // doctor id
            "amount"=> $data->amount,
            "currency"=> $data->currency,
            "status"=> 1
        ))){
            file_put_contents('log/transaction_at_'.date('Y_m_d_H_i_s').'.txt', $this->db->error());
        }
        $ttid = $this->db->insert_id();
        if(! $this->db->insert('card_transaction', array(
            "method"=> 'shurjopay',
            "trans_id"=> $ttid,
            "amount"=> $data->amount,
            "product_id"=> $data->value3, // doctor id
            "product_name"=> '',
            "name"=> $data->name,
            "email"=> $data->email,
            "currency"=> $data->currency,
            "transaction_id"=> $data->order_id,
            "last4"=> $data->card_number ? $data->card_number : '',
            "token_id"=> $data->token_id ? $data->token_id : '',
            "customer_id"=> $data->customer_id ? $data->customer_id : $data->value2
        ))){
            file_put_contents('log/card_transaction_at_'.date('Y_m_d_H_i_s').'.txt', $this->db->error());
        }
        $ctid = $this->db->insert_id();
        if(! $this->db->where("id", $data->value1)->update('appointment', array(
            "trans_id"=> $ttid,
            "transaction_id"=> $data->order_id,
            "card_tab_id"=> $ctid,
            "status"=> "Requested"
            )
        )){
            file_put_contents('log/appointment_update_at_'.date('Y_m_d_H_i_s').'.txt', $this->db->error());
        }
    }
	
	// get all subcategory based on category 
	function getCategoryLists($cat)
    {
        $this->db->like('category', $cat);
        return $this->db->get('category_list')->result();
    }

    function getproductsByproductname($product)
    {
        $this->db->select('id, name, subcategory, vendor, price, image');
        $this->db->like('name', $product);
        $this->db->limit('50');
        return $this->db->get('medicine_another')->result();
    }
	
    // get filter wise  pharmacy product
	function getfilteredDataByAllLogic($data)
	{
		$q = "SELECT * FROM medicine_another WHERE cat_id = '".$data["category"][0]."'";
		if(count($data["type"]) > 0){
			$q .= " AND (";
			for($i=0; $i<count($data["type"]); $i++){
				if($i > 0)
					$q .= " OR";
				$q .= " product_type LIKE '%". $data["type"][$i] ."%'";
			}
			$q .= ")";
		}
		
		if(count($data["brand"]) > 0){
			$q .= " AND (";
			for($i=0; $i<count($data["brand"]); $i++){
				if($i > 0)
					$q .= " OR";
				$q .= " vendor LIKE '%". $data["brand"][$i] ."%'";
			}
			$q .= ")";
		}
		
		return $this->db->query($q)->result_array();
	}

    function getAllproductsByproductname($product)
    {
        $this->db->select('*');
        if($product=="")
        {
            $this->db->limit(100);
        }
        $this->db->like('name', $product);
        // $this->db->limit('50');
        return $this->db->get('medicine_another')->result();
    }

    function getAllproductsByproductcond($product)
    {
        $this->db->select('*');
        $this->db->where('subcategory', $product);
        $this->db->group_by('name');
        // $this->db->order_by('id', 'DESC');
        // $this->db->limit('50');
        return $this->db->get('medicine_another')->result();
    }

    function getAllproductsByproductbrands($product)
    {
        $this->db->select('*');
        $this->db->like('vendor', $product);
        // $this->db->limit('50');
        return $this->db->get('medicine_another')->result();
    }

    function getproductHistory($p_id)
    {
        $this->db->select('*');
        $this->db->where('id',$p_id);
        return $this->db->get('medicine_another')->row();
    }

    function getalldatabyletter($letter)
    {
        $query = $this->db->query("SELECT category_name FROM mp_category WHERE LEFT(category_name, 1)='".$letter."' and parent_id !=0 GROUP BY category_name");
        return $query->result();
    }

    function getalllabTestsdatabyletter($letter)
    {
        $query = $this->db->query("SELECT * FROM lab_tests WHERE LEFT(name, 1)='".$letter."' GROUP BY name");
        return $query->result();
    }

    function getallbrandsdatabyletter($letter)
    {
        $query = $this->db->query("SELECT vendor FROM medicine_another WHERE LEFT(vendor, 1)='".$letter."' GROUP BY vendor");
        return $query->result();
    }

    function getproductcountbycondition($condition)
    {
        $this->db->select('*');
        $this->db->where('subcategory',$condition);
        return $this->db->get('medicine_another')->num_rows();
    }

    function getproductcountbybrands($brand)
    {
        $this->db->select('*');
        $this->db->where('vendor',$brand);
        return $this->db->get('medicine_another')->num_rows();
    }

    function getallcategoriesByname($category)
    {
        // echo $category; exit;
        $this->db->select('*');
        $this->db->where(array('status'=>1,'parent_id'=>$category));
        // $this->db->group_by('category_name');
        // $this->db->limit('50');
        return $this->db->get('mp_category')->result();
    }

    function getallcategorieshere()
    {
        $this->db->select('*');
        $this->db->where(array('status'=>1));
        $this->db->group_by('category_name');
        return $this->db->get('mp_category')->result();
    }

    function getallbrandshere()
    {
        $this->db->select('*');
        $this->db->group_by('vendor');
        return $this->db->get('medicine_another')->result();
    }

    function getalltypeshere()
    {
        $this->db->select('*');
        $this->db->group_by('product_type');
        return $this->db->get('medicine_another')->result();
    }

    function getAllproductsByfilter($data)
    {
        if(isset($data['category']))
        {
            $this->db->like('subcategory', $data['category']);
        }
        if(isset($data['brand']))
        {
            $this->db->like('vendor', $data['brand']);
        }
        if(isset($data['type']))
        {
            $this->db->like('product_type', $data['type']);
        }
        return $this->db->get('medicine_another')->result();

    }

    function getmedicinesdetails($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('medicine_another')->row();
    }

    function getpresmedicinesdetails($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('prescription_cookies')->row();
    }

    function fetch_medicines_forcart($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('medicine_another')->row();
    }

    function insertOrders($data)
    {
        $product_id_and_quantity = $data['product_id_and_quantity'];
        $prescription_ids = $data['prescriptions_ids'];
        $d_arr = array();
        $data_pres_arr = array();
        if(!empty($product_id_and_quantity))
        {
            for($i=0; $i<count($product_id_and_quantity); $i++)
            {
                $product_id_and_quantity_h = explode(',',$product_id_and_quantity[$i]);
                if($product_id_and_quantity_h[0] !=""){
                array_push($d_arr,array('id'=>$product_id_and_quantity_h[0],'quantity'=>$product_id_and_quantity_h[1]));  
                }          
            }
        }
        if(!empty($prescription_ids))
        {
            for($i=0; $i<count($prescription_ids); $i++)
            {
                $this->db->where('id',$prescription_ids[$i]);
                $result_img = $this->db->get('prescription_cookies')->row();
                $prescription_img = $result_img->img_url;
                // $product_id_and_quantity_h = explode(',',$product_id_and_quantity[$i]);
                if($prescription_img!=""){
                array_push($data_pres_arr,array('presc_img'=>$prescription_img));   
                }         
            }
        }
        // echo "<pre>";
        // print_r($d_arr);
        // exit;
        $order_id = $data['order_id'];
        // echo $order_id; exit();
        $d_arr = json_encode($d_arr);
        $data_pres_arr = json_encode($data_pres_arr);
        $data_arr = array('cus_id'=>$data['patient_id'],'name'=>$data['name'],'phone'=>$data['phone'],'email'=>$data['email'],'amount'=>$data['amount'],'status'=>'pending','shippinaddress'=>$data['address'],'prescription_image'=>$data_pres_arr,'non_prescription_order'=>$d_arr,'notes'=>$data['notes'],'pay_type'=>$data['radio'],'order_id'=>$order_id,'transaction_id'=>$data['transaction_id']); 
        $this->db->insert('mp_orders',$data_arr);
        return $order_id; //$this->db->insert_id();
    }

    function insertprescriptiondata($img_url)
    {
        $data = array('img_url'=>$img_url);
        $this->db->insert('prescription_cookies',$data);
        return $this->db->insert_id();
    }

    function deleteprescription()
    {
        $presc_ids = $_COOKIE['presc_ids'];
        $presc_ids_here = explode(',', $presc_ids);
        for($i=0; $i<count($presc_ids_here); $i++)
        {
            $this->db->where('id',$presc_ids_here[$i]);
            $this->db->delete('prescription_cookies');
        }
        
    }

    function get15categorieshere()
    {
        $this->db->group_by('category_name');
        $this->db->where(array('status'=>1,'is_feature'=>1));
        return $this->db->get('mp_category')->result();
    }
	
	function getAllTags()
    {
        $this->db->select('tag_lists');
		$all = $this->db->get('posts')->result();
		$tags = array();
		if(count($all) > 0){
			foreach($all as $row){
				$a = explode(",", $row->tag_lists);
				for($i=0; $i<count($a); $i++){
					if($a[$i] != "" && array_search($a[$i], $tags) === false){
						array_push($tags, $a[$i]);
					}
				}
			}
		}
		return $tags;
    }
	
	function getAllBlogsCategory()
    {
        // SELECT blog_category.*, (SELECT COUNT(posts.id) FROM posts WHERE posts.category_id = blog_category.id GROUP BY posts.category_id) as total FROM `blog_category`
		$this->db->select('blog_category.*, (SELECT COUNT(posts.id) FROM posts WHERE posts.category_id = blog_category.id AND posts.is_approved = 1 AND posts.status = 1 GROUP BY posts.category_id) as category_id');
		$this->db->where('is_active', '1');
        return $this->db->get('blog_category')->result();
    }
    
    function getAllactivePosts($cat='', $tag='')
    {
		$this->db->select('posts.*, blog_category.title as blog_category_title, doctor.name as doctor_name, doctor.img_url as doctor_img');
		$this->db->join('blog_category', 'blog_category.id = posts.category_id');
		$this->db->join('doctor', 'doctor.id = posts.doc_id');
		if($cat != ''){
			$this->db->where('posts.category_id', $cat);
		}
		$this->db->where(array('posts.status'=>1,'posts.is_approved'=>1));
        if($tag != ''){
			$this->db->like('posts.tag_lists', $tag, 'both', false);
		}
		$this->db->limit(4);
        return $this->db->get('posts')->result();
		// echo $this->db->last_query(); exit();
    }
    
    function getpostdetails($url)
    {
        $this->db->where('page_url',$url);
        return $this->db->get('posts')->row();
    }
    
    function getrecentposts()
    {
        $this->db->where(array('status'=>1,'is_approved'=>1));
        $this->db->limit(5);
        $this->db->order_by('id','DESC');
        return $this->db->get('posts')->result();
    }

    function getlabtestdetailsdata($data)
    {
        $this->db->where('id',$data['id']);
        return $this->db->get('lab_tests')->row()->description;
    }
    
    // sypmtom checker code

    function getsypmtomchekerdata()
    {
        $this->db->like('type','Adult');
        $this->db->group_by('symptoms');
        return $this->db->get('symptoms_list')->result();
    }

    function getsymptomQuestionsByName($symptom_name)
    {
        $this->db->where('symptoms',$symptom_name);
        return $this->db->get('symptom_checker_data')->result();
    }

    function getsymptomAnswersByName($question_id)
    {
        $this->db->where('id',$question_id);
        return $this->db->get('symptom_checker_data')->row();
    }

    function getsymptomsbyType($type)
    {
        $this->db->like('type',$type);
        return $this->db->get('symptoms_list')->result();
    }

    function getallParentcategories()
    {
        $this->db->where(array('status'=>1, 'parent_id'=>0));
        return $this->db->get('mp_category')->result();
    }

    function getlabtestsforfrontend()
    {
        $this->db->where(array('status'=>'active', 'is_feature'=>1));
        return $this->db->get('lab_tests')->result();
    }

    function getlabtestsforfrontendByname($data)
    {
        $this->db->like('name', $data['lab_test_name']);
        $this->db->where('status', 'active');
        return $this->db->get('lab_tests')->result();
    }

    // sypmtom checker end here
	
	
	function addReview($post)
	{
		if($post["order_no"] > 0)
			$this->db->where("id", $post["order_no"])->update("appointment", array("review"=>$post["rating"]));
		
		$data = array(
			"product_id"=> $post["doctor_id"],
			"product_type"=> $post["type"],
			"order_no"=> $post["order_no"],
			"ratings"=> $post["rating"],
			"user_id"=> $post["user_id"],
			"comment"=> @$post["review_desc"],
		);
		if(! $this->db->insert("review", $data)){
			// print_r($this->db->error(), true);
			return 0;
		}
		return $this->db->insert_id();
	}
	
	function getDoctorReview($id)
	{
		$this->db->select("review.*, patient.name as patient_name, patient.img_url as img");
		$this->db->join("patient", "patient.ion_user_id = review.user_id");
		$this->db->where('review.product_id', $id);
		$this->db->where('review.product_type', 'Doctor');
        return $this->db->get('review')->result();
	}
	
	function countDoctorRating($id=false)
	{
		// SELECT COUNT(id) as total, AVG(ratings) as rating FROM `review` WHERE product_type = 'Doctor' GROUP BY product_id
		$this->db->select("COUNT(id) as total, AVG(ratings) as avg_rating, review.*");
		$this->db->where('review.product_type', 'Doctor');
		$this->db->group_by('product_id');
		if($id !== false)
			$this->db->where('product_id', $id);
		
		return $this->db->get('review')->result();
	}
	
	function add_remove_favourite($dr_id, $pid)
	{
		if($this->is_favourite($dr_id, $pid) > 0){
			$this->db->where("doctor_id", $dr_id);
			$this->db->where("patient_id", $pid);
			$this->db->delete("favourites");
			return "remove from";
		}else{
			$data = array(
				"doctor_id"=>$dr_id,
				"patient_id"=>$pid
			);
			$this->db->insert("favourites", $data);
			return "add to";
		}
	}
	
	function is_favourite($dr_id, $pid)
	{
		$this->db->where("doctor_id", $dr_id);
		$this->db->where("patient_id", $pid);
		return $this->db->from("favourites")->count_all_results();
	}
	
	function getMyFavourites($pid)
	{
		$this->db->select("favourites.id as fid, doctor.*");
		$this->db->join("doctor", "doctor.id = favourites.doctor_id");
		$this->db->where("patient_id", $pid);
		return $this->db->get("favourites")->result();
	}

    function getArrayKey($s_time) {
        $all_slot = array(
            0 => '12:00 AM',
            1 => '12:05 AM',
            2 => '12:10 AM',
            3 => '12:15 AM',
            4 => '12:20 AM',
            5 => '12:25 AM',
            6 => '12:30 AM',
            7 => '12:35 AM',
            8 => '12:40 PM',
            9 => '12:45 AM',
            10 => '12:50 AM',
            11 => '12:55 AM',
            12 => '01:00 AM',
            13 => '01:05 AM',
            14 => '01:10 AM',
            15 => '01:15 AM',
            16 => '01:20 AM',
            17 => '01:25 AM',
            18 => '01:30 AM',
            19 => '01:35 AM',
            20 => '01:40 AM',
            21 => '01:45 AM',
            22 => '01:50 AM',
            23 => '01:55 AM',
            24 => '02:00 AM',
            25 => '02:05 AM',
            26 => '02:10 AM',
            27 => '02:15 AM',
            28 => '02:20 AM',
            29 => '02:25 AM',
            30 => '02:30 AM',
            31 => '02:35 AM',
            32 => '02:40 AM',
            33 => '02:45 AM',
            34 => '02:50 AM',
            35 => '02:55 AM',
            36 => '03:00 AM',
            37 => '03:05 AM',
            38 => '03:10 AM',
            39 => '03:15 AM',
            40 => '03:20 AM',
            41 => '03:25 AM',
            42 => '03:30 AM',
            43 => '03:35 AM',
            44 => '03:40 AM',
            45 => '03:45 AM',
            46 => '03:50 AM',
            47 => '03:55 AM',
            48 => '04:00 AM',
            49 => '04:05 AM',
            50 => '04:10 AM',
            51 => '04:15 AM',
            52 => '04:20 AM',
            53 => '04:25 AM',
            54 => '04:30 AM',
            55 => '04:35 AM',
            56 => '04:40 AM',
            57 => '04:45 AM',
            58 => '04:50 AM',
            59 => '04:55 AM',
            60 => '05:00 AM',
            61 => '05:05 AM',
            62 => '05:10 AM',
            63 => '05:15 AM',
            64 => '05:20 AM',
            65 => '05:25 AM',
            66 => '05:30 AM',
            67 => '05:35 AM',
            68 => '05:40 AM',
            69 => '05:45 AM',
            70 => '05:50 AM',
            71 => '05:55 AM',
            72 => '06:00 AM',
            73 => '06:05 AM',
            74 => '06:10 AM',
            75 => '06:15 AM',
            76 => '06:20 AM',
            77 => '06:25 AM',
            78 => '06:30 AM',
            79 => '06:35 AM',
            80 => '06:40 AM',
            81 => '06:45 AM',
            82 => '06:50 AM',
            83 => '06:55 AM',
            84 => '07:00 AM',
            85 => '07:05 AM',
            86 => '07:10 AM',
            87 => '07:15 AM',
            88 => '07:20 AM',
            89 => '07:25 AM',
            90 => '07:30 AM',
            91 => '07:35 AM',
            92 => '07:40 AM',
            93 => '07:45 AM',
            94 => '07:50 AM',
            95 => '07:55 AM',
            96 => '08:00 AM',
            97 => '08:05 AM',
            98 => '08:10 AM',
            99 => '08:15 AM',
            100 => '08:20 AM',
            101 => '08:25 AM',
            102 => '08:30 AM',
            103 => '08:35 AM',
            104 => '08:40 AM',
            105 => '08:45 AM',
            106 => '08:50 AM',
            107 => '08:55 AM',
            108 => '09:00 AM',
            109 => '09:05 AM',
            110 => '09:10 AM',
            111 => '09:15 AM',
            112 => '09:20 AM',
            113 => '09:25 AM',
            114 => '09:30 AM',
            115 => '09:35 AM',
            116 => '09:40 AM',
            117 => '09:45 AM',
            118 => '09:50 AM',
            119 => '09:55 AM',
            120 => '10:00 AM',
            121 => '10:05 AM',
            122 => '10:10 AM',
            123 => '10:15 AM',
            124 => '10:20 AM',
            125 => '10:25 AM',
            126 => '10:30 AM',
            127 => '10:35 AM',
            128 => '10:40 AM',
            129 => '10:45 AM',
            130 => '10:50 AM',
            131 => '10:55 AM',
            132 => '11:00 AM',
            133 => '11:05 AM',
            134 => '11:10 AM',
            135 => '11:15 AM',
            136 => '11:20 AM',
            137 => '11:25 AM',
            138 => '11:30 AM',
            139 => '11:35 AM',
            140 => '11:40 AM',
            141 => '11:45 AM',
            142 => '11:50 AM',
            143 => '11:55 AM',
            144 => '12:00 PM',
            145 => '12:05 PM',
            146 => '12:10 PM',
            147 => '12:15 PM',
            148 => '12:20 PM',
            149 => '12:25 PM',
            150 => '12:30 PM',
            151 => '12:35 PM',
            152 => '12:40 PM',
            153 => '12:45 PM',
            154 => '12:50 PM',
            155 => '12:55 PM',
            156 => '01:00 PM',
            157 => '01:05 PM',
            158 => '01:10 PM',
            159 => '01:15 PM',
            160 => '01:20 PM',
            161 => '01:25 PM',
            162 => '01:30 PM',
            163 => '01:35 PM',
            164 => '01:40 PM',
            165 => '01:45 PM',
            166 => '01:50 PM',
            167 => '01:55 PM',
            168 => '02:00 PM',
            169 => '02:05 PM',
            170 => '02:10 PM',
            171 => '02:15 PM',
            172 => '02:20 PM',
            173 => '02:25 PM',
            174 => '02:30 PM',
            175 => '02:35 PM',
            176 => '02:40 PM',
            177 => '02:45 PM',
            178 => '02:50 PM',
            179 => '02:55 PM',
            180 => '03:00 PM',
            181 => '03:05 PM',
            182 => '03:10 PM',
            183 => '03:15 PM',
            184 => '03:20 PM',
            185 => '03:25 PM',
            186 => '03:30 PM',
            187 => '03:35 PM',
            188 => '03:40 PM',
            189 => '03:45 PM',
            190 => '03:50 PM',
            191 => '03:55 PM',
            192 => '04:00 PM',
            193 => '04:05 PM',
            194 => '04:10 PM',
            195 => '04:15 PM',
            196 => '04:20 PM',
            197 => '04:25 PM',
            198 => '04:30 PM',
            199 => '04:35 PM',
            200 => '04:40 PM',
            201 => '04:45 PM',
            202 => '04:50 PM',
            203 => '04:55 PM',
            204 => '05:00 PM',
            205 => '05:05 PM',
            206 => '05:10 PM',
            207 => '05:15 PM',
            208 => '05:20 PM',
            209 => '05:25 PM',
            210 => '05:30 PM',
            211 => '05:35 PM',
            212 => '05:40 PM',
            213 => '05:45 PM',
            214 => '05:50 PM',
            215 => '05:55 PM',
            216 => '06:00 PM',
            217 => '06:05 PM',
            218 => '06:10 PM',
            219 => '06:15 PM',
            220 => '06:20 PM',
            221 => '06:25 PM',
            222 => '06:30 PM',
            223 => '06:35 PM',
            224 => '06:40 PM',
            225 => '06:45 PM',
            226 => '06:50 PM',
            227 => '06:55 PM',
            228 => '07:00 PM',
            229 => '07:05 PM',
            230 => '07:10 PM',
            231 => '07:15 PM',
            232 => '07:20 PM',
            233 => '07:25 PM',
            234 => '07:30 PM',
            235 => '07:35 PM',
            236 => '07:40 PM',
            237 => '07:45 PM',
            238 => '07:50 PM',
            239 => '07:55 PM',
            240 => '08:00 PM',
            241 => '08:05 PM',
            242 => '08:10 PM',
            243 => '08:15 PM',
            244 => '08:20 PM',
            245 => '08:25 PM',
            246 => '08:30 PM',
            247 => '08:35 PM',
            248 => '08:40 PM',
            249 => '08:45 PM',
            250 => '08:50 PM',
            251 => '08:55 PM',
            252 => '09:00 PM',
            253 => '09:05 PM',
            254 => '09:10 PM',
            255 => '09:15 PM',
            256 => '09:20 PM',
            257 => '09:25 PM',
            258 => '09:30 PM',
            259 => '09:35 PM',
            260 => '09:40 PM',
            261 => '09:45 PM',
            262 => '09:50 PM',
            263 => '09:55 PM',
            264 => '10:00 PM',
            265 => '10:05 PM',
            266 => '10:10 PM',
            267 => '10:15 PM',
            268 => '10:20 PM',
            269 => '10:25 PM',
            270 => '10:30 PM',
            271 => '10:35 PM',
            272 => '10:40 PM',
            273 => '10:45 PM',
            274 => '10:50 PM',
            275 => '10:55 PM',
            276 => '11:00 PM',
            277 => '11:05 PM',
            278 => '11:10 PM',
            279 => '11:15 PM',
            280 => '11:20 PM',
            281 => '11:25 PM',
            282 => '11:30 PM',
            283 => '11:35 PM',
            284 => '11:40 PM',
            285 => '11:45 PM',
            286 => '11:50 PM',
            287 => '11:55 PM',
        );

        $key = array_search($s_time, $all_slot);
        return $key;
    }

}
