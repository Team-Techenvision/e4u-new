<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
    public function course_detail($courseid){
    	$course_fields = 'id,name,description,duration,price';
		$this->db->select($course_fields);
		$this->db->from("courses");
		$this->db->where("id",$courseid);
		$this->db->where("status",'1');
		$this->db->order_by("id",'asc');
		$this->db->limit("1");
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
    }
    public function get_settings(){
		$fields=array('*');
		$this->db->select($fields);
		$this->db->from("settings s");
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
	}
    public function category_detail($category_id){
    	$course_fields = 'id,name,description,duration,price,price_d,course_type,course_category_id';
		$this->db->select($course_fields);
		$this->db->from("courses");
		$this->db->where("status",'1');
		$this->db->where("show_in_frontend",'1');
		$this->db->where("course_category_id",$category_id);
		$this->db->order_by("order_by_category",'asc');
		$result=$this->db->get();
		$data_sets=$result->result_array();
		return $data_sets;
    }
     public function cat_course_detail($category_id,$course_id){
    	$course_fields = 'id,name,description,duration,price,price_d,course_type,course_category_id';
		$this->db->select($course_fields);
		$this->db->from("courses");
		$this->db->where("status",'1');
		$this->db->where("course_category_id",$category_id);
		$this->db->where("id",$course_id);
		$this->db->order_by("id",'asc');
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
    }
    public function success($course_type, $user_id)
    {    
    	$data['ccavenue_details']=$this->config->item('ccavenue_details');
    	$courseid = $this->input->post('choose');
    	$fields = array("id","price","duration", "course_type"); 
		$this->db->select($fields);
		$this->db->from("courses");
		$this->db->where("status = 1 AND id =".$courseid);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		
		
		$duration = $data_sets['duration'];
		$price = $data_sets['price'];
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
			$order_status = 1;
		}
		
		$order_arr = array('order_id'=>$order_id,
								'created'=>$date,
								'course_id' => $courseid,
								'user_id' => $user_id,
								'user_name'=>$user_name,
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
					 'price' => $data_sets['price'],
					 'no_of_days' => $days_count,
					 'course_start_date' => $start_date,
					 'course_expiry_date' => $expiry_date,
					 'order_id'=>$o_id,
					 'status' => 1);					
				if($this->db->insert("user_plans",$arr)){
					if($course_type ==1){
						$courseid = $this->input->post('choose');
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
						$merchant_data = array("merchant_id"=>$data['ccavenue_details']['merchant_id'],
				                    "order_id"=>$order_id,
				                    "currency"=>$data['ccavenue_details']['currency'],
				                    "amount"=>$price,
		                          "redirect_url"=>base_url().'home/payment_response',
		                          "cancel_url"=>base_url().'home/payment_response',
		                          "language"=>$data['ccavenue_details']['language'] );
		            $order_details = array("order_id"=>$order_id, "o_id"=>$o_id, "user_name"=>$user_name, "user_email"=>$user_email );
		            $this->session->set_userdata('order_details',$order_details);
						return $merchant_data;
					}
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
    
    public function success_new($user_id,$courseid) //modified
    {    	

    	$data['ccavenue_details']=$this->config->item('ccavenue_details');
    	// var_dump($data['ccavenue_details']);die;

    	$fields = array("id","price","duration","currency_type"); //modified 
		$this->db->select($fields);
		$this->db->from("courses");
		$this->db->where("status = 1 AND id =".$courseid);
		$result=$this->db->get();
		$data_sets=$result->row_array();	
		$duration = $data_sets['duration'];
		$currency_type = $data_sets['currency_type'];
       
		if($currency_type==1){	//modified
			$currency_code = $data['ccavenue_details']['currency1'];
			$price = $data_sets['price'];
		}

		$current_time = time();
		$start_date = date('Y-m-d',$current_time);
		$expiry_count = strtotime("+$duration months", $current_time);
		$expiry_date = date('Y-m-d', $expiry_count);
		

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
		$user_fields = array("id", "first_name", "last_name", "email","address","phone");
		$where[] = array( TRUE, "id =",$user_id);
		$user_details = $this->base_model->get_advance_list('users', '', $user_fields, $where, 'row_array');

		$user_name = $user_details["first_name"];
		$user_email = $user_details["email"];
		// insert order into table
		$transaction_id = 1;
		$payment_type = 1;
		$order_status = 1;
		
		//modified
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
					 'price' => $price,	//modified
					 'no_of_days' => $days_count,
					 'course_start_date' => $start_date,
					 'course_expiry_date' => $expiry_date,
					 'order_id'=>$o_id,
					 'status' => 1);
					//print_r($arr);exit; 					
				if($this->db->insert("user_plans",$arr)){

					// for payment gateway start
						$merchant_data = array("merchant_id"=>$data['ccavenue_details']['merchant_id'],
					                    "order_id"=>$order_id,
					                    "currency"=>$currency_code,
					                    "amount"=>$price,
			                          	"redirect_url"=>base_url().'home/payment_response',
			                          	"cancel_url"=>base_url().'home/payment_response',
			                          	"language"=>$data['ccavenue_details']['language'],
			                          	"billing_name"=>$user_details['first_name']."".$user_details['last_name'],
			                          	"billing_address"=>$user_details['address'],
			                          	"billing_email"=>$user_email,
			                          	"billing_tel"=>$user_details['phone']
			                           );
			            $order_details = array("order_id"=>$order_id, "o_id"=>$o_id, "user_name"=>$user_name, "user_email"=>$user_email );
			            $this->session->set_userdata('order_details',$order_details);
						return $merchant_data;
					// for payment gateway end
					


				}else{
					// Display error msg if record doesnt insert in user_plans table
					$error = array("msg"=>"Database error");
					return $error;
				}			
			
		}else{
				// Display error msg if record doesnt insert in order table
				$error = array("msg"=>"Database error");
				return $error;
		}
    }
    
    public function get_course_name($courseid)
    {
    	$fields = array('co.name as course_name','co.duration','co.*');
    	$this->db->select($fields);
		$this->db->from("courses as co");
		$this->db->where("co.id",$courseid);
		$result=$this->db->get();
		$data_sets=$result->row_array();
		return $data_sets;
    }
    public function check_purchased($user_id)
    {    	    	
		$user_plan_fields=array("o.course_id");
		$this->db->select($user_plan_fields);
		$this->db->from("orders as o");
		$this->db->join("user_plans as u", "o.id = u.order_id and o.order_status = 1");
		$this->db->where("o.user_id=".$user_id);
		$result=$this->db->get();
		$data_sets=$result->result_array();		
		foreach($data_sets as $data_ret){
			$data[] = $data_ret['course_id'];
		}
		return $data;
		
    }
    public function get_materials($course="0")
	 {
		$this->db->select($fields);
		$this->db->from("downloads d"); 
		$this->db->join("classes cl","cl.id=d.class_id");
		$this->db->join("subjects s","s.id=d.subject_id");
		$this->db->where("d.course_id",$course);
		$this->db->where("d.status",1);
		$this->db->where("cl.status",1);
		$this->db->where("s.status",1);
		$this->db->order_by('d.id','desc');
		$result=$this->db->get();
		return $result->result_array();
	 }

	 public function get_materials_dashboard($course_id, $class_id, $subject_id,$chapter_id,$limit='',$start='')
	 {
		$this->db->select("*");
		$this->db->from("downloads d"); 
		$this->db->where("d.course_id",$course_id);
		$this->db->where("d.class_id",$class_id);
		$this->db->where("d.subject_id",$subject_id);
		$this->db->where("d.chapter_id",$chapter_id);
		$this->db->where("d.status",1);
		if($limit){
			  $this->db->limit($limit, $start);
		}
		$result=$this->db->get();
		return $result->result_array();
	 }
	 public function get_attachments($downloads_id,$limit=0)
	 {
		$this->db->select("*");
		$this->db->from("downloads_attachment d"); 
		$this->db->where("d.downloads_id",$downloads_id);
		// $this->db->order_by('d.id','desc');
		if($limit){
			$this->db->limit($limit);
		}
		$result=$this->db->get();
		return $result->result_array();
	 }
	  public function get_attachment($id)
	 {
		$this->db->select("*");
		$this->db->from("downloads_attachment d"); 
		$this->db->where("d.id",$id);
		$result=$this->db->get();
		// echo $this->db->last_query();die;
		return $result->row_array();
	 }


	 public function get_ordercounts($id){
	 	$this->db->select('*');
		$this->db->from('orders as o');
		$this->db->join('user_plans as u', 'o.id = u.order_id');
		$this->db->where('o.order_status',1);
		$this->db->where('o.user_id',$id);
		$result = $this->db->get();
		return $result->num_rows();
	 }
	 
	 public function update_payment_details($order_id, $payment_data){		 	
	 	$order_details = $this->session->userdata('order_details');
	 	$this->db->where('order_id', $order_id);
		$this->db->update('orders', $payment_data);		
		if($this->db->affected_rows()){
			$this->load->library('email');
			$course_details = $this->user_payment_details($order_id);	 	
			$course_name = $course_details["course_name"]; 
			$user_name = $course_details["user_name"];
			$user_email = $course_details["email"];
			if($payment_data["order_status"] == 1){
				// Pls change mail content
				/*$email_config_data = array('[USERNAME]'=> $order_details["user_name"], 										   
											'[USER_EMAIL]' => $order_details["user_email"],
											'[SITE_NAME]' => $this->config->item('site_name'));*/
				$email_config_data = array('[USERNAME]'=> $user_name, 										   										
											'[COURSE_NAME]' => $course_name,
											'[SITE_NAME]' => $this->config->item('site_name'));									
	
				$cond = array();
				$cond[] = array(TRUE, 'id', 6 ); 
				$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');   
				foreach($email_config_data as $key => $value)
				{
					$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
				}
				$date = date('Y-m-d H:i:s');
				$this->email->from("noreply@e4u.com");
				$this->email->to($user_email);
				$this->email->subject($mailcontent['subject']);
				$this->email->message($mailcontent['email_content']);				
				$result= $this->email->send();
	 		}
	 		else 
	 		{
	 			if($payment_data["order_status"] == 3)
	 			{
	 				$status_message = "failured";
	 			}
	 			else if($payment_data["order_status"] == 4)
	 			{
	 				$status_message = "aborted";
	 			}
	 			else if($payment_data["order_status"] == 5)
	 			{
	 				$status_message = "pending";
	 			}
	 			
	 			$email_config_data = array('[USERNAME]'=> $user_name, 
	 									   '[COURSE_NAME]' => $course_name,					
										   '[ORDER_STATUS]' => $status_message,
										   '[SITE_NAME]' => $this->config->item('site_name'));									
	
				$cond = array();
				$cond[] = array(TRUE, 'id', 17 ); 
				$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');   
				foreach($email_config_data as $key => $value)
				{
					$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
				}
				$date = date('Y-m-d H:i:s');
				$this->email->from("noreply@e4u.com");
				$this->email->to($user_email);
				$this->email->subject($mailcontent['subject']);
				$this->email->message($mailcontent['email_content']);				
				$result= $this->email->send();
	 		}
			return true;			
		}else{
			return false;
		}	 
	 }
	 public function get_page_content($slug){
		 $this->db->where("status",1);
		 $this->db->where("alias",$slug);
		 $res=$this->db->get("pages");
		 return $res;
	 }
	 public function get_faq()
	 {
	 	$fields = array('id','question','answer');
	 	$this->db->select($fields);
	 	$this->db->from('faqs');
	 	$this->db->where('status',1);
	 	$result = $this->db->get();
	 	$data = $result->result_array();
	 	return $data;
	 	
	 }
	 public function get_category_details($cat_id)
	 {
	 	$fields = array('category');
	 	$this->db->select($fields);
	 	$this->db->from('course_category');
	 	$this->db->where('status',1);
	 	$this->db->where('id',$cat_id);
	 	$result = $this->db->get();
	 	$data = $result->row_array();
	 	return $data;
	 }
	 public function is_expired($course_ids,$user_id)
	 {
	 	$fields = array('course_id','is_expired');
	 	$this->db->select($fields);
	 	$this->db->from('user_plans');
	 	$this->db->where_in('course_id',$course_ids);
	 	$this->db->where('user_id',$user_id);
	 	$result = $this->db->get();
	 	$data = $result->result_array();
	 	$res=array();
	 	foreach($data as $data_ret)
	 	{
	 		$res[$data_ret['course_id']] = $data_ret['is_expired'];
	 	}
	 	return $res;
	 	
	 }

	  public function course_relevant_classes($course_id)
	 {
	 	$fields = array('rel.class_id','rel.course_id','cl.name');
	 	$this->db->select($fields);
	 	$this->db->from('relevant_classes rel');
	 	$this->db->where_in('rel.course_id',$course_id);

	 	$this->db->where('rel.status', 1);
	 	$this->db->where('cl.status', 1);

	 	$this->db->join('classes cl','rel.class_id =  cl.id');

	 	$result = $this->db->get();
	 	// echo $this->db->last_query();die;
	 	$data = $result->result_array();
	 	$res=array();
	 	foreach($data as $data_ret)
	 	{
	 		$res[$data_ret['course_id']][] = $data_ret['class_id'];
	 	}
	 	return $res;
	 }

	 public function is_cancelled($course_id,$user_id) // modified
	 {
	 	$fields = array('order_status');
	 	$this->db->select($fields);
	 	$this->db->from('orders');
	 	$this->db->where('course_id',$course_id);
	 	$this->db->where('user_id',$user_id);	 	
	 	$this->db->order_by('id', 'desc');
	 	$this->db->limit(1);
	 	$result = $this->db->get();	 	
	 	$data = $result->row_array();			 	
	 	if(count($data)){
	 		return $data["order_status"];
	 	}else{
	 		$order_status = 0;
	 		return $order_status;
	 	}
	 }
	 public function check_expiry($user_id,$courseid)
	 {
	 	$fields = array('is_expired');
	 	$this->db->select($fields);
	 	$this->db->from('user_plans');
	 	$this->db->where('course_id',$courseid);
	 	$this->db->where('user_id',$user_id);
	 	$this->db->order_by('id','desc');
	 	$result = $this->db->get();
	 	$data = $result->row_array();
	 	return $data;
	 }
	 public function already_purchased($user_id,$course_id)
    {    	    	
		$user_plan_fields=array("o.id");
		$this->db->select($user_plan_fields);
		$this->db->from("orders as o");
		$this->db->join("user_plans as u", "o.id = u.order_id and o.order_status = 1");
		$this->db->where("o.user_id",$user_id);
		$this->db->where("o.course_id",$course_id);
		$result=$this->db->get();
		$data_sets=$result->num_rows();		
		return $data_sets;
    }
    
    public function user_payment_details($order_id){    	
    	$this->db->select("c.name as course_name, CONCAT(u.first_name,' ',u.last_name) as user_name, u.email");
		$this->db->from("orders o"); 
		$this->db->join("courses c","c.id=o.course_id");
		$this->db->join("users u","u.id=o.user_id");
		$this->db->where("o.order_id",$order_id);
		$course_details_result=$this->db->get();		
		$course_details = $course_details_result->row_array();
		return $course_details;
    }

}

