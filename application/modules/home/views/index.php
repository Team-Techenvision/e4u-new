 <?php if($this->session->flashdata('failure')){?>
   <script>
   alert("<?php echo $this->session->flashdata('failure');?>");
    </script>
<?php } ?>

<?php if($this->session->flashdata('success')){?>
   <script>
    alert("<?php echo $this->session->flashdata('success');?>");
    </script>
<?php } ?>

<?php if($this->session->flashdata('free_trial_expired')){?>
   <script>
    alert("<?php echo $this->session->flashdata('free_trial_expired');?>");
    </script>
<?php } ?>

<style type="text/css">
  .courses .courses-details span {
    font-size: 16px !important;
  }
  a.morelink {
  text-decoration:none;
  outline: none;
}
.morecontent span {
  display: none;
}
</style>


        <section class="courses"  data-aos="fade-down" data-aos-duration="2000"  data-aos-easing="ease-in-out">
            <div class="container">
                <div class="course-title">
                    <h1>Distinction of Courses </h1>
                </div>
                <div class="row">
                  <?php $i=0; $a='';?>
                <?php foreach($courses as $course){ ?>

                    <div class="col-md-4 col-sm-4 courses-details" data-aos="fade-up" data-aos-duration="3000"  data-aos-delay="50">
                        <img width="197px" height="197px" src="<?php echo base_url().'appdata/course_plans/'.$course['image'];?>" alt="courses">
                        <h2><?php echo $course['name'];?> </h2>
                        <p class="comment more"><?php echo htmlspecialchars_decode($course['description']);?> </p>
                      <?php $a=$i; $i++;?>
                         <?php //print_r($is_expired);print_r($check_purchased);?>
                        <?php 
                          if(isset($is_expired[$course['id']]))
                          {
                            $expired_val = $is_expired[$course['id']];
                          }
                        if(count($this->session->userdata('user_is_logged_in'))){ 
                           if(in_array($course['id'],$check_purchased) && $expired_val==1){ 

                              $url = base_url()."dashboard"; 
                              $attach =" ";
                              $word_subscribe = "My Courses";
                          
                           }else{

                              $url = "#payModal".$course['id']; 
                              $attach = 'id="pay_modal_link" data-toggle="modal"';
                              $word_subscribe = "Pay ".$currency." ".number_format($course['price'],2);
                           }
                        }else{ 
                          $url = "#myModal"; // href="#changemodal" data-toggle="modal"
                          $attach = 'id="login_modal_link" data-toggle="modal"';
                          $word_subscribe = "subscribe";
                        }
                        if($course['duration'] > 1)
                        {
                           $duration = $course['duration']." Months";  
                        } else { 
                           $duration = $course['duration']." Month";  
                        } 

                        ?>
                       <a href="<?php echo $url;?>" <?php echo $attach;?> class="course-1 course-btn" > 
                          <?php echo $word_subscribe;?><span class="icon"></span> 
									       </a>
                    </div>
                    <!-- modal start -->
                    <div class="modal fade" id="payModal<?php echo $course['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog login-dialog" role="document">
                              <div class="modal-content login-content">
                                 <div class="modal-body login-bdy">
                                    <button type="button" class="close frgt-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><img src="<?php echo base_url().'assets/site/images/close-cross.png';?>"></span>
                                    </button>        
                                  <div class="login-select-section" id="reset_tab">
                              <div class="popup-login-section reset-psd" >
                              <!--<form class="" id='subscribe_submit' role="form"> -->
                                <span class='green'></span>
                                 <h2><?php echo $course['name'];?></h2>
                                  <div>Duration : <?php echo $duration;?></div>                                  
                                  <?php
                                    $chosen_class_id = $user_data['class_id'];
                                    if(isset($course_relevant_classes[$course['id']]))
                                    {
                                      $class = $course_relevant_classes[$course['id']];
                                      if(in_array($chosen_class_id, $class)){
                                        ?>
                                        <div class="login-btn">
                                          <a href="<?php echo base_url();?>home/payment/<?php echo $course['id'];?>"><button type="submit" class="btn btn-success btn-block load_loader" ><span class="">Pay now </span><!-- <img src="<?php echo base_url().'assets/site/images/arrow.png';?>"> -->
                                        </button> </a>
                                        </div>
                                        <?php
                                      }else{
                                        ?>
                                        <div class="">
                                       <p>You are not allowed to purchase this course.
                                       Check your selected class. You can change class only once </p>
                                       </div>
                                        <?php
                                      }
                                    }
                                  ?>
                              <!--</form>-->
                              </div>  
                          </div> 
                        </div>
                       </div>
                     </div>
                   </div>
                  <!-- modal end -->
                  <?php }?>
                </div>
            </div>
        </section>



        <section class="registration" data-aos="fade-down" data-aos-duration="1500"  data-aos-easing="ease-in-out">
            <div class="registration-wrapper">
                <div class="container">
                    <div class="registration-title">
                        <h1>Registration Benefits</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="registration-image">
                               <img src="<?php echo base_url().'assets/site/images/create-profile.png';?>" alt="courses" data-aos="flip-left" data-aos-duration="3000"  data-aos-easing="ease-in-out">
                            </div>
                            <h2>Create Profile </h2>
                            <p>Maecenas non mauris in nisicursus consequat nec vitae curabitur at erat odionon </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="registration-image">
                                <img src="<?php echo base_url().'assets/site/images/subject-materials.png';?>" alt="courses" data-aos="flip-left" data-aos-duration="3000"  data-aos-easing="ease-in-out">
                            </div>
                            <h2>Subject Materials</h2>
                            <p>Maecenas non mauris in nisicursus consequat nec vitae curabitur at erat odionon </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="registration-image">
                                <img src="<?php echo base_url().'assets/site/images/practice.png';?>" alt="courses" data-aos="flip-left" data-aos-duration="3000"  data-aos-easing="ease-in-out">
                            </div>
                            <h2>Practice </h2>
                            <p>Maecenas non mauris in nisicursus consequat nec vitae curabitur at erat odionon </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="registration-image"> 
                               <img src="<?php echo base_url().'assets/site/images/adaptive.png';?>" alt="courses" data-aos="flip-left" data-aos-duration="3000"  data-aos-easing="ease-in-out">
                            </div>
                            <h2>Adaptive Assessment </h2>
                            <p>Maecenas non mauris in nisicursus consequat nec vitae curabitur at erat odionon </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="registration-image">
                               <img src="<?php echo base_url().'assets/site/images/goal-based.png';?>"  alt="courses" data-aos="flip-left" data-aos-duration="2000"  data-aos-easing="ease-in-out">
                            </div>
                            <h2>Goal Based Learning</h2>
                            <p>Maecenas non mauris in nisicursus consequat nec vitae curabitur at erat odionon </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="registration-image">
                               <img src="<?php echo base_url().'assets/site/images/performance.png';?>" alt="courses" data-aos="flip-left" data-aos-duration="2000"  data-aos-easing="ease-in-out">
                            </div>
                            <h2>Performance Report</h2>
                            <p>Maecenas non mauris in nisicursus consequat nec vitae curabitur at erat odionon </p>
                        </div>

                    </div>
                </div>
            </div>
        </section>
                          

        <section class="student-slider" data-aos="fade-down" data-aos-duration="1500"  data-aos-easing="ease-in-out">
            <div class="container">
                <div class="page-innercontainer">
                    <h2> What our students says </h2>
                    <?php //print_r($testi);die;?>
                    <div class="owl-carousel home-slider owl-theme">
                        <?php foreach($testi as $test){ ?>
                        <div class="slider-wrapper">
                            <div class="item">
                                <img src="<?php echo base_url().'appdata/testimonials/'.$test['user_image'];?>" alt="student-icon" class="profile-icon">

                                <p> <?php echo $test['user_description'];?>  </p>
                                <img src="<?php echo base_url().'assets/site/images/text-quotes.png';?>" class="text-quotes">
                                <h4> <?php echo $test['user_name'];?>   </h4>
                                <span><?php echo $test['about_client'];?>  </span>
                            </div>
                        </div>
                      <?php } ?>
                    </div>
                </div>
            </div>
        </section>
      
      <!-- RESET Modal -->
     
    <div class="modal fade" id="resetmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog login-dialog" role="document">
            <div class="modal-content login-content">
               <div class="modal-body login-bdy">
                  <button type="button" class="close frgt-close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><img src="<?php echo base_url().'assets/site/images/close-cross.png';?>"></span>
                  </button>        
                <div class="login-select-section" id="reset_tab">
            <div class="popup-login-section reset-psd" >
            <form class="login-form1 reset-psd" id='reset_pswd' role="form">
              <span class='green'></span>
               <h2>Reset Password</h2>
               <div class="form-group login-input success_before">
                <input type="password" class="form-control" id="new_password" placeholder="New Password">
                <span class="new_pass"></span>
               </div>
                <div class="form-group login-input">
                <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                <span class="confirm_pass"></span>
               </div>
               <div class="login-btn">
                <button type="submit" class="btn btn-success btn-block" ><span class=""></span> Submit<img src="<?php echo base_url().'assets/site/images/arrow.png';?>"></button>
               </div>
            </form> 
            </div>  
        </div> 
      </div>
     </div>
   </div>
 </div>
    
       

