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
                    	<div class="title"><h3 style="display:inline-block"><?php echo "Manage Standard Test";//echo $this->lang->line('managesurprisedetails');?></h3>
                    		<span class="create_new pull-right"><?php echo anchor(base_url().SITE_ADMIN_URI.'/surprise_test/add?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,' Add New Standard Test',array('class'=>'btn btn-suc pull-right glyphicon glyphicon-plus','title'=>'Add New Standard Test')); ?></span>
                    		
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
							<?php echo form_open(base_url().SITE_ADMIN_URI.'/surprise_test/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_surprise_test"'); ?>
							<div class="form-group">
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
									<?php echo form_input('search_name',$keyword_name,'placeholder= "Search Test Name" class="form-control" id="search_name"'); ?>
								</div>
								<div class="col-sm-2 col-lg-1">
								<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
								echo form_submit($submit_val);?>
								</div>
								<div class="col-sm-2 col-lg-1">
								<a class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/surprise_test/reset'; ?>" title="Reset">Reset</a>
								</div>
							</div>
							<?php echo form_close(); ?>
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
						<?php echo form_open(base_url().SITE_ADMIN_URI.'/surprise_test/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
	                              <table class="datatable table table-striped" cellspacing="0" width="100%">
	                                  <thead>
	                                      <tr>
											  <th><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); ?></th>
	                                      	  <th>S.No</th>
	                                      	  <th>Test Name</th>
	                                          <th>Course Name</th>
	                                          <th>Test Duration</th>
	                                          <th>Date of Exam</th>
	                                          <th>Total Questions</th>
	                                          <th>Status</th>
	                                          <th>Created</th>
											  <th>Publish Status</th>
	                                          <th class="text-center">Action</th>											  
	                                      </tr>
	                                  </thead>
	                                  <tbody>
	                                  <?php if($total_rows > 0 ) {
												foreach ($surprise_test as $key=>$res) 
												{  
													$class="odd"; if($key% 2 ) $class="even"; ?>
													<tr class="<?php echo $class;?>">
													<td><?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$res['id']); ?></td>
													<td><?php echo ($limit_end+$key+1);?></td>	
													<td><?php echo (strlen($res['test_name'])>30?substr($res['test_name'],0,30)."...":$res['test_name']) ;?></td>			
												<td><?php echo (strlen($res['course_name'])>30?substr($res['course_name'],0,30)."...":$res['course_name']) ;?></td>
													<td><?php if($res['duration'] == 1){
																if($res['hours'] > 1){
																	echo $res['hours']." hrs  ".$res['mins']."mins";}
																	else{
																		echo $res['hours']." hr  ".$res['mins']."mins";
																		}
														  	   } else {
															  		echo "Not Available";
														  	  }
														?>
													</td>
													<td><?php 
													if($res['from_date'] == $res['to_date']){
													echo date( ADMIN_DATE_FORMAT, strtotime($res['from_date']));
													}else{
													 echo date( ADMIN_DATE_FORMAT, strtotime($res['from_date']))." - ".date( ADMIN_DATE_FORMAT, strtotime($res['to_date']));
													 }?>
													</td>
													<td><?php echo $res['ques_count'];?></td>
													<td>
														<?php if($res['status'] ==1){?>
															<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_test/update_status/<?php echo $res['id'];?>/<?php echo $res['status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" class="change_status"><span class="icon glyphicon glyphicon glyphicon-ok"></span></a>
														<?php }else{?>
															<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_test/update_status/<?php echo $res['id'];?>/<?php echo $res['status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" class="change_status"><span class="icon glyphicon glyphicon glyphicon-remove"></span></a> 
														<?php }?>
													</td>
													<td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['created']));?></td>
													<td>
													<?php if($res["publish_status"]==1){
														?>
														&nbsp;<a onclick='return confirm("Are you sure to make change..?");' href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_test/publish/<?php echo $res['id']."/".$res['course_id'];?>/<?php echo $res['publish_status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>"><span class="icon glyphicon glyphicon-ok"></span>&nbsp;<span>Published</span></a>
														<?php
													}else{
														?>
														&nbsp;<a onclick='return confirm("Are you sure to make change..?");' href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_test/publish/<?php echo $res['id']."/".$res['course_id'];?>/<?php echo $res['publish_status'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>"><span class="icon glyphicon glyphicon-remove"></span>&nbsp;<span>UnPublished</span></a>
														<?php
													} ?>
													</td>
													<td class="actions text-center">
													<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_questions/add/<?php echo $res['id'].'/'.$res['course_id']; ?>" title = "Add Questions"><span class="icon glyphicon glyphicon-plus"></span>&nbsp;<span class="title">Add Questions / </span></a>
													<?php //if($res['st_count']==0){ ?>
													<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_test/edit/<?php echo $res['id'];?>" title = "Edit"><span class="icon glyphicon glyphicon-pencil"></span>&nbsp;<span class="title">Edit / </span></a>
													<?php //} ?>
													<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_test/delete/<?php echo $res['id'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" title = "Delete" class="delete-con"><span class="icon glyphicon glyphicon-trash"></span>&nbsp;<span class="title">Delete</span></a>
													
													
													</td>
													
													
													</tr>
													<?php
												}
	                                    	 } else {
	                                     		echo '<tr><td colspan="11" style="text-align:center;"> No records found</td></tr>'; 
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
								echo form_dropdown('more_action_id',$this->config->item('bulkactions'),$this->input->post('offer_type'),'id="MoreActionId" class="span2 js-more-action form-control"'); 
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

