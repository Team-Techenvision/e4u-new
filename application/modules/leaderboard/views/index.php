<!-- <div class="leaderboard-main">
	<div class="wrapper">
		<div class="leader-title">
			<h2>Leader Board</h2>
			<div class="leader-dropdown select-box">
			<?php $option=$all_subject;
			echo form_dropdown("filter-dropdown",$option,$filter_type,"id='filter-dropdown'");?>
			</div>
		</div>
		<div class="leader-table">
			<table>
				<thead>
					<tr>
						<th class="align-center">Rank</th>
						<th>Participants</th>
						<th class="align-center">Questions</th>
						<th class="align-center">Accuracy</th>
						<th class="align-center">Speed (Q/Hr)</th>
						<th class="align-center">Progress Test</th>
						<th class="align-center">Performance Tips</th>
					</tr>
				</thead>
				<tbody>
				<?php $rank = 1;?>
				<?php foreach($participants as $key=>$value) { ?>
				<?php if($value['user_id'] != ""){ ?>
					<tr <?php if(($rank%2)!=0){?>class="odd"<?php } ?>>
						<td class="align-center"><?php echo $rank;?></td>
						<?php if($value['profile_image']!=""){
							
							$img_src = thumb($this->config->item('profile_image_url') .$value['profile_image'] ,'50', '50', 'thumb_profile_img',$maintain_ratio = TRUE);
							$img_prp = base_url() . 'appdata/profile/thumb_profile_img/'.$img_src;
					 	}else{
					 		if($value['gender'] == 2)
							{
								$img_src = 'assets/site/images/no-image.png';
							}
							else
							{
								$img_src = 'assets/site/images/no-image-men.png';
							}
						  	$img_prp=base_url() .$img_src;
					 	} ?>
						<td><div class="participant-name-wrap"><img height="40" src="<?php echo $img_prp;?>" alt="Participant" /><span class="participant-name"><?php echo $value['first_name']." ".$value['last_name'];?></span></div></td>
						<td class="align-center"><?php echo $value['questions'];?></td>
						<td class="align-center"><?php echo $value['accuracy'];?></td>
						<td class="align-center">
						<?php 
						if($value['minutes'] > 60){
							$hours = $value['minutes']/60;
						}else{
							$hours = 1;
						}
						$speed = $value['questions']/$hours;
						echo round($speed);?>
						</td>
						<td class="align-center"><?php echo $value['progress_count'];?></td>
						<?php if($value['tips'] != "") { ?>
						<td class="align-center"><a href="<?php echo base_url();?>leaderboard/tips/<?php echo $value['user_id'];?>" title="Performance Tips" class="perform-tip fancybox fancybox.ajax">Knowledge Study</a></td>
						<?php }else{?>
						<td class="align-center"> ---- </td>
						
						<?php } ?>
					</tr>
				<?php }else{ ?>
				 	
			 	<?php } ?>
				<?php $rank++;
			 	} if(count($participants)==0){
					?>
					<tr class="odd"><td  colspan="7" class="align-center">No Records Found</td></tr>
					<?php
				} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
 -->


			<section class="tabcontent-wrapper" data-aos="fade-down" data-aos-duration="2500">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
						        <div class="top-content">
                                <span> Leaderboard</span>
                                <div class="std-month-drd pull-right">
                                    <div class="dropdown-wrapper">
                                        <div class="dropdown">
                                           <!--  <a class="btn btn-secondary dropdown-toggle dropdown-menu-right" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Standard Test Name
													</a> -->
                                         <!--    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">January</a>
                                                <a class="dropdown-item" href="#">February</a>
                                                <a class="dropdown-item" href="#">March</a>
                                            </div> -->
                                            <?php $option = $standard_tests;
												echo form_dropdown("filter-dropdown",$option,$filter_type,'id="filter-dropdown" class="btn btn-secondary dropdown-toggle dropdown-menu-right standard_test" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
								<div class="leaderboard-table table-responsive">
								     <table class="table">
										<thead class="lbtable-head">
										  <tr>
											<th>Rank</th>											
											<th> Participants </th>
											<th>Questions</th>
											<th>Accuracy</th>
											<th>Speed(Q/HR)</th>
											<th>Progress</th>
										  </tr>
										</thead>
										<tbody class="content_leaderboard">
											<?php $this->load->view('content_leaderboard');?>
										</tbody>
									  </table>
								</div>					   			   
						   </div>
					   </div>
				    </div>
		  </section>
       <script type="text/javascript">
       	$('.standard_test').change(function(){
       		$('.content_leaderboard').html('');
       		var url = base_url + "leaderboard/get_participants/";
       		var std_test_id = $(this).val();
       		$.ajax({
	            type: "POST",
	            url: url,
	            data: "std_test_id=" + std_test_id,
	            success: function (result) { 
	                if(result != ''){
	                	$('.content_leaderboard').html($.trim(result));	
	                }
	            }
	        });
       	});
       
	     	
       </script>
	  