<?php
  $this->load->view('home/login');
?>
<?php 
if(isset($show_reset_modal) && $show_reset_modal==1){
?>
<script type="text/javascript">
  $('#resetmodal_link').trigger('click');
$('#reset_pswd').on('submit',function(e){
   valid_reset();
    return false;
  });

  function valid_reset(){
    var new_pass = $("#new_password").val();
    var confirm_pass = $("#confirm_password").val();
    var ref_id='<?php echo $ref;?>';
    $(".error-msg").remove();
    $(".green").remove();
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
    var url = base_url + "home/action_reset_password";
    $.ajax({
      type: "POST",
      url: url + "?new_pass="+new_pass+"&confirm_pass="+confirm_pass+"&id="+ ref_id,
      cache: false,
      DataType:"JSON",
      success: function(result){
        if(result != ''){
          // console.log(result);
                   result=$.trim(result);
                   var obj=$.parseJSON(result);
                   var valid_user = obj.valid_user;
                   var reset_pass = obj.reset;
                   if(valid_user == 0){
                    $(".new_pass").before("<label class='error-msg'>Unknown user.</label>");
                   }
                   else{
                    if(reset_pass == 1){
                      if(!$(".green").is(":visible")){
                      $(".success_before").before("<span class='success-msg'>Password changed successfully.</span>");         }
                      $(".green").css("color", "green");
                          setTimeout(function(){
                            window.open(base_url+"home/",'_self');
                          },2000);
                   }
                   else{
                    $(".new_pass").before("<label class='error-msg'>Password reset not successfull.</label>");
                   }
                   }
                }
      }
    });
    }
    return false;
  }
   

