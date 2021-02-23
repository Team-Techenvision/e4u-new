<!-- Main Content -->
<div class="container-fluid">
	<div class="side-body">
		<div class="page-title"></div>
		<div class="row">
			<div class="col-xs-12">
				<div class="card">
					<div class="card-header">
						<?php 
						$pagestatus = $this->uri->segment(3) ? $this->uri->segment(3) : 'index';
						$pagingstatus = $this->uri->segment(4) ? $this->uri->segment(4) : '1';
						$fieldssort = $this->uri->segment(5) ? $this->uri->segment(5) : 'id';
						$ordersort = $this->uri->segment(6) ? $this->uri->segment(6) : 'desc';
						?>
						<div class="card-title col-sm-12">
							<div class="title"><h3 style="display:inline-block">Manage Materials</h3>
							<span class="create_new pull-right"><?php echo anchor(base_url().SITE_ADMIN_URI.'/downloads/add?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,' Add New Material',array('class'=>'btn btn-suc glyphicon glyphicon-plus pull-right','title'=>'Add New Material')); ?></span>
						
							</div>
						</div>
					</div>
					<div class="card-body">
						<!-- Flash Message -->
						<?php
						if($this->session->flashdata('flash_message')){ ?>
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<?php echo $this->session->flashdata('flash_message'); ?>
							<?php $this->session->unmark_flash('flash_failure_message'); ?>
						</div> 
						<?php } ?>
						<?php echo form_open(base_url().SITE_ADMIN_URI.'/downloads/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_download"'); ?>
							<div class="form-group">
						        <div class="col-sm-2">
									<?php echo form_input('search_date',$keyword_date,'placeholder= "Search by Date" class="form-control" id="search_date"'); ?>
								</div>
								<!-- <div class="col-sm-2">
									<?php 
									// $options = array(
									// 			'' => 'Uploaded By',
                  					// 			'0'  => 'Admin',
                  					// 			'1'    => 'User'
									// 			);
												?>
									<?php //echo form_dropdown('search_uploaded',$options,$keyword_uploaded,'id="search_uploaded" class="form-control"'); ?>
								</div> -->
		    					<div class="col-sm-2 col-lg-1">
		        					<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
		        					echo form_submit($submit_val);?>
		    					</div>
		    					<div class="col-sm-2 col-lg-1">
		    						<a class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/downloads/reset'; ?>" title="Reset">Reset</a>
		    					</div>
							</div>
						<?php echo form_close(); ?>
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
							<?php echo form_open(base_url().SITE_ADMIN_URI.'/downloads/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
							<table class="datatable table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); ?></th>
										<th>S.No</th>
										<th>Material Name</th>
										<th>Course</th>
										<th>Class</th>
										<th>Subject</th>
										<th>Status</th>
										<th>Uploaded Date</th>
										<th>Uploaded By</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if($total_rows > 0 ) {
									foreach ($downloads as $key=>$res) 
									{  
									$class="odd"; if($key% 2 ) $class="even"; ?>
									<tr class="<?php echo $class;?>">
										<td><?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$res['id']); ?></td>
										<td><?php echo ($limit_end+$key+1);?></td>				                                     				
										<td><?php echo (strlen($res['download_name'])>30?substr($res['download_name'],0,30)."...":$res['download_name']) ;?></td>
										<td><?php echo (strlen($res['course_name'])>30?substr($res['course_name'],0,30)."...":($res['course_name']=="")?"N/A":$res['course_name']) ;?></td>
										<td><?php echo (strlen($res['class_name'])>30?substr($res['class_name'],0,30)."...":$res['class_name']) ;?></td>
										<td><?php echo (strlen($res['subject_name'])>30?substr($res['subject_name'],0,30)."...":$res['subject_name']) ;?></td>
										 
										<td>
										<?php if($res['status'] ==1){?>
										<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads/update_status/<?php echo $res['id'];?>/<?php echo $res['status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" class="change_status"><span class="icon glyphicon glyphicon glyphicon-ok icon_align"></span></a><p class="p_align">Active/Approved</p>
										<?php }else{?>
										<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads/update_status/<?php echo $res['id'];?>/<?php echo $res['status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" class="change_status"><span class="icon glyphicon glyphicon glyphicon-remove icon_align icon_align"></span></a><p class="p_align">Inactive/Not Approved</p>
										<?php }?>
										</td>
										
										<td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['created']));?></td>
										<td><?php if($res['uploaded_by'] == 0){
												echo "Admin";
												}else{
												echo "User(<a href='".SITE_URL().SITE_ADMIN_URI."/user_reports/view/".$res['user_id']."' target='_blank'><u>".$res['username']."</u></a>)";
												}
											?>
										</td>
										<td class="actions text-center">
											<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads/edit/<?php echo $res['id'];?>" title = "Edit"><span class="icon glyphicon glyphicon-pencil"></span>&nbsp;<span class="title">Edit</span></a> / 
										 
											<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads/view/<?php echo $res['id'];?>/<?php echo $res['uploaded_by'];?>" title = "View">											
											<span class="title">View</span></a> / 
											<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads/delete/<?php echo $res['id'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" title = "Delete" class="delete-con"><span class="icon glyphicon glyphicon-trash"></span>&nbsp;<span class="title">Delete</span></a>
										</td>
									</tr>
									<?php
									}
									} else {
									echo '<tr><td colspan="10" style="text-align:center;"> No records found</td></tr>'; 
									} ?>
								</tbody>
							</table>
							<?php 
							if($total_rows > 0 ) {  ?>
							<div class="bottom">
								<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
									<?php echo page_results($total_rows,$per_page,$this->uri->segment(3),$limit_end); ?>
								</div>
								<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
									<?php echo $this->pagination->create_links(); ?>
								</div>
								<div class="clear"></div>
							</div>
							<?php } ?>
							<div class="multi-actions">
								<?php
								/* if($this->uri->segment(3)!="deactivate") {
								echo form_dropdown('more_action_id',$this->config->item('bulkactions'),$this->input->post('offer_type'),'id="MoreActionId" class="span2 js-more-action form-control"'); 
								} */
								?>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

