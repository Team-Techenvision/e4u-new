 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
        <div class="page-title">
        </div>
         <div class="row">
            <div class="col-xs-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title"><?php echo $this->lang->line('editemailtemplate');?></div>
                        </div>
                        <div class="back pull-right">
									<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/email_templates" title="Back">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_teacher_form');				
								echo form_open('', $attributes); ?>
                        <form class="form-horizontal">
                            <div class="form-group">
                            		<?php echo form_label('Name <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-10">
												<?php echo form_input('name', $email_templates['name'] ,'disabled placeholder= "Name" class="form-control" id="name"'); 
                   						if(form_error('name')) echo form_label(form_error('name'), 'name', array("id"=>"name-error" , "class"=>"error")); ?>
                                 </div>
                            </div>
                            <div class="form-group">
                            		<?php echo form_label('Subject <span class="required">*</span>','subject', array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-10">
												<?php echo form_input('subject', ($post?$this->input->post('subject'):$email_templates['subject'])  ,'placeholder= "Subject" class="form-control" id="subject"'); 
                   						if(form_error('subject')) echo form_label(form_error('subject'), 'subject', array("id"=>"subject-error" , "class"=>"error")); ?>
                                </div>
                            </div>
                            <div class="form-group">
                            		<?php echo form_label('Description <span class="required">*</span>','description',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-10">
												<?php echo form_input('description', ($post?$this->input->post('description'):$email_templates['description'])  ,'placeholder= "description" class="form-control" id="description"'); 
                                		if(form_error('description')) echo form_label(form_error('description'), 'description', array("id"=>"description-error" , "class"=>"error"));?>
										  </div>
                            </div>
                             <div class="form-group">
                            		<?php echo form_label('Email Content <span class="required">*</span>','email_content',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-10">
												<?php echo form_textarea('email_content', ($post?$this->input->post('email_content'):$email_templates['email_content'])  ,'placeholder= "Email Content" class="form-control email_content" id="email_content"'); 
                                		if(form_error('email_content')) echo form_label(form_error('email_content'), 'email_content', array("id"=>"email_content-error" , "class"=>"error"));?>
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


