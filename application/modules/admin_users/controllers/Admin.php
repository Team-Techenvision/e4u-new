<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
			$this->load->library('form_validation');
			$this->load->language(array('flash_message','form_validation'), 'english');
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
										$data = array( 'admin_is_logged_in' => array(
											'admin_username' => $response['username'],
											//'admin_is_logged_in' => true,
										 	'admin_user_id' => $response['id'],
											'admin_display_name' => $response['display_name'],
											'admin_email' => $response['email'],
											'admin_last_login' => $time
										) );
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
				  	$data['main_content'] = 'admin_users/login';
				  	$data['page_title']  = 'Admin Login';
				  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 
				} 
		}
		
		public function dashboard(){ 
					if(!$this->session->has_userdata('admin_is_logged_in')){
						redirect(SITE_ADMIN_URI);
			  		}
					$data['main_content'] = 'admin_users/dashboard';
				  	$data['page_title']  = 'Admin Dashboard';
					$this->load->view(ADMIN_LAYOUT_PATH, $data); 
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
							echo "forgot password link";
							echo "email tenplate comes here";
							echo "reset passowrd"; die;
						}
					}
				}
				$data['main_content'] = 'admin_users/forgot_password';
			  	$data['page_title']  = 'Forgot Password';
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data);
		  	} 
		}
		public function reset_password(){ 
			if($this->session->has_userdata('admin_is_logged_in')){
				redirect(SITE_ADMIN_URI.'/dashboard');
			}else{
				$data = array();
				if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
					$this->load->model('base_model');
					$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
					$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
					if ($this->form_validation->run()){
						$this->base_model->update('admin_users', array('password'=>md5($this->input->post('new_password'))) , array('id'=> 1));
 						$this->session->set_flashdata('flash_success_message', $this->lang->line('reset_password'));
					}
				}
				$data['main_content'] = 'admin_users/reset_password';
			  	$data['page_title']  = 'Reset Password';
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
}
