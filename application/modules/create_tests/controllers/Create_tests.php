<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Create_tests extends MX_Controller
{
  	function __construct()
	{
		parent::__construct();
		$this->load->helper("function_helper");	
		if(!is_loggedin()) {
				redirect();	
			}

		$this->load->model(array('create_tests_model','tests/tests_model','dashboard/dashboard_model','subjective/subjective_model','leaderboard/leaderboard_model','home/home_model')); 
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
		if($_SERVER['HTTP_REFERER']=="")
		{			
			redirect(base_url()."dashboard");
		}
		$this->load->helper("profile_helper");
		compare_session();
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		 
	}
	public function index($page_num=1)
	{
			$user_arr=$this->session->userdata('user_is_logged_in');	
			$join_tables= array();
			$fields = 'class_id, free_trial_expiry_date ';
			$where[] = array(TRUE,'u.id',$user_arr["user_id"]);  
			$user_class_id = $this->base_model->get_advance_list('users as u', $join_tables,$fields, $where, 'row', '', '', array('u.id'));
			$class_id = $user_class_id->class_id;	
				
				$current_date = date('Y-m-d');
				$free_trial_exp_date = $user_class_id->free_trial_expiry_date;
				$datetime1 = date_create($current_date); 
				$datetime2 = date_create($free_trial_exp_date); 
				$interval = date_diff($datetime1, $datetime2); 
				$trial =$interval->format('%R%a');

			$ad_page = $this->uri->segment(1);
			$ad_banner = $this->dashboard_model->get_ad($ad_page);
			$data['ad_banner'] = $ad_banner;
			
			$course = $this->dashboard_model->get_paid_course($user_arr["user_id"]);		 
			if(count($course) > 0){
					$d_course_id = $course['id'];
					$data["course_arr"]=$course;
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
					$course = $this->home_model->course_detail($get_course_id);

				if( $trial < 0){
					 $this->session->set_flashdata('free_trial_expired', 'Your Free trial for '. $course['name'].'course plan is expired. Please subscribe to continue.');
					 redirect(base_url()."subscribe");
				}else{
					$d_course_id = $get_course_id;
					$data["course_arr"]=$course;
				}
			}
			$dashboard_class=$this->tests_model->relevant_classes($d_course_id);
			$subjects = $this->dashboard_model->get_subjects($d_course_id, $class_id);
			$d_subject_id = "";
			if(count($subjects)>0){
				foreach($subjects as $subject){
					$d_subject_id = $subject["id"]; //first subject id
					break;					
				}
			}		
			$result = "";
			$data['class_id'] =$class_id;
			foreach($subjects as $subject){
				$subj[$subject["id"]] = ucfirst($subject["name"]);
			}
			$data["d_subject_id"] = $d_subject_id;
			$data["subjects"]=$subj;
			$chapters = $this->create_tests_model->get_chapters_first($d_course_id, $d_subject_id, $class_id);
			foreach($chapters as $chapter){
				$chap[ucfirst($chapter['subject_id'])][$chapter["id"]] = ucfirst($chapter["name"]);
			}

			$data["chapters"] = $chap;
			$d_chapter_id = "";
			if(count($chapters)>0){
				foreach($chapters as $ch){
					$d_chapter_id = $ch["id"]; //first chapter id
					$d_chapter_name = ucfirst($ch["name"]); //first chapter name
					break;					
				}
			}	
			$data['sel_chapters'] =array();

			$data['main_content'] = 'create_tests/index';
			$data['page_title']  = 'E4U';  
			// echo "<pre>";print_r($data);die;
			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
		}

		public function request(){
			$course_id = $this->input->post('course_id');
			$class_id = $this->input->post('class_id');
			$subject_id = $this->input->post('subject_id');
			$chapters_id = $this->input->post('chapter_id');
			
			
			$data = array();
			$chapters = $this->create_tests_model->get_chapters($course_id,$class_id,$subject_id);
			foreach($chapters as $chapter){
				$chap[ucfirst($chapter['subject_id'])][$chapter["id"]] = ucfirst($chapter["name"]);
			}
			$data["chapters"] = $chap;

			$subjects = $this->dashboard_model->get_subjects($course_id, $class_id);
			foreach($subjects as $subject){
				$subj[$subject["id"]] = ucfirst($subject["name"]);
			}
			$data["subjects"]=$subj;
			$data['sel_chapters'] = array();
			$data['sel_chapters'] = explode(',',$chapters_id);
			
			
			$this->load->view('create_tests/chapters_list',$data);
		}

}
