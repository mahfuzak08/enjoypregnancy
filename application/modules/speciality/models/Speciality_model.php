<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Speciality_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertSpeciality($data) {
        // $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        // $data2 = array_merge($data, $data1);
        $this->db->insert('specialities', $data);
    }

    function getSpeciality() {
        // $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('specialities');
        return $query->result();
    }

    function getSpecialityById($id) {
        // $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('specialities');
        return $query->row();
    }

    function updateSpeciality($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('specialities', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('specialities');
    }

    // symptom checker
    function getAllsymptoms()
    {
        $this->db->order_by('symptoms','ASC');
        $query = $this->db->get('symptoms_list');
        return $query->result();
    }

    function insertSymptom($data)
    {
        $this->db->insert('symptoms_list', $data);
    }

    function updateSymptom($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('symptoms_list', $data);
    }

    function deletesymptom($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('symptoms_list');
    }

    function getSymptomById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('symptoms_list');
        return $query->row();
    }

    function getAllQuestionsAndAnswers()
    {
        $this->db->order_by('symptoms','ASC');
        $query = $this->db->get('symptom_checker_data');
        return $query->result();
    }

    function deletesymptomQuestionandAnswer($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('symptom_checker_data');
    }

    function insertquestioningAnswer($data)
    {
        $this->db->insert('symptom_checker_data', $data);
        // echo $this->db->error(); exit;
    }

    function updatequestioningAnswer($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('symptom_checker_data', $data);
    }

    function getquestionanswerData($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('symptom_checker_data')->row_array();
    }

}
