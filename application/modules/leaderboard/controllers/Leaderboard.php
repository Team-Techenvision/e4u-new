<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Leaderboard extends MX_Controller
{
	  	function __construct()
  		{
  			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
    		 if(!$this->session->has_userdata('user_is_logged_in'))
			 {
				 redirect(base_url());
			 }
			$this->load->model('home/home_model'); 
			$this->load->model('tests/tests_model'); 
			$this->load->model('dashboard/dashboard_model'); 
			$this->load->model('leaderboard_model'); 
			$this->load->helper('thumb_helper');
			$this->load->helper('html');
			$this->load->helper("profile_helper");
			compare_session(1);
		}
		public function index($type="")
		{
			$user_arr=$this->session->userdata('user_is_logged_in');	

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
			$data['course_id'] = $d_course_id;
			$standard_tests = $this->tests_model->get_surprise_test_class($d_course_id,$class_id);// id is course id

			// print_r($standard_tests);die;
			
				// $tests[""]="Standard Test Name";
			foreach($standard_tests as $std_test){
				$tests[$std_test["id"]] = ucfirst($std_test["test_name"]);
			}
			foreach($standard_tests as $std_test){
				$first_test[] = $std_test["id"];
				break;
			}
			// print_r($first_test);die;
			$data['standard_tests'] = $tests;
			$progress_participant = $this->leaderboard_model->get_participants($first_test[0]);
			$data['filter_type'] = $type;
  
			$sort = array();
			foreach($progress_participant as $k=>$v) {
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
			array_multisort($sort['progress_count'], SORT_DESC, $sort['questions'], SORT_DESC, $sort['accuracy'], SORT_DESC, $sort['speed'], SORT_DESC,$progress_participant); 
			$data['participants'] = $progress_participant;
			$data['main_content'] = 'leaderboard/index';
			$data['page_title']  = 'e4u'; 
			// echo "<pre>";print_r($data);die;
			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
		}
		public function tips($user_id)
		{
			$data['tips'] = $this->leaderboard_model->get_tips($user_id);
			$this->load->view('leaderboard/performancetips-popup',$data);
		}

		public function get_participants()
		{
			$std_test_id = $this->input->post('std_test_id');
			$progress_participant = $this->leaderboard_model->get_participants($std_test_id);
			$sort = array();
			foreach($progress_participant as $k=>$v) {
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
			array_multisort($sort['progress_count'], SORT_DESC, $sort['questions'], SORT_DESC, $sort['accuracy'], SORT_DESC, $sort['speed'], SORT_DESC,$progress_participant); 
			$data['participants'] = $progress_participant;
			$this->load->view('leaderboard/content_leaderboard',$data);
		}
		
}
