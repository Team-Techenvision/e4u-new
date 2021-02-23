<div class="ans_desc_popup">
	<h2>Performance Tips</h2	>
	<div class="uploadnow-content-main clearfix">
		<div id="preloader1" class="pre-loader"></div>
		<?php  $attributes = array('class' => 'normal popup_performance','id' => 'performance-form-id');
	  	echo form_open('tests/submit_performance_tips', $attributes, array('performance'=>true)); ?>
	  	<?php echo form_input(array('name' => 'user_id', 'type'=>'hidden', 'id' =>'user_id','class'=>'user_id','value' => $user_id));?>
	  	<?php echo form_input(array('name' => 'exam_code', 'type'=>'hidden', 'id' =>'exam_code','class'=>'exam_code','value' => $exam_code));?>
	  	<div class="input text">
	  		<?php echo form_label('Title <span>*</span>','title'); ?>
			<?php echo form_input('title', $get_tips['tips_title'], 'id="title"'); ?>
			<?php if(form_error('title')) echo form_label(form_error('title'), 'title', array("id"=>"title-error" , "class"=>"error"));?>
	  	</div>
		<div class="input textarea">
			<?php echo form_label('Tips <span>*</span>','tips'); ?>
			<?php echo form_textarea('tips', $get_tips['tips'], 'id="tips"'); ?>
			<?php if(form_error('tips')) echo form_label(form_error('tips'), 'tips', array("id"=>"tips-error" , "class"=>"error"));?>
		</div>
		<div class="submit">
			<input type="submit" id="update" value="Submit" title="Submit"/>
		</div>
		<?php echo form_close();  ?>
	</div>
</div>
<script>
$( document ).ready(function() {
$("#performance-form-id").submit(function(){
	$("#preloader1").show();
    var formData = new FormData($(this)[0]);
	var url=$("#performance-form-id").attr('action');
	var $this=$(this);
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {  
        	$("#preloader1").hide();
            var data=jQuery.parseJSON($.trim(data));
            
        	$("#performance-form-id input,textarea").each(function() {
				$(this).next('span').remove();
			});
        	$(this).next('span').remove();
        	if(data.status=="error") {
        		$.each(data.errorfields,function(key, value){
        			var error="<span style='color:red;' class='login-error'>"+value.error+"</span>";
        			$this.find("[name="+value.field+"]").after(error);
        		});
        	}else{
        		var success = '<span class="download-success-message">Done! Performance tips submitted successfully</span>';
        		$(".uploadnow-content-main").first().prepend(success);
        		setTimeout(function(){
					$('.fancybox-close').trigger('click');
				},2000);
        	}
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
	});
});
</script>


