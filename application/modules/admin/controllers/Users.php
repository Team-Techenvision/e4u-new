<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller
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
		$this->load->model('users_model'); 
	}
	public function index($page_num = 1)
	{  
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
		$config["base_url"] = base_url().SITE_ADMIN_URI."/users/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = array();
		$where = array();
		
		if($keyword_class)
		{
			$where[] = array( TRUE, 'class_id', $keyword_class);
			$data['keyword_class'] = $keyword_class;
		}
		else{
			$data['keyword_class'] = "";
		}
		
		if($keyword_name)
		{
			$where[] = array( FALSE,"(first_name LIKE '%$keyword_name%' or email LIKE '%$keyword_name%' or concat (first_name,' ',last_name) LIKE '%$keyword_name%')");
			 
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}
		$fields = 'id,first_name,last_name,email,class_id,address,phone,status,created'; 			  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('users', $join_tables, $fields, $where, 'num_rows','','','id');
		$data['users'] = $this->base_model->get_advance_list('users', '', $fields, $where, '', 'id', 'desc', 'id', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data['get_class'] = $this->base_model->getSelectList('classes');		//get all classes
		$data['main_content'] = 'users/index';
		$data['page_title']  = 'Users'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_class');	
		$this->session->unset_userdata('search_name');
		$this->session->unset_userdata('search_medium');
		$this->session->unset_userdata('search_board');
		redirect(base_url().SITE_ADMIN_URI.'/users/');
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
			$this->form_validation->set_rules('fname', 'First Name','trim|required');
			$this->form_validation->set_rules('lname', 'Last Name','trim|required');
			$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[users.email]|is_unique[admin_users.email]');	
			$this->form_validation->set_rules('class_studying_id', 'Class Studying','trim|callback_validate_select[Class Studying]');						
			$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[10]|regex_match[/^(?=.*[0-9])[- +0-9]+$/]');			
			$this->form_validation->set_rules('address', 'Address', 'trim|required'); 				
			$this->form_validation->set_rules('dob_date', 'Date', 'trim|required'); 				
			$this->form_validation->set_rules('dob_month', 'Month', 'trim|required'); 				
			$this->form_validation->set_rules('dob_year', 'Year', 'trim|required'); 				
			if ($this->form_validation->run())
			{   
				$pass = random_password(8);
				$pass_store = md5($pass);
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'first_name' => $this->input->post('fname'),
										'last_name' => $this->input->post('lname'),
										'email' => $this->input->post('email'),
										'password' => $pass_store,
										'class_id' => $this->input->post('class_studying_id'),
										'address' => $this->input->post('address'),
										'phone' => $this->input->post('phone'),
										'dob_date' => $this->input->post('dob_date'),
										'dob_month' => $this->input->post('dob_month'),
										'dob_year' => $this->input->post('dob_year'),
										'gender' =>	$this->input->post('gender'),
										'status' => $this->input->post('status'),
										'created' => $date
									  );
				$this->base_model->insert( 'users', $update_array);
				
				/* Send email to user */
				$user_email = $this->input->post('email');
				$user_name = $this->input->post('fname')." ".$this->input->post('lname');
				$this->load->library('email');

				//added start
					$smtp_mail = $this->config->item('smtp_mail');
					$this->email->initialize($smtp_mail);
				//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");


				$email_config_data = array('[USERNAME]'=> $user_name, 
										   '[PASSWORD]' => $pass,
										   '[USER_EMAIL]' => $user_email,
										   '[SITE_NAME]' => $this->config->item('site_name'),
										   '[SITE_URL]'=>base_url());				
				$cond = array();
				$cond[] = array(TRUE, 'id', 2 ); 
				$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');   
				foreach($email_config_data as $key => $value)
				{
					$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
				}
				// print_r($mailcontent['email_content']);die;							
				$this->email->from($smtp_mail['smtp_user'],"E4U");
				$this->email->to($user_email);
				$this->email->subject($mailcontent['subject']);
				$this->email->message($mailcontent['email_content']);
				$result= $this->email->send();
				$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				redirect(base_url().SITE_ADMIN_URI.'/users/');
			}
			$data['post'] = TRUE;
		}
		$data['get_class'] = $this->base_model->getSelectList('classes');		
		$data['main_content'] = 'users/add';
		$data['page_title']  = 'Users'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	
	public function edit($id = NULL)
	{
		$data['post'] = FALSE;
		$join_tables = $where = array(); 
		$where1[] = array( TRUE, 'id', $id);
		$fields = 'email'; 
		$getValues = $this->base_model->get_advance_list('users', $join_tables, $fields, $where1, 'row_array');
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_rules('fname', 'First Name','trim|required');
			$this->form_validation->set_rules('lname', 'Last Name','trim|required');
			$this->form_validation->set_rules('email', 'Email ID','trim|required|valid_email');
			if($this->input->post('email') != $getValues['email']) {
				$is_unique =  '|is_unique[users.email]|is_unique[admin_users.email]' ;
				} else {
					$is_unique =  '' ;
				}
				$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email'.$is_unique);
			$this->form_validation->set_rules('class_studying_id', 'Class Studying','trim|callback_validate_select[Class Studying]');
			// $this->form_validation->set_rules('medium', 'Medium','trim|callback_validate_select[Medium]');					
			// $this->form_validation->set_rules('board', 'Study Board','trim|callback_validate_select[Study Board]');					
			$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[10]|regex_match[/^(?=.*[0-9])[- +0-9]+$/]');
			$this->form_validation->set_rules('address', 'Address', 'trim|required');		
			$this->form_validation->set_rules('dob_date', 'Date', 'trim|required'); 				
			$this->form_validation->set_rules('dob_month', 'Month', 'trim|required'); 				
			$this->form_validation->set_rules('dob_year', 'Year', 'trim|required'); 

			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'first_name' => $this->input->post('fname'),
										'last_name' => $this->input->post('lname'),
										'email' => $this->input->post('email'),
										'class_id' => $this->input->post('class_studying_id'),
										'address' => $this->input->post('address'),
										'phone' => $this->input->post('phone'),
										'dob_date' => $this->input->post('dob_date'),
										'dob_month' => $this->input->post('dob_month'),
										'dob_year' => $this->input->post('dob_year'),
										'gender' =>	$this->input->post('gender'),
										'status' => $this->input->post('status'),
										'modified' => $date
									  );
				$this->base_model->update ( 'users', $update_array, array('id'=>$id));
				$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
				redirect(base_url().SITE_ADMIN_URI.'/users/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  
		$fields = 'id, first_name,last_name,class_id,email,address,gender,phone,dob_date,dob_month,dob_year,status'; 
		$where[] = array( TRUE, 'id', $id);
		$data['users'] = $this->base_model->get_advance_list('users', $join_tables, $fields, $where, 'row_array');
		$data['get_class'] = $this->base_model->getSelectList('classes');
		$data['main_content'] = 'users/edit';
		$data['page_title']  = 'users'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{		
		$table_name = 'users';
		change_status($table_name,$id,$status,$pageredirect,$pageno,1);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function delete($id,$pageredirect=null,$pageno)
	{
		$table_name = 'users';
		delete_record($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno)
	{
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1)
		{
			foreach($bulk_ids as $id)
			{
				$data = array('status' => '1');
				$this->users_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) 
			{
				$data = array('status' => '0');
				$this->users_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('users', array('id' => $id));
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
