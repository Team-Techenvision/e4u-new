<div class="container">
	<div class="login-box"><div>
	<div class="login-form row">
		<div class="col-sm-12 text-center login-header">
			<i class="login-logo fa fa-connectdevelop fa-5x"></i>
			<h4 class="login-title">E4U - Profile</h4>
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
						<div class="title">Profile</div>
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
					<?php } 
					
					if($this->session->flashdata('flash_success_message')){ ?>
					<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Done!</strong> <?php echo $this->session->flashdata('flash_success_message'); ?>
						<?php $this->session->unmark_flash('flash_success_message'); ?>
					</div> 
					<?php } ?>
					<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_changepass_form');
					echo form_open('', $attributes, array('login'=>true)); ?>
					<div class="form-group">
						<?php echo form_label('User Name <span class="required">*</span>','uname',array('class'=>'col-sm-4 control-label')); ?>
						<div class="col-sm-6">
							<?php echo form_input('uname',isset($_POST['uname'])?$_POST['uname']: (isset($profile['username']) ? $profile['username'] : '') ,'placeholder="User Name" class="form-control" id="fname"'); 
							if(form_error('uname')) echo form_label(form_error('uname'), 'uname', array("id"=>"uname-error" , "class"=>"error")); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo form_label('Email <span class="required">*</span>','email',array('class'=>'col-sm-4 control-label')); ?>
						<div class="col-sm-6">
							<?php echo form_input('email', isset($_POST['email'])?$_POST['email']:(isset($profile['email']) ? $profile['email'] : '') ,'placeholder="Email" class="form-control" id="email"'); 
							if(form_error('email')) echo form_label(form_error('email'), 'email', array("id"=>"email-error" , "class"=>"error")); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo form_label('Display Name <span class="required">*</span>','dname',array('class'=>'col-sm-4 control-label')); ?>
						<div class="col-sm-6">
							<?php echo form_input('dname', isset($_POST['dname'])?$_POST['dname']:(isset($profile['display_name']) ? $profile['display_name'] : '') ,'placeholder="Display Name" class="form-control" id="dname"'); 
							if(form_error('dname')) echo form_label(form_error('dname'), 'dname', array("id"=>"dname-error" , "class"=>"error")); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo form_label('Phone Number <span class="required">*</span>','phone',array('class'=>'col-sm-4 control-label')); ?>
						<div class="col-sm-6">
							<?php echo form_input('phone', isset($_POST['phone'])?$_POST['phone']:(isset($profile['phone_number']) ? $profile['phone_number'] : '') ,'placeholder="Phone Number" class="form-control" id="phone"'); 
							if(form_error('phone')) echo form_label(form_error('phone'), 'phone', array("id"=>"phone-error" , "class"=>"error")); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo form_label('Address <span class="required">*</span>','address',array('class'=>'col-sm-4 control-label')); ?>
						<div class="col-sm-6">
							<?php echo form_textarea('address', isset($_POST['address'])?$_POST['address']:(isset($profile['address']) ? $profile['address'] : ''),'placeholder="Address" class="form-control" id="address"'); 
							if(form_error('address')) echo form_label(form_error('address'), 'address', array("id"=>"address-error" , "class"=>"error")); ?>
						</div>
					</div>
					<div class="login-button text-center">
						<?php echo form_submit('submit', 'Submit', 'title="Submit" class="btn btn-primary" '); ?>
					</div>
					<?php echo form_close();  ?>
				</div>
			</div>
		</div>
	</div>
</div>
