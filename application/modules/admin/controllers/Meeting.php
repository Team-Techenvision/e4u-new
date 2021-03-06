<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting extends Admin_Controller
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
		$this->load->model(array('certificate_model'));
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
		$this->load->helper('thumb_helper');
		$this->load->helper('html');
		$this->load->library('pagination');
		$config  = $this->config->item('pagination');
		$config["base_url"] = base_url().SITE_ADMIN_URI."/meeting/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$where = array();  
		$join_tables[] = array();
		if($keyword_name)
		{
			$where[] = array( TRUE, 'mt.meeting_topic LIKE ', '%'.$keyword_name.'%' );
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}
		
		$fields = '*'; 			  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('meeting mt', "", $fields, $where, 'num_rows','','','ID');
		
		
		$data['meeting'] = $this->base_model->get_advance_list('meeting mt', array(), $fields, $where, '', 'ID', 'desc', 'ID', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data['main_content'] = 'meeting/index';
		$data['page_title']  = 'Meeting'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	

	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/meeting/');
	}
	public function validate_select($val, $fieldname){
		if($val==""){
			$this->form_validation->set_message('validate_select', 'Please choose the '.$fieldname.'.');
			return FALSE;
		}			
	}
	public function add()
	{
		$this->load->helper('thumb_helper');
		 $this->load->helper('html');
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_rules('course_list', 'course list','trim|callback_validate_select[Course]');
			$this->form_validation->set_rules('meeting_topic', 'Meeting topic','trim|required|is_unique[meeting.meeting_topic]');
			$this->form_validation->set_rules('url', 'Url','trim|required|callback_valid_url[url]');
			$this->form_validation->set_rules('meeting_description', 'Description','trim|required');
			$this->form_validation->set_rules('meeting_date', 'Meeting date','trim|required');

			if(!$this->input->post('class_list')){
				$this->form_validation->set_rules('class_list', 'class Id','trim|required');
			}
			
			if ($this->form_validation->run())
			{   

				$dbDate = $this->input->post('meeting_date');	
				$ht = $this->input->post('hours_to');
				$mt = $this->input->post('mins_to');
				$exp_date = "$dbDate  $ht:$mt:00";
				
				$date = date('Y-m-d H:i:s');

				$class_list = implode(',',$this->input->post('class_list'));
				$class_arr = $this->input->post('class_list');
				$update_array = array (	
				'course_id' => $this->input->post('course_list'),	
				'class_id' => $class_list,	
				'meeting_topic' => $this->input->post('meeting_topic'),
				'description' =>  $this->input->post('meeting_description'),
				'hours_from' => $this->input->post('hours_from'),
				'mins_from' => $this->input->post('mins_from'),
				'hours_to' => $this->input->post('hours_to'),
				'mins_to' => $this->input->post('mins_to'),
				'url' => $this->input->post('url'),
				'meeting_date' => $this->input->post('meeting_date'),
				'meeting_expiry' => $exp_date,
				'status' => $this->input->post('status'),
				'created' => $date
				);
				$insertId = $this->base_model->insert( 'meeting', $update_array);
			  
				 foreach($class_arr as $val){
					$update_array1 = array (	
					   'meeting_id' => $insertId,	
					   'class_id' =>  $val,	
					   'created' => $date
					);
				  $this->base_model->insert( 'meeting_by_class', $update_array1);
				 } 
				 
				$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				redirect(base_url().SITE_ADMIN_URI.'/meeting/');

			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  $fields = 'ID, meeting_topic, status'; 
		$data['page_list'] = $this->base_model->getSelectList('banner_page');
		$data['course_list'] = $this->base_model->getSelectList('courses');
		$data['main_content'] = 'meeting/add';
		$data['page_title']  = 'Meeting'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function edit($id = NULL)
	{
		$this->load->helper('thumb_helper');
		$this->load->helper('html');
		$data['post'] = FALSE;
		$join_tables = $where = array(); 
		$where[] = array( TRUE, 'ID', $id);
		$fields = 'meeting_topic'; 
		$getValues = $this->base_model->get_advance_list('meeting', $join_tables, $fields, $where, 'row_array');
	
		// $where[] = array( TRUE, 'meeting_id', $id);
		// $qns_data = $this->base_model->get_advance_list('meeting_by_class', '', '', $where, 'row', '', ''); 
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 	
			$this->form_validation->set_rules('course_list', 'course list','trim|callback_validate_select[Course]');
			$this->form_validation->set_rules('meeting_topic', 'Meeting topic','trim|required');
			$this->form_validation->set_rules('url', 'Url','trim|required|callback_valid_url[url]');
			$this->form_validation->set_rules('meeting_description', 'Description','trim|required');
			$this->form_validation->set_rules('meeting_date', 'Meeting date','trim|required');

			if ($this->form_validation->run())
			{  

				$dbDate = $this->input->post('meeting_date');	
				$ht = $this->input->post('hours_to');
				$mt = $this->input->post('mins_to');
				$exp_date = "$dbDate  $ht:$mt:00";

				$date = date('Y-m-d H:i:s');
				$class_list = implode(',',$this->input->post('class_list'));
				$class_arr = $this->input->post('class_list');
				$update_array = array (	
				'course_id' => $this->input->post('course_list'),	
				'class_id' => $class_list,	
				'meeting_topic' => $this->input->post('meeting_topic'),
				'description' =>  $this->input->post('meeting_description'),
				'hours_from' => $this->input->post('hours_from'),
				'mins_from' => $this->input->post('mins_from'),
				'hours_to' => $this->input->post('hours_to'),
				'mins_to' => $this->input->post('mins_to'),
				'url' => $this->input->post('url'),
				'meeting_date' => $this->input->post('meeting_date'),
				'meeting_expiry' => $exp_date,
				'status' => $this->input->post('status'),
				'modified' => $date
				);
				$this->base_model->update ( 'meeting', $update_array, array('ID'=>$id));
				$where1[] = array( TRUE, 'meeting_id', $id);
				$already_check = $this->base_model->get_advance_list('meeting_by_class', '', '',$where1, '', '', '');
				
				$getDbData = array();
				foreach($already_check as $val){
					$getDbData[] =  $val['class_id'];
				}
          
				$deleteData = array_diff($getDbData, $class_arr);

				if(count($deleteData) !=0 ){
				 $this->base_model->delete_meeting_class($deleteData);
				}

				foreach($class_arr as $val){
					if (!in_array($val, $getDbData))
					{
						$update_array1 = array (	
							'meeting_id' => $id,	
							'class_id' =>  $val,	
							'modified' => $date
							);
						$this->base_model->insert( 'meeting_by_class', $update_array1);		
					}
				 } 
				
				$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
				redirect(base_url().SITE_ADMIN_URI.'/meeting/');
				
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  
		$fields = '*'; 
		$where[] = array( TRUE, 'ID', $id);
		$data['meeting'] = $this->base_model->get_advance_list('meeting', $join_tables, $fields, $where, 'row_array');
		$data['course_list'] = $this->base_model->getSelectList('courses');
		$data['meeting_main'] = $this->base_model->getCommonListFields('meeting','',array('ID' => $id));
		$class_list = $this->certificate_model->getClasses($data['meeting_main'][0]->course_id);
			if($class_list){
			  	foreach($class_list as $class){
			  		$data['class_list'][ucfirst($class['id'])] = $class['name'];
			  	}
			  }
		$data['sel_class_list'] = explode(',',$data['meeting_main'][0]->class_id); //$data['meeting_main'][0]->class_id;
		$data['main_content'] = 'meeting/edit';
		$data['page_title']  = 'Meeting'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'meeting';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/meeting/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function delete($id,$pageredirect=null,$pageno) 
	{
		// $getImg = $this->base_model->getCommonListFields('meeting',array('image'),array('id' => $id));
		// if ($getImg[0]->image) {
        //     @unlink($this->config->item('banner_img') . $getImg[0]->image);
        // }
		$this->base_model->delete ('meeting',array('id' => $id));
		$this->base_model->delete ('meeting_by_class',array('meeting_id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/meeting/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno){
		
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'meeting');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'meeting');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$getImg = $this->base_model->getCommonListFields('meeting',array('image'),array('id' => $id));
				if ($getImg[0]->image) {
				    @unlink($this->config->item('banner_img') . $getImg[0]->image);
				}
				$this->base_model->delete('meeting', array('id' => $id));
				
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/meeting/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/meeting/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function valid_url($url, $field_name)
	{	
		if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
		    $this->form_validation->set_message('valid_url', 'Enter valid '.$field_name);
		    return FALSE;
		}else{
			return TRUE;
		}
	}
}
