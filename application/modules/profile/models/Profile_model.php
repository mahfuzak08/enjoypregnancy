<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getProfileById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    function updateProfile($id, $data, $group_name) {
        $this->db->where('ion_user_id', $id);
        $this->db->update($group_name, $data);
    }

    function updateIonUser($username, $email, $phone, $password, $ion_user_id) {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }
	
	function updateUserInfo($post, $id) {
		$user_data = array(
			'username' => $post['name'],
			'img' => $post['img_url'],
			'email' => $post['email'],
			'phone' => $post['phone']
		);
        
		$patient_data = array(
			'name' => $post['name'],
			'email' => $post['email'],
			'address' => $post['address'],
			'phone' => $post['phone'],
			'sex' => $post['gender'],
			'birthdate' => $post['date_of_birth'],
			'bloodgroup'=>$post['bloodgroup'],
			'img_url' => $post['img_url'],
			'medicale_history' => implode(',',$post['medicaleHistory'])
		);
		
		$this->db->trans_begin();
		
		$this->db->where('id', $id);
        $this->db->update('users', $user_data);
		
		$this->db->where('id', $post['id']);
        $this->db->update('patient', $patient_data);
		
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $id;
        }
    }

    function getUsersGroups($id) {
        $this->db->where('user_id', $id);
        $query = $this->db->get('users_groups');
        return $query;
    }

    function getGroups($group_id) {
        $this->db->where('id', $group_id);
        $query = $this->db->get('groups');
        return $query;
    }

    function getdoctortbldata($id)
    {
        $this->db->where('ion_user_id',$id);
        $query = $this->db->get('doctor');
        return $query->row();
    }
    
    function getpatienttbldata($id)
    {
        $this->db->where('ion_user_id',$id);
        $query = $this->db->get('patient');
        return $query->row();
    }

    function getCounries()
    {
        $this->db->group_by('country');
        return $this->db->get('countries_and_cities')->result();
    }

    function updateprofileimage($id,$img_url)
    {
        $data = array('img_url'=>$img_url);
        $this->db->where('ion_user_id',$id);
        $this->db->update('doctor',$data);
    }

    function updatePatientprofileimage($id,$img_url)
    {
        $data = array('img_url'=>$img_url);
        $this->db->where('ion_user_id',$id);
        $this->db->update('patient',$data);
    }
    function getPatientprofileimage($id)
    {
        $this->db->where('ion_user_id',$id);
        return $this->db->get('patient')->row();
    }

}