</script>
<?php
}
?>
<?php 
if(isset($show_reset_modal) && $show_reset_modal==2){
?>
  <script>
    $('#error_msg').html('The reset password url was expired.');
    $('#login_modal_link').trigger('click');
    setTimeout(function(){
      window.open(base_url+"home/",'_self');
     },2000);

  </script>
<?php }?> 
    
 <!-- Modal -->
 <script type="text/javascript">
   $('.load_loader').click(function(){
      $("#preloader1").show();
   });
 </script>
 <script>
   $(window).scroll(function(){
    if ($(this).scrollTop() > 50) {
       $('#header-inner').addClass('newClass');
    } else {
       $('#header-inner').removeClass('newClass');
    }
});
   </script>

   
      
<script type="text/javascript">
 $(document).ready(function() {
  var showChar = 50;
  var ellipsestext = "";
  var moretext = "View More";
  var lesstext = "Less";
  $('.more').each(function() {
    var content = $(this).html();

    if(content.length > showChar) {

      var c = content.substr(0, showChar);
      var h = content.substr(showChar-0, content.length - showChar);

      var html = c + '<span class="moreelipses"></span>&nbsp;<span class="morecontent "><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">'+moretext+'</a></span>';

      $(this).html(html);
    }

  });

  $(".morelink").click(function(){
    if($(this).hasClass("less")) {
      $(this).removeClass("less");
      $(this).html(moretext);
    } else {
      $(this).addClass("less");
      $(this).html(lesstext);
    }
    $(this).parent().prev().toggle();
    $(this).prev().toggle();
    return false;
  });
});
</script>    