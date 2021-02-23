<div class="login-popupmain">
	<div class="account-creation">
		<h3>Reset Password</h3>
		<p>Please refer your registered <br />mail id to get the link to <br />reset your password.</p>
	</div>
	<div class="popup-login-section">
		<h2 class="popup-logo">e4u</h2>
		<?php  $attributes = array('class' => 'normal popuplogin','id' => 'login_form');				
		echo form_open('', $attributes, array('login'=>true)); ?>
			<div class="input text new_pass">
				<?php echo form_password('new_password', (!isset($_POST['new_password'])?"":$_POST['new_password']) ,'placeholder="New Password" id="new_password"'); ?>
				<span class="password-icon input-icon"></span>
			</div>
			<div class="input text confirm_pass">
				<?php echo form_password('confirm_password', (!isset($_POST['confirm_password'])?"":$_POST['confirm_password']) ,'placeholder="Confirm Password" id="confirm_password"'); ?>
				<span class="password-icon input-icon"></span>
			</div>
			<div class="submit">
				<input type="button" onclick="valid_reset()" id="submit" class="btn btn-primary click" title="Submit" value="Submit" name="submit">
			</div>
		<?php echo form_close();  ?>
	</div>
</div>
<script type="text/javascript">
	$("#login_form input").keypress(function(e){
	var code = e.keyCode;
 
 	if(code == 13) {  
	  	$("#login_form").find("input[type='button']").trigger("click");
	  	return false;
 	}
});
</script>
