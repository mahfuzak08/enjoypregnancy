<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->model('doctor/doctor_model');
		$this->load->model('donor/donor_model');
		$this->load->model('auth/general_model');
		$this->load->model('frontend/frontend_model');
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	//redirect if needed, otherwise display the user list
	function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	/*	elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
        */        
		else
		{
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$data['users'] = $this->ion_auth->users()->result();
			foreach ($data['users'] as $k => $user)
			{
				$data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			// $this->_render_page('auth/index', $data);
			print_r("48");
			exit;
            redirect('home', 'refresh');
		}
	}

	//log the user in
// 	function login()
// 	{
            
//         if ($this->ion_auth->logged_in())
// 		{
// 			//redirect them to the login page
// 			redirect('home');
// 		}
// 		$data['title'] = "Login";

// 		//validate form input
// 		$this->form_validation->set_rules('identity', 'Identity', 'required');
// 		$this->form_validation->set_rules('password', 'Password', 'required');

// 		if ($this->form_validation->run() == true)
// 		{
// 			//check to see if the user is logging in
// 			//check for "remember me"
// 			$remember = (bool) $this->input->post('remember');

// 			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
// 			{
// 				//if the login is successful
// 				//redirect them back to the home page
// 				$this->session->set_flashdata('message', $this->ion_auth->messages());
// 				redirect('home', 'refresh');
// 			}
// 			else
// 			{
// 				//if the login was un-successful
// 				//redirect them back to the login page
// 				$this->session->set_flashdata('message', $this->ion_auth->errors());
// 				redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
// 			}
// 		}
// 		else
// 		{
// 			//the user is not logging in so display the login page
// 			//set the flash data error message if there is one
// 			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

// 			$data['identity'] = array('name' => 'identity',
// 				'id' => 'identity',
// 				'type' => 'text',
// 				'value' => $this->form_validation->set_value('identity'),
// 			);
// 			$data['password'] = array('name' => 'password',
// 				'id' => 'password',
// 				'type' => 'password',
// 			);
//             //My Code 			
// 			$data['doctors'] = $this->doctor_model->getDoctorlogin();
//             $data['groups'] = $this->donor_model->getBloodBanklogin();
//             $data['country_codes'] = $this->general_model->getcountryCodes();
//             $data['speciality'] = $this->general_model->getSpeciality();
//             $data['hospitals'] = $this->doctor_model->getHospitals();
//             $data['countires'] = $this->frontend_model->getCounries();
// //             echo "<pre>";
// // 			print_r($data['hospitals']);
// // 			exit;
// 			$this->_render_page('auth/login', $data);
// 		}
// 	}

	//log the user in
	function loginViaOtp()
	{
		$data['title'] = "Login";
		
		$remember = (bool) $this->input->post('remember');
		if ($this->ion_auth->loginViaOTP($this->input->post('identity'),$remember))
		{
			//if the login is successful
			//redirect them back to the home page
			$_SESSION['localTimeZone'] = $this->input->post('zone');
			$_SESSION['localTimeZoneAbbr'] = $this->input->post('zone_abbr');
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			if ($this->ion_auth->in_group(array('Patient'))) {
				redirect('patient/dashboard', 'refresh');
			}
			elseif ($this->ion_auth->in_group(array('Doctor'))) {
				redirect('doctor/dashboard', 'refresh');
			}
			else{
				print_r("139");
			exit;
				redirect('home', 'refresh');
			}
		}
		else
		{
			//if the login was un-successful
			//redirect them back to the login page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
		}		
	}

	function loginViaOtppharmacy()
	{		
		$remember = (bool) $this->input->post('remember');
		if ($this->ion_auth->loginViaOTP($this->input->post('identity'),$remember))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}		
	}



	//log the user in new_login()
	function login()
	{
		if ($this->ion_auth->logged_in())
		{
			//redirect them to the login page
			print_r("175");
			exit;
			redirect('home');
		}
		$data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		// print_r($_POST);
        
		if ($this->form_validation->run() == true)
		{
			//check to see if the user is logging in
			//check for "remember me"
			// print_r(189);
			$remember = (bool) $this->input->post('remember');
			// echo $this->input->post('phonecode'); exit;
			// if($user->email_active==0)
			// {
			// 	$this->sesison->set_flashdata('email_active_msg','Please verify your email.');
			// 	redirect('auth/login');
			// }
			// print_r($user);
			// exit;
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember,$this->input->post('phonecode')))
			{
				//if the login is successful
				//redirect them back to the home page
				// print_r("     login success   ");
				$_SESSION['localTimeZone'] = $this->input->post('zone');
				$_SESSION['localTimeZoneAbbr'] = $this->input->post('zone_abbr');
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				if ($this->ion_auth->in_group(array('Patient'))) {
					redirect('patient/dashboard');
				}
				elseif ($this->ion_auth->in_group(array('Doctor'))) {
					redirect('doctor/dashboard');
				}
				elseif ($this->ion_auth->in_group(array('Accountant', 'Receptionist'))) {
					redirect('finance/addPaymentView', 'refresh');
				}
				else{
					redirect('home', 'refresh');
				}
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);
            //My Code 			
			$data['doctors'] = $this->doctor_model->getDoctorlogin();
            $data['groups'] = $this->donor_model->getBloodBanklogin();
            $data['country_codes'] = $this->general_model->getcountryCodes();
            $data['speciality'] = $this->general_model->getSpeciality();
            $data['hospitals'] = $this->doctor_model->getHospitals();
            $data['countires'] = $this->frontend_model->getCounries();
