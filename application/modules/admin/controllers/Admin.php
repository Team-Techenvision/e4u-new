<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	  	function __construct()
  		{

    		parent::__construct();
			$this->load->library('form_validation');
			$this->load->language(array('flash_message','form_validation'), 'english');
			getSearchDetails($this->router->fetch_class());
			$this->load->model('base_model'); 
			$this->load->model('Admin_model'); 
		}

		/******** Admin login function *******/
		public function index()
		{  
               
			
				if($this->session->has_userdata('admin_is_logged_in')){
						redirect(SITE_ADMIN_URI.'/dashboard');
			  	}else{ 
                 
                    
			
			    
				  	$data = array(); 
				  	if ($this->input->server('REQUEST_METHOD') === 'POST'){ 

                    
			
				  			$this->load->model('base_model'); $this->load->model('auth_model'); 
				  			$this->form_validation->set_rules('username', 'Username/Email','trim|required|callback_validate_username[username/email]');
							$this->form_validation->set_rules('password', 'Password', 'trim|required'); 
							if ($this->form_validation->run()){
								$user_name = $this->input->post('username');
								$password = $this->input->post('password');
								
								$response = $this->auth_model->authenticateLogin($user_name,$password,'admin_users','SUPER_ADMIN');

								 
								if(!empty($response)){
										$time = date('d-M-Y H:i'); 
										//$time = date('Y-m-d H:i:s'); 
										$data = array( 'admin_is_logged_in' => array(
											'admin_username' => $response['username'],
										 	'admin_user_id' => $response['id'],
											'admin_display_name' => $response['display_name'],
											'admin_email' => $response['email'],
											'admin_last_login' => $time
										) );
										//var_dump($data);
										$this->session->set_userdata($data); 
										$this->session->set_flashdata('flash_success_message', $this->lang->line('login_success'));
										$this->base_model->adv_update('admin_users',array('login_count'=>'login_count+1'),array("id"=>$response['id']), array("last_login_time"=>$time));
										redirect(SITE_ADMIN_URI.'/dashboard');
								}else
								{
										$this->session->set_flashdata('flash_failure_message', $this->lang->line('login_failure'));	
								}								
							}
							
				  	}
				  	$data['main_content'] = 'admin/login';
				  	$data['page_title']  = 'Admin Login';
				  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 
				} 
		}
		
		public function dashboard(){ 
					if(!$this->session->has_userdata('admin_is_logged_in')){
						redirect(SITE_ADMIN_URI);
			  		} 
					#total inquiry
					$enq_cond=array("status"=>0);
					$data["new_inquries"]=$this->Admin_model->get_counts("enquiries",$enq_cond); 
					#total certificate
					$cert_cond=array("status"=>1);
					$data["total_certificate"]=$this->Admin_model->get_counts("certificate",$cert_cond); 
					#course purchased
					$course_cond=array("status"=>1,"course_type"=>2);
					$data["total_course"]=$this->Admin_model->get_counts("user_plans",$course_cond); 
					#total user 
					$data["total_users"]=$this->Admin_model->get_counts("users"); 
					#active user 
					$data["active_users"]=$this->Admin_model->get_counts("users",array("status"=>1)); 
					#Inactive user 
					$data["inactive_users"]=$this->Admin_model->get_counts("users",array("status"=>0));
					#test_today
					$data_today=date("Y-m-d 00:00:00");
					$data_today_end=date("Y-m-d 23:59:00");
					$course_cond=array("test_type !="=>0,"start_date>="=>$data_today,"start_date<="=>$data_today_end);
					$data["test_today"]=$this->Admin_model->get_counts("test_engagement",$course_cond);

					#surprise test_today
					$course_cond=array("status"=>1,"test_type"=>1,"start_date>="=>$data_today);
					$data["progress_today"]=$this->Admin_model->get_counts("test_engagement",$course_cond); 
					#progress test_today
					$course_cond=array("status"=>1,"test_type"=>2,"start_date>="=>$data_today);
					$data["surprise_today"]=$this->Admin_model->get_counts("test_engagement",$course_cond); 
					#total test 
					$course_cond=array("test_type !="=>0);
					$data["total_test"]=$this->Admin_model->get_counts("test_engagement",$course_cond); 
					#total progress test 
					$course_cond=array("status"=>1,"test_type "=>1);
					$data["total_Protest"]=$this->Admin_model->get_counts("test_engagement",$course_cond);
					#total surprise test 
					$course_cond=array("status"=>1,"test_type "=>2);
					$data["total_surprisetest"]=$this->Admin_model->get_counts("test_engagement",$course_cond);

					#register today 
					$today=date('Y-m-d 00:00:00');
					$today_end=date('Y-m-d 23:59:59');
					$cond1=array("created >="=>$today,"created <="=>$today_end);
					$data["today_total_users"]=$this->Admin_model->get_counts("users",$cond1);

					#course purchased today
					$cond2=array("status"=>1,"course_type"=>2,"created >="=>$today,"created <="=>$today_end);
					$data["total_course_purchase_today"]=$this->Admin_model->get_counts("user_plans",$cond2); 

					#total certificate
					$cond3=array("status"=>1,"created >="=>$today,"created <="=>$today_end);
					$data["total_certificate_today"]=$this->Admin_model->get_counts("certificate",$cond3); 

					#total material upload
					$cond4=array("created >="=>$today,"created <="=>$today_end, "status="=>0);
					$data["total_material_upload_today"]=$this->Admin_model->get_counts("downloads",$cond4); 

					#total inquiry today
					$cond5=array("status"=>0,"created >="=>$today,"created <="=>$today_end);
					$data["new_inquries_today"]=$this->Admin_model->get_counts("enquiries",$cond5); 

					$data['main_content'] = 'admin/dashboard';
				  $data['page_title']  = 'Admin Dashboard';
					$this->load->view(ADMIN_LAYOUT_PATH, $data); 
		}
		public function profile()
		{ 
			if(!$this->session->has_userdata('admin_is_logged_in')){
				redirect(SITE_ADMIN_URI);
	  		} else
	  		{
			$data = array();
			$admin_id = $this->session->userdata('admin_is_logged_in');
			$id = $admin_id["admin_user_id"];
			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{ 
				$this->load->model('base_model');
				$this->form_validation->set_rules('uname', 'User Name', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
				$this->form_validation->set_rules('dname', 'Display Name', 'trim|required');
				$this->form_validation->set_rules('address', 'Address', 'trim|required');
				$this->form_validation->set_rules('phone', 'Phone number', 'trim|required|numeric|exact_length[10]');
				if ($this->form_validation->run())
				{                                                                                  
					$where = "id=".$id;
					$update_array = array('username'=> $this->input->post('uname'),
										  'email' => $this->input->post('email'),
										  'display_name' => $this->input->post('dname'),
										  'address' => $this->input->post('address'),
										  'phone_number' => $this->input->post('phone')
										  );
					$update1 = $this->base_model->update('admin_users',$update_array,$where);
					$data = array( 'admin_is_logged_in' => array(
											'admin_username' => $this->input->post('uname'),
											'admin_display_name' => $this->input->post('dname'),
											'admin_email' => $this->input->post('email') ,
											'admin_user_id' => $id 
										) );

							$this->session->set_userdata($data); 
					
							$this->session->set_flashdata('flash_success_message', $this->lang->line('profile'));
				}
				$data['post'] = TRUE;
			}
			$join_tables = array();
			$where = array();
			$fields = 'id,username,email,phone_number,address,display_name'; 
			$where[] = array( TRUE, 'id', $id);
			$data['profile'] = $this->base_model->get_advance_list('admin_users', $join_tables, $fields, $where, 'row_array');
			$data['main_content'] = 'admin/profile';
		  	$data['page_title']  = 'Profile';
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data);
		  	}
		}
		public function validate_username($val, $field_name){  
				if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $val)) return TRUE;
				if (preg_match('/^[a-zA-Z0-9_]*$/',$val)) return TRUE; 
				$this->form_validation->set_message('validate_username', 'Enter valid '.$field_name);
				return FALSE;
		}
		public function forgot_password(){ 
			if($this->session->has_userdata('admin_is_logged_in')){
				redirect(SITE_ADMIN_URI.'/dashboard');
			}else{
				$data = array();
				if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
					$this->load->model('base_model');
					$this->form_validation->set_rules('username', 'Username/Email', 'trim|required|callback_validate_username[username/email]');
					if ($this->form_validation->run()){
						$username = $this->input->post('username');
						$count = $this->base_model->getCount('admin_users',array('username' => $username));
						if($count == 0){
							$this->session->set_flashdata('flash_failure_message', $this->lang->line('invalid_username'));	
						}else{	
							
							$uid = rand();
							$this->load->helper('date');
							$my_date = date("Y-m-d h:i:s", time());
							
							if($this->base_model->update('admin_users', array('uid' => $uid,'uid_request_date' => $my_date), array('username' => $this->input->post('username'),'id' => '1'))){
									$username = $this->input->post('username');
									$cond = array();
									$cond[] = array(TRUE, 'username', $username ); 
									$maildetails = $this->base_model->get_records('admin_users','id,email, display_name, uid_request_date', $cond, 'row_array');   
								
									/* email send to admin */
									$this->load->library('email');
									$email_config_data = array('[USERNAME]'=> $maildetails['display_name'], 
															   '[PASSCODELINK]' => $this->config->item('admin_resetpassword_url'). $uid,
															   '[SITE_NAME]' => $this->config->item('site_name'));
								  					   
									$this->email->from("noreply@e4u.com","e4u");
									$this->email->to("malarvizhi@blazedream.com");
									$this->email->subject('Forgot Password Alert for User');
									$cond = array();
									$cond[] = array(TRUE, 'id', 1 ); 
									$mailcontent = $this->base_model->get_records('email_templates','id,email_content', $cond, 'row_array');   
									
									foreach($email_config_data as $key => $value){
										$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
									}
									$this->email->message($mailcontent['email_content']);
									$result= $this->email->send();
									if($result){
										$this->session->set_flashdata('flash_success_message', $this->lang->line('mail_sent'));
									}else{
										$this->session->set_flashdata('flash_failure_message', $this->lang->line('mail_fail'));
									}
									
									
							
							}
						
						}
					}
				}
				$data['main_content'] = 'admin/forgot_password';
			  	$data['page_title']  = 'Forgot Password';
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data);
		  	} 
		}
		public function reset_password($uid){ 
			if($this->session->has_userdata('admin_is_logged_in')){
				redirect(SITE_ADMIN_URI.'/dashboard');
			}else{
				$data = array();
				if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
					$this->load->model('base_model');
					$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
					$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
					if ($this->form_validation->run()){
						
 						$count = $this->base_model->getCount('admin_users', array('uid' => $uid));
						if ($count == 0) {
							$this->session->set_flashdata('flash_failure_message', $this->lang->line('reset_password_error'));
						}else {
							$new_member_insert_data = array(
								'password' => md5($this->input->post('new_password')),
								'uid' => ''
							);
							$update = $this->base_model->update('admin_users', $new_member_insert_data, array('uid' => $uid));
							if($update){
								$this->session->set_flashdata('flash_success_message', $this->lang->line('reset_password'));
							}
						}
 						
					}
				}
				$data['main_content'] = 'admin/reset_password';
			  	$data['page_title']  = 'Reset Password';
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data);
		  	} 
		}
		
		public function change_password(){ 
				if(!$this->session->has_userdata('admin_is_logged_in')){
					redirect(SITE_ADMIN_URI);
		  		} 
		  		else{
				$data = array();
				if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
					$this->load->model('base_model');
					$this->form_validation->set_rules('current_password', 'current password', 'callback_validate_currentpassword[Current Password]');
					$this->form_validation->set_rules('new_password', 'new password', 'trim|required|min_length[6]');
					$this->form_validation->set_rules('confirm_password', 'confirm password', 'min_length[6]|callback_validate_password['.$this->input->post('current_password').','.$this->input->post('confirm_password').','.$this->input->post('new_password').']');
					
					if ($this->form_validation->run()){
						$update1 = $this->base_model->update('admin_users', array('password'=>md5($this->input->post('new_password'))) , array('id'=> $this->session->userdata['admin_is_logged_in']['admin_user_id'],'password'=> md5($this->input->post('current_password'))));
						if($update1){		
								unset($_POST);					
								$this->session->set_flashdata('flash_success_message', $this->lang->line('change_password'));
								if ($this->session->has_userdata('admin_is_logged_in')) {
									 $this->session->unset_userdata('admin_is_logged_in');
								}
								redirect(SITE_ADMIN_URI);								
							}
 						
					}
				}
				$data['main_content'] = 'admin/change_password';
			  	$data['page_title']  = 'Change Password';
			  	$data['current_pwd'] = md5($this->input->post('current_password'));
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data);
		  	}
		}
		public function logout(){
			$session_userdata = array('admin_is_logged_in');
			$this->session->unset_userdata($session_userdata);
			if (!$this->session->has_userdata('is_logged_in')) {
				 $this->session->sess_destroy();
			}
			redirect(SITE_ADMIN_URI);
		}
		public function validate_currentpassword($val, $field_name){  			
				$count = $this->base_model->getCount('admin_users',array('password' => md5($val) ,'id' => $this->session->userdata['admin_is_logged_in']['admin_user_id']));
				if($count == 0){
					$this->form_validation->set_message('validate_currentpassword', 'Enter the valid current password.');
					return FALSE;
				}
		}		
		public function validate_password($val, $args){		
			$s = explode(",", $args);
			if(md5($s[0])==md5($s[1])){
				$this->form_validation->set_message('validate_password', 'Current password and new password must not be same');			
				return FALSE;
			}	
			if(md5($s[1])!=md5($s[2])){
				$this->form_validation->set_message('validate_password', 'confirm new password and new password must be same');			
				return FALSE;
			}

		}
		
		

}
