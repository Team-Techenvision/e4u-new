<section class="register-wrapper">
		<h3 style="text-align:center;margin-bottom:10px;font-weight:bold;color:green"><?php if(isset($success_title)){ echo $success_title; }?></h3>
		<p style="text-align: center;line-height: 29px;margin-bottom:13px;"><?php if(isset($success_msg)){ echo $success_msg; }?></p>

            <div class="container">
               <div class="register-innercontainer">
                  <div class="row">
                     <div class="col-lg-6 col-md-12  signup-wrapper">
                        <div class="register-signup">
                           <h2> Sign Up </h2>
                           <form action="#" method="post"  enctype="multipart/form-data">
                              <div class="form-group input-group">
                                 <input type="text" class="form-control first-name" name="first-name" id="usr"  value="<?php echo set_value('first-name');?>" placeholder="First Name *">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><img src="<?php echo base_url().'assets/site/images/register/user-icon.png';?>"></span>
                                 </div>
                                 <?php if(form_error('first-name')) echo form_label(form_error('first-name'), 'first-name', array("id"=>"first-name-error" , "class"=>"error-msg"));
                                 ?>
                              </div>
                              
                              <div class="form-group input-group">
                                 <input type="text" class="form-control lastname" name="last-name" id="last-name" placeholder="Last Name *" value="<?php echo set_value('last-name');?>">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><img src="<?php echo base_url().'assets/site/images/register/user-icon.png';?>"></span>
                                 </div>
                                 <?php if(form_error('last-name')) echo form_label(form_error('last-name'), 'last-name', array("id"=>"last-name-error" , "class"=>"error-msg"));
                                 ?>
                              </div>
                              
                                 <div class="form-group input-group gender">
                                 <label class="col-md-4 col-sm-4">Gender <?php $val = set_value('gender');?> <span class="required">*</span></label>
                                     <div class="col-md-8 col-sm-8">
                                        <ul>
                                           <li>
                                              <input type="radio" id="male" name="gender" value="1" checked <?php if($val==1) { echo "checked"; }?>>
                                                        <label for="male">Male</label>
                                          </li>
                                          <li>
                                              <input type="radio" id="female" name="gender" value="2"  <?php if($val==2) { echo "checked"; }?>>
                                                       <label for="female">Female</label>
                                          </li>
                                       </ul>
                                     </div>
                                 </div>
                              <div class="form-group input-group">
                                 <input type="text" value="<?php echo set_value('email');?>" class="form-control" id="email" name="email" placeholder="Your email ID *">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><img src="<?php echo base_url().'assets/site/images/register/email.png';?>"></span>
                                 </div>
                                 <?php if(form_error('email')) echo form_label(form_error('email'), 'email', array("id"=>"email-error" , "class"=>"error-msg"));
                                 ?>
                              </div>
                              
                              <div class="form-group input-group">
                                 <input type="password" class="form-control" id="pwd" name="password" placeholder="Password *">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><img src="<?php echo base_url().'assets/site/images/register/password.png';?>"></span>
                                 </div>
                                 <?php if(form_error('password')) echo form_label(form_error('password'), 'password', array("id"=>"password-error" , "class"=>"error-msg"));
                                 ?>
                              </div>
                                
                              <div class="form-group input-group">
                                 <input type="password" class="form-control" id="cpwd" name="confirm-password" placeholder="Confirm Password *">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><img src="<?php echo base_url().'assets/site/images/register/password.png';?>"></span>
                                 </div>
                                 <?php if(form_error('confirm-password')) echo form_label(form_error('confirm-password'), 'confirm-password', array("id"=>"confirm-password-error" , "class"=>"error-msg"));
                                 ?>
                              </div>
                               
                              <div class="form-group input-group">
                                 <input type="text" class="form-control" id="contact" value="<?php echo set_value('contact-number');?>" name="contact-number" placeholder="Contact Number *">
                                 <div class="input-group-append">
                                    <span class="input-group-text"><img src="<?php echo base_url().'assets/site/images/register/contact.png';?>"></span>
                                 </div>
                                 <?php if(form_error('contact-number')) echo form_label(form_error('contact-number'), 'contact-number', array("id"=>"contact-number-error" , "class"=>"error-msg"));
                                 ?>
                              </div>
                              
                              <div class="form-group ">
                                 <label for="exampleFormControlTextarea1">Contact Address <span class="required">*</span></label>
                                 <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="contact-address" 
                                    placeholder="Type Address here..."><?php echo set_value('contact-address');?></textarea>
                                    <?php if(form_error('contact-address')) echo form_label(form_error('contact-address'), 'contact-address', array("id"=>"contact-address-error" , "class"=>"error-msg"));
                                 ?>
                              </div>
                             
                              <div class="form-group  dob">
                               <label for="exampleFormControlTextarea1" class="label-dob">Date Of Birth <span class="required">*</span></label>
                                <?php $dob_date = 'id="days" class="form-control sel-pick"'; $date =  array(" "=>"Date");
          								     echo form_dropdown('dob_date', $date, set_value('dob_date'), $dob_date); 
          								      //if(form_error('dob_date')) echo form_label(form_error('dob_date'), 'dob_date', array("id"=>"dob_date-error" , "class"=>"error-msg"));
          								     ?>
            								 <?php $dob_month = 'id="months" class="form-control sel-pick"'; $date =  array(" "=>"Month");
            								  echo form_dropdown('dob_month', $date, set_value('dob_month'), $dob_month); 
            								   //if(form_error('dob_month')) echo form_label(form_error('dob_month'), 'dob_month', array("id"=>"dob_month-error" , "class"=>"error-msg"));
            								 ?>
            								 <?php $dob_year = 'id="years" class="form-control sel-pick year"'; $date =  array(" "=>"Year");
            								  echo form_dropdown('dob_year', $date, set_value('dob_year'), $dob_year); 
            								 //if(form_error('dob_year')) echo form_label(form_error('dob_year'), 'dob_year', array("id"=>"dob_year-error" , "class"=>"error-msg"));
            								 
                              if(form_error('dob_year') || form_error('dob_month') || form_error('dob_date')) echo form_label("Please Enter Valid Date of Birth", 'dob_year', array("id"=>"dob_year-error" , "class"=>"error-msg"));
                              ?>

                              </div>
                              <div class="form-group classess">
                               <?php $js = 'id="exampleFormControlSelect1" class="form-control sel-pick"'; $class_list[""] = "Select Classes *";
         								         echo form_dropdown('class_list', $class_list, set_value('class_list'), $js);
         								       if(form_error('class_list')) echo form_label(form_error('class_list'), 'class_list', array("id"=>"class_list-error" , "class"=>"error-msg"));
         								      ?>
                              </div>
                              <div class="form-group register-btn">
                                 <button type="submit" class="btn-btn"> Sign Up
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-12 ">
                        <div class="register-account">
                           <h2>Have an account ? </h2>
                           <p>Welcome Back Student. Please  login into your account</p>
                           <div class="form-group">
                              <button class="btn-btn menu-btn" href="#myModal" data-toggle="modal"> Login </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- End of Register wrapper -->    
<?php
	$this->load->view('home/login');
?>
       