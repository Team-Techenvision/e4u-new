	   <footer id="footer" class="faa-parent" data-aos="fade-down" data-aos-duration="2000"  data-aos-easing="ease-in-out">
            <div class="footer-wrapper">
                <div class="container">
                    <div class="col-lg-12 col-md-12">
                        <div class="download-app">
                            <h4>Download App on </h4>
                            <div class="download-img">
                                <img src="<?php echo base_url().'assets/site/images/google-pay.jpg';?> " class="img-center  faa-pulse animated-hover faa-slow.">
                                <img src="<?php echo base_url().'assets/site/images/app-store.jpg';?> " class="img-center  faa-pulse animated-hover faa-slow.">
                            </div>

                        </div>
                    </div>

                    <div class="footer-bottom" data-aos="fade-down" data-aos-duration="1000"  data-aos-easing="ease-in-out">
                        <div class="row">
                            <div class="col-lg-5 col-md-12">
                                <div class="footer-menu">
                                    <ul>
                                       <?php 
                                        if($this->uri->segment(2) == "standard_detail"){
                                       ?>
                                        <a href="#" title="Home"><li> Home  </li></a>
                                        <a href="#" title="About Us"><li> About Us </li></a>
                                        <a href="#" title="Courses"><li> Courses </li></a>
                                        <a href="#" title="FAQ's"><li> FAQ's </li></a>
                                        <a href="#" title="Contact US"><li> Contact US </li></a>
                                        <a href="#" title="Privacy Policy"><li> Privacy Policy </li></a>
                                        <?php } else {?>
                                        <a href="<?php echo base_url();?>" title="Home"><li> Home  </li></a>
                                        <a href="<?php echo base_url().'about_us';?>" title="About Us"><li> About Us </li></a>
                                        <a href="<?php echo base_url().'subscribe';?>" title="Courses"><li> Courses </li></a>
                                        <a href="<?php echo base_url().'faq';?>" title="FAQ's"><li> FAQ's </li></a>
                                        <a href="<?php echo base_url().'contact_us';?>" title="Contact US"><li> Contact US </li></a>
                                        <a href="<?php echo base_url(). 'privacy';?>" title="Privacy Policy"><li> Privacy Policy </li></a>
                                        <?php }?>   
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="footer-socialmenu">
                                    <span> Follow Us </span>
                                    <img src="<?php echo base_url().'assets/site/images/facebook.png';?> " class="img-center">
                                    <img src="<?php echo base_url().'assets/site/images/twitter.png';?> " class="img-center">
                                    <img src="<?php echo base_url().'assets/site/images/instagram.png';?> " class="img-center">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="footer-copyright">
                                    <p> Copyrights @<?php echo date("Y")?> E4U. All Rights Reserved </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </footer>

    <!-- JavaScript Libraries -->
       <script src="<?php echo base_url().'assets/site/js/main.js?'.time();?>"></script> 
       <!-- for displaying dashboard carousal in dashboard page -->
        


        <script>
		    $('.forget').click(function() {
			 $(".close").addClass("frgt-close");
         	 $('#login_tab').hide();         	 
             $('#forget_tab').show();
			 
         });
         		
         $(document).ready(function() {
         
         // Gets the video src from the data-src on each button
         var $imageSrc;  
         $('.gallery img').click(function() {
             $imageSrc = $(this).data('bigimage');
         });
         console.log($imageSrc);
           
           
           
         // when the modal is opened autoplay it  
         $('#myModal').on('shown.bs.modal', function (e) {
             
         // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
         
         $("#image").attr('src', $imageSrc  ); 
         })
           
           
         // reset the modal image
         $('#myModal').on('hide.bs.modal', function (e) {
             // a poor man's stop video
             $("#image").attr('src',''); 
         }) 
         // document ready  
         });
         
         
         
            $(document).ready(function() {

                $('.home-slider').owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: true,
                    center: true,
                    autoplay: false,
                    pagination: false,
                    dots: false,
                    navText: ["<img src='<?php echo base_url().'assets/site/images/left-arrow.jpg';?>' alt='arrow'>",
                        "<img src='<?php echo base_url().'assets/site/images/right-arrow.jpg';?>' alt='arrow'>"
                    ],
                    autoplay: true,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        1000: {
                            items: 3,

                        }
                    }
                })

            });
        </script>