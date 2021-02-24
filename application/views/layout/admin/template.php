<?php 
	header("Expires: Thu, 19 Nov 1981 08:52:00 GMT"); //Date in the past
	header("Cache-Control: no-store, no-cache, must-revalidate"); //HTTP/1.1
	?>
<!DOCTYPE html>
<html>
	<head>
    	<title> 
    	<?php
		if(!empty($page_title))
		{			
		echo $page_title;
		}		
		?>	 - Admin Panel</title>
    	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/site/" ?>favicon.ico" />
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
		<meta charset="utf-8"/>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
		<?php $this->load->view('layout/admin/header');  ?>
		</head>	 
	</head>
	<?php $body_class = '';  if(!$this->session->has_userdata('admin_is_logged_in')) $body_class = "login-page" ; ?>
	<body class="flat-blue <?php echo $body_class; ?>">
			<?php if($this->session->has_userdata('admin_is_logged_in')){  ?> 
			<div class="app-container"> <?php } ?>
				<?php  
				 $this->load->view('layout/admin/main_content'); 
				 $this->load->view('layout/admin/footer');
				 ?>
				<?php if($this->session->has_userdata('admin_is_logged_in')){  ?> 
			</div> <?php } ?>
	</body>
</html>
