<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonials extends Admin_Controller
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
		$this->load->library('pagination');
		$config  = $this->config->item('pagination');
		$config["base_url"] = base_url().SITE_ADMIN_URI."/testimonials/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = $where = array();
		if($keyword_name)
		{
			$where[] = array( TRUE, 'user_name LIKE ', '%'.$keyword_name.'%' );
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		} 		
		$fields = 'id,user_name,user_description,status,created'; 			  	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('testimonials', $join_tables, $fields, $where, 'num_rows','','','id');
		$data['testimonials'] = $this->base_model->get_advance_list('testimonials', '', $fields, $where, '', 'id', 'desc', 'id', $limit_start, $limit_end);
		$this->pagination->initialize($config);
		$data['main_content'] = 'testimonials/index';
		$data['page_title']  = 'Testimonials'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	

	}
	public function reset()
	{
		$this->session->unset_userdata('search_name');
		redirect(base_url().SITE_ADMIN_URI.'/testimonials/');
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
			$this->form_validation->set_rules('name', 'Name','trim|required');
			$this->form_validation->set_rules('about_client', 'About Client','trim|required');
			$this->form_validation->set_rules('description', 'Testimonial','trim|required|max_length[200]');
			if ($_FILES['testi_image']['size'] == "0") {
                $this->form_validation->set_rules('testi_image', 'image', 'callback_validate_select[Image]');
            }
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$config['upload_path'] = $this->config->item('testi_img');
                $config['allowed_types'] = "gif|jpg|jpeg|png"; 
                $config['min_width'] = "70"; 
                $config['min_height'] = "70";   
				$config['max_width'] = "100";
				$config['max_height'] = "100"; 
                 
                $this->load->library('upload', $config);
                $image_up = $this->upload->do_upload('testi_image');
				
				if (!$image_up)
        		{
				    $upload = array('error' => $this->upload->display_errors());
				   	$data['upload_error'] = $upload;
				   
				}
				else
				{
					$image_data = array('upload_data' => $this->upload->data());
					$update_array = array (	
											'user_name' => $this->input->post('name'),
											'about_client' => $this->input->post('about_client'),
											'user_description' => $this->input->post('description'),
											'user_image' => $image_data['upload_data']['file_name'],
											'status' => $this->input->post('status'),
											'created' => $date
										  );
					$this->base_model->insert( 'testimonials', $update_array);
					$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
					redirect(base_url().SITE_ADMIN_URI.'/testimonials/');
				}
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  $fields = 'id,name,status'; 
		$data['main_content'] = 'testimonials/add';
		$data['page_title']  = 'Testimonials'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function edit($id = NULL)
	{
		$this->load->helper('thumb_helper');
		$this->load->helper('html');
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 				

			$this->form_validation->set_rules('name', 'Name','trim|required');
			$this->form_validation->set_rules('about_client', 'About Client','trim|required');
			$this->form_validation->set_rules('description', 'Description','trim|required');				
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				if ($_FILES['testi_image']['name'] != "") {
					$config['upload_path'] = $this->config->item('testi_img');
		            $config['allowed_types'] = "gif|jpg|jpeg|png";
				 	$config['min_width'] = "70"; 
                	$config['min_height'] = "70";   
					$config['max_width'] = "100";
					$config['max_height'] = "100"; 
		            $this->load->library('upload', $config);
		            $image_up = $this->upload->do_upload('testi_image');
		            if (!$image_up)
		    		{
						$upload = array('error' => $this->upload->display_errors());
					   	$data['upload_error'] = $upload;
					}
					else
					{
						$image_data = array('upload_data' => $this->upload->data());
						$update_array = array (	'user_name' => $this->input->post('name'),
											    'about_client' => $this->input->post('about_client'),
												'user_image' => $image_data['upload_data']['file_name'],
												'user_description' => $this->input->post('description'),
												'status' => $this->input->post('status'),
												'modified' => $date
									  );
						$this->base_model->update ( 'testimonials', $update_array, array('id'=>$id));
						$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
						redirect(base_url().SITE_ADMIN_URI.'/testimonials/');
					}
			}else{
					if($this->input->post('testi_image_hidden')){
					$update_array = array (	'user_name' => $this->input->post('name'),
											'user_image' => $this->input->post('testi_image_hidden'),
											'about_client' => $this->input->post('about_client'),
											'user_description' => $this->input->post('description'),
											'status' => $this->input->post('status'),
											'modified' => $date
										  );
					$this->base_model->update ( 'testimonials', $update_array, array('id'=>$id));
					$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
					redirect(base_url().SITE_ADMIN_URI.'/testimonials/');
					}else{
						$update_array = array (	'user_name' => $this->input->post('name'),
											    'about_client' => $this->input->post('about_client'),
												'user_description' => $this->input->post('description'),
												'status' => $this->input->post('status'),
												'modified' => $date
										  );
						$this->base_model->update ( 'testimonials', $update_array, array('id'=>$id));
						$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
						redirect(base_url().SITE_ADMIN_URI.'/testimonials/');
					}
				}
			}	
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  
		$fields = 'id, user_name,user_description,user_image,status,about_client'; 
		$where[] = array( TRUE, 'id', $id);
		$data['testimonials'] = $this->base_model->get_advance_list('testimonials', $join_tables, $fields, $where, 'row_array');
		$data['main_content'] = 'testimonials/edit';
		$data['page_title']  = 'Testimonials'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'testimonials';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/testimonials/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function delete($id,$pageredirect=null,$pageno) 
	{
		$getImg = $this->base_model->getCommonListFields('testimonials',array('user_image'),array('id' => $id));
		if ($getImg[0]->user_image) 
		{
            @unlink($this->config->item('testi_img') . $getImg[0]->user_image);
        }
		$this->base_model->delete ('testimonials',array('id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/testimonials/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno){
		
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'testimonials');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'testimonials');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('testimonials', array('id' => $id));
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/testimonials/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/testimonials/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
