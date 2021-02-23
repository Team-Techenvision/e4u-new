<div class="ans_desc_popup performtip-popup">
	<h2>
		<div class="participant-image">
		<?php if($tips['profile_image']!=""){
			$img_src = thumb($this->config->item('profile_image_url') .$tips['profile_image'] ,'50', '50', 'thumb_profile_img',$maintain_ratio = TRUE);
			$img_prp = base_url() . 'appdata/profile/thumb_profile_img/'.$img_src;
	 	}else{
		 	$img_src="assets/site/images/no-image-men.png";
		  	$img_prp=base_url() .$img_src;
	 	} ?>
		<img height="50" src="<?php echo $img_prp;?>" alt="Participant" />
		</div>
		<p><?php echo $tips['first_name']." ".$tips['last_name'];?></p>
		<span><?php echo $tips['course_name'];?></span>
	</h2>
	<div class="ans_desc_desc">
		<h3><?php echo $tips['tips_title'];?></h3>
		<div class="overall-content scroll-pane">
			<div class="overall-content-inner">
				<p><?php echo $tips['tips'];?></p>
			</div>
		</div>
	</div>	
</div>
