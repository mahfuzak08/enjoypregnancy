<?php
#Author Md. Hasanat Zamil  hzamil@gmail.com
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pf extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('pf_model');
        //  $this->load->model('patient_model');
        $this->load->model('patientfromtemplate/patientfromtemplate_model');

    }
    public function signature()
    {
        $data['token'] = $this->input->get('token');
        $this->load->view('signature', $data);

    }
    public function index()
    {

        $id = $this->input->get('token');
        $data['template'] = $this->pf_model->getPatientFromTemplateByToken($id);

        if($data['template']->answared == 'Yes') redirect("pf/message?type=2&id=" . $id);

        $data['sections'] = $this->pf_model->getFormSection($data['template']->id);

        // $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('patientfrom_view', $data);
        $this->load->view('home/footer'); // just the header file

    }

    public function saveAnsFrm()
    {
        $id = $this->input->post('token');
        $template = $this->pf_model->getPatientFromTemplateByToken($id);



        if ($template->answared == 'No') {
            $answares = $this->input->post('ans');
            $anstype = $this->input->post('anstype');

            if ($template) {
                $temData = array(
                    'submited_date' => time(),
                    'answare_json' => serialize($answares),
                    'completed' => 'Yes',
                    'answared' => 'Yes',
                );
                $this->patientfromtemplate_model->updatePatientForm($template->fid, $temData);

                foreach ($answares as $key => $ans) {

                    $ans_type = $anstype[$key];
                    $formData = array(
                        'patient_form_id' => $template->fid,
                        'question_id' => $key,
                        'answare' => is_array($ans) ? implode('|', $ans) : $ans
                    );

                    ///////////////////////////////////
                    $this->pf_model->insertPatientFormAnsware($formData);
                }

                //////////////////File Attachment/////////////////


                if ($_FILES)
                    foreach ($_FILES as $fileArr) {
                        print_r($fileArr);
                        foreach ($fileArr['name'] as $k2 => $item) {
                            print_r($fileArr['tmp_name'][$k2]);
                            $tmp_name = $fileArr['tmp_name'][$k2];
                            $file_name = $item;

                           $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                            $new_file_name = "./uploads/patient_form/" . time() . '_' . str_replace(' ', '_', $file_name);
                            $extensions = array("jpeg", "jpg", "png", "gif", "pdf", "mp4", "wav", "ogg", "avi","webm");

                            if (in_array($ext, $extensions))
                                $result = move_uploaded_file($tmp_name, $new_file_name);

                            if ($result) {
                                $formData = array(
                                    'patient_form_id' => $template->fid,
                                    'question_id' => $k2,
                                    'answare' => $new_file_name
                                );
                                $this->pf_model->insertPatientFormAnsware($formData);
                            }


                        }
                    }
                ////end file upload//////////////

                redirect("pf/message?type=0&id=" . $id);
            } else redirect("pf/message?type=1&id=" . $id);
        } else redirect("pf/message?type=2&id=" . $id);
    }


    public function message()
    {
        $id = $this->input->get('token');
        $type = $this->input->get('type');
        if($type == 1) {
            $data['messageTitle'] = 'Error!';
            $data['messageTxt'] = 'Failed to submit';
        }
        if($type == 0){
        $data['messageTitle'] = 'Thank you!';
        $data['messageTxt'] = "We've received your information. Enjoy the rest of your day.";
        }
        if($type == 2) {
            $data['messageTitle'] = 'Alert!';
            $data['messageTxt'] = 'This information has already been sent. There\'s nothing more to do.!';
        }
        $data['template'] = $this->pf_model->getPatientFromTemplateByToken($id);
        $this->load->view('home/css'); // just the header file
        $this->load->view('patientfrom_message', $data);
        $this->load->view('home/footer'); // just the header file
    }


}