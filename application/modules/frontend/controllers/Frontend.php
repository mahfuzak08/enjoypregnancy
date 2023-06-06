<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// use Dotenv\Dotenv;
// use Square\SquareClient;
// use Square\Models\Money;
// use Square\Models\CreatePaymentRequest;
// use Square\Exceptions\ApiException;
// use Ramsey\Uuid\Uuid;

use ShurjopayPlugin\ShurjopayEnvReader;
use ShurjopayPlugin\Shurjopay;
use ShurjopayPlugin\PaymentRequest;

class Frontend extends MX_Controller {
    private $conf;

    function __construct()
    {
        parent::__construct();
        $this->load->model('auth/general_model');
        $this->load->model('frontend_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('hospital/package_model');
        $this->load->model('patient/patient_model');
        $this->load->model('slide/slide_model');
        $this->load->model('service/service_model');
        $this->load->model('featured/featured_model');
		$this->load->model('payment/payment_model');
		$this->load->model('schedule/schedule_model');
        $this->load->library(array('ion_auth','form_validation'));
        $this->lang->load('auth');
        $this->load->helper(array('form', 'url'));
        $this->load->module('sms');
        date_default_timezone_set('Asia/Dhaka');
    }

    /**
     * Prepare and send HTTP requests using curl library and process response.
     *
     * @param $url Destination URL
     * @param $method POST or GET
     * @param $payload_data
     * @param $header Header options
     * @return mixed
     */
    public function getHttpResponse($url, $method, $payload_data, $header)
    {
        try {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $url,
                    CURLOPT_HTTPHEADER => $header,
                    CURLOPT_POST => 1,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => $payload_data,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    // CURLOPT_FOLLOWLOCATION => true,
                    // CURLOPT_SSL_VERIFYPEER => $this->conf->ssl_verifypeer,
                )
            );
            $response = curl_exec($curl);
            return (json_decode($response));
        }
        catch (Exception $e) {
            print_r("Please check and resolve errors to make successful request ", 0, $e);
        } finally {
            curl_close($curl);
        }
        return null;
    }
	
	public function uuid_v4($trim = false) 
	{
		
		$format = ($trim == false) ? '%04x%04x-%04x-%04x-%04x-%04x%04x%04x' : '%04x%04x%04x%04x%04x%04x%04x%04x';
    	
		return sprintf($format,

			// 32 bits for "time_low"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),

			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,

			// 48 bits for "node"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}

    /**
	 * Shurjopay payment
	 */
	public function shurjoPay_payment(){
		if($_POST["amount"]>0){
            $amount = $_POST["amount"];
            if(strlen($_POST["patient_phone"])>11){
                $_POST["patient_phone"] = substr($_POST["patient_phone"], -11);
            }
            if(strlen($_POST["doctor_phone"])>11){
                $_POST["doctor_phone"] = substr($_POST["doctor_phone"], -11);
            }
            $env = new ShurjopayEnvReader(__DIR__ . '/_env');
            $sp_instance = new Shurjopay($env->getConfig());
            
            $request = new PaymentRequest();
            $request->currency = 'BDT';
            $request->amount = $amount;
            $request->discountAmount = '0';
            $request->discPercent = '0';
            $request->customerName = $_POST["patient_name"];
            $request->customerPhone = $_POST["patient_phone"];
            $request->customerEmail = $_POST["patient_email"];
            $request->customerAddress = $_POST["patient_address"] ? $_POST["patient_address"] : $_POST["doctor_city"];
            $request->customerCity = 'Dhaka';
            $request->customerState = 'Dhaka';
            $request->customerPostcode = '1207';
            $request->customerCountry = 'Bangladesh';
            $request->shippingAddress = $_POST["doctor_city"];
            $request->shippingCity = $_POST["doctor_city"];
            $request->shippingCountry = 'Bangladesh';
            $request->receivedPersonName = $_POST["doctor_name"];
            $request->shippingPhoneNumber = $_POST["doctor_phone"];
            $request->value1 = $_POST["inv_id"];
            $request->value2 = $_POST["patient_id"];
            $request->value3 = $_POST["doctor_id"];
            $request->value4 = 'value4';
            $this->frontend_model->insertPaymentLog($request);
            $sp_instance->makePayment($request);
        }
        else
            redirect('frontend/bookingsuccessfull/'.$_GET["id"]);
	}
    public function spreturn(){
        $env = new ShurjopayEnvReader(__DIR__ . '/_env');
        $sp_instance = new Shurjopay($env->getConfig());


        $response_data = (object)array(
            'Status' => 'No data found'
        );
        
        $_REQUEST['order_id'] = $_REQUEST['order_id'] ? $_REQUEST['order_id'] : $_GET['order_id'];
        
        if ($_REQUEST['order_id'])
        {
            $shurjopay_order_id = trim($_REQUEST['order_id']);
            $response_data = $sp_instance->verifyPayment($shurjopay_order_id);
            if($response_data[0]->sp_code=='1000')
            {
                $this->frontend_model->update_appointment($response_data[0]);
                $db = new SQLite3('products.db');
                $id =  $shurjopay_order_id;
                $name = $response_data[0]->name;
                $price = $response_data[0]->amount;
                $status = $response_data[0]->bank_status;
                $insert_stmt = $db->prepare('INSERT INTO products (id, name, price, status) VALUES (:id, :name, :price, :status)');
                $insert_stmt->bindValue(':id', $id, SQLITE3_TEXT);
                $insert_stmt->bindValue(':name', $name, SQLITE3_TEXT);
                $insert_stmt->bindValue(':price', $price, SQLITE3_FLOAT);
                $insert_stmt->bindValue(':status', $status, SQLITE3_TEXT);
                $result=$insert_stmt->execute();
                // close the database connection
                $db->close();
            }
        }
        $this->frontend_model->insertPaymentLog($response_data[0]);
        redirect('frontend/bookingsuccessfull/'.$response_data[0]->value1);
    }
	
	public function sq_up(){
		$data['base'] = $_GET['base'];
		$data['baseamt'] = $_GET['baseamt'];
		$data['title'] = "MAULAJI-PAYMENT";
		$this->load->view('frontend/sq-up', $data);
	}
	
	public function squareup_payment($postdata)
	{
		$squareup = $this->settings_model->get_api_info('squareup');
		$itemPrice = $postdata['pay_amount']*100;
		$paidCurrency = "GBP";
		$name = $postdata['card_name']; 
		$email = $postdata['email'];
		
		$url = $squareup->key4;
		$args["amount_money"] = array("amount"=> $itemPrice, "currency"=> $paidCurrency);
		$args["idempotency_key"] = $this->uuid_v4();
		$args["source_id"] = $postdata['token_id'];
		$args["location_id"] = $squareup->key3;
		
		$headers = array(
			'Square-Version: '.$squareup->key5,
			'Authorization: Bearer '.$squareup->key6,
			'Content-Type: application/json'
		);
		try{
			$c = curl_init();
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_URL, $url);
			curl_setopt($c, CURLOPT_POST, 1);
			curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($args));
			curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($c);
			curl_close($c);
			$result = json_decode($response, true);
			$transactionID = $result['payment']['id'];
			$arg = array(
				"method"	=> "by_squareup",
				"from"		=> $postdata['pateint_id'],
				"to"		=> $postdata['doct_id'],
				"amount"	=> $itemPrice/100,
				"currency"	=> $paidCurrency,
				"note"		=> "Doctor's Fee Received"
			);
			$trans_id = $this->payment_model->add_update_trans($arg);
			if($trans_id > 0){
				$arg = array(
					"method"		=> "squareup",
					"trans_id"		=> $trans_id,
					"amount"		=> $itemPrice/100,
					"product_name"	=> "Doctor's Fee Received",
					"name"			=> $name,
					"email"			=> $email,
					"transaction_id"=> $transactionID,
					"token_id"		=> $postdata['token_id'],
					"last4"			=> $result['payment']['card_details']['card']['last_4'],
					"customer_id"	=> '',
					"currency"		=> $paidCurrency,
					"note"			=> "Doctor's Fee Received"
				);
				$cttnx = $this->payment_model->add_card_trans($arg);
				
			}
			
			return array("success" => true, "msg"=> "Your Payment has been Successful!", "data"=>$arg, "card_tab_id"=> $cttnx );
		}
		catch (ApiException $e) {
			echo json_encode(array('success'=> false, 'errors' => $e));
		}
	}
	
	public function stripe_payment($postdata)
    {
		require_once('application/libraries/stripe-php/init.php');
		$stripe = $this->settings_model->get_api_info('stripe');
		$stripeSecret = $stripe->key2;
		$payment_id = $statusMsg = ''; 
		$ordStatus = 'error'; 
		$currency = "USD";
		
		if(! empty($postdata['token_id'])){
			$token  = $postdata['token_id']; 
			$name = $postdata['card_name']; 
			$email = $postdata['email']; 
			$itemPrice = $postdata['pay_amount'];
			
			// Set API key 
			\Stripe\Stripe::setApiKey($stripeSecret);
			
			// Add customer to stripe 
			try {  
				$customer = \Stripe\Customer::create(array( 
					'email' => $email, 
					'source'  => $token
				)); 
			}catch(Exception $e) {  
				$api_error = $e->getMessage();  
			}
			
			if(empty($api_error) && $customer){
				// Charge a credit or a debit card 
				try {  
					$charge = \Stripe\Charge::create(array( 
						'customer' => $customer->id, 
						'amount'   => $itemPrice, 
						'currency' => $currency, 
						'description' => "Doctors Fee" 
					)); 
				}catch(Exception $e) {  
					$api_error = $e->getMessage();  
				}
				
				if(empty($api_error) && $charge){         
					// Retrieve charge details 
					$chargeJson = $charge->jsonSerialize(); 
				 
					// Check whether the charge is successful 
					if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
						// Transaction details  
						$transactionID = $chargeJson['balance_transaction']; 
						$paidAmount = $chargeJson['amount']; 
						$paidAmount = ($paidAmount/100); 
						$paidCurrency = $chargeJson['currency']; 
						$payment_status = $chargeJson['status']; 
						
						$arg = array(
							"method"	=> "by_stripe",
							"from"		=> $postdata['pateint_id'],
							"to"		=> $postdata['doct_id'],
							"amount"	=> $itemPrice,
							"currency"	=> $paidCurrency,
							"note"		=> "Doctor's Fee Received"
						);
						$trans_id = $this->payment_model->add_update_trans($arg);
						if($trans_id > 0){
							$arg = array(
								"method"		=> "stripe",
								"trans_id"		=> $trans_id,
								"amount"		=> $itemPrice,
								"product_name"	=> "Doctor's Fee Received",
								"name"			=> $name,
								"email"			=> $email,
								"transaction_id"=> $transactionID,
								"token_id"		=> $token,
								"last4"			=> $chargeJson['payment_method_details']['card']['last4'],
								"customer_id"	=> $customer->id,
								"currency"		=> $paidCurrency,
								"note"			=> "Doctor's Fee Received"
							);
							$cttnx = $this->payment_model->add_card_trans($arg);
							
						}
						
						// If the order is successful 
						if($payment_status == 'succeeded'){ 
							$data = array("success" => true, "msg"=> "Your Payment has been Successful!", "data"=>$arg, "card_tab_id"=> $cttnx );
						}else{ 
							$data = array("success" => false, "msg"=> "Your Payment has Failed!");
						} 
					} else {
						$data = array("success" => false, "msg"=> "Transaction has been failed!");
					} 
				}else{
					$data = array("success" => false, "msg"=> "Charge creation failed! $api_error");
				}
			}
			else{
				$data = array("success" => false, "msg"=> "Invalid card details! $api_error");
			}
			
		}
		else{
			$data = array("success" => false, "msg"=> "Error on form submission.");
		}
		
		// echo json_encode($data);
		return $data;
    }

    // public function index() {
    //     $data = array();
    //     $data['doctors'] = $this->doctor_model->getDoctor();
    //     $data['speciality'] = $this->frontend_model->getSpeciality();
    //     $data['hospitals'] = $this->doctor_model->getHospitals();
    //     $data['packages'] = $this->package_model->getPackage();
    //     $data['slides'] = $this->slide_model->getSlide();
    //     $data['services'] = $this->service_model->getService();
    //     $data['featureds'] = $this->featured_model->getFeatured();
    //     $data['countires'] = $this->frontend_model->getCounries();
    //     $this->load->view('frontend', $data);
    // }

    public function index() {
        $data = array();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['speciality'] = $this->frontend_model->getSpeciality();
        // $data['speciality1'] = $this->frontend_model->getSpecialityFirst10Rows(10, 0);
        // $data['speciality2'] = $this->frontend_model->getSpecialitySecond10Rows(10, 10);
        // $data['speciality3'] = $this->frontend_model->getSpecialityTird10Rows(10, 20);
        // $data['speciality4'] = $this->frontend_model->getSpecialityFourth10Rows(10, 30);
        $data['hospitals'] = $this->doctor_model->getHospitals();
        $data['packages'] = $this->package_model->getPackage();
        $data['slides'] = $this->slide_model->getSlide("Home");
        $data['services'] = $this->service_model->getService();
        $data['featureds'] = $this->featured_model->getFeatured();
        $data['countires'] = $this->frontend_model->getCounries();
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $data['blogs'] = $this->frontend_model->getAllactivePosts();
        // $data['citiesdata'] = $this->frontend_model->getcitiesdata();
        $this->load->view('includes/header.php');
        $this->load->view('frontend/frontend_new', $data);
        $this->load->view('includes/footer.php');
    }
    function sendapplink()
    {
        $to = '+'.$_GET['phone_number'];
        $message = "Download the App:\n  https://play.google.com/store/apps/details?id=com.telemedicine.maulaji&hl=en_GB&gl=US";
        // $message .= "IOS APP:\n https://play.google.com/store/apps/details?id=com.telemedicine.callgpnow&hl=en_GB&gl=US";
        $res = $this->sms->sendSmsapplink($to, $message);
        echo 1;
    }
    public function addNew() {
        $id = $this->input->post('id');

        $patient = $this->input->post('patient');

        $doctor = $this->input->post('doctor');
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = strtotime($date);
        }

        $time_slot = $this->input->post('time_slot');

        $time_slot_explode = explode('To', $time_slot);

        $s_time = trim($time_slot_explode[0]);
        $e_time = trim($time_slot_explode[1]);


        $remarks = $this->input->post('remarks');

        $sms = $this->input->post('sms');

        $status = 'Requested';

        $redirect = 'frontend';

        $request = 'Yes';

        $user = '';

        if ((empty($id))) {
            $add_date = date('m/d/y');
            $registration_time = time();
            $patient_add_date = $add_date;
            $patient_registration_time = $registration_time;
        }

        $s_time_key = $this->getArrayKey($s_time);

        $p_name = $this->input->post('p_name');
        $p_email = $this->input->post('p_email');
        if (empty($p_email)) {
            $p_email = $p_name . '-' . rand(1, 1000) . '-' . $p_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($p_name)) {
            $password = $p_name . '-' . rand(1, 100000000);
        }
        $p_phone = $this->input->post('p_phone');
        $p_age = $this->input->post('p_age');
        $p_gender = $this->input->post('p_gender');
        $patient_id = rand(10000, 1000000);

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($patient == 'add_new') {
            $this->form_validation->set_rules('p_name', 'Patient Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('p_phone', 'Patient Phone', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }

        if ($patient == 'patient_id') {
            $this->form_validation->set_rules('patient_id', 'Patient Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }

        // Validating Name Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Doctor Field
        $this->form_validation->set_rules('doctor', 'Doctor', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Date Field
        $this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|min_length[1]|max_length[1000]|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('feedback', 'Form Validation Error !');
            redirect("frontend");
        } else {

            if ($patient == 'patient_id') {
                $patient = $this->input->post('patient_id');

                if (!empty($patient)) {
                    $patient_exist = $this->patient_model->getPatientById($patient)->id;
                }

                if (empty($patient_exist)) {
                    $this->session->set_flashdata('feedback', 'Invalid Patient Id !');
                    redirect("frontend");
                }
            }

            if ($patient == 'add_new') {
                $data_p = array(
                    'patient_id' => $patient_id,
                    'name' => $p_name,
                    'email' => $p_email,
                    'phone' => $p_phone,
                    'sex' => $p_gender,
                    'age' => $p_age,
                    'add_date' => $patient_add_date,
                    'registration_time' => $patient_registration_time,
                    'how_added' => 'from_appointment'
                );
                $username = $this->input->post('p_name');
                // Adding New Patient
                if ($this->ion_auth->email_check($p_email)) {
                    $this->session->set_flashdata('feedback', 'Email Address of Patient Is Already Registered');
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $p_email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $p_email))->row()->id;
                    $this->patient_model->insertPatient($data_p);
                    $patient_user_id = $this->db->get_where('patient', array('email' => $p_email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->patient_model->updatePatient($patient_user_id, $id_info);
                }

                $patient = $patient_user_id;
                //    }
            }
            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'patient' => $patient,
                'doctor' => $doctor,
                'date' => $date,
                's_time' => $s_time,
                'e_time' => $e_time,
                'time_slot' => $time_slot,
                'remarks' => $remarks,
                'add_date' => $add_date,
                'registration_time' => $registration_time,
                'status' => $status,
                's_time_key' => $s_time_key,
                'user' => $user,
                'request' => $request
            );
            $username = $this->input->post('name');
            if (empty($id)) {     // Adding New department
                $this->frontend_model->insertAppointment($data);

                if (!empty($sms)) {
                    $this->sms->sendSmsDuringAppointment($patient, $doctor, $date, $s_time, $e_time);
                }

                $patient_doctor = $this->patient_model->getPatientById($patient)->doctor;

                $patient_doctors = explode(',', $patient_doctor);

                if (!in_array($doctor, $patient_doctors)) {
                    $patient_doctors[] = $doctor;
                    $doctorss = implode(',', $patient_doctors);
                    $data_d = array();
                    $data_d = array('doctor' => $doctorss);
                    $this->patient_model->updatePatient($patient, $data_d);
                }
                $this->session->set_flashdata('feedback', 'Appointment Added Successfully. Please wait. You will get a confirmation sms.');
            }

            if (!empty($redirect)) {
                redirect($redirect);
            } else {
                redirect('appointment');
            }
        }
    }

    function getArrayKey($s_time) {
        $all_slot = array(
            0 => '12:00 PM',
            1 => '12:05 AM',
            2 => '12:10 AM',
            3 => '12:15 AM',
            4 => '12:20 AM',
            5 => '12:25 AM',
            6 => '12:30 AM',
            7 => '12:35 AM',
            8 => '12:40 PM',
            9 => '12:45 AM',
            10 => '12:50 AM',
            11 => '12:55 AM',
            12 => '01:00 AM',
            13 => '01:05 AM',
            14 => '01:10 AM',
            15 => '01:15 AM',
            16 => '01:20 AM',
            17 => '01:25 AM',
            18 => '01:30 AM',
            19 => '01:35 AM',
            20 => '01:40 AM',
            21 => '01:45 AM',
            22 => '01:50 AM',
            23 => '01:55 AM',
            24 => '02:00 AM',
            25 => '02:05 AM',
            26 => '02:10 AM',
            27 => '02:15 AM',
            28 => '02:20 AM',
            29 => '02:25 AM',
            30 => '02:30 AM',
            31 => '02:35 AM',
            32 => '02:40 AM',
            33 => '02:45 AM',
            34 => '02:50 AM',
            35 => '02:55 AM',
            36 => '03:00 AM',
            37 => '03:05 AM',
            38 => '03:10 AM',
            39 => '03:15 AM',
            40 => '03:20 AM',
            41 => '03:25 AM',
            42 => '03:30 AM',
            43 => '03:35 AM',
            44 => '03:40 AM',
            45 => '03:45 AM',
            46 => '03:50 AM',
            47 => '03:55 AM',
            48 => '04:00 AM',
            49 => '04:05 AM',
            50 => '04:10 AM',
            51 => '04:15 AM',
            52 => '04:20 AM',
            53 => '04:25 AM',
            54 => '04:30 AM',
            55 => '04:35 AM',
            56 => '04:40 AM',
            57 => '04:45 AM',
            58 => '04:50 AM',
            59 => '04:55 AM',
            60 => '05:00 AM',
            61 => '05:05 AM',
            62 => '05:10 AM',
            63 => '05:15 AM',
            64 => '05:20 AM',
            65 => '05:25 AM',
            66 => '05:30 AM',
            67 => '05:35 AM',
            68 => '05:40 AM',
            69 => '05:45 AM',
            70 => '05:50 AM',
            71 => '05:55 AM',
            72 => '06:00 AM',
            73 => '06:05 AM',
            74 => '06:10 AM',
            75 => '06:15 AM',
            76 => '06:20 AM',
            77 => '06:25 AM',
            78 => '06:30 AM',
            79 => '06:35 AM',
            80 => '06:40 AM',
            81 => '06:45 AM',
            82 => '06:50 AM',
            83 => '06:55 AM',
            84 => '07:00 AM',
            85 => '07:05 AM',
            86 => '07:10 AM',
            87 => '07:15 AM',
            88 => '07:20 AM',
            89 => '07:25 AM',
            90 => '07:30 AM',
            91 => '07:35 AM',
            92 => '07:40 AM',
            93 => '07:45 AM',
            94 => '07:50 AM',
            95 => '07:55 AM',
            96 => '08:00 AM',
            97 => '08:05 AM',
            98 => '08:10 AM',
            99 => '08:15 AM',
            100 => '08:20 AM',
            101 => '08:25 AM',
            102 => '08:30 AM',
            103 => '08:35 AM',
            104 => '08:40 AM',
            105 => '08:45 AM',
            106 => '08:50 AM',
            107 => '08:55 AM',
            108 => '09:00 AM',
            109 => '09:05 AM',
            110 => '09:10 AM',
            111 => '09:15 AM',
            112 => '09:20 AM',
            113 => '09:25 AM',
            114 => '09:30 AM',
            115 => '09:35 AM',
            116 => '09:40 AM',
            117 => '09:45 AM',
            118 => '09:50 AM',
            119 => '09:55 AM',
            120 => '10:00 AM',
            121 => '10:05 AM',
            122 => '10:10 AM',
            123 => '10:15 AM',
            124 => '10:20 AM',
            125 => '10:25 AM',
            126 => '10:30 AM',
            127 => '10:35 AM',
            128 => '10:40 AM',
            129 => '10:45 AM',
            130 => '10:50 AM',
            131 => '10:55 AM',
            132 => '11:00 AM',
            133 => '11:05 AM',
            134 => '11:10 AM',
            135 => '11:15 AM',
            136 => '11:20 AM',
            137 => '11:25 AM',
            138 => '11:30 AM',
            139 => '11:35 AM',
            140 => '11:40 AM',
            141 => '11:45 AM',
            142 => '11:50 AM',
            143 => '11:55 AM',
            144 => '12:00 AM',
            145 => '12:05 PM',
            146 => '12:10 PM',
            147 => '12:15 PM',
            148 => '12:20 PM',
            149 => '12:25 PM',
            150 => '12:30 PM',
            151 => '12:35 PM',
            152 => '12:40 PM',
            153 => '12:45 PM',
            154 => '12:50 PM',
            155 => '12:55 PM',
            156 => '01:00 PM',
            157 => '01:05 PM',
            158 => '01:10 PM',
            159 => '01:15 PM',
            160 => '01:20 PM',
            161 => '01:25 PM',
            162 => '01:30 PM',
            163 => '01:35 PM',
            164 => '01:40 PM',
            165 => '01:45 PM',
            166 => '01:50 PM',
            167 => '01:55 PM',
            168 => '02:00 PM',
            169 => '02:05 PM',
            170 => '02:10 PM',
            171 => '02:15 PM',
            172 => '02:20 PM',
            173 => '02:25 PM',
            174 => '02:30 PM',
            175 => '02:35 PM',
            176 => '02:40 PM',
            177 => '02:45 PM',
            178 => '02:50 PM',
            179 => '02:55 PM',
            180 => '03:00 PM',
            181 => '03:05 PM',
            182 => '03:10 PM',
            183 => '03:15 PM',
            184 => '03:20 PM',
            185 => '03:25 PM',
            186 => '03:30 PM',
            187 => '03:35 PM',
            188 => '03:40 PM',
            189 => '03:45 PM',
            190 => '03:50 PM',
            191 => '03:55 PM',
            192 => '04:00 PM',
            193 => '04:05 PM',
            194 => '04:10 PM',
            195 => '04:15 PM',
            196 => '04:20 PM',
            197 => '04:25 PM',
            198 => '04:30 PM',
            199 => '04:35 PM',
            200 => '04:40 PM',
            201 => '04:45 PM',
            202 => '04:50 PM',
            203 => '04:55 PM',
            204 => '05:00 PM',
            205 => '05:05 PM',
            206 => '05:10 PM',
            207 => '05:15 PM',
            208 => '05:20 PM',
            209 => '05:25 PM',
            210 => '05:30 PM',
            211 => '05:35 PM',
            212 => '05:40 PM',
            213 => '05:45 PM',
            214 => '05:50 PM',
            215 => '05:55 PM',
            216 => '06:00 PM',
            217 => '06:05 PM',
            218 => '06:10 PM',
            219 => '06:15 PM',
            220 => '06:20 PM',
            221 => '06:25 PM',
            222 => '06:30 PM',
            223 => '06:35 PM',
            224 => '06:40 PM',
            225 => '06:45 PM',
            226 => '06:50 PM',
            227 => '06:55 PM',
            228 => '07:00 PM',
            229 => '07:05 PM',
            230 => '07:10 PM',
            231 => '07:15 PM',
            232 => '07:20 PM',
            233 => '07:25 PM',
            234 => '07:30 PM',
            235 => '07:35 PM',
            236 => '07:40 PM',
            237 => '07:45 PM',
            238 => '07:50 PM',
            239 => '07:55 PM',
            240 => '08:00 PM',
            241 => '08:05 PM',
            242 => '08:10 PM',
            243 => '08:15 PM',
            244 => '08:20 PM',
            245 => '08:25 PM',
            246 => '08:30 PM',
            247 => '08:35 PM',
            248 => '08:40 PM',
            249 => '08:45 PM',
            250 => '08:50 PM',
            251 => '08:55 PM',
            252 => '09:00 PM',
            253 => '09:05 PM',
            254 => '09:10 PM',
            255 => '09:15 PM',
            256 => '09:20 PM',
            257 => '09:25 PM',
            258 => '09:30 PM',
            259 => '09:35 PM',
            260 => '09:40 PM',
            261 => '09:45 PM',
            262 => '09:50 PM',
            263 => '09:55 PM',
            264 => '10:00 PM',
            265 => '10:05 PM',
            266 => '10:10 PM',
            267 => '10:15 PM',
            268 => '10:20 PM',
            269 => '10:25 PM',
            270 => '10:30 PM',
            271 => '10:35 PM',
            272 => '10:40 PM',
            273 => '10:45 PM',
            274 => '10:50 PM',
            275 => '10:55 PM',
            276 => '11:00 PM',
            277 => '11:05 PM',
            278 => '11:10 PM',
            279 => '11:15 PM',
            280 => '11:20 PM',
            281 => '11:25 PM',
            282 => '11:30 PM',
            283 => '11:35 PM',
            284 => '11:40 PM',
            285 => '11:45 PM',
            286 => '11:50 PM',
            287 => '11:55 PM',
        );

        $key = array_search($s_time, $all_slot);
        return $key;
    }

    public function settings() {
        if (!$this->ion_auth->in_group('superadmin')) {
            redirect('home/permission');  
        }
        $data = array();
        $data['settings'] = $this->frontend_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('settings', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    public function update() {
        if (!$this->ion_auth->in_group('superadmin')) {
            redirect('home/permission');  
        }
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $emergency = $this->input->post('emergency');
        $support = $this->input->post('support');
        $currency = $this->input->post('currency');
        $logo = $this->input->post('logo');
        $block_1_text_under_title = $this->input->post('block_1_text_under_title');
        $service_block_text_under_title = $this->input->post('service_block__text_under_title');
        $doctor_block_text_under_title = $this->input->post('doctor_block__text_under_title');

        $facebook_id = $this->input->post('facebook_id');
        $twitter_id = $this->input->post('twitter_id');
        $twitter_username = $this->input->post('twitter_username');
        $google_id = $this->input->post('google_id');
        $youtube_id = $this->input->post('youtube_id');
        $skype_id = $this->input->post('skype_id');


        if (!empty($email)) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            // Validating Title Field
            $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            // Validating Email Field
            $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            // Validating Address Field   
            $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[1]|max_length[1000]|xss_clean');
            // Validating Phone Field           
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('currency', 'Currency', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('logo', 'Logo', 'trim|min_length[1]|max_length[1000]|xss_clean');

            // Validating Currency Field   
            $this->form_validation->set_rules('emergency', 'Emergency', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('support', 'Support', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('logo', 'Logo', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('block_1_text_under_title', 'Block 1 Text Under Title', 'trim|min_length[1]|max_length[500]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('service_block__text_under_title', 'Service Block Text Under Title', 'trim|min_length[1]|max_length[500]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('doctor_block__text_under_title', 'Doctor Block Text Under Title', 'trim|min_length[1]|max_length[500]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('facebook_id', 'Facebook Id', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('twitter_id', 'Teitter Id', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('twitter_username', 'Teitter Username', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('google_id', 'Google Id', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('youtube_id', 'Youtube Id', 'trim|min_length[1]|max_length[100]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('skype_id', 'Skype Id', 'trim|min_length[1]|max_length[100]|xss_clean');


            if ($this->form_validation->run() == FALSE) {
                $data = array();
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('settings', $data);
                $this->load->view('home/footer'); // just the footer file
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
                        'title' => $title,
                        'address' => $address,
                        'phone' => $phone,
                        'email' => $email,
                        'currency' => $currency,
                        'emergency' => $emergency,
                        'support' => $support,
                        'block_1_text_under_title' => $block_1_text_under_title,
                        'service_block__text_under_title' => $service_block_text_under_title,
                        'doctor_block__text_under_title' => $doctor_block_text_under_title,
                        'facebook_id' => $facebook_id,
                        'twitter_id' => $twitter_id,
                        'twitter_username' => $twitter_username,
                        'google_id' => $google_id,
                        'youtube_id' => $youtube_id,
                        'skype_id' => $skype_id,
                        'logo' => $img_url
                    );
                } else {
                    $data = array();
                    $data = array(
                        'title' => $title,
                        'address' => $address,
                        'phone' => $phone,
                        'email' => $email,
                        'currency' => $currency,
                        'emergency' => $emergency,
                        'support' => $support,
                        'block_1_text_under_title' => $block_1_text_under_title,
                        'service_block__text_under_title' => $service_block_text_under_title,
                        'doctor_block__text_under_title' => $doctor_block_text_under_title,
                        'facebook_id' => $facebook_id,
                        'twitter_id' => $twitter_id,
                        'twitter_username' => $twitter_username,
                        'google_id' => $google_id,
                        'youtube_id' => $youtube_id,
                        'skype_id' => $skype_id,
                    );
                }
                //$error = array('error' => $this->upload->display_errors());

                $this->frontend_model->updateSettings($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
                // Loading View
                redirect('frontend/settings');
            }
        } else {
            $this->session->set_flashdata('feedback', 'Email Required!');
            redirect('frontend/settings', 'refresh');
        }
    }
    
    function getcities()
    {
        $country_id = $this->input->post('country_id');
        $res = $this->frontend_model->getcitiesdata($country_id);
        foreach($res as $value)
        {
            echo '<li class="list-group-item" onclick="cityval('."'".$value->city_ascii."'".')"><i class="fa fa-search"></i> &nbsp;'.$value->city_ascii.'</li>';
        }
    }
    
    function getcities2()
    {
        $country_id = $this->input->post('country_id');
        $res = $this->frontend_model->getcitiesdata($country_id);
        foreach($res as $value)
        {
            echo '<option value="'.$value->city_ascii.'">'.$value->city_ascii.'</option>';
        }
    }
    
    function searchdoctors()
    {
        $data = array();
        $data = $_GET;
        // if(empty($data['speciality']))
        // {
            $data['doctors'] = $this->frontend_model->getdoctorslist($_GET);
        // }
        // else
        // {
        //     $data['doctors'] = $this->frontend_model->getdoctorslistByspiciality($data);
        // }
        // print_r($data);
        
        // $data['speciality'] = $this->frontend_model->getSpeciality();
        // $data['hospitals'] = $this->doctor_model->getHospitals();
        $data['countires'] = $this->frontend_model->getCounries();
        $data['rating'] = $this->frontend_model->countDoctorRating();
        $this->load->view('includes/header.php');
        $this->load->view('doctorslist_new', $data);
        $this->load->view('includes/footer.php');
    }
    function doctorslist()
    {
        $data = array();
        $data = $_GET;
        $data['doctors'] = $this->frontend_model->getdoctorslist($data);
        $data['speciality'] = $this->frontend_model->getSpeciality();
        $data['hospitals'] = $this->doctor_model->getHospitals();
        $data['countires'] = $this->frontend_model->getCounries();
        $this->load->view('includes/header.php');
        $this->load->view('doctorslist', $data);
        $this->load->view('includes/footer.php');
    }
    function checkthistimeslots()
    {
        // if(!$this->ion_auth->logged_in())
        // {
        //     $data_arr = array('status'=>'not_login','app_count'=>0,'p_id'=>0);
        //     echo json_encode($data_arr);
        //     exit;
        // }
        // else
        // {
      //       $pat_auth_id = $this->ion_auth->user()->row()->user_id;
		    // $p_data = $this->frontend_model->getpatId($pat_auth_id);
		    // if(empty($p_data))
		    // {
		    //     $data_arr = array('status'=>'not_login','app_count'=>0,'p_id'=>0);
      //           echo json_encode($data_arr);
      //           exit;
		    // }
            $data = $this->input->post();
            $result = $this->frontend_model->getbookedslots($data);
            
      //       $pat_auth_id = $this->ion_auth->user()->row()->user_id;
		    // $p_data = $this->frontend_model->getpatId($pat_auth_id);
		    
            $data_arr = array('status'=>'loggedin','app_count'=>$result,'p_id'=>0);
            echo json_encode($data_arr);
            exit;
        // }
    }
    
    function userauthenticate()
    {
        // $data = $this->input->post();
        // $result = $this->frontend_model->checkuserdata($data);
        $remember = "";
        if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
		{
		    $pat_auth_id = $this->ion_auth->user()->row()->user_id;
		    $p_data = $this->frontend_model->getpatId($pat_auth_id);
            // $this->session->set_flashdata('message', $this->ion_auth->messages());
            // redirect('home', 'refresh');
            if(!empty($p_data))
            {
                $data_arr = array('status'=>'loggedin','p_id'=>$p_data->id);
            }
            else
            {
                $this->ion_auth->logout();
                $data_arr = array('status'=>'invalid','p_id'=>0);
            }
            echo json_encode($data_arr);
		}
		else
		{
            // $this->session->set_flashdata('message', $this->ion_auth->errors());
            // redirect('auth/login', 'refresh'); 
            $data_arr = array('status'=>'invalid','p_id'=>0);
            echo json_encode($data_arr);
            // echo "invalid_data";
		}
    }
    
    function bookappointment()
    {
        $data = array();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['speciality'] = $this->frontend_model->getSpeciality();
        $data['hospitals'] = $this->doctor_model->getHospitals();
        $data['packages'] = $this->package_model->getPackage();
        $data['slides'] = $this->slide_model->getSlide();
        $data['services'] = $this->service_model->getService();
        $data['featureds'] = $this->featured_model->getFeatured();
        $data['countires'] = $this->frontend_model->getCounries();
        $this->load->view('frontend/bookappointment', $data);   
    }
    
    public function doctorvisit() 
    {
        $data = array();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['speciality'] = $this->frontend_model->getSpeciality();
        $data['hospitals'] = $this->doctor_model->getHospitals();
        $data['packages'] = $this->package_model->getPackage();
        $data['slides'] = $this->slide_model->getSlide();
        $data['services'] = $this->service_model->getService();
        $data['featureds'] = $this->featured_model->getFeatured();
        // $data['countires'] = $this->frontend_model->getCounries();
        $this->load->view('homevisit', $data);
    }

    function getvisitorlocation()
    {
        //if latitude and longitude are submitted
        if(!empty($this->input->post('latitude')) && !empty($this->input->post('longitude')))
        {
            //send request and receive json data by latitude and longitude
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($this->input->post('latitude')).','.trim($this->input->post('longitude')).'&key=AIzaSyDnUEGim3Z6VsndogcDOjee5wAf6p7xz34&sensor=false';
            $json = @file_get_contents($url);
            $data = json_decode($json);
            $status = $data->status;
            print_r($data); exit();
            //if request status is successful
            if($status == "OK"){
                //get address from json data
                $location = $data->results[0]->formatted_address;
            }else{
                $location =  '';
            }
            
            //return address to ajax 
            echo $location;
        }
    }

    public function consult_urgent_docotrs()
    {
        $data = array();
        $data1 = array();
        $data['speciality'] = $this->frontend_model->getSpeciality();
        $data['hospitals'] = $this->doctor_model->getHospitals();
        $data['countires'] = $this->frontend_model->getCounries();
        if(isset($_GET))
        {
            $data1 = $_GET;
        }        
        // echo "<pre>";
        // print_r($data1);
        // exit;
        // $data['citiesdata'] = $this->frontend_model->getcitiesdata();
        $data['doctors_data'] = $this->frontend_model->getconultation_doctors($data1);
        $data['rating'] = $this->frontend_model->countDoctorRating();
        $this->load->view('includes/header.php');
        $this->load->view('frontend/consult-urgent-doctor.php', $data);
        $this->load->view('includes/footer.php');
    }
	
	function book_doctor_by_hospital($id)
    {
        $id = urldecode($id);
        $data = array();
        $this->load->model('hospital/hospital_model');
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $data['hospital_data'] = $this->hospital_model->getHospitalById($id);
        $this->load->view('includes/header.php');
        $this->load->view('frontend/booking-by-hospital.php', $data);
        $this->load->view('includes/footer.php');        
    }

    public function book_home_visit()
    {
        $data = array();
        $data1 = array();
        $data['speciality'] = $this->frontend_model->getSpeciality();
        $data['hospitals'] = $this->doctor_model->getHospitals();
        $data['countires'] = $this->frontend_model->getCounries();
        $data['rating'] = $this->frontend_model->countDoctorRating();
        // $data['citiesdata'] = $this->frontend_model->getcitiesdata();
        if(isset($_GET))
        {
            $data1 = $_GET;
        }
        $data['doctors_data'] = $this->frontend_model->get_home_visit_doctors($data1);
        $this->load->view('includes/header.php');
        $this->load->view('frontend/book_home_visit_doctors.php', $data);
        $this->load->view('includes/footer.php');
    }

    function book_urgent_consultation($id)
    {
        $id = urldecode($id);
        $data = array();
        $data['doctor_id'] = $id;
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $data['doctor_data'] = $this->frontend_model->getDoctordataByid($id);
        $this->load->view('includes/header.php');
        $this->load->view('frontend/urgent-consultation.php', $data);
        $this->load->view('includes/footer.php');        
    }

    function book_doctor_home_visit($id)
    {
        $id = urldecode($id);
        $data = array();
        $data['doctor_id'] = $id;
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $data['doctor_data'] = $this->frontend_model->getDoctordataByid($id);
        $this->load->view('includes/header.php');
        $this->load->view('frontend/home-visit-booking.php', $data);
        $this->load->view('includes/footer.php');        
    }

    function doctor_profile($dr_id)
    {
        $data = array();
        $data['doctor_profile_data'] = $this->doctor_model->getDoctorProfiledata($dr_id);
		$data['doctor_review'] = $this->frontend_model->getDoctorReview($dr_id);
		$data['rating'] = $this->frontend_model->countDoctorRating($dr_id);
		$data['favourite'] = 0;
		if($this->ion_auth->logged_in())
        {
            $patient_ion_id = $this->ion_auth->get_user_id();
			$patient_data = $this->frontend_model->getpatiendatabyId($patient_ion_id);
			$data['favourite'] = $this->frontend_model->is_favourite($dr_id, $patient_data->id);
        }
        $this->load->view('includes/header.php');
        $this->load->view('frontend/doctor-profile.php', $data);
        $this->load->view('includes/footer.php');
    }
    
    function add_review()
	{
		if(!$this->ion_auth->logged_in())
        {
            redirect('frontend');
        }
		$post = $this->input->post();
		$id = $this->frontend_model->addReview($post);
		redirect('frontend/doctor_profile/'.$post['doctor_id']);
	}
	
    /**
     * type = app/ home (appointment/ home visite(not req now))
     */
	function send_appointment_invoice($id, $type='app'){
	    if($type == 'app'){
	        $invoice = $this->frontend_model->get_app_invoice($id);
	        $title = "consultant";
	        $payment = 'Card No: '.@$invoice[0]['last4'].'<br>'.@$invoice[0]['transaction_id'];
	    }
	    elseif($type == 'home'){
	        $invoice = $this->frontend_model->get_homve_invoice($id);
	        $title = "hove visite";
	        $payment = 'Pay by Cash';
	    }
	    else exit();
        $settings = $this->frontend_model->getSettings();

		$this->email->from('no-replay@enjoypregnancy.org', $settings->title);
        $this->email->to(array($invoice[0]['doctor_email'], $invoice[0]['patient_email']));
        $this->email->bcc(array($settings->email, 'mahfuzak08@gmail.com'));
        $this->email->subject("Your $title appointment has been booked in ".$settings->web_address." - Order #$id");
		$message = '<!DOCTYPE html><html> <head></head> <body> <br><br><br><div style="width: 700px;height: auto;background-color: #FFF;position: absolute;top:100;bottom: 0;left: 0;right: 0;margin: auto;color:black;font-size: 18px;"> <div style="padding:10px;"> <table style="width:100%;border-collapse: collapse;"> <tr> <td style="width:50%;border-bottom:1px solid #BBB;"><img src="'.$settings->web_address.'/'.$settings->logo.'" style="max-width: 200px"></td><td style="width:50%;border-bottom:1px solid #BBB;text-align:right;"><strong>Order No:</strong> #'.$invoice[0]['id'].' <br><strong>Issued:</strong> '. explode(" ", $invoice[0]['add_date'])[0].' </td></tr><tr> <td style="width:50%;"> <p><strong>Invoice From</strong><br>'.$invoice[0]['doctor_name'].' <br>'.$invoice[0]['doctor_phone'].'<br>'.$invoice[0]['doctor_email'].'<br>'.$invoice[0]['doctor_city'].', '.$invoice[0]['doctor_country'].'</p></td><td style="width:50%; text-align:right;"> <p><strong>Invoice To</strong><br>'.$invoice[0]['patient_name'].'<br>'.$invoice[0]['patient_phone'].'<br>'.$invoice[0]['patient_address'].'<br><strong>Gender: </strong>'.strtoupper($invoice[0]['patient_gender']).'</p></td></tr><tr> <td style="width:50%;"> <p><strong>Payment Method</strong><br>'.$payment.'</p></td><td style="width:50%; text-align:right;"><p><strong>Appointment Info</strong><br>Date: '.$invoice[0]['date'].'<br>Status: '.$invoice[0]['status'].'</p></td></tr><tr> <td colspan="2"> <br><br><table style="width: 100%; border-collapse: collapse;"> <thead> <tr> <th style="border-bottom:1px solid #BBB; text-align: left">Description</th> <th style="border-bottom:1px solid #BBB; text-align: center">Quantity</th> <th style="border-bottom:1px solid #BBB; text-align: center">VAT</th> <th style="border-bottom:1px solid #BBB; text-align: right">Total</th> </tr></thead> <tbody> <tr> <td style="border-bottom:1px solid #BBB; text-align: left">General Consultation</td><td style="border-bottom:1px solid #BBB; text-align: center">1</td><td style="border-bottom:1px solid #BBB; text-align: center">$0</td><td style="border-bottom:1px solid #BBB; text-align: right">$'.@$invoice[0]['amount'].'</td></tr><tr> <td style="border-bottom:1px solid #BBB; text-align: left">Chat/ Audio/ Video Call Booking</td><td style="border-bottom:1px solid #BBB; text-align: center">1</td><td style="border-bottom:1px solid #BBB; text-align: center">$0</td><td style="border-bottom:1px solid #BBB; text-align: right">Free</td></tr><tr> <td colspan="2"> </td><td style="border-bottom:1px solid #BBB; text-align: left; font-weight:700;">Subtotal</td><td style="border-bottom:1px solid #BBB; text-align: right; font-weight:700;">$'.@$invoice[0]['amount'].'</td></tr><tr> <td colspan="2"> </td><td style="border-bottom:1px solid #BBB; text-align: left; font-weight:700;">Discount</td><td style="border-bottom:1px solid #BBB; text-align: right; font-weight:700;"></td></tr><tr> <td colspan="2"> </td><td style="border-bottom:1px solid #BBB; text-align: left; font-weight:700;">Total</td><td style="border-bottom:1px solid #BBB; text-align: right; font-weight:700;">$'.@$invoice[0]['amount'].'</td></tr></tbody> </table> </td></tr><tr><td colspan="2"><h4>Other information</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed dictum ligula, cursus blandit risus. Maecenas eget metus non tellus dignissim aliquam ut a ex. Maecenas sed vehicula dui, ac suscipit lacus. Sed finibus leo vitae lorem interdum, eu scelerisque tellus fermentum. Curabitur sit amet lacinia lorem. Nullam finibus pellentesque libero.</p></td></tr></table> </div></div></div></body></html>';
        $this->email->message($message);
		$this->email->send();
// 		print_r($invoice);
	}
	
    function bookingsuccessfull($id)
    {
		$data = array();
		$this->send_appointment_invoice($id, 'app');
		$data['invoice'] = $this->frontend_model->get_app_invoice($id);
        $this->load->view('includes/header.php');
        $this->load->view('frontend/booking-success.php', $data);
        $this->load->view('includes/footer.php');
    }

    // function bookconsultnow()
    // {
    //     $data = $this->input->post();
	// 	if($data['pay_amount'] > 0){
	// 		if($data['payment_method'] == 'by_stripe')
	// 			$data['payment'] = $this->stripe_payment($data);
	// 		elseif($data['payment_method'] == 'by_squareup'){
	// 			$data['payment'] = $this->squareup_payment($data);
	// 		}
			
	// 		if($data['payment']['success'] == true){
	// 			$res = $this->frontend_model->insert_urgent_consult_booking_data($data);
	// 			if($res>0)
	// 			{
	// 				$this->payment_model->add_update_trans(array('id'=>$data['payment']['data']['trans_id'], 'update_order'=> true, 'order_no'=>$res, 'order_type'=>'appointment'));
	// 				redirect('frontend/bookingsuccessfull/'.$res);
	// 			}
	// 			else{
	// 				$this->session->set_flashdata('error_msg','Appointment booking error.');
	// 				redirect('frontend/book_appointment/'.$data['doct_id']);
	// 			}
	// 		}else{
	// 			$this->session->set_flashdata('error_msg','Appointment booking error.');
	// 			redirect('frontend/book_appointment/'.$data['doct_id']);
	// 		}
	// 	}
	// 	else{
	// 		$res = $this->frontend_model->insert_urgent_consult_booking_data($data);
	// 		if($res>0)
	// 		{
	// 			redirect('frontend/bookingsuccessfull/'.$res);
	// 		}
	// 		else{
	// 			$this->session->set_flashdata('error_msg','Appointment booking error.');
	// 			redirect('frontend/book_appointment/'.$data['doct_id']);
	// 		}
	// 	}
    // }
    function bookconsultnow()
    {
        $data = $this->input->post();
        $res = $this->frontend_model->insert_urgent_consult_booking_data($data);
        if($res>0)
        {
            // $this->payment_model->add_update_trans(array('id'=>$data['payment']['data']['trans_id'], 'update_order'=> true, 'order_no'=>$res, 'order_type'=>'appointment'));
            redirect('frontend/bookingsuccessfull_payment_notdone/'.$res);
            // redirect('frontend/bookingsuccessfull/'.$res);
        }
        else{
            $this->session->set_flashdata('error_msg','Appointment booking error.');
            redirect('frontend/booknormalappointmentwithdoctor?doctor_id='.$data['doct_id']);
        }
    }
    function bookingsuccessfull_payment_notdone($id){
        $data = array();
		// $this->send_appointment_invoice($id, 'app');
		$data['invoice'] = $this->frontend_model->get_app_invoice($id);
        $this->load->view('includes/header.php');
        $this->load->view('frontend/booking-success1.php', $data);
        $this->load->view('includes/footer.php');
    }
    function bookhomevisittnow()
    {
        $data = $this->input->post();
        $res = $this->frontend_model->insert_home_visit_booking_data($data);
        if($res)
        {
            $this->session->set_flashdata('success_msg','Appointment for home visit booked with <strong>Dr. '.$data['doct_name'].'</strong><br> on <strong>'.date('d M, Y', strtotime(str_replace('/','-',$data['date']))).'</strong>');
            // redirect('frontend/bookingsuccessfull');
			$this->send_appointment_invoice($res, 'home');
			$this->load->view('includes/header.php');
			$this->load->view('frontend/booking-success-old.php', $data);
			$this->load->view('includes/footer.php');
        }
    }
	
	function add_favourites($dr_id)
	{
		if(!$this->ion_auth->logged_in())
        {
            $data['loginornot'] = 0;
			$this->session->set_flashdata('error_msg','You need to login first to continue.');
        }
		elseif(!$this->ion_auth->in_group('Patient'))
		{
			$this->session->set_flashdata('error_msg','You are not a patient.');
		}
		else{
			$patient_ion_id = $this->ion_auth->get_user_id();
			$data['patient_data'] = $this->frontend_model->getpatiendatabyId($patient_ion_id);
			$res = $this->frontend_model->add_remove_favourite($dr_id, $data['patient_data']->id);
			
			$this->session->set_flashdata('error_msg', 'Doctor '.$res.' favourite list.');
		}
		if(isset($_GET['dash']) && $_GET['dash'] == 'favo')
			redirect('patient/favourites');
		else
			redirect('frontend/doctor_profile/'.$dr_id);
	}
	
	// Step 1
    function book_appointment($id)
    {
        $id = urldecode($id);
        $data = array();
        $data['doctor_id'] = $id;
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $data['doctor_data'] = $this->frontend_model->getDoctordataByid($id);
        $data['doctor_profile_data'] = $this->doctor_model->getDoctorProfiledata($id);
		$data['holidays'] = $this->schedule_model->getHolidaysByDoctor($id);
        $this->load->view('includes/header.php');
        $this->load->view('frontend/book-normal-appointment.php', $data);
        $this->load->view('includes/footer.php'); 
    }

	// Step 2
    function booknormalappointmentwithdoctor()
    {
        $data['appointment_data'] = $_GET;
        if(!$this->ion_auth->logged_in())
        {
            $data['loginornot'] = 0;
        }
        else
        {
            $data['loginornot'] = 1;
			$data['patient_data'] = $this->frontend_model->getpatiendatabyId($this->ion_auth->get_user_id());
        }
        
        $data['doctor_profile_data'] = $this->doctor_model->getDoctorProfiledata($_GET['doctor_id']);
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $this->load->view('includes/header.php');
        $this->load->view('frontend/booking-step2.php', $data);
        $this->load->view('includes/footer.php');
        $this->load->view('includes/pharmacy_footer.php');
    }

    function terms_conditions()
    {
        $data = array();        
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $this->load->view('includes/header.php', $data);
        $this->load->view('term-condition.php', $data);
        $this->load->view('includes/footer.php');
    }

    function privacy_policy()
    {
        $data = array();        
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $this->load->view('includes/header.php', $data);
        $this->load->view('privacy-policy.php', $data);
        $this->load->view('includes/footer.php');
    }

    function covid()
    {
        $data = array();        
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $this->load->view('includes/header.php', $data);
        $this->load->view('covid-19.php', $data);
        $this->load->view('includes/footer.php');
    }

    function benefits_of_online_consult()
    {
        $data = array();        
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $this->load->view('includes/header.php', $data);
        $this->load->view('benefits-of-online-consult.php', $data);
        $this->load->view('includes/footer.php');
    }

    function contact()
    {
        $data = array();        
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $this->load->view('includes/header.php', $data);
        $this->load->view('contact-us.php', $data);
        $this->load->view('includes/footer.php');
    }

    function sendcontactrequest()
    {
        $data = $this->input->post();
        $file = $_FILES['attachment']['name'];
        // echo "<pre>";
        // print_r($data['contact_support']);
        // exit;
        $email = $data['email'];
        // $messageprint1 = $this->parser->parse_string($message1, $data1);
        $message = "<p><strong>Dear Admin,</strong></p>";
        $message .= "<p>Contact message received with the following details:</p>";
        $message .= "<p><strong>First name:</strong> ".$data['first_name']."</p>";
        $message .= "<p><strong>Last name:</strong> ".$data['last_name']."</p>";
        $message .= "<p><strong>Email:</strong> ".$data['email']."</p>";
        $message .= "<p><strong>Contact number:</strong> ".$data['contact_number']."</p>";
        $message .= "<p><strong>Message:</strong> ".$data['message']."</p>";
        // echo $message;
        // exit;
        // $this->load->library('email'); 
        // $config['mailtype'] = "html";
        // $config['newline'] = "\r\n";
        // $this->email->initialize($config);        
        $this->email->from('no-replay@maulaji.com', 'Maulaji');
        // $this->email->to('haseenawan@gmail.com');
        $this->email->to('contact@maulaji.com');
        $file_data = $this->upload_file_contact();
        // echo "<pre>";
        // print_r($file_data);
        // exit();
        $this->email->subject('Contact Meassage received at maulaji.com');
        $this->email->message($message);
        $this->email->attach($file_data['full_path']);
        if($data['contact_support']=='yes')
        {
             $this->email->send();
             $this->session->set_flashdata('msg_sent_success','<b>Success!</b> Thank You for contacting us. Your message has been sent successfully we will contact you shortly.');
            redirect('frontend/contact');
        }
        else
        {
            $this->session->set_flashdata('msg_sent_success','<b>Success!</b> Thank You for contacting us. Your message has been sent successfully we will contact you shortly.');
            redirect('frontend/contact');
        }
    }

function upload_file_contact()
 {
    // $config['file_name'] = $file;
    $config['upload_path'] = 'uploads/';
    $config['allowed_types'] = 'png|jpg|JPG|jpeg|JPEG|doc|docx|pdf';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if($this->upload->do_upload('attachment'))
    {
        return $this->upload->data();   
    }
    else
    {
        return $this->upload->display_errors();
    }
 }

    function current_Address()
    {
        $latitude = $this->input->post('lat');
        $longitude = $this->input->post('lng');
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&key=AIzaSyAT2zrRl1pjiErc88r1qMg19QZ3hw0Ukwg&sensor=false';
        $json = @file_get_contents($url);
        $data=json_decode($json);
        // echo "<pre>";
        // print_r($data);
        // exit;
        // $status = $data->status;
        // echo $current_address = $data->results[0]->address_components[5]->long_name;
        echo json_encode(["city" => $data->results[0]->address_components[2]->long_name, "country" => $data->results[0]->address_components[5]->long_name]);
    }
    
    function blogs()
    {
        $data = array();
		$cat = isset($_GET['cat']) ? $_GET['cat'] : '';
		$tag = isset($_GET['tag']) ? $_GET['tag'] : '';
        $data['recent_posts'] = $this->frontend_model->getrecentposts();
        $data['blogs'] = $this->frontend_model->getAllactivePosts($cat, $tag);
        $data['blogs_category'] = $this->frontend_model->getAllBlogsCategory();
        $data['tag_lists'] = $this->frontend_model->getAllTags();
        $this->load->view('includes/header', $data);
        $this->load->view('blogs', $data);
        $this->load->view('includes/footer');
    }
    
    function blog_details($url)
    {
        // echo $url; exit;
        $data = array(); 
        $data['post_details'] = $this->frontend_model->getpostdetails($url);
        $data['recent_posts'] = $this->frontend_model->getrecentposts();
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $data['blogs_category'] = $this->frontend_model->getAllBlogsCategory();
        $data['tag_lists'] = $this->frontend_model->getAllTags();
        $this->load->view('includes/header.php', $data);
        $this->load->view('blog-details.php', $data);
        $this->load->view('includes/footer.php');
    }
    // pharmacy code here
    function pharmacy()
    {
        $data = array();   
        $data['country_codes'] = $this->general_model->getcountryCodes();     
		$data['slides'] = $this->slide_model->getSlide("Pharmacy");
        $this->load->view('includes/pharmacy_header.php', $data);
        $this->load->view('frontend/pharmacy.php', $data);
        $this->load->view('includes/footer.php');
        $this->load->view('includes/pharmacy_footer.php');
    }

    function by_conditions()
    {
        $data = array();        
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $this->load->view('includes/pharmacy_header.php', $data);
        $this->load->view('includes/pharmacy_search_form.php', $data);
        $this->load->view('frontend/by-conditions.php', $data);
        $this->load->view('includes/footer.php');
        $this->load->view('includes/pharmacy_footer.php');
    }

    function by_brands()
    {
        $data = array();  
        $data['country_codes'] = $this->general_model->getcountryCodes();      
        $this->load->view('includes/pharmacy_header.php', $data);
        $this->load->view('includes/pharmacy_search_form.php', $data);
        $this->load->view('frontend/by-brands.php', $data);
        $this->load->view('includes/footer.php');
        $this->load->view('includes/pharmacy_footer.php');
    }

    function products()
    {
        $data = array(); 
        if(isset($_GET['p']))
        {
            $product_name = $_GET['p'];
            $data['title_here'] = "Search results";
            $data['products'] = $this->frontend_model->getAllproductsByproductname($product_name);
        }
        elseif(isset($_GET['p_by_cond']))
        {
            $product_name = urldecode($_GET['p_by_cond']);
            $data['title_here'] = $_GET['p_by_cond'];
            $data['products'] = $this->frontend_model->getAllproductsByproductcond($product_name);
        }
        elseif(isset($_GET['p_by_brand']))
        {
            $product_name = urldecode($_GET['p_by_brand']);
            $data['title_here'] = $_GET['p_by_brand'];
            $data['products'] = $this->frontend_model->getAllproductsByproductbrands($product_name);
        }
        elseif(isset($_GET['filtertype']))
        {
            $data['title_here'] = 'Search results';
            $data['products'] = $this->frontend_model->getAllproductsByfilter($_GET);
        }
        $data['category'] = $this->frontend_model->getCategoryLists('Medicines');
        $data['country_codes'] = $this->general_model->getcountryCodes();       
        $this->load->view('includes/pharmacy_header.php', $data);
        $this->load->view('includes/pharmacy_search_form.php', $data);
        $this->load->view('frontend/products.php', $data);
        $this->load->view('includes/footer.php');
        $this->load->view('includes/pharmacy_footer.php');
    }

    function searchproduct()
    {
        $product = $_GET['val'];
        if($product !="")
        {
            $products_result = $this->frontend_model->getproductsByproductname($product);
        }
        else
        {
            $products_result = array();
        }
        echo json_encode($products_result);
    }

    function getfilteredData()
    {
        $data = $this->input->post();
        $result = $this->frontend_model->getfilteredDataByAllLogic($data);
		echo json_encode($result);
    }

    function product_description($p_id)
    {
        $data = array();   
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $data['product_history'] = $this->frontend_model->getproductHistory($p_id); 
        // echo "<pre>";
        // print_r($data['product_history']);
        // exit;    
        $this->load->view('includes/pharmacy_header.php', $data);
        $this->load->view('frontend/product-description.php', $data);
        $this->load->view('includes/footer.php');
        $this->load->view('includes/pharmacy_footer.php');
    }

    function cart()
    {
        $data = array();        
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $this->load->view('includes/pharmacy_header.php', $data);
        $this->load->view('frontend/cart.php', $data);
        $this->load->view('includes/footer.php');
        $this->load->view('includes/pharmacy_footer.php');
    }

    function checkout()
    {
        $data = array();  
        if($_COOKIE['prod_ids']=="" and $_COOKIE['presc_ids']=="")
        {
            redirect('frontend/cart');
        }
        $data['product_id_and_quantity'] = $_GET['product_id_and_quantity'];
        $data['prescriptions'] = $_GET['prescriptions_ids'];
        $data['country_codes'] = $this->general_model->getcountryCodes();      
        $this->load->view('includes/pharmacy_header.php', $data);
        $this->load->view('frontend/checkout.php', $data);
        $this->load->view('includes/footer.php');
        $this->load->view('includes/pharmacy_footer.php');
    }

    function getcartproductsdata()
    {
        $ids = $_GET['product_ids'];
        $pres_ids = $_GET['prescription_id'];

        $split_ids = explode(',', $ids);
        $split_pres_ids = explode(',', $pres_ids);

        $medicine_data = "";
        $m_price = 0;

        if($pres_ids !="")
        {
            for($i=0; $i<count($split_pres_ids); $i++)
            {
                $medicine_details = $this->frontend_model->getpresmedicinesdetails($split_pres_ids[$i]);
                $medicine_data .= '<li class="clearfix">
                    <div class="close-icon" onclick="removeprrescookie('.$medicine_details->id.')"><i class="far fa-times-circle"></i></div>
                    <img class="avatar-img rounded" src="'.$medicine_details->img_url.'" alt="Medicine img" onerror="this.src = '."'".base_url().'assets/images/default_image.jpg'."'".';">
                </li>';

                // $m_price = $m_price + str_replace('Rs.','',$medicine_details->price);
            }
        }

        if($ids != "")
        {
            for($i=0; $i<count($split_ids); $i++)
            {
                $medicine_details = $this->frontend_model->getmedicinesdetails($split_ids[$i]);
                if($medicine_details->category=='Personal Care')
                { 
                	$path = 'Personal_Care/';
                }
            	elseif($medicine_details->category=='Wellbeing & Fitness')
            	{ 
            		$path = 'Wellbeing_Fitness/';
            	}
            	elseif($medicine_details->category=='Medical Devices')
            	{ 
            		$path = 'Medical_Devices/';
            	}
            	else
            	{ 
            		$path = 'Medicines/';
            	}
                $medicine_data .= '<li class="clearfix">
                    <div class="close-icon" onclick="removeproduct('.$medicine_details->id.')"><i class="far fa-times-circle"></i></div>
                    <img class="avatar-img rounded" src="'.base_url().'assets/images/image/'.$medicine_details->image.'.jpg" alt="Medicine img" onerror="this.src = '."'".base_url().'assets/images/default_image.jpg'."'".';">
                    <span class="item-name">'.$medicine_details->name.'</span>
                    <span class="item-price">'.$medicine_details->price.'</span>
                    <span class="item-quantity">Quantity: 01</span>
                </li>';

                $m_price = $m_price + str_replace('Rs.','',$medicine_details->price);
            }
        }
        // echo $medicine_data;
        // echo 'Price: '.$m_price;
        echo json_encode(['product_detail'=>$medicine_data,'price'=>$m_price]);
    }

    function getcartorescriptiondata()
    {
        $ids = $_GET['prescription_id'];
        $split_ids = explode(',', $ids);
        $medicine_data = "";
        $m_price = 0;
        if($ids != "")
        {
            for($i=0; $i<count($split_ids); $i++)
            {
                $medicine_details = $this->frontend_model->getpresmedicinesdetails($split_ids[$i]);
                $medicine_data .= '<li class="clearfix">
                    <div class="close-icon" onclick="removeprrescookie('.$medicine_details->id.')"><i class="far fa-times-circle"></i></div>
                    <img class="avatar-img rounded" src="'.$medicine_details->img_url.'" alt="Medicine img" onerror="this.src = '."'".base_url().'assets/images/image_9.jpg'."'".';">
                </li>';

                // $m_price = $m_price + str_replace('Rs.','',$medicine_details->price);
            }
        }
        // echo $medicine_data;
        // echo 'Price: '.$m_price;
        echo json_encode(['product_detail'=>$medicine_data]);
    }

    function medcheckout()
    {
        $data = $this->input->post();
        $data['order_id'] = "MAULAJI-".rand(10,99999);
        // echo $data['radio']; exit;
        $data['transaction_id'] = '';
        if($data['radio']=="by_card")
        {
            $changerate = 1;
            $total_stripe_payment = round($data['amount']*$changerate,2)*100;

            require APPPATH . 'third_party/stripe/stripe-php/init.php';
            
            $currency = "GBP";
            \Stripe\Stripe::setApiKey('sk_test_51IG6NjCnnFzOpBJC51qnVDBJ54TruldpdZL8oUwEUcFtjeMjzNf8n8TOwzpJIe3SZ0qHkNXP2u2m3q6SebZnApY700wBSBRrZs'); // Enter secret key
            $session = \Stripe\Checkout\Session::create([
              'payment_method_types' => ['card'],
              'line_items' => [[
                'name' => 'Booking',
             
                'description' => 'Payment for Maulaji Medicines. Order ID are:'.$data['order_id'],
                ///'images' => ['https://example.com/t-shirt.png'],
                'amount' => $total_stripe_payment,
                'currency' => 'GBP',
                'quantity' => '1'
              ]],
              'success_url' => base_url().'frontend/bookingsuccessfull?success_payment=true&'.http_build_query($data),
              'cancel_url' => base_url().'frontend/checkout?cancel_payment=true',
            ]); 
            // echo $session->id; exit;
            // $_SESSION['STRIPE_SESSION_ID'] = $session->id ;   
            $this->session->set_userdata('stripe_sessionID', $session->id);      
            $this->session->set_flashdata('stripe_session_id', $session->id);
            redirect('frontend/checkout');
            exit();
        }
        else
        {
            // $this->makemedicinepayment($data['amount'],$data['email'],$data['stripeToken']);
            // exit();
            $res = $this->frontend_model->insertOrders($data);
            // echo "<pre>";
            // print_r($data);
            // exit;
            $this->session->set_flashdata('success_order', $res);
            redirect('frontend/bookingsuccessfull');
        }
    }

    function uploadprescription()
    {
        $prescriptimg = str_replace(' ','_',time().$_FILES['prescriptimg']['name']);
        $res = $this->upload_prescription($prescriptimg);
        echo $res;
    }

    function upload_prescription($prescriptimg)
    {
        $config['file_name'] = $prescriptimg;
        $config['upload_path']          = 'uploads/prescription_images';
        $config['allowed_types']        = '*';
        $config['max_size']             = 10000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;
        $img_url = base_url().'uploads/prescription_images/'.$prescriptimg;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('prescriptimg'))
        {
            $error = array('error' => $this->upload->display_errors());
            // print_r($error);
            return 0;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $res = $this->frontend_model->insertprescriptiondata($img_url);
            return $res;
        }
    }

    // Payment API
    function makemedicinepayment($itemPrice,$email,$token)
    {
    	
    }
    
    // Symptom Checker Code
    
    function symptomchecker()
    {
        $data = array();
        $data['symptoms_data'] = $this->frontend_model->getsypmtomchekerdata();
        $this->load->view('includes/header.php');
        $this->load->view('frontend/symptomchecker.php', $data);
        $this->load->view('includes/footer.php');
        // $this->load->view('includes/pharmacy_footer.php');
    }

    function getquestionsbyName()
    {
        $symptom_name = $this->input->get('symptom_name');
        $symptom_result = $this->frontend_model->getsymptomQuestionsByName($symptom_name);
        // html result
        if(empty($symptom_result))
        {
            echo "<h4 class='text-center' style='color: #b2b2b2;'>Result Not Found</h4>";
        }
        else
        {
            echo "<ul class='question-wrap'>";
            foreach($symptom_result as $value)
            {
                echo "<li class='symptom-questions hide-show-".$value->id."'>
                    <p>".$value->questions."</p>
                    <div class='row'><div class='col-md-6'><button type='button' class='btn btn-info btn-block questions-btn-no' onclick='noquestionbuton(".$value->id.")'> No </button></div> <div class='col-md-6'><button type='button' class='btn btn-primary btn-block questions-btn-yes' onclick='yesquestionbuton(".$value->id.")'> Yes </button></div></div>
                </li>";
            }
            echo "</ul>";
        }
    }

    function getanswersbyId()
    {
        $question_id = $this->input->get('question_id');
        $answers_result = $this->frontend_model->getsymptomAnswersByName($question_id);
        if($answers_result->answers=="" and $answers_result->self_care=="")
        {
            echo "<h4 class='text-center' style='color: #b2b2b2;'>Result Not Found</h4>";
            echo "<div class='text-center'><button type='button' class='btn btn-info btn-block questions-btn-yes' onclick='startOver()'> Start Over </button></div>";
        }
        else
        {
            echo "<div class=''>
                <h4 style='color: #b2b2b2;'>Diagnosis</h4>
                <p>".$answers_result->answers."</p>";
            if($answers_result->self_care !="")
            {
                echo "<hr> <h4 style='color: #db0c35;''>Self Care</h4><p>".$answers_result->self_care."</p>";
            }
            echo "<div class='text-center'><a href='frontend/searchdoctors?city=&hospital=&hospital_id=' target='_blank' class='btn btn-primary btn-block'> Book Appointment with Doctor </a> <button type='button' class='btn btn-info btn-block questions-btn-yes' onclick='startOver()'> Start Over </button></div></div>";
        }
    }

    function getsymptomsByType()
    {
        $type = $this->input->get('type');
        $result = $this->frontend_model->getsymptomsbyType($type);
        foreach($result as $value)
        {
            echo '<li class="symptom"><a href="javascript:void(0)" class="'.str_replace(array(' ',','), '', preg_replace('/[^A-Za-z ]/', '', $value->symptoms)).'" data-symptom-id="'.$value->id.'" data-symptom-name="'.$value->symptoms.'" title="'.$value->symptoms.'">'.$value->symptoms.'</a></li>';
        }
    }

    // symptom checker end here

    // Talk messenger code
    function talkmessenger()
    {
        $data['maulaji_talk'] = 'yes';
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/talk.php', $data);
        $this->load->view('includes/footer.php', $data);
    }
    // end here
    function drive()
    {
        $data['maulaji_talk'] = 'drive';
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/drive.php', $data);
        $this->load->view('includes/footer.php', $data);
    }

    function docshare()
    {
        $data['maulaji_talk'] = 'docshare';
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/docshare.php', $data);
        $this->load->view('includes/footer.php', $data);
    }

    function healthandwellness()
    {
        $data['maulaji_talk'] = 'health';
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/healthandwellness.php', $data);
        $this->load->view('includes/footer.php', $data);
    }

    function learnmedical()
    {
        $data['maulaji_talk'] = 'learn';
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/learnmedical.php', $data);
        $this->load->view('includes/footer.php', $data);
    }

    function community()
    {
        $data['maulaji_talk'] = 'community';
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/community.php', $data);
        $this->load->view('includes/footer.php', $data);
    }

    function labtest()
    {
        $data['maulaji_talk'] = 'labtest';
        $data['labtests'] = $this->frontend_model->getlabtestsforfrontend();
        $data['slides'] = $this->slide_model->getSlide("Lab Test");
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/labtest.php', $data);
        $this->load->view('includes/footer.php', $data);
        $this->load->view('includes/pharmacy_footer.php');
    }

    function viewallLabTest()
    {
        $data = array();        
        $data['country_codes'] = $this->general_model->getcountryCodes();
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/viewalllabtests.php', $data);
        $this->load->view('includes/footer.php');
        $this->load->view('includes/pharmacy_footer.php');
    }

    function getlabtestdetails()
    {
        $data = $this->input->get();
        $lab_test_details = $this->frontend_model->getlabtestdetailsdata($data);
        echo $lab_test_details; exit;
    }

    function searchlabtest()
    {
        $data = $this->input->get();
        // echo "<pre>";
        // print_r($data);
        // exit;
        $data['maulaji_talk'] = 'labtest';
        $data['labtests'] = $this->frontend_model->getlabtestsforfrontendByname($data);
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/search-labtest.php', $data);
        $this->load->view('includes/footer.php', $data);
        $this->load->view('includes/pharmacy_footer.php');
    }
    
    function faq()
    {
        $data = array();
		$data['faqs'] = $this->settings_model->getFaqs();
        $this->load->view('includes/header.php', $data);
        $this->load->view('frontend/faq.php', $data);
        $this->load->view('includes/footer.php', $data);
    }

}

/* End of file appointment.php */
    /* Location: ./application/modules/appointment/controllers/appointment.php */
    