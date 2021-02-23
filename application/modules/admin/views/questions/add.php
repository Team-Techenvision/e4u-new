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
                            <div class="title"><?php echo "Map Questions"; //echo $this->lang->line('addquestion');   ?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/questions" title="Back">Back</a>
						</div>
                    </div>
					<input type="hidden" name="uri_segment" id="uri_segment"  value="<?php echo $this->uri->segment(2); ?>"/>
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
								echo form_open_multipart('', $attributes);
								// print_r(validation_errors());
								 ?>                        
							<div class="form-group">
								<?php echo form_label('Course <span class="required">*</span>','search_course',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									
									$js = 'id="search_course" class="form-control"';
									echo form_dropdown('course_list', $course_list, isset($_POST['course_list'])?$_POST['course_list']:'', $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Class <span class="required">*</span>','search_class',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="search_class" class="form-control"';
									echo form_dropdown('class_list', $class_list, isset($_POST['class_list'])?$_POST['class_list']:'', $js);
									if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Subject <span class="required">*</span>','search_subject',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="search_subject" class="form-control"';
									echo form_dropdown('subject_list', $subject_list, isset($_POST['subject_list'])?$_POST['subject_list']:'', $js);
									if(form_error('subject_list')) echo form_label(form_error('subject_list'), 'subject_list', array("id"=>"subject_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Chapters <span class="required">*</span>','search_chapter',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="search_chapter" class="form-control"';
									echo form_dropdown('chapter_list', $chapter_list, isset($_POST['chapter_list'])?$_POST['chapter_list']:'', $js);
									if(form_error('chapter_list')) echo form_label(form_error('chapter_list'), 'chapter_list', array("id"=>"chapter_list-error" , "class"=>"error")); ?>
								</div>
							</div>
						
                     		     
                           <div class="form-group">
								<?php echo form_label('Question Tags <span class="required">*</span>','tags',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<select name="tags[]" class="form-control" id="search_tags" multiple="multiple">
										<option value=" ">select tags</option>
										<?php if(count($tags)>0) { foreach($tags as $tag){?>
											<option value="<?php echo $tag;?>"><?php echo $tag;?></option>
										<?php }}?>
									</select>
									<?php
									if(form_error('tags')) echo form_label(form_error('tags'), 'tags', array("id"=>"choice-count-error" , "class"=>"error")); ?>
								</div>
							</div>
							
							<div class="form-group">
								<?php echo form_label('','',array('class'=>'col-sm-2 control-label')); ?>
							 	<div class="col-sm-4">	
									<?php
									if(form_error('selected_qn')) echo form_label(form_error('selected_qn'), 'selected_qn', array("id"=>"choice-count-error" , "class"=>"error")); ?>
								</div>
							</div>

							<!-- <div class="questions_search" style="padding: 0px 0px 0px 80px;">
							</div> -->

							<table id="questions_search_table" class="datatable table table-striped display" cellspacing="0" width="100%">
								<thead>
										<tr>
											<th class="dt-body-center"><input type="checkbox" name="select_all" value="1" id="questions-select-all"></th>
											<th>Question Title</th>
											<th>Question</th>
											<th>Explanation Title</th>
											<th>Explanation</th>
											<th>Tag</th>
										</tr>
								</thead>
							</table>
							
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
                                    <button class="btn btn-default" title="Save">Save</button>
							        </div>
                                    <div class="col-sm-offset-2 col-sm-10">
                                    <small>Note: Your option image's dimension within 460*160 pixels, it will show normally, if dimensions exceed 460*160 then option image will show with the default dimension (460*160 px).</small>
                                	</div>
                            </div>
								<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
