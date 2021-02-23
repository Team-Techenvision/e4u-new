<div class="result-graph-content">
	
	<?php if($type==0){ ?>
	<div class="level-dropdown">
		<div class="levelcomplete-list select-box">
			<?php $option = array(); 
				foreach($levels as $level){ 
					$option[$level["id"]] = substr($level["chapter_name"],0,20)."-".$level["name"];
				} 
				if(count($option)==0){
					$option[""]="No Levels";
				}						
				?>
			<?php echo form_dropdown("level_completed",$option,$filter_level,"id='level_completed'");?>
		</div>
	</div>
	<?php  
	} else if($type==1){ #for chapters on progress chart
		?>
		<div class="level-dropdown">
		<div class="levelcomplete-list select-box">
			<?php	$option_c = array(); 
						foreach($chapters as $chapter){ 
							$option_c[$chapter["id"]] = substr($chapter["chapter_name"],0,20);
						} 
if(count($option_c)==0){
	$option_c[""]="No Chapters";
}						
						?>
				<?php echo form_dropdown("chapter",$option_c,$filter_chapter,"id='chapter'");?>
		</div>
	</div>	
		<?php
		
	} ?>
	
	<div class="graph-section">			
		<?php
		if($is_chart==0){?>
		<!--[start]--><!--div></div><!--[start]-->
		<?php }else{
			########## Dont remove the comment <!--[start]--> #######
		?>
			<!--[start]--><?php echo $chart; ?><!--[start]-->
		<?php } ?>
	</div>  
	<?php if($is_chart==0){?>	
		<div class="no-content-found">
			<p>The data you're looking for can't be found.</p>
		<span></span>
		</div>
	<?php } ?>	
</div>

 
 
