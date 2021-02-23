<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
	private $json = array();
	private $opts = array();
	function valid_register_password($str) {
		return ( $this->valid_hasnumber($str) === TRUE && $this->valid_hasletter($str) === TRUE && $this->valid_hascaps($str) === TRUE && $this->valid_hassymbol($str) === TRUE) ? TRUE : FALSE;
	}
	function valid_hasnumber($str) {
		if( !preg_match("#[0-9]+#", $str) ) {
			return FALSE;
		}
		return TRUE;
	}
	
	function valid_hasletter($str) {
		if( !preg_match("#[a-z]+#", $str) ) {
			return FALSE;
		}
		return TRUE;
	}
	
	function valid_hascaps($str) {
		if( !preg_match("#[A-Z]+#", $str) ) {
			return FALSE;
		}
		return TRUE;
	}
	
	function valid_hassymbol($str) {
		if( !preg_match("#\W+#", $str) ) {
			return FALSE;
		}
		return TRUE;
	}
	function get_json($extra_array = array(),$error_array=array())
	{
		if(count($extra_array)) {
			foreach($extra_array as $addition_key=>$addition_value) {
				$this->json[$addition_key] = $addition_value;
			}
		}
		$this->json['options'] = $this->opts;
		if(!empty($error_array)){
			foreach($error_array AS $key => $row)
				$error[] = array('field' => $key, 'error' => $row);
		}
		foreach($this->_error_array AS $key => $row)
			$error[] = array('field' => $key, 'error' => $row);
			
			
		if(isset($error)) {
			$this->json['status'] = 'error';
			$this->json['errorfields'] = $error;
		} else {
			$this->json['status'] = 'success';		
		}	
		return json_encode($this->json);
	}
}
