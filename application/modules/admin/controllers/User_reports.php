<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_reports extends Admin_Controller
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
		$this->load->helper('thumb_helper');
		$this->load->helper('html');
		$this->load->library('excel');
		$this->load->model(array('base_model','users_model','dashboard/dashboard_model')); 
	}
	public function index($page_num = 1)
	{  



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
		$search_medium_keyword  = isset($_POST['search_medium'])?trim($_POST['search_medium']):(isset($_SESSION['search_medium'])?$_SESSION['search_medium']:'');
		$this->session->set_userdata('search_medium', $search_medium_keyword); 
		$keyword_medium_session = $this->session->userdata('search_medium');
		if($keyword_medium_session != '')
		{
			$keyword_medium = $this->session->userdata('search_medium');
		}
		else{
			isset($_SESSION['search_medium'])?$this->session->unset_userdata('search_medium'):'';
			$keyword_medium = "";
		}
		$search_class_keyword  = isset($_POST['search_class'])?trim($_POST['search_class']):(isset($_SESSION['search_class'])?$_SESSION['search_class']:'');
		$this->session->set_userdata('search_class', $search_class_keyword);		
		$keyword_class_session = $this->session->userdata('search_class');
		if($keyword_class_session != '')
		{
			$keyword_class = $this->session->userdata('search_class');
		}
		else{
			isset($_SESSION['search_class'])?$this->session->unset_userdata('search_class'):'';
			$keyword_class = "";
		}
		$search_board_keyword  = isset($_POST['search_board'])?trim($_POST['search_board']):(isset($_SESSION['search_board'])?$_SESSION['search_board']:'');
		$this->session->set_userdata('search_board', $search_board_keyword);		
		$keyword_board_session = $this->session->userdata('search_board');
		if($keyword_board_session != '')
		{
			$keyword_board = $this->session->userdata('search_board');
		}
		else{
			isset($_SESSION['search_board'])?$this->session->unset_userdata('search_board'):'';
			$keyword_board = "";
		}
		   $user_status_rec  =  ($this->input->post('user_status')==""?$this->input->get('user_status'):$this->input->post('user_status')); 
		if($user_status_rec!=""){
		 
		  $this->session->set_userdata('user_status',$user_status_rec);
		}
		$user_status = $this->session->userdata('user_status');
		 
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
		$config["base_url"] = base_url().SITE_ADMIN_URI."/user_reports/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
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
		if($keyword_medium)
		{
			$where[] = array( TRUE, 'u.medium_id', $keyword_medium);
			$data['keyword_medium'] = $keyword_medium;
		}
		else{
			$data['keyword_medium'] = "";
		}
		if($keyword_class)
		{
			$where[] = array( TRUE, 'u.class_id', $keyword_class);
			$data['keyword_class'] = $keyword_class;
		}
		else{
			$data['keyword_class'] = "";
		}
		if($keyword_board)
		{
			$where[] = array( TRUE, 'u.board', $keyword_board);
			$data['keyword_board'] = $keyword_board;
		}
		else{
			$data['keyword_board'] = "";
		}
		if($user_status)
		{
			$data['status'] = $user_status;
			if($user_status==2){
				$user_status=0;
			}
		 
			$where[] = array( TRUE, 'u.status', $user_status);
			
		}
		else{
			$data['status'] = "";
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
				$where[] = array( TRUE, "u.created >=",$from_date);
				$where[] = array( TRUE, "u.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;		
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_from_date." 23:59:59";
				$where[] = array( TRUE, "u.created >=",$from_date);
				$where[] = array( TRUE, "u.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;			
				$data['keyword_to_date'] = "";		
			}
			
		}
		else{
			if($keyword_to_date){				
				$from_date = $keyword_to_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "u.created >=",$from_date);
				$where[] = array( TRUE, "u.created <=",$to_date);
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$data['keyword_to_date'] = "";
			}
			$data['keyword_from_date'] = "";
		}

		/*data coming from dashboard*/	
		$today_date=$this->input->get("date");#for current date only
		if($today_date!=""){
			$_SESSION["search_from_date"]=$today_date; 
			$data['keyword_from_date'] = $today_date;
		}	 
		if($today_date){
			$today=$today_date.' 00:00:00';
			$today_end=$today_date.' 23:59:59';
			$where[] = array( TRUE, 'u.created >=', $today);  
			$where[] = array( TRUE, 'u.created <=', $today_end);  
		}	


		$fields = 'u.id,u.first_name,u.last_name,u.email,u.class_id,u.address,u.phone,u.status,u.created'; 
		$join_tables[] = array('user_plans as up','up.user_id = u.id');	
		$join_tables[] = array('courses as co','co.id = up.course_id');	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where, 'num_rows','','','u.id');
		$data['user_reports'] = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where, '', 'u.id', 'desc', 'u.id', $limit_start, $limit_end);
		
		foreach($data['user_reports'] as $key=>$value)
		{
			$paid_course = $this->dashboard_model->get_paid_course($value['id']);
			$levels_completed = $this->users_model->get_levels_completed($value['id']);
			$doc_uploaded = $this->users_model->get_documents_count($value['id']);
			// print_r($paid_course);
			// foreach($paid_course as $key=>$ret)
			// {
				$course_name[$value['id']][] = $paid_course['name'];
			// }

			$data['imp_course'][$value['id']] = implode(",",$course_name[$value['id']]);
			unset($course_name[""]);
			// $data['l_count'][$value['id']] = $levels_completed;
			// $data['d_count'][$value['id']] = $doc_uploaded;
			 
		}
		
		$this->pagination->initialize($config);
		$data['get_course'] = $this->base_model->getSelectList('courses');
		$data['get_class'] = $this->base_model->getSelectList('classes');		//get all classes
		// $data['get_medium'] = $this->base_model->getSelectList('medium');		//get all mediums
		// $data['get_board'] = $this->base_model->getSelectList('study_board');  	//get all boards
		$data['main_content'] = 'user_reports/index';
		$data['page_title']  = 'User Reports'; 
		// echo "<pre>";print_r($data);die;
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_class');	
		$this->session->unset_userdata('search_course');
		$this->session->unset_userdata('search_name');
		$this->session->unset_userdata('search_medium');
		$this->session->unset_userdata('search_board');
		$this->session->unset_userdata('user_status');
		$this->session->unset_userdata('search_from_date');
		$this->session->unset_userdata('search_to_date');
		redirect(base_url().SITE_ADMIN_URI.'/user_reports/');
	}
	
	public function view($id = NULL)
	{
		$join_tables = array();
		$where = array();
		$join_tables[] = array('user_plans as up','up.user_id = u.id');
		$join_tables[] = array('courses as co','up.course_id = co.id');
		$join_tables[] = array("test_engagement te","te.user_id=u.id");
		$join_tables[] = array("classes cl","cl.id=u.class_id");
		// $join_tables[] = array("study_board sb","sb.id=u.board");
		// $join_tables[] = array("medium m","m.id=u.medium_id");
		$join_tables[] = array("test_details td","td.test_id=te.id");

		$fields = 'u.id, concat(u.first_name," ",u.last_name) as user_name,u.email,co.name as course_name,cl.name as class_name,u.phone,u.address,
		u.gender,u.created,COUNT(DISTINCT(te.id)) as progress_count,u.last_login_time,u.status,u.profile_image'; 
		$where[] = array( TRUE, 'u.id', $id);
		// $where[] = array( TRUE, 'te.test_type', 1);
		// $where[] = array( TRUE, 'te.result', 1);
		// $where[] = array( TRUE, 'te.status', 1);
		$data['user_reports'] = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where,'row_array');
		// echo $this->db->last_query();die;
		$paid_courses = $this->dashboard_model->get_paid_course($id);
		foreach($paid_courses as $key=>$value)
		{
			$ret[] = $value['name'];
		}
		$data['course_name'] = implode(',',$ret);
		
		$data['main_content'] = 'user_reports/view';
	  	$data['page_title']  = 'User Reports';  

	  	// echo "<pre>";print_r($data);die;
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
		$keyword_medium = $this->session->userdata('search_medium');
		if($keyword_medium)
		{
			$where[] = array( TRUE, 'u.medium_id', $keyword_medium);
			$data['keyword_medium'] = $keyword_medium;
		}
		else{
			$data['keyword_medium'] = "";
		}
		$keyword_class = $this->session->userdata('search_class');
		if($keyword_class)
		{
			$where[] = array( TRUE, 'u.class_id', $keyword_class);
			$data['keyword_class'] = $keyword_class;
		}
		else{
			$data['keyword_class'] = "";
		}
		$keyword_board = $this->session->userdata('search_board');
		if($keyword_board)
		{
			$where[] = array( TRUE, 'u.board', $keyword_board);
			$data['keyword_board'] = $keyword_board;
		}
		else{
			$data['keyword_board'] = "";
		}
		$user_status = $this->session->userdata('user_status');
		if($user_status)
		{
			$data['status'] = $user_status;
			if($user_status==2){
				$user_status=0;
			}
		 
			$where[] = array( TRUE, 'u.status', $user_status);
	
		}
		else{
			$data['status'] = "";
		}
		$keyword_name = $this->session->userdata('search_name');
		if($keyword_name)
		{
			$where[] = array( FALSE,"(u.first_name LIKE '%$keyword_name%' or u.email LIKE '%$keyword_name%' or concat (u.first_name,' ',u.last_name) LIKE '%$keyword_name%')");
			 
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
				$where[] = array( TRUE, "u.created >=",$from_date);
				$where[] = array( TRUE, "u.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;		
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_from_date." 23:59:59";
				$where[] = array( TRUE, "u.created >=",$from_date);
				$where[] = array( TRUE, "u.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;			
				$data['keyword_to_date'] = "";		
			}
	
		}
		else{
			if($keyword_to_date){				
				$from_date = $keyword_to_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "u.created >=",$from_date);
				$where[] = array( TRUE, "u.created <=",$to_date);
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$data['keyword_to_date'] = "";
			}
			$data['keyword_from_date'] = "";
		}
		$fields = 'u.id,concat(u.first_name," ",u.last_name) as user_name,u.email,u.class_id,u.status,u.created,u.phone'; 
		$join_tables[] = array('user_plans as up','up.user_id = u.id');	
		$join_tables[] = array('courses as co','co.id = up.course_id');	
		$data['user_reports'] = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where, '', 'u.id', 'desc', 'u.id', '', '');
		
		$header_arr = array('User Name','Email ID','Contact Number','Course Plan','Created Date');

		foreach($header_arr as $head_title){
			$header .=  $head_title. "\t";    
		}
		$data_exp = "";
		foreach($data['user_reports'] as $i=>$row)
		{
			$paid_course = $this->dashboard_model->get_paid_course($row['id']);
			$levels_completed = $this->users_model->get_levels_completed($row['id']);
			$doc_uploaded = $this->users_model->get_documents_count($row['id']);
			// foreach($paid_course as $key=>$ret)
			// {
				$course_name[$row['id']][] = $paid_course['name'];
			// }
			$imp_course[$row['id']] = implode(",",$course_name[$row['id']]);
			unset($course_name[""]);
			$l_count[$row['id']] = $levels_completed;
			$d_count[$row['id']] = $doc_uploaded;

			$line = '';
			$course_plan = isset($imp_course[$row['id']])?$imp_course[$row['id']]:'N/A';
			
			$single_row = array($row['user_name'],$row['email'],$row['phone'],$course_plan,date('Y-m-d',strtotime($row['created'])));
		

			foreach( $single_row as $k=>$value ){
				if ( ( !isset( $value ) ) || ( $value == "" ) ){
				    $value = "0"."\t";
				}else{

				    $value = str_replace( '"' , '""' , $value );
				    $value = '"' . $value . '"' . "\t";
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
		header("Content-Disposition: attachment; filename=e4u-UserReports.xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		print "$header\n$data_exp";
		exit;
	}
	
}
