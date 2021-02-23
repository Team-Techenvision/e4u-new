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
                                    <div class="title"><?php echo $this->lang->line('certificates');  ?></div>
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
												<?php echo form_open(base_url().SITE_ADMIN_URI.'/certificates/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_issued_certificates"'); ?>
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
														<?php 
															$test_type = array(""=>"Select Type", "1"=>"Progress", "2"=>"Surprise");
														echo form_dropdown('test_type',$test_type,$keyword_test_type,'id="test_type" class="form-control"'); ?>
													</div>
													<div class="col-sm-2">
														<?php 
														echo form_dropdown('search_course',$get_course,$keyword_course,'id="search_course" class="form-control"'); ?>
													</div>
													
													<?php if($keyword_test_type!=2){ 
																$class = "";
															}else{
																$class = "element-hide";
															} ?>
													<div class="col-sm-2">
														<?php $get_class[''] = "Select Class";
														$attributes = array("id"=>"search_class", "class"=>"form-control ".$class);																
														echo form_dropdown('search_class',$get_class,$keyword_class,$attributes); ?>
													</div>													
													<div class="col-sm-2" style="margin-top:10px;">
														<?php $get_subject[''] = "Select Subject";
														$attributes = array("id"=>"search_subject", "class"=>"form-control ".$class);
														echo form_dropdown('search_subject',$get_subject,$keyword_subject,$attributes); ?>
													</div>
													<div class="col-sm-2" style="margin-top:10px;">
														<?php $get_chapter[''] = "Select Chapter";
														$attributes = array("id"=>"search_chapter", "class"=>"form-control ".$class);
														echo form_dropdown('search_chapter',$get_chapter,$keyword_chapter,$attributes); ?>
													</div>													
																			
													<div class="col-sm-12 " style="margin-top:10px">				
														<div class="col-sm-2  col-lg-1 pull-right">
		                             				<a class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/certificates/export'; ?>" title="Export">Export</a>
		                             			</div>
		                             			<div class="col-sm-2  col-lg-1 pull-right">
		                             				<a class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/certificates/reset'; ?>" title="Reset">Reset</a>
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
				                                      	  <th>S.No</th>                              
				                                          <th>Certificate Type</th>
				                                          <th>User Name</th>
														  <th>Issued Date</th>
				                                          <th>Course Plan</th> 
				                                          <th>Subject</th>
				                                          <th>Chapter</th>
				                                          <th>Level</th>
				                                          <th>Action</th>
				                                      </tr>
				                                  </thead>
				                                  <tfoot>
				                                      <tr>
														  <th>Certificate Type</th>
				                                          <th>User Name</th>
														  <th>Issued Date</th>
				                                          <th>Course Plan</th> 
				                                          <th>Subject</th>
				                                          <th>Chapter</th>
				                                          <th>Level</th>
				                                          <th>Action</th>      
				                                      </tr>
				                                  </tfoot>
				                                  <tbody>
				                                     <?php if($total_rows > 0 ) { 
														 $i=$limit_end+1;
				                                     		foreach ($user_reports as $key=>$res) 
				                                     		{ 
															?>
															<tr>
															<td><?php echo $i++; ?></td>
															<td><?php echo  ($res["test_type"]==1?"Progress":"Surprise"); ?>
															</td>
															<td>
															<?php echo $res["first_name"]." ".$res["last_name"]; ?>
															</td>
															<td>
															<?php echo date("d-m-Y",strtotime($res["issued_date"])); ?>
															</td>
															<td>
															<?php echo ($res["course_name"]!=""?$res["course_name"]:"N/A") ; ?>
															</td>
															<td>
															<?php echo ($res["subject_name"]!=""?$res["subject_name"]:"N/A") ; ?>
															</td>
															<td>
															<?php echo ($res["chapter_name"]!=""?$res["chapter_name"]:"N/A") ; ?>
															</td>	
															<td>
															<?php echo ($res["level_name"]!=""?$res["level_name"]:"N/A") ; ?>
															</td>
															<td>
															<a title="Download Certificate" target="_blank"class="" href="<?php echo base_url()."admin/certificates/generate_certificate/".$res["test_id"]; ?>"><i class="glyphicon glyphicon-download-alt"></i> Download Certificate</a>
															</td>
															</tr>
															<?php
															}
				                                     }else {
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
											<div class="multi-actions "></div>
										<?php echo form_close(); ?>
				                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
