<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('finance/finance_model');
        $this->load->model('appointment/appointment_model');
        $this->load->model('notice/notice_model');
        $this->load->model('home_model');
        $this->load->model('pharmacist/pharmacist_model');
        $this->load->model('hospital/pharmacy_model');
    }

    public function index() {
        // echo 123; exit;
        if (!$this->ion_auth->in_group(array('superadmin'))) {
			
			if ($this->ion_auth->in_group(array('Doctor'))) {
                redirect('doctor/dashboard');
            }
			if ($this->ion_auth->in_group(array('Patient'))) {
                redirect('patient/dashboard');
            }
			
            $data = array();
            $data['settings'] = $this->settings_model->getSettings();
            $data['sum'] = $this->home_model->getSum('gross_total', 'payment');
            $data['payments'] = $this->finance_model->getPayment();
            $data['notices'] = $this->notice_model->getNotice();
            $data['this_month'] = $this->finance_model->getThisMonth();
            $data['expenses'] = $this->finance_model->getExpense();
            if ($this->ion_auth->in_group(array('Doctor'))) {
                redirect('doctor/details');
            } else {
                $data['appointments'] = $this->appointment_model->getAppointment();
            }

            if ($this->ion_auth->in_group(array('Accountant', 'Receptionist'))) {
                redirect('finance/addPaymentView');
            }

            // if ($this->ion_auth->in_group(array('Pharmacist'))) {
            //     // echo "123 I am here"; exit;
            //     redirect('hospital/pharmacy/home');
            // }
            // exit;
            if ($this->ion_auth->in_group(array('Patient'))) {
                redirect('patient/medicalHistory');
            }



            $data['this_month']['payment'] = $this->finance_model->thisMonthPayment();
            $data['this_month']['expense'] = $this->finance_model->thisMonthExpense();
            $data['this_month']['appointment'] = $this->finance_model->thisMonthAppointment();

            $data['this_day']['payment'] = $this->finance_model->thisDayPayment();
            $data['this_day']['expense'] = $this->finance_model->thisDayExpense();
            $data['this_day']['appointment'] = $this->finance_model->thisDayAppointment();

            $data['this_year']['payment'] = $this->finance_model->thisYearPayment();
            $data['this_year']['expense'] = $this->finance_model->thisYearExpense();
            $data['this_year']['appointment'] = $this->finance_model->thisYearAppointment();

            $data['this_month']['appointment'] = $this->finance_model->thisMonthAppointment();
            $data['this_month']['appointment_treated'] = $this->finance_model->thisMonthAppointmentTreated();
            $data['this_month']['appointment_cancelled'] = $this->finance_model->thisMonthAppointmentCancelled();

            $data['this_year']['payment_per_month'] = $this->finance_model->getPaymentPerMonthThisYear();


            $data['this_year']['expense_per_month'] = $this->finance_model->getExpensePerMonthThisYear();
            if($this->session->userdata('is_hospital')==1)
            {
                $this->load->view('pharmacy-dashboard',$data);
            }
            elseif($this->session->userdata('is_hospital')==2)
            {
                $this->load->view('laboratory-dashboard',$data);
            }
            else
            {
                $this->load->view('dashboard'); // just the header file
            }
            $this->load->view('home', $data);
            $this->load->view('footer', $data);
            
        } else {
            // echo "<pre>";
            // print_r($this->session->userdata('is_hospital'));
            // exit;
            if($this->session->userdata('is_hospital')==1)
            {
                $data['heading_live'] = 'Pharmacies';
                $data['hospitals'] = $this->hospital_model->getPharmacies();
                $this->load->view('pharmacy-dashboard'); // just the header file
                $this->load->view('home', $data);
                $this->load->view('footer');
            }
            elseif($this->session->userdata('is_hospital')==2)
            {
                $data['heading_live'] = 'Laboratories';
                $data['hospitals'] = $this->hospital_model->getLaboratories();
                $this->load->view('laboratory-dashboard'); // just the header file
                $this->load->view('home', $data);
                $this->load->view('footer');
            }
            else
            {
                $data['heading_live'] = 'Hospitals';
                $data['hospitals'] = $this->hospital_model->getHospital();
                $this->load->view('dashboard'); // just the header file
                $this->load->view('home', $data);
                $this->load->view('footer');
            }
        }
    }

    public function permission() {
        $this->load->view('permission');
    }


