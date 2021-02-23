            <!-- Main Content -->
         <!--    <div class="container-fluid">
                <div class="side-body padding-top">
                 -->	<?php $admin_id = $this->session->userdata('admin_is_logged_in');
						$this->load->helper('function_helper');
						$modules = modules();
						foreach($modules as $key=>$value){
							$module_id[] = $value['id'];	
						}?>
					<?php if((!in_array('31',$module_id) && !in_array('30',$module_id) && !in_array('34',$module_id) && !in_array('33',$module_id) && !in_array('18',$module_id) && !in_array('22',$module_id) && !in_array('31',$module_id) && !in_array('30',$module_id) && !in_array('34',$module_id) && !in_array('33',$module_id) && !in_array('22',$module_id) && !in_array('15',$module_id) && !in_array('12',$module_id) && !in_array('28',$module_id) && !in_array('18',$module_id)) && $admin_id['admin_user_id']!=1){?>
						<!-- <div class="overall-state-inner" style="font-weight:700;text-align:center;margin-top: 300px;font-size:32px;"> 
							<div class="row">
								<p>The data you're looking for can't be found.</p>
							<span></span>
							</div>
						</div> -->
					<?php } ?>
				<!-- 	<div class="row">
					   <div class="col-md-12" style="display:<?php if((in_array('31',$module_id) || in_array('30',$module_id) || in_array('34',$module_id) || in_array('33',$module_id) || in_array('18',$module_id) || in_array('22',$module_id)) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
					   	<h3 class="text-center">Today's</h3>
					   </div>
				   	</div>
                    <div class="row">
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('31',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
              				<a href="<?php echo base_url().SITE_ADMIN_URI."/purchase_reports?date=".date('Y-m-d'); ?>" class="purple">
                                <div class="card summary-inline image_color">
                                    <div class="card-body">
                                        <i class="icon fa fa-shopping-cart fa-4x"></i>
                                        <div class="content">
                                            <div class="title"><?php echo $total_course_purchase_today; ?></div>
                                            <div class="sub-title"><h4>Plans Purchased</h4></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
 						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('30',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                            <a href="<?php echo base_url().SITE_ADMIN_URI."/user_reports?date=".date('Y-m-d'); ?>">
                                <div class="card yellow summary-inline">
                                    <div class="card-body">
                                        <i class="icon icon fa fa-user fa-4x"></i>
                                        <div class="content">
                                            <div class="title"><?php echo $today_total_users; ?></div>
                                            <div class="sub-title"><h4>Registered User</h4></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('34',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                            <a href="<?php echo base_url()."admin/test_reports/?date=".date("Y-m-d"); ?>" class="today-test">
                                <div class="card summary-inline test-color">
                                    <div class="card-body">
                                        <i class="icon  fa fa-tasks fa-4x"></i>
                                        <div class="content">
                                            <div class="title"><?php echo $test_today ?></div>
                                            <div class="sub-title"><h4>Test</h4></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('33',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
 							<a href="<?php echo base_url().SITE_ADMIN_URI."/certificates?date=".date('Y-m-d'); ?>">
                              <div class="card blue summary-inline">
                                    <div class="card-body">
                                        <i class="icon fa fa-certificate fa-4x"></i>
                                        <div class="content">
                                            <div class="title"><?php echo $total_certificate_today; ?></div>
                                            <div class="sub-title"><h4>Certificates issues</h4></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
 						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('18',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                     	 	<a href="<?php echo base_url().SITE_ADMIN_URI."/downloads?date=".date('Y-m-d'); ?>">
                                <div class="card red summary-inline">
                                    <div class="card-body">
                                        <i class="icon fa fa-upload fa-4x"></i>
                                        <div class="content">
                                            <div class="title"><?php echo $total_material_upload_today; ?></div>
                                            <div class="sub-title"><h4>Material upload</h4></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
 						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('22',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                       		<a href="<?php echo base_url().SITE_ADMIN_URI."/enquiries?date=".date('Y-m-d'); ?>">
                                <div class="card green summary-inline">
                                    <div class="card-body">
                                        <i class="icon fa fa-envelope fa-4x"></i>
                                        <div class="content">
                                            <div class="title"><?php echo $new_inquries_today; ?></div>
                                            <div class="sub-title"><h4>Enquiries</h4></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>

<div class="clearfix"></div>
<div class="row">
					   <div class="col-md-12" style="display:<?php if((in_array('31',$module_id) || in_array('30',$module_id) || in_array('34',$module_id) || in_array('33',$module_id) || in_array('22',$module_id)) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
						   <h3 class="text-center">Overall Stats</h3>
				   	   </div>
					   </div>
			  		   <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('22',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                         <a href="<?php echo base_url().SITE_ADMIN_URI."/enquiries"; ?>">
                             <div class="card green summary-inline">
                                 <div class="card-body">
                                     <i class="icon fa fa-envelope fa-4x"></i>
                                     <div class="content">
                                         <div class="title"><?php echo $new_inquries; ?></div>
                                         <div class="sub-title"><h4>Enquiries</h4></div>
                                     </div>
                                     <div class="clear-both"></div>
                                 </div>
                             </div>
                         </a>
                      </div>
					  <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('33',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                            <a href="<?php echo base_url().SITE_ADMIN_URI."/certificates"; ?>">
                                <div class="card blue summary-inline">
                                    <div class="card-body">
                                        <i class="icon fa fa-certificate fa-4x"></i>
                                        <div class="content">
                                            <div class="title"><?php echo $total_certificate; ?></div>
                                            <div class="sub-title"><h4>Certificates</h4></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
						  <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('31',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                            <a href="<?php echo base_url().SITE_ADMIN_URI."/purchase_reports"; ?>">
                                <div class="card summary-inline plan">
                                    <div class="card-body">
                                        <i class="icon fa fa-shopping-cart fa-4x"></i>
                                        <div class="content">
                                            <div class="title"><?php echo $total_course; ?></div>
                                            <div class="sub-title"><h4>Plans Purchased</h4></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div> 
						
<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('34',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                            <a href="<?php echo base_url()."admin/test_reports"; ?>" class="today-test">
                                <div class="card summary-inline test-color">
                                    <div class="card-body">
                                        <i class="icon  fa fa-tasks fa-4x"></i>
                                        <div class="content">
                                            <div class="title"><?php echo $total_test ?></div>
                                            <div class="sub-title"><h4>Total Test</h4></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a> -->
							<!--original hide div class="sub-exam" style="position:relative;z-index:999999;display:none;">
							<div style="position:absolute;width: 100%;">
							<div style="card card-success">
							 <div class="card-header" style="background-color:#543A35;color:#fff;">
                                    <div class="card-title">
                                        <div class="title"> <h3 style="padding: 10px;" ><a style="color:#fff;text-decoration:none" href="#"><i class="fa fa-tasks"></i>Progress Test <?php echo $progress_today; ?></a></h3></div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
							</div>
							<div style="card card-success">
							 <div class="card-header" style="background-color:#543A35;color:#fff;">
                                    <div class="card-title">
                                        <div class="title"> <h3  style="padding: 10px;margin-top: -10px;"  style="margin-top: -10px;"><a style="color:#fff;text-decoration:none" href="#"><i class="fa fa-tasks"></i>Surprise Test <?php echo $surprise_today; ?></h3></a></div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
							</div>
							</div>
							</div original hide-->
                      <!--   </div>
						<div class="clearfix"></div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 card card-success" style="display:<?php if(in_array('30',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                                <div class="card-header" style="background-color:#2a3f61">
                                    <div class="card-title">
                                        <div class="title"><i class="fa fa-users"></i> Total Users Registered</div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
								  <div class="row">
								  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
										<a href="<?php echo  base_url().SITE_ADMIN_URI."/user_reports/reset/"; ?>">
										<div class="card yellow summary-inline text-center">
											<div class="card-body">
											<h3 style="margin-top:0px;margin-bottom:5px">All Users</h3>
											  
												<h1 style="margin-top:0px;margin-bottom:5px"><?php echo $total_users; ?></h1>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div> 
								  </div>
                                 <div class="row">
                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<a href="<?php echo  base_url().SITE_ADMIN_URI."/user_reports/index/?user_status=1"; ?>">
										<div class="card green summary-inline">
											<div class="card-body">
												<i class="icon fa fa-user fa-4x"></i>
												<div class="content">
													<div class="title"><?php echo $active_users; ?></div>
													<div class="sub-title"><h4>Active Users</h4></div>
												</div>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div>  
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<a href="<?php echo   base_url().SITE_ADMIN_URI."/user_reports/index/?user_status=2"; ?>">
										<div class="card red summary-inline">
											<div class="card-body">
												<i class="icon fa fa-user fa-4x"></i>
												<div class="content">
													<div class="title"><?php echo $inactive_users; ?></div>
													<div class="sub-title"><h4>Inactive Users</h4></div>
												</div>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div>
                                </div>
                            </div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 card card-success" style="display:<?php if(in_array('34',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                                <div class="card-header" style="background-color:#2a3f61">
                                    <div class="card-title">
                                        <div class="title"><i class="fa fa-tasks"></i> Total Test Taken</div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
								  <div class="row">
								  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<a href="<?php echo base_url()."admin/test_reports/reset" ?>">
										<div class="card yellow summary-inline text-center">
											<div class="card-body">
											<h3 style="margin-top:0px;margin-bottom:5px">Total Tests</h3>
											  
												<h1 style="margin-top:0px;margin-bottom:5px"><?php echo $total_test; ?></h1>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div> 
								  </div>
                                <div class="row">
                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<a href="<?php echo base_url()."admin/test_reports?exam_type=1" ?>">
										<div class="card blue summary-inline">
											<div class="card-body">
												<i class="icon fa fa-clock-o fa-4x"></i>
												<div class="content">
													<div class="title"><?php echo $total_Protest; ?></div>
													<div class="sub-title"><h4>Progress Test</h4></div>
												</div>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div>  
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<a href="<?php echo base_url()."admin/test_reports?exam_type=2" ?>">
										<div class="card summary-inline image_color">
											<div class="card-body">
												<i class="icon fa fa-flash fa-4x"></i>
												<div class="content">
													<div class="title"><?php echo $total_surprisetest; ?></div>
													<div class="sub-title"><h4>Surprise Test</h4></div>
												</div>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div>
                                </div>
                            </div>
					
					
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:<?php if((in_array('15',$module_id) || in_array('12',$module_id) || in_array('28',$module_id) || in_array('18',$module_id)) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
                           <div class="row">
						   <div class="col-md-12">
						   <h3 class="text-center">Quick Links</h3>
						   </div>
						   </div>
                                <div class="row">
                                     <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('15',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
										<a href="<?php echo base_url()."admin/surprise_test" ?>">
										<div class="card blue summary-inline">
											<div class="card-body">
												<i class="icon fa fa-flash fa-4x"></i>
												<div class="content"> 
													<div class="sub-title"><h2>Surprise Test</h2></div>
												</div>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div>  
									<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('12',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
										<a href="<?php echo base_url()."admin/questions" ?>">
										<div class="card blue summary-inline" >
											<div class="card-body">
												<i class="icon fa fa-question-circle fa-4x"></i>
												<div class="content">
											 
													<div class="sub-title"><h2>Questions</h2></div>
												</div>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div>	
									<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('28',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
										<a href="<?php echo base_url()."admin/orders" ?>">
										<div class="card blue summary-inline" >
											<div class="card-body">
												<i class="icon fa fa-shopping-cart fa-4x"></i>
												<div class="content">
											 
													<div class="sub-title"><h2>Orders</h2></div>
												</div>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div>	
									<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display:<?php if(in_array('18',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>">
										<a href="<?php echo base_url()."admin/downloads" ?>">
										<div class="card blue summary-inline"  >
											<div class="card-body">
												<i class="icon fa fa-download fa-4x"></i>
												<div class="content">
											 
													<div class="sub-title"><h2>Downloads</h2></div>
												</div>
												<div class="clear-both"></div>
											</div>
										</div>
										</a>
									</div>
                                </div>      
					</div>
                    </div>
                </div>
            </div>
 -->