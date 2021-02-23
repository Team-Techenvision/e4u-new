<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Classes_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    } 
	public function update_status($id, $data) 
	{
		$this->db->where('id', $id);
		$this->db->update('classes', $data);
		 
	}
	public function rm_count($course_id)
	{
		$fields = array('class_id');
		$this->db->select($fields);
		$this->db->from('chapters');
		$this->db->where('course_id',$course_id);
		$this->db->where('status',1);
		$this->db->group_by('class_id');
		$res = $this->db->get();
		$data = $res->result_array();
		return $data;
	}
	
	public function get_counts_chapters(){
		$this->db->group_by("course_id");
		$this->db->select("count(id) as totals,course_id"); 
		$res=$this->db->get("chapters");
		 
		 $data= $res->result_array();
		 foreach($data as $in_data){
			 $ret_data[$in_data["course_id"]]=$in_data["totals"];
		 }
		 return $ret_data;
	}
}

