<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subjects_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
	public function update_status($id, $data) 
	{
		$this->db->where('id', $id);
		$this->db->update('subjects', $data);
		 
	}	
}

