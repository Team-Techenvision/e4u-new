<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    } 
	public function get_counts($table, $condition=array(),$option="") 
	{  	$this->db->select("count(id) as totals");
		if(!empty($condition)){
			$this->db->where($condition);
		} 
		$res=$this->db->get($table);
		$row_Data=$res->row_array();
		 return $row_Data["totals"];
	}
	public function get_counts_course(){
		$this->db->group_by("course_category_id");
		$this->db->select("count(id) as totals,course_category_id"); 
		$res=$this->db->get("courses");
		 $data= $res->result_array();
		 foreach($data as $in_data){
			 $ret_data[$in_data["course_category_id"]]=$in_data["totals"];
		 }
		 return $ret_data;
	}
}

