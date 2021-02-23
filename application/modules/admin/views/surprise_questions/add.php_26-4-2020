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
                            <div class="title"><?php echo "Add Standard Question";//$this->lang->line('addsurprisequestion');  ?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/surprise_questions" title="Back">Back</a>
						</div>
                    </div>
					<input type="hidden" name="uri_segment" id="uri_segment" value="<?php echo $this->uri->segment(2); ?>"/>
					<input type="hidden" name="currentSubject" id="currentSubject" value=""/>
					<input type="hidden" name="currentIndex" id="currentIndex" value=""/>
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
									$set_test = $this->uri->segment('5') ?$this->uri->segment('5'):(isset($_POST['course_list']) ? $_POST['course_list'] : '' );
									$js = 'id="course_list" class="form-control"';
									echo form_dropdown('course_list', $course_list, $set_test, $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error")); ?>
								</div>
							</div> 
							<div class="form-group">
								<?php echo form_label('Test Name <span class="required">*</span>','test_name',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="test_name" class="form-control"';
									$set_test = $this->uri->segment('4')?$this->uri->segment('4'):(isset($_POST['test_name']) ? $_POST['test_name'] : '' );
									
									echo form_dropdown('test_name', $test_name, $set_test, $js);
									if(form_error('test_name')) echo form_label(form_error('test_name'), 'test_name', array("id"=>"test_name-error" , "class"=>"error")); ?>
								</div>
							</div>

							<div class="form-group after-add-more">
								<?php echo form_label('Subjects <span class="required">*</span>','subject_id',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="subject_id" class="form-control std-subject" disabled="disabled"';
									$set_test = $this->uri->segment('4')?$this->uri->segment('4'):(isset($_POST['subject_id']) ? $_POST['subject_id'] : '' );
									
									echo form_dropdown('subject_id[]', $subject_id, $set_test, $js);
									//echo form_multiselect('subject_id[]',$subject_id,isset($_POST['subject_id[]'])?explode(',',$_POST['subject_id']):'',$js); 
									if(form_error('subject_id')) echo form_label(form_error('subject_id[]'), 'subject_id', array("id"=>"subject_id-error" , "class"=>"error")); ?>
									<input type="hidden" name="questionSubject[]" id="questionSubject" class="questionSubject"> <span class="show_qn_count" style="margin:10px">Question : 0</span>
								</div>
								<div class="input-group-btn"> 
								    <button class="btn btn-info std-edit" type="button" style="margin-right:10px"><i class="glyphicon glyphicon-edit"></i> Edit</button> 
									<button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
								</div>
							</div>

							<div class="copy hide">
								<div class="form-group control-group"> 
									<?php echo form_label('Add Subjects <span class="required">*</span>','subject_id',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<?php
										$js = 'id="subject_id" class="form-control std-subject" disabled="disabled" ';
										$set_test = $this->uri->segment('4')?$this->uri->segment('4'):(isset($_POST['subject_id']) ? $_POST['subject_id'] : '' );
										
										echo form_dropdown('subject_id[]', $subject_id, $set_test, $js);
										//echo form_multiselect('subject_id[]',$subject_id,isset($_POST['subject_id[]'])?explode(',',$_POST['subject_id']):'',$js); 
										if(form_error('subject_id')) echo form_label(form_error('subject_id[]'), 'subject_id', array("id"=>"subject_id-error" , "class"=>"error")); ?>
										<input type="hidden" name="questionSubject[]" id="questionSubject" class="questionSubject"><span class="show_qn_count" style="margin:10px">Question : 0</span>
									</div>
									<div class="input-group-btn"> 
										<button class="btn btn-info std-edit" type="button" style="margin-right:10px"><i class="glyphicon glyphicon-edit"></i> Edit</button> 
										<button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
									</div>
								</div>
							</div>

							<!-- questions map start -->
                           <div class="form-group">
								<?php echo form_label('Question Tags <span class="required">*</span>','tags',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<select name="tags[]" class="form-control" id="search_tags_standard" multiple="multiple">
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


							<!-- <table id="questions_search_table" class="datatable table table-striped display" cellspacing="0" width="100%"></table> -->

							<table id="questions_search_table" class="datatable table table-striped display" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><input type="checkbox" name="select_all" value="1" id="questions-select-all"></th>
										<th>Question Title</th>
										<th>Question</th>
										<th>Explanation Title</th>
										<th>Explanation</th>
										<th>Tag</th>
									</tr>
								</thead>
							</table>


							<!-- questions map end -->

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


