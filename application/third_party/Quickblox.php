<?php /*** QUICKBLOX API ***/
DEFINE('QB_API_ENDPOINT', "https://api.quickblox.com");
DEFINE('QB_PATH_SESSION', "session.json");
class Quickblox{
	
	function __construct($DataArray =array())
	{	
			$this->appId = $DataArray['appId'];
			$this->authKey = $DataArray['authKey'];
			$this->authSecret = $DataArray['authSecret'];
			$this->login =  $DataArray['username']; 
			$this->email =  $DataArray['email']; 
			$this->password = $DataArray['password'];
	}
	
	function createSession() {
		  if (!$this->appId || !$this->authKey || !$this->authSecret || !$this->login || !$this->password) {
			 return false;
		  } 
			/** Generate signature **/
		  $nonce = rand();
		  $timestamp = time(); // time() method must return current timestamp in UTC but seems like hi is return timestamp in current time zone
		  $signature_string = "application_id=" . $this->appId . "&auth_key=" . $this->authKey . "&nonce=" . $nonce . "&timestamp=" . $timestamp . "&user[login]=" . $this->login . "&user[password]=" . $this->password;

		  $signature = hash_hmac('sha1', $signature_string , $this->authSecret);

		  /** Build post body **/
		  $post_body = http_build_query( array(
			 'application_id' => $this->appId,
			 'auth_key' => $this->authKey,
			 'timestamp' => $timestamp,
			 'nonce' => $nonce,
			 'signature' => $signature,
			 'user[login]' => $this->login,
			 'user[password]' => $this->password
		  ));

		  /** Configure cURL **/
		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . QB_PATH_SESSION); // Full path is - https://api.quickblox.com/session.json
		  curl_setopt($curl, CURLOPT_POST, true); // Use POST
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
		  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		  $response = curl_exec($curl); 
		  $responseJSON = json_decode($response);
		  if (!empty($responseJSON))
		  {  
		  		if(isset($responseJSON->errors)){
		  			//return 'Error on quickblox authentication';
		  			return FALSE;
		  		}else
					return $responseJSON->session;
		  }
		  else {
			 	$error = curl_error($curl). '(' .curl_errno($curl). ')';
			 	//return $error;
			 	return FALSE;
		  }
		  curl_close($curl);
	}
	
	public function signUp($postfields){
		$url = 'http://api.quickblox.com/users.json';
		$method = 'POST';
		return $this->quickblox_curl_connect($url, $method, $postfields);
	}
	
	public function getUser($email){
		$url = 'http://api.quickblox.com//users/by_email.json?email='.$email;
		$method = 'GET';
		return $this->quickblox_curl_connect($url, $method);
	}
	
	public function deleteUser($user_id)
	{
		$url = 'http://api.quickblox.com/users/'.$user_id.'.json';
		$method = 'DELETE';
		return $this->quickblox_curl_connect($url, $method);
	}
	
	public function resetPassword($email){
		$url = 'http://api.quickblox.com/users/password/reset.json?email='.$email;
		$method = 'GET';
		return $this->quickblox_curl_connect($url, $method);
	}
	
	function quickblox_curl_connect($url, $method, $postfields = ''){
			$session = $this->createSession();  
			if(!empty($session)){
				$token = $session->token;
				$ch = curl_init($url); 
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
				if($postfields) 
					curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				  'Content-Type: application/json',
				  'QuickBlox-REST-API-Version: 0.1.0',
				  'QB-Token: ' . $token
				));
				$resultJSON = curl_exec($ch);
				return json_decode($resultJSON); 
			}
			return 'Error on token';
	}
}
