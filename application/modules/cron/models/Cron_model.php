<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
	public function get_dates(){
		$res=$this->db->get("settings");
		return $res->row_array();
	}
	public function get_expiring_users($date){
		$this->db->where_in("course_expiry_date",$date);
		$this->db->from("user_plans");
		$this->db->join("users","users.id=user_plans.user_id");
		$this->db->join("courses","courses.id=user_plans.course_id");
		$this->db->group_by("user_plans.id");
		$res=$this->db->get();
		//echo $this->db->last_query();
		return $res->result_array();
	}
	public function expiry_status()
	{
		$current_date = date('Y-m-d');
		$fields = array('up.id as user_plan_id','u.first_name','u.last_name','co.name as course_name','u.email','up.course_start_date','up.course_expiry_date','up.is_expired');
		$this->db->select($fields);
		$this->db->from("user_plans up");
		$this->db->join("users u","u.id=up.user_id");
		$this->db->join("courses co","co.id=up.course_id");
		//$this->db->where("up.is_expired","1");
		//$this->db->where("up.course_expiry_date <='".$current_date."'");
		$this->db->group_by("up.id");
		$res = $this->db->get();
		$data = $res->result_array();
		return $data;
	}
}

