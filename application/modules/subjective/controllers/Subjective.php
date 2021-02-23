<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subjective extends MX_Controller
{
  	function __construct()
	{
		parent::__construct();
		$this->load->model(array('subjective_model','dashboard/dashboard_model','tests/tests_model')); 
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
	public function chapters($course_id="",$class_id="",$category_id="",$subject_id="")
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
		if($class_id !=''&&$class_id !="blank.html")		//set session for class
		{
		 $this->session->set_userdata('selected_class', $selected_class); 
		
		}
		$subjective = $this->subjective_model->is_subjective($course_id);
		if($subjective['is_subjective'] != 1)
		{
			redirect(base_url().'dashboard');
		}
		$subjects=$this->tests_model->relevant_subjects($course_id,$class_id);
		if(empty($subjects))
		{
			redirect(base_url().'dashboard');
		}
		$key = $subject_id;
		
		$keys = array_keys($subjects);
		if($key != '')
		{
			$data['current_subject'] = $key;
			$chapter_list=$this->subjective_model->chapter_list($course_id,$class_id,$key,$category_id);
		}
		else
		{
			$data['current_subject'] = $keys[0];
			$chapter_list=$this->subjective_model->chapter_list($course_id,$class_id,$keys[0],$category_id);
		}
		
		$category_list=$this->subjective_model->all_category();
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$selected_course_class = $this->dashboard_model->get_paid_courses_class($selected_course,"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$selected_course_class;
		$data["data_course"]['type'] = $subjective;
		$data['course'] = $course_id;
		$data['class'] = $class_id;
		$data['category'] = $category_id;
		$data['chapter_list'] = $chapter_list;
		$data['category_list'] = $category_list;
		$data['subjects'] = $subjects;
		$ad_page = $this->uri->segment(1);
		$ad_banner = $this->dashboard_model->get_ad($ad_page);
		$data['ad_banner'] = $ad_banner;
		$data['main_content'] = 'subjective/chapters';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
	}
	public function questions($course_id="",$class_id="",$category_id="",$subject_id="",$chapter_id="",$page_num = 1)
	{
		$subjective = $this->subjective_model->is_subjective($course_id);
		if($subjective['is_subjective'] != 1)
		{
			redirect(base_url().'dashboard');
		}
		$this->load->library('pagination');
		$config  = $this->config->item('pagination_subj');
	  	$config["base_url"] = base_url()."subjective/questions/".$course_id."/".$class_id."/".$category_id."/".$subject_id."/".$chapter_id;
	 	$data["per_page"] = $config["per_page"] = $this->config->item('subj_list', 'page_per_limit_subj'); 
	  	$config["uri_segment"] = 8;
	  	if($this->uri->segment(8)=="")
	  	{
	  	 	$data['current_page'] = 0;
	  	}
	  	else
	  	{
	  		$data['current_page'] = $this->uri->segment(8)-1;
	  	}
	  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
	  	$limit_start = $config['per_page'];	
		$user_arr=$this->session->userdata('user_is_logged_in');
		
		$data['selected_chapter']=$this->tests_model->chapter($chapter_id);
		$data['selected_subject']=$this->tests_model->subject($subject_id);
		$param = array('course_id'=>$course_id,
					   'class_id'=>$class_id,
					   'subject_id'=>$subject_id,
					   'chapter_id'=>$chapter_id,
					   'sub_category_id'=>$category_id);
		$question = $this->subjective_model->get_questions($param,$limit_start, $limit_end);
		if(empty($question)){
			redirect(base_url().'dashboard');
		}
		else
		{
			$data['question'] = $question;
		}
		$data['total_rows'] = $config['total_rows'] = count($this->subjective_model->get_questions($param));
		$this->pagination->initialize($config);
		$category_list=$this->subjective_model->category_select_list($course_id,$class_id,$subject_id,$chapter_id,"select");
		$data['type'] = $subjective;
		$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");
		$selected_course_class = $this->dashboard_model->get_paid_courses_class($course_id,"select");
		$data["data_course"]["course_arr"]=$course_paid;
		$data["data_course"]["class_arr"]=$selected_course_class;
		$data['course'] = $course_id;
		$data['class'] = $class_id;
		$data['category'] = $category_id;
		$data['chapter_list'] = $chapter_id;
		$data['subjects'] = $subject_id;
		$data['category_list'] = $category_list;
		$data['main_content'] = 'subjective/questions';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
	} 
	public function popup()
	{
		$course_id=$this->input->get("course_id");
		$class_id=$this->input->get("class_id");
		$data['category_list']=$this->subjective_model->category_list($course_id,$class_id);
		$data['type'] = $this->subjective_model->is_subjective($course_id);
		echo json_encode($data);
	}
	public function popup_content($course_id,$class_id)
	{
		$subjects = $this->tests_model->relevant_subjects($course_id,$class_id);
		$val = array_values($subjects);
		$data['first_sub'] = $val[0];
		$data['category_list'] = $this->subjective_model->all_category();
		$data['course_id'] = $course_id;
		$data['class_id'] = $class_id;
		$this->load->view("subjective/subjective_popup",$data);
	}
}
