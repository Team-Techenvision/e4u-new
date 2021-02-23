<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends Admin_Controller
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
		$this->load->model('classes_model'); 
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
		$config["base_url"] = base_url().SITE_ADMIN_URI."/classes/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = $where = array();
		if($keyword_name)
		{
			$where[] = array( TRUE, 'c.name LIKE ', '%'.$keyword_name.'%' );
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}
		$fields = 'c.id, c.name,c.status,c.created,count(ch.class_id) as ch_count,count(rc.class_id) as rc_count';
		$join_tables[] = array('relevant_classes as rc','c.id = rc.class_id');
		$join_tables[] = array('chapters as ch','c.id = ch.class_id'); 			  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('classes as c', $join_tables, $fields, $where, 'num_rows','','','c.id');
		$data['classes'] = $this->base_model->get_advance_list('classes as c', $join_tables, $fields, $where, '', 'c.id', 'desc', 'c.id', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data['main_content'] = 'classes/index';
		$data['page_title']  = 'classes'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/classes/');
	}
	public function add()
	{
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_rules('name', 'Name','trim|required|is_unique[classes.name]');
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'name' => $this->input->post('name'),
										'status' => $this->input->post('status'),
										'created' => $date
									  );
				$this->base_model->insert( 'classes', $update_array);
				$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				redirect(base_url().SITE_ADMIN_URI.'/classes/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  $fields = 'id, name,status'; 
		$data['main_content'] = 'classes/add';
		$data['page_title']  = 'classes'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function edit($id = NULL)
	{
		$data['post'] = FALSE;
		$join_tables = $where = array(); 
		$where[] = array( TRUE, 'id', $id);
		$fields = 'name'; 
		$getValues = $this->base_model->get_advance_list('classes', $join_tables, $fields, $where, 'row_array');
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 	
			if($this->input->post('name') != $getValues['name']) {
			$is_unique =  '|is_unique[classes.name]' ;
			} else {
				$is_unique =  '' ;
			}
	      $this->form_validation->set_rules('name', 'Name', 'trim|required'.$is_unique);				
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'name' => $this->input->post('name'),
										'status' => $this->input->post('status'),
										'modified' => $date
									  );
				$this->base_model->update ( 'classes', $update_array, array('id'=>$id));
				$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
				redirect(base_url().SITE_ADMIN_URI.'/classes/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  
		$fields = 'id, name,status'; 
		$where[] = array( TRUE, 'id', $id);
		$data['classes'] = $this->base_model->get_advance_list('classes', $join_tables, $fields, $where, 'row_array');
		$data['main_content'] = 'classes/edit';
		$data['page_title']  = 'classes'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'classes';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/classes/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function delete($id,$pageredirect=null,$pageno) 
	{
		$test_details = check_delete($id,6);
		if($test_details["is_delete"]==0){
			$table_name = 'classes';
			delete_record($table_name,$id,$status,$pageredirect,$pageno);
			$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
			redirect(base_url().SITE_ADMIN_URI.'/classes/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		else
		{
			redirect(base_url().SITE_ADMIN_URI.'/classes/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
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
				$this->classes_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) 
			{
				$data = array('status' => '0');
				$this->classes_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$test_details = check_delete($id,6);
				if($test_details["is_delete"]==0){
					$this->base_model->delete('classes', array('id' => $id));
				}
				else
				{
					redirect(base_url().SITE_ADMIN_URI.'/classes/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/classes/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/classes/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
