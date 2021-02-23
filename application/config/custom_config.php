<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

$pagination = array(
				'per_page' => 10,
				'use_page_numbers' => 'TRUE', 
				'full_tag_open' => '<ul class="pagination normal">',
				'full_tag_close' => '</ul>',
				'num_tag_open' => '<li class="paginate_button">',
				'num_tag_close' => '</li>',
				'cur_tag_open' => '<li class="paginate_button active"><a>',
				'cur_tag_close' => '</a></li>',
				'prev_tag_open' => '<li id="DataTables_Table_0_prev" class="paginate_button prev">',
				'prev_tag_close' => '</li>',
				'next_tag_open' => '<li id="DataTables_Table_0_next" class="paginate_button next">',
				'last_tag_open' => '<li id="DataTables_Table_0_next" class="paginate_button next">',
				'last_tag_close' => '</li>',
				'first_tag_open' => '<li id="DataTables_Table_0_next" class="paginate_button next">',
				'first_tag_close' => '</li>',
				'next_tag_close' => '</li>',
				'prev_link'=> 'Previous',
				'next_link' => 'Next'
		);
$pagination_dashboard = array(
				'per_page' => 3,
				'use_page_numbers' => 'TRUE', 
				'full_tag_open' => '<ul class="">',
				'full_tag_close' => '</ul>',
				'num_tag_open' => '<li class="pagination_dashboard">',
				'num_tag_close' => '</li>',
				'cur_tag_open' => '<li class="pagination_dashboard active"><a id="pagination">',
				'cur_tag_close' => '</a></li>',
				'prev_tag_open' => '<li id="" class="pagination_dashboard ">',
				'prev_tag_close' => '</li>',
				'next_tag_open' => '<li id="" class="pagination_dashboard ">',
				'last_tag_open' => '<li id="" class="pagination_dashboard ">',
				'last_tag_close' => '</li>',
				'first_tag_open' => '<li id="" class="pagination_dashboard ">',
				'first_tag_close' => '</li>',
				'next_tag_close' => '</li>',
				'prev_link'=> '',
				'next_link' => ''
		);
$pagination_ans = array(
				'per_page' => 5,
				'use_page_numbers' => 'TRUE', 
				'full_tag_open' => '<ul class="">',
				'full_tag_close' => '</ul>',
				'num_tag_open' => '<li class="pagination_dashboard">',
				'num_tag_close' => '</li>',
				'cur_tag_open' => '<li class="pagination_dashboard active"><a id="pagination">',
				'cur_tag_close' => '</a></li>',
				'prev_tag_open' => '<li id="" class="pagination_dashboard ">',
				'prev_tag_close' => '</li>',
				'next_tag_open' => '<li id="" class="pagination_dashboard ">',
				'last_tag_open' => '<li id="" class="pagination_dashboard ">',
				'last_tag_close' => '</li>',
				'first_tag_open' => '<li id="" class="pagination_dashboard ">',
				'first_tag_close' => '</li>',
				'next_tag_close' => '</li>',
				'prev_link'=> '',
				'next_link' => ''
		);


$pagination_subj = array(
				'per_page' => 5,
				'use_page_numbers' => 'TRUE', 
				'full_tag_open' => '<ul class="pagination">',
				'full_tag_close' => '</ul>',
				'num_tag_open' => '<li class="paginate_button">',
				'num_tag_close' => '</li>',
				'cur_tag_open' => '<li class="paginate_button active"><a>',
				'cur_tag_close' => '</a></li>',
				'prev_tag_open' => '<li id="DataTables_Table_0_prev" class="paginate_button prev">',
				'prev_tag_close' => '</li>',
				'next_tag_open' => '<li id="DataTables_Table_0_next" class="paginate_button next">',
				'last_tag_open' => '<li id="DataTables_Table_0_next" class="paginate_button next">',
				'last_tag_close' => '</li>',
				'first_tag_open' => '<li id="DataTables_Table_0_next" class="paginate_button next">',
				'first_tag_close' => '</li>',
				'next_tag_close' => '</li>',
				'prev_link'=> 'Previous',
				'next_link' => 'Next'
		);
$config['pagination'] = $pagination;
$config['pagination_subj'] = $pagination_subj;
$config['pagination_dashboard'] = $pagination_dashboard;
$config['pagination_ans'] = $pagination_ans;
							
$config['page_per_limit'] = array(
				'admin_list'=> 10
			);
$config['page_per_limit_dashboard'] = array(
				'materials'=> 3
			);
