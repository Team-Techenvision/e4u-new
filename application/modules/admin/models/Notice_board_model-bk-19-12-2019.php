<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notice_board_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    } 
	public function get_users($course_id) 
	{  
		$this->db->where("course_id",$course_id);
		$this->db->where("status",1);
		$this->db->where("is_expired",1);
		$res=$this->db->get("user_plans");
		return $res->result_array();
	}
	public function get_all_users() 
	{
		$this->db->where("status",1);
		$res=$this->db->get("users");
		return $res->result_array();
	}
	
	public function getUsers($course_id){
		$this->db->select('u.id, u.first_name, u.last_name, up.course_id');
    	$this->db->from('users as u');
    	$this->db->join('user_plans as up', 'up.course_id = '.$course_id.' and up.user_id = u.id');
    	$this->db->where("u.status",1);
    	$this->db->where("up.status",1);
    	$this->db->where("up.is_expired",1);
    	$this->db->order_by('u.first_name', 'asc');    	
    	$this->db->order_by('u.last_name', 'asc');  
    	$this->db->group_by('u.id');  	
    	$query  = $this->db->get();    	
    	return $query->result_array();
	}
}

