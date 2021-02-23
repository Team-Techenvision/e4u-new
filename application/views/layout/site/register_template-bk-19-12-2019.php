<!doctype html>
<html lang="en">
 <head>
  <title>E4U - Home</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/site/" ?>favicon.ico" />
  <meta name="format-detection" content="telephone=no">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
 <?php $this->load->view('layout/site/common-header');  ?> 
 </head>
 <body class="home">
    <div id="preloader1" class="pre-loader"></div>
        <?php $this->load->view('layout/site/register-header'); ?>
	<div class="page-wrapper">
		<?php  $this->load->view('layout/site/main_content');  ?> 
	</div>
	<?php if($_GET['view_mode']!='app'){?>
 	<?php $this->load->view('layout/site/footer');  ?> 
 	<?php } ?>
 </body>
</html>
  <script>
     $('.forget').click(function() {
       $(".close").addClass("frgt-close");
           $('#login_tab').hide();           
             $('#forget_tab').show();            
         });     
         $('#myModal').on('hidden.bs.modal', function () {
      location.reload();      
    });
   
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
          // $('#days').html('');
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
         <?php if(set_value('dob_date')){ ?>
          var date = "<?php echo set_value('dob_date');?>" ;$('#days').val(date)
         <?php } ?>
          <?php if(set_value('dob_month')){ ?>
          var month = "<?php echo set_value('dob_month');?>" ; $('#months').val(month)
          <?php } ?>
           <?php if(set_value('dob_year')){ ?>
          var year ="<?php echo set_value('dob_year');?>" ;$('#years').val(year) 
          <?php } ?>
          
         
              
      </script>
<script>
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
              //alert(base_url+data.url);
              window.open(base_url+data.url,'_self');
            }             
              }
            }
        });
        return false;
    });
    
  });

$('#forgot_form').on('submit',function(e){
    valid_forgot();
    return false;
  });
  function valid_forgot(){
    $(".frgt_email").html("");
   var email = $("#frgt_email").val();
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

   $(".error-msg").remove();
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
      url: url + "?email=" +  email,
      cache: false,
      DataType:"JSON",
      success: function(result){
        $("#preloader1").hide();
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
