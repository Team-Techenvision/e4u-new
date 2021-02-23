<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class MY_Controller extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }
}
 
class Admin_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->helper('function');
  }
}
 
class Public_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
  }
}

class Mobile_service_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->helper('function');
  }
  
  function check_user_token($user_id, $token, $table_name, $check_old_password = false){
  		$this->load->model('base_model');
  		/*** Check token ***/
  		$cond = array();
  		$cond[] = array( TRUE, 'id',$user_id);
  		//$cond[] = array( TRUE, 'status', 1);
  		$user = $this->base_model->get_records($table_name, 'id,email,app_expire_time,password,app_token,status', $cond, 'row_array');
  		if(!empty($user) && $user['status'] == 1){
  			if( $token == $user['app_token']){  
  				if ($user['app_expire_time'] >= date('Y-m-d h:i:s')) { 
  					//if($check_old_password && (md5($check_old_password) != $user['password']))	{	 
  						//return 'OLD_PASSWORD_ERROR';
  					//}
  					$result = 'SUCCESS';
  					$this->base_model->update($table_name, array('app_expire_time'=>date('Y-m-d h:i:s', strtotime("+1 days") )) , array('id'=> $user['id']));
 				} else { //$result = 'TOKEN_EXPIRED';  
  						$result = 'SUCCESS';
  						}
  			}else
  				$result = 'TOKEN_ERROR';
  		}else if(!empty($user) && $user['status'] == 0){
  			$result = 'INACTIVATE_USER_ID';
  		}else{
  			$result = 'INVALID_USER_ID';
  		}
  		return $result; 
  }
}
