<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lists extends Mobile_service_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','csv_import'));
		$this->load->language(array('flash_message','form_validation'), 'english');
	}
	public function index(){
		$this->load->model('base_model'); 
		$result = array();
        $data = array();

		$class_list = array();
		$class_list = $this->base_model->getSelectList('classes');
		unset($class_list[""]);

		$board_list = array();
		$board_list = $this->base_model->getSelectList('study_board');
		unset($board_list[""]);
		
		$medium_list = array();
		$medium_list = $this->base_model->getSelectList('medium');
		unset($medium_list[""]);
		
		$subject_list = array();
		$subject_list_arr = $this->base_model->getSelectList('subjects');
		$subject_list["All"]  = "All";
		foreach($subject_list_arr as $key=>$val){
			$subject_list[$key] = $val;
		}
		unset($subject_list[""]);

		$i=0;		
		foreach($class_list as $key => $val){
			$data['class_list'][$i]['id'] = $key;
			$data['class_list'][$i]['name'] = $val;
			$i++;
		}
		$i=0;
		foreach($board_list as $key => $val){
			$data['board_list'][$i]['id'] = $key;
			$data['board_list'][$i]['name'] = $val;
			$i++;
		}
		$i=0;
		foreach($medium_list as $key => $val){
			$data['medium_list'][$i]['id'] = $key;
			$data['medium_list'][$i]['name'] = $val;
			$i++;
		}
		$i=0;
		foreach($subject_list as $key => $val){
			$data['subject_list'][$i]['id'] = $key;
			$data['subject_list'][$i]['name'] = $val;
			$i++;
		}
		$result = array( 'success'=> 1 , 'message'=> 'list' ,'data' => $data);  
		echo $response = json_encode($result);
		return TRUE;
	}
	public function sub_category()
	{
		$this->load->model(array('webservice/webservice_model')) ;
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
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
					$category_list=$this->webservice_model->category_list();
					if(!empty($category_list)){
							$result = array( 'success'=> 1 , 'message'=> 'Sub category list' ,'data' => $category_list);
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

	public function alerts(){ 
		$this->load->model(array('alerts/alerts_model','dashboard/dashboard_model','webservice/webservice_model')) ;
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
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
						$user_arr = $user_id;
						$course_paid=$this->dashboard_model->get_paid_course($user_arr);			
						foreach($course_paid as $data_in){
							$id[]=$data_in["id"];
						}
						
						//List all alerts
						$data['alerts_list'] = $this->alerts_model->get_alerts($user_arr,"","",$page);
						$total_alerts = $this->webservice_model->total_alerts($user_arr);
						$current_date = date('Y-m-d H:i:s');
						$alert_list = $data['alerts_list'];
						
						$i=0;
						foreach($alert_list as $key=>$value){
							$alert_id[] = $value['id'];
							if($value['attachment']!="")
							{
								$attach_src = base_url().'appdata/alert_attachments/'.$value['attachment'];
							}
							else
							{
								$attach_src = "";
							}
							$alert_lists[$i]['id'] = $value['id'];
							$alert_lists[$i]['created'] = $value['created'];
							$alert_lists[$i]['title'] = $value['title'];
							$alert_lists[$i]['attachment'] = $attach_src;
							$alert_lists[$i]['short_description'] = $value['short_description'];
							$alert_lists[$i]['course_name'] = $value['course_name'];
							$alert_lists[$i]['alert_type'] = $value['alert_type'];
							
							$i++;
						}

						//insert viewed alerts
						$alert_visit = $this->alerts_model->alert_visit($user_arr, $alert_id);
						if(!empty($alert_list)){
							$result = array( 'success'=> 1 , 'message'=> 'alerts list' ,'total_alerts'=>$total_alerts,'current_date'=>$current_date,'data' => $alert_lists);
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
	public function new_alerts()
	{ 
		$this->load->model(array('alerts/alerts_model','dashboard/dashboard_model','webservice/webservice_model')) ;
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
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
						$course_paid=$this->dashboard_model->get_paid_course($user_id);			
						foreach($course_paid as $data_in){
							$id[]=$data_in["id"];
						}
						//get viewed alert id
						$alert_visit_id=$this->alerts_model->get_alert_id($user_id);
						foreach($alert_visit_id as $data_ret)
						{
							$alert_id[]=$data_ret["alert_id"];
						}
						//new alert count
						$alert_count = $this->alerts_model->get_alerts($user_id,1,$alert_id);	
						if(!empty($alert_count))
						{
							$result = array( 'success'=> 1 , 'message'=> 'New alerts count' ,'count' => $alert_count);
						}else if($alert_count==""){
							$result = array( 'success'=> 1 , 'message'=> 'New alerts count' ,'count' => '0');
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

	public function leaderboard(){ 
		$this->load->model(array('leaderboard/leaderboard_model')) ;
		$this->load->helper('thumb_helper');
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('type', 'type', 'trim'); 
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$type=isset($_POST['type'])?$this->input->post('type')!=""?$this->input->post('type'):"All":"All";
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
						$leaderboard_participant = $this->leaderboard_model->get_participants($type);
						$sort = array();
			foreach($leaderboard_participant as $k=>$v) {
				$sort['progress_count'][$k] = $v['progress_count'];
				$sort['questions'][$k] = $v['questions'];
				$sort['accuracy'][$k] = $v['accuracy'];  
				if($v['minutes'] > 60){
					$hours = $v['minutes']/60;
				}else{
					$hours = 1;
				}
				$speed = $value['questions']/$hours;
				$sort['speed'][$k] = $speed;
			}
			array_multisort($sort['progress_count'], SORT_DESC, $sort['questions'], SORT_DESC, $sort['accuracy'], SORT_DESC, $sort['speed'], SORT_DESC,$leaderboard_participant); 
						$participant = $this->leaderboard_model->get_participants($type,$user_id);
						if($participant[0]['profile_image'] != ''){
							$img_src = thumb($this->config->item('profile_image_url') .$participant[0]['profile_image'] ,'200', '200', 'thumb_profile_img',$maintain_ratio = FALSE);
						    $participant[0]['profile_image'] = base_url() . 'appdata/profile/thumb_profile_img/'.$img_src;
		            }
		            if($participant[0] != ""){
				        if($participant[0]['minutes'] > 60){
				        	$hours = $participant[0]['minutes']/60;
						}else{
							$hours = 1;
						}
						$speed = $participant[0]['questions']/$hours;
				        $participant[0]['speed'] = round($speed);
		            }
						foreach($leaderboard_participant as $key=>$leader){
								if($leader['profile_image'] != ''){
									$img_src = thumb($this->config->item('profile_image_url') .$leader['profile_image'] ,'200', '200', 'thumb_profile_img',$maintain_ratio = FALSE);
						     $leaderboard_participant[$key]['profile_image'] = base_url() . 'appdata/profile/thumb_profile_img/'.$img_src;
		            }
		            
		            	if($leader['minutes'] > 60){
		            	$hours = $leader['minutes']/60;
					}else{
						$hours = 1;
					}
					$speed = $leader['questions']/$hours;
		            $leaderboard_participant[$key]['speed'] = round($speed);
						}							
						if(!empty($leaderboard_participant)){
							$result = array( 'success'=> 1 , 'message'=> 'alerts list' , 'selected_type'=>$type ,'user'=>$participant[0],'data' => $leaderboard_participant);
						}else if(!empty($participant[0])){
							$result = array( 'success'=> 1 , 'message'=> 'alerts list' , 'selected_type'=>$type ,'user'=>'No Record Found','data' => $leaderboard_participant);
						}else{
							$result = array('success' => 0, 'message' => 'Sorry, there is no results found. Try again with fewer filters.');
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
	public function device_token(){ 
	$this->load->model(array('alerts/alerts_model','dashboard/dashboard_model','webservice/webservice_model')) ;
	$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('device_token', 'Token', 'trim|required');  
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$device_token = $this->input->post('device_token'); 
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
						$update_array = array (	'device_token' => $device_token);
						$update = $this->base_model->update( 'users', $update_array, array('id'=>$user_id));
						 
						$result = array('success'=> 1 , 'message'=> 'Successfully received'); 
						push_notification($user_id); 
						 
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
