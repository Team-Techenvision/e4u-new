<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

	public function get_paid_course($id,$option="") 
	{
		$fields=array("name",'t2.id','t1.price');
		$this->db->select($fields);
		$this->db->from("user_plans t1");
		$this->db->join("courses t2","t2.id=t1.course_id");
		$this->db->join("orders t3","t3.id=t1.order_id");
		$this->db->where("t1.user_id",$id);
		$this->db->where("t3.order_status",1);	
		$this->db->where("t1.status",1);
		$this->db->where("t1.is_expired",1);
		$this->db->order_by('t2.name','asc');	
		$this->db->group_by("t1.course_id");
		$result=$this->db->get();
		// echo $this->db->last_query();die;
		if($option=="select"){
			$data_sets=$result->result_array();
			$data_ret=array(""=>"Select The Course");
			foreach($data_sets as $data_in)
			{
				$data_ret[$data_in["id"]]=$data_in["name"]; 
			}
			return $data_ret;

		}else{
			$data_sets = array();
			
			if($result !== FALSE && $result->num_rows() > 0){
				$data_sets=$result->row_array(); //result_array();
			}
			return $data_sets;
		}	
 			
	}
	
	public function get_ad($ad_page) 
	{
		$fields=array('a.id','a.name','a.description','a.image','a.url');
		$this->db->select($fields);
		$this->db->from("advertisements a");
		$this->db->join("ad_page_position app","app.id=a.position_id");
		$this->db->join("ad_page ap","ap.id=a.page_id");
		$this->db->where("ap.name",$ad_page);
		$this->db->where("a.status",1);	
		$this->db->order_by("a.id", "desc");
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
	public function get_paid_courses_class($course_id,$option="") 
	{
		$fields=array("t2.name",'t1.class_id');
		$this->db->select($fields);
		$this->db->from("relevant_classes t1");
		$this->db->join("classes t2","t2.id=t1.class_id");
		$this->db->where("course_id",$course_id);
		$this->db->where("t2.status",1);
		$this->db->order_by('t2.name','asc');	
		$result=$this->db->get();
		if($option="select"){
			$data_sets=$result->result_array();
			$data_ret=array(""=>"Select The Class");
			foreach($data_sets as $data_in)
			{
				$data_ret[$data_in["class_id"]]=$data_in["name"]; 
			}
			return $data_ret;
		}	
 			
	}
	
	public function getcount($user_id, $course_id, $class_id, $type){
		if($course_id=="0"){
		 return 0;
		}
		if($type == "answer"){
			$fields=array("t2.name as subject_name", "count(t4.id) as answer_count");
		}else{
			$fields=array("t2.name as subject_name", "count(t4.id) as question_count", "TIME_TO_SEC( TIMEDIFF( t3.end_date, t3.start_date ) ) AS diff");
		}		
		$this->db->select($fields);
		$this->db->from("relevant_subjects as t1");
		$this->db->join("subjects as t2", "t1.subject_id = t2.id",'left'); 
		$this->db->join("test_engagement as t3", "t3.subject_id =t1.subject_id AND t3.user_id = '$user_id' AND t3.class_id= $class_id  AND t3.test_type = 1 AND t3.status = 1 AND t3.result = 1 AND t3.course_id=$course_id",'left');
		if($type == "answer"){ 
			$this->db->join("test_details as t4", "t4.test_id=t3.id AND t4.is_correct=1",'left');
		}else{
			$this->db->join("test_details as t4", "t4.test_id=t3.id","left");
		}
		$this->db->where("t1.course_id", $course_id);
		$this->db->group_by("t1.subject_id");
		$this->db->order_by("t2.sort_order","asc");
		$result=$this->db->get();
		return $result->result_array();
	}
	public function get_chapters($course_id,$class_id,$user_id,$subject_id){
		$this->db->select("ch.id,ch.name as chapter_name,te.user_percent");
		$this->db->from("level_completed as lc");
		$this->db->join("chapters ch","ch.id=lc.chapter_id","left");		
		$this->db->join("levels as l", "l.id =lc.level_id");
		$this->db->join("test_engagement as te", "te.level_id =lc.level_id AND te.test_type=1 AND te.result=1","left");
		$this->db->where("lc.user_id", $user_id);
		$this->db->where("lc.course_id", $course_id);
		$this->db->where("lc.class_id", $class_id);
		$this->db->where("lc.subject_id", $subject_id);
		$this->db->where("lc.result", 1);		
		$this->db->order_by("ch.name", "asc");
		$this->db->group_by("lc.chapter_id");
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_chapters_first($course_id,$subject_id,$class_id){
		$this->db->select("c.id, c.name");
	  	$this->db->from("chapters as c");
	  	$this->db->where("c.course_id", $course_id);
	  	$this->db->where("c.class_id", $class_id);
	  	$this->db->where("c.subject_id", $subject_id);
	  	$this->db->where('c.status','1');
	  	$this->db->order_by("c.name", "asc");
	  	$result = $this->db->get();
		return $result->result_array();
	}
	public function get_chapter($chapter_id){
		$this->db->select("c.id, c.name");
	  	$this->db->from("chapters as c");
	  	$this->db->where("c.id", $chapter_id);
	  	$this->db->where('c.status','1');
	  	$this->db->order_by("c.name", "asc");
	  	$result = $this->db->get();
		return $result->row_array();
	}


	
	public function get_chapters_details($course_id, $class_id, $user_id=""){
		if($user_id!=""){
			$this->db->select("count(*) as completed_chapters");
			$this->db->from(" chapter_completed");
			$this->db->where("course_id", $course_id);
			$this->db->where("class_id", $class_id);
			$this->db->where("user_id", $user_id);
		}else{
			$this->db->select("count(c.id) as total_chapters");
			$this->db->from("relevant_subjects as rs");
			$this->db->join("chapters as c", "rs.subject_id = c.subject_id and rs.course_id = c.course_id and rs.class_id = c.class_id ");
			$this->db->where("rs.course_id", $course_id);
			$this->db->where("rs.class_id", $class_id);
		}
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function get_subjects($course_id, $class_id){	
		$this->db->select("s.id, s.name");
		$this->db->from("subjects as s");
		$this->db->join("relevant_subjects as rs","s.id = rs.subject_id");
		$this->db->where("rs.course_id", $course_id);
		$this->db->where("rs.class_id", $class_id);
		$this->db->order_by('s.sort_order','asc');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_notices($course_id = null, $class_id = null){	
		$this->db->select("*");
		$this->db->from("notice_board as s");
		if(!empty($course_id)){
			$this->db->where("s.course_id", $course_id);
		}
		if(!empty($class_id)){
			$this->db->where("s.class_id", $class_id);
		}
		$this->db->where("s.status", 1);
		$this->db->order_by('s.id','desc');
		//$this->db->limit(4);
		$result = $this->db->get();
		return $result->result_array();
	}


	
	public function get_levels($course_id, $class_id, $subject_id){		
		$this->db->select("lc.id, lc.name,ch.name as chapter_name");
		$this->db->from("levels as lc");
		$this->db->join("chapters ch","ch.id=lc.chapter_id","left");		
		$this->db->where("lc.course_id", $course_id);
		$this->db->where("lc.class_id", $class_id);
		$this->db->where("lc.subject_id", $subject_id); 
		$this->db->order_by("ch.name", "asc");
		$this->db->group_by("lc.id");
		$result = $this->db->get();
		return $result->result_array();
	}
	public function get_levels_completed($course_id, $class_id, $user_id, $subject_id){		
		 $this->db->select("l.id,l.name,ch.id as chapter_id,ch.name as chapter_name,te.user_percent");
		$this->db->from("level_completed as lc");
		$this->db->join("chapters ch","ch.id=lc.chapter_id","left");		
		$this->db->join("levels as l", "l.id =lc.level_id");
		$this->db->join("test_engagement as te", "te.level_id =lc.level_id AND te.test_type=1 AND te.result=1","left");
		$this->db->where("lc.user_id", $user_id);
		$this->db->where("lc.course_id", $course_id);
		$this->db->where("lc.class_id", $class_id);
		$this->db->where("lc.subject_id", $subject_id);
		$this->db->where("lc.result", 1);		
		$this->db->order_by("lc.level_id", "asc");
		$this->db->group_by("lc.level_id");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function get_sets($course_id, $class_id, $user_id, $subject_id, $level_id, $type = 0){				
		$set_values = array();
		$this->db->select("id, name");
		$this->db->from("sets");		
		$this->db->where("course_id", $course_id);
		$this->db->where("class_id", $class_id);
		$this->db->where("subject_id", $subject_id);
		$this->db->where("level_id", $level_id);
		$result = $this->db->get();
		$sets = $result->result_array();		
		foreach($sets as $set){
			$this->db->select("tg.id, tg.user_percent, s.name");
			$this->db->from("test_engagement as tg");
			$this->db->join("sets as s", "s.id = tg.set_id");
			$this->db->where("tg.user_id", $user_id);
			$this->db->where("tg.course_id", $course_id);
			$this->db->where("tg.class_id", $class_id);
			$this->db->where("tg.subject_id", $subject_id);
			$this->db->where("tg.level_id", $level_id);
			$this->db->where("tg.test_type", $type);
			$this->db->where("tg.status", 1);
			$this->db->where("tg.set_id", $set["id"]);
			$this->db->order_by("tg.end_date", "desc");
			$this->db->order_by("tg.id", "asc");
			$result = $this->db->get();
			if(count($result->result_array())){
				$set_values[] = $result->result_array();
			}			
		}		
		return $set_values;		
	}
	public function levels($course_id, $class_id, $user_id, $subject_id, $chapter_id, $type = 1){				
		$set_values = array();
		$this->db->select("id, name");
		$this->db->from("levels");		
		$this->db->where("course_id", $course_id);
		$this->db->where("class_id", $class_id);
		$this->db->where("subject_id", $subject_id);
		$this->db->where("chapter_id", $chapter_id);
		$result = $this->db->get();
		$sets = $result->result_array();		
		foreach($sets as $set){
			$this->db->select("tg.id, tg.user_percent, s.name");
			$this->db->from("test_engagement as tg");
			$this->db->join("levels as s", "s.id = tg.level_id");
			$this->db->where("tg.user_id", $user_id);
			$this->db->where("tg.course_id", $course_id);
			$this->db->where("tg.class_id", $class_id);
			$this->db->where("tg.subject_id", $subject_id);
			$this->db->where("tg.chapter_id", $chapter_id);
			$this->db->where("tg.test_type", $type);
			$this->db->where("tg.status", 1);
			$this->db->where("tg.level_id", $set["id"]);
			$this->db->order_by("tg.end_date", "desc");
			$this->db->order_by("tg.id", "asc");
			$result = $this->db->get();
			if(count($result->result_array())){
				$set_values[] = $result->result_array();
			}			
		}		
		return $set_values;		
	}
	
}