$config['page_per_limit_ans'] = array(
				'materials'=> 5
			);

$config['page_per_limit_subj'] = array(
	'subj_list'=> 5
); 
$cis=& get_instance();
//$config['bulkactions'] = array(''=>'Select Action','1'=>'Active','2'=>'Inactive','3'=>'Delete');
$config['bulkactions'] = array(''=>'Select Action','1'=>'Active','2'=>'Inactive');
if($cis->uri->segment(3)=="active") {
	unset($config['bulkactions'][1]);
} else if ($cis->uri->segment(3)=="inactive") {
	unset($config['bulkactions'][2]);
}else if ($cis->uri->segment(3)=="delete") {
	unset($config['bulkactions'][3]);
}

//$config['bulkactions_course'] = array(''=>'Select Action','1'=>'Active','2'=>'Inactive','3'=>'Delete');
$config['bulkactions_course'] = array(''=>'Select Action','1'=>'Active','2'=>'Inactive');
if($cis->uri->segment(3)=="active") {
	unset($config['bulkactions'][1]);
} else if ($cis->uri->segment(3)=="inactive") {
	unset($config['bulkactions'][2]);
}else if ($cis->uri->segment(3)=="delete") {
	unset($config['bulkactions'][3]);
}

$config['bulkactions_orders'] = array(''=>'Select Action','1'=>'Cancel');
if($cis->uri->segment(3)=="cancel") {
	unset($config['bulkactions'][1]);
}
$config['admin_resetpassword_url']	= $this->config['base_url'].SITE_ADMIN_URI.'/resetpassword/';
$config['site_resetpassword_url']	= $this->config['base_url'].'home/index/reset_password?ref=';
$config['site_user_activate_url']	= $this->config['base_url'].'home/useractive/';
$config['download_materials']	= $this->config['base_url'].'appdata/attachments/';
$config['ad_img'] = FCPATH.'appdata/ads/';
$config['banner_img'] = FCPATH.'appdata/banners/';
$config['course_plans'] = FCPATH.'appdata/course_plans/';
$config['testi_img'] = FCPATH.'appdata/testimonials/';
$config['site_name'] = "E4U";
$config['currency_symbol'] = "<i class='fa fa-rupee'></i>";
$config['dollar_symbol'] = "<i class='fa fa-dollar'></i>"; // modified
$config['forgot_mail_subj'] = "Forgot Password Alert for User";
//$config['question_type'] = array('1' => 'Text', '2' => 'Image' );
$config['question_type'] = array('2' => 'Image' );
$config['answer_type'] = array('' => 'Select',  '1' => 'Text', '2' => 'Image');
//$config['explanation_type'] = array('0'=>'Select', '1' => 'Text', '2' => 'Image' );
$config['explanation_type'] = array('2' => 'Image' );
$config['choice_count'] = array('' => 'Select', '2' => '2', '3' => '3', '4' => '4', '5' => '5');
$config['severity'] = array('' => 'Select','2' => 'Hard', '1' => 'Medium', '3' => 'Easy');
$config['severity_front_end'] = array( '3' => 'Easy','2' => 'Hard'); //'1' => 'Medium'
$config['question_img'] = FCPATH.'appdata/questions/thumb_questions_img/';
$config['subjective_question_img'] = FCPATH.'appdata/subjective_questions/thumb_subjective_questions_img/';
$config['answers_img'] = FCPATH.'appdata/answers/thumb_answers_img/';
$config['ans_img_width'] = "460";
$config['ans_img_height'] = "160";
$config['questions_url'] = $this->config['base_url'].'appdata/questions/thumb_questions_img/';
$config['explanation_url'] = $this->config['base_url'].'appdata/explanations/thumb_explanation_img/';
$config['answers_url'] = $this->config['base_url'].'appdata/answers/thumb_answers_img/';
$config['explanation_img'] = FCPATH.'appdata/explanations/thumb_explanation_img/';
$config['subjective_explanation_img'] = FCPATH.'appdata/subjective_explanations/thumb_subjective_explanation_img/';
$config['surprise_question_img'] = FCPATH.'appdata/surprise_img/surprise_questions_img/thumb_questions_img/';
$config['surprise_answer_img'] = FCPATH.'appdata/surprise_img/surprise_answers_img/thumb_answers_img/';
$config['surprise_answers_url'] = $this->config['base_url'].'appdata/surprise_img/surprise_answers_img/thumb_answers_img/';
$config['surprise_explanation_img'] = FCPATH.'appdata/surprise_img/surprise_explanations_img/thumb_explanation_img/';
$config['attachments'] = FCPATH.'appdata/attachments/';
$config['alert_attachments'] = FCPATH.'appdata/alert_attachments/';
$config['profile_image_url'] = FCPATH.'appdata/profile/';

