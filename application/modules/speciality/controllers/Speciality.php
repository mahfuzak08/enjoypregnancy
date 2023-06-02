<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Speciality extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('speciality_model');

        if (!$this->ion_auth->in_group('superadmin')) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data['specialities'] = $this->speciality_model->getSpeciality();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('speciality', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $image = $_FILES['image']['name'];
        $icon = $_FILES['icon']['name'];
        // $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Password Field    
        // Validating Email Field
        // $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[2]|max_length[1000]|xss_clean');
        // Validating Address Field  
        

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['speciality'] = $this->speciality_model->getSpecialityById($id);
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {



            if(!empty($image))
            {
                $image = $this->upload_specialityImage(str_replace(" ", "_", time().$image));
            }
            else
            {
                if (empty($id))
                {
                    $image = base_url().'assets/images/speciality_images/default.jpg';
                }
                else
                {
                    $image = $this->input->post('old_image');
                }
            }

            if(!empty($icon))
            {
                $icon = $this->upload_specialityIcon(str_replace(" ", "_", time().$icon));
            }
            else
            {
                if (empty($id))
                {
                    $icon = base_url().'assets/images/speciality_images/default.jpg';
                }
                else
                {
                    $icon = $this->input->post('old_icon');
                }
            }

            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'speciality' => $name,
                'image' => $image,
                'icon' => $icon
                // 'description' => $description
            );
            if (empty($id)) {     // Adding New department
                $this->speciality_model->insertSpeciality($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $this->speciality_model->updateSpeciality($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('speciality');
        }
    }

    function upload_specialityImage($image)
    {
        $config['file_name'] = $image;
        $config['upload_path']          = './assets/images/speciality_images';
        $config['allowed_types']        = 'gif|jpg|JPG|png|jpeg|JPEG';
        $config['max_size']             = 10000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;
        $img_url = base_url().'assets/images/speciality_images/'.$image;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('image'))
        {
            $error = array('error' => $this->upload->display_errors());
            // print_r($error);
            // return 0;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            return $img_url;
        }
    }

    function upload_specialityIcon($icon)
    {
        $config['file_name'] = $icon;
        $config['upload_path']          = './assets/images/speciality_images';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 10000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;
        $img_url = base_url().'assets/images/speciality_images/'.$icon;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('icon'))
        {
            $error = array('error' => $this->upload->display_errors());
            // print_r($error);
            // return 0;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            return $img_url;
        }
    }

    function getSpeciality() {
        $data['departments'] = $this->speciality_model->getSpeciality();
        $this->load->view('department', $data);
    }

    function editSpeciality() {
        $data = array();
        $id = $this->input->get('id');
        $data['speciality'] = $this->speciality_model->getSpecialityById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editSpecialityByJason() {
        $id = $this->input->get('id');
        $data['speciality'] = $this->speciality_model->getSpecialityById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->speciality_model->delete($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('speciality');
    }

    // Symptom checker code
    function symptomchecker()
    {
        // echo 123; exit;
        $data['symptoms'] = $this->speciality_model->getAllsymptoms();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('symptomchecker/symptomchecker', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addNewSymptom()
    {
        $data = $this->input->post();
        $id = $data['id'];
        $data = array(
                'symptoms' => $data['symptoms'],
                'type' => $data['type']
            );
        if (empty($id)) 
        {     
            // Adding New symptom            
            $this->speciality_model->insertSymptom($data);
            $this->session->set_flashdata('feedback', lang('added'));
        } 
        else 
        { 
            // Updating symptom
            $this->speciality_model->updateSymptom($id, $data);
            $this->session->set_flashdata('feedback', lang('updated'));
        }
        // Loading View
        redirect('symptomchecker');
    }

    function deletesymptom()
    {
        $id = $this->input->get('id');
        $this->speciality_model->deletesymptom($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('symptomchecker');
    }

    function editSymptomByJason()
    {
        $id = $this->input->get('id');
        $data['symptom_data'] = $this->speciality_model->getSymptomById($id);
        echo json_encode($data);
    }

    function symptomcheckerQuestionsAndAnswers()
    {
        $data['questionandanswers'] = $this->speciality_model->getAllQuestionsAndAnswers();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('symptomchecker/symptomcheckerQuestionAndAnswers', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addquestionanswer()
    {
        $data['symptoms'] = $this->speciality_model->getAllsymptoms();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('symptomchecker/add_question_answer', $data);
        $this->load->view('home/footer'); // just the header file

    }

    function editsymptomcheckerQuestionsAndAnswers($id)
    {
        $data['symptoms'] = $this->speciality_model->getAllsymptoms();
        $data['question_answer_data'] = $this->speciality_model->getquestionanswerData($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('symptomchecker/edit_question_answer', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function deletequestionsandanswers()
    {
        $id = $this->input->get('id');
        $this->speciality_model->deletesymptomQuestionandAnswer($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('symptomchecker/questionsAndanswers');
    }

    function addNewQuestioningAnswering()
    {
        $data = $this->input->post();
        $id = $data['id'];
        $data = array('symptoms' => $data['symptom'], 'questions' => $data['question'], 'answers' => $data['answer'], 'self_care' => $data['self_care']);
        // echo "<pre>";
        // print_r($data);
        // exit;
        if($id=="")
        {
            $this->speciality_model->insertquestioningAnswer($data);
            $this->session->set_flashdata('feedback', lang('added'));
        }
        else
        {
            $this->speciality_model->updatequestioningAnswer($id,$data);
            $this->session->set_flashdata('feedback', lang('updated'));
        }        
        redirect('symptomchecker/questionsAndanswers');
    }
    // end here

}

/* End of file department.php */
/* Location: ./application/modules/department/controllers/department.php */
