<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Course_plan extends Admin_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
    		$this->load->library(array('form_validation'));
			$this->load->language(array('flash_message','form_validation'), 'english');
			if(!$this->session->has_userdata('admin_is_logged_in')){
					redirect(SITE_ADMIN_URI);
			}
			$this->load->model(array('base_model','classes_model')); 
			getSearchDetails($this->router->fetch_class());
			$this->load->helper('function_helper');
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
				isset($_SESSION['search_course'])?$this->session->unset_userdata('search_course'):'';
				$keyword_name = "";
			}	
			if($this->input->post("search_categ")!=""){
				$this->session->set_userdata('search_categ', $this->input->post("search_categ")); 
			}
			$search_categ =$this->session->userdata('search_categ');
			$data["search_categ"]=$search_categ;
			$this->load->library('pagination');
			$config  = $this->config->item('pagination');
		  	$config["base_url"]    = base_url().SITE_ADMIN_URI."/course_plan/index";
		 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		  	$config["uri_segment"] = 4;
		  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		  	$limit_start = $config['per_page'];
		  	$join_tables = array();
		  	$where = array();  
		  	if($keyword_name)
			{
				$where[] = array( TRUE, 'name LIKE ', '%'.$keyword_name.'%' );
				$data['keyword_name'] = $keyword_name;
			}
			else{
				$data['keyword_name'] = "";
			}
			$data['currency'] = $this->config->item('currency_symbol');
			$data['dollar_symbol'] = $this->config->item('dollar_symbol');
		  	$fields = 'co.id, name, co.description, price, duration, co.status, co.created';	// 
			 $join_tables[] = array();
		   	$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('courses co', '', $fields, $where, 'num_rows','','','co.id');
		  	$data['courses'] = $this->base_model->get_advance_list('courses co','', $fields, $where, '', 'id', 'desc', 'id', $limit_start, $limit_end);
			$data["chapter_count"]=$this->classes_model->get_counts_chapters();
		    $this->pagination->initialize($config);
			$data['main_content'] = 'course_plan/index';
		  	$data['page_title']  = 'course plan'; 
		  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		public function reset()
		{
			$this->session->unset_userdata('search_name');
			$this->session->unset_userdata('search_categ');
			redirect(base_url().SITE_ADMIN_URI.'/course_plan/');
		}		
		public function validate_select($val, $fieldname){ 
			if($val==""){
				if($fieldname=="price"){
					$this->form_validation->set_message('validate_select', 'Please enter atleast one price.');
					return FALSE;
				}else{
					$this->form_validation->set_message('validate_select', 'Please choose the '.$fieldname.'.');
					return FALSE;
				}				
			}			
		}
		 public function add()
		{
			$data['post'] = FALSE;
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$arr=" course_category_id=$course_cat_id";				
				$this->form_validation->set_rules('name', 'name','trim|required|is_unique[courses.name.'.$arr.']');
				
						 $this->form_validation->set_rules('description', 'description','trim|required|max_length[200]');
						 if(($this->input->post('price')=="")){				 		 	
							$this->form_validation->set_rules('price','price','trim|numeric|callback_validate_select[price]');		
						 }
						 if($this->input->post('price')!=""){
						 	$this->form_validation->set_rules('price','price (INR)','trim|numeric');
						 }
				if($this->input->post('duration') == 0)
				{
					$this->form_validation->set_message('no_zero_duration', 'The duration field must be greater than zero.');
					$this->form_validation->set_rules('duration','duration','trim|numeric|required|no_zero_duration');
				}
				if($this->input->post('price')=="0")
				{	
					$this->form_validation->set_message('no_zero', 'The price (INR) field must be greater than zero.');
					$this->form_validation->set_rules('price','price','trim|numeric|no_zero');
				}
				
				$class_counts = $this->input->post('class_counts');
				$this->form_validation->set_rules("relevant_classes_0", 'relevant classes','trim|callback_validate_select[relevant classes]');
				for($i = 1; $i <=$class_counts; $i++){
					if($this->input->post('relevant_classes_'.$i) == ''){
						$this->form_validation->set_rules("relevant_classes_".$i, 'relevant classes','trim|callback_validate_select[relevant classes]');
					}
				}				
				if ($this->form_validation->run()){ 										
					$date = date('Y-m-d H:i:s');				
					$where = array();
					$config['upload_path'] = $this->config->item('course_plans');
	                $config['allowed_types'] = "gif|jpg|jpeg|png"; 
	                $config['min_width'] = "195"; 
	                $config['min_height'] = "195";   
					
	                $this->load->library('upload', $config);
	                $image_up = $this->upload->do_upload('image');
					
					if (!$image_up)
	        		{
					    $upload = array('error' => $this->upload->display_errors());
					   	$data['upload_error'] = $upload;
					}
					else
					{
						$image_data = array('upload_data' => $this->upload->data());

					$update_array = array ('name' => $this->input->post('name'),
										   'description' => $this->input->post('description'), 
										   'currency_type' => 1, //1 - rs, 2 - usd, 3 - both	
										   'price' => $this->input->post('price'), 
										   'image' => $image_data['upload_data']['file_name'],
										   'duration' => $this->input->post('duration'), 
										   'status' => ($this->input->post('status')) ? $this->input->post('status') : 0,
										   'created' => $date
										);	
										// print_r($update_array);die;								
					$relevant_classes = array();$relevant_subject = array();
					
					$insertId = $this->base_model->insert('courses', $update_array);
					// echo $insertId ;die;
					for($i = 0; $i <= $class_counts; $i++){
						if($this->input->post('relevant_classes_'.$i) != ''){
							$relevant_subject = $this->input->post('relevant_subjects'.$this->input->post('relevant_classes_'.$i));
							$class = array('course_id' => $insertId, 'class_id' => $this->input->post('relevant_classes_'.$i), 'created' => $date);	
							$this->base_model->insert('relevant_classes', $class);
							foreach($relevant_subject as $subject){
								$subjects = array('course_id' => $insertId, 'class_id' => $this->input->post('relevant_classes_'.$i), 'subject_id' => $subject, 'created' => $date);	
								$this->base_model->insert('relevant_subjects', $subjects);
							}
						}
					}
					$this->session->set_flashdata('flash_message', $this->lang->line('add_record'));
					redirect(base_url().SITE_ADMIN_URI.'/course_plan/');
				}
			}
				$data['post'] = TRUE;
			}
			$data['relevant_class'] = $this->base_model->getSelectList('classes');
			$data['relevant_subject'] = $this->base_model->getSelectList('subjects');
			$data['main_content'] = 'course_plan/add';
			$data['page_title']  = 'Course Plan'; 
			$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}
		
		public function edit($id = NULL)
		{
			
				$data['post'] = FALSE;
				$join_tables = $where = array(); 
				$where[] = array( TRUE, 'id', $id);
				$fields = 'name'; 
				$getValues = $this->base_model->get_advance_list('courses', $join_tables, $fields, $where, 'row_array');
				if ($this->input->server('REQUEST_METHOD') === 'POST')
				{ 					
					if($this->input->post('name') != $getValues['name']) {
					$arr=" course_category_id";
					$is_unique =  '|is_unique[courses.name.'.$arr.']' ;
					} else {
						$is_unique =  '' ;
					}
					$this->form_validation->set_rules('name', 'Name', 'trim|required'.$is_unique);					
				    $this->form_validation->set_rules('description', 'description','trim|required|max_length[200]');
				 	 	if($this->input->post('price')==""){ 
					 		$this->form_validation->set_rules('price', 'price','trim|numeric|callback_validate_select[price]');
					 	}
					 	if($this->input->post('price')!=""){	
							$this->form_validation->set_rules('price','price (INR)','trim|numeric');
						}
					$this->form_validation->set_rules('duration', 'Duration','trim|required');
					if($this->input->post('duration') == 0)
					{
					$this->form_validation->set_message('no_zero_duration', 'The duration field must be greater than zero.'); //modified
					$this->form_validation->set_rules('duration','duration','trim|required|numeric|no_zero_duration');
					}
					if($this->input->post('price') == "0") //modified
					{
					$this->form_validation->set_message('no_zero', 'The price (INR) field must be greater than zero.');
					$this->form_validation->set_rules('price','price','trim|numeric|no_zero');
					}
					$class_counts = $this->input->post('class_counts');
					$this->form_validation->set_rules("relevant_classes_0", 'relevant classes','trim|callback_validate_select[relevant classes]');
					for($i = 1; $i <= $class_counts; $i++){	
						if($this->input->post('relevant_classes_'.$i) == ''){
							$this->form_validation->set_rules("relevant_classes_".$i, 'relevant classes','trim|callback_validate_select[relevant classes]');
						}
					}
					
				if ($this->form_validation->run())
				{   						
						$date = date('Y-m-d H:i:s');
						if ($_FILES['image']['name'] != "") {
						$config['upload_path'] = $this->config->item('course_plans');
		            	$config['allowed_types'] = "gif|jpg|jpeg|png";
					 	$config['min_width'] = "195"; 
		                $config['min_height'] = "195";  
			            $this->load->library('upload', $config);
			            $image_up = $this->upload->do_upload('image');
				            if (!$image_up)
				    		{
								$upload = array('error' => $this->upload->display_errors());
							   	$data['upload_error'] = $upload;
							}
							else
							{
								$image_data = array('upload_data' => $this->upload->data());
								$update_array = array ('name' => $this->input->post('name'),
											   'description' => $this->input->post('description'),
											   'currency_type' => 1,
											   'price' => $this->input->post('price'),
										  	   'image' => $image_data['upload_data']['file_name'],
											   'duration' => $this->input->post('duration'),
											   'modified' => $date
											   );	
							}
						}else{
						$update_array = array ('name' => $this->input->post('name'),
											   'description' => $this->input->post('description'),
											   'currency_type' => 1,
											   'price' => $this->input->post('price'),
										  		// 'image' => $image,
											   'duration' => $this->input->post('duration'),
											   'modified' => $date
											   );	
						}						   
						$this->base_model->update ( 'courses', $update_array, array('id'=>$id));
						$this->base_model->delete ( 'relevant_classes', array('course_id'=>$id));
						$this->base_model->delete ( 'relevant_subjects', array('course_id'=>$id));
						$relevant_classes = array();$relevant_subject = array();
						for($i = 0; $i <= $class_counts; $i++){
							if($this->input->post('relevant_classes_'.$i) != ''){
								$relevant_subject = $this->input->post('relevant_subjects'.$this->input->post('relevant_classes_'.$i));
								$class = array('course_id' => $id, 'class_id' => $this->input->post('relevant_classes_'.$i), 'modified' => $date);	
								$this->base_model->insert('relevant_classes', $class);
								foreach($relevant_subject as $subject){
									$subjects = array('course_id' => $id, 'class_id' => $this->input->post('relevant_classes_'.$i), 'subject_id' => $subject, 'modified' => $date);	
									$this->base_model->insert('relevant_subjects', $subjects);
								}
							}
						}
						
						$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
						redirect(base_url().SITE_ADMIN_URI.'/course_plan/');
					}
					$data['post'] = TRUE;
				}				
				$join_tables = $where = array();  $fields = 'co.id, co.name, co.image, co.description, co.price, co.duration,co.status'; 
			  	$where[] = array( TRUE, 'co.id', $id);
			  	$data['courses'] = $this->base_model->get_advance_list('courses as co', $join_tables, $fields, $where, 'row_array');
			  	$classes_selected = $this->base_model->getCommonListFields('relevant_classes as rc', array('rc.class_id'),array('rc.course_id' => $id));
			  	foreach($classes_selected as $class){
			  		$data['classes_selected'][] = $class->class_id;
			  		$subject_selected = $this->base_model->getCommonListFields('relevant_subjects', array('subject_id'),array('course_id' => $id, 'class_id' => $class->class_id));
			  		
					foreach($subject_selected as $subject){
				  		$data['subject_selected'][$class->class_id][] = $subject->subject_id;
				  	}}
			  	$join_tables = $where = array();  
			  	$fields = ' '; 
			  	$where[] = array( TRUE, 'co.id', $id);
			  	// $data['course_cat'] = $this->base_model->get_advance_list('courses as co', $join_tables, $fields, $where, 'row_array');
			  	$chap_count = $this->classes_model->rm_count($id);
		  		foreach($chap_count as $chap){
			  		$data['chap'][] = $chap['class_id'];
			  	}
			    $data['relevant_class'] = $this->base_model->getSelectList('classes');
				$data['relevant_subject'] = $this->base_model->getSelectList('subjects');
				$data['main_content'] = 'course_plan/edit';
			  	$data['page_title']  = 'Course Plan'; 
			  	// echo validation_errors(); die;
			  	// print_r($data);die;
			  	$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
		}

	public function delete($id,$pageredirect=null,$pageno) {
		$test_details = check_delete($id,7);
		if($test_details["is_delete"]==0){
			$this->base_model->delete ('courses',array('id' => $id));
			$this->base_model->delete ( 'relevant_classes', array('course_id'=>$id));
			$this->base_model->delete ( 'relevant_subjects', array('course_id'=>$id));
			$this->session->set_flashdata('flash_message', $this->lang->line('delete_record') );
			redirect(base_url().SITE_ADMIN_URI.'/course_plan/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		else
		{
			redirect(base_url().SITE_ADMIN_URI.'/course_plan/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	function update_status($id,$status,$pageredirect,$pageno)
	{
		$table_name = 'courses';
		change_status($table_name,$id,$status,$pageredirect,$pageno);
		$this->session->set_flashdata('flash_message', $this->lang->line('update_record'));
		redirect(base_url().SITE_ADMIN_URI.'/course_plan/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	// public function get_count(){
	// 	$course_id = $this->input->post('course_id');
	// 	$where = array();
	// 	$where[] = array( TRUE,"course_category_id",$course_id);
	// 	$fields = 'order_by_category';	
	//   	$return_data = $this->base_model->get_advance_list('courses', '', $fields, $where, 'row_array', 'order_by_category', 'desc', '', '1');
	//   	if(count($return_data)>0){
	//   		$count = $return_data["order_by_category"] + 1;
	//   	}else{
	//   		$count = 1;
	//   	}
	// 	echo $count;
	// }	
}
