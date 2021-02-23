<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Push_notification
{
    public function push_notification_android($token, $msg, $type, $attendance_id = null) {
    	  $app_key = '4343434'; 
        $url = 'https://android.googleapis.com/gcm/send';
 		  $message = array(
						'message' => $msg,
						'flag' => $type,
						'vibrate'	=> 1,
						'sound'	=> 1,
						'id'	=> $attendance_id
			);
					
        $fields = array(
            'registration_ids' => array($token),
            'data' => $message,
        );
 
        $headers = array(
            'Authorization: key=' . $app_key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $url);
 		  curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        $result = curl_exec($ch);
        if ($result === FALSE) {
				$res =  '6';
        }
		  else
		  {
					$res =  '4';
		  }
 		  curl_close($ch);
        return $res;
    }
}
