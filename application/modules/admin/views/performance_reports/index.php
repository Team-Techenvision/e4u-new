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
                                    <div class="title"><?php echo $this->lang->line('manageperformancereports');  ?></div>
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
												<?php echo form_open(base_url().SITE_ADMIN_URI.'/performance_reports/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_double"'); ?>
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
														echo form_dropdown('search_course',$get_course,$keyword_course,'id="course_list" class="form-control"'); ?>
													</div>
												<!-- 	<div class="col-sm-2">
														<?php $get_class[''] = "Select Class";
														echo form_dropdown('search_class',$get_class,$keyword_class,'id="class_list" class="form-control"'); ?>
													</div>
													<div class="col-sm-2">
														<?php $get_subject[''] = "Select Subject";
														echo form_dropdown('search_subject',$get_subject,$keyword_subject,'id="subject_list" class="form-control"'); ?>
													</div>	 -->	
													<div class="col-sm-12 " style="margin-top:10px">
														<div class="col-sm-2  col-lg-1 pull-right">
														<a style="margin-top:10px;" class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/performance_reports/export'; ?>" title="Export">Export</a>
														</div>
														<div class="col-sm-2  col-lg-1 pull-right">
														<a style="margin-top:10px;" class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/performance_reports/reset'; ?>" title="Reset">Reset</a>
														</div>
														<div class="col-sm-2  col-lg-1 pull-right">
														<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'style'=>'margin-top:10px', 'value' => 'Search', 'title' => 'Search');
														echo form_submit($submit_val);?>
														</div>
													</div>
												</div>
												<?php echo form_close(); ?>
                                		<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
				                          		
	<?php echo form_open(base_url().SITE_ADMIN_URI.'/performance_reports/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
				                              <table class="datatable table table-striped" cellspacing="0" width="100%">
				                                  <thead>
				                                      <tr>
<!--th><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); ?></th-->
				                                      		<th>S.No</th>				                                      
				                                          <th>User Name</th>
				                                          <th>Standard Test</th>

				                                          <th>Questions</th>
				                                          <th>Accuracy</th>
				                                          <th>Speed</th>
				                                          <th>Progress</th>
				                                          <!--th>Action</th-->
				                                      </tr>
				                                  </thead>
				                                  <tfoot>
				                                      <tr>
				                                      	  <th>User Name</th>
				                                          <th>Standard Test</th>

				                                      	  <th>Questions</th>
				                                      	  <th>Accuracy</th>
				                                          <th>Speed</th>
				                                          <th>Progress</th>
				                                          <th>Action</th>	                                          
				                                      </tr>
				                                  </tfoot>
				                                  <tbody>
				                                     <?php if($total_rows > 0 ) {
				                                     		$i=0;
				                                     		foreach ($performance_reports as $key=>$res) 
				                                     		{   
						 

							   $class="odd"; if($key% 2 ) $class="even"; ?>
				                                     				<tr class="<?php echo $class;?>">

<!--td><?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$res['id']); ?></td-->
<td><?php echo ($limit_end+$key+1);?></td>				                                     			
 
<td><?php $name= $res['first_name'].'&nbsp;'.$res['last_name']; echo (strlen($name)>30?substr($name,0,30)."...":$name) ;?></td>
<td><?php echo $res['test_name'];?></td>
<td><?php echo isset($res['questions'])?$res['questions']:'0';?></td>
<td><?php echo isset($res['accuracy'])?$res['accuracy']:'0';?></td>
<td><?php if($res['minutes'] > 60){
			$hours = $res['minutes']/60;
		  }else{
			$hours = 1;
		  }
		  $speed = $res['questions']/$hours;
echo round($speed);?></td>
<td><?php echo isset($res['progress_count'])?$res['progress_count']:'0';?></td>
				                                     							
<!--td class="actions"><a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/performance_reports/view/<?php echo $res['id'];?>" title = "View"><span class="icon glyphicon glyphicon-eye-open"></span><span class="title">View</span></a></td-->
</tr>

								<?php
				                                     		$i++; }
				                                     }else {
				                                     	echo '<tr><td colspan="8" style="text-align:center;"> No records found</td></tr>'; 
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
        
