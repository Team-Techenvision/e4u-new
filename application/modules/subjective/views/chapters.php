<div class="inner_banner" style="background-image:url(<?php echo base_url();?>assets/site/images/practice-banner.jpg)">
	<?php $this->load->view('layout/site/course-form',$data_course);  ?> 
</div>
<div class="inner_content">
	<div class="subject_menu clearfix">
		<div class="content_wrapper">
			<ul>
				<?php foreach($subjects as $key=>$value){ ?>
				<?php if($value != "") { ?>
				<li class="<?php echo strtolower($value); ?> act"><a class="<?php echo ($key == $current_subject?"active":""); ?>" href="<?php echo base_url();?>subjective/chapters/<?php echo $course;?>/<?php echo $class;?>/<?php echo $category	;?>/<?php echo $key;?>" title="<?php echo $value; ?>"><span class="icon-sprite"></span><?php echo $value; ?></a></li>
				<?php } }?>
			</ul>
		</div>
	</div>
	<div class="chapter_list">
		<div class="content_wrapper">
			<h2>Chapters</h2>
			<?php if(!empty($subjects)){?>
			<a class="download fancybox fancybox.ajax" title="Download" href="<?php echo base_url()."tests/get_downloads/$class/$current_subject" ?>"><span class="icon-sprite"></span>Download</a>
			
			<div class="progress_test" style="padding:0px;border:none;">
			<div class="select-box practice_level">
			 	<?php echo form_input(array('name' => 'course_id', 'type'=>'hidden', 'id' =>'course_id','value' => $course));
				echo form_input(array('name' => 'class_id', 'type'=>'hidden', 'id' =>'class_id','value' => $class));
				echo form_input(array('name' => 'subject_list', 'type'=>'hidden', 'id' =>'subject_id','value' => $current_subject));?>
				<?php $selected_category = $category;
				echo form_dropdown("category_list",$category_list,$selected_category,
"id='category_list'");?>
			</div>
			<a class="ans_prev" href="<?php echo base_url();?>tests/chapters/<?php echo $course;?>/<?php echo $class;?>/<?php echo $current_subject;?>" title="Back to Objective" style="margin-top:0px;">Back to Objective</a>
			</div>
			<?php } ?>
			<ul class="chapter_list_items">
			<?php if(!empty($chapter_list)){?>
			<?php $i=1; ?>
			<?php foreach($chapter_list as $key=>$value){ ?>
				<?php if($i%4 == 1)
				{
					$style_class = "no-margin";
				}
				else
				{
					$style_class = "";
				}
				?>
				<li class="<?php echo $style_class;?>">
					<?php if($i < 10) {
					 echo form_label('0'.$i,'count');
					}
					else
					{
						echo form_label($i,'count');
					}?>
					<h3><?php echo $value['name'] ?></h3>
				<p><?php
			if(strlen($value['description'])>85){
				echo substr($value['description'],0,85)."...";
			}else{
				echo $value['description'];
			}
					 ?></p>
					<a href="<?php echo base_url();?>subjective/questions/<?php echo $course;?>/<?php echo $class;?>/<?php echo $category;?>/<?php echo $current_subject;?>/<?php echo $value['id'];?>" title="Select Chapter">Select Chapter</a>
				</li>
				<?php $i++; ?>
			<?php } ?>
			<?php } else { ?>
				<h1 style="border: 1px solid #ccc;font-size: 23px;padding-bottom: 20px;padding-top: 20px;text-align: center;">Chapters Not Available</h1>
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
<script>
$("#category_list").on("change", function() {		
	var course_id = $('#course_id').val();
	var class_id = $('#class_id').val();
	var subject_id = $('#subject_id').val();
	var category_id = $(this).val();
	if(category_id != ""){
	location.href = base_url+"subjective/chapters/"+course_id+"/"+class_id+"/"+category_id+"/"+subject_id;
	}
	
});
</script>
