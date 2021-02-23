<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_privileges extends Admin_Controller
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
		$config["base_url"] = base_url().SITE_ADMIN_URI."/user_privileges/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = array();
		$where = array();
		
		if($keyword_name)
		{
			$where[] = array( FALSE,"(username LIKE '%$keyword_name%' or email LIKE '%$keyword_name%' or display_name LIKE '%$keyword_name%')");
			 
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}
		$fields = 'id,username,display_name,email,address,phone_number,status,created'; 	
		$where[] = array('FALSE','id != 1');		  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('admin_users', $join_tables, $fields, $where, 'num_rows','','','id');
		$data['users'] = $this->base_model->get_advance_list('admin_users', '', $fields, $where, '', 'id', 'desc', 'id', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data['main_content'] = 'user_privileges/index';
		$data['page_title']  = 'User Privileges'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/user_privileges/');
	}
	public function validate_select($val, $fieldname){
		if($val==""){
			$this->form_validation->set_message('validate_select', 'Please choose atleast one '.$fieldname.'.');
			return FALSE;
		}			
	}	
	public function add()
	{
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_message('regex_match','Please enter only alphabets and spaces.');
			$this->form_validation->set_rules('uname', 'User Name','trim|required|alpha_numeric|is_unique[admin_users.username]');
			$this->form_validation->set_rules('dname', 'Display Name','trim|required|regex_match[/^[a-zA-Z ]*$/]');
			$this->form_validation->set_rules('password', 'Password','trim|required|min_length[6]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password','trim|required|matches[password]|min_length[6]');
			$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[admin_users.email]|is_unique[users.email]');	
			$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[6]|regex_match[/^(?=.*[0-9])[- +0-9]+$/]');			
			$this->form_validation->set_rules('address', 'Address', 'trim|required'); 
			
			$privileges = implode(',',$this->input->post('main_all[]'));
			
			if(count($privileges) == 0)
			{
				$this->form_validation->set_rules('checkbox_error', 'privileges', 'callback_validate_select[privileges]');
			}
			
			if ($this->form_validation->run())
			{   
				
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'username' => $this->input->post('uname'),
										'email' => $this->input->post('email'),
										'password' => md5($this->input->post('password')),
										'display_name' => $this->input->post('dname'),
										'address' => $this->input->post('address'),
										'phone_number' => $this->input->post('phone'),
										'privileges' => $privileges,
										'status' => $this->input->post('status'),
										'created' => $date
									  );
				$this->base_model->insert( 'admin_users', $update_array);
				
				/* Send email to user */
				$user_email = $this->input->post('email');
				$user_name = $this->input->post('uname');
				$this->load->library('email');
				$email_config_data = array('[USERNAME]'=> $this->input->post('dname'), 
										   '[PASSWORD]' => $this->input->post('password'),
										   '[USER_NAME]' => $user_name,
										   '[SITE_NAME]' => $this->config->item('site_name'),
										   '[SITE_URL]'=>base_url()."admin/");				
				$cond = array();
				$cond[] = array(TRUE, 'id', 13 ); 
				$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');   
				foreach($email_config_data as $key => $value)
				{
					$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
				}							
				$this->email->from("noreply@e4u.com","e4u");
				$this->email->to($user_email);
				$this->email->subject($mailcontent['subject']);
				$this->email->message($mailcontent['email_content']);
				$result= $this->email->send();
				$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				redirect(base_url().SITE_ADMIN_URI.'/user_privileges/');
			}
			$data['post'] = TRUE;
		}
		$main_modules = $this->users_model->get_main_modules();
		$data['modules'] = $main_modules;
		foreach($main_modules as $key=>$val)
		{
			$sub_modules[] = $this->users_model->get_sub_modules($val['id']);
		}
		$data['sub_modules'] = $sub_modules;
		$data['main_content'] = 'user_privileges/add';
		$data['page_title']  = 'User Privileges'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	
	public function edit($id = NULL)
	{
		if($id==1){
			redirect(base_url()."admin/user_privileges/");
		}
		$data['post'] = FALSE;
		$join_tables = $where = array(); 
		$where1[] = array( TRUE, 'id', $id); 
		$fields = 'email,username'; 
		$getValues = $this->base_model->get_advance_list('admin_users', $join_tables, $fields, $where1, 'row_array');
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_message('regex_match','Please enter only alphabets and spaces.');
			$this->form_validation->set_rules('uname', 'User Name','trim|required|alpha_numeric');
			$this->form_validation->set_rules('dname', 'Display Name','trim|required|regex_match[/^[a-zA-Z ]*$/]');
			$this->form_validation->set_rules('password', 'Password','trim|min_length[6]');
			if($this->input->post('password') != ""){
			$this->form_validation->set_rules('confirm_password', 'Confirm Password','trim|required|matches[password]|min_length[6]');}
			$this->form_validation->set_rules('email', 'Email ID','trim|required|valid_email');
			if($this->input->post('email') != $getValues['email']) {
				$is_unique =  '|is_unique[admin_users.email]|is_unique[users.email]' ;
				} else {
					$is_unique =  '' ;
				}
			$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email'.$is_unique);
				// username
			 
			if($this->input->post('uname') != $getValues['username']) {
				$is_unique =  '|is_unique[admin_users.username]' ;
				} else {
					$is_unique =  '' ;
				}
				$this->form_validation->set_rules('uname', 'User Name','trim|required|alpha_numeric'.$is_unique);
			
			$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|min_length[6]|regex_match[/^(?=.*[0-9])[- +0-9]+$/]');
			$this->form_validation->set_rules('address', 'Address', 'trim|required');	
			$privileges = implode(',',$this->input->post('main_all[]'));
			if(count($privileges) == 0)
			{
				$this->form_validation->set_rules('checkbox_error', 'privileges', 'callback_validate_select[privileges]');
			}
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'username' => $this->input->post('uname'),
										'display_name' => $this->input->post('dname'),
										'email' => $this->input->post('email'),
										'address' => $this->input->post('address'),
										'phone_number' => $this->input->post('phone'),
										'privileges' => $privileges,
										'status' => $this->input->post('status'),
										'modified' => $date
									  );
				if($this->input->post('password') != "")
				{
					$update_arr = array('password' => md5($this->input->post('password')));
					$this->base_model->update ( 'admin_users', $update_arr, array('id'=>$id));
					
					/* Send email to user */
					$user_email = $this->input->post('email');
					$user_name = $this->input->post('uname');
					$this->load->library('email');
					$email_config_data = array('[USERNAME]'=> $this->input->post('dname'), 
											   '[PASSWORD]' => $this->input->post('password'),
											   '[USER_NAME]' => $user_name,
											   '[SITE_NAME]' => $this->config->item('site_name'),
											   '[SITE_URL]'=>base_url()."admin/");				
					$cond = array();
					$cond[] = array(TRUE, 'id', 15 ); 
					$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');   
					foreach($email_config_data as $key => $value)
					{
						$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
					}							
					$this->email->from("noreply@e4u.com","e4u");
					$this->email->to($user_email);
					$this->email->subject($mailcontent['subject']);
					$this->email->message($mailcontent['email_content']);
					$result= $this->email->send();
				}
				$this->base_model->update ( 'admin_users', $update_array, array('id'=>$id));
				$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
				redirect(base_url().SITE_ADMIN_URI.'/user_privileges/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  
		$fields = 'id, username,display_name,email,address,phone_number,privileges,status'; 
		$where[] = array( TRUE, 'id', $id);
		$data['users'] = $this->base_model->get_advance_list('admin_users', $join_tables, $fields, $where, 'row_array');
		$main_modules = $this->users_model->get_main_modules();
		$data['modules'] = $main_modules;
		foreach($main_modules as $key=>$val)
		{
			$sub_modules[] = $this->users_model->get_sub_modules($val['id']);
		}
		$data['sub_modules'] = $sub_modules;
		$data['main_content'] = 'user_privileges/edit';
		$data['page_title']  = 'User Privileges'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{		
		$table_name = 'admin_users';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/user_privileges/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function delete($id,$pageredirect=null,$pageno)
	{
		$table_name = 'admin_users';
		delete_record($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/user_privileges/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
				$this->base_model->update_status($id, $data,'admin_users');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) 
			{
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data,'admin_users');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('admin_users', array('id' => $id));
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/user_privileges/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/user_privileges/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
