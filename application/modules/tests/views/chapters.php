<div class="inner_banner" style="background-image:url(<?php echo base_url();?>assets/site/images/practice-banner.jpg)">
	<?php $this->load->view('layout/site/course-form',$data_course);  ?> 
</div>
<div class="inner_content">
	<div class="subject_menu clearfix">
		<div class="content_wrapper">
			<ul class="sbj-div">
				<?php foreach($subjects as $key=>$value){ ?>
				<?php if($value != "") { ?>
				<li class="<?php echo strtolower($value); ?> act"><a class="<?php echo ($key == $current_subject?"active":""); ?>" href="<?php echo base_url();?>tests/chapters/<?php echo $course;?>/<?php echo $class;?>/<?php echo $key;?>" title="<?php echo $value; ?>"><span class="icon-sprite"></span><?php echo $value; ?></a></li>
				<?php } }?>
			</ul>
		</div>
	</div>
	<div class="chapter_list">
		<div class="content_wrapper">
			<h2>Chapters</h2>
			<?php if(!empty($subjects)){?>
			<a class="download fancybox fancybox.ajax" title="Download" href="<?php echo base_url()."tests/get_downloads/$class/$current_subject" ?>"><span class="icon-sprite"></span>Download</a>
			<?php if($type['is_subjective']==1 && !empty($cat_count)){?>
			<div class="progress_test" style="padding:0px;border:none;">
				<a class="ans_prev" href="<?php echo base_url();?>subjective/chapters/<?php echo $course;?>/<?php echo $class;?>/<?php echo $category_id;?>/<?php echo $current_subject;?>" title="Back to Subjective" style="margin-top:0px;">Back to Subjective</a>
			</div>
			<?php } ?>
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
					<h3><?php if(strlen($value['name'])>30){
						echo substr($value['name'],0,30)."...";
						}else{
							echo $value['name'];
						}
					?></h3>
				<p><?php
			if(strlen($value['description'])>70){
				echo substr($value['description'],0,70)."...";
			}else{
				echo $value['description'];
			}
					 ?></p>
					<a href="<?php echo base_url();?>tests/levels/<?php echo $current_subject;?>/<?php echo $value['id'];?>" title="Select Chapter">Select Chapter</a>
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
