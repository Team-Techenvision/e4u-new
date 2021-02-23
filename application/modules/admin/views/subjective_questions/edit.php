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
                            <div class="title"><?php echo $this->lang->line('editsubjectivequestion');  ?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/subjective_questions" title="Back">Back</a>
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
								 <div class="alert alert-danger alert-dismissible" role="alert">
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									 <strong>Warning!</strong> <?php echo $this->session->flashdata('flash_failure_message'); ?>
									 <?php $this->session->unmark_flash('flash_failure_message'); ?>
								</div> 
								<?php } if($this->session->flashdata('flash_success_message')){ ?>
								 <div class="alert alert-success" role="alert">
									 <strong>Done!</strong> <?php echo $this->session->flashdata('flash_success_message'); ?>
									 <?php $this->session->unmark_flash('flash_success_message'); ?>
								</div> 
								<?php } ?>
                    		<?php  
                    		$attributes = array('class' => 'form-horizontal','id' => 'map_questions_form');				
								echo form_open_multipart('', $attributes); ?>
                        	<div class="form-group">
								<?php echo form_label('Course <span class="required">*</span>','search_course',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									
									$js = 'id="search_course" class="form-control subjective_course edit_subj"';
									$set_course = isset($_POST['course_list'])?$_POST['course_list']: (isset($subjective_questions->course_id) ? $subjective_questions->course_id : '');
									echo form_dropdown('course_list', $course_list,$set_course, $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Class <span class="required">*</span>','search_class',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="search_class" class="form-control"';
									$set_class = isset($_POST['class_list'])?$_POST['class_list']: (isset($subjective_questions->class_id) ? $subjective_questions->class_id : '');
									echo form_dropdown('class_list', $class_list, $set_class, $js);
									if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Subject <span class="required">*</span>','search_subject',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="search_subject" class="form-control"';
									$set_subject = isset($_POST['subject_list'])?$_POST['subject_list']: (isset($subjective_questions->subject_id) ? $subjective_questions->subject_id : '');
									echo form_dropdown('subject_list', $subject_list, $set_subject, $js);
									if(form_error('subject_list')) echo form_label(form_error('subject_list'), 'subject_list', array("id"=>"subject_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Sub Category <span class="required">*</span>','search_category',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="search_category" class="form-control subjective_cat"';
									$set_category = isset($_POST['category_list']) ? $_POST['category_list'] : (isset($subjective_questions->sub_category_id) ? $subjective_questions->sub_category_id : '');
									echo form_dropdown('category_list', $category_list, $set_category, $js);
									if(form_error('category_list')) echo form_label(form_error('category_list'), 'category_list', array("id"=>"category-list-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Chapters <span class="required">*</span>','search_chapter',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php  
									$js = 'id="search_chapter" class="form-control"';
									$set_chapter = isset($_POST['chapter_list'])?$_POST['chapter_list']: (isset($subjective_questions->chapter_id) ? $subjective_questions->chapter_id : '');
									echo form_dropdown('chapter_list', $chapter_list, $set_chapter , $js);
									if(form_error('chapter_list')) echo form_label(form_error('chapter_list'), 'chapter_list', array("id"=>"chapter-list-error" , "class"=>"error")); ?>
								</div>
							</div>
							
							
							<!--QUestion Type -->
							
							<div class="form-group">
								<?php echo form_label('Question Type <span class="required">*</span>','question_type',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="question_type" class="form-control"';
									$set_question_type = isset($_POST['question_type']) ? $_POST['question_type'] : (isset($subjective_questions->question_type) ? $subjective_questions->question_type : '');
									echo form_dropdown('question_type', $this->config->item('question_type'), $set_question_type, $js);
									if(form_error('question_type')) echo form_label(form_error('question_type'), 'question_type', array("id"=>"question-type-error" , "class"=>"error")); ?>
								</div>
         				</div>
         				
         				<!--QUestion Type -->
							
						<?php
                    	if($this->input->post('question_type')){
                    		if($this->input->post('question_type')==1){ ?>
	                   		<div class="form-group question-textimg-div">
   			                	<?php	echo form_label('Question <span class="required">*</span>','question',array('class'=>'col-sm-2 control-label')); ?>
   	                		<div class="col-sm-4">
   			     					<?php	echo form_textarea('question',isset($_POST['question'])?$_POST['question']: (isset($subjective_questions->question) ? $subjective_questions->question : ''),'placeholder= "Question" class="form-control" id="question"');
   		                		if(form_error('question')) echo form_label(form_error('question'), 'question', array("id"=>"question-error" , "class"=>"error"));?>
   	                		</div></div><?php                      			
                    		}else{?>
                    			<div class="form-group question-textimg-div">
                    				<?php	echo form_label('Question <span class="required">*</span>','question',array('class'=>'col-sm-2 control-label')); ?>
                    			<div class="col-sm-4">                    				
                    				<?php	echo form_upload(array('id' => 'question', 'name' => 'question', 'class' => 'form-control', 'placeholder' => ''));  ?>
                    				<small>Allowed Types: gif,jpg,jpeg,png | min 300*300 px</small>
                    				<?php if(!isset($_POST['question']) and ($subjective_questions->question_type!=1) and isset($subjective_questions->question)){ ?>
                    				<div style="position:relative" class="col-sm-6">
                						<a class="fancybox fancybox.ajax"  href="<?php echo base_url().SITE_ADMIN_URI.'/questions/image_view/'.$subjective_questions->question.'/4'?>" title="View Image">View Image</a>
											<input type="hidden" value="1" name="question_image_present">						
										</div> <?php } ?>
                    				<?php if(form_error('question')) echo form_label(form_error('question'), 'question', array("id"=>"question-error" , "class"=>"error"));?>
                    				<?php if(isset($question_upload_error['error'])){ echo form_label($question_upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                    			</div></div>
                    	<?php	}                 			
                    	}else{ ?>
                   		<div class="form-group question-textimg-div">
                   		<?php echo form_label('Question <span class="required">*</span>','question',array('class'=>'col-sm-2 control-label')); ?>
                   		<div class="col-sm-4">
        					<?php 
        						if($subjective_questions->question_type==2){
        							echo form_upload(array('id' => 'question', 'name' => 'question', 'class' => 'form-control', 'placeholder' => '')); ?>
        							<small>Allowed Types: gif,jpg,jpeg,png | min 300*300 px</small><br> 
        							<div style="position:relative" class="col-sm-6">
        								<a class="fancybox fancybox.ajax"  href="<?php echo base_url().SITE_ADMIN_URI.'/questions/image_view/'.$subjective_questions->question.'/4'?>" title="View Image">View Image</a>
										<input type="hidden" value="1" name="question_image_present">			
									</div>
        					<?php (isset($subjective_questions->question) ? $subjective_questions->question : '');
        						}else{
        						echo form_textarea('question',(isset($subjective_questions->question) ? $subjective_questions->question : ''),'placeholder= "Question" class="form-control" id="question"'); }
                   			?>	
                   			</div></div><?php } ?>
							
							<div class="form-group">
								<?php echo form_label('Explanation Type <span class="required">*</span>','explanation_type',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="explanation_type" class="form-control"';
									$set_explanation_type = isset($_POST['explanation_type']) ? $_POST['explanation_type'] : (isset($subjective_questions->explanation_type) ? $subjective_questions->explanation_type : '1');
									echo form_dropdown('explanation_type', $this->config->item('explanation_type'), $set_explanation_type, $js);
									if(form_error('explanation_type')) echo form_label(form_error('explanation_type'), 'explanation_type', array("id"=>"explanation-type-error" , "class"=>"error")); ?>
								</div>
         					</div>
         				
         				<?php
                    	if($this->input->post('explanation_type')){
                    		if($this->input->post('explanation_type')==1){ ?>
	                   		<div class="form-group explanation-textimg-div">
   			                	<?php	echo form_label('Explanation <span class="required">*</span>','',array('class'=>'col-sm-2 control-label', 'id'=>'explanation')); ?>
   	                		<div class="col-sm-4">
   			     					<?php	echo form_textarea('explanation',isset($_POST['explanation'])?$_POST['explanation']: (isset($subjective_questions->explanation) ? $subjective_questions->explanation : ''),'placeholder= "explanation" class="form-control" id="explanation"');
   		                		if(form_error('explanation')) echo form_label(form_error('explanation'), 'explanation', array("id"=>"explanation-error" , "class"=>"error"));?>
   	                		</div></div><div class="form-group note_t">
		               			<div class="col-sm-2"></div>
				           		<div class="col-sm-4">
				           		<?php $note_text = "<ul><li>Text</li></ul>"; ?>
				           		<small> Note: use html tags (<?php echo htmlentities($note_text);?>) for bullet points.</small>
				           		</div>
				           	</div><?php                      			
                    		}else{?>
                    			<div class="form-group explanation-textimg-div">
                    				<?php	echo form_label('explanation <span class="required">*</span>','',array('class'=>'col-sm-2 control-label', 'id'=>'explanation')); ?>
                    			<div class="col-sm-4">
                    				<?php	echo form_upload(array('id' => 'explanation', 'name' => 'explanation', 'class' => 'form-control', 'placeholder' => ''));  ?>
                    				<small>Allowed Types: gif,jpg,jpeg,png | min 300*300 px</small>
                    				<?php if(!isset($_POST['explanation']) and ($subjective_questions->explanation_type!=1) and isset($subjective_questions->explanation)){ ?>
                    				<div style="position:relative" class="col-sm-6">
                    					<a class="fancybox fancybox.ajax"  href="<?php echo base_url().SITE_ADMIN_URI.'/questions/image_view/'.$subjective_questions->explanation.'/5'?>" title="View Image">View Image</a>
											<input type="hidden" value="1" name="explanation_image_present">						
										</div> <?php } ?>
                    				<?php if(form_error('explanation')) echo form_label(form_error('explanation'), 'explanation', array("id"=>"explanation-error" , "class"=>"error"));?>
                    				<?php if(isset($explanation_upload_error['error'])){ echo form_label($explanation_upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                    			</div></div>
                    	<?php	}                 			
                    	}else{ ?>
                   		<div class="form-group explanation-textimg-div">
                   	<?php	echo form_label('Explanation <span class="required">*</span>','explanation',array('class'=>'col-sm-2 control-label')); ?>
                   		<div class="col-sm-4">
        					<?php 
        						if($subjective_questions->explanation_type==2){
        							echo form_upload(array('id' => 'explanation', 'name' => 'explanation', 'class' => 'form-control', 'placeholder' => '')); ?>
        							<small>Allowed Types: gif,jpg,jpeg,png | min 300*300 px</small><br> 
        							<div style="position:relative" class="col-sm-6">
        								<a class="fancybox fancybox.ajax"  href="<?php echo base_url().SITE_ADMIN_URI.'/questions/image_view/'.$subjective_questions->explanation.'/5'?>" title="View Image">View Image</a>
										<input type="hidden" value="1" name="explanation_image_present">
									</div>
        					<?php 
        						}else{
        						echo form_textarea('explanation',(isset($subjective_questions->explanation) ? $subjective_questions->explanation : ''),'placeholder= "explanation" class="form-control" id="explanation"'); 			}
                   				?>	
                   		</div></div><div class="form-group note_t">
		               			<div class="col-sm-2"></div>
				           		<div class="col-sm-4">
				           		<?php $note_text = "<ul><li>Text</li></ul>"; ?>
				           		<small> Note: use html tags (<?php echo htmlentities($note_text);?>) for bullet points.</small>
				           		</div>
				           	</div><?php } ?>        				
							<div class="form-group">
								<?php echo form_label('Severity','severity',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="severity" class="form-control"';
									$severity = isset($_POST['severity']) ? $_POST['severity'] : (isset($subjective_questions->severity) ? $subjective_questions->severity : '');
									echo form_dropdown('severity', $this->config->item('severity'), $severity, $js);
									if(form_error('severity')) echo form_label(form_error('severity'), 'severity', array("id"=>"severity-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
	                       	<?php 	                       	
	                       	echo form_label('Status <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
			                    <div class="col-sm-4 topspace">
									<?php if(($subjective_questions->status) ==1){?>
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
                                    <button type="submit" class="btn btn-default form-submit" title="Save">Save</button>
                                </div>
                            </div>
						<?php echo form_close();  ?>
                </div>
            </div>
        </div>
    </div>
</div>


