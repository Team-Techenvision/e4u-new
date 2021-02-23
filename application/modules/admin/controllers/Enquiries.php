<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiries extends Admin_Controller
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
		$config["base_url"] = base_url().SITE_ADMIN_URI."/enquiries/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = $where = array();
		if($keyword_name)
		{
			$where[] = array( FALSE,"(first_name LIKE '%$keyword_name%' or last_name LIKE '%$keyword_name%' or concat (first_name,' ',last_name) LIKE '%$keyword_name%' or email LIKE '%$keyword_name%' or phone LIKE '%$keyword_name%')");
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}

		$today_date=$this->input->get("date");#for current date only
		if($today_date){
			$today=$today_date.' 00:00:00';
			$today_end=$today_date.' 23:59:59';
			$where[] = array( TRUE, 'created >=', $today);  
			$where[] = array( TRUE, 'created <=', $today_end);  
		}	

		$fields = 'id,created,first_name,last_name,email,phone,message,status'; 			  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('enquiries', $join_tables, $fields, $where, 'num_rows','','','id');
		$data['enquiries'] = $this->base_model->get_advance_list('enquiries', '', $fields, $where, '', 'id', 'desc', 'id', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data['main_content'] = 'enquiries/index';
		$data['page_title']  = 'Enquiries'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	

	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/enquiries/');
	}
	public function view($id = NULL)
	{
		$join_tables = $where = array();  
		$fields = 'id,created,first_name,last_name,email,phone,message'; 
		$where[] = array( TRUE, 'id', $id);
		$data['enquiries'] = $this->base_model->get_advance_list('enquiries', $join_tables, $fields, $where, 'row_array');
	 
		$status = 1;
		$update_array = array ("status"=>$status);
		$this->base_model->update( 'enquiries', $update_array, array('id'=>$id));	
 
		$data['main_content'] = 'enquiries/view';
		$data['page_title']  = 'Enquiries'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function delete($id,$pageredirect=null,$pageno) 
	{
		$this->base_model->delete ('enquiries',array('id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/enquiries/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
