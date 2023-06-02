<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getSum($field, $table) {
        $this->db->select_sum($field);
        $query = $this->db->get($table);
        return $query->result();
    }

    function getPharmacyModules()
    {
        $uid = $this->ion_auth->get_user_id();
        $this->db->where('ion_user_id',$uid);
        return $this->db->get('hospital')->row()->module;
    }

    function getPharmacyModulesById()
    {
        $uid = $this->ion_auth->get_user_id();
        $this->db->where('ion_user_id',$uid);
        $pharmacy_id = $this->db->get('pharmacist')->row()->hospital_id;

        $this->db->where('id',$pharmacy_id);
        return $this->db->get('hospital')->row()->module;
    }

    function getLaboratoryModulesById()
    {
        $uid = $this->ion_auth->get_user_id();
        $this->db->where('ion_user_id',$uid);
        $pharmacy_id = $this->db->get('laboratorist')->row()->hospital_id;

        $this->db->where('id',$pharmacy_id);
        return $this->db->get('hospital')->row()->module;
    }

    function getPharmacist() {
        $this->db->where(array('hospital_id' => $this->session->userdata('hospital_id'), 'is_saleman' => 0));
        $query = $this->db->get('pharmacist');
        return $query->result();
    }

    function getSalesman()
    {
        $this->db->where(array('hospital_id' => $this->session->userdata('hospital_id'), 'is_saleman' => 1));
        if($this->session->userdata('is_hospital')==1)
        {
            $query = $this->db->get('pharmacist');
        }
        elseif($this->session->userdata('is_hospital')==2)
        {
            $query = $this->db->get('laboratorist');
        }
        return $query->result();
    }

    function assignordertoSaleman($data)
    {
        $update_data = array('status' => 'pending', 'assign_to_saleman' => $data['saleman_id'], 'saleman_cancel_id' => '');
        $this->db->where('id',$data['order_id']);
        $this->db->update('mp_orders', $update_data);
    }

    function getuserInfohere()
    {
        $uid = $this->ion_auth->get_user_id();
        $this->db->where('ion_user_id',$uid);
        return $this->db->get('pharmacist')->row();
    }

    function acceptorderBySaleman($id)
    {
        $update_data = array('status' => 'dispatched');
        $this->db->where('id',$id);
        $this->db->update('mp_orders', $update_data);
    }

    function rejectorderBySaleman($data)
    {
        // echo "<pre>";
        // print_r($data);
        // exit;
        $uid = $this->ion_auth->get_user_id();
        $update_data = array('status' => 'pending', 'assign_to_saleman' => '', 'saleman_cancel_reason' => $data['reason'], 'saleman_cancel_id' => $uid);
        $this->db->where('id',$data['order_id']);
        $this->db->update('mp_orders', $update_data);
    }

    function markascompleteOrder($data)
    {
        $uid = $this->ion_auth->get_user_id();
        $update_data = array('status' => 'completed', 'proof_of_delivery' => $data['proof_of_delivery']);
        $this->db->where('id',$data['order_id']);
        $this->db->update('mp_orders', $update_data);
    }

    function getLabTests()
    {
        return $this->db->get('lab_tests')->result();
    }

    function addNewlabtest_i($data)
    {
        $status = 'active';
        if($data['is_feature']=="")
        {
            $data['is_feature'] = 0;
        }
        $data_insert_array = array('name'=>$data['name'],'image'=>$data['lab_test_img'],'price'=>$data['price'],'description'=>$data['description'],'status'=>$status,'dateandtime' => date('d-m-Y H:i:s'), 'is_feature' => $data['is_feature'], 'sample_required' => $data['sample_required']);
        $this->db->insert('lab_tests', $data_insert_array);
    }

    function geteditLabtests($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('lab_tests')->row();
    }

    function updatelabtest_i($data)
    {
        $status = 'active';
        if($data['is_feature']=="")
        {
            $data['is_feature'] = 0;
        }
        $data_insert_array = array('name'=>$data['name'],'image'=>$data['lab_test_img'],'price'=>$data['price'],'description'=>$data['description'],'status'=>$status, 'is_feature' => $data['is_feature'], 'sample_required' => $data['sample_required']);
        $this->db->where('id', $data['id']);
        $this->db->update('lab_tests', $data_insert_array);
    }

    function deletelabtestdata($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('lab_tests');
    }

}
