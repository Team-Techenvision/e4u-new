<div class="uploadnow-content-main clearfix">
	<div id="preloader1" class="pre-loader"></div>
	<?php  $attributes = array('class' => 'normal popupdownloads','id' => 'download-form-id');
		   echo form_open_multipart('', $attributes, array('download'=>true)); ?>
		<div class="input text">
			<?php echo form_label('Title <span>*</span>'); ?>
			<?php echo form_input('download_name', set_value('download_name'), 'id="download-name"'); ?>
		</div>
		
		<div class="input text upload">
			<?php echo form_label('Upload File (Unlimited Files upload) <span>*</span>'); ?>
			<div class="custom-upload">
				
				<?php echo form_upload(array('id' => 'attachment', 'name' => 'attachment[]', 'class' => 'attachment', 'multiple' => '','accept' => '.pdf,.doc,.mp3,.mp4,.rar,.docx,.zip,.swf')); ?>
				<div class="fake-file"><span>Click here to Browse</span></div>
			</div>
			<span class="upload-hint">(Please upload only .pdf,.doc,.docx,.mp3,.mp4,.swf,.rar or .zip files.</br> Maximum upload file size is 2MB)</span>
		</div>
		<input type="hidden" value="<?php echo $course_id; ?>" name="target_course" id="target_course" />
		<div class="input textarea">
			<?php echo form_label('Comments <span>*</span>'); ?>
			<?php echo form_textarea('comments', set_value('comments'), 'id="comments"'); ?>
		</div>
		<div class="submit">
			<input type="submit" value="UPLOAD NOW" />
			<input course="<?php echo $course_id; ?>" id="reset-form" type="reset" value="CANCEL" />
		</div>
	<?php echo form_close();  ?>
</div>
<script>
$( document ).ready(function() {
$("form#download-form-id").submit(function(){
	$("#preloader1").show();
    var formData = new FormData($(this)[0]);
	var url=$("#download-form-id").attr('action');
	var $this=$(this);
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {  
        	$("#preloader1").hide();
            var data=jQuery.parseJSON($.trim(data));
            
        	$("#download-form-id input,textarea").each(function() {
				$(this).next('span').remove();
			});
			$(".custom-upload").next('.login-error').remove();
        	$(this).next('span').remove();
        	$(".uploadnow-content-main").find(".download-success-message").remove();
        	if(data.status=="error") {
        		$.each(data.errorfields,function(key, value){
        			var error="<span style='color:red;' class='login-error'>"+value.error+"</span>";
        			$this.find("[name="+value.field+"]").after(error);
        			if(value.field == "attachment"){
        				var replace_string = error.replace('enter','choose');
        				$this.find(".custom-upload").after(replace_string);
        			}
        		});
        	}else{
        		var success = '<span class="download-success-message">Upload Successfully. Admin has to approve your material.</span>';
        		$(".uploadnow-content-main").first().prepend(success);
        		$('form#download-form-id')[0].reset();
        		$('.fake-file span').html('Click here to Browse');
        	}
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});
$('#attachment').livequery('change',function() {
	var filenames = $.map(this.files, function (file) {
		return file.name;
	});
	if(filenames.length <= 1)
	{
		$(".fake-file span").html(filenames.join(', '));
	}
	else
	{
		$(".fake-file span").html(filenames.length+" Files Selected");
	}
			
});
$("#reset-form").click(function(){
	$.fancybox.close();
});
});
</script>
