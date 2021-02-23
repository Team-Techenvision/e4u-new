 <!-- header -wrapper -->
      <div class="editprofile-wrapper">
         <section class="edit-profile">
            <div class="container">
            	<form enctype="multipart/form-data" method="post" id="editProfileForm" action="<?php echo base_url().'profile'?>">
                 <div class="row">
                  <div class="picture-container">
                     <div class="picture">
                     	  <?php  
                     if($this->session->has_userdata('user_is_logged_in')){ 
                         $this->load->helper('profile_helper');
                         $user = user_data();
                          $class_added="profile-pic";
                         if($user[0]->profile_image!=""){
                         // $img_src = thumb($this->config->item('profile_image_url') .$user[0]->profile_image ,'thumb_profile_img',$maintain_ratio = TRUE);
                              $img_prp = array('src' => base_url() . 'appdata/profile/'.$user[0]->profile_image, 'alt' => 'Profile', 'title' =>strlen($user[0]->first_name." ".$user[0]->last_name)>16?substr(($user[0]->first_name." ".$user[0]->last_name),0,16):$user[0]->first_name." ".$user[0]->last_name , 'id' => 'wizardPicturePreview','class'=>$class_added , 'width'=>'148px' , 'height' => '148px');
                         }else{
                         	if($user[0]->gender == 1) {
                              $img_src = 'assets/site/images/no-image-men.png';
                         	}
                          	else{
                          	  $img_src = 'assets/site/images/no-image.png';	
                          	}
                           $img_prp=array('src' => base_url() .$img_src, 'alt' => 'Profile', 'title'=>strlen($user[0]->first_name." ".$user[0]->last_name)>16?substr(($user[0]->first_name." ".$user[0]->last_name),0,16):$user[0]->first_name." ".$user[0]->last_name, 'id' => 'wizardPicturePreview','class'=>$class_added , 'width'=>'148px' , 'height' => '148px');
                         }
                         ?>
                        <?php echo img($img_prp);?>
                        <span></span>
                     <?php } ?>
                      <!--   <img src="<?php //echo base_url().'assets/site/images/profile-icon.png';?>" id="wizardPicturePreview" title="" class="profile-pic"> -->
                        <input type="file" id="wizard-picture" name="upload_image_name" class="form-control" title="">
                     </div>
                     <img src="<?php echo base_url().'assets/site/images/profile-edit.png';?>"  id="wizard-picture" title="edit icon" class="edit-icon">
                  </div>
               </div>
               <div class="row">
			      <div class="profile-title">
			     		<h3 class="">
                     		<?php echo (strlen($user[0]->first_name." ".$user[0]->last_name)>16?substr(($user[0]->first_name." ".$user[0]->last_name),0,16):$user[0]->first_name." ".$user[0]->last_name);?>
                        </h3>
					 </div>
			   </div>    

                <div class="failure-msg"><?php if(isset($upload_error)){ echo $upload_error; }?></div>
                <div class="success-msg"><?php if(isset($success_msg)){ echo $success_msg; }?></div>
               <div class="row mrg-top">
                  <div class="col-lg-12 col-md-12">
                     <div class="form-row ">
                        <div class="form-group col-md-5">
                           <label for="inputEmail4">First Name <span class="required">*</span></label>
                           <?php $fname = isset($_POST['fname'])?$_POST['fname']: (isset($users[0]['first_name']) ? $users[0]['first_name'] : '');?>
                           <input type="text" value="<?php echo $fname;?>" name="fname" class="form-control" id="inputEmail4" placeholder="">
                            <?php if(form_error('fname')) echo form_label(form_error('fname'), 'fname', array("id"=>"fname-error" , "class"=>"error-msg"));?>
                           <span class="error-msg"> </span>
                        </div>
                        <div class="form-group col-md-2 empty-div">
                        </div>
                        <div class="form-group col-md-5">
                           <label for="inputPassword4">Last Name <span class="required">*</span> </label>
                             <?php $lname = isset($_POST['lname'])?$_POST['lname']: (isset($users[0]['last_name']) ? $users[0]['last_name'] : '');?>

                           <input type="text" value="<?php echo $lname;?>" name="lname" class="form-control" id="inputPassword4" placeholder="">
                            <?php if(form_error('lname')) echo form_label(form_error('lname'), 'lname', array("id"=>"lname-error" , "class"=>"error-msg"));?>
                            <span class="error-msg"> </span>
                        </div>
                     </div>
				 <?php if($users[0]['gender']== '1'){
				 	$checked_male = "checked";
				 	$checked_female = " ";	
				 }
				 if($users[0]['gender'] == '2'){
				 	$checked_male = " ";
				 	$checked_female = "checked";
				 }
				 ?>
				       <div class="form-row ">
				       	     <div class="form-group col-md-5 input-group gender">
 								<!-- <div class="form-group "> -->
                                 <label class="col-md-4 col-sm-4">Gender <span class="required">*</span></label>
                                     <div class="col-md-8 col-sm-8">
                                        <ul>
                                           <li>
                                              <input type="radio" id="male" name="gender" value="1" <?php echo $checked_male;?>>
                                              <label for="male">Male</label>
                                          </li>
                                          <li>
                                              <input type="radio" id="female" name="gender" value="2" <?php echo $checked_female;?>>
                                              <label for="female">Female</label>
                                          </li>
                                       </ul>
                                     </div>
                                 <!-- </div> -->
                            </div>
                             <div class="form-group col-md-2 empty-div">
	                        </div>
	                         <div class="form-group col-md-5 empty-div">
	                        </div>
                        </div>

                     <div class="form-row ">
                        <div class="form-group col-md-5">
                           <label for="inputEmail4">Your email Id <span class="required">*</span></label>
                            <?php $email = isset($_POST['email'])?$_POST['email']: (isset($users[0]['email']) ? $users[0]['email'] : '');?>
                           <input type="text" class="form-control" value="<?php echo $email;?>"  name="email" id="inputEmail4" placeholder="" readonly>
                            <?php if(form_error('email')) echo form_label(form_error('email'), 'email', array("id"=>"email-error" , "class"=>"error-msg"));?>
                            <span class="error-msg"> </span>
                        </div>
                        <div class="form-group col-md-2 empty-div">
                        </div>
                        <div class="form-group col-md-5">
                           <label for="inputPassword4">Phone Number <span class="required">*</span></label>
                            <?php $phone = isset($_POST['phone'])?$_POST['phone']: (isset($users[0]['phone']) ? $users[0]['phone'] : '');?>
                           <input type="text" class="form-control"  value="<?php echo $phone;?>" name="phone" id="inputPassword4" placeholder="">
                           <?php if(form_error('phone')) echo form_label(form_error('phone'), 'phone', array("id"=>"phone-error" , "class"=>"error-msg"));?>
                           <span class="error-msg"> </span>
                        </div>
                     </div>
                     <div class="form-row datespacing-issue">
                        <div class="form-group col-md-1 col-4">
                           <label for="exampleFormControlTextarea1" class="label-dob">DD <span class="required">*</span></label>
                           <!-- <select class="form-control" id="days"></select> -->
                            <?php $dob_date = 'id="days" class="form-control"'; $date =  array(" "=>"Date *");
                            $selected_date = isset($_POST['dob_date'])?$_POST['dob_date']: (isset($users[0]['dob_date']) ? $users[0]['dob_date'] : ' ');

								echo form_dropdown('dob_date', $date, set_value('dob_date'), $dob_date);
								if(form_error('dob_date')) echo form_label(form_error('dob_date'), 'dob_date', array("id"=>"dob_date-error" , "class"=>"error-msg"));
								 ?>
                        </div>
                        <div class="form-group col-md-2 col-4">
                           <label for="exampleFormControlTextarea1" class="label-dob">MM <span class="required">*</span></label>
                           <!-- <select class="form-control" id="months"></select> -->
                            <?php $dob_month = 'id="months" class="form-control"'; $date =  array(" "=>"Month *");
                            $selected_month = isset($_POST['dob_month'])?$_POST['dob_month']: (isset($users[0]['dob_month']) ? $users[0]['dob_month'] : '');
								echo form_dropdown('dob_month', $date, set_value('dob_month'), $dob_month);
								if(form_error('dob_month')) echo form_label(form_error('dob_month'), 'dob_month', array("id"=>"dob_month-error" , "class"=>"error-msg")) ?>
                        </div>
                        <div class="form-group col-md-2 col-4">
                           <label for="exampleFormControlTextarea1" class="label-dob">YY <span class="required">*</span></label>
                           <!-- <select class="form-control" id="years"></select> -->
                           <?php $dob_year = 'id="years" class="form-control"'; $date = array(" "=>"Year *");
                           $selected_year = isset($_POST['dob_year'])?$_POST['dob_year']: (isset($users[0]['dob_year']) ? $users[0]['dob_year'] : ' ');
								echo form_dropdown('dob_year', $date, set_value('dob_year'), $dob_year);
								if(form_error('dob_year')) echo form_label(form_error('dob_year'), 'dob_year', array("id"=>"dob_year-error" , "class"=>"error-msg")) ?>
                        </div>
                        <div class="form-group col-md-2 empty-div">
                        </div>
                        <div class="form-group col-md-5">
                           <label for="inputPassword4">Class <span class="required">*</span></label>
                          	<?php $set_class = isset($_POST['class_studying_id'])?$_POST['class_studying_id']: (isset($users[0]['class_id']) ? $users[0]['class_id'] : '');
          									echo form_dropdown('class_studying_id',$class_list,$set_class,'id="class_studying_id" class="form-control"'); 
          									if(form_error('class_studying_id')) echo form_label(form_error('class_studying_id'), 'class_studying_id', array("id"=>"class_studying_id-error" , "class"=>"error-msg"));?>
                            <label class="change">You can change class only once</label>
                        </div>
                     </div>
                     <div class="form-row justify-content-between">
                        <div class="form-group col-md-5">
                           <label for="inputEmail4">Contact Address <span class="required">*</span></label>          
                             <?php $address = isset($_POST['address'])?$_POST['address']: (isset($users[0]['address']) ? $users[0]['address'] : '');?>               
						            <textarea class="form-control"  name="address" id="exampleFormControlTextarea1" rows="3"
                                 placeholder=""><?php echo $address;?></textarea>
                                 <?php if(form_error('address')) echo form_label(form_error('address'), 'address', array("id"=>"address-error" , "class"=>"error-msg"));?>
                                 <span class="error-msg"> </span>
                        </div>
                        <?php $data_update=$this->session->userdata('user_is_logged_in');
                                 $id= $data_update["user_id"];  ?>
                        <div class="form-group col-md-5">
                           <label for="inputEmail4">Subcription Details </label>                 
						             
                                 <?php 
                                 $query = $this->db->query("SELECT DISTINCT(courses.name) FROM `user_plans` INNER JOIN courses ON (courses.id=user_plans.course_id) WHERE user_id=$id");
                                 $row = $query->result();
                                 foreach($row  as $r)
                                 { ?>
                                    <input type="text" value="<?php echo $r->name; ?>" class="form-control" readonly> 
                                <?php  }
                                 
                                  ?>
                               
                                 
                        </div>
                       
                     </div>
					 
					    <div class="form-row">
                        <div class="form-group col-md-12 text-center upadate">
						       <input type="submit" name="edit-submit" class="btn-normal" value="Update">                           
                        </div>
						
                     </div>
					 
                  </div>
               </div>
           </form>
            </div>
         </section>
         <section class="edit-subscription">
          <!--   <div class="container">
               <div class="row">
                  <div class="col-md-12 subscription-wrapper">
                     <h3> Subscription Detail</h3>
                     <div class="col-md-3 subscription-details">
                        <p>subscription plan </p>
                        <span>Grade 6th-10th </span>
                     </div>
                     <div class="col-md-3 subscription-details">
                        <p>Enrolled Date </p>
                        <span>10/08/19 </span>
                     </div>
                     <div class="col-md-3 subscription-details">
                        <p>Valid Till </p>
                        <span>09/08/20 </span>
                     </div>
                     <div class="col-md-3 subscription-details">
                        <p>PriCe </p>
                        <span> &#x20b9;</label> 500 </span>
                     </div>
                  </div>
               </div> -->
         </section>
         </div>
     <script type="text/javascript">
