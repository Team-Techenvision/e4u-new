<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisements extends Admin_Controller
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
		$this->load->helper('thumb_helper');
		$this->load->helper('html');
		$this->load->library('pagination');
		$config  = $this->config->item('pagination');
		$config["base_url"] = base_url().SITE_ADMIN_URI."/advertisements/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = $where = array();
		if($keyword_name)
		{
			$where[] = array( TRUE, 'name LIKE ', '%'.$keyword_name.'%' );
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}  
		$fields = 'id, name, image, url, description, expiry_date, status, created'; 			  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('advertisements', $join_tables, $fields, $where, 'num_rows','','','id');
		$data['advertisements'] = $this->base_model->get_advance_list('advertisements', '', $fields, $where, '', 'id', 'desc', 'id', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data['main_content'] = 'advertisements/index';
		$data['page_title']  = 'Advertisements'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	

	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/advertisements/');
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
			$this->form_validation->set_rules('name', 'Name','trim|required|max_length[35]|is_unique[advertisements.name]');
			$this->form_validation->set_rules('url', 'Url','trim|required|callback_valid_url[url]');
			$this->form_validation->set_rules('expiry_date', 'Expiry Date','trim|required');
			$this->form_validation->set_rules('page_id', 'page','trim|callback_validate_select[Page Name]');
			$this->form_validation->set_rules('position_id', 'position','trim|callback_validate_select[Position]');
			if ($_FILES['ad_image']['size'] == "0") {
                $this->form_validation->set_rules('ad_image', 'image', 'callback_validate_select[Image]');
            }
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$config['upload_path'] = $this->config->item('ad_img');
            $config['allowed_types'] = "gif|jpg|jpeg|png";
				$config['min_width'] = "1200"; 
            $config['min_height'] = "120";  
				$config['max_width'] = "1200";
				$config['max_height'] = "120"; 
            $this->load->library('upload', $config);
            $image_up = $this->upload->do_upload('ad_image');
			   if (!$image_up)
        		{
				    $upload = array('error' => $this->upload->display_errors());
				    $data['upload_error'] = $upload;
				}
				else
				{
				$image_data = array('upload_data' => $this->upload->data()); 
				$update_array = array (	'name' => $this->input->post('name'),
										'image' => $image_data['upload_data']['file_name'],
										'url' => $this->input->post('url'),										
										'page_id' => $this->input->post('page_id'),
										'position_id' => $this->input->post('position_id'),
										'expiry_date' => date("Y-m-d H:i:s", strtotime($this->input->post('expiry_date'))),
										'status' => $this->input->post('status'),
										'created' => $date
									  );
				$this->base_model->insert( 'advertisements', $update_array);
				$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				redirect(base_url().SITE_ADMIN_URI.'/advertisements/');
				}
			}
			$data['post'] = TRUE;
		}
		$data['page_id'] = $this->base_model->getSelectList('ad_page');
		if($this->input->post('page_id')){			
			$join_tables = $where = array();  
			$where[] = array( TRUE, ' 	ad_page_id', $this->input->post('page_id'));
			$fields = 'id, position,status'; 
			$position_id = $this->base_model->get_advance_list('ad_page_position', $join_tables, $fields, $where, '', 'position', 'asc');
			$data['position_id'] = array('' => 'Select');
			foreach($position_id as $position){
		  		$data['position_id'][$position['id']] = ucfirst($position['position']);
		  	}
		}else{
			$data['position_id'] = array('' => 'Select');
		}
		
		$join_tables = $where = array();  $fields = 'id, name,status'; 
		$data['main_content'] = 'advertisements/add';
		$data['page_title']  = 'Advertisements'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function edit($id = NULL)
	{
		$this->load->helper('thumb_helper');
		$this->load->helper('html');
		$data['post'] = FALSE;
		$join_tables = $where = array(); 
		$where[] = array( TRUE, 'id', $id);
		$fields = 'name'; 
		$getValues = $this->base_model->get_advance_list('advertisements', $join_tables, $fields, $where, 'row_array');
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 	
			$this->form_validation->set_rules('name', 'name','trim|required|max_length[35]');	
			if($this->input->post('name') != $getValues['name']) {
			$is_unique =  '|is_unique[advertisements.name]' ;
			} else {
				$is_unique =  '' ;
			}
	      $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[35]'.$is_unique);
			$this->form_validation->set_rules('url', 'Url','trim|required|callback_valid_url[url]');
			$this->form_validation->set_rules('expiry_date', 'Expiry Date','trim|required');
			$this->form_validation->set_rules('page_id', 'page','trim|callback_validate_select[Page Name]');
			$this->form_validation->set_rules('position_id', 'position','trim|callback_validate_select[Position]');
			
			if ($this->form_validation->run())
			{  
				$date = date('Y-m-d H:i:s');
				if ($_FILES['ad_image']['name'] != "") {
					$config['upload_path'] = $this->config->item('ad_img');
		         $config['allowed_types'] = "gif|jpg|jpeg|png";
					$config['min_width'] = "1200"; 
					$config['min_height'] = "120";  
					$config['max_width'] = "1200";
					$config['max_height'] = "120";
		         $this->load->library('upload', $config);
		         $image_up = $this->upload->do_upload('ad_image');
		         if (!$image_up)
		    		{
						$upload = array('error' => $this->upload->display_errors());
					  	$data['upload_error'] = $upload;
					   
					}else{
					$image_data = array('upload_data' => $this->upload->data());
					$update_array = array (	'name' => $this->input->post('name'),
											'image' => $image_data['upload_data']['file_name'],
											'url' => $this->input->post('url'),											
											'page_id' => $this->input->post('page_id'),
											'position_id' => $this->input->post('position_id'),
											'expiry_date' => date("Y-m-d H:i:s", strtotime($this->input->post('expiry_date'))),
											'status' => $this->input->post('status'),
											'modified' => $date
										  );
				
					$this->base_model->update ( 'advertisements', $update_array, array('id'=>$id));
					$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
					redirect(base_url().SITE_ADMIN_URI.'/advertisements/');
					}
				}else{
					if($this->input->post('ad_image_hidden')){
					$update_array = array (	'name' => $this->input->post('name'),
											'image' => $this->input->post('ad_image_hidden'),
											'url' => $this->input->post('url'),											
											'page_id' => $this->input->post('page_id'),
											'position_id' => $this->input->post('position_id'),
											'expiry_date' => date("Y-m-d H:i:s", strtotime($this->input->post('expiry_date'))),
											'status' => $this->input->post('status'),
											'modified' => $date
										  );
					$this->base_model->update ( 'advertisements', $update_array, array('id'=>$id));
					$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
					redirect(base_url().SITE_ADMIN_URI.'/advertisements/');
					}else{
						$update_array = array (	'name' => $this->input->post('name'),
											'url' => $this->input->post('url'),											
											'page_id' => $this->input->post('page_id'),
											'position_id' => $this->input->post('position_id'),
											'expiry_date' => date("Y-m-d H:i:s", strtotime($this->input->post('expiry_date'))),
											'status' => $this->input->post('status'),
											'modified' => $date
										  );
					$this->base_model->update ( 'advertisements', $update_array, array('id'=>$id));
					$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
					redirect(base_url().SITE_ADMIN_URI.'/advertisements/');
					}
				}					
				
			}
			$data['post'] = TRUE;
			$data['page_id'] = $this->base_model->getSelectList('ad_page');
			$fields = 'id,position';
			$where = array('ad_page_id' => $this->input->post('page_id'));
		  	$data['position_id'] = $this->base_model->getSelectList('ad_page_position', $where, '',$fields);
			
		}else{
			$data['page_id'] = $this->base_model->getSelectList('ad_page');
			$join_tables = $where = array();  
			$fields = 'po.id id, po.position position'; 
			$where[] = array( TRUE, 'ad.id', $id);
			$join_tables[] = array('ad_page_position as po','ad.page_id = po.ad_page_id');
			$position_id = $this->base_model->get_advance_list('advertisements ad', $join_tables, $fields, $where, '', 'po.position', 'asc');
			$data['position_id'] = array('' => 'Select');
			foreach($position_id as $position){
		  		$data['position_id'][$position['id']] = ucfirst($position['position']);
		  	}
	  	}
		$join_tables = $where = array();  
		$fields = 'id, name, image, url, description, expiry_date, page_id, position_id, status'; 
		$where[] = array( TRUE, 'id', $id);
		$data['advertisements'] = $this->base_model->get_advance_list('advertisements', $join_tables, $fields, $where, 'row_array');
		$data['main_content'] = 'advertisements/edit';
		$data['page_title']  = 'Advertisements'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'advertisements';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/advertisements/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function delete($id,$pageredirect=null,$pageno) 
	{
		$getImg = $this->base_model->getCommonListFields('advertisements',array('image'),array('id' => $id));
		if ($getImg[0]->image) {
            @unlink($this->config->item('ad_img') . $getImg[0]->image);
        }
		$this->base_model->delete ('advertisements',array('id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/advertisements/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno){
		
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'advertisements');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'advertisements');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$getImg = $this->base_model->getCommonListFields('advertisements',array('image'),array('id' => $id));
				if ($getImg[0]->image) {
				    @unlink($this->config->item('ad_img') . $getImg[0]->image);
				}
				$this->base_model->delete('advertisements', array('id' => $id));
				
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/advertisements/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/advertisements/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function request(){
		$page_id = $this->input->post('page_id');
		$data['position_list'] = array();
		$join_tables = $where = array();  
	  	$fields = 'id,position';
	    $where = array('ad_page_id' => $page_id);
	  	$position_list = $this->base_model->getSelectList('ad_page_position', $where, '',$fields);
		$data['position_list'] = $position_list; 
		echo json_encode($data);
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
