<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('patient_model');
        $this->load->model('chat/chat_model');
        $this->load->model('frontend/frontend_model');
        $this->load->model('profile/profile_model');
        $this->load->model('bodycharttemplate/bodycharttemplate_model');
        $this->load->model('patientfromtemplate/patientfromtemplate_model');
        $this->load->model('donor/donor_model');
        $this->load->model('appointment/appointment_model');
        $this->load->model('bed/bed_model');
        $this->load->model('lab/lab_model');
        $this->load->model('finance/finance_model');
        $this->load->model('finance/pharmacy_model');
        $this->load->model('payment/payment_model');
        $this->load->model('sms/sms_model');
        $this->load->module('sms');
        $this->load->module('pf');
        $this->load->model('prescription/prescription_model');
        require APPPATH . 'third_party/stripe/stripe-php/init.php';
        $this->load->model('medicine/medicine_model');
        $this->load->model('doctor/doctor_model');
        $this->load->module('paypal');
        if (!$this->ion_auth->in_group(array('admin', 'Patient', 'Doctor'))) {
            redirect('home/permission');
        }
    }
	
	/*
	* Mahfuz start on 8-Jul-2021
	*/
	function dashboard()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		$data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient_data']->id);
		$data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($data['patient_data']->id);
        $data['labs'] = $this->lab_model->getLabByPatientId($data['patient_data']->id);
		$data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($data['patient_data']->id);
		$data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($data['patient_data']->id);
		$data['medicalHistoryLists'] = $this->patient_model->getmedicalHistorySetups();
		$data['treatment_notes'] = $this->patient_model->getTreatment_notes($data['patient_data']->id);
		$data['patientMedicalHistory'] = $this->patient_model->getPatientMedicalHistory($data['patient_data']->id);
		$data['home_appointment_requests'] = $this->doctor_model->getHomeAppointmentsByPatient($data['patient_data']->id);
		$data['pulse_rate'] = 0;
		$data['respiratory_rate'] = 0;
		$data['temperature'] = 0;
		$data['blood_pressure'] = 0;
		$data['glucose_level'] = 0;
		
        foreach($data['treatment_notes'] as $tn){
			if($tn->vital_signs != null){
				$vs = json_decode($tn->vital_signs);
				if($vs[0] != '' && $data['pulse_rate'] == 0) $data['pulse_rate'] = $vs[0];
				if($vs[1] != '' && $data['respiratory_rate'] == 0) $data['respiratory_rate'] = $vs[1];
				if($vs[2] != '' && $data['temperature'] == 0) $data['temperature'] = $vs[2];
				if($vs[3] != '' && $data['blood_pressure'] == 0) $data['blood_pressure'] = $vs[3];
				if($vs[4] != '' && $data['glucose_level'] == 0) $data['glucose_level'] = $vs[4];
			}
		}
		
		foreach ($data['appointments'] as $appointment) {
            $timeline[$appointment->date + 1] = array(
				'title' => lang('appointment'),
				'date' => date('d-m-Y', $appointment->date),
				'icon' => 'fa fa-stethoscope',
				'bg' => '#8dd7d6',
				'dicon' => 'fa fa-user-md',
				'dtitle' => $appointment->doctor_name,
				'details' => $appointment->s_time . ' - ' . $appointment->e_time
			);
        }

        foreach ($data['prescriptions'] as $prescription) {
            $timeline[$prescription->date + 2] = array(
				'title' => lang('prescription'),
				'date' => date('d-m-Y', $prescription->date),
				'icon' => 'fa fa-medkit',
				'bg' => '#009988',
				'dicon' => 'fa fa-user-md',
				'dtitle' => $prescription->doctor_name,
				'details' => '<a class="btn btn-sm bg-info-light detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>'
			);
        }

        foreach ($data['labs'] as $lab) {
            $timeline[$lab->date + 3] = array(
				'title' => lang('lab'),
				'date' => date('d-m-Y', $lab->date),
				'icon' => 'fa fa-flask',
				'bg' => '#90b4e6',
				'dicon' => 'fa fa-user-md',
				'dtitle' => $lab->doctor_name,
				'details' => '<a class="btn btn-sm bg-primary-light invoicebutton" title="Lab" href="patient/report_view?id=' . $lab->id . '"><i class="fas fa-file-medical-alt"></i> ' . lang('report') . '</a>'
			);
        }

        foreach ($data['medical_histories'] as $medical_history) {
            $timeline[$medical_history->date + 4] = array(
				'title' => lang('case_history'),
				'date' => date('d-m-Y', $medical_history->date),
				'icon' => 'fa fa-flask',
				'bg' => '#009988',
				'dicon' => '',
				'dtitle' => '',
				'details' => $medical_history->description
			);
        }

        foreach ($data['patient_materials'] as $patient_material) {
            $timeline[$patient_material->date + 5] = array(
				'title' => lang('documents'),
				'date' => date('d-m-Y', $patient_material->date),
				'icon' => 'fa fa-file-o',
				'bg' => '#009988',
				'dicon' => '',
				'dtitle' => $patient_material->title,
				'details' => '<a href="' . $patient_material->url . '" download="" class="btn btn-sm bg-success-light" title="' . lang('download') . '"><i class="fa fa-download"></i> ' . lang('download') . '</a>'
			);
        }
		
		if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }
		$data['chatpage'] = false;
		$data['page_title'] = 'Dashboard';
		$this->load->view('partial/_header', $data);
        $this->load->view('patient-home', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	function report_view() {
        $data = array();
        $id = $this->input->get('id');
        $patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
        $data['lab'] = $this->lab_model->getLabById($id);

        if ($data['lab']->hospital_id != $this->session->userdata('hospital_id')) {
            $this->load->view('home/permission');
        }

        // $this->load->view('invoice', $data);
        $data['chatpage'] = false;
		$data['page_title'] = 'Report';
		$this->load->view('partial/_header', $data);
        $this->load->view('patient_report', $data);
        $this->load->view('partial/_footer', $data);
    }
	
	function profile()
	{
		$data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		$data['medicalHistoryLists'] = $this->patient_model->getmedicalHistorySetups();
		$data['chatpage'] = false;
		$data['page_title'] = 'Profile';
		$this->load->view('partial/_header', $data);
        $this->load->view('patient_profile', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function add_update() {
        $feedback = array();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
        if($_POST['oldemail'] != $_POST['email'])
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean|is_unique[users.email]');
        if($_POST['oldphone'] != $_POST['phone'])
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean|is_unique[users.phone]');
        
		if ($this->form_validation->run() == FALSE) {
			$feedback['status'] = false;
			$feedback['message'] = validation_errors();
			$this->session->set_flashdata('feedback', $feedback);
			redirect('patient/profile');
        } else {
			$_POST['img_url'] = $_POST['old_profileimage'];
			if($_FILES['profileimage']['size'] > 0){
				$profile_img = $_FILES['profileimage']['name'];
				$config1 = array(
					'file_name' => $profile_img,
					'upload_path' => "./uploads/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => False,
					'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height' => "1768",
					'max_width' => "2024"
				);
				$this->load->library('Upload', $config1);
				$this->upload->initialize($config1);
				
				if ($this->upload->do_upload('profileimage')) {
					$path1 = $this->upload->data();
					$img_url1 = "uploads/" . $path1['file_name'];
					$_POST['img_url'] = $img_url1;
				}
			}
			$ion_user_id = $this->ion_auth->get_user_id();
            $res = $this->profile_model->updateUserInfo($_POST, $ion_user_id);
			
			if($res !== false){
				$feedback['status'] = true;
				$feedback['message'] = "Profile update successfully";
			}
			else {
				$feedback['status'] = false;
				$feedback['message'] = "Profile update error";
			}
			$this->session->set_flashdata('feedback', $feedback);
			redirect('patient/profile');
        }
    }
	
    
	public function viewInvoice($id)
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		$data['invoice'] = $this->frontend_model->get_app_invoice($id);
		$data['chatpage'] = false;
		$data['page_title'] = 'Invoice';
		$this->load->view('partial/_header', $data);
        $this->load->view('appointment_invoice', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function favourites()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		$data['favourites'] = $this->frontend_model->getMyFavourites($data['patient_data']->id);
		$data['rating'] = $this->frontend_model->countDoctorRating();
		$data['chatpage'] = false;
		$data['page_title'] = 'Favourites';
		$this->load->view('partial/_header', $data);
        $this->load->view('favourites', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	
	public function dependent()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		if(isset($_GET['edit_dep']) && $_GET['edit_dep'] > 0){
			$data['dependent'] = $this->patient_model->getDependentById($_GET['edit_dep']);
		}
		elseif(isset($_GET['delete_dep']) && $_GET['delete_dep'] > 0){
			if($this->patient_model->deleteDependentById($_GET['delete_dep']) == true){
				$feedback['status'] = true;
				$feedback['message'] = "Dependent delete successfully";
				$this->session->set_flashdata('feedback', $feedback);
				redirect('patient/dependent');
			}
		}
		$data['dependents'] = $this->patient_model->getDependentByPatienId($data['patient_data']->id);
		$data['chatpage'] = false;
		$data['page_title'] = 'Dependent';
		$this->load->view('partial/_header', $data);
        $this->load->view('dependent', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function update_dependent()
	{
		print_r($_POST);
		$feedback = array();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('patient_id', 'Patient ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('relationship', 'Relationship', 'trim|xss_clean');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|xss_clean');
		$this->form_validation->set_rules('blood_group', 'Blood Group', 'trim|xss_clean');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$feedback['status'] = false;
			$feedback['message'] = validation_errors();
			$this->session->set_flashdata('feedback', $feedback);
			redirect('patient/dependent');
        } else {
			$_POST['img_url'] = $_POST['old_profile_image'];
			if($_FILES['profile_image']['size'] > 0){
				$profile_img = $_FILES['profile_image']['name'];
				$config1 = array(
					'file_name' => $profile_img,
					'upload_path' => "./uploads/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => False,
					'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height' => "1768",
					'max_width' => "2024"
				);
				$this->load->library('Upload', $config1);
				$this->upload->initialize($config1);
				
				if ($this->upload->do_upload('profile_image')) {
					$path1 = $this->upload->data();
					$img_url1 = "uploads/" . $path1['file_name'];
					$_POST['img_url'] = $img_url1;
				}
			}
			
			$res = $this->patient_model->updateDependentInfo($_POST);
			
			if($res === true){
				$feedback['status'] = true;
				$feedback['message'] = "Dependent update successfully";
			}
			else {
				$feedback['status'] = false;
				$feedback['message'] = "Dependent update error";
			}
			$this->session->set_flashdata('feedback', $feedback);
			redirect('patient/dependent');
        }
	}
	
	public function accounts()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		
		$data['date_from'] = '';
		$data['date_to'] = '';
		if(! empty($this->input->post('date_from'))){
			$data['date_from'] = $this->input->post('date_from').' 00:00:01';
			$data['date_to'] = $this->input->post('date_to'). ' 23:59:59';
		}
		$arg = array(
			'id' => $data['patient_data']->id, 
			'type' => 'patient',
			'fdate' => $data['date_from'], 
			'tdate' => $data['date_to']
		);
		$data['payment_history'] = $this->payment_model->get_payment_history($arg);
		
		$data['chatpage'] = false;
		$data['page_title'] = 'Accounts';
		$this->load->view('partial/_header', $data);
        $this->load->view('patient_account', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function medical_records()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
        if(isset($_GET['delete']))
		{
			if($this->patient_model->deletePatientMaterial($_GET['delete'])){
				$this->session->set_flashdata('feedback', 'Medical Records '.lang('delete'));
				redirect('patient/medical_records');
			}
			else{
				$this->session->set_flashdata('error_msg', 'Unexpected Error.');
			}
		}
		elseif(isset($_GET['privacy']) && isset($_GET['type']))
		{
			if($this->patient_model->patientMaterialPrivacyUpdate($_GET['privacy'], $_GET['type'])){
				$this->session->set_flashdata('feedback', 'Medical Records '.lang('delete'));
				redirect('patient/medical_records');
			}
			else{
				$this->session->set_flashdata('error_msg', 'Unexpected Error.');
			}
		}
		$patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		$data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($data['patient_data']->id);
		$data['hospital'] = $this->hospital_model->getHospitalById($data['patient_data']->hospital_id);
		
		$data['chatpage'] = false;
		$data['page_title'] = 'Medical Records';
		$this->load->view('partial/_header', $data);
        $this->load->view('medical_records', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function medical_details()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
		
		if(isset($_GET['delete']))
		{
			if($this->patient_model->deletePatientMedicalHistory($_GET['delete'])){
				$this->session->set_flashdata('feedback', 'Medical Details '.lang('delete'));
				redirect('patient/medical_details');
			}
			else{
				$this->session->set_flashdata('error_msg', 'Unexpected Error.');
			}
		}
		
        $data['settings'] = $this->settings_model->getSettings();
		$patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		$data['patientMedicalHistory'] = $this->patient_model->getPatientMedicalHistory($data['patient_data']->id);
		
		$data['chatpage'] = false;
		$data['page_title'] = 'Medical Details';
		$this->load->view('partial/_header', $data);
        $this->load->view('medical_details', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	function addPatientMedicalHistory()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('patient_id', 'Patient ID', 'trim|xss_clean');
        $this->form_validation->set_rules('vaccine', 'Vaccine Name', 'trim|xss_clean');
        $this->form_validation->set_rules('bmi', 'BMI Status', 'trim|xss_clean');
        $this->form_validation->set_rules('heart_rate', 'Heart rate', 'trim|xss_clean');
        $this->form_validation->set_rules('weight', 'Weight', 'trim|xss_clean');
        $this->form_validation->set_rules('fbc', 'fbc', 'trim|xss_clean');
        $this->form_validation->set_rules('res_rate', 'Respiratory Rate', 'trim|xss_clean');
        $this->form_validation->set_rules('blood_pressure', 'Blood Pressure', 'trim|xss_clean');
        $this->form_validation->set_rules('temperature', 'Temperature', 'trim|xss_clean');
		// print_r($_POST);

        if ($this->form_validation->run() == FALSE || (empty($_POST['vaccine']) && empty($_POST['bmi']) && empty($_POST['heart_rate']) && empty($_POST['weight']) && empty($_POST['fbc']) && empty($_POST['res_rate']) && empty($_POST['blood_pressure']) && empty($_POST['temperature']) ) ) {
            $this->session->set_flashdata('error_msg', lang('validation_error'));
        } else {
			$result = $this->patient_model->insertPatientMedicalHistory($_POST);
            if($result > 0)
				$this->session->set_flashdata('feedback', 'Medical details '.lang('added'));
			else
				$this->session->set_flashdata('error_msg', 'Unexpected error');
        }
		redirect('patient/medical_details');
    }
	
	public function change_password()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$patient_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		
		if(isset($_POST['change_password'])){
			$this->form_validation->set_rules('old', 'Old Password', 'required|trim|xss_clean');
			$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]|trim|xss_clean');
			$this->form_validation->set_rules('new_confirm', 'Confirm Password', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error_msg', validation_errors());
			} else {
			
				$identity = $this->session->userdata('identity');
				$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
				
				if ($change)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('feedback', $this->ion_auth->messages());
					//log the user out
					$logout = $this->ion_auth->logout();
					redirect('auth/login', 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error_msg', $this->ion_auth->errors());
				}
			}
		}
		
		$data['chatpage'] = false;
		$data['page_title'] = 'Change Password';
		$this->load->view('partial/_header', $data);
        $this->load->view('change_password', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	function get_patient_details()
    {
        $data = array();

        $from_where = $this->input->get('from_where');
        $id = $this->input->get('id');

        if (!empty($from_where)) {
            $this->db->where('id', $id);
            $id = $this->db->get('appointment')->row()->patient;
			$data['patient_data'] = $this->patient_model->getPatientById($id);
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
			$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
        }
		
		if ($id != '' && $from_where == '') {
			$data['patient_data'] = $this->frontend_model->getpatiendatabyId($id);
        }
		
		if ($this->ion_auth->in_group(array('Doctor'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
        }
		
		$data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient_data']->id);
		$data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($data['patient_data']->id);
        $data['labs'] = $this->lab_model->getLabByPatientId($data['patient_data']->id);
		$data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($data['patient_data']->id);
		$data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($data['patient_data']->id);
		$data['medicalHistoryLists'] = $this->patient_model->getmedicalHistorySetups();
		$data['treatment_notes'] = $this->patient_model->getTreatment_notes($data['patient_data']->id);
		$data['patientMedicalHistory'] = $this->patient_model->getPatientMedicalHistory($data['patient_data']->id);
		$data['symptoms'] = $this->patientfromtemplate_model->getPatientForm($data['patient_data']->id,'symptoms');
		
        $this->load->view('partial/_patient_details', $data);
    }
	
	/*End*/
	
	
	
	
	
	
	
	
	
	
	function medicalHistory()
    {
        $data = array();
        $patient_id = $this->input->get('id');
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
		$data['template'] = $_SESSION['template'];
        if ($this->ion_auth->in_group(array('Patient'))) {
            $user_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($user_id)->id;
        }

        $data['patient'] = $this->patient_model->getPatientById($patient_id);
        // $patient_hospital_id = $this->patient_model->getPatientById($patient_id)->hospital_id;
        if ($data['patient']->hospital_id != $this->session->userdata('hospital_id')) {
            redirect('home/permission');
        }

        // for new patient
        if($this->ion_auth->in_group(array('Patient')) and ($data['patient']->birthdate=="" or $data['patient']->bloodgroup=="" or $data['patient']->medicale_history=="" or $data['patient']->sex==""))
        {               
            redirect('profile');
        }
        // $data['template'] = $this->bodycharttemplate_model->getBodychart();
        // $data['treatment_notes'] = $this->patient_model->getTreatment_notes($patient_id);
        $data['patient_add_forms'] = $this->patientfromtemplate_model->getPatientForm($patient_id);
        $data['templateforms'] = $this->patientfromtemplate_model->getPatientFromTemplate();


        $data['medicalHistorySetups'] = $this->patient_model->getmedicalHistorySetups();
        
        $data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient']->id);
        // $data['patients'] = $this->patient_model->getPatient();
        // $data['doctors'] = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($patient_id);
        $data['labs'] = $this->lab_model->getLabByPatientId($patient_id);
        // $data['beds'] = $this->bed_model->getBedAllotmentsByPatientId($patient_id);
        $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($patient_id);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($patient_id);

        

        foreach ($data['appointments'] as $appointment) {
            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $appointment->doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['prescriptions'] as $prescription) {
            $timeline[$prescription->date + 2] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $prescription->date) . '</h5>
                                            <div class="activity purple">
                                                <span>
                                                    <i class="fa fa-medkit"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $prescription->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $prescription->doctor_name . '</h4>
                                                                    <a class="btn btn-info btn-xs detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['labs'] as $lab) {
            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab->doctor_name . '</h4>
                                                                    <a class="btn btn-xs invoicebutton" title="Lab" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['medical_histories'] as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['patient_materials'] as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $patient_material->date) . ' <a class="pull-right" title="' . lang('download') . '"  href="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('medical_history', $data);
        $this->load->view('home/footer'); // just the footer file
    }

	
    public function SavePatientmedicalHistory()
    {
        $requestData = $_REQUEST;
        $pid = $this->input->post('p_id');        
        $medicale_history = implode(',',$this->input->post('medicaleHistory'));
        if(in_array('Other', $this->input->post('medicaleHistory')))
        {
            $other_medical_history = $this->input->post('other_medical_history');
        }
        else
        {
            $other_medical_history = '';
        }
        // echo $other_medical_history."<br>";
        // echo $medicale_history; exit;
        $formData = array(
            'medicale_history' => $medicale_history,
            'other_medical_history' => $other_medical_history
        );
        $this->patient_model->updatePatientmedicaleHistory($formData,$pid);
        redirect("patient/medicalHistory" );
    }

//////////////////MHZ  new Data Ajax//////////////////////////
    public function prescriptionByPatientJson(){
        $requestData = $_REQUEST;
        $pid = $this->input->get('id');
        $prescriptions = $this->prescription_model->getPrescriptionByPatientId($pid);
        $i = 0;
        foreach ($prescriptions as $item) {
            $i = $i + 1;

            $option1 = '<a href="javascript:;" class="btn btn-info btn-xs btn_width viewPrescriptionbtn" data-ref= "'. $item->id . '" ><i class="fa fa-eye"> </i></a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editPrescriptionBtn" data-toggle="modal" data-ref="' . $item->id . '"><i class="fa fa-edit"></i></button>';

            $option3 = '<a href="javascript:;" class="btn btn-info btn-xs btn_width delPrescriptionbtn" data-ref= "'. $item->id . '" ><i class="fa fa-trash"> </i></a>';
            $option4 = '<a href="javascript:;" class="btn btn-info btn-xs btn_width printPrescriptionbtn" data-ref= "'. $item->id . '" ><i class="fa fa-print"> </i></a>';

            $doctordetails = $this->doctor_model->getDoctorById($item->doctor);
            if (!empty($doctordetails)) {
                $doctorname = $doctordetails->name;
            } else {
                $doctorname = $item->doctorname;
            }

            if (!empty($item->medicine)) {
                $medicine = explode('###', $item->medicine);
                $medicine_name  = '';
                foreach ($medicine as $key => $value) {
                    $medicine_id = explode('***', $value);
                    $medicine_details = $this->medicine_model->getMedicineById($medicine_id[0]);
                    if (!empty($medicine_details)) {
                        $medicine_name_with_dosage  = $medicine_details->name . ' -' . $medicine_id[1];
                        $medicine_name_with_dosage  = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                        rtrim($medicine_name_with_dosage, ',');
                        $medicine_name .= $medicine_name_with_dosage ;
                    }
                }
            }

            $time_slot = $item->time_slot;
            $date = date('d-m-Y', $item->date);


            $info[] = array(
                $date,
                $doctorname,
                $medicine_name,
                $option1 . ' ' . $option2 . ' ' . $option3 . ' ' . $option4
            );
        }

        if (!empty($prescriptions)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => sizeof($prescriptions),
                "recordsFiltered" => sizeof($prescriptions),
                "data" => $info
            );
        }
        else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function labFormByPatientJson(){
        $requestData = $_REQUEST;
        $pid = $this->input->get('id');
        $result = $this->lab_model->getLabByPatientId($pid);

        $i = 0;
        foreach ($result as $item) {
            $i = $i + 1;

            $option1 = '<button  class="btn btn-info btn-xs btn_width viewReportbtn" data-ref="'.$item->id.'" ><i class="fa fa-eye"> </i> Report</button>';

            $doctordetails = $this->doctor_model->getDoctorById($item->doctor);
            if (!empty($doctordetails)) {
                $doctorname = $doctordetails->name;
            } else {
                $doctorname = $item->doctorname;
            }

            $time_slot = $item->time_slot;
            $date = date('d-m-Y', $item->date);


            $info[] = array(
                $item->id,
                $date,
                $doctorname,
                $option1
            );
        }

        if (!empty($result)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => sizeof($result),
                "recordsFiltered" => sizeof($result),
                "data" => $info
            );
        }
        else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function bedFormByPatientJson(){
        $requestData = $_REQUEST;
        $pid = $this->input->get('id');
        $result = $this->bed_model->getBedAllotmentsByPatientId($pid);
        $i = 0;
        foreach ($result as $item) {
            $i = $i + 1;

            $info[] = array(
                $item->bed_id,
                $item->last_a_time,
                $item->last_d_time
            );
        }

        if (!empty($result)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => sizeof($result),
                "recordsFiltered" => sizeof($result),
                "data" => $info
            );
        }
        else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function patient_form()
    {
        $requestData = $_REQUEST;
        $pid = $this->input->get('pid');
        $data['templateforms'] = $this->patientfromtemplate_model->getPatientFromTemplate();
         $data['patient_id'] = $pid;


        $data['type'] =$this->input->get('type');
		$data['template'] = $_SESSION['template'];
		$data['patient'] = $this->patient_model->getPatientById($pid);
        $this->load->view('patient_form', $data);
    }

    public function add_medical_notes()
    {
        $pid = $this->input->POST('pid');
        $data['patient']  = $this->patient_model->getPatientById($pid);
        $data['patient_id'] = $pid;
		$data['template'] = $_SESSION['template'];
        $this->load->view('add_medical_notes', $data);
    }

    public function add_document()
    {
        $data = array();
        $pid = $this->input->POST('pid');
        $data['patient']  = $this->patient_model->getPatientById($pid);
        $data['patient_id'] = $pid;
		$data['template'] = $_SESSION['template'];
        $this->load->view('add_document', $data);
    }
    public  function editPatientPopup()
    {
         $id = $this->input->POST('pid');
        $data['groups'] =  $data['groups'] = $this->donor_model->getBloodBank();
        $data['patient'] = $this->patient_model->getPatientById($id);
         $data['doctor'] = $this->doctor_model->getDoctorById($data['patient']->doctor);
        $data['medicalHistorySetups'] = $this->patient_model->getmedicalHistorySetups();
        $this->load->view('edit_patient', $data);
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////
    public function documentRequestByPatientJson(){
        $requestData = $_REQUEST;
        $pid = $this->input->get('id');
        $result = $this->patientfromtemplate_model->getPatientForm($pid, 'document');
        $patient = $this->patient_model->getPatientById($pid);
        $i = 0;
        foreach ($result as $item) {
            $i = $i + 1;

            if (!$this->ion_auth->in_group('Patient')) {
                $option1 = '';
                if($item->completed == 'No'){
                    $option1 = '<button class="btn btn-sm btn-default copyBtn" data-action="'.base_url('pf/?token='.$item->token).'">Copy link</button> ';
                }
                if($item->answared == 'Yes'){
                    $option1 .= '<button class="btn btn-sm btn-default ansBtn" data-token="'.$item->token.'">Answer</button> ';
                }
                $option1 .= '<a class="btn btn-primary  btn-sm SendSmsBtn" data-phone=".'.$patient->phone .'"   data-msg="Mr '.$patient->name.', can you please complete the form? Link: '.base_url('pf/?token='.$item->token).'"   style="color: #fff;margin-right:5px;" href="javascript:;"><i class="fa fa-sms"></i> SMS</a> 
     <a class="btn btn-primary  btn-sm SendEmailBtn" data-email="'.$patient->email .'" data-msg="Mr  '.$patient->name.', can you please complete the form? Link: '.base_url('pf/?token='.$item->token) .'"   style="color: #fff;margin-right:5px;" href="javascript:;"><i class="fa fa-envelope"></i> Email</a> 
                                                         <a data-ref="'.$item->id.'" data-msg="Are you sure you want to delete this item?" class="btn btn-danger  btn-sm delbtn"><i class="fa fa-trash"></i> </a>';

            }



            $created_at =  date('m/d/Y', $item->created_at);
            $submited_date =  !empty($item->submited_date)? date('m/d/Y', $item->submited_date):'';

            $info[] = array(
                '<a href="'.base_url('pf/?token='.$item->token).'" target="_blank">'.$item->template.'</a>',
                $created_at,
                $item->completed,
                $submited_date,
                $option1
            );
        }

        if (!empty($result)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => sizeof($result),
                "recordsFiltered" => sizeof($result),
                "data" => $info
            );
        }
        else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    public function patintFormByPatientJson(){
        $requestData = $_REQUEST;
        $pid = $this->input->get('id');
        $result = $this->patientfromtemplate_model->getPatientForm($pid,'symptoms');
        $patient = $this->patient_model->getPatientById($pid);
        $i = 0;
        foreach ($result as $item) {
            $i = $i + 1;

            if (!$this->ion_auth->in_group('Patient')) {
                $option1 = '';
               if($item->completed == 'No'){
                             $option1 = '<button class="btn btn-sm btn-default copyBtn" data-action="'.base_url('pf/?token='.$item->token).'">Copy link</button> ';
                         }
                           if($item->answared == 'Yes'){
                                  $option1 .= '<button class="btn btn-sm btn-default ansBtn" data-token="'.$item->token.'">Answer</button> ';
                           }
$option1 .= '<a class="btn btn-primary  btn-sm SendSmsBtn" data-phone=".'.$patient->phone .'"   data-msg="Mr '.$patient->name.', can you please complete the form? Link: '.base_url('pf/?token='.$item->token).'"   style="color: #fff;margin-right:5px;" href="javascript:;"><i class="fa fa-sms"></i> SMS</a> 
     <a class="btn btn-primary  btn-sm SendEmailBtn" data-email="'.$patient->email .'" data-msg="Mr  '.$patient->name.', can you please complete the form? Link: '.base_url('pf/?token='.$item->token) .'"   style="color: #fff;margin-right:5px;" href="javascript:;"><i class="fa fa-envelope"></i> Email</a> 
                                                         <a data-ref="'.$item->id.'" data-msg="Are you sure you want to delete this item?" class="btn btn-danger  btn-sm delbtn"><i class="fa fa-trash"></i> </a>';

            }



            $created_at =  date('m/d/Y', $item->created_at);
            $submited_date =  !empty($item->submited_date)? date('m/d/Y', $item->submited_date):'';

            $info[] = array(
                '<a href="'.base_url('pf/?token='.$item->token).'" target="_blank">'.$item->template.'</a>',
                $created_at,
                $item->completed,
                $submited_date,
                $option1
            );
        }

        if (!empty($result)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => sizeof($result),
                "recordsFiltered" => sizeof($result),
                "data" => $info
            );
        }
        else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function medicalenoteByPatientJson(){
        $requestData = $_REQUEST;
        $pid = $this->input->get('id');
        $result =  $this->patient_model->getTreatment_notes($pid);
        $i = 0;
        foreach ($result as $item) {
            $i = $i + 1;

             if (!$this->ion_auth->in_group('Patient')) {

                $option1 = '<button type="button" class="btn btn-info btn-xs btn_width viewTreatmentButton" data-ref= "'. $item->id . '"  title="View"  ><i class="fa fa-images"></i> </button>
                    <a class="btn btn-info btn-xs btn_width delbtn" title="'.lang('delete').'" data-ref= "'. $item->id . '"     ><i class="fa fa-trash"></i> </a>';

            }



            $doctor_details = $this->doctor_model->getDoctorByIonUserId($item->doctor);
            if (!empty($doctor_details)) {
                $appointment_doctor = $doctor_details->name;
            } else {
                $appointment_doctor = '';
            }


            $date = date('d-m-Y', $item->add_date);


            $info[] = array(
                $date,
                $appointment_doctor,
                $item->presenting_complaint,
                $option1
            );
        }

        if (!empty($result)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => sizeof($result),
                "recordsFiltered" => sizeof($result),
                "data" => $info
            );
        }
        else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function appointmentsByPatientJson(){
        $requestData = $_REQUEST;
        $pid = $this->input->get('id');
        $appointments  = $this->appointment_model->getAppointmentByPatient($pid);
        $i = 0;
        foreach ($appointments as $appointment) {
            $i = $i + 1;

            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editAppointmentBtn" data-toggle="modal" data-id="' . $appointment->id . '"><i class="fa fa-edit"></i></button>';

            $option2 = '<a href="javascript:;" class="btn btn-info btn-xs btn_width delAppbtn" data-ref= "'. $appointment->id . '" ><i class="fa fa-trash"> </i></a>';

            if ($this->ion_auth->in_group(array('Doctor'))) {
                if ($appointment->status == 'Confirmed') {
                    if ($appointment->status == 'Confirmed') {
                        $options7 = '<a href="javascript:;"  class="btn btn-info btn-xs btn_width liveCallBtn" title="' . lang('start_live') . '" style="color: #fff;" data-ref="meeting/instantLive?id=' . $appointment->id . '" target="_blank" onclick="return confirm(\'Are you sure you want to start a live meeting with this patient? SMS and Email will be sent to the Patient.\');"><i class="fa fa-headphones"></i> ' . lang('live') . '</a>';

                 } else {
                        $options7 = '';
                    }
                } else {
                    $options7 = '';
                }
            } else {
                $options7 = '';
            }


            $doctordetails = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctordetails)) {
                $doctorname = $doctordetails->name;
            } else {
                $doctorname = $appointment->doctorname;
            }

            $time_slot = $appointment->time_slot;
            $date = date('d-m-Y', $appointment->date);


            $info[] = array(
                $date,
                $time_slot,
                $doctorname,
                $appointment->status,
                $option1 . ' ' . $option2 . ' ' .$options7
            );
        }

        if (!empty($appointments)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => sizeof($appointments),
                "recordsFiltered" => sizeof($appointments),
                "data" => $info
            );
        }
    else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

   public function delete_appointment() {
        $data = array();
         $id = $this->input->post('ref');

        $res = $this->appointment_model->delete($id);


        if (!empty($res)) {
          return 1;
        } else {
            return 0;
        }
    }
    public function document_list() {
        $data = array();
        $id = $this->input->post('id');
        $pid = $this->input->post('pid');

        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($pid);
        $this->load->view('document_list', $data);
    }

    public function edit_appointment() {
        $data = array();
        $id = $this->input->post('id');
        $pid = $this->input->post('pid');

        if($id) $data['appointment'] = $this->appointment_model->getAppointmentById($id);
        $data['patient'] = $this->patient_model->getPatientById($pid);
        $data['doctor'] = $this->doctor_model->getDoctorById($data['appointment']->doctor);

		$data['template'] = $_SESSION['template'];
        $this->load->view('appointment_form', $data);
    }

///////////////End MHZ////////////////////

    public function medicalHistoryAjax()
    {
        $data = array();
        $id = $this->input->get('id');

        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
        }


        // $patient_hospital_id = $this->patient_model->getPatientById($id)->hospital_id;
        // if ($patient_hospital_id != $this->session->userdata('hospital_id')) {
        //     redirect('home/permission');
        // }
      //  $data['template'] = $this->bodycharttemplate_model->getBodychart();
      //  $data['treatment_notes'] = $this->patient_model->getTreatment_notes($id);
      //  $data['patient_add_forms'] = $this->patientfromtemplate_model->getPatientForm($id);
       // $data['templateforms'] = $this->patientfromtemplate_model->getPatientFromTemplate();

        $data['patient'] = $this->patient_model->getPatientById($id);
         $data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient']->id);
        $data['patients'] = $this->patient_model->getPatient();
         $data['doctors'] = $this->doctor_model->getDoctor();
       $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id);
         $data['labs'] = $this->lab_model->getLabByPatientId($id);
         $data['beds'] = $this->bed_model->getBedAllotmentsByPatientId($id);
        $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($id);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id);


        foreach ($data['appointments'] as $appointment) {
            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$prescription->date + 2] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $prescription->date) . '</h5>
                                            <div class="activity purple">
                                                <span>
                                                    <i class="fa fa-medkit"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $prescription->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <a class="btn btn-info btn-xs detailsbutton timelineBtn" title="View" data-ref="prescription/viewPrescription?type=1&id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['labs'] as $lab) {

            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = '';
            }

            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab_doctor . '</h4>
                                                                    <a class="btn btn-xs invoicebutton timelineBtn" title="Lab" style="color: #fff;" data-ref="lab/invoice?type=1&id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['medical_histories'] as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['patient_materials'] as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $patient_material->date) . ' <a class="pull-right timelineBtn" title="' . lang('download') . '"  data-ref="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }

        $this->load->view('medical_history_popup', $data);
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function duplicate_patient_form_template()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
         $token = $this->input->get('token');
        $data = $this->patientfromtemplate_model->getPatientFromTemplateById($token);

        if ($data) {
            $tempData = array(
                'name' => $data->name . '_Copy',
                'summary' => $data->summary
            );
            $this->patientfromtemplate_model->insertPatientFromTemplate($tempData);
        }
        redirect('patient/patient_frm_tem');
    }

    public function viewansware()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $token = $this->input->get('token');
        $data['template'] = $this->pf_model->getPatientFromTemplateByToken($token);
        $data['sections'] = $this->pf_model->getFormSection($data['template']->id);

        $this->load->view('home/css'); // just the header file
        $this->load->view('answarefrom', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function edit_patient_form_template()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $id = $this->input->get('id');
        $data['template'] = $this->patientfromtemplate_model->getPatientFromTemplateById($id);
        //print_r(   $data['template'] = unserialize($data['template']->summary));
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('edit_patient_form_template', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function viewtemplate()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $id = $this->input->get('id');
        $data['template'] = $this->patientfromtemplate_model->getPatientFromTemplateById($id);
        //print_r(   $data['template'] = unserialize($data['template']->summary));
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('patient_template_edit', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function save_patient_form()
    {

        $id = $this->input->post('id');
        $form_id = $this->input->post('form_id');
        $patient_id = $this->input->post('patient_id');
        $type = $this->input->post('type');
       // $appointment_id = $this->input->post('appointment_id');
        $formData = array(
            'created_at' => time(),
            'form_id' => $form_id,
            'type' => $type,
            'patient_id' => $patient_id,
            'token' => sha1(md5(time()))
        );
        $this->patientfromtemplate_model->insertPatientForm($formData);
        redirect("patient/medicalHistory?id=" . "$patient_id");
    }


    public function save_patient_template()
    {

        $data = $this->input->post();
        $data = json_decode(json_encode($data));

        $tempData = array(
            'name' => $data->template,
            'summary' => serialize($data)
        );
        $this->patientfromtemplate_model->insertPatientFromTemplate($tempData);
        $template_id = $this->db->insert_id();
        //////////////////////////////////////////////////////insert Section/////////////////////////////////////////////////////////////////////////
        foreach ($data->section as $key => $section) {
            $ptsData = array(
                'section' => $section->title,
                'template_id' => $template_id
            );
            $this->patientfromtemplate_model->insertPatientTemplateSection($ptsData);
            $section_id = $this->db->insert_id();
            //////////////////////Quiz/////////////////////
            if (!empty($section->quiz))
                foreach ($section->quiz as $quiz) {
                    $quizData = array(
                        'question' => $quiz->title,
                        'question_type' => $quiz->quize_type,
                        'required' => $quiz->required,
                        'section_id' => $section_id,
                        'template_id' => $template_id,
                    );
                    $this->patientfromtemplate_model->insertPatientTemplateSectionQuestion($quizData);
                    $quiz_id = $this->db->insert_id();

                    if ($quiz->ans)
                        foreach ($quiz->ans as $k => $ans) {
                            $ansData = array(
                                'question_id' => $quiz_id,
                                'answare' => $ans
                            );
                            $this->patientfromtemplate_model->insertPatientTemplateSectionQuestionAns($ansData);
                            // $quiz_id = $this->db->insert_id();
                        }

                }
            ///////////////////////////////Ans/////////////////////////
        }  //end foreach//
        redirect('patient/patient_frm_tem');

    }

    public function delete_patient_form()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $id = $this->input->get('id');
        $pid = $this->input->get('pid');

        $this->patientfromtemplate_model->deletePatientAddFrom($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('patient/medicalHistory?id='.$pid);
    }


    public function deleteTreatment()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $id = $this->input->get('id');
        $this->patient_model->deleteTreatment($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('patient');
    }

    public function deletepatient_template()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $id = $this->input->get('id');

        $this->patientfromtemplate_model->deletePatientFromTemplate($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('patient/patient_frm_tem');
    }

    public function update_patient_template()
    {
        $id = $this->input->get('id');
        $this->patientfromtemplate_model->deletePatientTemplateSection($id);


        $data = $this->input->post();
        $data = json_decode(json_encode($data));

        $tempData = array(
            'name' => $data->template,
            'summary' => serialize($data)
        );
        $this->patientfromtemplate_model->updatePatientFromTemplate($id, $tempData);
        $template_id = $id;
        //////////////////////////////////////////////////////insert Section/////////////////////////////////////////////////////////////////////////
        foreach ($data->section as $key => $section) {
            $ptsData = array(
                'section' => $section->title,
                'template_id' => $template_id
            );
            $this->patientfromtemplate_model->insertPatientTemplateSection($ptsData);
            $section_id = $this->db->insert_id();
            //////////////////////Quiz/////////////////////
            if (!empty($section->quiz))
                foreach ($section->quiz as $quiz) {
                    $quizData = array(
                        'question' => $quiz->title,
                        'question_type' => $quiz->quize_type,
                        'required' => $quiz->required,
                        'section_id' => $section_id,
                        'template_id' => $template_id,
                    );
                    $this->patientfromtemplate_model->insertPatientTemplateSectionQuestion($quizData);
                    $quiz_id = $this->db->insert_id();

                    if ($quiz->ans)
                        foreach ($quiz->ans as $k => $ans) {
                            $ansData = array(
                                'question_id' => $quiz_id,
                                'answare' => $ans
                            );
                            $this->patientfromtemplate_model->insertPatientTemplateSectionQuestionAns($ansData);
                            // $quiz_id = $this->db->insert_id();
                        }

                }
            ///////////////////////////////Ans/////////////////////////
        }  //end foreach//
        redirect('patient/patient_frm_tem');

    }

    public function save_treatment_note()
    {
        $id = $this->input->post('id');
        $patient_id = $this->input->post('patient_id');
        $date = strtotime($this->input->post('date'));
        $user = $this->ion_auth->get_user_id();
        $presenting_complaint = $this->input->post('presenting_complaint');

        $complaint_history = '';//$this->input->post('complaint_history');
        $medical_history = $this->input->post('medical_history');
        $other_history = $this->input->post('other_history');
        $vital_signs = json_encode($this->input->post('vital_signs'));
        $medication = '';//$this->input->post('medication');
        $assessment = $this->input->post('assessment');
        $differential_diagnosis = $this->input->post('differential_diagnosis');
        $treatment = '';//$this->input->post('treatment');
        $treatment_plan = $this->input->post('treatment_plan');
        
        $referral = $this->input->post('referral');
        $investigations = $this->input->post('investigations');
        $prescriptions = $this->input->post('prescriptions');
        // echo "<pre>";
        // print_r($_POST);
        // exit;
        if (empty($id)) {
            $data = array(
                'patient_id' => $patient_id,
                'doctor' => $this->ion_auth->get_user_id(),
                'presenting_complaint' => $presenting_complaint,
                'complaint_history' => $complaint_history,
                'medical_history' => $medical_history,
                'medication' => $medication,
                'assessment' => $assessment,
                'treatment' => $treatment,
                'treatment_plan' => $treatment_plan,
                'differential_diagnosis' => $differential_diagnosis,
                'other_history' => $other_history,
                'vital_signs' => $vital_signs,
                'referral' => $referral,
                'investigations' => $investigations,
                'prescriptions' => $prescriptions,
                'Darft' => 'No',
                'add_date' => trim($date),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->patient_model->insertTreatment($data);
            $inserted_id = $this->db->insert_id();
			
			
			
			$mnh = array(
				"patient_id"=>$patient_id,
				"date"=>date("Y-m-d")
				); 
			$flg = false;
			if($_POST["vital_signs"][0] > 0){
				$flg = true;
				$mnh['heart_rate'] = $_POST["vital_signs"][0];
			}
			if($_POST["vital_signs"][1] > 0){
				$flg = true;
				$mnh['res_rate'] = $_POST["vital_signs"][1];
			}
			if($_POST["vital_signs"][2] > 0){
				$flg = true;
				$mnh['temperature'] = $_POST["vital_signs"][2];
			}
			if($_POST["vital_signs"][3] > 0){
				$flg = true;
				$mnh['blood_pressure'] = $_POST["vital_signs"][3];
			}
			if($_POST["vital_signs"][4] > 0){
				$flg = true;
				$mnh['fbc'] = $_POST["vital_signs"][4];
			}
			if($flg) $this->patient_model->insertPatientMedicalHistory($mnh);
            $template = $this->input->post('template');

            if ($template)
                foreach ($template as $key => $value) {
                    $data2 = array(
                        'treatment_id' => $inserted_id,
                        'body_pic' => trim($value)
                    );

                    //print_r($data2);
                    $this->patient_model->insertPic($data2);
                }


        }
        redirect("patient/medicalHistory?id=" . "$patient_id");
    }


    public function patient_frm_tem()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $data['items'] = $this->patientfromtemplate_model->getPatientFromTemplate();

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('patient_frm_tem', $data);
        $this->load->view('home/footer'); // just the header file
    }


    public function addtempate()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }


        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('addtempate', $data);
        $this->load->view('home/footer'); // just the header file
    }


    public function index()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $data['template'] = $this->bodycharttemplate_model->getBodychart();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('patient', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function calendar()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('calendar', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $data = array();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['groups'] = $this->donor_model->getBloodBank();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew()
    {

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        $id = $this->input->post('id');


        if (empty($id)) {
            $limit = $this->patient_model->getLimit();
            if ($limit <= 0) {
                $this->session->set_flashdata('feedback', lang('patient_limit_exceed'));
                redirect('patient');
            }
        }


        $redirect = $this->input->get('redirect');
        if (empty($redirect)) {
            $redirect = $this->input->post('redirect');
        }
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $sms = $this->input->post('sms');
        $doctor = $this->input->post('doctor');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $sex = $this->input->post('sex');
        $birthdate = $this->input->post('birthdate');
        $bloodgroup = $this->input->post('bloodgroup');
        $patient_id = $this->input->post('p_id');
        if (empty($patient_id)) {
            $patient_id = rand(10000, 1000000);
        }
        if ((empty($id))) {
            $add_date = date('m/d/y');
            $registration_time = time();
        } else {
            $add_date = $this->patient_model->getPatientById($id)->add_date;
            $registration_time = $this->patient_model->getPatientById($id)->registration_time;
        }



        $email = $this->input->post('email');
        if (empty($email)) {
            $email = $name . '@' . $phone . '.com';
        }


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[3]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Doctor Field
        //   $this->form_validation->set_rules('doctor', 'Doctor', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[2]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[2]|max_length[50]|xss_clean');
        // Validating Email Field
        $this->form_validation->set_rules('sex', 'Sex', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('birthdate', 'Birth Date', 'trim|min_length[2]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('bloodgroup', 'Blood Group', 'trim|min_length[1]|max_length[10]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', lang('validation_error'));
                redirect("patient/editPatient?id=$id");
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['doctors'] = $this->doctor_model->getDoctor();
                $data['groups'] = $this->donor_model->getBloodBank();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $file_name = $_FILES['img_url']['name'];
            $file_name_pieces = explode('_', $file_name);
            $new_file_name = '';
            $count = 1;
            foreach ($file_name_pieces as $piece) {
                if ($count !== 1) {
                    $piece = ucfirst($piece);
                }

                $new_file_name .= $piece;
                $count++;
            }
            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "10000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "10000",
                'max_width' => "10000"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            $medicale_history = implode(',',$this->input->post('medicaleHistory'));


            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'patient_id' => $patient_id,
                    'img_url' => $img_url,
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'doctor' => $doctor,
                    'phone' => $phone,
                    'sex' => $sex,
                    'birthdate' => $birthdate,
                    'bloodgroup' => $bloodgroup,
                    'add_date' => $add_date,
                    'medicale_history' => $medicale_history,
                    'registration_time' => $registration_time
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'patient_id' => $patient_id,
                    'name' => $name,
                    'email' => $email,
                    'doctor' => $doctor,
                    'address' => $address,
                    'phone' => $phone,
                    'sex' => $sex,
                    'birthdate' => $birthdate,
                    'bloodgroup' => $bloodgroup,
                    'add_date' => $add_date,
                    'medicale_history' => $medicale_history,
                    'registration_time' => $registration_time
                );
            }

            $username = $this->input->post('name');

            if (empty($id)) {     // Adding New Patient
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                    redirect('patient/addNewView');
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                    $this->patient_model->insertPatient($data);
                    $patient_user_id = $this->db->get_where('patient', array('email' => $email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->patient_model->updatePatient($patient_user_id, $id_info);
                    $this->hospital_model->addHospitalIdToIonUser($ion_user_id, $this->hospital_id);
                    //sms
                    $set['settings'] = $this->settings_model->getSettings();
                    $autosms = $this->sms_model->getAutoSmsByType('patient');
                    $message = $autosms->message;
                    $to = $phone;
                    $name1 = explode(' ', $name);
                    if (!isset($name1[1])) {
                        $name1[1] = null;
                    }
                    $data1 = array(
                        'firstname' => $name1[0],
                        'lastname' => $name1[1],
                        'name' => $name,
                        'doctor' => $doctor,
                        'company' => $set['settings']->system_vendor
                    );
                    //   if (!empty($sms)) {
                    // $this->sms->sendSmsDuringPatientRegistration($patient_user_id);
                    if ($autosms->status == 'Active') {
                        $messageprint = $this->parser->parse_string($message, $data1);
                        $data2[] = array($to => $messageprint);
                        $this->sms->sendSms($to, $message, $data2);
                    }
                    //end
                    //  }
                    //email

                    $autoemail = $this->email_model->getAutoEmailByType('patient');
                    if ($autoemail->status == 'Active') {
                        $emailSettings = $this->email_model->getEmailSettings();
                        $message1 = $autoemail->message;
                        $messageprint1 = $this->parser->parse_string($message1, $data1);
                        $this->email->from($emailSettings->admin_email);
                        $this->email->to($email);
                        $this->email->subject('Appointment confirmation');
                        $this->email->message($messageprint1);
                        $this->email->send();
                    }

                    //end


                    $this->session->set_flashdata('feedback', lang('added'));
                }
                //    }
            } else { // Updating Patient
                $ion_user_id = $this->db->get_where('patient', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->patient_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->patient_model->updatePatient($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            if (!empty($redirect)) {
                redirect($redirect);
            } else {
                redirect('patient');
            }
        }
    }

    function editPatient()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['groups'] = $this->donor_model->getBloodBank();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPatientByJason()
    {
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id);
        $data['doctor'] = $this->doctor_model->getDoctorById($data['patient']->doctor);
        echo json_encode($data);
    }

    function getPatientByJason()
    {
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id);

        $doctor = $data['patient']->doctor;
        $data['doctor'] = $this->doctor_model->getDoctorById($doctor);

        if (!empty($data['patient']->birthdate)) {
            $birthDate = strtotime($data['patient']->birthdate);
            $birthDate = date('m/d/Y', $birthDate);
            $birthDate = explode("/", $birthDate);
            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
            $data['age'] = $age . ' Year(s)';
        }

        echo json_encode($data);
    }

    function patientDetails()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function report()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('diagnostic_report_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function addDiagnosticReport()
    {
        $id = $this->input->post('id');
        $invoice = $this->input->post('invoice');
        $patient = $this->input->post('patient');
        $report = $this->input->post('report');

        $date = time();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');


        // Validating Name Field
        $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Password Field

        $this->form_validation->set_rules('report', 'Report', 'trim|min_length[1]|max_length[10000]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect('patient/report?id=' . $invoice);
        } else {

            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'invoice' => $invoice,
                'date' => $date,
                'report' => $report
            );

            if (empty($id)) {     // Adding New department
                $this->patient_model->insertDiagnosticReport($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $this->patient_model->updateDiagnosticReport($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('patient/report?id=' . $invoice);
        }
    }

    function patientPayments()
    {
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('patient_payments', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function caseList()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatient();
        $data['medical_histories'] = $this->patient_model->getMedicalHistory();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('case_list', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function documents()
    {
        $data['patients'] = $this->patient_model->getPatient();
        $data['files'] = $this->patient_model->getPatientMaterial();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('documents', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function myCaseList()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
            $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($patient_id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('my_case_list', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function myDocuments()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
            $data['files'] = $this->patient_model->getPatientMaterialByPatientId($patient_id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('my_documents', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function myPrescription()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
            $data['doctors'] = $this->doctor_model->getDoctor();
            $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($patient_id);
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('my_prescription', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    public function myPayment()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
            $data['settings'] = $this->settings_model->getSettings();
            $data['payments'] = $this->finance_model->getPaymentByPatientId($patient_id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('my_payment', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    function myPaymentHistory()
    {
		$data = array();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }


        if ($this->ion_auth->in_group(array('Patient'))) {
            $user_id = $this->ion_auth->get_user_id();
            $data['patient'] = $this->patient_model->getPatientByIonUserId($user_id);
        }
        $data['settings'] = $this->settings_model->getSettings();
		$data['date_from'] = '';
		$data['date_to'] = '';
			
        if(! empty($this->input->post('date_from'))){
			$data['date_from'] = $this->input->post('date_from').' 00:00:01';
			$data['date_to'] = $this->input->post('date_to'). ' 23:59:59';
		}
		$arg = array(
			'id' => $data['patient']->id, 
			'type' => 'patient',
			'fdate' => $data['date_from'], 
			'tdate' => $data['date_to']
		);
		
		$data['payment_history'] = $this->payment_model->get_payment_history($arg);
		// print_r($data['payment_history']);
        // if (!empty($date_from)) {
            // $data['payments'] = $this->finance_model->getPaymentByPatientIdByDate($patient, $date_from, $date_to);
            // $data['deposits'] = $this->finance_model->getDepositByPatientIdByDate($patient, $date_from, $date_to);
            // $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
        // } else {
            // $data['payments'] = $this->finance_model->getPaymentByPatientId($patient);
            // $data['pharmacy_payments'] = $this->pharmacy_model->getPaymentByPatientId($patient);
            // $data['ot_payments'] = $this->finance_model->getOtPaymentByPatientId($patient);
            // $data['deposits'] = $this->finance_model->getDepositByPatientId($patient);
            // $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
        // }


        // $data['patient'] = $this->patient_model->getPatientByid($patient);
        // $data['settings'] = $this->settings_model->getSettings();


        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('my_payments_history', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function deposit()
    {
        $id = $this->input->post('id');


        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
        } else {
            $this->session->set_flashdata('feedback', lang('undefined_patient_id'));
            redirect('patient/myPaymentsHistory');
        }


        $payment_id = $this->input->post('payment_id');
        $date = time();

        $deposited_amount = $this->input->post('deposited_amount');

        $deposit_type = $this->input->post('deposit_type');

        if ($deposit_type != 'Card') {
            $this->session->set_flashdata('feedback', lang('undefined_payment_type'));
            redirect('patient/myPaymentsHistory');
        }

        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Patient Name Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Deposited Amount Field
        $this->form_validation->set_rules('deposited_amount', 'Deposited Amount', 'trim|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            redirect('patient/myPaymentsHistory');
        } else {
            $data = array();
            $data = array('patient' => $patient,
                'date' => $date,
                'payment_id' => $payment_id,
                'deposited_amount' => $deposited_amount,
                'deposit_type' => $deposit_type,
                'user' => $user
            );
            if (empty($id)) {
                if ($deposit_type == 'Card') {
                    $payment_details = $this->finance_model->getPaymentById($payment_id);
                    $gateway = $this->settings_model->getSettings()->payment_gateway;
                    if ($gateway == 'PayPal') {
                        $card_type = $this->input->post('card_type');
                        $card_number = $this->input->post('card_number');
                        $expire_date = $this->input->post('expire_date');
                        $cvv = $this->input->post('cvv_number');

                        $all_details = array(
                            'patient' => $payment_details->patient,
                            'date' => $payment_details->date,
                            'amount' => $payment_details->amount,
                            'doctor' => $payment_details->doctor_name,
                            'discount' => $payment_details->discount,
                            'flat_discount' => $payment_details->flat_discount,
                            'gross_total' => $payment_details->gross_total,
                            'status' => 'unpaid',
                            'patient_name' => $payment_details->patient_name,
                            'patient_phone' => $payment_details->patient_phone,
                            'patient_address' => $payment_details->patient_address,
                            'deposited_amount' => $deposited_amount,
                            'payment_id' => $payment_details->id,
                            'card_type' => $card_type,
                            'card_number' => $card_number,
                            'expire_date' => $expire_date,
                            'cvv' => $cvv,
                            'from' => 'patient_payment_details',
                            'user' => $user,
                            'cardholdername' => $this->input->post('cardholder')
                        );
                        $this->paypal->paymentPaypal($all_details);
                    } elseif ($gateway == 'Paystack') {
                        $ref = date('Y') . '-' . rand() . date('d') . '-' . date('m');
                        $amount_in_kobo = $deposited_amount;
                        $this->load->module('paystack');
                        $this->paystack->paystack_standard($amount_in_kobo, $ref, $patient, $payment_id, $user, '2');
                    } elseif ($gateway == 'Stripe') {
                        $card_number = $this->input->post('card_number');
                        $expire_date = $this->input->post('expire_date');
                        $cvv = $this->input->post('cvv_number');
                        $token = $this->input->post('token');

                        $stripe = $this->db->get_where('paymentGateway', array('name =' => 'Stripe'))->row();
                        \Stripe\Stripe::setApiKey($stripe->secret);
                        $charge = \Stripe\Charge::create(array(
                            "amount" => $deposited_amount * 100,
                            "currency" => "usd",
                            "source" => $token
                        ));
                        $chargeJson = $charge->jsonSerialize();
                        if ($chargeJson['status'] == 'succeeded') {
                            $data1 = array(
                                'date' => $date,
                                'patient' => $patient,
                                'payment_id' => $payment_id,
                                'deposited_amount' => $amount_received,
                                'gateway' => 'Stripe',
                                'user' => $user,
                                'hospital_id' => $this->session->userdata('hospital_id')
                            );
                            $this->finance_model->insertDeposit($data1);
                            $this->session->set_flashdata('feedback', lang('added'));
                        } else {
                            $this->session->set_flashdata('feedback', lang('transaction_failed'));
                        }
                        //  redirect("finance/invoice?id=" . "$inserted_id");
                        redirect('patient/myPaymentHistory');
                    } elseif ($gateway == 'Pay U Money') {
                        redirect("payu/check?deposited_amount=" . "$deposited_amount" . '&payment_id=' . $payment_id);
                    } else {
                        $this->session->set_flashdata('feedback', lang('payment_failed_no_gateway_selected'));
                        redirect('patient/myPaymentHistory');
                    }
                } else {
                    $this->finance_model->insertDeposit($data);
                    $this->session->set_flashdata('feedback', lang('added'));
                }
            } else {
                $this->finance_model->updateDeposit($id, $data);

                $amount_received_id = $this->finance_model->getDepositById($id)->amount_received_id;
                if (!empty($amount_received_id)) {
                    $amount_received_payment_id = explode('.', $amount_received_id);
                    $payment_id = $amount_received_payment_id[0];
                    $data_amount_received = array('amount_received' => $deposited_amount);
                    $this->finance_model->updatePayment($amount_received_payment_id[0], $data_amount_received);
                }

                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('patient/myPaymentHistory');
        }
    }

    function myInvoice()
    {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('myInvoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function addMedicalHistory()
    {
        $id = $this->input->post('id');
        $patient_id = $this->input->post('patient_id');

        $date = $this->input->post('date');

        $title = $this->input->post('title');

        if (!empty($date)) {
            $date = strtotime($date);
        } else {
            $date = time();
        }

        $description = $this->input->post('description');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $redirect = $this->input->post('redirect');
        if (empty($redirect)) {
            $redirect = 'patient/medicalHistory?id=' . $patient_id;
        }

        // Validating Name Field
        $this->form_validation->set_rules('date', 'Date', 'trim|min_length[1]|max_length[100]|xss_clean');

        // Validating Title Field
        $this->form_validation->set_rules('title', 'Title', 'trim|min_length[1]|max_length[100]|xss_clean');

        // Validating Password Field

        $this->form_validation->set_rules('description', 'Description', 'trim|min_length[5]|max_length[10000]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("patient/editMedicalHistory?id=$id");
            } else {
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }

            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'patient_id' => $patient_id,
                'date' => $date,
                'title' => $title,
                'description' => $description,
                'patient_name' => $patient_name,
                'patient_phone' => $patient_phone,
                'patient_address' => $patient_address,
            );

            if (empty($id)) {     // Adding New department
                $this->patient_model->insertMedicalHistory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $this->patient_model->updateMedicalHistory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect($redirect);
        }
    }

    public function diagnosticReport()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            $current_user = $this->ion_auth->get_user_id();
            $patient_user_id = $this->patient_model->getPatientByIonUserId($current_user)->id;
            $data['payments'] = $this->finance_model->getPaymentByPatientId($patient_user_id);
        } else {
            $data['payments'] = $this->finance_model->getPayment();
        }

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('diagnostic_report', $data);
        $this->load->view('home/footer'); // just the header file
    }

    // function medicalHistory()
    // {
    //     $data = array();
    //     $id = $this->input->get('id');

    //     if ($this->ion_auth->in_group(array('Patient'))) {
    //         $patient_ion_id = $this->ion_auth->get_user_id();
    //         $id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
    //     }


    //     $patient_hospital_id = $this->patient_model->getPatientById($id)->hospital_id;
    //     if ($patient_hospital_id != $this->session->userdata('hospital_id')) {
    //         redirect('home/permission');
    //     }
    //     $data['template'] = $this->bodycharttemplate_model->getBodychart();
    //     $data['treatment_notes'] = $this->patient_model->getTreatment_notes($id);
    //     $data['patient_add_forms'] = $this->patientfromtemplate_model->getPatientForm($id);
    //     $data['templateforms'] = $this->patientfromtemplate_model->getPatientFromTemplate();


    //     $data['medicalHistorySetups'] = $this->patient_model->getmedicalHistorySetups();
    //     $data['patient'] = $this->patient_model->getPatientById($id);
    //     $data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient']->id);
    //     $data['patients'] = $this->patient_model->getPatient();
    //     $data['doctors'] = $this->doctor_model->getDoctor();
    //     $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id);
    //     $data['labs'] = $this->lab_model->getLabByPatientId($id);
    //     $data['beds'] = $this->bed_model->getBedAllotmentsByPatientId($id);
    //     $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($id);
    //     $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id);

    //     if($this->ion_auth->in_group(array('Patient'))){
    //         $u_id = $this->ion_auth->get_user_id();
    //         $p_status_data = $this->profile_model->getpatienttbldata($u_id);
    //     }
    //     else
    //     {
    //         $p_status_data = array();
    //     }
    //     // echo "<pre>";
    //     // print_r($p_status_data);
    //     // exit;

    //     if($this->ion_auth->in_group(array('Patient')) and ($p_status_data->birthdate=="" or $p_status_data->bloodgroup=="" or $p_status_data->medicale_history=="" or $p_status_data->sex==""))
    //     {               
    //         redirect('profile');
    //         // echo "Under Construction!"; exit;
    //     }

    //     foreach ($data['appointments'] as $appointment) {
    //         $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
    //         if (!empty($doctor_details)) {
    //             $doctor_name = $doctor_details->name;
    //         } else {
    //             $doctor_name = '';
    //         }
    //         $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
    //             <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
    //                                         <h5 class="pull-right">' . date('d-m-Y', $appointment->date) . '</h5>
    //                                         <div class="activity terques">
    //                                             <span>
    //                                                 <i class="fa fa-stethoscope"></i>
    //                                             </span>
    //                                             <div class="activity-desk">
    //                                                 <div class="panel col-md-6">
    //                                                     <div class="panel-body">
    //                                                         <div class="arrow"></div>
    //                                                         <i class=" fa fa-calendar"></i>
    //                                                         <h4>' . date('d-m-Y', $appointment->date) . '</h4>
    //                                                         <p></p>
    //                                                         <i class=" fa fa-user-md"></i>
    //                                                             <h4>' . $doctor_name . '</h4>
    //                                                                 <p></p>
    //                                                                 <i class=" fa fa-clock-o"></i>
    //                                                             <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
    //                                                     </div>
    //                                                 </div>
    //                                             </div>
    //                                         </div>
    //                                     </div>';
    //     }

    //     foreach ($data['prescriptions'] as $prescription) {
    //         $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
    //         if (!empty($doctor_details)) {
    //             $doctor_name = $doctor_details->name;
    //         } else {
    //             $doctor_name = '';
    //         }
    //         $timeline[$prescription->date + 2] = '<div class="panel-body profile-activity" >
    //                                        <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
    //                                         <h5 class="pull-right">' . date('d-m-Y', $prescription->date) . '</h5>
    //                                         <div class="activity purple">
    //                                             <span>
    //                                                 <i class="fa fa-medkit"></i>
    //                                             </span>
    //                                             <div class="activity-desk">
    //                                                 <div class="panel col-md-6">
    //                                                     <div class="panel-body">
    //                                                         <div class="arrow"></div>
    //                                                         <i class=" fa fa-calendar"></i>
    //                                                         <h4>' . date('d-m-Y', $prescription->date) . '</h4>
    //                                                         <p></p>
    //                                                         <i class=" fa fa-user-md"></i>
    //                                                             <h4>' . $doctor_name . '</h4>
    //                                                                 <a class="btn btn-info btn-xs detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
    //                                                     </div>
    //                                                 </div>
    //                                             </div>
    //                                         </div>
    //                                     </div>';
    //     }

    //     foreach ($data['labs'] as $lab) {

    //         $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
    //         if (!empty($doctor_details)) {
    //             $lab_doctor = $doctor_details->name;
    //         } else {
    //             $lab_doctor = '';
    //         }

    //         $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
    //                                         <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
    //                                         <h5 class="pull-right">' . date('d-m-Y', $lab->date) . '</h5>
    //                                         <div class="activity blue">
    //                                             <span>
    //                                                 <i class="fa fa-flask"></i>
    //                                             </span>
    //                                             <div class="activity-desk">
    //                                                 <div class="panel col-md-6">
    //                                                     <div class="panel-body">
    //                                                         <div class="arrow"></div>
    //                                                         <i class=" fa fa-calendar"></i>
    //                                                         <h4>' . date('d-m-Y', $lab->date) . '</h4>
    //                                                         <p></p>
    //                                                          <i class=" fa fa-user-md"></i>
    //                                                             <h4>' . $lab_doctor . '</h4>
    //                                                                 <a class="btn btn-xs invoicebutton" title="Lab" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
    //                                                     </div>
    //                                                 </div> 
    //                                             </div>
    //                                         </div>
    //                                     </div>';
    //     }

    //     foreach ($data['medical_histories'] as $medical_history) {
    //         $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
    //                                         <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
    //                                         <h5 class="pull-right">' . date('d-m-Y', $medical_history->date) . '</h5>
    //                                         <div class="activity greenn">
    //                                             <span>
    //                                                 <i class="fa fa-file"></i>
    //                                             </span>
    //                                             <div class="activity-desk">
    //                                                 <div class="panel col-md-6">
    //                                                     <div class="panel-body">
    //                                                         <div class="arrow"></div>
    //                                                         <i class=" fa fa-calendar"></i>
    //                                                         <h4>' . date('d-m-Y', $medical_history->date) . '</h4>
    //                                                         <p></p>
    //                                                          <i class=" fa fa-note"></i> 
    //                                                             <p>' . $medical_history->description . '</p>
    //                                                     </div>
    //                                                 </div> 
    //                                             </div>
    //                                         </div>
    //                                     </div>';
    //     }

    //     foreach ($data['patient_materials'] as $patient_material) {
    //         $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
    //                                        <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
    //                                         <h5 class="pull-right">' . date('d-m-Y', $patient_material->date) . '</h5>
    //                                         <div class="activity purplee">
    //                                             <span>
    //                                                 <i class="fa fa-file-o"></i>
    //                                             </span>
    //                                             <div class="activity-desk">
    //                                                 <div class="panel col-md-6">
    //                                                     <div class="panel-body">
    //                                                         <div class="arrow"></div>
    //                                                         <i class=" fa fa-calendar"></i>
    //                                                         <h4>' . date('d-m-Y', $patient_material->date) . ' <a class="pull-right" title="' . lang('download') . '"  href="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
    //                                                              <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
    //                                                     </div>
    //                                                 </div> 
    //                                             </div>
    //                                         </div>
    //                                     </div>';
    //     }

    //     if (!empty($timeline)) {
    //         $data['timeline'] = $timeline;
    //     }
    //     $this->load->view('home/dashboard'); // just the header file
    //     $this->load->view('medical_history', $data);
    //     $this->load->view('home/footer'); // just the footer file
    // }

    function editMedicalHistoryByJason()
    {
        $id = $this->input->get('id');
        $data['medical_history'] = $this->patient_model->getMedicalHistoryById($id);
        $data['patient'] = $this->patient_model->getPatientById($data['medical_history']->patient_id);
        echo json_encode($data);
    }

    function getCaseDetailsByJason()
    {
        $id = $this->input->get('id');
        $data['case'] = $this->patient_model->getMedicalHistoryById($id);
        $patient = $data['case']->patient_id;
        $data['patient'] = $this->patient_model->getPatientById($patient);
        echo json_encode($data);
    }


    function getPatientByAppointmentByDctorId($doctor_id)
    {
        $data = array();
        $appointments = $this->appointment_model->getAppointmentByDoctor($doctor_id);
        foreach ($appointments as $appointment) {
            $patient_exists = $this->patient_model->getPatientById($appointment->patient);
            if (!empty($patient_exists)) {
                $patients[] = $appointment->patient;
            }
        }

        if (!empty($patients)) {
            $patients = array_unique($patients);
        } else {
            $patients = '';
        }

        return $patients;
    }

    function patientMaterial()
    {
        $data = array();
        $id = $this->input->get('patient');
        $data['settings'] = $this->settings_model->getSettings();
        $data['patient'] = $this->patient_model->getPatientById($id);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('patient_material', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function addPatientMaterial()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('patient_id', 'Patient ID', 'required|trim|xss_clean');
        $this->form_validation->set_rules('symptoms', 'Symptoms', 'trim|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', validation_errors());
        } else {
			$title = $this->input->post('title');
			$patient_id = $this->input->post('patient_id');
			$hospital_id = $this->input->post('hospital_id');
			$user_file = $this->input->post('user_file');
			$symptoms = $this->input->post('symptoms');
			$date = time();
			
            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }


            $file_name = $_FILES['user_file']['name'];
            $file_name_pieces = explode('_', $file_name);
            $new_file_name = '';
            $count = 1;
            foreach ($file_name_pieces as $piece) {
                if ($count !== 1) {
                    $piece = ucfirst($piece);
                }

                $new_file_name .= $piece;
                $count++;
            }
            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf|mp4|avi|wmv|mov|ogg",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
               // 'max_height' => "10000",
               // 'max_width' => "10000"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('user_file')) {
                $path = $this->upload->data();
                $user_file = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'title' => $title,
                    'url' => $user_file,
                    'patient' => $patient_id,
                    'symptoms' => $symptoms,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y'),
                );
            } else {
                $data = array();
                $data = array(
                    'date' => $date,
                    'title' => $title,
                    'patient' => $patient_id,
					'symptoms' => $symptoms,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y'),
                );
                $this->session->set_flashdata('feedback', lang('upload_error'));
            }

            $this->patient_model->insertPatientMaterial($data);
            $this->session->set_flashdata('feedback', lang('added'));
        }
		redirect('patient/medical_records');
    }

    function deleteCaseHistory()
    {
        $id = $this->input->get('id');
        $redirect = $this->input->get('redirect');
        $case_history = $this->patient_model->getMedicalHistoryById($id);
        $this->patient_model->deleteMedicalHistory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        if ($redirect == 'case') {
            redirect('patient/caseList');
        } else {
            redirect("patient/MedicalHistory?id=" . $case_history->patient_id);
        }
    }

    function deletePatientMaterial()
    {
        $id = $this->input->get('id');
        $redirect = $this->input->get('redirect');
        $patient_material = $this->patient_model->getPatientMaterialById($id);
        $path = $patient_material->url;
        if (!empty($path)) {
            unlink($path);
        }
        $this->patient_model->deletePatientMaterial($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        if ($redirect == 'documents') {
            redirect('patient/documents');
        } else {
            redirect("patient/MedicalHistory?id=" . $patient_material->patient);
        }
    }

    function delete()
    {
        $data = array();
        $id = $this->input->get('id');

        $patient_hospital_id = $this->patient_model->getPatientById($id)->hospital_id;
        if ($patient_hospital_id != $this->session->userdata('hospital_id')) {
            redirect('home/permission');
        }

        $user_data = $this->db->get_where('patient', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->patient_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('patient');
    }

    function getPatient()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientBysearch($search);
            } else {
                $data['patients'] = $this->patient_model->getPatient();
            }
        } else {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientByLimitBySearch($limit, $start, $search);
            } else {
                $data['patients'] = $this->patient_model->getPatientByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $doctor_id = $this->patient_model->getDoctorIdhere();
        foreach ($data['patients'] as $patient) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = ' <a type="button" class="btn editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }
            
            $InAppVoiceCall = '<a class="btn btn-info" onclick="return confirm(\' Are you sure you want to start a live voice meeting with this patient? Notification will be sent to the Patient phone. \')" title="' . 'In App Voice Call' . '" style="color: #fff;margin-right:5px;" href="'.base_url().'meeting/liveChatApp?roomId='.$patient->id.'-'.$doctor_id.'&type=2" target="_blank"><i class="fa fa-phone"></i> ' . 'In App Voice Call' . '</a>';
            $InAppVideoCall = '<a class="btn btn-info" onclick="return confirm(\' Are you sure you want to start a live video meeting with this patient? Notification will be sent to the Patient phone. \')" title="' . 'In App Video Call' . '" style="color: #fff;margin-right:5px;" href="'.base_url().'meeting/liveChatApp?roomId='.$patient->id.'-'.$doctor_id.'&type=1" target="_blank"><i class="fa fa-video"></i> ' . 'In App Video Call' . '</a>';
            
            $options2 = '<a class="btn detailsbutton" title="' . lang('info') . '" style="color: #fff;" href="patient/patientDetails?id=' . $patient->id . '"><i class="fa fa-info"></i> ' . lang('info') . '</a>';

            $clickToCall = '<a class="btn btn-info" onclick="connectCall(this,\'' . $patient->phone . '\')" title="' . lang('Call') . '" style="color: #fff;margin-right:5px;" href="#"><i class="fa fa-phone"></i> ' . lang('Call') . '</a>';
            $clickToSms = '<a class="btn btn-primary" onclick="showSendSmsModal(this,\'' . $patient->phone . '\')" title="' . lang('SMS') . '" style="color: #fff;margin-right:5px;" href="#"><i class="fa fa-sms"></i> ' . lang('SMS') . '</a>';
            $clickToEmail = '<a class="btn btn-primary" onclick="showSendEmailModal(this,\'' . $patient->email . '\')" title="' . lang('Email') . '" style="color: #fff;" href="#"><i class="fa fa-envelope"></i> ' . lang('Email') . '</a>';

            $options3 = '<a class="btn green" title="' . lang('history') . '" style="color: #fff;" href="patient/medicalHistory?id=' . $patient->id . '"><i class="fa fa-stethoscope"></i> ' . lang('history') . '</a>';

            $options4 = '<a class="btn invoicebutton" title="' . lang('payment') . '" style="color: #fff;" href="finance/patientPaymentHistory?patient=' . $patient->id . '"><i class="fa fa-money-bill-alt"></i> ' . lang('payment') . '</a>';

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                $options5 = '<a class="btn delete_button" title="' . lang('delete') . '" href="patient/delete?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }

            $options6 = ' <a type="button" class="btn detailsbutton inffo" title="' . lang('info') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-info"> </i> ' . lang('info') . '</a>';


            if ($this->ion_auth->in_group(array('admin', 'Doctor'))) {
                $options1 = $InAppVoiceCall.$InAppVideoCall.$clickToCall . $clickToSms . $clickToEmail . $options1;
                $options7 = '<a class="btn green detailsbutton" title="' . lang('instant_meeting') . '" style="color: #fff;" href="meeting/instantLive?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to start a live meeting with this patient? SMS and Email will be sent to the Patient.\');"><i class="fa fa-headphones"></i> ' . lang('start_live') . '</a>';
            } else {
                $options7 = '';
            }


            if ($this->ion_auth->in_group(array('admin'))) {
                $info[] = array(
                    $patient->id,
                    '<a type="button" href="javascript:;" class="historyBtn" data-pid="'.$patient->id.'">'.$patient->name.'</a>',
                    $patient->phone,
                    $this->settings_model->getSettings()->currency . $this->patient_model->getDueBalanceByPatientId($patient->id),
                  $options1 . ' ' . $options6 . ' ' . $options3 . ' ' . $options4 . ' ' . $options5,
                    //  $options6
                );
            }

            if ($this->ion_auth->in_group(array('Accountant', 'Receptionist'))) {
                $info[] = array(
                    $patient->id,
                    $patient->name,
                    $patient->phone,
                    $this->settings_model->getSettings()->currency . $this->patient_model->getDueBalanceByPatientId($patient->id),
                    $options1 . ' ' . $options6 . ' ' . $options4,
                    //  $options2
                );
            }


            if ($this->ion_auth->in_group(array('Laboratorist', 'Nurse', 'Doctor'))) {
                $info[] = array(
                    $patient->id,
                    '<a type="button" href="javascript:;" class="historyBtn" data-pid="'.$patient->id.'">'.$patient->name.'</a>',
                    $patient->phone,
                   // $options1 . ' ' . $options6 . ' ' . $options3,
                      $options6
                );
            }





        }

        if (!empty($data['patients'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('patient')->num_rows(),
                "recordsFiltered" => $this->db->get('patient')->num_rows(),
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

    function getPatientPayments()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientBysearch($search);
            } else {
                $data['patients'] = $this->patient_model->getPatient();
            }
        } else {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientByLimitBySearch($limit, $start, $search);
            } else {
                $data['patients'] = $this->patient_model->getPatientByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();

        foreach ($data['patients'] as $patient) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = ' <a type="button" class="btn editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }

            $options2 = '<a class="btn detailsbutton" title="' . lang('info') . '" style="color: #fff;" href="patient/patientDetails?id=' . $patient->id . '"><i class="fa fa-info"></i> ' . lang('info') . '</a>';

            $options3 = '<a class="btn green" title="' . lang('history') . '" style="color: #fff;" href="patient/medicalHistory?id=' . $patient->id . '"><i class="fa fa-stethoscope"></i> ' . lang('history') . '</a>';

            $options4 = '<a class="btn btn-xs green" title="' . lang('payment') . ' ' . lang('history') . '" style="color: #fff;" href="finance/patientPaymentHistory?patient=' . $patient->id . '"><i class="fa fa-money-bill-alt"></i> ' . lang('payment') . ' ' . lang('history') . '</a>';

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                $options5 = '<a class="btn delete_button" title="' . lang('delete') . '" href="patient/delete?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }

            $due = $this->settings_model->getSettings()->currency . $this->patient_model->getDueBalanceByPatientId($patient->id);

            $info[] = array(
                $patient->id,
                $patient->name,
                $patient->phone,
                $due,
                //  $options1 . ' ' . $options2 . ' ' . $options3 . ' ' . $options4 . ' ' . $options5,
                $options4
            );
        }

        if (!empty($data['patients'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('patient')->num_rows(),
                "recordsFiltered" => $this->db->get('patient')->num_rows(),
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

    function getCaseList()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->patient_model->getMedicalHistoryBySearch($search);
            } else {
                $data['cases'] = $this->patient_model->getMedicalHistory();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->patient_model->getMedicalHistoryByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->patient_model->getMedicalHistoryByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();

        foreach ($data['cases'] as $case) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = ' <a type="button" class="btn btn-info btn-xs btn_width editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"> </i> </a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                $options2 = '<a class="btn btn-info btn-xs btn_width delete_button" title="' . lang('delete') . '" href="patient/deleteCaseHistory?id=' . $case->id . '&redirect=case" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i></a>';
                $options3 = ' <a type="button" class="btn btn-info btn-xs btn_width detailsbutton case" title="' . lang('case') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-file"> </i> </a>';
            }

            if (!empty($case->patient_id)) {
                $patient_info = $this->patient_model->getPatientById($case->patient_id);
                if (!empty($patient_info)) {
                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                } else {
                    $patient_details = $case->patient_name . '</br>' . $case->patient_address . '</br>' . $case->patient_phone . '</br>';
                }
            } else {
                $patient_details = '';
            }

            $info[] = array(
                date('d-m-Y', $case->date),
                $patient_details,
                $case->title,
                $options3 . ' ' . $options1 . ' ' . $options2
                // $options4
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('medical_history')->num_rows(),
                "recordsFiltered" => $this->db->get('medical_history')->num_rows(),
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

    function getDocuments()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['documents'] = $this->patient_model->getDocumentBySearch($search);
            } else {
                $data['documents'] = $this->patient_model->getPatientMaterial();
            }
        } else {
            if (!empty($search)) {
                $data['documents'] = $this->patient_model->getDocumentByLimitBySearch($limit, $start, $search);
            } else {
                $data['documents'] = $this->patient_model->getDocumentByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();

        foreach ($data['documents'] as $document) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = '<a class="btn btn-info btn-xs" href="' . $document->url . '" download> ' . lang('download') . ' </a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
                $options2 = '<a class="btn btn-info btn-xs delete_button" href="patient/deletePatientMaterial?id=' . $document->id . '&redirect=documents"onclick="return confirm(\'You want to delete the item??\');"> X </a>';
            }

            if (!empty($document->patient)) {
                $patient_info = $this->patient_model->getPatientById($document->patient);
                if (!empty($patient_info)) {
                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                } else {
                    $patient_details = $document->patient_name . '</br>' . $document->patient_address . '</br>' . $document->patient_phone . '</br>';
                }
            } else {
                $patient_details = '';
            }

            $info[] = array(
                date('d-m-y', $document->date),
                $patient_details,
                $document->title,
                '<a class="example-image-link" href="' . $document->url . '" data-lightbox="example-1" data-title="' . $document->title . '">' . '<img class="example-image" src="' . $document->url . '" width="100px" height="100px"alt="image-1">' . '</a>',
                $options1 . ' ' . $options2
                // $options4
            );
        }

        if (!empty($data['documents'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('patient_material')->num_rows(),
                "recordsFiltered" => $this->db->get('patient_material')->num_rows(),
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }







    function getMedicalHistoryDashboardByJason()
    {
        $data = array();

        $from_where = $this->input->get('from_where');
        $id = $this->input->get('id');

        if (!empty($from_where)) {
            $this->db->where('id', $id);
            $id = $this->db->get('appointment')->row()->patient;
        }


        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
        }

        $data = array();


        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
        }


        $patient_hospital_id = $this->patient_model->getPatientById($id)->hospital_id;
        if ($patient_hospital_id != $this->session->userdata('hospital_id')) {
            redirect('home/permission');
        }
        //  $data['template'] = $this->bodycharttemplate_model->getBodychart();
        //  $data['treatment_notes'] = $this->patient_model->getTreatment_notes($id);
        //  $data['patient_add_forms'] = $this->patientfromtemplate_model->getPatientForm($id);
        // $data['templateforms'] = $this->patientfromtemplate_model->getPatientFromTemplate();

        $data['patient'] = $this->patient_model->getPatientById($id);
        $data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient']->id);
         $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
         $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id);
        $data['labs'] = $this->lab_model->getLabByPatientId($id);
       $data['beds'] = $this->bed_model->getBedAllotmentsByPatientId($id);
        $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($id);
         $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id);


        foreach ($data['appointments'] as $appointment) {
            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$prescription->date + 2] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $prescription->date) . '</h5>
                                            <div class="activity purple">
                                                <span>
                                                    <i class="fa fa-medkit"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $prescription->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <a class="btn btn-info btn-xs detailsbutton timelineBtn" title="View" data-ref="prescription/viewPrescription?type=1&id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['labs'] as $lab) {

            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = '';
            }

            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab_doctor . '</h4>
                                                                    <a class="btn btn-xs invoicebutton timelineBtn" title="Lab" style="color: #fff;" data-ref="lab/invoice?type=1&id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['medical_histories'] as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['patient_materials'] as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $patient_material->date) . ' <a class="pull-right timelineBtn" title="' . lang('download') . '"  data-ref="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }

        $this->load->view('medical_history_popup', $data);
    }

















    function getMedicalHistoryByJason()
    {
        $data = array();

        $from_where = $this->input->get('from_where');
        $id = $this->input->get('id');

        if (!empty($from_where)) {
            $this->db->where('id', $id);
            $id = $this->db->get('appointment')->row()->patient;
        }


        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $id = $this->patient_model->getPatientByIonUserId($patient_ion_id)->id;
        }

        $patient = $this->patient_model->getPatientById($id);
        $appointments = $this->appointment_model->getAppointmentByPatient($patient->id);
        $patients = $this->patient_model->getPatient();
        $doctors = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id);
        $beds = $this->bed_model->getBedAllotmentsByPatientId($id);
        //  $orders = $this->order_model->getOrderByPatientId($id);
        $labs = $this->lab_model->getLabByPatientId($id);
        $medical_histories = $this->patient_model->getMedicalHistoryByPatientId($id);
        $patient_materials = $this->patient_model->getPatientMaterialByPatientId($id);



        /////////////////////////MHZ////////////////////////////
        $treatment_notes =  $this->patient_model->getTreatment_notes($id);
        $all_body_chart ='';



        foreach ($treatment_notes as $key=>$item) {
            $doctor_details = $this->doctor_model->getDoctorByIonUserId($item->doctor);
            if (!empty($doctor_details)) {
                $appointment_doctor = $doctor_details->name;
            } else {
                $appointment_doctor = '';
            }

            $all_body_chart .= '<tr class="">
                                            <td>'.date('d-m-Y', $item->add_date).'</td>
                                            <td>'. $appointment_doctor .' </td>
                                            <td>'.$item->presenting_complaint.'</td>';
            if (!$this->ion_auth->in_group('Patient')) {
                $all_body_chart .= '<td class="no-print"><button type="button" class="btn btn-info btn-xs btn_width viewTreatmentButton" title="'.lang('view').'" data-toggle="modal" data-id="'.$item->id.'"><i class="fa fa-images"></i> </button> </td>';
                                             }
            $all_body_chart .= '</tr>';
        }


/////////////////////////////////end Body chart///////////////////////////////////////////////////////////////
        $patient_add_forms = $this->patientfromtemplate_model->getPatientForm($id);
  $all_patintForm =  '';
  foreach ($patient_add_forms as $item) {  $submited_date = ( $item->answared == 'Yes')? date('m/d/Y', $item->submited_date): '';
                                              $all_patintForm .= '<tr class=""> 
                                                    <td><a href="'.base_url('pf/?token='.$item->token).'" target="_blank">'.$item->template.'</a> </td>
                                                    <td>'.date('m/d/Y', $item->created_at).'</td>
                                                    <td>'.$item->completed.'</td>

                                                    <td>'. $submited_date .'</td>
                                                    <td align="text-right">';

                                                      if($item->answared == 'Yes'){
                                                          $all_patintForm .= '<button class="btn btn-sm btn-default ansBtn" data-token="'.$item->token.'">Answer</button>';
                                                        }
      $all_patintForm .= ' 
                                                    </td>
                                                </tr>';
                                             }
///////////////////end patient form MHZ///////////////////////////////////////////////
        foreach ($appointments as $appointment) {

            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }

            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }


        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$prescription->date + 6] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $prescription->date) . '</h5>
                                            <div class="activity purple">
                                                <span>
                                                    <i class="fa fa-medkit"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $prescription->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <a class="btn btn-info btn-xs detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }
        foreach ($labs as $lab) {

            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = '';
            }

            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab_doctor . '</h4>
                                                                    <a class="btn btn-xs invoicebutton" title="Lab" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($medical_histories as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($patient_materials as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d-m-Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d-m-Y', $patient_material->date) . ' <a class="pull-right" title="' . lang('download') . '"  href="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }


        if (!empty($timeline)) {
            krsort($timeline);
            $timeline_value = '';
            foreach ($timeline as $key => $value) {
                $timeline_value .= $value;
            }
        }


        $all_appointments = '';
        foreach ($appointments as $appointment) {

            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $appointment_doctor = $doctor_details->name;
            } else {
                $appointment_doctor = "";
            }


            $patient_appointments = '<tr class = "">

        <td>' . date("d-m-Y", $appointment->date) . '
        </td>
        <td>' . $appointment->time_slot . '</td>
        <td>'
                . $appointment_doctor . '
        </td>
        <td>' . $appointment->status . '</td>
        <td><a type="button" href="appointment/editAppointment?id=' . $appointment->id . '" class="btn btn-info btn-xs btn_width" title="Edit" data-id="' . $appointment->id . '">' . lang('edit') . '</a></td>

        </tr>';

            $all_appointments .= $patient_appointments;
        }


        if (empty($all_appointments)) {
            $all_appointments = '';
        }


        $all_case = '';

        foreach ($medical_histories as $medical_history) {
            $patient_case = ' <tr class="">
                                                    <td>' . date("d-m-Y", $medical_history->date) . '</td>
                                                    <td>' . $medical_history->title . '</td>
                                                    <td>' . $medical_history->description . '</td>
                                                </tr>';

            $all_case .= $patient_case;
        }


        if (empty($all_case)) {
            $all_case = '';
        }
        $all_prescription = '';

        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $prescription_doctor = $doctor_details->name;
            } else {
                $prescription_doctor = '';
            }
            $medicinelist = '';
            if (!empty($prescription->medicine)) {
                $medicine = explode('###', $prescription->medicine);

                foreach ($medicine as $key => $value) {
                    $medicine_id = explode('***', $value);
                    $medicine_details = $this->medicine_model->getMedicineById($medicine_id[0]);
                    if (!empty($medicine_details)) {
                        $medicine_name_with_dosage = $medicine_details->name . ' -' . $medicine_id[1];
                        $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                        rtrim($medicine_name_with_dosage, ',');
                        $medicinelist .= '<p>' . $medicine_name_with_dosage . '</p>';
                    }
                }
            } else {
                $medicinelist = '';
            }

            $option1 = '<a class="btn btn-info btn-xs btn_width" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye">' . lang('view') . '</i></a>';
            $prescription_case = ' <tr class="">
                                                    <td>' . date('m/d/Y', $prescription->date) . '</td>
                                                    <td>' . $prescription_doctor . '</td>
                                                    <td>' . $medicinelist . '</td>
                                                         <td>' . $option1 . '</td>
                                                </tr>';

            $all_prescription .= $prescription_case;
        }


        if (empty($all_prescription)) {
            $all_prescription = '';
        }


        $all_lab = '';

        foreach ($labs as $lab) {
            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = "";
            }
            $option1 = '<a class="btn btn-info btn-xs btn_width" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-eye">' . lang('report') . '</i></a>';
            $lab_class = ' <tr class="">
                                                    <td>' . $lab->id . '</td>
                                                    <td>' . date("m/d/Y", $lab->date) . '</td>
                                                    <td>' . $lab_doctor . '</td>
                                                         <td>' . $option1 . '</td>
                                                </tr>';

            $all_lab .= $lab_class;
        }


        if (empty($all_lab)) {
            $all_lab = '';
        }
        $all_bed = '';

        foreach ($beds as $bed) {


            $bed_case = ' <tr class="">
                                                    <td>' . $bed->bed_id . '</td>
                                                    <td>' . $bed->a_time . '</td>
                                                    <td>' . $bed->d_time . '</td>
                                                         
                                                </tr>';

            $all_bed .= $bed_case;
        }


        if (empty($all_bed)) {
            $all_bed = '';
        }


        $all_material = '';
        foreach ($patient_materials as $patient_material) {

            if (!empty($patient_material->title)) {
                $patient_documents = $patient_material->title;
            }


            $patient_material = '
            
                                            <div class="panel col-md-3"  style="height: 200px; margin-right: 10px; margin-bottom: 36px; background: #f1f1f1; padding: 34px;">

                                                <div class="post-info">
                                                    <img src="' . $patient_material->url . '" height="100" width="100">
                                                </div>
                                                <div class="post-info">
                                                    
                                                ' . $patient_documents . '

                                                </div>
                                                <p></p>
                                                <div class="post-info">
                                                    <a class="btn btn-info btn-xs btn_width" href="' . $patient_material->url . '" download> ' . lang("download") . ' </a>
                                                    <a class="btn btn-info btn-xs btn_width" title="' . lang("delete") . '" href="patient/deletePatientMaterial?id=' . $patient_material->id . '"onclick="return confirm("Are you sure you want to delete this item?");"> X </a>
                                                </div>

                                                <hr>

                                            </div>';
            $all_material .= $patient_material;
        }

        if (empty($all_material)) {
            $all_material = ' ';
        }


        if (!empty($patient->img_url)) {
            $profile_image = '<a href="#">
                            <img src="' . $patient->img_url . '" alt="">
                        </a>';
        } else {
            $profile_image = '';
        }


        $data['view'] = '
        <section class="col-md-3">
            <header class="panel-heading clearfix">
                <div class="">
                    ' . lang("patient") . ' ' . lang("info") . ' 
                </div>

            </header> 




            <aside class="profile-nav">
                <section class="">
                    <div class="user-heading round">
                        ' . $profile_image . '
                        <h1>' . $patient->name . '</h1>
                        <p> ' . $patient->email . ' </p>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"> ' . lang("patient") . ' ' . lang("name") . '<span class="label pull-right r-activity">' . $patient->name . '</span></li>
                        <li>  ' . lang("patient_id") . ' <span class="label pull-right r-activity">' . $patient->id . '</span></li>
                        <li>  ' . lang("phone") . '<span class="label pull-right r-activity">' . $patient->phone . '</span></li>
                        <li>  ' . lang("email") . '<span class="label pull-right r-activity">' . $patient->email . '</span></li>
                        <li>  ' . lang("gender") . '<span class="label pull-right r-activity">' . $patient->sex . '</span></li>
                        <li>  ' . lang("birth_date") . '<span class="label pull-right r-activity">' . $patient->birthdate . '</span></li>
                        <li style="height: 200px;">  ' . lang("address") . '<span class="pull-right r-activity" style="height: 200px;">' . $patient->address . '</span></li>
                    </ul>

                </section>
            </aside>


        </section>





        <section class="col-md-9">
            <header class="panel-heading clearfix">
                <div class="col-md-7">
                    ' . lang("history") . ' | ' . $patient->name . '
                </div>

            </header>

            <section class="panel-body">   
                <header class="panel-heading tab-bg-dark-navy-blueee">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#appointments">' . lang("appointments") . '</a>
                        </li>
                      
                         <li class="">
                            <a data-toggle="tab" href="#prescription">' . lang("prescription") . '</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#bodycharteditor">Medical Notes</a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#patintForm">Patient Symptoms</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#lab">' . lang("lab") . '</a>
                        </li>
                        
                        <li class="">
                            <a data-toggle="tab" href="#profile">' . lang("documents") . '</a>
                        </li>
                         <li class="">
                            <a data-toggle="tab" href="#bed">' . lang("bed") . '</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#timeline">' . lang("timeline") . '</a> 
                        </li>
                    </ul>
                </header>
                <div class="panel">
                    <div class="tab-content">
                        <div id="appointments" class="tab-pane active">
                            <div class="">

                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("time_slot") . '</th>
                                                <th>' . lang("doctor") . '</th>
                                                <th>' . lang("status") . '</th>
                                                <th>' . lang("option") . '</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $all_appointments . '
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="home" class="tab-pane">
                            <div class="">



                                <div class="adv-table editable-table ">


                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("title") . '</th>
                                                <th>' . lang("description") . '</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $all_case . '
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        <div  id="bodycharteditor" class="tab-pane"> 
           
                            <div class="adv-table editable-table  table-responsive">
                                <table class="table table-striped table-hover table-bordered" id="">
                                    <thead>
                                    <tr>
                                        <th>' . lang("date") . '</th>
                                        <th>' . lang("doctor") . '</th>
                                        <th>Medical Notes</th>
                                        <th></th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                           '. $all_body_chart .'
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        
                        
                        <div id="patintForm" class="tab-pane">
                       
                                    <div class="adv-table editable-table table-responsive ">
                                        <table class="table table-striped table-hover table-bordered" id="">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Created Date</th>
                                                <th>Completed</th>
                                                <th>Submitted</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>    '. $all_patintForm .'

                                            </tbody>
                                        </table>
                                    </div>
                        </div>
                        
            
                                    <div id="prescription" class="tab-pane">
                                           <div class="">



                                       <div class="adv-table editable-table ">


                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("doctor") . '</th>
                                                <th>' . lang("medicine") . '</th>
                                                <th>' . lang("options") . '</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $all_prescription . '
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                        <div id="lab" class="tab-pane"> <div class="">
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("id") . '</th>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("doctor") . '</th>
                                                <th>' . lang("options") . '</th>
                                            </tr>
                                        </thead>
                                        <tbody>'
            . $all_lab .
            '</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                           <div id="bed" class="tab-pane"> <div class="">
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("bed_id") . '</th>
                                                <th>' . lang("alloted_time") . '</th>
                                                <th>' . lang("discharge_time") . '</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>'
            . $all_bed .
            '</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div id="profile" class="tab-pane"> <div class="">

                                <div class="adv-table editable-table ">
                                    <div class="">
                                        ' . $all_material . '
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="timeline" class="tab-pane"> 
                            <div class="">
                                <div class="">
                                    <section class="panel ">
                                        <header class="panel-heading">
                                            Timeline
                                        </header>


                                        ' . $timeline_value . '

                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</section>



</section>';


        echo json_encode($data);
    }

    public function getPatientinfo()
    {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->patient_model->getPatientInfo($searchTerm);

        echo json_encode($response);
    }

    public function getPatientinfoWithAddNewOption()
    {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->patient_model->getPatientinfoWithAddNewOption($searchTerm);

        echo json_encode($response);
    }

}

/* End of file patient.php */
/* Location: ./application/modules/patient/controllers/patient.php */
    