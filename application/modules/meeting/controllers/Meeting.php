<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("function_helper");	
		if(!is_loggedin()) {
				redirect();	
		}
		 
		$this->load->library('form_validation');
		$this->load->language(array('flash_message','form_validation'), 'english');			
		$this->load->model('base_model'); 
		$this->load->model('home/home_model');
		$this->load->helper("profile_helper");
		compare_session();
	}
	public function index()
	{
		$data['meeting'] = $this->home_model->get_meeting();
		$data['main_content'] = 'meeting/index';
		$data['page_title']  = 'Meeting'; 
		$user_arr=$this->session->userdata('user_is_logged_in');
		if(count($user_arr)){
			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
		}
		else{
			$this->load->view(SITE_REGISTER_LAYOUT_PATH, $data);
		}
	}
}