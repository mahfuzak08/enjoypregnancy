<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hospital extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('hospital_model');
        $this->load->model('hospital/package_model');
        $this->load->model('donor/donor_model');
        $this->load->model('pgateway/pgateway_model');
        $this->load->model('sms/sms_model');
        $this->load->model('email/email_model');
        if (!$this->ion_auth->in_group('superadmin')) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data['hospitals'] = $this->hospital_model->getHospital();
        $data['packages'] = $this->package_model->getPackage();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('hospital', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function pharmacies() {
        $data['hospitals'] = $this->hospital_model->getPharmacies();
        $data['packages'] = $this->package_model->getPackage();
        $this->load->view('home/pharmacy-dashboard'); // just the header file
        $this->load->view('hospital/pharmacy', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function laboratories()
    {
        $data['hospitals'] = $this->hospital_model->getLaboratories();
        $data['packages'] = $this->package_model->getPackage();
        $this->load->view('home/laboratory-dashboard'); // just the header file
        $this->load->view('hospital/laboratory', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['packages'] = $this->package_model->getPackage();
        if($this->session->userdata('is_hospital')==1)
        {
            $this->load->view('home/pharmacy-dashboard'); // just the header file
        }
        elseif($this->session->userdata('is_hospital')==2)
        {
            $this->load->view('home/laboratory-dashboard'); // just the header file
        }
        else
        {
            $this->load->view('home/dashboard'); // just the header file
        }
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
    	// echo "<pre>";
    	// print_r($this->input->post());
    	// exit();
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $package = $this->input->post('package');
        $language = $this->input->post('language');
        
        $redirect = $this->input->post('redirect');

        if (!empty($package)) {
            $module = $this->package_model->getPackageById($package)->module;
            $p_limit = $this->package_model->getPackageById($package)->p_limit;
            $d_limit = $this->package_model->getPackageById($package)->d_limit;
        } else {
            $p_limit = $this->input->post('p_limit');
            $d_limit = $this->input->post('d_limit');
            $module = $this->input->post('module');
            if (!empty($module)) {
                $module = implode(',', $module);
            }
        }
        
        $language_array = array('english', 'arabic', 'spanish', 'french', 'italian', 'portuguese');

        if (!in_array($language, $language_array)) {
            $language = 'english';
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[5]|max_length[50]|xss_clean');

        // Validating Phone Field           
        $this->form_validation->set_rules('p_limit', 'Patient Limit', 'trim|required|min_length[1]|max_length[100]|xss_clean');

        // Validating Phone Field           
        $this->form_validation->set_rules('language', 'Language', 'trim|required|min_length[1]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
        	// echo "Here Now"; echo validation_errors(); exit();
            if (!empty($id)) {
                redirect("hospital/editHospital?id=$id");
            } else {
                $data['packages'] = $this->package_model->getPackage();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $is_hospital = $this->input->post('is_hospital');
            if($is_hospital==1)
            {
                $is_hospital = 1;
            }
            elseif($is_hospital==2)
            {
                $is_hospital = 2;
            }
            else
            {
                $is_hospital = 0;
            }
            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'phone' => $phone,
                'package' => $package,
                'p_limit' => $p_limit,
                'd_limit' => $d_limit,
                'module' => $module,
                'is_hospital' => $is_hospital
            );

            $username = $this->input->post('name');

            if (empty($id)) {     // Adding New Hospital
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', lang('payment_failed_no_gateway_selected'));
                    redirect('hospital/addNewView');
                } else {
                    $dfg = 11;
                    $this->ion_auth->register($username, $password, $email, $dfg, array('is_hospital'=>$is_hospital));
                    $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                    $this->hospital_model->insertHospital($data);
                    $hospital_user_id = $this->db->get_where('hospital', array('email' => $email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->hospital_model->updateHospital($hospital_user_id, $id_info);
                    $hospital_settings_data = array();
                    $hospital_settings_data = array('hospital_id' => $hospital_user_id,
                        'title' => $name,
                        'email' => $email,
                        'address' => $address,
                        'phone' => $phone,
                        'language' => $language,
                        'system_vendor' => 'Maulaji Health Services - Hospital management System',
                        'discount' => 'flat',
                        'sms_gateway' => 'Twilio',
                        'currency' => '$'
                    );
                    $this->settings_model->insertSettings($hospital_settings_data);
                    $hospital_blood_bank = array();
                    $hospital_blood_bank = array('A+' => '0 Bags', 'A-' => '0 Bags', 'B+' => '0 Bags', 'B-' => '0 Bags', 'AB+' => '0 Bags', 'AB-' => '0 Bags', 'O+' => '0 Bags', 'O-' => '0 Bags');
                    foreach ($hospital_blood_bank as $key => $value) {
                        $data_bb = array('group' => $key, 'status' => $value, 'hospital_id' => $hospital_user_id);
                        $this->donor_model->insertBloodBank($data_bb);
                        $data_bb = NULL;
                    }

                    $data_sms_clickatell = array();
                    $data_sms_clickatell = array(
                        'name' => 'Clickatell',
                        'username' => 'Your ClickAtell Username',
                        'password' => 'Your ClickAtell Password',
                        'api_id' => 'Your ClickAtell Api Id',
                        'user' => $this->ion_auth->get_user_id(),
                        'hospital_id' => $hospital_user_id
                    );

                    $this->sms_model->addSmsSettings($data_sms_clickatell);

                    $data_sms_msg91 = array(
                        'name' => 'MSG91',
                        'username' => 'Your MSG91 Username',
                        'api_id' => 'Your MSG91 API ID',
                        'sender' => 'Sender Number',
                        'authkey' => 'Your MSG91 Auth Key',
                        'user' => $this->ion_auth->get_user_id(),
                        'hospital_id' => $hospital_user_id
                    );

                    $this->sms_model->addSmsSettings($data_sms_msg91);



                    $data_sms_twilio = array(
                        'name' => 'Twilio',
                        'sid' => 'SID Number',
                        'token' => 'Token Number',
                        'sendernumber' => 'Sender Number',
                        'user' => $this->ion_auth->get_user_id(),
                        'hospital_id' => $hospital_user_id
                    );

                    $this->sms_model->addSmsSettings($data_sms_twilio);






                    $data_pgateway_paypal = array(
                        'name' => 'PayPal', // Sandbox / testing mode option.
                        'APIUsername' => 'PayPal API Username', // PayPal API username of the API caller
                        'APIPassword' => 'PayPal API Password', // PayPal API password of the API caller
                        'APISignature' => 'PayPal API Signature', // PayPal API signature of the API caller
                        'status' => 'test',
                        'hospital_id' => $hospital_user_id
                    );

                    $this->pgateway_model->addPaymentGatewaySettings($data_pgateway_paypal);

                    $data_pgateway_payumoney = array(
                        'name' => 'Pay U Money', // Sandbox / testing mode option.
                        'merchant_key' => 'Merchant key', // PayPal API username of the API caller
                        'salt' => 'Salt', // PayPal API password of the API caller
                        'status' => 'test',
                        'hospital_id' => $hospital_user_id
                    );

                    $this->pgateway_model->addPaymentGatewaySettings($data_pgateway_payumoney);



                    $data_pgateway_stripe = array(
                        'name' => 'Stripe', // Sandbox / testing mode option.
                        'secret' => 'Secret', // Sandbox / testing mode option.
                        'publish' => 'Publish', // PayPal API username of the API caller
                        'hospital_id' => $hospital_user_id
                    );

                    $this->pgateway_model->addPaymentGatewaySettings($data_pgateway_stripe);

                    $data_pgateway_payumoney = array(
                        'name' => 'Paystack', // Sandbox / testing mode option.
                        'public_key' => 'Public key', // PayPal API username of the API caller
                        'secret' => 'secret', // PayPal API password of the API caller
                        'status' => 'test',
                        'hospital_id' => $hospital_user_id
                    );

                    $this->pgateway_model->addPaymentGatewaySettings($data_pgateway_payumoney);



                    $data_email_settings = array(
                        'admin_email' => 'Admin Email', // Sandbox / testing mode option.
                        'hospital_id' => $hospital_user_id
                    );

                    $this->email_model->addEmailSettings($data_email_settings);

                    $this->hospital_model->createAutoSmsTemplate($hospital_user_id);
                    $this->hospital_model->createAutoEmailTemplate($hospital_user_id);

                    $this->session->set_flashdata('feedback', lang('new_hospital_created'));
                    if(!empty($redirect))
                    {
                        redirect($redirect);
                    }
                    else
                    {
                        redirect('hospital');
                    }
                }
            } else { // Updating Hospital
                $ion_user_id = $this->db->get_where('hospital', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->hospital_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->hospital_model->updateHospital($id, $data);

                $hospital_settings_data = array();
                $hospital_settings_data = array(
                    'language' => $language
                );
                $this->settings_model->updateHospitalSettings($id, $hospital_settings_data);


                $this->session->set_flashdata('feedback', lang('updated'));
                redirect('hospital/editHospital?id=' . $id);
            }
            // Loading View
        }
    }

    function getHospital() {
        $data['hospitals'] = $this->hospital_model->getHospital();
        $this->load->view('hospital', $data);
    }

    function activate() {
        $hospital_id = $this->input->get('hospital_id');
        $redirect = $this->input->get('redirect');
        // exit;
        $data = array('active' => 1);
        $this->hospital_model->activate($hospital_id, $data);
        $this->session->set_flashdata('feedback', lang('activated'));
         if ($redirect == 'deactive') {
            redirect('hospital/disable');
        } elseif ($redirect == 'active') {
            redirect('hospital/active');
        } else {
            if($this->input->get('pharmacy')=='yes')
            {
                redirect('hospital/pharmacies');
            }
            else
            {
                redirect('hospital');
            }            
        }
        
    }

    function deactivate() {
        $hospital_id = $this->input->get('hospital_id');
        $redirect = $this->input->get('redirect');
        $data = array('active' => 0);
        $this->hospital_model->deactivate($hospital_id, $data);
        $this->session->set_flashdata('feedback', lang('deactivated'));
        if ($redirect == 'deactive') {
            redirect('hospital/disable');
        } elseif ($redirect == 'active') {
            redirect('hospital/active');
        } else {
            if($this->input->get('pharmacy')=='yes')
            {
                redirect('hospital/pharmacies');
            }
            else
            {
                redirect('hospital');
            }            
        }
    }

    function editHospital() {
        $data = array();
        $id = $this->input->get('id');
        $data['packages'] = $this->package_model->getPackage();
        $data['hospital'] = $this->hospital_model->getHospitalById($id);
        if($this->session->userdata('is_hospital')==1)
        {
            $this->load->view('home/pharmacy-dashboard'); // just the header file
        }
        elseif($this->session->userdata('is_hospital')==2)
        {
            $this->load->view('home/laboratory-dashboard'); // just the header file
        }
        else
        {
            $this->load->view('home/dashboard');
        }
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editHospitalByJason() {
        $id = $this->input->get('id');
        $data['hospital'] = $this->hospital_model->getHospitalById($id);
        $data['settings'] = $this->settings_model->getSettingsByHId($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('hospital', array('id' => $id))->row();
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->hospital_model->delete($id);
        if($this->input->get('pharmacy')=='yes')
        {
            redirect('hospital/pharmacies');
        }
        elseif($this->input->get('pharmacy')=='lab')
        {
            redirect('hospital/laboratories');
        }
        else
        {
            redirect('hospital');
        }        
    }

    public function active() {
        $data['hospitals'] = $this->hospital_model->getHospital();
        $data['packages'] = $this->package_model->getPackage();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('active_hospital', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function disable() {
        $data['hospitals'] = $this->hospital_model->getHospital();
        $data['packages'] = $this->package_model->getPackage();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('disable_hospital', $data);
        $this->load->view('home/footer'); // just the header file
    }

}

/* End of file hospital.php */
/* Location: ./application/modules/hospital/controllers/hospital.php */
