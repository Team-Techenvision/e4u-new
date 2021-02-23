<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
    		$this->load->library(array('form_validation','csv_import'));
    		$this->load->library(array('form_validation'));
			$this->load->language(array('flash_message','form_validation'), 'english');
			$this->load->library('upload');	
			$this->load->library('email');
			$this->load->helper('thumb_helper');	
			if(!$this->session->has_userdata('admin_is_logged_in')){
					redirect(SITE_ADMIN_URI);
			}
			getSearchDetails($this->router->fetch_class());
			$this->load->model('base_model'); 
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
				
			$this->load->library('pagination');
			$config  = $this->config->item('pagination');
		  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/orders/index";
		 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		  	$config["uri_segment"] = 4;
		  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		  	$limit_start = $config['per_page'];
		  	$join_tables = $where = array(); 
			if($keyword_course!="")
			{					
				$where[] = array( TRUE, 'o.course_id', $keyword_course);
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
			/*if($keyword_from_date)
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
			}				*/
			
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
			
						
			// $course_type = 2;
		  	$fields = 'o.id, o.order_id, c.name as course_name, u.first_name,u.last_name, o.price, o.currency_type, o.payment_type, o.created, o.order_status,up.course_start_date,up.is_expired'; 
		  	$join_tables[] = array('courses as c','o.course_id = c.id');
		  	$join_tables[] = array('users as u','o.user_id = u.id');
		  	$join_tables[] = array('user_plans as up','up.order_id = o.id');
		  	// $where[] = array( TRUE, "c.course_type =",$course_type);
		  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, 'num_rows','','','o.id');
		  	$data['questions'] = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, '', 'o.id', 'desc', 'o.id', $limit_start, $limit_end);
	   	$this->pagination->initialize($config);
	   	$data['get_course'] = $this->base_model->getSelectList('courses');	
	   	$data['currency'] = $this->config->item('currency_symbol');	
   		$data['dollar_symbol'] = $this->config->item('dollar_symbol');	    
			$data['main_content'] = 'orders/index';
		  	$data['page_title']  = 'Orders'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		
		function update_status($o_id,$from=""){	
			$fields = 'user_id, order_status'; 		
			$where[] = array( TRUE, "id =",$o_id);
			$row_count = $this->base_model->get_advance_list('orders as o', '', $fields, $where, 'num_rows');
			if($row_count!=0){
			  	$status_details = $this->base_model->get_advance_list('orders as o', '', $fields, $where, 'row_array');			  							  	
			  	if($status_details['order_status']==2){
			  		$this->session->set_flashdata('flash_success_message', $this->lang->line('cancelled_order'));
			  		
			  		if($from == "1")
			  		{
			  			redirect(base_url().SITE_ADMIN_URI.'/offline_subscription');
			  		}else
			  		{
						redirect(base_url().SITE_ADMIN_URI.'/orders/');
					}		  		
				}else{
					array_pop($where);
					$id = $o_id;
				 	$order_status = 2;
					$update_array = array ("order_status"=>$order_status);
					$this->base_model->update( 'orders', $update_array, array('id'=>$o_id));					 
					
					$fields = 'u.id, u.first_name, u.email, o.order_status'; 
			  		$join_tables[] = array('users as u','o.user_id = u.id');
					$where[] = array( TRUE, "o.id =",$id);					 
				  	$user_details = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where);		 						  	
				  	
					// Sending mail to user
					$user_id = $user_details[0]['id'];
					$user_email = $user_details[0]['email'];
					$user_name = $user_details[0]['first_name'];
					$this->load->library('email');

					//added start
					$smtp_mail = $this->config->item('smtp_mail');
					$this->email->initialize($smtp_mail);
					//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");


					$email_config_data = array('[USERNAME]'=> $user_name, 										   
												'[USER_EMAIL]' => $user_email,
												'[SITE_NAME]' => $this->config->item('site_name'));
			
					$cond = array();
					$cond[] = array(TRUE, 'id', 5 ); 
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
				
					$this->session->set_flashdata('flash_success_message', $this->lang->line('cancel_order'));
					if($from == "1")
			  		{
			  			redirect(base_url().SITE_ADMIN_URI.'/offline_subscription');
			  		}else
			  		{
						redirect(base_url().SITE_ADMIN_URI.'/orders/');
					}
				}
			}else{
				$this->session->set_flashdata('flash_success_message', $this->lang->line('invalid_order'));
				redirect(base_url().SITE_ADMIN_URI.'/orders/');	
			}
		}
		public function view($id)
		{
			if(isset($_GET['from'])){
			$data['from'] = $_GET['from'];}
			if($this->input->server('REQUEST_METHOD')=== 'POST'){
				$o_id = $this->input->post('hidden'); //Its a primary key from orders table(Not an order_id from orders)
				$offline = $this->input->post('offline');
				$this->update_status($o_id,$offline);
			}else{
			$fields = 'o.id, o.order_id, c.name as course_name, u.first_name, u.last_name, o.price, o.currency_type, o.payment_type, o.created, o.order_status,up.course_start_date,up.course_expiry_date,up.is_expired'; 
		  	$join_tables[] = array('courses as c','o.course_id = c.id');
		  	$join_tables[] = array('users as u','o.user_id = u.id');
		  	$join_tables[] = array('user_plans as up','up.order_id = o.id');
		  	$where[] = array( TRUE, "o.id =",$id);			  				  	
		  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, 'num_rows','','','o.id');
		  	$data['orders'] = $this->base_model->get_advance_list('orders as o', $join_tables, $fields, $where, '', 'o.id', 'desc', 'o.id');
		  	$data['currency'] = $this->config->item('currency_symbol');
	  		$data['dollar_symbol'] = $this->config->item('dollar_symbol');	 
		  	$data['main_content'] = 'orders/view';
		  	$data['page_title']  = 'Orders'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data);}
		}
		
		public function cancel($id){
			$this->update_status($id);
		}	
		
		public function reset()
		{
			$this->session->unset_userdata('search_course');
			$this->session->unset_userdata('search_from_date');
			$this->session->unset_userdata('search_to_date');
			$this->session->unset_userdata('search_currency');
			redirect(base_url().SITE_ADMIN_URI.'/orders/');
		}	
	
		public function bulkactions($pageredirect=null,$pageno){		
			$fieldsorts = $this->input->get('sortingfied');			
			$typesorts = $this->input->get('sortype');
			$bulk_type= $this->input->post('more_action_id');
			$bulk_ids= $this->input->post('checkall_box');
			
			
			if($bulk_type == 1){
				foreach($bulk_ids as $id) {
					$update_array = array ("order_status"=>2);
					$this->base_model->update( 'orders', $update_array, array('id'=>$id));
				}
				$this->session->set_flashdata('flash_message', $this->lang->line('bulk_cancelled_order') );
			}
			else {
				$this->session->set_flashdata('flash_message', $this->lang->line('bulk_cancel_error'));
				redirect(base_url().SITE_ADMIN_URI.'/orders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
			}
			redirect(base_url().SITE_ADMIN_URI.'/orders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		
	}
