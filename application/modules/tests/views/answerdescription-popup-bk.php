<div class="ans_desc_popup">
	<h2>Answer Description</h2>
	<div class="ans_desc_desc">
		<h3>You have <?php if($option_selected==""){ echo "not "; }?>choosen the <span class="selected">Answer <?php echo $option_selected; ?></span> and the correct answer was <span class="correct">Option <?php echo $answer_description['correct_answer'];?></span>  because</h3>
		<?php 
			if($answer_description['explanation_type'] == 2 && $test_type == 2){
				$exp = "<img src='".base_url() . 'appdata/surprise_img/surprise_explanations_img/thumb_explanation_img/'. $answer_description['explanation']."' />";
			}else if($answer_description['explanation_type'] == 2 && $test_type != 2){
				$exp = "<img src='".base_url() . 'appdata/explanations/thumb_explanation_img/'. $answer_description['explanation']."' />";
			}else{
				$exp = $answer_description['explanation'];
			}
		?>
		<h4><?php echo $exp; ?></h4>
	</div>	
</div>
