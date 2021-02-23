<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test_report_model extends CI_Model {
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
		$this->db->update('users', $data);
		 
	}
	public function get_levels_completed($user_id)
	{
		$fields =array('COUNT(DISTINCT(te.id)) as progress_count');
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->where("te.user_id",$user_id);
		$this->db->where("te.test_type","1");
		$this->db->where("te.result","1");
		$this->db->group_by("te.user_id");
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
	public function get_documents_count($user_id)
	{
		$fields =array('COUNT(DISTINCT(d.id)) as documents');
		$this->db->select($fields);
		$this->db->from("downloads d");
		$this->db->where("d.user_id",$user_id);
		$this->db->where("d.status","1");
		$this->db->group_by("d.user_id");
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
	public function get_total_questions($user_id)
	{
		$fields = array('count(td.question_id) as total_questions');
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->join("test_details td","td.test_id=te.id");
		$this->db->join('courses as co','co.id = te.course_id',"left");
		$this->db->where("te.user_id",$user_id);
		$this->db->where("te.test_type","1");	
		$this->db->where("te.result","1");
		$this->db->where("te.status","1");
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
	public function get_total_progress($user_id)
	{
		$c_fields = array('o.course_id');
		$this->db->select($c_fields);
		$this->db->from("orders o");
		$this->db->where("o.order_status","1");
		$this->db->where("o.user_id",$user_id);
		$result = $this->db->get();
		$res = $result->result_array();
		foreach($res as $key=>$value)
		{
			$l_fields = array('l.id');
			$this->db->select($l_fields);
			$this->db->from("levels l");
			$this->db->join("sets s","s.level_id=l.id");
			$this->db->join("questions q","q.set_id=s.id");
			$this->db->where("l.course_id",$value['course_id']);
			$this->db->group_by("l.id");
			$results = $this->db->get();
			$numrows += $results->num_rows();
		}
		return $numrows;
	}
	
}

