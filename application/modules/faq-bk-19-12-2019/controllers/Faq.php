<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		 
		$this->load->library('form_validation');
		$this->load->language(array('flash_message','form_validation'), 'english');			
		$this->load->model('base_model'); 
		$this->load->model('home/home_model');
		$this->load->helper("profile_helper");
		compare_session();
	}
	public function index()
	{
		$data['faq'] = $this->home_model->get_faq();
		$data['main_content'] = 'faq/index';
		$data['page_title']  = 'E4U'; 
		$user_arr=$this->session->userdata('user_is_logged_in');
		if(count($user_arr)){
			$this->load->view(SITE_LAYOUT_DASHBOARD_PATH, $data);
		}
		else{
			$this->load->view(SITE_LAYOUT_PATH, $data);
		}
	}
}
