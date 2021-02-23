<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-expand-toggle">
                <i class="fa fa-bars icon"></i>
            </button>
            <ol class="breadcrumb navbar-breadcrumb">
            	<?php $top_title =  SITE_NAME; 
            	if($this->uri->segment(2)=='dashboard') $top_title = 'Dashboard';             	 
            	if($this->uri->segment(2)=='subjects') $top_title =$this->lang->line('Subjects');  
            	if($this->uri->segment(2)=='classes') $top_title = $this->lang->line('Classes'); 
            	if($this->uri->segment(2)=='medium') $top_title = $this->lang->line('Mediums');  
            	if($this->uri->segment(2)=='faqs') $top_title = 'FAQ\'s'; 
            	if($this->uri->segment(2)=='users') $top_title = 'Users'; 
            	if($this->uri->segment(2)=='pages') $top_title = 'CMS Pages'; 
            	if($this->uri->segment(2)=='testimonials') $top_title = 'Testimonials'; 
            	if($this->uri->segment(2)=='enquiries') $top_title = 'Enquiries'; 
            	if($this->uri->segment(2)=='settings') $top_title = 'Settings';
            	if($this->uri->segment(2)=='course_plan') $top_title = 'Course Plan';
            	if($this->uri->segment(2)=='chapters') $top_title = $this->lang->line('Chapters');
            	if($this->uri->segment(2)=='levels') $top_title = $this->lang->line('Levels');
            	if($this->uri->segment(2)=='sets') $top_title =  $this->lang->line('Sets');
            	if($this->uri->segment(2)=='advertisements') $top_title = 'Advertisements';
            	if($this->uri->segment(2)=='banners') $top_title = 'Banners';
            	if($this->uri->segment(2)=='sections') $top_title = 'Sections';  
           		if($this->uri->segment(2)=='teachers') $top_title = 'Teachers';  
           		if($this->uri->segment(2)=='students') $top_title = 'Students';
           		if($this->uri->segment(2)=='parents') $top_title = 'Parents';    
           		if($this->uri->segment(2)=='countries') $top_title = 'Loaction - Countries';  
           		if($this->uri->segment(2)=='states') $top_title = 'Loaction - States';  
           		if($this->uri->segment(2)=='cities') $top_title = 'Loaction - Cities';
           		if($this->uri->segment(2)=='areas') $top_title = 'Loaction - Areas'; 
           		if($this->uri->segment(2)=='email_templates') $top_title = 'Email Templates'; 
           		 ?>
                <li class="active"><?php echo $top_title; ?></li>
            </ol>
            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="fa fa-th icon"></i>
            </button>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="fa fa-times icon"></i>
            </button>
            <?php $admin_id = $this->session->userdata('admin_is_logged_in');?>
             <?php if($admin_id["admin_user_id"] == 1){?>
            
            <li class="text settings" >
                <?php echo anchor(base_url().SITE_ADMIN_URI.'/settings','<span title="Settings" class="icon fa fa-cog" style="padding: 24px 0px 0px 0px;"></span>'); ?>
            </li> 
            
            <?php } ?>
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo getSessionAdminDetail(); ?> <span class="caret"></span></a>
                <ul class="dropdown-menu animated fadeInDown">
                   
                    <li>
                        <div class="profile-info">
                            <h4 class="username"><?php echo getSessionAdminDetail(); ?> </h4>
                            <p><?php echo getSessionAdminDetail('admin_email'); ?></p>
                            <div class="btn-group margin-bottom-2x" role="group">
                            	<?php echo anchor(base_url().SITE_ADMIN_URI.'/profile', '<i class="fa fa-user"></i>Profile', array('title' => 'Profile','class'=>'btn btn-default')); ?>
                                <?php echo anchor(base_url().SITE_ADMIN_URI.'/logout', '<i class="fa fa-sign-out"></i>Logout', array('title' => 'Logout','class'=>'btn btn-default')); ?></br>
                                <?php echo anchor(base_url().SITE_ADMIN_URI.'/changepassword', 'Change Password', array('title' => 'Change Password')); ?>
                            </div>   
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
