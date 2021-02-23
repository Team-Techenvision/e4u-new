<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends Mobile_service_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','csv_import'));
		$this->load->language(array('flash_message','form_validation'), 'english');
		$this->load->model('tests/tests_model');
		$this->load->model(array('webservice/webservice_model','home/home_model','leaderboard/leaderboard_model'));
		$this->load->helper("surprise_test_helper");
	}
	public function chapters(){ 
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id', 'trim|required');
			$this->form_validation->set_rules('class_id', 'class id', 'trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$relevant_subject=$this->tests_model->relevant_subjects($course_id,$class_id);
						$key = $this->input->post('subject_id');
						$keys = array_keys($relevant_subject);
						if($key != '')
						{
							$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$key);
							$data['current_subject'] = $key;
							$chapter_list=$this->tests_model->chapter_list($course_id,$class_id,$key);
						}
						else
						{
							$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$keys[0]);
							$data['current_subject'] = $keys[0];
							$chapter_list=$this->tests_model->chapter_list($course_id,$class_id,$keys[0]);
						}
						if($correct_map!=0 && !empty($chapter_list)){
							$result = array( 'success'=> 1 , 'message'=> 'chapters list' ,'data' => $chapter_list);
						}else if($correct_map==0){
							$result = array('success' => 0, 'message' => 'Not Available');
						} 
						else{
							$result = array('success' => 0, 'message' => 'No records found');
						} 
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function materials_list(){
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('class_id', 'class id', 'trim|required');
			$this->form_validation->set_rules('subject_id', 'class id', 'trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = ($this->input->post('course_id')==""?0:$this->input->post('course_id'));
				$class_id = $this->input->post('class_id');
				$subject_id = $this->input->post('subject_id');
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
					if($course_id!=0){
						$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$subject_id);}
						else
						{
						$correct_map=1;
						}
						if($course_id==0)
						{
							$attachment=$this->home_model->get_materials($course_id);
						}
						else
						{
							$attachment=$this->tests_model->get_materials($course_id,$class_id,$subject_id);
						}
						if($attachment && $correct_map!=0){
							$ext = array();
							$i=0;
							foreach($attachment as $attach){
								$ext = explode(".",$attach['attachment']);
								$data["attachments"][$i]["id"]=$attach['id'];
								$data["attachments"][$i]["attachment"]=$attach['attachment'];
								$data["attachments"][$i]["extension"]=$ext[1];
								$data["attachments"][$i]["download_name"]=$attach['download_name'];
								$data["attachments"][$i]["comments"]=$attach['comments'];
								$i++;
							}
							$data["path"]=$this->config->item("download_materials");
							$result = array( 'success'=> 1 , 'message'=> 'materials list' ,'data' => $data);
						}else if($correct_map == 0){
							$result = array( 'success'=> 0 , 'message'=> 'Not Available');
						}
						else
						{
							$result = array( 'success'=> 0 , 'message'=> 'No records found');
						}
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function upload_materials(){
		$this->load->helper('string');
		$this->load->helper('thumb_helper');
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id', 'trim|required');
			$this->form_validation->set_rules('class_id', 'class id', 'trim|required');
			$this->form_validation->set_rules('subject_id', 'class id', 'trim|required');
			$this->form_validation->set_rules('download_name', 'download name', 'trim|required');
			$this->form_validation->set_rules('comments', 'comments', 'trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$subject_id = $this->input->post('subject_id');
				$date = date('Y-m-d H:i:s');
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						//write image to a file need to change this line. image uloaded successfully
						//fi;e allowed types are pdf|doc|mp3|mp4|rar|docx.
						$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$subject_id);
					  	$join_tables = $where = array();  
					  	$fields = 'c.id course_id, rc.class_id class_id, rs.subject_id subject_id'; 
					  	$where[] = array( TRUE, 'c.id', $this->input->post('course_id'));
					  	$where[] = array( TRUE, 'rc.class_id', $this->input->post('class_id'));
					  	$where[] = array( TRUE, 'rs.subject_id', $this->input->post('subject_id'));
					  	$join_tables[] = array('relevant_classes as rc','rc.course_id = c.id');		
					  	$join_tables[] = array('relevant_subjects as rs','rs.course_id = c.id');
					  	$list = $this->base_model->get_advance_list('courses as c', $join_tables, $fields, $where);
					  	if(!empty($list) && $correct_map!=0){
						 	$image_dat=$this->input->post("attachment"); 
		 	  				$data = base64_decode($image_dat);
							$recived_attachment_name=random_string('unique').time().".".$this->input->post("extension");
							if(file_put_contents($this->config->item('attachments').$recived_attachment_name, $data)){
								$update_array = array();
								$update_array = array ('course_id' => $course_id, 
													   'class_id' => $class_id, 
													   'subject_id' => $subject_id, 
													   'download_name' => $this->input->post('download_name'), 
													   'comments' => $this->input->post('comments'), 
													   'attachment' => $recived_attachment_name,
													   'uploaded_by' => 1,
													   'status' => 0,
													   'created' => $date,
													   'user_id' => $user_id,
													   );
													   
								$insertId = $this->base_model->insert('downloads', $update_array);
								if($insertId){
									$result = array('success' => 1, 'message' => 'File has been uploaded successfully');
								} 
							}else{
								$result = array('success' => 0, 'message' => 'File has not uploaded');
							}
						}else if($correct_map == 0){
							$result = array('success' => 0, 'message' => 'Not Available');
						}else{
							$result = array('success' => 0, 'message' => 'some error occured or invalid course,class and subject');
						}
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function levels_list()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id','trim|required');
			$this->form_validation->set_rules('class_id', 'class id','trim|required');
			$this->form_validation->set_rules('subject_id', 'subject id','trim|required');
			$this->form_validation->set_rules('chapter_id', 'chapter id','trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$subject_id = $this->input->post('subject_id');
				$chapter_id = $this->input->post('chapter_id');
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$subject_id);
						$level_list=$this->tests_model->level_list($course_id,$class_id,$subject_id,$chapter_id);
						
						$i=0;
						foreach($level_list as $key=>$value){
							$set_ids=array();
							$data['level_lists'][$i]['name'] = $value['name'];
							$data['level_lists'][$i]['order'] = $value['order'];
							$data['level_lists'][$i]['description'] = $value['description'];
							$data['level_lists'][$i]['id'] = $value['id'];
							$param = array('course_id'=> $course_id,
										   'class_id' => $class_id,
										   'subject_id' => $subject_id,
										   'chapter_id' => $chapter_id,
										   'level_id' => $value['id'],
										   'user_id' => $user_id,
										  );
							$completed_set = $this->tests_model->completed_set_count($param);
							foreach($completed_set[0] as $key_set=>$val_set)
							{
								$set_ids[] = $val_set['set_id'];
							}
							$total_set = $this->tests_model->set_count($value['id'],$chapter_id,"set_result");
							foreach($total_set as $key=>$val)
							{
								$set_ids[] = $val['id'];
							}
							$total_set = count(array_unique($set_ids));
							$level_completed = $this->tests_model->check_level_completed($user_id,$course_id,$class_id,$subject_id,$chapter_id,$value['id']);
							if($total_set > $completed_set[1] || $level_completed == ""){
								$data['level_lists'][$i]['level_completed'] = 0;
							}else if(!empty($level_completed)){
								$data['level_lists'][$i]['level_completed'] = 1;
							}
							else
							{
							$data['level_lists'][$i]['level_completed'] = 0;
							}
							$progress_completed=$this->tests_model->is_progress_completed($user_id,$value['id']);
							if($progress_completed!=0 && $total_set == $completed_set[1]){
								$data['level_lists'][$i]['progress_completed'] =1;
							}else if($total_set > $completed_set[1] && $progress_completed!=0){
							$data['level_lists'][$i]['progress_completed'] =2;
							}else{
							$data['level_lists'][$i]['progress_completed'] =0;
							}
							
							$data['level_lists'][$i]['total_set'] = $total_set;
							
							$data['level_lists'][$i]['completed_set'] = $completed_set[1];
							
							$data['level_lists'][$i]['count_correct'] = $this->webservice_model->count_correct($course_id,$class_id,$subject_id,$chapter_id,$value['id'],1,$user_id);
							$count_skip = $this->webservice_model->count_skip($course_id,$class_id,$subject_id,$chapter_id,$value['id'],$user_id);
							$count_wrong = $this->webservice_model->count_correct($course_id,$class_id,$subject_id,$chapter_id,$value['id'],0,$user_id);
							$total_wrong = $count_skip+$count_wrong;
							$data['level_lists'][$i]['count_wrong'] = $total_wrong;
							$level_percent = ($completed_set[1]/$total_set)*100;
							$data['level_lists'][$i]['total_percent'] = $level_percent;
							
							$i++;
						}
						if(!empty($level_list) && $correct_map!=0){
							$result = array('success'=> 1, 'message'=> 'Success level list', 'data'=> $data);
						}
						else if($correct_map == 0)
						{
							$result = array('success'=> 0 , 'message'=> 'Not Available');
						}
						else
						{
							$result = array('success'=> 0 , 'message'=> 'No records found');
						}
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function sets_list()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id','trim|required');
			$this->form_validation->set_rules('class_id', 'class id','trim|required');
			$this->form_validation->set_rules('subject_id', 'subject id','trim|required');
			$this->form_validation->set_rules('chapter_id', 'chapter id','trim|required');
			$this->form_validation->set_rules('level_id', 'level id','trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$subject_id = $this->input->post('subject_id');
				$chapter_id = $this->input->post('chapter_id');
				$level_id = $this->input->post('level_id');
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$subject_id);
						$set_list_basic=$this->tests_model->set_list($course_id,$class_id,$subject_id,$chapter_id,$level_id);						
						$j=0;
						foreach($set_list_basic as $data_inn_set){
						$stat_of_set=$this->tests_model->set_status($user_id,$data_inn_set["id"]);
							if($stat_of_set["status"]==1&&$stat_of_set["result"]==1){
								$status_set=1;#pass
							}else if($stat_of_set["status"]==1&&$stat_of_set["result"]==0){
								$status_set=2;#fail
							}else if($stat_of_set["status"]==0&&$stat_of_set["id"]!=""){
								$status_set=3;#progress
							}else{
								$status_set=0;#pending
							}
							
							$set_list[$j]=array(
							"id"=>$data_inn_set["id"],
							"name"=>$data_inn_set["name"],
							"order"=>$data_inn_set["order"],
							"description"=>$data_inn_set["description"],
							"status"=>$status_set,
							);
							$j++;
						}
						if(!empty($set_list_basic) && $correct_map != 0){
							$result = array('success'=> 1, 'message'=> 'Success set list', 'data'=> $set_list);
						}else if($correct_map == 0)
						{
							$result = array('success'=> 0 , 'message'=> 'Not Available');
						}
						else
						{
							$result = array('success'=> 0 , 'message'=> 'No records found ');
						}
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function start_test()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id','trim|required');
			$this->form_validation->set_rules('class_id', 'class id','trim|required');
			$this->form_validation->set_rules('subject_id', 'subject id','trim|required');
			$this->form_validation->set_rules('chapter_id', 'chapter id','trim|required');
			$this->form_validation->set_rules('level_id', 'level id','trim|required');
			$this->form_validation->set_rules('set_id', 'set id','trim|required');
			if($this->form_validation->run()){
				 
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$subject_id = $this->input->post('subject_id');
				$chapter_id = $this->input->post('chapter_id');
				$level_id = $this->input->post('level_id');
				$set_id = $this->input->post('set_id');
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$test_arr = array('session_course'=> $course_id,
										  'session_class' => $class_id,
										  'subject_id' => $subject_id,
										  'chapter_id' => $chapter_id,
										  'level_id' => $level_id,
										  'set_id' => 	$set_id,
										  );
						$resume_status = $this->tests_model->resume_status($test_arr,$user_id);
	 
						if($resume_status[0] != 0)
						{
							$exam_code = $resume_status[1];
						}else{
						 
							$test_random_id = rand(0,10000);
							$test_id = $this->tests_model->test_manage($user_id,$test_random_id,$test_arr,"",0);
							$test_details = $this->tests_model->test_details($test_id,$test_arr);
							$exam_code = $this->tests_model->get_exam_code($test_id);
							
						}
						$test_info = $this->tests_model->get_test_details($exam_code['exam_code']);
						$testid = $test_info[0]['id'];
						$questions = $this->tests_model->questions($testid,$start=0);
						$res = array();
						$i=0;
						foreach($questions as $ques)
						{		
							$option_arr=unserialize($ques['choices']);
							$options=array();
							foreach($option_arr as $data_Arr){																	
								$options[]["options"] = $data_Arr;								
							}
							if($ques['question_type']==1){ 
								$question = $ques['question'];
							}else{
								$question = base_url() . 'appdata/questions/thumb_questions_img/'. $ques['question'];
							}
							
							if($ques['explanation_type']==2){
								$explanation = base_url() . 'appdata/explanations/thumb_explanation_img/'. $ques['explanation'];
							}else{
								$explanation = $ques['explanation'];
							}
							
							if($ques['severity']==1)
							{
								$severity_text = "Important";
							}	
							else if($ques['severity']==2)
							{
								$severity_text = "High";
							}
							else if($ques['severity']==3)
							{
								$severity_text = "Low";
							}
							else
							{
								$severity_text = "";
							}
							
							$res[$i]['question_id'] = $ques['id'];
							$res[$i]['question_type'] = $ques['question_type'];
							$res[$i]['question'] = $question;
							$res[$i]['severity'] = $severity_text;
							$res[$i]['answer_type'] = $ques['answer_type'];
							$res[$i]['choices'] =  $options;
							$res[$i]['choices_path'] = $this->config->item('answers_url');
							$res[$i]['correct_answer'] = $ques['correct_answer'];
							$res[$i]['selected_answer'] = $ques['selected_answer'];
							$res[$i]['explanation_type'] = $ques['explanation_type'];
							$res[$i]['explanation'] = $explanation;							
							$res[$i]['is_correct'] = $ques['is_correct'];
							$res[$i]['status'] = $ques['status'];
							
							
							$res[$i]['test_random_id'] = $exam_code['exam_code'];
							$res[$i]['test_id'] = $testid;
							$i++;
						}
						$result = array('success'=> 1, 'message'=> 'Questions list','data' => $res);
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function save_answer()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('ques_id', 'question id','trim|required');
			$this->form_validation->set_rules('test_id', 'test id','trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$question_id = $this->input->post('ques_id');
				$test_id = $this->input->post('test_id');
				$option_selected = $this->input->post('option_selected');

				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$answer = $this->tests_model->answer_detail($question_id);
						$data['answer'] = $answer;
						if($answer['correct_answer'] == $option_selected){
							$data['is_correct'] = "TRUE";
						}else{
							$data['is_correct'] = "FALSE";
						}
						$test_id = $this->input->post('test_id');
						$this->tests_model->is_correct($question_id,$test_id,$option_selected);
						$result = array('success'=> 1, 'message'=> 'Questions list','data' => $data);
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function result_report()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('test_random_id', 'test random id', 'trim|required'); 
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');

				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$exam_code = $this->input->post('test_random_id');
						$test_info = $this->tests_model->get_test_details($exam_code);
						$testid = $test_info[0]['id'];
						$session_course = $test_info[0]['course_id'];
						$session_class = $test_info[0]['class_id'];
						$subject_id = $test_info[0]['subject_id'];
						$chapter_id = $test_info[0]['chapter_id'];
						$level_id = $test_info[0]['level_id'];
						$set_id = $test_info[0]['set_id'];
						
						$param = array('course_id'=> $session_course,
						   'class_id' => $session_class,
						   'subject_id' => $subject_id,
						   'chapter_id' => $chapter_id,
						   'user_id' => $user_id,
						   'level_id' => $level_id
						  );
						
						
						$data['count'] = $this->tests_model->question_count($testid);
						$user_percent = $this->tests_model->user_percent($testid,$data['count']);
						$this->tests_model->submit_test($user_id,$exam_code,$user_percent);
						
						$data['set_count']=$this->tests_model->set_count($level_id,$chapter_id);
						$data['completed_set_count']=$this->tests_model->completed_set_count($param);
						$data['overall_percent']=$this->tests_model->overall_percent($param,$data['set_count'],$data['completed_set_count'][1],$data['completed_set_count'][0]);
						$data['level_completed']=$this->tests_model->level_completed($param,$data['overall_percent'],$data['set_count'],$data['completed_set_count'][1]);
						
						$pass_percent = $this->tests_model->pass_percentage($testid);
						$level_name = $this->webservice_model->level_name($level_id);
						$res['pass_percent'] = round($pass_percent['pass_percent']);
						$res['user_percent'] = $user_percent;
						if($user_percent >= round($pass_percent['pass_percent']))
						{
							$res['result'] = 1;
						}
						else{
							$res['result'] = 0;
							
						}
						$progress_completed_set = $this->tests_model->progress_completed_set($user_id,$level_id);
				 		$new_set = $this->tests_model->check_new_set($param,$progress_completed_set);
				 		$is_progress = $this->tests_model->is_progress_completed($user_id,$level_id);
						
						if($data['overall_percent'] >= round($pass_percent['pass_percent']) && $data['set_count'] == $data['completed_set_count'][1] && $new_set==0 && $is_progress == 0){
							$res['progress'] = "TRUE";
						}else{
							$res['progress'] = "FALSE";
						}
						
						if(($res['result'] == 1 || $res['result'] == 0) && $res['progress'] == "TRUE"){
							$res['message'] = "You have successfully completed the test.";
							$res['description'] = "You have completed the test in ".$level_name['name'];
						}else if($res['result'] == 1 && $res['progress'] == "FALSE"){
							$res['message'] = "You have successfully completed the test.";
							$res['description'] = "You have completed the test in ".$level_name['name'];
						}else if($res['result'] == 0 && $res['progress'] == "FALSE"){
							$res['message'] = "You have not achieved the minimum score";
							$res['description'] = "Please take re-test to score above ".round($pass_percent['pass_percent'])."%.";
						}
						
						$res['answered'] = $this->tests_model->answered($testid,1);
						$not_answered = $this->tests_model->answered($testid,"0");
						$res['count_correct'] = $this->tests_model->count_correct($testid,1);
						$count_wrong = $this->tests_model->count_correct($testid,"0");
						$total_wrong = $not_answered+$count_wrong;
						$res['count_wrong'] = $total_wrong;
						$res['percent_completed'] = $user_percent;
			 
						if($test_info[0]["test_type"]==1){
							$res['progress'] =$this->tests_model->is_avail_progress($param);
						}
						$result = array('success'=> 1, 'message'=> 'Questions list','data' => $res);
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function start_progress_test()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id','trim|required');
			$this->form_validation->set_rules('class_id', 'class id','trim|required');
			$this->form_validation->set_rules('subject_id', 'subject id','trim|required');
			$this->form_validation->set_rules('chapter_id', 'chapter id','trim|required');
			$this->form_validation->set_rules('level_id', 'level id','trim|required');

			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$subject_id = $this->input->post('subject_id');
				$chapter_id = $this->input->post('chapter_id');
				$level_id = $this->input->post('level_id');

				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$check_prog_completed = $this->tests_model->check_progress_completed($user_id,$course_id,$class_id,$subject_id,$chapter_id,$level_id);
						if($check_prog_completed > 0)
						{
							$is_progress_completed = 1;
						}
						else
						{
							$is_progress_completed = 0;
						}
						$test_arr = array('session_course'=> $course_id,
						  'session_class' => $class_id,
					      'subject_id' => $subject_id,
					      'chapter_id' => $chapter_id,
					      'level_id' => $level_id,
					      'set_id' => 	0,
					      );
					  
						$test_random_id = rand(0,10000);
						$test_id = $this->tests_model->test_manage($user_id,$test_random_id,$test_arr,"",1);
						$progress_test_details = $this->tests_model->progress_test_details($test_id,$test_arr,$user_id);
						$exam_code = $this->tests_model->get_exam_code($test_id);
						$questions = $this->tests_model->questions($test_id,$start=0);
						$res = array();
						$i=0;
						foreach($questions as $ques)
						{		
							$option_arr=unserialize($ques['choices']);
							$options=array();
							foreach($option_arr as $data_Arr){
								$options[]["options"]=$data_Arr;
							}
							
							if($ques['question_type']==1){ 
								$question = $ques['question'];
							}else{
								$question = base_url() . 'appdata/questions/thumb_questions_img/'. $ques['question'];
							}
							
							if($ques['explanation_type']==2){
								$explanation = base_url() . 'appdata/explanations/thumb_explanation_img/'. $ques['explanation'];
							}else{
								$explanation = $ques['explanation'];
							}
							
							if($ques['severity']==1)
							{
								$severity_text = "Important";
							}	
							else if($ques['severity']==2)
							{
								$severity_text = "High";
							}
							else if($ques['severity']==3)
							{
								$severity_text = "Low";
							}
							else
							{
								$severity_text = "";
							}
							
							$res[$i]['question_id'] = $ques['id'];
							$res[$i]['question_type'] = $ques['question_type'];
							$res[$i]['question'] = $question;
							$res[$i]['severity'] = $severity_text;
							$res[$i]['answer_type'] = $ques['answer_type'];
							$res[$i]['choices'] =  $options;
							$res[$i]['choices_path'] = $this->config->item('answers_url');
							$res[$i]['correct_answer'] = $ques['correct_answer'];
							$res[$i]['selected_answer'] = $ques['selected_answer'];
							$res[$i]['is_correct'] = $ques['is_correct'];
							$res[$i]['explanation_type'] = $ques['explanation_type'];
							$res[$i]['explanation'] = $explanation;
							$res[$i]['status'] = $ques['status'];
							$res[$i]['test_random_id'] = $exam_code['exam_code'];
							$res[$i]['test_id'] = $test_id;
							$i++;
						}
						$sett_det=$this->tests_model->get_count_down();
						$res_time['time'] = $sett_det["count_down_time"];
						$result = array('success'=> 1, 'message'=> 'Progress Questions list','is_completed'=>$is_progress_completed,'data' => $res,"count_down"=>$res_time);
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function progress_answer_details()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('test_random_id', 'test random id','trim|required');

			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$exam_code = $this->input->post('test_random_id');
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$test_info = $this->tests_model->get_test_details($exam_code);
						$testid = $test_info[0]['id'];
						$data['questions'] = $this->tests_model->questions($testid,$start=0);
						$res=array();
						$i=0;
						foreach($data['questions'] as $question){
							$option_arr=unserialize($question['choices']);
							$options=array();
							foreach($option_arr as $data_Arr){
								$options[]["options"]=$data_Arr;
							}
							$res[$i]['id'] = $question['id'];
							$res[$i]['question'] = $question['question'];
							$res[$i]['choices'] = $options;
							$res[$i]['correct_answer'] = $question['correct_answer'];
							$res[$i]['status'] = $question['status'];
							$res[$i]['selected_answer'] = $question['selected_answer'];
							$res[$i]['is_correct'] = $question['is_correct'];
							$i++;
						}
						$result = array('success'=> 1, 'message'=> 'Progress Test Results','data' => $res);
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	function progress_test_report(){
		
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('test_random_id', 'test random id', 'trim|required'); 
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');

				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$exam_code = $this->input->post('test_random_id');
						$test_info = $this->tests_model->get_test_details($exam_code);
						$testid = $test_info[0]['id'];
						$session_course = $test_info[0]['course_id'];
						$session_class = $test_info[0]['class_id'];
						$subject_id = $test_info[0]['subject_id'];
						$chapter_id = $test_info[0]['chapter_id'];
						$level_id = $test_info[0]['level_id'];
						$set_id = $test_info[0]['set_id'];
						
						$param = array('course_id'=> $session_course,
						   'class_id' => $session_class,
						   'subject_id' => $subject_id,
						   'chapter_id' => $chapter_id,
						   'user_id' => $user_id,
						   'level_id' => $level_id
						  );
						$data['count'] = $this->tests_model->question_count($testid);
						$data['user_percent'] = $this->tests_model->user_percent($testid,$data['count']);
						$res['progress_result']=$this->tests_model->submit_test($user_id,$exam_code,$data['user_percent']);
						$res['download_certificate']='';
						if($res['progress_result']==1){
							 $this->tests_model->certificate($param,$testid,$data['user_percent'],$percentage['pass_percent'],1);
						$res['download_certificate']=base_url()."webservice/certificates/view_certificate/".$testid."/".$user_id; 
						}
						$data['set_count']=$this->tests_model->set_count($level_id,$chapter_id);
						$data['completed_set_count']=$this->tests_model->completed_set_count($param);
						$data['overall_percent']=$this->tests_model->overall_percent($param,$data['set_count'],$data['completed_set_count'][1],$data['completed_set_count'][0]);
						$data['level_completed']=$this->tests_model->level_completed($param,$data['overall_percent'],$data['set_count'],$data['completed_set_count'][1]);
						
						$pass_percent = $this->tests_model->pass_percentage($testid);
						
						if($data['overall_percent'] >= round($pass_percent['pass_percent'])  && $data['set_count'] == $data['completed_set_count'][1]){
							$res['progress'] = "TRUE";
						}else{
							$res['progress'] = "FALSE";
						}
						$res['answered'] = $this->tests_model->answered($testid,1);
						$res['not_answered'] = $this->tests_model->answered($testid,"0");
						$res['count_correct'] = $this->tests_model->count_correct($testid,1);
						$res['count_wrong'] = $this->tests_model->count_correct($testid,"0");
						$res['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
			 
						if($test_info[0]["test_type"]==1){
							$res['progress'] =$this->tests_model->is_avail_progress($param);
						}
						
						$data['questions'] = $this->tests_model->questions($testid,$start=0);
						$data_arr=array();
						$i=0;
						foreach($data['questions'] as $question){
							$option_arr=unserialize($question['choices']);
							$options=array();
							foreach($option_arr as $data_Arr){
								$options[]["options"]=$data_Arr;
							}
							$data_arr[$i]['id'] = $question['id'];
							$data_arr[$i]['question'] = $question['question'];
							$data_arr[$i]['choices'] = $options;
							$data_arr[$i]['correct_answer'] = $question['correct_answer'];
							$data_arr[$i]['status'] = $question['status'];
							$data_arr[$i]['selected_answer'] = $question['selected_answer'];
							$data_arr[$i]['is_correct'] = $question['is_correct'];
							$i++;
						}
						
						$result = array('success'=> 1, 'message'=> 'Progress Result','data' => $res,'quest_answer_details'=>$data_arr);
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	
	}
	public function submit_progress_test(){ 
		if($this->input->post("master_data")!=""){
			$json=json_decode($this->input->post("master_data")); 
			$questions_set=$json->data; 
			$user_id=$json->user_id;
			$test_id=$json->test_id; 
			$test_random_id=$json->test_random_id; 
			$type=$json->type;
			$oauth_token=$json->oauth_token; 
			$device_type=$this->input->post("device_type"); 
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$data_cert=0;
						foreach($questions_set as $data_in){ 
							$question_id= $data_in->ques_id;
							$option_selected= $data_in->selected_answer;
							#update records to test_details  
							if($type == 2)
							{
								$this->tests_model->surprise_correct($question_id,$test_id,$option_selected);
							}
							else
							{
								$this->tests_model->is_correct($question_id,$test_id,$option_selected);
							}
						}
						// result report
	
						$exam_code =$test_random_id;
						if($type == 2){
						$test_info = $this->tests_model->get_test_details($exam_code);
						$testid = $test_info[0]['id'];
						$session_course = $test_info[0]['course_id'];
						}else{
						$test_info = $this->tests_model->get_test_details($exam_code);
						$testid = $test_info[0]['id'];
						$session_course = $test_info[0]['course_id'];
						$session_class = $test_info[0]['class_id'];
						$subject_id = $test_info[0]['subject_id'];
						$chapter_id = $test_info[0]['chapter_id'];
						$level_id = $test_info[0]['level_id'];
						$set_id = $test_info[0]['set_id'];
						}
						if($type==2)
						{
							$param = array('course_id'=> $session_course,
					   				   	   'user_id' => $user_id,
					  				      );
						}else{
							$param = array('course_id'=> $session_course,
							   'class_id' => $session_class,
							   'subject_id' => $subject_id,
							   'chapter_id' => $chapter_id,
							   'user_id' => $user_id,
							   'level_id' => $level_id
							  );
						}
						$data['count'] = $this->tests_model->question_count($testid);
						$data['user_percent'] = $this->tests_model->user_percent($testid,$data['count']);
						if($type == 2){
							$res['surprise_result']=$this->tests_model->submit_test($user_id,$exam_code,$data['user_percent']);
						}else{
							$progress_completed = $this->tests_model->check_progress_completed($user_id,$session_course,$session_class,$subject_id,$chapter_id,$level_id);
							if($progress_completed>0){
								$result = array('success'=> 0 , 'message'=> 'Some error '); #by simiyon
									echo json_encode($result);die;
							}
							$res['progress_result']=$this->tests_model->submit_test($user_id,$exam_code,$data['user_percent']);
						}
						$res['download_certificate']='';
						$pass_percent = $this->tests_model->pass_percentage($testid);
						$res['pass_percent'] = round($pass_percent['pass_percent']);
						
						//insert chapter_completed table
						$total_levels = $this->tests_model->total_levels($session_course,$session_class,$subject_id,$chapter_id);
						$completed_levels = $this->tests_model->completed_levels_in_chap($session_course,$session_class,$subject_id,$chapter_id,$user_id);
						if($total_levels == $completed_levels)
						{
							$chapter_completed = $this->tests_model->chapter_completed($session_course,$session_class,$subject_id,$chapter_id,$user_id);
						}
						////
						$res['user_percent'] = $data['user_percent'];
						$get_tips = $this->tests_model->get_tips($user_id);
						$res['tips_title'] = $get_tips['tips_title'];
						$res['tips'] = $get_tips['tips'];
						if($res['progress_result']==1 && $type==1){
							 $data_cert=$this->tests_model->certificate($param,$testid,$data['user_percent'],$pass_percent['pass_percent'],1);
							 $res['download_certificate']=base_url()."webservice/certificates/view_certificate/".$testid."/".$user_id; 
							 $res['message'] = "You have successfully completed the progress test.";
							 $res['description'] = "You have successfully completed the progress test.";
						}else if($res['surprise_result']==1 && $type==2)
						{
							$data_cert=$this->tests_model->certificate($param,$testid,$data['user_percent'],$pass_percent['pass_percent'],2);
							$res['download_certificate']=base_url()."webservice/certificates/view_certificate/".$testid."/".$user_id; 
							$res['message'] = "You have successfully completed the surprise test.";
							$res['description'] = "You have successfully completed the surprise test.";
						}
						
						if($data_cert==1){
							$this->send_certificate($testid,$user_id);
						}
						
						if($res['progress_result']==0 && $type==1){
							$res['message'] = "You have not achieved the minimum score";
							$res['description'] = "Please take re-test to score above ".round($pass_percent['pass_percent'])."%.";
						}else if($res['surprise_result']==0 && $type==2)
						{
							$res['message'] = "You have not achieved the minimum score";
							$res['description'] = "You didn't score minimum pass percentage in surprise test.";
						}
						
						if($type != 2){
							$data['set_count']=$this->tests_model->set_count($level_id,$chapter_id);
							$data['completed_set_count']=$this->tests_model->completed_set_count($param);
							$data['overall_percent']=$this->tests_model->overall_percent($param,$data['set_count'],$data['completed_set_count'][1],$data['completed_set_count'][0]);
							$data['level_completed']=$this->tests_model->level_completed($param,$data['overall_percent'],$data['set_count'],$data['completed_set_count'][1]);
						
						
							if($data['overall_percent'] >= round($pass_percent['pass_percent'])  && $data['set_count'] == $data['completed_set_count'][1]){
								$res['progress'] = "TRUE";
							}else{
								$res['progress'] = "FALSE";
							}
						}
						$res['answered'] = $this->tests_model->answered($testid,1);
						$not_answered = $this->tests_model->answered($testid,"0");
						$res['count_correct'] = $this->tests_model->count_correct($testid,1);
						$count_wrong = $this->tests_model->count_correct($testid,"0");
						$total_wrong = $not_answered+$count_wrong;
						$res['count_wrong'] = $total_wrong;
						$res['percent_completed'] = $data['user_percent'];
						$rank_holder = $this->leaderboard_model->get_participants();
						foreach($rank_holder as $key=>$value){
							$topper[] = $value['user_id'];
						}
						if(in_array($user_id,$topper)){
							$res['topper'] = "1";
						}else{
							$res['topper'] = "0";
						}
						
			 
						if($test_info[0]["test_type"]==1){
							$res['progress'] =$this->tests_model->is_avail_progress($param);
						}
						if($type == 2){
							$data['questions'] = $this->tests_model->surprise_questions($testid,$start=0);
						}else{
							$data['questions'] = $this->tests_model->questions($testid,$start=0);
						}
						
						$data_arr=array();
						$i=0;
						foreach($data['questions'] as $question){ 
							if($question['question_type']==1){ 
								$question_name = $question['question'];
							}else if($question['question_type']==2 && $type == 2){
								$question_name = base_url() . 'appdata/surprise_img/surprise_questions_img/thumb_questions_img/'. $question['question'];
							}else{
								$question_name = base_url() . 'appdata/questions/thumb_questions_img/'. $question['question'];
							}
							
							if($question['explanation_type']==2 && $type!=2){
								$explanation = base_url() . 'appdata/explanations/thumb_explanation_img/'. $question['explanation'];
							}else if($question['explanation_type']==2 && $type==2){
								$explanation = base_url() . 'appdata/surprise_img/surprise_explanations_img/thumb_explanation_img/'. $question['explanation'];
							}else{
								$explanation = $question['explanation'];
							}
							
							if($question['severity']==1)
							{
								$severity_text = "Important";
							}	
							else if($question['severity']==2)
							{
								$severity_text = "High";
							}
							else if($question['severity']==3)
							{
								$severity_text = "Low";
							}
							else
							{
								$severity_text = "";
							}
							
							$data_arr[$i]['id'] = $question['id'];
							$data_arr[$i]['question_type'] = $question['question_type'];
							$data_arr[$i]['question'] = $question_name; 
							$data_arr[$i]['severity'] = $severity_text;
							$data_arr[$i]['correct_answer'] = $question['correct_answer'];
							$data_arr[$i]['explanation_type'] = $question['explanation_type'];
							$data_arr[$i]['explanation'] = $explanation;
							$data_arr[$i]['status'] = $question['status'];
							$data_arr[$i]['selected_answer'] = $question['selected_answer'];
							$data_arr[$i]['is_correct'] = $question['is_correct'];
							$i++;
						}
						
						if($type == 2){
							$result = array('success'=> 1, 'message'=> 'Surprise Result','data' => $res,'quest_answer_details'=>$data_arr);
						}else{
							$result = array('success'=> 1, 'message'=> 'Progress Result','data' => $res,'quest_answer_details'=>$data_arr);
						}
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
						echo json_encode($result);
   
			}else{
				$result = array('success'=> 0 , 'message'=> 'Some error ');
				echo json_encode($result);
			}
	}
	public function performance_tips()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('title', 'title', 'trim|required'); 
			$this->form_validation->set_rules('tips', 'tips', 'trim|required'); 

			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$title = $this->input->post('title');
				$tips = $this->input->post('tips');

				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$update_array = array (	'tips_title' => $title,
												'tips' => $tips,
											  );
						$data['tips_title'] = $title;
						$data['tips'] = $tips;
						$update = $this->base_model->update( 'users', $update_array, array('id'=>$user_id));
						 
							$result = array('success'=> 1 , 'message'=> 'Performance Tips Updated Successfully','data'=>$data);
						 
						 
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function surprise_test_list()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id', 'trim|required'); 

			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');

				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$res=array();
						$res = $this->tests_model->get_surprise_test($course_id)[1];
						$surprise_test_completed = $this->tests_model->surprise_test_completed($course_id,$user_id);
						if($res != ""){
							if(in_array($res['id'],$surprise_test_completed)){
								$res['is_completed'] = 1;
							}else{
								$res['is_completed'] = 0;
							}
						}
						if($res != "")
						{
							$result = array('success'=> 1, 'message'=> 'Surprise Test list','data' => $res);
						}
						else
						{
							$result = array('success'=> 0, 'message'=> 'No Test Found');
						}
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function start_surprise_test()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id','trim|required');
			$this->form_validation->set_rules('surprise_test_id', 'surprise test id','trim|required');

			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$surprise_test_id = $this->input->post('surprise_test_id');

				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$check_surprise_completed = $this->tests_model->check_surprise_completed($user_id,$course_id,$surprise_test_id);
						if($check_surprise_completed>0)
						{
							$is_surprise_completed = 1;
						}
						else
						{
							$is_surprise_completed = 0;
						}
						$test_random_id = rand(0,10000);
						$test_id = $this->tests_model->test_manage($user_id,$test_random_id,$course_id,$surprise_test_id,2);
						$surprise_test_details = $this->tests_model->surprise_test_details($test_id,$course_id,$user_id,$surprise_test_id);
						$exam_code = $this->tests_model->get_exam_code($test_id);
						$questions = $this->tests_model->surprise_questions($test_id,$start=0);
						$res = array();
						$i=0;
						foreach($questions as $ques)
						{		
							$option_arr=unserialize($ques['choices']);
							$options=array();
							foreach($option_arr as $data_Arr){
								$options[]["options"]=$data_Arr;
							}
							
							if($ques['question_type']==1){ 
								$question = $ques['question'];
							}else{
								$question = base_url() . 'appdata/surprise_img/surprise_questions_img/thumb_questions_img/'. $ques['question'];
							}
							
							if($ques['explanation_type']==1){
								$explanation = $ques['explanation'];
							}else{
								$explanation = base_url() . 'appdata/surprise_img/surprise_explanations_img/thumb_explanation_img/'. $ques['explanation'];
							}
							
							if($ques['severity']==1)
							{
								$severity_text = "Important";
							}	
							else if($ques['severity']==2)
							{
								$severity_text = "High";
							}
							else if($ques['severity']==3)
							{
								$severity_text = "Low";
							}
							else
							{
								$severity_text = "";
							}
							
							$res[$i]['question_id'] = $ques['id'];
							$res[$i]['question_type'] = $ques['question_type'];
							$res[$i]['question'] = $question;
							$res[$i]['severity'] = $severity_text;
							$res[$i]['answer_type'] = $ques['answer_type'];
							$res[$i]['choices'] =  $options;
							$res[$i]['choices_path'] = $this->config->item('surprise_answers_url');
							$res[$i]['correct_answer'] = $ques['correct_answer'];
							$res[$i]['selected_answer'] = $ques['selected_answer'];
							$res[$i]['is_correct'] = $ques['is_correct'];
							$res[$i]['explanation_type'] = $ques['explanation_type'];
							$res[$i]['explanation'] = $explanation;
							$res[$i]['status'] = $ques['status'];
							$res[$i]['test_random_id'] = $exam_code['exam_code'];
							$res[$i]['test_id'] = $test_id;
							$i++;
						}
						$sett_det=$this->tests_model->get_surprise_test($course_id);
						$ret_arr = array();
						foreach($sett_det[1] as $key=>$value)
						{
							$ret_arr['duration'] = $value['duration'];
							$ret_arr['hours'] = $value['hours'];
							$i++;
						}
					$result = array('success'=> 1, 'message'=> 'Surprise Questions List','is_completed'=>$is_surprise_completed,'data'=>$res,'count_down_time'=>$ret_arr);
					break;
					default:
					$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function surprise_answer_details()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('test_random_id', 'test random id','trim|required');

			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$exam_code = $this->input->post('test_random_id');
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$test_info = $this->tests_model->get_test_details($exam_code);
						$testid = $test_info[0]['id'];
						$data['questions'] = $this->tests_model->surprise_questions($testid,$start=0);
						$res=array();
						$i=0;
						foreach($data['questions'] as $question){
							$option_arr=unserialize($question['choices']);
							$options=array();
							foreach($option_arr as $data_Arr){
								$options[]["options"]=$data_Arr;
							}
							$res[$i]['id'] = $question['id'];
							$res[$i]['question'] = $question['question'];
							$res[$i]['choices'] = $options;
							$res[$i]['correct_answer'] = $question['correct_answer'];
							$res[$i]['status'] = $question['status'];
							$res[$i]['selected_answer'] = $question['selected_answer'];
							$res[$i]['is_correct'] = $question['is_correct'];
							$i++;
						}
					
					$result = array('success'=> 1, 'message'=> 'Surprise Test Results','data' => $res);
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function surprise_test_report(){
		
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('test_random_id', 'test random id', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id', 'trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');

				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$exam_code = $this->input->post('test_random_id');
						$test_info = $this->tests_model->get_test_details($exam_code);
						$testid = $test_info[0]['id'];
						
						$param = array('course_id'=> $course_id,
					   				   'user_id' => $user_id,
					                  );
						$data['count'] = $this->tests_model->question_count($testid);
						$data['user_percent'] = $this->tests_model->user_percent($testid,$data['count']);
						$res['surprise_result']=$this->tests_model->submit_test($user_id,$exam_code,$data['user_percent']);
						$res['download_certificate']='';
						if($res['surprise_result']==1){
							 $this->tests_model->certificate($param,$testid,$data['user_percent'],$percentage['pass_percent'],2);
						$res['download_certificate']=base_url()."webservice/certificates/view_certificate/".$testid."/".$user_id; 
						}
						
						$res['answered'] = $this->tests_model->answered($testid,1);
						$res['not_answered'] = $this->tests_model->answered($testid,"0");
						$res['count_correct'] = $this->tests_model->count_correct($testid,1);
						$res['count_wrong'] = $this->tests_model->count_correct($testid,"0");
						$res['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
						
						$data['questions'] = $this->tests_model->surprise_questions($testid,$start=0);
						$data_arr=array();
						$i=0;
						foreach($data['questions'] as $question){
							$option_arr=unserialize($question['choices']);
							$options=array();
							foreach($option_arr as $data_Arr){
								$options[]["options"]=$data_Arr;
							}
							$data_arr[$i]['id'] = $question['id'];
							$data_arr[$i]['question'] = $question['question'];
							$data_arr[$i]['choices'] = $options;
							$data_arr[$i]['correct_answer'] = $question['correct_answer'];
							$data_arr[$i]['status'] = $question['status'];
							$data_arr[$i]['selected_answer'] = $question['selected_answer'];
							$data_arr[$i]['is_correct'] = $question['is_correct'];
							$i++;
						}
						
						$result = array('success'=> 1, 'message'=> 'Surprise Result','data' => $res,'quest_answer_details'=>$data_arr);
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function submit_surprise_test(){ 
		if($this->input->post("master_data")!=""){
			 
			$json=json_decode($this->input->post("master_data")); 
			$questions_set=$json->data; 
			$user_id=$json->user_id; 
			$test_id=$json->test_id; 
			$test_random_id=$json->test_random_id; 
			$oauth_token=$json->oauth_token; 
			$device_type=$this->input->post("device_type"); 
	
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
	
						foreach($questions_set as $data_in){ 
							$question_id= $data_in->ques_id;
							$option_selected= $data_in->selected_answer;
							#update records to test_details  
							$this->tests_model->is_correct($question_id,$test_id,$option_selected);
						}
						// result report
	
						$exam_code =$test_random_id;
						$test_info = $this->tests_model->get_test_details($exam_code);
						$testid = $test_info[0]['id'];
						
						$param = array('course_id'=> $course_id,
					   				   'user_id' => $user_id,
					                  );
						$data['count'] = $this->tests_model->question_count($testid);
						$data['user_percent'] = $this->tests_model->user_percent($testid,$data['count']);
						$res['surprise_result']=$this->tests_model->submit_test($user_id,$exam_code,$data['user_percent']);
						$res['download_certificate']='';
						if($res['surprise_result']==1){
							 $this->tests_model->certificate($param,$testid,$data['user_percent'],$percentage['pass_percent'],2);
						$res['download_certificate']=base_url()."webservice/certificates/view_certificate/".$testid."/".$user_id; 
						}
						$res['answered'] = $this->tests_model->answered($testid,1);
						$not_answered = $this->tests_model->answered($testid,"0");
						$res['count_correct'] = $this->tests_model->count_correct($testid,1);
						$count_wrong = $this->tests_model->count_correct($testid,"0");
						$total_wrong = $not_answered+$count_wrong;
						$res['count_wrong'] = $total_wrong;
						$res['percent_completed'] = $this->tests_model->percent_completed($testid,$data['count']);
						$data['questions'] = $this->tests_model->surprise_questions($testid,$start=0);
						$data_arr=array();
						$i=0;
						foreach($data['questions'] as $question){ 
							if($question['question_type']==1){ 
								$question_name = $question['question'];
							}else{
								$question_name = base_url() . 'appdata/surprise_img/surprise_questions_img/thumb_questions_img/'. $question['question'];
							}
							
							if($question['explanation_type']==2){
								$explanation = base_url() . 'appdata/surprise_img/surprise_explanations_img/thumb_explanation_img/'. $question['explanation'];
							}else{
								$explanation = $question['explanation'];
							}
							
							if($question['severity']==1)
							{
								$severity_text = "Important";
							}	
							else if($question['severity']==2)
							{
								$severity_text = "High";
							}
							else if($question['severity']==3)
							{
								$severity_text = "Low";
							}
							else
							{
								$severity_text = "";
							}
							
						
							$data_arr[$i]['id'] = $question['id'];
							$data_arr[$i]['question_type'] = $question['question_type'];
							$data_arr[$i]['question'] = $question_name; 
							$data_arr[$i]['severity'] = $severity_text;
							$data_arr[$i]['correct_answer'] = $question['correct_answer'];
							$data_arr[$i]['explanation_type'] = $question['explanation_type'];
							$data_arr[$i]['explanation'] = $explanation;
							$data_arr[$i]['status'] = $question['status'];
							$data_arr[$i]['selected_answer'] = $question['selected_answer'];
							$data_arr[$i]['is_correct'] = $question['is_correct'];
							$i++;
						}
						
						$result = array('success'=> 1, 'message'=> 'Surprise Result','data' => $res,'quest_answer_details'=>$data_arr);
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
						echo json_encode($result);
   
			}else{
				$result = array('success'=> 0 , 'message'=> 'Some error ');
				echo json_encode($result);
			}
	}
	public function send_certificate($test_id,$user_id){ 
			//generate pdf 
			$this->load->model('certificates/certificates_model');
			$this->load->model('base_model');
			$data['certificate_details']=$this->certificates_model->get_certificate_details($user_id,$test_id);
			
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
				$this->email->from("noreply@e4u.com");
				$this->email->to($user_email);
				$this->email->subject($mailcontent['subject']);
				$this->email->message($mailcontent['email_content']);
				$this->email->attach('appdata/pdfs/'.$pdfFilePath); 
				$result= $this->email->send();
				@unlink('appdata/pdfs/'.$pdfFilePath);	
			
		}
	
	}

?>
