<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Public_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
		}
		
		public function reset_password($token, $parent = FALSE)
		{	
			$table_name = 'teachers'; 
			if($parent) $table_name = 'parents'; 
			
			$this->load->model('base_model'); 
			/***check valid token ***/
		  	$cond = array(); 
			$cond[] = array(TRUE, 'forgot_pwd_token', $token ); 
			$user_count = $this->base_model->get_records($table_name,'id,email, display_name, forgot_pwd_expire_time', $cond, 'row_array');   
			if(!empty($user_count)){
				if( $user_count['forgot_pwd_expire_time']  >= date('Y-m-d h:i:s') ){
						$data['error'] = FALSE;
						if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
							//$this->form_validation->set_rules('new_password', 'new password','trim|required|min_length[8]|valid_register_password');
							$this->form_validation->set_rules('new_password', 'new password','trim|required');
							$this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|matches[new_password]'); 
							if ($this->form_validation->run())
							{   
								$this->base_model->update($table_name, array('password'=>md5($this->input->post('new_password')), 'forgot_pwd_token'=>'', 'forgot_pwd_expire_time'=>'' ) , array('id'=> $user_count['id']));
 								$this->session->set_flashdata('flash_success_message', $this->lang->line('reset_password_token_success'));
 								$data['error'] = TRUE;
		 					}
						}
				} else{
					$data['error'] = TRUE;
					$this->session->set_flashdata('flash_failure_message', $this->lang->line('reset_password_token_expired'));
				}
			}
			else
			{  
				$this->session->set_flashdata('flash_failure_message', $this->lang->line('reset_password_token_error'));
				$data['error'] = TRUE;
			}
			$data['main_content'] = 'login/reset_password';
		  	$data['page_title']  = 'Reset Password';
		  	$this->load->view(SITE_LAYOUT_PATH, $data); 
		}
}
