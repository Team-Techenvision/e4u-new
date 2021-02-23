<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller
{
	  	function __construct()
  		{
  			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
    		if(!$this->session->has_userdata('user_is_logged_in'))
			{
				redirect(base_url());
			}
			$this->load->model('base_model'); 
		}
		public function index()
		{
			$this->load->helper('thumb_helper');
			$data_update=$this->session->userdata('user_is_logged_in');
			$id= $data_update["user_id"];
 
			$fields = 'u.id,u.first_name,u.last_name,u.email,u.medium_id,u.class_id,u.board,
			address,phone,u.profile_image'; 	
			$join_tables= array();
 
			$where[] = array(TRUE,'u.id',$id);  
			$data['users'] = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where, '', '', '', array('u.id'));
			
			$data['post'] = FALSE;
			$join_tables1 = $where = array(); 
			$where1[] = array( TRUE, 'id', $id);
			$fields1 = 'email'; 
			$getValues = $this->base_model->get_advance_list('users', $join_tables1, $fields1, $where1, 'row_array');
			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{ 
				$this->form_validation->set_rules('fname', 'first name','trim|required');
				$this->form_validation->set_rules('lname', 'last name','trim|required');
				$this->form_validation->set_rules('email', 'email id','trim|required|valid_email');
				if($this->input->post('email') != $getValues['email']) {
					$is_unique =  '|is_unique[users.email]' ;
					} else {
						$is_unique =  '' ;
					}
					$this->form_validation->set_rules('email', 'email id', 'trim|required|valid_email'.$is_unique);
				$this->form_validation->set_rules('medium', 'Medium','trim|required');					
				$this->form_validation->set_rules('board', 'Study Board','trim|required');					
				$this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|numeric|regex_match[/^[0-9]+$/]|exact_length[10]'); 				
				$this->form_validation->set_rules('address', 'Address', 'trim|required');				
				if ($this->form_validation->run())
				{   
					$date = date('Y-m-d H:i:s');
					$update_array = array (	'first_name' => $this->input->post('fname'),
											'last_name' => $this->input->post('lname'),
											'email' => $this->input->post('email'),
											'class_id' => $this->input->post('class'),
											'medium_id' => $this->input->post('medium'),
											'board' => $this->input->post('board'),
											'address' => $this->input->post('address'),
											'phone' => $this->input->post('phone'),
											'modified' => $date
										  );
					$this->base_model->update ( 'users', $update_array, array('id'=>$id));
					$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
					redirect(base_url().'dashboard/');
				}
				$data['post'] = TRUE;
			}
			$data['class_list'] = $this->base_model->getSelectList('classes');
			$data['medium_list'] = $this->base_model->getSelectList('medium');
			$data['board_list'] = $this->base_model->getSelectList('study_board');
			$data['main_content'] = 'profile/index';
			$data['page_title']  = 'e4u'; 
			$this->load->view(SITE_LAYOUT_PATH, $data);
		}
		public function imgupload(){
			$this->load->helper('thumb_helper');
			$oldImageName = $this->base_model->getCommonListFields('users', array('profile_image'), array('id' => $this->session->userdata['user_is_logged_in']['user_id']));
        	@unlink($this->config->item('profile_image_url') . $oldImageName[0]->profile_image);
        	$config['allowed_types'] = "gif|jpg|jpeg|png";
			$config['upload_path'] = $this->config->item('profile_image_url');
		    $config['allowed_types'] = "gif|jpg|jpeg|png";
		    $this->load->library('upload', $config);
		    if ($this->upload->do_upload('profile_image')) {
		        $image_data = array('upload_data' => $this->upload->data());
		        $update = $this->base_model->update('users', array('profile_image' => $image_data['upload_data']['file_name']), array('id' => $this->session->userdata['user_is_logged_in']['user_id']));
		        if($update){
		        	$ImageName = $this->base_model->getCommonListFields('users', array('profile_image'), array('id' => $this->session->userdata['user_is_logged_in']['user_id']));
		        	$img_src = thumb($this->config->item('profile_image_url') .$ImageName[0]->profile_image ,'200', '200', 'thumb_profile_img',$maintain_ratio = TRUE);
                    $img_prp = array('src' => base_url() . 'appdata/profile/thumb_profile_img/'.$img_src, 'alt' => $ImageName[0]->profile_image, 'title' =>$ImageName[0]->profile_image);
		        	$extra_array = array('status'=>'success','img'=>$img_prp['src']);
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
			$data_update=$this->session->userdata('user_is_logged_in');
			$id= $data_update["user_id"];
			$current_pass = $this->input->get('current_pass');
			$new_pass = $this->input->get('new_pass');
			$confirm_pass = $this->input->get('confirm_pass');
			
			if(isset($current_pass)){
				$count = $this->base_model->getCount('users',array('password' => md5($current_pass) ,'id' => $id));
				if($count == 0){
					$count = 0;
				}
			}
			
			$update1 = $this->base_model->update('users', array('password'=>md5($new_pass)) , array('id'=> $id,'password'=> md5($current_pass)));
			if($update1)
			{
				$update = 1;
			}
			else{
				$update = 0;
			}
			$arr=array('valid_pass'=>$count,'update'=>$update);
			echo json_encode($arr); 
		}
		
}
