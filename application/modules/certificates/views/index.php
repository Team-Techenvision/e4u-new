<div class="certification-section">
	<div class="wrapper">
<?php
 	if(!empty($certificate_list)){
	$k=1;
	$ribben_icon='';
	foreach($certificate_list as $certificate)
	{ ?>
	<?php
		if($certificate['test_type']==1)
		{
			$ribben_icon="green-ribben";
		}
		if($certificate['test_type']==2)
		{
			$ribben_icon="red-ribben";
		}
	?>
	<div class="certificate-list">
		<div class="certificate-content">
			<span class="<?php echo $ribben_icon; ?> dashboard-sprite"></span>
			<div class="certification-inner<?php echo $k; ?>">
				<?php if($certificate['test_type']==1)
				{
					$test_type= $certificate['level_name']." progress test";
					$text = "in ";
					$bold_text = $certificate['course_name'];
				}else if($certificate['test_type']==2)
				{
					$test_type="surprise test";
					$text = "on ".date('d-m-Y',strtotime($certificate['end_date']));
					$bold_text = "";
				} else 
				{
					$test_type="";
					$text="";
					$bold_text = "";
				}?>
				<p>Well Done! You have successfully completed the <?php echo $test_type." ".$text;?> <strong><?php echo $bold_text; ?></strong></p>
				<a target="_blank" href="<?php echo base_url().'certificates/generate_certificate/'.$certificate['test_id']; ?>" title="Download Certificate">DOWNLOAD CERTIFICATE</a>
			</div>
		</div>
		<div class="certificate-date">
			<?php $date = date('M dS, Y',strtotime($certificate['end_date']));?>
			Completed on: <span><?php echo $date;?></span>
		</div>
	</div>
	<?php if($k%4==0)
	{ 
		$k=0; 
	} 
	$k++;
	} 
	echo $this->pagination->create_links();
	} else { ?>
	<div class="">
		<div class="alert-list">
			<h2 style="text-align:center;padding:0px">No Records Found</h2>
		</div>
	</div>
	<?php } ?>
	</div>
</div>	

