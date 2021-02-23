<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends Admin_Controller
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
		$this->load->model('page_model'); 
	}

	public function index($page_num = 1)
	{  
		$search_name_keyword  =  isset($_POST['search_name'])?trim($_POST['search_name']):(isset($_SESSION['search_name'])?$_SESSION['search_name']:'');
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
		$config["base_url"] = base_url().SITE_ADMIN_URI."/pages/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = $where = array(); 
		if($keyword_name)
		{
			$where[] = array( TRUE, 'title LIKE ', '%'.$keyword_name.'%' );
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}  
		$fields = 'id,title,status,created,meta_keywords,meta_description'; 			  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('pages', $join_tables, $fields, $where, 'num_rows','','','id');
		$data['pages'] = $this->base_model->get_advance_list('pages', '', $fields, $where, '', 'id', 'desc', 'id', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data['main_content'] = 'pages/index';
		$data['page_title']  = 'Pages'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/pages/');
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'pages';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/pages/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function add()
	{
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_rules('title', 'Page Title','trim|required|is_unique[pages.title]');
			$this->form_validation->set_rules('meta_key', 'Meta Keyword','trim|required|max_length[160]');
			$this->form_validation->set_rules('description', 'Meta Description', 'trim|required|max_length[250]');
			$this->form_validation->set_rules('content', 'Content','trim|required');
			$this->form_validation->set_rules('seo_title', 'SEO Title','trim|required|max_length[60]');
			if ($this->form_validation->run())
			{   
				$table = 'pages';
				$string = $this->input->post('title');
				$slug = create_unique_slug($string,$table,$field='alias');
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'title' => $this->input->post('title'),
										'meta_keywords' => $this->input->post('meta_key'),
										'meta_description' => $this->input->post('description'),
										'seo_title' => $this->input->post('seo_title'),
										'alias' => $slug,
										'content' => $this->input->post('content'),
										'status' => $this->input->post('status'),
										'created' => $date
									  );
				$this->base_model->insert('pages', $update_array);
				$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				redirect(base_url().SITE_ADMIN_URI.'/pages/');
			}
			$data['post'] = TRUE;
		}
		$data['main_content'] = 'pages/add';
		$data['page_title']  = 'Pages'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function edit($id = NULL)
	{
		$data['post'] = FALSE;
		$join_tables = $where = array(); 
		$where1[] = array( TRUE, 'id', $id);
		$fields = 'title'; 
		$getValues = $this->base_model->get_advance_list('pages', $join_tables, $fields, $where1, 'row_array');
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_rules('title', 'title','trim|required');	
			if($this->input->post('title') != $getValues['title']) {
			$is_unique =  '|is_unique[pages.title]' ;
			} else {
				$is_unique =  '' ;
			}
			$this->form_validation->set_rules('title', 'Page Title', 'trim|required'.$is_unique);
			$this->form_validation->set_rules('meta_key', 'Meta Keyword','trim|required|max_length[160]');
			$this->form_validation->set_rules('description', 'Meta Description','trim|required|max_length[250]');
			$this->form_validation->set_rules('content', 'Content','trim|required');
			$this->form_validation->set_rules('seo_title', 'SEO Title','trim|required|max_length[60]');
			if ($this->form_validation->run())
			{   
				$table = 'pages';
				$string = $this->input->post('title');
				$slug = create_unique_slug($string,$table,$field='alias','id',$id);
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'title' => $this->input->post('title'),
										'meta_keywords' => $this->input->post('meta_key'),
										'meta_description' => $this->input->post('description'),
										'seo_title' => $this->input->post('seo_title'),
										'alias' => $slug,
										'content' => $this->input->post('content'),
										'status' => $this->input->post('status'),
										'modified' => $date
									  );
				$this->base_model->update ( 'pages', $update_array, array('id'=>$id));
				$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
				redirect(base_url().SITE_ADMIN_URI.'/pages/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  
		$fields = 'id,title,meta_keywords,meta_description,seo_title,content,status'; 
		$where[] = array( TRUE, 'id', $id);
		$data['pages'] = $this->base_model->get_advance_list('pages',$join_tables,$fields,$where, 'row_array');
		$data['main_content'] = 'pages/edit';
		$data['page_title']  = 'pages'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function delete($id,$pageredirect=null,$pageno) 
	{
		$table_name = 'pages';
		delete_record($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/pages/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
				$this->page_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) 
			{
				$data = array('status' => '0');
				$this->page_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('pages', array('id' => $id));
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/pages/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/pages/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
