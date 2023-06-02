<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class bodycharttemplate extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('Bodycharttemplate/Bodycharttemplate_model');

        if (!$this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Patient', 'Receptionist'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('bodycharttemplate/templatelist_view');
        $this->load->view('home/footer'); // just the footer file
    }

    public function request() {
        $data['patients'] = $this->patient_model->getPatient();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('templatelist_view');
        $this->load->view('home/footer'); // just the header file
    }

 




}

/* End of file appointment.php */
    /* Location: ./application/modules/appointment/controllers/appointment.php */
    