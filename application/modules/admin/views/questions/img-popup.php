<div class="img_popup ans_desc_popup">
<h2>View Image</h2>
	<div class="scroll-pane">
		<?php if($type == 1)
		{
			$link = 'appdata/questions/thumb_questions_img/';
	 	} 
		else if($type == 2)
		{ 
			$link = 'appdata/answers/thumb_answers_img/';
		} 
		else if($type == 3)
		{
			$link = 'appdata/explanations/thumb_explanation_img/';
		} 
		else if($type == 4)
		{
			$link = 'appdata/subjective_questions/thumb_subjective_questions_img/';
		}
		else if($type == 5)
		{
			$link = 'appdata/subjective_explanations/thumb_subjective_explanation_img/';
		}
		else if($type == 6){
			$link = 'appdata/surprise_img/surprise_questions_img/thumb_questions_img/';
		}
		else if($type == 7){
			$link = 'appdata/surprise_img/surprise_answers_img/thumb_answers_img/';
		}
		else if($type == 8){
			$link = 'appdata/surprise_img/surprise_explanations_img/thumb_explanation_img/';
		}?>
		<div class="fancy-cont" style="min-width:1000px;text-align:center">
			<img style="max-width:100%" src="<?php echo base_url().$link.$ques_img;?>" alt="Loding" >
		</div>
	</div>	
</div>
