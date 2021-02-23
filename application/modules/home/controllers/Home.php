<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		 
		$this->load->library('form_validation');		
		$this->load->helper('payment_helper');	
		$this->load->helper("profile_helper");	
		$this->load->language(array('flash_message','form_validation'), 'english');			
		$this->load->model('base_model'); 
		$this->load->model(array('home_model','cron/Cron_model'));
		// if($this->uri->segment(2)!="logout"){
		// 	compare_session();	
		// }
		$this->load->helper("function_helper");	
		
		
	}
	public function index($type="")
	{ 	
		//echo $type;die;
		if($type=="about-us"){ 
			$this->cms_page($type);die;
		}
		if($type=="why-e4u"){ 
			$this->cms_page($type);die;
		}
		if($type=="conditions"){ 
			$this->cms_page($type);die;
		}
		if($type=="privacy-policy"){ 
			$this->cms_page($type);die;
		}
		if($type=="neet"){ 
			$this->cms_page($type);die;
		}
		$pages_types=array("reset_password","login","downloads");
		if($type!=""&&!in_array($type,$pages_types)){
			
		 redirect(base_url()."page_not_found");
		}
		
		$user_arr=$this->session->userdata('user_is_logged_in');
		//print_r($user_arr);die;
		
		if($type=="reset_password"){

			$ref = base64_decode($this->input->get('ref'));
			$data["type_mode"]=$type;
			$data["ref"] = $ref;
			
			$cond = array();
			$cond[] = array(TRUE, 'id', $ref ); 
			$uid = $this->base_model->get_records('users','uid_request_date,uid_status', $cond, 'row_array');
 
			$current_date = date("Y-m-d",time()) ;
     		$uid_date = date("Y-m-d",strtotime($uid['uid_request_date']));
     		$diff = abs(strtotime($current_date) - strtotime($uid_date));
    		$days = floor($diff/(60*60*24));
				// print_r($days);
				// echo $uid['uid_status'];die;
    		
    		
			if($days >= 1 || $uid['uid_status'] == 0)
			{	
				$data['show_reset_modal']=2;

				//redirect(base_url().'home/index/login');  //link expiration for reset password
			}	
			else
			{	
				$data['show_reset_modal']=1;
				//$this->base_model->update('users', array('uid_status' => 0), array('id' => $ref));
			}
		}else{
			
			$data["ref"]="";
		}
		if($type=="login"){
			$data["type_mode"]=$type;
		}else if($type=="downloads"){
			$data["redirect_type"]=$type;
		}
		$where1 = 'bp.name = "home"'; 
		$page_fields = 'bp.id';
		$page_id = $this->base_model->getRow('banner_page as bp', $page_fields, $where1, $return = array('return' => 'row_object'), '');
		/**Ram:purpose to set value for id**/
		$id=count($page_id)>0?$page_id[0]->id:0;
		/**end**/
		$fields = 'bn.image,bn.url,bn.description';
		$join_tables[] = array('banner_page as bp','bn.page_id = bp.id');
		$where[] = array(FALSE,'bn.status = 1 and bn.page_id = '.$id);

		$data['banners'] = $this->base_model->get_advance_list('banners as bn', $join_tables, $fields, $where, '', 'bn.id', 'desc', '', '5', '');
		
		$course_fields = 'id,name,image,short_description, description,currency_type,price,duration';
		$where_course[] = array(FALSE,'status = 1');  
		$data['courses'] = $this->base_model->get_advance_list('courses', '', $course_fields, $where_course, '', 'id', '', '', '3', '');
		$data['currency'] = $this->config->item('currency_symbol');
		
		

		$testi_fields = 'id,user_name,user_description,user_image';
		$where_testi[] = array(FALSE,'status = 1');  
		$data['testi'] = $this->base_model->get_advance_list('testimonials', '', $testi_fields, $where_testi, '', 'id', 'desc', '', '5', '');

		$result=$this->home_model->get_page_content('registration-benefits');
		if($result->num_rows()!=0){
			$data["reg_benefits"]=$result->row_array();	
		}
		
		 // print_r($data);die;

		$data['main_content'] = 'home/index';
		$data['page_title']  = 'e4u';
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
			$this->load->view(SITE_LAYOUT_PATH, $data); 	
		

		
	}
	public function login()
		{
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				if($this->form_validation->run() == false){
					echo $this->form_validation->get_json(); die;
				}else{
					$extra_array = array();
					$email = $this->input->post('email');
					$password = $this->input->post('password');
					$remember = $this->input->post('remember');
					
					$where = array('email' => $email, 'password' => md5($password));
					$userexists = $this->base_model->getCount('users',$where);
					if($userexists!=0){

						// cookies start
							if(isset($remember)){
								setcookie('email', $email,time()+7200,'/');
								setcookie('password', $password,time()+7200,'/');
							}
							else if(!isset($remember)) {
								if(isset($_COOKIE['email']) || isset($_COOKIE['password'])) {
								$past = time() - 100;
								setcookie('email', gone, $past);
								setcookie('password', gone, $past);
								}
							}
						// cookies end

						$fields = 'id,first_name,last_name,email,status'; 
						$where_cond[] = array( TRUE, 'email', $email);
						$where_cond[] = array( TRUE, 'password', md5($password));
						$response = $this->base_model->get_advance_list('users','',$fields,$where_cond, 'row_array');
						if($response['status'] == 1){
						/* modified */
						$t = session_id(); 

						$time = date('Y-m-d H:i:s'); 
						$token = generate_token($response['id'].$time);


						$update_session_array = array ("session_id"=>$t , 'app_token' => $token);
						$this->base_model->update( 'users', $update_session_array, array('id'=>$response['id']));
						/* modified */
						

						$data = array('user_is_logged_in' => array(
							'id' => $response['id'],
							'username' => $response['first_name'],
						 	'user_id' => $response['id'],
							'display_name' => $response['first_name']." ".$response['last_name'],
							'email' => $response['email'],
							'last_login' => $time,
							'app_token' => $token,
							'session_id' =>$t  // modified
						));
						                      
						$this->base_model->adv_update('users',array('login_count'=>'login_count+1'),array("id"=>$response['id']), array("last_login_time"=>$time));
						$this->session->set_userdata($data);  						
						$order_counts = $this->home_model->get_ordercounts($response['id']);
						if($order_counts==0){
							$url = "home";
						}else{
							$url = "home";
						}
						if($this->session->userdata("last_url")!=""){
							$url=$this->session->userdata("last_url");
						}
						
						$extra_array = array('status'=>'success','msg'=>$this->lang->line('login_success'), 'url'=>$url);
						$this->session->set_flashdata('flash_message', $this->lang->line('login_success'));
						echo json_encode($extra_array);die;
						}else{
							$extra_array = array('status'=>'error-login','msg'=>$this->lang->line('login_inactive'));
							echo json_encode($extra_array);die;
						}
					}else{
						$extra_array = array('status'=>'error-login','msg'=>$this->lang->line('login_failure'));
						echo json_encode($extra_array);die;
					}
				}
			}
			$this->load->view('home/login');
		}
	public function logout($type="")
	{
		$session_userdata = array('user_is_logged_in');
		$this->session->unset_userdata($session_userdata);
		//modified for session mismacth alert end
		/*$multiuser_login = "";
		if($this->session->has_userdata('multilogin_alert')){
			$multiuser_login = 1;
		}		*/
		if (!$this->session->has_userdata('user_is_logged_in')) 
		{
			 $this->session->sess_destroy();
		}
		//modified for session mismacth alert end
		/*if($multiuser_login!=""){
			$this->session->set_userdata('multilogin_alert', 'Unauthorized Access Multiple connections to a server by the same user, using more than one user name, are not allowed. Disconnect all previous connections to the server or shared resource and try again.');			
		}	*/
		
		if($type!="")
		{
			redirect(base_url()."home/index/login");
		}
		else
		{
			redirect(base_url());
		}
	}
	public function useractive($uid){ 
		if($this->session->has_userdata('user_is_logged_in')){
			redirect(base_url().'/subscribe');
		}else{
			$count = $this->base_model->getCount('users', array('uid' => $uid));
			if ($count == 0) {
				$this->session->set_flashdata('failure','Your account is already activated.');
			}else {
				$update_data = array(
				'status' => 1,
				'uid' => ''
				);
				$update = $this->base_model->update('users', $update_data, array('uid' => $uid));
				if($update){
					$this->session->set_flashdata('success','Account activated successfully.');
				}
			}
			redirect(base_url()."home");
	  	} 
	}
	public function register()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			// if($this->input->post('steps') == 'step1'){
				$this->form_validation->set_message('regex_match','Please enter only alphabets and spaces.');
				$this->form_validation->set_rules('first-name', 'First Name', 'trim|required|regex_match[/^[a-zA-Z ]*$/]');
				$this->form_validation->set_rules('last-name', 'Last Name', 'trim|required|regex_match[/^[a-zA-Z ]*$/]');
				$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[users.email]|is_unique[admin_users.email]');
				$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
				$this->form_validation->set_rules('dob_date', 'date', 'trim|required');
				$this->form_validation->set_rules('dob_month', 'month', 'trim|required');
				$this->form_validation->set_rules('dob_year', 'year', 'trim|required');

				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[12]');
				$this->form_validation->set_rules('confirm-password', 'Confirm Password', 'trim|required|matches[password]');
				// $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			// }
			// if($this->input->post('steps') == 'step2'){
				$this->form_validation->set_rules('contact-number', 'Contact Number', 'trim|required|numeric|exact_length[10]');
				$this->form_validation->set_rules('contact-address', 'Contact Address', 'trim|required');
				$this->form_validation->set_rules('class_list', 'Class', 'trim|required');
				// $this->form_validation->set_rules('medium_list', 'Medium', 'trim|required');
				// $this->form_validation->set_rules('board_list', 'Board', 'trim|required');
			// }

			if($this->form_validation->run() == true){
			
				$created = date('Y-m-d H:i:s');
				$date = date('Y-m-d H:i:s');
				$date = strtotime($date);
				$date = strtotime("+7 day", $date);
				$exp_date = date('Y-m-d ', $date);


				$uid = rand();

				$settings = $this->home_model->get_settings();
				$trial = $settings->free_trail;

				$data = array('first_name' => $this->input->post('first-name'),
							  'last_name' => $this->input->post('last-name'),
							  'gender' => $this->input->post('gender'),
							  'email' => $this->input->post('email'),
							  'dob_date' => $this->input->post('dob_date'),
							  'dob_month' => $this->input->post('dob_month'),
							  'dob_year' => $this->input->post('dob_year'),
							  'password' => md5($this->input->post('password')),
							  'phone' => $this->input->post('contact-number'),
							  'address' => $this->input->post('contact-address'),
							  'class_id' => $this->input->post('class_list'),
							  'status' => 0,
							  'created' => $created,
							  'free_trial_expiry_date' => $exp_date,
							  'uid_request_date' => $created,
							  'uid' => $uid,
							  );
				$this->base_model->insert('users',$data);
				$cond = array();
				$cond[] = array(TRUE, 'id', 4 ); 

				$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');  
				/* email send to user */
				 $this->load->library('email');
				 	//added start
						$smtp_mail = $this->config->item('smtp_mail');
						$this->email->initialize($smtp_mail);
					//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");


				$email_config_data = array('[USERNAME]'=> $this->input->post('first-name'),
										   '[USER_EMAIL]' => $this->input->post('email'),
										   '[ACTIVELINK]' => $this->config->item('site_user_activate_url'). $uid,
										   '[SITE_NAME]' => $this->config->item('site_name'));
			  					   
				 $this->email->from($smtp_mail['smtp_user'],"E4U");
				 $this->email->to($this->input->post('email'));
				 $this->email->subject($mailcontent['subject']);
				
				
				
				foreach($email_config_data as $key => $value){
					$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
				}
				 $this->email->message($mailcontent['email_content']);
				 $result= $this->email->send();
				
				// $extra_array = array('status'=>'success','msg'=> 'successfully registerted');
				 $extra_array = array('status'=>'success','msg'=> 'successfully registerted');
				 $data['success_title'] = 'Congrats..! Registration done successfully..!';
				 $data['success_msg'] = 'Verification email is sent to your registered email id.Please verify your account to login.';
				//echo json_encode($extra_array);//die;
				}
		
		}
		$data['class_list'] = $this->base_model->getSelectList('classes');
		$data['main_content'] = 'home/register';
		$data['page_title']  = 'e4u - register'; 

		$this->load->view(SITE_REGISTER_LAYOUT_PATH, $data); 

		
		
	}
	public function success(){
		$this->load->view('home/success');
	}
	public function forgot_password()
	{
		$this->load->view('home/forgot_password');
	}

		public function success_forgot(){
			$this->load->view('home/success_forgot');
		}
	public function action_forgot_password()
	{
		//
		$valid_email="";
		$status_email="";
		$forgot_email = $this->input->get('email');
		$count = $this->base_model->getCount('users',array('email' => $forgot_email));
		if($count == 0){
			$valid_email=0;
		}else{	
			$valid_email=1;
			$uid = rand();
			$this->load->helper('date');
			$my_date = date("Y-m-d h:i:s", time());
			if($this->base_model->update('users', array('uid_request_date' => $my_date), array('email' => $forgot_email))){
				$cond = array();
				$cond[] = array(TRUE, 'email', $forgot_email ); 
				$maildetails = $this->base_model->get_records('users','id,concat(first_name," ", last_name) as username,email', $cond, 'row_array');   
				/* email send to user */
				$this->load->library('email');
			//added start
				$smtp_mail = $this->config->item('smtp_mail');
				$this->email->initialize($smtp_mail);
			//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");
				$encode = base64_encode($maildetails['id']);
				$cond = array();
				$cond[] = array(TRUE, 'id', 1 ); 
				$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');   


				$email_config_data = array('[USERNAME]'=> $maildetails['username'], 
										   '[PASSCODELINK]' => $this->config->item('site_resetpassword_url').$encode,
										   '[MAIL_TITLE]' =>$mailcontent['subject'],
										   '[SITE_NAME]' => $this->config->item('site_name'));
				$this->email->from($smtp_mail['smtp_user'],"E4U");
				$this->email->to($forgot_email);
				$this->email->subject($mailcontent['subject']);
				
			
				foreach($email_config_data as $key => $value){
					$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
				}
				
				$this->email->message($mailcontent['email_content'],$headers);
				$result= $this->email->send();
				
				if($result){
					$status_email=1;
					$this->base_model->update('users', array('uid_status' => 1), array('email' => $forgot_email));
					
				}else{
					$status_email=1;
					$this->base_model->update('users', array('uid_status' => 1), array('email' => $forgot_email));
				}
				// print_r($mailcontent['email_content']);die;
			}
		}
		$arr=array('valid_email'=>$valid_email,'email_sent'=>$status_email);
		echo json_encode($arr);
	}
	public function reset_password(){ 
		
		redirect(base_url()."/home/index/reset_password");
	}
	public function action_reset_password(){
		$count = "";
		$update = "";
		$reset_id = $this->input->get('id');
		$new_pass = $this->input->get('new_pass');
		$confirm_pass = $this->input->get('confirm_pass');
		$data = array();
		$count = $this->base_model->getCount('users', array('id' => $reset_id));
		if ($count == 0) {
			$count = 0;
		}else {
			$count = 1;
			$new_member_insert_data = array(
				'password' => md5($new_pass),
			);
			$update = $this->base_model->update('users', $new_member_insert_data, array('id' => $reset_id));
			$this->base_model->update('users', array('uid_status' => 0), array('id' => $reset_id));
			if($update){
				$update = 1;
			}
			else{
				$update = 1;
			}
		}
		$arr=array('valid_user'=>$count,'reset'=>$update);
		echo json_encode($arr);		
	}

	public function check_confirm_valid(){
		
		$user_arr=$this->session->userdata('user_is_logged_in');
		$user_id=$user_arr['user_id'];
		$confirm_valid = 0;
		$old_pass = $this->input->get('old_pass');
		$data = array();
		$count = $this->base_model->getCount('users', array('id' => $user_id,'password'=>md5($old_pass)));
		if ($count == 0) {
			$confirm_valid = 0;
		}else {
			$confirm_valid = 1;
		}
		$arr=array('confirm_valid'=> $confirm_valid);
		echo json_encode($arr);		
	}
	public function action_change_password(){
		$count = "";
		$update = "";
		$user_arr=$this->session->userdata('user_is_logged_in');
		$user_id=$user_arr['user_id'];
		$new_pass = $this->input->get('new_pass');
		$confirm_pass = $this->input->get('confirm_pass');
		$data = array();
		$count = $this->base_model->getCount('users', array('id' => $user_id));
		if ($count == 0) {
			$count = 0;
		}else {
			$count = 1;
			$new_member_insert_data = array(
				'password' => md5($new_pass),
			);
			$update = $this->base_model->update('users', $new_member_insert_data, array('id' => $user_id));
			if($update){
				$update = 1;
			}
			else{
				$update = 0;
			}
		}
		$arr=array('valid_user'=>$count,'changed_status'=>$update);
		echo json_encode($arr);		
	}

	
	public function category_detail($category_id)
	{	
		if($this->session->userdata('user_is_logged_in')){
			$user_arr=$this->session->userdata('user_is_logged_in');
		}
		$data['currency'] = $this->config->item('currency_symbol');
		$data['dollar_symbol'] = $this->config->item('dollar_symbol'); // modified
		$courses = $this->home_model->category_detail($category_id);
		foreach($courses as $key=>$value)
		{
			$course_ids[] = $value['id'];
		}
		$data['is_expired'] = $this->home_model->is_expired($course_ids,$user_arr['user_id']);
		$category_det = $this->home_model->get_category_details($category_id);
		$data['courses'] = $courses;
		$data['category_name'] = $category_det['category'];
		$data['check_purchased'] = $this->home_model->check_purchased($user_arr["user_id"]);
		$data['post'] = FALSE;
		
		$data['main_content'] = 'home/category_detail';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data); 
	}
	public function course_detail_popup($course_id)
	{
		$data['res_dates']=$this->Cron_model->get_dates();
		//print_r($data);die;
		// $category_det = $this->home_model->get_category_details($category_id);
		// $course_det = $this->home_model->cat_course_detail($category_id,$course_id);
		// $duration = $course_det['duration'];
		// $current_time = time();
		// $start_date = date('d/m/Y',$current_time);
		// $expiry_count = strtotime("+$duration months", $current_time);
		// $data['expiry_date'] = date('d/m/Y', $expiry_count); 
		// $data['start_date'] = $start_date;
		// $data['content_expiry_date'] = date('F d, Y', $expiry_count);
		// $data['content_start_date'] = date('F d, Y', $current_time);
		// $data['category_name'] = $category_det['category'];
		// $data['details'] = $course_det;
		// $data['course_type'] = $course_type;
		// $data['currency'] = $this->config->item('currency_symbol');
		// $data['dollar_symbol'] = $this->config->item('dollar_symbol');// modified

		
		$this->load->view('course_detail_popup',$data); 
	}
	public function payment($courseid) // modified
	{
		$coursename = $this->home_model->get_course_name($courseid);
		if($this->session->userdata('user_is_logged_in')){
			$user_arr=$this->session->userdata('user_is_logged_in');
		}
		if(!isset($user_arr["user_id"])){
			$this->session->set_userdata("last_url","home/payment/".$course_id);
			redirect(base_url()."home/index/login");
		}

		$check_purchased = $this->home_model->already_purchased($user_arr["user_id"],$courseid);
		$expired = $this->home_model->check_expiry($user_arr["user_id"],$courseid);
        
		if($check_purchased != 0 && $expired['is_expired']==1)
		{
			$this->session->set_flashdata('already_purchased', 'You have already purchased '. $coursename['course_name'].' course.');
			redirect(base_url()."dashboard/thank_you");
		}

		$response = $this->home_model->success_new($user_arr["user_id"],$courseid); // modified
       
		if(isset($response["merchant_id"])){ 
		
				$data['merchant_data'] = $response;
				
				$this->load->view('home/ccavRequestHandler',$data); 
				
				//Pls remove comments when you want to integrate payment getway and remove redirection to dashboard
				
				/* email send to user */
				
				$cond = array();
				$cond[] = array(TRUE, 'id', 6 );
				$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array');  
				$this->load->library('email');
				//added start
						$smtp_mail = $this->config->item('smtp_mail');
						$this->email->initialize($smtp_mail);
					//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");

				$email_config_data = array('[USERNAME]'=> $user_arr['display_name'],
										   '[COURSE_NAME]'=>$coursename['course_name'],
										   '[SITE_NAME]' => $this->config->item('site_name'));
			  					   
				$this->email->from($smtp_mail['smtp_user'],"E4U");
				$this->email->to($user_arr['email']);
				$this->email->subject($mailcontent['subject']);
				
				foreach($email_config_data as $key => $value){
					$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
				}
				$this->email->message($mailcontent['email_content']);
				$result= $this->email->send();
				/* email send to user */
				$this->base_model->update('users', array('class_change_counter' => 1), array('id' => $user_arr["user_id"]));

				$this->session->set_flashdata('payment_message', 'You have successfully purchased '. $coursename['course_name'].' course.');
				redirect(base_url().'dashboard/thank_you');
			}
			else{
				$this->session->set_flashdata('database_error', $response["msg"]);		
				redirect(base_url().'dashboard/payment_failed');				
			}
	}
	public function downloads(){
		$attachment=$this->home_model->get_materials();
		$data["attachments"]=$attachment;
		$data["path"]=$this->config->item("download_materials");
		$data['page_title']  = 'e4u'; 
		$this->load->view('downloads', $data); 	
	}
	public function download_file($file_name=""){
		$this->load->helper('download');
		$data = file_get_contents($this->config->item("download_materials").$file_name); // Read the file's contents
		$name = $file_name;
		force_download($name, $data);
	}		
	
	public function payment_response()
	{				
		$workingKey = '9ACA5D6858041AA421287635D6834453';		//Working Key should be provided here.
      $encResponse = $_POST["encResp"];			//This is the response sent by the CCAvenue Server
      $rcvdString = decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
      $order_status = "";
      $decryptValues = explode('&', $rcvdString);
      $dataSize = sizeof($decryptValues);
	
		//$order_details = $this->session->userdata('order_details');	

      $information = explode('=',$decryptValues[0]);
      $response_data_array = array();
      $response_data_array['plan_purchase']['order_id'] = $information[1];
      $information = explode('=',$decryptValues[1]);
      $response_data_array['plan_purchase']['transaction_id']=$information[1];
      $transaction_id = $information[1];
      $information=explode('=',$decryptValues[2]);
      $response_data_array['plan_purchase']['bank_ref_no']=$information[1];
      $information=explode('=',$decryptValues[3]);
      $response_data_array['plan_purchase']['order_status']=$information[1];
      $information=explode('=',$decryptValues[4]);
      $response_data_array['plan_purchase']['failure_message']=$information[1];
      $information=explode('=',$decryptValues[5]);
      $response_data_array['plan_purchase']['payment_mode']=$information[1];
      $information=explode('=',$decryptValues[6]);
      $response_data_array['plan_purchase']['card_name']=$information[1];
      $information=explode('=',$decryptValues[7]);
      $response_data_array['plan_purchase']['status_code']=$information[1];
      $information=explode('=',$decryptValues[8]);
      $response_data_array['plan_purchase']['status_message']=$information[1];
	  $information=explode('=',$decryptValues[9]);
      $response_data_array['plan_purchase']['currency']=$information[1];
      $information=explode('=',$decryptValues[10]);
   	  $response_data_array['plan_purchase']['amount']=$information[1];
      $information=explode('=',$decryptValues[11]);
	  $response_data_array['plan_purchase']['billing_name']=$information[1];
	  $information=explode('=',$decryptValues[12]);
      $response_data_array['plan_purchase']['billing_address']=$information[1];
      $information=explode('=',$decryptValues[13]);
      $response_data_array['plan_purchase']['billing_city']=$information[1];
      $information=explode('=',$decryptValues[14]);
      $response_data_array['plan_purchase']['billing_state']=$information[1];
      $information=explode('=',$decryptValues[15]);
      $response_data_array['plan_purchase']['billing_zip']=$information[1];
      $information=explode('=',$decryptValues[16]);
      $response_data_array['plan_purchase']['billing_country']=$information[1];
      $information=explode('=',$decryptValues[17]);
      $response_data_array['plan_purchase']['billing_tel']=$information[1];
      $information=explode('=',$decryptValues[18]);
      $response_data_array['plan_purchase']['billing_email']=$information[1];
      $information=explode('=',$decryptValues[19]);
      $response_data_array['plan_purchase']['delivery_name']=$information[1];
      $information=explode('=',$decryptValues[20]);
      $response_data_array['plan_purchase']['delivery_city']=$information[1];
      $information=explode('=',$decryptValues[21]);
      $response_data_array['plan_purchase']['delivery_state']=$information[1];     
      $information=explode('=',$decryptValues[22]);
      $response_data_array['plan_purchase']['delivery_zip']=$information[1];
      $information=explode('=',$decryptValues[23]);
      $response_data_array['plan_purchase']['delivery_zip']=$information[1];
      $information=explode('=',$decryptValues[24]);
      $response_data_array['plan_purchase']['delivery_country']=$information[1];
      $information=explode('=',$decryptValues[25]);
      $response_data_array['plan_purchase']['delivery_tel']=$information[1];
      $information=explode('=',$decryptValues[26]);
      $order_id=$response_data_array['plan_purchase']['order_id'];
      $order_status = $response_data_array['plan_purchase']['order_status'];
     
 	 if($order_status==="Success") {
 	 	$status = 1;
 	 	$message = "Thankyou for purchasing the course with us. Your transaction is successful.";
 	 }elseif($order_status==="Failure"){
     	$status = 3;
     	$message = "Your transaction has been declined.";
     }else if($order_status==="Aborted"){
      $status = 4;  
      $message = "Your transaction has been declined.";
     }else if($order_status==="Pending"){
      $status = 5;   
      $message = "Your transaction has been declined.";
     }else{
    	$status = 6;
    	$message = "Database error";
     }
          
      $order_id = $response_data_array['plan_purchase']['order_id'];
    	$payment_data = array('order_status'=>$status,                        
                        'response_data'=>$rcvdString);
      
      $payment_status = $this->home_model->update_payment_details($order_id, $payment_data);                
                        
		if($status == 1){
			// add mesasge in session
			$this->session->set_flashdata('payment_message', $message);
			redirect(base_url().'subscribe');			
		}
		else{
			//database error : If response didn't update in DB, show error
			$this->session->set_flashdata('payment_failure', $message);
			redirect(base_url().'subscribe');
		}
    }
	
	public function cms_page($slug){
	
		if($slug==""){
			redirect(base_url());die;
		}
	$result=$this->home_model->get_page_content($slug);
	if($result->num_rows()==0){
		redirect(base_url());die;
	} 
	$data["page_content"]=$result->row_array();
	$data['page_title']  = 'e4u';  
	$data['main_content'] = 'home/cms-page';
	echo  $this->load->view(SITE_LAYOUT_PATH,$data,true);
	}

	public function payment_response_mobile()
	{			
     	
		$myFile = $_SERVER['DOCUMENT_ROOT'].'/e4u/application/modules/home/controllers/new_test.txt';
		
		if (!file_exists($myFile)) {
		  print 'File not found';
		}
		else if(!$fh = fopen($myFile, 'a+')) {
		  print 'Can\'t open file';
		}
		else {
				fwrite($fh, "hwllo");
		  		print 'Success open file';
			 	fclose($fh);
		}
    }
}		
			
			
			
			
			
			
			
			
