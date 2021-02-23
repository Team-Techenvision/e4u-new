<div class="inner_banner paymentchart-banner home-title-sec" style="background-image:url(<?php echo base_url();?>assets/site/images/practice-banner.jpg)">
	<div class="home-title-bg">Choose</div>
	<h2>FAQ's</h2>
</div>
<div class="inner_content">	
		<?php $i=1;?>		
		<?php foreach($faq as $key=>$value){?>
		<h2><span><?php echo $i;?>. <span><?php echo $value['question'];?></h2>
		<small><p style="margin-bottom:10px;"><?php echo $value['answer'];?></p></small>
		<?php $i++;
		} ?>
</div>


	
