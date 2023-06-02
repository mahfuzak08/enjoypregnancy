<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\ClientToken;
use Twilio\Jwt\Grants\VoiceGrant;

class Doctor extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bodycharttemplate/bodycharttemplate_model');
        $this->load->model('doctor_model');
        $this->load->model('cms_model');
        $this->load->model('frontend/frontend_model');
        $this->load->model('auth/general_model');
        $this->load->model('department/department_model');
        $this->load->model('appointment/appointment_model');
        $this->load->model('patient/patient_model');
		$this->load->model('medicine/medicine_model');
        $this->load->model('prescription/prescription_model');
        $this->load->model('schedule/schedule_model');
        $this->load->module('patient');
        $this->load->module('sms');
        if (!$this->ion_auth->in_group(array('admin', 'Accountant', 'Doctor', 'Receptionist', 'Nurse', 'Laboratorist', 'Patient'))) {
            redirect('home/permission');
        }
    }
	
	public function dashboard()
	{
		$data = array();
		$_SESSION['template'] = "doccure";
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
		$data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		if($data['doctor_data']->is_approved==0)
        {
            redirect('profile');
        }
		elseif($data['doctor_data']->is_approved==2)
        {
            redirect('doctor/profile');
        }
		
		$data['total_patient'] = $this->doctor_model->getTotalPatient($data['doctor_data']->id);
		$data['today_patient'] = $this->doctor_model->getTotalPatient($data['doctor_data']->id, true);
		$data['appointments'] = $this->appointment_model->getAppointmentByDoctor($data['doctor_data']->id);
		$data['home_appointment_requests'] = $this->doctor_model->getHomeAppointmentsByDoctor($data['doctor_data']->id);
        
		$data['chatpage'] = false;
		$data['page_title'] = 'Dashboard';
		$this->load->view('partial/_header', $data);
        $this->load->view('doctor-home', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function viewInvoice($id)
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		$data['invoice'] = $this->frontend_model->get_app_invoice($id);
		$data['chatpage'] = false;
		$data['page_title'] = 'Invoice';
		$this->load->view('partial/_header', $data);
        $this->load->view('patient/appointment_invoice', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function appointments()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
		$data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		
		$data['appointments'] = $this->appointment_model->getAppointmentByDoctor($data['doctor_data']->id);
        
		$data['chatpage'] = false;
		$data['page_title'] = 'Appointments';
		$this->load->view('partial/_header', $data);
        $this->load->view('appointments', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function my_patients()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
		$data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		
		$data['patient_lists'] = $this->doctor_model->getMyPatient($data['doctor_data']->id);
        
		$data['chatpage'] = false;
		$data['page_title'] = 'My Patients';
		$this->load->view('partial/_header', $data);
        $this->load->view('my_patients', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function accounts()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		$data['acc_info'] = $this->payment_model->get_account_info($data['doctor_data']->id, 'Doctor');
		
		$data['date_from'] = '';
		$data['date_to'] = '';
		if(! empty($this->input->post('date_from'))){
			$data['date_from'] = $this->input->post('date_from').' 00:00:01';
			$data['date_to'] = $this->input->post('date_to'). ' 23:59:59';
		}
		$arg = array(
			'id' => $data['doctor_data']->id, 
			'type' => 'doctor',
			'fdate' => $data['date_from'], 
			'tdate' => $data['date_to']
		);
		$data['payment_history'] = $this->payment_model->get_trans_history($arg);
		$data['balance'] = $this->payment_model->get_summary($arg);
		
		$data['chatpage'] = false;
		$data['page_title'] = 'Accounts';
		$this->load->view('partial/_header', $data);
        $this->load->view('doctor_account', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	function schedule_timing()
	{
		$data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		$data['schedules'] = $this->schedule_model->getSlotByDoctorId($data['doctor_data']->id);
		$data['holidays'] = $this->schedule_model->getHolidaysByDoctor($data['doctor_data']->id);
		
		$data['chatpage'] = false;
		$data['page_title'] = 'Schedule Timing';
		$this->load->view('partial/_header', $data);
        $this->load->view('schedule_timing', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	function prescriptions()
	{
		$data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		$data['prescriptions'] = $this->prescription_model->getPrescriptionByDoctorId($data['doctor_data']->id);
		
		$data['chatpage'] = false;
		$data['page_title'] = 'Prescriptions';
		$this->load->view('partial/_header', $data);
        $this->load->view('prescriptions', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function openPrescriptionForm() {
		if (!$this->ion_auth->in_group(array('admin', 'Doctor'))) {
            redirect('home/permission');
        }

        $data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		
		$data['chatpage'] = false;
		$data['page_title'] = 'Prescriptions';
		$this->load->view('partial/_header', $data);
        $this->load->view('add_new_prescription_view', $data);
        $this->load->view('partial/_footer', $data);
	}
	// public function openPrescriptionForm() {
		// $id = $_GET['id'];
        // if (!$this->ion_auth->in_group(array('admin', 'Doctor'))) {
            // redirect('home/permission');
        // }
		
        // $data = array();
        // $data['settings'] = $this->settings_model->getSettings();
		// $doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		// $data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		// $data['medicines'] = $this->medicine_model->getMedicine();
        // $data['patients'] = $this->patient_model->getPatient();
        
		// $this->load->view('prescription_form', $data);
    // }
	
	function viewPrescription() {
		$data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		
        $id = $this->input->get('id');

        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);



        if (!empty($data['prescription']->hospital_id)) {
            if ($data['prescription']->hospital_id != $this->session->userdata('hospital_id')) {
                $this->load->view('home/permission');
            } else {
                $data['settings'] = $this->settings_model->getSettings();

                if($this->input->get('type') == 1) 
					$this->load->view('home/css', $data);
				else  
					$this->load->view('partial/_header', $data); // just the header file

                $this->load->view('prescription_view', $data);
                $this->load->view('partial/_footer', $data); // just the header file

            }

        } else {

            $this->load->view('home/permission');

        }

    }
	
	function delete_prescription() {

        $id = $this->input->get('id');

        $admin = $this->input->get('admin');

        $patient = $this->input->get('patient');

        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);

        if (!empty($data['prescription']->hospital_id)) {

            if ($data['prescription']->hospital_id != $this->session->userdata('hospital_id')) {

                $this->load->view('home/permission');

            } else {
                $this->prescription_model->deletePrescription($id);
                $this->session->set_flashdata('feedback', lang('deleted'));
                redirect('doctor/prescriptions');
            }
        } else {
            $this->load->view('home/permission');
        }

    }
	
	function bodycharttemplate()
    {
		$data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		
		$data['template'] = $this->bodycharttemplate_model->getBodychart();
		$data['chatpage'] = false;
		$data['page_title']="Body Chart Template";
		
		$this->load->view('partial/_header', $data);
        $this->load->view('bodychart', $data);
		// $this->load->view('bodycharttemplate/templatelist_view', $data);
        $this->load->view('partial/_footer', $data);
    }
	
	function blogs()
    {
		$data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		
		$data['all_posts'] = $this->cms_model->get_all_posts($data['doctor_data']->id);
		$data['chatpage'] = false;
		$data['page_title']="Blogs";
		
		$this->load->view('partial/_header', $data);
        $this->load->view('view_posts', $data);
        $this->load->view('partial/_footer', $data);
    }
	
	public function add_new_blog()
    {  
		$data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		$data['blogs_category'] = $this->frontend_model->getAllBlogsCategory();
		
		$data['chatpage'] = false;
		$data['page_title']="Add New Post";
		$data['page_link']="Add New Post";
		$this->load->view('partial/_header', $data);
        $this->load->view('add_new_post', $data);
        $this->load->view('partial/_footer', $data);
    }
	
	public function edit_post($post_id)
    {  
		$data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		
		$data['pid'] = $post_id;
		$data['edit'] = $this->cms_model->get_post_data($post_id);
		$data['blogs_category'] = $this->frontend_model->getAllBlogsCategory();
		
		$data['chatpage'] = false;
		$data['page_title']="Edit Post";
		$this->load->view('partial/_header', $data);
		$this->load->view('add_new_post' , $data);
		$this->load->view('partial/_footer', $data);
    }
	
	function profile()
	{
		$data = array();
        $data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		$data['speciality'] = $this->general_model->getSpeciality();
		$data['countries'] = $this->general_model->getCountry();
		
		$data['chatpage'] = false;
		$data['page_title'] = 'Profile';
		$this->load->view('partial/_header', $data);
        $this->load->view('doctor_profile', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	public function change_password()
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$doctor_ion_id = $data['user_id'] = $this->ion_auth->get_user_id();
		$data['doctor_data'] = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id);
		
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

    public function index() {
        
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['departments'] = $this->department_model->getDepartment();
        $data['speciality'] = $this->general_model->getSpeciality();
        $data['countires'] = $this->frontend_model->getCounries();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('doctor', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data = array();
        $data['departments'] = $this->department_model->getDepartment();
        $data['speciality'] = $this->general_model->getSpeciality();
        $data['countires'] = $this->frontend_model->getCounries();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        
        if (empty($id)) {
            $limit = $this->doctor_model->getLimit();
            if ($limit <= 0) {
                $this->session->set_flashdata('feedback', lang('doctor_limit_exceed'));
                redirect('doctor');
            }
        }        
        
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $department = $this->input->post('department');
        $profile = $this->input->post('profile');
        $country = $this->input->post('country');
        $city = $this->input->post('city');

        $urgent_care = $this->input->post('urgent_care'); 
        $doctor_type = $this->input->post('doctor_type');    
        // exit;
        if($urgent_care=="")
        {
            $urgent_care = 0;
        }
        $home_visit = $this->input->post('home_visit');
        if($home_visit=="")
        {
            $home_visit = 0;
        }
        $services = $this->input->post('services');
        $specialization = $this->input->post('specialization');

        $gender = $this->input->post('gender');
        $date_of_birth = $this->input->post('date_of_birth');

        $about_me = $this->input->post('about_me');

        $address = json_encode($this->input->post('address'));
        $state_province = $this->input->post('state_province');
        $postal_code = $this->input->post('postal_code');

        $pricing = $this->input->post('pricing');
        if($pricing=='cust_price')
        {
            $pricing = $this->input->post('cust_price');
        }
        

        $urgent_fee = $this->input->post('urgent_fee');
        $home_fee = $this->input->post('home_fee');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Address Field   
        // $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[1]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[1]|max_length[50]|xss_clean');
        // Validating Department Field   
        $this->form_validation->set_rules('department', 'Department', 'trim|min_length[1]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('profile', 'Profile', 'trim|required|min_length[1]|max_length[50]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['departments'] = $this->department_model->getDepartment();
                $data['doctor'] = $this->doctor_model->getDoctorById($id);
                $data['speciality'] = $this->general_model->getSpeciality();
                $data['countires'] = $this->frontend_model->getCounries();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['departments'] = $this->department_model->getDepartment();
                $data['speciality'] = $this->general_model->getSpeciality();
                $data['countires'] = $this->frontend_model->getCounries();
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
                'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "1768",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                'img_url' => $img_url,
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'phone' => $phone,
                'department' => $department,
                'profile' => $profile,
                'country' => $country,
                'city' => $city,
                'doctor_type' => $doctor_type,
                'home_visit_status' => $home_visit,
                'urgent_care_status' => $urgent_care,
                'state_province' => $state_province,
                'postal_code' => $postal_code,
                'gender' => $gender,
                'date_of_birth' => $date_of_birth,
                'about_me' => $about_me,            
                'pricing' => $pricing,            
                'urgent_fee' => $urgent_fee,            
                'home_fee' => $home_fee,            
                'services' => $services,            
                'specialization' => $specialization
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'phone' => $phone,
                'department' => $department,
                'profile' => $profile,
                'country' => $country,
                'city' => $city,
                'doctor_type' => $doctor_type,
                'home_visit_status' => $home_visit,
                'urgent_care_status' => $urgent_care,
                'state_province' => $state_province,
                'postal_code' => $postal_code,
                'gender' => $gender,
                'date_of_birth' => $date_of_birth,
                'about_me' => $about_me,            
                'pricing' => $pricing,            
                'urgent_fee' => $urgent_fee,            
                'home_fee' => $home_fee,            
                'services' => $services,            
                'specialization' => $specialization
                );
            }
            
        // identity doc Haseen
        $identitydoc = $_FILES['identitydoc']['name'];
        $doctor_lic_doc = $_FILES['doctor_lic_doc']['name'];
        
        $file_name_pieces1 = explode('_', $identitydoc);
        $new_file_name1 = '';
        $count1 = 1;
        foreach ($file_name_pieces1 as $piece1) {
            if ($count1 !== 1) {
                $piece1 = ucfirst($piece1);
            }
            $new_file_name1 .= $piece1;
            $count1++;
        }
        $config1 = array(
            'file_name' => $new_file_name1,
            'upload_path' => "./uploads/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => False,
            'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "1768",
            'max_width' => "2024"
        );
        $this->load->library('Upload', $config1);
        $this->upload->initialize($config1);
        
        if ($this->upload->do_upload('identitydoc')) {
            $path1 = $this->upload->data();
            $img_url1 = "uploads/" . $path1['file_name'];
            $data['identitydoc'] = $img_url1;
        } else {
            // $data['identitydoc'] = "";
        }
        $file_name_pieces2 = explode('_', $doctor_lic_doc);
        $new_file_name2 = '';
        $count2 = 1;
        foreach ($file_name_pieces2 as $piece2) {
            if ($count2 !== 1) {
                $piece2 = ucfirst($piece2);
            }
            $new_file_name2 .= $piece2;
            $count2++;
        }
        $config2 = array(
            'file_name' => $new_file_name2,
            'upload_path' => "./uploads/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => False,
            'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "1768",
            'max_width' => "2024"
        );
        $this->load->library('Upload', $config2);
        $this->upload->initialize($config2);
        
        if ($this->upload->do_upload('doctor_lic_doc')) {
            $path1 = $this->upload->data();
            $img_url1 = "uploads/" . $path1['file_name'];
            $data['doctor_lic_doc'] = $img_url1;
        } else {
            // $data['doctor_lic_doc'] = "";
        }
        // end here
            
            $username = $this->input->post('name');
            if (empty($id)) {     // Adding New Doctor
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                    redirect('doctor/addNewView');
                } else {
                    $dfg = 4;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                    $this->doctor_model->insertDoctor($data);
                    $doctor_user_id = $this->db->get_where('doctor', array('email' => $email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->doctor_model->updateDoctor($doctor_user_id, $id_info);
                    $this->hospital_model->addHospitalIdToIonUser($ion_user_id, $this->hospital_id);

                    //sms
                    $set['settings'] = $this->settings_model->getSettings();
                    $autosms = $this->sms_model->getAutoSmsByType('doctor');
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
                        'department' => $department,
                        'company' => $set['settings']->system_vendor
                    );

                    if ($autosms->status == 'Active') {
                        $messageprint = $this->parser->parse_string($message, $data1);
                        $data2[] = array($to => $messageprint);
                        $this->sms->sendSms($to, $message, $data2);
                    }
                    //end
                    //email

                    $autoemail = $this->email_model->getAutoEmailByType('doctor');
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
            } else { // Updating Doctor
                $ion_user_id = $this->db->get_where('doctor', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->doctor_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->doctor_model->updateDoctor($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('doctor');
        }
    }

    function editDoctor() {
        $data = array();
        $data['departments'] = $this->department_model->getDepartment();
        $id = $this->input->get('id');
        $data['doctor'] = $this->doctor_model->getDoctorById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function details() {

        $data = array();
		$_SESSION['template'] = "old";
        if ($this->ion_auth->in_group(array('Doctor'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $id = $this->doctor_model->getDoctorByIonUserId($doctor_ion_id)->id;
        } else {
            redirect('home');
        }

        $data['template'] = $this->bodycharttemplate_model->getBodychart();
        $data['doctor'] = $this->doctor_model->getDoctorById($id);
        $data['todays_appointments'] = $this->appointment_model->getAppointmentByDoctorByToday($id);
        $data['appointments'] = $this->appointment_model->getAppointmentByDoctor($id);
        $data['patients'] = $this->patient_model->getPatient();
        $data['appointment_patients'] = $this->patient->getPatientByAppointmentByDctorId($id);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescriptionByDoctorId($id);
        $data['holidays'] = $this->schedule_model->getHolidaysByDoctor($id);
        $data['schedules'] = $this->schedule_model->getScheduleByDoctor($id);
        $doc_data = $data['doctor'];
        if($doc_data->is_approved==0 or $doc_data->is_approved==2)
        {
            // $this->session->set_flashdata(,);
            redirect('profile');
        }
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editDoctorByJason() {
        $id = $this->input->get('id');
        $data['doctor'] = $this->doctor_model->getDoctorById($id);
        echo json_encode($data);
    }

    function delete() {

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('doctor', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->doctor_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('doctor');
    }

    function getDoctor() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];


        if ($limit == -1) {
            if (!empty($search)) {
                $data['doctors'] = $this->doctor_model->getDoctorBysearch($search);
            } else {
                $data['doctors'] = $this->doctor_model->getDoctor();
            }
        } else {
            if (!empty($search)) {
                $data['doctors'] = $this->doctor_model->getDoctorByLimitBySearch($limit, $start, $search);
            } else {
                $data['doctors'] = $this->doctor_model->getDoctorByLimit($limit, $start);
            }
        }
        //  $data['doctors'] = $this->doctor_model->getDoctor();
        $admin_id =  $this->ion_auth->get_user_id();

        foreach ($data['doctors'] as $doctor) {
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) {
                $options1 = '<a type="button" class="btn btn-info btn-xs btn_width editbutton" title="' . lang('edit') . '" data-toggle="modal" data-id="' . $doctor->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
                //   $options1 = '<a class="btn btn-info btn-xs btn_width" title="' . lang('edit') . '" href="doctor/editDoctor?id='.$doctor->id.'"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }
            $options2 = '<a class="btn btn-info btn-xs detailsbutton" title="' . lang('appointments') . '"  href="appointment/getAppointmentByDoctorId?id=' . $doctor->id . '"> <i class="fa fa-calendar"> </i> ' . lang('appointments') . '</a>';
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) {
                $options3 = '<a class="btn btn-info btn-xs btn_width delete_button" title="' . lang('delete') . '" href="doctor/delete?id=' . $doctor->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            }
            if ($this->ion_auth->in_group(array('admin' ))) {
                $InAppVoiceCall = '<a class="btn btn-info" onclick="return confirm(\' Are you sure you want to start a live voice meeting with this patient? Notification will be sent to the Patient phone. \')" title="' . 'In App Voice Call' . '" style="color: #fff;margin-right:5px;" href="' . base_url() . 'meeting/liveChatAdminDoctorApp?roomId=' . $doctor->id . '-' . $admin_id . '&type=2" target="_blank"><i class="fa fa-phone"></i> ' . 'In App Voice Call' . '</a>';
                $InAppVideoCall = '<a class="btn btn-info" onclick="return confirm(\' Are you sure you want to start a live video meeting with this patient? Notification will be sent to the Patient phone. \')" title="' . 'In App Video Call' . '" style="color: #fff;margin-right:5px;" href="' . base_url() . 'meeting/liveChatAdminDoctorApp?roomId=' . $doctor->id . '-' . $admin_id . '&type=1" target="_blank"><i class="fa fa-video"></i> ' . 'In App Video Call' . '</a>';
                $clickToCall = '<a class="btn btn-info" onclick="connectCall(this,\'' . $doctor->phone . '\')" title="' . lang('Call') . '" style="color: #fff;margin-right:5px;" href="#"><i class="fa fa-phone"></i> ' . lang('Call') . '</a>';
                $clickToSms = '<a class="btn btn-primary" onclick="showSendSmsModal(this,\'' . $doctor->phone . '\')" title="' . lang('SMS') . '" style="color: #fff;margin-right:5px;" href="javascript:;"><i class="fa fa-sms"></i> ' . lang('SMS') . '</a>';
                $clickToEmail = '<a class="btn btn-primary" onclick="showSendEmailModal(this,\'' . $doctor->email . '\')" title="' . lang('Email') . '" style="color: #fff;" href="javascript:;"><i class="fa fa-envelope"></i> ' . lang('Email') . '</a>';

               // $optionMHZ =  $InAppVoiceCall.' '. $InAppVideoCall. ' '.$clickToCall. ' '.$clickToSms. ' '.$clickToEmail;
               $optionMHZ =  $clickToCall. ' '.$clickToSms. ' '.$clickToEmail;
            } else $optionMHZ= '';
            // Haseen code
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) {
                $getdoc_status = $this->doctor_model->getDocstatus($doctor->ion_user_id);
                if($doctor->is_approved==1)
                {
                    $options7 = '<a class="btn btn-info btn-xs btn_width approve_button" title="' . lang('approved') . '" href="javascript:void(0)"><i class="fa fa-check"> </i> ' . lang('approved') . '</a>';   
                }
                else
                {
                    $options7 = '<a class="btn btn-info btn-xs btn_width approve_button" title="' . lang('approve') . '" href="doctor/approve/' . $doctor->ion_user_id . '" onclick="return confirm(\'Are you sure you want to approve this doctor?\');"><i class="fa fa-check"> </i> ' . lang('approve') . '</a>';
                }
            }

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) {
                $options8 = '<a class="btn btn-info btn-xs btn_width disapprove_button" title="' . 'Not approve' . '" href="javascript:void(0)" onclick="adduseridtomodal('."'".$doctor->ion_user_id."'".','."'".$doctor->email."'".')" data-toggle="modal" data-target="#disapprove_modal"><i class="fa fa-times"> </i> ' .' Not approve '. '</a>';
            }
			$medical_registration_verified_btn = '';
			if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist')) && $doctor->medical_registration_verified == 0) {
                $medical_registration_verified_btn = '<a class="btn btn-info btn-xs btn_width approve_button" title="' . lang('approve') . '" href="doctor/medical_reg_verified/' . $doctor->ion_user_id . '/1" onclick="return confirm(\'Are you sure you want to verified this doctor medical registration?\');"><i class="fa fa-check"> </i> Medical Registration Verified</a>';
            }
			elseif($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist')) && $doctor->medical_registration_verified == 1) {
                $medical_registration_verified_btn = '<a class="btn btn-info btn-xs btn_width btn-danger" title="' . lang('approve') . '" href="doctor/medical_reg_verified/' . $doctor->ion_user_id . '/0" onclick="return confirm(\'Are you sure you want to unverified this doctor medical registration?\');"><i class="fa fa-trash"> </i> Medical Registration Unverified</a>';
            }
            
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) {
                if($doctor->doctor_lic_doc !="")
                {
                    $options9 = '<a class="btn btn-primary btn-xs btn_width" title="' . ('Licence Info') . '" href="assets/doctor_prop_data/' . $doctor->doctor_lic_doc . '" target="_blank"><i class="fa fa-info"> </i> ' . ('Licence Info') . '</a>';
                }
                else
                {
                    $options9 = "";
                }

                if($doctor->doctor_lic_doc !="")
                {
                    $identityoptions = '<a class="btn btn-primary btn-xs btn_width" title="' . ('Identity Info') . '" href="assets/doctor_prop_data/' . $doctor->identitydoc . '" target="_blank"><i class="fa fa-info"> </i> ' . ('Identity Info') . '</a>';
                }
                else
                {
                    $identityoptions = "";
                }

                if($doctor->proof_of_address !="")
                {
                    $proofofaddressoptions = '<a class="btn btn-primary btn-xs btn_width" title="' . ('Proof of address') . '" href="assets/doctor_prop_data/' . $doctor->proof_of_address . '" target="_blank"><i class="fa fa-info"> </i> ' . ('Proof of address') . '</a>';
                }
                else
                {
                    $proofofaddressoptions = "";
                }
                    
            }
            
            // end here
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) {
                $options4 = '<a href="schedule/holidays?doctor=' . $doctor->id . '" class="btn btn-info btn-xs btn_width" data-toggle="modal" data-id="' . $doctor->id . '"><i class="fa fa-book"></i> ' . lang('holiday') . '</a>';
                $options5 = '<a href="schedule/timeSchedule?doctor=' . $doctor->id . '" class="btn btn-info btn-xs btn_width" data-toggle="modal" data-id="' . $doctor->id . '"><i class="fa fa-book"></i> ' . lang('time_schedule') . '</a>';
                $options6 = '<a type="button" class="btn btn-info btn-xs btn_width detailsbutton inffo" title="' . lang('info') . '" data-toggle="modal" data-id="' . $doctor->id . '"><i class="fa fa-info"> </i> ' . lang('info') . '</a>';
            }

            $info[] = array(
                $doctor->id,
                $doctor->name,
                $doctor->email,
                $doctor->phone,
                $doctor->department,
                $doctor->profile,
                //  $options1 . ' ' . $options2 . ' ' . $options3,
                $optionMHZ.' '.$options7 . ' ' . $options8. ' ' .$medical_registration_verified_btn.' '.$options9.' '.$identityoptions. ' '.$proofofaddressoptions.' '. $options6 . ' ' . $options1 . ' ' . $options2 . ' ' . $options4 . ' ' . $options5 . ' ' . $options3,
                    //  $options2
            );
        }

        if (!empty($data['doctors'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('doctor')->num_rows(),
                "recordsFiltered" => $this->db->get('doctor')->num_rows(),
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

    public function getDoctorInfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->doctor_model->getDoctorInfo($searchTerm);

        echo json_encode($response);
    }

    public function getDoctorWithAddNewOption() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->doctor_model->getDoctorWithAddNewOption($searchTerm);

        echo json_encode($response);
    }
    
    function approve($id)
    {
       $response = $this->doctor_model->approvedoctorstatus($id);
       $success_message = '<div class="alert alert-success">Doctor account has been approved successfully.</div>';
       $reason = "Thank You! Your account has been successfully approved now you can access all features of Maulaji.";
       $this->send_mail($response['email'],$reason,$success_message);
    }
	
	function medical_reg_verified($id, $state)
    {
       $response = $this->doctor_model->verifieddoctormedicalregistration($id, $state);
       if($state == 1){
		$success_message = '<div class="alert alert-success">Doctor medical registration has been verified successfully.</div>';
		$reason = "Thank You! Your medical registration has been verified now you can access all features of Maulaji.";
	   }else{
		$success_message = '<div class="alert alert-warning">Doctor medical registration has been unverified.</div>';
		$reason = "Soory! Your medical registration has been unverified, from now you can not access all features of Maulaji.";
	   }
       $this->send_mail($response['email'],$reason,$success_message);
    }
    
    function disapprove()
    {
       $id = $this->input->post('d_id');
       $d_email = $this->input->post('d_email');
       $reason = 'Dear user your account is not approved due to the following reason: <br>'.$this->input->post('reason');
       $response = $this->doctor_model->disapprovedoctorstatus($id);
       $success_message = '<div class="alert alert-success">Doctor account has been disapproved successfully.</div>';
       $this->send_mail($d_email,$reason,$success_message);
    }
    
    public function send_mail($email,$reason,$success_message) { 
        $emailSettings = $this->email_model->getEmailSettings();
         $from_email = $emailSettings->admin_email;//"admin@callgpnow.com"; 
         $to_email = $email; 
   
         //Load email library 
         $this->load->library('email'); 
         $config['mailtype'] = 'html';
         $this->email->initialize($config);
         $this->email->from($from_email, 'Maulaji'); 
         $this->email->to($to_email);
         $this->email->subject('Account confirmation'); 
         $this->email->message($reason); 
         //Send mail  
         $this->email->send();
         $this->session->set_flashdata('success',$success_message);
         redirect('doctor'); 
    }
      
    public function getToken()
    {
        $smsSettings = $this->sms_model->getSmsSettingsByGatewayName('Twilio');
        $twilioSid  = $smsSettings->sid;
        $authToken  = $smsSettings->token;
        $apiKey     = 'SK69e68f839abd938c732b3c620e4bcb36';
        $apiSecret  = 'SFTYVl3M3ufwCPJvFEEJgveIl2XWR1TO';
        $appSid     = 'APac81bc7feef5d0917b32a5c449f60f5c';

        $capability = new ClientToken($twilioSid, $authToken);
        $capability->allowClientOutgoing($appSid);

        // $capability->allowClientIncoming($name);

        $token = $capability->generateToken();
        echo $token;
        return;
    }
    
    public function sendMessage()
    {
        $smsSettings = $this->sms_model->getSmsSettingsByGatewayName('Twilio');
        $twilioSid  = $smsSettings->sid;
        $authToken  = $smsSettings->token;
        
        $options  = [
            "from" => '+447445170500',
            "body" => $this->input->post('body')
        ];

       try{
            $client = new Client(
            $twilioSid,
            $authToken
        );
        
        $client->messages
            ->create(
                $this->input->post('to'),
                $options
            );
            
            echo  json_encode([
                        'success' => true,
                        'message' => 'Sms Message Sent Successfully'
                    ]);
       }catch(\Exception $ex){
           echo  json_encode([
                        'success' => false,
                        'message' => 'Error: '.$ex->getMessage()
                    ]);
       }
    }
    
    public function sendEmail()
    {
       $to_email = $this->input->post('email');
       try{
            $emailSettings = $this->email_model->getEmailSettings();
            $subject = 'Quick Message';
            $this->email->from($emailSettings->admin_email);
            $this->email->to($to_email);
            $this->email->subject($subject);
            $this->email->message($this->input->post('body'));
            $this->email->send();            
            
            echo  json_encode([
                        'success' => true,
                        'message' => 'Email Message Sent Successfully'
                    ]);
       }catch(\Exception $ex){
           echo  json_encode([
                        'success' => false,
                        'message' => 'Error: '.$ex->getMessage()
                    ]);
       }
    }
    
    function blog_requests()
    {
        $data['all_posts'] = $this->cms_model->get_reuested_posts();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('blogs/request_view_posts', $data);
        $this->load->view('home/footer'); // just the footer file
    }
    
    function cleanpost($post_name)
    {
       $name = trim($post_name);
       $post_name = str_replace(' ', '-', $name); 
       return preg_replace('/[^A-Za-z0-9\-]/', '', $post_name);
    }
            
    function save_new_post()
    {
        $data = $this->input->post();
        $image_h = $_FILES['post_image']['name'];
        $data['page_content'] = str_replace("'","`",$data['page_content']);
        if(!empty($image_h))
        {
            $image_h = str_replace(' ','-',time().$image_h);
            $ud = $this->uploadprofimg($image_h);
            // file_put_contents('finfo1.txt', $ud->file_name);
            $data['post_image'] = $ud === false ? "" : $ud['file_name'];
        }
        else
        {
            $data['post_image'] = "";
        }
        $data['category_id'] = $this->cms_model->find_or_add_catid($data);
		$data['url'] = $this->cleanpost(strtolower($data['post_name'])); //str_replace(' ','-',strtolower($data['post_name']));  
        $res = $this->cms_model->add_post_data($data);
        $this->session->set_flashdata('blog_success_msg','Blog created successfully, it will be appear on site once admin approve your blog.');
        redirect('doctor/blogs');           
    }

    function uploadprofimg($image_h)
    {
        $config['upload_path']   = 'assets/images/post_img';
        $config['allowed_types'] = 'jpg|png|jpeg|gif';
        $config['overwrite']     = FALSE;
        $config['file_name']     = $image_h;
        $config['max_size']      = '100000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('post_image')) {
            $error = array(
                'error' => $this->upload->display_errors()
            );
            return false;
        }else{
            return $this->upload->data();
        }
    }

    function update_post_data()
    {
        // echo $_SERVER['DOCUMENT_ROOT']; exit;
        $data = $this->input->post();
        $image_h = $_FILES['post_image']['name'];
        $data['page_content'] = str_replace("'", "`", $data['page_content']);
        if(!empty($image_h))
        {
            $image_h = time().$image_h;
            $ud = $this->uploadprofimg($image_h);
            // file_put_contents('finfo2.txt', $ud['file_name'] .'<br>all = '.json_encode($ud));
            $data['post_image'] = $ud === false ? "" : $ud['file_name'];
        }
        else
        {
            $data['post_image'] = $data['old_image'];
        }
		$data['category_id'] = $this->cms_model->find_or_add_catid($data);
        $data['url'] = $this->cleanpost(strtolower($data['post_name'])); //str_replace(' ','-',strtolower($data['post_name']));
        $res = $this->cms_model->update_post_details($data);
		if($res==1)
			$this->session->set_flashdata('blog_success_msg','Blog updated successfully, it will be appear on site once admin approve your blog.');
		else
			$this->session->set_flashdata('blog_success_msg','Blog updated error.');
        redirect('doctor/blogs'); 
    }

    function delete_post($id)
    {
      $this->cms_model->deletepostdata($id);
      $this->session->set_flashdata('feedback', lang('deleted'));
      redirect('doctor/blogs');
    }
    
    function copypost($id)
    {
        $data = $this->cms_model->get_post_data($id); 
        $data['url'] = $data['page_url'].time().'-copy'; 
        $data['post_name'] = $data['page_name'].' '.time().' Copy';       
        $res = $this->cms_model->add_copy_post_data($data);
		$this->session->set_flashdata('blog_success_msg','Blog copied successfully, it will be appear on site once admin approve your blog.');
        redirect('doctor/blogs');        
    }
    
    function approve_post($id)
    {
        $res = $this->cms_model->approve_post($id);
        $this->session->set_flashdata('blog_success_msg', 'Blog approved successfully.');
        redirect('doctor/blog_requests');
    }
    
    function reject_post($id)
    {
        $res = $this->cms_model->reject_post($id);
        $this->session->set_flashdata('blog_success_msg', 'Blog rejected successfully.');
        redirect('doctor/blog_requests');
    }

}

/* End of file doctor.php */
/* Location: ./application/modules/doctor/controllers/doctor.php */
