 <!-- Main Content -->
 <script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.min.js'; ?>"></script>
<div class="container-fluid">
    <div class="side-body">
        <div class="page-title"></div>
         <div class="row">
            <div class="col-xs-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title"><?php echo $this->lang->line('editmaterial');?></div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads" title="Back">Back</a>
						</div>
                    </div>
                    <?php if($_POST) { ?> 
                    	<input type="hidden" name="window_post" id="window_post" value="1"/>
                    <?php }else{ ?>
                    	<input type="hidden" name="window_post" id="window_post" value="0"/>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_downloads_form');				
								echo form_open_multipart('', $attributes); ?>

                        	<div class="form-group">
								<?php echo form_label('Course','course_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$course_list[""]="Free";
									$js = 'id="courselist" class="form-control"';
									$set_course = isset($_POST['course_list'])?$_POST['course_list']: (isset($downloads->course_id) ? $downloads->course_id : '');
									echo form_dropdown('course_list', $course_list,$set_course, $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error"));?>
								</div>
							</div>
							  
							<div class="form-group">
								<?php echo form_label('Class <span class="required">*</span>','class_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="classlist" class="form-control"';
									$set_class = isset($_POST['class_list'])?$_POST['class_list']: (isset($downloads->class_id) ? $downloads->class_id : '');
 
									echo form_dropdown('class_list', $class_list, $set_class, $js);
									if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error"));?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Subject <span class="required">*</span>','subject_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="subjectlist" class="form-control"';
									$set_subject = isset($_POST['subject_list'])?$_POST['subject_list']: (isset($downloads->subject_id) ? $downloads->subject_id : '');
									echo form_dropdown('subject_list', $subject_list, $set_subject, $js);
									if(form_error('subject_list')) echo form_label(form_error('subject_list'), 'subject_list', array("id"=>"subject_list-error" , "class"=>"error"));?>
								</div>
							</div>


							<div class="form-group">
								<?php echo form_label('Chapter <span class="required">*</span>','chapter_list',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									$js = 'id="chapterlist" class="form-control"';
									$set_chapter = isset($_POST['chapter_list'])?$_POST['chapter_list']: (isset($downloads->chapter_id) ? $downloads->chapter_id : '');
									echo form_dropdown('chapter_list', $chapter_list, $set_chapter, $js);
									if(form_error('chapter_list')) echo form_label(form_error('chapter_list'), 'chapter_list', array("id"=>"chapter_list-error" , "class"=>"error"));?>
								</div>
							</div>



                            <div class="form-group">
                            	<?php echo form_label('Material Name <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
                            
									<?php 
									echo form_input('name', isset($_POST['name'])?$_POST['name']: (isset($downloads->download_name) ? $downloads->download_name : '') ,'placeholder= "Name" class="form-control" id="name"'); 
		               				if(form_error('name')) echo form_label(form_error('name'), 'name', array("id"=>"name-error" , "class"=>"error")); ?>
                                 </div>
							</div>
							


							<?php 
							$arr= array();
							foreach($attachments as $key => $attach){
							$arr[] = $attach->attachment;
							$arr_name[] = $attach->attachment_name;
							$ext = pathinfo($attach->attachment, PATHINFO_EXTENSION);
								?>
                            <div class="form-group" id="div_<?php echo $attach->id;?>"> 
                            	<?php echo form_label('Attachment','attachment',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
                                	<?php //echo $attach->attachment_name;?>
									<?php 
									if(($attach->attachment) != '' && $ext == "pdf"){
										$attach_src = base_url().'appdata/attachments/' .$attach->attachment; ?>
                                     	<a href="<?php echo $attach_src; ?>" target="_blank"><?php echo $attach->attachment_name; ?></a>
                                    <?php }else {?>
										<a href="<?php echo "https://www.youtube.com/watch?v=".$attach->attachment; ?>" target="_blank"><?php echo $attach->attachment_name; ?></a>
									<?php } ?>

                                     <a style='color:#F90202;' class='remove_add button_remove' href='javascript:void(0);' id='<?php echo $attach->id;?>' value='-' data-filename="<?php echo $attach->attachment;?>"  data-name="<?php echo $attach->attachment_name;?>"><span class='icon glyphicon glyphicon-trash'></span>Remove</a>
                                     <br>
                                    <?php if(form_error('attachment')) echo form_label(form_error('attachment'), 'attachment', array("id"=>"attachment-error" , "class"=>"error"));?>
		               				<?php if(isset($upload_error['error'])) { echo  form_label($upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                   					<?php if(isset($upload_error['error1'])) { echo  form_label('<p>'.$upload_error['error1'].'</p>','upload-error',array('class'=>'error'));  } ?>
                                 </div>
							</div>

						<?php } 

						?>
						<div class="add_input_field">        

							</div>
							<?php //if(form_error('attachment')) echo form_label(form_error('attachment'), 'attachment', array("id"=>"attachment-error" , "class"=>"error"));?>
                   					<?php //if(isset($upload_error['error'])) { echo  form_label($upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                   					<?php //if(isset($upload_error['error1'])) { echo  form_label('<p>'.$upload_error['error1'].'</p>','upload-error',array('class'=>'error'));  } ?>


						<div class="form-group">
                                <div class="col-sm-5 topspace">
								<div style=""><a  href="javascript:void(0)" id="add-more-course" class="add_input pull-right"><span class="glyphicon glyphicon-plus"></span>Add More</a></div>
                                 </div>
                            </div>


						<input type="hidden" name="counter_add" id="counter_add" value="-1">
						<input type="hidden" name="old_images" id="old_images"  value="1"/>
						<input type="hidden" name="old_images_name" id="old_images_name"  value="1"/>

						  <script type="text/javascript">
                                var arr = <?php echo json_encode($arr);?>;
                                var arr_name = <?php echo json_encode($arr_name);?>;
                                $('#old_images').val(arr);
                                $('#old_images_name').val(arr_name);

                          </script>
                          <?php
							foreach($attachments as $attach){?>
                          	<script type="text/javascript">
                                    $("#<?php echo $attach->id;?>").click(function(){

                                      var itemtoRemove=$("#<?php echo $attach->id;?>").data('filename');
                                      arr.splice($.inArray(itemtoRemove, arr),1);

                                      var itemtoRemovename=$("#<?php echo $attach->id;?>").data('name');
                                      arr_name.splice($.inArray(itemtoRemovename, arr_name),1);


                                      $('#div_<?php echo $attach->id;?>').hide();
                                	  $('#old_images').val(arr);
                                	  $('#old_images_name').val(arr_name);
                                      console.log($('#old_images').val());
                                      console.log($('#old_images_name').val());
                                    });
                           </script>
                       	<?php }?>

						
							<div class="form-group">
                            	<?php echo form_label('Description <span class="required">*</span>','comments',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php 
									echo form_textarea('comments', isset($_POST['comments'])?$_POST['comments']: (isset($downloads->comments) ? $downloads->comments : '') ,'class="form-control" id="comments"'); 
		               				if(form_error('comments')) echo form_label(form_error('comments'), 'attachment', array("id"=>"comments-error" , "class"=>"error")); ?>
                                 </div>
							</div>
			 				<div class="form-group">
                            	<?php echo form_label('Status <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4 topspace">
		                            <?php if(($downloads->status) ==1){?>
									<?php echo form_radio('status', '1',TRUE,'class="align_radio"'); ?> 
									<?php if($from == "view_and_approve"){?>
									<?php echo form_label('Approve','name',array('class'=>'align_label')); ?>
									<?php } else { ?>
									<?php echo form_label('Active','name',array('class'=>'align_label')); ?>
									<?php } ?>
									<?php echo form_radio('status', '0','','class="align_radio"'); ?> 
									<?php if($from == "view_and_approve"){?>
									<?php echo form_label('Not Approve','name',array('class'=>'align_label')); ?>
									<?php } else { ?>
									<?php echo form_label('Inactive','name',array('class'=>'align_label')); ?>
									<?php } ?>
									<?php }else{?>
									<?php echo form_radio('status', '1','','class="align_radio"'); ?> 
									<?php if($from == "view_and_approve"){?>
									<?php echo form_label('Approve','name',array('class'=>'align_label')); ?>
									<?php } else { ?>
									<?php echo form_label('Active','name',array('class'=>'align_label')); ?>
									<?php } ?>
									<?php echo form_radio('status', '0',TRUE,'class="align_radio"'); ?> 
									<?php if($from == "view_and_approve"){?>
									<?php echo form_label('Not Approve','name',array('class'=>'align_label')); ?>
									<?php } else { ?>
									<?php echo form_label('Inactive','name',array('class'=>'align_label')); ?>
									<?php } ?>
									<?php } ?>
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
	            //$(".add_input_field").append("<div class='form-group'> <label for='attachment_name' class='col-sm-2 control-label'>Attachment name <span class='required'>*</span></label> <div class='col-sm-4'><input type='text' name='attachment_name[]' value='' id='attachment_name' class='attachment_name-error'> </div></div><div class='form-group'> <label for='attachment' class='col-sm-2 control-label'>Attachment <span class='required'>*</span></label> <div class='col-sm-4'><input type='file' name='attachment[]' id='attachment' class='attachment-upload'> <small>Please upload .pdf,.mp4 files only <br>Maxiumum upload file size is 2 MB</small><br><a style='color:#F90202;' class='remove_add' href='javascript:void(0);'><span class='icon glyphicon glyphicon-trash'></span>Remove</a></div></div>"); 
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
	                htmlDiv += "<div class='form-group' style='text-align: right;'><div class='col-sm-4'><a style='color:#F90202;' class='remove_add_edit' href='javascript:void(0);'>";
				    htmlDiv += "<span class='icon glyphicon glyphicon-trash'></span>Remove</a></div></div>";
			    $(".add_input_field").append(htmlDiv); 
			    var counter = $('#counter_add').val();
				counter = parseInt(counter) +1;
           		$('#counter_add').val(counter);
			    radioBtnNameSet();
	    });
	    $(document).on("click", "a.remove_add" , function() {
	        $(this).parent().parent().remove();
	         var counter = $('#counter_add').val();
	         counter = parseInt(counter) -1;
            $('#counter_add').val(counter);
	    });

		$(document).on("click", "a.remove_add_edit" , function() {
			var index = $(".remove_add_edit").index(this);
			 //index = index + 1;
			 $(".material-attachment-type").eq(index).remove();
			 $(".material-attachment-name").eq(index).remove();
			 $(".material-attachment").eq(index).remove();
			 $(".material-attachment-youtube").eq(index).remove();
			 $(".remove_add_edit").eq(index).remove();
	         var counter = $('#counter_add').val();
	         counter = parseInt(counter) -1;
             $('#counter_add').val(counter);
			 radioBtnNameSet();
	    });
		
   });

</script>

