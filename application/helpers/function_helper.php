<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( !function_exists('getSessionAdminDetail')) {
		function getSessionAdminDetail( $param = 'admin_display_name' ){ 
				$CI = &get_instance();
				/** Param must be ==> 'admin_username', 'admin_user_id', 'admin_display_name', 'admin_email',  'admin_last_login' ***/
				if($CI->session->has_userdata('admin_is_logged_in')){
					$userData = $CI->session->userdata('admin_is_logged_in');
					if(!empty($userData))
					{
							if($userData[$param])
								return $userData[$param];
							else 
								return FALSE;
					}
					else
						return FALSE; 
				}
				return FALSE; 			
		}
}

if ( !function_exists('CreateDirectory')) {	
		function CreateDirectory($path){
			if(!is_dir($path)){
				$oldmask = umask(0);
				mkdir($path, 0777);
				umask($oldmask);
			}
			return true;
		}
}

if ( !function_exists('RemoveDirectory')) {	
	function RemoveDirectory($path) {
				if (is_dir($path)) {
					$files = glob( $path . DIRECTORY_SEPARATOR . '*');
					foreach( $files as $file ){
						 if($file == '.' || $file == '..'){continue;}
						 if(is_dir($file)){
							  RemoveDirectory( $file );
						 }else{
							  unlink( $file );
						 }
					}
					rmdir( $path ); 
				}
			return true;
	}	
}

if ( !function_exists('Check_valid_csv_header')) {	
	function Check_valid_csv_header( $array1, $array2 ) {  
		if(count($array1 ) != count($array2))
			return FALSE;
		elseif(count(array_intersect($array1, $array2)) != count($array1))
			return FALSE;
		else
			return TRUE;
	}
}

if ( !function_exists('create_slug')) {	
	function create_slug($name, $table)
	{
		 $CI = get_instance();
		 //$CI->load->model($model);
		 $slug            = url_title($name);
		 $slug            = strtolower($slug);
		 $i               = 0;
		 $params          = array();
		 $params['slug'] = $slug;
		 if ($CI->input->post('id')) {
		     $params['id !='] = $CI->input->post('id');
		 }
		 while ($CI->db->where($params)->get($table)->num_rows()) {
		     if (!preg_match('/-{1}[0-9]+$/', $slug)) {
		         $slug .= '-' . ++$i;
		     } else {
		         $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
		     }
		     $params['slug'] = $slug;
		 }
		 return $slug;
	}
}

if ( !function_exists('page_results')) {
	function page_results($total_rows=null,$per_page = 10,$cur_page=3,$limit_end=null,$result=TRUE){
		$pages = $total_rows / $per_page;
		$total_pages = ceil($pages);	
		$start = $limit_end ;
		if($total_pages == $cur_page){
			$lim = $total_pages - 1;
			$end = $total_rows - ( $lim * $per_page) + $start;
			$start = $start + 1;
		} else {
			$start = $limit_end + 1 ;
			$end = $limit_end + $per_page ;
		}
		$end = ($end==0) ? $start : $end;
		$output = array();
		$output['start'] = $start;
		$output['end'] = $end;
		$output['total_rows'] = $total_rows;
		$output['total_pages'] = $total_pages;
		$pages = ($total_pages>1) ? ' Pages' : ' Page';
		$end = ($total_pages>1) ? $end : $total_rows;
		return ($result) ? 'Showing '.$start.' to '.$end.' of '.$total_rows.' entries' : $output;
	}
}

if ( !function_exists('generate_token')) {
	function generate_token($user_id) {
		if($user_id) return md5(uniqid($user_id, true));
		else return md5(uniqid(rand(), true)); 
	}
}
if ( !function_exists('change_status')) {
	function change_status($table_name,$id,$status,$pageredirect,$pageno,$app_token='')
		{
			$CI = get_instance();
			$fieldsorts = $CI->input->get('sortingfied');
			$typesorts = $CI->input->get('sortype');
			if($status == 1){
			$status = 0;										
			$update_array = array ('status' => $status);
			}else{
			$status = 1;										
			$update_array = array ('status' => $status);
			}	  
			$CI->base_model->update ($table_name, $update_array, array('id'=>$id));
			if($app_token == 1){
				$CI->base_model->update ($table_name, array('app_token' => ''), array('id'=>$id));		
			}		
		}
	}
