<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('payment_model');
    }

	public function add_edit_account(){
		if($this->payment_model->save_account_info($_POST) > 0)
			$this->session->set_flashdata('feedback', 'Account info save successfully');
		else
			$this->session->set_flashdata('error_msg', 'Account info save error');
		
		redirect('doctor/accounts');
	}
	
	public function add_update_trans(){
		if($this->payment_model->add_update_trans($_POST) > 0)
			$this->session->set_flashdata('feedback', 'Payment request successfully');
		else
			$this->session->set_flashdata('error_msg', 'Payment request error');
		
		redirect('doctor/accounts');
	}
	
	public function bank_transfer() {
        if (!$this->ion_auth->in_group('admin')) {
            redirect('home');
        }
        $data['settings'] = $this->settings_model->getSettings();
		$arg['fdate'] = '';
		$arg['tdate'] = '';
		$arg['type'] = 'admin';
		$arg['id'] = $this->session->userdata('hospital_id');
        $data['result'] = $this->payment_model->get_trans_history($arg);
		
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('bank_transfer', $data);
        $this->load->view('home/footer'); // just the header file
    }
	
	public function add_update_bank_trans(){
		file_put_contents("up.txt", $_GET);
		$arg['bank_acc_id'] = $_GET['bid'];
		$arg['trnx_id'] = $_GET['tid'];
		$arg['admin_bank'] = "Check";
		$arg['amount'] = $_GET["amt"];
		$arg['user_id'] = $this->ion_auth->get_user_id();
		$arg['hid'] = $this->session->userdata('hospital_id');
		
		$res = $this->payment_model->add_update_bank_transfer($arg);
		if($res > 0){
			$this->payment_model->add_update_trans(array('id'=>$_GET['tid'], 'update_order'=> true, 'order_no'=>$res, 'order_type'=>'withdraw', 'status'=> 1));
			$this->session->set_flashdata('success', 'Payment process successfully');
		}
		else
			$this->session->set_flashdata('error', 'Payment process error');
		
		redirect('payment/bank_transfer');
	}
	
}