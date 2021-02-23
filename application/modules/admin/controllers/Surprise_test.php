<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Surprise_test extends Admin_Controller
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
			
			$search_from_date_keyword  = isset($_POST['search_from_date'])?trim($_POST['search_from_date']):(isset($_SESSION['search_from_date'])?$_SESSION['search_from_date']:'');
			$this->session->set_userdata('search_from_date', $search_from_date_keyword); 			
			$keyword_from_date_session = $this->session->userdata('search_from_date');
			if($keyword_from_date_session != '')
			{
				$keyword_from_date = $this->session->userdata('search_from_date');
			}
			else
			{
				isset($_SESSION['search_from_date'])?$this->session->unset_userdata('search_from_date'):'';
				$keyword_from_date = "";
			}	
			
			$search_to_date_keyword  = isset($_POST['search_to_date'])?trim($_POST['search_to_date']):(isset($_SESSION['search_to_date'])?$_SESSION['search_to_date']:'');
			$this->session->set_userdata('search_to_date', $search_to_date_keyword); 			
			$keyword_to_date_session = $this->session->userdata('search_to_date');
			if($keyword_to_date_session != '')
			{
				$keyword_to_date = $this->session->userdata('search_to_date');
			}
			else
			{
				isset($_SESSION['search_to_date'])?$this->session->unset_userdata('search_to_date'):'';
				$keyword_to_date = "";
			}
			$this->load->library('pagination');
			$config  = $this->config->item('pagination');
		  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/surprise_test/index";
		 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		  	$config["uri_segment"] = 4;
		  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		  	$limit_start = $config['per_page'];
		  	$join_tables = $where = array(); 
		  	if($keyword_name)
			{
				$where[] = array( TRUE, 'c.test_name LIKE ', '%'.$keyword_name.'%' );
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
			if($keyword_from_date){
				if($keyword_to_date){
					$from_date = $keyword_from_date." 00:00:00";
					$to_date = $keyword_to_date." 23:59:59";
					$where[] = array( TRUE, "c.from_date >=",$from_date);
					$where[] = array( TRUE, "c.to_date <=",$to_date);
					$data['keyword_from_date'] = $keyword_from_date;		
					$data['keyword_to_date'] = $keyword_to_date;
				}else{
					$from_date = $keyword_from_date." 00:00:00";
					$to_date = $keyword_from_date." 23:59:59";
					$where[] = array( TRUE, "c.from_date >=",$from_date);
					$where[] = array( TRUE, "c.from_date <=",$to_date);
					$data['keyword_from_date'] = $keyword_from_date;			
					$data['keyword_to_date'] = "";		
				}
				
			}
			else{
				if($keyword_to_date){				
					$from_date = $keyword_to_date." 00:00:00";
					$to_date = $keyword_to_date." 23:59:59";
					$where[] = array( TRUE, "c.to_date >=",$from_date);
					$where[] = array( TRUE, "c.to_date <=",$to_date);
					$data['keyword_to_date'] = $keyword_to_date;
				}else{
					$data['keyword_to_date'] = "";
				}
				$data['keyword_from_date'] = "";
			}			
		  	$fields = 'c.id,c.test_name,c.test_description,c.duration,c.hours,c.mins,
		  	c.secs,c.from_date,c.to_date,c.status, c.created,co.name course_name,count(sq.test_id) as ques_count,c.course_id course_id,publish_status,COUNT(tg.surprise_test_id) as st_count'; 
		  	$join_tables[] = array('courses as co','c.course_id = co.id');
		  	$join_tables[] = array('surprise_questions as sq','sq.test_id = c.id');
		  	$join_tables[] = array('test_engagement as tg','tg.surprise_test_id = c.id',"left");
		  	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('surprise_test as c', $join_tables, $fields, $where, 'num_rows','','','c.id');
		  	$data['surprise_test'] = $this->base_model->get_advance_list('surprise_test as c', $join_tables, $fields, $where, '', 'c.id', 'desc', 'c.id', $limit_start, $limit_end);
		    $this->pagination->initialize($config);
		    $data['get_course'] = $this->base_model->getSelectList('courses');
			$data['main_content'] = 'surprise_test/index';
		  	$data['page_title']  = 'Surprise Test'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function reset()
		{
			$this->session->unset_userdata('search_name');
			$this->session->unset_userdata('search_course');
			$this->session->unset_userdata('search_from_date');
			$this->session->unset_userdata('search_to_date');
			redirect(base_url().SITE_ADMIN_URI.'/surprise_test/');
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
				$this->form_validation->set_rules('course_list', 'Course','trim|callback_validate_select[Course]');
				// $this->form_validation->set_rules('class_list[]', 'Class','trim|required');
				$this->form_validation->set_rules('name', 'Name','trim|required');
				$this->form_validation->set_rules('description', 'Description','trim|required');
				// $this->form_validation->set_rules('duration', 'Duration','trim|required');
				// if( $this->input->post('duration')==1){
				$this->form_validation->set_rules('hours', 'Time','trim|required');
				// }				
				$this->form_validation->set_rules('from_date', 'From Date','trim|required');
				$this->form_validation->set_rules('to_date', 'To Date','trim|required');


				if(!$this->input->post('class_list')){
					$this->form_validation->set_rules('class_list', 'class Id','trim|required');
				}


				if ($this->form_validation->run()){ 
					$date = date('Y-m-d H:i:s');
					$update_array = array();
					// $enable = $this->input->post('duration');
					// if($enable == 1){
						$time = $this->input->post('hours');
					// }
					// else{
					// 	$time = '00';
					// }
						// print_r($this->input->post('class_list'));die;
						 $class_list = implode(',',$this->input->post('class_list'));
					
						$update_array = array ('course_id' => $this->input->post('course_list'), 
											   'class_id' => $class_list, 
											   'test_name' => $this->input->post('name'), 
											   'test_description' => $this->input->post('description'),
											   //'duration' => $this->input->post('duration'), 
											   'hours' => $time,
										   	   'mins' =>  $this->input->post('mins'),
											   'from_date' => date('Y-m-d H:i:s',strtotime($this->input->post('from_date'))), 
											   'to_date' => date('Y-m-d H:i:s',strtotime($this->input->post('to_date'))), 
											   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
											   'created' => $date
											   );
						$insertId = $this->base_model->insert('surprise_test', $update_array);
						$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
						redirect(base_url().SITE_ADMIN_URI.'/surprise_test/');
				}
				$data['post'] = TRUE;
			}
			$data['course_list'] = $this->base_model->getSelectList('courses');
			$data['main_content'] = 'surprise_test/add';
			$data['page_title']  = 'Surprise Test'; 
			$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function edit($id = NULL)
		{
			$data['post'] = FALSE;
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->form_validation->set_rules('course_list', 'course','trim|callback_validate_select[Course]');
				// $this->form_validation->set_rules('class_list[]', 'Class','trim|callback_validate_select[Class]');
				$this->form_validation->set_rules('name', 'Name','trim|required');
				$this->form_validation->set_rules('description', 'Description','trim|required');
				// $this->form_validation->set_rules('duration', 'Duration','trim|required');
				$this->form_validation->set_rules('hours', 'Time','trim|required');
				$this->form_validation->set_rules('from_date', 'From Date','trim|required');
				$this->form_validation->set_rules('to_date', 'To Date','trim|required');

				if(!$this->input->post('class_list')){
					$this->form_validation->set_rules('class_list', 'class Id','trim|required');
				}


				if ($this->form_validation->run())
				{  
					$date = date('Y-m-d H:i:s');
					// $enable = $this->input->post('duration');
					// if($enable == 1){
						$time = $this->input->post('hours');
					// }
					// else{
					// 	$time = '00';
					// }
					 $class_list = implode(',',$this->input->post('class_list'));
					$update_array = array ('course_id' => $this->input->post('course_list'), 
						 				   'class_id' => $class_list , 
										   'test_name' => $this->input->post('name'), 
										   'test_description' => $this->input->post('description'),
										   // 'duration' => $this->input->post('duration'), 
										   'hours' => $time,
										   'mins' =>  $this->input->post('mins'),
										   'from_date' => date('Y-m-d H:i:s',strtotime($this->input->post('from_date'))), 
										   'to_date' => date('Y-m-d H:i:s',strtotime($this->input->post('to_date'))), 
										   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
									   	   'modified' => $date
										   );
					$this->base_model->update ( 'surprise_test', $update_array, array('id'=>$id));
					$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
					redirect(base_url().SITE_ADMIN_URI.'/surprise_test/');
				}
				$data['post'] = TRUE;
		 	}
		   	$data['course_list'] = $this->base_model->getSelectList('courses');
			$data['surprise_test_main'] = $this->base_model->getCommonListFields('surprise_test','',array('id' => $id));
			$data['surprise_test'] = $data['surprise_test_main'][0];

			
			$class_list = $this->certificate_model->getClasses($data['surprise_test_main'][0]->course_id);
			
			if($class_list){
			  	foreach($class_list as $class){
			  		$data['class_list'][ucfirst($class['id'])] = $class['name'];
			  	}
		  	}
		  	$data['sel_class_list'] = explode(',',$data['surprise_test_main'][0]->class_id);
		  	 // print_r($data['sel_class_list']);die;
			$data['main_content'] = 'surprise_test/edit';
		  	$data['page_title']  = 'Surprise Test'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}

	public function delete($id,$pageredirect=null,$pageno) 
	{
		$this->base_model->delete ('surprise_test',array('id' => $id));
		$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
		redirect(base_url().SITE_ADMIN_URI.'/surprise_test/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'surprise_test';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/surprise_test/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkactions($pageredirect=null,$pageno){
		
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('status' => '1');
				$this->base_model->update_status($id, $data, 'surprise_test');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('status' => '0');
				$this->base_model->update_status($id, $data, 'surprise_test');
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else if($bulk_type == 3)
		{
			foreach($bulk_ids as $id) 
			{
				$this->base_model->delete('surprise_test', array('id' => $id));
			
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_deleted') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().SITE_ADMIN_URI.'/surprise_test/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().SITE_ADMIN_URI.'/surprise_test/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	 public function get_tests(){
		 if($this->input->post("course")!=""){
			 $course_id=$this->input->post("course");
			 	$join_tables = $where = array();  
	  	$fields = 'id,test_name'; 
	  	$where[] = array( TRUE, 'course_id', $course_id); 
	  	$subject_list = $this->base_model->get_advance_list('surprise_test', $join_tables, $fields, $where, '', 'test_name', 'asc');
		if($subject_list){
			foreach($subject_list as $subject){
		  		$data['test_list'][$subject["id"]] =ucfirst($subject['test_name']);
		  	}
	  	} 
		echo json_encode($data);
		 }
		 
	 }
	public function publish($id,$course_id,$status,$pageredirect,$pageno){
		 $date = date('Y-m-d H:i:s');
		 $check_ex_alert=$this->download_model->get_data($id);
		 $user_list_course=$this->alert_model->get_users($course_id);
		 $surprise_detail = $this->download_model->get_details($id);
		 foreach($user_list_course as $in_user_list){
			$user_list[]=$in_user_list["user_id"];
		 }
		 if($surprise_detail['duration']!=0)
		 {
		 	$content = "The test duration is ".$surprise_detail['hours']." hour(s)";
		 }
		 else
		 {
		 	$content = "";
		 }
		 if($status == 0&&$check_ex_alert["alert_item_id"]==0){
			$alert_array = array('created' => $date,
								 'title' => 'New Surprise test has been published by admin.',
								 'short_description' => 'Gear up for our next surprise test on '.date('d-m-Y',strtotime($surprise_detail['from_date'])).','.
 $content.' and will appear any time on the mentioned day, stay online with us and boost your scores up on the leaderboard.',
								 'status' => '1','alert_type'=>2,"alert_item_id"=>$id,"course_id"=>$course_id);
			$alertId = $this->base_model->insert('alerts', $alert_array);
			if($alertId)
			{
				foreach($user_list as $key=>$value)
				{
					$array = array();
					$array = array ('alert_id' => $alertId, 
									'user_id' => $value,
								 	'status' => 1,
									);
					$insertId = $this->base_model->insert('alert_users', $array);
				}
			}
			
		}
		if($status==0){
			$ex_status=1;
			$this->session->set_flashdata('flash_message',"Test Published Successfully..!");
		}else{
			$ex_status=0;
			$this->session->set_flashdata('flash_message',"Test Unpublished Successfully..!");
		}
		
		$update_array = array ("publish_status"=>$ex_status);
		$this->base_model->update ( 'surprise_test', $update_array, array('id'=>$id)); 
		
		redirect(base_url().SITE_ADMIN_URI.'/surprise_test/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
}
