<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subjective extends Mobile_service_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','csv_import'));
		$this->load->language(array('flash_message','form_validation'), 'english');
		$this->load->model(array('tests/tests_model','subjective/subjective_model','dashboard/dashboard_model'));
		$this->load->model(array('webservice/webservice_model','home/home_model'));
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
			$this->form_validation->set_rules('category_id', 'category id', 'trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$category_id = $this->input->post('category_id');
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
						$subjects=$this->tests_model->relevant_subjects($course_id,$class_id);
						$key = $this->input->post('subject_id');
						
						$keys = array_keys($subjects);
						if($key != '')
						{
							$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$key);
							$data['current_subject'] = $key;
							$chapter_list=$this->subjective_model->chapter_list($course_id,$class_id,$key,$category_id);
						}
						else
						{
							$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$keys[0]);
							$data['current_subject'] = $keys[0];
							$chapter_list=$this->subjective_model->chapter_list($course_id,$class_id,$keys[0],$category_id);
						}
						if(!empty($chapter_list) && $correct_map!=0){
							$result = array( 'success'=> 1 , 'message'=> 'chapters list' ,'data' => $chapter_list);
						}
						else if($correct_map == 0){
							$result = array('success' => 0, 'message' => 'Not Available');
						}else{
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
	public function recent_chapters(){ 
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id', 'trim|required');
			$this->form_validation->set_rules('class_id', 'class id', 'trim|required');
			$this->form_validation->set_rules('category_id', 'category id', 'trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$category_id = $this->input->post('category_id');
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
						$subjects=$this->tests_model->relevant_subjects($course_id,$class_id);
						$key = $this->input->post('subject_id');
						$keys = array_keys($subjects);
						if($key != '')
						{
							$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$key);
							$data['current_subject'] = $key;
							$chapter_list=$this->webservice_model->recent_chapter_list($course_id,$class_id,$key,$category_id);
						}
						else
						{
							$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$keys[0]);
							$data['current_subject'] = $keys[0];
							$chapter_list=$this->webservice_model->recent_chapter_list($course_id,$class_id,$keys[0],$category_id);
						}
						$notes['title'] = "";#Take a test on next topic
						$notes['description'] = "";#Lorem Ipsum is simply dummy text of the printing and typesetting industry.
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
						if($correct_map == 0)
						{
							$result = array('success' => 0, 'message' => 'Not Available');
						}
						else if(!empty($res) || !empty($notes) || (!empty($chapter_list) && $correct_map!=0)){
							$result = array( 'success'=> 1 , 'message'=> 'Recent chapters list' ,'chapter_list' => $chapter_list,'notes'=>$notes,'surprise_test'=>$res);
						}else{
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
	public function questions(){ 
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id', 'trim|required');
			$this->form_validation->set_rules('class_id', 'class id', 'trim|required');
			$this->form_validation->set_rules('category_id', 'category id', 'trim|required');
			$this->form_validation->set_rules('subject_id', 'subject id', 'trim|required');
			$this->form_validation->set_rules('chapter_id', 'chapter id', 'trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$category_id = $this->input->post('category_id');
				$subject_id = $this->input->post('subject_id');
				$chapter_id = $this->input->post('chapter_id');
				$page = $this->input->post('page');
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
						if($page == "")
						{
							$page = 1;
						}
						
						$limit_end = ($page - 1) * 5;  
	  					$limit_start = 5;	
						$param = array('course_id'=>$course_id,
					   				   'class_id'=>$class_id,
					   				   'subject_id'=>$subject_id,
					   				   'chapter_id'=>$chapter_id,
					   				   'sub_category_id'=>$category_id);
					   	$data['question'] = $this->subjective_model->get_questions($param,$limit_start, $limit_end);
					   	$total_questions = $this->webservice_model->total_subj_questions($param);
					   	
					   	$questions = $data['question'];
					   	$res = array();
						$i=0;
						foreach($questions as $ques)
						{		
							if($ques['question_type']==1){ 
								$question = $ques['question'];
							}else{
								$question = base_url() . 'appdata/subjective_questions/thumb_subjective_questions_img/'. $ques['question'];
							}
							
							if($ques['explanation_type']==2){
								$explanation = base_url() . 'appdata/subjective_explanations/thumb_subjective_explanation_img/'. $ques['explanation'];
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
							$res[$i]['explanation_type'] = $ques['explanation_type'];
							$res[$i]['explanation'] = $explanation;
							$res[$i]['category_id'] = $ques['category_id'];
							$res[$i]['category_name'] = $ques['category_name'];
							$res[$i]['status'] = $ques['status'];
							$i++;
						}
						if(!empty($question)){
							$result = array( 'success'=> 1 , 'message'=> 'Questions list' ,'total_questions'=>$total_questions,'per_page'=>'5','data' => $res);
						}else{
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
}
?>
