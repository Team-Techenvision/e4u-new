							<table>
								<tbody>
									<?php foreach($questions as $qn){ ?>
										<tr class="row" style="border-bottom: solid 1px #cccccc;">
											<th class="col-sm-2">
												 <label class="checkbox">
									                <input value="<?php echo $qn['id'];?>" type="checkbox" name="selected_qn[]"> select
									            </label>
											</th>
											<td class="col-sm-8">
												<?php if($qn['question_type']==1){
													echo $qn['question'];
												}
												if($qn['question_type']==2){
													?>
													<img width="20%" height="20%" src="<?php echo $this->config->item('questions_url').$qn['question'];?>">
													<a class="fancybox fancybox.ajax"  href="<?php echo base_url().SITE_ADMIN_URI.'/questions/image_view/'.$qn['question'].'/1'?>" title="View Image">View Image</a> 
													<?php
												}
												?>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>