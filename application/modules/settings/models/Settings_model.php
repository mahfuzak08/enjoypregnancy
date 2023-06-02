<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertSettings($hospital_settings_data) {
        $this->db->insert('settings', $hospital_settings_data);
    }

    function getSettings() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('settings');
        return $query->row();
    }
    
    function getSettingsapplink() {
        $this->db->where('id', '35');
        $query = $this->db->get('settings');
        return $query->row();
    }

    function updateSettings($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('settings', $data);
    }

    function updateHospitalSettings($id, $data) {
        $this->db->where('hospital_id', $id);
        $this->db->update('settings', $data);
    }

    function getSubscription() {
        $this->db->where('id', $this->hospital_id);
        $query = $this->db->get('hospital');
        return $query->row();
    }
	
	function getFaqs($id=0) {
		if($id>0)
			$this->db->where('id', $id);
		$this->db->order_by('position');
        return $this->db->get('faq')->result();
    }
	
	function setFaq($post) {
		if($this->db->insert('faq', $post))
			return $this->db->insert_id();
		else
			return 0;
    }
	
	function deleteFaq($id) {
		$this->db->where('id', $id);
		if($this->db->delete('faq'))
			return true;
		else
			return false;
    }
	
	function get_api_info($type='', $status=1) {
		if($type !== '')
			$this->db->where('type', $type);
		if($status === 1)
			$this->db->where('status', 1);
		
        return $this->db->get('api_keys')->row();
    }
	
	function set_api_info($post) {
		$data = array(
			"type"=>$post["type"],
			"status"=>$post["status"],
			"key1"=>@$post["key1"],
			"key2"=>@$post["key2"],
			"key3"=>@$post["key3"],
			"key4"=>@$post["key4"],
			"key5"=>@$post["key5"],
			"key6"=>@$post["key6"]
		);
		
		if($post['id'] > 0){
			$this->db->where('id', $post['id']);
			if($this->db->update('api_keys', $data))
				return $post['id'];
			else{
				print_r($this->db->error(), true);
				// return 0;
				exit();
			}
		}else{
			if($this->db->insert('api_keys', $data))
				return $this->db->insert_id();
			else{
				print_r($this->db->error(), true);
				// return 0;
				exit();
			}
		}
		
    }

}
