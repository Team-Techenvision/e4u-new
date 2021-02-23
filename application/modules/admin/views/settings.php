 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title">Settings</div>
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
							<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								 <strong>Done!</strong> <?php echo $this->session->flashdata('flash_success_message'); ?>
								 <?php $this->session->unmark_flash('flash_success_message'); ?>
							</div> 
							<?php } ?>
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_enquiry_form');				
							echo form_open('', $attributes);?> 
							<!--<div class="form-group">
                            	<?php echo form_label('Pass Percentage <span class="required">*</span> ','marks',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4"> -->
									<?php echo form_hidden('marks',isset($_POST['marks'])?$_POST['marks']: (isset($settings['pass_percentage']) ? $settings['pass_percentage'] : ''),
									' class="" id="marks"');//.' %';
		               				if(form_error('marks')) echo form_label(form_error('marks'), 'marks', array("id"=>"marks-error" , "class"=>"error")); ?>
                                <!-- </div>
                            </div>
                            <div class="form-group">
                            	<?php echo form_label('No. Of Questions Sets <span class="required">*</span> ','ques',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4"> -->
									<?php echo form_hidden('ques', isset($_POST['ques'])?$_POST['ques']: (isset($settings['question_count']) ? $settings['question_count'] : '')  ,' class="" id="ques"');
		               				if(form_error('ques')) echo form_label(form_error('ques'), 'ques', array("id"=>"ques-error" , "class"=>"error")); ?>
                                <!-- </div>
                            </div>
                             <div class="form-group">
                            	<?php echo form_label('Count Down Time <span class="required">*</span> ','count_down_time',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4"> -->
									<?php echo form_hidden('count_down_time', isset($_POST['count_down_time'])?$_POST['count_down_time']: (isset($settings['count_down_time']) ? $settings['count_down_time'] : '')  ,' class="" id="count_down_time"'); ?>
									<!-- <label>(In Min Only)</label> -->
		               				<?php if(form_error('count_down_time')) echo form_label(form_error('count_down_time'), 'count_down_time', array("id"=>"count_down_time-error" , "class"=>"error")); ?>
                               <!--  </div>
                            </div>
							<div class="form-group">
                            	<?php echo form_label('Renew or Purchase A Plan Remainder <span class="required">*</span> ','remainder',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4"> -->
									<?php echo form_hidden('remainder', isset($_POST['remainder'])?$_POST['remainder']: (isset($settings['remainder']) ? $settings['remainder'] : '')  ,' class="" id="remainder"'); ?>
									<!-- <label>(In Days Only)</label> -->
		               				<?php if(form_error('remainder')) echo form_label(form_error('remainder'), 'remainder', array("id"=>"remainder-error" , "class"=>"error")); ?>
                               <!--  </div>
                            </div> -->
                            <div class="form-group">
                            	<?php echo form_label('Mark Per Question <span class="required">*</span> ','mark_per_ques',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4"> 
									<?php echo form_input('mark_per_ques', isset($_POST['mark_per_ques'])?$_POST['mark_per_ques']: (isset($settings['mark_per_ques']) ? $settings['mark_per_ques'] : '')  ,' class="" id="mark_per_ques"'); ?>
									<!-- <label>(In days Only)</label> -->
		               				<?php if(form_error('mark_per_ques')) echo form_label(form_error('mark_per_ques'), 'mark_per_ques', array("id"=>"mark_per_ques-error" , "class"=>"error")); ?>
                                </div>
                            </div>

                            <div class="form-group">
                            	<?php echo form_label('Negative Mark<span class="requi red">*</span> ','negative_mark',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4"> 
									<?php echo form_input('negative_mark', isset($_POST['negative_mark'])?$_POST['negative_mark']: (isset($settings['negative_mark']) ? $settings['negative_mark'] : '')  ,' class="" id="negative_mark"'); ?>
									<!-- <label>(In days Only)</label> -->
		               				<?php if(form_error('negative_mark')) echo form_label(form_error('negative_mark'), 'negative_mark', array("id"=>"negative_mark-error" , "class"=>"error")); ?>
                                </div>
                            </div>

                            <div class="form-group">
                            	<?php echo form_label('Free Trial <span class="required">*</span> ','free_trial',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4"> 
									<?php echo form_input('free_trial', isset($_POST['free_trial'])?$_POST['free_trial']: (isset($settings['free_trial']) ? $settings['free_trial'] : '')  ,' class="" id="free_trial"'); ?>
									<label>(In days Only)</label>
		               				<?php if(form_error('free_trial')) echo form_label(form_error('free_trial'), 'free_trial', array("id"=>"free_trial-error" , "class"=>"error")); ?>
                                </div>
                            </div>


                            <legend><?php echo form_label('Contact Information:','name'); ?> </legend>
                            	<fieldset>
			                    	<div class="form-group">
		                        		<?php echo form_label('Contact Number <span class="required">*</span> ','contact_number',array('class'=>'col-sm-2 control-label')); ?>
		                           		<div class="col-sm-4">
										<?php echo form_input('contact_number',isset($_POST['contact_number'])?$_POST['contact_number']: (isset($settings['contact_number']) ? $settings['contact_number'] : ''),' class="" id="contact_number" placeholder="Ex:0123456789"');
				           				if(form_error('contact_number')) echo form_label(form_error('contact_number'), 'contact_number', array("id"=>"contact_number-error" , "class"=>"error")); ?>
		                            	</div>
                           	 		</div>
                           	 		<div class="form-group">
		                        		<?php echo form_label('Email ID <span class="required">*</span> ','email',array('class'=>'col-sm-2 control-label')); ?>
		                           		<div class="col-sm-4">
										<?php echo form_input('contact_email',isset($_POST['contact_email'])?$_POST['contact_email']: (isset($settings['contact_mail']) ? $settings['contact_mail'] : ''),' class="" id="contact_email" placeholder="Example@gmail.com"');
				           				if(form_error('contact_email')) echo form_label(form_error('contact_email'), 'contact_email', array("id"=>"contact_email-error" , "class"=>"error")); ?>
		                            	</div>
                           	 		</div>
                           	 		<div class="form-group">
		                        		<?php echo form_label('Address <span class="required">*</span> ','address',array('class'=>'col-sm-2 control-label')); ?>
		                           		<div class="col-sm-4">
										<?php echo form_textarea('contact_address',isset($_POST['contact_address'])?$_POST['contact_address']: (isset($settings['contact_address']) ? $settings['contact_address'] : ''),' class="form-control" id="contact_address" placeholder="Address"');
				           				if(form_error('contact_address')) echo form_label(form_error('contact_address'), 'contact_address', array("id"=>"contact_address-error" , "class"=>"error")); ?>
		                            	</div>
                           	 		</div>
                            	</fieldset>
                           	<legend></legend>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default" title="Save">Save</button>
                                </div>
                            </div>
                           
						<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


