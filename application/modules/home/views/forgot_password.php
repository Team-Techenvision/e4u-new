<div class="login-popupmain">
	<div class="account-creation">
		<h3>Forgot Password</h3>
		<p>Please refer your registered <br />mail id to get the link to <br />reset your password.</p>
	</div>
	<div class="popup-login-section">
		<h2 class="popup-logo">e4u</h2>
		<?php  $attributes = array('class' => 'normal popuplogin','id' => 'forgot_form');				
		echo form_open('', $attributes, array('login'=>true)); ?>
			<div class="input text email">
				<?php echo form_input('email', (!isset($_POST['email'])?"":$_POST['email']) ,'placeholder="Email ID" id="email"'); ?>
				<span class="mail-icon input-icon"></span>
				<?php if(form_error('email')) echo form_label(form_error('email'), 'email', array("id"=>"email-error" , "class"=>"error")); ?>
			</div>
			<div class="submit">
				<input type="button" onclick="valid_forgot()" id="submit" class="btn btn-primary" title="Submit" value="Submit" name="submit">
			</div>
		<?php echo form_close();  ?>
	</div>
</div>
