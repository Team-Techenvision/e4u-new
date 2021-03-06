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
                            <div class="title"><?php echo "Add Standard Test";//$this->lang->line('addsurprisetest');?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_test" title="Back">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'questions_form');				
							echo form_open_multipart('', $attributes); ?>
							<div class="form-group">
								<?php echo form_label('Course <span class="required">*</span>','course_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="course_list" class="form-control search_course_class"';
									echo form_dropdown('course_list', $course_list, set_value('course_list'), $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error")); ?>
								</div>
							</div>


							<div class="form-group">
								<?php echo form_label('Class <span class="required">*</span>','search_class',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="search_class" class="form-control" multiple="multiple"';
									// $class_list[" "] ="select";
									echo form_multiselect('class_list[]','', isset($_POST['class_list'])?$_POST['class_list']:'', $js);
									if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error")); ?>
								</div>
							</div>



							<div class="form-group">
								<?php echo form_label('Test Name <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									 echo form_input('name',set_value('name'),'placeholder= "Name" class="form-control" id="name"');  
									if(form_error('name')) echo form_label(form_error('name'), 'name', array("id"=>"name-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Description <span class="required">*</span>','description',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									echo form_textarea('description',set_value('description'),'placeholder= "Description" class="form-control" id="description"'); 
									if(form_error('description')) echo form_label(form_error('description'), 'description', array("id"=>"description-error" , "class"=>"error")); ?>
								</div>
							</div>
                          	
                           <div class="form-group">
                           		<?php echo form_label('Duration <span class="required">*</span>','Duration',array('class'=>'col-sm-2 control-label')); ?>
                             	<?php 
                             	for($i=1; $i<=24;$i++){
                             		$hours[$i] = $i;
                             	}

                             	for($i=0; $i<60;$i++){
                             		$mins[$i] = $i;
                             	}
                             	$attributes = 'id="hours" class="form-control"';
										?>
								<div class="col-sm-4">
								<?php echo form_dropdown('hours', $hours, isset($_POST['hours'])?$_POST['hours']:'', $attributes);
                             	 ?><span>Hour(s)</span>
                             	<?php if(form_error('hours')) echo form_label(form_error('hours'), 'hours', array("id"=>"hours-error" , "class"=>"error")); ?>
                             	<?php echo form_dropdown('mins', $mins, isset($_POST['mins'])?$_POST['mins']:'', $attributes);
                             	 ?><span>Minute(s)</span>
                             	 <?php if(form_error('mins')) echo form_label(form_error('mins'), 'mins', array("id"=>"mins-error" , "class"=>"error")); ?>
                             </div>
							</div>


							<div class="form-group">
								<?php echo form_label('Exam Date <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-2">
									<?php echo form_input('from_date',set_value('from_date'),'placeholder= "From Date" class="form-control" id="from_date"'); 
									if(form_error('from_date')) echo form_label(form_error('from_date'), 'from_date', array("id"=>"from_date-error" , "class"=>"error")); ?>
								</div>
								<div class="col-sm-2">
								<?php echo form_input('to_date',set_value('to_date'),'placeholder= "To Date" class="form-control" id="to_date"');
								if(form_error('to_date')) echo form_label(form_error('to_date'), 'to_date', array("id"=>"to_date-error" , "class"=>"error")); ?>
								</div>
							</div>
			 				<div class="form-group">
                            	<?php echo form_label('Status <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4 topspace">
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


