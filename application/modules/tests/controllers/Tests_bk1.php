<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends MX_Controller
{
  	function __construct()
	{
		parent::__construct();
		$this->load->model(array('tests_model','dashboard/dashboard_model')); 
		$this->load->library('form_validation');
		$this->load->language(array('flash_message','form_validation'), 'english');		
		if(!$this->session->has_userdata('user_is_logged_in'))
		{
			redirect(base_url());
		} 
	}
	public function chapters($course_id='',$class_id='',$subject_id='')
	{
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
		if($selected_class !='')		//set session for class
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
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$relevant_class;
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
		$level_list=$this->tests_model->level_list($subject_id,$chapter_id);
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$relevant_class;
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
			$level_completed = $this->tests_model->check_level_completed($user_arr["user_id"],$session_course,$session_class,$subject_id,$chapter_id,$value['id']);
			if(!empty($level_completed)){
				$data['level_lists'][$i]['level_completed'] = 1;
			}
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
		$set_list=$this->tests_model->set_list($subject_id,$chapter_id,$level_id);
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$relevant_class;
		$data['course'] = $session_course;
		$data['class'] = $session_class;
		$data['chapter'] = $chapter_id;
		$data['level'] = $level_id;
		$data['set_list'] = $set_list;
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
	public function upload_course($course,$subject,$class){
		$this->load->model('base_model');
		if ($this->input->server('REQUEST_METHOD') === 'POST'){   
		
			$this->form_validation->set_rules('download_name', 'field label','trim|required');
			$this->form_validation->set_rules('comments', 'comments','trim|required');
			if ($_FILES['attachment']['name'][0] == "") {
                $this->form_validation->set_rules('attachment', 'Attachment', 'required');
            }
           
			if($this->form_validation->run() == false){  
				echo $this->form_validation->get_json(); die;
			}else{	 
				
				$files = $_FILES;
				$cpt = count($_FILES['attachment']['name']);
				$ext = array('pdf','doc','mp3','mp4','rar','docx');
				for($j=0; $j<$cpt; $j++)
        		{
        			$attach = explode(".",$files['attachment']['name'][$j]);
        			if(!in_array($attach[1],$ext)){
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
						$config['allowed_types'] = "pdf|doc|mp3|mp4|rar|docx"; 
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
	public function practice_detail($test_random_id="",$start="0",$status="")
	{
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
		$subject_id = $test_info[0]['subject_id'];
		$chapter_id = $test_info[0]['chapter_id'];
		$level_id = $test_info[0]['level_id'];
		$set_id = $test_info[0]['set_id'];
		$test_status = $test_info[0]['status'];
		$data['test_id'] = $testid;
		if($test_status==1 && $status==""){
			redirect(base_url().'tests/chapters/'.$session_course.'/'.$session_class);
		}
		
		$param = array('course_id'=> $session_course,
					   'class_id' => $session_class,
					   'subject_id' => $subject_id,
					   'chapter_id' => $chapter_id,
					   'level_id' => $level_id,
					   'user_id' => $user_arr["user_id"],
				      );
		
		$level_list=$this->tests_model->level_select_list($subject_id,$chapter_id,"select");
		$set_list=$this->tests_model->set_select_list($subject_id,$chapter_id,$level_id,"select");
		$data['current_subject'] = $subject_id;
		$data['chapter'] = $chapter_id;
		$data['level'] = $level_id;
		$data['set'] = $set_id;
		$data['selected_subject']=$this->tests_model->subject($subject_id);
		$data['selected_chapter']=$this->tests_model->chapter($chapter_id);
		$data['completed_level']=$this->tests_model->level($level_id);
		$data['completed_set']=$this->tests_model->set($set_id);
		$data['set_count']=$this->tests_model->set_count($level_id);
		$data['completed_set_count']=$this->tests_model->completed_set_count($param);
		$data['overall_percent']=$this->tests_model->overall_percent($param,$data['set_count'],$data['completed_set_count'][1],$data['completed_set_count'][0]);
		
		$data['questions'] = $this->tests_model->questions($testid,$start);
		$data['next'] = $start+1;
		$data['previous'] = $start-1;
		
		$data['count'] = $this->tests_model->question_count($testid);
		$data['pass_percentage'] = $this->tests_model->pass_percentage($testid);
		$data['answered'] = $this->tests_model->answered($testid,1);
		$data['not_answered'] = $this->tests_model->answered($testid,"0");
		$data['count_correct'] = $this->tests_model->count_correct($testid,1);
		$data['count_wrong'] = $this->tests_model->count_correct($testid,"0");
		$data['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
		$data['serial_number'] = $this->tests_model->serial_number($testid,$start);
		
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$relevant_class;
		$data['course'] = $session_course;
		$data['class'] = $session_class;
		$data['level_list'] = $level_list;
		$data['set_list'] = $set_list;
		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		
		
		$data['main_content'] = 'tests/practice_detail';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
	}
	public function answer_details()
	{
		$user_arr=$this->session->userdata('user_is_logged_in');
		$question_id = $this->input->post('ques_id');
		$option_selected = $this->input->post('option_selected');
		$data['answer'] = $this->tests_model->answer_detail($question_id);
		$test_id = $this->input->post('test_id');
		$data['save_answer'] = $this->tests_model->is_correct($question_id,$test_id,$option_selected);
		echo json_encode($data);
	}
	public function answer_description($question_id="",$option_selected="")
	{
		$data['option_selected'] = $option_selected;
		$data['answer_description'] = $this->tests_model->answer_detail($question_id);
		$this->load->view('tests/answerdescription-popup',$data);
	}
	public function start_test($subject_id="",$chapter_id="",$level_id="",$set_id="")
	{
		$user_arr=$this->session->userdata('user_is_logged_in');
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		if($session_course != '')
		{
			$relevant_class=$this->tests_model->relevant_classes($session_course);
		}
		$test_arr = array('session_course'=> $session_course,
						  'session_class' => $session_class,
					      'subject_id' => $subject_id,
					      'chapter_id' => $chapter_id,
					      'level_id' => $level_id,
					      'set_id' => 	$set_id,
					      );
		//$test_random_id = rand(0,1000000);
		$resume_status = $this->tests_model->resume_status($test_arr,$user_arr["user_id"]);
	
		if($resume_status[0] != 0)
		{
			$test_random_id = $resume_status[1]['exam_code'];
			redirect(base_url().'tests/practice_detail/'.$test_random_id);
		}else{
			$test_random_id = rand(0,1000000);
			$test_id = $this->tests_model->test_manage($user_arr["user_id"],$test_random_id,$test_arr,0);
			$test_details = $this->tests_model->test_details($test_id,$test_arr);
			redirect(base_url().'tests/practice_detail/'.$test_random_id);
		}
	}
	public function start_progress_test($subject_id="",$chapter_id="",$level_id="")
	{
		$user_arr=$this->session->userdata('user_is_logged_in');
		$session_course = $this->session->userdata('selected_course');
		$session_class = $this->session->userdata('selected_class');
		
		$test_arr = array('session_course'=> $session_course,
						  'session_class' => $session_class,
					      'subject_id' => $subject_id,
					      'chapter_id' => $chapter_id,
					      'level_id' => $level_id,
					      'set_id' => 	0,
					      );
		$test_random_id = rand(0,1000000);
		$test_id = $this->tests_model->test_manage($user_arr["user_id"],$test_random_id,$test_arr,1);
		$progress_test_details = $this->tests_model->progress_test_details($test_id,$test_arr,$user_arr['user_id']);
		
		redirect(base_url().'tests/progress_detail/'.$test_random_id);
	}
	public function progress_detail($test_random_id="",$start="0",$status="")
	{
		$time = $this->tests_model->get_count_down();
		$data['total_time'] = $time['count_down_time'];
		$startdate = $this->tests_model->get_start_time($test_random_id);
		$data['start_date'] = $startdate['start_date'];
		$date1 = $startdate['start_date'];
		$date2 = date('Y-m-d H:i:s'); 
		$start_date = new DateTime($date1);
		$since_start = $start_date->diff(new DateTime($date2));
		//echo $since_start->days.' days total<br>';
		//echo $since_start->y.' years<br>';
		//echo $since_start->m.' months<br>';
		//echo $since_start->d.' days<br>';
		//echo $since_start->h.' hours<br>';
		//echo $since_start->i.' minutes<br>';
		//echo $since_start->s.' seconds<br>';

		$minutes = $since_start->days * 24 * 60;
		$minutes += $since_start->h * 60;
		$minutes += $since_start->i;
		//echo $minutes.' minutes';
		//echo "<br/>";
		//echo $data['total_time']-$minutes;
		
		
		$data['seconds'] = $since_start->s;
		$data['minutes'] = $minutes;
		$data['time_difference'] = $data['total_time']-$minutes;
		
		
		if($data['time_difference']<=0&&$status==""){  
			redirect(base_url().'tests/submit_progress_test/'.$test_random_id);
		}else{
	
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
		$subject_id = $test_info[0]['subject_id'];
		$chapter_id = $test_info[0]['chapter_id'];
		$level_id = $test_info[0]['level_id'];
		$set_id = $test_info[0]['set_id'];
		$data['is_completed'] = $test_info[0]['status'];
		$data['test_id'] = $testid;

		$data['current_subject'] = $subject_id;
		$data['chapter'] = $chapter_id;
		$data['level'] = $level_id;
		$data['set'] = $set_id;
		$data['selected_subject']=$this->tests_model->subject($subject_id);
		$data['selected_chapter']=$this->tests_model->chapter($chapter_id);
		
		$data['questions'] = $this->tests_model->questions($testid,$start);
		$data['next'] = $start+1;
		$data['previous'] = $start-1;
		
		$data['count'] = $this->tests_model->question_count($testid);
		$data['answered'] = $this->tests_model->answered($testid,1);
		$data['not_answered'] = $this->tests_model->answered($testid,"0");
		$data['count_correct'] = $this->tests_model->count_correct($testid,1);
		$data['count_wrong'] = $this->tests_model->count_correct($testid,"0");
		$data['user_percent'] = $this->tests_model->user_percent($testid,$data['count']);
		$data['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
		$data['serial_number'] = $this->tests_model->serial_number($testid,$start);
		
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$relevant_class;
		$data['course'] = $session_course;
		$data['class'] = $session_class;
		$data['option_selected'] = '';
		//$data['level_list'] = $level_list;
		//$data['set_list'] = $set_list;
		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		
		$data['main_content'] = 'tests/progress_detail';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
		}
	
	}
	public function submit_progress_test($test_random_id)
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
		$subject_id = $test_info[0]['subject_id'];
		$chapter_id = $test_info[0]['chapter_id'];
		$level_id = $test_info[0]['level_id'];
		$set_id = $test_info[0]['set_id'];
	
		$param = array('course_id'=> $session_course,
					   'class_id' => $session_class,
					   'subject_id' => $subject_id,
					   'chapter_id' => $chapter_id,
					   'level_id' => $level_id,
					   'set_id' => $set_id,
					   'user_id' => $user_arr["user_id"],
					  );
		$data['count'] = $this->tests_model->question_count($testid);
		$data['user_percent'] = $this->tests_model->user_percent($testid,$data['count']);
		$data['submit'] = $this->tests_model->submit_test($user_arr["user_id"],$exam_code,$data['user_percent']);
		$percentage = $this->tests_model->pass_percentage($testid);
		$data['certificate'] = $this->tests_model->certificate($param,$testid,$data['user_percent'],$percentage['pass_percent'],1);
		
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
			$level_id = $test_info[0]['level_id'];
			$set_id = $test_info[0]['set_id'];
		
			$param = array('course_id'=> $session_course,
						   'class_id' => $session_class,
						   'subject_id' => $subject_id,
						   'chapter_id' => $chapter_id,
						   'level_id' => $level_id,
						   'user_id' => $user_arr["user_id"],
						  );
			$data['count'] = $this->tests_model->question_count($testid);
			$data['user_percent'] = $this->tests_model->user_percent($testid,$data['count']);
			$data['submit'] = $this->tests_model->submit_test($user_arr["user_id"],$exam_code,$data['user_percent']);
			$data['set_count']=$this->tests_model->set_count($level_id);
			$data['completed_set_count']=$this->tests_model->completed_set_count($param);
			$data['overall_percent']=$this->tests_model->overall_percent($param,$data['set_count'],$data['completed_set_count'][1],$data['completed_set_count'][0]);
			$data['level_completed']=$this->tests_model->level_completed($param,$data['overall_percent'],$data['set_count'],$data['completed_set_count'][1]);
			redirect(base_url().'tests/practice_detail/'.$exam_code."/0/1");
		}
	}
	public function request()
	{
		$subject_id = $this->input->post('subject_id');
		$chapter_id = $this->input->post('chapter_id');
		$level_id = $this->input->post('level_id');
		$data = array();
		$data['set_list'] = array();
		$data['set_list'] = $this->tests_model->set_select_list($subject_id,$chapter_id,$level_id,"select");
		echo json_encode($data);
	}
	public function view_result($exam_code,$start="0")
	{
		
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
		$subject_id = $test_info[0]['subject_id'];
		$chapter_id = $test_info[0]['chapter_id'];
		$level_id = $test_info[0]['level_id'];
		$set_id = $test_info[0]['set_id'];
		$data['test_id'] = $testid;

		$data['current_subject'] = $subject_id;
		$data['chapter'] = $chapter_id;
		$data['level'] = $level_id;
		$data['set'] = $set_id;
		$data['selected_subject']=$this->tests_model->subject($subject_id);
		$data['selected_chapter']=$this->tests_model->chapter($chapter_id);
		
		$data['questions'] = $this->tests_model->questions($testid,$start);
		$data['next'] = $start+1;
		$data['previous'] = $start-1;
		
		$data['count'] = $this->tests_model->question_count($testid);
		$data['answered'] = $this->tests_model->answered($testid,1);
		$data['not_answered'] = $this->tests_model->answered($testid,"0");
		$data['count_correct'] = $this->tests_model->count_correct($testid,1);
		$data['count_wrong'] = $this->tests_model->count_correct($testid,"0");
		$data['user_percent'] = $this->tests_model->user_percent($testid,$data['count']);
		$data['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
		$data['serial_number'] = $this->tests_model->serial_number($testid,$start);
		
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$relevant_class;
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
}
