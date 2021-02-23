<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Offline_subscription extends Admin_Controller
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
		$this->load->model('base_model'); 
		$this->load->model(array('users_model','home/home_model')); 
	}
	public function index($page_num = 1)
	{  
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
		$search_from_date_keyword  = isset($_POST['search_from_date'])?trim($_POST['search_from_date']):(isset($_SESSION['search_from_date'])?$_SESSION['search_from_date']:'');
		$this->session->set_userdata('search_from_date', $search_from_date_keyword); 			
		$keyword_from_date_session = $this->session->userdata('search_from_date');
		if($keyword_from_date_session != '')
		{
			$keyword_from_date = $this->session->userdata('search_from_date');
		}
		else
		{
			isset($_SESSION['search_from_date'])?$this->session->unset_userdata('search_from_date'):'';
			$keyword_from_date = "";
		}
		$search_to_date_keyword  = isset($_POST['search_to_date'])?trim($_POST['search_to_date']):(isset($_SESSION['search_to_date'])?$_SESSION['search_to_date']:'');
		$this->session->set_userdata('search_to_date', $search_to_date_keyword); 			
		$keyword_to_date_session = $this->session->userdata('search_to_date');
		if($keyword_to_date_session != '')
		{
			$keyword_to_date = $this->session->userdata('search_to_date');
		}
		else
		{
			isset($_SESSION['search_to_date'])?$this->session->unset_userdata('search_to_date'):'';
			$keyword_to_date = "";
		}		
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config["base_url"] = base_url().SITE_ADMIN_URI."/offline_subscription/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = array();
		$where = array();
		
		if($keyword_name)
		{
			$where[] = array( FALSE,"(u.first_name LIKE '%$keyword_name%' or concat (u.first_name,' ',u.last_name) LIKE '%$keyword_name%')");
			 
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}
		if($keyword_course)
		{
			$where[] = array( TRUE, 'up.course_id', $keyword_course);
			$data['keyword_course'] = $keyword_course;
		}
		else{
			$data['keyword_course'] = "";
		}
		if($keyword_from_date)
		{
			$from_date = $keyword_from_date." 00:00:00";	
			$where[] = array( TRUE, "o.created >=",$from_date);
			$data['keyword_from_date'] = $keyword_from_date;
		}
		else{
			$data['keyword_from_date'] = "";
		}
		if($keyword_to_date)
		{
			$to_date = $keyword_to_date." 23:59:59";
			$where[] = array( TRUE, "o.created <=",$to_date);
			$data['keyword_to_date'] = $keyword_to_date;
		}
		else{
			$data['keyword_to_date'] = "";
		}
		$fields = 'up.id,u.first_name,u.last_name,up.course_start_date,o.price,o.currency_type,co.name as course_name,o.id as order_id,up.course_expiry_date';
		$join_tables[] = array('orders as o','o.id = up.order_id'); 	
		$join_tables[] = array('users as u','u.id = o.user_id'); 	
		$join_tables[] = array('courses as co','co.id = up.course_id'); 
		$where[] = array('TRUE','o.payment_type','0');		  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('user_plans up', $join_tables, $fields, $where, 'num_rows','','','up.id');
		$data['users'] = $this->base_model->get_advance_list('user_plans up', $join_tables, $fields, $where, '', 'up.id', 'desc', 'up.id', $limit_start, $limit_end); 
		$this->pagination->initialize($config);
		$data['get_course'] = $this->base_model->getSelectList('courses',array('status'=>'1'));
		$data['currency'] = $this->config->item('currency_symbol');
		$data['dollar_symbol'] = $this->config->item('dollar_symbol');
		$data['main_content'] = 'offline_subscription/index';
		$data['page_title']  = 'User Privileges'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		$this->session->unset_userdata('search_course');
		$this->session->unset_userdata('search_from_date');
		$this->session->unset_userdata('search_to_date');
		redirect(base_url().SITE_ADMIN_URI.'/offline_subscription/');
	}
	public function validate_select($val, $fieldname){
		if($val==""){
			$this->form_validation->set_message('validate_select', 'Please choose the '.$fieldname.'.');
			return FALSE;
		}			
	}	
	public function add()
	{
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_rules('user_name', 'User','callback_validate_select[user]');
			// $this->form_validation->set_rules('course_category', 'Course Category','callback_validate_select[course category]');
			$this->form_validation->set_rules('course', 'Course','callback_validate_select[course]');
			
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$user_id = $this->input->post('user_name');
				// $course_type = 0;
				$price_type = $this->input->post('price'); // 1 - rs, 0 - usd
				$response = $this->users_model->success($user_id, $price_type);				
				$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				redirect(base_url().SITE_ADMIN_URI.'/offline_subscription');
			}
			$data['post'] = TRUE;
		}
		$data['get_users'] = $this->users_model->get_users();
		// $data['course_category'] = $this->base_model->getSelectList('course_category','','','id,category');		
		$data['course'] = $this->base_model->getSelectList('courses',array('status'=>'1'));
		$data['main_content'] = 'offline_subscription/add';
		$data['page_title']  = 'User Privileges'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function search()
	{
		$keyword = $this->input->post('keyword');
		$data['suggest'] = $this->users_model->get_users($keyword); 
		echo json_encode($data);
	}
	
	public function request()
	{ 
		$user_id = $this->input->post('user_id');
		$cate_id = $this->input->post('cate_id');
		$data = array();
		$data['course'] = array();
		$join_tables = $where = array();  
	  	$fields = 'o.course_id'; 
	  	$where[] = array( TRUE, 'up.user_id', $user_id);
	  	$where[] = array( TRUE, 'up.is_expired', '1');
	  	$join_tables[] = array('user_plans as up','up.order_id = o.id'); 
	  	$purchased_course = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where);
	  	 
	  	foreach($purchased_course as $key=>$value)
	  	{
	  		$purchased_courseid[] = $value['course_id'];
	  	}
	  	
	  	$data['course'] = $this->users_model->get_course_list($cate_id,$purchased_courseid);
	  		 
		echo json_encode($data);
	}	
	public function request2()
	{ 
		$course_id = $this->input->post('course_id');
		$data = array();
		$join_tables = $where = array();  
	  	$fields = 'co.price,co.currency_type,co.duration'; 
	  	$where[] = array( TRUE, 'co.id', $course_id);
	  	$data = $this->base_model->get_advance_list('courses as co', $join_tables, $fields, $where,'row_array');
	  	$duration = $data['duration'];
		$current_time = time();
		$start_date = date('d-m-Y',$current_time);
		$expiry_count = strtotime("+$duration months", $current_time);
		$data['expiry_date'] = date('d-m-Y', $expiry_count); 
		echo json_encode($data);
	}
	public function request3()
	{ 
		$user_id = $this->input->post('user_id');
		$data = array();
		$data['course'] = array();
		// $data['course_category'] = array();
		$join_tables = $where = array();  
	  	$fields = 'co.id,co.name'; 
	  	$where[] = array( TRUE, 'co.status', '1');
	  	// $where[] = array( TRUE, 'co.course_type', '0');
	  	$course_list = $this->base_model->get_advance_list('courses as co', $join_tables, $fields, $where);
	  	
	  	if($course_list){
		  	foreach($course_list as $course){
		  		if($course['id']!=""){
		  			$data['course'][ucfirst($course['name'])] = $course['id'];
		  		}		  		
		  	}
	  	}
	  	
	  	// $fields2 = 'cc.id,cc.category'; 
	  	// $where2[] = array( TRUE, 'cc.status', '1');
	  	// $course_cat_list = $this->base_model->get_advance_list('course_category as cc', $join_tables, $fields2, $where2);
	  	
	  	// if($course_cat_list){
		  // 	foreach($course_cat_list as $course_cat){
		  // 		if($course_cat['id']!=""){
		  // 			$data['course_category'][ucfirst($course_cat['category'])] = $course_cat['id'];
		  // 		}		  		
		  // 	}
	  	// }
	  	
		echo json_encode($data);
	}
}
