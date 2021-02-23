<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Levels extends Admin_Controller
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
			$this->load->model('certificate_model');
			$this->load->helper(array('function_helper'));
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
		  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/levels/index";
		 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		  	$config["uri_segment"] = 4;
		  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		  	$limit_start = $config['per_page'];
		  	$join_tables = $where = array();  
		  	if($keyword_course)
			{
				$class_list = $this->certificate_model->getClasses($keyword_course);	  	
				$data['get_class'] = $this->make_select($class_list, "Select Class");
				$where[] = array( TRUE, 'c.course_id', $keyword_course);
				$data['keyword_course'] = $keyword_course;
			}
			else{
				$data['keyword_course'] = "";
			}
			if($keyword_class)
			{
				$subject_list = $this->certificate_model->getSubjects($keyword_course, $keyword_class);
				$data['get_subject'] = $this->make_select($subject_list, "Select Subject");
				$where[] = array( TRUE, 'c.class_id', $keyword_class);
				$data['keyword_class'] = $keyword_class;
			}
			else{
				$data['keyword_class'] = "";
			}
			if($keyword_subject)
			{
				$chapter_list = $this->certificate_model->getChapters($keyword_course, $keyword_class, $keyword_subject);
				$data['get_chapter'] = $this->make_select($chapter_list, "Select Chapter");
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
			if($keyword_name)
			{
				$where[] = array( TRUE, 'c.name LIKE ', '%'.$keyword_name.'%');
				$data['keyword_name'] = $keyword_name;
			}
			else{
				$data['keyword_name'] = "";
			}
		  	$fields = 'c.id, c.name level_name, c.status, c.created, c.order, co.name course_name, cl.name class_name, s.name subject_name, ch.name chapter_name,count(tg.level_id) as l_count,count(set.level_id) as s_count'; 
		  	$join_tables[] = array('courses as co','c.course_id = co.id');
		  	$join_tables[] = array('relevant_classes as rc','c.course_id = rc.course_id and rc.class_id=c.class_id');
		  	$join_tables[] = array('classes as cl','rc.class_id = cl.id');	
		  	$join_tables[] = array('relevant_subjects as rs','c.course_id = rs.course_id and rs.subject_id=c.subject_id and rc.class_id=rs.class_id');		  	
		  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');	
		  	$join_tables[] = array('chapters as ch','c.chapter_id = ch.id');	
		  	$join_tables[] = array('test_engagement as tg','c.id = tg.level_id');
		  	$join_tables[] = array('sets as set','c.id = set.level_id');
	  		$where[] = array( TRUE, 'co.status', 1); 
		  	$where[] = array( TRUE, 'cl.status', 1);  
		  	$where[] = array( TRUE, 's.status', 1); 
		  	$where[] = array( TRUE, 'ch.status', 1);		  	
		  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('levels as c', $join_tables, $fields, $where, 'num_rows','','','c.id');
		  	$data['levels'] = $this->base_model->get_advance_list('levels as c', $join_tables, $fields, $where, '', 'c.id', 'desc', 'c.id', $limit_start, $limit_end);
		  	
		    $this->pagination->initialize($config);
		    $data['get_course'] = $this->base_model->getSelectList('courses');
			$data['main_content'] = 'levels/index';
		  	$data['page_title']  = 'Levels'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function reset()
		{
			$this->session->unset_userdata('search_course');
			$this->session->unset_userdata('search_class');
			$this->session->unset_userdata('search_subject');
			$this->session->unset_userdata('search_chapter');
			$this->session->unset_userdata('search_name');
			redirect(base_url().SITE_ADMIN_URI.'/levels/');
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
				$this->form_validation->set_rules('course_list', 'course list','callback_validate_select[Course]');
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[Class]');
				$this->form_validation->set_rules('subject_list', 'subject list','callback_validate_select[Subject]');
				$this->form_validation->set_rules('chapter_list', 'chapter list','callback_validate_select[Chapter]');
				$name_array = $this->input->post('name');
		        foreach ($name_array as $key => $name) {
					
						$course=$this->input->post('course_list');
						$subject_list=$this->input->post('subject_list');
						$class_list=$this->input->post('class_list'); 
						$chapter_list=$this->input->post('chapter_list'); 
						$arr=" course_id=$course   and class_id=$class_list  and  subject_id=$subject_list  and chapter_id=$chapter_list";
					
		                $this->form_validation->set_rules('name[' . $key . ']', 'Name', 
		                'trim|required|is_unique[levels.name.'.$arr.']');
 
		        }		       
		      /* modified */
		  		$order_array = $this->input->post('order');
		      foreach ($order_array as $key => $order) {
		      	//$order_arr=" subject_id='$subject_list' AND  course_id='$course' AND class_id='$class_list' AND chapter_id='$chapter_list'";
		      	//$this->form_validation->set_rules('order[' . $key . ']', 'Order', 'trim|required|is_unique[levels.order.'.$order_arr.']');
		      	
		      	if($order_array[$key]=="0"){
		      		$this->form_validation->set_message('no_zero_order'.$key, 'The order field must be greater than zero.');
		      		$this->form_validation->set_rules('order[' . $key . ']', 'Order', 'no_zero_order'.$key);
		      	}else{
		      		$this->form_validation->set_rules('order[' . $key . ']', 'Order', 'trim|required|integer');
		      	}      	
		      	
		      }
		      /* modified */
				if ($this->form_validation->run()){ 
					$date = date('Y-m-d H:i:s');
					$update_array = array();
					$description=$this->input->post("description");
					foreach($this->input->post('name') as $key=>$name){
					
					/* modified */
					$where = array();
					$fields = 'id, order';
					$where[] = array( TRUE, 'course_id', $this->input->post('course_list'));		
					$where[] = array( TRUE, 'subject_id', $this->input->post('subject_list'));	
					$where[] = array( TRUE, 'class_id', $this->input->post('class_list'));	
					$where[] = array( TRUE, 'chapter_id', $this->input->post('chapter_list'));
					$where[] = array( TRUE, 'order>=', $order_array[$key]);															   	
					$level_details = $this->base_model->get_advance_list('levels', '', $fields, $where, '', 'order', 'asc');								
					$temp_order_id = $order_array[$key]+1;					
					foreach($level_details as $level_detail){																	
						$update_order_array = array('order'=>$temp_order_id,
													 		'modified' => $date
													 		);
						$this->base_model->update ( 'levels', $update_order_array, array('id'=>$level_detail["id"]));
						$temp_order_id++;
					}
					/* modified */
					
					
					$update_array = array ('name' => $name, 
									       'description' => $description[$key], 
										   'course_id' => $this->input->post('course_list'), 
										   'subject_id' => $this->input->post('subject_list'), 
										   'class_id' => $this->input->post('class_list'), 
										   'chapter_id' => $this->input->post('chapter_list'), 
										   'order' => $order_array[$key], //modified
										   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
										   'created' => $date
										   );
					$insertId = $this->base_model->insert('levels', $update_array);
				    }
					
					
					$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
					redirect(base_url().SITE_ADMIN_URI.'/levels/');
				}
				$data['post'] = TRUE;
				$data['class_list'] = array();
				$data['subject_list'] = array();
				$join_tables = $where = array();  
			  	$fields = 'cl.id, cl.name class_name'; 
			  	$where[] = array( TRUE, 'rc.course_id', $this->input->post('course_list'));
			  	$join_tables[] = array('classes as cl','rc.class_id = cl.id');			  	
			  	$class_list = $this->base_model->get_advance_list('relevant_classes as rc', $join_tables, $fields, $where, '', 'cl.name', 'asc');
			  	if($class_list and $this->input->post('course_list')!=""){
			  		$data['class_list'][''] = 'Select Class'; 
				  	foreach($class_list as $class){
				  		$data['class_list'][$class['id']] = ucfirst($class['class_name']);
				  	}
			  	}
			  	$join_tables = $where = array();  
			  	$fields = 's.id, s.name subject_name'; 
			  	$where[] = array( TRUE, 'rs.course_id', $this->input->post('course_list'));
			  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');			  	
			  	$subject_list = $this->base_model->get_advance_list('relevant_subjects as rs', $join_tables, $fields, $where, '', 's.name', 'asc');
				$data['subject_list'][''] = 'Select Subject'; 
				if($subject_list and $this->input->post('class_list')!=""){					
					foreach($subject_list as $subject){
				  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
				  	}
			  	}
				$data['chapter_list'] = array();
				$data['chapter_list'][''] = 'Select Chapter';
				if($this->input->post('subject_list')!=""){
					$data['chapter_list'] = $this->base_model->getSelectList('chapters', array('course_id' => $this->input->post('course_list'), 'class_id' => $this->input->post('class_list'), 'subject_id' => $this->input->post('subject_list')));				
				}				
				$data['course_list'] = $this->base_model->getSelectList('courses');
				$data['course_list'][''] = 'Select Course';
				#new
			if($this->input->post('course_list')==""){
				$data['class_list'] = array(""=>"Select Class");
				$data['subject_list'] = array(""=>"Select Subject");
				$data['chapter_list'] = array(""=>"Select Chapter");
			}
			}else {
			$data['course_list'] = $this->base_model->getSelectList('courses'); 
			$data['course_list'][''] = 'Select Course';
			$data['class_list'] = array(""=>"Select Class");
			$data['subject_list'] = array(""=>"Select Subject");
			$data['chapter_list'] = array(""=>"Select Chapter");
			}
			
			$data['main_content'] = 'levels/add';
			$data['page_title']  = 'Levels'; 
			$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		
		public function edit($id = NULL)
		{
			$data['post'] = FALSE;
			$join_tables = $where = array(); 
			$where1[] = array( TRUE, 'id', $id);
			$fields = 'name, order'; // modified
			$getValues = $this->base_model->get_advance_list('levels', $join_tables, $fields, $where1, 'row_array');
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->form_validation->set_rules('course_list', 'course list','callback_validate_select[Course]');
				$this->form_validation->set_rules('class_list', 'class list','callback_validate_select[Class]');
				$this->form_validation->set_rules('subject_list', 'subject list','callback_validate_select[Subject]');
				$this->form_validation->set_rules('chapter_list', 'chapter list','callback_validate_select[Chapter]');
				$this->form_validation->set_rules('name', 'Name','trim|required');	
	 			$course=$this->input->post('course_list');
				$subject_list=$this->input->post('subject_list');
				$class_list=$this->input->post('class_list'); 
				$chapter_list=$this->input->post('chapter_list');
				$order=$this->input->post('order'); // modified 
				if($this->input->post('name') != $getValues['name'] && $course!="" && $subject_list!="" && $class_list!="" && $chapter_list!="") {					
						$arr=" course_id =$course   and class_id =$class_list  and  subject_id =$subject_list  and chapter_id =$chapter_list";
						$is_unique =  '|is_unique[levels.name.'.$arr.']' ;
				} else {
					$is_unique =  '' ;
				}
				$this->form_validation->set_rules('name', 'name', 'trim|required'.$is_unique);
				if($order=="0"){
		      	$this->form_validation->set_message('no_zero_order', 'The order field must be greater than zero.');
		      	$this->form_validation->set_rules('order', 'Order', 'no_zero_order');
		      }else{
		      	$this->form_validation->set_rules('order', 'Order', 'trim|required|integer');
		      }
				if ($this->form_validation->run())
				{  
					$date = date('Y-m-d H:i:s');
					/* modified */
					$where = array();
					$fields = 'id, name, order';
					$where[] = array( TRUE, 'course_id', $this->input->post('course_list'));		
					$where[] = array( TRUE, 'subject_id', $this->input->post('subject_list'));	
					$where[] = array( TRUE, 'class_id', $this->input->post('class_list'));	
					$where[] = array( TRUE, 'chapter_id', $this->input->post('chapter_list'));
					$where[] = array( TRUE, 'order>=', $order);	
					$where[] = array( TRUE, 'id!=', $id);															   	
					$level_details = $this->base_model->get_advance_list('levels', '', $fields, $where, '', 'order', 'asc');					
					$temp_order_id = $order+1;
					foreach($level_details as $level_detail){																							
						$update_order_array = array('order'=>$temp_order_id,
													 		'modified' => $date
													 		);
						$this->base_model->update ( 'levels', $update_order_array, array('id'=>$level_detail["id"]));
						$temp_order_id++;
					}
					/* modified */
					
					
					
					$update_array = array ('name' => $this->input->post('name'), 
										   'description' => $this->input->post('description'), 
										   'order' => $order,  // modified
										   'course_id' => $this->input->post('course_list'), 
										   'subject_id' => $this->input->post('subject_list'), 
										   'class_id' => $this->input->post('class_list'), 
										   'chapter_id' => $this->input->post('chapter_list'), 
										   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
										   'modified' => $date
										   );
					$this->base_model->update ( 'levels', $update_array, array('id'=>$id));
					$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
					redirect(base_url().SITE_ADMIN_URI.'/levels/');
				}
				$data['post'] = TRUE;
			
				$data['class_list'] = array();
				$data['subject_list'] = array();
				$join_tables = $where = array();  
			  	$fields = 'cl.id, cl.name class_name'; 
			  	$where[] = array( TRUE, 'rc.course_id', $this->input->post('course_list'));
			  	$join_tables[] = array('classes as cl','rc.class_id = cl.id');			  	
			  	$class_list = $this->base_model->get_advance_list('relevant_classes as rc', $join_tables, $fields, $where, '', 'cl.name', 'asc');
			  	$data['class_list'][''] = 'Select Class'; 
			  	if($class_list){			  		
				  	foreach($class_list as $class){
				  		$data['class_list'][$class['id']] = ucfirst($class['class_name']);
				  	}
			  	}
			  	$join_tables = $where = array();  
			  	$fields = 's.id, s.name subject_name'; 
			  	$where[] = array( TRUE, 'rs.course_id', $this->input->post('course_list'));
			  	$join_tables[] = array('subjects as s','rs.subject_id = s.id');			  	
			  	$subject_list = $this->base_model->get_advance_list('relevant_subjects as rs', $join_tables, $fields, $where, '', 's.name', 'asc');
				$data['subject_list'][''] = 'Select Subject'; 
				if($subject_list and $this->input->post('class_list')!=""){					
					foreach($subject_list as $subject){
				  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
				  	}
			  	}
				$data['chapter_list'] = array();
				$data['chapter_list'][''] = 'Select Chapter';
				if($this->input->post('subject_list')!=""){
					$data['chapter_list'] = $this->base_model->getSelectList('chapters', array('course_id' => $this->input->post('course_list'), 'class_id' => $this->input->post('class_list'), 'subject_id' => $this->input->post('subject_list')));	
				}
			}else{
			$fields = 'cl.id, cl.name class_name'; 
		  	$where[] = array( TRUE, 'c.id', $id);
		  	$join_tables[] = array('relevant_classes as rl','c.course_id = rl.course_id');			
		  	$join_tables[] = array('classes as cl','rl.class_id = cl.id');  	
		  	$class_list = $this->base_model->get_advance_list('levels as c', $join_tables, $fields, $where, '', 'cl.name', 'asc');
		  	$data['class_list'][''] = 'Select Class';
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
		  	$subject_list = $this->base_model->get_advance_list('levels as c', $join_tables, $fields, $where, '', 's.name', 'asc');
			if($subject_list){
				$data['subject_list'][''] = 'Select Subject'; 
				foreach($subject_list as $subject){
			  		$data['subject_list'][$subject['id']] = ucfirst($subject['subject_name']);
			  	}
		  	}
		  	
		  	$join_tables = $where = array();  
		  	$fields = 'ch.id, ch.name chapter_name'; 
		  	$where[] = array( TRUE, 'c.id', $id);
		  	$join_tables[] = array('chapters as ch','c.course_id = ch.course_id and c.class_id = ch.class_id and c.subject_id = ch.subject_id');
		  	  	
		  	$chapter_list = $this->base_model->get_advance_list('levels as c', $join_tables, $fields, $where, '', 'ch.name', 'asc');
		  
		  
			if($chapter_list){
				$data['chapter_list'][''] = 'Select Chapter'; 
				foreach($chapter_list as $chapter){
			  		$data['chapter_list'][$chapter['id']] = ucfirst($chapter['chapter_name']);
			  	}
		  	}
		 
			}
		 
		   	$data['course_list'] = $this->base_model->getSelectList('courses');
		  	$data['course_list'][''] = 'Select Course';
			$data['levels_main'] = $this->base_model->getCommonListFields('levels','',array('id' => $id));
			$data['levels'] = $data['levels_main'][0];			
			$join_tables = $where = array();  
			$fields = 'COUNT(tg.level_id) as l_count,count(set.level_id) as s_count'; 
			$where[] = array( TRUE, 'c.id', $id);
			$join_tables[] = array('test_engagement as tg','tg.level_id = c.id',"left");
			$join_tables[] = array('sets as set','c.id = set.level_id');
			$data['test_details'] = $this->base_model->get_advance_list('levels as c', $join_tables, $fields, $where, 'row', '', '');
			$data['main_content'] = 'levels/edit';
		  	$data['page_title']  = 'Levels'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}

	public function delete($id,$pageredirect=null,$pageno) {
		$test_details = check_delete($id,3);
		if($test_details["is_delete"]==0){
			$this->base_model->delete ('levels',array('id' => $id));
			$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
			redirect(base_url().SITE_ADMIN_URI.'/levels/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		else
		{
			redirect(base_url().SITE_ADMIN_URI.'/levels/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'levels';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/levels/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		
	}
	function bulkactions($pageredirect=null,$pageno){
		
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'levels');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'levels');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$test_details = check_delete($id,3);
				if($test_details["is_delete"]==0)
				{
					$this->base_model->delete('levels', array('id' => $id));
				}
				else
				{
					redirect(base_url().SITE_ADMIN_URI.'/levels/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/levels/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/levels/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function request(){
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$subject_id = $this->input->post('subject_id');
		$data = array();
		$data['chapter_list'] = array();
		$data['chapter_list'] = $this->base_model->getSelectList('chapters', array('course_id' => $course_id, 'class_id' => $class_id, 'subject_id' => $subject_id));
		$data['chapter_list'] = array_flip($data['chapter_list']);
		echo json_encode($data);
	}
	public function make_select($select_values, $default){
		$return_values[""] = $default;
		foreach($select_values as $select_value){
			$return_values[$select_value["id"]] = $select_value["name"];
		}
		return $return_values;	
	}
	public function get_Count(){				
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$subject_id = $this->input->post('subject_id');		
		$chapter_id = $this->input->post('chapter_id');		
		$where = array();
		$where[] = array( TRUE,"course_id",$course_id);
		$where[] = array( TRUE,"class_id",$class_id);
		$where[] = array( TRUE,"subject_id",$subject_id);	
		$where[] = array( TRUE,"chapter_id",$chapter_id);						
		$fields = 'order';	
	  	$return_data = $this->base_model->get_advance_list('levels', '', $fields, $where, 'row_array', 'order', 'desc', '', '1');	  	
	  	if(count($return_data)>0){
	  		$count = $return_data["order"] + 1;
	  	}else{
	  		$count = 1;
	  	}
		echo $count; die;
	}
}
