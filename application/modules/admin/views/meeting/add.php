 <!-- Main Content -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('addmeeting');?></div>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_meeting_form');				
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
                            	<?php echo form_label('Meeting topic <span class="required">*</span>','meeting_topic',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('meeting_topic',set_value('meeting-topic'),'placeholder= "Meeting topic" class="form-control" id="meeting-topic"'); 
                   					if(form_error('meeting_topic')) echo form_label(form_error('meeting_topic'), 'meeting_topic', array("id"=>"meeting_topic-error" , "class"=>"error")); ?>
                                </div>
							</div>
					
							<div class="form-group">
                            	<?php echo form_label('Description <span class="required">*</span>','meeting_description',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php  $set_description = isset($_POST['meeting_description']) ? $_POST['meeting_description']:'';
									 echo form_textarea('meeting_description',$set_description,'placeholder= "Description" class="form-control meeting_description" id="description"'); 
                   					if(form_error('meeting_description')) echo form_label(form_error('meeting_description'), 'meeting_description', array("id"=>"description-error" , "class"=>"error")); ?>
                                </div>
							</div>
						
							<div class="form-group">
                            	<?php echo form_label('Url <span class="required">*</span>','url',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('url',set_value('url'),'placeholder= "Url" class="form-control" id="url"'); 
                   					if(form_error('url')) echo form_label(form_error('url'), 'url', array("id"=>"url-error" , "class"=>"error")); ?>
                                </div>
							</div>

							<div class="form-group">
								<?php echo form_label('Meeting Date<span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-2 cc_cursor">
									<input type="date" name="meeting_date" value="" placeholder="Meeting Date" class="form-control" id="txtDate">
								</div>
							</div>

							<div class="form-group">
                           		<?php echo form_label('From time <span class="required">*</span>','Duration',array('class'=>'col-sm-2 control-label')); ?>
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
								<?php echo form_dropdown('hours_from', $hours, isset($_POST['hours_from'])?$_POST['hours_from']:'', $attributes);
                             	 ?><span>Hour(s)</span>
                             	<?php if(form_error('hours_from')) echo form_label(form_error('hours_from'), 'hours_from', array("id"=>"hours_from-error" , "class"=>"error")); ?>
                             	<?php echo form_dropdown('mins_from', $mins, isset($_POST['mins_from'])?$_POST['mins_from']:'', $attributes);
                             	 ?><span>Minute(s)</span>
                             	 <?php if(form_error('mins_from')) echo form_label(form_error('mins_from'), 'mins_from', array("id"=>"mins_from-error" , "class"=>"error")); ?>
                             </div>
							</div>

							<div class="form-group">
                           		<?php echo form_label('To time <span class="required">*</span>','Duration',array('class'=>'col-sm-2 control-label')); ?>
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
								<?php echo form_dropdown('hours_to', $hours, isset($_POST['hours_to'])?$_POST['hours_to']:'', $attributes);
                             	 ?><span>Hour(s)</span>
                             	<?php if(form_error('hours_to')) echo form_label(form_error('hours_to'), 'hours_to', array("id"=>"hours_to-error" , "class"=>"error")); ?>
                             	<?php echo form_dropdown('mins_to', $mins, isset($_POST['mins_to'])?$_POST['mins_to']:'', $attributes);
                             	 ?><span>Minute(s)</span>
                             	 <?php if(form_error('mins_to')) echo form_label(form_error('mins_to'), 'mins_to', array("id"=>"mins_to-error" , "class"=>"error")); ?>
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


										<script type="text/javascript">
											$(function(){
												var dtToday = new Date();
												
												var month = dtToday.getMonth() + 1;
												var day = dtToday.getDate();
												var year = dtToday.getFullYear();
												if(month < 10)
													month = '0' + month.toString();
												if(day < 10)
													day = '0' + day.toString();
												
												var maxDate = year + '-' + month + '-' + day;										
												$('#txtDate').attr('min', maxDate);
											});
										</script>