//             echo "<pre>";
// 			print_r($data['hospitals']);
// 			exit;
            $this->load->view('includes/header.php');
			$this->_render_page('auth/new_login', $data);
			$this->load->view('includes/footer.php');
		}
	}

	function loginpharmacy()
	{         
		//check to see if the user is logging in
		//check for "remember me"
		$remember = (bool) $this->input->post('remember');
		// echo $this->input->post('identity'); exit;
		if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember,$this->input->post('phonecode')))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}

	function register()
	{
		$data['title'] = "Register";
		$data['hospitals'] = $this->doctor_model->getHospitals();
		$data['country_codes'] = $this->general_model->getcountryCodes();
		$this->load->view('includes/header.php');
		$this->_render_page('auth/register.php', $data);
		$this->load->view('includes/footer.php');
	}

	function doctor_register()
	{
		$data['title'] = "Doctor Register";
		$data['hospitals'] = $this->doctor_model->getHospitals();
		$data['country_codes'] = $this->general_model->getcountryCodes();
		$this->load->view('includes/header.php');
		$this->_render_page('auth/doctor-register.php', $data);
		$this->load->view('includes/footer.php');
	}
	function hospital_register()
	{
		$data['title'] = "Register Your Hospital";
		$data['country_codes'] = $this->general_model->getcountryCodes();
		$this->load->view('includes/header.php');
		$this->_render_page('auth/hospital-register.php', $data);
		$this->load->view('includes/footer.php');
	}

	function pharmacy_register()
	{
		$data['title'] = "Register Your Pharmacy";
		$data['country_codes'] = $this->general_model->getcountryCodes();
		$this->load->view('includes/header.php');
		$this->_render_page('auth/pharmacy-register.php', $data);
		$this->load->view('includes/footer.php');
	}

	function labortary_register()
	{
		$data['title'] = "Register Your Labortary";
		$data['country_codes'] = $this->general_model->getcountryCodes();
		$this->load->view('includes/header.php');
		$this->_render_page('auth/labortary-register.php', $data);
		$this->load->view('includes/footer.php');
	}
	// function forgot_password()
	// {
	// 	$data['title'] = "Forgot Password";
	// 	$data['country_codes'] = $this->general_model->getcountryCodes();
	// 	$this->load->view('includes/header.php');
	// 	$this->_render_page('auth/doctor-register.php', $data);
	// 	$this->load->view('includes/footer.php');
	// }
	//log the user out
	function logout()
	{
		$data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	//change password
	function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			//display the form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
			);
			$data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
			);
			$data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			$this->_render_page('auth/change_password', $data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	//forgot password
	function forgot_password()
	{
		//setting validation rules by checking wheather identity is username or email
		if($this->config->item('identity', 'ion_auth') == 'username' )
		{
		   $this->form_validation->set_rules('email', $this->lang->line('forgot_password_username_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false)
		{
			//setup the input
			$data['email'] = array('name' => 'email',
				'id' => 'email',
			);

			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
			}
			else
			{
				$data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			//set any errors and display the form
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->view('includes/header.php');
			$this->_render_page('auth/forgot_password', $data);
			$this->load->view('includes/footer.php');
		}
		else
		{
			// get identity from username or email
			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))->users()->row();
			}
			else
			{
				$identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
			}
	            	if(empty($identity)) {

	            		if($this->config->item('identity', 'ion_auth') == 'username')
		            	{
                                   $this->ion_auth->set_message('forgot_password_username_not_found');
		            	}
		            	else
		            	{
		            	   $this->ion_auth->set_message('forgot_password_email_not_found');
		            	}

		                $this->session->set_flashdata('message', $this->ion_auth->messages());
                		redirect("auth/forgot_password", 'refresh');
            		}

			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				//if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$data['min_password_length'].'}.*$',
				); 
				$data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password', 
					'pattern' => '^.{'.$data['min_password_length'].'}.*$',
				);
				$data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$data['csrf'] = $this->_get_csrf_nonce();
				$data['code'] = $code;

				//render
				$this->load->view('includes/header.php');
				$this->_render_page('auth/reset_password', $data);
				$this->load->view('includes/footer.php');
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$data['csrf'] = $this->_get_csrf_nonce();
			$data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth/deactivate_user', $data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	//create a new user
	function create_user()
	{
		$data['title'] = "Create User";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$tables = $this->config->item('tables','ion_auth');

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'));
		$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'));
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == true)
		{
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email    = strtolower($this->input->post('email'));
			$password = $this->input->post('password');

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
		{
			//check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//display the create user form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$data['password_confirm'] = array(
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->_render_page('auth/create_user', $data);
		}
	}

	//edit a user
	function edit_user($id)
	{
		$data['title'] = "Edit User";

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			//update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
				);

				//update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

			//check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	//redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }
			    else
			    {
			    	//redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }

			}
		}

		//display the edit user form
		$data['csrf'] = $this->_get_csrf_nonce();

		//set the flash data error message if there is one
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$data['user'] = $user;
		$data['groups'] = $groups;
		$data['currentGroups'] = $currentGroups;

		$data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);

		$this->_render_page('auth/edit_user', $data);
	}

	// create a new group
	function create_group()
	{
		$data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			//display the create group form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->_render_page('auth/create_group', $data);
		}
	}

	//edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->_render_page('auth/edit_group', $data);
	}


	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
