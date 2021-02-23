<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends Admin_Controller
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
			$this->load->model('base_model'); 
		}

		public function index($page_num = 1)
		{  
				$search_course_keyword  = trim($this->input->post('search_course'));
				if($search_course_keyword !='')		//set session for course
				{
					$this->session->set_userdata('search_course', $search_course_keyword); 
				}
				$keyword_course_session = $this->session->userdata('search_course');
				if($keyword_course_session != '')
				{
					$keyword_course = $this->session->userdata('search_course');
				}
				else
				{
					$keyword_course = "";
				}
				$search_class_keyword  = trim($this->input->post('search_class'));
				if($search_class_keyword !='')		//set session for class
				{
					$this->session->set_userdata('search_class', $search_class_keyword); 
				}
				$keyword_class_session = $this->session->userdata('search_class');
				if($keyword_class_session != '')
				{
					$keyword_class = $this->session->userdata('search_class');
				}
				else
				{
					$keyword_class = "";
				}
				$search_subject_keyword  = trim($this->input->post('search_subject'));
				if($search_subject_keyword !='')		//set session for subject
				{
					$this->session->set_userdata('search_subject', $search_subject_keyword); 
				}
				$keyword_subject_session = $this->session->userdata('search_subject');
				if($keyword_subject_session != '')
				{
					$keyword_subject = $this->session->userdata('search_subject');
				}
				else
				{
					$keyword_subject = "";
				}
				$search_chapter_keyword  = trim($this->input->post('search_chapter'));
				if($search_chapter_keyword !='')		//set session for chapter
				{
					$this->session->set_userdata('search_chapter', $search_chapter_keyword); 
				}
				$keyword_chapter_session = $this->session->userdata('search_chapter');
				if($keyword_chapter_session != '')
				{
					$keyword_chapter = $this->session->userdata('search_chapter');
				}
				else
				{
					$keyword_chapter = "";
				}
				$search_level_keyword  = trim($this->input->post('search_level'));
				if($search_level_keyword !='')		//set session for level
				{
					$this->session->set_userdata('search_level', $search_level_keyword); 
				}
				$keyword_level_session = $this->session->userdata('search_level');
				if($keyword_level_session != '')
				{
					$keyword_level = $this->session->userdata('search_level');
				}
				else
				{
					$keyword_level = "";
				}
				$search_set_keyword  = trim($this->input->post('search_set'));
				if($search_set_keyword !='')		//set session for set
				{
					$this->session->set_userdata('search_set', $search_set_keyword); 
				}
				$keyword_set_session = $this->session->userdata('search_set');
				if($keyword_set_session != '')
				{
					$keyword_set = $this->session->userdata('search_set');
				}
				else
				{
					$keyword_set = "";
				}	
				$search_name_keyword  = trim($this->input->post('search_name'));
				if($search_name_keyword !='')		//set session for name
				{
					$this->session->set_userdata('search_name', $search_name_keyword); 
				}
				$keyword_name_session = $this->session->userdata('search_name');
				if($keyword_name_session != '')
				{
					$keyword_name = $this->session->userdata('search_name');
				}
				else
				{
					$keyword_name = "";
				}	
				$this->load->library('pagination');
				$config  = $this->config->item('pagination');
			  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/questions/index";
			 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
			  	$config["uri_segment"] = 4;
			  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
			  	$limit_start = $config['per_page'];
			  	$join_tables = $where = array(); 
			  	if($keyword_name)
				{
					$where[] = array( TRUE, 'c.question LIKE ', '%'.$keyword_name.'%' );
					$data['keyword_name'] = $keyword_name;
				}
				else{
					$data['keyword_name'] = "";
				} 
				if($keyword_course)
				{
					$where[] = array( TRUE, 'c.course_id', $keyword_course);
					$data['keyword_course'] = $keyword_course;
				}
				else{
					$data['keyword_course'] = "";
				}
				if($keyword_class)
				{
					$where[] = array( TRUE, 'c.class_id', $keyword_class);
					$data['keyword_class'] = $keyword_class;
				}
				else{
					$data['keyword_class'] = "";
				}
				if($keyword_subject)
				{
					$where[] = array( TRUE, 'c.subject_id', $keyword_subject);
					$data['keyword_subject'] = $keyword_subject;
				}
				else{
					$data['keyword_subject'] = "";
				}
				if($keyword_chapter)
				{
					$where[] = array( TRUE, 'c.chapter_id', $keyword_chapter);
					$data['keyword_chapter'] = $keyword_chapter;
				}
				else{
					$data['keyword_chapter'] = "";
				}
				if($keyword_level)
				{
					$where[] = array( TRUE, 'c.level_id', $keyword_level);
					$data['keyword_level'] = $keyword_level;
				}
				else{
					$data['keyword_level'] = "";
				}
				if($keyword_set)
				{
					$where[] = array( TRUE, 'c.set_id', $keyword_set);
					$data['keyword_set'] = $keyword_set;
				}
				else{
					$data['keyword_set'] = "";
				}
				
			  	$fields = 'c.id, c.question, c.question_type, c.status, c.created, co.name course_name, cl.name class_name, s.name subject_name, ch.name chapter_name, l.name level_name, sets.name set_name'; 
			  	//$where[] = array( TRUE, 'c.status', 1);
			  	$join_tables[] = array('courses as co','c.course_id = co.id');
			  	$join_tables[] = array('classes as cl','c.class_id = cl.id');			  	
			  	$join_tables[] = array('subjects as s','c.subject_id = s.id');	
			  	$join_tables[] = array('chapters as ch','c.chapter_id = ch.id');
			  	$join_tables[] = array('levels as l','c.level_id = l.id');	
			  	$join_tables[] = array('sets as sets','c.set_id = sets.id');					  	
			  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, 'num_rows','','','c.id');
			  	$data['questions'] = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, '', 'c.id', 'desc', 'c.id', $limit_start, $limit_end);
			  	
			    $this->pagination->initialize($config);
			    $data['get_course'] = $this->base_model->getSelectList('courses');
			    $data['get_class'] = $this->base_model->getSelectList('classes');
				$data['get_subject'] = $this->base_model->getSelectList('subjects');
				$data['get_chapter'] = $this->base_model->getSelectList('chapters');
				$data['get_level'] = $this->base_model->getSelectList('levels');
				$data['get_set'] = $this->base_model->getSelectList('sets');
				$data['main_content'] = 'questions/index';
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
			redirect(base_url().SITE_ADMIN_URI.'/questions/');
		}
		public function add()
		{
			
			$data['post'] = FALSE;
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			
				$this->form_validation->set_rules('course_list', 'course list','trim|required');
				$this->form_validation->set_rules('class_list', 'class list','trim|required');
				$this->form_validation->set_rules('subject_list', 'subject list','trim|required');
				$this->form_validation->set_rules('chapter_list', 'chapter list','trim|required');
				$this->form_validation->set_rules('level_list', 'level list','trim|required');
				$this->form_validation->set_rules('set_list', 'set list','trim|required');
				$this->form_validation->set_rules('question_type', 'question type','trim|required');
				$this->form_validation->set_rules('answer_type', 'answer type','trim|required');
				$this->form_validation->set_rules('choice_count', 'choice count','trim|required');
				$this->form_validation->set_rules('correct_answer', 'correct answer','trim|required');
				$this->form_validation->set_rules('explanation_type', 'explanation type','trim|required');
				$this->form_validation->set_rules('severity', 'severity','trim|required');				
				
				if($this->input->post('question_type') == 1){
					$this->form_validation->set_rules('question', 'question', 'trim|required');
				}else{
					if($_FILES['question']['name'] == ""){
						$this->form_validation->set_rules('question', 'question', 'trim|required');
					}
				}
				
				if($this->input->post('explanation_type') == 1){
					$this->form_validation->set_rules('explanation', 'explanation', 'trim|required');
				}else{
					if($_FILES['explanation']['name'] == ""){
						$this->form_validation->set_rules('explanation', 'explanation', 'trim|required');
					}
				}
				
				if($this->input->post('answer_type') == 1){ 
					$name_array = $this->input->post('choices');
					if(!empty($name_array)){
						foreach ($name_array as $key => $name) {
						    if ($name == "") {
						        $this->form_validation->set_rules('choices[' . $key . ']', 'choices', 'trim|required');
						    }
						}
			  		}
		  		}else{
	  				$chcount = $this->input->post('choice_count');
	  				for($k = 0; $k < $chcount ; $k++) {
	  					if($_FILES['choices']['name'][$k] == ""){
	  					$this->form_validation->set_rules('choices[' . $k . ']', 'choices', 'trim|required');
	  					}
	  				}
		  		}
		  		
		  		//////////////////
				if ($this->form_validation->run()){ 				
					$date = date('Y-m-d H:i:s');
					$update_array = array();        
         				
					
					 
				   if($this->input->post('explanation_type')==2)
					{		
						$thumb_src = "";					
					  	$config['upload_path'] = $this->config->item('explanation_img');
						$config['allowed_types'] = "gif|jpg|jpeg|png"; 
						$config['min_width'] = "300"; 
	               $config['min_height'] = "300"; 					
						$this->upload->initialize($config);
						$explanation_image_up = $this->upload->do_upload('explanation');
						
						if (!$explanation_image_up) {                  	
                  	$upload = array('error' => $this->upload->display_errors());
					   	$data['explanation_upload_error'] = $upload;
                	}else{
                		$image_data = array('upload_data' => $this->upload->data());
							$explanation = $image_data['upload_data']['file_name'];	
							$thumb_exp_src = thumb($this->config->item('explanation_img') .$explanation ,'200', '200', 'thumb_explanation_img',FALSE);		
							$explanation	= $thumb_exp_src;			
                	}
					}else{
						$explanation = $this->input->post('explanation');
					}					
 					
					if($this->input->post('question_type')==2)
					{					 
						unset($config);
						$thumb_src = "";
						$config=array();							
						$config['upload_path'] = $this->config->item('question_img');
						$config['allowed_types'] = "gif|jpg|jpeg|png"; 
						$config['min_width'] = "300"; 
	               $config['min_height'] = "300"; 
					   $this->upload->initialize($config);
						$question_image_up = $this->upload->do_upload('question');
						
						if (!$question_image_up) {                  	
                  	$upload = array('error' => $this->upload->display_errors());
					   	$data['question_upload_error'] = $upload;					   	 
                	}else{
                		$image_data = array('upload_data' => $this->upload->data());
							$question = $image_data['upload_data']['file_name'];								
							$thumb_ques_src = thumb($this->config->item('question_img').$question ,'200', '200', 'thumb_questions_img',FALSE);
							$question = $thumb_ques_src;						
                	} 
					}else{
						$question = $this->input->post('question');
					}
											
				 	 
						unset($config);						
						$config=array();
					if($this->input->post('answer_type') == 2){ 
						$thumb_src = "";
						$files = $_FILES;
						$cpt = count($_FILES['choices']['name']);						
						for($i=0; $i<$cpt; $i++){
							$_FILES['userfile']['name']= $files['choices']['name'][$i];
                		$_FILES['userfile']['type']= $files['choices']['type'][$i];
						   $_FILES['userfile']['tmp_name']= $files['choices']['tmp_name'][$i];
						   $_FILES['userfile']['error']= $files['choices']['error'][$i];
						   $_FILES['userfile']['size']= $files['choices']['size'][$i];
						   
						   $config['upload_path'] = $this->config->item('answers_img');
						   $config['allowed_types'] = "gif|jpg|jpeg|png"; 
						   $config['min_width'] = "300"; 
		               $config['min_height'] = "300"; 						  					   
						   $this->upload->initialize($config);
						   $image_up = $this->upload->do_upload();
							if (!$image_up){
								$upload = array('error' => $this->upload->display_errors());
							   $data['upload_error'][$i] = $upload;							 
							}else{
								$image_data = array('upload_data' => $this->upload->data());									
							 	$thumb_src = thumb($this->config->item('answers_img') . $image_data['upload_data']['file_name'],'200', '200', 'thumb_answers_img',FALSE);
								$upload_name1[] = $thumb_src;							
							}
						}
				    }
				    
					 if(!isset($data['upload_error']) and !isset($data['question_upload_error']) and !isset($data['explanation_upload_error'])){
					 	if($this->input->post('answer_type') == 2){ 
					 		$alphabets = array('0'=>'A','1'=>'B','2'=>'C','3'=>'D','4'=>'E');
							$choice_array = array();
							foreach($alphabets as $key => $alpha){
								if(isset($upload_name1[$key])){
									$choice_array[$alpha] = $upload_name1[$key];
									unset($upload_name1[$key]);
								}
							}
					 	}else{
					 		$alphabets = array('0'=>'A','1'=>'B','2'=>'C','3'=>'D','4'=>'E');
							$choice_array = array();
							foreach($alphabets as $key => $alpha){
								if(isset($name_array[$key])){
									$choice_array[$alpha] = $name_array[$key];
									unset($name_array[$key]);
								}
							}					 		
					 	}					 	
					 	$update_array = array ('course_id' => $this->input->post('course_list'), 
												   'subject_id' => $this->input->post('subject_list'), 
												   'class_id' => $this->input->post('class_list'), 
												   'chapter_id' => $this->input->post('chapter_list'), 
												   'level_id' => $this->input->post('level_list'), 
												   'set_id' => $this->input->post('set_list'), 
												   'question_type' => $this->input->post('question_type'), 
												   'question' => $question, 
												   'answer_type' => $this->input->post('answer_type'), 
												   'choice_count' => $this->input->post('choice_count'), 												   
												   'choices' => serialize($choice_array), 
												   'correct_answer' => $this->input->post('correct_answer'), 
												   'explanation_type' => $this->input->post('explanation_type'), 
												   'explanation' => $explanation, 
												   'severity' => $this->input->post('severity'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'created' => $date
												   );
								print_r($update_array);
							$insertId = $this->base_model->insert('questions', $update_array);
							$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
							redirect(base_url().SITE_ADMIN_URI.'/questions/');
					 }
				}
				
				///////////////////
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

				$data['level_list'] = array();
				$data['level_list'] = $this->base_model->getSelectList('levels', array('course_id' => $this->input->post('course_list'), 'class_id' => $this->input->post('class_list'), 'subject_id' => $this->input->post('subject_list'), 'chapter_id' => $this->input->post('chapter_list')));
				
				$data['set_list'] = array();
				$data['set_list'] = $this->base_model->getSelectList('sets', array('course_id' => $this->input->post('course_list'), 'class_id' => $this->input->post('class_list'), 'subject_id' => $this->input->post('subject_list'), 'chapter_id' => $this->input->post('chapter_list'), 'id' => $this->input->post('set_list')));
				$data['course_list'] = $this->base_model->getSelectList('courses');
				#new
			if($this->input->post('course_list')==""){
				$data['course_list'] = $this->base_model->getSelectList('courses'); 
				$data['class_list'] = $this->base_model->getSelectList('classes');
				$data['subject_list'] = $this->base_model->getSelectList('subjects');
				$data['chapter_list'] = $this->base_model->getSelectList('chapters');
			}
			}else{			
			$data['course_list'] = $this->base_model->getSelectList('courses');
			$data['class_list'] = $this->base_model->getSelectList('classes');
			$data['subject_list'] = $this->base_model->getSelectList('subjects');
			$data['chapter_list'] = $this->base_model->getSelectList('chapters');
			$data['level_list'] = $this->base_model->getSelectList('levels');
			$data['set_list'] = $this->base_model->getSelectList('sets');
			}

			$data['main_content'] = 'questions/add';
			$data['page_title']  = 'Questions'; 
			$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		
		public function edit($id = NULL)
		{						
			$data['post'] = FALSE;
			$this->load->helper('thumb_helper');
			$this->load->helper('html');
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->form_validation->set_rules('course_list', 'course list','trim|required');
				$this->form_validation->set_rules('class_list', 'class list','trim|required');
				$this->form_validation->set_rules('subject_list', 'subject list','trim|required');
				$this->form_validation->set_rules('chapter_list', 'chapter list','trim|required');
				$this->form_validation->set_rules('level_list', 'level list','trim|required');
				$this->form_validation->set_rules('set_list', 'set list','trim|required');
				$this->form_validation->set_rules('question_type', 'question type','trim|required');
				$this->form_validation->set_rules('answer_type', 'answer type','trim|required');
				$this->form_validation->set_rules('choice_count', 'choice count','trim|required');
				$this->form_validation->set_rules('correct_answer', 'correct answer','trim|required');
				$this->form_validation->set_rules('explanation_type', 'explanation','trim|required');
				$this->form_validation->set_rules('severity', 'severity','trim|required');
				
				if($this->input->post('question_type') == 1){
					$this->form_validation->set_rules('question', 'question', 'trim|required');
				}else{
					if(!($this->input->post('question_image_present'))){	
						if($_FILES['question']['name'] == ""){
							$this->form_validation->set_rules('question', 'question', 'trim|required');
						}
					}						
				}
			
				if($this->input->post('explanation_type') == 1){
					$this->form_validation->set_rules('explanation', 'explanation', 'trim|required');
				}else{
					if(!($this->input->post('explanation_image_present'))){	
						if($_FILES['explanation']['name'] == ""){
							$this->form_validation->set_rules('explanation', 'explanation', 'trim|required');
						}
					}						
				}
				
		  		if($this->input->post('answer_type') == 1){ 
				$name_array = $this->input->post('choices');
				if(!empty($name_array)){
					foreach ($name_array as $key => $name) {
					    if ($name == "") {
					        $this->form_validation->set_rules('choices[' . $key . ']', 'choices', 'trim|required');
					    }
					}
		  		}
		  		}else{
		  			if(!($this->input->post('image_present'))){	
	  				$chcount = $this->input->post('choice_count');
	  				for($k = 0; $k < $chcount ; $k++) {
	  					if($_FILES['choices']['name'][$k] == ""){
	  					$this->form_validation->set_rules('choices[' . $k . ']', 'choices', 'trim|required');
	  					}
	  				}
	  				}
		  		}
				if ($this->form_validation->run())
				{
					$row = $this->base_model->getCommonListFields('questions','',array('id' => $id));                					
					$upload_name1 = array();
					$date = date('Y-m-d H:i:s');
					if($this->input->post('explanation_type')==2)
					{
						if($_FILES['explanation']['name'] != ""){
							$thumb_src = "";					
						  	$config['upload_path'] = $this->config->item('explanation_img');
							$config['allowed_types'] = "gif|jpg|jpeg|png"; 
							$config['min_width'] = "300"; 
				         $config['min_height'] = "300"; 					
							$this->upload->initialize($config);
							$explanation_image_up = $this->upload->do_upload('explanation');
					
							if (!$explanation_image_up) {                  	
				         	$upload = array('error' => $this->upload->display_errors());
								$data['explanation_upload_error'] = $upload;
				       	}else{
				       		$image_data = array('upload_data' => $this->upload->data());
								$explanation = $image_data['upload_data']['file_name'];	
								$thumb_exp_src = thumb($this->config->item('explanation_img') .$explanation ,'200', '200', 'thumb_explanation_img',FALSE);		
								$explanation	= $thumb_exp_src;			
				       	}		
						}else{
							$explanation = $row[0]->explanation;					
						}
					}else{
						$explanation = $this->input->post('explanation');
					}
					
					if($this->input->post('question_type')==2)
					{		
						if($_FILES['question']['name'] != ""){
							unset($config);
							$thumb_src = "";
							$config=array();							
							$config['upload_path'] = $this->config->item('question_img');
							$config['allowed_types'] = "gif|jpg|jpeg|png"; 
							$config['min_width'] = "300"; 
				         $config['min_height'] = "300"; 
							$this->upload->initialize($config);
							$question_image_up = $this->upload->do_upload('question');
					
							if (!$question_image_up) {                  	
				         	$upload = array('error' => $this->upload->display_errors());
								$data['question_upload_error'] = $upload;					   	 
				       	}else{
				       		$image_data = array('upload_data' => $this->upload->data());
								$question = $image_data['upload_data']['file_name'];								
								$thumb_ques_src = thumb($this->config->item('question_img').$question ,'200', '200', 'thumb_questions_img',FALSE);
								$question = $thumb_ques_src;						
				       	} 	
						}else{
							$question = $row[0]->question;
						}
						
					}else{
						$question = $this->input->post('question');
					}
					
					unset($config);						
					$config=array();
					if($this->input->post('answer_type') == 2){ 
						//if($this->input->post('image_present') ){
							$thumb_src = "";
							$files = $_FILES;
							$cpt = count($_FILES['choices']['name']);						
							for($i=0; $i<$cpt; $i++){
								if($files['choices']['name'][$i] != ""){  
									$_FILES['userfile']['name']= $files['choices']['name'][$i];
						    		$_FILES['userfile']['type']= $files['choices']['type'][$i];
									$_FILES['userfile']['tmp_name']= $files['choices']['tmp_name'][$i];
									$_FILES['userfile']['error']= $files['choices']['error'][$i];
									$_FILES['userfile']['size']= $files['choices']['size'][$i];
							
									$config['upload_path'] = $this->config->item('answers_img');
									$config['allowed_types'] = "gif|jpg|jpeg|png"; 
									$config['min_width'] = "300"; 
							      $config['min_height'] = "300"; 						  					   
									$this->upload->initialize($config);
									$image_up = $this->upload->do_upload();
									if (!$image_up){
										$upload = array('error' => $this->upload->display_errors());
										$data['upload_error'][$i] = $upload;							 
									}else{
										$image_data = array('upload_data' => $this->upload->data());									
										$thumb_src = thumb($this->config->item('answers_img') . $image_data['upload_data']['file_name'],'200', '200', 'thumb_answers_img',FALSE);
										$upload_name1[] = $thumb_src;							
									}
								}
							}								
						//}						
					 }
					
					if(!isset($data['upload_error']) and !isset($data['question_upload_error']) and !isset($data['explanation_upload_error'])){
					 	if($this->input->post('answer_type') == 2){ 
						 	$alphabets = array('0'=>'A','1'=>'B','2'=>'C','3'=>'D','4'=>'E');
							$choice_array = array();
							foreach($alphabets as $key => $alpha){
								if(isset($upload_name1[$key])){
									$choice_array[$alpha] = $upload_name1[$key];
									unset($upload_name1[$key]);
								}
							}
						 }else{
						 	$alphabets = array('0'=>'A','1'=>'B','2'=>'C','3'=>'D','4'=>'E');
							$choice_array = array();
							foreach($alphabets as $key => $alpha){
								if(isset($name_array[$key])){
									$choice_array[$alpha] = $name_array[$key];
									unset($name_array[$key]);
								}
							}					 		
						}				 	
							
						if(empty($choice_array)){
							$update_array = array ('course_id' => $this->input->post('course_list'), 
												   'subject_id' => $this->input->post('subject_list'), 
												   'class_id' => $this->input->post('class_list'), 
												   'chapter_id' => $this->input->post('chapter_list'), 
												   'level_id' => $this->input->post('level_list'), 
												   'set_id' => $this->input->post('set_list'), 
												   'question_type' => $this->input->post('question_type'), 
												   'question' => $question, 
												   'answer_type' => $this->input->post('answer_type'), 
												   'choice_count' => $this->input->post('choice_count'), 												  
												   'correct_answer' => $this->input->post('correct_answer'), 
												   'explanation_type' => $this->input->post('explanation_type'), 
												   'explanation' => $explanation, 
												   'severity' => $this->input->post('severity'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'modified' => $date
												   );
						}else{
							$update_array = array ('course_id' => $this->input->post('course_list'), 
												   'subject_id' => $this->input->post('subject_list'), 
												   'class_id' => $this->input->post('class_list'), 
												   'chapter_id' => $this->input->post('chapter_list'), 
												   'level_id' => $this->input->post('level_list'), 
												   'set_id' => $this->input->post('set_list'), 
												   'question_type' => $this->input->post('question_type'), 
												   'question' => $question, 
												   'answer_type' => $this->input->post('answer_type'), 
												   'choice_count' => $this->input->post('choice_count'), 												   
												   'choices' => serialize($choice_array), 
												   'correct_answer' => $this->input->post('correct_answer'), 
												   'explanation_type' => $this->input->post('explanation_type'), 
													'explanation' => $explanation, 
												   'severity' => $this->input->post('severity'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'modified' => $date
												   );
						}	
						$this->base_model->update ( 'questions', $update_array, array('id'=>$id));
						$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
						redirect(base_url().SITE_ADMIN_URI.'/questions/');
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

				$data['level_list'] = array();
				$data['level_list'] = $this->base_model->getSelectList('levels', array('course_id' => $this->input->post('course_list'), 'class_id' => $this->input->post('class_list'), 'subject_id' => $this->input->post('subject_list'), 'chapter_id' => $this->input->post('chapter_list')));
				
				$data['set_list'] = array();
				$data['set_list'] = $this->base_model->getSelectList('sets', array('course_id' => $this->input->post('course_list'), 'class_id' => $this->input->post('class_list'), 'subject_id' => $this->input->post('subject_list'), 'chapter_id' => $this->input->post('chapter_list'), 'id' => $this->input->post('set_list')));
			}else{
				$fields = 'cl.id, cl.name class_name'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$join_tables[] = array('relevant_classes as rl','c.course_id = rl.course_id');			
			  	$join_tables[] = array('classes as cl','rl.class_id = cl.id');  	
			  	$class_list = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, '', 'cl.name', 'asc');
			  	if($class_list){
				  	foreach($class_list as $class){
				  		$data['class_list'][$class['id']] = ucfirst($class['class_name']);
				  	}
			  	}
			  	
			  	$join_tables = $where = array();  
			  	$fields = 's.id, s.name subject_name'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$join_tables[] = array('relevant_subjects as rs','c.course_id = rs.course_id');	
			  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');  		  	
			  	$subject_list = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, '', 's.name', 'asc');
				if($subject_list){
					foreach($subject_list as $subject){
				  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
				  	}
			  	}
			  	
			  	$join_tables = $where = array();  
			  	$fields = 'ch.id, ch.name chapter_name'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$join_tables[] = array('chapters as ch','c.course_id = ch.course_id and c.class_id = ch.class_id and c.subject_id = ch.subject_id');
			  	$chapter_list = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, '', 'ch.name', 'asc');
				$data['chapter_list'] = array();
				if($chapter_list){
					foreach($chapter_list as $chapter){
				  		$data['chapter_list'][$chapter['id']] = ucfirst($chapter['chapter_name']);
				  	}
			  	}
			 	
				$join_tables = $where = array();  
			  	$fields = 'ch.id, ch.name level_name'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$join_tables[] = array('levels as ch','c.course_id = ch.course_id and c.class_id = ch.class_id and c.subject_id = ch.subject_id and c.chapter_id = ch.chapter_id');
			  	$level_list = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, '', 'ch.name', 'asc');
			
				if($level_list){
					foreach($level_list as $level){
				  		$data['level_list'][$level['id']] = ucfirst($level['level_name']);
				  	}
			  	}
			  	
			  	$join_tables = $where = array();  
			  	$fields = 'sets.id, sets.name set_name'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$join_tables[] = array('sets as sets','c.course_id = sets.course_id and c.class_id = sets.class_id and c.subject_id = sets.subject_id and c.chapter_id = sets.chapter_id and c.set_id = sets.id');
			  	$set_list = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, '', 'sets.name', 'asc');
			
				if($set_list){
					foreach($set_list as $set){
				  		$data['set_list'][$set['id']] = ucfirst($set['set_name']);
				  	}
			  	}
		 
		 	}
		   $data['course_list'] = $this->base_model->getSelectList('courses');
			$data['questions_main'] = $this->base_model->getCommonListFields('questions','',array('id' => $id));
			$data['questions'] = $data['questions_main'][0];
			$data['main_content'] = 'questions/edit';
		  	$data['page_title']  = 'Questions'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}

	
	
	public function delete($id,$pageredirect=null,$pageno) {
		$getImg = $this->base_model->getCommonListFields('questions',array('question_type', 'question', 'answer_type','choices', 'explanation_type', 'explanation'),array('id' => $id));		
		if($getImg['0']->question_type == '2'){
		        @unlink($this->config->item('question_img') . $getImg['0']->$question);
		        @unlink($this->config->item('question_img') .'thumb_questions_img/'. $getImg['0']->$question);
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
		$this->base_model->delete ('questions',array('id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/questions/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'questions';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/questions/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno){
		
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'questions');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'questions');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$getImg = $this->base_model->getCommonListFields('questions',array('answer_type','choices'),array('id' => $id));
		
				if($getImg['0']->answer_type == '2'){
					$choices = unserialize($getImg['0']->choices);
					foreach($choices as $choice) {
						@unlink($this->config->item('answers_img') . $choice);
					}
				}
				$this->base_model->delete('questions', array('id' => $id));
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/questions/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/questions/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
			$this->form_validation->set_rules('course_list', 'course list','trim|required');
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
						$csv_header_array = array('Question Type','Class Name','Subject Name','Chapter Name','Level Name','Set Name','Question','Option A','Option B','Option C','Option D','Option E','Correct Answer','Explanation','Severity'); 
						if( Check_valid_csv_header($csv_array['header_data'], $csv_header_array) ) {	  					 		
							$date = date('Y-m-d H:i:s'); 
							$insert_data = array(); 
							$count = 0; $subcount = 0; $subject_id = 0; $class_id = 0; $qtype = 0;
							foreach ($csv_array['row_data'] as $row) {
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
								
								$quescount = $this->base_model->getCount('questions',array('question' => $row['Question'], 'set_id' => $set_id, 'level_id' => $level_id, 'chapter_id' => $chapter_id, 'subject_id' => $subject_id, 'class_id' => $class_id, 'course_id' => $this->input->post('course_list')));
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
									
									if($row['Question Type'] == "text"){
										$qtype = 1;
									}else{
										$qtype = 2;
									}
									$insertdata = array('created' => $date,
														'modified' => $date,
														'question' => $row['Question'],
														'correct_answer' => $row['Correct Answer'],
														'explanation' => $row['Explanation'],
														'answer_type' => $qtype,
														
														'choice_count' => count($choice_array),
														'choices' => serialize($choice_array),
														'severity' => $severity,
														
														'status' => '1',
														'subject_id' => $subject_id,
														'class_id' => $class_id,
														'course_id' => $this->input->post('course_list'),
														'chapter_id' => $chapter_id,
														'level_id' => $level_id,
														'set_id' => $set_id
														);
									
								 	$ques_id = $this->base_model->insert('questions', $insertdata);
								}else{
									/*$quesfields = 'id'; 
			  	         			$queswhere[] = array( TRUE, 'question', $row['Question']);
			  	         			$queswhere[] = array( TRUE, 'set_id', $set_id);
			  	         			$queswhere[] = array( TRUE, 'level_id', $level_id);
			  	         			$queswhere[] = array( TRUE, 'chapter_id', $chapter_id);
			  	         			$queswhere[] = array( TRUE, 'subject_id', $subject_id);
			  	         			$queswhere[] = array( TRUE, 'class_id', $class_id);
			  	         			$queswhere[] = array( TRUE, 'course_id', $this->input->post('course_list'));
									$questions = $this->base_model->get_advance_list('questions', '', $quesfields, $queswhere, 'row_array');
									$ques_id = $questions['id'];*/
								}
								//echo $this->input->post('course_list')."class id ".$class_id." subjct id".$subject_id." ".$chapter_id." ".$level_id." ".$set_id." ".$ques_id; die;
							} 
							RemoveDirectory($file_path);
							//if($insert_data) $this->base_model->insert_batch('questions', $insert_data);
							$this->session->set_flashdata('flash_success_message', $this->lang->line('upload_csv_success'));
							redirect(base_url().SITE_ADMIN_URI.'/questions/');
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
				
				//$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
				//redirect(base_url().SITE_ADMIN_URI.'/questions/');
			}
		}
		$data['post'] = TRUE;
		$data['course_list'] = $this->base_model->getSelectList('courses');
		$data['main_content'] = 'questions/import';
		$data['page_title']  = 'Questions'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
}
