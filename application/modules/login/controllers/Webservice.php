<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends Mobile_service_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
		}
		
		/***Login service - Fields - username, password, device_type, device_token, device_imei, device_token_flag ***/
		public function login($parent = FALSE) 
		{     
			$table_name = 'teachers'; $constant = 'TEACHER';  $auth_constant = 'TEACHER';  $field_name = 'teacher_id';
			if($parent){
				$table_name = 'parents'; $constant = 'PARENT'; $auth_constant = ''; $field_name = 'parent_id';
			}
			$result = array(); 
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
					$this->load->model('base_model'); $this->load->model('auth_model'); 
		  			$this->form_validation->set_rules('username', 'Username/Email','trim|required|callback_validate_username[username/email]');
					$this->form_validation->set_rules('password', 'Password', 'trim|required'); 
					$this->form_validation->set_rules('device_type', 'Device type', 'trim|required'); 
					$this->form_validation->set_rules('device_imei', 'Device token', 'trim|required'); 
					$this->form_validation->set_rules('device_token', 'Device Register Id', 'trim|required');
					 
					if ($this->form_validation->run()){
							$user_name = $this->input->post('username');
							$password = $this->input->post('password');
							$response = $this->auth_model->authenticateLogin($user_name,$password,$table_name,$auth_constant);
							if(!empty($response)){
									/*** Check User token avialability ***/
									$imei = $this->input->post('device_imei');  
									$device_type = $this->input->post('device_type'); 
									$device_token = $this->input->post('device_token'); 
									$flag = $this->input->post('device_token_flag'); 	
									$user_type = $this->config->item($constant, 'app_user_type'); 
																	
									$device_user_con = array();
									$device_user_con[] = array(TRUE,'user_id', $response['id']);
									$device_user_con[] = array(TRUE,'user_type', $user_type);									
									$user_devices = $this->base_model->get_records('user_devices', '*', $device_user_con, 'row_array');
									
									$device_token_con = array();
									$device_token_con[] = array(TRUE,'imei_number', $imei);
									$device_token_con[] = array(TRUE,'type', $device_type);									
									$user_mobile_exist = $this->base_model->get_records('user_devices', '', $device_token_con, 'num_rows');
									
									if(empty($user_devices)){
											if($user_mobile_exist <= 0 )
													$device_id = $this->insert_user_device( $response['id'] , $imei, $device_token, $device_type, $constant);
											else
											{
												if($flag == 1 ){
														$this->base_model->delete('user_devices', array('imei_number' => $imei, 'type' =>$device_type ) );
														$device_id = $this->insert_user_device($response['id'] , $imei, $device_token, $device_type, $constant);
												}
												else 
													$result = array('result'=>array( 'status'=> 0 , 'message'=>17 )); //Replace Device Token with existing token";
											}
									}else
									{  
											if($user_devices['imei_number'] == $imei && $user_devices['type'] == $device_type ){
												 if($user_devices['token'] != $device_token )
													 $this->base_model->update('user_devices', array('token'=> $device_token), array('user_id'=>$response['id'], 'user_type'=> $user_type));
											}else
											{ 
												if($flag == 0){   
													if($user_mobile_exist <= 0 )
															$result = array('result'=>array( 'status'=> 0 , 'message'=>18 )); //Existing user -  Replace Device Token with new token";
													else
															$result = array('result'=>array( 'status'=> 0 , 'message'=>19 )); //Existing user - Replace Device Token with existing token";
												}else
												{
														$this->base_model->delete('user_devices', array('imei_number' => $imei, 'type' =>$device_type ) );
														$this->base_model->delete('user_devices', array('user_id' => $response['id'], 'user_type'=> $user_type ));														
														$device_id = $this->insert_user_device($response['id'] , $imei, $device_token, $device_type, $constant);
												}
											}
									}
									if(!empty($result))
									{
										echo json_encode($result);
										return FALSE;
									}
									$this->load->helper('encrypt');
									$quickblox_cond = array();
									$quickblox_cond[] = array( 'TRUE', $field_name, $response['id']);
									$quickblox = $this->base_model->get_records('quickblox_'.$table_name, 'login,password', $quickblox_cond, 'row_array');
									$quickapp = array('quickblox_login'=>'', 'quickblox_password' => ''); 
									if(!empty($quickblox))
										$quickapp = array('quickblox_login'=>$quickblox['login'], 'quickblox_password' => decryptString($quickblox['password']));
									$time = date('Y-m-d H:i:s'); 
									$token = generate_token($response['id']);
									$responseData = array(  
										'username' => $response['username'],
										'user_id' => $response['id'],
										'display_name' => $response['display_name'],
										'email' => $response['email'],
										'last_login' => $time,
										'token' => $token
									);
									$responseData = array_merge($responseData, $quickapp);
									if(!$parent){
										$if_class_teacher = $this->base_model->getCount('sections', array('class_teacher_id'=>$response['id']));
										if($if_class_teacher > 0)
											$responseData = array_merge($responseData, array('is_class_teacher' => 1)); 
										else
											$responseData = array_merge($responseData, array('is_class_teacher' => 0)); 								
									}
									$this->base_model->adv_update($table_name,array('login_count'=>'login_count+1' ),array("id"=>$response['id']), 
											array("last_login_time"=>$time, 'app_token'=>$token, 'app_expire_time'=> date('Y-m-d H:i:s', strtotime("+1 days") )));
									$result = array('result'=>array( 'status'=> 1 , 'message'=>14 ),'login'=> $responseData);  
							}else
							{
									$result = array('result'=>array( 'status'=> 0 , 'message'=>13 ));  //Invalid Crediential";
							}
					}else
					{
						$result = array('result'=>array( 'status'=> 0 , 'message'=>12 ) ,
											 'field_error' => $this->form_validation->error_array() );  //Invalid Params";
					}
			}else
			{
					$result = array('result'=>array( 'status'=> 0 , 'message'=>11 ) );  //Not Post";
			} 
			echo $response = json_encode($result);
			return TRUE;
		}
		
		public function validate_username($val, $field_name){  
				if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $val)) return TRUE;
				if (preg_match('/^[a-zA-Z0-9_]*$/',$val)) return TRUE; 
				$this->form_validation->set_message('validate_username', 'Enter valid '.$field_name);
				return FALSE;
		}	
		
		public function insert_user_device($user_id , $imei, $device_token, $device_type, $constant){
			$device_insert_data = array(
		  		'user_id'=> $user_id, 
		  		'imei_number'=> $imei,
		  		'token'=> $device_token, 
		  		'type'=> $device_type,
		  		'user_type'=> $this->config->item($constant, 'app_user_type')																													
		 	);
		 	return $device_id = $this->base_model->insert('user_devices', $device_insert_data);
		}	
		
		/***Forgot password - Fields - email ***/
		public function forgot_password($parent = FALSE)
		{
			$url = 'teacher';  $table_name = 'teachers';
			if($parent) { $url = 'parent';  $table_name = 'parents'; }
			
			$result = array(); 
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
					$this->load->model('base_model'); $this->load->model('auth_model'); 
		  			$this->form_validation->set_rules('email', 'Email','trim|required|valid_email');
		  			if ($this->form_validation->run()){
		  					$email = $this->input->post('email');
		  					$cond = array(); 
		  					$cond[] = array(TRUE, 'email', $email ); 
		  					$user_count = $this->base_model->get_records($table_name,'id,email, display_name, forgot_pwd_expire_time', $cond, 'row_array');   
		  					if(!empty($user_count))
		  					{	
		  						$token = generate_token($user_count['id']); 
								$this->base_model->update($table_name, array('forgot_pwd_token'=> $token, 'forgot_pwd_expire_time' => date('Y-m-d H:i:s', strtotime("+1 days") ) ), array('id'=>$user_count['id']));
								$this->load->library('email_template');
								$mail_response = $this->email_template->send_mail($user_count['email'], SITE_ADMIN_MAIL, 'Forgot Password Alert for User', 
										array('[##USERNAME##]'=> $user_count['display_name'], 
												'[##PASSCODELINK##]' => base_url() . $url.'/reset_password/' . $token));
								if($mail_response)
										$result = array('result'=>array( 'status'=> 1 , 'message'=>20 ));							
								else
										$result = array('result'=>array( 'status'=> 0 , 'message'=>21 ));
							}else
		  					{
		  						$result = array('result'=>array( 'status'=> 0 , 'message'=>13 ));  //Invalid Email";
		  					}
		  			}
		  			else
					{
						$result = array('result'=>array( 'status'=> 0 , 'message'=>12 ) ,
											 'field_error' => $this->form_validation->error_array() );  //Invalid Params";
					}
		  	}
		  	else
			{
					$result = array('result'=>array( 'status'=> 0 , 'message'=>11 ) );  //Not Post";
			} 
			echo $response = json_encode($result);
			return TRUE;
		}
		
		/***change password - Fields - app_token, user_id, old password , new passwrd, confirm password ***/
		public function change_password($parent = FALSE)
		{
			$table_name = 'teachers';
			if($parent) $table_name = 'parents';
			$result = array(); 
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
					$this->load->model('base_model'); $this->load->model('auth_model'); 
					$this->form_validation->set_rules('app_token', 'app token','trim|required');		
					$this->form_validation->set_rules('user_id', 'user id','trim|required');		
					$this->form_validation->set_rules('old_password', 'old password','trim|required');			
					$this->form_validation->set_rules('new_password', 'new password','trim|required');
					$this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|matches[new_password]'); 
					if ($this->form_validation->run()){
							$response = $this->check_user_token($this->input->post('user_id'), $this->input->post('app_token'), $table_name,$this->input->post('old_password') ); 
							switch(trim($response))
							{
								case 'SUCCESS' :
									$this->base_model->update($table_name, array('password'=>md5($this->input->post('new_password'))) , array('id'=> $this->input->post('user_id')));
		  							$result = array('result'=>array( 'status'=> 1 , 'message'=>14 ) );
		  							break;
		  						case 'INVALID_USER_ID' :
		  							$result = array('result'=>array( 'status'=> 0 , 'message'=>22 ) );
		  							break;
		  						case 'TOKEN_EXPIRED' :
		  							$result = array('result'=>array( 'status'=> 0 , 'message'=>24 ) );
		  							break;
		  						case 'TOKEN_ERROR' :
		  							$result = array('result'=>array( 'status'=> 0 , 'message'=>23 ) ); 
		  							break;
		  						case 'OLD_PASSWORD_ERROR' :
		  							$result = array('result'=>array( 'status'=> 0 , 'message'=>13 ) );
		  						default : 
		  							break; 
							}
		  			}
		  			else
					{
						$result = array('result'=>array('status'=> 0 , 'message'=>12 ),'field_error' => $this->form_validation->error_array() );  //Invalid Params";
					}
		  	}
		  	else
			{
					$result = array('result'=>array( 'status'=> 0 , 'message'=>11 ) );  //Not Post";
			} 
			echo $response = json_encode($result);
			return TRUE;
		}
}