if ( !function_exists('delete_record')) {
	function delete_record($table_name,$id,$status,$pageredirect,$pageno)
		{
			$CI = get_instance();
			$fieldsorts = $CI->input->get('sortingfied');
			$typesorts = $CI->input->get('sortype');
			$CI->db->delete($table_name,array('id' => $id));
					
		}
	}
if ( !function_exists('create_unique_slug')) {
	function create_unique_slug($string,$table,$field='alias',$key=NULL,$value=NULL) 
		{ 
			$CI =get_instance();
			$slug = url_title($string); 
			$slug = strtolower($slug); 
			$i = 0; 
			$params = array (); 
			$params[$field] = $slug; 
			if($key)
			{
				$params["$key !="] = $value; 
			}
			while ($CI->db->where($params)->get($table)->num_rows()) 
			{ 
				if (!preg_match ('/-{1}[0-9]+$/', $slug )) 
				{
					$slug .= '-' . ++$i; 
				}
				else 
				{
					$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
				}
				$params [$field] = $slug; 
			} 
			return $slug;
		} 
}
if ( !function_exists('random_password')) {
	function random_password( $length = 8 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
}

if ( !function_exists('push_notification')) 
{
	function push_notification($user_id="")
	{ 
		$CI = get_instance();
		$CI->load->model(array("dashboard/dashboard_model","alerts/alerts_model","base_model"));  
		$fields = 'id,device_token'; 
		$where_cond=array();	
		if($user_id!="")
		{
			$where_cond[] = array( TRUE, 'id',$user_id);
		} 
		$where_cond[] = array( TRUE, 'device_token !=',"");
		$response_master = $CI->base_model->get_advance_list('users','',$fields,$where_cond, 'result_array'); 
	 	foreach($response_master as $response)
	 	{
			$device_token=$response["device_token"]; 
	 		if($device_token!="")
	 		{
				$data_arr = $CI->alerts_model->get_alerts($response["id"],"push");
				if(count($data_arr)>0)
				{
					$i=1;
					foreach($data_arr as $data_in)
					{
						 $msg = array(
										'message' 	=> $data_in["short_description"],
										'title'		=> $data_in["title"] 
									 ); 	
						 $fields = array(
									'registration_ids' 	=> array($device_token),
									'data'			=> $msg);
						 $headers = array(
									'Authorization: key=' . API_ACCESS_KEY,
									'Content-Type: application/json'
						);
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
						$result = curl_exec($ch );
						curl_close( $ch );
						print_r($result);
						unset($msg);
						unset($fields);
						unset($headers);$i++;
						 
					} 
				} 
				 
				//insert viewed alerts
				$alert_id=null;
				$CI->alerts_model->alert_visit($response["id"], $alert_id);
			} 
		} 
	} 
}
 
if ( !function_exists('is_user_active')) 
{	
	function is_user_active($user_id)
	{
		$CI = get_instance();		
		$CI->db->select('id, email, last_login_time, status');
		$CI->db->where("id=".$user_id);
		$selectResponse = $CI->db->get("users");
		return $selectResponse->row_array();		
	}
} 

if ( !function_exists('modules')) 
{	
	function modules()
	{
		$CI = get_instance();	
		if($CI->session->has_userdata('admin_is_logged_in'))
		{ 
			$CI->load->model('users_model');
			$admin_id = $CI->session->userdata('admin_is_logged_in');
  			$privil = $CI->users_model->get_privileges($admin_id['admin_user_id']);
  			$modules = $CI->users_model->get_modules_name($privil['privileges']);
  			foreach($modules as $key=>$value)
  			{
				$module_name[] = $value['module_name'];
			}	
			if(($CI->uri->segment(2) != 'dashboard') && ($CI->uri->segment(2) != 'profile')&& ($admin_id['admin_user_id'] != 1) && ($CI->uri->segment(2) != 'changepassword') && ($_SERVER['HTTP_REFERER']!=base_url().SITE_ADMIN_URI."/offline_subscription"))
			{
				if(!in_array($CI->uri->segment(2),$module_name))
				{
					redirect(base_url().SITE_ADMIN_URI.'/dashboard');
				}
			}
			
			return $modules;
		}
	}
}
//for disable delete and status in admin
if ( !function_exists('check_delete')) 
{	
	function check_delete($id,$type)
	{
		$CI = get_instance();		
		$CI->db->select('COUNT(id) as is_delete');
		if($type=="1")								//for objective & surprise questions
		{
			$CI->db->where("question_id",$id);    
			$res = $CI->db->get("test_details");
		}
		else if($type==2)							//for sets
		{
			$CI->db->where("set_id",$id);  		
			$res = $CI->db->get("questions");
		}
		else if($type==3)							//for levels
		{
			$CI->db->where("level_id",$id);  		
			$res = $CI->db->get("sets");
		}
		else if($type==4)							//for chapters
		{
			$CI->db->where("chapter_id",$id);  		
			$res = $CI->db->get("levels");
		}
		else if($type==5)							//for subjects
		{
			$CI->db->where("subject_id",$id);  		
			$res = $CI->db->get("chapters");
		}
		else if($type==6)							//for classes
		{
			$CI->db->where("class_id",$id);  		
			$res = $CI->db->get("chapters");
		}
		else if($type==7)							//for courses
		{
			$CI->db->where("course_id",$id);  		
			$res = $CI->db->get("chapters");
		}
		return $res->row_array();		
	}
} 


if ( !function_exists('is_loggedin')) 
{	
 function is_loggedin() {
		$CI = &get_instance();
		if($CI->session->has_userdata('user_is_logged_in')){
			$userData = $CI->session->userdata('user_is_logged_in');
			if(!empty($userData)){
				// print_r($userData['id']);die;
				$data = is_user_active_check($userData['id']);
				if($data[0]->status==1)
					{ 
						$token_check = get_token($userData['id']);
						if($token_check[0]->app_token == $userData['app_token']){
							return true; 
						}else{
							$session_userdata = array('admin_is_logged_in');
							$CI->session->unset_userdata($session_userdata);
							if (!$CI->session->has_userdata('is_logged_in')) {
								 $CI->session->sess_destroy();
							}
							return FALSE;
						}
					}
				else
				 {  
				 	$session_userdata = array('admin_is_logged_in');
					$CI->session->unset_userdata($session_userdata);
					if (!$CI->session->has_userdata('is_logged_in')) {
						 $CI->session->sess_destroy();
					}
					//$CI->session->sess_destroy();
					return FALSE;
			     }

			}else{ return FALSE; }
		}
       return FALSE; 	
    }
}

function is_user_active_check($user_id)
{
	
	$CI = &get_instance();		
	$menus = $CI->db->select(array('status'))->where("id=".$user_id)->get('users')->result();
	// echo $CI->db->last_query();
	//print_r($menus);die;
	return $menus;
}

function get_token($user_id)
{
	
	$CI = &get_instance();		
	$app_token = $CI->db->select(array('app_token'))->where("id=".$user_id)->where("status=1")->get('users')->result();
	//echo $CI->db->last_query();
	 // print_r($app_token);die;
	return $app_token;
}

if ( !function_exists('generate_token')) {
	function generate_token($user_id) {
		if($user_id) return md5(uniqid($user_id, true));
		else return md5(uniqid(rand(), true)); 
	}
}



