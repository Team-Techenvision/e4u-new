<html>
<head>
<title>Ads Payment Progress  </title>
</head>
<body>
<center>
<!--<h1>payment</h1>-->
<?php 
    //echo phpinfo();exit;
    $details = $merchant_data;
	$merchant_data = '';
	$working_key = 'sgdgdfgdfgdfgdfgdfgdfgdfgfdgdfgdfgdfgd';//Shared by CCAVENUES
	$access_code = 'gdfggfdgdfgdfgdfgdfgfdgfdgdfg';//Shared by CCAVENUES	
	foreach ($details as $key => $value){
		$merchant_data.=$key.'='.urlencode($value).'&';
	}
	
	$encrypted_data=encrypt($working_key,$merchant_data); // Method for encrypting the data.
	//https://test.ccavenue.com
	//service@ccavenue.com
?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php  
echo "<input type='hidden' name='encRequest' value='".$encrypted_data."'>";
echo "<input type='hidden' name='access_code' value='".$access_code."'>";
?>
</form>
</center>
<script language='javascript'>
document.redirect.submit();

</script>
</body>
</html>

