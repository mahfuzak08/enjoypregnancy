<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chat_model extends CI_model {

    function __construct() {

        parent::__construct();

        $this->load->database();

    }
	
	function setConversation($ids, $userid, $title="Personal")
	{
		$data = array(
			"participants_ids"=> implode(',', $ids),
			"conv_type"=> count($ids) == 2 ? "single" : "group",
			"created_by"=>$userid
		);
		if($data['conv_type'] == "group"){
			$data['title'] = $title;
		}
		if($this->db->insert("conversation", $data))
			return $this->db->insert_id();
		else
			return 0;
	}
	
	function updateConversation($arg)
	{
		$data = array();
		
		if(isset($arg['title']) && $arg['title'] != "") 
			$data['title'] = $arg['title'];
		if(isset($arg['img']) && $arg['img'] != "") 
			$data['img'] = $arg['img'];
		if(isset($arg['type']) && $arg['type'] != "" && $arg['type'] == "leave" && $arg['receiver'] != "")
			$data['participants_ids'] = implode(',', array_diff(explode(",", $arg['receiver']), [$arg['user_id']] ) );
		if(isset($arg['select_user']) && $arg['select_user'] != "")
			$data['participants_ids'] = implode(',', $arg['select_user']);
		
		$this->db->where("id", $arg[id]);
		if(isset($arg['type']) && $arg['type'] == "delete"){
			return $this->db->delete("conversation");
		}
		elseif($this->db->update("conversation", $data))
			return true;
		else
			return false;
	}
	
	function getOneConversation($id, $userid, $type="single")
	{
		if($type == "single"){
			$str = "SELECT conversation.*, users.username, users.img as fimg, message.msg_body, message.created_at as msg_time
				FROM conversation 
				JOIN users on users.id = REPLACE(REPLACE(conversation.participants_ids, ".$userid.", ''), ',', '') 
				LEFT JOIN message on message.id = conversation.last_msg_id
				WHERE conversation.id = $id";
		}
		elseif($type == "group"){
			$str = "SELECT conversation.*, message.msg_body, message.created_at as msg_time 
				FROM conversation 
				LEFT JOIN message on message.id = conversation.last_msg_id
				WHERE conversation.id = $id";
		}
		return $this->db->query($str)->result();
	}
	
	function getConversation($ids, $userid)
	{
		$str = "SELECT id FROM conversation WHERE FIND_IN_SET(".$ids[0].", participants_ids) AND FIND_IN_SET(".$ids[1].", participants_ids)";
		$convid = $this->db->query($str)->row()->id;
		if($convid == "")
			$convid = $this->setConversation($ids, $userid);
		
		if($convid > 0){
			return $this->getOneConversation($convid, $userid);
		}else{
			return 0;
		}
	}
	
	function getParticipantsInfo($ids)
	{
		if(gettype($ids) == "string"){
			$ids = explode(",", $ids);
		}
		$this->db->select("id, username, img");
		$this->db->where_in("id", $ids);
		return $this->db->get("users")->result();
	}
	
	function createGroup($ids, $userid)
	{
		$str = "SELECT id FROM conversation WHERE FIND_IN_SET(".$ids[0].", participants_ids) AND FIND_IN_SET(".$ids[1].", participants_ids)";
		$convid = $this->db->query($str)->row()->id;
		if($convid == "")
			$convid = $this->setConversation($ids, $userid);
		
		if($convid > 0){
			return $this->getOneConversation($convid, $userid);
		}else{
			return 0;
		}
	}
	
	function getConversationLists($userid)
	{
		$str = "SELECT conversation.*, users.username, users.img as fimg, message.msg_body, message.created_at as msg_time, (SELECT COUNT(id) FROM message WHERE read_status = $userid AND conversation_id = conversation.id) as total_unread
				FROM conversation 
				LEFT JOIN users on users.id = REPLACE(REPLACE(conversation.participants_ids, ".$userid.", ''), ',', '') 
				LEFT JOIN message on message.id = conversation.last_msg_id
				WHERE FIND_IN_SET(".$userid.", conversation.participants_ids)";
		return $this->db->query($str)->result();
	}
	
	function is_room_name_free($str)
	{
		$this->db->where("title", $str);
		$this->db->from("conversation");
		return $this->db->count_all_results() > 0 ? false : true;
	}
	
	function totalUnreadMessages($id)
	{
		$this->db->select('id');
		$this->db->from("message");
		$this->db->where("FIND_IN_SET('$id', read_status)");
		return $this->db->count_all_results();
	}
	
	function getMessages($id, $msgid=0)
	{
		$this->db->select("message.*, c.title, c.img, c.conv_type, users.username as sender_name, users.img as sender_img");
		$this->db->join("users", "users.id = message.sender_id", "left");
		$this->db->join("conversation as c", "c.id = message.conversation_id", "left");
		if($msgid>0)
			$this->db->where("message.id", $msgid);
		else
			$this->db->where("conversation_id", $id);
		$result = $this->db->get("message")->result();
		
		if($msgid == 0){
			$user_id = $this->ion_auth->get_user_id();
			$str = "UPDATE message
						SET read_status = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', read_status, ','), ',$user_id,', ','))
						WHERE FIND_IN_SET('$user_id', read_status)";
			$this->db->query($str);
		}
		return $result;
	}
	
	function setMessage($post)
	{
		$data=array(
			"conversation_id"=>$post["conversation_id"],
			"msg_body"=>$post["message"],
			"read_status"=>$post["receiver"],
			"sender_id"=>$post["sender_id"],
			"msg_type"=>$post["msg_type"]
		);
		if($this->db->insert("message", $data)){
			$lid = $this->db->insert_id();
			$this->db->where("id", $post["conversation_id"])->update("conversation", array("last_msg_id"=>$lid));
			return $lid;
		}
		else false;
	}


}