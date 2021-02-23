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
                            <div class="title"><?php echo $this->lang->line('addchapters');  ?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/chapters" title="Back">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'chapters_form');				
								echo form_open('', $attributes); ?>
                            
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
								<?php echo form_label('Class <span class="required">*</span>','class_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="class_list" class="form-control"';
									echo form_dropdown('class_list', $class_list, isset($_POST['class_list'])?$_POST['class_list']:'', $js);
									if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Subject <span class="required">*</span>','subject_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="subject_list" class="form-control"';
									echo form_dropdown('subject_list', $subject_list, isset($_POST['subject_list'])?$_POST['subject_list']:'', $js);
									if(form_error('subject_list')) echo form_label(form_error('subject_list'), 'subject_list', array("id"=>"subject_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="add-more-name">
								<?php 
									$post_name = $this->input->post('name');
									$total_name = (count($post_name) > 1) ? count($post_name) : 1;
									for($i=0;$i<$total_name;$i++){
										$style = ($i>0) ? 'style="margin-top:10px;"' : '';?>
									<div class="template<?php echo $i; ?>">
										<div class="form-group">
						            		<?php echo form_label('Name <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
						                    <div class="col-sm-4">
											<?php
												echo form_input('name[]',set_value('name['.$i.']'),'placeholder= "Name" '.$style.' class="form-control check_name extra-name extra-name'.$i.'" id="name"'); ?> 
					   							<?php if(form_error('name['.$i.']')) echo form_label(form_error('name['.$i.']'), 'name['.$i.']', array("id"=>"name-error$i" , "class"=>"error"));
						   						?>
						                    </div>                                 
						                </div>
						            <div class="form-group">
				                  	<?php echo form_label('Order <span class="required">*</span>','order',array('class'=>'col-sm-2 control-label')); ?>
				                     <div class="col-sm-4">
												<?php echo form_input('order[]',set_value('order['.$i.']'),'placeholder= "Order" class="form-control check_order" id="order"'); 
				             				if(form_error('order['.$i.']')) echo form_label(form_error('order['.$i.']'), 'order['.$i.']', array("id"=>"order-error$i" , "class"=>"error")); ?>
				                     </div>
										</div>
										<div class="form-group">
						                	<?php echo form_label('Description ','description',array('class'=>'col-sm-2 control-label')); ?>
											<div class="col-sm-4 ">    
												<?php echo form_textarea("description[]",set_value('description['.$i.']'),"placeholder='Description' style='height:100px' id='description' class='form-control'"); ?> 
												<?php if(form_error('description['.$i.']')) echo form_label(form_error('description['.$i.']'), 'description['.$i.']', array("id"=>"description-error$i" , "class"=>"error"));
												if($i>0){ ?>	<a style="color:red;margin-top:5px" href="javascript:delete_row('<?php echo $i; ?>');" row="<?php echo $i; ?>" class="delete-name pull-right delete<?php echo $i; ?>"><span class="icon glyphicon glyphicon-trash" ></span>Remove </a>
												<?php } ?>                                
						              		</div>
						           		</div>
									</div>
								<?php } ?>
							</div>
			 				<div class="form-group">
						    	<?php echo form_label('Status <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
						        <div class="col-sm-6 topspace">
									<a href="" id="add-more" class="add-more pull-right" title="Add More"><span class="glyphicon glyphicon-plus"></span> Add More</a>
									<?php echo form_radio('status', '1',TRUE,'class="align_radio"'); ?> 
									<?php echo form_label('Active','name',array('class'=>'align_label')); ?>
									<?php echo form_radio('status', '0','','class="align_radio"'); ?> 
									<?php echo form_label('Inactive','name',array('class'=>'align_label')); ?>
						        </div>
						    </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" title="Save" class="btn btn-default">Save</button>
                                </div>
                            </div>
							<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


