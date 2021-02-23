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
                            <div class="title"><?php echo $this->lang->line('addcourse');  ?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/course_plan">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'course_plan_form','enctype' => 'multipart/form-data');				
								echo form_open('', $attributes); ?>
                        <form class="form-horizontal">
                        	
                            <div class="form-group">
                            		<?php echo form_label('Name <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-5">
										<?php echo form_input('name',set_value('name'),'placeholder= "Name" class="form-control" id="name"'); 
                   						if(form_error('name')) echo form_label(form_error('name'), 'name', array("id"=>"name-error" , "class"=>"error")); ?>
                                 </div>
                            </div>



                            <div class="form-group">
                            	<?php echo form_label('Image <span class="required">*</span>','image',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php 
									echo form_upload(array('id' => 'image', 'name' => 'image', 'class' => 'banner-image-upload')); ?><small style="display:block">Allowed Types: gif,jpg,jpeg,png | Min:195*195 px</small> 
									<?php
                   					if(form_error('image')) echo form_label(form_error('image'), 'image', array("id"=>"banner-image-error" , "class"=>"error")); ?>									
                   					<?php if(isset($upload_error['error'])) { echo  form_label($upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                                </div>
							</div>



                         
							<div class="form-group">
								<?php echo form_label('Description <span class="required">*</span>','description',array('class' => 'col-sm-2 control-label')); ?>
								<div class="col-sm-5">
									<?php echo form_textarea('description',set_value('description'),'placeholder = "Description" class="form-control" id="description"');
									if(form_error('description')) echo form_label(form_error('description'), 'description', array("id"=>"description-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group <?php echo $class; ?>" id="price-div">
								<?php echo form_label('Price (INR)<span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-5">
									<?php echo form_input('price',set_value('price'),'placeholder= "Price in INR" class="form-control" id="price"');
									?>									
									<?php
									if(form_error('price')) echo form_label(form_error('price'), 'price', array("id"=>"price-error" , "class"=>"error")); ?>
								</div>
							</div>
						
							<div class="form-group">
								<?php echo form_label('Duration <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-5">
									<?php echo form_input('duration',set_value('duration'),'placeholder= "Duration in months" class="form-control" id="duration"');?>
									<?php
									if(form_error('duration')) echo form_label(form_error('duration'), 'duration', array("id"=>"duration-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="extra-class-subjects">
							<div class="form-group relevent_class">
								<?php echo form_label('Relevant Classes <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-5">
									<?php
									$js = 'id="relevant_classes_0" class="form-control relevant_classes"';
									echo form_dropdown('relevant_classes_0', $relevant_class, set_value('relevant_classes_0'), $js);
									if(form_error('relevant_classes_0')) echo form_label(form_error('relevant_classes_0'), 'relevant_classes_0',array("id"=>"relevant_classes_0" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group relevent_subject">
								<?php echo form_label('Relevant Subjects ','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-5">
									<?php
									$js = 'id="relevant_subjects" class="form-control relevant_subjects"';
									echo form_multiselect('relevant_subjects[]', $relevant_subject, set_value('relevant_subjects[]'), $js);
									if(form_error('relevant_subjects')) echo form_label(form_error('relevant_subjects'), 'relevant_subjects', array("id"=>"relevant-subjects-error" , "class"=>"error")); ?>
								</div>
							</div>
							</div>
							<?php $set_val = isset($_POST['class_counts']) ? $_POST['class_counts'] : 0; ?>
							<input type="hidden" name="class_counts" id="class_counts" value="<?php echo $set_val; ?>"/>
							<div class="add-more-controllers">
							<?php 
								$count = $this->input->post('class_counts');
								for($i = 1;$i<=$count; $i++){
									?>
							<div class="form-group relevent_class remove_class<?php echo $i; ?>">
								<?php echo form_label('Relevant Classes <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-5">
									<?php
									$js = 'id="relevant_classes_'.$i.'" class="form-control relevant_classes"';
									echo form_dropdown('relevant_classes_'.$i.'', $relevant_class, set_value('relevant_classes_'.$i.''), $js);
									if(form_error("relevant_classes_".$i)) echo form_label(form_error("relevant_classes_".$i), "relevant_classes_".$i,array("id"=>"relevant_classes_".$i , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group relevent_subject remove_class<?php echo $i; ?>">
								<?php echo form_label('Relevant Subjects <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-5">
									<?php
									$js = 'id="relevant_subjects" class="form-control relevant_subjects"';
									echo form_multiselect('relevant_subjects[]', $relevant_subject, set_value('relevant_subjects[]'), $js);
									if(form_error('relevant_subjects')) echo form_label(form_error('relevant_subjects'), 'relevant_subjects', array("id"=>"relevant-subjects-error" , "class"=>"error")); ?>
									<?php $str = 'remove_class'.$i; ?>
									<a style="color:#F90202" class='delete_relevant_class delete_relevant_class1' href="javascript:delete_relevant_class('<?php echo $str; ?>',this);"><span class="icon glyphicon glyphicon-trash" ></span> Delete</a>
								</div>
							</div>
							<?php
								}
							?>
							</div>

							
			 				<div class="form-group">
                            	<?php echo form_label('Status <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-5 topspace">
								<div style=""><a   href="javascript:void(0)" id="add-more-course" class="add-more-course pull-right"><span class="glyphicon glyphicon-plus"></span>Add More</a></div>
									<?php echo form_radio('status', '1',TRUE,'class="align_radio"'); ?> 
									<?php echo form_label('Active','name',array('class'=>'align_label')); ?>
									<?php echo form_radio('status', '0','','class="align_radio"'); ?> 
									<?php echo form_label('Inactive','name',array('class'=>'align_label')); ?>
                                 </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Save</button>
                                </div>
                            </div>
                            </form>
								<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

