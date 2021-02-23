 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
        <div class="page-title">
            <!--<span class="title">Sections</span>
            <div class="description">with jquery Datatable for display data with most usage functional. such as search, ajax loading, pagination, etc.</div> -->
        </div>
         <div class="row">
            <div class="col-xs-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title"><?php echo "View Subscription details";//$this->lang->line('vieworderdetails');?></div>
                        </div>
                        <div class="back pull-right">
                        	<?php if($from == "offline")
                        	{
                        		$href=SITE_URL().SITE_ADMIN_URI."/offline_subscription";
                        	}
                        	else
                        	{
                        		$href=SITE_URL().SITE_ADMIN_URI."/orders";
                        	}?>
							<a href="<?php echo $href;?>" title="Back">Back</a>
						</div>
                    </div>
                    <input type="hidden" name="uri_segment" id="uri_segment" value="<?php echo $this->uri->segment(2); ?>"/>
                     <?php if($_POST) { ?> 
                    	<input type="hidden" name="window_post" id="window_post_set" value="1"/>
                    <?php }else{ ?>
                    	<input type="hidden" name="window_post" id="window_post_set" value="0"/>
                    <?php } ?>
                    <div class="card-body">
                    		<!-- Flash Message -->
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
                    		<?php  echo "<h4>".$orders[0]['course_name']." Course</h3>";
                    		$attributes = array('class' => 'form-horizontal','id' => 'view_order_form');                    		
								echo form_open('', $attributes); ?>	
								<?php if($from == "offline"){?>
								 <input type="hidden" name="offline" id="offline" value="1"/>
								 <?php } else { ?>
								 <input type="hidden" name="offline" id="offline" value="0"/>
								 <?php } ?>
								<div class="form-group">
									<?php echo form_label('User Name','',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<p class="form-control" style="border:none"><?php echo $orders[0]['first_name']." ".$orders[0]['last_name']; ?></p>																			
									</div>
								</div>
                        <div class="form-group">
									<?php echo form_label('Course Name','',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<p class="form-control" style="border:none"><?php echo $orders[0]['course_name']; ?></p>																			
									</div>
								</div>
								<div class="form-group">
									<?php echo form_label('Order ID','',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<p class="form-control" style="border:none"><?php echo $orders[0]['order_id']; ?></p>										 									
									</div>
								</div>
								<input type="hidden" name="hidden" value="<? echo $orders[0]['id']?>">
								<!--created time -->
								<div class="form-group">
									<?php echo form_label('Order Date','',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<p class="form-control" style="border:none"><?php echo date( ADMIN_DATE_FORMAT, strtotime($orders[0]['course_start_date']));?></p>
									</div>
								</div>
								<div class="form-group">
									<?php echo form_label('Expiry Date','',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<p class="form-control" style="border:none"><?php echo date( ADMIN_DATE_FORMAT, strtotime($orders[0]['course_expiry_date']));?></p>
									</div>
								</div>
								<div class="form-group"> <!-- modified -->
									<?php echo form_label('Price','',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<p class="form-control" style="border:none"><?php echo (($orders[0]['currency_type']==1)?$currency:$dollar_symbol)." ".$orders[0]['price']; ?></p>	
									</div>
								</div>
								<div class="form-group">
									<?php echo form_label('Payment Type','',array('class'=>'col-sm-2 control-label')); ?> 
									<div class="col-sm-4">
										<?php if($orders[0]['payment_type']==1){ $payment = 'Online Payment';}else{$payment = 'Offline Payment';} ?>
										<p class="form-control" style="border:none"><?php echo $payment; ?></p>
									</div>
								</div>								
								<div class="form-group">
									<?php echo form_label('Order Status','',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<?php if($orders[0]['order_status']==0){$status = "In Progress";}else if($orders[0]['order_status']==1){$status = "Success";}elseif($orders[0]['order_status']==2){$status = "Cancelled";}
												elseif($orders[0]['order_status']==3){$status = "Failed";} elseif($orders[0]['order_status']==4){$status = "Aborted";}
												elseif($orders[0]['order_status']==5){$status = "Pending";}else{echo "Database error";}	?> 									
										<p class="form-control" style="border:none"><?php echo $status; ?></p>
									</div>
								</div>
								<div class="form-group">
									<?php echo form_label('Expiry Status','',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<?php if($orders[0]['is_expired']==1)
										{
											$exp_status = "Active";
										}
										else
										{
											$exp_status = "Expired";
										}	?> 									
										<p class="form-control" style="border:none"><?php echo $exp_status; ?></p>
									</div>
								</div>
								<div class="form-group">
				                	<div class="col-sm-offset-2 col-sm-10">
				                		<?php if($orders[0]['order_status']!=2){ ?>
				                	   <button type="submit" title="Cancel Subscription" class="btn btn-default form-submit cancel-btn" style="margin-right:10px;" id="cancel_order">Cancel Subscription</button><?php } ?>                        	   
										<a title="Back" href="<?php echo $href;?>" class="btn btn-default" > Back</a>	
				                   </div>
                        		</div>				  
							<?php echo form_close();  ?>
                    	</div>
           	 		</div>
            	</div>
        	</div>
      </div>
</div>


