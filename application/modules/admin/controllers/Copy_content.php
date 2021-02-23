<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Copy_content extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','csv_import'));
		$this->load->language(array('flash_message','form_validation'), 'english');
		if(!$this->session->has_userdata('admin_is_logged_in'))
		{
			redirect(SITE_ADMIN_URI);
		}
		getSearchDetails($this->router->fetch_class());
		$this->load->helper('function_helper');
		$this->load->model(array('base_model', 'copycontent_model')); 
	}
	public function index($page_num = 1)
	{	
		if($this->input->server('REQUEST_METHOD') === 'POST'){ 			
			$this->form_validation->set_rules('course_list', 'course list','callback_validate_select[Course]');
			$this->form_validation->set_rules('course_list_to', 'course list','callback_validate_select[Course]');
			
			if($this->input->post('subject_list')!=""){
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[class]');				
			}			
			if($this->input->post('chapter_list')!=""){
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list', 'subject list','callback_validate_select[subject]');				
			}			
			if($this->input->post('level_list')!=""){
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list', 'subject list','callback_validate_select[subject]');
				$this->form_validation->set_rules('chapter_list', 'subject list','callback_validate_select[chapter]');				
			}			
			if($this->input->post('set_list')!=""){
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list', 'subject list','callback_validate_select[subject]');
				$this->form_validation->set_rules('chapter_list', 'subject list','callback_validate_select[chapter]');
				$this->form_validation->set_rules('level_list', 'subject list','callback_validate_select[level]');				
			}
						
			if($this->input->post('class_list_to')!=""){
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[class]');
			}
			if($this->input->post('subject_list_to')!=""){
				$this->form_validation->set_rules('class_list_to', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list', 'subject list','callback_validate_select[subject]');
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[class]');
			}
			if($this->input->post('chapter_list_to')!=""){
				$this->form_validation->set_rules('class_list_to', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list_to', 'class list','callback_validate_select[subject]');
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list', 'subject list','callback_validate_select[subject]');
				$this->form_validation->set_rules('chapter_list', 'chapter list','callback_validate_select[chapter]');
			}
			if($this->input->post('level_list_to')!=""){
				$this->form_validation->set_rules('class_list_to', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list_to', 'class list','callback_validate_select[subject]');
				$this->form_validation->set_rules('chapter_list_to', 'class list','callback_validate_select[chapter]');
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list', 'subject list','callback_validate_select[subject]');
				$this->form_validation->set_rules('chapter_list', 'chapter list','callback_validate_select[chapter]');
				$this->form_validation->set_rules('level_list', 'level list','callback_validate_select[level]');
			}
			if($this->input->post('set_list_to')!=""){
			$this->form_validation->set_rules('class_list_to', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list_to', 'class list','callback_validate_select[subject]');
				$this->form_validation->set_rules('chapter_list_to', 'class list','callback_validate_select[chapter]');
				$this->form_validation->set_rules('level_list_to', 'class list','callback_validate_select[level]');
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[class]');
				$this->form_validation->set_rules('subject_list', 'subject list','callback_validate_select[subject]');
				$this->form_validation->set_rules('chapter_list', 'chapter list','callback_validate_select[chapter]');
				$this->form_validation->set_rules('level_list', 'level list','callback_validate_select[level]');
				$this->form_validation->set_rules('set_list', 'set list','callback_validate_select[set]');
			}
			
			//die;
			$date = date('Y-m-d H:i:s');			
			if($this->form_validation->run()){ 				
				//$this->copycontent_model->copy_data();
				$this->copycontent_model->copy_questions();
				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['course_list'][''] = 'Select Course';
				$data['class_list'] = array(""=>"Select Class");
				$data['subject_list'] = array(""=>"Select Subject");
				$data['chapter_list'] = array(""=>"Select Chapter");
				$data['level_list'] = array(""=>"Select Level");
				$data['set_list'] = array(""=>"Select Set");
				$data['materials'] = array(""=>"Select Material");
				$data['course_list_to'] = $this->base_model->getSelectList('courses');
				$data['course_list_to'][''] = 'Select Course';
				$data['class_list_to'] = array(""=>"Select Class");
				$data['subject_list_to'] = array(""=>"Select Subject");
				$data['chapter_list_to'] = array(""=>"Select Chapter");
				$data['level_list_to'] = array(""=>"Select Level");
				$data['set_list_to'] = array(""=>"Select Set");
				$data['objective_question_count'] = 0;
				$data['subjective_question_count'] =  0;
				unset($_POST);
				//$data['main_content'] = 'copy_content/index';
				//$data['page_title']  = 'Copy Content'; 
				//$this->load->view(ADMIN_LAYOUT_PATH, $data);
				//$this->session->set_flashdata('flash_success_message', 'Data copied successfully');
				redirect(base_url().SITE_ADMIN_URI.'/copy_content/');
			}	
			// copy from
			$data['class_list'] = array();			
			$join_tables = $where = array();  
		  	$fields = 'cl.id, cl.name class_name'; 
		  	$where[] = array( TRUE, 'rc.course_id', $this->input->post('course_list'));
		  	$join_tables[] = array('classes as cl','rc.class_id = cl.id');			  	
		  	$class_list = $this->base_model->get_advance_list('relevant_classes as rc', $join_tables, $fields, $where, '', 'cl.name', 'asc');
		  	$data['class_list'][''] = 'Select Class'; 
		  	if($class_list){		  		
		  		$data['class_list']['all'] = 'All classes';
			  	foreach($class_list as $class){
			  		$data['class_list'][$class['id']] = ucfirst($class['class_name']);
			  	}
		  	}
		  	$data['subject_list'] = array();
		  	$join_tables = $where = array();  
		  	$fields = 'rs.id, s.name as subject_name'; 
		  	$where[] = array( TRUE, 'rs.course_id', $this->input->post('course_list'));
		  	if($this->input->post('class_list')!="" and $this->input->post('class_list')!="all"){
		  		$where[] = array( TRUE, 'rs.class_id', $this->input->post('class_list'));
		  	}
		  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');			  	
		  	$subject_list = $this->base_model->get_advance_list('relevant_subjects as rs', $join_tables, $fields, $where, '', 'rs.class_id', 'asc');		  
			$data['subject_list'][''] = 'Select Subject';
			if($subject_list){			
				$data['subject_list']['all'] = 'All subjects';
				foreach($subject_list as $subject){
			  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
			  	}
		  	}		  	 
			$data['chapter_list'] = array();
			$where = array();
			$where['course_id'] =$this->input->post('course_list');
		  	if($this->input->post('class_list')!="" and $this->input->post('class_list')!="all"){
		  		$where['class_id'] = $this->input->post('class_list');
		  	} 
		  	if($this->input->post('subject_list')!="" and $this->input->post('subject_list')!="all"){		  		
				$this->db->select("rs.subject_id");
			  	$this->db->from("relevant_subjects as rs");
			  	$this->db->where("rs.id", $this->input->post('subject_list'));
				$result1 = $this->db->get();	
				$data_subject = $result1->row_array();		
				$subject_id = $data_subject["subject_id"];				
		  		$where['subject_id'] = $subject_id;
		  	} 		  	
		  	$data['chapter_list'] = $this->copycontent_model->getSelectList('chapters', $where, '', 'id,name', 'id');			  
			if(count($data['chapter_list'])>1){
				$data['chapter_list']["all"] = "All chapters";
			}
			$data['chapter_list'][""] = "Select Chapter";
			
						
			$data['level_list'] = array();
			$where = array();
			$where['course_id'] =$this->input->post('course_list');
			if($this->input->post('class_list')!="" and $this->input->post('class_list')!="all"){
				$where['class_id'] = $this->input->post('class_list');
			} 
			if($this->input->post('subject_list')!="" and $this->input->post('subject_list')!="all"){		  		
				$this->db->select("rs.subject_id");
			  	$this->db->from("relevant_subjects as rs");
			  	$this->db->where("rs.id", $this->input->post('subject_list'));
				$result1 = $this->db->get();	
				$data_subject = $result1->row_array();		
				$subject_id = $data_subject["subject_id"];				
				$where['subject_id'] = $subject_id;
			}
			if($this->input->post('chapter_list')!="" and $this->input->post('chapter_list')!="all"){
				$where['chapter_id'] = $this->input->post('chapter_list');
			} 
			$data['level_list'] = $this->copycontent_model->getSelectList('levels', $where, '', 'id,name', 'chapter_id');			
			if(count($data['level_list'])>1){
				$data['level_list']["all"] = "All levels";
			}
			$data['level_list'][""] = "Select Level";
			
			$data['set_list'] = array();
			$where = array();
			$where['course_id'] =$this->input->post('course_list');
			if($this->input->post('class_list')!="" and $this->input->post('class_list')!="all"){
				$where['class_id'] = $this->input->post('class_list');
			} 
			if($this->input->post('subject_list')!="" and $this->input->post('subject_list')!="all"){		  		
				$this->db->select("rs.subject_id");
			  	$this->db->from("relevant_subjects as rs");
			  	$this->db->where("rs.id", $this->input->post('subject_list'));
				$result1 = $this->db->get();	
				$data_subject = $result1->row_array();		
				$subject_id = $data_subject["subject_id"];				
				$where['subject_id'] = $subject_id;
			}
			if($this->input->post('chapter_list')!="" and $this->input->post('chapter_list')!="all"){
				$where['chapter_id'] = $this->input->post('chapter_list');
			} 
			if($this->input->post('level_list')!="" and $this->input->post('level_list')!="all"){
				$where['level_id'] = $this->input->post('level_list');
			} 
			$data['set_list'] = $this->copycontent_model->getSelectList('sets', $where, '', 'id,name', 'id');								
			if(count($data['set_list'])>1){
				$data['set_list']["all"] = "All sets";
			}			
			$data['set_list'][""] = "Select Set";		
			$temp_materials = $this->copycontent_model->getmaterials($this->input->post('course_list'), $this->input->post('class_list'), $this->input->post('subject_list'));
					
			if(!is_null($temp_materials)){
				if(count($temp_materials)>1){
				//$data['materials']["all"] = "All Materials";
				array_unshift($temp_materials, "All Materials");
				}			
				//$data['materials'][""] = "Select Material";
				array_unshift($temp_materials, "Select Material");	
				foreach($temp_materials as $key=>$value){
					if($value == "All Materials"){
						$data['materials']['all'] = $value;
					}else if($value == "Select Material"){
						$data['materials'][''] = $value;
					}else{
					$data['materials'][$key] = $value;
					}
				}
			}else{
				$data['materials'][''] = "Select Material";
			}
			
			$data['course_list'] = $this->base_model->getSelectList('courses');
			$data['course_list'][''] = 'Select Course';
			if($this->input->post('course_list')==""){
				$data['course_list'] = $this->base_model->getSelectList('courses'); 
				$data['course_list'][''] = 'Select Course';
				$data['class_list'] = array(""=>"Select Class");
				$data['subject_list'] = array(""=>"Select Subject");
				$data['chapter_list'] = array(""=>"Select Chapter");
				$data['level_list'] = array(""=>"Select Level");
				$data['set_list'] = array(""=>"Select Set");
				$data['materials'] = array(""=>"Select Material");
			}
			
			$data['objective_question_count'] = $this->copycontent_model->getCount("questions", $this->input->post('course_list'), ($this->input->post('class_list'))?$this->input->post('class_list'):"all",
			($this->input->post('subject_list'))?$this->input->post('subject_list'):"all", ($this->input->post('chapter_list'))?$this->input->post('chapter_list'):"all",
			($this->input->post('level_list'))?$this->input->post('level_list'):"all", ($this->input->post('set_list'))?$this->input->post('set_list'):"all");	 		  	
	  		$data['subjective_question_count'] = $this->copycontent_model->getCount("subjective_questions", $this->input->post('course_list'), ($this->input->post('class_list'))?$this->input->post('class_list'):"all",
			($this->input->post('subject_list'))?$this->input->post('subject_list'):"all", ($this->input->post('chapter_list'))?$this->input->post('chapter_list'):"all");
		
			$data['subjective_question'] = ($this->input->post('subjective_question'))?$this->input->post('subjective_question'):"";
			$data['objective_question'] = ($this->input->post('objective_question'))?$this->input->post('objective_question'):"";
			//copy to
			
			$data['class_list_to'] = array();			
			$join_tables = $where = array();  
		  	$fields = 'cl.id, cl.name class_name'; 
		  	$where[] = array( TRUE, 'rc.course_id', $this->input->post('course_list_to'));
		  	$join_tables[] = array('classes as cl','rc.class_id = cl.id');			  	
		  	$class_list = $this->base_model->get_advance_list('relevant_classes as rc', $join_tables, $fields, $where, '', 'cl.name', 'asc');
		  	$data['class_list_to'][''] = 'Select Class'; 
		  	if($class_list){		  		
			  	foreach($class_list as $class){
			  		$data['class_list_to'][$class['id']] = ucfirst($class['class_name']);
			  	}
		  	}
		  	$data['subject_list_to'] = array();
		  	$join_tables = $where = array();  
		  	$fields = 'rs.id, s.name as subject_name'; 
		  	$where[] = array( TRUE, 'rs.course_id', $this->input->post('course_list_to'));
			if($this->input->post('class_list_to')!="" and $this->input->post('class_list_to')!="all"){
				$where[] = array( TRUE, 'rs.class_id', $this->input->post('class_list_to'));
			}
		  	$join_tables[] = array('subjects as s', 'rs.subject_id = s.id');			  	
		  	$subject_list = $this->base_model->get_advance_list('relevant_subjects as rs', $join_tables, $fields, $where, '', 'rs.class_id', 'asc');		  
			$data['subject_list_to'][''] = 'Select Subject';
			if($subject_list){				
				foreach($subject_list as $subject){
			  		$data['subject_list_to'][$subject['id']] = ucfirst($subject['subject_name']);
			  	}
		  	}	
		  			  	 
			$data['chapter_list_to'] = array();
			$where = array();
			$where['course_id'] =$this->input->post('course_list_to');
			if($this->input->post('class_list_to')!="" and $this->input->post('class_list_to')!="all"){
				$where['class_id'] = $this->input->post('class_list_to');
			} 
			if($this->input->post('subject_list_to')!="" and $this->input->post('subject_list_to')!="all"){		  		
				$this->db->select("rs.subject_id");
			  	$this->db->from("relevant_subjects as rs");
			  	$this->db->where("rs.id", $this->input->post('subject_list_to'));
				$result1 = $this->db->get();	
				$data_subject = $result1->row_array();		
				$subject_id = $data_subject["subject_id"];				
				$where['subject_id'] = $subject_id;
			}
			$data['chapter_list_to'] = $this->copycontent_model->getSelectList('chapters', $where, '', 'id,name', 'id');			
			unset($data['chapter_list_to']["all"]);			
			$data['chapter_list_to'][""] = "Select Chapter";
			
			
			$data['level_list_to'] = array();
			$where = array();
			$where['course_id'] =$this->input->post('course_list_to');
			if($this->input->post('class_list_to')!="" and $this->input->post('class_list_to')!="all"){
				$where['class_id'] = $this->input->post('class_list_to');
			}
			if($this->input->post('subject_list_to')!="" and $this->input->post('subject_list_to')!="all"){		  		
				$this->db->select("rs.subject_id");
			  	$this->db->from("relevant_subjects as rs");
			  	$this->db->where("rs.id", $this->input->post('subject_list_to'));
				$result1 = $this->db->get();	
				$data_subject = $result1->row_array();		
				$subject_id = $data_subject["subject_id"];				
				$where['subject_id'] = $subject_id;
			}
			if($this->input->post('chapter_list_to')!="" and $this->input->post('chapter_list_to')!="all"){
				$where['chapter_id'] = $this->input->post('chapter_list');
			}
			$data['level_list_to'] = $this->copycontent_model->getSelectList('levels', $where, '', 'id,name', 'chapter_id');
			unset($data['level_list_to']["all"]);
			$data['level_list_to'][""] = "Select Level";	
			
			$data['set_list_to'] = array();
			$where = array();
			$where['course_id'] =$this->input->post('course_list_to');
			if($this->input->post('class_list_to')!="" and $this->input->post('class_list_to')!="all"){
				$where['class_id'] = $this->input->post('class_list_to');
			} 
			if($this->input->post('subject_list_to')!="" and $this->input->post('subject_list_to')!="all"){		  		
				$this->db->select("rs.subject_id");
			  	$this->db->from("relevant_subjects as rs");
			  	$this->db->where("rs.id", $this->input->post('subject_list_to'));
				$result1 = $this->db->get();	
				$data_subject = $result1->row_array();		
				$subject_id = $data_subject["subject_id"];				
				$where['subject_id'] = $subject_id;
			}
			if($this->input->post('chapter_list_to')!="" and $this->input->post('chapter_list_to')!="all"){
				$where['chapter_id'] = $this->input->post('chapter_list');
			} 
			if($this->input->post('level_list_to')!="" and $this->input->post('level_list_to')!="all"){
				$where['level_id'] = $this->input->post('level_list_to');
			} 
			$data['set_list_to'] = $this->copycontent_model->getSelectList('sets', $where, '', 'id,name', 'id');
			unset($data['set_list_to']["all"]);
			$data['set_list_to'][""] = "Select Set";			
			
			
			$data['course_list_to'] = $this->base_model->getSelectList('courses');
			$data['course_list_to'][''] = 'Select Course';
			if($this->input->post('course_list_to')==""){
				$data['course_list_to'] = $this->base_model->getSelectList('courses'); 
				$data['course_list_to'][''] = 'Select Course';
				$data['class_list_to'] = array(""=>"Select Class");
				$data['subject_list_to'] = array(""=>"Select Subject");
				$data['chapter_list_to'] = array(""=>"Select Chapter");
				$data['level_list_to'] = array(""=>"Select Level");
				$data['set_list_to'] = array(""=>"Select Set");	
				$data['objective_question_count'] = 0;
				$data['subjective_question_count'] =  0;			
			}
		}else{
			$data['course_list'] = $this->base_model->getSelectList('courses');
			$data['course_list'][''] = 'Select Course';
			$data['class_list'] = array(""=>"Select Class");
			$data['subject_list'] = array(""=>"Select Subject");
			$data['chapter_list'] = array(""=>"Select Chapter");
			$data['level_list'] = array(""=>"Select Level");
			$data['set_list'] = array(""=>"Select Set");
			$data['materials'] = array(""=>"Select Material");
			$data['course_list_to'] = $this->base_model->getSelectList('courses');
			$data['course_list_to'][''] = 'Select Course';
			$data['class_list_to'] = array(""=>"Select Class");
			$data['subject_list_to'] = array(""=>"Select Subject");
			$data['chapter_list_to'] = array(""=>"Select Chapter");
			$data['level_list_to'] = array(""=>"Select Level");
			$data['set_list_to'] = array(""=>"Select Set");
			$data['objective_question_count'] = 0;
			$data['subjective_question_count'] =  0;
		}		
		$data['main_content'] = 'copy_content/index';
		$data['page_title']  = 'Copy Content'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function validate_select($val, $fieldname){
		if($val==""){
			$this->form_validation->set_message('validate_select', 'Please choose the '.$fieldname.'.');
			return FALSE;
		}			
	}
	
	public function request(){
		$data = array();
		$data['class_list'] = array();			
		$course_id = $this->input->post('course_id');
	  	$class_list = $this->copycontent_model->getClasses($course_id);	 
	  	if($class_list){	  		
		  	foreach($class_list as $class){
		  		$data['class_list'][ucfirst($class['name'])] = $class['id'];
		  	}
	  	}
	  	
	  	$subject_list = $this->copycontent_model->getSubjects($course_id, "all");	 	  	
	  	if($subject_list){	  		
			foreach($subject_list as $subject){		  		
		  		$data['subject_list'][$subject['id']] = ucfirst($subject['name']);
		  	}
	  	}	
	  	
	  	$chapter_list = $this->copycontent_model->getChapters($course_id, "all", "all");			  			  	
	  	if($chapter_list){	  		
			foreach($chapter_list as $chapter){
				$data['chapter_list'][ucfirst($chapter['id'])] = $chapter['name'];
		  		//$data['chapter_list'][ucfirst($chapter['name'])] = $chapter['id'];		  		
		  	}
	  	}
	  	
	  	$level_list = $this->copycontent_model->getLevels($course_id, "all", "all", "all");	 		  	
	  	if($level_list){	  		
			foreach($level_list as $level){
		  		$data['level_list'][ucfirst($level['name'])] = $level['id'];
		  	}
	  	}	
	  	
	  	$set_list = $this->copycontent_model->getSets($course_id, "all", "all", "all", "all");		  	
	  	if($set_list){	  		
			foreach($set_list as $set){		  		
		  		$data['set_list'][$set['id']] = ucfirst($set['name']);
		  	}
	  	}	
	  	
	  	$objective_question_count = $this->copycontent_model->getCount("questions", $course_id, "all", "all", "all", "all", "all");	 		  	
	  	$subjective_question_count = $this->copycontent_model->getCount("subjective_questions", $course_id, "all", "all", "all");
	  	if($objective_question_count==0 and $subjective_question_count==0){
	  		$data["result"] = "failure";
	  	}else{
	  		$data["result"] = "success";
		  	$data["objective_question_count"] = $objective_question_count;
		  	$data["subjective_question_count"] = $subjective_question_count;	
	  	}	  	
	  	$material_list = $this->copycontent_model->getmaterials($course_id, "all", "all");	 		   	
	  	if($material_list){	  		
			foreach($material_list as $key=>$value){		  		
		  		$data['material_list'][$key] = ucfirst($value);
		  	}
	  	}	  		
		echo json_encode($data);
	}
		
	public function request1(){
		$data = array();			
		$data['subject_list'] = array();
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
	  	$subject_list = $this->copycontent_model->getSubjects($course_id, $class_id);	 	  	
	  	if($subject_list){	  		
			foreach($subject_list as $subject){
		  		//$data['subject_list'][ucfirst($subject['name'])] = $subject['id'];
		  		$data['subject_list'][$subject['id']] = ucfirst($subject['name']);
		  	}
	  	}		
	  	
	  	$chapter_list = $this->copycontent_model->getChapters($course_id, $class_id, "all");	  		  			  	
	  	if($chapter_list){	  		
			foreach($chapter_list as $chapter){
				$data['chapter_list'][ucfirst($chapter['id'])] = $chapter['name'];
		  		//$data['chapter_list'][ucfirst($chapter['name'])] = $chapter['id'];		  		
		  	}
	  	}
	  	
	  	$level_list = $this->copycontent_model->getLevels($course_id, $class_id, "all", "all");	 		  	
	  	if($level_list){	  		
			foreach($level_list as $level){
		  		$data['level_list'][ucfirst($level['name'])] = $level['id'];
		  	}
	  	}	
	  	
	  	$set_list = $this->copycontent_model->getSets($course_id, $class_id, "all", "all", "all");	 		  	
	  	if($set_list){	  		
			foreach($set_list as $set){		  		
		  		$data['set_list'][$set['id']] = ucfirst($set['name']);
		  	}
	  	}
	  	
	  	$objective_question_count = $this->copycontent_model->getCount("questions", $course_id, $class_id, "all", "all", "all", "all");	 		  	
	  	$subjective_question_count = $this->copycontent_model->getCount("subjective_questions", $course_id, $class_id, "all", "all");
	  	if($objective_question_count==0 and $subjective_question_count==0){
	  		$data["result"] = "failure";
	  	}else{
	  		$data["result"] = "success";
		  	$data["objective_question_count"] = $objective_question_count;
		  	$data["subjective_question_count"] = $subjective_question_count;	
	  	}
	  	
	  	$material_list = $this->copycontent_model->getmaterials($course_id, $class_id, "all");	 	  	
	  	if($material_list){	  		
			foreach($material_list as $key=>$value){		  		
		  		$data['material_list'][$key] = ucfirst($value);
		  	}
	  	}
	  	  		  	
		echo json_encode($data);
	}
		
	public function request2(){
		$data = array();			
		$data['chapter_list'] = array();
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$subject_id = $this->input->post('subject_id');
	  	$chapter_list = $this->copycontent_model->getChapters($course_id, $class_id, $subject_id);	  			  	
	  	if($chapter_list){	  		
			foreach($chapter_list as $chapter){
		  		//$data['chapter_list'][ucfirst($chapter['name'])] = $chapter['id'];
		  		$data['chapter_list'][$chapter['id']] = ucfirst($chapter['name']);
		  	}
	  	}		
	  	
	  	$level_list = $this->copycontent_model->getLevels($course_id, $class_id, $subject_id, "all");	 		  	
	  	if($level_list){	  		
			foreach($level_list as $level){
		  		$data['level_list'][ucfirst($level['name'])] = $level['id'];
		  	}
	  	}	
	  	
	  	$set_list = $this->copycontent_model->getSets($course_id, $class_id, $subject_id, "all", "all");	 		  	
	  	if($set_list){	  		
			foreach($set_list as $set){		  		
		  		$data['set_list'][$set['id']] = ucfirst($set['name']);
		  	}
	  	}  		  			  	
	  	
	  	$objective_question_count = $this->copycontent_model->getCount("questions", $course_id, $class_id, $subject_id, "all", "all", "all");	 		  	
	  	$subjective_question_count = $this->copycontent_model->getCount("subjective_questions", $course_id, $class_id, $subject_id, "all");
	  	if($objective_question_count==0 and $subjective_question_count==0){
	  		$data["result"] = "failure";
	  	}else{
	  		$data["result"] = "success";
		  	$data["objective_question_count"] = $objective_question_count;
		  	$data["subjective_question_count"] = $subjective_question_count;	
	  	}
	  	
	  	$material_list = $this->copycontent_model->getmaterials($course_id, $class_id, $subject_id);	 	  	
	  	if($material_list){	  		
			foreach($material_list as $key=>$value){	
				if($value!="Select" or $key!="all"){
					$data['material_list'][$key] = ucfirst($value);
				}  				  		
		  	}
	  	}
	  	
		echo json_encode($data);
	}
		
	public function request3(){
		$data = array();			
		$data['level_list'] = array();
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$subject_id = $this->input->post('subject_id');
		$chapter_id = $this->input->post('chapter_id');
	  	$level_list = $this->copycontent_model->getLevels($course_id, $class_id, $subject_id, $chapter_id);	 		  	
	  	if($level_list){	  		
			foreach($level_list as $level){
		  		$data['level_list'][ucfirst($level['name'])] = $level['id'];
		  	}
	  	}	
	  	
	  	$set_list = $this->copycontent_model->getSets($course_id, $class_id, $subject_id, $chapter_id, "all");	 		  	
	  	if($set_list){	  		
			foreach($set_list as $set){		  		
		  		$data['set_list'][$set['id']] = ucfirst($set['name']);
		  	}
	  	}	
	  	
	  	$objective_question_count = $this->copycontent_model->getCount("questions", $course_id, $class_id, $subject_id, $chapter_id, "all", "all");	 		  	
	  	$subjective_question_count = $this->copycontent_model->getCount("subjective_questions", $course_id, $class_id, $subject_id,  $chapter_id);
	  	if($objective_question_count==0 and $subjective_question_count==0){
	  		$data["result"] = "failure";
	  	}else{
	  		$data["result"] = "success";
		  	$data["objective_question_count"] = $objective_question_count;
		  	$data["subjective_question_count"] = $subjective_question_count;	
	  	}
	  	  		  			  	
		echo json_encode($data);
	}
		
	public function request4(){
		$data = array();			
		$data['set_list'] = array();
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$subject_id = $this->input->post('subject_id');
		$chapter_id = $this->input->post('chapter_id');
		$level_id = $this->input->post('level_id');
	  	$set_list = $this->copycontent_model->getSets($course_id, $class_id, $subject_id, $chapter_id, $level_id);	 		  	
	  	if($set_list){	  		
			foreach($set_list as $set){
		  		//$data['set_list'][ucfirst($set['name'])] = $set['id'];
		  		$data['set_list'][$set['id']] = ucfirst($set['name']);
		  	}
	  	}	  	
	  	$objective_question_count = $this->copycontent_model->getCount("questions", $course_id, $class_id, $subject_id, $chapter_id, $level_id, "all");	 		  	
	  	$subjective_question_count = $this->copycontent_model->getCount("subjective_questions", $course_id, $class_id, $subject_id,  $chapter_id);
	  	if($objective_question_count==0 and $subjective_question_count==0){
	  		$data["result"] = "failure";
	  	}else{
	  		$data["result"] = "success";
		  	$data["objective_question_count"] = $objective_question_count;
		  	$data["subjective_question_count"] = $subjective_question_count;	
	  	}	  		  		  			  	
		echo json_encode($data);
	}
		
	public function request5(){	
		$data = array();
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$subject_id = $this->input->post('subject_id');
		$chapter_id = $this->input->post('chapter_id');
		$level_id = $this->input->post('level_id');
		$set_id = $this->input->post('set_id');
	  	$objective_question_count = $this->copycontent_model->getCount("questions", $course_id, $class_id, $subject_id, $chapter_id, $level_id, $set_id);	 		  	
	  	$subjective_question_count = $this->copycontent_model->getCount("subjective_questions", $course_id, $class_id, $subject_id, $chapter_id);
	  	if($objective_question_count==0 and $subjective_question_count==0){
	  		$data["result"] = "failure";
	  	}else{
	  		$data["result"] = "success";
		  	$data["objective_question_count"] = $objective_question_count;
		  	$data["subjective_question_count"] = $subjective_question_count;	
	  	}	  			  			  		  			  	
		echo json_encode($data);
	}	
	
	
	
}	
