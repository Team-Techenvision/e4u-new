<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends Mobile_service_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
		}
		
		/***Login service - Fields - username, password, device_type ***/
		public function login($parent = FALSE) 
		{    
			$this->load->helper('thumb_helper');
			$result = array(); 
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
					$this->load->model('base_model'); 
		  			$this->form_validation->set_rules('email', 'Email','trim|required|valid_email');
					$this->form_validation->set_rules('password', 'Password', 'trim|required'); 
					$this->form_validation->set_rules('device_type', 'Device type', 'trim|required'); 
					$this->form_validation->set_rules('device_id', 'device id', 'trim|required'); //modified
					$this->form_validation->set_rules('device_auth', 'device auth', 'trim|required'); //modified
					if ($this->form_validation->run()){
							$date = date('Y-m-d H:i:s');
							$email = $this->input->post('email');
							$password = $this->input->post('password');
							$device_auth = $this->input->post('device_auth');
							$device_id = $this->input->post('device_id');
							$fields = 'id,first_name,last_name,email,course_id,class_id,medium_id,
							profile_image,status,login_count,board,address, imei'; //modified
							$where_cond[] = array( TRUE, 'email', $email);
							$where_cond[] = array( TRUE, 'password', md5($password));
							$response = $this->base_model->get_advance_list('users','',$fields,$where_cond, 'row_array');
							$course_list= array();
							$class_list= array();
							$class_id = 0;
							$course_id  = 0;
							if(!empty($response)){										
							if($response['imei']!=""){												
								if($response['imei'] == $this->input->post('device_id')){	
									$result = $this->getUserdetails($response);	
								}else{
									$result = array('success'=> 0, 'message'=> 'This account has been logged in another device.'); 
								}								
							}elseif($response['imei']=="" && $device_auth =="true"){
								$imei_count = $this->base_model->getCount('users',array('imei' => $this->input->post('device_id')));
								if($imei_count == 0){								
									$update_array = array('imei'=>$device_id,
														 		'modified' => $date
														 		);
									$this->base_model->update ( 'users', $update_array, array('id'=>$response["id"]));
									$result = $this->getUserdetails($response);
								}else{
									$result = array( 'success'=> 0 , 'message'=> 'This device has been registered on another account.' ) ;
								}
							}else{
								$result = array( 'success'=> 0, 'message'=>'Invalid device auth', 'data'=> "Do you want to register this device?");  								
							}								
								
							}else{
									$result = array('success'=> 0, 'message'=> 'Invalid Login Credentials' ); 
							}
					}else
					{
						$result = array( 'success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
					}
			}else
			{
					$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
			} 
			echo $response = json_encode($result);
			return TRUE;
		}
	// reg fields are username(contains first name and lastname), email, phone, password
	public function register()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->load->model('base_model'); 
			$this->form_validation->set_rules('device_type', 'Device type', 'trim|required'); 
			$this->form_validation->set_rules('first_name', 'first name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'last name', 'trim|required');
			$this->form_validation->set_rules('email', 'email id', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[12]');
			$this->form_validation->set_rules('confirm-password', 'confirm password', 'trim|required|matches[password]');
			$this->form_validation->set_rules('contact-number', 'contact number', 'trim|required|numeric');
			$this->form_validation->set_rules('device_id', 'device id', 'trim|required'); 
			$this->form_validation->set_rules('gender', 'gender', 'trim|required');
			if ($this->form_validation->run()){
				$count = $this->base_model->getCount('users',array('email' => $this->input->post('email')));
				if($count != 0){
					$result = array( 'success'=> 0 , 'message'=> 'This email id already exists.Please enter unique email id.' ) ;  
				}else{
					$imei_count = $this->base_model->getCount('users',array('imei' => $this->input->post('device_id')));
					if($imei_count != 0){
						$result = array( 'success'=> 0 , 'message'=> 'This device has been registered on another account.' ) ;  
					}else{
						$date = date('Y-m-d H:i:s');
						$uid = rand();
				
						$data = array('first_name' => $this->input->post('first_name'),
									  'last_name' => $this->input->post('last_name'),
									  'email' => $this->input->post('email'),
									  'password' => md5($this->input->post('password')),
									  'phone' => $this->input->post('contact-number'),
									  'gender' => $this->input->post('gender'),									  
									  'status' => 0,
									  'created' => $date,
									  'uid_request_date' => $date,
									  'uid' => $uid,
									  'imei' => $this->input->post('device_id')
									  );
						$this->base_model->insert('users',$data);
						$cond = array();
						$cond[] = array(TRUE, 'id', 4 ); 
						$mailcontent = $this->base_model->get_records('email_templates','id,subject,email_content', $cond, 'row_array');   
						/* email send to user */
						$this->load->library('email');
						$email_config_data = array('[USERNAME]'=> $this->input->post('first-name'), 
													'[ACTIVELINK]' => $this->config->item('site_user_activate_url'). $uid,
													'[SITE_NAME]' => $this->config->item('site_name'));
					  					   
						$this->email->from("noreply@e4u.com","e4u");
						$this->email->to($this->input->post('email'));
						$this->email->subject($mailcontent['subject']);
				
						foreach($email_config_data as $key => $value){
							$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
						}
						$this->email->message($mailcontent['email_content']);
						$result= $this->email->send();
				
						$result = array( 'success'=> 1 , 'message'=> 'Registration done successfully,Verification Email is sent to your registered Email ID. Please verify your account to login' ) ;  
					}
				}
			}else{
				$result = array( 'success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		}
		echo $response = json_encode($result);
		return TRUE;
	}
	public function forgot_password()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->load->model('base_model'); 
			$this->form_validation->set_rules('email', 'email id', 'trim|required|valid_email');
			$this->form_validation->set_rules('device_type', 'Device type', 'trim|required'); 
			if ($this->form_validation->run()){
				$forgot_email = $this->input->post('email');
				$fields = 'id'; 
				$where_cond[] = array( TRUE, 'email', $forgot_email);
				$response = $this->base_model->get_advance_list('users','',$fields,$where_cond, 'row_array');
				
				if($response['id']){
					$valid_email=1;
					$uid = rand();
					$this->load->helper('date');
					$my_date = date("Y-m-d h:i:s", time());
					if($this->base_model->update('users',array('uid_request_date' => $my_date), array('email' => $forgot_email))){
						$cond = array();
						$cond[] = array(TRUE, 'email', $forgot_email ); 
						$maildetails = $this->base_model->get_records('users','id,concat(first_name," ", last_name) as username,email', $cond, 'row_array');  
					 	$encode = base64_encode($maildetails['id']);
					 	$cond = array();
					 	$cond[] = array(TRUE, 'id', 1 ); 
						$mailcontent = $this->base_model->get_records('email_templates','id,subject,
						email_content', $cond, 'row_array');   
						/* email send to user */
						$this->load->library('email');
						$email_config_data = array('[USERNAME]'=> $maildetails['username'], 
												   '[PASSCODELINK]' => $this->config->item('site_resetpassword_url'). $encode,
												   '[SITE_NAME]' => $this->config->item('site_name'));
						$this->email->from("noreply@e4u.com","e4u");
						$this->email->to($forgot_email);
						$this->email->subject($mailcontent['subject']);
						
			
						foreach($email_config_data as $key => $value){
							$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
						}
						$this->email->message($mailcontent['email_content']);
						$result= $this->email->send();
						if($result){
							$this->base_model->update('users', array('uid_status' => 1), array('email' => $forgot_email));
					
						}else{
							$this->base_model->update('users', array('uid_status' => 1), array('email' => $forgot_email));
						}
						$result = array( 'success'=> 1 , 'message'=> 'Email Sent Successfully' ) ;  
					}
				}else{
					$result = array( 'success'=> 0 , 'message'=> 'Email Id Does not Exists');
				}
			}else{
				$result = array( 'success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		}
		echo $response = json_encode($result);
		return TRUE;
	}
	public function push_notification_all(){
		push_notification();
	}
	public function getUserdetails($response){
		if($response['status'] == 1){
				$time = date('Y-m-d H:i:s'); 
				$token = generate_token($response['id']);
				$join_tables[] = array('orders as o','o.id = up.order_id');
				$wher[] = array( TRUE, 'up.user_id', $response['id']);
				$wher[] = array( TRUE, 'o.order_status', 1);
				$course_id = $this->base_model->get_advance_list('user_plans as up', $join_tables, 'up.course_id', $wher, 'result_array');
				if(!empty($course_id)){
					foreach($course_id as $key){
						$course_list[] = $key['course_id'];
						$class_wher[] = array( TRUE, 'course_id', $key['course_id']);
						$class_id = $this->base_model->get_advance_list('relevant_classes','','class_id',$class_wher,'result_array');
						unset($class_wher);
						if(!empty($class_id)){
							foreach($class_id as $class){
								$class_list[$key['course_id']][] = $class['class_id'];
							}
						}else{
							$class_list[$key['course_id']][] = 0;
						}
					}
				}
				if(empty($course_list)) $course_list=0;
				if(empty($class_list)) $class_list=0;
				if($response['profile_image'] != ""){
					$img_src = thumb($this->config->item('profile_image_url') .$response['profile_image'] ,'178', '178', 'thumb_profile_img',FALSE);
					$profile_image = base_url() . 'appdata/profile/thumb_profile_img/'.$img_src;
				}else{
					$profile_image = '';
				}
				if($response['medium_id']==0 || $response['class_id']==0 || $response['board']=="" || $response['address']=="")
				{
					$first_login = 1;
				}
				else
				{
					$first_login = 0;
				}
				$responseData = array(  
					'username' => $response['first_name'],
					'user_id' => $response['id'],
					'display_name' => $response['first_name']." ".$response['last_name'],
					'email' => $response['email'],
					'course_id' => $course_list,
					'class_id' => $class_list,
					'medium_id' => $response['medium_id'],
					'last_login' => $time,
					'is_first_login' => $first_login,
					'token' => $token,
					'profile_image' => $profile_image
				);
			
			
				$this->base_model->adv_update('users',array('login_count'=>'login_count+1' ),array("id"=>$response['id']), 
						array("last_login_time"=>$time, 'app_token'=>$token, 'app_expire_time'=> date('Y-m-d H:i:s', strtotime("+1 days") )));
				$result = array( 'success'=> 1, 'message'=>'login successfully', 'data'=> $responseData);  
				return $result;
		}else{
			$result = array('success'=> 0, 'message'=> 'Your account is In-active/Blocked' ); 
			return $result;
		}		
	}
}
