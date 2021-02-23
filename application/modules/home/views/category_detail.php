<script>
	$(document).ready(function(){	
		$('.course-detail-list ul li:nth-child(4n-3)').addClass('first');
	});
</script>
<div class="inner_banner paymentchart-banner home-title-sec" style="background-image:url(<?php echo base_url();?>assets/site/images/practice-banner.jpg)">
	<div class="home-title-bg">Choose</div>
	<h2>CHOOSE YOUR PLAN FROM <?php echo strtoupper($category_name);?></h2>
	<p>We have collection of courses for effective study.<br /> Here you can find and choose your expedition easier!</p>
</div>
<div class="inner_content paymentchart-container course-detail-list">		
	<?php echo form_open('', 'id="payment_chart"');?>	
	<div class="wrapper">
		<div class="course-detail-scroll scroll-pane">
			<?php if(!empty($courses)){ ?>
			<ul>			
				<?php $i=1; 
				 foreach($courses as $course) { ?>
				 <?php if($i%12 == 1)
					{
						$i = 1;
					}
				 ?>
				<li class="course<?php echo $i;?> course-list-page dyn-course<?php echo $course['id'];?> <?php echo($course['id'] == $course_id && !in_array($course['id'],$check_purchased)?'selected':''); ?>">
					<h3><?php echo strlen($course['name'])>30?substr($course['name'],0,30)."...":$course['name']; ?></h3>
					<?php $year = $course['duration']/12;?>
							<?php if($course['duration'] > 1 && $year<1)
							{
								$duration =  $course['duration']." Months"; ?> 
							<?php }else if($year == 1)
							{
								$duration = $year." Year";
							} else if($year > 1)
							{
								$months = $course['duration']%12;
								if($months != 0 && $months != 1)
								{
									$month = $months.' months';
								}
								else if($months == 1)
								{
									$month = $months.' month';
								}
								else
								{
									$month = "";
								}
								if($month != "" && floor($year)==1)
								{
									$duration = floor($year).' yr '.$month;
								}
								else if($month != "" && floor($year)>1)
								{
									$duration = floor($year).' yrs '.$month;
								}else
								{
									$duration = floor($year).' Years';
								}
							}else if($course['duration'] == 1){ 
								$duration = ($course['duration']*30)." Days";
						 	}else
						 	{ 
							 	$duration = "";
						 	}?>
						 	
						 	<?php if($course['course_type'] == 1){
								$price = "Free";
							}else{
								$price = "";
								if($course['price']!=0){
									$price = $currency." ".number_format(round($course['price']));
								}
								if($course['price_d']!=0){
									if($price!=""){
										$price = $price." / ".$dollar_symbol." ".number_format(round($course['price_d']));
									}else{
										$price = $dollar_symbol." ".number_format(round($course['price_d']));
									}														
								}
							}?>
					<h4><span><?php echo $price; ?></span></h4>
					<h5 class="per-duration"><?php if($price!="Free"): ?>(Subscription for <?php if($duration != ""){?><?php echo $duration;?><?php } ?>)<?php endif; ?></h5>
					<div class="paymentcourse-description">
						<div class="description-inner">
							<p><?php echo $course['description'];?></p>
						</div>
					</div>
					<?php if(isset($is_expired[$course['id']]))
						{
							$expired_val = $is_expired[$course['id']];
						}
						?>
					<div class="payment-choose pay-nw-btn">
						<?php if(in_array($course['id'],$check_purchased) && $expired_val==1){
							$title ="Purchased";
						}
						else if($course['course_type'] == 1){
							$title = "Start Now";
						}else
						{
							$title = "Pay Now12";
						}?>
						
						<?php if(in_array($course['id'],$check_purchased) && $expired_val==1)
					 	{
					 		$class = "pay-nw";
					 		$href = "javascript:void(0)";
					 	}else{
					 		$class = "download pay-nw fancybox fancybox.ajax";
					 		$href = base_url()."home/course_detail_popup/".$course['course_category_id']."/".$course['id']."/".$course['course_type'];
					 	}?>
						
						<a title="<?php echo $title;?>" class="<?php echo $class;?>" style="cursor: default;" href="<?php echo $href;?>">
						<?php if(in_array($course['id'],$check_purchased) && $expired_val==1){ ?>
							<label style="cursor:default;" class="label_course label choose_label<?php echo $course['id'];?>" for="plan<?php echo $i; ?>">Purchased</label>
						<?php }else{ ?>
							<label class="label_course choose_label<?php echo $course['id'];?>" for="plan<?php echo $i; ?>"><?php echo($course['course_type'] == 1?'Start Now':'Pay Now1'); ?></label>
						<?php } ?>
						</a>
					</div>
				</li>
				<?php $i++; ?>
				<?php } ?>
			</ul>
			<?php } else {?>
				<h1 style="border: 1px solid #ccc;font-size: 23px;padding-bottom: 20px;padding-top: 20px;text-align: center;">No Records Found</h1>
			<?php } ?>
		</div>
	</div>
	<?php echo form_close();?>	
</div>

	
