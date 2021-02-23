<div class="subjective-popupmain">
	<div class="subjective-pop-section clearfix">
	<?php echo form_open();?>
	<?php echo form_input(array('name' => 'course_id', 'type'=>'hidden', 'id' =>'course_id','value' => $course_id));?>
	<?php echo form_input(array('name' => 'class_id', 'type'=>'hidden', 'id' =>'class_id','value' => $class_id));?>
	<h2>Choose your <?php echo $first_sub;?> options</h2>
	<div class="obj-button">
		<a class="ans_prev" href="<?php echo base_url();?>tests/chapters/<?php echo $course_id;?>/<?php echo $class_id;?>">Objective</a>
	</div>
	<div class="select-box">
		<?php $category_list[''] = "Subjective";?>
		<?php echo form_dropdown("subjective",$category_list,'',"id='subjective'");?>
	</div>
	<?php echo form_close();?>
</div>
</div>

