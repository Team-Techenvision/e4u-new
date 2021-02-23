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
                                    <div class="title"><?php echo $this->lang->line('manageuserreports');  ?></div>
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
												<?php echo form_open(base_url().SITE_ADMIN_URI.'/user_reports/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_user_report"'); ?>
												<div class="form-group">
													<div class="col-sm-2">
										            	<?php echo form_input('search_name',$keyword_name,'placeholder= "Search Name" class="form-control" id="search_name"'); ?>
													</div>
													<div class="col-sm-2">
														<?php echo form_input('search_from_date',$keyword_from_date,'placeholder= "Search by From Date" class="form-control" id="search_from_date"'); ?>
													</div>
													<div class="col-sm-2">
														<?php echo form_input('search_to_date',$keyword_to_date,'placeholder= "Search by To Date" class="form-control" id="search_to_date"'); ?>
													</div>									         
																									
													<div class="col-sm-2">
														<?php $get_course[''] = "Select Course";
														echo form_dropdown('search_course',$get_course,$keyword_course,'id="search_course" class="form-control"'); ?>
													</div>
													
													<div class="col-sm-2">
														<?php $get_class[''] = "Select Class";
														echo form_dropdown('search_class',$get_class,$keyword_class,'id="search_class" class="form-control"'); ?>
													</div>
													
										        	<div class="col-sm-2" style="margin-top:10px;">
										            	<?php 
														$status_arr[''] = "Select Status";
														$status_arr['1'] = "Active";
														$status_arr['2'] = "Inactive";
														echo form_dropdown('user_status',$status_arr,$status,'id="user_status" class="form-control"'); ?>
													</div>										        	
													<div class="col-sm-12 " style="margin-top:10px">
														<div class="col-sm-2  col-lg-1 pull-right">
				                       				<a class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/user_reports/export'; ?>" title="Export">Export</a>
				                       			</div>
				                       			<div class="col-sm-2  col-lg-1 pull-right">
				                       				<a class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/user_reports/reset'; ?>" title="Reset">Reset</a>
				                       			</div>                           							
														<div class="col-sm-2  col-lg-1 pull-right">
				                       				<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
				                       				echo form_submit($submit_val);?>
				                       			</div>
                                			</div>
												</div>
												<?php echo form_close(); ?>
                                		<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
				                          		
	<?php echo form_open(base_url().SITE_ADMIN_URI.'/user_reports/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
				                              <table class="datatable table table-striped" cellspacing="0" width="100%">
				                                  <thead>
				                                      <tr>
<!--th><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); ?></th-->
				                                      		<th>S.No</th>				                                      
				                                          <th>Name</th>
				                                          <th>Course Plan</th>
				                                        
				                                          <th>Created</th>
				                                          <th>Status</th>
				                                          <th>Action</th>
				                                      </tr>
				                                  </thead>
				                                  <tfoot>
				                                      <tr>
				                                      	  <th>Name</th>
				                                      	  <th>Course Plan</th>
				                                      	  
				                                          <th>Created</th>
				                                          <th>Status</th>
				                                          <th>Action</th>	                                          
				                                      </tr>
				                                  </tfoot>
				                                  <tbody>
				                                     <?php if($total_rows > 0 ) {
				                                     		foreach ($user_reports as $key=>$res) 
				                                     		{   
						 

							   $class="odd"; if($key% 2 ) $class="even"; ?>
				                                     				<tr class="<?php echo $class;?>">

			<!--td><?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$res['id']); ?></td-->
			<td><?php echo ($limit_end+$key+1);?></td>				                                     			
			 
			<td><?php $name= $res['first_name'].'&nbsp;'.$res['last_name']; echo (strlen($name)>30?substr($name,0,30)."...":$name) ;?></td>
			<td><?php echo isset($imp_course[$res['id']])?$imp_course[$res['id']]:'N/A';?></td>
	
			<td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['created']));?></td>
			<td><?php
echo ($res["status"]==1?"Active":"Inactive");
			?></td>
				                                     							
<td class="actions"><a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/user_reports/view/<?php echo $res['id'];?>" title = "View"><span class="icon glyphicon glyphicon-eye-open"></span><span class="title">View</span></a></td>
</tr>
													<?php
				                       				 }
				                                     }else {
				                                     	echo '<tr><td colspan="9" style="text-align:center;"> No records found</td></tr>'; 
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
        
