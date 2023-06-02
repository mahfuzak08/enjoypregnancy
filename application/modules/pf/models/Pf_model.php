<?php
#Author Md. Hasanat Zamil  hzamil@gmail.com
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pf_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getPatientFromTemplateByToken($token)
    {
        $query = $this->db->query("SELECT s.*, f.id as fid, f.form_id, f.token, f.answared 
                   FROM patient_add_forms as f ,  patient_from_templates as s WHERE f.token = '$token' AND  f.form_id = s.id ");

        return $query->row();
    }



    function getFormSection($template_id)
    {
        $query = $this->db->query("SELECT  *  FROM patient_template_sections WHERE template_id = '$template_id' ");
        return $query->result();
    }
    function getQuizById($sectionId)
    {
        $query = $this->db->query("SELECT  *  FROM patient_template_section_questions WHERE section_id = '$sectionId' ");
        return $query->result();
    }

    function getAnswareById($quizId)
    {
        $query = $this->db->query("SELECT  *  FROM patient_template_section_question_answares WHERE question_id = '$quizId' ");
        return $query->result();
    }

    function insertPatientFormAnsware($data) {
        $this->db->insert('patient_question_answares', $data);
    }


    function getPatientAnswareById($quizId, $form_id)
    {
        $query = $this->db->query("SELECT  *  FROM patient_question_answares WHERE question_id = '$quizId' AND patient_form_id = '$form_id' ");
        return $query->row();
    }

}