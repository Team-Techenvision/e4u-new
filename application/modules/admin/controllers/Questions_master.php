<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Questions_master extends Admin_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
    		$this->load->library(array('form_validation','csv_import'));
    		$this->load->library(array('form_validation'));
			$this->load->language(array('flash_message','form_validation'), 'english');
			$this->load->library('upload');	
			$this->load->helper('thumb_helper');	
			if(!$this->session->has_userdata('admin_is_logged_in')){
					redirect(SITE_ADMIN_URI);
			}
			getSearchDetails($this->router->fetch_class());
			$this->load->model('base_model'); 
		}

		public function index($page_num = 1)
		{  
				

				$search_name_keyword  = isset($_POST['search_name'])?trim($_POST['search_name']):(isset($_SESSION['search_name'])?$_SESSION['search_name']:'');
				$this->session->set_userdata('search_name', $search_name_keyword); 
				$keyword_name_session = $this->session->userdata('search_name');
				if($keyword_name_session != '')
				{
					$keyword_name = $this->session->userdata('search_name');
				}
				else
				{
					isset($_SESSION['search_name'])?$this->session->unset_userdata('search_name'):'';
					$keyword_name = "";
				}	
				$this->load->library('pagination');
				$config  = $this->config->item('pagination');
			  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/questions_master/index";
			 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
			  	$config["uri_segment"] = 4;
			  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
			  	$limit_start = $config['per_page'];
				$join_tables = $where = array(); 
			  	if($keyword_name)
				{
					$where[] = array( TRUE, 'c.question_title LIKE ', '%'.$keyword_name.'%' );
					//$where[] = array( TRUE, 'c.question_type', 2);
					$data['keyword_name'] = $keyword_name;
				}
				else{
					$data['keyword_name'] = "";
				} 

				$fields = 'c.id, c.question, c.question_type, c.question_title, c.explanation_title, c.explanation, c.tags, c.status, c.created'; 
			 	  	
			  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('questions_master as c', '', $fields, $where, 'num_rows','','','c.id');
			  	$data['questions'] = $this->base_model->get_advance_list('questions_master as c', $join_tables, $fields, $where, '', 'c.id', 'desc', 'c.id', $limit_start, $limit_end);			  	
			   $this->pagination->initialize($config);
			   $data['get_course'] = $this->base_model->getSelectList('courses'); 
			   $data['main_content'] = 'questions_master/index';
			   $data['page_title']  = 'Questions'; 
			   $this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function reset()
		{
			$this->session->unset_userdata('search_name');
			$this->session->unset_userdata('search_course');
			$this->session->unset_userdata('search_class');
			$this->session->unset_userdata('search_subject');
			$this->session->unset_userdata('search_chapter');
			$this->session->unset_userdata('search_level');
			$this->session->unset_userdata('search_set');
			redirect(base_url().SITE_ADMIN_URI.'/questions_master/');
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
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{ 	
			
					$this->form_validation->set_rules('severity', 'Severity','trim|required');
					$this->form_validation->set_rules('question_type', 'Question Type','trim|required');
					$this->form_validation->set_rules('question_title', 'Question Type','trim|required');
					$this->form_validation->set_rules('choice_count', 'choice count','trim|callback_validate_select[Choice Count]');
					$this->form_validation->set_rules('correct_answer[]', 'correct answer','trim|callback_validate_select[Correct Answer]');
					$this->form_validation->set_rules('explanation_title', 'Explanation Type','trim|required');
					$this->form_validation->set_rules('explanation_type', 'Explanation Type','trim|required');
					$choice_count = $this->input->post('choice_count');
					$answer_crct = $this->input->post('correct_answer');


					if(!$this->input->post('tags_exist') && !$this->input->post('tags')){
						$this->form_validation->set_rules('tags', 'Question Tags','trim|required');
					}	
					


					// if($choice_count){
					// 	$k=0;
					// 	for($i=1;$i<=$choice_count;$i++){
					// 			if($k==0){
					// 				$option = 'A';
					// 			}elseif($k==1){
					// 				$option = 'B';
					// 			}elseif($k==2){
					// 				$option = 'C';
					// 			}elseif($k==3){
					// 				$option = 'D';
					// 			}elseif($k==4){
					// 				$option = 'E';
					// 			}

					// 		$this->form_validation->set_rules('answer_type'.$i, 'answer type for option '.$option,'trim|callback_validate_select[Answer Type]');
					// 		$k++;
					// 	}
					// }
					// $this->form_validation->set_rules('choices[]', 'Choice field','trim|callback_validate_select[choices]');
					// if($this->input->post('question_type') == 1){
					// 	$this->form_validation->set_rules('question', 'Question', 'trim|required');
					// }else{
					// 	if($_FILES['question']['name'] == ""){
					// 		$this->form_validation->set_rules('question', 'Question', 'trim|callback_validate_select[Question]');
					// 	}
					// }
					// if($this->input->post('explanation_type') == 1){
					// 	$this->form_validation->set_rules('explanation', 'Explanation', 'trim|required');
					// }else 
					// if($this->input->post('explanation_type') == 2){
					// 	if($_FILES['explanation']['name'] == ""){
					// 		$this->form_validation->set_rules('explanation', 'Explanation', 'trim|callback_validate_select[Explanation]');
					// 	}
					// }
					// for($i=1;$i<=$choice_count;$i++){
					// 			if($i==1){
					// 				$option = 'A';
					// 			}elseif($k==2){
					// 				$option = 'B';
					// 			}elseif($k==3){
					// 				$option = 'C';
					// 			}elseif($k==4){
					// 				$option = 'D';
					// 			}elseif($k==5){
					// 				$option = 'E';
					// 			}
					// 	if($this->input->post('answer_type'.$i) == 1){ 
					// 		$name_array = $this->input->post('choices'.$i);
					// 			 if ($name_array == "") {
					// 			     $this->form_validation->set_rules('choices'.$i, 'Text field '.$option.'', 'trim|required');
					// 			 }
				  	// 	}
				  	// 	if($this->input->post('answer_type'.$i) == 2){
			  		// 			if($_FILES['choices'.$i]['name'] == ""){
			  		// 			$this->form_validation->set_rules('choices'.$i, 'Image field '.$option.'', 'trim|required');
			  		// 				}
				  	// 	}
			  		// }
					 
					  //exit;
					
			if ($this->form_validation->run())
			{
				    $date = date('Y-m-d H:i:s');
					$update_array = array();        
				    if($this->input->post('explanation_type')==2)
					{		
						$thumb_src = "";					
					  	$config['upload_path'] = $this->config->item('explanation_img');
						$config['allowed_types'] = "gif|jpg|jpeg|png"; 
						// $config['min_width'] = "300"; 
	               		$config['file_name'] = time();
						$this->upload->initialize($config);
						$explanation_image_up = $this->upload->do_upload('explanation');
						if (!$explanation_image_up) {                  	
                  		$upload = array('error' => $this->upload->display_errors());
					   	$data['explanation_upload_error'] = $upload;
                	}else{
                		$image_data = array('upload_data' => $this->upload->data());
							$explanation = $image_data['upload_data']['file_name'];	
                	}
					}else if($this->input->post('explanation_type')==1){
						$explanation = $this->input->post('explanation');
					}
					else{
						$explanation = ' ';
					}					
 					
					if($this->input->post('question_type')==2)
					{		
					
						unset($config);
						$thumb_src = "";
						$config=array();							
						$config['upload_path'] = $this->config->item('question_img');
						$config['allowed_types'] = "gif|jpg|jpeg|png"; 
						// $config['min_width'] = "300"; 
						$config['file_name'] = time(); 
					    $this->upload->initialize($config);
						$question_image_up = $this->upload->do_upload('question');
						
						if (!$question_image_up) {                  	
                  	$upload = array('error' => $this->upload->display_errors());
					   	$data['question_upload_error'] = $upload;					   	 
                	}else{
                		$image_data = array('upload_data' => $this->upload->data());
							$question = $image_data['upload_data']['file_name'];								
                	} 
					}else{
						$question = $this->input->post('question');
					}
					// 	unset($config);						
					// 	$config=array();
					// $choice_count = $this->input->post('choice_count');	
					// for($i=1;$i<=$choice_count;$i++){
					// 	if($this->input->post('answer_type'.$i) == 2){ 
					// 	$thumb_src = "";
					// 	$files = $_FILES;
					// 	//$cpt = count($_FILES['choices'.$i]['name']);
					// 	   $_FILES['userfile']['name']= $files['choices'.$i]['name'];
                	// 	   $_FILES['userfile']['type']= $files['choices'.$i]['type'];
					// 	   $_FILES['userfile']['tmp_name']= $files['choices'.$i]['tmp_name'];
					// 	   $_FILES['userfile']['error']= $files['choices'.$i]['error'];
					// 	   $_FILES['userfile']['size']= $files['choices'.$i]['size'];
					// 	   $config['upload_path'] = $this->config->item('answers_img');
					// 	   $config['allowed_types'] = "gif|jpg|jpeg|png"; 
					// 	   // $config['min_width'] = "300"; 
		            //        $config['file_name'] = time().rand(1000,9999); 
					// 	   $this->upload->initialize($config);
					// 	   $image_up = $this->upload->do_upload();
					// 		if (!$image_up){
					// 			$upload = array('error' => $this->upload->display_errors());
					// 		   $data['upload_error'] = $upload;							 
					// 		}else{
					// 			$image_data = array('upload_data' => $this->upload->data());							
					// 			$upload_name1[$i] = $image_data['upload_data']['file_name'];		
					// 		}
					// 	}
					// }
				    if(!isset($data['upload_error']) and !isset($data['question_upload_error']) and !isset($data['explanation_upload_error']))
					 {
						$alphabets = array('0'=>'A','1'=>'B','2'=>'C','3'=>'D','4'=>'E');
						$choice_array = array_slice($alphabets, 0, $choice_count);
						// $choice_array = array();
						// $ans_array = array();
						// foreach($alphabets as $key => $alpha){
						// 	if($this->input->post('answer_type'.($key+1)) !="" ){
						// 		$ans_array[$key] = $this->input->post('answer_type'.($key+1));
						//  	if($this->input->post('answer_type'.($key+1)) == 2){ 
						// 		if(isset($upload_name1[($key+1)])){
						// 			$choice_array[$alpha] = $upload_name1[($key+1)];
						// 			// unset($upload_name1[$key]);
						// 		}
						//  	}
						//  	 if($this->input->post('answer_type'.($key+1)) == 1){
						// 		if($this->input->post('choices'.($key+1))){
						// 			$choice_array[$alpha] = $this->input->post('choices'.($key+1));
						// 			// unset($name_array[$key]);
						// 		}
						//  	}
						//  }
						// }
						 //endforeach
						 if($this->input->post('tags_exist')){
						 	$tags = implode(',',$this->input->post('tags_exist'));
						 }	
						 if($this->input->post('tags')){
						 	if(isset($tags))
						 		$tags.=','. $this->input->post('tags');
						 	else
						 		$tags = $this->input->post('tags');
						 }
							 // print_r($tags);die;

						 $update_array = array ('question_type' => $this->input->post('question_type'), 
						 						'question_title' => $this->input->post('question_title'), 
											   'question' => $question, 
											   'tags' => strtolower($tags), 
											   //'answer_type' => implode(',',$ans_array), 
											   'choice_count' => $this->input->post('choice_count'),
											   'choices' => serialize($choice_array), 
											   'correct_answer' => implode(',',$answer_crct), 
											   'explanation_type' => $this->input->post('explanation_type'), 
											   'explanation_title' => $this->input->post('explanation_title'), 
											   'explanation' => $explanation, 
											   'severity' => $this->input->post('severity'), 
											   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
											   'show_options' => ($this->input->post('show_options')) ? $this->input->post('show_options') : 0,
											   'created' => $date
											   );
								   
							$insertId = $this->base_model->insert('questions_master', $update_array);
							$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
							redirect(base_url().SITE_ADMIN_URI.'/questions_master/');
					 }
				
			}
		
					$data['post'] = TRUE;
					$data['class_list'] = array();
					$data['subject_list'] = array();
					$join_tables = $where = array();  
				  	$fields = 'cl.id, cl.name class_name'; 
				  	$where[] = array( TRUE, 'rc.course_id', $this->input->post('course_list'));
				  	$join_tables[] = array('classes as cl','rc.class_id = cl.id');			  	
				  	$class_list = $this->base_model->get_advance_list('relevant_classes as rc', $join_tables, $fields, $where, '', 'cl.name', 'asc');
				  	if($class_list){
				  		$data['class_list'][''] = 'Select'; 
					  	foreach($class_list as $class){
					  		$data['class_list'][$class['id']] = ucfirst($class['class_name']);
					  	}
				  	}
				  	$join_tables = $where = array();  
				  	$fields = 's.id, s.name subject_name'; 
				  	$where[] = array( TRUE, 'rs.course_id', $this->input->post('course_list'));
				  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');			  	
				  	$subject_list = $this->base_model->get_advance_list('relevant_subjects as rs', $join_tables, $fields, $where, '', 's.name', 'asc');
					if($subject_list){
						$data['subject_list'][''] = 'Select'; 
						foreach($subject_list as $subject){
					  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
					  	}
				  	}
					$data['chapter_list'] = array();
					$data['chapter_list'] = $this->base_model->getSelectList('chapters', array('course_id' => $this->input->post('course_list'), 'class_id' => $this->input->post('class_list'), 'subject_id' => $this->input->post('subject_list')));
					$data['course_list'] = $this->base_model->getSelectList('courses');
					#new
					if($this->input->post('course_list')==""){
						$data['course_list'] = $this->base_model->getSelectList('courses'); 
						$data['class_list'] = $this->base_model->getSelectList('classes');
						$data['subject_list'] = $this->base_model->getSelectList('subjects');
						$data['chapter_list'] = $this->base_model->getSelectList('chapters');
					}

		}
		else{	
			$data['course_list'] = $this->base_model->getSelectList('courses');
			$data['class_list'] = $this->base_model->getSelectList('classes');
			$data['subject_list'] = $this->base_model->getSelectList('subjects');
			$data['chapter_list'] = $this->base_model->getSelectList('chapters');
		}
		$data['tags']=$this->base_model->get_tags();
			$data['main_content'] = 'questions_master/add';
			$data['page_title']  = 'Questions'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function edit($id = NULL)
	{						
			$data['post'] = FALSE;
			$this->load->helper('thumb_helper');
			$this->load->helper('html');
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->form_validation->set_rules('question_type', 'Question Type','trim|required');
				$this->form_validation->set_rules('question_title', 'Question Type','trim|required');
				$this->form_validation->set_rules('choice_count', 'Choice Count','trim|callback_validate_select[Choice Count]');
				$this->form_validation->set_rules('correct_answer[]', 'Correct Answer','trim|callback_validate_select[Correct Answer]');
				$this->form_validation->set_rules('explanation_type', 'Explanation','trim|required');
				$this->form_validation->set_rules('explanation_title', 'Explanation Type','trim|required');
				$this->form_validation->set_rules('severity', 'Severity','trim|required');
				$answer_crct = $this->input->post('correct_answer');

				
				if(!$this->input->post('tags_exist') && !$this->input->post('tags')){
					$this->form_validation->set_rules('tags', 'Question Tags','trim|required');
				}



				// if($choice_count = $this->input->post('choice_count')){
				// 	$k=0;
				// 	for($i=1;$i<=$choice_count;$i++){
				// 			if($k==0){
				// 				$option = 'A';
				// 			}elseif($k==1){
				// 				$option = 'B';
				// 			}elseif($k==2){
				// 				$option = 'C';
				// 			}elseif($k==3){
				// 				$option = 'D';
				// 			}elseif($k==4){
				// 				$option = 'E';
				// 			}

				// 		$this->form_validation->set_rules('answer_type'.$i, 'answer type for option'.$option,'trim|callback_validate_select[Answer Type]');
				// 	}
				// }


				// if($this->input->post('question_type') == 1){
				// 	$this->form_validation->set_rules('question', 'Question', 'trim|required');
				// }else{
				// 	if(!($this->input->post('question_image_present'))){	
				// 		if($_FILES['question']['name'] == ""){
				// 			$this->form_validation->set_rules('question', 'Question', 'trim|callback_validate_select[Question]');
				// 		}
				// 	}						
				// }
				// if($this->input->post('explanation_type') == 1){
				// 	$this->form_validation->set_rules('explanation', 'Explanation', 'trim|required');
				// }else if($this->input->post('explanation_type') == 2){
				// 	if(!($this->input->post('explanation_image_present'))){	
				// 		if($_FILES['explanation']['name'] == ""){
				// 			$this->form_validation->set_rules('explanation', 'Explanation', 'trim|callback_validate_select[Explanation]');
				// 		}
				// 	}						
				// }
			  	// for($i=1;$i<=$choice_count;$i++){
				// 				if($i==1){
				// 					$option = 'A';
				// 				}elseif($k==2){
				// 					$option = 'B';
				// 				}elseif($k==3){
				// 					$option = 'C';
				// 				}elseif($k==4){
				// 					$option = 'D';
				// 				}elseif($k==5){
				// 					$option = 'E';
				// 				}
				// 		if($this->input->post('answer_type'.$i) == 1){ 
				// 			$name_array = $this->input->post('choices'.$i);
				// 				 if ($name_array == "") {
				// 				     $this->form_validation->set_rules('choices'.$i, 'Text field '.$option.'', 'trim|required');
				// 				 }
				//   		}
				//   		if($this->input->post('answer_type'.$i) == 2){
				//   			if(!($this->input->post('choices_exist_img'.$i))){	
			  	// 				if($_FILES['choices'.$i]['name'] == ""){
			  	// 				$this->form_validation->set_rules('choices'.$i, 'Image field '.$option.'', 'trim|required');
			  	// 					}
			  	// 			}
				//   		}
			  	// 	}

				if ($this->form_validation->run())
				{
					$row = $this->base_model->getCommonListFields('questions_master','',array('id' => $id));                					
					$upload_name1 = array();
					$date = date('Y-m-d H:i:s');
					if($this->input->post('explanation_type')==2)
					{
						if($_FILES['explanation']['name'] != ""){
							$thumb_src = "";					
						  	$config['upload_path'] = $this->config->item('explanation_img');
							$config['allowed_types'] = "gif|jpg|jpeg|png"; 
							// $config['min_width'] = "300"; 
				            $config['file_name'] = time();
							$this->upload->initialize($config);
							$explanation_image_up = $this->upload->do_upload('explanation');
					
							if (!$explanation_image_up) {                  	
				         	$upload = array('error' => $this->upload->display_errors());
								$data['explanation_upload_error'] = $upload;
				       	}else{
				       		$image_data = array('upload_data' => $this->upload->data());
								$explanation = $image_data['upload_data']['file_name'];	
				       	}		
						}else{
							$explanation = $row[0]->explanation;					
						}
					}else if($this->input->post('explanation_type')==1){
						$explanation = $this->input->post('explanation');
					}
					else{
						$explanation = ' ';
					}	
					
					if($this->input->post('question_type')==2)
					{		
						if($_FILES['question']['name'] != ""){
							unset($config);
							$thumb_src = "";
							$config=array();							
							$config['upload_path'] = $this->config->item('question_img');
							$config['allowed_types'] = "gif|jpg|jpeg|png"; 
							// $config['min_width'] = "300"; 
				            $config['file_name'] = time(); 
							$this->upload->initialize($config);
							$question_image_up = $this->upload->do_upload('question');
					
							if (!$question_image_up) {                  	
				         	$upload = array('error' => $this->upload->display_errors());
								$data['question_upload_error'] = $upload;					   	 
				       	}else{
				       		$image_data = array('upload_data' => $this->upload->data());
								$question = $image_data['upload_data']['file_name'];								
				       	} 	
						}else{
							$question = $row[0]->question;
						}
						
					}else{
						$question = $this->input->post('question');
					}
					unset($config);						
					$config=array();
					$choice_count = $this->input->post('choice_count');	
					for($i=1;$i<=$choice_count;$i++){
						if($this->input->post('answer_type'.$i) == 2){ 
						$thumb_src = "";
						$files = $_FILES;
						//$cpt = count($_FILES['choices'.$i]['name']);

						if($_FILES['choices'.$i]['name'] != ""){
						   $_FILES['userfile']['name']= $files['choices'.$i]['name'];
                		   $_FILES['userfile']['type']= $files['choices'.$i]['type'];
						   $_FILES['userfile']['tmp_name']= $files['choices'.$i]['tmp_name'];
						   $_FILES['userfile']['error']= $files['choices'.$i]['error'];
						   $_FILES['userfile']['size']= $files['choices'.$i]['size'];
						   $config['upload_path'] = $this->config->item('answers_img');
						   $config['allowed_types'] = "gif|jpg|jpeg|png"; 
						   // $config['min_width'] = "300"; 
		                   $config['file_name'] = time().rand(1000,9999); 
						   $this->upload->initialize($config);
						   $image_up = $this->upload->do_upload();
							if (!$image_up){
								$upload = array('error' => $this->upload->display_errors());
							   $data['upload_error'] = $upload;							 
							}else{
								$image_data = array('upload_data' => $this->upload->data());							
								$upload_name1[$i] = $image_data['upload_data']['file_name'];		
							}
						}else{
							$upload_name1[$i] = $this->input->post('choices_exist_img'.$i);
						}
					}
				}
					
					if(!isset($data['upload_error']) and !isset($data['question_upload_error']) and !isset($data['explanation_upload_error'])){
					 	
						 $alphabets = array('0'=>'A','1'=>'B','2'=>'C','3'=>'D','4'=>'E');
						 $choice_array = array_slice($alphabets, 0, $choice_count);
						// $choice_array = array();
						// $ans_array = array();
						// foreach($alphabets as $key => $alpha){
						// 	if($this->input->post('answer_type'.($key+1)) !="" ){
						// 		$ans_array[$key] = $this->input->post('answer_type'.($key+1));
						//  	if($this->input->post('answer_type'.($key+1)) == 2){ 
						// 		if(isset($upload_name1[($key+1)])){
						// 			$choice_array[$alpha] = $upload_name1[($key+1)];
						// 			// unset($upload_name1[$key]);
						// 		}
						//  	}
						//  	 if($this->input->post('answer_type'.($key+1)) == 1){
						// 		if($this->input->post('choices'.($key+1))){
						// 			$choice_array[$alpha] = $this->input->post('choices'.($key+1));
						// 			// unset($name_array[$key]);
						// 		}
						//  	}
						//  }
						// }
					 //endforeach	

						 if($this->input->post('tags_exist')){
						 	$tags = implode(',',$this->input->post('tags_exist'));
						 }	
						 if($this->input->post('tags')){
						 	if(isset($tags))
						 		$tags.=','. $this->input->post('tags');
						 	else
						 		$tags = $this->input->post('tags');
						 }


							$update_array = array (
												   'question_type' => $this->input->post('question_type'), 
												   'question_title' => $this->input->post('question_title'), 
												   'question' => $question, 
												   'tags' => strtolower($tags), 
												   'answer_type' => implode(',',$ans_array), 
												   'choice_count' => $this->input->post('choice_count'),
												   'choices' => serialize($choice_array), 
												   'correct_answer' => implode(',',$answer_crct), 
												   'explanation_type' => $this->input->post('explanation_type'), 
												   'explanation_title' => $this->input->post('explanation_title'), 
												   'explanation' => $explanation, 
												   'severity' => $this->input->post('severity'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'show_options' => ($this->input->post('show_options')) ? $this->input->post('show_options') : 0,
												   'modified' => $date
												   );

							// questions table update
							$get_questions = $this->base_model->getCommonListFields('questions','',array('questions_master_id' => $id));
							if(count($get_questions)>0){
								$update_array_quest = array (
												   'question_type' => $this->input->post('question_type'), 
												   'question_title' => $this->input->post('question_title'), 
												   'question' => $question, 
												   'answer_type' => implode(',',$ans_array), 
												   'choice_count' => $this->input->post('choice_count'),
												   'choices' => serialize($choice_array), 
												   'correct_answer' => implode(',',$answer_crct), 
												   'explanation_type' => $this->input->post('explanation_type'), 
												   'explanation_title' => $this->input->post('explanation_title'), 
												   'explanation' => $explanation, 
												   'severity' => $this->input->post('severity'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'show_options' => ($this->input->post('show_options')) ? $this->input->post('show_options') : 0,
												   'modified' => $date
												   );

								$this->base_model->update('questions', $update_array_quest, array('questions_master_id' => $id));	
							}
							// questions table update
							// surprise questions table update for standard test
							$get_std_questions = $this->base_model->getCommonListFields('surprise_questions','',array('questions_master_id' => $id));
							if(count($get_std_questions)>0){
								$update_array_std_quest = array (
												   'question_type' => $this->input->post('question_type'), 
												   'question_title' => $this->input->post('question_title'), 
												   'question' => $question, 
												   'answer_type' => implode(',',$ans_array), 
												   'choice_count' => $this->input->post('choice_count'),
												   'choices' => serialize($choice_array), 
												   'correct_answer' => implode(',',$answer_crct), 
												   'explanation_type' => $this->input->post('explanation_type'), 
												   'explanation_title' => $this->input->post('explanation_title'), 
												   'explanation' => $explanation, 
												   'severity' => $this->input->post('severity'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'show_options' => ($this->input->post('show_options')) ? $this->input->post('show_options') : 0,
												   'modified' => $date
												   );

								$this->base_model->update('surprise_questions', $update_array_std_quest, array('questions_master_id' => $id));	
							}
							// surprise questions table update for standard test

						$this->base_model->update ( 'questions_master', $update_array, array('id'=>$id));
						$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
						redirect(base_url().SITE_ADMIN_URI.'/questions_master/');
					}	
				}

				$data['post'] = TRUE;
				$data['class_list'] = array();
				$data['subject_list'] = array();
				$join_tables = $where = array();  
			  	$fields = 'cl.id, cl.name class_name'; 
			  	$where[] = array( TRUE, 'rc.course_id', $this->input->post('course_list'));
			  	$join_tables[] = array('classes as cl','rc.class_id = cl.id');			  	
			  	$class_list = $this->base_model->get_advance_list('relevant_classes as rc', $join_tables, $fields, $where, '', 'cl.name', 'asc');
			  	if($class_list){
			  		$data['class_list'][''] = 'Select'; 
				  	foreach($class_list as $class){
				  		$data['class_list'][$class['id']] = ucfirst($class['class_name']);
				  	}
			  	}
			  	$join_tables = $where = array();  
			  	$fields = 's.id, s.name subject_name'; 
			  	$where[] = array( TRUE, 'rs.course_id', $this->input->post('course_list'));
			  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');			  	
			  	$subject_list = $this->base_model->get_advance_list('relevant_subjects as rs', $join_tables, $fields, $where, '', 's.name', 'asc');
				if($subject_list){
					$data['subject_list'][''] = 'Select'; 
					foreach($subject_list as $subject){
				  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
				  	}
			  	}
				$data['chapter_list'] = array();
				$data['chapter_list'] = $this->base_model->getSelectList('chapters', array('course_id' => $this->input->post('course_list'), 'class_id' => $this->input->post('class_list'), 'subject_id' => $this->input->post('subject_list')));
			   } else{
			  	$join_tables = $where = array();  
			  	$fields = 'c.choice_count'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$count = $this->base_model->get_advance_list('questions_master as c', $join_tables, $fields, $where, '', '', '');
		 	
		 	}
		 	$data['count'] = $count[0]['choice_count'];
	   		$data['course_list'] = $this->base_model->getSelectList('courses');
			$data['questions_main'] = $this->base_model->getCommonListFields('questions_master','',array('id' => $id));
			$data['questions'] = $data['questions_main'][0];
			// get question count from test details table
			$join_tables = $where = array();  
			$fields = 'COUNT(td.question_id) as is_delete'; 
			$where[] = array( TRUE, 'c.id', $id);
			$join_tables[] = array('test_details as td','td.question_id = c.id AND td.test_type!=2',"left");	
			$data['test_details'] = $this->base_model->get_advance_list('questions_master as c', $join_tables, $fields, $where, 'row', '', '');
			$data['tags']=$this->base_model->get_tags();
			$data['edited_tags']=$this->base_model->get_tags($id);
			// print_r($data['edited_tags']);
			// print_r($data['tags']);die;
			$data['main_content'] = 'questions_master/edit';
		  	$data['page_title']  = 'Questions'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}		
		

	
	
	public function delete($id,$pageredirect=null,$pageno) {

		$getImg = $this->base_model->getCommonListFields('questions_master',array('question_type', 'question_title', 'explanation_type',  'question', 'answer_type','choices', 'explanation_type', 'explanation'),array('id' => $id));
	 
		if($getImg['0']->question_type == '2'){
		        @unlink($this->config->item('question_img') . $getImg['0']->question);
		        @unlink($this->config->item('question_img') .'thumb_questions_img/'. $getImg['0']->question);
        }
				 
		if($getImg['0']->explanation_type == '2'){
		     @unlink($this->config->item('explanation_img') . $getImg['0']->explanation);
		     @unlink($this->config->item('question_img') .'thumb_explanation_img/'. $getImg['0']->explanation);
     	}
		if($getImg['0']->answer_type == '2'){
			$choices = unserialize($getImg['0']->choices);
			foreach($choices as $choice) {
		        @unlink($this->config->item('answers_img') . $choice);
		        @unlink($this->config->item('answers_img') .'thumb_answers_img/'. $choice);
		    }
        }
		$this->base_model->delete ('questions_master',array('id' => $id));
		$this->base_model->delete ('questions',array('questions_master_id' => $id)); //added
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/questions_master/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'questions_master';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/questions_master/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno){
		
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'questions_master');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'questions_master');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$getImg = $this->base_model->getCommonListFields('questions_master',array('answer_type','choices'),array('id' => $id));
		
				if($getImg['0']->answer_type == '2'){
					$choices = unserialize($getImg['0']->choices);
					foreach($choices as $choice) {
						@unlink($this->config->item('answers_img') . $choice);
					}
				}
				$this->base_model->delete('questions_master', array('id' => $id));
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/questions_master/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/questions_master/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function request(){
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$subject_id = $this->input->post('subject_id');
		$chapter_id = $this->input->post('chapter_id');
		$level_id = $this->input->post('level_id');
		$data = array();
		$data['set_list'] = array();
		$data['set_list'] = $this->base_model->getSelectList('sets', array('course_id' => $course_id, 'class_id' => $class_id, 'subject_id' => $subject_id, 'chapter_id' => $chapter_id,'level_id' => $level_id)); 
		echo json_encode($data);
	}
	public function import(){
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 			
			$this->form_validation->set_rules('course_list', 'course list','trim|callback_validate_select[Course]');
			if ($this->form_validation->run()){ 
				$this->load->library('upload');
				$file_path = $this->config->item( 'tmp_csv_path', 'file_path').time().'/';
				$config = array('upload_path'=>$file_path, 'allowed_types'=> 'csv');
				CreateDirectory($config['upload_path']);
				$this->upload->initialize($config);
				if ( $this->upload->do_upload('questions_csv')) {
					$upload_data = $this->upload->data();
					
					$file_name = $file_path.$upload_data['file_name']; 
					if ($csv_array = $this->csv_import->get_array($file_name)) { 
						$csv_header_array = array('Class Name','Subject Name','Chapter Name','Level Name','Set Name','Question Type','Question','Answer Type','Option A','Option B','Option C','Option D','Option E','Correct Answer','Explanation Type','Explanation','Severity'); 
						if( Check_valid_csv_header($csv_array['header_data'], $csv_header_array) ) {	  					 		
							$date = date('Y-m-d H:i:s'); 
							$insert_data = array(); 
							$count = 0; $subcount = 0; $subject_id = 0; $class_id = 0; $qtype = 0;
							foreach ($csv_array['row_data'] as $row) {
								if($row['Class Name'] != "" && $row['Subject Name'] != ""  && $row['Chapter Name'] != ""  && $row['Level Name'] != "" && $row['Set Name'] != ""
								 && $row['Question Type'] != ""  && $row['Question'] != ""  && $row['Answer Type'] != ""  && $row['Option A'] != "" && $row['Option B'] != "" && 
								 $row['Correct Answer'] != "" && $row['Explanation Type'] != "" && $row['Explanation'] != ""){
									if($row['Class Name'] != ""){
										$count = $this->base_model->getCount('classes',array('name' => $row['Class Name']));
										if ($count == 0) {
										 	$class_id = $this->base_model->insert('classes',array('created' => $date, 'modified' => $date, 'name' => $row['Class Name'], 'status' => '1'));
										}else{
											$fields = 'id'; 
					  	         			$where[] = array( TRUE, 'name', $row['Class Name']);
											$classes = $this->base_model->get_advance_list('classes', '', $fields, $where, 'row_array');
											unset($where);
											$class_id = $classes['id'];
										}
									}
									$relevantcount = $this->base_model->getCount('relevant_classes',array('class_id' => $class_id, 'course_id' => $this->input->post('course_list')));
									if ($relevantcount == 0) {
									 	$this->base_model->insert('relevant_classes',array('created' => $date, 'modified' => $date, 'course_id' => $this->input->post('course_list'), 'class_id' => $class_id, 'status' => '1'));
									}
									$subcount = $this->base_model->getCount('subjects',array('name' => $row['Subject Name']));
									if ($subcount == 0) {
									 	$subject_id = $this->base_model->insert('subjects',array('created' => $date, 'modified' => $date, 'name' => $row['Subject Name'], 'status' => '1'));							
									 	
									}else{
										$subfields = 'id'; 
				  	         			$subwhere[] = array( TRUE, 'name', $row['Subject Name']);
										$subjects = $this->base_model->get_advance_list('subjects', '', $subfields, $subwhere, 'row_array');
										unset($subwhere);
										$subject_id = $subjects['id'];
								
									}
									$relevantsubcount = $this->base_model->getCount('relevant_subjects',array('class_id' => $class_id, 'subject_id' => $subject_id,'course_id' => $this->input->post('course_list')));
									if ($relevantsubcount == 0) {
									 	$this->base_model->insert('relevant_subjects',array('created' => $date, 'modified' => $date, 'course_id' => $this->input->post('course_list'), 'class_id' => $class_id, 'subject_id' => $subject_id, 'status' => '1'));
									}
									$chapterscount = $this->base_model->getCount('chapters',array('name' => $row['Chapter Name'], 'subject_id' => $subject_id, 'class_id' => $class_id, 'course_id' => $this->input->post('course_list')));
									if ($chapterscount == 0) {
									 	$chapter_id = $this->base_model->insert('chapters',array('created' => $date, 'modified' => $date, 'name' => $row['Chapter Name'], 'status' => '1', 'subject_id' => $subject_id, 'class_id' => $class_id, 'course_id' => $this->input->post('course_list')));
									}else{
										$chapfields = 'id'; 
				  	         			$chapwhere[] = array( TRUE, 'name', $row['Chapter Name']);
				  	         			$chapwhere[] = array( TRUE, 'subject_id', $subject_id);
				  	         			$chapwhere[] = array( TRUE, 'class_id', $class_id);
				  	         			$chapwhere[] = array( TRUE, 'course_id', $this->input->post('course_list'));
										$chapters = $this->base_model->get_advance_list('chapters', '', $chapfields, $chapwhere, 'row_array');
										unset($chapwhere);
										$chapter_id = $chapters['id'];
								
									}
									$levelscount = $this->base_model->getCount('levels',array('name' => $row['Level Name'], 'chapter_id' => $chapter_id, 'subject_id' => $subject_id, 'class_id' => $class_id, 'course_id' => $this->input->post('course_list')));
									if ($levelscount == 0) {
									 	$level_id = $this->base_model->insert('levels',array('created' => $date, 'modified' => $date, 'name' => $row['Level Name'], 'status' => '1', 'subject_id' => $subject_id, 'class_id' => $class_id, 'course_id' => $this->input->post('course_list'), 'chapter_id' => $chapter_id));
									}else{
										$levelsfields = 'id'; 
				  	         			$levelswhere[] = array( TRUE, 'name', $row['Level Name']);
				  	         			$levelswhere[] = array( TRUE, 'chapter_id', $chapter_id);
				  	         			$levelswhere[] = array( TRUE, 'subject_id', $subject_id);
				  	         			$levelswhere[] = array( TRUE, 'class_id', $class_id);
				  	         			$levelswhere[] = array( TRUE, 'course_id', $this->input->post('course_list'));
										$levels = $this->base_model->get_advance_list('levels', '', $levelsfields, $levelswhere, 'row_array');
										unset($levelswhere);
										$level_id = $levels['id'];
								
									}
									$setscount = $this->base_model->getCount('sets',array('name' => $row['Set Name'], 'level_id' => $level_id, 'chapter_id' => $chapter_id, 'subject_id' => $subject_id, 'class_id' => $class_id, 'course_id' => $this->input->post('course_list')));
									if ($setscount == 0) {
									 	$set_id = $this->base_model->insert('sets',array('created' => $date, 'modified' => $date, 'name' => $row['Set Name'], 'status' => '1', 'subject_id' => $subject_id, 'class_id' => $class_id, 'course_id' => $this->input->post('course_list'), 'chapter_id' => $chapter_id, 'level_id' => $level_id));
									}else{
										$setsfields = 'id'; 
				  	         			$setswhere[] = array( TRUE, 'name', $row['Set Name']);
				  	         			$setswhere[] = array( TRUE, 'level_id', $level_id);
				  	         			$setswhere[] = array( TRUE, 'chapter_id', $chapter_id);
				  	         			$setswhere[] = array( TRUE, 'subject_id', $subject_id);
				  	         			$setswhere[] = array( TRUE, 'class_id', $class_id);
				  	         			$setswhere[] = array( TRUE, 'course_id', $this->input->post('course_list'));
										$sets = $this->base_model->get_advance_list('sets', '', $setsfields, $setswhere, 'row_array');
										unset($setswhere);
										$set_id = $sets['id'];								
									}
								
									$quescount = $this->base_model->getCount('questions_master',array('question' => $row['Question'], 'set_id' => $set_id, 'level_id' => $level_id, 'chapter_id' => $chapter_id, 'subject_id' => $subject_id, 'class_id' => $class_id, 'course_id' => $this->input->post('course_list')));
									$severity = 0;
									if ($quescount == 0) {
										$severity = array_search($row['Severity'], $this->config->item('severity'));
										$alphabets = array('A','B','C','D','E');
										$choice_array = array();
										foreach($alphabets as $alpha){
											if($row['Option '.$alpha] != null){
												$choice_array[$alpha] = $row['Option '.$alpha];
											}
										}
									
										if(strtolower($row['Question Type'])=="text"){
											$qtype = 1;
										}
										else{
											$qtype = 2;
										}
										// 1 text 2 image
										if(strtolower($row['Answer Type'])=="text"){
											$answer_type = 1;
										}
										else{
											$answer_type = 2;
										}
										if(strtolower($row['Explanation Type']) == "text"){
											$explanation_type = 1;
										}
										else{
											$explanation_type = 2;
										}
										$insertdata = array('created' => $date,
															'modified' => $date,
															'course_id' => $this->input->post('course_list'),
															'class_id' => $class_id,
															'subject_id' => $subject_id,
															'chapter_id' => $chapter_id,
															'level_id' => $level_id,
															'set_id' => $set_id,
															'question_type'=>$qtype,
															'answer_type' => $answer_type,
															'choice_count' => count($choice_array),
															'question' => $row['Question'],
															'choices' => serialize($choice_array),														
															'correct_answer' => $row['Correct Answer'],
															'explanation_type'=>$explanation_type,
															'explanation' => $row['Explanation'],
															'severity' => $severity,
															'status' => '1'
															);
									
									 	$ques_id = $this->base_model->insert('questions_master', $insertdata);
									}else{
										
									}
								}
							} 
							RemoveDirectory($file_path);
							$this->session->set_flashdata('flash_success_message', $this->lang->line('upload_csv_success'));
							redirect(base_url().SITE_ADMIN_URI.'/questions_master/');
						}else{
							$this->session->set_flashdata('flash_failure_message', $this->lang->line('upload_csv_mismatch_row'));
						}
					} else {
						$this->session->set_flashdata('flash_failure_message', $this->lang->line('upload_csv_failure'));
					}
				}else{
					$data['error'] = $this->upload->display_errors();
					$this->session->set_flashdata('flash_failure_message', $this->upload->display_errors());
				}
				RemoveDirectory($file_path);
			}
		}
		$data['post'] = TRUE;
		$data['course_list'] = $this->base_model->getSelectList('courses');
		$data['main_content'] = 'questions_master/import';
		$data['page_title']  = 'Questions'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function correct_answer(){
		$count = $this->input->post('count');
		$data = array();
		if($count == 2){
			$data['correct_answer'] = array('A'=>'A','B'=>'B');
		}
		else if($count == 3)
		{
			$data['correct_answer'] = array('A'=>'A','B'=>'B','C'=>'C');
		}
		else if($count == 4)
		{
			$data['correct_answer'] = array('A'=>'A','B'=>'B','C'=>'C','D'=>'D');
		}
		else
		{
			$data['correct_answer'] = array('A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E');
		}
		echo json_encode($data);
	}
	public function make_select($data_Arr,$place_hold){
		$to_ret[""]=$place_hold;
		foreach($data_Arr as $data_in){
			
			$to_ret[$data_in["id"]]=$data_in["name"];
			
		}
		return $to_ret;
		
	}
	public function image_view($question_img,$type)
	{
		if(!$this->session->has_userdata('admin_is_logged_in')){
			redirect(SITE_ADMIN_URI);
		}else
		{
			$data['ques_img'] = $question_img;
			$data['type'] = $type;
			$this->load->view('questions_master/img-popup',$data); 
		}
	}
}
