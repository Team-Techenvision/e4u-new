<!DOCTYPE html>
<html lang="en">
   <head>
    <style type="text/css">
      .pagination_dashboard{
            letter-spacing: 10px;
            font: 17px Gotham-Bold;
            display:inline;
            color:#666666;
      }
      .pagination_dashboard a{
            color:#666666;
      }
      .pagination_dashboard.active{
            color:black;
      }
    </style>
      <meta charset="utf-8">
      <title><?php if(!empty($page_title)): echo $page_title; else: echo 'Dashboard - E4U'; endif; ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/site/" ?>favicon.ico" />
      
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <meta content="" name="keywords">
      <meta content="" name="description">
       <?php $this->load->view('layout/site/common-header');  ?> 
   </head>
   <body>
       <div id="preloader1" class="pre-loader"></div>
    
      <!--==========================
         Header Start
         ============================-->
      <div class="page-wrapper alert-container create-container">
         <div class="header-innerwrapper">
            <?php
              $this->load->view('layout/site/dashboard-header');
            	$this->load->view('layout/site/dashboard_subheader');
              
            ?>
         </div>
       
         <!-- End of alert Wrapper -->
		  		 <?php 
            	  $this->load->view('layout/site/main_content');
            	?>
 	        <?php $this->load->view('layout/site/footer');  ?> 
         </div>
      </div>
      
         <!-- change password Modal -->
      <div class="modal fade" id="changemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog login-dialog" role="document">
            <div class="modal-content login-content">
               <div class="modal-body login-bdy">
                  <button type="button" class="close frgt-close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><img src="<?php echo base_url().'assets/site/images/close-cross.png';?>"></span>
                  </button>        
                <div class="login-select-section" id="change_tab">
            <div class="popup-login-section change-psd" >
            <form class="login-form change-psd" id='change_password' role="form">
               <h2>Change Password</h2>
               <span class="change_status"></span>
               <div class="form-group login-input">
                <input type="password" class="form-control" name='old_pswd' id='old_pswd'  placeholder="Old Password">
                <span class="old_pass"></span>
               </div>
               <div class="form-group login-input">
                <input type="password" class="form-control"  name='new_pswd' id='new_pswd' placeholder="New Password">
                <span class="new_pass"></span>
               </div>
                <div class="form-group login-input">
                <input type="password" class="form-control"  name='confirm_pswd' id='confirm_pswd' placeholder="Confirm Password">
                <span class="confirm_pass"></span>
               </div>
               <div class="login-btn">
                <button type="submit" class="btn btn-success btn-block"><span class=""></span> Submit<img src="<?php echo base_url().'assets/site/images/arrow.png';?>"></button>
               </div>
            </form> 
            </div>  
        </div>  
          </div>
            </div>
         </div>
      </div>
          <!-- change password Modal end-->
   </body>
   <script>
    $('#change_password').on('submit',function(e){
   change_password();
    return false;
  });

  function change_password(){
    var old_pass = $("#old_pswd").val();
    var new_pass = $("#new_pswd").val();
    var confirm_pass = $("#confirm_pswd").val();
    $(".error-msg").remove();
    $(".green").remove();
    var url = base_url + "home/check_confirm_valid";
    var confirm_valid = 0;
     $.ajax({
      type: "POST",
      url: url + "?old_pass="+old_pass,
      cache: false,
      DataType:"JSON",
      success: function(result){
           result=$.trim(result);
           var obj=$.parseJSON(result);
           var confirm_valid = obj.confirm_valid;
               if(parseInt(confirm_valid) == 0){
     $(".old_pass").append("<label class='error-msg'>Old Password does not match with your current Password.</label>");
   }
   else{ 
     $(".old_pass").html('');
    if(new_pass=='' && confirm_pass==''){
      $(".new_pass").append("<label class='error-msg'>Please enter the New Password.</label>");
      $(".confirm_pass").append("<label class='error-msg'>Please enter the Confirm Password.</label>");
    }
    else if(new_pass=='')
    {
      $(".new_pass").append("<label class='error-msg'>Please enter the New Password.</label>");
    }
    else if(confirm_pass=='')
      {
        $(".confirm_pass").append("<label class='error-msg'>Please enter the Confirm Password.</label>");
      }
    else if(new_pass != confirm_pass){
      $(".confirm_pass").append("<label class='error-msg'>New Password does not match with Confirm Password.</label>");
    }
    else if(new_pass.length < 6){
      $(".new_pass").append("<label class='error-msg'>Password should be greater than or equal to 6 characters.</label>");
    }
    
    else
    {
    var url = base_url + "home/action_change_password";
    $.ajax({
      type: "POST",
      url: url + "?new_pass="+new_pass+"&confirm_pass="+confirm_pass,
      cache: false,
      DataType:"JSON",
      success: function(result){
        if(result != ''){
          console.log(result);
                   result=$.trim(result);
                   var obj=$.parseJSON(result);
                   var valid_user = obj.valid_user;
                   var changed_status = obj.changed_status;
                   if(valid_user == 0){
                    $(".change_status").before("<label class='error-msg'>Unknown user.</label>");
                   }
                   else{
                    if(changed_status == 1){
                      if(!$(".green").is(":visible")){
                      $(".change_status").before("<span class='green'>Password changed successfully.</span>");         }
                      $(".green").css("color", "green");
                      setTimeout(function(){
                        window.open(base_url+'dashboard','_self');
                      },2000);
                   }
                   else{
                    $(".change_status").before("<label class='error-msg'>Password reset not successfull.</label>");
                   }
                   }
                }
      }
    });
    }
  }

 }
});
  return false;
}
   

   </script>
</html>