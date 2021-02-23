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
                                	<div class="title"><?php echo "Manage Subscription Details";//$this->lang->line('manageorderdetails');?></div>
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
										<?php if($this->session->flashdata('flash_failure_message')){ ?>
										 <div class="alert alert-danger alert-dismissible" role="alert">
										 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											 <strong>Warning!</strong> <?php echo $this->session->flashdata('flash_failure_message'); ?>
											 <?php $this->session->unmark_flash('flash_failure_message'); ?>
										</div> 
										<?php } if($this->session->flashdata('flash_success_message')){ ?>
										 <div class="alert alert-success alert-dismissible" role="alert">
										  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											 <strong>Done!</strong> <?php echo $this->session->flashdata('flash_success_message'); ?>
											 <?php $this->session->unmark_flash('flash_success_message'); ?>
										</div> 
										<?php } ?>
										<?php echo form_open(base_url().SITE_ADMIN_URI.'/orders/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
										<div class="form-group">
											<div class="col-sm-2">
												<?php $get_course[''] = "Select Course";
												echo form_dropdown('search_course',$get_course,$keyword_course,'id="course_list" class="form-control"'); ?>
											</div>
											<div class="col-sm-2">
												<?php echo form_input('search_from_date', $keyword_from_date, 'placeholder="Select From Date" id="from_date_list" class="form-control"'); ?>
											</div>
											<div class="col-sm-2">
												<?php echo form_input('search_to_date', $keyword_to_date, 'placeholder="Select To Date" id="to_date_list" class="form-control"'); ?>
											</div>
											<!-- modified -->
											<!-- <div class="col-sm-2">
												<?php //$get_currency[''] = "Select Currency";$get_currency['1'] = "INR";$get_currency['2'] = "USD";
												//echo form_dropdown('search_currency',$get_currency,$keyword_currency,'id="course_currency" class="form-control"'); ?>
											</div>	 -->						
											<div class="col-sm-2  col-lg-1">
												<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
													echo form_submit($submit_val);?>
											</div>
											<div class="col-sm-2  col-lg-1">
												<a title="Reset" class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/orders/reset'; ?>">Reset</a>
											</div>
										</div>
										<?php echo form_close(); ?>
										
                                		<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	<?php echo form_open(base_url().SITE_ADMIN_URI.'/orders/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
				                              <table class="datatable table table-striped" cellspacing="0" width="100%">
				                                  <thead>
				                                      <tr>

<th><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); ?></th>
	                                      	  <th>S.No</th>		
	                                      	  <th>Order ID</th>
	                                          <th>Course Name</th>
	                                          <th>User Name</th>
	                                          <th>Price</th>
	                                          <th>Payment Type</th>
	                                          <th>Order Date</th>
	                                          <th>Order Status</th>
	                                          <th>Expiry Status</th>
	                                          <th class="text-center">Action</th>
	                                      </tr>
	                                  </thead>
	                                  <tbody>
	                                  <?php if($total_rows > 0 ) {
												foreach ($questions as $key=>$res) 
												{  
													$class="odd"; if($key% 2 ) $class="even"; ?>
													<tr class="<?php echo $class;?>">
													<td><?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$res['id']); ?></td>
													<td><?php echo ($limit_end+$key+1);?></td>	
													<td><?php echo $res['order_id']; ?></td>			                                     				
													<td><?php echo (strlen($res['course_name'])>30?substr($res['course_name'],0,30)."...":$res['course_name']) ;?></td>
													<td><?php echo (strlen($res['first_name']." ".$res['last_name'])>30?substr(($res['first_name']." ".$res['last_name']),0,30)."...":$res['first_name']." ".$res['last_name']) ;?> </td>
           <!-- modified --> 				<td><?php echo (($res['currency_type']==1)?$currency:$dollar_symbol)." ".(strlen($res['price'])>30?substr($res['price'],0,30)."...":$res['price']) ;?></td>
                             				<td><?php if($res['payment_type']==1){echo "Online Payment";}else{echo "Offline Payment";} ?></td>																 
                             				<td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['course_start_date']));?></td>
													<td><?php if($res['order_status']==0){echo "In Progress";} else if($res['order_status']==1){echo "Success";}elseif($res['order_status']==2){echo "Cancelled";}
																elseif($res['order_status']==3){echo "Failed";} elseif($res['order_status']==4){echo "Aborted";} elseif($res['order_status']==5){echo "Pending";}
																else{echo "Database error";} ?></td>
													<?php if($res['is_expired']==1)
													 {
													 	$class_exp="label-success";
														$expiry_stat = "Active";
													 }
													 else
													 {
													 	$class_exp="label-danger";
													 	$expiry_stat = "Expired";
													 } ?>
													<td><label class="label <?php echo $class_exp;?>"><?php echo $expiry_stat;?></label></td>											
													<td class="actions text-center"><a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/orders/view/<?php echo $res['id'];?>" title = "View"><span class="icon glyphicon glyphicon-eye-open"></span><span class="title">View</span></a><?php if($res['order_status']!=2){ ?> / <a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/orders/cancel/<?php echo $res['id'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" title = "Cancel Subscription" class="cancel-con"><span class="icon glyphicon glyphicon-remove"></span><span class="title">Cancel </span></a><?php } ?></td>
													</tr>
													<?php	}
	                                    	 } else {
	                                     		echo '<tr><td colspan="10" style="text-align:center;"> No records found</td></tr>'; 
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
				echo form_dropdown('more_action_id',$this->config->item('bulkactions_orders'),$this->input->post('offer_type'),'id="MoreActionId" class="span2 js-more-action form-control"'); 
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
        
