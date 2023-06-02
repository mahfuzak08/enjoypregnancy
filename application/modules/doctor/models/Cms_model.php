<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_model extends CI_model {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->database();
            // $this->load->helper(array('form','url'));
    }
	
	function find_or_add_catid($data){
		$this->db->where('title', $data['blog_category']);
		$result = $this->db->get('blog_category')->row();
		if(!empty($result)) return $result->id;
		else{
			if($this->db->insert('blog_category', array('title'=>$data['blog_category'], 'created_by'=>$data['id']))){
				return $this->db->insert_id();
			}else{
				return 0;
			}
		}
	}

    function add_post_data($data)
    {
        if(isset($data['status']))
        {
            $status = "1";
        }
        else
        {
            $status = "0";
        }        
        $date_i = date('Y-m-d H:i:s');
        $data_arr = array(
			'page_name'=>$data['post_name'],
			'title'=>$data['title'],
			'category_id'=>$data['category_id'],
			'description'=>$data['description'],
			'og_banner'=>$data['post_image'],
			'page_content'=>$data['page_content'],
			'status'=>$status,
			'dateandtime'=>$date_i,
			'page_url'=>$data['url'],
			'author'=>$data['author'],
			'video_url'=>$data['video_url'],
			'tag_lists'=>$data['tag_lists'],
			'doc_id'=>$data['id'],
			'is_approved'=>0
		);
        $this->db->insert('posts',$data_arr);
        return $this->db->insert_id();
        // return 1;
    }

    function add_copy_post_data($data)
    {
        if($data['status']==1)
        {
            $status = "1";
        }
        else
        {
            $status = "0";
        }
        $date_i = date('Y-m-d H:i:s'); 
        $data_arr = array(
			'page_name'=>$data['post_name'],
			'title'=>$data['title'],
			'category_id'=>$data['category_id'],
			'description'=>$data['description'],
			'og_banner'=>$data['og_banner'],
			'page_content'=>$data['page_content'],
			'status'=>$status,
			'dateandtime'=>$date_i,
			'page_url'=>$data['url'],
			'author'=>$data['author'],
			'video_url'=>$data['video_url'],
			'tag_lists'=>$data['tag_lists'],
			'doc_id'=>$data['doc_id'],
			'is_approved'=>0
		);
        $this->db->insert('posts',$data_arr);
        return $this->db->insert_id();
    }  

    function get_all_posts($id)
    {
        $this->db->where('doc_id',$id);
        return $this->db->get("posts")->result();
    }


    function get_post_data($id)
    {
		$this->db->select('posts.*, blog_category.title as bct');
		$this->db->join('blog_category', 'posts.category_id = blog_category.id', 'left');
        $this->db->where('posts.id',$id);
        return $this->db->get("posts")->row_array();
    }

    function update_post_details($data)
    {
        $status = $data['status'];
        $date_i = date('Y-m-d H:i:s');
        $data_arr = array(
			'page_name'=>$data['post_name'],
			'title'=>$data['title'],
			'category_id'=>$data['category_id'],
			'description'=>$data['description'],
			'og_banner'=>$data['post_image'],
			'page_content'=>$data['page_content'],
			'status'=>$status,
			'dateandtime'=>$date_i,
			'page_url'=>$data['url'],
			'author'=>$data['author'],
			'video_url'=>$data['video_url'],
			'tag_lists'=>$data['tag_lists'],
			'doc_id'=>$data['id'],
			'is_approved'=>0
		);
        $this->db->where("id",$data['post_id']);
		if($this->db->update('posts',$data_arr)) return 1;
		else return 0;
    }

    function deletepostdata($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('posts');
    }
    
    function get_reuested_posts()
    {
        $this->db->where(array('status'=>1,'is_approved'=>0));
        return $this->db->get('posts')->result();
    }
    
    function approve_post($id)
    {
        $data_arr = array('is_approved'=>1);
        $this->db->where("id",$id);
        $this->db->update('posts',$data_arr);
        return 1;
    }
    
    function reject_post($id)
    {
        $data_arr = array('is_approved'=>2);
        $this->db->where("id",$id);
        $this->db->update('posts',$data_arr);
        return 1;
    }
    
}
