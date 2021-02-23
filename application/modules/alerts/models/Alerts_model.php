<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Alerts_model extends CI_Model{
	public function construct()
	{
		$this->load->database();
	}
	public function get_alerts($user_id,$type="",$visited_id="",$start="",$limit_start = null, $limit_end = null)
	{ 
		$fields=array("t2.id","t2.created", "t2.title","t2.attachment", "t2.short_description","co.name as course_name",
		"t2.alert_type");
		$this->db->select($fields);
		$this->db->from("alert_users t1");
		$this->db->join("alerts t2","t2.id=t1.alert_id","left");
		$this->db->join("courses co","co.id=t2.course_id","left");
		if($type!="" )
		{
			$this->db->where("t1.user_id",$user_id);
			$this->db->where("t1.status",1);
		}
		else 
		{
			$this->db->where("t1.user_id",$user_id);
		}
		$this->db->where("t2.status",1);
		$this->db->group_by("t1.id");
		$this->db->order_by("t2.created","desc");
		if($type=="" && $start!="")
		{
			$start = $start*10;
			$this->db->limit(10,$start);
		}
		if ($limit_start != '' || $limit_end != '')
		{
      		$this->db->limit($limit_start, $limit_end);
      	}
		$res=$this->db->get();
		if($type=="")
		{
			$data=$res->result_array();
		}
		else if($type=="push")
		{ 	
			$data=$res->result_array();
			
		}else{
			$data=$res->num_rows();
		}
		return $data;
		
	}
	public function alerts_list($user_id,$arr_course,$type="",$option="",$start="", $limit_start = null, $limit_end = null)
	{
		if($arr_course==null)
		{
			return 0;
		}
		$fields=array("a.id","a.created", "a.title", "a.short_description","a.attachment","co.name as course_name",
		"a.alert_type");
		$this->db->select($fields);
		$this->db->from("alerts a");
		$this->db->join("alert_users au","au.alert_id=a.id","left");
		$this->db->join("courses co","co.id=a.course_id","left");
		$this->db->join("orders o","o.course_id=a.course_id","left");
		if($type!="" && $option!="")
		{
			$this->db->where("(au.user_id =".$user_id." OR a.course_id IN(".implode(",",$arr_course)."))");
			$this->db->where_not_in("a.id",$option);
		}
		else 
		{
			$this->db->where("au.user_id",$user_id);
			$this->db->or_where_in("a.course_id",$arr_course);
			$this->db->where("o.created <= a.created");
		}
		$this->db->where("a.status",1);
		if($type=="" && $start!="")
		{
			$start = $start*10;
			$this->db->limit(10,$start);
		}
		if ($limit_start != '' || $limit_end != '')
		{
      		$this->db->limit($limit_start, $limit_end);
      	}
		$this->db->order_by("a.created","desc");
		$this->db->group_by("a.id");
		$result=$this->db->get();
		if($type=="")
		{
			$data=$result->result_array();
		}
		else
		{ 	
			if($type=="push")
			{
				$data=$result->result_array();
			}else{
				$data=$result->num_rows();
			}
			
		}
		return $data;
	}
	public function alert_visit($user_id,$alert_id=null)
	{  
		$arr = array('status' => '2'); 
		$this->db->where('user_id',$user_id);
		$this->db->where('status','1');
		$this->db->update('alert_users',$arr);
	}
	public function get_alert_id($user_id)
	{
		$fields = array('alert_id');
		$this->db->select($fields);
		$this->db->from("alert_users");
		$this->db->where("user_id",$user_id);
		$this->db->where("status",2);
		$result=$this->db->get();
		$data=$result->result_array();
		return $data;
	}
 
}

?>
