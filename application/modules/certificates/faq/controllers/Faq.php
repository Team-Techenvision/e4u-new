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
	}
	public function index()
	{
		$data['faq'] = $this->home_model->get_faq();
		$data['main_content'] = 'faq/index';
		$data['page_title']  = 'e4u'; 
		$this->load->view(SITE_LAYOUT_PATH, $data);
	}
}
