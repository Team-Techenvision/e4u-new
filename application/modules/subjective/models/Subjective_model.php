<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subjective_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
    public function get_subjects($course_id,$class_id)
    {
    	$fields = array('s.id','s.name');
    	$this->db->select($fields);
		$this->db->from("subjects s");
		$this->db->join("relevant_subjects rs","rs.subject_id=s.id");
		$this->db->where("rs.course_id",$course_id);
		$this->db->where("rs.class_id",$class_id);
		$this->db->where('s.status',1);
		$result=$this->db->get();
		$data_sets=$result->result_array();
		$data=array();
		foreach($data_sets as $data_in){
			$data[$data_in['id']] = $data_in['name'];
		}
		return $data;
    }
    public function chapter_list($course_id,$class_id,$subject_id,$category_id)
    {
    	$fields = array('ch.id','ch.name','ch.description','sc.id as category_id','sc.name as category_name');
    	$this->db->select($fields);
		$this->db->from("chapters ch");
		$this->db->join("subjective_questions subq","subq.chapter_id=ch.id");
		$this->db->join("relevant_classes rc","rc.course_id=subq.course_id and rc.class_id=subq.class_id");
		$this->db->join("classes cl","cl.id=rc.class_id");
		$this->db->join("relevant_subjects rs","rs.course_id=subq.course_id and subq.subject_id=rs.subject_id and rc.class_id=rs.class_id");
		$this->db->join("subjects s","s.id=rs.subject_id");
		$this->db->join("sub_category sc","sc.id=subq.sub_category_id");
		$this->db->where("subq.course_id",$course_id);
		$this->db->where("subq.class_id",$class_id);
		$this->db->where("subq.subject_id",$subject_id);
		$this->db->where("subq.sub_category_id",$category_id);
		$this->db->where('ch.status',1);
		$this->db->where('subq.status',1);
		$this->db->group_by('ch.id');
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
    }
    public function get_questions($param,$limit_start = null, $limit_end = null)
    {
    	$ques_fields=array('subq.id','subq.question_type','subq.question','subq.explanation_type', 'subq.explanation','subq.severity','subq.status','sc.id as category_id','sc.name as category_name');
		$this->db->select($ques_fields);
		$this->db->from("subjective_questions subq");
		$this->db->join("relevant_classes rc","rc.course_id=subq.course_id and rc.class_id=subq.class_id");
		$this->db->join("classes cl","cl.id=rc.class_id");
		$this->db->join("relevant_subjects rs","rs.course_id=subq.course_id and subq.subject_id=rs.subject_id and rc.class_id=rs.class_id");
		$this->db->join("subjects s","s.id=rs.subject_id");
		$this->db->join("sub_category sc","sc.id=subq.sub_category_id");
		$this->db->where("subq.course_id",$param['course_id']);
		$this->db->where("subq.class_id",$param['class_id']);
		$this->db->where("subq.subject_id",$param['subject_id']);
		$this->db->where("subq.chapter_id",$param['chapter_id']);
		$this->db->where("subq.sub_category_id",$param['sub_category_id']);
		$this->db->where('subq.status',1);
		if ($limit_start != '' || $limit_end != '')
		{
      		$this->db->limit($limit_start, $limit_end);
      	}
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
    }
    public function category_select_list($course_id="",$class_id="",$subject_id="",$chapter_id="",$option="") 
	{
		$fields=array("sc.id","sc.name");
		$this->db->select($fields);
		$this->db->from("sub_category sc");
		$this->db->join("subjective_questions subq","subq.sub_category_id=sc.id");
		$this->db->where("subq.course_id",$course_id);
		$this->db->where("subq.class_id",$class_id);
		if($subject_id!=""){
		$this->db->where("subq.subject_id",$subject_id);
		}
		if($chapter_id!=""){
		$this->db->where("subq.chapter_id",$chapter_id);
		}
		$this->db->where("sc.status",1);
		$this->db->where("subq.status",1);
		$this->db->order_by('sc.name','asc');	
		$result=$this->db->get();
		if($option=="select")
		{
			$data_sets=$result->result_array();
			$data=array(""=>"Select");
			foreach($data_sets as $data_ret)
			{
				$data[$data_ret['id']] = $data_ret['name'];
			}
			return $data;
		}
		else
		{
			$num_rows = $result->num_rows();
			return $num_rows;
		}
	}
	public function category_list($course_id="",$class_id="")
	{
		$fields=array("sc.id","sc.name");
		$this->db->select($fields);
		$this->db->from("sub_category sc");
		$this->db->join("subjective_questions subq","subq.sub_category_id=sc.id");
		$this->db->where("subq.course_id",$course_id);
		$this->db->where("subq.class_id",$class_id);
		$this->db->where("sc.status",1);
		$this->db->where("subq.status",1);
		$this->db->group_by('sc.id');
		$this->db->order_by('sc.name','asc');	
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
	}
	public function is_subjective($course_id)
	{
		$fields=array('is_subjective','name');
		$this->db->select($fields);
		$this->db->from("courses");
		$this->db->where('id',$course_id);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
	public function all_category()
	{
		$fields=array("sc.id","sc.name");
		$this->db->select($fields);
		$this->db->from("sub_category sc");
		$this->db->where("sc.status",1);
		$this->db->order_by('sc.name','asc');	
		$result=$this->db->get();
		$data_sets=$result->result_array();
		$data=array(""=>"Select");
			foreach($data_sets as $data_ret)
			{
				$data[$data_ret['id']] = $data_ret['name'];
			}
			return $data;
	}
}

