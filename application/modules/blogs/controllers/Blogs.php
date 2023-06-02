<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MX_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('profile/profile_model');
        $this->load->model('auth/general_model');
        $this->load->model('hoispital/hospital_model');
        $this->load->model('blog/Cms_model','cm');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(array('form','url'));
    }

    public function index()
    {  
        echo 123; exit;
      $meta['page_title']="Posts";
      $data['page_link']="Posts";
      $data['all_pages'] = $this->cm->get_all_posts();
      $this->load->view('home/dashboard'); // just the header file
      $this->load->view('blog/view_posts', $data);
      $this->load->view('home/footer'); // just the footer file
    }

    public function add_new_post()
    {  
      $meta['page_title']="Blog";    
      $data['page_title']="Blog";
      $data['page_link']="Add New Post";
      $data['Sub_link']="";
      $this->load->view('include/header', $meta);
      $this->load->view('include/sidebar');
      $this->load->view('add_new_page' , $data);
    }

    function save_new_post()
    {
        $data = $this->input->post();
        $doctor_id =  $this->ion_auth->get_user_id();
        $image_h = $_FILES['post_image']['name'];
        $data['page_content'] = str_replace("'","`",$data['page_content']);
        if(!empty($image_h))
        {
            $image_h = time().$image_h;
            $ud = $this->uploadprofimg($image_h);
            file_put_contents('finfo.txt', json_encode($ud));
            $data['post_image'] = $image_h;
        }
        else
        {
            $data['post_image'] = "";
        }
        // echo str_replace('bookingadmin', '', $_SERVER['DOCUMENT_ROOT']); exit();
        if(file_exists(str_replace('bookingadmin', '', $_SERVER['DOCUMENT_ROOT']).'/'.str_replace(' ','-',strtolower($data['title'])).'.php'))
        {
          $this->session->set_flashdata('error_page_existance','Post already exists at this name. Try another name please.');
          $this->session->set_flashdata('pagecontent',$data['page_content']);
          redirect('cms/posts');
          exit;
        }        
        // echo "<pre>";
        // print_r($data);
        // exit;
        $data['url'] = str_replace(' ','-',strtolower($data['title']));  
        $res = $this->cm->add_post_data($data);
        $fp = fopen(str_replace('bookingadmin', '', $_SERVER['DOCUMENT_ROOT']).'/'.str_replace(' ','-',strtolower($data['title'])).'.php','w');        
        $page_data = $this->getpagedatafnc($res);          
        fwrite($fp, '<?php include("header.php"); ?>'.$page_data.'<?php include("footer.php"); ?>');
        fclose($fp);

        $this->session->set_flashdata('success','Post successfully created.');
        redirect('cms/posts?success=1');           
    }

    function getpagedatafnc($id)
    {
      $post_data = $this->cm->getpagedatatohtml($id);
      // $post_data = mysqli_fetch_object($query);
      // echo "<pre>";
      // print_r($post_data);
    $html = '<style type="text/css">
      .post-img img 
      {
         border-radius: 5px;
         -webkit-box-shadow: 0px 2px 23px -7px rgba(0,0,0,0.75);
         -moz-box-shadow: 0px 2px 23px -7px rgba(0,0,0,0.75);
         box-shadow: 0px 2px 23px -7px rgba(0,0,0,0.75);
      }
    </style>
    <div class="setting-main-area-for-all">
      <div class="inner-section">
                  <div class="container">
            <h2 class="main-title">
               Post
            </h2>

            <ul class="breadcrumbs">
               <li>
                  <a href="#">
                     <span>Home</span> 
                  </a>
                  <span class="breadcrumb-divider"></span>
               </li> 
               <li> / </li>
               <li>
                  <span> Post </span>
               </li>
            </ul> 
         </div>
      </div>
      </div>
      <!-- main -->      
      <div class="page-section" style="padding:60px 0;">
         <div class="container item-card">            
            <div class="row text-card">
               <div class="col-lg-8">
                  <h2>'.$post_data['title'].'</h2>
                  <span class="divider"></span>
                  <div class="discription-div">                     
                     '.$post_data['page_content'].'
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="text-center post-img">
                     <img src="bookingadmin/images/post_img/'.$post_data['og_banner'].'" class="img-responsive" style="width: 100%">
                  </div>
                  <br>
                  <div class="author-div">                       
                     <div class="row">
                        <div class="col-md-6">
                           <i class="fa fa-user"></i>'.$post_data['author'].'
                           </div>
                        <div class="col-md-6">
                           <i class="fa fa-calendar"></i>'.date('F d, Y',strtotime($post_data['dateandtime'])).'
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>';

      return $html;
    }

    function uploadprofimg($image_h)
    {
        $config['upload_path']   = 'images/post_img';
        $config['allowed_types'] = 'jpg|png|jpeg|gif';
        $config['overwrite']     = FALSE;
        $config['file_name']     = $image_h;
        $config['max_size']      = '100000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('post_image')) {
            $error = array(
                'error' => $this->upload->display_errors()
            );

        }
        else{
         $ud = $this->upload->data();
         file_put_contents('finfo1.txt', json_encode($ud));
         return $ud;
        }
    }

     public function update_post($id)
    {  
      $meta['page_title']="Post";  
      $data['page_title']="Post";
      $data['page_link']="Update Post";
      $data['Sub_link']="";
      $data['pid'] = $id;
      $this->load->view('include/header', $meta);
      $this->load->view('include/sidebar');
      $data['parent_pages'] = $this->cm->get_all_parent_pages();
      $data['edit'] = $this->cm->get_post_data($id);
      $this->load->view('update_post' , $data);
      // $this->load->view('include/footer');
    }

    function update_post_data()
    {
        // echo $_SERVER['DOCUMENT_ROOT']; exit;
        $data = $this->input->post();
        $image_h = $_FILES['post_image']['name'];
        $data['page_content'] = str_replace("'", "`", $data['page_content']);
        if(!empty($image_h))
        {
            $image_h = time().$image_h;
            $this->uploadprofimg($image_h);
            $data['post_image'] = $image_h;
        }
        else
        {
            $data['post_image'] = $data['old_image'];
        }        
        $data['url'] = str_replace(' ','-',strtolower($data['title']));
        $res = $this->cm->update_post_details($data);  
        // rename(str_replace('bookingadmin', '', '../'.$_SERVER['DOCUMENT_ROOT']).'/'.strtolower($data['old_post_url']).'.php', str_replace(' ','-',strtolower($data['title'])).'.php');
        // file_put_contents(str_replace('bookingadmin', '', '../'.$_SERVER['DOCUMENT_ROOT']).'/'.str_replace(' ','-',strtolower($data['title'])).'.php', "");        
        // $page_data = $this->getpagedatafnc($data['id']);
        unlink(str_replace('bookingadmin', '', $_SERVER['DOCUMENT_ROOT']).'/'.str_replace(' ','-',strtolower($data['old_post_url'])).'.php');
        // rename(str_replace('bookingadmin', '', $_SERVER['DOCUMENT_ROOT']).'/'.strtolower($data['old_post_url']).'.php', str_replace(' ','-',strtolower($data['title'])).'.php');
        // file_put_contents(str_replace('bookingadmin', '', $_SERVER['DOCUMENT_ROOT']).'/'.str_replace(' ','-',strtolower($data['title'])).'.php', "");        
        $page_data = $this->getpagedatafnc($data['id']); 
        $fp = fopen(str_replace('bookingadmin', '', $_SERVER['DOCUMENT_ROOT']).'/'.str_replace(' ','-',strtolower($data['title'])).'.php','w');
        fwrite($fp, '<?php include("header.php"); ?>'.$page_data.'<?php include("footer.php"); ?>');
        fclose($fp);
        
        $this->session->set_flashdata('success','Post successfully Updated.');
        redirect('cms/posts?success=3'); 
    }

    function delete_post($id,$travel_guide)
    {
      $pagename = $this->cm->getpagedatatohtml($id);
      unlink(str_replace('bookingadmin', '', $_SERVER['DOCUMENT_ROOT']).'/'.str_replace(' ','-',strtolower($pagename['page_url'])).'.php');
      $this->cm->deletepostdata($id);
      $this->session->set_flashdata('success','Post successfully deleted.');
      redirect('cms/posts?success=2');
    }
    
    function copypost($id)
    {
        $data = $this->cm->get_post_data($id); 
        $data['url'] = $data['page_url'].'-copy'; 
        $data['title'] = $data['title'].' Copy';       
        $res = $this->cm->add_copy_post_data($data);

        $fp = fopen(str_replace('bookingadmin', '', '../'.$_SERVER['DOCUMENT_ROOT']).'/'.str_replace(' ','-',strtolower($data['page_url'])).'-copy.php','w');
        $page_data = $this->getpagedatafnc($res);
        fwrite($fp, '<?php include("header.php"); ?>'.$page_data.'<?php include("footer.php"); ?>');    
        fclose($fp);

        $this->session->set_flashdata('success','Post successfully copied.');
        redirect('cms/posts?success=3');        
    }
    
}
