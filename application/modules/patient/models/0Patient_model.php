<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Patient_model extends CI_model {



    function __construct() {

        parent::__construct();

        $this->load->database();

    }

  function insertTreatment($data) {
        $this->db->insert('treatment_notes', $data);
    }

    function insertPic($data) {
        $this->db->insert('treatment_pic', $data);
    }
  function getTreatment_notes($patient_id) {
        $this->db->where('patient_id', $patient_id);
        $query = $this->db->get('treatment_notes');
        return $query->result();
    }
  function deleteTreatment($id) {
        $this->db->where('id', $id);
        $this->db->delete('treatment_notes');
    }


    function insertPatient($data) {

        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));

        $data2 = array_merge($data, $data1);

        $this->db->insert('patient', $data2);

    }

    function getmedicalHistorySetups() {


        $query = $this->db->get('medical_history_setups');

        return $query->result();

    }

    function updatePatientmedicaleHistory(  $data, $id) {
        $this->db->where('id', $id);

        $this->db->update('patient', $data);

    }

    function getPatient() {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->order_by('id', 'desc');

        $query = $this->db->get('patient');

        return $query->result();

    }



    function getLimit() {

        $current = $this->db->get_where('patient', array('hospital_id' => $this->session->userdata('hospital_id')))->num_rows();

        $limit = $this->db->get_where('hospital', array('id' => $this->session->userdata('hospital_id')))->row()->p_limit;

        if (!is_numeric($limit)) {

            $limit = 0;

        }

        return $limit - $current;

    }



    function getPatientBySearch($search) {

        $this->db->order_by('id', 'desc');

        $query = $this->db->select('*')

                ->from('patient')

                ->where('hospital_id', $this->session->userdata('hospital_id'))

                ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%')", NULL, FALSE)

                ->get();

        ;

        return $query->result();

    }



    function getPatientByLimit($limit, $start) {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);

        $query = $this->db->get('patient');

        return $query->result();

    }



    function getPatientByLimitBySearch($limit, $start, $search) {

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);

        $query = $this->db->select('*')

                ->from('patient')

                ->where('hospital_id', $this->session->userdata('hospital_id'))

                ->where("(id LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR address LIKE '%" . $search . "%')", NULL, FALSE)

                ->get();

        ;

        return $query->result();

    }



    function getPatientById($id) {

        // $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->where('id', $id);

        $query = $this->db->get('patient');

        return $query->row();

    }



    function getPatientByIonUserId($id) {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->where('ion_user_id', $id);

        $query = $this->db->get('patient');

        return $query->row();

    }



    function getPatientByEmail($email) {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->where('email', $email);

        $query = $this->db->get('patient');

        return $query->row();

    }



    function updatePatient($id, $data) {

        $this->db->where('id', $id);

        $this->db->update('patient', $data);

    }



    function delete($id) {

        $this->db->where('id', $id);

        $this->db->delete('patient');

    }



    function insertMedicalHistory($data) {

        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));

        $data2 = array_merge($data, $data1);

        $this->db->insert('medical_history', $data2);

    }



    function getMedicalHistoryByPatientId($id) {

        // $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->where('patient_id', $id);

        $query = $this->db->get('medical_history');

        return $query->result();

    }



    function getMedicalHistory() {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->order_by('id', 'desc');

        $query = $this->db->get('medical_history');

        return $query->result();

    }



    function getMedicalHistoryBySearch($search) {

        $this->db->order_by('id', 'desc');

        $query = $this->db->select('*')

                ->from('medical_history')

                ->where('hospital_id', $this->session->userdata('hospital_id'))

                ->where("(id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%')", NULL, FALSE)

                ->get();

        ;

        return $query->result();

    }



    function getMedicalHistoryByLimit($limit, $start) {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);

        $query = $this->db->get('medical_history');

        return $query->result();

    }



    function getMedicalHistoryByLimitBySearch($limit, $start, $search) {

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);

        $query = $this->db->select('*')

                ->from('medical_history')

                ->where('hospital_id', $this->session->userdata('hospital_id'))

                ->where("(id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%')", NULL, FALSE)

                ->get();

        ;

        return $query->result();

    }



    function getMedicalHistoryById($id) {

        $this->db->where('id', $id);

        $query = $this->db->get('medical_history');

        return $query->row();

    }



    function updateMedicalHistory($id, $data) {

        $this->db->where('id', $id);

        $this->db->update('medical_history', $data);

    }



    function insertDiagnosticReport($data) {

        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));

        $data2 = array_merge($data, $data1);

        $this->db->insert('diagnostic_report', $data2);

    }



    function updateDiagnosticReport($id, $data) {

        $this->db->where('id', $id);

        $this->db->update('diagnostic_report', $data);

    }



    function getDiagnosticReport() {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->order_by('id', 'desc');

        $query = $this->db->get('diagnostic_report');

        return $query->result();

    }



    function getDiagnosticReportById($id) {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->where('id', $id);

        $query = $this->db->get('diagnostic_report');

        return $query->row();

    }



    function getDiagnosticReportByInvoiceId($id) {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->where('invoice', $id);

        $query = $this->db->get('diagnostic_report');

        return $query->row();

    }



    function getDiagnosticReportByPatientId($id) {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->where('patient', $id);

        $query = $this->db->get('diagnostic_report');

        return $query->result();

    }



    function insertPatientMaterial($data) {

        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));

        $data2 = array_merge($data, $data1);

        $this->db->insert('patient_material', $data2);

    }



    function getPatientMaterial() {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->order_by('id', 'desc');

        $query = $this->db->get('patient_material');

        return $query->result();

    }



    function getDocumentBySearch($search) {       

        $this->db->order_by('id', 'desc');

        $query = $this->db->select('*')

                ->from('patient_material')

                ->where('hospital_id', $this->session->userdata('hospital_id'))

                ->where("(id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%' OR title LIKE '%" . $search . "%' OR datestring LIKE '%" . $search . "%')", NULL, FALSE)

                ->get();

        ;

        return $query->result();            

    }



    function getDocumentByLimit($limit, $start) {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);

        $query = $this->db->get('patient_material');

        return $query->result();

    }



    function getDocumentByLimitBySearch($limit, $start, $search) {               

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);

        $query = $this->db->select('*')

                ->from('patient_material')

                ->where('hospital_id', $this->session->userdata('hospital_id'))

                ->where("(id LIKE '%" . $search . "%' OR patient_name LIKE '%" . $search . "%' OR patient_phone LIKE '%" . $search . "%' OR patient_address LIKE '%" . $search . "%' OR title LIKE '%" . $search . "%' OR datestring LIKE '%" . $search . "%')", NULL, FALSE)

                ->get();

        ;

        return $query->result();       

    }



    function getPatientMaterialById($id) {

        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->where('id', $id);

        $query = $this->db->get('patient_material');

        return $query->row();

    }



    function getPatientMaterialByPatientId($id) {

        // $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

        $this->db->where('patient', $id);

        $query = $this->db->get('patient_material');

        return $query->result();

    }



    function deletePatientMaterial($id) {

        $this->db->where('id', $id);

        $this->db->delete('patient_material');

    }



    function deleteMedicalHistory($id) {

        $this->db->where('id', $id);

        $this->db->delete('medical_history');

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



    function getDueBalanceByPatientId($patient) {

        $query = $this->db->get_where('payment', array('patient' => $patient))->result();

        $deposits = $this->db->get_where('patient_deposit', array('patient' => $patient))->result();

        $balance = array();

        $deposit_balance = array();

        foreach ($query as $gross) {

            $balance[] = $gross->gross_total;

        }

        $balance = array_sum($balance);





        foreach ($deposits as $deposit) {

            $deposit_balance[] = $deposit->deposited_amount;

        }

        $deposit_balance = array_sum($deposit_balance);







        $bill_balance = $balance;



        return $due_balance = $bill_balance - $deposit_balance;

    }



    function getPatientInfo($searchTerm) {

        if (!empty($searchTerm)) {

            $this->db->select('*');

            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

            $this->db->where("name like '%" . $searchTerm . "%' OR id like '%" . $searchTerm . "%'");

            $fetched_records = $this->db->get('patient');

            $users = $fetched_records->result_array();

        } else {

            $this->db->select('*');

            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

            $this->db->limit(10);

            $fetched_records = $this->db->get('patient');

            $users = $fetched_records->result_array();

        }

        // Initialize Array with fetched data

        $data = array();

        foreach ($users as $user) {

            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' (' . lang('id') . ': ' . $user['id'] . ')');

        }

        return $data;

    }



    function getPatientinfoWithAddNewOption($searchTerm) {

        if (!empty($searchTerm)) {

            $this->db->select('*');

            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

            $this->db->where("name like '%" . $searchTerm . "%' OR id like '%" . $searchTerm . "%'");

            $fetched_records = $this->db->get('patient');

            $users = $fetched_records->result_array();

        } else {

            $this->db->select('*');

            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));

            $this->db->limit(10);

            $fetched_records = $this->db->get('patient');

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
    
    function getDoctorIdhere()
    {
        $dr_id = $this->session->userdata('user_id');
        $this->db->where('ion_user_id',$dr_id);
        $res = $this->db->get('doctor')->row_array();
        return $res['id'];
    }



}

