<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chat extends MX_Controller {

    function __construct() {
		parent::__construct();
		
		$this->load->model('chat_model');
		$this->load->model('frontend/frontend_model');
		$this->load->model('doctor/doctor_model');
        
		
	    if (!$this->ion_auth->in_group(array('Patient', 'Doctor') ) ) {
            redirect('home');
        }
    }
	
	public function index(){
		redirect('home');
	}
	
	function open($arg)
	{
		$data = array();
		$data['localTimeZone'] = $_SESSION['localTimeZone'];
		$data['localTimeZoneAbbr'] = $_SESSION['localTimeZoneAbbr'];
        $data['settings'] = $this->settings_model->getSettings();
		$data['sender_id'] = $data['user_id'] = $this->ion_auth->get_user_id();
		
		if($arg!=='all'){
			$ids = explode("-", $arg);
			for($i=0; $i<count($ids); $i++)
				$ids[$i] = base_convert($ids[$i], 16, 10);
			
			$data['conversation'] = $this->chat_model->getConversation($ids, $data['sender_id'])[0];
		}
		
		
		if ($this->ion_auth->in_group(array('Patient'))) {
			$data['patient_ion_id'] = $data['sender_id'];
			$data['patient_data'] = $data['sender_info'] = $this->frontend_model->getpatiendatabyId($data['sender_id']);
		}elseif ($this->ion_auth->in_group(array('Doctor'))) {
			$data['patient_ion_id'] = 0;
			$data['doctor_data'] = $data['sender_info'] = $this->doctor_model->getDoctorByIonUserId($data['sender_id']);
		}
		
		$data['conversation_lists'] = $this->chat_model->getConversationLists($data['sender_id']);
		usort($data['conversation_lists'], function($a, $b) {return strcmp($a->msg_time, $b->msg_time);});
		$data['conversation_lists'] = array_reverse($data['conversation_lists']);
		if($arg != 'all' && $data['conversation'] != 0)
			$data['messages'] = $this->chat_model->getMessages($data['conversation']->id, 0);
		elseif(count($data['conversation_lists']) > 0){
			$data['conversation'] = $data['conversation_lists'][0];
			$data['messages'] = $this->chat_model->getMessages($data['conversation']->id, 0);
		}
		$data['doctors'] = $this->doctor_model->getDoctor();
		
        $data['chatpage'] = true;
		$this->load->view('partial/_header', $data);
        $this->load->view('chat', $data);
        $this->load->view('partial/_footer', $data);
	}
	
	function get_users(){
		$data['doctors'] = $this->doctor_model->getDoctor();
		echo json_encode($data);
	}
	
	function openajax()
	{
		$data = array();
		$patient_ion_id = $this->ion_auth->get_user_id();
		$data['messages'] = $this->chat_model->getMessages($_POST['id'], 0);
		$data['success'] = true;
		echo json_encode($data);
	}
	
	function getOneConversation(){
		$convid = isset($_POST['id']) ? $_POST['id'] : isset($_GET['id']) ? $_GET['id'] : 0;
		$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : isset($_GET['user_id']) ? $_GET['user_id'] : 0;
		$type = isset($_POST['type']) ? $_POST['type'] : isset($_GET['type']) ? $_GET['type'] : 'single';
		$data['conversation'] = $this->chat_model->getOneConversation($convid, $user_id, $type)[0];
		$data['participants'] = $this->chat_model->getParticipantsInfo($data['conversation']->participants_ids);
		echo json_encode($data);
	}
	
	function create_room()
	{
		$data = array();
		$data = $_POST;
		$user_ion_id = $this->ion_auth->get_user_id();
		if(count($data['select_user']) == 2){
			$data['conversation'] = $this->chat_model->getConversation($data['select_user'], $user_ion_id)[0];
		}
		elseif(count($data['select_user']) > 2){
			if($this->chat_model->is_room_name_free($data['room_name'])){
				$convid = $this->chat_model->setConversation($data['select_user'], $user_ion_id, $data['room_name']);
				if($convid > 0)
					$data['conversation'] = $this->chat_model->getOneConversation($convid, $user_ion_id, 'group')[0];
				else{
					echo json_encode(array("success"=>false, "msg"=>"Group create error."));
					return false;
				}
			}else{
				echo json_encode(array("success"=>false, "msg"=>"Group name already exists, please try another."));
				return false;
			}
		}
		
		$data['messages'] = $this->chat_model->getMessages($data['conversation']->id, 0);
		$data['success'] = true;
		echo json_encode($data);
	}
	
	function update_room()
	{
		$data = array();
		$data = $_POST;
		$user_ion_id = $this->ion_auth->get_user_id();
		if($data['title'] != $data['old_room_name']){
			if(! $this->chat_model->is_room_name_free($data['title'])){
				echo json_encode(array("success"=>false, "msg"=>"Group name already exists, please try another."));
				return false;
			}
		}
		
		if($this->chat_model->updateConversation($data)){
			$conversation = $this->chat_model->getOneConversation($data['id'], $user_ion_id, 'group')[0];
			echo json_encode(array("success"=>true, "msg"=>"Group update successfully.", "conversation"=> $conversation));
		}
		else{
			echo json_encode(array("success"=>false, "msg"=>"Group update error, please try again letter."));
		}
	}
	
	function leave_delete_group()
	{
		$data = array();
		$data = $_POST;
		$user_ion_id = $this->ion_auth->get_user_id();
		$data['user_id'] = $user_ion_id;
		if($this->chat_model->updateConversation($data)){
			$conversation;
			if($data['type'] == 'leave'){
				$conversation = $this->chat_model->getOneConversation($data['id'], $user_ion_id, 'group')[0];
				$this->chat_model->setMessage(array("conversation_id"=>$data["id"], "message"=> "I am leaving from this group, bye bye...", "sender_id"=> $user_ion_id, "receiver"=>$conversation->participants_ids, "msg_type"=>"notification"));
			}
			echo json_encode(array("success"=>true, "data"=>$data, "conversation"=> $conversation));
		}
		else{
			echo json_encode(array("success"=>false, "msg"=>"Group update error, please try again letter."));
		}
	}
	
	function chat_submit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('sender_id', 'sender_id error', 'trim|required');
		$this->form_validation->set_rules('receiver', 'receiver error', 'trim|required');
		$this->form_validation->set_rules('conversation_id', 'conversation_id error', 'trim|required');
		$this->form_validation->set_rules('message', 'message empty', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array("success"=>false, "error"=>validation_error()));
		}
		else{
			if(strpos($_POST['receiver'], ',') !== false){
				$ids = explode(',', $_POST['receiver']);
				$_POST['receiver'] = implode(',', array_diff($ids, [$_POST['sender_id']] ) );
			}
			if(!empty($_FILES['msg_files']['name'][0])) {
				$files = $this->upload_files($_FILES['msg_files']);
				if(count($files)>0){
					$_POST['message'] .= "@FILE@".json_encode($files);
				}
			}
			elseif(!empty($_FILES['msg_audio_file']['name'])) {
				$_FILES['msg_audio_file']['name'] = time()."_".$_FILES['msg_audio_file']['name'];
				$files = $this->upload_voice();
				if(count($files)>0){
					$_POST['message'] .= "@FILE@".json_encode($files);
				}
			}
			$msgid = $this->chat_model->setMessage($_POST);
			$msg = $this->chat_model->getMessages($_POST['conversation_id'], $msgid);
			echo json_encode(array("success"=>true, "msg"=>$msg));
		}
	}
	
	function notification_msg()
	{
		$user_ion_id = $this->ion_auth->get_user_id();
		$conversation = $this->chat_model->getOneConversation($_POST['conversation_id'], $user_ion_id, 'group')[0];
		$_POST['receiver'] = implode(',', array_diff(explode(",", $conversation->participants_ids), [$_POST['sender_id']] ) );
		$_POST['msg_type'] = 'notification';
		$msgid = $this->chat_model->setMessage($_POST);
		$msg = $this->chat_model->getMessages($_POST['conversation_id'], $msgid);
		echo json_encode(array("success"=>true, "msg"=>$msg));
	}
	
	private function upload_files($files)
    {
        $config = array(
            'upload_path'   => 'chat_uploads/',
            'allowed_types' => '*',
            'overwrite'     => true
        );

        $this->load->library('upload', $config);

        $return_files = array();
		
        foreach ($files['name'] as $key => $file) {
			$_FILES['file']['name']     = time() .'_'. $files['name'][$key]; 
			$_FILES['file']['type']     = $files['type'][$key]; 
			$_FILES['file']['tmp_name'] = $files['tmp_name'][$key]; 
			$_FILES['file']['error']    = $files['error'][$key]; 
			$_FILES['file']['size']     = $files['size'][$key];
			$this->upload->initialize($config);
            if ($this->upload->do_upload('file')) {
                $ud = $this->upload->data();
				$return_files[] = "chat_uploads/" . $ud['file_name'];
            } else {
                return false;
            }
        }

        return $return_files;
    }
	
	private function upload_voice()
    {
        $config = array(
            'upload_path'   => 'chat_uploads/',
            'allowed_types' => '*',
            'overwrite'     => true
        );

        $this->load->library('Upload', $config);

        $return_files = array();
		
		$this->upload->initialize($config);
		if ($this->upload->do_upload('msg_audio_file')) {
			$ud = $this->upload->data();
			$return_files[] = "chat_uploads/" . $ud['file_name'];
		} else {
			file_put_contents("ue.txt", $this->upload->display_errors());
			return false;
		}
		
        return $return_files;
    }
	
	
}

/* End of file chat.php */
/* Location: ./application/modules/chat/controllers/chat.php */