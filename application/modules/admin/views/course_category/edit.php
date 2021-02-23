 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('edit_courese_categ');  ?></div>
							</div>
							<div class="back pull-right">
								<a title="Back" href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/course_category">Back</a>
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
                            	<?php echo form_label('Category <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('name', isset($_POST['name'])?$_POST['name']: (isset($course_category['category']) ? $course_category['category'] : '') ,'placeholder= "Category Name" class="form-control" id="name"'); 
                   					if(form_error('name')) echo form_label(form_error('name'), 'name', array("id"=>"name-error" , "class"=>"error")); ?>
                                 </div>
                             </div>
                             <div class="form-group">
                            	<?php echo form_label('Description <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_textarea('description',isset($_POST['description'])?htmlspecialchars_decode($_POST['description']): (isset($course_category['description']) ? htmlspecialchars_decode($course_category['description']) : ''),'placeholder= "Category Description" class="form-control" id="description"'); 
                   					if(form_error('description')) echo form_label(form_error('description'), 'description', array("id"=>"description-error" , "class"=>"error")); ?>
                                 </div>
							</div>
			 				<div class="form-group">
	                        	<?php echo form_label('Status <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
	                            <div class="col-sm-4 topspace">
									<?php if($course_category['status'] ==1){?>
									<?php echo form_radio('status', '1',TRUE,'class="align_radio"'); ?> 
									<?php echo form_label('Active','name',array('class'=>'align_label')); ?>
									<?php echo form_radio('status', '0','','class="align_radio"'); ?> 
									<?php echo form_label('Inactive','name',array('class'=>'align_label')); ?>
									<?php }else{?>
									<?php echo form_radio('status', '1','','class="align_radio"'); ?> 
									<?php echo form_label('Active','name',array('class'=>'align_label')); ?>
									<?php echo form_radio('status', '0',TRUE,'class="align_radio"'); ?> 
									<?php echo form_label('Inactive','name',array('class'=>'align_label')); ?>
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


