<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Leaderboard_model extends CI_Model{
	public function construct(){
		$this->load->database();
	}
	public function get_participants($type="",$user_id="")
	{
		$fields=array("te.user_id","u.first_name","u.last_name","u.profile_image","COUNT(DISTINCT(te.id)) as progress_count","COUNT(td.question_id) as questions","SUM(td.is_correct) as accuracy","SUM(DISTINCT(TIMESTAMPDIFF(MINUTE,te.start_date,te.end_date))) as minutes","u.tips","co.name as course_name","u.gender");
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->join("users u","u.id=te.user_id");
		$this->db->join("test_details td","td.test_id=te.id");
		$this->db->join("courses co","co.id=te.course_id","left");
		$this->db->where("te.surprise_test_id",$type);
		$this->db->where("te.test_type","2");
		$this->db->where("td.status","1");
		$this->db->where("te.result","1");
		$this->db->where("u.status","1");
		if($user_id != ""){
			$this->db->where("te.user_id",$user_id);
		}
		
		$this->db->order_by("progress_count","desc");
		$this->db->group_by("te.user_id");
		$this->db->limit(10);
		$result=$this->db->get();
		if($user_id != ""){
			$data=$result->row_array();
		}
		$data=$result->result_array();
		// echo $this->db->last_query();die;
		return $data;
	}
	public function get_tips($user_id)
	{
		$fields = array("u.tips","u.tips_title","co.name as course_name","u.first_name","u.last_name",
		"u.profile_image");
		$this->db->select($fields);
		$this->db->from("users u");
		$this->db->join("test_engagement te","te.user_id=u.id","left");
		$this->db->join("courses co","co.id=te.course_id");
		$this->db->where("u.id",$user_id);
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
 	}
	public function get_all_subject(){
		$this->db->where("status",1);
		$this->db->order_by('sort_order','asc');
		$res=$this->db->get("subjects")->result_array();
		$data["All"]="Over All"; 
		foreach($res as $result_in){
			$data[$result_in["id"]]=$result_in["name"];
		}
		return $data;
	}
}

?>
