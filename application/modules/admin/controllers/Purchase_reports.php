<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_reports extends Admin_Controller
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
		
		$search_currency_keyword  = isset($_POST['search_currency'])?trim($_POST['search_currency']):(isset($_SESSION['search_currency'])?$_SESSION['search_currency']:'');
		$this->session->set_userdata('search_currency', $search_currency_keyword); 										
		$keyword_currency_session = $this->session->userdata('search_currency');
		if($keyword_currency_session != '')
		{					
			$keyword_currency = $this->session->userdata('search_currency');
		}
		else
		{
			isset($_SESSION['search_currency'])?$this->session->unset_userdata('search_currency'):'';
			$keyword_currency = "";
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
		$config["base_url"] = base_url().SITE_ADMIN_URI."/purchase_reports/index";
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
		if($keyword_currency!="")
		{					
			$where[] = array( TRUE, 'o.currency_type', $keyword_currency);
			$data['keyword_currency'] = $keyword_currency;
		}
		else{
			$data['keyword_currency'] = "";
		}
		if($keyword_name)
		{
			$where[] = array( FALSE,"(u.first_name LIKE '%$keyword_name%' or u.email LIKE '%$keyword_name%' or concat (u.first_name,' ',u.last_name) LIKE '%$keyword_name%' or up.price LIKE '%$keyword_name%')");
			 
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}		
		
		if($keyword_from_date){
			if($keyword_to_date){
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "o.created >=",$from_date);
				$where[] = array( TRUE, "o.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;		
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_from_date." 23:59:59";
				$where[] = array( TRUE, "o.created >=",$from_date);
				$where[] = array( TRUE, "o.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;			
				$data['keyword_to_date'] = "";		
			}
			
		}
		else{
			if($keyword_to_date){				
				$from_date = $keyword_to_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "o.created >=",$from_date);
				$where[] = array( TRUE, "o.created <=",$to_date);
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
			$where[] = array( TRUE, 'o.created >=', $today);  
			$where[] = array( TRUE, 'o.created <=', $today_end);  
		}	


		
		$fields = 'o.id,u.first_name,u.last_name,u.email,o.created as purchased_date,co.name as course_name,o.price, o.currency_type, up.course_expiry_date'; 
		$join_tables[] = array('user_plans as up','up.order_id = o.id');	
		$join_tables[] = array('courses as co','co.id = up.course_id');	
		$join_tables[] = array('users as u','u.id = up.user_id');
		$where[] = array( TRUE, 'o.order_status', 1);
		// $where[] = array( TRUE, 'up.course_type', 2);
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, 'num_rows','','','o.id');
		$data['purchase_reports'] = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, '', 'o.id', 'desc', 'o.id', $limit_start, $limit_end);
		$data['currency'] = $this->config->item('currency_symbol');
		$data['dollar_symbol'] = $this->config->item('dollar_symbol');
		$this->pagination->initialize($config);
		$data['get_course'] = $this->base_model->getSelectList('courses'); //get all courses
		$data['main_content'] = 'purchase_reports/index';
		$data['page_title']  = 'Purchase Reports'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_course');
		$this->session->unset_userdata('search_name');
		$this->session->unset_userdata('search_date');
		$this->session->unset_userdata('search_from_date');
		$this->session->unset_userdata('search_to_date');
		$this->session->unset_userdata('search_currency');
		redirect(base_url().SITE_ADMIN_URI.'/purchase_reports/');
	}
	
	public function view($id = NULL)
	{
		$join_tables = array();
		$where = array();
		$join_tables[] = array('user_plans as up','up.order_id = o.id');
		$join_tables[] = array('courses as co','co.id = up.course_id');
		$join_tables[] = array("users as u","u.id = up.user_id");
		$fields = 'u.id, concat(u.first_name," ",u.last_name) as user_name,u.email,co.name as course_name,o.created as purchased_date,o.price,o.currency_type,up.course_expiry_date'; 
		$where[] = array( TRUE, 'o.id', $id);
		$where[] = array( TRUE, 'o.order_status', 1);
		$data['purchase_reports'] = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where,'row_array');
		$data['currency'] = $this->config->item('currency_symbol');
		$data['dollar_symbol'] = $this->config->item('dollar_symbol');
		$data['main_content'] = 'purchase_reports/view';
	  	$data['page_title']  = 'Purchase Reports';  
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
		$keyword_currency = $this->session->userdata('search_currency');
		if($keyword_currency!="")
		{					
			$where[] = array( TRUE, 'o.currency_type', $keyword_currency);
			$data['keyword_currency'] = $keyword_currency;
		}
		else{
			$data['keyword_currency'] = "";
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
				$where[] = array( TRUE, "o.created >=",$from_date);
				$where[] = array( TRUE, "o.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;		
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_from_date." 23:59:59";
				$where[] = array( TRUE, "o.created >=",$from_date);
				$where[] = array( TRUE, "o.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;			
				$data['keyword_to_date'] = "";		
			}
	
		}
		else{
			if($keyword_to_date){				
				$from_date = $keyword_to_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "o.created >=",$from_date);
				$where[] = array( TRUE, "o.created <=",$to_date);
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$data['keyword_to_date'] = "";
			}
			$data['keyword_from_date'] = "";
		}
		$fields = 'o.id,concat(u.first_name," ",u.last_name) as user_name,u.email,o.created as purchased_date,co.name as course_name,o.price,o.currency_type,up.course_expiry_date'; 
		$join_tables[] = array('user_plans as up','up.order_id = o.id');	
		$join_tables[] = array('courses as co','co.id = up.course_id');	
		$join_tables[] = array('users as u','u.id = up.user_id');
		$where[] = array( TRUE, 'o.order_status', 1);
		// $where[] = array( TRUE, 'up.course_type', 2);
		$purchase_reports = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, '', 'o.id', 'desc', 'o.id', '', '');		
		$header_arr = array('Course Plan','User Name','Price','Purchased Date','Expiry Date');

		foreach($header_arr as $head_title){
			$header .=  $head_title. "\t";    
		}
		$data_exp = "";
		foreach($purchase_reports as $i=>$row)
		{
			$line = '';
	
			$single_row = array($row['course_name'],$row['user_name'],($row['currency_type']==1?"INR":"USD")." ".$row['price'],
								$row['purchased_date'],$row['course_expiry_date']);
		
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
		header("Content-Disposition: attachment; filename=e4u-PurchaseReports.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$data_exp";
		exit;
	}
}	
