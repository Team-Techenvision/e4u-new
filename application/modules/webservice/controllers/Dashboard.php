<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Mobile_service_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','csv_import'));
		$this->load->language(array('flash_message','form_validation'), 'english');
		$this->load->model(array('webservice_model','tests/tests_model','home/home_model','subjective/subjective_model','dashboard/dashboard_model'));
	}
	public function course_plan(){ 
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			 
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_category = $this->input->post('course_category'); #n
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
						$where_purchase[] = array(FALSE,'status = 1');  
						$where_purchase[] = array(TRUE,'user_id',$user_id);  
						$purchasedCourses = $this->base_model->get_advance_list('user_plans', '', 'course_id', $where_purchase, '', 'id', '', '', '', '');
						foreach($purchasedCourses as $purchase){
							$purchased[] = $purchase['course_id'];
						}
						$course_fields = 'co.id,name,co.description,co.course_type, co.currency_type,
						co.price,co.price_d,co.duration,co.course_category_id,co.order_by_category,cc.category, up.course_expiry_date';
						$join_tables[] = array('course_category as cc','co.course_category_id = cc.id','inner');
						$join_tables[] = array('user_plans as up','up.course_id = co.id and up.user_id = '.$user_id,'left');
						if($course_category !=""){
							$where_course[] = array(TRUE,'co.course_category_id',$course_category);  
						}
						$where_course[] = array(FALSE,'co.status = 1');  
						$where_course[] = array(FALSE,'co.show_in_frontend = 1');
						$courses = $this->base_model->get_advance_list('courses co', $join_tables, $course_fields, $where_course, '', 'co.order_by_category', 'asc', 'co.id', '', '');
						
						foreach($courses as $key=>$value)
						{
							$course_ids[] = $value['id'];
						}
						$is_expired = $this->home_model->is_expired($course_ids,$user_id);
						
						$i=0;
						foreach($courses as $course){
							$is_cancelled =  $this->home_model->is_cancelled($course['id'],$user_id);
							if(isset($is_expired[$course['id']]))
							{
								$expired_val = $is_expired[$course['id']];
							}					
													
							$year = $course['duration']/12;
							if($course['duration'] > 1 && $year<1)
							{
								$course_duration =  $course['duration']." Months";
							}else if($year == 1)
							{
								$course_duration = $year." Year";
							} else if($year > 1)
							{
								$year_acc=(string)strpos($year,".");
								if($year_acc!=""){
									$year=number_format($year,1);
								}
								$course_duration = $year.' Years';
							}else if($course['duration'] == 1)
							{ 
								$course_duration = ($course['duration']*30)." Days";
						 	}else
						 	{ 
							 	$course_duration = "";
						 	}
							$data[$i]['id'] = $course['id'];
							$data[$i]['name'] = $course['name'];
							$data[$i]['currency_type'] = $course['currency_type'];
							$data[$i]['price'] = number_format(round($course['price']));
							$data[$i]['usd'] = number_format(round($course['price_d']));
							$data[$i]['course_category_id'] = $course['course_category_id'];
							$data[$i]['order'] = $course['order_by_category'];
							$data[$i]['category'] = $course['category'];
							if($course['name'] == 'foundation'||$course['name'] == 'Foundation')
							{
								$data[$i]['course_image'] = base_url().'appdata/Landing_page_icons/foundation_logo.png';
							}elseif($course['name'] == 'Advanced'||$course['name'] == 'advanced')
							{
								$data[$i]['course_image'] = base_url().'appdata/Landing_page_icons/advance_icon.png';
							}elseif($course['name'] == 'Elite'||$course['name'] == 'elite')
							{
								$data[$i]['course_image'] = base_url().'appdata/Landing_page_icons/elite_logo.png';
							}else{
								$data[$i]['course_image'] = base_url().'appdata/Landing_page_icons/advance_icon.png';
							}
							$data[$i]['description'] = $course['description'];
							$data[$i]['course_type'] = $course['course_type'];
							$data[$i]['purchased_status'] = (in_array($course['id'],$purchased) && $expired_val==1) ? (($is_cancelled!="1")?"no":"yes") : "no";
							if(in_array($course['id'],$purchased) && $expired_val==1){
								$duration = $course['duration'];
								$current_time = time();
								$start_date = date('d/m/Y',$current_time);
								$expiry_count = strtotime("+$duration months", $current_time);
								if(round($course['price'])==0 and round($course['price_d'])==0){
									$data[$i]['duration'] = "";
								}else{									
									if($is_cancelled!="1"){ //modified
										$data[$i]['duration'] = $course_duration;
									}else{
										$data[$i]['duration'] = date('d/m/Y', strtotime($course['course_expiry_date']));
									}
								}
							}
							else
							{
								if(round($course['price'])==0 and round($course['price_d'])==0){
									$data[$i]['duration'] = "";
								}else{
									$data[$i]['duration'] = $course_duration;
								}
							}
							$i++;	
						}
						$result = array('success'=> 1 , 'message'=> 'course plan', 'data'=> $data);
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
	public function course_planlist(){ 
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_category = $this->input->post('course_category'); #n
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
						$where_purchase[] = array(FALSE,'status = 1');  
						$where_purchase[] = array(TRUE,'user_id',$user_id);  
						$purchasedCourses = $this->base_model->get_advance_list('user_plans', '', 'course_id', $where_purchase, '', 'id', '', '', '', '');
						foreach($purchasedCourses as $purchase){
							$purchased[] = $purchase['course_id'];
						}
						$course_fields = 'co.id,name,co.description,co.price,co.duration,co.course_type,
						co.course_category_id';
						$join_tables[] = array('courses as co','co.id = up.course_id');
						$join_tables[] = array('orders as o','o.id = up.order_id');
						$where_course[] = array(FALSE,'co.status = 1'); 
						$where_course[] = array(TRUE,'up.user_id',$user_id); 
						$where_course[] = array(TRUE,'o.order_status','1');
						$where_course[] = array(TRUE,'up.is_expired','1');
						$courses = $this->base_model->get_advance_list('user_plans up', $join_tables, $course_fields, $where_course, '', 'co.name', 'asc', 'up.course_id', '', '');
						
						foreach($courses as $key=>$value)
						{
							$course_ids[] = $value['id'];
						}
						$is_expired = $this->home_model->is_expired($course_ids,$user_id);
						
						$i=0;
						foreach($courses as $course){
							if(isset($is_expired[$course['id']]))
							{
								$expired_val = $is_expired[$course['id']];
							}
							
							$join_tables = array();
							$where_class = array();
							$data[$i]['id'] = $course['id'];
							$data[$i]['name'] = $course['name'];
							
							if($course['name'] == 'foundation'||$course['name'] == 'Foundation'||$course['course_category_id'] == 3)
							{
								$data[$i]['course_image'] = base_url().'appdata/course_img/normal_Foundation.png';
							}elseif($course['name'] == 'Advanced'||$course['name'] == 'advanced'||$course['course_category_id'] == 1)
							{
								$data[$i]['course_image'] = base_url().'appdata/course_img/normal_advanced.png';
							}elseif($course['name'] == 'Elite'||$course['name'] == 'elite'||$course['course_category_id'] == 2)
							{
								$data[$i]['course_image'] = base_url().'appdata/course_img/normal_elite.png';
							}else{
								$data[$i]['course_image'] = base_url().'appdata/course_img/normal_advanced.png';
							}
							$data[$i]['description'] = $course['description'];
							$data[$i]['purchased_status'] = (in_array($course['id'],$purchased) && $expired_val==1) ? "yes" : "no";
							
							$data[$i]['relevant_classes'] = array();
							$where_class[] = array(FALSE,'c.status = 1');  
							$where_class[] = array(TRUE,'rc.course_id',$course['id']);  
							$join_tables[] = array('classes as c','rc.class_id = c.id');
							$fields = 'rc.class_id class_id,c.name class_name';
							$purchasedClasses = $this->base_model->get_advance_list('relevant_classes rc', $join_tables, $fields, $where_class, '', 'id', '', '', '', '');
							$j=0;
							
							foreach($purchasedClasses as $class){
								$join_sub_tables = array();
								$where_subject = array();
								$data[$i]['relevant_classes'][$j]['class_id'] = $class['class_id'];
								$data[$i]['relevant_classes'][$j]['class_name'] = $class['class_name'];
								
								$data[$i]['relevant_classes'][$j]['relevant_subjects'] = array();
								$where_subject[] = array(FALSE,'s.status = 1');  
								$where_subject[] = array(TRUE,'rb.course_id',$course['id']);  
								$where_subject[] = array(TRUE,'rb.class_id',$class['class_id']);  
								$join_sub_tables[] = array('subjects as s','rb.subject_id = s.id');
								$subfields = 'rb.subject_id subject_id,s.name subject_name';
								$relevantSubjects = $this->base_model->get_advance_list('relevant_subjects rb', $join_sub_tables, $subfields, $where_subject, '', 's.sort_order', 'asc', 'rb.subject_id', '', '');
								
								$k=0;
								foreach($relevantSubjects as $subject){
									$data[$i]['relevant_classes'][$j]['relevant_subjects'][$k]['subject_id'] = $subject['subject_id'];
									$data[$i]['relevant_classes'][$j]['relevant_subjects'][$k]['subject_name'] = $subject['subject_name'];
									if($subject['subject_name'] == 'chemistry' || $subject['subject_name'] == 'Chemistry'){
										$data[$i]['relevant_classes'][$j]['relevant_subjects'][$k]['subject_image'] = base_url().'appdata/subject_img/btn_chemistry_normal.png';
									}elseif($subject['subject_name'] == 'physics' || $subject['subject_name'] == 'Physics'){
										$data[$i]['relevant_classes'][$j]['relevant_subjects'][$k]['subject_image'] = base_url().'appdata/subject_img/btn_physics_normal.png';
									}elseif($subject['subject_name'] == 'botany' || $subject['subject_name'] == 'Botany'){
										$data[$i]['relevant_classes'][$j]['relevant_subjects'][$k]['subject_image'] = base_url().'appdata/subject_img/btn_botany_normal.png';
									}elseif($subject['subject_name'] == 'zoology' || $subject['subject_name'] == 'Zoology'){
										$data[$i]['relevant_classes'][$j]['relevant_subjects'][$k]['subject_image'] = base_url().'appdata/subject_img/btn_zoology_normal.png';
									}elseif($subject['subject_name'] == 'english' || $subject['subject_name'] == 'English')
									{
										$data[$i]['relevant_classes'][$j]['relevant_subjects'][$k]['subject_image'] = base_url().'appdata/subject_img/btn_english_normal.png';
									}elseif($subject['subject_name'] == 'gk' || $subject['subject_name'] == 'GK')
									{
										$data[$i]['relevant_classes'][$j]['relevant_subjects'][$k]['subject_image'] = base_url().'appdata/subject_img/btn_gk_normal.png';
									}
									else{
										$data[$i]['relevant_classes'][$j]['relevant_subjects'][$k]['subject_image'] = base_url().'appdata/subject_img/btn_default_normal.png';
									}
									$k++;
								}
								
								
								$j++;
							}

							$i++;	
						}
						$result = array('success'=> 1 , 'message'=> 'course plan list', 'data'=> $data);
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
	public function buy_course(){
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id', 'trim|required');
			$this->form_validation->set_rules('course_type', 'course type', 'trim|required');
			$this->form_validation->set_rules('currency_type', 'currency type', 'trim|required');
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
						$course_type = $this->input->post('course_type');
						$currency_type = $this->input->post('currency_type');
						$purchaseCount = $this->webservice_model->getCount('user_plans',array('user_id' => $user_id, 'course_id' => $this->input->post('course_id'),'course_type'=>$course_type, 'status' => 1,'is_expired'=>'1'));
						$is_expired = $this->home_model->is_expired($this->input->post('course_id'),$user_id);
						$is_cancelled =  $this->home_model->is_cancelled($this->input->post('course_id'),$user_id); //modified
						if(isset($is_expired[$this->input->post('course_id')]))
						{
							$expired_val = $is_expired[$this->input->post('course_id')];
						}						
						if($purchaseCount == 0 or $is_cancelled!="1" or $expired_val!="1") {
							$purchased = $this->webservice_model->success($course_type, $user_id, $currency_type);
							if($purchased){
								$result = array('success'=> 1 , 'message'=> 'Subscribed to plan successfully ', 'order_id' => $purchased);
							}else{
								$result = array('success'=> 0 , 'message'=> 'some error occurred or invalid course');
							}
						}else{
							$result = array('success'=> 0 , 'message'=> 'This course has been already purchased by this user');	
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
	public function performance(){
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			$this->form_validation->set_rules('course_id', 'course id', 'trim|required');
			$this->form_validation->set_rules('class_id', 'class id', 'trim|required');
			$this->form_validation->set_rules('subject_id', 'subject id', 'trim|required');
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$course_id = $this->input->post('course_id');
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
						$correct_map=$this->webservice_model->check_mapping($course_id,$class_id,$subject_id);
						$type = $this->subjective_model->is_subjective($course_id);
						$cat_count = $this->subjective_model->category_select_list($course_id,$class_id,$subject_id);
						if($type['is_subjective']==1 && $cat_count != 0)
						{
							$data['is_subjective'] = '1';
						}
						else
						{
							$data['is_subjective'] = '0';
						}
						$total_questions = $this->webservice_model->subject_total_ques($user_id,$course_id,$class_id,$subject_id);
						$skipped = $this->webservice_model->subject_count_skipped($user_id,$course_id,$class_id,$subject_id);
						$correct = $this->webservice_model->subject_count_correct($user_id,$course_id,$class_id,$subject_id,1);
						$wrong = $this->webservice_model->subject_count_correct($user_id,$course_id,$class_id,$subject_id,0);
						$progress_enabled= $this->webservice_model->progress_test($user_id,$course_id,$class_id,$subject_id);
						$progress_levels= $this->webservice_model->total_progress_levels($course_id,$class_id,$subject_id);
						
						$percent = ($progress_enabled[2]/$progress_levels['counts'])*100;
						$data['performance_percent'] = round($percent);
						
						if($progress_enabled[1] != 0)
						{
							$data['is_progress'] = "TRUE";
						}
						else 
						{
							$data['is_progress'] = "FALSE";
						}
						foreach($progress_enabled[0] as $key=>$value)
						{
							$chapter_id = $value['chapter_id'];
							$chapter_name = $value['chapter_name'];
							$level_id = $value['level_id'];
							$level_name = $value['level_name'];
						}
						$total_wrong = $skipped['skip']+$wrong['counts'];
						$data['total_questions'] = $total_questions['counts'];
						$data['correct'] = $correct['counts'];
						$data['wrong'] = $total_wrong;
						$data['title'] = "";//Take a test on next topic
						$data['description'] = "";//Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						if($progress_enabled[1] != 0)
						{
						$data['chapter_id'] = $chapter_id;
						$data['chapter_name'] = $chapter_name;
						$data['level_id'] = $level_id;
						$data['level_name'] = $level_name;
						}
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
						if($data != "" && $correct_map!=0){
							$result = array('success'=> 1 , 'message'=> 'Dashboard','data'=>$data,'surprise_test'=>$res);
						}else if($correct_map == 0)
						{
							$result = array('success'=> 0 , 'message'=> 'Not Available');
						}else{
							$result = array('success'=> 0 , 'message'=> 'No Records Found');
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
	public function course_category(){
		
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
						 
						$categ_fields = 'cc.id,cc.description,cc.category'; 
						$where_course[] = array(FALSE,'cc.status = 1'); 
						$where_course[] = array(FALSE,'co.show_in_frontend = 1'); 
						$join_tables_cat[] = array('courses as co','co.course_category_id = cc.id','inner');
						$category = $this->base_model->get_advance_list('course_category cc', $join_tables_cat, $categ_fields, $where_course, '', 'cc.id', '', 'cc.id', '', '');
						$i=0;
						 
						foreach($category as $category_det){
							$data[$i]['id'] = $category_det['id'];
							$data[$i]['category'] = $category_det['category'];
							$data[$i]['description'] = $category_det['description'];
							if($category_det['category'] == 'foundation'||$category_det['category'] == 'Foundation')
							{
								$data[$i]['course_image'] = base_url().'appdata/Landing_page_icons/foundation_logo.png';
							}elseif($category_det['category'] == 'Advanced'||$category_det['category'] == 'advanced')
							{
								$data[$i]['course_image'] = base_url().'appdata/Landing_page_icons/advance_icon.png';
							}elseif($category_det['category'] == 'Elite'||$category_det['category'] == 'elite')
							{
								$data[$i]['course_image'] = base_url().'appdata/Landing_page_icons/elite_logo.png';
							}else{
								$data[$i]['course_image'] = base_url().'appdata/Landing_page_icons/advance_icon.png';
							} 
							$i++;	
						}
						$result = array('success'=> 1 , 'message'=> 'course plan category', 'data'=> $data);
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
