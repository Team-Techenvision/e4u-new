 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('editcmspage');?></div>
							</div>
							<div class="back pull-right">
								<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/pages" title="Back">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_teacher_form');				
							echo form_open('', $attributes); ?>
                            <div class="form-group">
                            	<?php echo form_label('Page Title <span class="required">*</span>','title',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-8">
									<?php echo form_input('title', isset($_POST['title'])?$_POST['title']: (isset($pages['title']) ? $pages['title'] : '') ,'placeholder= "Title" class="form-control" id="title"'); 
                   					if(form_error('title')) echo form_label(form_error('title'), 'title', array("id"=>"title-error" , "class"=>"error")); ?>
                                </div>
                             </div>
                             <legend><?php echo form_label('SEO:','name'); ?></legend>
					 		 <fieldset>
								 <div class="form-group">
									<?php echo form_label('SEO Title <span class="required">*</span>','seo_title',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-8">
										<?php echo form_input('seo_title',isset($_POST['seo_title'])?$_POST['seo_title']: (isset($pages['seo_title']) ? $pages['seo_title'] : ''),'placeholder= "SEO Title" class="form-control" id="seo_title"');
										if(form_error('seo_title')) echo form_label(form_error('seo_title'), 'seo_title', array("id"=>"seo_title-error" , "class"=>"error")); ?>
									</div>
								</div>
		                         <div class="form-group">	
		                        	<?php echo form_label('Meta Keyword <span class="required">*</span>','meta_key',array('class'=>'col-sm-2 control-label')); ?>
		                            <div class="col-sm-8">
										<?php echo form_input('meta_key', isset($_POST['meta_key'])?$_POST['meta_key']: (isset($pages['meta_keywords']) ? $pages['meta_keywords'] : '') ,'placeholder= "Ex:Keyword1,Keyword2,Keyword3,..." class="form-control" id="meta_key"'); 
		               					if(form_error('meta_key')) echo form_label(form_error('meta_key'), 'meta_key', array("id"=>"meta_key-error" , "class"=>"error")); ?>
		                            </div>
		                         </div>
		                         <div class="form-group">
		                        	<?php echo form_label('Meta Description <span class="required">*</span>','description',array('class'=>'col-sm-2 control-label')); ?>
		                            <div class="col-sm-8">
										<?php echo form_textarea('description',isset($_POST['description'])?$_POST['description']: (isset($pages['meta_description']) ? $pages['meta_description'] : ''),'placeholder="Meta Description" class="form-control" id="description"'); 
		               					if(form_error('description')) echo form_label(form_error('description'), 'description', array("id"=>"description-error" , "class"=>"error")); ?>
		                            </div>
								</div>
							</fieldset>
							<legend></legend>
                            <div class="form-group">
                            	<?php echo form_label('Content <span class="required">*</span>','content',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-8">
									<?php echo form_textarea('content',isset($_POST['content'])?$_POST['content']: (isset($pages['content']) ? $pages['content'] : ''),'class="form-control email_content" id="email_content"'); 
                   					if(form_error('content')) echo form_label(form_error('content'), 'content', array("id"=>"content-error" , "class"=>"error")); ?>
                                </div>
							</div>
			 				<div class="form-group">
                            	<?php echo form_label('Status <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-8 topspace">
		                            <?php if($pages['status'] ==1){?>
										<?php echo form_radio('status', '1',TRUE,'class="align_radio" id="active"'); ?> 
										<?php echo form_label('Active','active',array('class'=>'align_label')); ?>
										<?php echo form_radio('status', '0','','class="align_radio" id="inactive"'); ?> 
										<?php echo form_label('Inactive','inactive',array('class'=>'align_label')); ?>
									<?php }else{?>
									<?php echo form_radio('status', '1','','class="align_radio" id="active"'); ?> 
										<?php echo form_label('Active','active',array('class'=>'align_label')); ?>
										<?php echo form_radio('status', '0',TRUE,'class="align_radio" id="inactive"'); ?> 
										<?php echo form_label('Inactive','inactive',array('class'=>'align_label')); ?>
									<?php } ?>
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


