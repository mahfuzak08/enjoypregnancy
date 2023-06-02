<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('profile/profile_model');
        $this->load->model('auth/general_model');
        $this->load->model('hoispital/hospital_model');
        $this->load->model('donor/donor_model');
        $this->load->model('frontend/frontend_model');
        $this->load->model('patient/patient_model');
        $this->load->model('home/home_model');
    }

    public function index() {
        $data = array();
        $id = $this->ion_auth->get_user_id();
        $data['settings'] = $this->frontend_model->getSettings();
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['countires'] = $this->profile_model->getCounries();
        $data['profile'] = $this->profile_model->getProfileById($id);
        $data['speciality'] = $this->general_model->getSpeciality();
        $data['medicalHistorySetups'] = $this->patient_model->getmedicalHistorySetups();
        if($this->ion_auth->in_group(array('Patient'))){
        	$p_status_data = $this->profile_model->getpatienttbldata($id);
    	}
    	else
    	{
    		$p_status_data = array();
    	}
    	// echo "<pre>";
    	// print_r($p_status_data);
    	// exit;
        if($this->ion_auth->in_group(array('Doctor')))
        {
            $doctor_status = $this->profile_model->getdoctortbldata($id);
            // echo "<pre>";
            // print_r($doctor_status); exit;
            if($doctor_status->is_approved==0 or $doctor_status->is_approved==3)
            {
                $this->load->view('profile_modal', $data);
            }
            else
            {
                if($this->session->userdata('is_hospital')==1 or $this->session->userdata('is_hospital')==2)
                {
                    $this->load->view('home/pharmacy-dashboard');
                }
                else
                {
                    $this->load->view('home/dashboard'); // just the header file
                }
                $this->load->view('profile', $data);
                $this->load->view('home/footer'); 
            }
        }
        elseif($this->ion_auth->in_group(array('Patient')) and ($p_status_data->birthdate=="" or $p_status_data->bloodgroup=="" or $p_status_data->medicale_history=="" or $p_status_data->sex==""))
        {       		
        	$this->load->view('profile_modal', $data);
        	// echo "Under Construction!"; exit;
        }
        else
        {
            if($this->session->userdata('is_hospital')==1 or $this->session->userdata('is_hospital')==2)
            {
                $this->load->view('home/pharmacy-dashboard');
            }
            else
            {
                $this->load->view('home/dashboard'); // just the header file
            }
            $this->load->view('profile', $data);
            $this->load->view('home/footer'); 
        }
        // just the footer file
    }

    public function addNew() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $urgent_care = $this->input->post('urgent_care'); 
        $speciality = $this->input->post('speciality');   
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
        $addresses_arr = $this->input->post('address');
        $full_address = $addresses_arr[0].' '.$addresses_arr[1];
        $address_lat_long = $this->get_lat_long($full_address);
        $address_lat_long = explode(',', $address_lat_long);
        // echo $address_lat_long;
        // exit;
        $city = $this->input->post('city');
        $state_province = $this->input->post('state_province');
        $country = $this->input->post('country');
        $postal_code = $this->input->post('postal_code');

        $pricing = $this->input->post('rating_option');
        if($pricing=='custom_price')
        {
            $pricing = $this->input->post('cust_price');
        }
		
		// $pricing = $this->input->post('pricing');
        // if($pricing=='cust_price')
        // {
            // $pricing = $this->input->post('cust_price');
        // }
        

        $urgent_fee = $this->input->post('urgent_fee');
        $home_fee = $this->input->post('home_fee');

        $degree = $this->input->post('degree');
        $college_institute = $this->input->post('college_institute');
        $degree_compl_year = $this->input->post('degree_compl_year');
        for($i=0; $i<count($degree);$i++)
        {
            $education[] = array('degree' => $degree[$i], 'college_institute' => $college_institute[$i], 'degree_compl_year'=>$degree_compl_year[$i]);
        }
        $education = json_encode($education);
        
        $exp_hospital_name = $this->input->post('exp_hospital_name');
        $exp_from = $this->input->post('exp_from');
        $exp_to = $this->input->post('exp_to');
        $designation = $this->input->post('designation');
        for($i=0; $i<count($exp_hospital_name);$i++)
        {
            $experience[] = array('exp_hospital_name' => $exp_hospital_name[$i], 'exp_from' => $exp_from[$i], 'exp_to' => $exp_to[$i], 'designation' => $designation[$i]);
        }
        $experience = json_encode($experience);
        

        $awards = $this->input->post('awards');
        $award_year = $this->input->post('award_year');
        $award_description = $this->input->post('award_description');
        for($i=0; $i<count($awards);$i++)
        {
            $awards_h[] = array('awards' => $awards[$i], 'award_year' => $award_year[$i], 'award_description' => $award_description[$i]);
        }
        $awards = json_encode($awards_h);
        $status_app = $this->input->post('support_status');
        if($status_app==0)
        {
            $approved_sts = 2;
        }
        elseif($status_app==2)
        {
            $approved_sts = 2;
        }
        else
        {
            $approved_sts = 1;
        }
        $professional_insurance_doc = str_replace(' ','_',$_FILES['professional_insurance_doc']['name']);
        $professional_ref_doc1 = str_replace(' ','_',$_FILES['professional_ref_doc1']['name']);
        $professional_ref_doc2 = str_replace(' ','_',$_FILES['professional_ref_doc2']['name']);
        $license_registeration = str_replace(' ','_',$_FILES['license_registeration']['name']);
        $identity_doc = str_replace(' ','_',$_FILES['identity_doc']['name']);
        $proof_of_address = str_replace(' ','_',$_FILES['proof_of_address']['name']);
        if($professional_ref_doc1!="")
        {
            $professional_ref_doc1 = time().$professional_ref_doc1;
            $this->uploadDoctorfiles($professional_ref_doc1,'professional_ref_doc1');
        }
        else
        {
            $professional_ref_doc1 = $this->input->post('sec_professional_ref_doc1');
        }
		
		if($professional_ref_doc2!="")
        {
            $professional_ref_doc2 = time().$professional_ref_doc2;
            $this->uploadDoctorfiles($professional_ref_doc2,'professional_ref_doc2');
        }
        else
        {
            $professional_ref_doc2 = $this->input->post('sec_professional_ref_doc2');
        }
		
		if($professional_insurance_doc!="")
        {
            $professional_insurance_doc = time().$professional_insurance_doc;
            $this->uploadDoctorfiles($professional_insurance_doc,'professional_insurance_doc');
        }
        else
        {
            $professional_insurance_doc = $this->input->post('sec_professional_insurance_doc');
        }
        
		if($license_registeration!="")
        {
            $license_registeration = time().$license_registeration;
            $this->uploadDoctorfiles($license_registeration,'license_registeration');
        }
        else
        {
            $license_registeration = $this->input->post('sec_doctor_lic_doc');
        }
        
            
        if($identity_doc!="")
        {
            $identity_doc = time().$identity_doc;
            $this->uploadDoctorfiles($identity_doc,'identity_doc');
        }
        else
        {
            $identity_doc = $this->input->post('sec_identitydoc');
        }
        if($proof_of_address!="")
        {
            $proof_of_address = time().$proof_of_address;
            $this->uploadDoctorfiles($proof_of_address,'proof_of_address');
        }
        else
        {
            $proof_of_address = $this->input->post('sec_proof_of_address');
        }
        
        // clinic Info
        $clinic_name = $this->input->post('clinic_name');
        $clinic_address = $this->input->post('clinic_address');
        
        // if(count($clinic_image) > 0)
        // {
        //     // $this->uploadclinicImage($clinic_image);
        // }
        // else
        // {
        //     $clinic_image = array();
        // }
        // echo "<pre>";
        // print_r($clinic_image);
        // exit;
        
        $clinic_array = array();
        $clinic_day_arr = array();
        $from_clinic_time_arr = array();
        $to_clinic_time_arr = array();
        for($i=0; $i<count($clinic_name);$i++)
        {
            $clinic_image = $_FILES['clinic_image'.$i]['name'];
        //     echo "<pre>";
        // print_r($clinic_image);
        // exit;
            $clinic_day = json_encode($this->input->post('clinic_day'.$i));            
            // echo "<pre>";
            // print_r($clinic_day);
            $from_clinic_time = json_encode($this->input->post('from_clinic_time'.$i));
            // echo "<pre>";
            // print_r($from_clinic_time);
            $to_clinic_time = json_encode($this->input->post('to_clinic_time'.$i));
            // echo "<pre>";
            // print_r($to_clinic_time);
            $clinic_array[] = array('clinic_name' => $clinic_name[$i], 'clinic_address' => $clinic_address[$i], 'clinic_image' => 'assets/clinic_images/'.$clinic_image[$i], 'clinic_day'=>$clinic_day, 'from_clinic_time'=>$from_clinic_time, 'to_clinic_time'=>$to_clinic_time);
        }
        
        $clinic_array = json_encode($clinic_array);
        // echo "<pre>";
        // print_r($clinic_array);
        // exit;

        $data['profile'] = $this->profile_model->getProfileById($id);
        if ($data['profile']->email != $email) {
            if ($this->ion_auth->email_check($email)) {
                $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                redirect('profile');
            }
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        // Validating Password Field
        if (!empty($password)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $id = $this->ion_auth->get_user_id();
            $data['profile'] = $this->profile_model->getProfileById($id);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('profile', $data);
            $this->load->view('home/footer'); // just the footer file
        } else {
            $data = array();
            if ($this->ion_auth->in_group(array('Doctor'))) {
            $data = array(
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'latitude' => $address_lat_long[0],
                'longitude' => $address_lat_long[1],
                'phone' => $phone,
                'doctor_type' => $doctor_type,
                'home_visit_status' => $home_visit,
                'urgent_care_status' => $urgent_care,
                'profile' => $speciality,
                'identitydoc'=> $identity_doc,
                'doctor_lic_doc'=> $license_registeration,
                'proof_of_address'=> $proof_of_address,
                'professional_insurance_doc'=> $professional_insurance_doc,
                'professional_ref_doc1'=> $professional_ref_doc1,
                'professional_ref_doc2'=> $professional_ref_doc2,
                'country' => $country,
                'city' => $city,
                'state_province' => $state_province,
                'postal_code' => $postal_code,
                'gender' => $gender,
                'date_of_birth' => $date_of_birth,
                'about_me' => $about_me,            
                'pricing' => $pricing,            
                'urgent_fee' => $urgent_fee,            
                'home_fee' => $home_fee,            
                'services' => $services,            
                'specialization' => $specialization,   
                'clinic_info' => $clinic_array,
                'education' => $education,            
                'experience' => $experience,            
                'awards' => $awards,  
                'is_approved' => $approved_sts
            );
            }
            else
            {
                $address0 = json_decode($address);
                $address = $address0[0];
                $bloodgroup = $this->input->post('bloodgroup');
                $medicale_history = implode(',',$this->input->post('medicaleHistory'));
                $data = array(
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'phone' => $phone,
                'sex' => $gender,
                'birthdate' => $date_of_birth,
                'bloodgroup'=>$bloodgroup,
                'medicale_history' => $medicale_history,
                );
            }
            // echo "<pre>";
            // print_r($data);
            // exit;
            $username = $this->input->post('name');
            $ion_user_id = $this->ion_auth->get_user_id();
            $group_id = $this->profile_model->getUsersGroups($ion_user_id)->row()->group_id;
            $group_name = $this->profile_model->getGroups($group_id)->row()->name;
            $group_name = strtolower($group_name);
            if (empty($password)) {
                $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
            } else {
                $password = $this->ion_auth_model->hash_password($password);
            }
            $this->profile_model->updateIonUser($username, $email, $phone, $password, $ion_user_id);
            if (!$this->ion_auth->in_group(array('superadmin'))) {
                if ($this->ion_auth->in_group(array('admin'))) {
                    $this->hospital_model->updateHospitalByIonId($ion_user_id, $data);
                } else {
                    $this->profile_model->updateProfile($ion_user_id, $data, $group_name);
                }
            }
            $this->session->set_flashdata('feedback', lang('updated'));
            if($_SESSION['template'] == "doccure"){
				redirect('doctor/dashboard');
			}
            
            if($status_app==0)
            {
                $this->session->set_flashdata('profile_success_msg', 'Your profile aproval request has been submited successfully. You will get a confirmation email shortly.');
            }
            if(empty($this->input->post('pateint_here')))
            {
            	redirect('profile');
            }
            else
            {
            	redirect('patient/medicalHistory');
            }
            // Loading View
            
        }
    }

    
	public function update() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $oldemail = $this->input->post('oldemail');
        $phone = $this->input->post('phone');
        $urgent_care = $this->input->post('urgent_care'); 
        $speciality = $this->input->post('speciality');   
        $doctor_type = $this->input->post('doctor_type');    
        
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
        $addresses_arr = $this->input->post('address');
        $full_address = $addresses_arr[0].' '.$addresses_arr[1];
        $address_lat_long = $this->get_lat_long($full_address);
        $address_lat_long = explode(',', $address_lat_long);
        
		$city = $this->input->post('city');
        $state_province = $this->input->post('state_province');
        $country = $this->input->post('country');
        $postal_code = $this->input->post('postal_code');

        $pricing = $this->input->post('rating_option');
        if($pricing=='custom_price')
        {
            $pricing = $this->input->post('cust_price');
        }
        

        $urgent_fee = $this->input->post('urgent_fee');
        $home_fee = $this->input->post('home_fee');

        $degree = $this->input->post('degree');
        $college_institute = $this->input->post('college_institute');
        $degree_compl_year = $this->input->post('degree_compl_year');
        for($i=0; $i<count($degree);$i++)
        {
            $education[] = array('degree' => $degree[$i], 'college_institute' => $college_institute[$i], 'degree_compl_year'=>$degree_compl_year[$i]);
        }
        $education = json_encode($education);
        
        $exp_hospital_name = $this->input->post('exp_hospital_name');
        $exp_from = $this->input->post('exp_from');
        $exp_to = $this->input->post('exp_to');
        $designation = $this->input->post('designation');
        for($i=0; $i<count($exp_hospital_name);$i++)
        {
            $experience[] = array('exp_hospital_name' => $exp_hospital_name[$i], 'exp_from' => $exp_from[$i], 'exp_to' => $exp_to[$i], 'designation' => $designation[$i]);
        }
        $experience = json_encode($experience);
        
        $awards = $this->input->post('awards');
        $award_year = $this->input->post('award_year');
        $award_description = @$this->input->post('award_description');
        for($i=0; $i<count($awards);$i++)
        {
            $awards_h[] = array('awards' => $awards[$i], 'award_year' => $award_year[$i], 'award_description' => $award_description[$i]);
        }
        $awards = json_encode($awards_h);
        $status_app = $this->input->post('support_status');
        if($status_app==0)
        {
            $approved_sts = 2;
        }
        elseif($status_app==2)
        {
            $approved_sts = 2;
        }
        else
        {
            $approved_sts = 1;
        }
        $profileimage = str_replace(' ','_',$_FILES['profileimage']['name']);
		$proImg = $this->input->post('old_profileimage');
		
        $professional_insurance_doc = str_replace(' ','_',$_FILES['professional_insurance_doc']['name']);
        $professional_ref_doc1 = str_replace(' ','_',$_FILES['professional_ref_doc1']['name']);
        $professional_ref_doc2 = str_replace(' ','_',$_FILES['professional_ref_doc2']['name']);
        $license_registeration = str_replace(' ','_',$_FILES['license_registeration']['name']);
        $identity_doc = str_replace(' ','_',$_FILES['identity_doc']['name']);
        $proof_of_address = str_replace(' ','_',$_FILES['proof_of_address']['name']);
        if($professional_ref_doc1!="")
        {
            $professional_ref_doc1 = time().$professional_ref_doc1;
            $this->uploadDoctorfiles($professional_ref_doc1,'professional_ref_doc1');
        }
        else
        {
            $professional_ref_doc1 = $this->input->post('sec_professional_ref_doc1');
        }
		
		if($professional_ref_doc2!="")
        {
            $professional_ref_doc2 = time().$professional_ref_doc2;
            $this->uploadDoctorfiles($professional_ref_doc2,'professional_ref_doc2');
        }
        else
        {
            $professional_ref_doc2 = $this->input->post('sec_professional_ref_doc2');
        }
		
		if($professional_insurance_doc!="")
        {
            $professional_insurance_doc = time().$professional_insurance_doc;
            $this->uploadDoctorfiles($professional_insurance_doc,'professional_insurance_doc');
        }
        else
        {
            $professional_insurance_doc = $this->input->post('sec_professional_insurance_doc');
        }
		
        if($profileimage!="")
        {
            $profileimage = time().$profileimage;
            $proImgr = $this->updatedoctorproimage($profileimage,'profileimage');
			$proImg = $proImgr !== false ? $proImgr : $proImg;
        }
		
		if($license_registeration!="")
        {
            $license_registeration = time().$license_registeration;
            $this->uploadDoctorfiles($license_registeration,'license_registeration');
        }
        else
        {
            $license_registeration = $this->input->post('sec_doctor_lic_doc');
        }
        
            
        if($identity_doc!="")
        {
            $identity_doc = time().$identity_doc;
            $this->uploadDoctorfiles($identity_doc,'identity_doc');
        }
        else
        {
            $identity_doc = $this->input->post('sec_identitydoc');
        }
        if($proof_of_address!="")
        {
            $proof_of_address = time().$proof_of_address;
            $this->uploadDoctorfiles($proof_of_address,'proof_of_address');
        }
        else
        {
            $proof_of_address = $this->input->post('sec_proof_of_address');
        }
        
        // clinic Info
        $clinic_name = $this->input->post('clinic_name');
        $clinic_address = $this->input->post('clinic_address');
        
        $clinic_array = array();
        for($i=0; $i<count($clinic_name);$i++)
        {
            $clinic_image = $_FILES['clinic_image'.$i]['name'];
       		$clinic_array[] = array('clinic_name' => $clinic_name[$i], 'clinic_address' => $clinic_address[$i], 'clinic_image' => '', 'clinic_day'=>'', 'from_clinic_time'=>'', 'to_clinic_time'=>'');
        }
        
        $clinic_array = json_encode($clinic_array);
        
		if ($oldemail != $email) {
            if ($this->ion_auth->email_check($email)) {
                $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
				if($_SESSION['template'] == "doccure") redirect("doctor/profile");
                else redirect('profile');
            }
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            redirect("doctor/profile");
        } else {
            $data = array(
                'name' => $name,
                'email' => $email,
				'img_url' => $proImg,
                'address' => $address,
                'latitude' => $address_lat_long[0],
                'longitude' => $address_lat_long[1],
                'phone' => $phone,
                'doctor_type' => $doctor_type,
                'home_visit_status' => $home_visit,
                'urgent_care_status' => $urgent_care,
                'profile' => $speciality,
                'identitydoc'=> $identity_doc,
                'doctor_lic_doc'=> $license_registeration,
                'proof_of_address'=> $proof_of_address,
                'professional_ref_doc1'=> $professional_ref_doc1,
                'professional_ref_doc2'=> $professional_ref_doc2,
                'professional_insurance_doc'=> $professional_insurance_doc,
                'country' => $country,
                'city' => $city,
                'state_province' => $state_province,
                'postal_code' => $postal_code,
                'gender' => $gender,
                'date_of_birth' => $date_of_birth,
                'about_me' => $about_me,            
                'pricing' => $pricing,            
                'urgent_fee' => $urgent_fee,            
                'home_fee' => $home_fee,            
                'services' => $services,            
                'specialization' => $specialization,   
                'clinic_info' => $clinic_array,
                'education' => $education,            
                'experience' => $experience,            
                'awards' => $awards,  
                'is_approved' => $approved_sts
            );
            
			$username = $this->input->post('name');
            $ion_user_id = $this->ion_auth->get_user_id();
            $group_id = $this->profile_model->getUsersGroups($ion_user_id)->row()->group_id;
            $group_name = $this->profile_model->getGroups($group_id)->row()->name;
            $group_name = strtolower($group_name);
            $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
            
			$this->profile_model->updateIonUser($username, $email, $phone, $password, $ion_user_id);
            $this->profile_model->updateProfile($ion_user_id, $data, $group_name);
			
            $this->session->set_flashdata('feedback', lang('updated'));
            if($status_app==0)
            {
                $this->session->set_flashdata('profile_success_msg', 'Your profile aproval request has been submited successfully. You will get a confirmation email shortly.');
            }
            redirect("doctor/profile");
        }
    }
	
	function get_lat_long($address)
    {

        $address = str_replace(" ", "+", $address);

        $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyAT2zrRl1pjiErc88r1qMg19QZ3hw0Ukwg&sensor=false");
        $json = json_decode($json);
        // echo "<pre>";
        // print_r($json);exit;
        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        return $lat.','.$long;
    
    }

    function updatedoctorimage()
    {
        $profile_img = $_FILES['profileimage']['name'];
        $old_profileimage = $this->input->post('old_profileimage');
        $id = $this->input->post('doc_id');
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
            $img_url = $img_url1;
        } else {
            $img_url = $old_profileimage;
        }
        if($this->ion_auth->in_group(array('Patient')))
        {
            $this->profile_model->updatePatientprofileimage($id,$img_url);
        }
        else
        {
            $this->profile_model->updateprofileimage($id,$img_url);
        }
        $this->session->set_flashdata('feedback', lang('updated'));
        redirect('profile');
    }

    function updatedoctorproimage($image,$value)
    {
        $config1 = array(
            'file_name' => $value,
            'upload_path' => "./uploads/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => False,
            'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "1768",
            'max_width' => "2024"
        );
        $this->load->library('Upload', $config1);
        $this->upload->initialize($config1);
        
        if ($this->upload->do_upload($value)) {
            $path1 = $this->upload->data();
            return "uploads/" . $path1['file_name'];
        } else {
            echo $this->upload->display_errors();
            echo "Some error occured"; 
			return false;
        }
    }
	
	function uploadDoctorfiles($image,$value)
    {
        $config1 = array(
            'file_name' => $image,
            'upload_path' => "assets/doctor_prop_data/",
            'allowed_types' => "*",
            'overwrite' => true,
            // 'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            // 'max_height' => "1768",
            // 'max_width' => "2024"
        );
        $this->load->library('Upload', $config1);
        $this->upload->initialize($config1);
        
        if ($this->upload->do_upload($value)) {
            // echo "all good here"; exit;
            $path1 = $this->upload->data();
            // $img_url1 = "uploads/" . $path1['file_name'];
            // $img_url = $img_url1;
        } else {
            echo $this->upload->display_errors();
            echo "Some error occured"; exit;
        }
    }
    
    function uploadclinicImage($clinic_img)
    {
        $config1 = array(
            'file_name' => $clinic_img,
            'upload_path' => "assets/clinic_images/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => False,
            'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "1768",
            'max_width' => "2024"
        );
        $this->load->library('Upload', $config1);
        $this->upload->initialize($config1);
        
        if ($this->upload->do_upload('clinic_image')) {
            echo "all good here"; exit;
            $path1 = $this->upload->data();
            // $img_url1 = "uploads/" . $path1['file_name'];
            // $img_url = $img_url1;
        } else {
            echo "Some error occured"; exit;
        }
    }

}

/* End of file profile.php */
/* Location: ./application/modules/profile/controllers/profile.php */
