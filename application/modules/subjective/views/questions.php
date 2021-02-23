<div class="inner_banner" style="background-image:url(<?php echo base_url();?>assets/site/images/practice-banner.jpg)">
	<?php $this->load->view('layout/site/course-form',$data_course);  ?> 
</div>
<div class="inner_content">
	<div class="practice_detail">
		<div class="practice_detail_title clearfix">
			<div class="content_wrapper">
				<div class="practice_left">
					<h2><?php echo $selected_chapter['name']; ?></h2>
					<ul class="practice-nav">
						<li><a title="<?php echo $selected_subject['name']; ?>" href="<?php echo base_url();?>subjective/chapters/<?php echo $course;?>/<?php echo $class;?>/<?php echo $category;?>/<?php echo $selected_subject['id'];?>"><?php echo $selected_subject['name']; ?></a></li>
						<li><a title="Chapter" href="#">Chapter</a></li>
				</ul>
				</div>
				<div class="practice_level">
					 <?php echo form_input(array('name' => 'course_id', 'type'=>'hidden', 'id' =>'course_id','value' => $course));
					 echo form_input(array('name' => 'class_id', 'type'=>'hidden', 'id' =>'class_id','value' => $class));
					 echo form_input(array('name' => 'chapter_list', 'type'=>'hidden', 'id' =>'chapter_id','value' => $selected_chapter['id']));
					 echo form_input(array('name' => 'subject_list', 'type'=>'hidden', 'id' =>'subject_id','value' => $selected_subject['id']));?>
					<div class="select-box">
						<?php $selected_category = $category;
						if(count($category_list)>2){
						echo form_dropdown("category_list",$category_list,$selected_category,
"id='category_list'");
					} ?>
					</div>
				</div>
			</div>
		</div>
		<div class="practice_detail_cont answer-section">
			<div class="content_wrapper">
				<div class="ques_ans clearfix">
					<?php echo form_open_multipart();?>
					<?php if(count($question) == 0) { ?>
						<h2 style="text-align:center;">No Questions Found</h2>
					<?php } else { ?>
					<?php $j=1+$current_page*$per_page;
					foreach($question as $key=>$questions)
					{
					if($questions['question_type'] == 1 ){
						$ques = nl2br($questions['question']);
						$ques_class = "";
					}else{
						$ques = "<img style='max-width: 100%;' src='".base_url().'appdata/subjective_questions/thumb_subjective_questions_img/'.$questions['question']."' />";
						$ques_class = "ans-image-quest";
					}
					
					if($questions['explanation_type'] == 1 ){
						$ans = nl2br($questions['explanation']);
						$ans_class = "image-options";
					}else{
						$ans = "<img src='".base_url().'appdata/subjective_explanations/thumb_subjective_explanation_img/'.$questions['explanation']."' />";
						$ans_class = "image-options";
					}
					
					?>	
					<div class="answer-section-list">
						<h2 class="<?php echo $ques_class; ?>">
						<?php if($questions['severity'] == 1){
							$severity = "Important";
						}else if($questions['severity'] == 2){
							$severity = "High";
						}else if($questions['severity'] == 3){
							$severity = "Low";
						}else{
							$severity = "";
						}?>
						<p>Q<?php echo $j; ?><?php if($severity != ""){?><span  class="ques_type"><?php echo $severity;?></span><?php } ?></p><?php echo $ques;?></h2>	
						<ul class="ques_ans_options answer-page-options clearfix <?php echo $ans_class;?>">
						<li class="list desc_li">
							<label for="option<?php echo $j;?>"><span>Answer</span><p><?php echo $ans;?></p></label>
						</li>
						<?php  ++$j; ?>
						</ul>
					</div>
					<?php } 
					echo $this->pagination->create_links();
					}?>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$("#category_list").on("change", function() {		
	var course_id = $('#course_id').val();
	var class_id = $('#class_id').val();
	var subject_id = $('#subject_id').val();
	var chapter_id = $('#chapter_id').val();
	var category_id = $(this).val();
	if(category_id != ""){
	location.href = base_url+"subjective/questions/"+course_id+"/"+class_id+"/"+category_id+"/"+subject_id+"/"+chapter_id;
	}
	
});
</script>

