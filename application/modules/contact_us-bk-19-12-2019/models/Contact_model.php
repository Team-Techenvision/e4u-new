<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact_model extends CI_Model{
	public function construct(){
		$this->load->database();
	}
	public function contact()
	{
		$fields = array('contact_number','contact_mail','contact_address');
		$this->db->select($fields);
		$this->db->from('settings');
		$this->db->where('id','1');
		$result = $this->db->get();
		$data = $result->row_array();
		return $data;
	}
 
}

?>
