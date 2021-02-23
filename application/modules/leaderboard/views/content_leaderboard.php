	<?php $rank = 1;?>
	<?php foreach($participants as $key=>$value) { ?>
	<?php if($value['user_id'] != ""){ ?>
	<tr <?php if(($rank%2)!=0){?>class="odd"<?php } ?>>
		<td class="align-center"><?php echo $rank;?></td>
		<?php if($value['profile_image']!=""){
			
			$img_src = thumb($this->config->item('profile_image_url') .$value['profile_image'] ,'50', '50', 'thumb_profile_img',$maintain_ratio = TRUE);
			$img_prp = base_url() . 'appdata/profile/thumb_profile_img/'.$img_src;
	 	}else{
	 		if($value['gender'] == 2)
			{
				$img_src = 'assets/site/images/no-image.png';
			}
			else
			{
				$img_src = 'assets/site/images/no-image-men.png';
			}
		  	$img_prp=base_url() .$img_src;
	 	} ?>
		<td><div class="participant-name-wrap"><img height="40" src="<?php echo $img_prp;?>" alt="Participant" class="rounded-circle" alt="leader-icon" /><span class="participant-name"><?php echo $value['first_name']." ".$value['last_name'];?></span></div></td>
		<td class="align-center"><?php echo $value['questions'];?></td>
		<td class="align-center"><?php echo $value['accuracy'];?></td>
		<td class="align-center">
		<?php 
		if($value['minutes'] > 60){
			$hours = $value['minutes']/60;
		}else{
			$hours = 1;
		}
		$speed = $value['questions']/$hours;
		echo round($speed);?>
		</td>
		<td class="align-center"><?php echo $value['progress_count'];?></td>
		</tr>
		<?php }else{ ?>
		 	
	 	<?php } ?>
		<?php $rank++;
	 	} if(count($participants)==0){
			?>
			<tr class="odd"><td  colspan="7" class="align-center">No Records Found</td></tr>
			<?php
		} ?>
	