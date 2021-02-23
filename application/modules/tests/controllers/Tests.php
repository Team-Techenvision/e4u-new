<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends MX_Controller
{
  	function __construct()
	{
		parent::__construct();
		$this->load->model(array('tests_model','dashboard/dashboard_model','subjective/subjective_model','leaderboard/leaderboard_model')); 
		$this->load->library('form_validation');
		$this->load->language(array('flash_message','form_validation'), 'english');		
		$this->load->helper(array("surprise_test_helper", "function_helper"));
		if(!$this->session->has_userdata('user_is_logged_in'))
		{
			redirect(base_url());
		} 
		$user_details = $this->session->userdata('user_is_logged_in', 'user_id');	
		$result = is_user_active($user_details["user_id"]);		
		if($result["status"]==0){
			redirect(base_url()."home/logout");
		}
		// if($_SERVER['HTTP_REFERER']=="")
		// {			
		// 	redirect(base_url()."dashboard");
		// }
		$this->load->helper("profile_helper");
		compare_session();
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		 
	}
	public function index(){
		$data['main_content'] = 'tests/index';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
	}
	public function chapters($course_id='',$class_id='',$subject_id='')
	{
		if (isset($_COOKIE['seconds'])) {
			setcookie('seconds', null, -1);
		}
		$user_arr=$this->session->userdata('user_is_logged_in');
		$selected_course  = $course_id;
		if($selected_course !='')		//set session for course
		{
			$this->session->set_userdata('selected_course', $selected_course); 
		}
		if($this->session->userdata('selected_course') != ''){
			$relevant_class=$this->tests_model->relevant_classes($selected_course);
		}
	    	$selected_class  = $class_id; 
		if($class_id !=''&&$class_id !="blank.html")		//set session for class
		{
		 $this->session->set_userdata('selected_class', $selected_class); 
		
		}
		$key = $subject_id;
		$relevant_subject=$this->tests_model->relevant_subjects($course_id,$class_id);
		$keys = array_keys($relevant_subject);
		if($key != '')
		{
			$data['current_subject'] = $key;
			$chapter_list=$this->tests_model->chapter_list($course_id,$class_id,$key);
		}
		else
		{
			$data['current_subject'] = $keys[0];
			$chapter_list=$this->tests_model->chapter_list($course_id,$class_id,$keys[0]);
		}
		$cat_count = $this->subjective_model->category_list($course_id,$class_id);
		
		$category_list = $this->subjective_model->all_category();
		$data['cat_count'] = $cat_count;	
		$val_cat = array_keys($category_list);
		$data['category_id'] = $val_cat[1];
		$data['type'] = $this->subjective_model->is_subjective($course_id);
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$selected_course_class = $this->dashboard_model->get_paid_courses_class($selected_course,"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$selected_course_class;
		$data['course'] = $course_id;
		$data['class'] = $class_id;
		$data['chapter_list'] = $chapter_list;
		$data['subjects'] = $relevant_subject;
		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		$data['main_content'] = 'tests/chapters';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
	}
	
	public function levels($subject_id="",$chapter_id="")
	{
		 
		$user_arr=$this->session->userdata('user_is_logged_in');
		$session_course = $this->session->userdata('selected_course'); 
		$session_class = $this->session->userdata('selected_class'); 
		if($session_course != '')
		{
			$relevant_class=$this->tests_model->relevant_classes($session_course);
		}
		$data['current_subject'] = $subject_id;
		$relevant_subject=$this->tests_model->relevant_subjects($session_course,$session_class);
		$data['selected_subject']=$this->tests_model->subject($subject_id);
		$data['selected_chapter']=$this->tests_model->chapter($chapter_id);
		$level_list=$this->tests_model->level_list($session_course,$session_class,$subject_id,$chapter_id);
		$category_list = $this->subjective_model->all_category();
		$val_cat = array_keys($category_list);
		$cat_count = $this->subjective_model->category_list($course_id,$class_id);
		$data['cat_count'] = $cat_count;
		$data['category_id'] = $val_cat[1];
		$data['type'] = $this->subjective_model->is_subjective($session_course);
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$selected_course_class = $this->dashboard_model->get_paid_courses_class($session_course,"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$selected_course_class;
		$data['course'] = $session_course;
		$data['class'] = $session_class;
		$data['chapter'] = $chapter_id;
		$data['level_list'] = $level_list;
		$data['subjects'] = $relevant_subject;
		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		
		#check practise test completed#
		$i=0;
		foreach($level_list as $key=>$value){
			$data['level_lists'][$i]['name'] = $value['name'];
			$data['level_lists'][$i]['description'] = $value['description'];
			$data['level_lists'][$i]['id'] = $value['id'];
			$data['level_lists'][$i]['level_completed'] = 0;
			$data['level_lists'][$i]['progress_completed'] = 0;
			$level_completed = $this->tests_model->check_level_completed($user_arr["user_id"],$session_course,$session_class,$subject_id,$chapter_id,$value['id']);
			  $progress_completed = $this->tests_model->check_progress_completed($user_arr["user_id"],$session_course,$session_class,$subject_id,$chapter_id);
			  $has_progress = $this->tests_model->has_progress($user_arr["user_id"],$session_course,$session_class,$subject_id,$chapter_id,$value['id']);
			  $param = array('course_id'=>$session_course,
			  				 'class_id'=>$session_class,
			  				 'subject_id'=>$subject_id,
			  				 'chapter_id'=>$chapter_id,
			  				 'level_id'=>$value['id'],
			  				 'user_id'=>$user_arr["user_id"]
			  				 );
			if(!empty($level_completed)){
				$data['level_lists'][$i]['level_completed'] = 1;
			}
			
			if($progress_completed > 0){
				 $data['level_lists'][$i]['progress_completed'] = 1;
			}
			else
			{
				$data['level_lists'][$i]['progress_completed'] = 0;
			}
			if($has_progress > 0)
			{
				$data['level_lists'][$i]['has_progress'] = 1;
			}
			$progress_completed_set = $this->tests_model->progress_completed_set($user_arr["user_id"],$value['id']);
		 	$data['level_lists'][$i]['new_set'] = $this->tests_model->check_new_set($param,$progress_completed_set);
			
			$i++;
		}
		$data['main_content'] = 'tests/levels';
		$data['page_title']  = 'e4u';
		$this->load->view(SITE_LAYOUT_PATH, $data);
	}
	public function sets($subject_id="",$chapter_id="",$level_id="")
	{
		$user_arr=$this->session->userdata('user_is_logged_in');
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		if($session_course != '')
		{
			$relevant_class=$this->tests_model->relevant_classes($session_course);
		}
		$data['current_subject'] = $subject_id;
		$relevant_subject=$this->tests_model->relevant_subjects($session_course,$session_class);
		$data['selected_subject']=$this->tests_model->subject($subject_id);
		$data['selected_chapter']=$this->tests_model->chapter($chapter_id);
		$data['selected_level']=$this->tests_model->level($level_id);
		$set_list=$this->tests_model->set_list($session_course,$session_class,$subject_id,$chapter_id,$level_id);
		$completed_set=$this->tests_model->completed_set_list($user_arr["user_id"]);
		$category_list=$this->subjective_model->category_select_list($session_course,$session_class,"","","select");
		$val_cat = array_keys($category_list);
		$cat_count = $this->subjective_model->category_list($course_id,$class_id);
		$data['cat_count'] = $cat_count;
		$data['category_id'] = $val_cat[1];
		$data['type'] = $this->subjective_model->is_subjective($session_course);
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$selected_course_class = $this->dashboard_model->get_paid_courses_class($session_course,"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$selected_course_class;
		$data['course'] = $session_course;
		$data['class'] = $session_class;
		$data['chapter'] = $chapter_id;
		$data['level'] = $level_id;
		$data['set_list'] = $set_list;
		$data['completed_set'] = $completed_set;
		$data['subjects'] = $relevant_subject;
		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		
		$data['main_content'] = 'tests/sets';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
	}
	public function get_downloads($class,$subject)
	{
		$user_arr=$this->session->userdata('user_is_logged_in');	
	  	$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$data["data_course"]=$course_paid;
		$attachment=$this->tests_model->get_materials(0,$class,$subject);
		$data["attachments"]=$attachment;
		$data["path"]=$this->config->item("download_materials");
		$data["class"]=$class;
		$data["subject"]=$subject;
		$data["course"]=0;
		$this->load->view("downloads", $data);
	}
	
	public function download_file($file_name=""){
		$this->load->helper('download');
		$data = file_get_contents($this->config->item("download_materials").$file_name); // Read the file's contents
		$name = $file_name;
		force_download($name, $data);
	}	
	
	public function upload_course($course,$subject,$class){
		$this->load->model('base_model');
		if ($this->input->server('REQUEST_METHOD') === 'POST'){   
		
			$this->form_validation->set_rules('download_name', 'title','trim|required');
			$this->form_validation->set_rules('comments', 'comments','trim|required');
			if ($_FILES['attachment']['name'][0] == "") {
                $this->form_validation->set_rules('attachment', 'attachment', 'required');
            }
           
			if($this->form_validation->run() == false){  
				echo $this->form_validation->get_json(); die;
			}else{	 
				
				$files = $_FILES;
				$cpt = count($_FILES['attachment']['name']);
				$ext = array('pdf','doc','mp3','mp4','rar','docx','zip','swf');
				for($j=0; $j<$cpt; $j++)
        		{
        			$attach = end(explode(".",$files['attachment']['name'][$j]));
        			if(!in_array($attach,$ext)){
        				$upload = array('error' => 'The filetype you are attempting to upload is not allowed.');
					   	$data['upload_error'][$j] = $upload;
        			}
        		}
        		if(!isset($data['upload_error'])){
					for($i=0; $i<$cpt; $i++)
		    		{
		    			$date = date('Y-m-d H:i:s');
		    			$_FILES['userfile']['name']= $files['attachment']['name'][$i];
		    			$_FILES['userfile']['type']= $files['attachment']['type'][$i];
						$_FILES['userfile']['tmp_name']= $files['attachment']['tmp_name'][$i];
						$_FILES['userfile']['error']= $files['attachment']['error'][$i];
						$_FILES['userfile']['size']= $files['attachment']['size'][$i];
						
						$config['upload_path'] = $this->config->item('attachments');
						$config['allowed_types'] = "pdf|doc|mp3|mp4|rar|docx|zip|swf"; 
						$config['max_size'] = '2048';
						$this->load->library('upload', $config);
						
						$this->upload->initialize($config);
						$image_up = $this->upload->do_upload();
						
				  	
						if (!$image_up)
						{
							$upload = array('error' => $this->upload->display_errors());
						   	$data['upload_errors'][$i] = $upload;
						 
						}else{
							$image_data = array('upload_data' => $this->upload->data());
							$upload_name1[] = $image_data['upload_data']['file_name'];


						}
					}
				}else{
				   	$upload = array('field' => 'attachment', 'error' => 'The filetype you are attempting to upload is not allowed.');
		   			echo json_encode(array('status' => 'error','errorfields' => array($upload))); die;
				}
				if(!isset($data['upload_errors']) && isset($upload_name1)){
					foreach($upload_name1 as $key => $val){
						
						$data_update=$this->session->userdata('user_is_logged_in');
						$id= $data_update["user_id"];
					
						$attachment_data = array('upload_data' => $this->upload->data());
						$update_array = array();
						$update_array = array ('course_id' => $course, 
											   'class_id' => $class, 
											   'subject_id' => $subject, 
											   'download_name' => $this->input->post('download_name'), 
											   'comments' => $this->input->post('comments'), 
											   'attachment' => $val,
											   'uploaded_by' => 1,
											   'status' => 0,
											   'created' => $date,
											   'user_id' => $id,
											   );
											   
					
						$insertId = $this->base_model->insert('downloads', $update_array);
						
					} 
					if($insertId){
						echo json_encode(array('status' => 'success')); die;
					}
				}else{
					
					$upload = array('field' => 'attachment', 'error' => strip_tags($this->upload->display_errors()));
			   		echo json_encode(array('status' => 'error','errorfields' => array($upload))); die;
				}
			}
		}
		$data["course_id"]=$course;
		$data["class_id"]=$class;
		$data["subject_id"]=$subject;
		$this->load->view("upload-form", $data);
	}
	public function materials_list($course_id="0",$class,$subject)
	{
		$attachment=$this->tests_model->get_materials($course_id,$class,$subject);
		$data["attachments"]=$attachment;
		$data["path"]=$this->config->item("download_materials");
		$data["class"]=$class;
		$data["subject"]=$subject;
		$data["course"]=$course_id;
		$this->load->view("materials-list", $data);
	}
	public function practice_detail($test_random_id="",$start="0",$status="",$page_num=1)
	{
		$progress_session = $this->session->userdata('progress_session');
		if($progress_session == 1&&$status==1)
		{
			$this->session->unset_userdata('progress_session');
			redirect(base_url().'dashboard');
		}
		$data['uri'] = $this->uri->segment(4);
		$data['submit_status'] = $status;
		$user_arr=$this->session->userdata('user_is_logged_in');
		$data['test_random_id'] = $test_random_id;
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		$test_info = $this->tests_model->get_test_details($test_random_id);
		$testid = $test_info[0]['id'];
		$subject_id = $test_info[0]['subject_id'];
		$chapter_id = $test_info[0]['chapter_id'];
		$data['test_id'] = $testid;
		$data['result'] = $test_info[0]['result'];
		$test_status = $test_info[0]['status'];
		if($test_status==1 && $status==""){
			redirect(base_url().'tests/chapters/'.$session_course.'/'.$session_class);
		}
		$param = array('course_id'=> $session_course,
					   'class_id' => $session_class,
					   'subject_id' => $subject_id,
					   'chapter_id' => $chapter_id,
					   'user_id' => $user_arr["user_id"],
				      );
		$data['current_subject'] = $subject_id;
		$data['chapter'] = $chapter_id;
		$data['selected_subject']=$this->tests_model->subject($subject_id);
		$data['selected_chapter']=$this->tests_model->chapter($chapter_id);
		$data['overall_percent']=$this->tests_model->overall_percent($param,'','','');
		// echo $start;die;
		if($status==1){

		/////////////
		$this->load->library('pagination');
		$config = $this->config->item('pagination_ans');
	  	$config["base_url"]    = base_url()."/tests/practice_detail/".$test_random_id."/0/1";
	 	$data["per_page"] = $config["per_page"] = $this->config->item('materials', 'page_per_limit_ans'); 
	  	$config["uri_segment"] = 6;
	  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
	  	$limit_start = $config['per_page'];	
	  	$data['total_rows'] = $config['total_rows'] = count($this->tests_model->questions($testid));
		$this->pagination->initialize($config);		
		$data["page"]=$page_num;		
		$data["links"] = $this->pagination->create_links();
		////////////
				$data['questions'] = $this->tests_model->questions($testid,$limit_end,$limit_start);
		}else{
				$data['questions'] = $this->tests_model->questions($testid,$start);
		}
		// print_r($data['questions']);die;
		$data['next'] = $start+1;
		$data['previous'] = $start-1;
		$data['count'] = $this->tests_model->question_count($testid);
		$data['user_marks'] = $this->tests_model->user_marks($testid,$data['count']);
		$data['pass_percentage'] = $this->tests_model->pass_percentage($testid);
		$data['answered'] = $this->tests_model->answered($testid,1);
		$data['not_answered'] = $this->tests_model->answered($testid,"0");
		$data['count_correct'] = $this->tests_model->count_correct($testid,1);
		$data['count_wrong'] = $this->tests_model->count_correct($testid,"0");
		$data['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
		$data['serial_number'] = $this->tests_model->serial_number($testid,$start);
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$selected_course_class = $this->dashboard_model->get_paid_courses_class($session_course,"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$selected_course_class;
		$data['course'] = $session_course;
		$data['course_id'] = $session_course;
		$data['class'] = $session_class;
		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		$data['main_content'] = 'tests/practice_detail';
		$data['page_title']  = 'e4u'; 
		$course_id = $session_course;
		$data['not_answered'] = $this->not_answered_custom($test_random_id,$course_id,($start+1),0); //0->practice, 1->create_test, 2->standard test
// echo "<pre>";print_r($data);die;

		$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
	}
	public function answer_details($type="")
	{
		$user_arr=$this->session->userdata('user_is_logged_in');
		$question_id = $this->input->post('ques_id');
		$option_selected = $this->input->post('option_selected');
		$data['answer'] = $this->tests_model->answer_detail($question_id);
		$test_id = $this->input->post('test_id');
		if($type == "surprise"){
			$data['save_answer'] = $this->tests_model->surprise_correct($question_id,$test_id,$option_selected);
		}else{
			$data['save_answer'] = $this->tests_model->is_correct($question_id,$test_id,$option_selected);
		}
		// echo json_encode($data);
		echo '1';
	}
	// public function standard_detail_submit()
	// {
	// 	$test_random_id = $this->input->post('test_random_id');
	// 	$test_info = $this->tests_model->get_test_details($test_random_id);
	// 	$user_arr=$this->session->userdata('user_is_logged_in');
	// 	$is_complate = array('status' => 1);
	// 	$this->db->where("surprise_test_id", $test_info[0]['surprise_test_id']);
	// 	$this->db->where("user_id", $user_arr['user_id']);
	// 	$this->db->where("exam_code", $test_random_id );
	// 	$this->db->update("test_engagement", $is_complate);
	//     echo "1";
	// }
	public function answer_description($question_id="",$option_selected="",$type="")
	{
		if(!$this->session->has_userdata('user_is_logged_in'))
		{
			redirect(base_url());
		} 
		else
		{
			$data['option_selected'] = $option_selected;
			$data['test_type'] = $type;
			if($type==2){
				$data['answer_description'] = $this->tests_model->surprise_answer_detail($question_id);
			}else{
				$data['answer_description'] = $this->tests_model->answer_detail($question_id);
			}
			$this->load->view('tests/answerdescription-popup',$data);
		}
	}
	public function not_answered($test_random_id="",$course_id="",$serial_no="",$type="")
	{
		$test_info = $this->tests_model->get_test_details($test_random_id);
		$testid = $test_info[0]['id'];
		$data['test_random_id'] = $test_random_id;
		$data['serial_no'] = $serial_no;
		if($course_id != "" && $type!= ""){
			$data['type'] = $type;
			$data['course_id'] = $course_id;
		}
		$data['not_answered'] = $this->tests_model->not_answered($testid,"0");
		$this->load->view('tests/not_answered',$data);
	}
	public function start_test($subject_id="",$chapter_id="",$severity="")
	{
		// echo $severity;die;

		setcookie('seconds', null, -1, '/');
		$user_arr=$this->session->userdata('user_is_logged_in');
		// $session_course = $this->session->userdata('selected_course');
		// $session_class = $this->session->userdata('selected_class');
		// get course and class start
			$join_tables= array();
			$fields = 'class_id, free_trial_expiry_date ';
			$where[] = array(TRUE,'u.id',$user_arr["user_id"]);  
			$user_class_id = $this->base_model->get_advance_list('users as u', $join_tables,$fields, $where, 'row', '', '', array('u.id'));
			$class_id = $user_class_id->class_id;
			$course = $this->dashboard_model->get_paid_course($user_arr["user_id"]);		 
			if(count($course) > 0){
				$d_course_id = $course['id'];
			}else{
				$course_fields = 'id,name,image,short_description, description,currency_type,price,duration';
				$where_course[] = array(FALSE,'status = 1');
				$courses = $this->base_model->get_advance_list('courses', '', $course_fields, $where_course, '', 'id', '', '', '3', '');
				foreach($courses as $key=>$value)
				{
					$course_ids[] = $value['id'];
				}
				$course_relevant_classes = $this->home_model->course_relevant_classes($course_ids);
				foreach($course_relevant_classes as $course_id => $value)
				{
					foreach($value as $key => $value){
						if($value == $class_id){
							$get_course_id = $course_id;
							break;
						}
					}
				}
				$d_course_id = $get_course_id;
			}
			$this->session->set_userdata('selected_course',$d_course_id);
			$this->session->set_userdata('selected_class',$class_id);
			$session_course = $this->session->userdata('selected_course');
			$session_class = $this->session->userdata('selected_class');
		//get course and class end
		if($session_course != '')
		{
			$relevant_class=$this->tests_model->relevant_classes($session_course);
		}
		$test_arr = array('session_course'=> $session_course,
						  'session_class' => $session_class,
					      'subject_id' => $subject_id,
					      'chapter_id' => $chapter_id,
					      );
		$resume_status = $this->tests_model->resume_status($test_arr,$user_arr["user_id"]);
		if($resume_status[0] != 0)
		{
			$test_random_id = $resume_status[1]['exam_code'];
			redirect(base_url().'tests/practice_detail/'.$test_random_id.'/'.'0');
		}else{
			$test_random_id = rand(0,10000);
			$test_id = $this->tests_model->test_manage($user_arr["user_id"],$test_random_id,$test_arr,'',0);
			$test_details = $this->tests_model->test_details($test_id,$test_arr,$severity);
			$exam_code = $this->tests_model->get_exam_code($test_id);
			redirect(base_url().'tests/practice_detail/'.$exam_code['exam_code']);
		}
	}
	public function start_progress_test()
	{
		$user_arr=$this->session->userdata('user_is_logged_in');
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		$this->session->unset_userdata('timer_duration');
		$subj_chap = json_decode($this->input->post('chapters_list'));
		$temp= array();
		foreach($subj_chap as $arr){
			foreach($arr as $key => $value){
				$temp[$key].= $value.',';
			}
		}
		$test_arr = array('session_course'=> $session_course,
						  'session_class' => $session_class,
					      ); 
		$test_random_id = rand(0,10000);
		$test_id = $this->tests_model->test_manage($user_arr["user_id"],$test_random_id,$test_arr,'',1); //test_type =>1 create test
		foreach($temp as $subject => $chapters){
			 $this->tests_model->create_tests($test_id,$subject,$chapters);	
		}
		$progress_test_details = $this->tests_model->progress_test_details($test_id,$test_arr,$user_arr['user_id']);
		$exam_code = $this->tests_model->get_exam_code($test_id);
		$data['exam_code'] = $exam_code['exam_code'];
		echo json_encode($data);
	}
	public function get_sub_wise_qns(){
		$subject_id = $this->input->post('sub_id');
		$test_id = $this->input->post('test_id');
		$data['serial_number'] = $this->tests_model->get_sub_wise_qn($subject_id,$test_id);
		echo json_encode($data);
	}
	public function progress_detail($test_random_id="",$start="0",$status="",$page_num=1)
	{
		$test_info = $this->tests_model->get_test_details($test_random_id);
		$testid = $test_info[0]['id'];
		if($status == 1)
		{
			$this->session->unset_userdata('progress_session');
			$this->session->unset_userdata('timer_duration');
		/////////////
		$this->load->library('pagination');
		$config = $this->config->item('pagination_ans');
	  	$config["base_url"]    = base_url()."/tests/progress_detail/".$test_random_id."/0/1";
	 	$data["per_page"] = $config["per_page"] = $this->config->item('materials', 'page_per_limit_ans'); 
	  	$config["uri_segment"] = 6;
	  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
	  	$limit_start = $config['per_page'];	
	  	$data['total_rows'] = $config['total_rows'] = count($this->tests_model->questions($testid));
		$this->pagination->initialize($config);		
		$data["page"]=$page_num;		
		$data["links"] = $this->pagination->create_links();
		////////////
				$data['questions'] = $this->tests_model->questions($testid,$limit_end,$limit_start);
		}else{
				$data['questions'] = $this->tests_model->questions($testid,$start);
				$data['subject_name'] = $this->tests_model->subject($data['questions']['subject_id']);

		}
		// echo $this->db->last_query();die;
		$data['uri'] = $this->uri->segment(4);
		$data['submit_status'] = $status;
		$user_arr=$this->session->userdata('user_is_logged_in');
		$data['test_random_id'] = $test_random_id;
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		if($session_course != '')
		{
			$relevant_class=$this->tests_model->relevant_classes($session_course);
		}
		$test_info = $this->tests_model->get_test_details($test_random_id);
		$testid = $test_info[0]['id'];
		$create_tests = $this->tests_model->get_create_test_subjects($testid);
		// print_r($create_tests);
		foreach($create_tests as $key => $c_test){
				$subjects = $this->tests_model->subject($c_test['subject_id']);
				$sel_subj_chap[$key]['subject_id'] = ucfirst($subjects["id"]);
				$sel_subj_chap[$key]['subject_name'] = ucfirst($subjects["name"]);
				$chap_list = explode(',', $c_test['chapter_id']);
				$chapters = $this->tests_model->chapters_ct($chap_list);
			foreach($chapters as $chapter){
				$sel_subj_chap[$key]['chapters_name'][] = ucfirst($chapter["name"]);
			}
			// $subj[$key]['chapters_name'] = ucfirst($subjects["name"]);
		}
		// $subject_id = $create_tests[0]['subject_id'];
		// $chapter_id = $create_tests[0]['chapter_id'];
		$data['is_completed'] = $test_info[0]['status'];
		$data['result'] = $test_info[0]['result'];
		$data['test_id'] = $testid;
		$test_status = $test_info[0]['status'];
		if($test_status==1 && $status==""){
			// redirect(base_url().'tests/chapters/'.$session_course.'/'.$session_class);
		} 
		$data['current_subject'] = $subject_id;
		$data['chapter'] = $chapter_id;
		$data['selected_subject'] = $sel_subj_chap; //$this->tests_model->subject($subject_id);
		// $data['selected_chapter'] = $chapter_id; //$this->tests_model->chapter($chapter_id);
		$data['course_name']=$this->tests_model->course_name($session_course);
		// $data['questions'] = $this->tests_model->questions($testid,$start);
		$data['next'] = $start+1;
		$data['previous'] = $start-1;
		$data['count'] = $this->tests_model->question_count($testid);
		$data['answered'] = $this->tests_model->answered($testid,1);
		// $data['not_answered'] = $this->tests_model->answered($testid,"0");
		$data['count_correct'] = $this->tests_model->count_correct($testid,1);
		$data['count_wrong'] = $this->tests_model->count_correct($testid,"0");
		$data['user_marks'] = $this->tests_model->user_marks($testid,$data['count']);
		$data['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
		$data['serial_number'] = $this->tests_model->serial_number($testid,$start);
		$data['user_id'] = $user_arr["user_id"];
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$selected_course_class = $this->dashboard_model->get_paid_courses_class($session_course,"select");
		$data['course'] = $session_course;
		$data['class'] = $session_class;
		$data['option_selected'] = '';
		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		$data['main_content'] = 'tests/progress_detail';
		$data['page_title']  = 'e4u'; 
		$data['not_answered'] = $this->not_answered_custom($test_random_id,$session_course,($start+1),0);
		// echo "<pre>";print_r($data);die;
		$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
	}
	public function submit_progress_test($test_random_id="")
	{
		$user_arr=$this->session->userdata('user_is_logged_in');
				  
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{  
			$exam_code = $this->input->post('test_random_id');
		}else if($test_random_id!=""){
			$exam_code = $test_random_id;
		}
		
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		$test_info = $this->tests_model->get_test_details($exam_code);
		$testid = $test_info[0]['id'];
		
	
		$param = array('course_id'=> $session_course,
					   'class_id' => $session_class,
					   // 'subject_id' => $subject_id,
					   // 'chapter_id' => $chapter_id,
					   // 'level_id' => $level_id,
					   // 'set_id' => $set_id,
					   'user_id' => $user_arr["user_id"],
					  );
					  
	   // $progress_completed = $this->tests_model->check_progress_completed($user_arr["user_id"],$session_course,$session_class,$subject_id,$chapter_id);
	   // if($progress_completed>0){
		  //  redirect(base_url()."dashboard");
	   // }
		$data['count'] = $this->tests_model->question_count($testid);
		$data['user_marks'] = $this->tests_model->user_marks($testid,$data['count']);
		$data['submit'] = $this->tests_model->submit_test($user_arr["user_id"],$exam_code,$data['user_marks']);
		$percentage = $this->tests_model->pass_percentage($testid);
		// $total_levels = $this->tests_model->total_levels($session_course,$session_class,$subject_id,$chapter_id);
		// $completed_levels = $this->tests_model->completed_levels_in_chap($session_course,$session_class,$subject_id,$chapter_id,$user_arr["user_id"]);
		// if($total_levels == $completed_levels)
		// {
		// 	// $chapter_completed = $this->tests_model->chapter_completed($session_course,$session_class,$subject_id,$chapter_id,$user_arr["user_id"]);
		// }
		if($data['submit']=="1"){$data['user_id'] = $user_arr["user_id"];
		// 	$data['certificate'] = $this->tests_model->certificate($param,$testid,$data['user_marks'],$percentage['pass_percent'],1);
		// 	if($data['certificate']==1){
		// 	$this->send_certificate($testid);
		// }
		}
		redirect(base_url().'tests/progress_detail/'.$exam_code."/0/1");
	
	}
	public function submit_test()
	{
		$user_arr=$this->session->userdata('user_is_logged_in');
				      
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{  
			$session_course = $this->session->userdata('selected_course');
			$session_class = $this->session->userdata('selected_class');
			$exam_code = $this->input->post('test_random_id');
			$test_info = $this->tests_model->get_test_details($exam_code);
			$testid = $test_info[0]['id'];
			$subject_id = $test_info[0]['subject_id'];
			$chapter_id = $test_info[0]['chapter_id'];
			// $level_id = $test_info[0]['level_id'];
			// $set_id = $test_info[0]['set_id'];
		
			$param = array('course_id'=> $session_course,
						   'class_id' => $session_class,
						   'subject_id' => $subject_id,
						   'chapter_id' => $chapter_id,
						   // 'level_id' => $level_id,
						   // 'user_id' => $user_arr["user_id"],
						  );
			$data['count'] = $this->tests_model->question_count($testid);
			$data['user_marks'] = $this->tests_model->user_marks($testid,$data['count']);
			$data['submit'] = $this->tests_model->submit_test($user_arr["user_id"],$exam_code,$data['user_marks']);
			// $data['set_count']=$this->tests_model->set_count($level_id,$chapter_id);
			// $data['completed_set_count']=$this->tests_model->completed_set_count($param);
			$data['overall_percent']=$this->tests_model->overall_percent($param,'','','');
			// $data['level_completed']=$this->tests_model->level_completed($param,$data['overall_percent'],$data['set_count'],$data['completed_set_count'][1]);
			redirect(base_url().'tests/practice_detail/'.$exam_code."/0/1");
		}
	}
	public function performance_tips($user_id,$exam_code)
	{
		$data['user_id'] = $user_id;
		$data['exam_code'] = $exam_code;
		$data['get_tips'] = $this->tests_model->get_tips($user_id);
		$this->load->view('tests/performance_tips',$data);
	}
	public function submit_performance_tips()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{   
			$this->form_validation->set_rules('title', 'title','trim|required');
			$this->form_validation->set_rules('tips', 'tips','trim|required');
			if($this->form_validation->run() == false){  
				echo $this->form_validation->get_json(); die;
			}else{	 
				$user_id = $this->input->post('user_id');
				$exam_code = $this->input->post('exam_code');
				$tips = $this->input->post('tips');
				$title = $this->input->post('title');
				$update = $this->tests_model->insert_tips($user_id,$tips,$title);
				if($update)
				{
					echo json_encode(array('status' => 'success')); die;
				}
			}
		}
	}
	public function request()
	{
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$subject_id = $this->input->post('subject_id');
		$chapter_id = $this->input->post('chapter_id');
		$level_id = $this->input->post('level_id');
		$data = array();
		$data['set_list'] = array();
		$data['set_list'] = $this->tests_model->set_select_list($course_id,$class_id,$subject_id,$chapter_id,$level_id,"select");
		echo json_encode($data);
	}
	public function view_result($exam_code,$start="0",$type="")
	{
		$data['type'] = $type;
		$data['uri'] = $this->uri->segment(4);
		$user_arr=$this->session->userdata('user_is_logged_in');
		$data['test_random_id'] = $exam_code;
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		if($session_course != '')
		{
			$relevant_class=$this->tests_model->relevant_classes($session_course);
		}
		$test_info = $this->tests_model->get_test_details($exam_code);
		$testid = $test_info[0]['id'];
		$course_id = $test_info[0]['course_id'];
		$subject_id = $test_info[0]['subject_id'];
		$chapter_id = $test_info[0]['chapter_id'];
		$level_id = $test_info[0]['level_id'];
		$set_id = $test_info[0]['set_id'];
		$data['test_id'] = $testid;

		$data['course_id'] = $course_id;
		$data['current_subject'] = $subject_id;
		$data['chapter'] = $chapter_id;
		$data['level'] = $level_id;
		$data['set'] = $set_id;
		$data['selected_subject']=$this->tests_model->subject($subject_id);
		$data['selected_chapter']=$this->tests_model->chapter($chapter_id);
		if($type == 2){
		$data['questions'] = $this->tests_model->surprise_questions($testid,$start);
		}else{
		$data['questions'] = $this->tests_model->questions($testid,$start);
		}
		$data['next'] = $start+1;
		$data['previous'] = $start-1;
		
		$data['count'] = $this->tests_model->question_count($testid);
		$data['answered'] = $this->tests_model->answered($testid,1);
		$data['not_answered'] = $this->tests_model->answered($testid,"0");
		$data['count_correct'] = $this->tests_model->count_correct($testid,1);
		$data['count_wrong'] = $this->tests_model->count_correct($testid,"0");
		$data['user_marks'] = $this->tests_model->user_marks($testid,$data['count']);
		$data['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
		$data['serial_number'] = $this->tests_model->serial_number($testid,$start);
		
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$selected_course_class = $this->dashboard_model->get_paid_courses_class($session_course,"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$selected_course_class;
		$data['course'] = $session_course;
		$data['class'] = $session_class;
		$data['option_selected'] = '';

		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		
		$data['main_content'] = 'tests/view_result';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
	}
	public function surprise($course_id="")
	{
			setcookie('seconds', null, -1, '/');
		  $surprise_test = surprise_test();
		  if($surprise_test==0){
			  redirect(base_url()."dashboard/");
		  }
		$user_arr=$this->session->userdata('user_is_logged_in');
		$user_id = $user_arr['user_id'];
		$data['user_id'] = $user_id;
		$data['course_id']=$course_id;
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		if($session_course != '')
		{
			$relevant_class=$this->tests_model->relevant_classes($session_course);
		}
		$course_paid=$this->dashboard_model->get_paid_course($user_id,"select");
		$selected_course_class = $this->dashboard_model->get_paid_courses_class($session_course,"select");
		$key = $course_id;
		$surprise_test_course = $this->tests_model->surprise_test_course($user_id);

		$keys = array_keys($surprise_test_course); 
		if($key != '')
		{
			$data['current_course'] = $key;
			$surprise_list = $this->tests_model->get_surprise_test($key);
			$surprise_test_completed = $this->tests_model->surprise_test_completed($key,$user_id);
	  	
		}
		else
		{
			$data['current_course'] = $keys[0];
			$surprise_list = $this->tests_model->get_surprise_test($keys[0]);
			$surprise_test_completed = $this->tests_model->surprise_test_completed($keys[0],$user_id);
		}
		$data['surprise_test_course'] = $surprise_test_course;
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$selected_course_class;
		$data['course'] = $session_course;
		$data['class'] = $session_class;
		$data['surprise_test'] = $surprise_list[1];
		$data['surprise_test_completed'] = $surprise_test_completed;
		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		
		$data['main_content'] = 'tests/start_surprise';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
	}
	public function standard_detail($test_random_id="",$course_id="",$start="0",$status="",$page_num=1)
	{
		// from start_standard_test (base_url().'tests/surprise_detail/'.$exam_code['exam_code'].'/'.$course_id);
		$surprise_test = surprise_test();
		if($surprise_test==0){
		  redirect(base_url()."dashboard/");
		}
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		$test_info = $this->tests_model->get_test_details($test_random_id);
		if($session_course != '')
		{
			$relevant_class=$this->tests_model->relevant_classes($session_course);
		}
		$data['course_id'] = $course_id;
		$data['surprise_test']= $this->tests_model->get_surprise_test($course_id,$test_info[0]["surprise_test_id"]);
		$surp_test=$data['surprise_test'][0];		  
			if($this->session->userdata("surp_timer_duration")!="" && $surp_test["duration"]==1){
				$data["different_date"]=$this->session->userdata("surp_timer_duration");
			} 
		 	$data['uri'] = $this->uri->segment(5);
			$data['submit_status'] = $status;
			$user_arr=$this->session->userdata('user_is_logged_in');
			$data['test_random_id'] = $test_random_id;
			$test_info = $this->tests_model->get_test_details($test_random_id);
			$testid = $test_info[0]['id'];
			$data['result'] = $test_info[0]['result'];
			$data['start_date'] = $test_info[0]['start_date'];
			$data['end_date'] = $test_info[0]['end_date'];
			$data['is_completed'] = $test_info[0]['status'];
			$data['test_id'] = $testid;
			$test_status = $test_info[0]['status'];
			if($test_status==1 && $status==""){
				redirect(base_url().'tests/surprise');
			}
			if($status==1){

			/////////////
			$this->load->library('pagination');
			$config = $this->config->item('pagination_ans');
		  	$config["base_url"]    = base_url()."/tests/standard_detail/".$test_random_id."/".$course_id."/0/1";
		 	$data["per_page"] = $config["per_page"] = $this->config->item('materials', 'page_per_limit_ans'); 
		  	$config["uri_segment"] = 7;
		  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		  	$limit_start = $config['per_page'];	
		  	$data['total_rows'] = $config['total_rows'] = count($this->tests_model->surprise_questions($testid));
			$this->pagination->initialize($config);		
			$data["page"]=$page_num;		
			$data["links"] = $this->pagination->create_links();
			////////////
				$data['questions'] = $this->tests_model->surprise_questions($testid,$limit_end,$limit_start);
			}else{
				$data['questions'] = $this->tests_model->surprise_questions($testid,$start);
			}
			 // echo "<pre>";print_r($data['questions']);die;
			$data['next'] = $start+1;
			$data['previous'] = $start-1;
			$data['count'] = $this->tests_model->question_count($testid);
			$data['answered'] = $this->tests_model->answered($testid,1);
			$data['not_answered'] = $this->tests_model->answered($testid,"0");
			$data['count_correct'] = $this->tests_model->count_correct($testid,1);
			$data['count_wrong'] = $this->tests_model->count_correct($testid,"0");
			$data['user_marks'] = $this->tests_model->user_marks($testid,$data['count']);
			$data['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
			$data['serial_number'] = $this->tests_model->serial_number($testid,$start);
			$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
			$selected_course_class = $this->dashboard_model->get_paid_courses_class($session_course,"select");
			$data["data_course"]["course_arr"]=$course_paid;
			$data["data_course"]["class_arr"]=$selected_course_class;
			$data['course'] = $session_course;
			$data['class'] = $session_class;
			$data['option_selected'] = '';
			$ad_page = $this->uri->segment(1);
			$ad_banner = $this->dashboard_model->get_ad($ad_page);
			$data['ad_banner'] = $ad_banner;
			$data['main_content'] = 'tests/surprise_detail';
			$data['page_title']  = 'e4u'; 
			$data['not_answered'] = $this->not_answered_custom($test_random_id,$course_id,($start+1),0);

		// echo "<pre>";print_r($data);die;


		$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
	}
	public function start_standard_test($course_id="",$standard_test_id="")
	{
		$this->session->unset_userdata("surp_timer_duration");	
		$surprise_test = surprise_test(); //1,0 for starter   1,1 for completeds
		if($surprise_test[1]==1){
			  $this->session->set_flashdata('already_completed', 'You have already completed the test.');
			  redirect(base_url()."dashboard/");
		} 
		$user_arr=$this->session->userdata('user_is_logged_in');
		$test_random_id = rand(0,10000);
		$test_id = $this->tests_model->test_manage($user_arr["user_id"],$test_random_id,$course_id,$standard_test_id,2);//0-practise/1-progress/2-surprise	//returns test engagement id
		$surprise_test_details = $this->tests_model->surprise_test_details($test_id,$course_id,$user_arr['user_id'],$standard_test_id);
		$exam_code = $this->tests_model->get_exam_code($test_id);
		//for timer
		$test_info = $this->tests_model->get_test_details($exam_code['exam_code']);
		// print_r($test_info);die;


		$data['surprise_test']= $this->tests_model->get_surprise_test($course_id,$test_info[0]["surprise_test_id"]);
		// print_r($data['surprise_test']);die;
		$surp_test=$data['surprise_test'][0];
		$time =$surp_test['hours'];
		$mins =$surp_test['mins'];
	    $remain_date=date("Y:m:d:H:i:s",strtotime("+".$time."hours"."+".$mins."mins"));
	    // echo $remain_date;die;

		$this->session->set_userdata("surp_timer_duration",$remain_date);	
		redirect(base_url().'tests/standard_detail/'.$exam_code['exam_code'].'/'.$course_id);
	}

	public function not_answered_custom($test_random_id="",$course_id="",$serial_no="",$type="")
	{
		$test_info = $this->tests_model->get_test_details($test_random_id);
		$testid = $test_info[0]['id'];
		$data['test_random_id'] = $test_random_id;
		$data['serial_no'] = $serial_no;
		if($course_id != "" && $type!= ""){
			$data['type'] = $type;
			$data['course_id'] = $course_id;
		}
		return $this->tests_model->not_answered($testid,"0");
		//$this->load->view('tests/not_answered',$data);
	}

	public function submit_surprise_test($test_random_id="",$course_id="")
	{
		// echo "here";die;
		  $surprise_test = surprise_test();
		  if($surprise_test==0){
			  redirect(base_url()."dashboard/");
		  }
		$user_arr=$this->session->userdata('user_is_logged_in');
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{  
			$exam_code = $this->input->post('test_random_id');
			$course_id = $this->input->post('course_id');
			
		}else if($test_random_id!="")
		{
			$exam_code = $test_random_id;
			$course_id = $course_id;
		}		
		$test_info = $this->tests_model->get_test_details($exam_code);
		$testid = $test_info[0]['id'];
	
		$param = array('course_id'=> $course_id,
					   'user_id' => $user_arr["user_id"],
					  );
		$data['count'] = $this->tests_model->question_count($testid);
		
		$data['user_marks'] = $this->tests_model->user_marks($testid,$data['count']);

		
		$data['submit'] = $this->tests_model->submit_test($user_arr["user_id"],$exam_code,$data['user_marks']);
		// $percentage = $this->tests_model->pass_percentage($testid);
		// $data['certificate'] = $this->tests_model->certificate($param,$testid,$data['user_marks']," ",2);
		
		// if($data['certificate']==1){0
		// 	$this->send_certificate($testid);
		// }
		redirect(base_url().'tests/standard_detail/'.$exam_code."/".$course_id."/0/1");
	}
		
		public function send_certificate($test_id){ 
			//generate pdf
			$user_arr=$this->session->userdata('user_is_logged_in');
			$this->load->model('certificates/certificates_model');
			$this->load->model('base_model');
			$data['certificate_details']=$this->certificates_model->get_certificate_details($user_arr["user_id"],$test_id);
			
			//$data = [];
		    //load the view and saved it into $html variable
		      $html=$this->load->view('certificates/certificate', $data, true); 
		    //this the the PDF filename that user will get to download
		   	// $rand = rand(0,100000);
		    $pdfFilePath = "e4u_certificate_".$data['certificate_details']['exam_code'].".pdf";
	 
		    //load mPDF library
		    $this->load->library('m_pdf');
	 
		    //generate the PDF from the given html
		    $this->m_pdf->pdf->WriteHTML($html);
		    //for download.
		    $this->m_pdf->pdf->Output("appdata/pdfs/".$pdfFilePath, "F");  
			
			/* Send email to user */
			// get user details
				$cond_user = array();
				$cond_user[] = array(TRUE, 'id', 7 );  
				$user_email = $data['certificate_details']["email"];
				$user_name =  $data['certificate_details']["first_name"]." ". $data['certificate_details']["last_name"];
				$this->load->library('email');
				$email_config_data = array('[USERNAME]'=> $user_name,  
										   '[SITE_NAME]' => $this->config->item('site_name'),
										   '[SITE_URL]'=>base_url());				
				$cond = array();
				$cond[] = array(TRUE, 'id', 7 ); 
				$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');   
				foreach($email_config_data as $key => $value)
				{
					$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
				}							
				$this->email->from("noreply@e4u.com","e4u");
				$this->email->to($user_email);
				$this->email->subject($mailcontent['subject']);
				$this->email->message($mailcontent['email_content']);
				$this->email->attach('appdata/pdfs/'.$pdfFilePath); 
				$result= $this->email->send();
				@unlink('appdata/pdfs/'.$pdfFilePath);	
			
		}
}
