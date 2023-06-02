<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hospital_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function hospitalId() {
        if (!$this->ion_auth->in_group(array('superadmin'))) {
            if ($this->ion_auth->in_group(array('admin'))) {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
                return $hospital_id;
            } else {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
                $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
                $group_name = strtolower($group_name);
                $hospital_id = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->hospital_id;
                return $hospital_id;
            }
        }
    }

    function modules() {
        if (!$this->ion_auth->in_group(array('superadmin'))) {
            if ($this->ion_auth->in_group(array('admin'))) {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $modules = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->module;
                $module = explode(',', $modules);
                return $module;
            } else {
                $current_user_id = $this->ion_auth->user()->row()->id;
                $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
                $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
                $group_name = strtolower($group_name);
                $hospital_id = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->hospital_id;
                $modules = $this->db->get_where('hospital', array('id' => $hospital_id))->row()->module;
                $module = explode(',', $modules);
                return $module;
            }
        }
    }

    function addHospitalIdToIonUser($ion_user_id, $hospital_id) {
        $hospital_ion_id = $this->db->get_where('hospital', array('id' => $hospital_id))->row()->ion_user_id;
        $uptade_ion_user = array(
            'hospital_ion_id' => $hospital_ion_id,
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }

    function insertHospital($data) {
        $this->db->insert('hospital', $data);
    }

    function getHospital() {
        $this->db->where('is_hospital',0);
        $query = $this->db->get('hospital');
        return $query->result();
    }

    function getPharmacies()
    {
        $this->db->where('is_hospital',1);
        $query = $this->db->get('hospital');
        return $query->result();
    }

    function getLaboratories()
    {
        $this->db->where('is_hospital',2);
        $query = $this->db->get('hospital');
        return $query->result();
    }

    function getHospitalById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('hospital');
        return $query->row();
    }

    function updateHospital($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('hospital', $data);
    }

    function updateHospitalByIonId($id, $data) {
        $this->db->where('ion_user_id', $id);
        $this->db->update('hospital', $data);
    }

    function activate($id, $data) {
        $this->db->where('id', $id);
        $this->db->or_where('hospital_ion_id', $id);
        $this->db->update('users', $data);
    }

    function deactivate($id, $data) {
        $this->db->where('hospital_ion_id', $id);
        $this->db->or_where('id', $id);
        $this->db->update('users', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('hospital');
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

    function getHospitalId($current_user_id) {
        $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
        $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
        $group_name = strtolower($group_name);
        $hospital_id = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->hospital_id;
        return $hospital_id;
    }

    function createAutoSmsTemplate($hospital_id) {
        $data = array();
        $data = array('0' => array(
                'name' => 'Payment successful sms to patient',
                'message' => 'Dear {name}, Your paying amount - Tk {amount} was successful. Thank You Please contact our support for further queries.',
                'type' => 'payment',
                'status' => 'Active',
            ),
            '1' => array(
                'name' => 'Appointment Confirmation sms to patient',
                'message' => 'Dear {name}, Your appointment with {doctorname} on {appoinmentdate} at {time_slot} is confirmed. For more information contact with {hospital_name} Regards',
                'type' => 'appoinment_confirmation',
                'status' => 'Active',
            ),
            '2' => array(
                'name' => 'Appointment creation sms to patient',
                'message' => 'Dear {name}, You have an appointment with {doctorname} on {appoinmentdate} at {time_slot} .Please confirm your appointment. For more information contact with {hospital_name} Regards',
                'type' => 'appoinment_creation',
                'status' => 'Active',
            ),
            '3' => array(
                'name' => 'Meeting Schedule Notification To Patient',
                'message' => 'Dear {patient_name}, You have a Live Video Meeting with {doctor_name} on {start_time}. For more information contact with {hospital_name} . Regards',
                'type' => 'meeting_creation',
                'status' => 'Active',
            ),
            '4' => array(
                'name' => 'send appoint confirmation to Doctor',
                'message' => 'Dear {name}, You are appointed as a doctor in {department} . Thank You {company}',
                'type' => 'doctor',
                'status' => 'Active',
            ),
            '5' => array(
                'name' => 'Patient Registration Confirmation',
                'message' => 'Dear {name}, You are registred to {company} as a patient to {doctor}. Regards',
                'type' => 'patient',
                'status' => 'Active',
        ));


        foreach ($data as $row) {
            $data1 = array();
            $data1 = array(
                'name' => $row['name'],
                'message' => $row['message'],
                'type' => $row['type'],
                'status' => $row['status'],
                'hospital_id' => $hospital_id
            );
            $this->db->insert('autosmstemplate', $data1);
        }
    }
    
    
    
    
    function createAutoEmailTemplate($hospital_id) {
        $data = array();
        $data = array('0' => array(
                'name' => 'Payment successful email to patient',
                'message' => 'Dear {name}, Your paying amount - Tk {amount} was successful. Thank You Please contact our support for further queries.',
                'type' => 'payment',
                'status' => 'Active',
            ),
            '1' => array(
                'name' => 'Appointment Confirmation email to patient',
                'message' => 'Dear {name}, Your appointment with {doctorname} on {appoinmentdate} at {time_slot} is confirmed. For more information contact with {hospital_name} Regards',
                'type' => 'appoinment_confirmation',
                'status' => 'Active',
            ),
            '2' => array(
                'name' => 'Appointment creation email to patient',
                'message' => 'Dear {name}, You have an appointment with {doctorname} on {appoinmentdate} at {time_slot} .Please confirm your appointment. For more information contact with {hospital_name} Regards',
                'type' => 'appoinment_creation',
                'status' => 'Active',
            ),
            '3' => array(
                'name' => 'Meeting Schedule Notification To Patient',
                'message' => 'Dear {patient_name}, You have a Live Video Meeting with {doctor_name} on {start_time}. For more information contact with {hospital_name} . Regards',
                'type' => 'meeting_creation',
                'status' => 'Active',
            ),
            '4' => array(
                'name' => 'Send Appointment confirmation to Doctor',
                'message' => 'Dear {name}, You are appointed as a doctor in {department} . Thank You {company}',
                'type' => 'doctor',
                'status' => 'Active',
            ),
            '5' => array(
                'name' => 'Patient Registration Confirmation',
                'message' => 'Dear {name}, You are registred to {company} as a patient to {doctor}. Regards',
                'type' => 'patient',
                'status' => 'Active',
        ));


        foreach ($data as $row) {
            $data1 = array();
            $data1 = array(
                'name' => $row['name'],
                'message' => $row['message'],
                'type' => $row['type'],
                'status' => $row['status'],
                'hospital_id' => $hospital_id
            );
            $this->db->insert('autoemailtemplate', $data1);
        }
    }
    
    
    
    
    
    

}
