<div class="login-popupmain resetpopup-main">
	<div class="account-creation">
		<h3>Change Password</h3>
		<p>To change your password, <br />Please refer your registered <br />mail id to get the link to<br />reset your password.</p>
	</div>
	<div class="popup-login-section change-pass-wrap">
		<?php  $attributes = array('class' => 'normal popuplogin','id' => 'login_form');				
		echo form_open('', $attributes, array('login'=>true)); ?>
			<div class="input text current_pass">
				<?php echo form_password('current_password', (!isset($_POST['current_password'])?"":$_POST['current_password']) ,'placeholder="Current Password" id="current_password"'); ?>
				<span class="password-icon input-icon"></span>
			</div>
			<div class="input text new_pass">
				<?php echo form_password('new_password', (!isset($_POST['new_password'])?"":$_POST['new_password']) ,'placeholder="New Password" id="new_password"'); ?>
				<span class="password-icon input-icon"></span>
			</div>
			<div class="input text confirm_pass">
				<?php echo form_password('confirm_password', (!isset($_POST['confirm_password'])?"":$_POST['confirm_password']) ,'placeholder="Confirm Password" id="confirm_password"'); ?>
				<span class="password-icon input-icon"></span>
			</div>
			<div class="submit">
				<?php echo form_submit('submit', 'Submit', 'title="Submit" class="btn btn-primary click" id="submit"'); ?>
			</div>
		<?php echo form_close();  ?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){ 
	
	$(".btn-primary").on('click',function(e){ 
		var url=base_url + "profile/action_change_pass";
			var $this = $(this);
			$.ajax({
				type: "POST",
		        url: url,
		        datatype:"json",
		        data: $("#login_form").serialize(), 
		        success:function(data)
		        {
		        	var data=jQuery.parseJSON($.trim(data));
		        	
		        	$("#login_form input").each(function() {
						$(this).next('.login-error').remove();
					});
		        	$(this).next('.login-error').remove();
		        	if(data.status=="error") {
		        		$.each(data.errorfields,function(key, value){
		        			var error="<span style='color:red;' class='login-error'>"+value.error+"</span>";
		        			$("#login_form").find("[name="+value.field+"]").after(error);
		        		});
		        	}else{
		        		$(".current_pass").before("<span class='green' style='line-height:20px;display:block;text-align:center;'>Password changed successfully.</br>Redirecting to login page...</span>");
						$(".green").css("color", "green");
							setTimeout(function(){
								window.open(base_url+"home/logout/login","_self");
							},2000);
		        	}
		        }
			});
			return false;
	});
});

</script>
