<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subjective_questions extends Admin_Controller
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
				$search_course_keyword  = isset($_POST['search_course'])?trim($_POST['search_course']):(isset($_SESSION['search_course'])?$_SESSION['search_course']:'');				
				$this->session->set_userdata('search_course', $search_course_keyword); 				
				$keyword_course_session = $this->session->userdata('search_course');
				if($keyword_course_session != '')
				{
					$keyword_course = $this->session->userdata('search_course');
				}
				else
				{
					isset($_SESSION['search_course'])?$this->session->unset_userdata('search_course'):'';
					$keyword_course = "";
				}
				
				$search_class_keyword  = isset($_POST['search_class'])?trim($_POST['search_class']):(isset($_SESSION['search_class'])?$_SESSION['search_class']:'');				
				$this->session->set_userdata('search_class', $search_class_keyword); 				
				$keyword_class_session = $this->session->userdata('search_class');
				if($keyword_class_session != '')
				{
					$keyword_class = $this->session->userdata('search_class');
				}
				else
				{
					isset($_SESSION['search_class'])?$this->session->unset_userdata('search_class'):'';
					$keyword_class = "";
				}
				
				$search_subject_keyword  = isset($_POST['search_subject'])?trim($_POST['search_subject']):(isset($_SESSION['search_subject'])?$_SESSION['search_subject']:'');
				$this->session->set_userdata('search_subject', $search_subject_keyword); 				
				$keyword_subject_session = $this->session->userdata('search_subject');
				if($keyword_subject_session != '')
				{
					$keyword_subject = $this->session->userdata('search_subject');
				}
				else
				{
					isset($_SESSION['search_subject'])?$this->session->unset_userdata('search_subject'):'';
					$keyword_subject = "";
				}
				
				$search_category_keyword  = isset($_POST['search_category'])?trim($_POST['search_category']):(isset($_SESSION['search_category'])?$_SESSION['search_category']:'');
				$this->session->set_userdata('search_category', $search_category_keyword); 				
				$keyword_category_session = $this->session->userdata('search_category');
				if($keyword_category_session != '')
				{
					$keyword_category = $this->session->userdata('search_category');
				}
				else
				{
					isset($_SESSION['search_category'])?$this->session->unset_userdata('search_category'):'';
					$keyword_category = "";
				}
				
				$search_chapter_keyword  = isset($_POST['search_chapter'])?trim($_POST['search_chapter']):(isset($_SESSION['search_chapter'])?$_SESSION['search_chapter']:'');
				$this->session->set_userdata('search_chapter', $search_chapter_keyword); 				
				$keyword_chapter_session = $this->session->userdata('search_chapter');
				if($keyword_chapter_session != '')
				{
					$keyword_chapter = $this->session->userdata('search_chapter');
				}
				else
				{
					isset($_SESSION['search_chapter'])?$this->session->unset_userdata('search_chapter'):'';
					$keyword_chapter = "";
				}
				
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
			  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/subjective_questions/index";
			 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
			  	$config["uri_segment"] = 4;
			  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
			  	$limit_start = $config['per_page'];
			  	$join_tables = $where = array(); 
			  	if($keyword_name)
				{
					$where[] = array( TRUE, 'c.question LIKE ', '%'.$keyword_name.'%' );
					$where[] = array( TRUE, 'c.question_type', 1);
					$data['keyword_name'] = $keyword_name;
				}
				else{
					$data['keyword_name'] = "";
				} 
				if($keyword_course)
				{
					$where[] = array( TRUE, 'c.course_id', $keyword_course);
					$data['keyword_course'] = $keyword_course;
					$fields_f="c.id,name";
					$join_tables_f[] = array('relevant_classes as rc','rc.class_id = c.id');
					$where_f[]= array( TRUE, 'rc.course_id', $keyword_course);
			     	$data_cass = $this->base_model->get_advance_list('classes as c', $join_tables_f, $fields_f, $where_f, '','name','asc',''); 
					 $data["get_class"]=$this->make_select($data_cass,"Select Class"); 
					 unset($where_f);
					 unset($join_tables_f);
					 //rel subjects
					 $fields_f="c.id,name";
					$join_tables_f[] = array('relevant_subjects as rc','rc.subject_id = c.id');
					$where_f[]= array( TRUE, 'rc.course_id', $keyword_course);
			     	$data_cass = $this->base_model->get_advance_list('subjects as c', $join_tables_f, $fields_f, $where_f, '','name','asc',''); 
					 $data["get_subject"]=$this->make_select($data_cass,"Select Subject");
					 unset($where_f);
					 unset($join_tables_f);
					 
				}
				else{
					$data['keyword_course'] = "";
				}
				if($keyword_class)
				{
					$where[] = array( TRUE, 'c.class_id', $keyword_class);
					$data['keyword_class'] = $keyword_class;
					$fields_f="c.id,name";
					$join_tables_f[] = array('relevant_subjects as rc','rc.subject_id = c.id');
					$where_f[]= array( TRUE, 'rc.course_id', $keyword_class);
			     	$data_cass = $this->base_model->get_advance_list('subjects as c', $join_tables_f, $fields_f, $where_f, '','name','asc',''); 
					 $data["get_subject"]=$this->make_select($data_cass,"Select Subject");
					 unset($where_f);
					 unset($join_tables_f);
				}
				else{
					$data['keyword_class'] = "";
				}
				if($keyword_subject)
				{
					$where[] = array( TRUE, 'c.subject_id', $keyword_subject);
					$data['keyword_subject'] = $keyword_subject;
					$fields_f="rc.id,name";
					$join_tables_f =array();
					$where_f[]= array( TRUE, 'rc.subject_id', $keyword_subject);
					if($keyword_class!=""){
						$where_f[]= array( TRUE, 'rc.class_id', $keyword_class);
					}
					if($keyword_course!=""){
						$where_f[]= array( TRUE, 'rc.course_id', $keyword_course);
					} 
			     	$data_cass = $this->base_model->get_advance_list('chapters as rc', $join_tables_f, $fields_f, $where_f, '','','',''); 
					 $data["get_chapter"]=$this->make_select($data_cass,"Select Chapter");
					 unset($where_f);
					 unset($join_tables_f);
				}
				else{
					$data['keyword_subject'] = "";
				}
				if($keyword_category)
				{
					$where[] = array( TRUE, 'c.sub_category_id', $keyword_category);
					$data['keyword_category'] = $keyword_category;
				}
				else{
					$data['keyword_category'] = "";
				}
				if($keyword_chapter)
				{
					$where[] = array( TRUE, 'c.chapter_id', $keyword_chapter);
					$data['keyword_chapter'] = $keyword_chapter;
				}
				else{
					$data['keyword_chapter'] = "";
				}
				
			  	$fields = 'c.id, c.question, c.question_type, c.status, c.created, co.name course_name, cl.name class_name, s.name subject_name, ch.name chapter_name,COUNT(td.question_id) as is_delete,sc.name as category_name'; 
			  	$where[] = array( TRUE, 'co.is_subjective', 1);
			  	$join_tables[] = array('courses as co','c.course_id = co.id');
			  	$join_tables[] = array('relevant_classes as rc','c.course_id = rc.course_id and rc.class_id=c.class_id');
			  	$join_tables[] = array('classes as cl','rc.class_id = cl.id');	
			  	$join_tables[] = array('relevant_subjects as rs','c.course_id = rs.course_id and rs.subject_id=c.subject_id and rc.class_id=rs.class_id');		  	
			  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');	
			  	$join_tables[] = array('chapters as ch','c.chapter_id = ch.id');
			  	$join_tables[] = array('sub_category as sc','sc.id = c.sub_category_id');	
			  	$join_tables[] = array('test_details as td','td.question_id = c.id AND td.test_type!=2',"left");			
			  	$where[] = array( TRUE, 'co.status', 1); 
		  		$where[] = array( TRUE, 'cl.status', 1);  
		  		$where[] = array( TRUE, 's.status', 1); 
		  		$where[] = array( TRUE, 'ch.status', 1);	
		  		$where[] = array( TRUE, 'sc.status', 1);	  	
			  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('subjective_questions as c', $join_tables, $fields, $where, 'num_rows','','','c.id');
			  	$data['subjective_questions'] = $this->base_model->get_advance_list('subjective_questions as c', $join_tables, $fields, $where, '', 'c.id', 'desc', 'c.id', $limit_start, $limit_end);			  	
			   $this->pagination->initialize($config);
			   $where_sub_course = array('is_subjective'=>1);
			   $data['get_course'] = $this->base_model->getSelectList('courses',$where_sub_course); 
			   $data['get_category'] = $this->base_model->getSelectList('sub_category'); 
			   $data['main_content'] = 'subjective_questions/index';
			   $data['page_title']  = 'Subjective Questions'; 
			   $this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function reset()
		{
			$this->session->unset_userdata('search_name');
			$this->session->unset_userdata('search_course');
			$this->session->unset_userdata('search_class');
			$this->session->unset_userdata('search_subject');
			$this->session->unset_userdata('search_chapter');
			$this->session->unset_userdata('search_category');
			redirect(base_url().SITE_ADMIN_URI.'/subjective_questions/');
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
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 				
			
				$this->form_validation->set_rules('course_list', 'course list','trim|callback_validate_select[Course]');
				$this->form_validation->set_rules('class_list', 'class list','trim|callback_validate_select[Class]');
				$this->form_validation->set_rules('subject_list', 'subject list','trim|callback_validate_select[Subject]');
				$this->form_validation->set_rules('chapter_list', 'chapter list','trim|callback_validate_select[Chapter]');
				$this->form_validation->set_rules('category_list', 'sub category','trim|callback_validate_select[Sub Category]');
				$this->form_validation->set_rules('question_type', 'Question Type','trim|required');
				$this->form_validation->set_rules('explanation_type', 'Explanation Type','trim|required');
				
				if($this->input->post('question_type') == 1){
					$this->form_validation->set_rules('question', 'Question', 'trim|required');
				}else{
					if($_FILES['question']['name'] == ""){
						$this->form_validation->set_rules('question', 'Question', 'trim|callback_validate_select[Question]');
					}
				}
				
				if($this->input->post('explanation_type') == 1){
					$this->form_validation->set_rules('explanation', 'Explanation', 'trim|required');
				}else{
					if($_FILES['explanation']['name'] == ""){
						$this->form_validation->set_rules('explanation', 'Explanation', 'trim|callback_validate_select[Explanation]');
					}
				}
		  		
				if ($this->form_validation->run()){ 				
					$date = date('Y-m-d H:i:s');
					$update_array = array();        
					 
				   if($this->input->post('explanation_type')==2)
					{		
						$thumb_src = "";					
					  	$config['upload_path'] = $this->config->item('subjective_explanation_img');
						$config['allowed_types'] = "gif|jpg|jpeg|png"; 
						$config['min_width'] = "300"; 
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
						$explanation = $this->input->post('explanation');
					}					
 					
					if($this->input->post('question_type')==2)
					{					 
						unset($config);
						$thumb_src = "";
						$config=array();							
						$config['upload_path'] = $this->config->item('subjective_question_img');
						$config['allowed_types'] = "gif|jpg|jpeg|png"; 
						$config['min_width'] = "300"; 
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
				 	 
					 if(!isset($data['upload_error']) and !isset($data['question_upload_error']) and !isset($data['explanation_upload_error'])){
					 					 	
					 	$update_array = array ('course_id' => $this->input->post('course_list'), 
												   'subject_id' => $this->input->post('subject_list'), 
												   'class_id' => $this->input->post('class_list'), 
												   'chapter_id' => $this->input->post('chapter_list'), 
												   'sub_category_id' => $this->input->post('category_list'), 
												   'question_type' => $this->input->post('question_type'), 
												   'question' => $question, 
												   'explanation_type' => $this->input->post('explanation_type'), 
												   'explanation' => $explanation, 
												   'severity' => $this->input->post('severity'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'created' => $date
												   );

							$insertId = $this->base_model->insert('subjective_questions', $update_array);
							$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
							redirect(base_url().SITE_ADMIN_URI.'/subjective_questions/');
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

				$where_sub_course = array('is_subjective'=>1);
				$data['course_list'] = $this->base_model->getSelectList('courses',$where_sub_course);
				#new
			if($this->input->post('course_list')==""){
				$where_sub_course = array('is_subjective'=>1);
				$data['course_list'] = $this->base_model->getSelectList('courses',$where_sub_course); 
				$data['class_list'] = $this->base_model->getSelectList('classes');
				$data['subject_list'] = $this->base_model->getSelectList('subjects');
				$data['chapter_list'] = $this->base_model->getSelectList('chapters');
			}
			}else{	
			$where_sub_course = array('is_subjective'=>1);		
			$data['course_list'] = $this->base_model->getSelectList('courses',$where_sub_course);
			$data['class_list'] = $this->base_model->getSelectList('classes');
			$data['subject_list'] = $this->base_model->getSelectList('subjects');
			$data['chapter_list'] = $this->base_model->getSelectList('chapters');
			
			}
			$data['category_list'] = $this->base_model->getSelectList('sub_category');
			$data['main_content'] = 'subjective_questions/add';
			$data['page_title']  = 'Subjective Questions'; 
			$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		
		public function edit($id = NULL)
		{						
			$data['post'] = FALSE;
			$this->load->helper('thumb_helper');
			$this->load->helper('html');
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->form_validation->set_rules('course_list', 'course list','trim|callback_validate_select[Course]');
				$this->form_validation->set_rules('class_list', 'class list','trim|callback_validate_select[Class]');
				$this->form_validation->set_rules('subject_list', 'subject list','trim|callback_validate_select[Subject]');
				$this->form_validation->set_rules('chapter_list', 'chapter list','trim|callback_validate_select[Chapter]');
				$this->form_validation->set_rules('category_list', 'sub category','trim|callback_validate_select[Sub Category]');
				$this->form_validation->set_rules('question_type', 'Question Type','trim|required');
				$this->form_validation->set_rules('explanation_type', 'Explanation','trim|required');
				
				if($this->input->post('question_type') == 1){
					$this->form_validation->set_rules('question', 'Question', 'trim|required');
				}else{
					if(!($this->input->post('question_image_present'))){	
						if($_FILES['question']['name'] == ""){
							$this->form_validation->set_rules('question', 'Question', 'trim|callback_validate_select[Question]');
						}
					}						
				}
			
				if($this->input->post('explanation_type') == 1){
					$this->form_validation->set_rules('explanation', 'Explanation', 'trim|required');
				}else{
					if(!($this->input->post('explanation_image_present'))){	
						if($_FILES['explanation']['name'] == ""){
							$this->form_validation->set_rules('explanation', 'Explanation', 'trim|callback_validate_select[Explanation]');
						}
					}						
				}
				
				if ($this->form_validation->run())
				{
					$row = $this->base_model->getCommonListFields('subjective_questions','',array('id' => $id));                					
					$upload_name1 = array();
					$date = date('Y-m-d H:i:s');
					if($this->input->post('explanation_type')==2)
					{
						if($_FILES['explanation']['name'] != ""){
							$thumb_src = "";					
						  	$config['upload_path'] = $this->config->item('subjective_explanation_img');
							$config['allowed_types'] = "gif|jpg|jpeg|png"; 
							$config['min_width'] = "300"; 
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
					}else{
						$explanation = $this->input->post('explanation');
					}
					
					if($this->input->post('question_type')==2)
					{		
						if($_FILES['question']['name'] != ""){
							unset($config);
							$thumb_src = "";
							$config=array();							
							$config['upload_path'] = $this->config->item('subjective_question_img');
							$config['allowed_types'] = "gif|jpg|jpeg|png"; 
							$config['min_width'] = "300"; 
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
					
					if(!isset($data['upload_error']) and !isset($data['question_upload_error']) and !isset($data['explanation_upload_error'])){
							
						$update_array = array ('course_id' => $this->input->post('course_list'), 
												   'subject_id' => $this->input->post('subject_list'), 
												   'class_id' => $this->input->post('class_list'), 
												   'chapter_id' => $this->input->post('chapter_list'), 
												   'sub_category_id' => $this->input->post('category_list'),  
												   'question_type' => $this->input->post('question_type'), 
												   'question' => $question, 
												   'explanation_type' => $this->input->post('explanation_type'), 
												   'explanation' => $explanation, 
												   'severity' => $this->input->post('severity'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'modified' => $date
												   );
						$this->base_model->update ( 'subjective_questions', $update_array, array('id'=>$id));
						$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
						redirect(base_url().SITE_ADMIN_URI.'/subjective_questions/');
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
				
				$data['category_list'] = array();
				$data['category_list'] = $this->base_model->getSelectList('sub_category');

			   } else{
				$fields = 'cl.id, cl.name class_name'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$join_tables[] = array('relevant_classes as rl','c.course_id = rl.course_id');			
			  	$join_tables[] = array('classes as cl','rl.class_id = cl.id');  	
			  	$class_list = $this->base_model->get_advance_list('subjective_questions as c', $join_tables, $fields, $where, '', 'cl.name', 'asc');
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
			  	$subject_list = $this->base_model->get_advance_list('subjective_questions as c', $join_tables, $fields, $where, '', 's.name', 'asc');
				if($subject_list){
					foreach($subject_list as $subject){
				  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
				  	}
			  	}
			  	
			  	$join_tables = $where = array();  
			  	$fields = 'ch.id, ch.name chapter_name'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$join_tables[] = array('chapters as ch','c.course_id = ch.course_id and c.class_id = ch.class_id and c.subject_id = ch.subject_id');
			  	$chapter_list = $this->base_model->get_advance_list('subjective_questions as c', $join_tables, $fields, $where, '', 'ch.name', 'asc');
				$data['chapter_list'] = array();
				if($chapter_list){
					foreach($chapter_list as $chapter){
				  		$data['chapter_list'][$chapter['id']] = ucfirst($chapter['chapter_name']);
				  	}
			  	}
			 	
			  	$join_tables = $where = array();  
			  	$fields = 'sc.id, sc.name category_name'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$join_tables[] = array('sub_category as sc','c.sub_category_id = sc.id');
			  	$category_list = $this->base_model->get_advance_list('subjective_questions as c', $join_tables, $fields, $where, '', 'sc.name', 'asc');
			
				if($category_list){
					foreach($category_list as $category){
				  		$data['category_list'][$category['id']] = ucfirst($category['category_name']);
				  	}
			  	}
			  	
		 	}
		 	
		 	$where_sub_course = array('is_subjective'=>'1');
	   		$data['course_list'] = $this->base_model->getSelectList('courses',$where_sub_course);
	   		$data['category_list'] = $this->base_model->getSelectList('sub_category');
			$data['subjective_questions_main'] = $this->base_model->getCommonListFields('subjective_questions','',array('id' => $id));
			$data['subjective_questions'] = $data['subjective_questions_main'][0];
			$data['main_content'] = 'subjective_questions/edit';
		  	$data['page_title']  = 'Subjective Questions'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	
	public function delete($id,$pageredirect=null,$pageno) {

		$getImg = $this->base_model->getCommonListFields('subjective_questions',array('question_type', 'question','explanation_type', 'explanation'),array('id' => $id));
	 
		if($getImg['0']->question_type == '2'){
		        @unlink($this->config->item('subjective_question_img') . $getImg['0']->question);
		        @unlink($this->config->item('subjective_question_img') .'thumb_subjective_questions_img/'. $getImg['0']->question);
        }
				 
		if($getImg['0']->explanation_type == '2'){
		     @unlink($this->config->item('subjective_explanation_img') . $getImg['0']->explanation);
		     @unlink($this->config->item('subjective_explanation_img') .'thumb_subjective_explanation_img/'. $getImg['0']->explanation);
     	}
		
		$this->base_model->delete ('subjective_questions',array('id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/subjective_questions/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'subjective_questions';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/subjective_questions/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno){
		
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'subjective_questions');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'subjective_questions');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('subjective_questions', array('id' => $id));
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/subjective_questions/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/subjective_questions/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function request(){
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$subject_id = $this->input->post('subject_id');
		$chapter_id = $this->input->post('chapter_id');
		$data = array();
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
				if ( $this->upload->do_upload('subjective_questions_csv')) {
					$upload_data = $this->upload->data();
					
					$file_name = $file_path.$upload_data['file_name']; 
					if ($csv_array = $this->csv_import->get_array($file_name)) { 
						$csv_header_array = array('Class Name','Subject Name','Category Name','Chapter Name','Question Type','Question','Explanation Type','Explanation','Severity'); 
						if( Check_valid_csv_header($csv_array['header_data'], $csv_header_array) ) {	  					 			
							$date = date('Y-m-d H:i:s'); 
							$insert_data = array(); 
							$count = 0; $subcount = 0; $subject_id = 0; $class_id = 0; $qtype = 0;
							foreach ($csv_array['row_data'] as $row) {
								if($row['Class Name'] != "" && $row['Subject Name'] != "" && $row['Category Name'] != "" && $row['Chapter Name'] != "" && $row['Question Type'] != "" && $row['Question'] != "" && $row['Explanation Type'] != "" && $row['Explanation'] != ""){
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
									
									$categorycount = $this->base_model->getCount('sub_category',array('name' => $row['Category Name']));
									if ($categorycount == 0) {
									 	$category_id = $this->base_model->insert('sub_category',array('created' => $date, 'modified' => $date, 'name' => $row['Category Name'], 'status' => '1'));
									}else{
										$categoryfields = 'id'; 
				  	         			$categorywhere[] = array( TRUE, 'name', $row['Category Name']);
										$category = $this->base_model->get_advance_list('sub_category', '', $categoryfields, $categorywhere, 'row_array');
										unset($categorywhere);
										$category_id = $category['id'];								
									}
								
									$quescount = $this->base_model->getCount('subjective_questions',array('question' => $row['Question'],'sub_category_id' => $category_id,'chapter_id' => $chapter_id, 'subject_id' => $subject_id, 'class_id' => $class_id, 'course_id' => $this->input->post('course_list')));
									$severity = 0;
									if ($quescount == 0) {
										$severity = array_search($row['Severity'], $this->config->item('severity'));
										if(strtolower($row['Question Type'])=="text"){
											$qtype = 1;
										}
										else{
											$qtype = 2;
										}
										
										if(strtolower($row['Explanation Type'])=="text"){
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
															'sub_category_id' => $category_id,
															'question_type'=>$qtype,
															'question' => $row['Question'],
															'explanation_type'=>$explanation_type,
															'explanation' => $row['Explanation'],
															'severity' => $severity,
															'status' => '1'
															);
									
									 	$ques_id = $this->base_model->insert('subjective_questions', $insertdata);
									}else{
										
									}
								}
							} 
							RemoveDirectory($file_path);
							$this->session->set_flashdata('flash_success_message', $this->lang->line('upload_csv_success'));
							redirect(base_url().SITE_ADMIN_URI.'/subjective_questions/');
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
		$where_sub_course = array('is_subjective'=>'1');
		$data['course_list'] = $this->base_model->getSelectList('courses',$where_sub_course);
		$data['main_content'] = 'subjective_questions/import';
		$data['page_title']  = 'Subjective Questions'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function make_select($data_Arr,$place_hold){
		$to_ret[""]=$place_hold;
		foreach($data_Arr as $data_in){
			
			$to_ret[$data_in["id"]]=$data_in["name"];
			
		}
		return $to_ret;
		
	}
}
