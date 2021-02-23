 		<?php if($main_content != "index_err" && $main_content != "faq/index" && $main_content != "contact_us/index"  && $main_content != "dashboard/thank-you" && $main_content != "dashboard/payment-failed" ){ 
            // && $main_content != "contact_us" && $main_content != "about_us" && $main_content != "privacy_policy"?>
 		 <div class="header-wrapper">
 		  <div class="page_content">
                <div class="banner-text" data-aos="fade-down" data-aos-duration="1500"  data-aos-easing="ease-in-out" >
                    <div class="container">
                        <?php print_r($banners[0]['description']);?>
                       <a href="<?php echo base_url()."dashboard";?>" class="banner-course btn-btn-dark"> Courses  </a>
                    </div>
                </div>
            </div>
        </div>
            <?php }?>