<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function add_update_bank_transfer($post){
		file_put_contents("up2.txt", $post);
		$data = array(
			"bank_acc_id"=> $post["bank_acc_id"],
			"user_id"=> $post['user_id'],
			"hospital_id"=> $post['hid'],
			"transfer_by"=> $post["admin_bank"],
			"trnx_id"=> $post["trnx_id"],
			"amount"=> $post["amount"],
			"currency"=> isset($post["currency"]) ? $post["currency"] : 'GBP',
			"note"=> @$post["note"]
		);
			
		if(! $this->db->insert("bank_transfer", $data)){
			// return $this->db->error();
			return 0;
		}
		
		return $this->db->insert_id();
	}
	
	function add_update_trans($arg) {
		if(! empty($arg['id']) && $arg['update_order']){
			$data = array(
				"order_type"=>$arg['order_type'],
				"order_no"=>$arg['order_no']
			);
			if(isset($arg['status']))
				$data['status'] = $arg['status'];
			if(! $this->db->where('id', $arg['id'])->update('transaction', $data)){
				// print_r($this->db->error(), true);
				return 0;
			}
			return true;
		}else{
			$arg['status'] = 1;
			if(isset($arg['trns_type']) && $arg['trns_type'] == 'withdraw'){
				$arg['amount'] = -($arg['amount']);
				$arg['status'] = 0;
			}
			$data = array(
				"method"=> $arg['method'],
				"user_from"=> $arg['from'],
				"user_to"=> $arg['to'],
				"amount"=> $arg['amount'],
				"currency"=> $arg['currency'],
				"note"=> @$arg['details'],
				"status"=> $arg['status']
			);
			if(! $this->db->insert('transaction', $data)){
				// print_r($this->db->error(), true);
				return 0;
			}
			return $this->db->insert_id();
		}
    }
	
	function add_card_trans($arg) {
		$data = array(
			"method"=> $arg['method'],
			"trans_id"=> $arg['trans_id'],
			"amount"=> $arg['amount'],
			"product_id"=> @$arg['product_id'],
			"product_name"=> @$arg['product_name'],
			"name"=> @$arg['name'],
			"email"=> @$arg['email'],
			"transaction_id"=> $arg['transaction_id'],
			"last4"=> $arg['last4'],
			"token_id"=> $arg['token_id'],
			"customer_id"=> @$arg['customer_id'],
			"currency"=> $arg['currency'],
			"note"=> @$arg['details']
		);
        if(! $this->db->insert('card_transaction', $data)){
			// print_r($this->db->error(), true);
			return 0;
		}
		return $this->db->insert_id();
    }
	
	function get_payment_history($arg)
	{
		if(! empty($arg['fdate']) ){
			$this->db->where('createdat >=', $arg['fdate']);
		}
		if(! empty($arg['tdate']) ){
			$this->db->where('createdat <=', $arg['tdate']);
		}
		
		if(! empty($arg['id']) && $arg['type'] == 'patient'){
			$this->db->where('user_from', $arg['id']);
		}
		elseif(! empty($arg['id']) && $arg['type'] == 'doctor'){
			$this->db->where('user_to', $arg['id']);
		}
		$this->db->select("transaction.*, doctor.ion_user_id as doctor_ion_user_id, doctor.name as doctor_name, doctor.img_url as doctor_img, patient.ion_user_id as patient_ion_user_id, patient.name as patient_name, patient.img_url as patient_img");
        $this->db->join("doctor", "doctor.id = transaction.user_to");
        $this->db->join("patient", "patient.id = transaction.user_from");
		$this->db->order_by('id', 'desc');
        $query = $this->db->get('transaction');
		// file_put_contents('text.txt', $this->db->last_query());
        return $query->result();
	}
	
	function get_trans_history($arg)
	{
		if(! empty($arg['fdate']) ){
			$this->db->where('createdat >=', $arg['fdate']);
		}
		if(! empty($arg['tdate']) ){
			$this->db->where('createdat <=', $arg['tdate']);
		}
		
		if(! empty($arg['id']) && $arg['type'] == 'doctor'){
			$this->db->where('user_to', $arg['id']);
		}
		if(! empty($arg['id']) && $arg['type'] == 'admin'){
			$this->db->select("transaction.*, doctor.ion_user_id as doctor_ion_user_id, doctor.name as doctor_name, bank_account.id as bid, bank_name, branch_name, account_no, account_name");
			$this->db->join("doctor", "doctor.id = transaction.user_to", "left");
			$this->db->join("bank_account", "doctor.id = bank_account.ref_id", "left");
		
			$this->db->where('method', 'bank_transfer');
			$this->db->where('user_from', $arg['id']);
		}
		$this->db->order_by('transaction.id', 'desc');
        $query = $this->db->get('transaction');
		return $query->result();
	}
	
	function get_summary($arg)
	{
		if(! empty($arg['fdate']) ){
			$this->db->where('createdat >=', $arg['fdate']);
		}
		if(! empty($arg['tdate']) ){
			$this->db->where('createdat <=', $arg['tdate']);
		}
		
		if(! empty($arg['id']) && $arg['type'] == 'patient'){
			$this->db->where('user_from', $arg['id']);
		}
		elseif(! empty($arg['id']) && $arg['type'] == 'doctor'){
			$this->db->where('user_to', $arg['id']);
		}
		$this->db->select("SUM(amount) as total");
        $query = $this->db->get('transaction')->row()->total;
		return $query;
	}
	
	function save_account_info($post){
		$data = array(
			"whom"=> $post['whom'],
			"ref_id"=> $post['ref_id'],
			"bank_name"=> $post['bank_name'],
			"branch_name"=> $post['branch_name'],
			"account_no"=> $post['account_no'],
			"account_name"=> $post['account_name']
		);
		
		if(@$post['acc_id'] > 0){
			$this->db->where("id", $post['acc_id']);
			if(! $this->db->update('bank_account', $data))
				$post['acc_id'] = 0;
		}else{
			if(! $this->db->insert('bank_account', $data)){
				// print_r($this->db->error(), true);
				$post['acc_id'] = 0;
			}
			$post['acc_id'] = $this->db->insert_id();
		}
		return $post['acc_id'];
	}
	
	function get_account_info($id, $type){
		$this->db->where("ref_id", $id);
		$this->db->where("whom", $type);
		return $this->db->get("bank_account")->row();
	}
}