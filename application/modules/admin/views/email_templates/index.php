 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
        <div class="page-title">
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">

                        <div class="card-title">
                        <div class="title"><?php echo $this->lang->line('managemailtemplate');?></div>
                        </div>
                    </div>
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
								<?php echo form_open(base_url().SITE_ADMIN_URI.'/email_templates','class="search_single"'); ?>
								<div class="form-group">
									<div class="col-sm-2">
										<?php echo form_input('search_name',$keyword_name,'placeholder= "Search Name" class="form-control" id="search_name"'); ?>
									</div>
		        					<div class="col-sm-2  col-lg-1">
		        					<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
		        					echo form_submit($submit_val);?>
		        					</div>
		        					<div class="col-sm-2  col-lg-1">
		        					<a class="btn btn-default full-width-btn" title='Reset' href="<?php echo base_url().SITE_ADMIN_URI.'/email_templates/reset'; ?>">Reset</a>
		        					</div>
								</div>
							<?php echo form_close(); ?>
                    		<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                              <table class="datatable table table-striped" cellspacing="0" width="100%">
                                  <thead>
                                      <tr>
                                      	  <th>S.No</th>				                                      
                                          <th>Name</th>
                                          <th>Subject</th>
                                          <th>Description</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tfoot>
                                      <tr>
                                      	  <th>S.No</th>				                                      
                                          <th>Name</th>
                                          <th>Subject</th>
                                          <th>Description</th>
                                          <th>Action</th>
                                      </tr>
                                  </tfoot>
                                  <tbody>
                                     <?php if($total_rows > 0 ) {
                                     		foreach ($email_templates as $key=>$res) 
                                     		{      $class="odd"; if($key% 2 ) $class="even"; 
                                     				echo '<tr class="'.$class.'">
															    <td>'.($limit_end+$key+1).'</td>
                                     							<td>'.$res['name'].'</td>
                                     							<td>'.($res['subject']?:'-').'</td>
                                     							<td>'.($res['description']?:'-').'</td>
                                     							<td><a href="'.SITE_URL().SITE_ADMIN_URI.'/email_templates/edit/'.$res['id'].'" title = "Edit"><span class="icon glyphicon glyphicon-pencil"></span><span class="title">Edit</span></a></td>
                                     							</tr>';
                                     		}
                                     }else {
                                     	echo '<tr><td colspan="5" style="text-align:center;"> No records found</td></tr>'; 
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
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