/** Uploaded File Path **/
$config["file_path"]	= array("tmp_csv_path" => "appdata/tmp/");

/** CCAvenue Config **/
//Modify mechant id, working key, access code
$config['ccavenue_details']=array('merchant_id'=>'656656',
											'workingkey'=>'6565656565656565656565656',
											'access_code'=>'65656565656565',
											'currency1'=>'INR',
											'currency2'=>'USD',
											'language'=>'EN',
											'title'=>'E4U' );
$config["classes"] = array("search_name");
$config["subjects"] = array("search_name");
$config["medium"] = array("search_name");
$config["course_plan"] = array("search_name","search_categ");
$config["chapters"] = array("search_name", "search_course", "search_class", "search_subject");
$config["levels"] = array("search_name", "search_course", "search_class", "search_subject", "search_chapter");
$config["sets"] = array("search_name", "search_course", "search_class", "search_subject", "search_chapter", "search_level");
$config["study_boards"] = array("search_name");
$config["sub_category"] = array("search_name");
$config["questions"] = array("search_course", "search_class", "search_subject", "search_chapter", "search_level", "search_set", "search_name");
$config["subjective_questions"] = array("search_course", "search_class", "search_subject", "search_category","search_chapter","search_name");
$config["surprise_test"] = array("search_from_date", "search_to_date", "search_course", "search_name");
$config["surprise_questions"] = array("search_name", "search_course", "search_test");
$config["alerts"] = array("search_course", "search_name");
$config["downloads"] = array("search_date", "search_uploaded");
$config["users"] = array("search_medium", "search_class", "search_board", "search_name");
$config["faqs"] = array("search_name");
$config["testimonials"] = array("search_name");
$config["enquiries"] = array("search_name");
$config["advertisements"] = array("search_name");
$config["banners"] = array("search_name");
$config["pages"] = array("search_name");
$config["email_templates"] = array("search_name");
$config["orders"] = array("search_course", "search_from_date", "search_to_date", "search_currency"); // modified
$config["user_reports"] = array("search_course", "search_medium", "search_class", "search_board", "user_status", "search_name","search_from_date","search_to_date");
$config["purchase_reports"] = array("search_course", "search_name","search_from_date","search_to_date", "search_currency");// modified
$config["performance_reports"] = array("search_course", "search_class", "search_subject", "search_name","search_from_date","search_to_date");
$config["certificates"] = array("search_course", "search_class", "search_subject", "search_chapter", "search_name","search_from_date","search_to_date", "test_type");
$config["test_reports"] = array("search_course", "search_class", "search_subject", "search_chapter", "search_name","search_from_date","search_to_date", "test_type");
$config["user_privileges"] = array("search_name");
$config["course_category"] = array("search_name");
$config["offline_subscription"] = array("search_name","search_course","search_from_date","search_to_date");

									
								
/*$config['smtp_mail'] = array(
			'protocol' => 'smtp',
			'smtp_host'   => 'ssl://smtp.gmail.com',
			'smtp_port'    => '465',
			'smtp_timeout' => '7',
			'smtp_user'  => 'blazedreamtechnology@gmail.com',
			'smtp_pass'   => 'Demo@123',
			'charset'   =>'utf-8',
			'newline'   => "\r\n",
			'mailtype' => 'html', // or htm,
			'validation' => TRUE // bool whether to validate email or not ,
		);
*/
			
$config['smtp_mail'] = array(
	'protocol' => 'smtp',
	'smtp_host'   => 'rin3.dizinc.com',
	'smtp_port'    => '587',
	'debug'        => 1,
	'smtp_timeout' => '7',
	'smtp_user'  => 'no-reply@e4uclassrooms.com',
	'_smtp_auth' => TRUE,
	'smtp_pass'   => 'Zwt36^T35u4ZC',
	'smtp_crypto' => 'tls',
	'charset'   =>'utf-8',
	'newline'   => "\r\n",
	'send_multipart' => TRUE,
	'charset' => 'utf-8',
	'mailtype' => 'html', // or htm,
	'validation' => TRUE, // bool whether to validate email or not ,
	'wordwrap' => TRUE
);












