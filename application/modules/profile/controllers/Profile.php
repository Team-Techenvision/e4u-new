<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller
{
	  	function __construct()
  		{
  			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
			$this->load->model('base_model'); 
			$this->load->helper("profile_helper");
			$this->load->helper("function_helper");	
			// compare_session(1);
			if(!is_loggedin()) {
				redirect();	
			}
		}
		public function index()
		{
			if(!$this->session->has_userdata('user_is_logged_in'))
			{
				 $extra_array = array('status'=>'session_expired','msg'=>$this->lang->line('session_expired'));
				 redirect(base_url());
			}
			$this->load->helper('thumb_helper');
			$data_update=$this->session->userdata('user_is_logged_in');
			$id= $data_update["user_id"];
			$fields = 'u.id,u.first_name,u.last_name,u.dob_date,u.dob_month,u.dob_year,u.gender,u.email, u.class_id,address,phone,u.profile_image,u.tips_title,u.tips,u.tips_status'; 	
			$join_tables= array();
			$where[] = array(TRUE,'u.id',$id);  
			$data['post'] = FALSE;			 
			$data['class_list'] = $this->base_model->getSelectList('classes');
			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{ 
				$this->form_validation->set_message('regex_match','Please enter only alphabets and spaces.');
				$this->form_validation->set_rules('fname','First Name','trim|required|regex_match[/^[a-zA-Z ]*$/]');
				$this->form_validation->set_rules('lname','Last Name','trim|required|regex_match[/^[a-zA-Z ]*$/]');
				$this->form_validation->set_rules('class_studying_id', 'Class','trim|required');					
				$this->form_validation->set_rules('phone', 'Mobile Number', 'trim|required|numeric|exact_length[10]'); 				
				$this->form_validation->set_rules('address', 'Address', 'trim|required');
				$this->form_validation->set_rules('dob_date', 'Date', 'trim|required');	
				$this->form_validation->set_rules('dob_month', 'Month', 'trim|required');	
				$this->form_validation->set_rules('dob_year', 'Year', 'trim|required');	
							
				if ($this->form_validation->run())
				{   
					$data_update=$this->session->userdata('user_is_logged_in');
					$id= $data_update["user_id"];
					$fields = 'u.id,u.first_name,u.last_name,u.dob_date,u.dob_month,u.dob_year,u.gender,u.email, u.class_id,address,phone,u.profile_image,u.tips_title,u.tips,u.tips_status,u.class_change_counter'; 	
					$join_tables= array();
					$where[] = array(TRUE,'u.id',$id);  
					$users = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where, '', '', '', array('u.id'));
					
					if($users[0]['class_change_counter']==1){
						$class_studying_id = $this->input->post('class_studying_id');
					}else{
						$class_studying_id = $users[0]['class_id'];
					}
					$date = date('Y-m-d H:i:s');
					$config['upload_path'] = $this->config->item('profile_image_url');
           		 	$config['allowed_types'] = "gif|jpg|jpeg|png";
					if(empty($_FILES['upload_image_name']['name'])) {
						$update_array = array (	'first_name' => $this->input->post('fname'),
											'last_name' => $this->input->post('lname'),
											'class_id' => $class_studying_id,
											'address' => $this->input->post('address'),
											'phone' => $this->input->post('phone'),
											'gender' => $this->input->post('gender'),
											'dob_date' => $this->input->post('dob_date'),
											'dob_month' => $this->input->post('dob_month'),
											'dob_year' => $this->input->post('dob_year'),
											'modified' => $date
										  );
						$this->base_model->update ( 'users', $update_array, array('id'=>$id));
						$data['success_msg'] = 'Profile updated successfully.';
					}
					else{
						$this->load->library('upload', $config);
            			$image_up = $this->upload->do_upload('upload_image_name');
					    if(!$image_up)
		        		{
							$upload = array('error' => $this->upload->display_errors());
							if($upload['error']=='upload_invalid_filetype'){
								$data['upload_error'] = "Allowed File Extensions: gif, jpg, jpeg, png.";
							}else{
								$data['upload_error'] = "Allowed File Extensions: gif, jpg, jpeg, png.Failed to upload profile image.Try again later.";
							}
						}
						else
						{
							$image_data = array('upload_data' => $this->upload->data()); // $image_data['upload_data']['file_name']
						
							$update_array = array (	'first_name' => $this->input->post('fname'),
											'last_name' => $this->input->post('lname'),
											'profile_image' => $image_data['upload_data']['file_name'],		
											'gender' => $this->input->post('gender'),
											'class_id' => $class_studying_id,
											'address' => $this->input->post('address'),
											'phone' => $this->input->post('phone'),
											'dob_date' => $this->input->post('dob_date'),
											'dob_month' => $this->input->post('dob_month'),
											'dob_year' => $this->input->post('dob_year'),
											'modified' => $date
										  );

							$this->base_model->update('users', $update_array, array('id'=>$id));
						 	$data['success_msg'] = 'Profile updated successfully.';
						}

					}
					// echo $users[0]['class_id'];die;
					if($users[0]['class_id'] != $class_studying_id){
						$this->base_model->update('users', array('class_change_counter' => 0) , array('id'=>$id));	
					}
					
				}else{
					//echo $this->form_validation->get_json(); die;
				}
			}
			$data['users'] = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where, '', '', '', array('u.id'));
			unset($_POST);
			$data['main_content'] = 'profile/index';
			$data['page_title']  = 'e4u'; 
			$data['page_title']  = 'e4u';  
			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
		}
		
		public function customAlpha($val) 
		{
			if(! preg_match("/^[a-zA-Z ]*$/", $val))
			{
				$arr = $this->form_validation->set_message('customAlpha', 'Please enter only alphabets and spaces');
				return $arr;
			}
		}

			

		public function imgupload(){
			$this->load->helper('thumb_helper');
			$oldImageName = $this->base_model->getCommonListFields('users', array('profile_image'), array('id' => $this->session->userdata['user_is_logged_in']['user_id']));
        	@unlink($this->config->item('profile_image_url') . $oldImageName[0]->profile_image);
        	$config['allowed_types'] = "gif|jpg|jpeg|png";
			$config['upload_path'] = $this->config->item('profile_image_url');
		    $config['min_width'] = "178"; 
            $config['min_height'] = "178";
		    $this->load->library('upload', $config);
		    if ($this->upload->do_upload('profile_image')) {
		        $image_data = array('upload_data' => $this->upload->data());
		        	if($image_data != ""){
		        	$ImageName = $image_data['upload_data']['file_name'];
		        	$img_src = thumb($this->config->item('profile_image_url') .$ImageName ,'178', '178', 'thumb_profile_img',FALSE);
                    $img_prp = array('src' => base_url() . 'appdata/profile/thumb_profile_img/'.$img_src, 'alt' => $ImageName[0]->profile_image, 'title' =>$ImageName[0]->profile_image);
		        	$extra_array = array('status'=>'success','img'=>$img_prp['src'],'img_name'=>$ImageName);
		        	echo json_encode($extra_array);die;
		        	}
            }else{
			    $extra_array = array('status'=>'error','msg'=>$this->upload->display_errors());
			    echo json_encode($extra_array);die;
            }
		}
		public function change_pass(){
			$this->load->view("reset_password");
		}
		public function action_change_pass(){
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
				$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
				$data_update=$this->session->userdata('user_is_logged_in');
				$id= $data_update["user_id"];
				$new_pass = $this->input->post('new_password');
				$current_pass = $this->input->post('current_password');
				$confirm_pass = $this->input->post('confirm_password');
				 
				if($current_pass!=""){
						$count = $this->base_model->getCount('users',array('password' => md5($current_pass) ,'id' => $id));
						if($count == 0){
				$this->form_validation->set_message('invalid_pass', 'Please enter valid Current Password.');
				$this->form_validation->set_rules('current_password', 'current password', 'invalid_pass');
						}
				}
				  
					if($new_pass!=""&&strlen($new_pass) < 6)
					{
						$this->form_validation->set_message('newpass_length', 'Password should be greater than or equal to 6 characters.');
						$this->form_validation->set_rules('new_password', 'new password', 'newpass_length');
					}
					else if($confirm_pass!=""&&$new_pass != $confirm_pass){
				
						$this->form_validation->set_message('pass_match', 'New Password does not match with Confirm Password.');
						$this->form_validation->set_rules('confirm_password', 'confirm password', 'pass_match');
					}else if($new_pass!=""&&$new_pass == $current_pass){
								 
						$this->form_validation->set_message('newpass_cur_pass', 'New Password and Current Password are same.');
						$this->form_validation->set_rules('new_password', 'confirm password', 'newpass_cur_pass');
						
					}
					
				 
					
				if($this->form_validation->run() == false){
					echo $this->form_validation->get_json(); die;
				}else{
			 
				$update1 = $this->base_model->update('users', array('password'=>md5($new_pass), 'app_token' => "") , array('id'=> $id,'password'=> md5($current_pass)));
				$data_ret=array("status"=>"success");
				echo json_encode($data_ret); 
						 
				}
			} 
		}
		
}
