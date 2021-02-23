<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Certificate_model extends CI_Model {
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
	public function get_certificate_details($test_id)
	{
		$fields=array("u.first_name","u.last_name","u.gender","te.exam_code","te.chapter_id","ch.name chapter_name","co.name course_name","te.level_id","l.name level_name","te.pass_percent","te.end_date",
		"c.test_type","te.user_percent","u.id as user_id","u.email","s.name as subject_name");
		$this->db->select($fields);
		$this->db->from("users u");
		$this->db->join("test_engagement te","te.user_id=u.id");
		$this->db->join("courses co","co.id=te.course_id","left");
		$this->db->join("chapters ch","ch.id=te.chapter_id","left");
		$this->db->join("subjects s","s.id=te.subject_id","left");
		$this->db->join("levels l","l.id=te.level_id","left");
		$this->db->join("certificate c","c.test_id=te.id");
		$this->db->where("te.id",$test_id);
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
	
	public function getClasses($course_id){
		$this->db->select("cl.id, cl.name");
	  	$this->db->from("relevant_classes as rc");
	  	$this->db->join("classes as cl","rc.class_id = cl.id");
	  	$this->db->where("rc.course_id", $course_id);
	  	$this->db->where('cl.status','1');
	  	$this->db->order_by("cl.name", "asc");
	  	$result = $this->db->get();
	  	// echo $this->db->last_query();die;
		return $result->result_array();
	}
	public function getSubjects($course_id, $class_id){
		$this->db->select("s.id, s.name");
	  	$this->db->from("relevant_subjects as rs");
	  	$this->db->join("subjects as s","rs.subject_id = s.id");
	  	$this->db->join("classes as c","rs.class_id = c.id");
	  	$this->db->where("rs.course_id", $course_id);
	  	$this->db->where("rs.class_id", $class_id);
	  	$this->db->where('s.status','1');
	  	$this->db->order_by("s.name", "asc");
	  	$result = $this->db->get();
		return $result->result_array();
	}
	
	public function getChapters($course_id, $class_id, $subject_id){
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
	
	public function getLevels($course_id, $class_id, $subject_id, $chapter_id){
		$this->db->select("l.id, l.name");
	  	$this->db->from("levels as l");
	  	$this->db->where("l.course_id", $course_id);
	  	$this->db->where("l.class_id", $class_id);
	  	$this->db->where("l.subject_id", $subject_id);
	  	$this->db->where("l.chapter_id", $chapter_id);
	  	$this->db->where('l.status','1');
	  	$this->db->order_by("l.name", "asc");
	  	$result = $this->db->get();
		return $result->result_array();
	}
	
	public function getSets($course_id, $class_id, $subject_id, $chapter_id, $level_id){
		$this->db->select("s.id, s.name");
	  	$this->db->from("sets as s");
	  	$this->db->where("s.course_id", $course_id);
	  	$this->db->where("s.class_id", $class_id);
	  	$this->db->where("s.subject_id", $subject_id);
	  	$this->db->where("s.chapter_id", $chapter_id);
	  	$this->db->where("s.level_id", $level_id);
	  	$this->db->where('s.status','1');
	  	$this->db->order_by("s.name", "asc");
	  	$result = $this->db->get();
		return $result->result_array();
	}

	public function getQuestions($course_id, $class_id, $subject_id, $chapter_id,$tags=null){
		$this->db->select("qm.*");
		$this->db->select("ques.course_id,ques.class_id,ques.subject_id,ques.chapter_id");
	  	$this->db->from("questions_master as qm");
	  	$this->db->join('questions ques', 'qm.id = ques.questions_master_id','left');
	  	// $this->db->where("ques.course_id", $course_id);
	  	// $this->db->where("ques.class_id", $class_id);
	  	// $this->db->where("ques.subject_id", $subject_id);
	  	// $this->db->where("ques.chapter_id", $chapter_id);
	  	if($tags){
	  		$tags_array = explode(',',$tags);
	  		$count = count($tags_array);
	  		if($count>1){
	  			$i=1;
		  		foreach($tags_array as $tag){
		  			//$where = '("qm.tags",LIKE,%'.$tag.'%)';
		  			if($i==1){
		  				$where  = "(`qm`.`tags` LIKE '%".$tag."%' OR ";
		  			}else if($i==$count){
		  				$where .= "`qm`.`tags` LIKE '%".$tag."%')";
		  			}else{
		  				$where .= "`qm`.`tags` LIKE '%".$tag."%' OR";
		  			}
		  			$i=$i+1;
		  		}
		  	}else{
		  		$where  = "(`qm`.`tags` LIKE '%".$tags."%')";
		  	}
		  	$this->db->where($where);
	 	 }
	  	$this->db->where('qm.status','1');
	  	$result = $this->db->get();
	  	// echo $this->db->last_query();die;
	  	$result = $result->result_array();
	  	foreach($result as $key1 => $value1){
	  		foreach($value1 as $key => $value){
	  			if($result[$key1]['course_id'] == $course_id && $result[$key1]['class_id']== $class_id && $result[$key1]['subject_id']== $subject_id && $result[$key1]['chapter_id']== $chapter_id){
	  				$result[$key1]['is_selected'] = 1;
	  			}else{
	  				$result[$key1]['is_selected'] = 0;
	  			}
	  		}
	  	}
		 return $result;
	}
	public function getQuestionStd($course_id, $test_id,$tags=null){
		$this->db->select("qm.*");
		$this->db->select("ques.course_id,ques.test_id");
	  	$this->db->from("questions_master as qm");
	  	$this->db->join('surprise_questions ques', 'qm.id = ques.questions_master_id','left');
	  	if($tags){
	  		$tags_array = explode(',',$tags);
	  		$count = count($tags_array);
	  		if($count>1){
	  			$i=1;
		  		foreach($tags_array as $tag){
		  			//$where = '("qm.tags",LIKE,%'.$tag.'%)';
		  			if($i==1){
		  				$where  = "(`qm`.`tags` LIKE '%".$tag."%' OR ";
		  			}else if($i==$count){
		  				$where .= "`qm`.`tags` LIKE '%".$tag."%')";
		  			}else{
		  				$where .= "`qm`.`tags` LIKE '%".$tag."%' OR";
		  			}
		  			$i=$i+1;
		  		}
		  	}else{
		  		$where  = "(`qm`.`tags` LIKE '%".$tags."%')";
		  	}
		  	$this->db->where($where);
	 	 }
	  	$this->db->where('qm.status','1');
	  	$result = $this->db->get();
	  	 // echo $this->db->last_query();die;
	  	$result = $result->result_array();
	  	foreach($result as $key1 => $value1){
	  		foreach($value1 as $key => $value){
	  			if($result[$key1]['course_id'] == $course_id && $result[$key1]['test_id']== $test_id){
	  				$result[$key1]['is_selected'] = 1;
	  			}else{
	  				$result[$key1]['is_selected'] = 0;
	  			}
	  		}
	  	}
		 return $result;
	}


	public function getQuestionsSelected($course_id, $class_id, $subject_id, $chapter_id,$tags=null){
		$this->db->select("qm.*");
		$this->db->select("ques.course_id,ques.class_id,ques.subject_id,ques.chapter_id");
	  	$this->db->from("questions_master as qm");
	  	$this->db->join('questions ques', 'qm.id = ques.questions_master_id','left');
	  	$this->db->where("ques.course_id", $course_id);
	  	$this->db->where("ques.class_id", $class_id);
	  	$this->db->where("ques.subject_id", $subject_id);
	  	$this->db->where("ques.chapter_id", $chapter_id);
	  	$this->db->where('qm.status','1');
	  	$result = $this->db->get();
	  	// echo $this->db->last_query();die;
	  	$result = $result->result_array();
	  	foreach($result as $key1 => $value1){
	  		foreach($value1 as $key => $value){
	  			if($result[$key1]['course_id'] == $course_id && $result[$key1]['class_id']== $class_id && $result[$key1]['subject_id']== $subject_id && $result[$key1]['chapter_id']== $chapter_id){
	  				$result[$key1]['is_selected'] = 1;
	  			}else{
	  				$result[$key1]['is_selected'] = 0;
	  			}
	  		}
	  	}
		 return $result;
	}
	public function getQuestionsSelectedStd($course_id, $test_id,$tags=null){
		$this->db->select("qm.*");
		$this->db->select("ques.course_id,ques.test_id");
	  	$this->db->from("questions_master as qm");
	  	$this->db->join('surprise_questions ques', 'qm.id = ques.questions_master_id','left');
	  	$this->db->where("ques.course_id", $course_id);
	  	$this->db->where("ques.test_id", $test_id);

	  	$this->db->where('qm.status','1');
	  	$result = $this->db->get();
	  	 // echo $this->db->last_query();die;
	  	$result = $result->result_array();
	  	foreach($result as $key1 => $value1){
	  		foreach($value1 as $key => $value){
	  			if($result[$key1]['course_id'] == $course_id && $result[$key1]['test_id']== $test_id){
	  				$result[$key1]['is_selected'] = 1;
	  			}else{
	  				$result[$key1]['is_selected'] = 0;
	  			}
	  		}
	  	}
		 return $result;
	}

	public function get_create_test_subjects($testid){
		$this->db->select('*');
		$this->db->from("create_tests ct"); 
		$this->db->where("ct.test_eng_id",$testid);
		$result=$this->db->get();
		$data = $result->result_array();
		foreach($data as $dt){
			$subj_ids[] = $dt['subject_id'];
		}

		foreach($data as $dt){
			$chap_ids[] = array_filter(explode(',',$dt['chapter_id']));
		}
		foreach($chap_ids as $chapter_ids){
			foreach($chapter_ids as $ch_ids){
				$final_chap[] = $ch_ids;	
			}
			
		}

		$this->db->select('*');
		$this->db->from("subjects sub"); 
		$this->db->where_in("sub.id",$subj_ids);
		$result=$this->db->get();
		$data_sets = $result->result_array();
		foreach( $data_sets as $dt){
			$sub_names[] = $dt['name']; 
		}

		$this->db->select('*');
		$this->db->from("chapters cha"); 
		$this->db->where_in("cha.id",$final_chap);
		$result=$this->db->get();
		$data_sets = $result->result_array();
		foreach($data_sets as $dt){
			$chap_names[] = $dt['name']; 
		}


		 $data['sub_names'] = implode(',',$sub_names);
		 $data['chap_names'] = implode(',',$chap_names);
		 return $data;
		// print_r($final_chap);die;
	}

	
}
//SELECT * FROM `questions_master` as `qm`  left JOIN questions ON questions.questions_master_id=qm.id WHERE `qm`.`tags` LIKE '%physics%' ESCAPE '!' AND `qm`.`status` = '1'
