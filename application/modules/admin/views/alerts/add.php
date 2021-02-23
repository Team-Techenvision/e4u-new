 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
        <div class="page-title"></div>
         <div class="row">
            <div class="col-xs-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title"><?php echo $this->lang->line('addalert');  ?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/alerts" title="Back">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'alerts_form');				
								echo form_open_multipart('', $attributes); ?>
                            
							<div class="form-group">
								<?php echo form_label('Course <span class="required">*</span>','course_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									
									$js = 'id="course_list" class="form-control"';
									echo form_dropdown('course_list', $course_list, isset($_POST['course_list'])?$_POST['course_list']:'', $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('User','',array('class'=>'col-sm-2 control-label')); ?>
								
								<div class="col-sm-4">				
									<?php 
											if($_POST['users']){
												$individual = ($_POST['users']==1)?TRUE:FALSE;
												$all_users = ($_POST['users']==2)?TRUE:FALSE;
											}else{												
												$individual = FALSE;
												$all_users = TRUE;
											}											
									?>		
									<?php 									
									echo form_radio("users", "1", $individual, "id=rad1");
									echo form_label("individual", "rad1");
									echo '&nbsp;&nbsp;&nbsp;';
									echo form_radio("users", "2", $all_users, "id=rad2");
									echo form_label("all users", "rad2");
									$js = 'id="user_list" class="form-control user_list"';															
									$set_user = isset($_POST['user_list'])?$_POST['user_list']: '0';
									echo form_multiselect('user_list[]', $user_list, $set_user, $js);				 ?>
								</div>
							</div>
							<div class="form-group">
                            		<?php echo form_label('Title <span class="required">*</span>','title',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('title',set_value('title'),'placeholder= "Title" class="form-control" id="title"'); ?> 
                   					<?php if(form_error('title')) echo form_label(form_error('title'), 'title', array("id"=>"title-error" , "class"=>"error"));?>
                                </div>
                            </div>
                            <div class="form-group">
                            		<?php echo form_label('Short Description <span class="required">*</span>','description',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_textarea('description',set_value('description'),'placeholder= "Description" class="form-control" id="description"'); ?> 
                   					<?php if(form_error('description')) echo form_label(form_error('description'), 'description', array("id"=>"description-error" , "class"=>"error"));?>
                                </div>
                            </div>
                            <div class="form-group">
                            		<?php echo form_label('Attachment','attachment_alert',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_upload(array('id' => 'attachment_alert', 'name' => 'attachment_alert', 'class' => 'attachment-alert-upload')); ?> 
											<small>Please upload .pdf,.doc,.mp3,.docx,.mp4,.swf,.rar or .zip files only <br> Maxiumum upload file size is 2 MB</small>
                   					<?php if(isset($upload_error['error'])) { echo  form_label($upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                   					<?php if(isset($upload_error['error1'])) { echo  form_label('<p>'.$upload_error['error1'].'</p>','upload-error',array('class'=>'error'));  } ?>
                                 </div>
                            </div>
			 				<div class="form-group">
                            	<?php echo form_label('Status <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-5 topspace">
									<?php echo form_radio('status', '1',TRUE,'class="align_radio" id="active"'); ?> 
									<?php echo form_label('Active','active',array('class'=>'align_label')); ?>
									<?php echo form_radio('status', '0','','class="align_radio" id="inactive"'); ?> 
									<?php echo form_label('Inactive','inactive',array('class'=>'align_label')); ?>
                                 </div>
                            </div>
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


