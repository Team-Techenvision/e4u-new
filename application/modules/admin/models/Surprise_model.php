<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Surprise_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
	
	 public function getTests($course_id){
		$this->db->select("id, test_name as name");
	  	$this->db->from("surprise_test");
	  	$this->db->where("course_id", $course_id);	  	
	  	$this->db->order_by("name", "asc");
	  	$result = $this->db->get();
		return $result->result_array();
	}


	public function getTestName($surprise_test_id){
		$this->db->select("id, test_name as name");
	  	$this->db->from("surprise_test");
	  	$this->db->where("id", $surprise_test_id);	  	
	  	$this->db->order_by("name", "asc");
	  	$result = $this->db->get();
		return $result->row_array();
	}


	
}

