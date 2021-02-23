<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<style>
.error{
	color:red !important;
}
</style>

 <div class="contact-map" data-aos="fade-down" data-aos-duration="1500">
			<div class="location">
        <!--<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d91556.47853850463!2d-94.0474914797774!3d44.183583157436615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sCecilia%20Chapman%20711-2880%20Nulla%20St.%20Mankato%20Mississippi%2096522!5e0!3m2!1sen!2sin!4v1571825704342!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>-->
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3887.437923459356!2d80.24682231430475!3d13.00776121760451!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a526794024956a1%3A0x9bd7a9017c966c59!2sLand%20Marvel%20Group!5e0!3m2!1sen!2sin!4v1593776831097!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" ></iframe>
			</div> 
			
				<div class="contact-form">
				
			<div class="Contaction-Sec">
			<div class="row">
			
					<div class="loc-form-Sec col-md-8 col-sm-12" >
					<div class="thanks-msg" id="thank-you" style="display:none;">
					<p>You have successfully submitted your query</p>
					</div>
					<div class="loc-form-inner">
					<h2>Send Message</h2>
                        <form class="loc-form row" role="form" method="post" name="contact" id="contact" action="<?php echo base_url().'contact_us/enquiry';?>">
                           <div class="form-group location-input col-md-6">
							  <label>First Name <span class="required">*</span></label>
                              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="">
                           </div>
                           <div class="form-group location-input col-md-6">
							  <label>Last Name  <span class="required">*</span></label>
                              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="">
                          </div>
						   <div class="form-group location-input col-md-6">
							  <label>Email-id  <span class="required">*</span></label>
                              <input type="email" class="form-control" name="email_id" id="email_id" placeholder="">
                           </div>
                           <div class="form-group location-input col-md-6">
							  <label>Phone number  <span class="required">*</span></label>
                              <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="">
                          </div>
						   <div class="form-group location-input message col-md-10">
							  <label>Message  <span class="required">*</span></label>
                              <input type="text" class="form-control" name="message" id="message" placeholder="">
                          </div>
							<div class="contact-btn" id="button_sub">
							
                              
							   <button class="btn"><img src="<?php echo base_url().'assets/site/images/submit.png';?>"></button>
                           </div>
                        </form>					  							 
                     </div>
					 </div>
					 <div class="loc-cont-sec col-md-4 col-sm-12">
						<h2>CONTACT INFORMATION</h2>
						
						<p class="address-loc">No.19/20, Sannadi Street,
              Land Marvel Appartments, Sannadi St E Block,
              Ground Floor, Villivakkam, Chennai-600 049</p>
						<div class="cont-no">
              <p class="smartphone"><span><a href="tel:9884173423">9884173423</a></span>
              <!--<br><span><a href="">+91 9878654454</a></span>--></p>
					
							
						</div>
						<p class="envelope"><a href="mailto: sales@e4uclassrooms.com">sales@e4uclassrooms.com</a></p>
						<div class="cont-sociallink">
							<h3>GET IN TOUCH</h3>
							<a href=""><img src="<?php echo base_url().'assets/site/images/contact-fb.png';?>"></a>
							<a href=""><img src="<?php echo base_url().'assets/site/images/contact-google.png';?>"></a>
							<a href=""><img src="<?php echo base_url().'assets/site/images/contact-link.png';?>"></a>
							<a href=""><img src="<?php echo base_url().'assets/site/images/contact-insta.png';?>"></a>
							
						</div>

																
					  </div>
					  </div>
					 </div>
        </div>
			</div>
		
		<script>
		// Wait for the DOM to be ready
$(function() {
	
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='contact']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      first_name: "required",
      last_name: "required",
	  message: "required",
      email_id: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      phone_no: {
        required: true
      }
    },
    // Specify validation error messages
    messages: {
      first_name: "Please enter the First Name",
      last_name: "Please enter the Last Name",
      phone_no: "Please enter the Phone No",
	  email_id: {
        required: "Please enter the Email-id",
        email: "Please enter a valid Email-id"
      },
      message: "Please enter the Message"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
		$('#button_sub').html("<img src='<?php echo base_url();?>/assets/site/images/ajax-loader.gif' />");
		$.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
				$('#button_sub').html("<button class='btn'><img src='<?php echo base_url();?>/assets/site/images/submit.png'></button>");
                $('#thank-you').show();
				$("#contact")[0].reset();
				$("#first_name").focus();
				setTimeout(function() { 
                    $('#thank-you').fadeOut('fast'); 
                }, 5000); 
            }            
        });
    }
  });
});
		</script>