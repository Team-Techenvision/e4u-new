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
			getSearchDetails($this->router->fetch_class());
			$this->load->model('base_model');
			$this->load->model('certificate_model');
			 
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
				
				$search_level_keyword  = isset($_POST['search_level'])?trim($_POST['search_level']):(isset($_SESSION['search_level'])?$_SESSION['search_level']:'');
				$this->session->set_userdata('search_level', $search_level_keyword); 				
				$keyword_level_session = $this->session->userdata('search_level');
				if($keyword_level_session != '')
				{
					$keyword_level = $this->session->userdata('search_level');
				}
				else
				{
					isset($_SESSION['search_level'])?$this->session->unset_userdata('search_level'):'';
					$keyword_level = "";
				}
				
				$search_set_keyword  = isset($_POST['search_set'])?trim($_POST['search_set']):(isset($_SESSION['search_set'])?$_SESSION['search_set']:'');				
				$this->session->set_userdata('search_set', $search_set_keyword);
				$keyword_set_session = $this->session->userdata('search_set');
				if($keyword_set_session != '')
				{
					$keyword_set = $this->session->userdata('search_set');
				}
				else
				{
					isset($_SESSION['search_set'])?$this->session->unset_userdata('search_set'):'';
					$keyword_set = "";
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
			  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/questions/index";
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
				if($keyword_chapter)
				{
					$where[] = array( TRUE, 'c.chapter_id', $keyword_chapter);
					$data['keyword_chapter'] = $keyword_chapter;
					//level list
					$fields_f="rc.id,name"; 
					$where_f[]= array( TRUE, 'rc.chapter_id', $keyword_chapter);
					if($keyword_class!=""){
						$where_f[]= array( TRUE, 'rc.class_id', $keyword_class);
					}
					if($keyword_course!=""){
						$where_f[]= array( TRUE, 'rc.course_id', $keyword_course);
					}
					if($keyword_subject!=""){
						$where_f[]= array( TRUE, 'rc.subject_id', $keyword_subject);
					} 
					 unset($where_f);
					 unset($join_tables_f);
				}
				else{
					$data['keyword_chapter'] = "";
				}
			
				if($keyword_set)
				{
					$where[] = array( TRUE, 'c.set_id', $keyword_set);
					$data['keyword_set'] = $keyword_set;
				}
				else{
					$data['keyword_set'] = "";
				}
				
			  	$fields = 'c.id, c.chapter_id, c.question, c.question_type, c.status, c.created, co.name course_name, cl.name class_name, s.name subject_name, ch.name chapter_name'; 
			  	$join_tables[] = array('courses as co','c.course_id = co.id');
			  	$join_tables[] = array('relevant_classes as rc','c.course_id = rc.course_id and rc.class_id=c.class_id');
			  	$join_tables[] = array('classes as cl','rc.class_id = cl.id');
			  	$join_tables[] = array('relevant_subjects as rs','c.course_id = rs.course_id and rs.subject_id=c.subject_id and rc.class_id=rs.class_id');			  	
			  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');	
			  	$join_tables[] = array('chapters as ch','c.chapter_id = ch.id');
			  	// $join_tables[] = array('test_details as td','td.question_id = c.id AND td.test_type!=2',"left");			
			  	$where[] = array( TRUE, 'co.status', 1); 
		  		$where[] = array( TRUE, 'cl.status', 1);  
		  		$where[] = array( TRUE, 's.status', 1); 
		  		$where[] = array( TRUE, 'ch.status', 1);

			  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, 'num_rows','','','c.chapter_id');
			  	// echo $data['total_rows'];
			  	$data['questions'] = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, 'result_array', '', '', 'c.chapter_id', $limit_start, $limit_end);	
				  // print_r($data['questions']);
				  //echo $this->db->last_query();
				  // die;		  	
			   $this->pagination->initialize($config);
			   $data['get_course'] = $this->base_model->getSelectList('courses'); 
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
		public function validate_select($val, $fieldname){
			if($val==""){
				$this->form_validation->set_message('validate_select', 'Please choose the '.$fieldname.'.');
				return FALSE;
			}			
		}
		public function add()
		{
			
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 				
				$this->form_validation->set_rules('course_list', 'course list','trim|callback_validate_select[Course]');
				$this->form_validation->set_rules('class_list', 'class list','trim|callback_validate_select[Class]');
				$this->form_validation->set_rules('subject_list', 'subject list','trim|callback_validate_select[Subject]');
				$this->form_validation->set_rules('chapter_list', 'chapter list','trim|callback_validate_select[Chapter]');
				$this->form_validation->set_rules('tags[]', 'Question Tags','trim|required');
				$this->form_validation->set_rules('selected_qn[]', 'Questions','trim|required');
				
				if ($this->form_validation->run()){ 				
					$date = date('Y-m-d H:i:s');
					       
         				 	$mapped_qns_id = $this->input->post('selected_qn[]');
							   //print_R($mapped_qns_id);
							   //echo count($mapped_qns_id);
							   //die;
         				 	foreach($mapped_qns_id as $key => $value){
         				 		$update_array = array(); 
         				 		$where =array();
								$where[] = array( TRUE, 'c.id', $value);
								$qns_data = $this->base_model->get_advance_list('questions_master as c', '', '', $where, 'row', '', '');
									
								$questions_master_id = $qns_data->id; 
								$question_type = $qns_data->question_type;
								$answer_type = $qns_data->answer_type;	
								$choice_count = $qns_data->choice_count;
								$question = $qns_data->question;
								$choices = $qns_data->choices;
								$correct_answer = $qns_data->correct_answer;
								$explanation_type = $qns_data->explanation_type;
								$explanation = $qns_data->explanation;
								$severity = $qns_data->severity;
								$show_options = $qns_data->show_options;
								$where1 = array();
								$where1[] = array( TRUE, 'qns.course_id',$this->input->post('course_list'));
								$where1[] = array( TRUE, 'qns.subject_id',$this->input->post('subject_list'));
								$where1[] = array( TRUE, 'qns.class_id', $this->input->post('class_list'));
								$where1[] = array( TRUE, 'qns.chapter_id', $this->input->post('chapter_list'));
								$where1[] = array( TRUE, 'qns.questions_master_id', $value);

								$already_check = $this->base_model->get_advance_list('questions as qns', '', '', $where1, 'row', '', '');
								//echo $this->db->last_query();
								// print_r($already_check);die;
								if(count($already_check)==0){
					 				$update_array =	array(
					 							   'course_id' => $this->input->post('course_list'), 
												   'subject_id' => $this->input->post('subject_list'), 
												   'class_id' => $this->input->post('class_list'), 
												   'chapter_id' => $this->input->post('chapter_list'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'created' => $date,
													    'questions_master_id' => $questions_master_id,
														'question_type' => $question_type,
														'answer_type' => $answer_type,
														'choice_count' => $choice_count,
														'question' => $question,
														'choices' => $choices,
														'correct_answer' => $correct_answer,
														'explanation_type' => $explanation_type,
														'explanation' => $explanation,
														'severity' => $severity,
														'show_options' => $show_options,
												   );
					 			$insertId = $this->base_model->insert('questions', $update_array);
					 			}
					 		}
							$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
							redirect(base_url().SITE_ADMIN_URI.'/questions/');
					 
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
				$this->form_validation->set_rules('course_list', 'course list','trim|callback_validate_select[Course]');
				$this->form_validation->set_rules('class_list', 'class list','trim|callback_validate_select[Class]');
				$this->form_validation->set_rules('subject_list', 'subject list','trim|callback_validate_select[Subject]');
				$this->form_validation->set_rules('chapter_list', 'chapter list','trim|callback_validate_select[Chapter]');
				$this->form_validation->set_rules('selected_qn[]', 'Questions','trim|required');

				if ($this->form_validation->run())
				{
					$row = $this->base_model->getCommonListFields('questions','',array('id' => $id));                					
					$upload_name1 = array();
					$date = date('Y-m-d H:i:s');
					$update_array=array();//customize here
					   $course_id = $this->input->post('course_list');
					   $subject_id = $this->input->post('subject_list');
					   $class_id = $this->input->post('class_list');
					   $chapter_id = $this->input->post('chapter_list');
						$this->base_model->delete('questions',array('course_id' => $course_id, 'class_id' => $class_id, 'subject_id' => $subject_id, 'chapter_id' => $chapter_id));
						$mapped_qns_id = $this->input->post('selected_qn[]');
						//print_R($mapped_qns_id);die;
         				 	foreach($mapped_qns_id as $key => $value){
         				 		$update_array = array(); 
         				 		$where =array();
								$where[] = array( TRUE, 'c.id', $value);
								$qns_data = $this->base_model->get_advance_list('questions_master as c', '', '', $where, 'row', '', '');
								$questions_master_id = $qns_data->id; 
								$question_type = $qns_data->question_type;
								$answer_type = $qns_data->answer_type;	
								$choice_count = $qns_data->choice_count;
								$question = $qns_data->question;
								$choices = $qns_data->choices;
								$correct_answer = $qns_data->correct_answer;
								$explanation_type = $qns_data->explanation_type;
								$explanation = $qns_data->explanation;
								$severity = $qns_data->severity;
								$show_options = $qns_data->show_options;
								// $where1[] = array( TRUE, 'qns.course_id',$this->input->post('course_id'));
								// $where1[] = array( TRUE, 'qns.subject_id',$this->input->post('subject_id'));
								// $where1[] = array( TRUE, 'qns.class_id', $this->input->post('class_id'));
								// $where1[] = array( TRUE, 'qns.chapter_id', $this->input->post('chapter_id'));
								// $where1[] = array( TRUE, 'qns.questions_master_id', $questions_master_id);

								// $already_check = $this->base_model->get_advance_list('questions as qns', '', '', $where1, 'row', '', '');
								// if(!$already_check){ // no need to check bcoz deleteing and inserting
					 				$update_array =	array(
					 							   'course_id' => $this->input->post('course_list'), 
												   'subject_id' => $this->input->post('subject_list'), 
												   'class_id' => $this->input->post('class_list'), 
												   'chapter_id' => $this->input->post('chapter_list'), 
												   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
												   'created' => $date,
													    'questions_master_id' => $questions_master_id,
														'question_type' => $question_type,
														'answer_type' => $answer_type,
														'choice_count' => $choice_count,
														'question' => $question,
														'choices' => $choices,
														'correct_answer' => $correct_answer,
														'explanation_type' => $explanation_type,
														'explanation' => $explanation,
														'severity' => $severity,
														'show_options' => $show_options
												   );
					 			$insertId = $this->base_model->insert('questions', $update_array);
					 			// }
					 		}
						//customize here end

						$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
						redirect(base_url().SITE_ADMIN_URI.'/questions/');
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
			  	$fields = 'c.choice_count'; 
			  	$where[] = array( TRUE, 'c.id', $id);
			  	$count = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, '', '', '');
		 	
		 	}
		 	$data['count'] = $count[0]['choice_count'];
	   		$data['course_list'] = $this->base_model->getSelectList('courses');
			$data['questions_main'] = $this->base_model->getCommonListFields('questions','',array('id' => $id));
			$data['questions'] = $data['questions_main'][0];
			$qns_details = $data['questions_main'][0];
			
			// get question count from test details table
			$join_tables = $where = array();  
			$fields = 'COUNT(td.question_id) as is_delete'; 
			$where[] = array( TRUE, 'c.id', $id);
			$join_tables[] = array('test_details as td','td.question_id = c.id AND td.test_type!=2',"left");	
			$data['test_details'] = $this->base_model->get_advance_list('questions as c', $join_tables, $fields, $where, 'row', '', '');
				
			// $where1 = array();
			// $where1[] = array( TRUE, 'qns.course_id', $qns_details->course_id);
			// $where1[] = array( TRUE, 'qns.class_id', $qns_details->class_id);
			// $where1[] = array( TRUE, 'qns.subject_id', $qns_details->subject_id);
			// $where1[] = array( TRUE, 'qns.chapter_id', $qns_details->chapter_id);
			$data['tags']=$this->base_model->get_tags();
			$data['mapped_questions'] = $this->certificate_model->getQuestionsSelected($qns_details->course_id, $qns_details->class_id, $qns_details->subject_id, $qns_details->chapter_id);
			 // print_r($data['questions']);die;
			// $data['mapped_questions'] = $this->base_model->get_advance_list('questions as qns', '', '', $where1, '', '', '');	
			$data['main_content'] = 'questions/edit';
		  	$data['page_title']  = 'Questions'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}

	
	
	public function delete($id,$pageredirect=null,$pageno) {

		// $getImg = $this->base_model->getCommonListFields('questions',array('question_type', 'question', 'answer_type','choices', 'explanation_type', 'explanation'),array('id' => $id));
	 
		// if($getImg['0']->question_type == '2'){
		//         @unlink($this->config->item('question_img') . $getImg['0']->question);
		//         @unlink($this->config->item('question_img') .'thumb_questions_img/'. $getImg['0']->question);
  //       }
				 
		// if($getImg['0']->explanation_type == '2'){
		//      @unlink($this->config->item('explanation_img') . $getImg['0']->explanation);
		//      @unlink($this->config->item('question_img') .'thumb_explanation_img/'. $getImg['0']->explanation);
  //    	}
		// if($getImg['0']->answer_type == '2'){
		// 	$choices = unserialize($getImg['0']->choices);
		// 	foreach($choices as $choice) {
		//         @unlink($this->config->item('answers_img') . $choice);
		//         @unlink($this->config->item('answers_img') .'thumb_answers_img/'. $choice);
		//     }
  //       }

        $where = array();
        $where[] = array( TRUE, 'qns.id', $id);
		$qns_data = $this->base_model->get_advance_list('questions as qns', '', '', $where, 'row', '', '');

		$course_id = $qns_data->course_id;
		$class_id = $qns_data->class_id;
		$subject_id = $qns_data->subject_id;
		$chapter_id = $qns_data->chapter_id;

		$this->base_model->delete('questions',array('course_id' => $course_id, 'class_id' => $class_id, 'subject_id' => $subject_id, 'chapter_id' => $chapter_id));
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
															'show_options' =>$show_options,
															'status' => '1'
															);
									
									 	$ques_id = $this->base_model->insert('questions', $insertdata);
									}else{
										
									}
								}
							} 
							RemoveDirectory($file_path);
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
			}
		}
		$data['post'] = TRUE;
		$data['course_list'] = $this->base_model->getSelectList('courses');
		$data['main_content'] = 'questions/import';
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
		//$type => 1->'questions' , 2 -> answers
		if(!$this->session->has_userdata('admin_is_logged_in')){
			redirect(SITE_ADMIN_URI);
		}else
		{
			$data['ques_img'] = $question_img;
			$data['type'] = $type;
			$this->load->view('questions/img-popup',$data); 
		}
	}



}
