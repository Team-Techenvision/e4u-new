 <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body">
                    <div class="page-title">
                    
                    </div>
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
                                    <div class="title"><?php echo $this->lang->line('extendedsubscription');  ?></div>
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
												<?php echo form_open(base_url().SITE_ADMIN_URI.'/extend_subscription/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_subscription_report"'); ?>
												<div class="form-group">
													<div class="col-sm-3">
										            	<?php echo form_input('search_name',$keyword_name,'placeholder= "Search Name" class="form-control" id="search_name"'); ?>
													</div>
													<div class="col-sm-3">
														<?php $get_course_category[''] = "Select Course Category";
														echo form_dropdown('search_course_category',$get_course_category,$keyword_category,'id="course_category_list" class="form-control"'); ?>
													</div>
													<div class="col-sm-3">
														<?php $get_course[''] = "Select Course";
														echo form_dropdown('search_course',$get_course,$keyword_course,'id="course_list" class="form-control"'); ?>
													</div>										            																										
                          					<div class="col-sm-2  col-lg-1">
                             					<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
                             					echo form_submit($submit_val);?>
                          					</div>
                          					<div class="col-sm-2  col-lg-1">
                          						<a class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/extend_subscription/reset'; ?>" title="Reset">Reset</a>
                          					</div>                          							
												</div>
												<?php echo form_close(); ?>												
												<?php echo form_open(base_url().SITE_ADMIN_URI.'/extend_subscription/apply/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="modify_subscription_report" autocomplete="on" style="padding-top:50px;"'); ?>
												 <div class="row" style="border-top:1px solid #ccc">
												<div id="expand-expiry" class="col-sm-offset-2 col-sm-8" style="margin-top:35px;margin-bottom:35px;">
													<!--label style="float:left;margin-left:14px;"> test </label-->
													
													<?php //echo form_open(base_url().SITE_ADMIN_URI.'/extend_subscription/apply/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="modify_subscription_report"'); ?>
													<div class="form-group">
																	<div  class="col-sm-4">
																	<h4>Expand expiry date:</h4>
																	</div>										
														<div class="col-sm-3">
															<?php
															echo form_dropdown('type',$get_type,'','id="type" class="form-control"'); ?>
														</div>		
														<div class="col-sm-3">
										            	<?php echo form_input('date','','placeholder= "" class="form-control" id="type_date"'); ?>
														</div>								            																										
		                       					<div class="col-sm-2  col-lg-2">
		                          					<?php $submit_val = array('name' => 'apply', 'class' => 'btn btn-default full-width-btn', 'id'=>'apply', 'value' => 'Apply', 'title' => 'Apply');
		                          					echo form_submit($submit_val);?>		                          					
		                       					</div>
		                       					
		                       					<input type="hidden" name="hidden" id="hidden" value="<?php echo count($extend_subscription); ?>"/>
		                       					<!--div class="col-sm-2  col-lg-1">
		                       						<a class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/extend_subscription/reset_type'; ?>" title="Reset">Reset</a>
		                       					</div-->                          							
													</div>
													 <div class="row text-center">
													 	<div class="col-sm-12">		                       
		                       						<small>If you don't select a record, it will apply to all records</small>	
		                       					</div>				
		                       					</div>
													<?php //echo form_close(); ?>
												</div>
												</div>												
                                		<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
				                          		
	<?php //echo form_open(base_url().SITE_ADMIN_URI.'/extend_subscription/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
				                              <table class="datatable table table-striped" cellspacing="0" width="100%">
				                                  <thead>
				                                      <tr>
<th><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); ?></th>
														  <th>S.No</th>
				                                          <th>Course Plan</th>
				                                          <th>User Name</th>				                                          
				                                          <th>Purchased Date</th>
				                                          <th>Expiry Date</th>
				                                          <!--th>Action</th-->
				                                      </tr>
				                                  </thead>
				                                  <tfoot>
				                                      <tr>
				                                      	  <th>Course Plan</th>
				                                      	  <th>User Name</th>
				                                          <th>Purchased Date</th>
				                                          <th>Expiry Date</th>
				                                          <!--th>Action</th-->	                                          
				                                      </tr>
				                                  </tfoot>
				                                  <tbody>
				                                     <?php if(count($extend_subscription) > 0 ) {
				                                     		foreach ($extend_subscription as $key=>$res) 
				                                     		{   
							   $class="odd"; if($key% 2 ) $class="even"; ?>
				                                     				<tr class="<?php echo $class;?>">

<td><?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$res['user_plan_id']); ?></td>
<td><?php echo ($limit_end+$key+1);?></td>				                                     			
<td><?php echo $res['course_name'];?></td>
<td><?php $name= $res['first_name'].'&nbsp;'.$res['last_name']; echo (strlen($name)>30?substr($name,0,30)."...":$name) ;?></td>
<td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['purchased_date']));?></td>
<td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['course_expiry_date']));?></td>				                                     							
<!--td class="actions"><a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/extend_subscription/view/<?php echo $res['id'];?>" title = "View"><span class="icon glyphicon glyphicon-eye-open"></span><span class="title">View</span></a></td-->
</tr>
													<?php
				                                     }
				                                     }else {
				                                     	echo '<tr><td colspan="8" style="text-align:center;"> No records found</td></tr>'; 
				                                     } ?>
				                                  </tbody>
				                              </table>
                                    
				                              <?php 
														if(count($extend_subscription) > 0 ) {  ?>
														 <div class="bottom">
															<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite"><?php echo page_results($total_rows,$per_page,$this->uri->segment(3),$limit_end); ?></div>
															<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
																<?php echo $this->pagination->create_links(); ?>
															</div>
															<div class="clear"></div>
														</div>
				                              <?php } ?>
<div class="multi-actions ">
							</div>
						<?php echo form_close(); ?>
				                         </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
