<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller
{
 		 
	  	function __construct()
  		{
  			$this->load->library('session');
		parent::__construct();
		$this->load->model(array('dashboard_model','tests/tests_model','alerts/alerts_model','home/home_model','subjective/subjective_model')); 
		$this->load->model('base_model'); 
		
		$this->load->helper("function_helper");	
		if(!is_loggedin()) {
				redirect();	
			}
		$this->load->helper("profile_helper");
		if(!$this->session->has_userdata('user_is_logged_in'))
		{
			redirect(base_url());
		}		
		$user_details = $this->session->userdata('user_is_logged_in', 'user_id');	
		$result = is_user_active($user_details["user_id"]);		
		if($result["status"]==0){
			redirect(base_url()."home/logout");
		}
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		$this->load->helper("function");
		}
		
		public function index($page_num=1)
		{
			$this->load->library("Amchart_master");
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
			$data['standard_tests'] = $this->tests_model->get_surprise_test_class($d_course_id,$class_id);// id is course id
			foreach($subjects as $subject){
				$subj[$subject["id"]] = ucfirst($subject["name"]);
			}
			$data["subjects"]=$subj;
			$chapters = $this->dashboard_model->get_chapters_first($d_course_id, $d_subject_id, $class_id);
			foreach($chapters as $chapter){
				$chap[$chapter["id"]] = ucfirst($chapter["name"]);
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
			$data["chapter_name"]=ucfirst($d_chapter_name);
			/////////////
			$this->load->library('pagination');
			$config  = $this->config->item('pagination_dashboard');
		  	$config["base_url"]    = base_url()."dashboard";
		 	$data["per_page"] = $config["per_page"] = $this->config->item('materials', 'page_per_limit_dashboard'); 
		  	$config["uri_segment"] = 2;
		  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		  	$limit_start = $config['per_page'];	
		  	$data['total_rows'] = $config['total_rows'] = count($this->home_model->get_materials_dashboard($d_course_id, $class_id, $d_subject_id,$d_chapter_id));
			$this->pagination->initialize($config);		
			$data["page"]=$page_num;		
			$data["links"] = $this->pagination->create_links();
			////////////

			$downloads = $this->home_model->get_materials_dashboard($d_course_id, $class_id, $d_subject_id,$d_chapter_id,$limit_start, $limit_end);
			foreach($downloads as $key => $download){
				$downloads[$key]['files'] = $this->home_model->get_attachments($download['id'],'6');
			}
			$data['study_material'] = $downloads;
			$data['notices'] = $this->dashboard_model->get_notices($d_course_id, $class_id);
			$data["path"]=$this->config->item("download_materials");
			$data['main_content'] = 'dashboard/index';
			$data['page_title']  = 'E4U';  
			   // echo "<pre>";print_r($data);die;

			$this->session->set_userdata('selected_course',$d_course_id);
			$this->session->set_userdata('selected_class',$class_id);


			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
		}
		public function download_file($file_name=""){
			$this->load->helper('download');
			$data = file_get_contents($this->config->item("download_materials").$file_name); // Read the file's contents
			$name = $file_name;
			force_download($name, $data);
		}	

		public function ax_get_class(){
			$course_id=$this->input->post("course_id");
			$classes=$this->dashboard_model-> get_paid_courses_class($course_id,"select");
	 		 echo json_encode(array_flip($classes));
		}
		
		public function overall_status($course_id="",$class_id="", $subject_id = "", $level_id = "", $type=0)
		{	
		compare_session(1);	 
			$this->load->library("Amchart_master");
			$user_arr=$this->session->userdata('user_is_logged_in');	
			$course_paid=$this->dashboard_model->get_paid_course($user_arr["user_id"],"select");	
		 
			if(count($course_paid)==1){
				echo  $this->load->view('dashboard/no-data-dashboard',$data,TRUE);die; 	
			}
			
			$data["recive_course"]=$course_id;
			if($course_id == ""){
				if(count($course_paid)>=2){
					foreach($course_paid as $cid=>$name){
						if($cid!=""){
							$course_id = $cid;
							break;
						}
					}
				}
				$data["page"]="index";
			}else if($course_id != ""){
					$data["page"]="";
			}
			if($course_id!=""){
				$relevant_class=$this->tests_model->relevant_classes($course_id);
				$data["data_course"]["class_arr"]=$relevant_class;
			} 
			if($class_id==""){
				if(count($relevant_class)>=1){
					foreach($relevant_class as $id=>$name){
						if($id!=""){
							$class_id = $id;
							break;
						}
					}
				}					
			}
			$subjects = $this->dashboard_model->get_subjects($course_id, $class_id); 
			
			if($subject_id == ""){
				if(count($subjects)>0){
					foreach($subjects as $subject){
						$subject_id = $subject["id"]; 
						break;					
					}
				}
			}	
			$levels = $this->dashboard_model->get_levels($course_id, $class_id, $subject_id);
			 
			if($level_id == ""){
				if(count($levels)>0){
					foreach($levels as $level){
						$level_id = $level["id"];
						 
						break;					
					}
				}
			}			
			$sets = $this->dashboard_model->get_sets($course_id, $class_id, $user_arr["user_id"], $subject_id, $level_id, $type);
			$result = "";
			$count = count($sets);					
			
			$f = 1;
			 
			foreach($sets as $set){
				 $new_set[]=array("value"=>$set[0]["user_percent"],"name"=>$set[0]["name"]);
				$f++;
			}
			
			$data["filter_type"] = $class_id;
			$relevant_subject = $this->dashboard_model->getcount($user_arr["user_id"], $course_id, $class_id, "answer");
				
				
			$data["answer_list"]=$relevant_subject;
				
			$data["question_list"] = $this->dashboard_model->getcount($user_arr["user_id"], $course_id, $class_id, "question");		
			$data["total_chapters"] = $this->dashboard_model->get_chapters_details($course_id, $class_id);						
			$data["completed_chapters"] = $this->dashboard_model->get_chapters_details($course_id, $class_id, $user_arr["user_id"]);
		
			$data["subjects"]=$subjects;
			$data["sets"]=$sets;
			$data["levels"]=$levels;
						
			 
		 	$conf_Arr=array("capMaximum"=>100,
							"capMinimum"=> 0,
							"title"=> "",
							"step"=> 10,
							"autoGridCount"=> false,
							"includeGuidesInMinMax"=> true
							);
			$this->amchart_master->chart->addValueAxis("ValueAxis-1", $conf_Arr); 
			 
			 //set field name
			 
			$this->amchart_master->chart->setConfig("categoryField", "name"); 
			// Add the data for the chart to use
			$this->amchart_master->chart->setData($new_set); 
			// Add 2 graphs 
			$graphinfo = array(
				"balloonText" => "[Percentage]: [[value]] %", // Optional
			);
			$this->amchart_master->chart->addGraph("value", $graphinfo);  
			$chart_code=$this->amchart_master->chart->getCode();
			$data["chart"]=$chart_code; 
			$data["is_chart"]=count($new_set); 
			$data["cur_course_id"]=$course_id;
			$data["data_course"]["course_arr"]= $course_paid;
			if(count($course_paid)>1){
				$this->load->view('dashboard/overall_status',$data);
			}else{
				$this->load->view('dashboard/no-data-dashboard',$data);
			}			
		}
		
		public function performance_graph($course_id="",$class_id="", $subject_id = "", $chapter_id="",$level_id = "", $type=0){
			// compare_session(1);	
			$this->load->library("Amchart_master");
			$user_arr=$this->session->userdata('user_is_logged_in');		
			if($type==0){
				$levels = $this->dashboard_model->get_levels($course_id, $class_id,$subject_id); 
			} else{
				$levels = $this->dashboard_model->get_levels_completed($course_id, $class_id,$user_arr["user_id"],$subject_id); 
				$chapters = $this->dashboard_model->get_chapters($course_id, $class_id,$user_arr["user_id"],$subject_id);
			}
			if($level_id == ""||$level_id == "0"){
				if(count($levels)>0){
					foreach($levels as $level){
						$level_id = $level["id"];
						break;					
					}
				}
			}
			if($chapter_id == ""||$chapter_id == "0"){
				if(count($chapters)>0){
					foreach($chapters as $chapter){
						$chapter_id = $chapter["id"];
						break;					
					}
				}
			}		
			if($type==0){			
				$sets = $this->dashboard_model->get_sets($course_id, $class_id, $user_arr["user_id"], $subject_id, $level_id, $type); 
				$result = "";
				$count = count($sets);				
				$f = 1;			
				foreach($sets as $set){
					  $new_set[]=array("value"=>$set[0]["user_percent"],"name"=>$set[0]["name"]);
					$f++;
				}
			}else{
				$levels = $this->dashboard_model->levels($course_id, $class_id, $user_arr["user_id"], $subject_id, $chapter_id, $type); 
				$result = "";
				$count = count($levels);				
				$f = 1;			
				foreach($levels as $level){
					  $new_set[]=array("value"=>$level[0]["user_percent"],"name"=>$level[0]["name"]);
					$f++;
				}
			}
			$conf_Arr=array("capMaximum"=>100,
							"capMinimum"=> 0,
							"title"=> "",
							"step"=> 10,
							"autoGridCount"=> false,
							"includeGuidesInMinMax"=> true
							);
			$this->amchart_master->chart->addValueAxis("ValueAxis-1", $conf_Arr); 
			
			 //set field name
			$this->amchart_master->chart->setConfig("categoryField", "name"); 
			// Add the data for the chart to use
			$this->amchart_master->chart->setData($new_set); 
			// Add 2 graphs 
			$graphinfo = array(
				"balloonText" => "[Percentage]: [[value]] %", // Optional
			);
			$this->amchart_master->chart->addGraph("value", $graphinfo);  
			$chart_code=$this->amchart_master->chart->getCode();			
			$data["chart"] = $chart_code;
			$data["filter_level"] = $level_id;
			$data["filter_chapter"] = $chapter_id;
			$data["is_chart"]=count($new_set); 
			$data["type"]=$type;
			$data["sets"]=$sets;
			$data["levels"]=$levels;
			$data["chapters"]=$chapters; 
			$this->load->view('dashboard/performance_graph', $data);
		}
		public function thank_you(){
			$data['main_content'] = 'dashboard/thank-you';
			$data['page_title']  = 'E4U';
			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data); 
		}
		public function get_ajax_materials($page_num=1){
			$data = array();			
			$course_id = $this->input->post('course_id');
			$class_id = $this->input->post('class_id');
			$subject_id = $this->input->post('subject_id');
			$chapter_id = $this->input->post('chapter_id');

			/////////////
			$this->load->library('pagination');
			$config  = $this->config->item('pagination_dashboard');
		  	$config["base_url"]    = base_url()."dashboard/get_ajax_materials";
		 	$data["per_page"] = $config["per_page"] = $this->config->item('materials', 'page_per_limit_dashboard'); 
		  	$config["uri_segment"] = $page_num;
		  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		  	$limit_start = $config['per_page'];	
		  	$data['total_rows'] = $config['total_rows'] = count($this->home_model->get_materials_dashboard($course_id, $class_id, $subject_id,$chapter_id));
			$this->pagination->initialize($config);		
			$data["page"]=$page_num;		
			$data["links"] = $this->pagination->create_links();
			////////////
			// echo $page_num,$this->pagination->create_links();die;
			$downloads = $this->home_model->get_materials_dashboard($course_id, $class_id, $subject_id,$chapter_id,$limit_start, $limit_end);
			foreach($downloads as $key => $download){
				$downloads[$key]['files'] = $this->home_model->get_attachments($download['id'],'6');
			}
			$chapter_name = $this->dashboard_model->get_chapter($chapter_id);
			$data["chapter_name"]=ucfirst($chapter_name['name']);
			$data['study_material'] = $downloads;
			return $this->load->view('dashboard/study_materials', $data);
		}
		public function get_attachment(){
			$id = $this->input->post('id');
			$attachment = $this->home_model->get_attachment($id);
			echo json_encode($attachment);
		}
		public function request(){
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$subject_id = $this->input->post('subject_id');
				$data = array();
				$data['chapter_list'] = array();
				$data['chapter_list'] = $this->base_model->getSelectList('chapters', array('course_id' => $course_id, 'class_id' => $class_id, 'subject_id' => $subject_id));
				$data['chapter_list'] = array_flip($data['chapter_list']);
				echo json_encode($data);
		}
}
