<div class="ans_desc_popup downloads-popup pay_now_popup">
	<div class="downloadpopup-tabsection">
		<h2><?php echo $category_name;?></h2>
		<h5><?php echo $details['name'];?></h5>
	</div>
	<div class="download-content-main">
		<div class="coursedownload-list clearfix">
			<div class="course-dtal-topcont">
				<?php $year = $details['duration']/12;?>
					<?php if($details['duration'] > 1 && $year<1)
					{
						$duration =  $details['duration']." Months"; ?> 
					<?php }else if($year == 1)
					{
						$duration =  $year." Year";
					} else if($year > 1)
					{
						$months = $details['duration']%12;
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
					}else if($details['duration'] == 1){ 
						$duration = ($details['duration']*30)." Days";
					}else{
						$duration = "";
					} ?>
				<h3><?php echo isset($duration)!=""?$duration:"";?> <?php echo $details['name'];?></h3>
				<?php if($details['course_type']==1){
					$content = "Your free trial begins on ".$content_start_date." and will end on ".$content_expiry_date.".We’ll send an email reminder ".$res_dates["remainder"]." days before the trial ends.";
				}
				else
				{
					$content = "Your ".$details['name']." course begins on ".$content_start_date." and will end on ".$content_expiry_date.".We’ll send an email reminder ".$res_dates["remainder"]." days before the plan expires.";
				}
				?>
				<p><?php echo $content;?></p>
			</div>
			<div class="ajaxupload-download">
				<div class="coursedownload-inner">						
					<ul>
						<li> 
							<label>Plan Start Date</label>
							<p><?php echo $start_date;?></p>	
						</li>
						<li> 
							<label>Plan Expiry Date</label>
							<p><?php echo $expiry_date;?></p>
						</li>
						<li class="price"> 
							<label>Price</label>
							<?php 
							if($details['course_type'] == 1){
								$price = "Free";
								echo "<p>".$price."</p>";
							}else{								
								echo "<br>";
								if($details['price']!=0){		
									$c = 1;
									$price1 = $currency." ".number_format(round($details['price']));																								
									echo form_radio('status', '1','TRUE','id="p1"');
									echo form_label($price1,'p1');
									echo ($details['price_d']!=0)?' (or)</br>':'';
								}
								if($details['price_d']!=0){
									$price2 = $dollar_symbol." ".number_format(round($details['price_d']));
									if($details['price']!=0){
										$v1 = "";										
									}else{
										$v1 = "TRUE";
										$c = 2;
									}
									echo form_radio('status', '2',$v1,'id="p2"');
									echo form_label($price2,'p2');
								}		
							}?>
							
						</li>
					</ul>
				</div>
			</div>
			<div class="paynw-btnbotm">
				<ul>
					<?php if($details['course_type'] == 1){
						$tool_tip = "Start Now";
						$c = 0;
					}else
					{
						$tool_tip = "Pay Now";
					}?>
					<li><a id="pn" href="<?php echo base_url();?>home/payment/<?php echo $details['course_type'];?>/<?php echo $details['id'];?>/<?php echo $details['course_category_id'].'/'.$c;?>" title="<?php echo $tool_tip;?>"><?php echo $tool_tip;?></a></li>
					<li><a href="javascript:void(0);" title="Cancel" id="reset-form">Cancel</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
$( document ).ready(function() {
	$("#reset-form").click(function(){
		$.fancybox.close();
	});
});
</script>
