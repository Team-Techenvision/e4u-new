 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
        <div class="page-title">
            <!--<span class="title">Sections</span>
            <div class="description">with jquery Datatable for display data with most usage functional. such as search, ajax loading, pagination, etc.</div> -->
        </div>
         <div class="row">
            <div class="col-xs-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title"><?php echo $this->lang->line('editsets');  ?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/sets" title="Back">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'sets_form');				
								echo form_open('', $attributes); ?>

                        	<div class="form-group">
								<?php echo form_label('Course <span class="required">*</span>','search_course',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									
									$js = 'id="course_list" class="form-control"';
									$set_course = isset($_POST['course_list'])?$_POST['course_list']: (isset($sets->course_id) ? $sets->course_id : '');
									echo form_dropdown('course_list', $course_list,$set_course, $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Class <span class="required">*</span>','search_class',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="class_list" class="form-control"';
									$set_class = isset($_POST['class_list'])?$_POST['class_list']: (isset($sets->class_id) ? $sets->class_id : '');
									echo form_dropdown('class_list', $class_list, $set_class, $js);
									if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Subject <span class="required">*</span>','search_subject',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="subject_list" class="form-control"';
									$set_subject = isset($_POST['subject_list'])?$_POST['subject_list']: (isset($sets->subject_id) ? $sets->subject_id : '');
									echo form_dropdown('subject_list', $subject_list, $set_subject, $js);
									if(form_error('subject_list')) echo form_label(form_error('subject_list'), 'subject_list', array("id"=>"subject_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Chapters <span class="required">*</span>','search_chapter',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php  
									//echo "<pre>";
									//print_r($chapter_list); die;
									
									$js = 'id="chapter_list" class="form-control"';
									$set_chapter = isset($_POST['chapter_list'])?$_POST['chapter_list']: (isset($sets->chapter_id) ? $sets->chapter_id : '');
									echo form_dropdown('chapter_list', $chapter_list, $set_chapter , $js);
									if(form_error('chapter_list')) echo form_label(form_error('chapter_list'), 'chapter_list', array("id"=>"chapter-list-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Level <span class="required">*</span>','search_level',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php  
									//echo "<pre>";
									//print_r($level_list); 
									//echo $sets->level_id;
									
									$js = 'id="level_list" class="form-control"';
									$set_level = isset($_POST['level_list']) ? $_POST['level_list'] : (isset($sets->level_id) ? $sets->level_id : '');
									echo form_dropdown('level_list', $level_list, $set_level , $js);
									if(form_error('level_list')) echo form_label(form_error('level_list'), 'level_list', array("id"=>"level-list-error" , "class"=>"error")); ?>
								</div>
							</div>
                            <div class="form-group">
                            	<?php echo form_label('Name <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
                            
									<?php 
									echo form_input('name', isset($_POST['name'])?$_POST['name']: (isset($sets->name) ? $sets->name : '') ,'placeholder= "Name" class="form-control" id="name"'); 
		               				if(form_error('name')) echo form_label(form_error('name'), 'name', array("id"=>"name-error" , "class"=>"error")); ?>
                                 </div>
							</div>
							<!-- modified -->
							<div class="form-group">
                     	<?php echo form_label('Order <span class="required">*</span>','order',array('class'=>'col-sm-2 control-label')); ?>
                     	<div class="col-sm-4">                     		
                        	<?php echo form_input('order', isset($_POST['order'])?$_POST['order']: (isset($sets->order) ? $sets->order : '') ,'placeholder= "Order" class="form-control check_order" id="order"'); 
		               				if(form_error('order')) echo form_label(form_error('order'), 'order', array("id"=>"order-error" , "class"=>"error")); ?>
                        </div>
							</div>
							<!-- modified -->
<div class="form-group">
                                	<?php echo form_label('Description','description',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4 ">    
										<?php echo form_textarea("description",isset($_POST['description'])?$_POST['description']: (isset($sets->description) ? $sets->description : ''),"placeholder='Description' style='height:100px' id='description' class='form-control'"); ?> 
<?php if(form_error('description')) echo form_label(form_error('description'), 'description', array("id"=>"description-error" , "class"=>"error"));
		 ?>                                
                                	</div>
                            	</div>
							<?php if($sets->s_count!=0 || $sets->q_count!=0){ 
                           	$class = "element-hide";
                           } ?>
			 				<div class="form-group <?php echo $class;?>">
		                  <?php echo form_label('Status <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
		                  <div class="col-sm-4 topspace">
								<?php if(($sets->status) ==1){?>
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
                              <button type="submit" class="btn btn-default form-submit" title="Save">Save</button>
                          </div>
                      </div>

								<?php echo form_close();  ?>
                </div>
            </div>
        </div>
    </div>
</div>