// 	Haseen code
	function patient_register()
	{
	    $this->load->library('Ion_auth');
        $this->lang->load('system_syntax');
        $this->load->model('ion_auth_model');
        $data = $this->input->post();
        $patient_id = rand(10000, 1000000);
        $add_date = date('m/d/y');
        $file_name = $_FILES['img_url']['name'];
        $identitydoc = $_FILES['identitydoc']['name'];
        $doctor_lic_doc = $_FILES['doctor_lic_doc']['name'];
        
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
            $data['img_url'] = $img_url;
        } else {
            $data['img_url'] = "";
        }
        
        // identity doc Haseen
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
            $data['identitydoc'] = "";
        }
        $is_doc = 0;
        $dfg = 5;
        if($data['support_input']==1)
        {
            $dfg = 4;
            $is_doc = 1;
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
                $data['doctor_lic_doc'] = "";
            }
        }
        // end here
	    
	   // echo "<pre>";
	   $data['phone'] = $data['phonecode'].$data['phone'];
	    $id = $this->ion_auth->register2($data['name'], $data['password'], $data['email'], $dfg, $data['phone'], $is_doc);
	    $data['ion_user_id'] = $id;
	    $data['patient_id'] = $patient_id;

	    $result = $this->general_model->addnewpatient($data);
	    $this->hospital_model->addHospitalIdToIonUser($id, $data['hospital_id']);

	    $from_email = "no-replay@maulaji.com"; 
	    $to_email = $data['email']; 

	    //Load email library 
	    $this->load->library('email'); 
	    $config['mailtype'] = "html";
	    $config['newline'] = "\r\n";
	    $this->email->initialize($config);
	    $this->email->from($from_email, 'Maulaji'); 
	    $this->email->to($to_email);
	    $this->email->subject('Verify Your Email-ID with Maulaji'); 
	    $this->email->message('Dear '.$data['name'].', <br> Thank you for registering with Maulaji. Our Team would like to extend a very warm welcome to you.<br> Please click on the link given below to verify your E-mail-ID. <br> <a href="'.base_url().'auth/verifyemailid/'.$data['ion_user_id'].'">Click here to verify your Email-ID</a>'); 
	    //Send mail 
	    $this->email->send();

	    echo $result;
	   // exit;
	}
	
	function checkemail()
	{
	    $email = $this->input->post('email');
	    $phone = $this->input->post('phone');
	    $result = $this->general_model->checkemail_i($email,$phone);
	    echo $result;
	}
	function checkphoneEemail()
	{
	    $email = $this->input->post('email');
	    $phone = $this->input->post('phone');
	    $result = $this->general_model->checkphone_i($email,$phone);
	    echo json_encode($result);
	}

	function checkphonenumber()
	{
		$phonenumber = str_replace(' ','','+'.$this->input->post('phonenumber'));
		$res = $this->general_model->checkphoneIndb($phonenumber);
		echo $res;
		exit;
	}

	function apiuniqueemail()
	{
		$email = $this->input->post('email');
	    $result = $this->general_model->checkemail_api($email);
	    echo $result;
	}

	function apiuniquephonenumber()
	{
		$phonenumber = $this->input->post('phonenumber');
		$res = $this->general_model->checkphoneIndb($phonenumber);
		echo $res;
		exit;
	}
	function verifyemailid($id)
	{
		if($this->general_model->verifyemailidhere($id))
		{
			$this->session->set_flashdata('email_verified_msg','<div class="alert alert-success">Your Email has been successfully verified.</div>');
			redirect('auth/login');
		}
		else
		{
			$this->session->set_flashdata('email_verified_msg','<div class="alert alert-danger">Your account couldn`t verify due to system error.</div>');
			redirect('auth/login');
		}
	}
// end here
	function _render_page($view, $data=null, $render=false)
	{

		$this->viewdata = (empty($data)) ? $data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

	
	//for API use
	//change password
	// that's why all checking are done by client
	function change_password_api()
	{
		$this->form_validation->set_rules('new_password', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
		$this->form_validation->set_rules('user_id', 'User ID', 'required');
		// file_put_contents("pass1.txt", $this->input->post('user_id') . '=' . $this->input->post('new_password'));
		if ($this->form_validation->run() == false)
		{
			$result['status'] = false;
			$result['message'] = validation_errors();
			echo json_encode($result);
		}
		else
		{
			$change = $this->ion_auth->change_password_api($this->input->post('user_id'), $this->input->post('new_password'));

			if ($change)
			{
				//if the password was successfully changed
				$result['status'] = true;
				$result['message'] = 'Password changed successfully';
			}
			else
			{
				$result['status'] = false;
				$result['message'] = 'Password change error';
			}
		}
		
		echo json_encode($result);
	}
}
