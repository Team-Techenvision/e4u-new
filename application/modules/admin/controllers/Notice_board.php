<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notice_board extends Admin_Controller
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
			$this->load->model('certificate_model'); 
			$this->load->model('Notice_board_model'); 

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
		  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/notice_board/index";
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
		  	$fields = 'a.id, a.title alert_name,a.short_description,a.created, a.course_id, co.name course_name, a.status'; 
		  	$join_tables[] = array('courses as co','a.course_id = co.id');

		  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('notice_board as a', $join_tables, $fields, $where, 'num_rows','','','a.id');
		  	$data['notice_board'] = $this->base_model->get_advance_list('notice_board as a', $join_tables, $fields, $where, '', 'a.id', 'desc', 'a.id', $limit_start, $limit_end);
		   $data['get_course'] = $this->base_model->getSelectList('courses');			   
		   $this->pagination->initialize($config);
			$data['main_content'] = 'notice_board/index';
		  	$data['page_title']  = 'Notice Board'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function reset()
		{
			$this->session->unset_userdata('search_course');
			$this->session->unset_userdata('search_name');
			redirect(base_url().SITE_ADMIN_URI.'/notice_board/');
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
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[Class]');
				$this->form_validation->set_rules('title', 'Title','required');
				$this->form_validation->set_rules('description', 'Short Description','required');			
					
				if ($this->form_validation->run()){ 
					$date = date('Y-m-d H:i:s');
	
						$update_array = array();
						$update_array = array ('title' => $this->input->post('title'), 
											   'short_description' => $this->input->post('description'), 
											   'course_id' => $this->input->post('course_list'), 
											   'class_id' => $this->input->post('class_list'), 
											   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
											   'created' => $date,
											   'added_by' => 1
											   );
						$alertId = $this->base_model->insert('notice_board', $update_array);
						$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
						redirect(base_url().SITE_ADMIN_URI.'/notice_board/');
				}
				$data['post'] = TRUE;
				$course_id = $this->input->post('course_list');
				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['class_list'] = $this->base_model->getSelectList('classes');
				$data['main_content'] = 'notice_board/add';
				$data['page_title']  = 'Notice Board'; 
				$this->load->view(ADMIN_LAYOUT_PATH, $data); 
			}else{
				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['class_list'] = $this->base_model->getSelectList('classes');
				$data['main_content'] = 'notice_board/add';
				$data['page_title']  = 'Notice Board'; 
				$this->load->view(ADMIN_LAYOUT_PATH, $data); 
			}
				
		}
	
		public function edit($id = NULL, $course_id)
		{
			$data['post'] = FALSE;
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->form_validation->set_rules('course_list', 'course list','callback_validate_select[Course]');
				$this->form_validation->set_rules('class_list', 'Class list','callback_validate_select[Class]');
				$this->form_validation->set_rules('title', 'Title','required');
				$this->form_validation->set_rules('description', 'Short Description','required');
				if ($this->form_validation->run())
				{  
						$date = date('Y-m-d H:i:s');
						$update_array = array ('title' => $this->input->post('title'), 
											   'short_description' => $this->input->post('description'), 
											   'course_id' => $this->input->post('course_list'), 
											   'class_id' => $this->input->post('class_list'), 
											   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0, 
											   'modified' => $date
											   );
											   
						$this->base_model->update ( 'notice_board', $update_array, array('id'=>$id));
						$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
						redirect(base_url().SITE_ADMIN_URI.'/notice_board/');

					
				}
				$data['post'] = TRUE;
				$course_id = $this->input->post('course_list');
				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['class_list'] = $this->base_model->getSelectList('classes');
				$data['notice_board_main'] = $this->base_model->getCommonListFields('notice_board','',array('id' => $id));
				$data['notice_board'] = $data['notice_board_main'][0];

				$class_list = $this->certificate_model->getClasses($data['notice_board_main'][0]->course_id);
				if($class_list){
				  	foreach($class_list as $class){
				  		$data['class_list'][ucfirst($class['id'])] = $class['name'];
				  	}
			  	}

				$data['main_content'] = 'notice_board/edit';
			  	$data['page_title']  = 'Notice Board'; 
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
			}else{

				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['notice_board_main'] = $this->base_model->getCommonListFields('notice_board','',array('id' => $id));
 					// print_r($data['notice_board_main'][0]) ;die;
				$class_list = $this->certificate_model->getClasses($data['notice_board_main'][0]->course_id);
				if($class_list){
				  	foreach($class_list as $class){
				  		$data['class_list'][ucfirst($class['id'])] = $class['name'];
				  	}
			  	}
				$data['hidden'] = $course_id;
				$data['notice_board'] = $data['notice_board_main'][0];
				$data['main_content'] = 'notice_board/edit';
			  	$data['page_title']  = 'Notice Board'; 
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
			}
		  	
		}
	public function delete($id,$pageredirect=null,$pageno)
	{
		$this->base_model->delete ('notice_board',array('id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/notice_board/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'notice_board';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/notice_board/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
				$this->base_model->update_status($id, $data, 'notice_board');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'notice_board');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('notice_board', array('id' => $id));
				$this->base_model->delete ('alert_users',array('alert_id' => $id));
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/notice_board/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/notice_board/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
	  	$user_list = $this->Notice_board_model->getUsers($course_id);	
	  	$res=array();
	  	if($user_list){	  		
		  	foreach($user_list as $user){		  		
		  		$res[]=array('name'=>ucfirst($user['first_name'])." ".ucfirst($user['last_name']),'id'=>$user['id']);		
		  	}			
	  	}
		echo json_encode($res);
	}
}
