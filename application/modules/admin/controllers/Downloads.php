<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Downloads extends Admin_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
    		$this->load->library(array('form_validation'));
			$this->load->language(array('flash_message','form_validation'), 'english');
			if(!$this->session->has_userdata('admin_is_logged_in')){
					redirect(SITE_ADMIN_URI);
			}
			getSearchDetails($this->router->fetch_class());
			$this->load->model('base_model'); 
			$this->load->model(array('download_model','alert_model','certificate_model'));
		}

		public function index($page_num = 1)
		{  
			$search_date_keyword  = isset($_POST['search_date'])?trim($_POST['search_date']):(isset($_SESSION['search_date'])?$_SESSION['search_date']:'');
			$this->session->set_userdata('search_date', $search_date_keyword); 			
			$keyword_date_session = $this->session->userdata('search_date');
			if($keyword_date_session != '')
			{
				$keyword_date = $this->session->userdata('search_date');
			}
			else
			{
				isset($_SESSION['search_date'])?$this->session->unset_userdata('search_date'):'';
				$keyword_date = "";
			}	
			$search_uploaded_keyword  = isset($_POST['search_uploaded'])?trim($_POST['search_uploaded']):(isset($_SESSION['search_uploaded'])?$_SESSION['search_uploaded']:'');
			$this->session->set_userdata('search_uploaded', $search_uploaded_keyword); 			
			$keyword_uploaded_session = $this->session->userdata('search_uploaded');
			if($keyword_uploaded_session != '')
			{
				$keyword_uploaded = $this->session->userdata('search_uploaded');
			}
			else
			{
				isset($_SESSION['search_uploaded'])?$this->session->unset_userdata('search_uploaded'):'';
				$keyword_uploaded = "";
			}	
				$this->load->library('pagination');
				$config  = $this->config->item('pagination');
			  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/downloads/index";
			 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
			  	$config["uri_segment"] = 4;
			  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
			  	$limit_start = $config['per_page'];
			  	$join_tables = array();
			  	$where = array();  
			  	if($keyword_date)
				{
					$from_date = $keyword_date." 00:00:00";
					$to_date = $keyword_date." 23:59:59";
					$where[] = array( TRUE, "d.created >=",$from_date);
					$where[] = array( TRUE, "d.created <=",$to_date);
					$data['keyword_date'] = $keyword_date;
				}
				else{
					$data['keyword_date'] = "";
				}
				if($keyword_uploaded != "")
				{
					$where[] = array( TRUE, 'd.uploaded_by', $keyword_uploaded);
					$data['keyword_uploaded'] = $keyword_uploaded;
				}
				else{
					$data['keyword_uploaded'] = "";
				}


		/*data coming from dashboard*/	
		$today_date=$this->input->get("date");#for current date only
		if($today_date!=""){
			$_SESSION["search_date"]=$today_date; 
			$data['keyword_date'] = $today_date;
		}	 
		if($today_date){
			$today=$today_date.' 00:00:00';
			$today_end=$today_date.' 23:59:59';
			$where[] = array( TRUE, 'd.created >=', $today);  
			$where[] = array( TRUE, 'd.created <=', $today_end);  
		}	


			  	$fields = 'd.id, d.download_name,d.uploaded_by, d.status, d.created, d.user_id, co.name course_name, cl.name class_name, s.name subject_name, 
			  	u.first_name username'; 
			  	$join_tables[] = array('courses as co','d.course_id = co.id');
		  		$join_tables[] = array('classes as cl','d.class_id = cl.id');
		  		$join_tables[] = array('subjects as s','d.subject_id = s.id');		
			  	$join_tables[] = array('users as u','d.user_id = u.id');
		  		$where[] = array( TRUE, 'cl.status', 1);  
		  		$where[] = array( TRUE, 's.status', 1);		  	
			  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('downloads as d', $join_tables, $fields, $where, 'num_rows','','','d.id');
			  	$data['downloads'] = $this->base_model->get_advance_list('downloads as d', $join_tables, $fields, $where, '', 'd.id', 'desc', 'd.id', $limit_start, $limit_end);
			    $this->pagination->initialize($config);
				$data['main_content'] = 'downloads/index';
			  	$data['page_title']  = 'Downloads'; 
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function reset()
		{
			$this->session->unset_userdata('search_date');
			$this->session->unset_userdata('search_uploaded');
			redirect(base_url().SITE_ADMIN_URI.'/downloads/');
		}
		public function view($id = NULL,$uploaded_by = NULL)
		{
			$join_tables = array();
			$where = array();
			$join_tables[] = array('courses as co','d.course_id = co.id');
			$join_tables[] = array('classes as cl','d.class_id = cl.id');			  	
	  		$join_tables[] = array('subjects as s','d.subject_id = s.id');	 
	  		$join_tables[] = array('users as u','d.user_id = u.id');	 
			$fields = 'd.id, d.download_name,d.uploaded_by, d.status, d.created, d.user_id, co.name course_name, cl.name class_name, s.name subject_name, 
			u.first_name username'; 
			$where[] = array( TRUE, 'd.id', $id);
			$data['downloads'] = $this->base_model->get_advance_list('downloads as d', $join_tables, $fields, $where,'row_array');
			
			$data['attachments'] = $this->base_model->getCommonListFields('downloads_attachment','',array('downloads_id' => $id));
			
			$data['uploaded_id'] = $uploaded_by;
			$data['main_content'] = 'downloads/view';
		  	$data['page_title']  = 'Downloads';  
			$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function validate_select($val, $fieldname){
			if($val==""){
				$this->form_validation->set_message('validate_select', 'Please choose the '.$fieldname.'.');
				return FALSE;
			}			
		}
		public function add()
		{	
			$data['post'] = FALSE;
			$data['course_list'] = $this->base_model->getSelectList('courses');
			$data['subject_list'] = $this->base_model->getSelectList('subjects');
			
			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{ 
		      	$this->form_validation->set_rules('name', 'Name', 'trim|required');
		      	$this->form_validation->set_rules('comments', 'Description', 'trim|required');
				$this->form_validation->set_rules('class_list', 'class', 'trim|callback_validate_select[Class]');
				$this->form_validation->set_rules('subject_list', 'subject', 'trim|callback_validate_select[Subject]');
		      	$count = $this->input->post('counter_add');
				// for($i=0; $i<=$count;$i++){
				// 	if(empty($_FILES['attachment']['name'][$i]))
				// 	{
	    		// 		$this->form_validation->set_rules('attachment', 'Attachment', 'required');
				// 	}

				// }
					
				
				if($this->form_validation->run())
				{ 
					$date = date('Y-m-d H:i:s');
					$config['upload_path'] = $this->config->item('attachments');
                	$config['allowed_types'] = "pdf|mp4"; 
					$upload_names;
                	// $config['max_size'] = '2048';
                	// attachments start
						for($i=0; $i<=$count;$i++){
							if(!empty($_FILES['attachment']['name'][$i]) )
							{
			    				   $files = $_FILES;
								   $_FILES['userfile']['name']= $files['attachment']['name'][$i];
		                		   $_FILES['userfile']['type']= $files['attachment']['type'][$i];
								   $_FILES['userfile']['tmp_name']= $files['attachment']['tmp_name'][$i];
								   if($files['attachment']['type'][$i]=="application/pdf"){
								   		$attachment_type=1;
								   }
								//    else if($files['attachment']['type'][$i]=="video/mp4"){
								//    		$attachment_type=2;
								//    }
								   $_FILES['userfile']['error']= $files['attachment']['error'][$i];
								   $_FILES['userfile']['size']= $files['attachment']['size'][$i];
				                   $config['file_name'] = time().rand(1000,9999); 
								   $this->load->library('upload', $config);
								   $image_up = $this->upload->do_upload();
									if (!$image_up){
										$upload = array('error' => $this->upload->display_errors());
									   $data['upload_error'] = $upload;							 
									}else{
										$image_data = array('upload_data' => $this->upload->data());							
										$upload_names[$i]['attachment'] = $image_data['upload_data']['file_name'];		
										$upload_names[$i]['attachment_type'] = $attachment_type;	
										$upload_names[$i]['attachment_name'] = $this->input->post('attachment_name['.$i.']');

									}
							}else{
								$upload_names[$i]['attachment'] = $this->input->post('youtube_key['.$i.']');	
								$upload_names[$i]['attachment_type'] = 2;
								$upload_names[$i]['attachment_name'] = $this->input->post('attachment_name['.$i.']');	
							}

						}
						
						//  if(isset($data['upload_error']))
						//  {
						// 	$upload = array('error' => $this->upload->display_errors(),
						// 					'error1' => 'Please upload only .pdf,.mp4 files');
						// 	$data['upload_error'] = $upload;
						//  }
						// else
						// {
							
						//$attachment_data = array('upload_data' => $this->upload->data());
						$update_array = array();
						$update_array = array ('download_name' => $this->input->post('name'), 
											   'comments' => $this->input->post('comments'), 
											   // 'attachment' => $attachment_data['upload_data']['file_name'], 
											   'course_id' => $this->input->post('course_list'), 
											   'subject_id' => $this->input->post('subject_list'), 
											   'chapter_id' => $this->input->post('chapter_list'), 
											   'class_id' => $this->input->post('class_list'), 
											   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
											   'created' => $date
											   );
						
						// exit;					   
						$insertId = $this->base_model->insert('downloads', $update_array);
						// insert to attachments tabel start
							foreach($upload_names as $key => $value){
								$update_array1 = array (
												   'downloads_id' => $insertId, 
												   'attachment' => $value['attachment'], 
												   'attachment_name' => $value['attachment_name'], 
												   // 'attachment_type' => $value['attachment_type'], 
												   'created' => $date,
												   'modified' => $date
												   );
								$this->base_model->insert('downloads_attachment', $update_array1);
							}
						// insert to attachments tabel end
						$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
						redirect(base_url().SITE_ADMIN_URI.'/downloads/');

					//} else end
				}
				$data['post'] = TRUE;
			}
			// $data['class_list'] = $this->base_model->getSelectList('classes');
			$data['main_content'] = 'downloads/add';
			$data['page_title']  = 'Downloads'; 
			$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
			
		}
		
		public function edit($id = NULL)
		{
			if(isset($_GET['from'])){
			$from = $_GET['from'];
			}
			else{
				$from = "";
			}
			
			$data['post'] = FALSE;
			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{ 
				$this->form_validation->set_rules('name', 'Name','trim|required');
				$this->form_validation->set_rules('comments', 'Description','trim|required');
				$this->form_validation->set_rules('class_list', 'class', 'trim|callback_validate_select[Class]');
				$this->form_validation->set_rules('subject_list', 'subject', 'trim|callback_validate_select[Subject]');
				
				$count = $this->input->post('counter_add');

				// for($i=0; $i<=$count;$i++){
				// 	if(empty($_FILES['attachment']['name'][$i]))
				// 	{
	    		// 		$this->form_validation->set_rules('attachment', 'Attachment', 'required');
				// 	}
				// }



				if ($this->form_validation->run())
				{  
						$upload_names;
						$date = date('Y-m-d H:i:s');
							// attachments start
							$config['upload_path'] = $this->config->item('attachments');
                			$config['allowed_types'] = "pdf|mp4"; 
                			if($this->input->post('old_images')){
									$arr = explode(',',$this->input->post('old_images'));
									$arr_name = explode(',',$this->input->post('old_images_name'));
									
									foreach($arr as $key => $value){
										$upload_names['old'.$key]['attachment'] = $value;
										//$upload_names[$key]['attachment_name'] = $value;
											foreach($arr_name as $key => $value){
												$upload_names['old'.$key]['attachment_name'] = $value;
												continue;
											}
									}
								}
								    // print_r($upload_names);die;

						if($count >= 0){

								for($i=0; $i<=$count;$i++){

									if(!empty($_FILES['attachment']['name'][$i]))
									{
				    				   $files = $_FILES;
									   $_FILES['userfile']['name']= $files['attachment']['name'][$i];
			                		   $_FILES['userfile']['type']= $files['attachment']['type'][$i];
									   $_FILES['userfile']['tmp_name']= $files['attachment']['tmp_name'][$i];
									   if($files['attachment']['type'][$i]=="application/pdf"){
									   		$attachment_type=1;
									   }else if($files['attachment']['type'][$i]=="video/mp4"){
									   		$attachment_type=2;
									   }
									   $_FILES['userfile']['error']= $files['attachment']['error'][$i];
									   $_FILES['userfile']['size']= $files['attachment']['size'][$i];
					                   $config['file_name'] = time().rand(1000,9999); 
									   $this->load->library('upload', $config);
									   $image_up = $this->upload->do_upload();
										if (!$image_up){
										   $upload = array('error' => $this->upload->display_errors());
										   $data['upload_error'] = $upload;							 
										}else{
											$image_data = array('upload_data' => $this->upload->data());
											$upload_names[$i]['attachment'] = $image_data['upload_data']['file_name'];		
											// $upload_names[$i]['attachment_type'] = $attachment_type;
											$upload_names[$i]['attachment_name'] = $this->input->post('attachment_name['.$i.']');
										}
									}else{
										$upload_names[$i]['attachment'] = $this->input->post('youtube_key['.$i.']');	
										$upload_names[$i]['attachment_type'] = 2;
										$upload_names[$i]['attachment_name'] = $this->input->post('attachment_name['.$i.']');
									}
								}
							}
							 // print_r($upload_names);die;
								
								
								//  if(isset($data['upload_error']))
								//  {
							    // 	$upload = array('error' => $this->upload->display_errors(),
							    // 					'error1' => 'Please upload only .pdf,.mp4 files');
							   	// 	$data['upload_error'] = $upload;
								//  }
								// else
								// {

									$this->base_model->delete ('downloads_attachment',array('downloads_id' => $id));
									$update_array = array();
									$update_array = array ('download_name' => $this->input->post('name'), 
														   'comments' => $this->input->post('comments'), 
														   // 'attachment' => $attachment_data['upload_data']['file_name'], 
														   'course_id' => $this->input->post('course_list'), 
														   'subject_id' => $this->input->post('subject_list'), 
														   'chapter_id' => $this->input->post('chapter_list'), 
														   'class_id' => $this->input->post('class_list'), 
														   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
														   'created' => $date
														   );
									$insertId = $this->base_model->update('downloads',$update_array , array('id' => $id));
									// insert to attachments tabel start
										foreach($upload_names as $key => $value){
											$update_array1 = array (
															   'downloads_id' => $id, 
															   'attachment' => $value['attachment'], 
															   'attachment_name' => $value['attachment_name'], 
															    // 'attachment_type' => $value['attachment_type'], 
															   'created' => $date,
															   'modified' => $date
															   );
											$this->base_model->insert('downloads_attachment', $update_array1);
										}
									// insert to attachments tabel end
									$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
									redirect(base_url().SITE_ADMIN_URI.'/downloads/');
								//}
					$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
					redirect(base_url().SITE_ADMIN_URI.'/downloads/');							
				}
				$data['post'] = TRUE;
				$data['class_list'] = array();
				$data['subject_list'] = array();
				

			  	$join_tables = $where = array();  
			  	$fields = 's.id, s.name subject_name'; 
			  	$where[] = array( TRUE, 'rs.course_id', $this->input->post('course_list'));
			  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');			  	
			  	$subject_list = $this->base_model->get_advance_list('relevant_subjects as rs', $join_tables, $fields, $where, '', 'rs.subject_id', 'desc');
				if($subject_list){
					$data['subject_list'][''] = 'Select'; 
					foreach($subject_list as $subject){
				  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
				  	}
			  	}
 
			}else{
				
				



			  	$join_tables = $where = array();  
			  	$fields = 'id, name'; 
			  	$where[] = array( TRUE, 'status', 1);
				$join_tables=array();
			  	$subject_list = $this->base_model->get_advance_list('subjects', $join_tables, $fields, $where, '', '', '');
				if($subject_list){
					foreach($subject_list as $subject){
				  		$data['subject_list'][$subject['id']] = ucfirst($subject['name']);
				  	}
			  	}

			  	$join_tables = $where = array();  
			  	$fields = 'ch.id, ch.name chapter_name'; 
			  	$where[] = array( TRUE, 'down.id', $id);
			  	$join_tables[] = array('chapters as ch','down.course_id = ch.course_id and down.class_id = ch.class_id and down.subject_id = ch.subject_id');
			  	$chapter_list = $this->base_model->get_advance_list('downloads as down', $join_tables, $fields, $where, '', 'ch.name', 'asc');
				$data['chapter_list'] = array();
				if($chapter_list){
					foreach($chapter_list as $chapter){
				  		$data['chapter_list'][$chapter['id']] = ucfirst($chapter['chapter_name']);
				  	}
			  	}
		  	}
		   	$data['course_list'] = $this->base_model->getSelectList('courses');



			$data['downloads_main'] = $this->base_model->getCommonListFields('downloads','',array('id' => $id));

			$class_list = $this->certificate_model->getClasses($data['downloads_main'][0]->course_id);
				if($class_list){
				  	foreach($class_list as $class){
				  		$data['class_list'][ucfirst($class['id'])] = $class['name'];
				  	}
			  	}


			$data['attachments'] = $this->base_model->getCommonListFields('downloads_attachment','',array('downloads_id' => $id));
			$data['downloads'] = $data['downloads_main'][0];
			$data['from'] = $from;
			$data['main_content'] = 'downloads/edit';
		  	$data['page_title']  = 'Downloads';  
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
	public function delete($id,$pageredirect=null,$pageno) 
	{
		$getFile = $this->base_model->getCommonListFields('downloads_attachment','',array('downloads_id' => $id));
		foreach($getFile as $file){
			if(isset($file->attachment)){
		      @unlink($this->config->item('attachments') . $file->attachment);
	        }
		}
		$this->base_model->delete('downloads',array('id' => $id));
		$this->base_model->delete('downloads_attachment',array('downloads_id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record'));
		redirect(base_url().SITE_ADMIN_URI.'/downloads/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$date = date('Y-m-d H:i:s');
		if($status == 1){
			$alert_array = array('created' => $date,
								 'title' => 'Uploaded material is not approved by admin',
								 'short_description' => 'We are thankful to you for uploading the materials that you found informative. We are sorry too that the materials will not be available on our site due to some inaccuracies or discrepancies with our terms and conditions that we found in the content.',
								 'status' => '1','alert_type'=>1);
		}else{
			$alert_array = array('created' => $date,
								 'title' => 'Uploaded material is approved by admin',
								 'short_description' => 'We found the materials uploaded by you are informative and interesting, this will be available on our site from '.date('d-m-Y',strtotime($date)).', Thank you for your contribution.',
								 'status' => '1','alert_type'=>1);
		}
		$table_name = 'downloads';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		
		$alertId = $this->base_model->insert('alerts', $alert_array);
		$user_id = $this->download_model->get_user_id($id);
		if(isset($alertId)){
		$array = array ('alert_id' => $alertId, 
				   	    'user_id' => $user_id['user_id'],
					    'status' => 1,
					   );
		$insertId = $this->base_model->insert('alert_users', $array);
		}		
		
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/downloads/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function approve($id,$status)
	{
		$date = date('Y-m-d H:i:s');
		if($status == 1){
			$status = 0;										
			$update_array = array ('status' => $status);
			$alert_array = array('created' => $date,
								 'title' => 'Uploaded material is not approved by admin',
								 'short_description' => 'We are thankful to you for uploading the materials that you found informative. We are sorry too that the materials will not be available on our site due to some inaccuracies or discrepancies with our terms and conditions that we found in the content.',
								 'status' => '1','alert_type'=>1);
		}else{
			$status = 1;										
			$update_array = array ('status' => $status);
			$alert_array = array('created' => $date,
								 'title' => 'Uploaded material is approved by admin',
								 'short_description' => 'We found the materials uploaded by you are informative and interesting, this will be available on our site from '.date('d-m-Y',strtotime($date)).', Thank you for your contribution.',
								 'status' => '1','alert_type'=>1);
		}	  
		$this->base_model->update ('downloads', $update_array, array('id'=>$id));
		
		$alertId = $this->base_model->insert('alerts', $alert_array);
		$user_id = $this->download_model->get_user_id($id);
		if(isset($alertId)){
		$array = array ('alert_id' => $alertId, 
				   	    'user_id' => $user_id['user_id'],
					    'status' => 1,
					   );
		$insertId = $this->base_model->insert('alert_users', $array);
		push_notification($user_id['user_id']);
		}
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/downloads');
	}
	function bulkactions($pageredirect=null,$pageno){
		
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'downloads'); //update material status
				
				//insert alert
				$date = date('Y-m-d H:i:s');
				$alert_array = array('created' => $date,
								 'title' => 'Uploaded material is approved by admin',
								 'short_description' => 'We found the materials uploaded by you are informative and interesting, this will be available on our site from '.date('d-m-Y',strtotime($date)).', Thank you for your contribution.',
								 'status' => '1','alert_type'=>1);
				$alertId = $this->base_model->insert('alerts', $alert_array);
				$user_id = $this->download_model->get_user_id($id);
				if(isset($alertId))
				{
					$array = array ('alert_id' => $alertId, 
							   	    'user_id' => $user_id['user_id'],
									'status' => 1,
								   );
					$insertId = $this->base_model->insert('alert_users', $array);
					//push_notification($user_id['user_id']);
				}
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'downloads');
				
				//insert alert
				$date = date('Y-m-d H:i:s');
				$alert_array = array('created' => $date,
								 'title' => 'Uploaded material is not approved by admin',
								 'short_description' => 'We are thankful to you for uploading the materials that you found informative. We are sorry too that the materials will not be available on our site due to some inaccuracies or discrepancies with our terms and conditions that we found in the content.',
								 'status' => '1','alert_type'=>1);
				$alertId = $this->base_model->insert('alerts', $alert_array);
				$user_id = $this->download_model->get_user_id($id);
				if(isset($alertId))
				{
					$array = array ('alert_id' => $alertId, 
							   	    'user_id' => $user_id['user_id'],
									'status' => 1,
								   );
					$insertId = $this->base_model->insert('alert_users', $array);
					//push_notification($user_id['user_id']);
				}
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$getFile = $this->base_model->getCommonListFields('downloads',array('attachment'),array('id' => $id));
				if(isset($getFile[0]->attachment)){
	      			@unlink($this->config->item('attachments') . $getFile[0]->attachment);
        		}
				$this->base_model->delete('downloads', array('id' => $id));
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/downloads/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/downloads/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function request(){
		$course_id = $this->input->post('course_id');
		if($course_id!=""){
			$data = array();
			$data['class_list'] = array();
			$join_tables = $where = array();  
		  	$fields = 'cl.id, cl.name class_name'; 
		  	$where[] = array( TRUE, 'rc.course_id', $course_id);
		  	$where[] = array( TRUE, 'cl.status', '1');
		  	$join_tables[] = array('classes as cl','rc.class_id = cl.id','inner');			  	
		  	$class_list = $this->base_model->get_advance_list('relevant_classes as rc', $join_tables, $fields, $where, '', 'rc.class_id', 'desc');
		  	if($class_list){
			  	foreach($class_list as $class){
			  		$data['class_list'][$class['id']] = ucfirst($class['class_name']);
			  	}
		  	}
			echo json_encode($data);
		}
		else
		{
			$data = array();
			$data['class_list'] = array();
			$data['subject_list'] = array();
			$join_tables = $where = array();  
	  		$fields = 'cl.id, cl.name class_name'; 
	  		$where[] = array( TRUE, 'cl.status', '1');
	  		$join_tables[] = array('classes as cl','rc.class_id = cl.id','inner');			  	
	  		$class_list = $this->base_model->get_advance_list('relevant_classes as rc', $join_tables, $fields, $where, '', 'rc.class_id', 'desc');
	  		if($class_list){
		  		foreach($class_list as $class){
		  			$data['class_list'][$class['id']] = ucfirst($class['class_name']);
		  		}
	  		}
	  		
			echo json_encode($data);	
		}
	}
	public function request1(){
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		if($course_id!="" && $class_id != ""){
		$data = array();
		$data['subject_list'] = array();
	  	$join_tables2 = $where = array();  
	  	$fields2 = 's.id, s.name subject_name'; 
	  	$where2[] = array( TRUE, 'rs.course_id', $course_id);
	  	$where2[] = array( TRUE, 'rs.class_id', $class_id);
	  	$where2[] = array( TRUE, 's.status', '1');
	  	$join_tables2[] = array('subjects as s','rs.subject_id = s.id');			  	
	  	$subject_list = $this->base_model->get_advance_list('relevant_subjects as rs', $join_tables2, $fields2, $where2, '', 'rs.subject_id', 'desc');
		if($subject_list){
			foreach($subject_list as $subject){
		  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
		  	}
	  	}
		echo json_encode($data);
		}
		else if($course_id == "")
		{
			$data['subject_list'] = array();
			$join_tables2 = $where = array();  
		  	$fields2 = 's.id, s.name subject_name'; 
		  	$where2[] = array( TRUE, 'rs.class_id', $class_id);
		  	$where2[] = array( TRUE, 's.status', '1');
		  	$join_tables2[] = array('subjects as s','rs.subject_id = s.id');			  	
		  	$subject_list = $this->base_model->get_advance_list('relevant_subjects as rs', $join_tables2, $fields2, $where2, '', 'rs.subject_id', 'desc');
			if($subject_list){
				foreach($subject_list as $subject){
			  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
			  	}
		  	}
		  	echo json_encode($data);
		}
	}
}