public function pharmacists() {
        $data['pharmacists'] = $this->home_model->getPharmacist();
        $this->load->view('home/pharmacy-dashboard'); // just the header file
        $this->load->view('pharmacist/pharmacist', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function salesman() {
        $data['salesman'] = $this->home_model->getSalesman();
        if($this->session->userdata('is_hospital')==1)
        {
            $this->load->view('home/pharmacy-dashboard'); // just the header file
            $this->load->view('pharmacist/salesman', $data);
        }
        elseif($this->session->userdata('is_hospital')==2)
        {
            $this->load->view('home/laboratory-dashboard');
            $this->load->view('laboratorist/salesman', $data);
        }
        
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewPharmacist() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');

        $is_saleman = $this->input->post('is_saleman');
        if(empty($is_saleman))
        {
            $is_saleman = 0;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|max_length[50]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['pharmacist'] = $this->pharmacist_model->getPharmacistById($id);
                $this->load->view('home/pharmacy-dashboard'); // just the header file
                $this->load->view('pharmacist/add_new', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $this->load->view('home/pharmacy-dashboard'); // just the header file
                $this->load->view('pharmacist/add_new');
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
                    'is_saleman' => $is_saleman
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'is_saleman' => $is_saleman
                );
            }
            $username = $this->input->post('name');
            if (empty($id)) {  // Adding New Pharmacist
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                    redirect('home/addNewPharmacistView');
                } else {
                    $dfg = 7;
                    $this->ion_auth->register($username, $password, $email, $dfg, array('is_hospital'=>1));
                    $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                    $this->pharmacist_model->insertPharmacist($data);
                    $pharmacist_user_id = $this->db->get_where('pharmacist', array('email' => $email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->pharmacist_model->updatePharmacist($pharmacist_user_id, $id_info);
                    $this->hospital_model->addHospitalIdToIonUser($ion_user_id, $this->hospital_id);
                    $this->session->set_flashdata('feedback', lang('added'));
                }
            } else { // Updating Pharmacist
                $ion_user_id = $this->db->get_where('pharmacist', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->pharmacist_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->pharmacist_model->updatePharmacist($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            if($is_saleman==0)
            {
                redirect('home/pharmacists');
            }
            else
            {
                redirect('home/salesman');
            }
        }
    }

    public function addNewPharmacistView() {
        $this->load->view('home/pharmacy-dashboard'); // just the header file
        $this->load->view('pharmacist/add_new');
        $this->load->view('home/footer'); // just the header file
    }

    function editPharmacistByJason() {
        $id = $this->input->get('id');
        $data['pharmacist'] = $this->pharmacist_model->getPharmacistById($id);
        echo json_encode($data);
    }

    function deletepharmacist() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('pharmacist', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->pharmacist_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        if($this->input->get('is_saleman')=='yes')
        {
            redirect('home/salesman');
        }
        else
        {
            redirect('home/pharmacists');
        }
    }

    public function porders() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['user_info'] = $this->home_model->getuserInfohere();
        $data['settings'] = $this->settings_model->getSettings();
        $data['orders'] = $this->pharmacy_model->getproducAssignedtOrders();
        $data['salemans'] = $this->home_model->getSalesman();
        // echo "<pre>";
        // print_r($data['user_info']);
        // exit;
        $this->load->view('home/pharmacy-dashboard'); // just the header file
        $this->load->view('hospital/pharmacy/porders', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getorderinformationByAjax()
    {
        $pid = $this->input->post('pid');
        $data = $this->pharmacy_model->getorderinformation($pid);
        $presc_imgs = json_decode($data['prescription_image']); 
        $non_prescription_order = json_decode($data['non_prescription_order']);
        $currency = "Rs.";
        if($data['pay_type']=='by_hand')
        {
            $payement_method = "Cash on delivery";
        } 
        elseif($data['pay_type']=='by_card')
        {
            $payement_method = "Credit card";
        }
        echo '<br><div class="row">
                <div class="col-md-12">
                  <p><strong>Order ID:</strong> <span class="order_id">'.$data['order_id'].'</span></p>
                  <p><strong>Customer name:</strong> <span class="">'.$data['name'].'</span></p>
                  <p><strong>Customer email:</strong> <span class="">'.$data['email'].'</span></p>
                  <p><strong>Customer phone:</strong> <span class="">'.$data['phone'].'</span></p>
                  <p><strong>Order Date & Time:</strong> <span class="">'.$data['date'].'</span></p>
                  <p><strong>Total Amount:</strong> <span class="">'.$currency.$data['amount'].'</span></p>
                  <p><strong>Discount:</strong> <span class="">'.$currency.$data['discount'].'</span></p>
                  <p><strong>Shipping Charges:</strong> <span class="">'.$currency.$data['shippedcharges'].'</span></p>
                  <p><strong>Shipping Address:</strong> <span class="">'.$data['shippinaddress'].'</span></p>
                  <p><strong>Notes:</strong> <span class="">'.$data['notes'].'</span></p>
                  <p><strong>Payment Type:</strong> <span class="">'.$payement_method.'</span></p>
                  ';
        if(count($presc_imgs) > 0)
        {
            // echo "<pre>";
            // print_r($presc_imgs);
            echo '<p><strong>Prescriptions:</strong></p>';
            foreach($presc_imgs as $key => $value)
            {
                echo '<a href="'.$value->presc_img.'" target="_blank" style="display:inline-block"><img src="'.$value->presc_img.'" class="thumbnail" style="margin-right:5px; width: 130px; margin-bottom:0px"></a>';
            }
        }

        if(count($non_prescription_order) > 0)
        {
            
            echo '<p><strong>Non Prescriptions:</strong></p>
            <table class="table">
                    <tr>
                        <th> Medicine Name </th>
                        <th> Price </th>
                        <th> Quantity </th>
                    </tr>
            ';
            for($i=0; $i<count($non_prescription_order);$i++)
            {
                $product_info_h = $this->pharmacy_model->getBookedproductInfo($non_prescription_order[$i]->id);
                // echo "<pre>";
                // print_r($non_prescription_order[$i]->id);
                // exit;
                echo '
                    <tr>
                        <td> '.$product_info_h["name"].' </td>
                        <td> '.$product_info_h["price"].' </td>
                        <td> '.$non_prescription_order[$i]->quantity.' </td>
                    </tr>
                ';
            }
            echo '</table></div>
              </div>';
              if($data['status']=='cancelled'){
            echo "<div class='form-group'><label>Reason for cancelled</label><textarea class='form-control' readonly style='height:auto !important'>".$data['cancel_reason']."</textarea></div>";
            }

            if ($this->ion_auth->in_group(array('superadmin')))
            {}elseif(!empty($data['saleman_cancel_reason'])){
                echo "<div class='form-group'><label>Reason of saleman order rejected</label><textarea class='form-control' readonly style='height:auto !important'>".$data['saleman_cancel_reason']."</textarea></div>";
            }

        }
        // echo json_encode($data);
    }
    // end products Orders

    function cancelorder()
    {
        $data = $this->input->post();
        $this->pharmacy_model->cancelProductorder($data);
        $this->session->set_flashdata('feedback', 'Cancelled');  
        redirect($data['redirect_url']);      
    }

    function assignOrdertoSaleman()
    {
        $data = $this->input->post();
        // echo "<pre>";
        // print_r($data);
        // exit;
        $this->home_model->assignordertoSaleman($data);
        $this->session->set_flashdata('feedback','Assigned');
        redirect('home/porders');
    }

    function acceptorderBysaleman($id)
    {
        $this->home_model->acceptorderBySaleman($id);
        $this->session->set_flashdata('feedback','Order Accepted');
        redirect('home/porders');
    }

    function rejectorderBysaleman()
    {
        $data = $this->input->post();
        // echo "<pre>";
        // print_r($data);
        // exit;
        $this->home_model->rejectorderBySaleman($data);
        $this->session->set_flashdata('feedback','Order Rejected');
        redirect('home/porders');
    }

    function markascomplete()
    {
        $data = $this->input->post();
        $proof_of_delivery = str_replace(' ','_',time().$_FILES['proof_of_delivery']['name']);
        $data['proof_of_delivery'] = $proof_of_delivery;
        $this->uploadproOfdelivery($proof_of_delivery);
        $this->home_model->markascompleteOrder($data);
        $this->session->set_flashdata('feedback','Order Completed');
        redirect('home/porders');
    }

    function uploadproOfdelivery($proof_of_delivery)
    {
        $config1 = array(
            'file_name' => $proof_of_delivery,
            'upload_path' => "assets/proof_of_delivery_files/",
            'allowed_types' => "*",
            'overwrite' => False,
            'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "1768",
            'max_width' => "2024"
        );
        $this->load->library('Upload', $config1);
        $this->upload->initialize($config1);
        
        if ($this->upload->do_upload('proof_of_delivery')) {
            // echo "all good here"; exit;
            $path1 = $this->upload->data();
            // $img_url1 = "uploads/" . $path1['file_name'];
            // $img_url = $img_url1;
        } else {
            // echo "Some error occured"; exit;
        }
    }

    function laborders()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['orders'] = $this->pharmacy_model->getlabOrders();
        $data['pharmacies'] = $this->hospital_model->getLaboratories();
        // echo "<pre>";
        // print_r($data['orders']);
        // exit;
        $this->load->view('home/laboratory-dashboard'); // just the header file
        $this->load->view('hospital/pharmacy/laborders', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function labTests()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['labtest'] = $this->home_model->getLabTests();
        // echo "<pre>";
        // print_r($data['labtest']);
        // exit;
        $this->load->view('home/laboratory-dashboard'); // just the header file
        $this->load->view('home/labtest', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addnewlabTest()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['labtest'] = $this->hospital_model->getLaboratories();
        // echo "<pre>";
        // print_r($data['orders']);
        // exit;
        $this->load->view('home/laboratory-dashboard'); // just the header file
        $this->load->view('home/addNewlabTest', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function editlabtest($id)
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['labtest'] = $this->home_model->geteditLabtests($id);
        // echo "<pre>";
        // print_r($data['orders']);
        // exit;
        $this->load->view('home/laboratory-dashboard'); // just the header file
        $this->load->view('home/addNewlabTest', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addnewlabTestpost()
    {
        $data = $this->input->post();
        if(empty($data['id']))
        {
            $lab_test_image = str_replace(' ','_',time().$_FILES['lab_test_image']['name']);
            $data['lab_test_img'] = $lab_test_image;
            $this->uploadprolabTestImage($lab_test_image);
            $this->form_validation->set_rules('description', 'description', 'trim');
            $this->home_model->addNewlabtest_i($data);
            $this->session->set_flashdata('feedback','Added');
        }
        else
        {
            $lab_test_image = str_replace(' ','_',time().$_FILES['lab_test_image']['name']);
            if(empty($_FILES['lab_test_image']['name']))
            {
                $data['lab_test_img'] = $data['old_lab_test_image'];
            }
            else
            {
                $data['lab_test_img'] = $lab_test_image;
                $this->uploadprolabTestImage($lab_test_image);
            }          
            
            $this->home_model->updatelabtest_i($data);
            $this->session->set_flashdata('feedback','updated');
        }
        
        redirect('home/labTests');
        // echo "<pre>";
        // print_r($data);
        // exit;
    }

    function uploadprolabTestImage($lab_test_image)
    {
        $config1 = array(
            'file_name' => $lab_test_image,
            'upload_path' => "assets/lab_test_images/",
            'allowed_types' => "*",
            'overwrite' => False,
            'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "1768",
            'max_width' => "2024"
        );
        $this->load->library('Upload', $config1);
        $this->upload->initialize($config1);
        
        if ($this->upload->do_upload('lab_test_image')) {
            // echo "all good here"; exit;
            $path1 = $this->upload->data();
            // $img_url1 = "uploads/" . $path1['file_name'];
            // $img_url = $img_url1;
        } else {
            // echo "Some error occured"; exit;
        }
    }

    function deletelabtest($id)
    {
        $this->home_model->deletelabtestdata($id);
        $this->session->set_flashdata('feedback','deleted');
        redirect('home/labTests');

    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
