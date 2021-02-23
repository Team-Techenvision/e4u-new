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
							<div class="title"><?php echo $this->lang->line('mangesubjects');  ?></div>
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
						<?php echo form_open(base_url().SITE_ADMIN_URI.'/subjects/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_single"'); ?>
							<div class="form-group">
								<div class="col-sm-2">
									<?php echo form_input('search_name',$keyword_name,'placeholder= "Search Name" class="form-control" id="search_name"'); 
									 ?>
								</div>
								<div class="col-sm-2 col-lg-1">
									<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
									echo form_submit($submit_val);?>
								</div>
								<div class="col-sm-2 col-lg-1">
									<a class="btn btn-default full-width-btn" title="Reset" href="<?php echo base_url().SITE_ADMIN_URI.'/subjects/reset'; ?>">Reset</a>
								</div>
							</div>
						<?php echo form_close(); ?>
						<span class="create_new">
						<?php echo anchor(base_url().SITE_ADMIN_URI.'/subjects/add?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'Add New Subject',array('class'=>'btn btn-suc glyphicon glyphicon-plus pull-right','title'=>'Add New Subject')); ?>
						</span>
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<?php echo form_open(base_url().SITE_ADMIN_URI.'/subjects/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
						<table class="datatable table table-striped" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php 
									//echo "<pre>"; print_r($subjects); "<pre>";
									// if($total_rows > 0 ) {
									// 	echo "<pre>"; print_r($subjects); "<pre>";
									// foreach ($subjects as $key=>$res) 
									// { if($res['ch_count']==0 && $res['rs_count']==0){?><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); //break; } } } ?></th>
									<th>S.No</th>				                                      
									<th>Name</th>
									<th>Order</th>
									<th>Status</th>
									<th>Created</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Name</th>
									<th>Order</th>
									<th>status</th>
									<th>created</th>
									<th class="text-center">Action</th>	                                          
								</tr>
							</tfoot>
							<tbody>
								<?php if($total_rows > 0 ) {
								foreach ($subjects as $key=>$res) 
								{   
								$class="odd"; if($key% 2 ) $class="even"; ?>
								<tr class="<?php echo $class;?>">
									<td><?php //if($res['ch_count']==0 && $res['rs_count']==0){?>
										<?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$res['id']); ?><?php //} ?></td>
									<td><?php echo ($limit_end+$key+1);?></td>
									<td><?php echo (strlen($res['name'])>30?substr($res['name'],0,30)."...":$res['name']) ;?></td>
									<td><?php echo $res['sort_order'];?></td>
									<td>
										<?php 
										if($res['status'] ==1){?>
										<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/subjects/update_status/<?php echo $res['id'];?>/<?php echo $res['status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" class="change_status"><span class="icon glyphicon glyphicon glyphicon-ok"></span></a>
										<?php }else{?>
										<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/subjects/update_status/<?php echo $res['id'];?>/<?php echo $res['status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" class="change_status"><span class="icon glyphicon glyphicon glyphicon-remove"></span></a> 
										<?php } ?>
									</td>			                                     							            <td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['created']));?></td>
									<td class="actions text-center"><a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/subjects/edit/<?php echo $res['id'];?>" title = "Edit"><span class="icon glyphicon glyphicon-pencil"></span><span class="title">Edit</span></a>
									<?php if($res['ch_count']==0 && $res['rs_count']==0){?>
									<span>/</span><a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/subjects/delete/<?php echo $res['id'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" title = "Delete" class="delete-con"><span class="icon glyphicon glyphicon-trash"></span><span class="title">Delete</span></a>
									<?php } ?></td>
								</tr>
								<?php
								}
								}else {
								echo '<tr><td colspan="6" style="text-align:center;"> No records found</td></tr>'; 
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
						<div class="multi-actions">
							<?php
							if($this->uri->segment(3)!="deactivate") {
							echo form_dropdown('more_action_id',$this->config->item('bulkactions_course'),$this->input->post('offer_type'),'id="MoreActionId" class="span2 js-more-action form-control"'); 
							}
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

