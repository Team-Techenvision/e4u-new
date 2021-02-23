<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Alerts extends Admin_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
    		$this->load->library(array('form_validation'));
    		$this->load->helper(array('function_helper'));
			$this->load->language(array('flash_message','form_validation'), 'english');
			if(!$this->session->has_userdata('admin_is_logged_in')){
					redirect(SITE_ADMIN_URI);
			}
			getSearchDetails($this->router->fetch_class());
			$this->load->model('base_model'); 
			$this->load->model('alert_model'); 

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
			$this->load->library('pagination');
			$config  = $this->config->item('pagination');
		  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/alerts/index";
		 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		  	$config["uri_segment"] = 4;
		  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		  	$limit_start = $config['per_page'];
		  	$join_tables = array();
		  	$where = array();  
		  	if($keyword_course)
			{
				$where[] = array( TRUE, 'a.course_id', $keyword_course);
				$data['keyword_course'] = $keyword_course;
			}
			else{
				$data['keyword_course'] = "";
			}
			if($keyword_name)
			{
				$where[] = array( TRUE, 'a.title LIKE ', '%'.$keyword_name.'%' );
				$data['keyword_name'] = $keyword_name;
			}
			else{
				$data['keyword_name'] = "";
			}
			$where[] = array( TRUE, 'a.added_by', 1);
		  	$fields = 'a.id, a.title alert_name,a.short_description,a.created, a.course_id, co.name course_name, a.status,o.user_name'; 
		  	$join_tables[] = array('courses as co','a.course_id = co.id');
		  	$join_tables[] = array('orders as o','a.user_id = o.user_id');
		  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('alerts as a', $join_tables, $fields, $where, 'num_rows','','','a.id');
		  	$data['alerts'] = $this->base_model->get_advance_list('alerts as a', $join_tables, $fields, $where, '', 'a.title', 'asc', 'a.id', $limit_start, $limit_end);
		   $data['get_course'] = $this->base_model->getSelectList('courses');			   
		   $this->pagination->initialize($config);
			$data['main_content'] = 'alerts/index';
		  	$data['page_title']  = 'Alerts'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function reset()
		{
			$this->session->unset_userdata('search_course');
			$this->session->unset_userdata('search_name');
			redirect(base_url().SITE_ADMIN_URI.'/alerts/');
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
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			
				$this->form_validation->set_rules('course_list', 'course list','callback_validate_select[Course]');
				$this->form_validation->set_rules('title', 'Title','required');
				$this->form_validation->set_rules('description', 'Short Description','required');			
					
				if ($this->form_validation->run()){ 
					$date = date('Y-m-d H:i:s');
					$user_list =$this->input->post('user_list');
					$config['upload_path'] = $this->config->item('alert_attachments');
                	$config['allowed_types'] = "pdf|doc|mp3|mp4|rar|docx|zip|swf"; 
                	$config['max_size'] = '2048';
                	$config['file_name'] = time();
                	$this->load->library('upload', $config);
                	$attachment_up = $this->upload->do_upload('attachment_alert');

					if (!$attachment_up && !empty($_FILES['attachment_alert']['size'] > 0))
        			{
				    	$upload = array('error' => $this->upload->display_errors(),
				    					'error1' => 'Please upload only .pdf,.doc,.docx,.mp3,.mp4,.swf,.rar or .zip files');
				   		$data['upload_error'] = $upload;
					}
					else
					{
						$attachment_data = array('upload_data' => $this->upload->data());	
						if($attachment_up!="")
						{
							$attach = $attachment_data['upload_data']['file_name'];
						}
						else
						{
							$attach = "";
						}	
						$update_array = array();
						$update_array = array ('title' => $this->input->post('title'), 
											   'short_description' => $this->input->post('description'), 
											   'attachment' => $attach,
											   'course_id' => $this->input->post('course_list'), 
											   'user_id' => 0,
											   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
											   'created' => $date,
											   'added_by' => 1
											   );
						$alertId = $this->base_model->insert('alerts', $update_array);
						$user_list_course=$this->alert_model->getUsers($this->input->post('course_list'));

						if(count($user_list)==0){
							foreach($user_list_course as $in_user_list){
								$user_list[]=$in_user_list["id"];
							}						
						}
						if(count($user_list)>0)
						{						
							foreach($user_list as $key=>$value)
							{
								$array = array();
								$array = array ('alert_id' => $alertId, 
												'user_id' => $value,
												'status' => 1
												);
								$insertId = $this->base_model->insert('alert_users',$array);
							}
						}
						$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
						redirect(base_url().SITE_ADMIN_URI.'/alerts/');
					}
				}
				$data['post'] = TRUE;
				$course_id = $this->input->post('course_list');
				if($course_id!=""){
					$user_list2 = $this->base_model->get_user_list($course_id);
					$data['user_list'] = array(""=>"Select");
			  		if($user_list2){
				  		foreach($user_list2 as $user){
				  			$data['user_list'][$user['id']] = ucfirst($user['first_name'])." ".ucfirst($user['last_name']);
				  		}				  		
			  		}			  		
				}else{
				  		$data['user_list'] = array(""=>"Select");
				}			  	
				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['main_content'] = 'alerts/add';
				$data['page_title']  = 'Alerts'; 
				$this->load->view(ADMIN_LAYOUT_PATH, $data); 
			}else{
				$data['user_list'] = array(""=>"Select");
				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['main_content'] = 'alerts/add';
				$data['page_title']  = 'Alerts'; 
				$this->load->view(ADMIN_LAYOUT_PATH, $data); 
			}
				
		}
	
		public function edit($id = NULL, $course_id)
		{
			$data['post'] = FALSE;
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->form_validation->set_rules('course_list', 'course list','callback_validate_select[Course]');
				$this->form_validation->set_rules('title', 'Title','required');
				$this->form_validation->set_rules('description', 'Short Description','required');
				if ($this->form_validation->run())
				{  
					$user_list = $this->input->post('user_list');						
					$this->base_model->delete ('alert_users',array('alert_id' => $id));
					$user_list_course=$this->alert_model->getUsers($this->input->post('course_list'));
					if(count($user_list)==0){
						foreach($user_list_course as $in_user_list){
							$user_list[]=$in_user_list["id"];
						}						
					}
					if(count($user_list)>0)
					{
						foreach($user_list as $key=>$value)
						{
							$array = array();
							$array = array ('alert_id' => $id, 
										    'user_id' => $value,
										 	'status' => 1
											);
							$insertId = $this->base_model->insert('alert_users', $array);
						}
						
					}
					
					$date = date('Y-m-d H:i:s');
					if (isset($_FILES['attachment_alert']) && $_FILES['attachment_alert']['name'] != "") {
					$config['upload_path'] = $this->config->item('alert_attachments');
                	$config['allowed_types'] = "pdf|doc|mp3|mp4|rar|docx|zip|swf"; 
                	$config['file_name'] = time();
                	$this->load->library('upload', $config);
                	$attachment_up = $this->upload->do_upload('attachment_alert');
					if (!$attachment_up)
        			{
				    	$upload = array('error' => $this->upload->display_errors(),
				    					'error1' => 'Please upload only .pdf,.doc,.docx,.mp3,.mp4,.swf,.rar or . zip files');
				   		$data['upload_error'] = $upload;
					}
					else
					{
						$attachment_data = array('upload_data' => $this->upload->data());
						$update_array = array ('title' => $this->input->post('title'), 
											   'short_description' => $this->input->post('description'), 
											   'attachment' => $attachment_data['upload_data']['file_name'],
											   'course_id' => $this->input->post('course_list'), 
											   'user_id' => 0, 
											   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0, 
											   'modified' => $date
											   );
											   
						$this->base_model->update ( 'alerts', $update_array, array('id'=>$id));
						$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
						redirect(base_url().SITE_ADMIN_URI.'/alerts/');
					}
					}else{
						if($this->input->post('attachment_hidden')!=""){
							$update_array = array ('title' => $this->input->post('title'), 
												   'short_description' => $this->input->post('description'), 
												   'attachment' => $this->input->post('attachment_hidden'),
												   'course_id' => $this->input->post('course_list'), 
												   'user_id' => 0, 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0, 
												   'modified' => $date
												   );
												   
							$this->base_model->update ( 'alerts', $update_array, array('id'=>$id));
							$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
						redirect(base_url().SITE_ADMIN_URI.'/alerts/');
						}else{
							$update_array = array ('title' => $this->input->post('title'), 
												   'short_description' => $this->input->post('description'), 
												   'attachment' => '',
												   'course_id' => $this->input->post('course_list'), 
												   'user_id' => 0, 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0, 
												   'modified' => $date
												   );
												   
							$this->base_model->update ( 'alerts', $update_array, array('id'=>$id));
							$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
						redirect(base_url().SITE_ADMIN_URI.'/alerts/');
						}
					}
				}
				$data['post'] = TRUE;
				$join_tables = $where = array();  
			  	$fields = ''; 
			  	$where[] = array( TRUE, 'au.alert_id', $id);
			  	$user_list = $this->base_model->get_advance_list('alert_users as au', $join_tables, $fields, $where, '', 'au.id', 'desc');
			  	foreach($user_list as $key=>$value)
			  	{
					$users_selected[]=$value['user_id'];
				}
				$course_id = $this->input->post('course_list');
				$hidden = $this->input->post('hidden');
				if($course_id==$hidden){
					$data['users_selected'] = $users_selected;
				}else{
					$data['users_selected'] = NULL;
				}
				
				if($course_id!=""){
				  	$user_list2 = $this->base_model->get_user_list($course_id);		
				  	$data['user_list'] = array(""=>"Select");  	
			  		if($user_list2){
				  		foreach($user_list2 as $user){
				  			$data['user_list'][$user['id']] = ucfirst($user['first_name'])." ".ucfirst($user['last_name']);
				  		}
			  		}			  		
				}else{
				  		$data['user_list'] = array(""=>"Select");
				}
				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['alerts_main'] = $this->base_model->getCommonListFields('alerts','',array('id' => $id));
				$data['alerts'] = $data['alerts_main'][0];
				$data['main_content'] = 'alerts/edit';
			  	$data['page_title']  = 'Alerts'; 
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
			}else{
				$join_tables = $where = array();  
			  	$fields = ''; 
			  	$where[] = array( TRUE, 'au.alert_id', $id);
			  	$user_list = $this->base_model->get_advance_list('alert_users as au', $join_tables, $fields, $where, '', 'au.id', 'desc');
			  	foreach($user_list as $key=>$value)
			  	{
					$users_selected[]=$value['user_id'];
				}
				$data['users_selected'] = $users_selected;
			  	
			  	$user_list2 = $this->base_model->get_user_list($course_id);	
			  	$hidden = $this->input->post("hidden");	  	
		  		if($user_list2){
		  			$data['user_list'][''] = 'Select';
			  		foreach($user_list2 as $user){
			  			$data['user_list'][$user['id']] = ucfirst($user['first_name'])." ".ucfirst($user['last_name']);
			  		}
		  		}
		  		else{
			  		$data['user_list'][''] = 'Select';
			  	}
				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['alerts_main'] = $this->base_model->getCommonListFields('alerts','',array('id' => $id));
				$data['hidden'] = $course_id;
				$data['alerts'] = $data['alerts_main'][0];
				$data['main_content'] = 'alerts/edit';
			  	$data['page_title']  = 'Alerts'; 
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
			}
		  	
		}
	public function delete($id,$pageredirect=null,$pageno)
	{
		$this->base_model->delete ('alerts',array('id' => $id));
		$this->base_model->delete ('alert_users',array('alert_id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/alerts/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'alerts';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/alerts/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno)
	{
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'alerts');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'alerts');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('alerts', array('id' => $id));
				$this->base_model->delete ('alert_users',array('alert_id' => $id));
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/alerts/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/alerts/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function request()
	{ 
		$course_id = $this->input->post('course_id');
	  	$user_list = $this->base_model->get_user_list($course_id);	
	  	$res=array();
	  	if($user_list){
		  	foreach($user_list as $user){		  		
		  		$res[]=array('name'=>ucfirst($user['first_name'])." ".ucfirst($user['last_name']),'id'=>$user['id']);		
		  	}			
	  	}else{
	  	}
		echo json_encode($res);
	}	
	
	public function getusers()
	{ 
		$course_id = $this->input->post('course_id');
	  	$user_list = $this->alert_model->getUsers($course_id);	
	  	$res=array();
	  	if($user_list){	  		
		  	foreach($user_list as $user){		  		
		  		$res[]=array('name'=>ucfirst($user['first_name'])." ".ucfirst($user['last_name']),'id'=>$user['id']);		
		  	}			
	  	}
		echo json_encode($res);
	}
}
