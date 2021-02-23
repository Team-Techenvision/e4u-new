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
                            <div class="title"> 
                            	<span><?php echo $this->lang->line('copy_content_from');  ?></span>
                            	<span style="margin-left:530px;"><?php echo $this->lang->line('copy_content_to');  ?></span>
                            </div>
                            
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'copy_content_form');				
								echo form_open('', $attributes); ?>
                        <div class="col-xs-6">   
									<div class="form-group">
										<?php echo form_label('Course <span class="required">*</span>','search_course_from',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php									
											$js = 'id="search_course_from" class="form-control"';
											echo form_dropdown('course_list', $course_list, isset($_POST['course_list'])?$_POST['course_list']:'', $js);
											if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error")); ?>
										</div>
									</div>
							  
									<div class="form-group">
										<?php echo form_label('Class ','search_class_from',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_class_from" class="form-control"';
											echo form_dropdown('class_list', $class_list, isset($_POST['class_list'])?$_POST['class_list']:'', $js);
											if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error")); ?>
										</div>
									</div>
							  
									<div class="form-group">
										<?php echo form_label('Subject ','search_subject_from',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_subject_from" class="form-control"';
											echo form_dropdown('subject_list', $subject_list,  isset($_POST['subject_list'])?$_POST['subject_list']:'', $js);
											if(form_error('subject_list')) echo form_label(form_error('subject_list'), 'subject_list', array("id"=>"subject_list-error" , "class"=>"error")); ?>
										</div>
									</div>
									<div class="form-group">
										<?php echo form_label('Chapters ','search_chapter_from',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_chapter_from" class="form-control"';
											echo form_dropdown('chapter_list', $chapter_list, isset($_POST['chapter_list'])?$_POST['chapter_list']:'', $js);
											if(form_error('chapter_list')) echo form_label(form_error('chapter_list'), 'chapter_list', array("id"=>"chapter_list-error" , "class"=>"error")); ?>
										</div>
									</div>
									<div class="form-group">
										<?php echo form_label('Levels ','search_level_from',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_level_from" class="form-control"';
											echo form_dropdown('level_list', $level_list,  isset($_POST['level_list'])?$_POST['level_list']:'', $js);
											if(form_error('level_list')) echo form_label(form_error('level_list'), 'level_list', array("id"=>"level_list-error" , "class"=>"error")); ?>
										</div>
									</div>
									<div class="form-group">
										<?php echo form_label('Sets ','search_set_from',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_set_from" class="form-control"';
											echo form_dropdown('set_list', $set_list,  isset($_POST['set_list'])?$_POST['set_list']:'', $js);
											if(form_error('set_list')) echo form_label(form_error('set_list'), 'set_list', array("id"=>"set_list-error" , "class"=>"error")); ?>
										</div>
									</div>																
									<div class="form-group <?php echo ($objective_question_count==0 and $subjective_question_count==0)?'element-hide':'';	?>" id="questions">
										<?php echo form_label('Questions ','',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">									 	
											<?php	
												$objcl = ($objective_question_count==0)?'element-hide':'';
												$subcl = ($subjective_question_count==0)?'element-hide':'';
												$objchk = ($objective_question!="")?'checked':'';
												$subchk = ($subjective_question!="")?'checked':'';																				
												echo "<span id='objective_question' class='$objcl'>";
												echo form_checkbox("objective_question",'1', $objchk, 'id="obq"');
												echo form_label("Objective Question"); 
												echo "<br>"; 
												echo "</span>";												
												echo "<span id='subjective_question' class='$subcl'>";
												echo form_checkbox("subjective_question",'2', $subchk, 'id="sbq"');
												echo form_label("Subjective Question");
												echo "</span>";
											?>
										</div>
									</div>
									
									<div class="form-group">
										<?php echo form_label('Materials ','materials_from',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php											
											$js = 'id="materials_from" class="form-control"';
											echo form_dropdown('materials', $materials,  isset($_POST['materials'])?$_POST['materials']:'', $js);
											if(form_error('materials')) echo form_label(form_error('materials'), 'materials', array("id"=>"materials-error" , "class"=>"error")); ?>
										</div>
									</div>
									
									<div class="form-group">
                        		<?php echo form_label('Write method','',array('class'=>'col-sm-2 control-label')); ?>
                            	<div class="col-sm-10 topspace">
                            		<?php echo form_radio('status', '2',TRUE,'class="align_radio" id="inactive"'); ?> 
											<?php echo form_label('Copy','inactive',array('class'=>'align_label')); ?>
											<?php echo form_radio('status', '1','','class="align_radio" id="active"'); ?> 
											<?php echo form_label('Overwrite','active',array('class'=>'align_label')); ?>											
						            </div>
                        	</div>
								</div>
								
								
								 <div class="col-xs-6"> 
									<div class="form-group">
										<?php echo form_label('Course <span class="required">*</span>','search_course_to',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php									
											$js = 'id="search_course_to" class="form-control"';
											echo form_dropdown('course_list_to', $course_list_to, isset($_POST['course_list_to'])?$_POST['course_list_to']:'', $js);
											if(form_error('course_list_to')) echo form_label(form_error('course_list_to'), 'course_list_to', array("id"=>"course_list_to-error" , "class"=>"error")); ?>
										</div>
									</div>
							  	
									<div class="form-group">
										<?php echo form_label('Class ','search_class_to',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_class_to" class="form-control"';
											echo form_dropdown('class_list_to', $class_list_to, isset($_POST['class_list_to'])?$_POST['class_list_to']:'', $js);
											if(form_error('class_list_to')) echo form_label(form_error('class_list_to'), 'class_list_to', array("id"=>"class_list_to-error" , "class"=>"error")); ?>
										</div>
									</div>
							  
									<div class="form-group">
										<?php echo form_label('Subject ','search_subject_to',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_subject_to" class="form-control"';
											echo form_dropdown('subject_list_to', $subject_list_to,  isset($_POST['subject_list_to'])?$_POST['subject_list_to']:'', $js);
											if(form_error('subject_list_to')) echo form_label(form_error('subject_list_to'), 'subject_list_to', array("id"=>"subject_list_to-error" , "class"=>"error")); ?>
										</div>
									</div>								
									<div class="form-group">
										<?php echo form_label('Chapters ','search_chapter_to',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_chapter_to" class="form-control"';
											echo form_dropdown('chapter_list_to', $chapter_list_to, isset($_POST['chapter_list_to'])?$_POST['chapter_list_to']:'', $js);
											if(form_error('chapter_list_to')) echo form_label(form_error('chapter_list_to'), 'chapter_list_to', array("id"=>"chapter_list_to-error" , "class"=>"error")); ?>
										</div>
									</div>
									<div class="form-group">
										<?php echo form_label('Levels ','search_level_to',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_level_to" class="form-control"';
											echo form_dropdown('level_list_to', $level_list_to,  isset($_POST['level_list_to'])?$_POST['level_list_to']:'', $js);
											if(form_error('level_list_to')) echo form_label(form_error('level_list_to'), 'level_list_to', array("id"=>"level_list_to-error" , "class"=>"error")); ?>
										</div>
									</div>
									<div class="form-group">
										<?php echo form_label('Sets ','search_set_to',array('class'=>'col-sm-2 control-label')); ?>
										<div class="col-sm-4">
											<?php
											$js = 'id="search_set_to" class="form-control"';
											echo form_dropdown('set_list_to', $set_list_to,  isset($_POST['set_list_to'])?$_POST['set_list_to']:'', $js);
											if(form_error('set_list_to')) echo form_label(form_error('set_list_to'), 'set_list_to', array("id"=>"set_list_to-error" , "class"=>"error")); ?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
                              <button type="submit" class="btn btn-default" title="submit">Submit</button>
                           </div>		
								</div>								
								<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


