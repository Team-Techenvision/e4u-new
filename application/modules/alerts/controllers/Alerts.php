<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Alerts extends MX_Controller
{
  	function __construct()
	{
		$this->load->library(array('form_validation','csv_import'));
		$this->load->language(array('flash_message','form_validation'), 'english');
		$this->load->helper("profile_helper");
		 if(!$this->session->has_userdata('user_is_logged_in'))
		 {
			 redirect(base_url());
		 }
		$this->load->model('base_model');
		$this->load->model(array('alerts_model','dashboard/dashboard_model')) ;
		compare_session(1);
	}
	public function index($page_num = 1)
	{
		$this->load->library('pagination');
		$config  = $this->config->item('pagination');
	  	$config["base_url"]    = base_url()."alerts/index";
	 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
	  	$config["uri_segment"] = 3;
	  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
	  	$limit_start = $config['per_page'];		  
	  	
		$user_arr = $this->session->userdata('user_is_logged_in');
		
		//List all alerts
		$data['alerts_list'] = $this->alerts_model->get_alerts($user_arr["user_id"],"","","",$limit_start, $limit_end);
		$data['total_rows'] = $config['total_rows'] = count($this->alerts_model->get_alerts($user_arr["user_id"]));
		$this->pagination->initialize($config);
		$alert_list = $data['alerts_list'];
		foreach($alert_list as $key=>$value)
		{
			$alert_id[] = $value['id'];
		}
		//insert viewed alerts
		$alert_visit = $this->alerts_model->alert_visit($user_arr["user_id"], $alert_id);
		$data['main_content'] = 'alerts/index';
		$data['page_title']  = 'e4u'; 			
		$this->load->view(SITE_LAYOUT_DASHBOARD_PATH,$data);
	}
}
