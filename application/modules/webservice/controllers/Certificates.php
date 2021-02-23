<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Certificates extends Mobile_service_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','csv_import'));
		$this->load->language(array('flash_message','form_validation'), 'english');
		$this->load->model(array('certificates/certificates_model','webservice/webservice_model'));
	}
	public function index()
	{
		$result = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			$this->form_validation->set_rules('oauth_token', 'oauth Token', 'trim|required'); 
			$this->form_validation->set_rules('user_id', 'user id','trim|required');
			$this->form_validation->set_rules('device_type', 'device type', 'trim|required'); 
			if($this->form_validation->run()){
				$oauth_token = $this->input->post('oauth_token');
				$user_id = $this->input->post('user_id');
				$page = $this->input->post('page');
				$response = $this->check_user_token($user_id, $oauth_token, 'users' ); 
				switch($response){
					case 'TOKEN_ERROR':
						$result = array('success'=> 0 , 'message'=> 'Invalid Token');
						break;
					case 'INVALID_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Invalid user');
						break;
					case 'INACTIVATE_USER_ID':
						$result = array('success'=> 0 , 'message'=> 'Inactivate user');
						break;
					case 'SUCCESS':
						$data['certificate_list']=$this->certificates_model->certificate_list($user_id,$page);
						$total_certificates = $this->webservice_model->total_certificates($user_id);
						if(!empty($data['certificate_list'])){
						$res = array();
						$i=0;
						foreach($data['certificate_list'] as $certificate){
						
						$res[$i]['id'] = $certificate['id'];
						$res[$i]['course_id'] = $certificate['course_id'];
						$res[$i]['course_name'] = $certificate['course_name'];
						$res[$i]['subject_name'] = ($certificate['subject_name']==""?"Surprise Test":$certificate['subject_name']);
						$res[$i]['level_name'] = ($certificate['level_name']==""?"Surprise Test":$certificate['level_name']);
						$res[$i]['end_date'] = $certificate['end_date'];
						$res[$i]['download_link'] =base_url()."webservice/certificates/view_certificate/".$certificate["test_id"]."/".$certificate["user_id"];
						
						$i++;
						}
						$result = array('success'=> 1, 'message'=> 'Certificates list','total_certificates'=>$total_certificates,'data' => $res);
						}else{
						$result = array('success'=> 0, 'message'=> 'No Certificates Available for this user');
						}
						break;
					default:
						$result = array('success'=> 0 , 'message'=> 'Some error ');
				}
			}else{
				$result = array('success'=> 0 , 'message'=> 'validation error' , 'errors'=> $this->form_validation->error_array());
			}
		}else{
			$result = array( 'success'=> 0 , 'message'=> 'method does not post' ) ;  
		} 
		echo $response = json_encode($result);
		return TRUE;
	}
	public function view_certificate($test_id,$user_id)
	{
		 
			$data['certificate_details']=$this->certificates_model->get_certificate_details($user_id,$test_id);
			
			//$data = [];
		    //load the view and saved it into $html variable
		    $html=$this->load->view('certificates/certificate', $data, true);
	 
		    //this the the PDF filename that user will get to download
		    $rand = rand(0,100000);
		    $pdfFilePath = "e4u_certificate_".$rand.".pdf";
	 
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

?>
