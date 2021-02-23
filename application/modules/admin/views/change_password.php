<div class="container">
	<div class="login-box"><div>
	<div class="login-form row">
		<div class="col-sm-12 text-center login-header">
			<i class="login-logo fa fa-connectdevelop fa-5x"></i>
			<h4 class="login-title">E4U - Change Password</h4>
		</div>
		<div class="col-sm-12">
			<div class="login-body card custom-card">
				<div class="progress hidden" id="login-progress">
					<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						Log In...
					</div>
				</div>
				<div class="card-header">
					<div class="card-title">
						<div class="title">Change Password</div>
					</div>
					<div class="back pull-right">
						<a title="Back" href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/dashboard">Back</a>
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
					<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_changepass_form');
					echo form_open('', $attributes, array('login'=>true)); ?>
					<div class="form-group">
						<?php echo form_label('Current Password <span class="required">*</span>','current_password',array('class'=>'col-sm-2 control-label')); ?>
						<div class="col-sm-5">
							<?php echo form_password('current_password', (!isset($_POST['current_password'])?"":$_POST['current_password']) ,'placeholder="Current Password" class="form-control" id="current_password"'); 
							if(form_error('current_password')) echo form_label(form_error('current_password'), 'current_password', array("id"=>"current_password-error" , "class"=>"error")); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo form_label('New Password <span class="required">*</span>','new_password',array('class'=>'col-sm-2 control-label')); ?>
						<div class="col-sm-5">
							<?php echo form_password('new_password', (!isset($_POST['new_password'])?"":$_POST['new_password']) ,'placeholder="New Password" class="form-control" id="new_password"'); 
							if(form_error('new_password')) echo form_label(form_error('new_password'), 'new_password', array("id"=>"new_password-error" , "class"=>"error")); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo form_label('Confirm New Password <span class="required">*</span>','confirm_password',array('class'=>'col-sm-2 control-label')); ?>
						<div class="col-sm-5">
							<?php echo form_password('confirm_password', (!isset($_POST['confirm_password'])?"":$_POST['confirm_password']) ,'placeholder="Confirm Password" class="form-control" id="confirm_password"');
							if(form_error('confirm_password')) echo form_label(form_error('confirm_password'), 'confirm_password', array("id"=>"confirm_password-error" , "class"=>"error"));  ?>
						</div>
					</div>
					<div class="login-button col-sm-offset-3">
						<?php echo form_submit('submit', 'Submit', 'title="Submit" class="btn btn-primary" '); ?>
					</div>
					<?php echo form_close();  ?>
				</div>
			</div>
		</div>
	</div>
</div>
