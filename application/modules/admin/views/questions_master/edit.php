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
                            <div class="title"><?php echo "Edit Question";//echo $this->lang->line('editquestion');  ?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/questions_master" title="Back">Back</a>
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
                    		<?php  
                    		$attributes = array('class' => 'form-horizontal','id' => 'map_questions_form');				
								echo form_open_multipart('', $attributes); ?>
                        	
                        	
							
							<!--QUestion Type -->
							
							<div class="form-group">
								<?php //echo form_label('Question Type <span class="required">*</span>','question_type',array('class'=>'col-sm-2 control-label')); ?>
								<?php echo form_label('Question Title <span class="required">*</span>','question_title',array('class'=>'col-sm-2 control-label')); ?>	
								<div class="col-sm-4">
									<?php
										$js = 'id="question_type" class="form-control" style="display:none"';
										echo form_dropdown('question_type', $this->config->item('question_type'), set_value('question_type'), $js);
										//if(form_error('question_type')) echo form_label(form_error('question_type'), 'question_type', array("id"=>"question-type-error" , "class"=>"error"));
										echo form_input('question_title',isset($_POST['question_title'])?$_POST['question_title']: (isset($questions->question_title) ? $questions->question_title : ''),'placeholder= "Question Title" class="form-control" id="question_title"'); 
										if(form_error('question_title')) echo form_label(form_error('question_title'), 'question_title', array("id"=>"question-title-error" , "class"=>"error")); 
									?>

								</div>
         					</div>
         				
         				<!--QUestion Type -->
													
							
							<?php
                    	if($this->input->post('question_type')){
                    		if($this->input->post('question_type')==1){ ?>
	                   		<div class="form-group question-textimg-div">
   			                	<?php	echo form_label('Question <span class="required">*</span>','question',array('class'=>'col-sm-2 control-label')); ?>
   	                		<div class="col-sm-4">
   			     					<?php	echo form_textarea('question',isset($_POST['question'])?$_POST['question']: (isset($questions->question) ? $questions->question : ''),'placeholder= "Question" class="form-control" id="question"');
   		                		if(form_error('question')) echo form_label(form_error('question'), 'question', array("id"=>"question-error" , "class"=>"error"));?>
   	                		</div></div><?php                      			
                    		}else{?>
                    			<div class="form-group question-textimg-div">
                    				<?php	echo form_label('Question <span class="required">*</span>','question',array('class'=>'col-sm-2 control-label')); ?>
                    			<div class="col-sm-4">                    				
                    				<?php	echo form_upload(array('id' => 'question', 'name' => 'question', 'class' => 'form-control', 'placeholder' => ''));  ?>
                    				<small>Allowed Types: gif,jpg,jpeg,png </small>
                    				<!-- | min 300*300 px -->
                    				<?php if(!isset($_POST['question']) and ($questions->question_type!=1) and isset($questions->question)){ ?>
                    				<div style="position:relative" class="col-sm-6">
											
											<a class="fancybox fancybox.ajax"  href="<?php echo base_url().SITE_ADMIN_URI.'/questions_master/image_view/'.$questions->question.'/1'?>" title="View Image">View Image</a>
											<input type="hidden" value="1" name="question_image_present">						
										</div> <?php } ?>
                    				<?php if(form_error('question')) echo form_label(form_error('question'), 'question', array("id"=>"question-error" , "class"=>"error"));?>
                    				<?php if(isset($question_upload_error['error'])){ echo form_label($question_upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                    			</div></div>
                    	<?php	}                 			
                    	}else{ ?>
                   		<div class="form-group question-textimg-div">
                   	<?php	echo form_label('Question <span class="required">*</span>','question',array('class'=>'col-sm-2 control-label')); ?>
                   		<div class="col-sm-4">
        					<?php 
        						if($questions->question_type==2){
        							echo form_upload(array('id' => 'question', 'name' => 'question', 'class' => 'form-control', 'placeholder' => '')); ?>
        							<small>Allowed Types: gif,jpg,jpeg,png </small><br> 
                    				<!-- | min 300*300 px -->

        							<div class="col-sm-6">
        								<a class="fancybox fancybox.ajax"  href="<?php echo base_url().SITE_ADMIN_URI.'/questions_master/image_view/'.$questions->question.'/1'?>" title="View Image">View Image</a> 
										<input type="hidden" value="1" name="question_image_present">						
									</div>
        					<?php (isset($questions->question) ? $questions->question : '');
        						}else{
        						echo form_textarea('question',(isset($questions->question) ? $questions->question : ''),'placeholder= "Question" class="form-control" id="question"'); }
                   	?>	
                   		</div></div><?php                    					
                    	}
                    ?>


                   			 <div class="form-group">
								<?php echo form_label('Select Question Tags[Existing] <span class="required">*</span> <br> (or)','tags',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php //print_r($edited_tags);die;?>
									 <select name="tags_exist[]" class="form-control" multiple="multiple">
										<option disabled>Select Existing Tags</option>
										<?php if(count($tags)>0) { foreach($tags as $tag){?>
											<option value="<?php echo $tag;?>" <?php if(in_array($tag, $edited_tags)){ echo "selected";}?>><?php echo $tag;?></option>
										<?php }}?>
									</select>

									<?php
									if(form_error('tags_exist')) echo form_label(form_error('tags_exist'), 'tags_exist', array("id"=>"choice-count-error" , "class"=>"error")); ?>
								</div>
							</div>

							<div class="form-group">
                            	<?php echo form_label('Add new Question Tags <span class="required">*</span>','tags',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('tags',set_value('tags'),'placeholder= "Question Tags" class="form-control" id="tags"'); 
                   					if(form_error('tags')) echo form_label(form_error('tags'), 'tags', array("id"=>"tags-error" , "class"=>"error")); ?>
                                </div>
							</div>
							<div class="form-group note_t">
				       			<div class="col-sm-2"></div>
						   		<div class="col-sm-4">
						   		<?php $note_text = "<ul><li>Text</li></ul>"; ?>
						   		<small> Note: Use comma (,) to seperate tags. Use relevant tags to search question while mapping to chapters.</small>
						   		</div>
						   	</div>



							<div class="form-group">
								<?php echo form_label('Choice Count <span class="required">*</span>','choice_count',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="choice_count" class="form-control"';
									$set_choice_count = isset($_POST['choice_count']) ? $_POST['choice_count'] : (isset($questions->choice_count) ? $questions->choice_count : '');
									echo form_dropdown('choice_count', $this->config->item('choice_count'), $set_choice_count, $js);
									if(form_error('choice_count')) echo form_label(form_error('choice_count'), 'choice_count', array("id"=>"choice-count-error" , "class"=>"error")); ?>
								</div>
							</div>

							<div class="form-group">			 						
	                       	<?php 	                       	
	                       	echo form_label('Status <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
	                        <div class="col-sm-4 topspace">
										<?php if(($questions->show_options) ==1){?>
										
										<?php echo form_radio('show_options', '0','','class="align_radio" id="box"'); ?> 
										<?php echo form_label('Checkbox','box',array('class'=>'align_label')); ?>
										<?php echo form_radio('show_options', '1',TRUE,'class="align_radio" id="alphabets"'); ?> 
										<?php echo form_label('Alphabets','alphabets',array('class'=>'align_label')); ?>
										
										<?php }else{?>

										<?php echo form_radio('show_options', '0',TRUE,'class="align_radio" id="box"'); ?> 
										<?php echo form_label('Checkbox','box',array('class'=>'align_label')); ?>
										<?php echo form_radio('show_options', '1','','class="align_radio" id="alphabets"'); ?> 
										<?php echo form_label('Alphabets','alphabets',array('class'=>'align_label')); ?>
										
										<?php } ?>
                           </div> 
                            
                    </div>
											
							<!-- 

							 -->
							
							<div class="form-group">
								<?php echo form_label('Correct Answer <span class="required">*</span>','correct_answer',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$count = ($_POST['choice_count'] != ""?$_POST['choice_count']:$count);
									if($count == ""){
										$correct_answer = array();
									}
									else if($count == 2){
										$correct_answer = array('A'=>'A','B'=>'B');
									}
									else if($count == 3)
									{	
										$correct_answer = array('A'=>'A','B'=>'B','C'=>'C');
									}
									else if($count == 4)
									{
										$correct_answer = array('A'=>'A','B'=>'B','C'=>'C','D'=>'D');
									}
									else
									{
										$correct_answer = array('A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E');
									}
									$js = 'id="correct_answer" class="form-control"';
									$set_correct_answer = isset($_POST['correct_answer[]']) ? explode(',',$_POST['correct_answer[]']) : (isset($questions->correct_answer) ? explode(',',$questions->correct_answer) : '');
									//$correct_answer[""] = "Select";
									if(($questions->show_options) ==1){
									 echo form_dropdown('correct_answer[]',$correct_answer,$set_correct_answer,$js); 
									}else{
									  echo form_multiselect('correct_answer[]',$correct_answer,$set_correct_answer,$js); 
									}
									if(form_error('correct_answer[]')) echo form_label(form_error('correct_answer[]'), 'correct_answer', array("id"=>"correct-answer-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group note_t">
				       			<div class="col-sm-2"></div>
						   		<div class="col-sm-4">
						   		<?php $note_text = "<ul><li>Text</li></ul>"; ?>
						   		<small> Note: Use ctrl+click to select multiple answers.</small>
						   		</div>
						   	</div>
						   	
							
							<div class="form-group">
								<?php //echo form_label('Explanation Type ','explanation_type',array('class'=>'col-sm-2 control-label')); 
								 echo form_label('Explanation Title ','explanation_title',array('class'=>'col-sm-2 control-label')); 
								?>
								<div class="col-sm-4">
									<?php
										$js = 'id="explanation_type" class="form-control" style="display:none"';
										echo form_dropdown('explanation_type', $this->config->item('explanation_type'), set_value('explanation_type'), $js);
										//if(form_error('explanation_type')) echo form_label(form_error('explanation_type'), 'explanation_type', array("id"=>"explanation-type-error" , "class"=>"error")); 
										echo form_input('explanation_title',isset($_POST['explanation_title'])?$_POST['explanation_title']: (isset($questions->explanation_title) ? $questions->explanation_title : ''),'placeholder= "explanation Title" class="form-control" id="question_title"'); 
										if(form_error('explanation_title')) echo form_label(form_error('explanation_title'), 'explanation_title', array("id"=>"explanation-title-error" , "class"=>"error")); 
									?>
								</div>
         				</div>
         				
         				<?php
                    	if($this->input->post('explanation_type')){
                    		
                    		if($this->input->post('explanation_type')==1){ ?>

	                   		<div class="form-group explanation-textimg-div">
   			                	<?php	echo form_label('Explanation ','',array('class'=>'col-sm-2 control-label', 'id'=>'explanation')); ?>
   	                		<div class="col-sm-4">
   			     					<?php	echo form_textarea('explanation',isset($_POST['explanation'])?$_POST['explanation']: (isset($questions->explanation) ? $questions->explanation : ''),'placeholder= "explanation" class="form-control" id="explanation"');
   		                		if(form_error('explanation')) echo form_label(form_error('explanation'), 'explanation', array("id"=>"explanation-error" , "class"=>"error"));?>
   	                		</div></div>
   	                		<div class="form-group note_t">
				       			<div class="col-sm-2"></div>
						   		<div class="col-sm-4">
						   		<?php $note_text = "<ul><li>Text</li></ul>"; ?>
						   		<small> Note: use html tags (<?php echo htmlentities($note_text);?>) for bullet points.</small>
						   		</div>
						   	</div><?php                      			
                    		}else{?>
                    			<div class="form-group explanation-textimg-div">
                    				<?php	echo form_label('explanation','',array('class'=>'col-sm-2 control-label', 'id'=>'explanation')); ?>
                    			<div class="col-sm-4">
                    				<?php	echo form_upload(array('id' => 'explanation', 'name' => 'explanation', 'class' => 'form-control', 'placeholder' => ''));  ?>
                    				<small>Allowed Types: gif,jpg,jpeg,png </small>
                    				<!-- | min 300*300 px -->
                    				<?php if(!isset($_POST['explanation']) and ($questions->explanation_type!=1) and isset($questions->explanation)){ ?>
                    				<div style="position:relative" class="col-sm-6">
                						<a class="fancybox fancybox.ajax"  href="<?php echo base_url().SITE_ADMIN_URI.'/questions_master/image_view/'.$questions->explanation.'/3'?>" title="View Image">View Image</a>
											<input type="hidden" value="1" name="explanation_image_present">						
										</div> <?php } ?>
                    				<?php if(form_error('explanation')) echo form_label(form_error('explanation'), 'explanation', array("id"=>"explanation-error" , "class"=>"error"));?>
                    				<?php if(isset($explanation_upload_error['error'])){ echo form_label($explanation_upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                    			</div></div>
                    	<?php	}                 			
                    	}else{ ?>
                   		<div class="form-group explanation-textimg-div">
                   	<?php	echo form_label('Explanation ','explanation',array('class'=>'col-sm-2 control-label')); ?>
                   		<div class="col-sm-4">
        					<?php 
        						if($questions->explanation_type==2){
        							echo form_upload(array('id' => 'explanation', 'name' => 'explanation', 'class' => 'form-control', 'placeholder' => '')); ?>
        							<small>Allowed Types: gif,jpg,jpeg,png </small><br> 
        							<!-- | min 300*300 px -->
        							<div style="position:relative" class="col-sm-6">
        								<a class="fancybox fancybox.ajax"  href="<?php echo base_url().SITE_ADMIN_URI.'/questions_master/image_view/'.$questions->explanation.'/3'?>" title="View Image">View Image</a>
										<input type="hidden" value="1" name="explanation_image_present">
									</div>
        					<?php 
        						}else{
        						echo form_textarea('explanation',(isset($questions->explanation) ? $questions->explanation : ''),'placeholder= "explanation" class="form-control" id="explanation"'); }
                   	?>	
                   		</div></div>
                   		<div class="form-group note_t">
			       			<div class="col-sm-2"></div>
					   		<div class="col-sm-4">
					   			<?php $note_text = "<ul><li>Text</li></ul>"; ?>
					   			<small> Note: use html tags (<?php echo htmlentities($note_text);?>) for bullet points.</small>
					   		</div>
					   	</div>
					   	<?php } ?>        				
							<div class="form-group">
								<?php echo form_label('Severity <span class="required">*</span>','severity',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="severity" class="form-control"';
									$severity = isset($_POST['severity']) ? $_POST['severity'] : (isset($questions->severity) ? $questions->severity : '');
									echo form_dropdown('severity', $this->config->item('severity'), $severity, $js);
									if(form_error('severity')) echo form_label(form_error('severity'), 'severity', array("id"=>"severity-error" , "class"=>"error")); ?>
								</div>
							</div>
							<?php if($test_details->is_delete!=0){
										$class = "element-hide";
									}
							?>


				

			 		<div class="form-group <?php echo $class;?>">			 						
	                       	<?php 	                       	
	                       	echo form_label('Status <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
	                        <div class="col-sm-4 topspace">
										<?php if(($questions->status) ==1){?>
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


