<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Extend_subscription extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','csv_import'));
		$this->load->language(array('flash_message','form_validation'), 'english');
		if(!$this->session->has_userdata('admin_is_logged_in'))
		{
			redirect(SITE_ADMIN_URI);
		}
		getSearchDetails($this->router->fetch_class());
		$this->load->helper('function_helper');
		$this->load->model(array('base_model','users_model')); 
	}
	public function index($page_num = 1)
	{	
		$search_name_keyword  = isset($_POST['search_name'])?trim($_POST['search_name']):(isset($_SESSION['search_name'])?$_SESSION['search_name']:'');
		$this->session->set_userdata('search_name', $search_name_keyword); 		
		$keyword_name_session = $this->session->userdata('search_name');
		if($keyword_name_session != '')
		{
			$keyword_name = $this->session->userdata('search_name');
		}
		else
		{
			isset($_SESSION['search_name'])?$this->session->unset_userdata('search_name'):'';
			$keyword_name = "";
		}
	
		$search_course_keyword  = isset($_POST['search_course'])?trim($_POST['search_course']):(isset($_SESSION['search_course'])?$_SESSION['search_course']:'');
		$this->session->set_userdata('search_course', $search_course_keyword); 								
		$keyword_course_session = $this->session->userdata('search_course');
		if($keyword_course_session != '')
		{					
			$keyword_course = $this->session->userdata('search_course');
		}
		else
		{
			isset($_SESSION['search_course'])?$this->session->unset_userdata('search_course'):'';
			$keyword_course = "";
		}
		
		$search_category_keyword  = isset($_POST['search_course_category'])?trim($_POST['search_course_category']):(isset($_SESSION['search_category'])?$_SESSION['search_category']:'');
		$this->session->set_userdata('search_category', $search_category_keyword); 										
		$keyword_category_session = $this->session->userdata('search_category');
		if($keyword_category_session != '')
		{					
			$keyword_category = $this->session->userdata('search_category');
		}
		else
		{
			isset($_SESSION['search_category'])?$this->session->unset_userdata('search_category'):'';
			$keyword_category = "";
		}		
		
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config["base_url"] = base_url().SITE_ADMIN_URI."/extend_subscription/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = array();
		$where = array();
		if($keyword_name)
		{
			$where[] = array( FALSE,"(u.first_name LIKE '%$keyword_name%' or u.email LIKE '%$keyword_name%' or concat (u.first_name,' ',u.last_name) LIKE '%$keyword_name%' or up.price LIKE '%$keyword_name%')");
			 
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}	
		
		if($keyword_course!="")
		{					
			$where[] = array( TRUE, 'co.id', $keyword_course);
			$data['keyword_course'] = $keyword_course;
		}
		else{
			$data['keyword_course'] = "";
		}
		if($keyword_category!="")
		{					
			$where[] = array( TRUE, 'co.course_category_id', $keyword_category);
			$data['keyword_category'] = $keyword_category;
		}
		else{
			$data['keyword_category'] = "";
		}
		$fields = 'o.id,up.id as user_plan_id,u.first_name,u.last_name,o.created as purchased_date,co.name as course_name,up.course_start_date, up.course_expiry_date'; 
		$join_tables[] = array('user_plans as up','up.order_id = o.id');	
		$join_tables[] = array('courses as co','co.id = up.course_id');	
		$join_tables[] = array('users as u','u.id = up.user_id');
		$where[] = array( TRUE, 'o.order_status', 1);
		$where[] = array( TRUE, 'up.course_type', 2);
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, 'num_rows','','','o.id');
		$data['extend_subscription'] = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, '', 'o.id', 'desc', 'o.id', $limit_start, $limit_end);				

		$this->pagination->initialize($config);
		
		$check_category = isset($_POST['search_course_category'])?trim($_POST['search_course_category']):(isset($_SESSION['search_category'])?$_SESSION['search_category']:'');
		
		if($check_category){	
			$where2 = array();
			$where2[] = array( TRUE, 'co.course_category_id', $check_category);
			$where2[] = array( TRUE, 'up.course_type', 2);
			$join_tables2[] = array('user_plans up','co.id = up.course_id', 'INNER');	
			$courses = $this->base_model->get_advance_list('courses co', $join_tables2, 'co.id, co.name', $where2, '', 'co.id', 'co.asc');
			$c[""] = "Select Course";
			foreach($courses as $course){
				$c[$course["id"]] = $course["name"];
			}
			$data['get_course'] = $c;
		}			 
		$fields1 = 'cc.id,cc.category'; 
		$join_tables1[] = array('courses c','c.course_category_id = cc.id');	
		$join_tables1[] = array('user_plans up','c.id = up.course_id', 'INNER');	
		$where1[] = array( TRUE, 'c.status', 1);
		$course_category = $this->base_model->get_advance_list('course_category cc', $join_tables1, $fields1, $where1, '', 'cc.category', 'asc', 'cc.id');
		$category = array();
		$category[""] = "Select";
		$get_type = array(""=>"Select type", "1"=>"Months", "2"=>"Days", "3"=>"Custom");
		$data['get_type'] = $get_type;
		foreach($course_category as $course){
			$category[$course["id"]] = $course["category"];
		}		
		$data['get_course_category'] = $category;
		$data['main_content'] = 'extend_subscription/index';
		$data['page_title']  = 'Extend Subscription'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		$this->session->unset_userdata('search_course');		
		$this->session->unset_userdata('search_category');
		redirect(base_url().SITE_ADMIN_URI.'/extend_subscription/');
	}
	public function reset_type()
	{
		$this->session->unset_userdata('search_type');
		$this->session->unset_userdata('search_date');		
		redirect(base_url().SITE_ADMIN_URI.'/extend_subscription/');
	}
	public function apply(){
		$type = $this->input->post('type');
		$counts = $this->input->post('date'); 
		$bulk_ids= $this->input->post('checkall_box');
		$i = 1;				
		date_default_timezone_set('Asia/Kolkata');	
		$date = date('Y-m-d H:i:s');		
		
			$keyword_name = isset($_SESSION['search_name'])?$this->session->userdata('search_name'):'';			
			$keyword_course = isset($_SESSION['search_course'])?$this->session->userdata('search_course'):'';			
			$keyword_category = isset($_SESSION['search_category'])?$this->session->userdata('search_category'):'';
		
			if($keyword_name)
			{
				$where[] = array( FALSE,"(u.first_name LIKE '%$keyword_name%' or u.email LIKE '%$keyword_name%' or concat (u.first_name,' ',u.last_name) LIKE '%$keyword_name%' or up.price LIKE '%$keyword_name%')");
				 
				$data['keyword_name'] = $keyword_name;
			}
			else{
				$data['keyword_name'] = "";
			}	
		
			if($keyword_course!="")
			{					
				$where[] = array( TRUE, 'co.id', $keyword_course);
				$data['keyword_course'] = $keyword_course;
			}
			else{
				$data['keyword_course'] = "";
			}
			if($keyword_category!="")
			{					
				$where[] = array( TRUE, 'co.course_category_id', $keyword_category);
				$data['keyword_category'] = $keyword_category;
			}
			else{
				$data['keyword_category'] = "";
			}
			$fields = 'up.id as user_plan_id, u.id as user_id, co.name'; 
			$join_tables[] = array('user_plans as up','up.order_id = o.id');	
			$join_tables[] = array('courses as co','co.id = up.course_id');	
			$join_tables[] = array('users as u','u.id = up.user_id');
			$where[] = array( TRUE, 'o.order_status', 1);
			$where[] = array( TRUE, 'up.course_type', 2);
			if(!empty($bulk_ids)){
			$imp_ids=implode(",",$bulk_ids);
			$where[] = array( FALSE, 'up.id in('.$imp_ids.')');
			}
			
			
			$user_details = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, '', 'o.id', 'desc', 'o.id', $limit_start, $limit_end);				
			foreach($user_details as $user){
				
				$where = array();
				$fields = 'course_start_date, course_expiry_date, no_of_days'; 
				$where[] = array( TRUE, 'id', $user["user_plan_id"]);					
				$return_data = $this->base_model->get_advance_list('user_plans', '', $fields, $where, 'row_array');	
															
											
				if($type == '1'){ //Months
					$duration = $counts." months";
					$expiry_date = date('Y-m-d', strtotime("+$duration", strtotime($return_data["course_expiry_date"])));
				}elseif($type == '2'){	//Days
					$duration = $counts." days";									
					$expiry_date = date('Y-m-d', strtotime("+$duration", strtotime($return_data["course_expiry_date"])));
				}else{
					$expiry_date = date('Y-m-d', strtotime($counts));
				}		
				$date1 = new DateTime($return_data["course_start_date"]); 
				$date2 = new DateTime($expiry_date);
				$diff = $date2->diff($date1)->format("%a");			
				$no_of_days = $diff + 1;
				$update_array = array ('course_expiry_date' =>	$expiry_date,  // modified
												'no_of_days' => $no_of_days,											   
												'modified' => $date
											);			
				$this->base_model->update ( 'user_plans', $update_array, array('id'=>$user["user_plan_id"]));
				
				// alert insertion
				$description = $user["name"]." course expiry date is extended from ".date("d-m-y", strtotime($return_data["course_expiry_date"]))." to ".date("d-m-y", strtotime($expiry_date));
				
				$alert_array = array('created' => $date,
									'title' => $description,
									'short_description' => 'Expiry date was extended by Admin',
									'status' => '1',
									);
				$alertId = $this->base_model->insert('alerts', $alert_array);	
				
				$alert_user_array = array('alert_id' => $alertId,
												'user_id' => $user["user_id"],
												'status' => '1');
				$this->base_model->insert('alert_users', $alert_user_array);				
			}		
		
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/extend_subscription/');	
	}
	

}	
