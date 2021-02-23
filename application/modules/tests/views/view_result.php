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
						<li><a title="<?php echo $selected_subject['name']; ?>" href="<?php echo base_url();?>tests/chapters/<?php echo $course;?>/<?php echo $class;?>/<?php echo $selected_subject['id'];?>"><?php echo $selected_subject['name']; ?></a></li>
						<?php if($type != 2){ ?>
						<li><a title="Chapter" href="#">Chapter</a></li>
						<?php } ?>
					</ul>
				</div>
				<div class="practice_level progress_test" style="padding:0px;border:none;">
					<?php if($type != 2){?>
						<a class="ans_prev" href="<?php echo base_url();?>tests/progress_detail/<?php echo $test_random_id;?>/0/1" title="Back to Result Page" style="margin-top:0px;">Back to Result Page</a>
					<?php } else { ?>
						<a class="ans_prev" href="<?php echo base_url();?>tests/surprise_detail/<?php echo $test_random_id;?>/<?php echo $course_id;?>/0/1" title="Back to Result Page" style="margin-top:0px;">Back to Result Page</a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="practice_detail_cont">
			<div class="content_wrapper">
				<ul class="ans_info">
					<li class="questions">
						<span><?php echo $count; ?></span>
						<label>Questions</label>
					</li>
					<li class="answers">
						<span><?php echo $answered; ?></span>
						<label>Answers</label>
					</li>
					<li class="successfull">
						<span><?php echo $count_correct; ?></span>
						<label>Successfull</label>
					</li>
					<li class="wrong">
						<span><?php echo $count_wrong; ?></span>
						<label>Wrong</label>
					</li>
					<li class="completed">
						<div class="c100 green small p<?php echo $percent_completed;?>">
							<span><?php echo $percent_completed;?>%</span>
							<div class="slice">
								<div class="bar"></div>
								<div class="fill"></div>
							</div>
						</div>
						<label>Completed</label>
					</li>
				</ul>
				<div class="ques_ans">
					<?php $j=1;
					
					if($questions['question_type'] == 2 && $type != 2 ){
						$ques = "<img src='".base_url().'appdata/questions/thumb_questions_img/'.$questions['question']."' />";
						$ques_class = "image-question";
					}else if($questions['question_type'] == 2 && $type == 2 ){
						$ques = "<img src='".base_url() . 'appdata/surprise_img/surprise_questions_img/thumb_questions_img/'. $questions['question']."' />";
						$ques_class = "image-question";
					}else{
						$ques = nl2br($questions['question']);
						$ques_class = "";
					}
					
					if($questions['answer_type'] == 1 ){
						$ans_class = "";
					}else{
						$ans_class = "image-options img-center";
					}
					?> 
					<h2 class="<?php echo $ques_class; ?>">
					<?php if($questions['severity'] == 1){
						$severity = "Important";
					}else if($questions['severity'] == 2){
						$severity = "High";
					}else if($questions['severity'] == 3){
						$severity = "Low";
					}else{
						$severity = "";
					}
					if($questions['answer_type'] == 1){ 
								$class_img="";
							}else{ 
								$class_img="question-img-ul";
							}
					?>
					<p>Q<?php echo $serial_number['serial_number']; ?><?php if($severity != ""){?><span  class="ques_type"><?php echo $severity;?></span><?php } ?></p><?php echo $ques;?></h2>	
					<?php if($questions['selected_answer'] == ""){ ?> <h2><span> <?php echo "NOT ANSWERED";?></span></h2> <?php } ?>
					<ul class="<?php echo $class_img; ?> ques_ans_options clearfix <?php echo $ans_class;?>">
						<?php $choices = unserialize($questions['choices']); 
					 	foreach($choices as $key=>$value){ 
					 		$correct = "";
					 		$wrong = "";?>
					 		<?php 
					 			  if($questions['correct_answer'] == $key){
					 			  		$correct = "ans_correct";
					 			  }else{
					 			  	    $correct = '';
					 			  }
					 			  if($questions['correct_answer'] != $questions['selected_answer'] ){
					 			  	 if($questions['selected_answer'] == $key){
					 			  		$wrong = "ans_wrong";
					 			  	  }else{
					 			  	    $wrong = '';
					 			  	  }
					 			  }
					 			  if($questions['answer_type'] == 2 && $type!=2){
									$ans = "<img src='".$this->config->item('answers_url').$value."' />";
								  }else if($questions['answer_type'] == 2 && $type==2){
								  	$ans = "<img src='".$this->config->item('surprise_answers_url').$value."'/>";
								  }else{
								  	$ans = $value;
								  }
					 		?>
							<li class="<?php echo $correct; ?> <?php echo $wrong; ?> list_<?php echo $key;?>">
						 	<?php echo form_radio('options',$key,'',array('class'=>'option_'.$key, 'id'=>'option'.$j)); ?>
						 	<label for="option<?php echo $j;?>"><span><?php echo $key;?></span><p><?php echo $ans;?></p></label>
							</li>
						<?php  $j++; } ?>
					</ul>
						
					<ul class="ques_ans_nav clearfix">
						<li>
						<a class="fancybox fancybox.ajax ans_description" href="<?php echo base_url();?>tests/answer_description/<?php echo $questions['id'];?>/<?php echo $questions['selected_answer'];?>/<?php echo $type;?>" title="Answer Description">Answer Description</a>
						</li>
						<li><a class="ans_prev" href="<?php echo base_url();?>tests/view_result/<?php echo $test_random_id;?>/<?php echo $previous;?>/<?php echo $type;?>"<?php if($uri==0){?>style="display:none"<?php } else { ?>style="display:inline-block"<?php } ?> title="Prev">Prev</a></li>
						<li><a class="ans_next" href="<?php echo base_url();?>tests/view_result/<?php echo $test_random_id;?>/<?php echo $next;?>/<?php echo $type;?>"<?php if($serial_number['serial_number']==$count){?>style="display:none"<?php } else { ?>style="display:inline-block"<?php } ?> title="Next">Next</a></li>
					</ul>
				</div>
				
			</div>
		</div>
	</div>
</div>
<script>
	$(".ans_description").click(function(){
		$(".ans_description").attr("href",base_url+"tests/answer_description/"+ques_id+"/"+option_selected);
	});
	$(document).bind("contextmenu",function(e){
         return false;
   	});
   	document.onkeypress = function (event) {
	    event = (event || window.event);
	    if (event.keyCode == 123) {
	        return false;
	    }
	}
	document.onmousedown = function (event) {
	    event = (event || window.event);
	    if (event.keyCode == 123) {
	        return false;
	    }
	}
	document.onkeydown = function (event) {
	    event = (event || window.event);
	    if (event.keyCode == 123) {
	        return false;
	    }
	}
</script>
