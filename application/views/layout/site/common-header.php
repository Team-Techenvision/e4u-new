<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Favicons -->
    <link href="<?php echo base_url().'assets/site/images/favicon.png';?>" rel="icon">
    <!-- Bootstrap CSS File -->

    <link href="<?php echo base_url().'assets/site/css/bootstrap.min.css';?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/site/css/font-awesome.min.css';?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/site/css/animate.min.css';?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/site/fonts/fonts.css';?>" rel="stylesheet">
    <!-- <link href="<?php echo base_url().'assets/site/css/aos.css';?>" rel="stylesheet"> -->
    <link href="<?php echo base_url().'assets/site/css/font-awesome-animation.min.css';?>" rel="stylesheet">


    <!-- Custom Stylesheet File -->
    <link href="<?php echo base_url().'assets/site/css/style.css?'.time();?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/site/css/responsive.css';?>" rel="stylesheet">
    
    <link href="<?php echo base_url().'assets/site/css/owl.carousel.min.css';?>" rel="stylesheet">

<script type="text/javascript">
	var base_url = '<?php echo base_url();?>';
	var current_date = '<?php echo date("Y-m-d-H-i-s");?>';
	
</script>


  		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="<?php echo base_url().'assets/site/js/jquery.min.js';?>"></script>
        <script src="<?php echo base_url().'assets/site/js/jquery-migrate.min.js';?>"></script>
        <script src="<?php echo base_url().'assets/site/js/bootstrap.bundle.min.js';?>"></script>
        <script src="<?php echo base_url().'assets/site/js/easing.min.js';?>"></script>
        <script src="<?php echo base_url().'assets/site/js/mobile-nav.js';?>"></script>
        <script src="<?php echo base_url().'assets/site/js/wow.min.js';?>"></script>
		<script src="<?php echo base_url().'assets/site/js/jquery.twbsPagination.min.js';?>"></script>
      	<script src="<?php echo base_url().'assets/site/js/popper.js';?>"></script>
        <script src="<?php echo base_url().'assets/site/js/owl.carousel.min.js';?>"></script>
      	<script src="<?php echo base_url().'assets/site/js/pdf.js';?>"></script>
      	<script src="<?php echo base_url().'assets/site/js/pdf.worker.js';?>"></script>
	 	<script src="<?php echo base_url().'assets/site/js/aos.js';?>"></script>
	 	 <script type="text/javascript" src="<?php echo base_url();?>assets/site/js/jquery.countdown.js"></script> 

       
<?php
  $allowed_pages = array('dashboard','tests','subjective');
  if(in_array($this->uri->segments[1],$allowed_pages)){
?>
<script type="text/javascript" src="<?php echo base_url();?>assets/site/js/dashboard.js"></script>
<?php
} 
 
 ?>
<script type="text/javascript">


<?php
if($ref!=""){
?>
var ref_id = '<?php echo $ref ?>';
<?php
}
	if($type_mode=="reset_password"){
	?>
	$(window).load(function(){
		var url_login=$(".login-btn").attr("href");
		var url_register=$(".registeration-home").attr("href");	
		$(".login-btn").attr("href","<?php echo base_url(); ?>home/reset_password");
		$(".login-btn").trigger("click");
		$(".login-btn").attr("href",url_login);
		$(".registeration-home").attr("href",url_register);
	});

	<?php
	}
	 ?>
<?php
	if($type_mode=="login"){
	?>
	$(window).load(function(){
		$(".user-login").trigger("click");
	});

	<?php } ?>
	<?php 
	if($redirect_type=="downloads"){
	?>
	$(window).load(function(){
		$(".download_popup").trigger("click");
	});

	<?php } ?>
	
 	var course_id='<?php echo $course_id ?>';
	$(window).load(function(){
		$(".show"+course_id).trigger("click");
	});
	
</script>

