<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patientfromtemplate_model extends CI_model
{

//patient_question_answares
//patient_template_section_question_answares
//patient_template_section_questions
//patient_template_sections
//patient_from_templates
//patient_add_forms


    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getPatientFromTemplate()
    {

        $query = $this->db->query("SELECT a.*, (SELECT COUNT(*) as total_secion  FROM patient_template_sections as s WHERE s.template_id = a.id ) as total_session, 
                 (SELECT COUNT(*) FROM patient_template_section_questions as q WHERE q.template_id = a.id ) as total_question FROM patient_from_templates as a");

        return $query->result();
    }

    function getPatientFromTemplateById($id)
    {

        $query = $this->db->query("SELECT a.*, (SELECT COUNT(*) as total_secion  FROM patient_template_sections as s WHERE s.template_id = a.id ) as total_session, 
                 (SELECT COUNT(*) FROM patient_template_section_questions as q WHERE q.section_id = a.id ) as total_question FROM patient_from_templates as a WHERE a.id = '$id'");

        return $query->row();
    }

    function getPatientForm($patient_id, $type='symptoms')
    {
        // $query = $this->db->query("SELECT f.*, (SELECT s.name FROM patient_from_templates as s WHERE f.form_id = s.id ) as template
                   // FROM patient_add_forms as f  WHERE f.patient_id = '$patient_id' AND f.type= '$type'");
		$this->db->select("f.*, s.name as template, p.name as patient_name, p.phone as phone, p.email as email");
		$this->db->join("patient_from_templates as s", "s.id = f.form_id");
		$this->db->join("patient as p", "f.patient_id = p.id");
		$this->db->where("f.patient_id", $patient_id);
		$this->db->where("f.type", $type);
		return $this->db->get("patient_add_forms as f")->result();
    }



    function deletePatientTemplateSection($id)
    {
        $this->db->where('template_id', $id);
        $this->db->delete('patient_template_sections');
    }


    function deletePatientAddFrom($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('patient_add_forms');
    }

    function deletePatientFromTemplate($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('patient_from_templates');
    }

    function updatePatientFromTemplate($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('patient_from_templates', $data);
    }


    function insertPatientForm($data) {
        $this->db->insert('patient_add_forms', $data);
    }

    function updatePatientForm($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('patient_add_forms', $data);
    }

    function insertPatientFromTemplate($data) {
        $this->db->insert('patient_from_templates', $data);
    }

    function insertPatientTemplateSection($data) {
        $this->db->insert('patient_template_sections', $data);
    }

    function insertPatientTemplateSectionQuestion($data) {
        $this->db->insert('patient_template_section_questions', $data);
    }


    function insertPatientTemplateSectionQuestionAns($data) {
        $this->db->insert('patient_template_section_question_answares', $data);
    }
        function insertTreatment($data)
    {

        $this->db->insert('treatment_notes', $data);
    }

    function insertPic($data)
    {
        $this->db->insert('treatment_pic', $data);
    }

    function getTreatment_notes()
    {
        $query = $this->db->get('treatment_notes');
        return $query->result();
    }



}
?>