/* Data od Birth Script starts here */
           var monthNames = [ "January", "February", "March", "April", "May", "June",
           "July", "August", "September", "October", "November", "December" ];
         
         for (i = new Date().getFullYear(); i > 1900; i--){
           $('#years').append($('<option />').val(i).html(i));
         }
           
         for (i = 1; i < 13; i++){
           $('#months').append($('<option />').val(i).html(i));
         }
         updateNumberOfDays(); 
           
         $('#years, #months').on("change", function(){
           updateNumberOfDays(); 
         });
         function updateNumberOfDays(){
           month=$('#months').val();
           year=$('#years').val();
           days=daysInMonth(month, year);
         
           for(i=1; i < days+1 ; i++){
                   $('#days').append($('<option />').val(i).html(i));
           }
           $('#message').html(monthNames[month-1]+" in the year "+year+" has <b>"+days+"</b> days");
         }
         
         function daysInMonth(month, year) {
           return new Date(year, month, 0).getDate();
         }
         /* End of Date of Birth */
          var date = "<?php echo $selected_date;?>" ;
          var month = "<?php echo $selected_month;?>" ;
          var year ="<?php echo $selected_year;?>" ;
          $('#days').val(date);
          $('#months').val(month);
          $('#years').val(year);
          $(document).ready(function(){
            // Prepare the preview for profile picture
            $("#wizard-picture").change(function(){
            readURL(this);
            });

            $('#editProfileForm').on('submit', function() {
               var errorFlag = true;
               $("input[type=text]").each(function(i){
                   var placeholder = $(this).attr("placeholder"); 
                   var inputValue = $(this).val(); 
                     if(inputValue.length == 0){
                        errorFlag = false;
                        $(".error-msg").eq(i).html("The "+placeholder +" field is required")
                     }else{
                        $(".error-msg").eq(i).html("");
                     }
               });
               if($("#exampleFormControlTextarea1").val().length == 0 ){
                  $(".error-msg").eq(4).html("The Contact address field is required");
                  errorFlag = false;
               }
              return errorFlag;
            });

         });

         function readURL(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
               $('#wizardPicturePreview').attr({src: e.target.result,width:'148px',height:'148px'}).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
            }
         }
	</script>
