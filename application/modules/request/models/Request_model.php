<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Request_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function requestId() {
        if (!$this->ion_auth->in_group(array('superadmin'))) {
            if ($this->ion_auth->in_group(array('admin'))) {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $request_id = $this->db->get_where('request', array('ion_user_id' => $current_user_id))->row()->id;
                return $request_id;
            } else {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
                $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
                $group_name = strtolower($group_name);
                $request_id = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->request_id;
                return $request_id;
            }
        }   
    }

    function modules() {
        if (!$this->ion_auth->in_group(array('superadmin'))) {
            if ($this->ion_auth->in_group(array('admin'))) {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $modules = $this->db->get_where('request', array('ion_user_id' => $current_user_id))->row()->module;
                $module = explode(',', $modules);
                return $module;
            } else {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
                $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
                $group_name = strtolower($group_name);
                $request_id = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->request_id;
                $modules = $this->db->get_where('request', array('id' => $request_id))->row()->module;
                $module = explode(',', $modules);
                return $module;
            }
        }
    }

    function addRequestIdToIonUser($ion_user_id, $request_id) {
        $request_ion_id = $this->db->get_where('request', array('id' => $request_id))->row()->ion_user_id;
        $uptade_ion_user = array(
            'request_ion_id' => $request_ion_id,
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }

    function insertRequest($data) {
        $this->db->insert('request', $data);
    }

    function getRequest() {
        if($this->session->userdata('is_hospital')==1)
        {
            $this->db->where('is_hospital',1);
        }
        elseif($this->session->userdata('is_hospital')==2)
        {
            $this->db->where('is_hospital',2);
        }
        else
        {
            $this->db->where('is_hospital',0);
        }
        $query = $this->db->get('request');
        return $query->result();
    }

    function getRequestById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('request');
        return $query->row();
    }

    function updateRequest($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('request', $data);
    }

    function activate($id, $data) {
        $this->db->where('id', $id);
        $this->db->or_where('request_ion_id', $id);
        $this->db->update('users', $data);
    }

    function deactivate($id, $data) {
        $this->db->where('request_ion_id', $id);
        $this->db->or_where('id', $id);
        $this->db->update('users', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('request');
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

    function getRequestId($current_user_id) {
        $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
        $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
        $group_name = strtolower($group_name);
        $request_id = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->request_id;
        return $request_id;
    }
    
    function insertHomevisitrequest($data)
    {
        $birth_date = str_replace("/"," ",$data['birth_date']);
        // echo $birth_date."<br>";
        $data['birth_date'] = date('F d, Y', strtotime($birth_date));
        $data_arr = array("dr_id"=>0,
                          "patient_id"=>$data['p_id'],
                          "patient_name"=>$data['fullname'],
                          "reason"=>$data['reason'],
                          "birth_date"=>$data['birth_date'],
                          "hospital_id"=>$data['hospital_id'],
                          "email"=>$data['email'],
                          "inserted_at"=>date('Y-m-d H:i:s'),
                          "home_address"=>$data['address'],
                          "date"=>$data['appointment_date'],
                          "phone"=>$data['phone'],
                          "status"=>"0",
                          "created_at"=>date('Y-m-d H:i:s'),
                          "updated_at"=>date('Y-m-d H:i:s'),
                          "preffered_time"=>$data['preferredtime']);
        if($this->db->insert("home_visits",$data_arr))
        {
            return 1;
        }
        else
        {
            return 0;
        }
        
    }

}
