<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_reports extends Admin_Controller
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
		$this->load->model(array('base_model','users_model','dashboard/dashboard_model'));  
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
		$search_class_keyword  = isset($_POST['search_class'])?trim($_POST['search_class']):(isset($_SESSION['search_class'])?$_SESSION['search_class']:'');
		$this->session->set_userdata('search_class', $search_class_keyword); 		
		$keyword_class_session = $this->session->userdata('search_class');
		if($keyword_class_session != '')
		{
			$keyword_class = $this->session->userdata('search_class');
		}
		else
		{
			isset($_SESSION['search_class'])?$this->session->unset_userdata('search_class'):'';
			$keyword_class = "";
		}
		$search_subject_keyword  = isset($_POST['search_subject'])?trim($_POST['search_subject']):(isset($_SESSION['search_subject'])?$_SESSION['search_subject']:'');
		$this->session->set_userdata('search_subject', $search_subject_keyword); 		
		$keyword_subject_session = $this->session->userdata('search_subject');
		if($keyword_subject_session != '')
		{
			$keyword_subject = $this->session->userdata('search_subject');
		}
		else
		{
			isset($_SESSION['search_subject'])?$this->session->unset_userdata('search_subject'):'';
			$keyword_subject = "";
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
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config["base_url"] = base_url().SITE_ADMIN_URI."/performance_reports/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = array();
		$where = array();
		if($keyword_course!="")
		{					
			$where[] = array( TRUE, 'te.course_id', $keyword_course);
			$data['keyword_course'] = $keyword_course;
		}
		else{
			$data['keyword_course'] = "";
		}
		if($keyword_class)
		{
			$where[] = array( TRUE, 'te.class_id', $keyword_class);
			$data['keyword_class'] = $keyword_class;
		}
		else{
			$data['keyword_class'] = "";
		}
		if($keyword_subject)
		{
			$where[] = array( TRUE, 'te.subject_id', $keyword_subject);
			$data['keyword_subject'] = $keyword_subject;
		}
		else{
			$data['keyword_subject'] = "";
		}
		if($keyword_name)
		{
			$where[] = array( FALSE,"(u.first_name LIKE '%$keyword_name%' or u.email LIKE '%$keyword_name%' or concat (u.first_name,' ',u.last_name) LIKE '%$keyword_name%')");
			 
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}
		
		if($keyword_from_date){
			if($keyword_to_date){
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "te.start_date >=",$from_date);
				$where[] = array( TRUE, "te.start_date <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;		
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_from_date." 23:59:59";
				$where[] = array( TRUE, "te.start_date >=",$from_date);
				$where[] = array( TRUE, "te.start_date <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;			
				$data['keyword_to_date'] = "";		
			}
			
		}
		else{
			if($keyword_to_date){				
				$from_date = $keyword_to_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "te.start_date >=",$from_date);
				$where[] = array( TRUE, "te.start_date <=",$to_date);
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$data['keyword_to_date'] = "";
			}
			$data['keyword_from_date'] = "";
		}
		
		$fields = 'te.user_id as id,st.test_name,u.first_name,u.last_name,u.email,u.created,SUM(td.is_correct) as accuracy,COUNT(DISTINCT(te.id)) as progress_count,COUNT(td.question_id) as questions,SUM(DISTINCT(TIMESTAMPDIFF(MINUTE,te.start_date,te.end_date))) as minutes'; 
		$join_tables[] = array('surprise_test as st','st.id = te.surprise_test_id',"");
		$join_tables[] = array('users as u','u.id = te.user_id',"");
		$join_tables[] = array("test_details as td","td.test_id=te.id","");
		$join_tables[] = array('courses as co','co.id = te.course_id',"left");
		$where[] = array( TRUE, 'te.status', 1);
		$where[] = array( TRUE, 'td.status', 1);
		$where[] = array( TRUE,"te.test_type","2");
		$where[] = array( TRUE,"te.result","1");
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('test_engagement as te', $join_tables, $fields, $where, 'num_rows','','','te.user_id');
		$data['performance_reports'] = $this->base_model->get_advance_list('test_engagement as te', $join_tables, $fields, $where, '', 'te.id', 'desc', 'te.user_id', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data['get_course'] = $this->base_model->getSelectList('courses');
		$data['get_class'] = $this->base_model->getSelectList('classes');
		$data['get_subject'] = $this->base_model->getSelectList('subjects');
		$data['main_content'] = 'performance_reports/index';
		$data['page_title']  = 'User Performance Reports';
		// echo "<pre>";print_r($data);die; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_class');	
		$this->session->unset_userdata('search_course');
		$this->session->unset_userdata('search_subject');
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/performance_reports/');
	}
	
	public function view($id = NULL)
	{
		$join_tables = array();
		$where = array();
		$join_tables[] = array('users as u','u.id = te.user_id',"");
		$join_tables[] = array("test_details as td","td.test_id=te.id","");
		$join_tables[] = array('courses as co','co.id = te.course_id',"left");
		$fields = 'te.id,u.first_name,u.last_name,u.email,u.created,SUM(td.is_correct) as accuracy,COUNT(DISTINCT(te.id)) as progress_count,COUNT(td.question_id) as questions,SUM(DISTINCT(TIMESTAMPDIFF(MINUTE,te.start_date,te.end_date))) as minutes';  
		$where[] = array( TRUE, 'te.user_id', $id);
		$where[] = array( TRUE, 'te.status', 1);
		$where[] = array( TRUE, 'td.status', 1);
		$where[] = array( TRUE, 'co.course_type', 2);
		$where[] = array( TRUE,"te.test_type","2");
		$where[] = array( TRUE,"te.result","1");
		$data['performance_reports'] = $this->base_model->get_advance_list('test_engagement as te', $join_tables, $fields, $where,'row_array','','','te.user_id','','');
		
		$total_questions = $this->users_model->get_total_questions($id);
		$total_progress = $this->users_model->get_total_progress($id);
		$data['total_questions'] = $total_questions['total_questions'];
		$data['total_progress'] = $total_progress;
		
		if($data['performance_reports']['minutes'] > 60){
			$hours = $data['performance_reports']['minutes']/60;
		}else{
			$hours = 1;
		}
		$speed = $data['performance_reports']['questions']/$hours;
		$data['speed']= round($speed);
		
		$data['main_content'] = 'performance_reports/view';
	  	$data['page_title']  = 'User Reports';  
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	
	public function export()
	{
		$header ="";
		$keyword_course = $this->session->userdata('search_course');
		
		$join_tables = array();
		$where = array();
		if($keyword_course!="")
		{					
			$where[] = array( TRUE, 'co.id', $keyword_course);
			$data['keyword_course'] = $keyword_course;
		}
		else{
			$data['keyword_course'] = "";
		}
		
		$keyword_name = $this->session->userdata('search_name');
		if($keyword_name)
		{
			$where[] = array( FALSE,"(u.first_name LIKE '%$keyword_name%' or u.email LIKE '%$keyword_name%' or concat (u.first_name,' ',u.last_name) LIKE '%$keyword_name%' or up.price LIKE '%$keyword_name%')");
			 
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}		
		$keyword_from_date = $this->session->userdata('search_from_date');
		$keyword_to_date = $this->session->userdata('search_to_date');
		if($keyword_from_date){
			if($keyword_to_date){
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "te.start_date >=",$from_date);
				$where[] = array( TRUE, "te.start_date <=",$to_date);				
				$data['keyword_from_date'] = $keyword_from_date;		
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_from_date." 23:59:59";
				$where[] = array( TRUE, "te.start_date >=",$from_date);
				$where[] = array( TRUE, "te.start_date <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;			
				$data['keyword_to_date'] = "";		
			}
	
		}
		else{
			if($keyword_to_date){				
				$from_date = $keyword_to_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "te.start_date >=",$from_date);
				$where[] = array( TRUE, "te.start_date <=",$to_date);
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$data['keyword_to_date'] = "";
			}
			$data['keyword_from_date'] = "";
		}			
		
		$fields = 'te.user_id as id,te.surprise_test_id,concat(u.first_name," ",u.last_name) as user_name,u.email,u.created,SUM(td.is_correct) as accuracy,COUNT(DISTINCT(te.id)) as progress_count,COUNT(td.question_id) as questions,SUM(DISTINCT(TIMESTAMPDIFF(MINUTE,te.start_date,te.end_date))) as minutes'; 
		$join_tables[] = array('users as u','u.id = te.user_id',"");
		$join_tables[] = array("test_details as td","td.test_id=te.id","");
		$join_tables[] = array('courses as co','co.id = te.course_id',"left");
		$where[] = array( TRUE, 'te.status', 1);
		$where[] = array( TRUE, 'td.status', 1);
		$where[] = array( TRUE,"te.test_type","2");
		$where[] = array( TRUE,"te.result","1");
		$performance_reports = $this->base_model->get_advance_list('test_engagement as te', $join_tables, $fields, $where, '', 'te.id', 'desc', 'te.user_id', '', '');
		
		$header_arr = array('User Name','Questions','Accuracy','Speed','Progress');

		foreach($header_arr as $head_title){
			$header .=  $head_title. "\t";    
		}
		$data_exp = "";
		foreach($performance_reports as $i=>$row)
		{
			if($row['minutes'] > 60){
			$hours = $row['minutes']/60;
			}else{
				$hours = 1;
			}
			$speed = $row['questions']/$hours;
			$total_speed = round($speed);
			$line = '';
	
			$single_row = array($row['user_name'],$row['questions'],
								$row['accuracy'],$total_speed,
				                $row['progress_count']);
		
			foreach( $single_row as $k=>$value ){
				if ( ( !isset( $value ) ) || ( $value == "" ) ){
				    $value = "0"."\t";
				}else{
				    $value1 = str_replace( '"' , '""' , $value );
				    $value = '"' . $value1 . '"' . "\t";
				}
				$line .= $value;
			}
			$data_exp .= trim( $line ) . "\n";
		}
		$data_exp = str_replace( "\r" , "" , $data_exp );

		if ( $data_exp == "" ){
			$data_exp = "\n(0) Records Found!\n";                        
		}

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=e4u-PerformanceReports.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$data_exp";
		exit;
	}
}
