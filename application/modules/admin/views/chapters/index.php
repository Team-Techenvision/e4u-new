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
                                    <div class="card-title col-sm-12">
                                    <div class="title">
										<h3 style="display: inline-block">
											<?php echo $this->lang->line('managechapters');  ?>
										</h3>
										<span class="create_new pull-right"><?php echo anchor(base_url().SITE_ADMIN_URI.'/chapters/add?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,' Add New Chapter',array('class'=>'btn btn-suc glyphicon glyphicon-plus pull-right','title'=>'Add New Chapter')); ?></span>
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
									<?php echo form_open(base_url().SITE_ADMIN_URI.'/chapters/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_double"'); ?>
									<div class="form-group">
										<div class="col-sm-2">
											<?php echo form_input('search_name',$keyword_name,'placeholder= "Search Name" class="form-control" id="search_name"'); 
											 ?>
										</div>
										<div class="col-sm-2">
											<?php $get_course[''] = "Select Course";
											echo form_dropdown('search_course',$get_course,$keyword_course,'id="search_course" class="form-control"'); ?>
										</div>
										<div class="col-sm-2">
											<?php $get_class[''] = "Select Class";
											echo form_dropdown('search_class',$get_class,$keyword_class,'id="search_class" class="form-control"'); ?>
										</div>
										<div class="col-sm-2">
											<?php $get_subject[''] = "Select Subject";
											echo form_dropdown('search_subject',$get_subject,$keyword_subject,'id="search_subject" class="form-control"'); ?>
										</div>
										<div class="col-sm-2 col-lg-1">
											<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
											echo form_submit($submit_val);?>
										</div>
										<div class="col-sm-2 col-lg-1">
											<a title="Reset" class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/chapters/reset'; ?>">Reset</a>
										</div>
									</div>
									<?php echo form_close(); ?>									
                            		<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	<?php echo form_open(base_url().SITE_ADMIN_URI.'/chapters/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
				                              <table class="datatable table table-striped" cellspacing="0" width="100%">
				                                  <thead>
				                                      <tr>
														  <th><?php 
														//   if($total_rows > 0 ) {	foreach ($chapters as $key=>$res){  if($res['c_count']==0 ){
																			echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); //break;	}}}?></th>
			                                      		  <th>S.No</th>
				                                          <th>Name</th>
				                                          <th>Course Name</th>
				                                          <th>Class Name</th>
				                                          <th>Subject Name</th>
				                                          <th>Order</th>
				                                          <th>Status</th>
				                                          <th>Created</th>
				                                          <th class="text-center">Action</th>
				                                      </tr>
				                                  </thead>
				                                  <tbody>
				                                  <?php if($total_rows > 0 ) {
															foreach ($chapters as $key=>$res) 
															{  
																$class="odd"; if($key% 2 ) $class="even"; ?>
																<tr class="<?php echo $class;?>">
																<td><?php 
																// if($res['c_count'] == 0){ 
																	echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$res['id']); 
																	//} ?></td>
																<td><?php echo ($limit_end+$key+1);?></td>
																<td><?php echo (strlen($res['chapter_name'])>30?substr($res['chapter_name'],0,30)."...":$res['chapter_name']) ;?></td>
																<td><?php echo (strlen($res['course_name'])>30?substr($res['course_name'],0,30)."...":$res['course_name']) ;?></td>
																<td><?php echo (strlen($res['class_name'])>30?substr($res['class_name'],0,30)."...":$res['class_name']) ;?></td>
																 <td><?php if($res['subject_name'] != "")
																 { ?>
																 <?php echo (strlen($res['subject_name'])>30?substr($res['subject_name'],0,30)."...":$res['subject_name']) ;?>
																 <?php } else { ?>
																 N/A
																 <?php } ?></td>
																  <td><?php echo $res['order'];?></td>
																<td>
																	<?php if($res['status'] ==1){?>
																		<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/chapters/update_status/<?php echo $res['id'];?>/<?php echo $res['status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" class="change_status"><span class="icon glyphicon glyphicon glyphicon-ok"></span></a>
																	<?php }else{?>
																		<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/chapters/update_status/<?php echo $res['id'];?>/<?php echo $res['status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" class="change_status"><span class="icon glyphicon glyphicon glyphicon-remove"></span></a> 
																	<?php } ?>
																</td>
																<td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['created']));?></td>
																<td class="actions text-center"><a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/chapters/edit/<?php echo $res['id'];?>" title = "Edit"><span class="icon glyphicon glyphicon-pencil"></span><span class="title">Edit</span></a><?php if($res['c_count'] == 0){ ?> / 
																 <a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/chapters/delete/<?php echo $res['id'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" title = "Delete" class="delete-con"><span class="icon glyphicon glyphicon-trash"></span><span class="title">Delete</span></a><?php } ?></td>
																</tr>

																<?php
															}
				                                    	 } else {
				                                     		echo '<tr><td  colspan="9" style="text-align:center;"> No records found</td></tr>'; 
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
                         	 <?php } if($total_rows > 0 ) {	foreach ($chapters as $key=>$res){  if($res['c_count']==0){ ?>
							<div class="multi-actions">
							<?php
							if($this->uri->segment(3)!="deactivate") {
							echo form_dropdown('more_action_id',$this->config->item('bulkactions'),$this->input->post('offer_type'),'id="MoreActionId" class="span2 js-more-action form-control"'); 
							}
							?>
							</div>
							<?php break;}}} echo form_close(); ?>
				                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
