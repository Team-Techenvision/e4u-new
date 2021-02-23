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
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('manageenquiries');  ?></div>
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
						<?php echo form_open(base_url().SITE_ADMIN_URI.'/enquiries/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_single"'); ?>
								<div class="form-group">
									<div class="col-sm-2">
										<?php echo form_input('search_name',$keyword_name,'placeholder= "Search Name" class="form-control" id="search_name"'); ?>
									</div>
		        					<div class="col-sm-2 col-lg-1">
		        					<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
		        					echo form_submit($submit_val);?>
		        					</div>
		        					<div class="col-sm-2 col-lg-1">
		        					<a class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/enquiries/reset'; ?>" title="Reset">Reset</a>
		        					</div>
								</div>
							<?php echo form_close(); ?>
							<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
								<?php echo form_open(base_url().SITE_ADMIN_URI.'/enquiries/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
								<table class="datatable table table-striped" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S.No</th>		                                      
											<th>Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th>Created</th>
											<th>Status</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th>Created</th>
											<th>Status</th>
											<th>Action</th>	                                          
										</tr>
									</tfoot>
									<tbody>
										<?php if($total_rows > 0 ) 
										{
											foreach ($enquiries as $key=>$res) 
											{   
												$class="odd"; if($key% 2 ) $class="even"; ?>
												<tr class="<?php echo $class;?>">
													<td><?php echo ($limit_end+$key+1);?></td>
													<td><?php $name= $res['first_name'].'&nbsp;'.$res['last_name'];
													echo (strlen($name)>30?substr($name,0,30)."...":$name) ;?></td>
													<td><?php echo (strlen($res['email'])>30?substr($res['email'],0,30)."...":$res['email']) ;?></td>
													<td><?php echo (strlen($res['phone'])>30?substr($res['email'],0,30)."...":$res['phone']) ;?></td> 	 
												 
													<td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['created']));?></td>
													<td>
													<?php if($res["status"]==0){
														?>
														<label class="label label-info">New</label>
														<?php
													}else{
														?> 
														<label class="label label-success">Read</label>
														 
														<?php
													}?>
													</td>
													<td class="actions text-center">
														<span class="icon glyphicon glyphicon-eye-open"></span><a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/enquiries/view/<?php echo $res['id'];?>" title = "View">
														<span class="title">View / </span>
														</a>
														<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/enquiries/delete/<?php echo $res['id'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" title = "Delete" class="delete-con"><span class="icon glyphicon glyphicon-trash"></span>&nbsp;<span class="title">Delete</span></a></td>
												</tr>
												<?php
											}
										} else {
										echo '<tr><td colspan="7" style="text-align:center;"> No records found</td></tr>'; 
										} ?>
									</tbody>
								</table>
								<?php 
								if($total_rows > 0 ) {  ?>
									<div class="bottom">
									<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite"><?php echo page_results($total_rows,$per_page,$this->uri->segment(3),$limit_end); ?></div>
									<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
									<?php echo $this->pagination->create_links(); ?>
									</div>
									<div class="clear"></div>
									</div>
								<?php } ?>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
        
