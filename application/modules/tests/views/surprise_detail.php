<?php if($submit_status == 0){ ?>
	<section class="test-overview">
	   <div class="container">
		   <div class="standard-testdetails">
	      <div class="exam-details">
		     <label>TEST NAME</label>
			 <h3><?php echo $surprise_test[0]['test_name'];?></h3>
		  </div>
		  <div class="exam-details questions">
		     <label class="questions">QUESTIONS</label>
			 <h3><?php echo $count;?></h3>
		  </div>
			<input type="hidden" id="questions_count" value="<?php echo $count;?>">
			<input type="hidden" id="answered_count" value="<?php echo $answered;?>">
			<input type="hidden" id="serial_no" value="<?php echo $serial_number['serial_number']; ?>">
		  <div class="exam-details completed">
		     <label>COMPLETED</label>
			 <h3><?php echo $percent_completed;//$answered;?> %</h3>
			 <div class="progress">
				<div class="bar" style="width:<?php echo $percent;?>%">
				</div>
			</div>
		  </div>
		  <div class="exam-details total-time">
		     <label>TOTAL TIME</label>
			 <h3><?php echo sprintf("%02d", $surprise_test[0]['hours']);?>:<?php echo sprintf("%02d", $surprise_test[0]['mins']).":00";?></h3>
		  </div>
		  <div class="exam-details time-elapsed time_count">
		     <label>TIME ELAPSED</label>
			 <h3><div class="count_down" current_time="<?php echo $different_date; ?>" id="count_down"><?php echo ($different_date==""?"00:00:00":"00:00:00"); ?></div></h3>
		  </div>
         </div>
	   </div>
	</section>
    <section class="tabcontent-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane   in active" id="Alerts">
                        <div class="alert-innerbox">
                            <div class="questions-queue">
							   <div class="col-md-12 col-sm-12  answered-unanswered">
							     <ul>
								   <li>
								      <div class="answered"></div><span>Answered</span>
								   </li>
								   <li>
								      <div class="unanswered"></div><span>Unanswered</span>
								   </li>
								 </ul>
							   </div>
							   <div class="col-md-12 col-sm-12 question-numbers">
							       <ul>
							       	<?php for($i=1;$i <= $count;$i++){
							       			$li_class = "not_answered";
							       			$href= base_url().'tests/standard_detail/'.$test_random_id.'/'.$course_id.'/'.($i-1);
							       	?>
							       	<?php foreach($not_answered as $ans){
							       			$unans[] = $ans['serial_number'];
							       		}
							       		if(in_array($i, $unans)){
							       			$li_class = "not_answered";	
							       		}else{
							       			$li_class = "done";	
							       		}
							       		if($serial_number['serial_number'] == $i){
												$li_class = "active";
										}?>
									 <a href="<?php echo $href; ?>" <?php if($i > 22 && $serial_number['serial_number'] < $i){ ?> style="display:none"; class="dots" <?php }?>>
										<li class="<?php echo $li_class;?>">
						       			 	<?php echo $i;?>
						       			</li>
							       	 </a>
							       	<?php }
							       	?>
								 	</ul>
											 <button <?php if($count > 22 || $serial_number['serial_number'] > 22){ ?> style="display:inline"; <?php }  else { ?>style="display:none;"<?php }?>  onclick="hide_show()" id="myBtn">
											 	<?php 
											 		 if($count > 22 || $serial_number['serial_number'] > 22){
											 		 	$button = base_url().'assets/site/images/show-less.png';
											 		 }
											 		 if($count == $serial_number['serial_number'] ){
											 		 	$button = base_url().'assets/site/images/show-more.png';
											 		 }
											 	?>
											 <img src="<?php echo $button?>" id="less-more">
											 </button>
								</div>
                           </div>
	
				<div class="question-section questions-images">
					

					<?php 
					$attributes = array('id'=>'surprise-test');
					echo form_open_multipart('tests/submit_surprise_test',$attributes);?>
					<?php if($count == 0) { ?>
						<h2 style="text-align:center;">No Questions Found</h2>
					<?php } else { ?>
						<h5><b><?php echo ucfirst($questions['subject_name']);?></b></h5>
					<?php $j=1;
						if($questions['question_type'] == 1 ){
						$ques = nl2br($questions['question']);
						$ques_class = "";
					}else{
						$ques = "<img src='".$this->config->item('questions_url'). $questions['question']."'/>";
						$ques_class = "image-question";
					}
					
					if($questions['answer_type'] == 1 ){
						$ans_class = "";
					}else{
						$ans_class = "image-options img-center";
					}

					$ans_array = explode(',',$questions['correct_answer']);
					$ans_count = count($ans_array);

					
					?>
					<input type="hidden" id="ans_count" value="<?php echo $ans_count;?>">
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
					<div class="col-md-12 col-sm-12">
					<h4>Q <?php echo $serial_number['serial_number']; ?></h4>
					      <div class="options-section modified">
								
						 		 <p><?php echo $ques; ?></p>
									  <!-- <img src="images/question-new.png" >  -->
						   </div> 
						<?php echo form_input(array('name' => 'ques_id', 'type'=>'hidden', 'id' =>'ques_id','value' => $questions['id']));?>
						<?php echo form_input(array('name' => 'surprise_test_id', 'type'=>'hidden', 'id' =>'surprise_test_id','value' => $surprise_test_id));?>
						<?php echo form_input(array('name' => 'course_id', 'type'=>'hidden', 'id' =>'course_id','value' => $course_id));?>
						<?php $choices = unserialize($questions['choices']); ?>
								  <!-- options start -->
						<div style="margin-top:30px" class="<?php if($questions['show_options']==0){ echo "options-checkboxes"; } else { echo "options-radioboxes";}?>">	
						<ul style="list-style-type: none;">
						<?php 
						$count_choice=0;
						foreach($choices as $key=>$value){ 
						if($ans_count==1){
					 		if($key == $questions['selected_answer'] && $questions['status'] == 1)
							{
								$correct="ans_select";
								$checked ="checked";
							}else
							{
								$correct="";
								$checked = "";
							}
						}else{
							$sel_ans_arr = explode(',',$questions['selected_answer']);
							if(in_array($key, $sel_ans_arr) && $questions['status'] == 1)
							{
								$correct="ans_select";
								$checked ="checked";
							}else
							{
								$correct="";
								$checked = "";
							}
						}
							// $arr = explode(',',$questions['show_options']);
							// if($arr[$count_choice] == 1){
							// 	$ans = "$value";
							// }else{
							// 	$ans = "<img src='".$this->config->item('answers_url').$value."' style='width:100%;height: 100px;'/>";
							// }
					 	?>
							<li class="progress_li surprise_li list_<?php echo $key;?> <?php echo $correct ?>">
							 <?php 
							    if( $questions['show_options'] == 0 ){
									echo form_checkbox('options[]',$key, $checked ,array('class'=>'options progress_options option_'.$key, 'id'=>'option'.$j)); 
								}else{
									echo form_radio('options[]',$key, $checked ,array('class'=>'options progress_options option_'.$key, 'id'=>'option'.$j)); 
								}
							    
							 ?>
						 	<label for="option<?php echo $j;?>">
								<!-- < ?php echo $j; ?> -->
						 		<span <?php if($questions['show_options']==0){?> style="display:none;"<?php }?>>

						 			<!-- < ?php echo $key;?> -->
						 				
						 		</span>
								   <p style="margin-left:5px!important;"><?php echo $value;?></p>
								 </label>
							</li>
						<?php  $j++; $count_choice++; }  ?>
									 </ul>
								  </div>
								<?php } ?>
								  <!-- options end -->
					 <div class="button-section" style="display:<?php if($count == 0){?> none;<?php } else { ?>block;<?php } ?>">
						<?php echo form_input(array('name' => 'surprise', 'type'=>'hidden', 'id' =>'surprise','value' => 'surprise'));?>
						<?php echo form_input(array('name' => 'user_percent', 'type'=>'hidden', 'id' =>'user_percent','value' => $user_percent));?>
						<?php echo form_input(array('name' => 'test_random_id', 'type'=>'hidden', 'id' =>'test_random_id','value' => $test_random_id));?>
						<?php echo form_input(array('name' => 'test_id', 'type'=>'hidden', 'id' =>'test_id','value' => $test_id));?>
						<?php echo form_input(array('name' => 'option_selected', 'type'=>'hidden', 'id' =>'option_selected','value' => $option_selected));?>
						
						<span class="ans_prev" <?php if($uri==0){?>style="display: none;"<?php } else { ?>style="display: inline-block;"<?php } ?>><a href="<?php echo base_url();?>tests/standard_detail/<?php echo $test_random_id;?>/<?php echo $course_id;?>/<?php echo $previous;?>" title="Previous"><button type="button" class="btn btn-submit">< Previous</button></a></span>
						
						<span class="ans_next"  <?php if($serial_number['serial_number']==$count){?>style="display: none;"<?php } else { ?>style="display: inline-block;"<?php } ?> >
						<a href="<?php echo base_url();?>tests/standard_detail/<?php echo $test_random_id;?>/<?php echo $course_id;?>/<?php echo $next;?>"title="Next"><button type="button" class="btn btn-skip ">Next ></button></a></span>

						<?php if($answered!=$count){ ?>	
						<button type="button" class="btn btn-submittion-question" data-toggle="modal" id="submitBtnSta" data-target="#myModal_standed">Submit </button>
						<?php
					   }?>
						<?php if($answered==$count){ 
							$submit = "Finish"; ?>
							<span>
							<?php echo form_submit('submit',$submit,'id="surprise_test_submit" class="btn btn-submit" title="'.$submit.'"');?>
							</span>
							<?php }else{
							$submit = "Submit";
						?>
						<?php
							}?>
					</div>
					<?php echo form_close();?>
							   </div>
						   </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--popup-->
<div class="modal submitting-popup" id="myModal_standed">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal body -->
        <div class="modal-body">
            <h2>Are you sure submitting the test?</h2>
			<button type="button" class="btn btn-yes" id="ModalYes">Yes</button>
			<button type="button" class="btn btn-no" id="ModalNo">No</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>
<!--popup-->
<script>
$('.header-right ul').find('li').find('a').attr('href', "#");
$('.logo').find('a').attr('href', "#");
$(".alert-box").find('li').find('a').attr('href', "#");

$("#ModalNo").on('click', function(){
	//alert("daskljfdls");
	$("#myModal_standed").modal("hide");
});	

$("#ModalYes").on('click', function(){
	$( "#surprise-test" ).submit();
});	


function hide_show(){
	var len = $('.dots').length;
	if(len){
		if($(".dots").css("display")== "none"){
			$('.dots').css('display','inline');
			$("#less-more").attr('src',"<?php echo base_url().'assets/site/images/show-more.png'?>"); 
		}else{
			$('.dots').css('display','none');
			$("#less-more").attr('src',"<?php echo base_url().'assets/site/images/show-less.png'?>"); 
		}
	}
}
	$(document).bind("contextmenu",function(e){
         return false;
   	});
   	document.onkeypress = function (event) {
	    event = (event || window.event);
	    if (event.keyCode == 123) {
	        return false;
	    }
	    if (event.keyCode == 116){
	    	window.onbeforeunload = null;
	    }
	}
	document.onmousedown = function (event) {
	    event = (event || window.event);
	    if (event.keyCode == 123) {
	        return false;
	    }
	    if (event.keyCode == 116){
	    	window.onbeforeunload = null;
	    }
	}
	document.onkeydown = function (event) {
	    event = (event || window.event);
	    if (event.keyCode == 123) {
	        return false;
	    }
	    if (event.keyCode == 116){
	    	window.onbeforeunload = null;
	    }
	}
		$('.ans_next').on('click',function(){
			window.onbeforeunload = null;
		});
		$('.ans_prev').on('click',function(){
			window.onbeforeunload = null;
		});
		$('#surprise-test').on('submit',function(){
			window.onbeforeunload = null;
		});
	<?php if($submit_status != 1){?>
		// window.onbeforeunload = function() 
		// {
		// 	return "";
		// }
		
	<?php } ?>
	$(".options").click(function(){
		var ischecked= $(this).is(':checked');
		if(ischecked){
		 	var ans_count = $('#ans_count').val();
			var selected_opt=[];
			$.each($("input[name='options[]']:checked"), function(){
                    selected_opt.push($(this).val());
            });
			if(selected_opt.length > ans_count && ans_count==1){
				// alert('Not allowed once');
				var toggle_id = $(this).attr("id");
				$("input[name='options[]']").prop('checked',false);
				$('.progress_li input:checkbox').parent().removeClass('ans_select');
				$("#"+toggle_id).prop('checked',true);
				// return false;
			}
			else if(selected_opt.length > ans_count){
				alert('You can select only '+ans_count+ ' answers');
				$(this).prop("checked",false);
				return false;
			}
		}else{
			$(this).parent().removeClass('ans_select');
		}
			var ques_id = $('#ques_id').val();
			var option_selected=[];
			$.each($("input[name='options[]']:checked"), function(){
                    option_selected.push($(this).val());
            });
			var test_id = $('#test_id').val();
			if($('#surprise').val()=='surprise'){
				var url = base_url + "tests/answer_details/"+$('#surprise').val();
			}else{
				var url = base_url + "tests/answer_details/";
			}
			$.ajax({
		        type: "POST",
		        url: url,
		        data: "ques_id="+ques_id+"&test_id="+test_id+"&option_selected="+option_selected,
		        success: function (result) {
		        	if(result != ''){
		            	 if($('#surprise').val()=='surprise'){
		            		if($("#surprise_test_submit").is(":visible")){
								$(".not_answered").remove();
							}
							 result=$.trim(result);
		            		var obj = jQuery.parseJSON(result);
		            		console.log(option_selected);
		            		$.each(option_selected, function( index, value ) {
							  $('.list_'+value).addClass('ans_select');
							});

		            		
		            		if($("#questions_count").val()==parseInt($("#answered_count").val())+1 && $('#serial_no').val()==$("#questions_count").val()){
								if(!$("#surprise_test_submit").is(":visible")){
									$(".ans_next").after('<span><input type="submit" title="Finish" id="surprise_test_submit"  class="btn btn-submit" value="Finish" name="submit"></span>');
									$(".not_answered").remove();
									$("#submitBtnSta").remove();
									
								}

		            		}	
		            	}
	            	}
	       	 	}	
	 		});
		});

$(window).on('beforeunload', function(){	 
	if($(".total_time").is(":visible")){
	    var second = $(".countdown-amount").text().split(':');
		document.cookie = "seconds="+second[2]+"; path=/";  
	}
});

// countdown start
	var datae=new Date() ;
	var date_sers=current_date.split("-");
	var datae_server=new Date(date_sers[0],date_sers[1] - 1, date_sers[2],date_sers[3],date_sers[4],date_sers[5]) ;
	var dif = datae.getTime() - datae_server.getTime(); 
	var Seconds_from_T1_to_T2 = dif / 1000;
	var Seconds_Between_Dates = Math.abs(Seconds_from_T1_to_T2);
	Seconds_Between_Dates=Seconds_Between_Dates+1;
	var duration;
	var count_down_time = $('#count_down').attr('current_time');
	if(count_down_time){
		var count_down = count_down_time.split(':'); 
		if($(".status").val()==1){
			duration = false;
		}
		else{
			duration = new Date(count_down[0],count_down[1] - 1, count_down[2],count_down[3],count_down[4],count_down[5]-Seconds_Between_Dates); 
		}
	}
	// console.log(count_down_time);//2019:11:28:16:20:07 
	// console.log(duration);
	var temp = new Date(duration);
    var final_time = temp.getFullYear()+'/'+((temp.getMonth())+1)+'/'+temp.getDate()+' '+temp.getHours()+':'+temp.getMinutes()+':'+temp.getSeconds();
	console.log(final_time);
	// return false;
	if(duration){
		$('#count_down').countdown(final_time)
		.on('update.countdown', function(event) {
		  var format = '%H:%M:%S';
		  if(event.offset.totalDays > 0) {
		    format = '%-d day%!d ' + format;
		  }
		  if(event.offset.weeks > 0) {
		    format = '%-w week%!w ' + format;
		  }
		  $(this).html(event.strftime(format));
		})
		.on('finish.countdown', function(event) {
				alert('Time over');
		    	$("#progress-test").trigger('submit');
		        $("#surprise-test").trigger('submit');
		        $("input[type='checkbox']").attr("disabled","disabled");
		        window.onbeforeunload = null;
		});
	}
	// countdown end
</script>
<?php } else{ 
	$this->load->view('std_test_result');			
} ?>



