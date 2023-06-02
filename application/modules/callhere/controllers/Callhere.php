<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Callhere extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(array('form','url'));
        $this->load->library('session');
        // $this->load->model('speciality_model');

        // if (!$this->ion_auth->in_group('superadmin')) {
        //     redirect('home/permission');
        // }
    }

    public function index() {
        echo "Hello world!";
    }

    public function getToken() {
        echo "Hello world! 123";
    }


}
