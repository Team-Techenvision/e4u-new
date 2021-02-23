<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Meeting_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }
}

