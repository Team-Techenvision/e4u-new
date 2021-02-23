<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Certificates_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
	public function certificate_list($user_id,$start="", $limit_start = null, $limit_end = null)
	{
		$fields=array("c.id","c.course_id","c.subject_id","c.user_id","s.name subject_name","c.status",
		"te.end_date","te.test_type","c.test_id","co.name as course_name","c.test_id","l.name as level_name");
		$this->db->select($fields);
		$this->db->from("certificate c");
		$this->db->join("subjects s","s.id=c.subject_id","left");
		$this->db->join("courses co","co.id=c.course_id","left");
		$this->db->join("levels l","l.id=c.level_id","left");
		$this->db->join("test_engagement te","te.id=c.test_id");
		$this->db->where("c.user_id =".$user_id);
		if($start!="")
		{
			$start = $start*10;
			$this->db->limit(10,$start);
		}
		if ($limit_start != '' || $limit_end != ''){
      	$this->db->limit($limit_start, $limit_end);
      }
		$this->db->order_by('c.id','desc');
		$result=$this->db->get();
		$data=$result->result_array();
		return $data;
	}
	public function get_certificate_details($user_id,$test_id)
	{
		$fields=array("u.first_name","u.last_name","u.gender","te.exam_code","te.chapter_id","ch.name chapter_name","co.name course_name","te.level_id","l.name level_name","te.pass_percent","te.end_date",
		"c.test_type","te.user_percent","u.email","s.name as subject_name");
		$this->db->select($fields);
		$this->db->from("users u");
		$this->db->join("test_engagement te","te.user_id=u.id");
		$this->db->join("courses co","co.id=te.course_id","left");
		$this->db->join("chapters ch","ch.id=te.chapter_id","left");
		$this->db->join("subjects s","s.id=te.subject_id","left");
		$this->db->join("levels l","l.id=te.level_id","left");
		$this->db->join("certificate c","c.test_id=te.id");
		$this->db->where("u.id =".$user_id." AND te.id=".$test_id);
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
}

