<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( !function_exists('getSearchDetails')) {
	function getSearchDetails($class){
		$CI = get_instance(); 
		if(isset($_SERVER["HTTP_REFERER"])){
			$url = explode("/",str_replace(base_url(), "", $_SERVER["HTTP_REFERER"])); 
			if(strpos($url[1],'?')){
				$url[1]	= substr($url[1], 0, strpos($url[1],'?'));	
			}			
			if(isset($url[1]) and $url[1]!=$class){				
				if($CI->config->item($url[1])){
					$sessions = $CI->config->item($url[1]);						
					foreach($sessions as $session){						
						if($CI->session->has_userdata($session)){							
							$CI->session->unset_userdata($session);
						}
					}
				}				
			}		
		}		
	}
}

 
