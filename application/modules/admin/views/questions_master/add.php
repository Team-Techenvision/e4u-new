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
                            <div class="title"><?php echo "Add Question";//echo $this->lang->line('addquestion');  ?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/questions_master" title="Back">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'questions_form');				
								echo form_open_multipart('', $attributes); ?> 


                     	  <div class="form-group">
								<?php //echo form_label('Question Type <span class="required">*</span>','question_type',array('class'=>'col-sm-2 control-label')); ?>
								<?php echo form_label('Question Title <span class="required">*</span>','question_title',array('class'=>'col-sm-2 control-label')); ?>		
								<div class="col-sm-4">
									<?php
									$js = 'id="question_type" class="form-control" style="display:none"';
									echo form_dropdown('question_type', $this->config->item('question_type'), set_value('question_type'), $js);
									//if(form_error('question_type')) echo form_label(form_error('question_type'), 'question_type', array("id"=>"question-type-error" , "class"=>"error"));
									echo form_input('question_title',set_value('question_title'),'placeholder= "Question Title" class="form-control" id="question_title"'); 
									if(form_error('question_title')) echo form_label(form_error('question_title'), 'question_title', array("id"=>"question-title-error" , "class"=>"error")); 
									?> 
								</div>
         				  </div>	     
                            
                    	<?php
                    	if($this->input->post('question_type')){
                    		if($this->input->post('question_type')==1){ ?>
	                   		<div class="form-group question-textimg-div">
   			                	<?php	echo form_label('Question <span class="required">*</span>','question',array('class'=>'col-sm-2 control-label')); ?>
   	                		<div class="col-sm-4">
   			     					<?php	echo form_textarea('question',set_value('question'),'placeholder= "Question" '.$style.' class="form-control" id="question"');
   		                		if(form_error('question')) echo form_label(form_error('question'), 'question', array("id"=>"question-error" , "class"=>"error"));?>
   	                		</div></div><?php                      			
                    		}else{?>
                    			<div class="form-group question-textimg-div">
                    				<?php	echo form_label('Question <span class="required">*</span>','question',array('class'=>'col-sm-2 control-label')); ?>
                    			<div class="col-sm-4">
                    				<?php	echo form_upload(array('id' => 'question', 'name' => 'question', 'class' => 'form-control', 'placeholder' => ''));  ?>
                    				<small>Allowed Types: gif,jpg,jpeg,png </small>
                    				<!-- | min 300*300 px -->
                    				<?php if(form_error('question')) echo form_label(form_error('question'), 'question', array("id"=>"question-error" , "class"=>"error"));?>
                    				<?php if(isset($question_upload_error['error'])){ echo form_label($question_upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                    			</div></div>
                    	<?php	}                 			
                    	}else{ ?>
                   	    <div class="form-group question-textimg-div">
                    				<?php	echo form_label('Question <span class="required">*</span>','question',array('class'=>'col-sm-2 control-label')); ?>
                    			<div class="col-sm-4">
                    				<?php	echo form_upload(array('id' => 'question', 'name' => 'question', 'class' => 'form-control', 'placeholder' => ''));  ?>
                    				<small>Allowed Types: gif,jpg,jpeg,png </small>
                    				<!-- | min 300*300 px -->
                    				<?php if(form_error('question')) echo form_label(form_error('question'), 'question', array("id"=>"question-error" , "class"=>"error"));?>
                    				<?php if(isset($question_upload_error['error'])){ echo form_label($question_upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                    			</div></div>

					   <?php                    					
                    	}
                    ?>
							
							<!-- <div class="form-group">
								<?php //echo form_label('Answer Type <span class="required">*</span>','answer_type',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									// $js = 'id="answer_type" class="form-control"';
									// echo form_dropdown('answer_type', $this->config->item('answer_type'), isset($_POST['answer_type'])?$_POST['answer_type']:'', $js);
									// if(form_error('answer_type')) echo form_label(form_error('answer_type'), 'answer_type', array("id"=>"answer-type-error" , "class"=>"error")); ?>
								</div>
							</div> -->

							<div class="form-group">
								<?php echo form_label('Select Question Tags[Existing] <span class="required">*</span> <br> (or)','tags',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<select name="tags_exist[]" class="form-control" multiple="multiple">
										<option disabled>Select Existing Tags</option>
										<?php if(count($tags)>0) { foreach($tags as $tag){?>
											<option value="<?php echo $tag;?>"><?php echo $tag;?></option>
										<?php }}?>
									</select>
									<?php
									if(form_error('tags_exist')) echo form_label(form_error('tags_exist'), 'tags_exist', array("id"=>"choice-count-error" , "class"=>"error")); ?>
								</div>
							</div>

							<div class="form-group">
                            	<?php echo form_label('Add Question Tags <span class="required">*</span>','tags',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('tags',set_value('tags'),'placeholder= "Question Tags" class="form-control" id="tags"'); 
                   					if(form_error('tags')) echo form_label(form_error('tags'), 'tags', array("id"=>"tags-error" , "class"=>"error")); ?>
                                </div>
							</div>
							<div class="form-group note_t">
				       			<div class="col-sm-2"></div>
						   		<div class="col-sm-4">
						   		<?php $note_text = "<ul><li>Text</li></ul>"; ?>
						   		<small> Note: Use comma (,) to seperate tags.  Use relevant tags to search question while mapping to chapters.</small>
						   		</div>
						   	</div>



							<div class="form-group">
								<?php echo form_label('Choice Count <span class="required">*</span>','choice_count',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="choice_count" class="form-control"';
									echo form_dropdown('choice_count', $this->config->item('choice_count'), isset($_POST['choice_count'])?$_POST['choice_count']:'', $js);
									if(form_error('choice_count')) echo form_label(form_error('choice_count'), 'choice_count', array("id"=>"choice-count-error" , "class"=>"error")); ?>
								</div>
							</div>

							<div class="form-group">
                            	<?php echo form_label('Options <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4 topspace">
                                	<?php echo form_radio('show_options', '0','TRUE','class="align_radio" id="box"'); ?> 
									<?php echo form_label('Checkbox','box',array('class'=>'align_label')); ?>

									<?php echo form_radio('show_options', '1','','class="align_radio" id="alphabets"'); ?> 
									<?php echo form_label('Alphabets','alphabets',array('class'=>'align_label')); ?>
									
                                 </div>
                            </div>

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
									else if($count == 5)
									{
										$correct_answer = array('A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E');
									}
									$js = 'id="correct_answer" class="form-control"';
									//$correct_answer[""] = "Select";
									echo form_multiselect('correct_answer[]',$correct_answer,isset($_POST['correct_answer[]'])?explode(',',$_POST['correct_answer']):'',$js); 
									
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
								<?php 
								  //echo form_label('Explanation Type ','explanation_type',array('class'=>'col-sm-2 control-label'));  
								  echo form_label('Explanation Title ','explanation_title',array('class'=>'col-sm-2 control-label')); 
								?>
								<div class="col-sm-4">
									<?php
									$js = 'id="explanation_type" class="form-control" style="display:none"';
									echo form_dropdown('explanation_type', $this->config->item('explanation_type'), set_value('explanation_type'), $js);
									//if(form_error('explanation_type')) echo form_label(form_error('explanation_type'), 'explanation_type', array("id"=>"explanation-type-error" , "class"=>"error")); 
									echo form_input('explanation_title',set_value('explanation_title'),'placeholder= "Explanation Title" class="form-control" id="question_title"'); 
									if(form_error('explanation_title')) echo form_label(form_error('explanation_title'), 'explanation_title', array("id"=>"explanation-title-error" , "class"=>"error")); 
									?>
								</div>
         				</div>
         				
         				
         				<?php
                    	if($this->input->post('explanation_type')){
                    		//if($this->input->post('explanation_type')==1){ ?>
	                   		<!-- <div class="form-group explanation-textimg-div">
   			                	<?php echo form_label('Explanation ','explanation',array('class'=>'col-sm-2 control-label')); ?>
   	                		<div class="col-sm-4">
   			     					<?php
									//$js = 'id="explanation" class="form-control"';
									//echo form_textarea('explanation',set_value('explanation'),'placeholder= "Explanation" '.$style.' class="form-control" id="explanation"'); 
									//if(form_error('explanation')) echo form_label(form_error('explanation'), 'explanation', array("id"=>"explanation-error" , "class"=>"error")); ?>
   	                		</div></div> -->
   	                		<!-- <div class="form-group note_t">
				       			<div class="col-sm-2"></div>
						   		<div class="col-sm-4">
						   		<?php $note_text = "<ul><li>Text</li></ul>"; ?>
						   		<small> Note: use html tags (<?php echo htmlentities($note_text);?>) for bullet points.</small>
						   		</div>
						   	</div> -->
							   <?php                      			
                    		//}else{?>
                    			<div class="form-group explanation-textimg-div">
                    				<?php	echo form_label('Explanation ','explanation',array('class'=>'col-sm-2 control-label')); ?>
                    			<div class="col-sm-4">
                    				<?php	echo form_upload(array('id' => 'explanation', 'name' => 'explanation', 'class' => 'form-control', 'placeholder' => ''));  ?>
                    				<small>Allowed Types: gif,jpg,jpeg,png </small>
                    			
                    				<?php if(form_error('explanation')) echo form_label(form_error('explanation'), 'explanation', array("id"=>"explanation-error" , "class"=>"error"));?>
                    				<?php if(isset($explanation_upload_error['error'])){ echo form_label($explanation_upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                    			</div></div>
                    	<?php	//}                 			
                    	}else{ ?>
                   		<div class="form-group explanation-textimg-div">
							   <?php 
								 //echo form_label('Explanation ','explanation',array('class'=>'col-sm-2 control-label')); 
								 echo form_label('Explanation ','explanation',array('class'=>'col-sm-2 control-label')); 
							   ?>
							<!-- <div class="col-sm-4"> -->
										<?php
										//$js = 'id="explanation" class="form-control"';
										//echo form_textarea('explanation',set_value('explanation'),'placeholder= "Explanation" '.$style.' class="form-control" id="explanation"'); 
										//if(form_error('explanation')) echo form_label(form_error('explanation'), 'explanation', array("id"=>"explanation-error" , "class"=>"error")); ?>
							<!-- </div> -->
							   <div class="col-sm-4">
                    				<?php	echo form_upload(array('id' => 'explanation', 'name' => 'explanation', 'class' => 'form-control', 'placeholder' => ''));  ?>
                    				<small>Allowed Types: gif,jpg,jpeg,png </small>
                    			
                    				<?php if(form_error('explanation')) echo form_label(form_error('explanation'), 'explanation', array("id"=>"explanation-error" , "class"=>"error"));?>
                    				<?php if(isset($explanation_upload_error['error'])){ echo form_label($explanation_upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                    			</div>
						   </div>
                   		<div class="form-group note_t">
				       			<div class="col-sm-2"></div>
						   		<div class="col-sm-4">
						   		<?php $note_text = "<ul><li>Text</li></ul>"; ?>
						   		<small> Note: use html tags (<?php echo htmlentities($note_text);?>) for bullet points.</small>
						   		</div>
						   	</div>
						   	<?php } ?>
							<div class="form-group">
								<?php echo form_label('Severity  <span class="required">*</span>','severity',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="severity" class="form-control"';
									echo form_dropdown('severity', $this->config->item('severity'), set_value('severity'), $js);
									if(form_error('severity')) echo form_label(form_error('severity'), 'severity', array("id"=>"severity-error" , "class"=>"error")); ?>
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
  <script>
  $(function() {
    var items = [ 'France', 'Italy', 'Malta', 'England', 
        'Australia', 'Spain', 'Scotland' ];
        
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
 
    $( "#search" )
      .autocomplete({
        minLength: 0,
        source: function( request, response ) {
          response( $.ui.autocomplete.filter(
            items, extractLast( request.term ) ) );
        },
        focus: function() {
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });
  });
  </script>