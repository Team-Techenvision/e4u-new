<div class="alerts-section-main">
	<div class="wrapper">

		<?php 
			if(count($alerts_list)>0){			
				foreach($alerts_list as $alert){ ?>
					<div class="alert-list">
						<?php if($alert['alert_type']==3){
							$course_name = $alert['course_name'];
							}else{
							$course_name = "";
							}?>
						<h2><a href="#"><?php echo $alert['title']." ".$course_name;?></a></h2>					
						<div class="post-date"><span><i class="date-icon dashboard-sprite"></i><?php echo date('H A', strtotime($alert['created']));?> |</span> Posted Date: <span><?php echo date('M dS, Y', strtotime($alert['created']));?></span></div>
						<p><?php echo $alert['short_description'];?></p>
						</div>
						<a href="#" title="Read More" class="readmore alertreadmore">Read More</a>
					</div>				
		<?php	}
			}else{?>
					<div class="alert-list">
					<h2 style="text-align:center;padding:0px">No alerts found</h2>
					</div>
		<?php
			}
		?>
	</div>
</div>
