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
		                            	<div class="title"><?php echo $this->lang->line('managecourse');  ?></div>
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
								<?php echo form_open(base_url().SITE_ADMIN_URI.'/course_plan/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'class="search_single"'); ?>
									<div class="form-group">
										<div class="col-sm-2">
											<?php //echo form_dropdown('search_categ',$category,$search_categ,' class="form-control" id="search_categ"'); ?>
									<!-- 	</div>
										<div class="col-sm-2"> -->
											<?php echo form_input('search_name',$keyword_name,'placeholder= "Search Name" class="form-control" id="search_name"'); ?>
										</div>
                    					<div class="col-sm-2 col-lg-1">
                    					<?php $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default full-width-btn', 'value' => 'Search', 'title' => 'Search');
                    					echo form_submit($submit_val);?>
                    					</div>
                    					<div class="col-sm-2 col-lg-1">
                    					<a title="Reset" class="btn btn-default full-width-btn" href="<?php echo base_url().SITE_ADMIN_URI.'/course_plan/reset'; ?>">Reset</a>
                    					</div>
									</div>
								<?php echo form_close(); ?>
								<span class="create_new"><?php //echo anchor(base_url().SITE_ADMIN_URI.'/course_plan/add?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'Add Course Plan',array('class'=>'btn btn-suc glyphicon glyphicon-plus  pull-right','title'=>'Add Course Plan')); ?></span>
                        		<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
								<?php echo form_open(base_url().SITE_ADMIN_URI.'/course_plan/bulkactions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
	                              <table class="datatable table table-striped" cellspacing="0" width="100%">
	                                  <thead>
	                                      <tr>
	                                      	  <th>S.No</th>                             
	                                          <th>Name</th>
	                                          <!-- <th>Category</th> -->
	                                          <!-- <th>Type</th> -->
	                                          <th>Price</th>
	                                          <th>Duration</th>
	                                          <!-- <th>Order</th> -->
	                                          <th>Created</th>
	                                          <th>Action</th>
	                                      </tr>
	                                  </thead>
	                                  <tbody>
	                                  <?php if($total_rows > 0 ) {
											foreach ($courses as $key=>$res) 
											{  
												$class="odd"; if($key% 2 ) $class="even"; ?>
												<tr class="<?php echo $class;?>">
												<td><?php echo ($limit_end+$key+1);?></td>	
												<td><?php echo (strlen($res['name'])>30?substr($res['name'],0,30)."...":$res['name']) ;?></td>
												<!-- <td><?php //echo (strlen($res['category'])>30?substr($res['category'],0,30)."...":$res['category']) ;?></td>  
												-->
												<!-- <td>
												<?php //echo $res['course_type']==1?"Free":"Paid"; ?>
												</td> -->
												<td><?php $price = $res['course_type']==1?"N/A":"";													
													if($res['price']!=0){
														$price = $currency." ".number_format($res['price'], 2);														
													}
													// if($res['price_d']!=0){
													// 	if($price!=""){
													// 		$price = $price." / ".$dollar_symbol." ".number_format($res['price_d'],2);
													// 	}else{
													// 		$price = $dollar_symbol." ".number_format($res['price_d'],2);
													// 	}														
													// }
													echo $price;									
													
												?></td>
												<td><?php echo $res['duration'];?> Month(s)</td>
												<!-- <td><?php //echo $res['order_by_category'];?></td> -->
												<td><?php echo date( ADMIN_DATE_FORMAT, strtotime($res['created']));?></td>
												<td class="actions"><a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/course_plan/edit/<?php echo $res['id'];?>" title = "Edit"><span class="icon glyphicon glyphicon-pencil"></span><span class="title">Edit</span></a> 
											
												<?php
												//if($chapter_count[$res["id"]]==0){ ?>
												 <!-- /  -->
												<!--  <a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/course_plan/delete/<?php echo $res['id'];?>/<?php echo $pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort;?>" title = "Delete" class="delete-con"><span class="icon glyphicon glyphicon-trash"></span><span class="title">Delete</span></a> -->
												<?php //} ?>
												</td>
												</tr>
												<?php
											}
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
						 	<?php echo form_close(); ?>
                 		</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
