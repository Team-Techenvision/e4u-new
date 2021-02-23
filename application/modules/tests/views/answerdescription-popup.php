<div class="ans_desc_popup">
	<h2>Answer Description</h2>
	<div class="ans_desc_desc desc_li">
		<?php if($answer_description['explanation_type'] == 2)
		{
			$class_img = "img_ans_desc";
		}
		else
		{
			$class_img = "";
		}?>
		<div class="scroll-pane <?php echo $class_img;?>">
			<h3>You have <?php if($option_selected==""){ echo "not "; }?>choosen the <span class="selected">Option <?php echo $option_selected; ?></span> and the correct answer was <span class="correct">Option <?php echo $answer_description['correct_answer'];?></span>  because</h3>
			<?php 
				if($answer_description['explanation_type'] == 2 && $test_type == 2){
					$exp = "<img style='max-width: 100%;' src='".base_url() . 'appdata/surprise_img/surprise_explanations_img/thumb_explanation_img/'. $answer_description['explanation']."' />";
				}else if($answer_description['explanation_type'] == 2 && $test_type != 2){
					$exp = "<img style='max-width: 100%;' src='".base_url() . 'appdata/explanations/thumb_explanation_img/'. $answer_description['explanation']."' />";
				}else{
					$exp = nl2br($answer_description['explanation']);
				}
			?>
			<h4><?php echo $exp; ?></h4>
		</div>	
	</div>	
</div>
