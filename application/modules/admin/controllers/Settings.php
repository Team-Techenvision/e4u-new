<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller
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
		$this->load->helper('function_helper');
		getSearchDetails($this->router->fetch_class());
		$this->load->model('base_model'); 
	}
	public function index($id = 1)
	{
		$data['post'] = FALSE;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{ 				
			$this->form_validation->set_rules('marks', 'Pass Percentage','trim|required|numeric');
			$this->form_validation->set_rules('ques', 'No. Of Questions Sets','trim|required|numeric');
			$this->form_validation->set_rules('count_down_time', 'Count Down Time','trim|required|numeric');
			$this->form_validation->set_rules('remainder', 'Renew or Purchase A Plan Remainder','trim|required');
			$this->form_validation->set_rules('contact_number', 'Contact Number','trim|required|regex_match[/^[0-9 \+]*$/i]');
			$this->form_validation->set_rules('contact_email', 'Email ID','trim|required|valid_email');
			$this->form_validation->set_rules('contact_address', 'Address','trim|required');
			$this->form_validation->set_rules('free_trial', 'Free trial','trim|required');
			$this->form_validation->set_rules('mark_per_ques', 'Mark per question','trim|required');
			$this->form_validation->set_rules('negative_mark', 'Negative mark','trim|required');
			
			if ($this->form_validation->run())
			{   
				$date = date('Y-m-d H:i:s');
				$update_array = array (	'pass_percentage' => $this->input->post('marks'),
										'question_count' => $this->input->post('ques'),
										'count_down_time' => $this->input->post('count_down_time'),
										'remainder' => $this->input->post('remainder'),
										'contact_number' => $this->input->post('contact_number'),
										'contact_mail' => $this->input->post('contact_email'),
										'contact_address' => $this->input->post('contact_address'),
										'free_trial' => $this->input->post('free_trial'),
										'mark_per_ques' => $this->input->post('mark_per_ques'),
										'negative_mark' => $this->input->post('negative_mark'),
										'modified' => $date
									  );
				$this->base_model->update ( 'settings', $update_array, array('id'=>$id));
				$this->session->set_flashdata('flash_success_message', $this->lang->line('update_record'));
				redirect(base_url().SITE_ADMIN_URI.'/settings/');
			}
			$data['post'] = TRUE;
		}
		$join_tables = $where = array();  
		$fields = 'id,mark_per_ques,negative_mark, pass_percentage,question_count,count_down_time,remainder,contact_address,free_trial,
		contact_mail,contact_number'; 
		$where[] = array( TRUE, 'id', $id);
		$data['settings'] = $this->base_model->get_advance_list('settings', $join_tables, $fields, $where, 'row_array');
		$data['main_content'] = 'settings';
		$data['page_title']  = 'Settings'; 
		$this->load->view(ADMIN_LAYOUT_PATH, $data); 	
	}
}
