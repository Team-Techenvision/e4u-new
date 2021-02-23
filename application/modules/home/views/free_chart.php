<div class="inner_banner paymentchart-banner home-title-sec" style="background-image:url(<?php echo base_url();?>assets/site/images/practice-banner.jpg)">
	<div class="home-title-bg">Choose</div>
	<h2>CHOOSE YOUR EXPEDITION</h2>
	<p>We have a great collection of MCQ’s for effective study.<br /> Here you can find and choose your expedition easier!</p>
</div>
<div class="inner_content paymentchart-container">	
	<?php echo form_open('', 'id="f_payment_chart"');?>	
	<div class="wrapper">
		<ul>
			<?php $i=1; ?>
			<?php foreach($courses as $course) { ?>
			<li class="course<?php echo $i;?> course-list-page dyn-course<?php echo $course['id'];?> <?php echo($course['id'] == $course_id && !in_array($course['id'],$check_purchased)?'selected':''); ?>">
				<img src="<?php echo base_url();?>assets/site/images/course-img<?php echo $i;?>.png" title="<?php echo $course['name'];?>" alt="<?php echo $course['name'];?>" />
				<h3><?php echo $course['name']; ?></h3>
				<div class="paymentcourse-description">
					<div class="description-inner">
						<p><?php echo $course['description'];?></p>
					</div>
				</div>
				<div class="payment-amount">
					<span class="course-amount"><?php echo ($course['price']!=0?$currency.number_format($course['price'],2):""); ?></span>
				<span class="course-duration">
					<?php if($course['duration'] > 1)
					{
						echo $course['duration']; ?> Months
					<?php } else if($course['duration']){ 
						echo $course['duration']; ?> Month
					<?php } ?>
				</span>	
				</div>
				<div class="payment-choose">
					<?php
					if($course['id'] == $course_id){
					$check_arr=TRUE;
					}else{
					$check_arr=FALSE;
					}
				 	echo form_radio('choose',$course['id'],in_array($course['id'],$check_purchased)?'':$check_arr,'id="plan'.$i.'" class="plan-buttons"' .(in_array($course['id'],$check_purchased)?"disabled":""));?>
				 	<?php if(in_array($course['id'],$check_purchased)){ ?>
				 		<label class="label_course label choose_label<?php echo $course['id'];?>" for="plan<?php echo $i; ?>">Purchased</label>
				 	<?php }else{ ?>
						<label class="label_course choose_label<?php echo $course['id'];?>" for="plan<?php echo $i; ?>"><?php echo($course['id'] == $course_id?'Selected Course':'Choose Course'); ?></label>
					<?php } ?>
				</div>
			</li>
			<?php $i++; ?>
			<?php } ?>
		</ul>
		<div class="paynow-button">
			<?php echo form_submit('submit','CONTINUE','id="payment_submit"');?>
		</div>
	</div>
	<?php echo form_close();?>	
</div>
<script>
	$(function(){
		$('#f_payment_chart').on('submit', function(e){
			if($('input[name="choose"]:checked').val()){
				return true;	
			}else{
				$('.success-error-msg').html("<p>Please select a course.</p><span class='close-btn'></span>");
				$('.success-error-msg').addClass('open');
				$('.success-error-msg').addClass('erroronly');
				return false;
			} 
		});
		
		
	});
</script>

	
