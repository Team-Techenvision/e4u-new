<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Webservice_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
    public function purchased($user_id)
    {
    	$courseid = $this->input->post('course_id');
    	$fields = array("id","price","duration"); 
		$this->db->select($fields);
		$this->db->from("courses");
		$this->db->where("status = 1 AND id =".$courseid);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		if($data_sets){
			$duration = $data_sets['duration'];
			$current_time = time();
			$start_date = date('Y-m-d',$current_time);
			$expiry_count = strtotime("+$duration months", $current_time);
			$expiry_date = date('Y-m-d', $expiry_count);
			$days_count = $data_sets['duration']*30;
			$date = date('Y-m-d H:i:s');
		
			$arr = array('created' => $date,
						 'user_id' => $user_id,
						 'course_id' => $courseid,
						 'price' => $data_sets['price'],
						 'no_of_days' => $days_count,
						 'course_start_date' => $start_date,
						 'course_expiry_date' => $expiry_date,
						 'status' => 1,
			);
			$insert_response = $this->db->insert("user_plans",$arr);
		    if ($insert_response) {
		        $insert_id  = $this->db->insert_id();
		        $return_var = $insert_id;
		    }
        }else{
        	$return_var = '';
        }
        return $return_var;
    }
    
    public function success($course_type, $user_id, $currency_type)
    {    
    	$courseid = $this->input->post('course_id');
    	$fields = array("id","price","price_d","duration", "course_type"); 
		$this->db->select($fields);
		$this->db->from("courses");
		$this->db->where("status = 1 AND id =".$courseid);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		
		$duration = $data_sets['duration'];
		if($currency_type==1){
			$price = $data_sets['price'];
		}elseif($currency_type==2){
			$price = $data_sets['price_d'];
		}else{
			$price = $data_sets['price'];
		}
		$current_time = time();
		$start_date = date('Y-m-d',$current_time);
		$expiry_count = strtotime("+$duration months", $current_time);
		$expiry_date = date('Y-m-d', $expiry_count);
		$days_count = $data_sets['duration']*30;
		$date = date('Y-m-d H:i:s');
		// Get order details
		$this->db->select("order_id");
		$this->db->from("orders");
		$this->db->order_by("id", "desc");
		$this->db->limit(1, 0);
		$order_result=$this->db->get();
		$num_rows = $order_result->num_rows();
		if($num_rows!=0){
			$order_details = $order_result->row_array();
			$order_id = $order_details['order_id']+1;
		}else{
			$order_id = 1;
		}
		// Get user details
		$user_fields = array("id", "first_name", "last_name", "email");
		$where[] = array( TRUE, "id =",$user_id);
		$user_details = $this->base_model->get_advance_list('users', '', $user_fields, $where, 'row_array');
		$user_name = $user_details["first_name"];
		$user_email = $user_details["email"];
		// insert order into table
		$transaction_id = 1;
		$payment_type = 1;
		if($course_type == 1){
			$order_status = 1;
		}else{
			$order_status = 0;
		}
		
		$order_arr = array('order_id'=>$order_id,
								'created'=>$date,
								'course_id' => $courseid,
								'user_id' => $user_id,
								'user_name'=>$user_name,
								'currency_type'=>$currency_type,
								'price'=>$price,
								'transaction_id'=>$transaction_id,
								'payment_type'=>$payment_type,
								'order_status'=>$order_status,
								'is_active'=>1
								);
								
		if($this->db->insert("orders",$order_arr)){		
			$o_id = $this->db->insert_id();
			$arr = array('created' => $date,
					 'user_id' => $user_id,
					 'course_id' => $courseid,
					 'course_type' => $course_type,
					 'price' => $price,
					 'no_of_days' => $days_count,
					 'course_start_date' => $start_date,
					 'course_expiry_date' => $expiry_date,
					 'order_id'=>$o_id,
					 'status' => 1);						
				if($this->db->insert("user_plans",$arr)){
					if($course_type ==1){
						$courseid = $this->input->post('course_id');
						$coursename = $this->home_model->get_course_name($courseid);
						$this->load->library('email');
						$email_config_data = array('[USERNAME]'=> $user_name,
												   '[COURSE_NAME]'=>$coursename['course_name'],
												   '[DURATION]'=>$coursename['duration'],
												   '[SITE_NAME]' => $this->config->item('site_name'));
						$cond = array();
						$cond[] = array(TRUE, 'id', 8 ); 
						$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');   
						foreach($email_config_data as $key => $value)
						{
							$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
						}
						$date = date('Y-m-d H:i:s');
						$this->email->from("noreply@e4u.com","e4u");
						$this->email->to($user_email);
						$this->email->subject($mailcontent['subject']);
						$this->email->message($mailcontent['email_content']);				
						$result= $this->email->send();
					}else{
						$courseid = $this->input->post('course_id');
						$coursename = $this->home_model->get_course_name($courseid);
						$cond = array();
						$cond[] = array(TRUE, 'id', 6 );
						$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');  
						$this->load->library('email');
						$email_config_data = array('[USERNAME]'=> $user_name,
												   '[COURSE_NAME]'=>$coursename['course_name'],
												   '[SITE_NAME]' => $this->config->item('site_name'));
					  					   
						$this->email->from("noreply@e4u.com","e4u");
						$this->email->to($user_email);
						$this->email->subject($mailcontent['subject']);
				
						foreach($email_config_data as $key => $value){
							$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
						}
						$this->email->message($mailcontent['email_content']);
						$result= $this->email->send();
					}
				}else{
					// Display error msg if record doesnt insert in user_plans table
					$error = array("msg"=>"Database error");
					return $error;
				}	
			return $order_id;
		}else{
				// Display error msg if record doesnt insert in order table
				$error = array("msg"=>"Database error");
				return false;
		}
    }
    
    public function getCount($table, $where)
    {
        if (is_array($where))
            $this->db->where($where);
        else
            $this->db->where('(' . $where . ')');
        $query = $this->db->get($table);
        return $query->num_rows();
    }
    public function count_correct($course_id,$class_id,$subject_id,$chapter_id,$level_id,$status,$user_id) 
	{
		$count=0;
		// get all sets
	 $this->db->select("id");
	 $this->db->from("sets");
	 $this->db->where("course_id",$course_id);
	 $this->db->where("class_id",$class_id);
	 $this->db->where("subject_id",$subject_id);
	 $this->db->where("chapter_id",$chapter_id);
	 $this->db->where("level_id",$level_id);
	 $res_set_all=$this->db->get()->result_array();
	 foreach($res_set_all as $all_set){
		 // get latest attended test id by certain set
		 $this->db->select("id");
		 $this->db->from("test_engagement");
		 $this->db->where("course_id",$course_id);
		 $this->db->where("class_id",$class_id);
		 $this->db->where("subject_id",$subject_id);
		 $this->db->where("chapter_id",$chapter_id);
		 $this->db->where("level_id",$level_id);
		 $this->db->where("set_id",$all_set["id"]); 
		 $this->db->where("user_id",$user_id);
		 $this->db->order_by("id","desc");
		 $this->db->limit(1); 
		 $res=$this->db->get();
		if($res->num_rows()!=0){
		 $res_single=$res->row_array();
		 $latest_id=$res_single["id"];
		 
		 // get count of answers
		 $this->db->select("count(td.id) as total_count");
		 $this->db->from("test_details td"); 
		 $this->db->where("td.test_id",$latest_id); 
		 
		 if($status==1){
			 $this->db->where("td.is_correct",$status); 
		 }else{
			 $this->db->where("td.status",1); 
			 $this->db->where("td.is_correct",$status); 
		 }
		 $res_count_Det=$this->db->get()->row_array();
		 $count +=$res_count_Det["total_count"];
		  
		}
	 }
	  
	  return $count;
	}
	
	public function count_skip($course_id,$class_id,$subject_id,$chapter_id,$level_id,$user_id) 
	{
		$count=0;
		// get all sets
	 $this->db->select("id");
	 $this->db->from("sets");
	 $this->db->where("course_id",$course_id);
	 $this->db->where("class_id",$class_id);
	 $this->db->where("subject_id",$subject_id);
	 $this->db->where("chapter_id",$chapter_id);
	 $this->db->where("level_id",$level_id);
	 $res_set_all=$this->db->get()->result_array();
	 foreach($res_set_all as $all_set){
		 // get latest attended test id by certain set
		 $this->db->select("id");
		 $this->db->from("test_engagement");
		 $this->db->where("course_id",$course_id);
		 $this->db->where("class_id",$class_id);
		 $this->db->where("subject_id",$subject_id);
		 $this->db->where("chapter_id",$chapter_id);
		 $this->db->where("level_id",$level_id);
		 $this->db->where("set_id",$all_set["id"]); 
		 $this->db->where("user_id",$user_id);
		 $this->db->order_by("id","desc");
		 $this->db->limit(1); 
		 $res=$this->db->get();
		if($res->num_rows()!=0){
		 $res_single=$res->row_array();
		 $latest_id=$res_single["id"];
		 
		 // get count of answers
		 $this->db->select("count(td.id) as total_count");
		 $this->db->from("test_details td"); 
		 $this->db->where("td.test_id",$latest_id); 
		 $this->db->where("td.status",0); 
		 $res_count_Det=$this->db->get()->row_array();
		 $count +=$res_count_Det["total_count"];
		  
		}
	 }
	  
	  return $count;
	}
	public function level_name($level_id)
	{
		$fields = array('name');
		$this->db->select($fields);
		$this->db->from("levels");
		$this->db->where("id",$level_id);
		$this->db->where("status",'1');
		$result = $this->db->get();
		$data = $result->row_array();
		return $data;
	}
	public function total_alerts($user_id)
	{
		$fields = array('a.id');
		$this->db->select($fields);
		$this->db->from("alerts a");
		$this->db->join("alert_users au","au.alert_id=a.id","left");
		$this->db->where("au.user_id",$user_id);
		$this->db->where("a.status",1);
		$result = $this->db->get();
		$num_rows = $result->num_rows();
		return $num_rows;
	}
	public function total_certificates($user_id)
	{
		$fields=array("c.id");
		$this->db->select($fields);
		$this->db->from("certificate c");
		$this->db->where("c.user_id",$user_id);
		$result=$this->db->get();
		$data=$result->num_rows();
		return $data;
	}
	public function subject_count_correct($user_id,$course_id,$class_id,$subject_id,$status="")
	{
		$fields = array('COUNT(td.id) as counts');
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->join("test_details td","td.test_id=te.id");
		$this->db->where("te.course_id",$course_id);
		$this->db->where("te.class_id",$class_id);
		$this->db->where("te.subject_id",$subject_id);
		$this->db->where("te.user_id",$user_id);
		if($status==1)
		{
			$this->db->where("td.is_correct",$status);
		}
		else
		{
			$this->db->where("td.status",1); 
			$this->db->where("td.is_correct",$status);
		}
		$this->db->where("te.test_type","1");
		$this->db->where("te.result","1");
		$this->db->where("te.status","1");
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
	public function subject_total_ques($user_id,$course_id,$class_id,$subject_id)
	{
		$fields = array('COUNT(td.question_id) as counts');
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->join("test_details td","td.test_id=te.id");
		$this->db->where("te.course_id",$course_id);
		$this->db->where("te.class_id",$class_id);
		$this->db->where("te.subject_id",$subject_id);
		$this->db->where("te.user_id",$user_id);
		$this->db->where("te.test_type","1");
		$this->db->where("te.result","1");
		$this->db->where("te.status","1");
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
	public function subject_count_skipped($user_id,$course_id,$class_id,$subject_id)
	{
		$fields = array('COUNT(td.id) as skip');
		$this->db->select($fields);
		$this->db->from("test_engagement te");
		$this->db->join("test_details td","td.test_id=te.id");
		$this->db->where("te.course_id",$course_id);
		$this->db->where("te.class_id",$class_id);
		$this->db->where("te.subject_id",$subject_id);
		$this->db->where("te.user_id",$user_id);
		$this->db->where("te.test_type","1");
		$this->db->where("te.result","1");
		$this->db->where("te.status","1");
		$this->db->where("td.status","0");
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
	public function progress_test($user_id,$course_id,$class_id,$subject_id)
	{
		$l_fields = array('te.level_id');
		$this->db->select($l_fields);
		$this->db->from("test_engagement te");
		$this->db->where("te.course_id",$course_id);
		$this->db->where("te.class_id",$class_id);
		$this->db->where("te.subject_id",$subject_id);
		$this->db->where("te.user_id",$user_id);
		$this->db->where("te.result","1");
		$this->db->where("te.test_type","1");
		$this->db->where("te.status","1");
		$this->db->group_by("level_id");
		$result=$this->db->get();
		$data=$result->result_array();
		$data_percent = $result->num_rows();
		foreach($data as $key=>$value)
		{
			$level_id[] = $value['level_id'];
		}
		$fields = array('lc.level_id','lc.chapter_id','l.name as level_name','ch.name as chapter_name');
		$this->db->select($fields);
		$this->db->from("level_completed lc");
		$this->db->join("levels l","l.id=lc.level_id");
		$this->db->join("chapters ch","ch.id=lc.chapter_id");
		$this->db->where("lc.course_id",$course_id);
		$this->db->where("lc.class_id",$class_id);
		$this->db->where("lc.subject_id",$subject_id);
		$this->db->where("lc.user_id",$user_id);
		$this->db->where_not_in("lc.level_id",$level_id);
		$this->db->where("lc.result","1");
		$this->db->order_by("lc.level_id","asc");
		$this->db->order_by("lc.chapter_id","asc");
		$this->db->limit(1);
		$res=$this->db->get();
		$data_ret=$res->result_array();
		$num_rows = $res->num_rows();
		return array($data_ret,$num_rows,$data_percent);
	}
	public function total_progress_levels($course_id,$class_id,$subject_id)
	{
		$c_fields = array('c.id');
		$this->db->select($c_fields);
		$this->db->from('chapters c');
		$this->db->where("c.course_id",$course_id);
		$this->db->where("c.class_id",$class_id);
		$this->db->where("c.subject_id",$subject_id);
		$this->db->where("c.status","1");
		$res_chap=$this->db->get();
		$data_chap=$res_chap->result_array();
		foreach($data_chap as $key=>$value)
		{
			$chap_id[] = $value['id'];
		}
		$l_fields = array('count(l.id) as counts');
		$this->db->select($l_fields);
		$this->db->from('levels l');
		$this->db->where("l.course_id",$course_id);
		$this->db->where("l.class_id",$class_id);
		$this->db->where("l.subject_id",$subject_id);
		$this->db->where_in("l.chapter_id",$chap_id);
		$this->db->where("l.status","1");
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
	public function recent_chapter_list($course_id,$class_id,$subject_id,$category_id)
	{
		$fields = array('ch.id','ch.name','ch.description','sc.id as category_id','sc.name as category_name');
    	$this->db->select($fields);
		$this->db->from("chapters ch");
		$this->db->join("subjective_questions subq","subq.chapter_id=ch.id");
		$this->db->join("sub_category sc","sc.id=subq.sub_category_id");
		$this->db->where("subq.course_id",$course_id);
		$this->db->where("subq.class_id",$class_id);
		$this->db->where("subq.subject_id",$subject_id);
		$this->db->where("subq.sub_category_id",$category_id);
		$this->db->where('ch.status',1);
		$this->db->where('subq.status',1);
		$this->db->group_by('ch.id');
		$this->db->order_by('ch.id','desc');
		$this->db->limit(3);
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
	}
	public function category_list()
	{
		$fields=array("sc.id","sc.name");
		$this->db->select($fields);
		$this->db->from("sub_category sc");
		$this->db->where("sc.status",1);
		$this->db->order_by('sc.name','asc');	
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
	}
	public function total_subj_questions($param)
	{
		$fields = array('subq.id');
		$this->db->select($fields);
		$this->db->from("subjective_questions subq");
		$this->db->where($param);
		$this->db->where("subq.status",1);
		$result = $this->db->get();
		$num_rows = $result->num_rows();
		return $num_rows;
	}
	public function check_mapping($course_id,$class_id,$subject_id)
	{
		$fields = array('rs.id');
		$this->db->select($fields);
		$this->db->from("relevant_subjects rs");
		$this->db->join("courses co","co.id=rs.course_id");
		$this->db->join("classes cl","cl.id=rs.class_id");
		$this->db->join("subjects s","s.id=rs.subject_id");
		$this->db->where("rs.course_id",$course_id);
		$this->db->where("rs.class_id",$class_id);
		$this->db->where("rs.subject_id",$subject_id);
		$this->db->where("s.status",1);
		$this->db->where("co.status",1);
		$this->db->where("cl.status",1);
		$result = $this->db->get();
		$num_rows = $result->num_rows();
		return $num_rows;
	}


}

