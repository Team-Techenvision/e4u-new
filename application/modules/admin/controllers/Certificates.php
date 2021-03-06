<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Certificates extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','csv_import'));
		$this->load->language(array('flash_message','form_validation'), 'english');
		if(!$this->session->has_userdata('admin_is_logged_in'))
		{
			redirect(SITE_ADMIN_URI);
		}
		getSearchDetails($this->router->fetch_class());
		$this->load->helper('function_helper');
		$this->load->library('excel');
		$this->load->model(array('base_model','dashboard/dashboard_model','certificate_model')); 
	}
	public function index($page_num = 1)
	{  		
		$search_test_type_keyword  = isset($_POST['test_type'])?trim($_POST['test_type']):(isset($_SESSION['search_test_type'])?$_SESSION['search_test_type']:'');		
		$this->session->set_userdata('search_test_type', $search_test_type_keyword); 			
		$keyword_test_type_session = $this->session->userdata('search_test_type');
		if($keyword_test_type_session != ''){
			$keyword_test_type = $this->session->userdata('search_test_type');
		}else{
			isset($_SESSION['search_test_type'])?$this->session->unset_userdata('search_test_type'):'';
			$keyword_test_type = "";
		}
		$search_from_date_keyword  = isset($_POST['search_from_date'])?trim($_POST['search_from_date']):(isset($_SESSION['search_from_date'])?$_SESSION['search_from_date']:'');
		$this->session->set_userdata('search_from_date', $search_from_date_keyword); 			
		$keyword_from_date_session = $this->session->userdata('search_from_date');
		if($keyword_from_date_session != ''){
			$keyword_from_date = $this->session->userdata('search_from_date');
		}else{
			isset($_SESSION['search_from_date'])?$this->session->unset_userdata('search_from_date'):'';
			$keyword_from_date = "";
		}	
		
		$search_to_date_keyword  = isset($_POST['search_to_date'])?trim($_POST['search_to_date']):(isset($_SESSION['search_to_date'])?$_SESSION['search_to_date']:'');
		$this->session->set_userdata('search_to_date', $search_to_date_keyword); 			
		$keyword_to_date_session = $this->session->userdata('search_to_date');
		if($keyword_to_date_session != ''){
			$keyword_to_date = $this->session->userdata('search_to_date');
		}else{
			isset($_SESSION['search_to_date'])?$this->session->unset_userdata('search_to_date'):'';
			$keyword_to_date = "";
		}
		
	
		$search_course_keyword  = isset($_POST['search_course'])?trim($_POST['search_course']):(isset($_SESSION['search_course'])?$_SESSION['search_course']:'');			
		$this->session->set_userdata('search_course', $search_course_keyword); 
		$keyword_course_session = $this->session->userdata('search_course');
		if($keyword_course_session != ''){
			$keyword_course = $this->session->userdata('search_course');
		}else{
			isset($_SESSION['search_course'])?$this->session->unset_userdata('search_course'):'';
			$keyword_course = "";
		}
		
		$search_class_keyword  = isset($_POST['search_class'])?trim($_POST['search_class']):(isset($_SESSION['search_class'])?$_SESSION['search_class']:'');			
		$this->session->set_userdata('search_class', $search_class_keyword); 
		$keyword_class_session = $this->session->userdata('search_class');
		if($keyword_class_session != ''){
			$keyword_class = $this->session->userdata('search_class');
		}else{
			isset($_SESSION['search_class'])?$this->session->unset_userdata('search_class'):'';
			$keyword_class = "";
		}  
		
		$search_subject_keyword  = isset($_POST['search_subject'])?trim($_POST['search_subject']):(isset($_SESSION['search_subject'])?$_SESSION['search_subject']:'');
		$this->session->set_userdata('search_subject', $search_subject_keyword); 				
		$keyword_subject_session = $this->session->userdata('search_subject');
		if($keyword_subject_session != ''){
			$keyword_subject = $this->session->userdata('search_subject');
		}else{
			isset($_SESSION['search_subject'])?$this->session->unset_userdata('search_subject'):'';
			$keyword_subject = "";
		}
		
		$search_chapter_keyword  = isset($_POST['search_chapter'])?trim($_POST['search_chapter']):(isset($_SESSION['search_chapter'])?$_SESSION['search_chapter']:'');
		$this->session->set_userdata('search_chapter', $search_chapter_keyword); 				
		$keyword_chapter_session = $this->session->userdata('search_chapter');
		if($keyword_chapter_session != ''){
			$keyword_chapter = $this->session->userdata('search_chapter');
		}else{
			isset($_SESSION['search_chapter'])?$this->session->unset_userdata('search_chapter'):'';
			$keyword_chapter = "";
		}
		
		$search_name_keyword  = isset($_POST['search_name'])?trim($_POST['search_name']):(isset($_SESSION['search_name'])?$_SESSION['search_name']:'');			
		$this->session->set_userdata('search_name', $search_name_keyword); 
		$keyword_name_session = $this->session->userdata('search_name');
		if($keyword_name_session != ''){
			$keyword_name = $this->session->userdata('search_name');
		}else{
			isset($_SESSION['search_name'])?$this->session->unset_userdata('search_name'):'';
			$keyword_name = "";
		}
		
		
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config["base_url"] = base_url().SITE_ADMIN_URI."/certificates/index";
		$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		$config["uri_segment"] = 4;
		$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		$limit_start = $config['per_page'];
		$join_tables = array();
		$where = array();
		if($keyword_test_type!=""){					
			$where[] = array( TRUE, 'c.test_type', $keyword_test_type);
			$data['keyword_test_type'] = $keyword_test_type;
		}else{
			$data['keyword_test_type'] = "";
		}
		
		/*data coming from dashboard*/	
		$today_date=$this->input->get("date");#for current date only
		if($today_date!=""){
			$_SESSION["search_from_date"]=$today_date; 
			$keyword_from_date= $today_date;
			$data['keyword_from_date'] = $today_date;
		}	 
		if($today_date){
			$today=$today_date.' 00:00:00';
			$today_end=$today_date.' 23:59:59';
			$where[] = array( TRUE, 'c.created >=', $today);  
			$where[] = array( TRUE, 'c.created <=', $today_end);  
		}	



		if($keyword_from_date){
			if($keyword_to_date){
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "c.created >=",$from_date);
				$where[] = array( TRUE, "c.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;		
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_from_date." 23:59:59";
				$where[] = array( TRUE, "c.created >=",$from_date);
				$where[] = array( TRUE, "c.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;			
				$data['keyword_to_date'] = "";		
			}			
		}else{
			if($keyword_to_date){				
				$from_date = $keyword_to_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "c.created >=",$from_date);
				$where[] = array( TRUE, "c.created <=",$to_date);
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$data['keyword_to_date'] = "";
			}
			$data['keyword_from_date'] = "";
		}
		
		if($keyword_course!=""){					
			$where[] = array( TRUE, 'c.course_id', $keyword_course);
			$data['keyword_course'] = $keyword_course;
		}else{
			$data['keyword_course'] = "";
		}
		if($keyword_test_type!="2"){
			if($keyword_course!=""){
				$class_list = $this->certificate_model->getClasses($keyword_course);	  	
			  	if($class_list){
			  		$data['get_class'][''] = 'Select Class';
				  	foreach($class_list as $class){
				  		$data['get_class'][ucfirst($class['id'])] = $class['name'];
				  	}
			  	}		
			}	
			if($keyword_class){							
				$where[] = array( TRUE, 'c.class_id', $keyword_class);
				$data['keyword_class'] = $keyword_class;
			}else{
				$data['keyword_class'] = "";
			}
			
			if($keyword_course!="" and $keyword_class!=""){
				$subject_list = $this->certificate_model->getSubjects($keyword_course, $keyword_class);	  	
			  	if($subject_list){
			  		$data['get_subject'][''] = 'Select Subject';
				  	foreach($subject_list as $subject){
				  		$data['get_subject'][ucfirst($subject['id'])] = $subject['name'];
				  	}
			  	}		
			}
			if($keyword_subject){				
				$where[] = array( TRUE, 'c.subject_id', $keyword_subject);
				$data['keyword_subject'] = $keyword_subject;
			}else{
				$data['keyword_subject'] = "";
			}
			
			if($keyword_course!="" and $keyword_class!="" and $keyword_subject!=""){
				$chapter_list = $this->certificate_model->getChapters($keyword_course, $keyword_class, $keyword_subject);												
			  	if($chapter_list){
			  		$data['get_chapter'][''] = 'Select Chapter';
				  	foreach($chapter_list as $chapter){
				  		$data['get_chapter'][ucfirst($chapter['id'])] = $chapter['name'];
				  	}
			  	}		
			}
			if($keyword_chapter){							
				$where[] = array( TRUE, 'c.chapter_id', $keyword_chapter);
				$data['keyword_chapter'] = $keyword_chapter;
			}else{			
				$data['keyword_chapter'] = "";
			}
		}
		
		if($keyword_name)
		{
			$where[] = array( FALSE,"(u.first_name LIKE '%$keyword_name%' or u.email LIKE '%$keyword_name%' or concat (u.first_name,' ',u.last_name) LIKE '%$keyword_name%')");
			 
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}
		$fields = 'c.id,u.first_name,u.last_name,c.test_type,co.name as course_name,cl.name as class_name,su.name as subject_name,lv.name as level_name,c.created as issued_date,cha.name as chapter_name,c.test_id'; 
		$join_tables[] = array('user_plans as up','up.user_id = c.user_id');	
		$join_tables[] = array('courses as co','co.id = c.course_id');	
		$join_tables[] = array('classes as cl','cl.id = c.class_id');	
		$join_tables[] = array('subjects as su','su.id = c.subject_id');	
		$join_tables[] = array('chapters as cha','cha.id = c.chapter_id');	
		$join_tables[] = array('levels as lv','lv.id = c.level_id');	
		$join_tables[] = array('users as u','u.id = c.user_id');	
		$data['total_rows'] = $config['total_rows'] = $this->base_model->get_advance_list('certificate as c', $join_tables, $fields, $where, 'num_rows','','','c.id');
		$data['user_reports'] = $this->base_model->get_advance_list('certificate as c', $join_tables, $fields, $where, '', 'c.id', 'desc', 'c.id', $limit_start, $limit_end);			
		$this->pagination->initialize($config);
		$data['get_course'] = $this->base_model->getSelectList('courses');		
		$data['main_content'] = 'certificates/index';
		$data['page_title']  = 'Certificates Issued'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function reset()
	{
		$this->session->unset_userdata('search_from_date');			
		$this->session->unset_userdata('search_to_date');	
		$this->session->unset_userdata('search_name');
		$this->session->unset_userdata('search_test_type');
		$this->session->unset_userdata('search_course');
		$this->session->unset_userdata('search_class');	
		$this->session->unset_userdata('search_subject');
		$this->session->unset_userdata('search_chapter');
		redirect(base_url().SITE_ADMIN_URI.'/certificates/');
	}
	
	public function view($id = NULL)
	{
		$join_tables = array();
		$where = array();
		$join_tables[] = array('user_plans as up','up.user_id = u.id');
		$join_tables[] = array('courses as co','up.course_id = co.id');
		$join_tables[] = array("test_engagement te","te.user_id=u.id");
		$join_tables[] = array("test_details td","td.test_id=te.id");
		$join_tables[] = array("downloads d","d.user_id=u.id");
		$fields = 'u.id, concat(u.first_name," ",u.last_name) as user_name,u.email,co.name as course_name,u.created,COUNT(DISTINCT(te.id)) as progress_count,COUNT(DISTINCT(d.id)) as documents'; 
		$where[] = array( TRUE, 'u.id', $id);
		$where[] = array( TRUE, 'te.test_type', 1);
		$where[] = array( TRUE, 'te.result', 1);
		$where[] = array( TRUE, 'te.status', 1);
		$data['user_reports'] = $this->base_model->get_advance_list('users as u', $join_tables, $fields, $where,'row_array');
		$paid_courses = $this->dashboard_model->get_paid_course($id);
		foreach($paid_courses as $key=>$value)
		{
			$ret[] = $value['name'];
		}
		$data['course_name'] = implode(',',$ret);
		
		$data['main_content'] = 'user_reports/view';
	  	$data['page_title']  = 'User Reports';  
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
	public function export()
	{
		$header ="";
		$keyword_test_type = $this->session->userdata('search_test_type');
		if($keyword_test_type!=""){					
			$where[] = array( TRUE, 'c.test_type', $keyword_test_type);
			$data['keyword_test_type'] = $keyword_test_type;
		}else{
			$data['keyword_test_type'] = "";
		}
		$keyword_from_date = $this->session->userdata('search_from_date');
		$keyword_to_date = $this->session->userdata('search_to_date');
		if($keyword_from_date){
			if($keyword_to_date){
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "c.created >=",$from_date);
				$where[] = array( TRUE, "c.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;		
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$from_date = $keyword_from_date." 00:00:00";
				$to_date = $keyword_from_date." 23:59:59";
				$where[] = array( TRUE, "c.created >=",$from_date);
				$where[] = array( TRUE, "c.created <=",$to_date);
				$data['keyword_from_date'] = $keyword_from_date;			
				$data['keyword_to_date'] = "";		
			}			
		}
		else{
			if($keyword_to_date){				
				$from_date = $keyword_to_date." 00:00:00";
				$to_date = $keyword_to_date." 23:59:59";
				$where[] = array( TRUE, "c.created >=",$from_date);
				$where[] = array( TRUE, "c.created <=",$to_date);
				$data['keyword_to_date'] = $keyword_to_date;
			}else{
				$data['keyword_to_date'] = "";
			}
			$data['keyword_from_date'] = "";
		}
		$keyword_course = $this->session->userdata('search_course');
		if($keyword_course!=""){					
			$where[] = array( TRUE, 'c.course_id', $keyword_course);
			$data['keyword_course'] = $keyword_course;
		}else{
			$data['keyword_course'] = "";
		}

		if($keyword_test_type!="2"){	
			$keyword_class = $this->session->userdata('search_class');
			$keyword_subject = $this->session->userdata('search_subject');
			$keyword_chapter = $this->session->userdata('search_chapter');
			if($keyword_class){							
				$where[] = array( TRUE, 'c.class_id', $keyword_class);
				$data['keyword_class'] = $keyword_class;
			}else{
				$data['keyword_class'] = "";
			}	
			if($keyword_subject){				
				$where[] = array( TRUE, 'c.subject_id', $keyword_subject);
				$data['keyword_subject'] = $keyword_subject;
			}else{
				$data['keyword_subject'] = "";
			}
			if($keyword_chapter){							
				$where[] = array( TRUE, 'c.chapter_id', $keyword_chapter);
				$data['keyword_chapter'] = $keyword_chapter;
			}else{			
				$data['keyword_chapter'] = "";
			}
		}
		$keyword_name_session = $this->session->userdata('search_name');
		if($keyword_name)
		{
			$where[] = array( FALSE,"(u.first_name LIKE '%$keyword_name%' or u.email LIKE '%$keyword_name%' or concat (u.first_name,' ',u.last_name) LIKE '%$keyword_name%')");
			 
			$data['keyword_name'] = $keyword_name;
		}
		else{
			$data['keyword_name'] = "";
		}		
		$fields = 'c.id,concat(u.first_name," ",u.last_name) as user_name,c.test_type,co.name as course_name,cl.name as class_name,su.name as subject_name,lv.name as level_name,c.created as issued_date,cha.name as chapter_name,c.test_id'; 
		$join_tables[] = array('user_plans as up','up.user_id = c.course_id');	
		$join_tables[] = array('courses as co','co.id = up.course_id');	
		$join_tables[] = array('classes as cl','cl.id = c.class_id');	
		$join_tables[] = array('subjects as su','su.id = c.subject_id');	
		$join_tables[] = array('chapters as cha','cha.id = c.chapter_id');	
		$join_tables[] = array('levels as lv','lv.id = c.level_id');	
		$join_tables[] = array('users as u','u.id = c.user_id');	
		$data['user_reports'] = $this->base_model->get_advance_list('certificate as c', $join_tables, $fields, $where, '', 'c.id', 'desc', 'c.id');
		
		$header_arr = array('Certificate Type','User Name','Issued Date','Course Plan','Subject', 'Chapter', 'Level');

		foreach($header_arr as $head_title){
			$header .=  $head_title. "\t";    
		}		
		foreach($data['user_reports'] as $i=>$row)
		{		
			$line = '';		
			$single_row = array($row["test_type"]==1?"Progress":"Surprise", $row["user_name"], date("d-m-Y",strtotime($row["issued_date"])),
								$row["course_name"]!=""?$row["course_name"]:"N/A", $row["subject_name"]!=""?$row["subject_name"]:"N/A", 
								$row["chapter_name"]!=""?$row["chapter_name"]:"N/A", $row["level_name"]!=""?$row["level_name"]:"N/A");
		

			foreach( $single_row as $k=>$value ){
				if ( ( !isset( $value ) ) || ( $value == "" ) ){
				    $value = "0"."\t";
				}else{
				    $value = str_replace( '"' , '""' , $value );
				    $value = '"' . $value . '"' . "\t";
				}
				$line .= $value;
			}
			$data_exp .= trim( $line ) . "\n";
		} 
		
		$data_exp = str_replace( "\r" , "" , $data_exp );


		if ( $data_exp == "" ){
			$data_exp = "\n(0) Records Found!\n";                        
		}

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=e4u-CertificateReports.xlsx");
		header("Pragma: no-cache");
		header("Expires: 0");

		print "$header\n$data_exp";
		exit;
	}
	public function generate_certificate($test_id="")
		{
			 
			$data['certificate_details']=$this->certificate_model->get_certificate_details($test_id);
			
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
			$this->m_pdf->pdf->Output("appdata/pdfs/".$pdfFilePath,'F');
			//$this->send_certificate($pdfFilePath,$data['certificate_details']['user_id']);
		    $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		    //for view and save
		    //$this->m_pdf->pdf->Output($pdfFilePath,"I"); 
			exit;
		
		}
		
		public function send_certificate($pdfFilePath,$user_id){
			
			
			/* Send email to user */
			// get user details
				$cond_user = array();
				$cond_user[] = array(TRUE, 'id', 7 ); 
				$user_detail = $this->base_model->get_records('users','id,first_name,last_name,email', $cond_user, 'row_array');  			
				$user_email = $user_detail["email"];
				$user_name =  $user_detail["first_name"]." ". $user_detail["last_name"];
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
				$this->email->from("noreply@e4u.com","e4u");
				$this->email->to($user_email);
				$this->email->subject($mailcontent['subject']);
				$this->email->message($mailcontent['email_content']);
				$this->email->attach('appdata/pdfs/'.$pdfFilePath); 
				$result= $this->email->send();
				@unlink('appdata/pdfs/'.$pdfFilePath);	
			
		}
		
		public function request(){
			$data = array();
			$data['class_list'] = array();			
			$course_id = $this->input->post('course_id');
		  	$class_list = $this->certificate_model->getClasses($course_id);	  	
		  	if($class_list){
			  	foreach($class_list as $class){
			  		$data['class_list'][ucfirst($class['name'])] = $class['id'];
			  	}
		  	}
			echo json_encode($data);
		}
		
		public function request1(){
			$data = array();			
			$data['subject_list'] = array();
			$course_id = $this->input->post('course_id');
			$class_id = $this->input->post('class_id');
		  	$subject_list = $this->certificate_model->getSubjects($course_id, $class_id);	  			  	
		  	if($subject_list){
				foreach($subject_list as $subject){
			  		$data['subject_list'][ucfirst($subject['name'])] = $subject['id'];
			  	}
		  	}		  		  	
			echo json_encode($data);
		}
		
		public function request2(){
			$data = array();			
			$data['chapter_list'] = array();
			$course_id = $this->input->post('course_id');
			$class_id = $this->input->post('class_id');
			$subject_id = $this->input->post('subject_id');
		  	$chapter_list = $this->certificate_model->getChapters($course_id, $class_id, $subject_id);	  			  	
		  	if($chapter_list){
				foreach($chapter_list as $chapter){
			  		$data['chapter_list'][ucfirst($chapter['name'])] = $chapter['id'];
			  	}
		  	}		  		  			  	
			echo json_encode($data);
		}
		
		public function request3(){
			$data = array();			
			$data['level_list'] = array();
			$course_id = $this->input->post('course_id');
			$class_id = $this->input->post('class_id');
			$subject_id = $this->input->post('subject_id');
			$chapter_id = $this->input->post('chapter_id');
		  	$level_list = $this->certificate_model->getLevels($course_id, $class_id, $subject_id, $chapter_id);	 		  	
		  	if($level_list){
				foreach($level_list as $level){
			  		$data['level_list'][ucfirst($level['name'])] = $level['id'];
			  	}
		  	}		  		  			  	
			echo json_encode($data);
		}
		
		public function request4(){
			$data = array();			
			$data['set_list'] = array();
			$course_id = $this->input->post('course_id');
			$class_id = $this->input->post('class_id');
			$subject_id = $this->input->post('subject_id');
			$chapter_id = $this->input->post('chapter_id');
			$level_id = $this->input->post('level_id');
		  	$set_list = $this->certificate_model->getSets($course_id, $class_id, $subject_id, $chapter_id, $level_id);	 		  	
		  	if($set_list){
				foreach($set_list as $set){
			  		$data['set_list'][ucfirst($set['name'])] = $set['id'];
			  	}
		  	}		  		  			  	
			echo json_encode($data);
		}

		public function get_questions(){
			$data = array();			
			$course_id = $this->input->post('course_id');
			$class_id = $this->input->post('class_id');
			$subject_id = $this->input->post('subject_id');
			$chapter_id = $this->input->post('chapter_id');
			$uri_segment_edit_question = $this->input->post('uri_segment_edit_question');
			$tags = $this->input->post('tags[]');
			  if($uri_segment_edit_question == "edit"){
				$questions = $this->certificate_model->getQuestionsSelected($course_id, $class_id, $subject_id, $chapter_id);
			  }else{
				$questions = $this->certificate_model->getQuestions($course_id, $class_id, $subject_id, $chapter_id, $tags);	
			  }
		  	if($questions){
				$data['questions'] = $questions;
			}
			$buildArray = [];	
			$i = 0;
			foreach($data['questions'] as $v){
				$Qurl = $this->config->item('questions_url').$v['question'];	
				$Eurl = $this->config->item('explanation_url').$v['explanation'];		
				$buildArray[$i][] = $v['id'];
				$buildArray[$i][] = $v['question_title'];
				$buildArray[$i][] = $Qurl;
				$buildArray[$i][] = $v['explanation_title'];
				$buildArray[$i][] = $Eurl;
				$buildArray[$i][] = $v['tags'];
				$buildArray[$i][] = $v['is_selected'];
				$i++;	
			}
			 echo json_encode($buildArray);		  	
		}

		public function get_questions_std(){
			$data = array();			
			$course_id = $this->input->post('course_id');
			$test_id = $this->input->post('test_id');
			$tags = $this->input->post('tags[]');
			$subject_id = $this->input->post('subject_id');
			$uri_segment_edit_standard = $this->input->post('uri_segment_edit_standard'); 
			if($uri_segment_edit_standard == 'edit'){
				$questions = $this->certificate_model->getQuestionsSelectedStd($course_id, $test_id, $subject_id);
			}else {
				$questions = $this->certificate_model->getQuestionStd($course_id, $test_id ,$tags);	
			}
		  	if($questions){
				$data['questions'] = $questions;
			  }
			$buildArray = [];	
			$i = 0;
			foreach($data['questions'] as $v){
				$Qurl = $this->config->item('questions_url').$v['question'];	
				$Eurl = $this->config->item('explanation_url').$v['explanation'];		
				$buildArray[$i][] = $v['id'];
				$buildArray[$i][] = $v['question_title'];
				$buildArray[$i][] = $Qurl;
				$buildArray[$i][] = $v['explanation_title'];
				$buildArray[$i][] = $Eurl;
				$buildArray[$i][] = $v['tags'];
				$buildArray[$i][] = $v['is_selected'];
				$i++;	
			}
			 echo json_encode($buildArray);			  		  	
			//$this->load->view('surprise_questions/search', $data); 
		}

}
