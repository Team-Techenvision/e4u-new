<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribe extends MX_Controller
{
 		 
	  	function __construct()
  		{
		parent::__construct();
		$this->load->model(array('subscribe_model','tests/tests_model','alerts/alerts_model','home/home_model','subjective/subjective_model')); 
		$this->load->model('base_model'); 

		$this->load->helper("function_helper");	
		$this->load->helper("profile_helper");
		$this->load->helper("function_helper");	
		if(!is_loggedin()) {
				redirect();	
			}

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
		
		public function index($page="")
		{
			// compare_session();	
			$this->load->library("Amchart_master");
			$user_arr=$this->session->userdata('user_is_logged_in');	
			$data["page"]=$page;					
			$ad_page = $this->uri->segment(1);
			$ad_banner = $this->subscribe_model->get_ad($ad_page);
			$data['ad_banner'] = $ad_banner;
			
			$course_fields = 'id,name,image,short_description, description,currency_type,price,duration';
			$where_course[] = array(FALSE,'status = 1');  

			$data['courses'] = $this->base_model->get_advance_list('courses', '', $course_fields, $where_course, '', 'id', '', '', '3', '');
			$data['currency'] = $this->config->item('currency_symbol');

			$result=$this->home_model->get_page_content('registration-benefits');
			if($result->num_rows()!=0){
				$data["reg_benefits"]=$result->row_array();	
			}

			$userplan_fields = 'user_id,course_id';
			$where_plan[] = array(FALSE,'status = 1');  
			$where_plan[] = array(TRUE,'user_id',$user_arr['user_id']);  
			$data['courses_check'] = $this->base_model->get_advance_list('user_plans', '', $userplan_fields, $where_plan, '', 'id', '', '', '', '');
			
			$testi_fields = 'id,user_name,about_client,user_description,user_image';
			$where_testi[] = array(FALSE,'status = 1');  
			$data['testi'] = $this->base_model->get_advance_list('testimonials', '', $testi_fields, $where_testi, '', 'id', 'desc', '', '5', '');
			

			/*added for plan */
			if(count($user_arr)){
				$cond = array();
				$cond[] = array(TRUE, 'id', $user_arr['id']); 
				$data['user_data'] = $this->base_model->get_records('users','class_id,free_trial_expiry_date', $cond, 'row_array');
	 

				if(!is_loggedin()) {
						redirect();	
				}
				$data['user_is_logged_in'] = 1;
				$courses = $data['courses'];
				foreach($courses as $key=>$value)
				{
					$course_ids[] = $value['id'];
				}
				$data['course_relevant_classes'] = $this->home_model->course_relevant_classes($course_ids);
				$data['is_expired'] = $this->home_model->is_expired($course_ids,$user_arr['user_id']);
				$data['check_purchased'] = $this->home_model->check_purchased($user_arr["user_id"]); //returns id 
			}
			/*added for plan */



			$data["is_chart"]=count($new_set); 			
 			$data['main_content'] = 'subscribe/index';
			$data['page_title']  = 'e4u';  
			//print_r($data);die;
			
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
			$classes=$this->subscribe_model-> get_paid_courses_class($course_id,"select");
	 		 echo json_encode(array_flip($classes));
		}
		
		public function overall_status($course_id="",$class_id="", $subject_id = "", $level_id = "", $type=0)
		{	
		// compare_session(1);	 
			$this->load->library("Amchart_master");
			$user_arr=$this->session->userdata('user_is_logged_in');	
			$course_paid=$this->subscribe_model->get_paid_course($user_arr["user_id"],"select");	
		 
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
			$subjects = $this->subscribe_model->get_subjects($course_id, $class_id); 
			
			if($subject_id == ""){
				if(count($subjects)>0){
					foreach($subjects as $subject){
						$subject_id = $subject["id"]; 
						break;					
					}
				}
			}	
			$levels = $this->subscribe_model->get_levels($course_id, $class_id, $subject_id);
			 
			if($level_id == ""){
				if(count($levels)>0){
					foreach($levels as $level){
						$level_id = $level["id"];
						 
						break;					
					}
				}
			}			
			$sets = $this->subscribe_model->get_sets($course_id, $class_id, $user_arr["user_id"], $subject_id, $level_id, $type);
			$result = "";
			$count = count($sets);					
			
			$f = 1;
			 
			foreach($sets as $set){
				 $new_set[]=array("value"=>$set[0]["user_percent"],"name"=>$set[0]["name"]);
				$f++;
			}
			
			$data["filter_type"] = $class_id;
			$relevant_subject = $this->subscribe_model->getcount($user_arr["user_id"], $course_id, $class_id, "answer");
				
				
			$data["answer_list"]=$relevant_subject;
				
			$data["question_list"] = $this->subscribe_model->getcount($user_arr["user_id"], $course_id, $class_id, "question");		
			$data["total_chapters"] = $this->subscribe_model->get_chapters_details($course_id, $class_id);						
			$data["completed_chapters"] = $this->subscribe_model->get_chapters_details($course_id, $class_id, $user_arr["user_id"]);
		
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
				$levels = $this->subscribe_model->get_levels($course_id, $class_id,$subject_id); 
			} else{
				$levels = $this->subscribe_model->get_levels_completed($course_id, $class_id,$user_arr["user_id"],$subject_id); 
				$chapters = $this->subscribe_model->get_chapters($course_id, $class_id,$user_arr["user_id"],$subject_id);
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
				$sets = $this->subscribe_model->get_sets($course_id, $class_id, $user_arr["user_id"], $subject_id, $level_id, $type); 
				$result = "";
				$count = count($sets);				
				$f = 1;			
				foreach($sets as $set){
					  $new_set[]=array("value"=>$set[0]["user_percent"],"name"=>$set[0]["name"]);
					$f++;
				}
			}else{
				$levels = $this->subscribe_model->levels($course_id, $class_id, $user_arr["user_id"], $subject_id, $chapter_id, $type); 
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
		
}
