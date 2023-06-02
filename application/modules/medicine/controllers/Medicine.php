<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medicine extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('medicine_model');
        // if (!$this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor'))) {
        //     redirect('home/permission');
        // }
    }

    public function index() {

        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/pharmacy-dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['medicines'] = $this->medicine_model->getMedicineByPageNumber($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineStockAlert() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = '0';
        $data['medicines'] = $this->medicine_model->getMedicineByStockAlert($page_number);
        //  $data['medicines'] = $this->medicine_model->getMedicineByStockAlertByPageNumber($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['pagee_number'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $data['alert'] = 'Alert Stock';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_stock_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineStockAlertByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $data['medicines'] = $this->medicine_model->getMedicineByStockAlert($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['pagee_number'] = $page_number;
        $data['alert'] = 'Alert Stock';
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_stock_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchMedicine() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['medicines'] = $this->medicine_model->getMedicineByKey($page_number, $key);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchMedicineInAlertStock() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['medicines'] = $this->medicine_model->getMedicineByKeyByStockAlert($page_number, $key);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_stock_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addMedicineView() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $this->load->view('home/pharmacy-dashboard', $data); // just the header file
        $this->load->view('add_new_medicine_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewMedicine() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $category_id = $this->input->post('category');
        $category_res = $this->medicine_model->getCategoryResults($category_id);
        $pcategory = $category_res['p_category'];//$this->input->post('sub_category');
        $subcategory = $category_res['subcategory'];//$this->input->post('sub_category');

        $p_price = $this->input->post('p_price');
        $type = $this->input->post('type');
        $s_price = $this->input->post('s_price');
        $quantity = $this->input->post('quantity');
        // $generic = $this->input->post('generic');
        $company = $this->input->post('company');
        $effects = $this->input->post('effects');
        $e_date = $this->input->post('e_date');
        $image = $_FILES['image']['name'];
        if(empty($id))
        {
            if(empty($image))
            {
                $image = "default_image.jpg";
            }
            else
            {
                $image = str_replace(' ','_',time().$image);
                $this->uploadProductImage($image);
            }
        }
        else
        {
            if(empty($image))
            {
                $image = $this->input->post('old_image');
            }
            else
            {
                $image = str_replace(' ','_',time().$image);
                $this->uploadProductImage($image);
            }
        }
        
        $descriptions = $this->input->post('descriptions');
        $prescription_required = $this->input->post('prescription_req');
        if(empty($prescription_required))
        {
            $prescription_required = 'no';
        }
        
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('medicine', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
        // Validating Purchase Price Field
        $this->form_validation->set_rules('p_price', 'Purchase Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Store Box Field
        // $this->form_validation->set_rules('box', 'Store Box', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Selling Price Field
        $this->form_validation->set_rules('s_price', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Quantity Field
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        // $this->form_validation->set_rules('generic', 'Generic Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Company Name Field
        $this->form_validation->set_rules('company', 'Company', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Effects Field
        $this->form_validation->set_rules('effects', 'Effects', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Expire Date Field
        $this->form_validation->set_rules('e_date', 'Expire Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['categories'] = $this->medicine_model->getMedicineCategory();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/pharmacy-dashboard', $data); // just the header file
            $this->load->view('add_new_medicine_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array(
                'category' => $pcategory,
                'subcategory' => $subcategory,
                'name' => $name,
                'vendor' => $company,
                'price' => $s_price,
                // 'box' => $box,
                'p_price' => $p_price,
                'image' => $image,
                'product_type' => $type,
                'quantity' => $quantity,
                // 'generic' => $generic,
                'effects' => $effects,
                'add_date' => $add_date,
                'e_date' => $e_date,
                'description' => $descriptions,
                'prescription_required' => $prescription_required
            );
            if (empty($id)) {
                $this->medicine_model->insertMedicine($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMedicine($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine');
        }
    }
    
    function uploadProductImage($image)
    {
         $config = array(
                    'file_name' => $image,
                    'upload_path' => "./assets/images/image/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => false,
                    'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "1768",
                    'max_width' => "2024"
                );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('image'))
        {
            $error = array('error' => $this->upload->display_errors());
            // echo "<pre>";
            // print_r($config);
            // print_r($error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            // echo "success";
        }
    }

    function editMedicine() {
        $data = array();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineById($id);
        // echo "<pre>";
        // print_r($data['medicine']);
        // exit;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/pharmacy-dashboard', $data); // just the header file
        $this->load->view('add_new_medicine_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function load() {
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');
        $previous_qty = $this->db->get_where('medicine_another', array('id' => $id))->row()->quantity;
        $new_qty = $previous_qty + $qty;
        $data = array();
        $data = array('quantity' => $new_qty);
        $this->medicine_model->updateMedicine($id, $data);
       $this->session->set_flashdata('feedback', lang('medicine_loaded'));
        redirect('medicine');
    }

    function editMedicineByJason() {
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteMedicine($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine');
    }

    public function medicineCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/pharmacy-dashboard', $data); // just the header file
        $this->load->view('medicine_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategoryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->medicine_model->getCategoriesP();
        $this->load->view('home/pharmacy-dashboard', $data); // just the header file
        $this->load->view('add_new_category_view');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        // $subcategory = $this->input->post('subcategory');
        $parent_cat = $this->input->post('parent_category');
        $status = $this->input->post('status');
        $is_feature = $this->input->post('is_feature');
        if($is_feature=="")
        {
            $is_feature = 0;
        }

        if($parent_cat=="")
        {
            $parent_cat = 0;
        }
        $cimage = $_FILES['category_img']['name'];
        if($cimage=="")
        {
            if($id=="")
            {
                $cimage = "default_image.jpg";
            }
            else
            {
                $cimage = $this->input->post('old_category_img');
            }
        }
        else
        {
            $cimage = str_replace(' ','_',time().$cimage);
            $this->uploadCategoryImage($cimage);
        }        

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Description Field
        // $this->form_validation->set_rules('subcategory', 'Subcategory', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['categories'] = $this->medicine_model->getCategoriesP();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/pharmacy-dashboard', $data); // just the header file
            $this->load->view('add_new_category_view');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category_name' => $category,
                'status' => $status,
                'parent_id' => $parent_cat,
                'is_feature' => $is_feature,
                'category_img' => $cimage
            );
            if (empty($id)) {
                $this->medicine_model->insertMedicineCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMedicineCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine/medicineCategory');
        }
    }

    function uploadCategoryImage($image)
    {
         $config = array(
                    'file_name' => $image,
                    'upload_path' => "./uploads/category_images/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => false,
                    'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "1768",
                    'max_width' => "2024"
                );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('category_img'))
        {
            $error = array('error' => $this->upload->display_errors());
            // echo "<pre>";
            // print_r($config);
            // print_r($error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            // echo "success";
        }
    }

    function edit_category() {
        $data = array();
        $id = $this->input->get('id');
        $data['categories'] = $this->medicine_model->getCategoriesP();
        $data['medicine'] = $this->medicine_model->getMedicineCategoryById($id);
        // echo "<pre>";
        // print_r($data['medicine']);
        // exit;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/pharmacy-dashboard', $data); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editMedicineCategoryByJason() {
        $id = $this->input->get('id');
        $data['medicinecategory'] = $this->medicine_model->getMedicineCategoryById($id);
        echo json_encode($data);
    }

    function deleteMedicineCategory() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteMedicineCategory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine/medicineCategory');
    }

    function getMedicineList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMedicineBysearch($search);
            } else {
                $data['medicines'] = $this->medicine_model->getMedicine();
            }
        } else {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMedicineByLimitBySearch($limit, $start, $search);
            } else {
                $data['medicines'] = $this->medicine_model->getMedicineByLimit($limit, $start);
            }
        }
        // echo "<pre>";
        // print_r($data['medicines']);
        // exit;
        //  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        foreach ($data['medicines'] as $medicine) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();
            if ($medicine->quantity <= 0) {
                $quan = '<p class="os">Stock Out</p>';
            } else {
                $quan = $medicine->quantity;
            }
            $load = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $medicine->id . '">' . lang('load') . '</button>';
            $option1 = '<a href="medicine/editMedicine?id='.$medicine->id.'" class="btn btn-info btn-xs btn_width" data-id="' . $medicine->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';

            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="medicine/delete?id=' . $medicine->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            $info[] = array(
                $i,
                $medicine->name,
                $medicine->category,
                // $medicine->box,
                $settings->currency.' ' . str_replace('Rs.','',$medicine->p_price),
                $settings->currency.' ' . str_replace('Rs.','',$medicine->price),
                $quan . '<br>' . $load,
                // $medicine->generic,
                $medicine->vendor,
                // $medicine->effects,
                $medicine->e_date,
                $option1 . ' ' . $option2
                    //  $options2
            );
        }

        if (!empty($data['medicines'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('medicine')->num_rows(),
                "recordsFiltered" => $this->db->get('medicine')->num_rows(),
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

    public function getMedicinenamelist() {
        $searchTerm = $this->input->post('searchTerm');

        $response = $this->medicine_model->getMedicineNameByAvailablity($searchTerm);
        $data = array();
        foreach ($response as $responses) {
            $data[] = array("id" => $responses->id, "data-id" => $responses->id, "data-med_name" => $responses->name, "text" => $responses->name);
        }

        echo json_encode($data);
    }

    public function getMedicineListForSelect2() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->medicine_model->getMedicineInfo($searchTerm);

        echo json_encode($response);
    }

    public function getMedicineForPharmacyMedicine() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->medicine_model->getMedicineInfoForPharmacySale($searchTerm);

        echo json_encode($response);
    }

}

/* End of file medicine.php */
/* Location: ./application/modules/medicine/controllers/medicine.php */
