<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model {
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
		$this->db->where("co.course_type","2");
		$result=$this->db->get();
		$data=$result->row_array();
		return $data;
	}
	public function get_total_progress($user_id)
	{
		$c_fields = array('o.course_id');
		$this->db->select($c_fields);
		$this->db->from("orders o");
		$this->db->join("user_plans up","up.order_id=o.id");
		$this->db->where("o.order_status","1");
		$this->db->where("o.user_id",$user_id);
		$this->db->where("up.course_type",'2');
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
	public function get_main_modules()
	{
		$fields = array('*');
		$this->db->select($fields);
		$this->db->from('modules');
		$this->db->where('is_parent','0');
		$res = $this->db->get();
		$data = $res->result_array();
		return $data;
	}
	public function get_sub_modules($module_id)
	{
		$fields = array('*');
		$this->db->select($fields);
		$this->db->from('modules');
		$this->db->where('is_parent',$module_id);
		$res = $this->db->get();
		$data = $res->result_array();
		return $data;
	}
	public function get_privileges($admin_id)
	{
		$fields = array('privileges');
		$this->db->select($fields);
		$this->db->from('admin_users');
		$this->db->where('id',$admin_id);
		$res = $this->db->get();
		$data = $res->row_array();
		return $data;
	}
	public function get_modules_name($privil_id)
	{
		$module_id = explode(",",$privil_id);
		$fields = array('id','module_name');
		$this->db->select($fields);
		$this->db->from('modules');
		$this->db->where_in('id',$module_id);
		$res = $this->db->get();
		$data = $res->result_array();
		return $data;
	}
	public function get_all_modules_name()
	{
		$fields = array('module_name');
		$this->db->select($fields);
		$this->db->from('modules');
		$res = $this->db->get();
		$data = $res->result_array();
		return $data;
	}
	public function success($user_id, $price_type)
    {    
    	$data['ccavenue_details']=$this->config->item('ccavenue_details');
    	$courseid = $this->input->post('course');
    	$fields = array("id","price","duration"); 
		$this->db->select($fields);
		$this->db->from("courses");
		$this->db->where("status = 1 AND id =".$courseid);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		
		
		$duration = $data_sets['duration'];
		if($price_type){
			$currency_type = 1;
			$price = $data_sets['price'];
		}else{
			$currency_type = 2;
			$price = $data_sets['price_d'];
		}			
		$current_time = time();
		$start_date = date('Y-m-d',$current_time);
		$expiry_count = strtotime("+$duration months", $current_time);
		$expiry_date = date('Y-m-d', $expiry_count);
		//$days_count = $data_sets['duration']*30;
		$date1 = new DateTime($start_date); 
		$date2 = new DateTime($expiry_date);
		$diff = $date2->diff($date1)->format("%a");			
		$days_count =	$diff + 1;
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
		$payment_type = 0;
		
			$order_status = 1;
		
		// modified		
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
					 // 'course_type' => $course_type,
					 'price' => $data_sets['price'],
					 'no_of_days' => $days_count,
					 'course_start_date' => $start_date,
					 'course_expiry_date' => $expiry_date,
					 'order_id'=>$o_id,
					 'status' => 1);
			$insert_id = $this->db->insert("user_plans",$arr);	
							
				if($insert_id){
					// if($course_type ==2){
						$courseid = $this->input->post('course');
						$coursename = $this->home_model->get_course_name($courseid);
						$this->load->library('email');

						//added start
							$smtp_mail = $this->config->item('smtp_mail');
							$this->email->initialize($smtp_mail);
						//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");


						$email_config_data = array('[USERNAME]'=> $user_name,
												   '[COURSE_NAME]'=>$coursename['course_name'],
												   '[DURATION]'=>$coursename['duration'],
												   '[SITE_NAME]' => $this->config->item('site_name'));
						$cond = array();
						$cond[] = array(TRUE, 'id', 14 ); 
						$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');   
						foreach($email_config_data as $key => $value)
						{
							$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
						}
						$date = date('Y-m-d H:i:s');
						$this->email->from($smtp_mail['smtp_user'],"E4U");
						$this->email->to($user_email);
						$this->email->subject($mailcontent['subject']);
						$this->email->message($mailcontent['email_content']);				
						$result= $this->email->send();
						
						return $insert_id;
					// }
				}else{
					// Display error msg if record doesnt insert in user_plans table
					$error = array("msg"=>"Database error");
					return $error;
				}	
			
		}else{
				// Display error msg if record doesnt insert in order table
				$error = array("msg"=>"Database error");
				return false;
		}
    }
    public function get_users($keyword="")
    {
    	$fields = array('*');
		$this->db->select($fields);
		$this->db->from('users');
		$this->db->where('status','1');
		if($keyword != ""){
		$this->db->like('first_name', $keyword);
		$this->db->or_like('last_name', $keyword);
		$this->db->or_where("concat(first_name,' ',last_name) LIKE '%".$keyword."%'");
		$this->db->where('status','1');
		}
		$res = $this->db->get();
		$data_sets = $res->result_array();
		$data =array();
		foreach($data_sets as $data_in){
			$data[$data_in['id']] = $data_in['first_name']." ".$data_in['last_name'];
		}
		return $data;
    }
    
    public function get_course_list($cate_id,$purchased_courseid)
    {
    	$fields = array('co.id','co.name');
		$this->db->select($fields);
		$this->db->from('courses as co');
		$this->db->where('co.course_category_id',$cate_id);
		$this->db->where('co.status','1');
		$this->db->where('co.course_type','2');
		$this->db->where_not_in('co.id',$purchased_courseid);
		$res = $this->db->get();
		$data_sets = $res->result_array();
		$data =array();
		foreach($data_sets as $data_in){
			$data[$data_in['name']] = $data_in['id'];
		}
		return $data;
    }
}

