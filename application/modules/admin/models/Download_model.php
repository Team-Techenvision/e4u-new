<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Download_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
	public function get_user_id($id) 
	{ 
		$fields = array('user_id');
		$this->db->select($fields);
		$this->db->from('downloads');
		$this->db->where('id', $id);
		$result=$this->db->get();
		$result_data=$result->row_array();
		return $result_data;
	}
	public function get_data($id){
		 
		$this->db->select("*");
		$this->db->from('alerts');
		$this->db->where('alert_item_id', $id);
		$result=$this->db->get();
		$result_data=$result->row_array();
		return $result_data;
	}
	public function get_details($id){
		 
		$this->db->select("*");
		$this->db->from('surprise_test');
		$this->db->where('id', $id);
		$result=$this->db->get();
		$result_data=$result->row_array();
		return $result_data;
	}
}

