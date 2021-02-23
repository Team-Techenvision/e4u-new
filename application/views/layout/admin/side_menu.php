<div class="side-menu sidebar-inverse">
	<nav class="navbar navbar-default" role="navigation">
		<div class="side-menu-container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo base_url().SITE_ADMIN_URI?>">
					<div class="logo">
						<img src="<?php echo base_url().'assets/images/w_logo.png';?>">
					</div>
				</a>
				<button type="button" class="navbar-expand-toggle pull-right visible-xs">
					<i class="fa fa-times icon"></i>
				</button>
			</div>
			<?php 
			$admin_id = $this->session->userdata('admin_is_logged_in');
			$this->load->helper('function_helper');
			$modules = modules();
			foreach($modules as $key=>$value){
				$module_id[] = $value['id'];	
			}?>
			<ul class="nav navbar-nav" id="panel-parent">
				<li class="<?php if($this->uri->segment(2)=='dashboard')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/dashboard','<span class="icon fa fa-tachometer"></span><span class="title">Dashboard</span>'); ?>
				</li>
				<li style="display:<?php if(in_array('1',$module_id) || in_array('2',$module_id) || in_array('3',$module_id) || in_array('4',$module_id) || in_array('35',$module_id) || in_array('5',$module_id) ||  in_array('6',$module_id) || in_array('7',$module_id) || in_array('8',$module_id) || in_array('9',$module_id) || in_array('10',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="panel panel-default dropdown <?php if($this->uri->segment(2)=='classes' || $this->uri->segment(2)=='sections')  echo 'active'; ?>">
					<?php echo anchor('#dropdown-table','<span class="icon fa fa-sitemap"></span><span class="title">Masters</span>', array('data-toggle'=>'collapse','data-parent'=>'#panel-parent') ); ?>
					<div id="dropdown-table" class="panel-collapse collapse">
						<div class="panel-body">
							<ul class="nav navbar-nav">
								<li style="display:<?php if(in_array('2',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='classes' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/classes', 'Classes'); ?></li>
							</ul>   
							 <ul class="nav navbar-nav">
								<li style="display:<?php if(in_array('3',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='subjects' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/subjects', ' Subjects'); ?></li>
							</ul>   
							<!-- <ul class="nav navbar-nav">
								<li style="display:<?php if(in_array('4',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='medium' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/medium', 'Medium'); ?></li>
							</ul> -->
							<!-- <ul class="nav navbar-nav">
								<li style="display:<?php if(in_array('35',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='course_category' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/course_category', 'Course category'); ?></li>
							</ul> -->
							<ul class="nav navbar-nav">
								<li style="display:<?php if(in_array('5',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='course_plan' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/course_plan', 'Course Plans'); ?></li>
							</ul> 
						  	<ul class="nav navbar-nav">
                             <li style="display:<?php if(in_array('6',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='chapters' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/chapters', 'Chapters'); ?></li>
                        	</ul> 
                            <!--  <ul class="nav navbar-nav">
                                 <li style="display:<?php if(in_array('7',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='levels' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/levels', 'Levels'); ?></li>
                            </ul>
                            <ul class="nav navbar-nav">
                                 <li style="display:<?php if(in_array('8',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='sets' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/sets', 'Sets'); ?></li>
                            </ul> -->
                            <!--  <ul class="nav navbar-nav">
                                 <li style="display:<?php if(in_array('9',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='study_boards' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/study_boards', 'Study Boards'); ?></li>
                            </ul> -->
                            <!--  <ul class="nav navbar-nav">
                                 <li style="display:<?php if(in_array('10',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='sub_category' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/sub_category', 'Subject Category'); ?></li>
                            </ul> -->
						</div>
					</div>
				</li>
				<li style="display:<?php if(in_array('11',$module_id) || in_array('12',$module_id) ||  in_array('13',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="panel panel-default dropdown <?php if($this->uri->segment(2)=='ques' || $this->uri->segment(2)=='ques')  echo 'active'; ?>">
					<?php echo anchor('#dropdown-questions','<span class="icon fa fa-question-circle"></span></span><span class="title">Questions Management</span>', array('data-toggle'=>'collapse','data-parent'=>'#panel-parent') ); ?>
					<div id="dropdown-questions" class="panel-collapse collapse">
						<div class="panel-body">							 
							<ul class="nav navbar-nav">
								<li style="display:<?php if(in_array('12',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='questions_master' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/questions_master', 'Manage Questions'); ?></li>

								<li style="display:<?php if(in_array('12',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='questions' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/questions', 'Chapter Wise Questions'); ?></li>
								<!-- <li style="display:<?php if(in_array('13',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='subjective_questions' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/subjective_questions', 'Subjective Questions'); ?></li> -->
							</ul>
						</div>
					</div>
				</li>


				<li style="display:<?php if(in_array('14',$module_id) || in_array('15',$module_id) ||  in_array('16',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="panel panel-default dropdown <?php if($this->uri->segment(2)=='surprise' || $this->uri->segment(2)=='surprise')  echo 'active'; ?>">
					<?php echo anchor('#dropdown-surprise','<span class="icon fa fa-pencil-square-o"></span><span class="title">Standard Test</span>', array('data-toggle'=>'collapse','data-parent'=>'#panel-parent') ); ?>
					<div id="dropdown-surprise" class="panel-collapse collapse">
						<div class="panel-body">							 
							<ul class="nav navbar-nav">
								<li style="display:<?php if(in_array('15',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='surprise_test' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/surprise_test', 'Manage Test'); ?></li>
								<li style="display:<?php if(in_array('16',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='surprise_questions' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/surprise_questions', 'Manage Questions'); ?></li>
							</ul>
						</div>
					</div>
				</li> 
				<li style="display:<?php if(in_array('39',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='notice_board')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/notice_board','<span class="icon fa fa-bell"></span><span class="title">Notice Board</span>'); ?>
				</li> 

			<!-- 	<li style="display:<?php if(in_array('17',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='alerts')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/alerts','<span class="icon fa fa-bell"></span><span class="title">Alerts</span>'); ?>
				</li> -->
			 	<li style="display:<?php if(in_array('18',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='downloads')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/downloads','<span class="icon fa fa-download"></span><span class="title">Materials</span>'); ?>
				</li>  
				<li style="display:<?php if(in_array('19',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='users')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/users','<span class="icon fa fa-user"></span><span class="title">Users</span>'); ?>
				</li>
				
				 <li style="display:<?php if(in_array('20',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='faqs')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/faqs','<span class="icon fa fa-question"></span><span class="title">FAQ\'S</span>'); ?>
				</li> 
				<li style="display:<?php if(in_array('21',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='testimonials')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/testimonials','<span class="icon fa fa-comments"></span><span class="title">Testimonials</span>'); ?>
				</li>
				<li style="display:<?php if(in_array('22',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='enquiries')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/enquiries','<span class="icon fa fa-info"></span><span class="title">Enquiries</span>'); ?>
				</li>
				<!-- <li style="display:<?php if(in_array('23',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='advertisements')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/advertisements','<span class="icon fa fa-newspaper-o"></span><span class="title">Advertisements</span>'); ?>
				</li>  -->
				<li style="display:<?php if(in_array('24',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='banners')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/banners','<span class="icon fa fa-picture-o"></span><span class="title">Banners</span>'); ?>
				</li> 
				<li style="display:<?php if(in_array('24',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='meeting')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/meeting','<span class="icon fa fa-group"></span><span class="title">Meeting</span>'); ?>
				</li> 
				<!--  <li style="display:<?php if(in_array('25',$module_id) || in_array('26',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="panel panel-default dropdown <?php if($this->uri->segment(2)=='cms' || $this->uri->segment(2)=='cms')  echo 'active'; ?>">
					<?php echo anchor('#dropdown-cms','<span class="icon fa fa-file-text"></span><span class="title">CMS</span>', array('data-toggle'=>'collapse','data-parent'=>'#panel-parent') ); ?>
					<div id="dropdown-cms" class="panel-collapse collapse">
						<div class="panel-body">							 
							<ul class="nav navbar-nav">
								<li style="display:<?php if(in_array('26',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='pages' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/pages', 'Manage Pages'); ?></li>
							</ul>
						</div>
					</div>
				</li>  -->
				<li style="display:<?php if(in_array('27',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='email_templates')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/email_templates','<span class="icon fa fa-mail-reply-all"></span><span class="title">Email Templates</span>'); ?>
				</li>
				<li style="display:<?php if(in_array('36',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='offline_subscription')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/offline_subscription','<span class="icon fa fa-user"></span><span class="title">Offline Subscriptions</span>'); ?>
				</li>

				<li style="display:<?php if(in_array('28',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='orders')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/orders','<span class="icon fa fa-shopping-cart"></span><span class="title">Subscriptions</span>'); ?>
				</li>
				
				<li style="display:<?php if(in_array('29',$module_id) || in_array('30',$module_id) ||  in_array('31',$module_id) || in_array('32',$module_id) || in_array('33',$module_id) || in_array('34',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="panel panel-default dropdown <?php if($this->uri->segment(2)=='reports' || $this->uri->segment(2)=='reports')  echo 'active'; ?>">
					<?php echo anchor('#dropdown-reports','<span class="icon fa fa-flag"></span><span class="title">Reports</span>', array('data-toggle'=>'collapse','data-parent'=>'#panel-parent') ); ?>
					<div id="dropdown-reports" class="panel-collapse collapse">
						<div class="panel-body">							 
							<ul class="nav navbar-nav">
								<li style="display:<?php if(in_array('30',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='user_reports' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/user_reports', 'User Reports'); ?></li>
								<li style="display:<?php if(in_array('31',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='purchase_reports' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/purchase_reports', 'Plan Purchase Reports'); ?></li>
								<li style="display:<?php if(in_array('32',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='performance_reports' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/performance_reports', 'Leaderboard'); ?></li> <!-- Standard Test Reports -->
								
								<li style="display:<?php if(in_array('34',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='test_reports' && $this->uri->segment(3)!='import' ) echo 'subactive';?>" ><?php echo anchor(base_url().SITE_ADMIN_URI.'/test_reports', 'Practice/Create Test Reports'); ?></li>
							</ul>
						</div>
					</div>
				</li>
				<!-- 
				<li style="display:<?php if($admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='user_privileges')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/user_privileges','<span class="icon fa fa-user"></span><span class="title">Users & Privileges</span>'); ?>
				</li>
				<li style="display:<?php if(in_array('37',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='extend_subscription')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/extend_subscription','<span class="icon fa fa-expand"></span><span class="title">Extend Subscription</span>'); ?>
				</li>
				<li style="display:<?php if(in_array('38',$module_id) || $admin_id['admin_user_id']==1){ echo 'block';}else{ echo 'none';}?>" class="<?php if($this->uri->segment(2)=='copy_content')  echo 'active'; ?>">
					<?php echo anchor(base_url().SITE_ADMIN_URI.'/copy_content','<span class="icon fa fa-files-o"></span><span class="title">Copy Content</span>'); ?>
				</li>  -->
			</ul>
		</div>
	</nav>
</div>
