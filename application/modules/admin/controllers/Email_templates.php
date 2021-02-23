<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email_templates extends Admin_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
			if(!$this->session->has_userdata('admin_is_logged_in')){
					redirect(SITE_ADMIN_URI);
			}
			getSearchDetails($this->router->fetch_class());
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
			  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/email_templates";
			 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
			  	$config["uri_segment"] = 3;
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
			  	$fields = 's.id, s.name, s.subject, s.description'; 
			  	$where[] = array( TRUE, 's.is_active', 1);
			  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('email_templates as s', $join_tables, $fields, $where, 'num_rows','','','s.id');
			  	$data['email_templates'] = $this->base_model->get_advance_list('email_templates as s', $join_tables, $fields, $where, '', 's.id', 'desc', 's.id', $limit_start, $limit_end);
			   $this->pagination->initialize($config);
				$data['main_content'] = 'email_templates/index';
			  	$data['page_title']  = 'Email templates'; 
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function reset()
		{
			$this->session->unset_userdata('search_name');
			redirect(base_url().SITE_ADMIN_URI.'/email_templates/');
		}
		public function edit($id = NULL)
		{
				$data['post'] = FALSE;
				if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
							$this->form_validation->set_rules('subject', 'Subject','trim|required');
							$this->form_validation->set_rules('description', 'Description', 'trim|required'); 
							$this->form_validation->set_rules('email_content', 'Email Content', 'trim|required'); 							
							if ($this->form_validation->run())
							{   
									$update_array = array ('subject' => $this->input->post('subject'),
																	'description'=> $this->input->post('description'),
																	'email_content' => $this->input->post('email_content') );
									$this->base_model->update ( 'email_templates', $update_array, array('id'=>$id));
	 								$this->session->set_flashdata('flash_success_message', $this->lang->line('email_template_edit'));
							}
							$data['post'] = TRUE;
				}
				$join_tables = $where = array();  $fields = 's.id, s.name, s.subject, s.description, s.email_content, s.email_variables'; 
			  	$where[] = array( TRUE, 's.is_active', 1);
			  	$where[] = array( TRUE, 's.id', $id);
			  	$data['email_templates'] = $this->base_model->get_advance_list('email_templates as s', $join_tables, $fields, $where, 'row_array');
			  	if(empty($data['email_templates'])){
			  		$this->session->set_flashdata('flash_failure_message', $this->lang->line('invalid_url'));
					redirect(SITE_ADMIN_URI.'/email_templates');
				}
				$data['main_content'] = 'email_templates/edit';
			  	$data['page_title']  = 'Email templates'; 
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
}
