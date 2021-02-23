<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function encryptString($plaintext) {
		$key = 'schoolappkey';
		$iv = mcrypt_create_iv( mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM );
		$encrypted = base64_encode(
			 $iv .
			 mcrypt_encrypt(
				  MCRYPT_RIJNDAEL_128,
				  hash('sha256', $key, true),
				  $plaintext,
				  MCRYPT_MODE_CBC,
				  $iv
			 )
		);
		if ($encrypted)
        {
            $encrypted = strtr(
                    $encrypted,
                    array(
                        '+' => '.',
                        '=' => '-',
                        '/' => '~'
                    )
                );
        }
        
		return $encrypted;
}

function decryptString ($encrypt_text) {
		$key = 'schoolappkey';
		$encrypt_text = strtr(
                $encrypt_text,
                array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
                )
            );
    	
    	$data = base64_decode($encrypt_text);
		$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

		$decrypted = rtrim(
			 mcrypt_decrypt(
				  MCRYPT_RIJNDAEL_128,
				  hash('sha256', $key, true),
				  substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
				  MCRYPT_MODE_CBC,
				  $iv
			 ),"\0"
		);
    	return $decrypted; 
}

function randomString($length = 8) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
