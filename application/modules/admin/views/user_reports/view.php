 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('viewuserreports'); ?></div>
							</div>
							<div class="back pull-right">
								<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/user_reports" title="Back">Back</a>
							</div>
						</div>
                    	<div class="card-body">
                    		<!-- Flash Message -->
							<?php if($this->session->flashdata('flash_failure_message')){ ?>
							<div class="alert alert-danger" role="alert">
								 <strong>Warning!</strong> <?php echo $this->session->flashdata('flash_failure_message'); ?>
								 <?php $this->session->unmark_flash('flash_failure_message'); ?>
							</div> 
							<?php } if($this->session->flashdata('flash_success_message')){ ?>
							<div class="alert alert-success" role="alert">
								 <strong>Done!</strong> <?php echo $this->session->flashdata('flash_success_message'); ?>
								 <?php $this->session->unmark_flash('flash_success_message'); ?>
							</div> 
							<?php } ?>
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_enquiry_form');				
							echo form_open('', $attributes); ?>
							<div class="form-group" style="position:absolute;margin-left:85%;">
								<?php if($user_reports['profile_image']!=""){
								 //$img_src = thumb($this->config->item('profile_image_url') .$user_reports['profile_image'] ,'50', '50', 'thumb_profile_img',$maintain_ratio = TRUE);
								 //$img_prp = base_url() . 'appdata/profile/thumb_profile_img/'.$img_src;
								 $img_prp = base_url() . 'appdata/profile/'.$user_reports['profile_image'];
								 }else{
									$img_src="assets/site/images/no-image-men.png";
								  	$img_prp=base_url() .$img_src;
								 }
								 ?>
								<img src="<?php echo $img_prp;?>" alt="Profile" title="Profile Image" style="height:100px;"/>
							</div>
							<div class="form-group">
                            	<?php echo form_label('Created Date : ','created',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="created" style="border:none;"><?php echo date( ADMIN_DATE_FORMAT, strtotime($user_reports['created'])); ?></p>
                                </div>
                            </div>
                            <?php if(isset($course_name)){ ?>
                            <div class="form-group">
                            	<?php $js = 'id="course_list" class="form-control"';
									$set_course = isset($_POST['course_list'])?$_POST['course_list']: (isset($course_name) ? $course_name : '');?>
                            	<?php echo form_label('Course Plan : ','course_list',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="course_list" style="border:none;"><?php echo $set_course; ?></p>
                                </div>
                            </div>
                            <?php } ?>
                         	<div class="form-group">
                            	<?php $js = 'id="user_name" class="form-control"';
									$set_name = isset($_POST['user_name'])?$_POST['user_name']: (isset($user_reports['user_name']) ? $user_reports['user_name'] : '');?>
                            	<?php echo form_label('User Name : ','user_name',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="user_name" style="border:none;"><?php echo $set_name; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php if($user_reports['gender'] == 1){
                            		$gen = "Male";
                            	}else if($user_reports['gender'] == 2){
                            		$gen = "Female";
                            	}else{
                            		$gen = "-";
                            	}?>
                            	<?php $js = 'id="gender" class="form-control"';
									$set_gender = isset($_POST['gender'])?$_POST['gender']: (isset($gen) ? $gen : '');?>
                            	<?php echo form_label('Gender : ','gender',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="gender" style="border:none;"><?php echo $set_gender; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php $js = 'id="class_name" class="form-control"';
									$set_class_name = isset($_POST['class_name'])?$_POST['class_name']: (isset($user_reports['class_name']) ? $user_reports['class_name'] : '');?>
                            	<?php echo form_label('Class : ','class_name',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="class_name" style="border:none;"><?php echo $set_class_name; ?></p>
                                </div>
                            </div>
                           <!--  <div class="form-group">
                            	<?php $js = 'id="medium_name" class="form-control"';
									$set_medium_name = isset($_POST['medium_name'])?$_POST['medium_name']: (isset($user_reports['medium_name']) ? $user_reports['medium_name'] : '');?>
                            	<?php echo form_label('Medium : ','medium_name',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="medium_name" style="border:none;"><?php echo $set_medium_name; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php $js = 'id="board_name" class="form-control"';
									$set_board_name = isset($_POST['board_name'])?$_POST['board_name']: (isset($user_reports['board_name']) ? $user_reports['board_name'] : '');?>
                            	<?php echo form_label('Board : ','board_name',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="board_name" style="border:none;"><?php echo $set_board_name; ?></p>
                                </div>
                            </div> -->
                            <div class="form-group">
                            	<?php $js = 'id="contact_number" class="form-control"';
									$set_contact_number = isset($_POST['contact_number'])?$_POST['contact_number']: (isset($user_reports['phone']) ? $user_reports['phone'] : '');?>
                            	<?php echo form_label('Contact Number : ','contact_number',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="contact_number" style="border:none;"><?php echo $set_contact_number; ?></p>
                                </div>
                            </div>
                         	<div class="form-group">
                            	<?php $js = 'id="email" class="form-control"';
									$set_email = isset($_POST['email'])?$_POST['email']: (isset($user_reports['email']) ? $user_reports['email'] : '');?>
                            	<?php echo form_label('Email : ','email',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="email" style="border:none;"><?php echo $set_email; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php $js = 'id="address" class="form-control"';
									$set_address = isset($_POST['address'])?$_POST['address']: (isset($user_reports['address']) ? $user_reports['address'] : '');?>
                            	<?php echo form_label('Address : ','address',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="address" style="border:none;"><?php echo $set_address; ?></p>
                                </div>
                            </div>
                           <!--  <div class="form-group">
                            	<?php $js = 'id="level_completed" class="form-control"';
									$set_level_completed = isset($_POST['level_completed'])?$_POST['level_completed']: (isset($user_reports['progress_count']) ? $user_reports['progress_count'] : '');?>
                            	<?php echo form_label('Levels Completed : ','level_completed',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="level_completed" style="border:none;"><?php echo $set_level_completed; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php $js = 'id="documents_uploaded" class="form-control"';
									$set_documents_uploaded = isset($_POST['documents_uploaded'])?$_POST['documents_uploaded']: (isset($user_reports['documents']) ? $user_reports['documents'] : '');?>
                            	<?php echo form_label('Documents Uploaded : ','documents_uploaded',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="documents_uploaded" style="border:none;"><?php echo $set_documents_uploaded; ?></p>
                                </div>
                            </div> -->
                            <div class="form-group">
                            	<?php $js = 'id="last_login" class="form-control"';
									$set_last_login = isset($_POST['last_login'])?$_POST['last_login']: (isset($user_reports['last_login_time']) ? $user_reports['last_login_time'] : '');?>
                            	<?php echo form_label('Last Login : ','last_login',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="last_login" style="border:none;"><?php echo $set_last_login; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php if($user_reports['status'] == 1){
                            		$stat = "Active";
                            	}else{
                            		$stat = "Inactive";
                            	}?>
                            	<?php $js = 'id="status" class="form-control"';
									$set_status = isset($_POST['status'])?$_POST['status']: (isset($stat) ? $stat : '');?>
                            	<?php echo form_label('Status : ','status',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="status" style="border:none;"><?php echo $set_status; ?></p>
                                </div>
                            </div>
						<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


