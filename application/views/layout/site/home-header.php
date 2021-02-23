 <?php if($main_content != "index_err" && $main_content != "faq/index"  && $main_content != "contact_us/index" ){
    $class="header-wrapper";
 }else{
  $class="class_new";
 } ?>
 <style>
.class_new{
  height: 130px !important;
} </style>
        <div class="<?php echo $class;?>">

             <header id="header-inner" class="header-inner">
            <div class="container"> 
                            
             <div class="logo">
               
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url().'assets/site/images/logo.png';?>" alt="Logo" class="img-fluid"></a>
              </div>
              <nav>
                  <div class=" header-right">
                     <ul class="">
                         <li class=""><a href="#myModal"  class="menu-btn" id='login_modal_link' data-toggle="modal">Login </a></li>
                             <li><a href="<?php echo base_url().'home/register';?>" class="menu-btn">Register</a></li>
                              <li style='display: none;'><a href="#resetmodal" id='resetmodal_link' class="menu-btn" data-toggle="modal">Reset</a></li>
                     </ul>
                      
                  </div>
               </nav>
               <div class="menu-toggle">
                        <i class="fa fa-bars menubar"></i>
               </div>
              
            </div>
         </header>
           <?php if($main_content != "index_err" && $main_content != "faq/index"  && $main_content != "contact_us/index" ){ ?>
            <div class="page_content">
                <div class="banner-text" data-aos="fade-down" data-aos-duration="1500"  data-aos-easing="ease-in-out" >
                    <div class="container">
                        <?php print_r($banners[0]['description']);?>
                       <!--  <p> Your Success <span>Companion For Every Exam</span> </p> -->
                        <a href="<?php echo base_url()."dashboard";?>" class="banner-course btn-btn-dark"> Courses  </a>
                    </div>
                </div>
            </div>
              <?php } ?>
        </div>
        <!-- header -wrapper -->


