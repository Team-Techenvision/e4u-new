<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Mobile_service_Controller
{
	  	function __construct()
  		{
  			parent::__construct();
			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
		}
		public function update_profile(){  
			$this->load->model('base_model'); 
			$result = array();
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$user_id = $this->input->post('user_id');
				$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
				$this->form_validation->set_rules('user_id', 'user id','trim|required');
				$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
				$this->form_validation->set_rules('first_name', 'first name', 'trim|required');
				$this->form_validation->set_rules('last_name', 'last name', 'trim|required');
				$this->form_validation->set_rules('email', 'email id','trim|required|valid_email');
				$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|numeric|regex_match[/^[0-9]+$/]|exact_length[10]'); 
				$this->form_validation->set_rules('address', 'Address', 'trim|required');
				$this->form_validation->set_rules('medium', 'Medium','trim|required');	
				$this->form_validation->set_rules('gender', 'gender','trim');				
				$this->form_validation->set_rules('board', 'Study Board','trim|required');					
				$this->form_validation->set_rules('class', 'Class','trim|required');
				
				if($this->form_validation->run()){
					
					$oauth_token = $this->input->post('oauth_token');
					$new_pass = $this->input->post('new_password');
					$current_pass = $this->input->post('current_password');
					$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
					switch($response){
						case 'TOKEN_ERROR':
							$result = array('success'=> 0 , 'message'=> 'Invalid Token');
							break;
						case 'INVALID_USER_ID':
							$result = array('success'=> 0 , 'message'=> 'Invalid user');
							break;
						case 'INACTIVATE_USER_ID':
							$result = array('success'=> 0 , 'message'=> 'Inactivate user');
							break;
						case 'SUCCESS':
							$join_tables1 = $where = array(); 
							$where1[] = array( TRUE, 'id', $this->input->post('user_id'));
							$where1[] = array( TRUE, 'app_token', $this->input->post('oauth_token'));
							$fields1 = 'email'; 
							$getValues = $this->base_model->get_advance_list('users', $join_tables1, $fields1, $where1, 'row_array');
							if($this->input->post('email') != $getValues['email']) {
								$count = $this->base_model->getCount('users',array('email' => $this->input->post('email')));
								if($count != 0){
									$result = array( 'success'=> 0 , 'message'=> 'This email id already exists.Please enter unique email id.' ) ;  
								}else{
									$date = date('Y-m-d H:i:s');
									/*$name = explode(" ",$this->input->post('user-name'));
									$first_name = ($name[0]) ? $name[0] : '';
									$last_name = '';
									for($i=1;$i<count($name);$i++){
										if($i != 1){ $last_name .= " ".$name[$i]; }else{ $last_name .= $name[$i]; }
									}*/
									$update_array = array (	'first_name' => $this->input->post('first_name'),
															'last_name' => $this->input->post('last_name'),
															'email' => $this->input->post('email'),
															'class_id' => $this->input->post('class'),
															'medium_id' => $this->input->post('medium'),
															'board' => $this->input->post('board'),
															'gender' => $this->input->post('gender'),
															'address' => $this->input->post('address'),
															'phone' => $this->input->post('phone'),
															'modified' => $date
														  );
									$update = $this->base_model->update ( 'users', $update_array, array('id'=>$user_id));
									
									if($update){
										$result = array('success'=> 1 , 'message'=> 'Profile Updated Successfully');
									}else{
										$result = array('success'=> 0 , 'message'=> 'Error in Update');
									}
								}	
							}else{
							
								$date = date('Y-m-d H:i:s');
								/*$name = explode(" ",$this->input->post('user-name'));
								$first_name = ($name[0]) ? $name[0] : '';
								$last_name = '';
								for($i=1;$i<count($name);$i++){
									if($i != 1){ $last_name .= " ".$name[$i]; }else{ $last_name .= $name[$i]; }
								}*/
								$update_array = array (	'first_name' => $this->input->post('first_name'),
														'last_name' => $this->input->post('last_name'),
														'email' => $this->input->post('email'),
														'class_id' => $this->input->post('class'),
														'medium_id' => $this->input->post('medium'),
														'board' => $this->input->post('board'),
														'gender' => $this->input->post('gender'),
														'address' => $this->input->post('address'),
														'phone' => $this->input->post('phone'),
														'modified' => $date
													  );
								$update = $this->base_model->update ( 'users', $update_array, array('id'=>$user_id));
								if($update){
									$result = array('success'=> 1 , 'message'=> 'Profile Updated Successfully');
								}else{
									$result = array('success'=> 0 , 'message'=> 'Error in Update');
								}
							}
							
							break;
							
						default:
							$result = array('success'=> 0 , 'message'=> 'Some error ');
						}
				
				
				}else{
					$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
				}
			}else{
				$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
			} 
			echo $response = json_encode($result);
			return TRUE;
		}
		
		public function change_password(){
			$this->load->model('base_model'); 
			$result = array();
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$user_id = $this->input->post('user_id');
				$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
				$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
				$this->form_validation->set_rules('user_id', 'user id','trim|required');
				$this->form_validation->set_rules('current_password', 'Current Password','trim|required');
				$this->form_validation->set_rules('new_password', 'New Password', 'trim|required'); 
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]'); 
				if($this->form_validation->run()){
					$oauth_token = $this->input->post('oauth_token');
					$new_pass = $this->input->post('new_password');
					$current_pass = $this->input->post('current_password');
					$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
					switch($response){
						case 'TOKEN_ERROR':
							$result = array('success'=> 0 , 'message'=> 'Invalid Token');
							break;
						case 'INVALID_USER_ID':
							$result = array('success'=> 0 , 'message'=> 'Invalid user');
							break;
						case 'INACTIVATE_USER_ID':
							$result = array('success'=> 0 , 'message'=> 'Inactivate user');
							break;
						case 'SUCCESS':
							$count = $this->base_model->getCount('users',array('password' => md5($current_pass) ,'id' => $user_id));
							if($count == 0){
								$result = array('success'=> 0 , 'message'=> 'Your current password is Wrong');
							}else{
								$update = $this->base_model->update('users', array('password'=>md5($new_pass)) , array('id'=> $user_id,'password'=> md5($current_pass)));
								if($update){
									$result = array('success'=> 1 , 'message'=> 'Password Updated Successfully');
								}else{
									$result = array('success'=> 0 , 'message'=> 'Error in Password Update');
								}
							}
							break;
						default:
							$result = array('success'=> 0 , 'message'=> 'Some error ');
						}
				}else{
					$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
				}
			}else{
				$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
			} 
			echo $response = json_encode($result);
			return TRUE;
		}
		public function show_profile(){
			$this->load->model('base_model'); 
			$this->load->helper('thumb_helper');
			$result = array();
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
				$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
				$this->form_validation->set_rules('user_id', 'user id','trim|required');
				if($this->form_validation->run()){ 
					$user_id = $this->input->post('user_id');
					$oauth_token = $this->input->post('oauth_token');	
					$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
					switch($response){
						case 'TOKEN_ERROR':
							$result = array('success'=> 0 , 'message'=> 'Invalid Token');
							break;
						case 'INVALID_USER_ID':
							$result = array('success'=> 0 , 'message'=> 'Invalid user');
							break;
						case 'INACTIVATE_USER_ID':
							$result = array('success'=> 0 , 'message'=> 'Inactivate user');
							break;
						case 'SUCCESS':
							$where[] = array( TRUE, 'u.id', $user_id);
							$where[] = array( TRUE, 'u.app_token', $oauth_token);
							$fields = 'u.id, u.created, u.modified, u.profile_image, u.course_id, u.medium_id, u.class_id, u.first_name, u.last_name, u.gender, u.email, u.school, u.board, u.location, u.address, u.phone, m.name medium_name, b.name board_name, c.name class_name'; 
						  	$join_tables[] = array('medium as m','u.medium_id = m.id');
						  	$join_tables[] = array('study_board as b','u.board = b.id');			  	
						  	$join_tables[] = array('classes as c','u.class_id = c.id');			  	
		  					$response = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where, '', '', '', array('u.id'));
							if($response[0]['profile_image'] != ''){
								$img_src = thumb($this->config->item('profile_image_url') .$response[0]['profile_image'] ,'200', '200', 'thumb_profile_img',$maintain_ratio = FALSE);
				                $response[0]['profile_image'] = base_url() . 'appdata/profile/thumb_profile_img/'.$img_src;
                        	}
                        	if($response[0]['gender'] == 1){
                        		$response[0]['gender'] = "Male";
                        	}else if($response[0]['gender'] == 2){
                        		$response[0]['gender'] = "Female";
                        	}else{
                        		$response[0]['gender'] = "";
                        	}
                        	if($response[0]['medium_id']==0 || $response[0]['class_id']==0 || $response[0]['board']=="" || $response[0]['address']=="")
							{
								$response[0]['is_first_login'] = 1;
							}
							else
							{
								$response[0]['is_first_login'] = 0;
							}
							if($response){
								$result = array('success'=> 1 , 'message'=> 'Profile Data','data' => $response);
							}else{
								$result = array('success'=> 0 , 'message'=> 'Error in Fetching Data');
							}
							break;
						default:
							$result = array('success'=> 0 , 'message'=> 'Some error ');
						}
				}else{
					$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
				}
			}else{
				$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
			} 
			echo $response = json_encode($result);
			return TRUE;
		}
		public function imgupload(){
			
 		 	$this->load->helper('string');
			$this->load->model('base_model'); 
			$this->load->helper('thumb_helper');
			
		
			$result = array();
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
				$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
				$this->form_validation->set_rules('user_id', 'user id','trim|required');
				if($this->form_validation->run()){ 
					$user_id = $this->input->post('user_id');
					$oauth_token = $this->input->post('oauth_token');	
					$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 

					switch($response){
						case 'TOKEN_ERROR':
							$result = array('success'=> 0 , 'message'=> 'Invalid Token');
							break;
						case 'INVALID_USER_ID':
							$result = array('success'=> 0 , 'message'=> 'Invalid user');
							break;
						case 'INACTIVATE_USER_ID':
							$result = array('success'=> 0 , 'message'=> 'Inactivate user');
							break;
						case 'SUCCESS':
						
							//write image to a file need to change this line. image uloaded successfully
						 	$image_dat=$this->input->post("profile_image"); 
		 	  				$data = base64_decode($image_dat);
							$recived_image_name=random_string('unique').time().".".$this->input->post("extension");
							 
							//$recived_image_name="images_i.jpg";#image name must be sent by andriod user
							file_put_contents($this->config->item('profile_image_url').$recived_image_name, $data);
		 
							$oldImageName = $this->base_model->getCommonListFields('users', array('profile_image'), array('id' => $user_id));
        					@unlink($this->config->item('profile_image_url') . $oldImageName[0]->profile_image); 
								$update = $this->base_model->update('users', array('profile_image' =>$recived_image_name ), array('id' => $user_id));
								if($update){
									$ImageName = $this->base_model->getCommonListFields('users', array('profile_image'), array('id' => $user_id));
		        					$img_src = thumb($this->config->item('profile_image_url') .$ImageName[0]->profile_image ,'178', '178', 'thumb_profile_img',FALSE);
									$upload_image['profile_image'] = base_url() . 'appdata/profile/thumb_profile_img/'.$img_src;
									$result = array('success' => 1, 'message' => 'profile image', 'data' => $upload_image);
									echo json_encode($result);die;
								}
							 
							break;
						default:
							$result = array('success'=> 0 , 'message'=> 'Some error ');
					}
				}else{
					$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
				}
				
			}else{
				$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
			} 
			echo $response = json_encode($result);
			return TRUE;
		}
		
}
