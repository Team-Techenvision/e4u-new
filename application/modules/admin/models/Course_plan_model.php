<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Course_plan_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
}

