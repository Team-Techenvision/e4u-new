<html>
<head>
<title>Ads Payment Progress  </title>
</head>
<body>
<center>

<?php  
   $details = $merchant_data;
	$merchant_data = ''; 
	$working_key = 'Working key';//Shared by CCAVENUES
	$access_code = 'access code';//Shared by CCAVENUES	
	foreach ($details as $key => $value){
		$merchant_data.=$key.'='.urlencode($value).'&';
	}

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php  
echo "<input type='hidden' name='encRequest' value='".$encrypted_data."'>";
echo "<input type='hidden' name='access_code' value='".$access_code."'>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>

