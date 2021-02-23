<!doctype html>
<html lang="en">
 <head>
  <title>E4U - home</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/site/" ?>favicon.ico" />
  <meta name="format-detection" content="telephone=no">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
<?php
$user_arr=$this->session->userdata('user_is_logged_in');
?>
 <?php $this->load->view('layout/site/common-header');  ?> 
 </head>
 <body>
   <div class="page-wrapper-main home-index">
       <div id="preloader1" class="pre-loader"></div>
  <?php //if($main_content != "index_err"){ ?>
      <?php 
      if(count($user_arr)==0){
        $this->load->view('layout/site/home-header');
    	}else{
        $this->load->view('layout/site/dashboard-header');  
        $this->load->view('layout/site/home-banner');  
      }
    	?> 
  <?php 
// }
  // else{
  //    if(count($user_arr)==0){
  //     $this->load->view('layout/site/register-header');
  //   }else{
  //     $this->load->view('layout/site/dashboard-header');  
  //   }
  // }
  ?>
  <div class="main-section">
		<?php  $this->load->view('layout/site/main_content');  ?> 
	</div>
	<?php if($_GET['view_mode']!='app'){?>
 	<?php $this->load->view('layout/site/footer');  ?> 
 	<?php } ?>
  </div>
<script>
   $('.forget').click(function() {
       $(".close").addClass("frgt-close");
              $('#login_tab').hide();           
              $('#forget_tab').show();            
         });     
         $('#myModal').on('hidden.bs.modal', function () {
              location.reload();      
         });

$(document).ready(function(){ 
  $("#login-form").on('submit',function(e){ 
      var url=$("#login-form").attr('action');
      var $this=$(this);
      $.ajax({
            type: "POST",
            url: url,
            datatype:"json",
            data: $("#login-form").serialize(), 
            success:function(data)
            {
              var global_path='';
              var data=jQuery.parseJSON($.trim(data));
              $("#login-form input").each(function() {
                $(this).next('.login-error').remove();
              });
              $(this).next('.login-error').remove();
              $("#error_msg").find('span.login-error').remove();
              if(data.status=="error") {
                $.each(data.errorfields,function(key, value){
                  var error="<span style='color:red;' class='login-error'>"+value.error+"</span>";
                  $this.find("[name="+value.field+"]").after(error);
                });
              }else if(data.status=="error-login") {
                var error="<span style='color:red;' class='login-error'>"+data.msg+"</span>";
                $("#error_msg").append(error);
                $("#error_msg").find('span.login-error').css('position','relative');
              }else{  
            if(global_path!=""){
              window.open(base_url+global_path,'_self');
            }else{
              // alert(base_url+data.url);
              window.open(base_url+data.url,'_self');
            }             
              }
            }
        });
        return false;
    });
    
  });
var imageUrl ="<?php echo base_url('appdata/banners/').$banners[0]['image'];?>";
$('.header-wrapper').css('background-image', 'url(' + imageUrl + ')');

$('#forgot_form').on('submit',function(e){
    valid_forgot();
    return false;
  });
  function valid_forgot(){
    $(".frgt_email").html("");
    
   var email = $("#frgt_email").val();
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
   $(".login-error").remove();
   $(".green").remove();
    if(email.length === 0 )
    {
       $(".frgt_email").html("<label class='error-msg'>Please enter the Email ID.</label>");
    }else if(!emailReg.test(email)){
      $(".frgt_email").html("<label class='error-msg'>Please enter a valid Email ID.</label>");
    }
    else
    {
    var url = base_url + "home/action_forgot_password";
     $("#preloader1").show();
    $.ajax({
      type: "POST",
      url: url + "?email="+email,
      cache: false,
      DataType:"JSON",
      success: function(result){
        $("#preloader1").hide();
        // alert(result);
        if(result != ''){
                      $(".frgt_email").html('');
                      result=$.trim(result);
                   var obj=$.parseJSON(result);
                   var valid_email = obj.valid_email;
                   var email_sent = obj.email_sent;
                   if(valid_email == 0){
                    $(".frgt_email").html("<label class='error-msg'>Email ID is not registered with us.</label>");
                   }
                   else{
                    if(email_sent == 1){
                      $("#forgot_form")[0].reset();
                      $('.frgt_email').html('<p style="text-align:center;margin-bottom:10px;font-weight:bold;color:green">Reset Link is sent to your registered email id.Please click on the link to reset your password.</p>')
                   }
                   else{
                    $(".frgt_email").before("<label class='error-msg' style='position: relative;top:-19px;left: 82px;'>Reset Link is not successfully sent to your registered email id. Try later.</label>");
                   }
                   }
                }
      }
    });
    }
    return false;
  }
</script>
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
   <?php $this->load->view('home/login'); ?>
 </body>
</html>