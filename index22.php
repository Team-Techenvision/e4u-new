<?php
 echo  $ipdat = file_get_contents("http://ip-api.com/json/46.246.126.114"); 
 
 $url = 'http://ip-api.com/json/46.246.126.114';

$rCURL = curl_init();

curl_setopt($rCURL, CURLOPT_URL, $url);
curl_setopt($rCURL, CURLOPT_HEADER, 0);
curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1); 
$aData = curl_exec($rCURL); 
curl_close($rCURL); 
$result = json_decode ( $aData );
print_r($result);