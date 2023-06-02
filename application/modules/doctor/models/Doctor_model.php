<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Doctor_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertDoctor($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('doctor', $data2);
    }

    function getDoctor() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('doctor');
        return $query->result();
    }
    function getHospitals() {
        $this->db->where('is_hospital',0);
        $query = $this->db->get('hospital');
        return $query->result();
    }
    function getDoctorlogin() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('doctor');
        return $query->result();
    }

    function getLimit() {
        $current = $this->db->get_where('doctor', array('hospital_id' => $this->hospital_id))->num_rows();
        $limit = $this->db->get_where('hospital', array('id' => $this->hospital_id))->row()->d_limit;
        return $limit - $current;
    }

    function getDoctorBySearch($search) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')
                ->from('doctor')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%'OR email LIKE '%" . $search . "%'OR department LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getDoctorByLimit($limit, $start) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('doctor');
        return $query->result();
    }

    function getDoctorByLimitBySearch($limit, $start, $search) {
        $this->db->like('id', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('doctor')
                ->where('hospital_id', $this->session->userdata('hospital_id'))
                ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%'OR email LIKE '%" . $search . "%'OR department LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();

        return $query->result();
    }

    function getDoctorById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('doctor');
        return $query->row();
    }

    function getDoctorByIonUserId($id) {
        // $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
		$this->db->select('doctor.*, country_currency.country as country_name, country_currency.currency_code, country_currency.symbol');
		$this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
        $this->db->where('ion_user_id', $id);
        $query = $this->db->get('doctor');
        return $query->row();
    }

    function updateDoctor($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('doctor', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('doctor');
    }

    function updateIonUser($username, $email, $password, $ion_user_id) {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }

    function getDoctorInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $query = $this->db->select('*')
                    ->from('doctor')
                    ->where('hospital_id', $this->session->userdata('hospital_id'))
                    ->where("(id LIKE '%" . $searchTerm . "%' OR name LIKE '%" . $searchTerm . "%')", NULL, FALSE)
                    ->get();
            $users = $query->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->limit(10);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        if ($this->ion_auth->in_group(array('Doctor'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('ion_user_id', $doctor_ion_id);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' (' . lang('id') . ': ' . $user['id'] . ')');
        }
        return $data;
    }

    function getDoctorWithAddNewOption($searchTerm) {
        if (!empty($searchTerm)) {
            $query = $this->db->select('*')
                    ->from('doctor')
                    ->where('hospital_id', $this->session->userdata('hospital_id'))
                    ->where("(id LIKE '%" . $searchTerm . "%' OR name LIKE '%" . $searchTerm . "%')", NULL, FALSE)
                    ->get();
            $users = $query->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->limit(10);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        if ($this->ion_auth->in_group(array('Doctor'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $this->db->select('*');
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $this->db->where('ion_user_id', $doctor_ion_id);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }



        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' (' . lang('id') . ': ' . $user['id'] . ')');
        }
        return $data;
    }
    // Haseen code
    function getDocstatus($id)
    {
        $this->db->select('*');
        $this->db->where("id",$id);  
        return $this->db->get("users")->row_array();
    }
    
    function verifieddoctormedicalregistration($id, $state)
    {
        $data = array('medical_registration_verified'=>$state);
        $this->db->where('ion_user_id',$id);
        $this->db->update('doctor',$data);
        
        $this->db->select('email');
        $this->db->where("id",$id);  
        return $this->db->get("users")->row_array();
    }
	function approvedoctorstatus($id)
    {
        // $data = array('active'=>1);
        // $this->db->where('id',$id);
        // $this->db->update('users',$data);
        
        $data = array('is_approved'=>1);
        $this->db->where('ion_user_id',$id);
        $this->db->update('doctor',$data);
        
        $this->db->select('email');
        $this->db->where("id",$id);  
        return $this->db->get("users")->row_array();
    }
    function disapprovedoctorstatus($id)
    {
        $data = array('is_approved'=>3);
        $this->db->where('ion_user_id',$id);
        $this->db->update('doctor',$data);
    }

    function getDoctorProfiledata($dr_id)
    {
		$this->db->select('doctor.*, country_currency.country as country_name, country_currency.currency_code, country_currency.symbol');
		$this->db->join('country_currency', 'doctor.country = country_currency.country', 'left');
        $this->db->where('doctor.id',$dr_id);
        return $this->db->get('doctor')->row();
    }
    
    function getUrgentAppointments()
    {
        // $this->db->where('dr_id',$dr_id);
        return $this->db->get('urgent_care_requests')->result();
    }
    
    function getUrgentAppointmentsByDoctor($doctor)
    {
        $this->db->where('dr_id',$doctor);
        return $this->db->get('urgent_care_requests')->result();
    }
    
    function getHomeAppointments()
    {
        // $this->db->where('dr_id',$dr_id);
        return $this->db->get('home_visits')->result();
    }
    
    function getHomeAppointmentsByDoctor($doctor)
    {
		$this->db->select("home_visits.*, patient.ion_user_id as patient_ion_user_id, patient.img_url as patient_img, patient.phone as patient_phone");
		$this->db->join("patient", "home_visits.patient_id = patient.id");
        $this->db->where('dr_id',$doctor);
		$this->db->order_by("home_visits.id", "desc");
        return $this->db->get('home_visits')->result();
    }
	
	function getHomeAppointmentsByPatient($pid)
    {
		$this->db->select("home_visits.*, doctor.ion_user_id as doctor_ion_user_id, doctor.name as doctor_name, doctor.img_url as doctor_img, doctor.phone as doctor_phone");
		$this->db->join("doctor", "home_visits.dr_id = doctor.id");
        $this->db->where('patient_id', $pid);
		$this->db->order_by("home_visits.id", "desc");
        return $this->db->get('home_visits')->result();
    }
    
    function getDoctorHospitalById($hospital_id)
    {
        $this->db->where('id',$hospital_id);
        return $this->db->get('hospital')->row_array();
    }    
    // end here
	
	
	function getMyPatient($doctor) {
        $this->db->select("appointment.*, patient.ion_user_id as patient_ion_user_id, patient.name as patient_name, patient.img_url as patient_img, patient.address as patient_address, patient.email as patient_email, patient.phone as patient_phone, patient.birthdate as birthdate, patient.sex as sex, patient.bloodgroup as bloodgroup");
        $this->db->join("patient", "appointment.patient = patient.id");
        $this->db->where('appointment.doctor', $doctor);
		$this->db->group_by('appointment.patient');
        $this->db->order_by('appointment.id', 'desc');
        $query = $this->db->get('appointment');
        return $query->result();
    }
	
	function getTotalPatient($doctor, $today=false) {
		if($today === true)
			$this->db->where('appointment.date', strtotime(date('d-m-Y')));
        $this->db->where('appointment.doctor', $doctor);
		$this->db->group_by('appointment.patient');
        $query = $this->db->get('appointment');
		return $query->num_rows();
    }
}
