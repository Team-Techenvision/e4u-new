   <!-- Modal -->
      <div class="modal fade login-blureffect2" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog login-dialog" role="document">
            <div class="modal-content login-content">
               <div class="modal-body login-bdy">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><img src="<?php echo base_url().'assets/site/images/close-cross.png';?>"></span>
                  </button>        
                  <div class="login-select-section" id="login_tab">
                     <div class="popup-login-section" >


        <?php   if($this->session->userdata('success')!=""){ ?>
		<div class="alert alert-success alert-dismissible" style="color:green;margin-bottom: 10px;text-align: center;" role="alert">
			<strong>Done!</strong> <?php echo $this->session->userdata('success'); ?>
			<?php $this->session->unset_userdata('success'); ?>
		</div> 
		<?php } ?>
		<?php if($this->session->userdata('failure')!=""){ ?>
		  <div id="error_msg"> <?php echo $this->session->userdata('failure'); ?>
			<?php $this->session->unset_userdata('failure'); ?>
		</div> 
		<?php } ?>
		
		<div class="confirm-div"></div>
		<?php if($this->session->flashdata('flash_failure_message')){ ?>
		<div class="alert alert-danger" role="alert">
			<strong>Warning!</strong> <?php echo $this->session->flashdata('flash_failure_message'); ?>
			<?php $this->session->unmark_flash('flash_failure_message'); ?>
		</div> 
		<?php } ?>
		
		<?php if($this->session->flashdata('flash_success_message')){ ?>
		<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Done!</strong> <?php echo $this->session->flashdata('flash_success_message'); ?>
			<?php $this->session->unmark_flash('flash_success_message'); ?>
		</div> 
		<?php } ?>  

                        <form class="login-form" id='login-form' role="form" action="<?php echo base_url().'home/login';?>" method="post"  enctype="multipart/form-data" autocomplete="off">

                           <h2>Login</h2>
                           <label id="error_msg" class="error-msg"></label>
                           <br>
                           <div class="form-group login-input">
                           	<?php $cookie_email = isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>
                              <input type="text" autocomplete="off" value="<?php echo $cookie_email;?>" class="form-control" id="usrname" name="email" placeholder="Your email ID">
                              <span class="mail-box"><img src="<?php echo base_url().'assets/site/images/message.png';?>"></span>
                           </div>
                           <div class="form-group login-input">
                           	<?php $cookie_pass = isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>
                              <input type="password"  autocomplete="off" value="<?php echo $cookie_pass;?>" class="form-control" id="psw" name="password" placeholder="Password">
                              <span class="mail-box"><img src="<?php echo base_url().'assets/site/images/key.png';?>"></span>
                           </div>
                           <div class="checkbox login-check">
                              <!-- <label> <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">Remember me</label> -->
                              <label class="rember-sec">Remember me
                              	<?php if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){ $checked = "checked";} else{ $checked = " "; } ?>
                              <input type="checkbox"  name="remember" id="remember" <?php echo $checked;?>> 
                              <span class="checkmark" id="checkhigh"></span>
                              </label>
                           </div>
                           <div class="login-forget-btn">
                              <a href="#" class="forget"> Forgot Password ?</a>
                           </div>
                           <div class="login-btn">
                              <button type="submit" class="btn btn-success btn-block ajax-login"><span class=""></span> Login<img src="<?php echo base_url().'assets/site/images/arrow.png';?>"></button>
                           </div>
                        </form>                          
                     </div>
                     <div class="account-creation">
                        <h3>Don't have an <br>account?</h3>
                        <p>To access all the features sign up <br>by 
                           filling in the given details
                        </p>
                        <a href="<?php echo base_url().'home/register';?>"  >Sign up<img src="<?php echo base_url().'assets/site/images/arrow.png';?>"></a>
                     </div>
                  </div> 
                  <div class="login-select-section" id="forget_tab">
                    <div class="popup-login-section froget-psd" >
                    <form class="login-form frgt-psd" id='forgot_form' action="<?php echo base_url().'home/action_forgot_password';?>" method="post" role="form">
                       <h2>Forgot Password</h2>
                       <div class="form-group login-input">
                        <input type="text" class="form-control" name='frgt_email' id="frgt_email" placeholder="Your email ID">
                        <span class='frgt_email'></span>
                        <span class="mail-box"><img src="<?php echo base_url().'assets/site/images/message.png';?>"></span>
                       </div>
                       <div class="login-btn">
                        <button type="submit" class="btn btn-success btn-block ajax-login"><span class=""></span> Submit<img src="<?php echo base_url().'assets/site/images/arrow.png';?>"></button>
                       </div>
                    </form> 
                    </div>  
                  </div> 
               </div>
            </div>
         </div>
      </div>

      <script>
         $('#checkhigh').keydown(function(e){      
    if(e.keyCode == 13 || e.keyCode == 32){
       $('span', this).click();        
    }
    if(e.keyCode != 9) return false;
});
         </script>

