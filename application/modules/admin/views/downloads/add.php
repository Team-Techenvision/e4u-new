 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
        <div class="page-title"></div>
         <div class="row">
            <div class="col-xs-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title"><?php echo $this->lang->line('addmaterial');?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads" title="Back">Back</a>
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
								echo form_open_multipart('', $attributes); ?>
                            
							<div class="form-group">
								<?php echo form_label('Course','course_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									// $course_list[""]="Free";	
									$course_list[""]="Select";	

									$js = 'id="courselist" class="form-control"';
									echo form_dropdown('course_list', $course_list, isset($_POST['course_list'])?$_POST['course_list']:'', $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error"));?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Class <span class="required">*</span>','class_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="classlist" class="form-control"';
									echo form_dropdown('class_list', $class_list, isset($_POST['class_list'])?$_POST['class_list']:'', $js);?>
								<?php if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error"));
                   						?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Subject <span class="required">*</span>','subject_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="subjectlist" class="form-control"';
									echo form_dropdown('subject_list', $subject_list, isset($_POST['subject_list'])?$_POST['subject_list']:'', $js);?>
									<?php if(form_error('subject_list')) echo form_label(form_error('subject_list'), 'subject_list', array("id"=>"subject_list-error" , "class"=>"error"));
                   						?>
								</div>
							</div>


							<div class="form-group">
								<?php echo form_label('Chapters <span class="required">*</span>','chapter_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$chapter_list[""]="Select";
									$js = 'id="chapterlist" class="form-control"';
									echo form_dropdown('chapter_list', $chapter_list, isset($_POST['chapter_list'])?$_POST['chapter_list']:'', $js);?>
									<?php if(form_error('chapter_list')) echo form_label(form_error('chapter_list'), 'chapter_list', array("id"=>"chapter_list-error" , "class"=>"error"));
                   						?>
								</div>
							</div>



							<div class="form-group">
                            		<?php echo form_label('Material Name <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('name',set_value('name'),'placeholder= "Name" class="form-control" id="name"'); ?> 
                   					<?php if(form_error('name')) echo form_label(form_error('name'), 'name', array("id"=>"name-error" , "class"=>"error"));
                   						?>
                                 </div>
                            </div>
                           
                            <input type="hidden" name="counter_add" id="counter_add" value="0">
							
							
                            <div class="form-group material-attachment-type">
                            	<?php echo form_label('Attachment Type <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                                 <div class="col-sm-4 topspace">
									<?php echo form_radio('attachment-type-0[]', '0',TRUE,'class="align_radio attachment-type"  id="active" rdIndex="0"' ); ?> 
									<?php echo form_label('PDF','active',array('class'=>'align_label')); ?>
									<?php echo form_radio('attachment-type-0[]', '1','','class="align_radio attachment-type" id="inactive" rdIndex="0"'); ?> 
									<?php echo form_label('YouTube','inactive',array('class'=>'align_label')); ?>
								 </div>
                            </div>

                            <div class="form-group material-attachment-name">
                            		<?php echo form_label('Attachment name <span class="required">*</span>','attachment_name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input(array('id' => 'attachment_name', 'name' => 'attachment_name[]', 'class' => 'attachment_name-error')); ?>
                                 </div>
                            </div>
							 
							   <div class="form-group material-attachment">
									<?php echo form_label('Attachment <span class="required">*</span>','attachment',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<?php echo form_upload(array('id' => 'attachment', 'name' => 'attachment[]', 'class' => 'attachment-upload')); ?> 
									   <small>Please upload .pdf files only <br> Maxiumum upload file size is 2 MB</small>
									</div>
								</div>

								<div class="form-group material-attachment-youtube" style="display:none">
										<?php echo form_label('YouTube Key <span class="required">*</span>','youtube_key',array('class'=>'col-sm-2 control-label')); ?>
									<div class="col-sm-4">
										<?php echo form_input(array('id' => 'youtube_key', 'name' => 'youtube_key[]', 'class' => 'youtube_key-error')); ?>
									</div>
								</div>
                         
                              <div class="add_input_field">        

							</div>
							<?php if(form_error('attachment')) echo form_label(form_error('attachment'), 'attachment', array("id"=>"attachment-error" , "class"=>"error"));?>
                   					<?php if(isset($upload_error['error'])) { echo  form_label($upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                   					<?php if(isset($upload_error['error1'])) { echo  form_label('<p>'.$upload_error['error1'].'</p>','upload-error',array('class'=>'error'));  } ?>

                            <div class="form-group">
                                <div class="col-sm-5 topspace">
								<div style=""><a  href="javascript:void(0)" id="add-more-course" class="add_input pull-right"><span class="glyphicon glyphicon-plus"></span>Add More</a></div>
                                 </div>
                            </div>
                            <div class="form-group">
                            		<?php echo form_label('Description <span class="required">*</span>','comments',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_textarea('comments',set_value('comments'), 'class="form-control" id="comments"'); ?> 
                   					<?php if(form_error('comments')) echo form_label(form_error('comments'), 'comments', array("id"=>"comments-error" , "class"=>"error"));?>
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

<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.min.js'; ?>"></script>
<script type="text/javascript">
    function radioBtnNameSet(cnt){
		var radLen = $(".material-attachment-type").length;
		if(radLen > 0){
			for(var i = 0; i < radLen; i++ ){
				$(".material-attachment-type").eq(i).find('div').find('input').attr('name', "attachment-type-"+(i)+"[]");
				$(".material-attachment-type").eq(i).find('div').find('input').attr('rdIndex', i);
				$(".material-attachment-type").eq(i).find('div').find('input').addClass('attachment-type');
			}
		}	
	}


    
	$(document).ready(function(){
		$(document).on("click", ".attachment-type" , function() {
            var rdIndex = $(this).attr('rdIndex');  
			var rdCheckedVal = $(this).val();
			if(rdCheckedVal == 1){
				$(".material-attachment").eq(rdIndex).hide();
				$(".material-attachment-youtube").eq(rdIndex).show();
			}else{
				$(".material-attachment").eq(rdIndex).show();
			    $(".material-attachment-youtube").eq(rdIndex).hide();	
			}
		});
	    $("a.add_input").click(function(e){
	            e.preventDefault();
				var htmlDiv = '<div class="form-group material-attachment-type">';
					htmlDiv += '<label class="col-sm-2 control-label">Attachment Type <span class="required">*</span></label>';                               
					htmlDiv += '<div class="col-sm-4 topspace">';
					htmlDiv += '<input type="radio" name="attachment-type[]" value="0" checked="checked" class="align_radio" id="active">';
					htmlDiv += '<label for="active" class="align_label" style="padding-left: 5px;"> PDF</label>	';								
					htmlDiv += '<input type="radio" name="attachment-type[]" value="1" class="align_radio" id="inactive">';
					htmlDiv += '<label for="inactive" class="align_label" style="padding-left: 5px;"> YouTube</label>';								 
					htmlDiv += '</div>';
					htmlDiv += '</div>';
					htmlDiv += "<div class='form-group material-attachment-name'>"; 
					htmlDiv += "<label for='attachment_name' class='col-sm-2 control-label'>Attachment name <span class='required'>*</span></label>";
					htmlDiv += "<div class='col-sm-4'><input type='text' name='attachment_name[]' value='' id='attachment_name' class='attachment_name-error'> </div></div>";
					htmlDiv += "<div class='form-group material-attachment'>";
					htmlDiv += "<label for='attachment' class='col-sm-2 control-label'>Attachment <span class='required'>*</span></label>";
					htmlDiv += "<div class='col-sm-4'><input type='file' name='attachment[]' id='attachment' class='attachment-upload'>";
					htmlDiv += "<small>Please upload .pdf files only <br>Maxiumum upload file size is 2 MB</small> </div></div>";
					htmlDiv += "<div class='form-group material-attachment-youtube' style='display:none'>"; 
					htmlDiv += "<label for='youtube_key' class='col-sm-2 control-label'>YouTube key<span class='required'>*</span></label>";
					htmlDiv += "<div class='col-sm-4'><input type='text' name='youtube_key[]' value='' id='youtube_key' class='youtube_key-error'></div></div>";
	                htmlDiv += "<div class='form-group' style='text-align: right;'><div class='col-sm-4'><a style='color:#F90202;' class='remove_add' href='javascript:void(0);'>";
				    htmlDiv += "<span class='icon glyphicon glyphicon-trash'></span>Remove</a></div></div>";
			    $(".add_input_field").append(htmlDiv); 
	            var counter = $('#counter_add').val();
				counter = parseInt(counter) +1;
           		$('#counter_add').val(counter);
				radioBtnNameSet();
	    });
	    $(document).on("click", "a.remove_add" , function() {
	        //$(this).parent().parent().remove();
			 var index = $(".remove_add").index(this);
			 index = index + 1;
			 $(".material-attachment-type").eq(index).remove();
			 $(".material-attachment-name").eq(index).remove();
			 $(".material-attachment").eq(index).remove();
			 $(".material-attachment-youtube").eq(index).remove();
			 $(".remove_add").eq(index-1).remove();
			 //console.log( "index", index);
	         var counter = $('#counter_add').val();
	         counter = parseInt(counter) -1;
             $('#counter_add').val(counter);
			 radioBtnNameSet();
	    });
   });

</script>