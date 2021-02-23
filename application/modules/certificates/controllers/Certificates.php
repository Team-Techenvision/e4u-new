<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Certificates extends MX_Controller
{
	  	function __construct()
  		{
  			$this->load->library(array('form_validation','csv_import'));
			$this->load->language(array('flash_message','form_validation'), 'english');
			if($_SERVER['HTTP_REFERER']=="")
			{
				redirect(base_url());
			}
    		 if(!$this->session->has_userdata('user_is_logged_in'))
			 {
				 redirect(base_url());
			 }
			$this->load->model('base_model'); 
			$this->load->model('certificates_model');
			$this->load->helper("profile_helper");	//modified
			compare_session(1); //modified
		}
		public function index($page_num = 1)
		{
			$this->load->library('pagination');
			$config  = $this->config->item('pagination');
		  	$config["base_url"]    = base_url()."certificates/index";
		 	$data["per_page"] = $config["per_page"] = $this->config->item('admin_list', 'page_per_limit'); 
		  	$config["uri_segment"] = 3;
		  	$data['limit_end'] = $limit_end = ($page_num - 1) * $config['per_page'];  
		  	$limit_start = $config['per_page'];	
		  	
			$user_arr=$this->session->userdata('user_is_logged_in');
			$data['certificate_list']=$this->certificates_model->certificate_list($user_arr["user_id"], "", $limit_start, $limit_end);			
			$data['total_rows'] = $config['total_rows'] = count($this->certificates_model->certificate_list($user_arr["user_id"]));
			$this->pagination->initialize($config);			
			$data['main_content'] = 'certificates/index';
			$data['page_title']  = 'e4u'; 
			$this->load->view("index",$data);
		}
		public function generate_certificate($test_id="")
		{
			$user_arr=$this->session->userdata('user_is_logged_in');
			$data['certificate_details']=$this->certificates_model->get_certificate_details($user_arr["user_id"],$test_id);
			
			//$data = [];
		    //load the view and saved it into $html variable
		      $html=$this->load->view('certificate', $data, true);
 
		    //this the the PDF filename that user will get to download
		   	// $rand = rand(0,100000);
		    $pdfFilePath = "e4u_certificate_".$data['certificate_details']['exam_code'].".pdf";
	 
		    //load mPDF library
		    $this->load->library('m_pdf');
	 
		    //generate the PDF from the given html
		    $this->m_pdf->pdf->WriteHTML($html);
		    //for download.
		    $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		    
		    //for view and save
		    //$this->m_pdf->pdf->Output($pdfFilePath,"I"); 
			exit;
		
		}
		
		
		
}
