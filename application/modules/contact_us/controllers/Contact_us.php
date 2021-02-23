<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_us extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		 
		$this->load->library('form_validation');
		$this->load->language(array('flash_message','form_validation'), 'english');			
		$this->load->model(array('base_model','contact_us/contact_model')); 

		// $this->load->helper("function_helper");	
		// if(!is_loggedin()) {
		// 		redirect();	
		// 	}
			
		$this->load->helper("profile_helper");
		compare_session();
	}
	public function index()
	{
		if(isset($_GET['id']) && $_GET['view_mode']=="app"){
			$user_id = $_GET['id'];
			$fields = 'u.id,u.first_name,u.last_name,u.email,phone'; 	
			$join_tables= array();
 
			$where[] = array(TRUE,'u.id',$user_id);  
			$data['users'] = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where, '', '', '', array('u.id'));
		}
		
		$user_arr=$this->session->userdata('user_is_logged_in');
		if(isset($user_arr['user_id']))
		{
			$fields = 'u.id,u.first_name,u.last_name,u.email,phone'; 	
			$join_tables= array();
 
			$where[] = array(TRUE,'u.id',$user_arr['user_id']);  
			$data['users'] = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where, '', '', '', array('u.id'));
		}
		
		$contact = $this->contact_model->contact();
		$data['contact'] = $contact;
		$data['main_content'] = 'contact_us/index';
		$data['page_title']  = 'e4u'; 
		$user_arr=$this->session->userdata('user_is_logged_in');
		if(count($user_arr)){
			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
		}
		else{
			$this->load->view(SITE_LAYOUT_PATH, $data);
		}
	}
	public function privacy()
	{
		$content = $this->contact_model->cms_content('23');
		
		$data['content'] = $content;
		$data['main_content'] = 'contact_us/privacy';
		$data['page_title']  = $content['title']; 
		$user_arr=$this->session->userdata('user_is_logged_in');
		if(count($user_arr)){
			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
		}
		else{
			$this->load->view(SITE_LAYOUT_PATH, $data);
		}
	}
	public function about_us()
	{
		$content = $this->contact_model->cms_content('24');
		
		$data['content'] = $content;
		$data['main_content'] = 'contact_us/about_us';
		$data['page_title']  = $content['title']; 
		$user_arr=$this->session->userdata('user_is_logged_in');
		if(count($user_arr)){
			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
		}
		else{
			$this->load->view(SITE_LAYOUT_PATH, $data);
		}
	}
	public function enquiry()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 
			$this->form_validation->set_rules('first_name', 'First Name','trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name','trim|required');
			$this->form_validation->set_rules('phone_no', 'Phone No','trim|required');
			$this->form_validation->set_rules('email_id', 'Email ID','trim|required|valid_email');
			$this->form_validation->set_rules('message', 'Message','trim|required');
			if($this->form_validation->run() == false){  
				echo $this->form_validation->get_json(); die;
			}else{  
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'first_name' => $this->input->post('first_name'),
										'last_name' => $this->input->post('last_name'),
										'phone' =>  $this->input->post('phone_no'),
										'email' =>  $this->input->post('email_id'),
										'message' =>  $this->input->post('message'),
										'status' => 0,
										'created' => $date
									  );
				$update = $this->base_model->insert('enquiries', $update_array);
				/* email send to user */
				$cond = array();
				$cond[] = array(TRUE, 'id', 11 );
				$user_email_id = $this->input->post('email_id');
				$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');  
				$this->load->library('email');
				
				//added start
				$smtp_mail = $this->config->item('smtp_mail');
				$this->email->initialize($smtp_mail);
				//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");
				
				$email_config_data = array('[USERNAME]'=> $this->input->post('first_name').' '.$this->input->post('last_name'),
										   '[SITE_NAME]' => $this->config->item('site_name'));
			  					   
				$this->email->from($smtp_mail['smtp_user'],"e4u");
				$this->email->to($user_email_id);
				$this->email->subject($mailcontent['subject']);
				
				foreach($email_config_data as $key => $value){
					$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
				}
				$this->email->message($mailcontent['email_content']);
				$result= $this->email->send();
				
				/* email send to admin */
				$cond2 = array();
				$cond2[] = array(TRUE, 'id', 10 );
				$mailcontent2 = $this->base_model->get_records('email_templates','id,email_content,subject', $cond2, 'row_array'); 
				$admin_details = $this->base_model->get_records('admin_users','id,email','1','row_array');
				$this->load->library('email');
				//added start
				$smtp_mail = $this->config->item('smtp_mail');
				$this->email->initialize($smtp_mail);
				//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");
				$email_config_data2 = array('[USERNAME]'=> $this->input->post('first_name').' '.$this->input->post('last_name'),
											'[FIRSTNAME]' => $this->input->post('first_name'),
											'[LASTNAME]' => $this->input->post('last_name'),
										    '[PHONE]'=> $this->input->post('phone_no'),
										    '[EMAILID]'=> $this->input->post('email_id'),
										    '[COMMENTS]'=> $this->input->post('message')
										    );
			  					   
				$this->email->from($smtp_mail['smtp_user'],"e4u");
				$this->email->to($admin_details['email']);
				$this->email->subject($mailcontent2['subject']);
				
				foreach($email_config_data2 as $key => $value){
					$mailcontent2['email_content'] = str_replace($key, $value, $mailcontent2['email_content']);
				}
				$this->email->message($mailcontent2['email_content']);
				$result2= $this->email->send();
				if($update)
				{
					echo json_encode(array('status' => 'success')); die;
				}
			}
		}
	}
	public function enquiry_success()
	{
		if(isset($_GET['id'])){
		$data['user_id'] = $_GET['id'];}
		$data['main_content'] = 'contact_us/enquiry_success';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
	}
	
}
