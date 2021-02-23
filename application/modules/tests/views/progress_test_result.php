					<section class="testresult-wrapper">
			<div class="container">
			<div class="test-mark-box">
			    <h1 class="text-center"> Test Result </h1>			
					<div class="row test-result progress-test">																
								 <div class="col-md-2">
									<div class="circle circle-blue">
										<p class="result"> <?php echo $count;?> </p>									
									 </div>
									<p class="question">Questions </p>
								</div>
								 <div class="col-md-2 ">
									<div class="circle circle-orange ">
										<p class="result"><?php echo $percent_completed;?>% </p>
									</div>
									<p class="question">Completed </p>
								</div>
								 <div class="col-md-2 ">
									<div class="circle circle-green">
										<p class="result"><?php echo $count_correct;?> </p>
									</div>
									<p class="question">Correct </p>
								</div>	
								<div class="col-md-2 ">
									<div class="circle circle-red">
										<p class="result"><?php echo $count_wrong;?></p>
									</div>
									<p class="question">Wrong </p>
								</div>	
								<div class="col-md-2 ">
									<div class="circle circle-black">
										<p class="result"><?php echo count($not_answered);?> </p>
									</div>
									<p class="question">Unanswered </p>
								</div>	
								<!-- <div class="col-md-2 ">
									<div class="circle circle-yellow">
										<p class="result"><?php echo $user_marks;?> </p>
									</div>
									<p class="question">Total Score </p>
								</div>	 -->
				     	</div>
				    </div>
			   </div>
		</section>
		
		<section class="time-wrapper">
		    <div class="container  ">
			   <div class="time-box">
					<div class="row time-details text-center">
						<div class="col-md-3"></div>
						<!-- <div class="col-md-3">  
						   <p>Total time </p>
						   <span>00:30:00 </span>
						</div>
						<div class="col-md-3">
							<p>Time Elapsed </p>
							<span>00:20:30 </span>
						</div> -->
						<div class="col-md-3"></div>					
					</div>				
					<div class="congrats-msg">
								<p> Dear  <label>
				<?php if($this->session->has_userdata('user_is_logged_in')){ 
              $this->load->helper('profile_helper');
                $user = user_data();
                echo '"'.ucfirst(strlen($user[0]->first_name." ".$user[0]->last_name)>16?substr(($user[0]->first_name." ".$user[0]->last_name),0,16):$user[0]->first_name." ".$user[0]->last_name).'"';
         		 }?>
						</label> congrats for the score.</p>
						<span>Please find the status of the Test you have gone through. </span>
					</div>
				</div>
		    </div>		
		</section>		
		<section class="answer-wrapper">
		  <div class="container">
		      <div class="row">
			    	 	<?php foreach($questions as $key => $value){?>
			    	 		<div class="question-section questions-images">
						  <?php  $j=1; if($value['question_type'] == 1 ){
									$ques = nl2br($value['question']);
									$ques_class = "";
								}else{
									$ques = "<img src='".$this->config->item('questions_url'). $value['question']."' style='width: 100%;height: 250px;'/>";
									$ques_class = "image-question";
								}
								if($value['answer_type'] == 1 ){
									$ans_class = "";
								}else{
									$ans_class = "image-options img-center";
								}
					      ?>
							<h2 class="<?php echo $ques_class; ?>">
							<?php if($value['severity'] == 1){
									$severity = "Important";
								}else if($value['severity'] == 2){
									$severity = "High";
								}else if($value['severity'] == 3){
									$severity = "Low";
								}else{
									$severity = "";
								}
								if($value['answer_type'] == 1){ 
									$class_img="";
								}else{ 
									$class_img="question-img-ul";
								}

								$ans_array = explode(',',$value['correct_answer']);
								$ans_count = count($ans_array);
							?>
						<div class="col-md-12 col-sm-12">
							<div class="options-section modified">
								 <h4>Q <?php echo $value['testt_serial_number']; ?></h4>
						 		 <p><?php echo $ques; ?></p>
						   </div> 

					     
								  <div class="<?php if($value['show_options']==0){ echo "options-display-images"; } else { echo "options-modified";}?>">	
								     <ul class=" ques_ans_options clearfix result_page">
                                       <?php  $choices = unserialize($value['choices']);
                                       	$count_choice =0;
                                       	foreach($choices as $key1=>$value1){ 
                                       
                                       		$chosen = " ";
									 // 		if($ans_count==1){
									 // 		if($key1 == $value['selected_answer'] && $value['status'] == 1)
										// 	{
										// 		if($value['is_correct'] == 1){
										// 			$chosen = "ans_correct";
										// 		}else{
										// 			$chosen ="ans_wrong"; //for chosen answer
										// 		}
										// 	}
										// }else{
										// 	$sel_ans_arr = explode(',',$value['selected_answer']);
										// 	if(in_array($key1, $sel_ans_arr) && $value['status'] == 1)
										// 	{
										// 		if($value['is_correct'] == 1){
										// 			$chosen = "ans_correct";
										// 		}else{
										// 			$chosen ="ans_wrong"; //for chosen answer
										// 		}
										// 	}

										// }
										// 	if($key1 == $value['correct_answer']){
										// 		$correct="ans_correct";	//for correct answer
										// 	}else
										// 	{
										// 		$correct="";
										// 	}
                                       		if($ans_count==1){
									 		if($key1 == $value['selected_answer'] && $value['status'] == 1)
											{
												if($value['is_correct'] == 1){
													//$chosen = "ans_correct";
													if($value['show_options']==0){ $chosen = "ans-correct"; }else{ $chosen = "ans_correct"; }
												}else{
													//$chosen ="ans_wrong"; //for chosen answer
													if($value['show_options']==0){ $chosen = "ans-wrong"; }else{ $chosen = "ans_wrong"; }
												}
											}
										}else{
											$sel_ans_arr = explode(',',$value['selected_answer']);
											if(in_array($key1, $sel_ans_arr) && $value['status'] == 1)
											{
												if($value['is_correct'] == 1){
													if($value['show_options']==0){ $chosen = "ans-correct"; }else{ $chosen = "ans_correct"; }
												}else{
													if($value['show_options']==0){ $chosen = "ans-wrong"; }else{ $chosen = "ans_wrong"; }
												}
											}

										}
											if($key1 == $value['correct_answer']){
												//$correct="ans_correct";	//for correct answer
												if($value['show_options']==0){ $correct = "ans-correct"; }else{ $correct = "ans_correct"; }
											}else
											{
												$correct="";
											}
											// $arr = explode(',',$value['answer_type']);
											// if($arr[$count_choice] == 1){
											// 	$ans = "$value1";
											// }else{
											// 	$ans = "<img src='".$this->config->item('answers_url').$value1."' style='width:100%;height: 100px;'/>";
											// }
								 		?>
										<li class="progress_li list_<?php echo $key1;?> <?php echo $correct; ?> <?php echo $chosen; ?>">
									 	<?php echo form_checkbox('options[]',$key1,'',array('class'=>'options progress_options option_'.$key1, 'id'=>'option'.$j ,'disabled' => 'disabled')); ?>
									 	<label for="option<?php echo $j;?>"><span <?php if($value['show_options']==0){?> style="display:none;"<?php }?>><?php echo $key1;?></span><p><?php echo $value1;?></p></label>
										</li>
										<?php  $j++; $count_choice++; }  ?>							
									 </ul>
								  </div>
							   </div>
							   <!-- explanation section start -->
							  <?php 
							  	if($value['explanation_type'] != 0){
							  		if($value['explanation_type'] == 2)
									{
										$class_img = "img_ans_desc";
									}
									else
									{
										$class_img = "";
									}
									if($value['explanation_type'] == 2){
										$exp = "<img style='max-width: 100%;' src='".base_url() . 'appdata/explanations/thumb_explanation_img/'. $value['explanation']."' />";
									}else{
										$exp = nl2br($value['explanation']);
									}
										?>
										<div class="options-section">
									      <h4>Explanation</h4>
										 <?php echo $exp; ?>
								  		</div>
										<?php
								}
								?>
							   <!-- explanation section end -->

						   </div>
						   <?php 
						} ?>
			  </div>
		  </div>
		</section>	
		<?php echo $links;?>