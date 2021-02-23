<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Course_category extends Admin_Controller
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
		$this->load->model('base_model'); 
		$this->load->helper('function_helper');
		$this->load->model(array('medium_model','admin_model')); 
		getSearchDetails($this->router->fetch_class());
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
			isset($_SESSION['search_course'])?$this->session->unset_userdata('search_course'):'';
			$keyword_name = "";
		}
		$this->load->library('pagination');
		$config  = $this->config->item('pagination');
		$config["base_url"]    = base_url().SITE_ADMIN_URI."/course_category/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = $where = array();
		if($keyword_name)
		{
			$where[] = array( TRUE, 'category LIKE ', '%'.$keyword_name.'%');
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}
		$fields = 'id, category,status,created_date'; 			  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('course_category', $join_tables, $fields, $where, 'num_rows','','','id');
		$data['course_category'] = $this->base_model->get_advance_list('course_category', '', $fields, $where, '', 'id', 'desc', 'id', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data["counts_arr"]=$this->admin_model->get_counts_course();  
		$data['main_content'] = 'course_category/index';
		$data['page_title']  = 'Course Category'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/course_category/');
	}
	public function add()
	{
		$data['post'] = FALSE;
		$admin_id = $this->session->userdata("admin_is_logged_in");
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 				
			$this->form_validation->set_rules('name', 'Category','trim|required|is_unique[course_category.category]');
			$this->form_validation->set_rules('description', 'Description','trim|required');
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'category' => $this->input->post('name'),
										'description' => $this->input->post('description'),
										'status' => $this->input->post('status'),
										'created_date' => $date,
										'created_by' => $admin_id['admin_user_id'],
									  );
				$this->base_model->insert( 'course_category', $update_array);
				$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				redirect(base_url().SITE_ADMIN_URI.'/course_category/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  $fields = 'id, category,status'; 
		$data['main_content'] = 'course_category/add';
		$data['page_title']  = 'Course Category'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function edit($id = NULL)
	{
		$admin_id = $this->session->userdata("admin_is_logged_in");
		$data['post'] = FALSE;
		$join_tables = $where = array(); 
		$where[] = array( TRUE, 'id', $id);
		$fields = 'category'; 
		$getValues = $this->base_model->get_advance_list('course_category', $join_tables, $fields, $where, 'row_array');
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 	
			if($this->input->post('name') != $getValues['category']) {
			$is_unique =  '|is_unique[course_category.category]' ;
			} else {
				$is_unique =  '' ;
			}
	      $this->form_validation->set_rules('name', 'Category', 'trim|required'.$is_unique);
	      $this->form_validation->set_rules('description', 'Description','trim|required');	
			if ($this->form_validation->run())
			{   
			$date = date('Y-m-d H:i:s');
			$update_array = array (	'category' => $this->input->post('name'),
									'description' => $this->input->post('description'),
									'status' => $this->input->post('status'),
									'created_by' => $admin_id['admin_user_id'],
									'modified_date' => $date
								  );
			$this->base_model->update ( 'course_category', $update_array, array('id'=>$id));
			$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
			redirect(base_url().SITE_ADMIN_URI.'/course_category/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  $fields = 'id, category,description,status'; 
		$where[] = array( TRUE, 'id', $id);
		$data['course_category'] = $this->base_model->get_advance_list('course_category', $join_tables, $fields, $where, 'row_array');
		$data['main_content'] = 'course_category/edit';
		$data['page_title']  = 'course_category'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'course_category';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/course_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function delete($id,$pageredirect=null,$pageno) 
	{
		$this->db->delete('course_category',array('id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/course_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno)
	{
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) 
			{
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data,'course_category');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) 
			{
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data,'course_category');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('course_category', array('id' => $id));
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/course_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/course_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
