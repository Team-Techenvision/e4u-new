 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('editmeeting');?></div>
							</div>
							<div class="back pull-right">
								<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/meeting" title="Back">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_meeting_form_id');				
							echo form_open_multipart('', $attributes); ?>
                            <div class="form-group">
								<?php echo form_label('Course <span class="required">*</span>','course_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="course_list" class="form-control search_course_class"';
									$set_course = isset($_POST['course_list'])?$_POST['course_list']: (isset($meeting['course_id']) ? $meeting['course_id'] : '');
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
                            	<?php echo form_label('Meeting topic <span class="required">*</span>','meeting_topic',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php
									$set_name = isset($_POST['meeting_topic']) ? $_POST['meeting_topic'] : (isset($meeting['meeting_topic']) ? $meeting['meeting_topic'] : '');  
									echo form_input('meeting_topic', $set_name ,'placeholder= "Meeting topic" class="form-control" id="meeting-topic"'); 
                   					if(form_error('meeting_topic')) echo form_label(form_error('meeting_topic'), 'meeting_topic', array("id"=>"meeting_topic-error" , "class"=>"error")); ?>
                                </div>
							</div>
							
							<div class="form-group">
                            	<?php echo form_label('Description <span class="required">*</span>','meeting_description',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php   
									$set_description = isset($_POST['meeting_description']) ? $_POST['meeting_description'] : (isset($meeting['description']) ? $meeting['description'] : '');  
									 echo form_textarea('meeting_description',$set_description,'placeholder= "Description" class="form-control meeting_description" id="description"'); 
                   					if(form_error('meeting_description')) echo form_label(form_error('meeting_description'), 'meeting_description', array("id"=>"description-error" , "class"=>"error")); ?>
                                </div>
							</div>

							<div class="form-group">
                            	<?php echo form_label('Url <span class="required">*</span>','url',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php 
									$set_url = isset($_POST['url']) ? $_POST['url'] : (isset($meeting['url']) ? $meeting['url'] : '');  
									echo form_input('url',$set_url,'placeholder= "Url" class="form-control" id="url"'); 
                   					if(form_error('url')) echo form_label(form_error('url'), 'url', array("id"=>"url-error" , "class"=>"error")); ?>
                                </div>
							</div>

							<div class="form-group">
								<?php echo form_label('Meeting Date<span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-2">
									<?php 
									$set_date = isset($_POST['meeting_date'])?$_POST['meeting_date']: (isset($meeting['meeting_date']) ? $meeting['meeting_date'] : '');
									echo form_input('meeting_date',$set_date ,'placeholder= "Meeting Date" class="form-control" id="meeting_date"'); 
									if(form_error('meeting_date')) echo form_label(form_error('meeting_date'), 'meeting_date', array("id"=>"meeting_date-error" , "class"=>"error")); ?>
								</div>
							</div>

							<div class="form-group">
                           		<?php echo form_label('From time <span class="required">*</span>','From time',array('class'=>'col-sm-2 control-label')); ?>
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
								<?php 
								$set_hours = isset($_POST['hours_from'])?$_POST['hours_from']:(isset($meeting['hours_from']) ? $meeting['hours_from'] : '');
								echo form_dropdown('hours_from', $hours, $set_hours, $attributes);
                             	 ?><span>Hour(s)</span>
                             	<?php if(form_error('hours_from')) echo form_label(form_error('hours_from'), 'hours_from', array("id"=>"hours_from-error" , "class"=>"error")); ?>
								 <?php 
								 $set_mins = isset($_POST['mins_from'])?$_POST['mins_from']:(isset($meeting['mins_from']) ? $meeting['mins_from'] : '');
								 echo form_dropdown('mins_from', $mins,  $set_mins, $attributes);
                             	 ?><span>Minute(s)</span>
                             	 <?php if(form_error('mins_from')) echo form_label(form_error('mins_from'), 'mins_from', array("id"=>"mins_from-error" , "class"=>"error")); ?>
							 </div>
							</div>	
							
							<div class="form-group">
                           		<?php echo form_label('To time <span class="required">*</span>','To time',array('class'=>'col-sm-2 control-label')); ?>
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
								<?php 
								$set_hours = isset($_POST['hours_to'])?$_POST['hours_to']:(isset($meeting['hours_to']) ? $meeting['hours_to'] : '');
								echo form_dropdown('hours_to', $hours, $set_hours, $attributes);
                             	 ?><span>Hour(s)</span>
                             	<?php if(form_error('hours_to')) echo form_label(form_error('hours_to'), 'hours_to', array("id"=>"hours_to-error" , "class"=>"error")); ?>
								 <?php 
								 $set_mins = isset($_POST['mins_to'])?$_POST['mins_to']:(isset($meeting['mins_to']) ? $meeting['mins_to'] : '');
								 echo form_dropdown('mins_to', $mins,  $set_mins, $attributes);
                             	 ?><span>Minute(s)</span>
                             	 <?php if(form_error('mins_to')) echo form_label(form_error('mins_to'), 'mins_to', array("id"=>"mins_to-error" , "class"=>"error")); ?>
							 </div>
							</div>	

			 				<div class="form-group">
                            	<?php echo form_label('Status <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-10 topspace">
		                            <?php if($meeting['status'] ==1){?>
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


