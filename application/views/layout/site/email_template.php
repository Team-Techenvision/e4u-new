<?php 
	header("Expires: Thu, 19 Nov 1981 08:52:00 GMT"); //Date in the past
	header("Cache-Control: no-store, no-cache, must-revalidate"); //HTTP/1.1
	?>
<!DOCTYPE html>
<html>
	<head>
    	<title><?php echo SITE_NAME.' - '.$subject; ?></title>
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
		<meta charset="utf-8"/>
	</head>
	<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
				   <td align="center" valign="top">
				      <table width="550" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
				         <tbody>
				            <tr bgcolor="#ffffff;">
				               <td align="left" valign="top" style="border:1px solid #ccc;background:#272727;padding:10px 20px"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt=""></td>
				            </tr>
				           	<?php echo $content; ?>
				         </tbody>
				      </table>
				   </td>
				</tr>
			</tbody>
		</table>
	</body>
</html>
	
