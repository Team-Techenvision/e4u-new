<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Create_tests_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
	public function relevant_subjects($course_id,$class_id) 
	{
		$rel_subj_fields = array("s.id","s.name"); 
		$this->db->select($rel_subj_fields);
		$this->db->from("relevant_subjects rs");
		$this->db->join("subjects s","s.id=rs.subject_id");
		$this->db->where("rs.course_id =".$course_id." AND rs.class_id =".$class_id);
		$this->db->where('s.status',1);
		$this->db->where('rs.status',1);
		$this->db->order_by('s.sort_order','asc');
		$result=$this->db->get();
		$data_sets=$result->result_array();
		$data=array();
		foreach($data_sets as $data_in){
			$data[$data_in['id']] = $data_in['name'];
		}
		return $data;
	}
	public function relevant_classes($course_id) 
	{
		$rel_class_fields = array("c.id","c.name"); 
		$this->db->select($rel_class_fields);
		$this->db->from("relevant_classes rc");
		$this->db->join("classes c","c.id=rc.class_id");
		$this->db->where("rc.course_id =".$course_id);
		$this->db->order_by("c.name","asc");
		$result=$this->db->get();
		$data_sets=$result->result_array();
		$data=array();
		foreach($data_sets as $data_in){
			$data[$data_in['id']] = $data_in['name'];
		}
		return $data;
	}
	public function chapter_list($course_id,$class_id,$subject_id) 
	{
		
		$fields=array("c.id","c.name","c.order","c.description");
		$this->db->select($fields);
		$this->db->from("chapters c");
		$this->db->where("c.course_id =".$course_id." AND c.class_id =".$class_id." AND c.subject_id=".$subject_id);
		$this->db->where("c.status",1);	
		$this->db->order_by("c.order", "asc");
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
	}
	public function chapter($chapter_id) 
	{
		$fields=array("c.id","c.name");
		$this->db->select($fields);
		$this->db->from("chapters c");
		$this->db->where("c.id =".$chapter_id);
		$this->db->where("c.status",1);	
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}


	public function subject($subject_id) 
	{
		$fields=array("s.id","s.name");
		$this->db->select($fields);
		$this->db->from("subjects s");
		$this->db->where("s.id =".$subject_id);
		$this->db->where("s.status",1);	
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
	public function level($level_id) 
	{
		$fields=array("l.id","l.name");
		$this->db->select($fields);
		$this->db->from("levels l");
		$this->db->where("l.id =".$level_id);
		$this->db->where("l.status",1);	
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
	public function course_name($course_id) 
	{
		$fields=array("co.id","co.name");
		$this->db->select($fields);
		$this->db->from("courses co");
		$this->db->where("co.id =".$course_id);
		$this->db->where("co.status",1);	
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
	public function set($set_id) 
	{
		$fields=array("s.id","s.name");
		$this->db->select($fields);
		$this->db->from("sets s");
		$this->db->where("s.id =".$set_id);
		$this->db->where("s.status",1);	
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
	
	public function set_count($level_id,$chapter_id,$type="") 
	{
		$fields=array("s.id");
		$this->db->select($fields);
		$this->db->from("sets s");
		$this->db->join("questions q","q.set_id=s.id");
		$this->db->where("s.level_id =".$level_id);
		$this->db->where("s.chapter_id =".$chapter_id);
		$this->db->where("s.status",1);
		$this->db->where("q.status",1);
		$this->db->group_by('q.set_id');	
		$result=$this->db->get();
		if($type == "set_result")
		{
			$num_rows = $result->result_array();
		}else
		{
			$num_rows = $result->num_rows();
		}
		return $num_rows;
	}
	public function completed_set_count($param) 
	{
		$fields=array("te.id","te.set_id");
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->join("sets s","s.id=te.set_id");
		$this->db->where("te.user_id =".$param['user_id']." AND te.course_id =".$param['course_id']." AND te.class_id =".$param['class_id']." AND te.subject_id =".$param['subject_id']." AND te.chapter_id =".$param['chapter_id']." AND te.level_id =".$param['level_id']);
		$this->db->where("te.status",1);
		$this->db->where("s.status",1);
		$this->db->where("te.set_id != 0");
		$this->db->group_by("te.set_id");
		$result=$this->db->get();
		$data_sets=$result->result_array();
		$num_rows = $result->num_rows();
		return array($data_sets,$num_rows);
	}
	public function level_list($course_id,$class_id,$subject_id,$chapter_id) 
	{
		$fields=array("l.id","l.name","l.order", "l.description");
		$this->db->select($fields);
		$this->db->from("levels l");
		$this->db->where("l.course_id=".$course_id." AND l.class_id=".$class_id." AND l.subject_id=".$subject_id." AND l.chapter_id=".$chapter_id);
		$this->db->where("l.status",1);	
		$this->db->order_by("l.order", "asc");
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
	}
	public function level_select_list($course_id,$class_id,$subject_id,$chapter_id,$option="") 
	{
		$fields=array("l.id","l.name");
		$this->db->select($fields);
		$this->db->from("levels l");
		$this->db->join("sets s","s.level_id=l.id");
		$this->db->join("questions q","q.set_id=s.id");
		$this->db->where("l.course_id=".$course_id." AND l.class_id=".$class_id." AND l.subject_id=".$subject_id." AND l.chapter_id=".$chapter_id);
		$this->db->where("l.status",1);
		$this->db->where("s.status",1);
		$this->db->where("q.status",1);
		$this->db->order_by('l.name','asc');	
		$result=$this->db->get();
		if($option="select")
		{
			$data_sets=$result->result_array();
			$data=array(""=>"Select Level");
			foreach($data_sets as $data_ret)
			{
				$data[$data_ret['id']] = $data_ret['name'];
			}
			return $data;
		}
	}
	public function set_select_list($course_id,$class_id,$subject_id,$chapter_id,$level_id,$option="") 
	{
		$fields=array("s.id","s.name");
		$this->db->select($fields);
		$this->db->from("sets s");
		$this->db->join("questions q","q.set_id=s.id");
		$this->db->where("s.course_id=".$course_id." AND s.class_id=".$class_id." AND s.subject_id=".$subject_id." AND s.chapter_id=".$chapter_id." AND s.level_id=".$level_id);
		$this->db->where("s.status",1);	
		$this->db->where('q.status',1);
		$this->db->order_by('s.name','asc');
		$result=$this->db->get();
		if($option="select")
		{
			$data_sets=$result->result_array();
			
			foreach($data_sets as $data_ret)
			{
				$data[$data_ret['id']] = $data_ret['name'];
			}
			return $data;
		}
	}
	public function set_list($course_id,$class_id,$subject_id,$chapter_id,$level_id) 
	{
		$fields=array("s.id","s.name","s.description", "s.order", "s.status");#n
		$this->db->select($fields);
		$this->db->from("sets s"); 
		$this->db->join("questions q","q.set_id=s.id");
		$this->db->where("s.course_id=".$course_id." AND s.class_id=".$class_id." AND s.subject_id=".$subject_id." AND s.chapter_id=".$chapter_id." AND s.level_id=".$level_id);
		$this->db->where("s.status",1);
		$this->db->where("q.status",1);
		$this->db->order_by("s.order", "asc");
		$this->db->group_by("s.id");	
		$result=$this->db->get();
		$data_sets=$result->result_array();
		 
		return $data_sets;
	}
	public function progress_completed_set($user_id,$level_id) 
	{
		$fields = array('te.set_id');
		$this->db->select($fields);
		$this->db->from("test_engagement te"); 
		$this->db->where("te.user_id",$user_id);
		$this->db->where("te.level_id",$level_id);
		$this->db->where('test_type','0');
		$this->db->where('status','1');
		$this->db->group_by("te.set_id");
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
	}
	public function check_new_set($param,$set_ids)
	{
		
		foreach($set_ids as $key=>$value)
		{
			$res[] = $value['set_id'];
		}
		$fields = array('s.id');
		$this->db->select($fields);
		$this->db->from('sets s');
		$this->db->join("questions q","q.set_id=s.id");
		$this->db->where('s.course_id',$param['course_id']);
		$this->db->where('s.class_id',$param['class_id']);
		$this->db->where('s.subject_id',$param['subject_id']);
		$this->db->where('s.chapter_id',$param['chapter_id']);
		$this->db->where('s.level_id',$param['level_id']);
		$this->db->where_not_in('s.id',$res);
		$this->db->where('s.status',1);
		$this->db->where('q.status',1);
		$this->db->group_by('s.id');
		$result=$this->db->get();
		$num_rows = $result->num_rows();
		return $num_rows;
		
	}
	public function completed_set_list($user_id,$status="") 
	{
		$fields=array("set_id");#n
		$this->db->select($fields);
		$this->db->from("test_engagement"); 
		$this->db->where("user_id",$user_id); 
		$this->db->where("status",'1'); 
	 	if($status!=""){
			$this->db->where("result",$status); 
		}
		$result=$this->db->get();
		$data_sets=$result->result_array();
		$data_ret=array();
		foreach($data_sets as $data_inn){
			$data_ret[]=$data_inn["set_id"];
		}
		 
		return $data_ret;
	}
	public function set_status($user_id,$set_id) 
	{
		$this->db->from("test_engagement"); 
		$this->db->where("user_id",$user_id);  
		$this->db->where("set_id",$set_id);  
		$this->db->limit(1);
		$this->db->order_by('id','desc'); 
		$result=$this->db->get();
		$data_sets=$result->row_array(); 
		return $data_sets;
	}
	
	public function get_materials($course="0",$class,$subject)
	{
		$this->db->select($fields);
		$this->db->from("downloads"); 
		$this->db->where("course_id",$course);
		$this->db->where("status",1);
		$this->db->where("class_id",$class);
		$this->db->where("subject_id",$subject);
		$this->db->order_by('id','desc');
		$result=$this->db->get();
		return $result->result_array();
	}
	public function get_count_down()
	{
		$fields = array('count_down_time');
		$this->db->select($fields);
		$this->db->from("settings"); 
		$result=$this->db->get();
		$data_sets = $result->row_array();
		return $data_sets;
	}
	public function test_manage($user_id,$test_random_id,$test_arr,$surprise_test_id="",$test_type)
	{
		$count_fields = array('s.pass_percentage');
		$this->db->select($count_fields);
		$this->db->from("settings s"); 
		$result=$this->db->get();
		$data_count_sets = $result->row_array();
		
		$date = date('Y-m-d H:i:s');
		if($surprise_test_id != "" && $test_type == 2)
		{
			$arr = array('start_date' => $date,
				 		'user_id' => $user_id,
				 		'course_id' => $test_arr,
				 		'test_type' => $test_type,
				 		'surprise_test_id' => $surprise_test_id,
					 	'pass_percent' => $data_count_sets['pass_percentage'],
					 );
		} else {
			$arr = array('start_date' => $date,
				 'user_id' => $user_id,
				 'course_id' => $test_arr['session_course'],
				 'class_id' => $test_arr['session_class'],
				 'subject_id' => $test_arr['subject_id'],
				 'chapter_id' => $test_arr['chapter_id'],
				 'level_id' => $test_arr['level_id'],
				 'set_id' => $test_arr['set_id'],
				 'test_type' => $test_type,
				 'surprise_test_id' => '0',
				 'pass_percent' => $data_count_sets['pass_percentage'],
			);
		}
		$this->db->insert("test_engagement",$arr);
		$te_id = $this->db->insert_id();
		$exam_code = array('exam_code' => $test_random_id.$te_id);
		$this->db->where("id",$te_id);
		$this->db->update("test_engagement",$exam_code);
		return $te_id;
	}
	public function get_exam_code($test_id)
	{
		$fields = array('te.exam_code');
		$this->db->select($fields);
		$this->db->from("test_engagement te"); 
		$this->db->where("te.id",$test_id);
		$result=$this->db->get();
		$data_sets = $result->row_array();
		return $data_sets;
	}
	public function test_details($test_id,$test_arr)
	{
		$count_fields = array('pass_percentage','question_count');
		$this->db->select($count_fields);
		$this->db->from("settings"); 
		$result=$this->db->get();
		$data_count_sets = $result->row_array();
		
		$ques_fields = array('q.id');
		$this->db->select($ques_fields);
		$this->db->from("questions q"); 
		$this->db->where("course_id=".$test_arr['session_course']." AND class_id=".$test_arr['session_class']." AND subject_id=".$test_arr['subject_id']." AND chapter_id=".$test_arr['chapter_id']." AND level_id=".$test_arr['level_id']." AND set_id=".$test_arr['set_id']);
		$this->db->limit($data_count_sets['question_count']);
		$this->db->where('q.status',1);
		$this->db->order_by('q.id', 'RANDOM');
		$result=$this->db->get();
		$data_sets = $result->result_array();
		$i=0;$j=1;
		foreach($data_sets as $data_ret)
		{
			$data[] = $data_ret['id'];
			$arr = array('question_id' => $data[$i],
						 'test_id' => $test_id,
						 'serial_number' => $j,
						 'test_type' => '0'
			);
			$this->db->insert("test_details",$arr);
			$i++;$j++;
		}
		
	}
	public function progress_test_details($test_id,$test_arr,$user_id){
		$count_fields = array('pass_percentage','question_count');
		$this->db->select($count_fields);
		$this->db->from("settings"); 
		$result=$this->db->get();
		$data_count_sets = $result->row_array();
		
		$ques_fields = array('td.question_id');
		$this->db->select($ques_fields);
		$this->db->from("test_engagement te"); 
		$this->db->join("test_details td","td.test_id=te.id");
		$this->db->where("te.course_id=".$test_arr['session_course']." AND te.class_id=".$test_arr['session_class']." AND te.subject_id=".$test_arr['subject_id']." AND te.chapter_id=".$test_arr['chapter_id']." AND te.level_id=".$test_arr['level_id']." AND user_id=".$user_id);
		$this->db->limit($data_count_sets['question_count']);
		$this->db->order_by("td.is_correct",'asc');
		$this->db->group_by("td.question_id");
		$result=$this->db->get();
		$data_sets = $result->result_array();
		$i=0;$j=1;
		foreach($data_sets as $data_ret)
		{
			$data[] = $data_ret['question_id'];
			$arr = array('question_id' => $data[$i],
						 'test_id' => $test_id,
						 'serial_number' => $j,
						 'test_type' => '1'
			);
			$this->db->insert("test_details",$arr);
			$i++;$j++;
		}
	}
	public function get_surprise_test($course_id,$test_id="")
	{
		$current_date = date('Y-m-d');
		$fields = array('st.*','co.name as course_name');
		$this->db->select($fields);
		$this->db->from("surprise_test st"); 
		$this->db->join("courses co","co.id=st.course_id");
		$this->db->join("surprise_questions sq","sq.test_id=st.id");
		$this->db->where("st.course_id=".$course_id." AND st.status=1");
		// $this->db->where("DATE(st.from_date) <=",$current_date);
		$this->db->where("DATE(st.to_date) >=",$current_date);
		$this->db->where("sq.status",1);
		$this->db->group_by("st.id");
		$this->db->order_by("st.id","desc");
		// $this->db->limit('1');
		if($test_id!=""){
		$this->db->where("st.id",$test_id);
		}
		$this->db->where("publish_status",1);
		$result=$this->db->get();
		  // echo $this->db->last_query();die;
		$data_sets = $result->result_array();
		$num_rows = $result->num_rows();
		// return array($num_rows,$data_sets);
		return $data_sets;
	}
	public function surprise_menu($course_id,$user_id)
	{
		foreach($course_id as $key=>$value)
		{
			$current_date = date('Y-m-d');
			$fields = array('st.id as surprise_id');
			$this->db->select($fields);
			$this->db->from("surprise_test st");
			$this->db->join("surprise_questions t2","t2.test_id=st.id");
			$this->db->where("st.course_id",$value);
			$this->db->where("st.status","1");
			$this->db->where("t2.status",1);
			$this->db->where("st.from_date <=",$current_date);
			$this->db->where("st.to_date >=",$current_date);
			$this->db->order_by('st.id','desc');
			$this->db->limit('1');
			$this->db->group_by("t2.test_id");
			$this->db->where("publish_status",1);
			$result=$this->db->get();
			$num_rows += $result->num_rows();
			$data[] = $result->row_array();
		}
		foreach($data as $testid_key=>$testid_value)
		{
			$surprise_testid[] = $testid_value['surprise_id'];
		}
		$te_fields = array('te.id');
		$this->db->select($te_fields);
		$this->db->from("test_engagement te");
		$this->db->where_in('te.surprise_test_id',$surprise_testid);
		$this->db->where('te.test_type','2');
		$this->db->where('te.status','1');
		$this->db->where('te.user_id',$user_id);
		$result_test=$this->db->get();
		$num_rows_test = $result_test->num_rows();
		if($num_rows != 0){
			if($num_rows==$num_rows_test )
			{
				$completed_test = 1;
			}
			else
			{
				$completed_test = 0;
			}
		}
		
		return array($num_rows,$completed_test);
	}
	public function surprise_test_completed($course_id,$user_id)
	{
		$fields = array('surprise_test_id');
		$this->db->select($fields);
		$this->db->from("test_engagement"); 
		$this->db->where("course_id",$course_id);
		$this->db->where("user_id",$user_id);
		$this->db->where("test_type",'2');
		$this->db->where("status",'1');
		$result=$this->db->get();
		$res = $result->result_array();
		$edata_ret=array();
		foreach($res as $data_arr){
		$edata_ret[]=$data_arr["surprise_test_id"];
		}
		return $edata_ret;
	}
	public function surprise_test_details($test_id,$course_id,$user_id,$surprise_test_id){
		$count_fields = array('pass_percentage','question_count');
		$this->db->select($count_fields);
		$this->db->from("settings"); 
		$result=$this->db->get();
		$data_count_sets = $result->row_array();
		
		$ques_fields = array('sq.id');
		$this->db->select($ques_fields);
		$this->db->from("surprise_questions sq"); 
		$this->db->join("surprise_test st","st.id=sq.test_id");
		$this->db->where("sq.test_id",$surprise_test_id);
		$this->db->where("sq.status",1);
		$this->db->limit($data_count_sets['question_count']);
		$this->db->order_by('sq.id', 'RANDOM');
		$result=$this->db->get();
		$data_sets = $result->result_array();
		$i=0;$j=1;
		foreach($data_sets as $data_ret)
		{
			$data[] = $data_ret['id'];
			$arr = array('question_id' => $data[$i],
						 'test_id' => $test_id,
						 'serial_number' => $j,
						 'test_type' => '2'
			);
			$this->db->insert("test_details",$arr);
			$i++;$j++;
		}

	}
	
	public function question_count($testid)
	{
		$count_fields = array('question_id');
		$this->db->select($count_fields);
		$this->db->from("test_details"); 
		$this->db->where("test_id=".$testid); 
		$result=$this->db->get();
		$num_rows = $result->num_rows();
		return $num_rows;
	}
	public function get_test_details($test_random_id) 
	{
		$fields=array('te.id','te.course_id','te.class_id','te.subject_id','te.end_date',
		'te.chapter_id','te.level_id','te.set_id','te.status','te.result','te.test_type','surprise_test_id','start_date');
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->where("exam_code=".$test_random_id);
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
	}
	public function questions($testid,$start="") 
	{
		$ques_fields=array('q.id','q.question_type','q.question','q.answer_type','q.choices',
		'q.correct_answer','td.status','td.selected_answer','td.is_correct', 'q.explanation_type', 'q.explanation','q.severity');
		$this->db->select($ques_fields);
		$this->db->from("questions q");
		$this->db->join("test_details td","td.question_id=q.id");
		$this->db->where("td.test_id=".$testid." AND q.status=1");
		if($start!=""){
		$this->db->limit("1",$start);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		}else{
		$result=$this->db->get();
		$data_sets=$result->result_array();
		}
		return $data_sets;
	}
	public function surprise_questions($testid,$start="") 
	{
		$ques_fields=array('sq.id','sq.question','sq.choices','sq.correct_answer','td.status',
		'td.selected_answer','td.is_correct','sq.question_type','sq.answer_type','sq.explanation_type',
		'sq.explanation','sq.severity');
		$this->db->select($ques_fields);
		$this->db->from("surprise_questions sq");
		$this->db->join("surprise_test st","st.id=sq.test_id");
		$this->db->join("test_details td","td.question_id=sq.id");
		$this->db->where("td.test_id=".$testid." AND sq.status=1");
		if($start!=""){
			$this->db->limit("1",$start);
			$result=$this->db->get();
			$data_sets=$result->row_array();
		}else{
			$result=$this->db->get();
			$data_sets=$result->result_array();
		}
		return $data_sets;
	}
	public function serial_number($testid,$start) 
	{
		$fields=array('serial_number');
		$this->db->select($fields);
		$this->db->from("test_details");
		$this->db->where("test_id=".$testid);
		$this->db->limit("1",$start);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
		
	}
	public function answer_detail($question_id) 
	{
		$ans_fields = array('q.id','q.correct_answer','q.explanation','q.question','q.explanation_type');
		$this->db->select($ans_fields);
		$this->db->from("questions q");
		$this->db->where("q.id=".$question_id);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
	public function surprise_answer_detail($question_id) 
	{
		$ans_fields = array('sq.id','sq.correct_answer','sq.explanation','sq.question'
		,'sq.explanation_type');
		$this->db->select($ans_fields);
		$this->db->from("surprise_questions sq");
		$this->db->where("sq.id=".$question_id);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
	public function is_correct($question_id,$test_id,$option_selected) 
	{
		$fields = array('q.correct_answer');
		$this->db->select($fields);
		$this->db->from("questions q");
		$this->db->where("q.id=".$question_id);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		
		if($option_selected == $data_sets['correct_answer'])
		{
			$update_array = array('is_correct' => 1,'status'=>1,'selected_answer' => $option_selected);
		}
		else
		{
		 $update_array = array('is_correct' => 0,'status'=>($option_selected!=""?1:0),'selected_answer' => $option_selected);
		}
		$this->db->where('test_id',$test_id);
		$this->db->where('question_id',$question_id);
		$this->db->update('test_details',$update_array);
		
	}
	public function surprise_correct($question_id,$test_id,$option_selected) 
	{
		$fields = array('sq.correct_answer');
		$this->db->select($fields);
		$this->db->from("surprise_questions sq");
		$this->db->where("sq.id=".$question_id);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		
		if($option_selected == $data_sets['correct_answer'])
		{
			$update_array = array('is_correct' => 1,'status'=>1,'selected_answer' => $option_selected);
		}
		else
		{
		 $update_array = array('is_correct' => 0,'status'=>1,'selected_answer' => $option_selected);
		}
		$this->db->where('test_id',$test_id);
		$this->db->where('question_id',$question_id);
		$this->db->update('test_details',$update_array);
		
	}
	public function count_correct($test_id,$status) 
	{
		$count = array('td.is_correct');
		$this->db->select($count);
		$this->db->from("test_details td");
		$this->db->where("td.test_id=".$test_id." AND td.is_correct=".$status." AND td.status=1");
		$result=$this->db->get();
		$num_rows = $result->num_rows();
		return $num_rows;
	}
	public function answered($test_id,$status) 
	{
		$count = array('td.status');
		$this->db->select($count);
		$this->db->from("test_details td");
		$this->db->where("td.test_id=".$test_id." AND td.status=".$status);
		$result=$this->db->get();
		$num_rows = $result->num_rows();
		return $num_rows;
	}
	public function not_answered($test_id,$status) 
	{
		$count = array('td.serial_number');
		$this->db->select($count);
		$this->db->from("test_details td");
		$this->db->where("td.test_id=".$test_id." AND td.status=".$status);
		$result=$this->db->get(); 
		return $result->result_array();
	}
	public function user_percent($test_id,$ques_count) 
	{
		$count = array('td.is_correct');
		$this->db->select($count);
		$this->db->from("test_details td");
		$this->db->where("td.test_id=".$test_id." AND td.is_correct=1");
		$result=$this->db->get();
		$correct = $result->num_rows();
		$calculate = $correct/$ques_count;
		$percentage = round($calculate * 100);
		return $percentage;
	}
	public function pass_percentage($test_id) 
	{
		$count = array('te.pass_percent',"te.user_percent");
		$this->db->select($count);
		$this->db->from("test_engagement te");
		$this->db->where("te.id=".$test_id);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
	public function resume_status($test_arr,$user_id) 
	{
		$count = array('te.id','te.status','te.exam_code');
		$this->db->select($count);
		$this->db->from("test_engagement te");
		$this->db->where("te.user_id =".$user_id." AND te.course_id =".$test_arr['session_course']." AND te.class_id =".$test_arr['session_class']." AND te.subject_id =".$test_arr['subject_id']." AND te.chapter_id =".$test_arr['chapter_id']." AND te.level_id =".$test_arr['level_id']." AND te.set_id=".$test_arr['set_id']);
		$this->db->where("te.status","0");
		$result=$this->db->get();
		$numrows = $result->num_rows();
		$data_sets=$result->row_array();
		return array($numrows,$data_sets);
	}
	public function overall_percent($param,$set_count,$set_completed_count,$set_id) 
	{
		if($set_count == $set_completed_count)
		{
		foreach($set_id as $key=>$value)
		{
			$count = array('te.user_percent');
			$this->db->select($count);
			$this->db->from("test_engagement te");
			$this->db->where("te.user_id =".$param['user_id']." AND te.course_id =".$param['course_id']." AND te.class_id =".$param['class_id']." AND te.subject_id =".$param['subject_id']." AND te.chapter_id =".$param['chapter_id']." AND te.level_id =".$param['level_id']." AND te.set_id=".$value['set_id']);
			$this->db->order_by("te.id","desc");
			$this->db->limit("1");
			
			$result=$this->db->get();
			$data_count_sets[] = $result->row_array();
			
			
			$percent += $result->num_rows();
		}
			$sum=0;
			foreach($data_count_sets as $key=>$value){
				$sum+=$value['user_percent'];
			}
			$overall = round($sum/$percent);
			
		}else{
			$overall = 0;
		}
		return $overall;
	}
	public function percent_completed($test_id,$ques_count) 
	{
		$count = array('td.status');
		$this->db->select($count);
		$this->db->from("test_details td");
		$this->db->where("td.test_id=".$test_id." AND td.status=1");
		$result=$this->db->get();
		$answered = $result->num_rows();
		$calculate = $answered/$ques_count;
		$percentage = round($calculate * 100);
		return $percentage;
	}
	public function submit_test($user_id,$exam_code,$user_percent)
	{	
		$count_fields = array('s.pass_percentage');
		$this->db->select($count_fields);
		$this->db->from("settings s"); 
		$result=$this->db->get();
		$data_count_sets = $result->row_array();
		
		if($user_percent >= $data_count_sets['pass_percentage']){
			$result = "1";
		}else{
			$result = "0";
		}
		$date = date('Y-m-d H:i:s');
		$arr = array('end_date' => $date,
		 			 'user_percent' => $user_percent,
		 			 'status' => 1,
		 			 'result' => $result,
					);
		$this->db->where("user_id=".$user_id." AND exam_code=".$exam_code);
		$this->db->update("test_engagement",$arr);
		return $result;
	}
	public function certificate($param,$testid,$user_percent,$pass_percent,$type)
	{
		$course_name = array("co.name as course_name","l.name as level_name","te.end_date");
		$this->db->select($course_name);
		$this->db->from("test_engagement te");
		$this->db->join("courses co","co.id=te.course_id","left");
		$this->db->join("levels l","l.id=te.level_id","left");
		$this->db->where("te.id",$testid);
		$result_course=$this->db->get();
		$data_course = $result_course->row_array();
		
		$ret_data=0;
		if($user_percent >= round($pass_percent))
		{
			$date = date('Y-m-d H:i:s');
			$test_end_date = date('d-m-Y',strtotime($data_course['end_date']));
			if($type == 2)
			{
				$arr=array('test_id' => $testid,
						   'course_id' => $param['course_id'],
						   'user_id' => $param['user_id'],
						   'test_type' => $type,
						   'created' => $date,
						   'status' => '1',
							);
				$alert_array = array('created' => $date,
								 	 'title' => 'Surprise test completed successfully.',
								     'short_description' => 'Well Done! You have successfully completed the surprise test on '.$test_end_date.'.',
								     'status' => '1',
								     'alert_type'=>3,
								     'course_id'=>$param['course_id']
								     );
			}
			else
			{
				$arr=array('test_id' => $testid,
						   'course_id' => $param['course_id'],
						   'class_id' => $param['class_id'],
						   'subject_id' => $param['subject_id'],
						   'chapter_id' => $param['chapter_id'],
						   'level_id' => $param['level_id'],
						   'set_id' => 0,
						   'user_id' => $param['user_id'],
						   'test_type' => $type,
						   'created' => $date,
						   'status' => '1',
							);
				$alert_array = array('created' => $date,
								 	 'title' => 'Well Done! You have successfully completed the '.$data_course['level_name'].' progress test in '.$data_course['course_name'].'.',
								     'short_description' => 'Way to go!! You thrived through the '.$data_course['level_name'].', engage yourself with the next level of more exciting and competitive questions.',
								     'status' => '1',
								     'alert_type'=>3,
								     'course_id'=>$param['course_id'],
								     'class_id' => $param['class_id'],
								     'subject_id' => $param['subject_id'],
								     );
			}
			if($type!=2){
				$fields = array('c.id');
				$this->db->select($fields);
				$this->db->from('certificate c');
				$this->db->where('user_id',$param['user_id']);
				$this->db->where('level_id',$param['level_id']);
				$query = $this->db->get();
				$num_rows = $query->num_rows();
				if($num_rows == 0){
					$this->db->insert('certificate',$arr);
					$ret_data=1;
				}
			}
			else{
				$this->db->insert('certificate',$arr);
				$ret_data=1;
			}
			$this->db->insert('alerts',$alert_array);
			$alert_id = $this->db->insert_id();
			if(isset($alert_id)){
				$array = array ('alert_id' => $alert_id, 
								'user_id' => $param['user_id'],
								'status' => 1,
							   );
				$this->db->insert('alert_users', $array);
			}
			
		}
		return $ret_data;
	}
	public function level_completed($param,$overall_percent,$set_count,$set_completed_count) 
	{
		$count = array("lc.id");
		$this->db->select($count);
		$this->db->from("level_completed lc"); 
		$this->db->where($param);
		$result_count=$this->db->get();
		$data_return = $result_count->num_rows();
		
		$fields = array('te.pass_percent');
		$this->db->select($fields);
		$this->db->from("test_engagement te"); 
		$result=$this->db->get();
		$data_sets = $result->row_array();
		$date = date('Y-m-d H:i:s');
		if($set_count == $set_completed_count)
		{
			if($overall_percent >= $data_sets['pass_percent'])
			{
	 			$result = 1;
			} else 
			{
			 	$result = 0;
			}
			
			if($data_return == 0)
			{
				$arr = array('user_id' => $param['user_id'],
						 'course_id' => $param['course_id'],
						 'class_id' => $param['class_id'],
						 'subject_id' => $param['subject_id'],
						 'chapter_id' => $param['chapter_id'],
						 'level_id' => $param['level_id'],
						 'result' => $result,
						 'created' => $date,
						 'status' => 1,
						);
		
				$this->db->insert('level_completed',$arr);
			}
			else
			{
				$update_arr = array('result' => $result,
					 		 		'created' => $date
								   );
				$this->db->where($param);
				$this->db->update('level_completed',$update_arr);
			}
		}
		
	}
	public function total_levels($course_id,$class_id,$subject_id,$chapter_id)
	{
		$fields = array('id');
		$this->db->select($fields);
		$this->db->from("levels");
		$this->db->where("course_id",$course_id);
		$this->db->where("class_id",$class_id);
		$this->db->where("subject_id",$subject_id);
		$this->db->where("chapter_id",$chapter_id);
		$this->db->where("status",1);
		$result=$this->db->get();
		$result_data=$result->num_rows();
		return $result_data;
	}
	public function completed_levels_in_chap($course_id,$class_id,$subject_id,$chapter_id,$user_id)
	{
		$fields = array('id');
		$this->db->select($fields);
		$this->db->from("test_engagement");
		$this->db->where("course_id",$course_id);
		$this->db->where("class_id",$class_id);
		$this->db->where("subject_id",$subject_id);
		$this->db->where("chapter_id",$chapter_id);
		$this->db->where("user_id",$user_id);
		$this->db->where("status",1);
		$this->db->where("result",1);
		$this->db->where("test_type",1);
		$this->db->group_by('level_id');
		$this->db->order_by('id','desc');
		$result=$this->db->get();
		$result_data=$result->num_rows();
		return $result_data;
	}
	public function chapter_completed($course_id,$class_id,$subject_id,$chapter_id,$user_id)
	{
		$date = date('Y-m-d H:i:s');
		$arr = array('course_id'=> $course_id,
					 'class_id' => $class_id,
					 'subject_id' => $subject_id,
					 'chapter_id' => $chapter_id,
					 'user_id' => $user_id,
					 'completed_date' => $date);
		$this->db->insert('chapter_completed',$arr);
	}
	public function check_level_completed($user_id,$course_id,$class_id,$subject_id,$chapter_id,$level_id)
	{
		$fields = array('id','user_id','result');
		$this->db->select($fields);
		$this->db->from("level_completed");
		$this->db->where("user_id=".$user_id." AND course_id=".$course_id." AND class_id=".$class_id." AND subject_id=".$subject_id." AND chapter_id=".$chapter_id." AND level_id=".$level_id." AND status=1 AND result=1");
		$result=$this->db->get();
		$result_data=$result->row_array();
		return $result_data;
	}
	public function has_progress($user_id,$course_id,$class_id,$subject_id,$chapter_id,$level_id)
	{
		$fields = array('te.id');
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->join("level_completed lc","lc.level_id=te.level_id");
		$this->db->where("te.user_id=".$user_id." AND te.course_id=".$course_id." AND te.class_id=".$class_id." AND te.subject_id=".$subject_id." AND te.chapter_id=".$chapter_id." AND te.level_id=".$level_id." AND te.test_type=1 AND lc.result=1");
		$result=$this->db->get();
		$result_data=$result->num_rows();
		return $result_data;
	}
	public function is_progress_completed($user_id,$level_id){
		$this->db->where("level_id",$level_id);
		$this->db->where("user_id",$user_id);
		$this->db->where("result",'1');
		$this->db->where("test_type",'1');
		$this->db->select("count(id) as counts");
		$res=$this->db->get("test_engagement");
		$row_data=$res->row_array();
		return $row_data["counts"];
	}
	public function check_progress_completed($user_id,$course_id,$class_id,$subject_id,$chapter_id,$level_id)
	{
		$this->db->select("count(id) as progress_count");
		$this->db->from("test_engagement");
		$this->db->where("user_id=".$user_id." AND course_id=".$course_id." AND class_id=".$class_id." AND subject_id=".$subject_id." AND chapter_id=".$chapter_id." AND level_id=".$level_id." AND result=1 AND test_type=1");
		$result=$this->db->get();
		$result_data=$result->row_array();
		$count=$result_data["progress_count"];
		return $count;
	}
	public function check_surprise_completed($user_id,$course_id,$surprise_test_id)
	{
		$this->db->select("count(id) as surprise_count");
		$this->db->from("test_engagement");
		$this->db->where("user_id=".$user_id." AND course_id=".$course_id." AND test_type=2 AND surprise_test_id=".$surprise_test_id." AND status=1");
		$result=$this->db->get();
		$result_data=$result->row_array();
		$count=$result_data["surprise_count"];
		return $count;
	}
	public function get_start_time($test_random_id)
	{
		$fields = array('start_date');
		$this->db->select($fields);
		$this->db->from("test_engagement");
		$this->db->where("exam_code=".$test_random_id);
		$result=$this->db->get();
		$result_data=$result->row_array();
		return $result_data;
	}
	public function is_avail_progress($param){
		$level_id=$param["level_id"];
		array_pop($param);
		$this->db->where($param);
		$this->db->where("level_id !=",$level_id);
		$this->db->where("result",0);
		 $res=$this->db->get("level_completed");
		 if($res->num_rows()!=0){
			return "TRUE"; 
		 }else{
			return   "FALSE";
		 }
	}
	public function surprise_test_course($user_id)
	{
		$current_date = date('Y-m-d');
		$fields=array("t2.name",'t2.id');
		$this->db->select($fields);
		$this->db->from("user_plans t1");
		$this->db->join("courses t2","t2.id=t1.course_id");
		$this->db->join("surprise_test st","st.course_id=t1.course_id");
		$this->db->where("user_id",$user_id);
		$this->db->where("DATE(st.from_date) <=",$current_date);
		$this->db->where("DATE(st.to_date) >=",$current_date);
		$this->db->where("t1.status",1);
		$this->db->where("st.publish_status",1);	
		$result=$this->db->get();
		$data_sets=$result->result_array();
		$data=array();
		foreach($data_sets as $data_in){
			$data[$data_in['id']] = $data_in['name'];
		}
		return $data;
	}
	public function rank_holder()
	{
		$fields=array("te.user_id");
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->join("test_details td","td.test_id=te.id");
		$this->db->join("users u","u.id=te.user_id");
		$this->db->where("te.test_type","1");
		$this->db->where("te.result","1");
		$this->db->order_by("AVG(DISTINCT(te.user_percent))","desc");
		$this->db->group_by("te.user_id");
		$this->db->limit(10);
		$result=$this->db->get();
		$data=$result->result_array();
		return $data;
	}
	public function insert_tips($user_id,$tips,$title)
	{
		$update_arr = array('tips' => $tips,
							'tips_title' => $title,
							'tips_status' => 1);
		$this->db->where("id",$user_id);
		$update = $this->db->update("users",$update_arr);
		return $update;
	}
	public function get_tips($user_id)
	{
		$fields = array("tips_title","tips");
		$this->db->select($fields);
		$this->db->from("users");
		$this->db->where("id",$user_id);
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}

	public function get_chapters_first($course_id,$subject_id,$class_id){
		$this->db->select("c.id, c.name,c.subject_id,s.name as subject_name");
	  	$this->db->from("chapters as c");
	  	$this->db->where("c.course_id", $course_id);
	  	$this->db->where("c.class_id", $class_id);
	  	$this->db->where("c.subject_id", $subject_id);
		$this->db->join("subjects s","s.id=c.subject_id");
	  	$this->db->where('c.status','1');
	  	$this->db->order_by("c.name", "asc");
	  	$result = $this->db->get();
		return $result->result_array();
	}



	 public function get_chapters($course_id,$class_id,$subject_id){
	 	$this->db->select("c.id,c.name,c.subject_id,s.name as subject_name");
		$this->db->from("chapters c");
		$this->db->where("c.course_id =".$course_id." AND c.class_id =".$class_id);
		$this->db->where("c.status",1);	
		$this->db->join("subjects s","s.id=c.subject_id");
		$this->db->order_by("c.subject_id", "asc");
	 	if($subject_id){
	  		$subject_array = explode(',',$subject_id);
	  		$count = count($subject_array);
	  		if($count>1){
	  			$i=1;
		  		foreach($subject_array as $sub){
		  			if($i==1){
		  				$where  = "(c.subject_id = ".$sub." OR ";
		  			}else if($i==$count){
		  				$where .= " c.subject_id = ".$sub.")";
		  			}else{
		  				$where .= " c.subject_id = ".$sub." OR";
		  			}
		  			$i=$i+1;
		  		}
		  	}else{
		  		$where  = "(c.subject_id = ".$subject_id.")";
		  	}
		  	$this->db->where($where);
	 	}
	 	$result=$this->db->get();
	 	$data_sets=$result->result_array();
		return $data_sets;
	 }
}

