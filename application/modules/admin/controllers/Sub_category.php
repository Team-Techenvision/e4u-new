<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_category extends Admin_Controller
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
		$this->load->helper('function_helper');
		$this->load->model('base_model'); 
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
	  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/sub_category/index";
	 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
	  	$config["uri_segment"] = 4;
	  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
	  	$limit_start = $config['per_page'];
	  	$join_tables = $where = array(); 
	  	if($keyword_name)
		{
			$where[] = array( TRUE, 'name LIKE ', '%'.$keyword_name.'%');
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		} 
	  	$fields = 'id, name,status,created'; 			  	
	  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('sub_category', $join_tables, $fields, $where, 'num_rows','','','id');
	  	$data['sub_category'] = $this->base_model->get_advance_list('sub_category', '', $fields, $where, '', 'id', 'desc', 'id', $limit_start, $limit_end);
	   	$this->pagination->initialize($config);
		$data['main_content'] = 'sub_category/index';
	  	$data['page_title']  = 'Sub Category'; 
	  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/sub_category/');
	}
	public function add()
	{
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_rules('name', 'name','trim|required|is_unique[sub_category.name]');
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$update_array = array ( 'name' => $this->input->post('name'),
										'status' => $this->input->post('status'),
										'created' => $date
									  );
				$this->base_model->insert( 'sub_category', $update_array);
				$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				redirect(base_url().SITE_ADMIN_URI.'/sub_category/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  $fields = 'id, name,status'; 
		$data['main_content'] = 'sub_category/add';
	  	$data['page_title']  = 'Sub Category'; 
	  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function edit($id = NULL)
	{
		$data['post'] = FALSE;
		$join_tables = $where = array(); 
		$where[] = array( TRUE, 'id', $id);
		$fields = 'name'; 
		$getValues = $this->base_model->get_advance_list('sub_category', $join_tables, $fields, $where, 'row_array');
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			if($this->input->post('name') != $getValues['name']) {
			$is_unique =  '|is_unique[sub_category.name]' ;
			} else {
				$is_unique =  '' ;
			}
	       	$this->form_validation->set_rules('name', 'Name', 'trim|required'.$is_unique);		
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$update_array = array ( 'name' => $this->input->post('name'),								'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,		
										'modified' => $date
									  );
				$this->base_model->update ( 'sub_category', $update_array, array('id'=>$id));
				$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
				redirect(base_url().SITE_ADMIN_URI.'/sub_category/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  $fields = 'id, name,status'; 
	  	$where[] = array( TRUE, 'id', $id);
	  	$data['sub_category'] = $this->base_model->get_advance_list('sub_category', $join_tables, $fields, $where, 'row_array');
		$data['main_content'] = 'sub_category/edit';
	  	$data['page_title']  = 'sub_category'; 
	  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'sub_category';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/sub_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function delete($id,$pageredirect=null,$pageno) 
	{
		$table_name = 'sub_category';
		delete_record($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/sub_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
				$this->base_model->update_status($id, $data, 'sub_category');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) 
			{
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'sub_category');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('sub_category', array('id' => $id));
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/sub_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/sub_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
