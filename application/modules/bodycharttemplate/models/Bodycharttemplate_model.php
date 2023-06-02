<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bodycharttemplate_model  extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertBodychart($data) {

        $this->db->insert('bodycharttemplate', $data);
    }

    function getBodychart() {
        $query = $this->db->get('bodycharttemplate');
        return $query->result();
    }

    function getBodychartBysearch($search) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')
            ->from('bodycharttemplate')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%'OR email LIKE '%" . $search . "%'OR department LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();
        return $query->result();
    }

    function getBodychartByLimit($limit, $start) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('bodycharttemplate');
        return $query->result();
    }

    function getBodychartByLimitBySearch($limit, $start, $search) {
        $this->db->like('id', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
            ->from('bodycharttemplate')
            ->where('hospital_id', $this->session->userdata('hospital_id'))
            ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%'OR email LIKE '%" . $search . "%'OR department LIKE '%" . $search . "%')", NULL, FALSE)
            ->get();

        return $query->result();
    }

    function getBodychartById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('bodycharttemplate');
        return $query->row();
    }
    function getBodychartTemplateById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('treatment_notes');
        return $query->row();
    }

    function getBodychartTemplatePic($id) {
        $this->db->where('treatment_id', $id);
        $query = $this->db->get('treatment_pic');
        return $query->result();
    }

    function updateBodychart($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('bodycharttemplate', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('bodycharttemplate');
    }


    function getBodychartInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $query = $this->db->select('*')
                ->from('bodycharttemplate')
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

    // end here
}
