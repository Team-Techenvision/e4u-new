<?php

	function user_data() 
	{
		$CI =& get_instance();
		if($CI->session->has_userdata('user_is_logged_in'))
		{ 
			$CI->load->helper('thumb_helper');
			$CI->load->helper('html');
			$CI->load->model('base_model');
			$users = $CI->base_model->getCommonListFields('users', array('gender','profile_image','first_name','last_name'), array('id' => $CI->session->userdata['user_is_logged_in']['user_id']));
		}
		return $users;
	}
	
	function compare_session($type=""){
		$CI = get_instance();
		$CI->load->model("base_model");  
		$CI->load->library("session");
		if($CI->session->has_userdata('user_is_logged_in')){							
			$users = $CI->base_model->getCommonListFields('users', array('session_id'), array('id' => $CI->session->userdata['user_is_logged_in']['user_id']));										
			if($users[0]->session_id!=$CI->session->userdata['user_is_logged_in']['session_id']){
				setcookie('multilogin_alert', 'Unauthorized Access Multiple connections to a server by the same user, using more than one user name, are not allowed. Disconnect all previous connections to the server or shared resource and try again.',time()+7200);	
				if($type==""){
					redirect(base_url()."home/logout");
				}else{
				 	$extra_array = array('status'=>'session_mismatch','msg'=>$CI->lang->line('session_expired'));
					echo json_encode($extra_array);die;
				}
			}
		}
	}


