<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends Mobile_service_Controller
{
	  	function __construct()
  		{
    		parent::__construct();
			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
			$this->load->model(array("Cron_model","base_model"));
		}
	/* PUSH NOTIFICATION FOR ALL APP USERS */	 
	public function push_notification_all(){
		push_notification();
	} 
	public function remainder_email(){
		$res_dates=$this->Cron_model->get_dates();
		//$res_dates["remainder"]="2,3";
		$date_remainder=explode(",",$res_dates["remainder"]);
		foreach($date_remainder as $data_remainder){
		 $now_date[]=date("Y-m-d",strtotime("+".$data_remainder."days")); 
		}
		$users_list=$this->Cron_model->get_expiring_users($now_date); 
		// echo $this->db->last_query();
		
		$cond = array();
		$cond[] = array(TRUE, 'id', 12 ); 
		$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array'); 
		$this->load->library('email'); 

					//added start
					$smtp_mail = $this->config->item('smtp_mail');
					$this->email->initialize($smtp_mail);
					//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");

		 foreach ($users_list as $user_data){ 
			$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array'); 
			$email_config_data = array('[USERNAME]'=> $user_data['first_name']." ".$user_data['last_name'],  
									   '[MAIL_TITLE]' =>$mailcontent['subject'],
									   '[SITE_NAME]' => $this->config->item('site_name'),
									   '[COURSE_NAME]' =>$user_data['name'],
									   '[EXP_DATE]' =>$user_data['course_expiry_date']);
			$this->email->from($smtp_mail['smtp_user'],"E4U");
			$this->email->to($user_data["email"]);
			$this->email->subject($mailcontent['subject']); 
			foreach($email_config_data as $key => $value){
				$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
			} 
			$headers=array();
			$this->email->message($mailcontent['email_content'],$headers); 
			$this->email->send();
		
		 }
		 //course expiration
		 $expiry = $this->Cron_model->expiry_status();
		

		 foreach($expiry as $keys=>$vals)
		 {
		 	$current_date = date("Y-m-d");
		 	if(date("Y-m-d",strtotime($vals['course_expiry_date'])) <= $current_date)
			{
				//updating expired status to 0 in user_plan table
				$update_array =array('is_expired'=>'0');
				// echo $vals['user_plan_id'];die;
				$ret = $this->base_model->update('user_plans', $update_array, array('is_expired'=>'1','id'=>$vals['user_plan_id']));
				if($ret == 1){
					//email send to user for course expired 
					$cond = array();
					$cond[] = array(TRUE, 'id', 16 ); 
					$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array'); 
					$this->load->library('email'); 

					//added start
					$smtp_mail = $this->config->item('smtp_mail');
					$this->email->initialize($smtp_mail);
					//added end  //$this->email->from($smtp_mail['smtp_user'],"E4U");
					$mailcontent = $this->base_model->get_records('email_templates','id,email_content,subject', $cond, 'row_array'); 
					$email_config_data = array('[USERNAME]'=> $vals['first_name']." ".$vals['last_name'],  
											   '[SITE_NAME]' => $this->config->item('site_name'),
											   '[COURSE_NAME]' =>$vals['course_name'],
											   '[SUBSCRIBED_DATE]' =>$vals['course_start_date']);
					$this->email->from($smtp_mail['smtp_user'],"E4U");
					$this->email->to($vals["email"]);
					$this->email->subject($mailcontent['subject']); 
					foreach($email_config_data as $key => $value){
						$mailcontent['email_content'] = str_replace($key, $value, $mailcontent['email_content']);
					} 
					$headers=array();
					$this->email->message($mailcontent['email_content'],$headers);
					$this->email->send();
				}
		 	}
		 
		}
	}
}
