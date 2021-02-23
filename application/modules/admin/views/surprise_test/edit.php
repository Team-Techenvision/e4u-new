 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
        <div class="page-title"></div>
         <div class="row">
            <div class="col-xs-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title"><?php echo "Edit Standard Test";//$this->lang->line('editsurprisetest');?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_test" title="Back">Back</a>
						</div>
                    </div>
                    <input type="hidden" name="uri_segment" id="uri_segment" value="<?php echo $this->uri->segment(2); ?>"/>
                     <?php if($_POST) { ?> 
                    	<input type="hidden" name="window_post" id="window_post_set" value="1"/>
                    <?php }else{ ?>
                    	<input type="hidden" name="window_post" id="window_post_set" value="0"/>
                    <?php } ?>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_surprise_test_form');				
								echo form_open_multipart('', $attributes); ?>

                        	<div class="form-group">
								<?php echo form_label('Course <span class="required">*</span>','course_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="course_list" class="form-control search_course_class"';
									$set_course = isset($_POST['course_list'])?$_POST['course_list']: (isset($surprise_test->course_id) ? $surprise_test->course_id : '');
									echo form_dropdown('course_list', $course_list,$set_course, $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error")); ?>
								</div>
							</div>

							<div class="form-group">
								<?php echo form_label('Class <span class="required">*</span>','search_class',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="search_class" class="form-control" multiple="multiple"';
									//print_r($class_list);die;
									$set_class = isset($_POST['class_list'])?$_POST['class_list']: (isset($sel_class_list) ? $sel_class_list : '');
									echo form_multiselect('class_list[]', $class_list, $set_class, $js);
									if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error")); ?>
								</div>
							</div>


							<div class="form-group">
								<?php echo form_label('Test Name <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									 echo form_input('name',isset($_POST['name'])?$_POST['name']: (isset($surprise_test->test_name) ? $surprise_test->test_name : ''),'placeholder= "Name" class="form-control" id="name"');  
									if(form_error('name')) echo form_label(form_error('name'), 'name', array("id"=>"name-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Description <span class="required">*</span>','description',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									echo form_textarea('description',isset($_POST['description'])?$_POST['description']: (isset($surprise_test->test_description) ? $surprise_test->test_description : ''),'placeholder= "Description" class="form-control" id="description"'); 
									if(form_error('description')) echo form_label(form_error('description'), 'description', array("id"=>"description-error" , "class"=>"error")); ?>
								</div>
							</div> 
							
                            
                            <div id="time"  class="form-group">  
                            	<?php echo form_label('Duration <span class="required">*</span>','Duration',array('class'=>'col-sm-2 control-label')); ?>
                            	<div class="col-sm-4">
								<?php 
								for($i=1; $i<=24;$i++){
                             		$hours[$i] = $i;
                             	}

                             	for($i=0; $i<60;$i++){
                             		$mins[$i] = $i;
                             	}

                             	$attributes = 'id="hours" class="form-control"';
								echo form_dropdown('hours', $hours, isset($_POST['hours'])?$_POST['hours']:(isset($surprise_test->hours) ? $surprise_test->hours : ''), $attributes);	?>
                             	<span>Hour(s)</span> 
                             	<?php if(form_error('hours')) echo form_label(form_error('hours'), 'hours', array("id"=>"hours-error" , "class"=>"error")); ?>

                             	<?php echo form_dropdown('mins', $mins, isset($_POST['mins'])?$_POST['mins']:(isset($surprise_test->mins) ? $surprise_test->mins : ''), $attributes);	?>
                             	<span>Minute(s)</span> 
                             	<?php if(form_error('mins')) echo form_label(form_error('mins'), 'mins', array("id"=>"mins-error" , "class"=>"error")); ?>

                             	</div>
							</div>

							<div class="form-group">
								<?php echo form_label('Exam Date <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-2">
									<?php $from_date = date( ADMIN_DATE_FORMAT, strtotime($surprise_test->from_date));?>
									<?php echo form_input('from_date',isset($_POST['from_date'])?$_POST['from_date']: (isset($from_date) ? $from_date : ''),'placeholder= "From Date" class="form-control" id="from_date"'); ?>
									<?php if(form_error('from_date')) echo form_label(form_error('from_date'), 'from_date', array("id"=>"from_date-error" , "class"=>"error")); ?>
								</div>
								<div class="col-sm-2">
									<?php $to_date = date( ADMIN_DATE_FORMAT, strtotime($surprise_test->to_date));?>
									<?php echo form_input('to_date',isset($_POST['to_date'])?$_POST['to_date']: (isset($to_date) ? $to_date : ''),'placeholder= "To Date" class="form-control" id="to_date"');
									if(form_error('to_date')) echo form_label(form_error('to_date'), 'to_date', array("id"=>"to_date-error" , "class"=>"error")); ?>
								</div>
							</div>
			 				<div class="form-group">
	                        	<?php echo form_label('Status <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
	                            <div class="col-sm-4 topspace">
									<?php if(($surprise_test->status) ==1){?>
									<?php echo form_radio('status', '1',TRUE,array('class'=>'align_radio', 'id'=>'active')); ?> 
									<?php echo form_label('Active','active',array('class'=>'align_label')); ?>
									<?php echo form_radio('status', '0','',array('class'=>'align_radio', 'id'=>'inactive')); ?> 
									<?php echo form_label('Inactive','inactive',array('class'=>'align_label')); ?>
									<?php }else{?>
									<?php echo form_radio('status', '1','',array('class'=>'align_radio', 'id'=>'active')); ?> 
									<?php echo form_label('Active','active',array('class'=>'align_label')); ?>
									<?php echo form_radio('status', '0',TRUE,array('class'=>'align_radio', 'id'=>'inactive')); ?> 
									<?php echo form_label('Inactive','inactive',array('class'=>'align_label')); ?>
									<?php } ?>
                             	</div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default form-submit" title="Save">Save</button>
                                </div>
                            </div>
						<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


