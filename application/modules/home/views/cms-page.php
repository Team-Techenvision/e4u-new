	<?php if($this->uri->segment(1)=="about-us"){
		$heading = "About Us";
	}
	else if($this->uri->segment(1)=="why-e4u")
	{
		$heading = "Why e4u";
	}
	else if($this->uri->segment(1)=="conditions")
	{
		$heading = "Conditions";
	}
	else if($this->uri->segment(1)=="privacy-policy")
	{
		$heading = "Privacy Policy";
	}
	else if($this->uri->segment(1)=="neet")
	{
		$heading = "NEET";
	}
	?>
	<?php include "includes/header.php";?>
	<div class="inner-banner">
		<div class="wrapper">
			<h2><?php echo $heading;?></h2>
		</div>
	</div>
 	<?php
	if($this->uri->segment(1)=="about-us"||$this->uri->segment(1)=="why-e4u"){
	 	echo $page_content["content"];
	}else{
	?>
	<div class="cmscontent">
		<div class="wrapper">
		<?php  echo $page_content["content"];
		?>
		</div>
	</div>
	<?php } ?>

 
