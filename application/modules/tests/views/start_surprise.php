<div class="inner_banner" style="background-image:url(<?php echo base_url();?>assets/site/images/practice-banner.jpg)">
	<?php $this->load->view('layout/site/course-form',$data_course);  ?> 
</div>
<div class="inner_content">
	<div class="subject_menu clearfix">
		<div class="content_wrapper">
			<ul class="surprise">
				<?php foreach($surprise_test_course as $key=>$value){ 
				?>
				<li class="<?php echo strtolower($value); ?> act"><a class="<?php echo ($key == $current_course?'active':''); ?>" href="<?php echo base_url();?>tests/surprise/<?php echo $key;?>" title="<?php echo $value; ?>"><?php echo $value; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="chapter_list">
		<div class="content_wrapper">
			<h2>Surprise Test</h2>
			<ul class="chapter_list_items">
			<?php if(!empty($surprise_test)){?>
				<li class="no-margin">
					<?php 
						echo form_label('01','count');
					?>
					<h3><?php if(strlen($surprise_test['test_name'])>30){
						echo substr($surprise_test['test_name'],0,30)."...";
						}else{
							echo $surprise_test['test_name'];
						} ?></h3>
					<p><?php
					if(strlen($surprise_test['test_description'])>70){
						echo substr($surprise_test['test_description'],0,70)."...";
					}else{
						echo $surprise_test['test_description'];
					}
		 			?></p>
		 			<?php $current_date = date('Y-m-d'); ?>
					 <?php if(in_array($surprise_test['id'],$surprise_test_completed)){
					 	$button = "Test Completed";
					 	$href = "javascript:void(0);";
					 	$title = "Test Completed";
					 }else{
					 	$button = "Start Test";
					 	$href = base_url().'tests/start_surprise_test/'.$surprise_test['course_id'].'/'.$surprise_test['id'];
					 	$title = "Start Test";
					 }?>
					<a href="<?php echo $href;?>" title="<?php echo $title;?>"><?php echo $button;?></a>
				</li>
			<?php } else { ?>
				<h1 style="border: 1px solid #ccc;font-size: 23px;padding-bottom: 20px;padding-top: 20px;text-align: center;">Surprise Test Not Available</h1>
			<?php } ?>
			</ul>
		</div>	
	</div>
	<?php if(isset($ad_banner)){?>
	<?php  $this->load->view('layout/site/bottom_ad_banner',$ad_banner);?>
	<?php }?>
	<div class="surprise_package clearfix">
		<div class="content_wrapper">
			<ul>
				<li>
					<img src="<?php echo base_url();?>assets/site/images/adaptive-icon.png" alt="icon"/>
					<h3><?php echo $this->lang->line('adaptive');?></h3>
					<p><?php echo $this->lang->line('adaptive_content');?></p>
				</li>
				<li class="qusetion_set">
					<img src="<?php echo base_url();?>assets/site/images/question-icon.png" alt="icon"/>
					<h3><?php echo $this->lang->line('question_set');?></h3>
					<p><?php echo $this->lang->line('question_content');?></p>
				</li>
				<li class="chapter_set">
					<img src="<?php echo base_url();?>assets/site/images/chapter-icon.png" alt="icon"/>
					<h3><?php echo $this->lang->line('chapter_set');?></h3>
					<p><?php echo $this->lang->line('chapter_content');?></p>
				</li>
			</ul>
		</div>
	</div>
</div>
