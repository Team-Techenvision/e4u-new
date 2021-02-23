 <?php if($main_content != "index_err" && $main_content != "faq/index"){
    $class="header-innerwrapper";
 }else{
  $class="class_new";
 } ?>
  <style>
.class_new{
  height: 130px !important;
} </style>
 <div class="<?php echo $class;?>">
              <header id="header-inner" class="header-inner fixed-top">
            <div class="container">                
          <div class="logo">
             <a href="<?php echo base_url();?>"><img src="<?php echo base_url().'assets/site/images/logo-inner.png';?>" alt="Logo" class="img-fluid"></a>
           </div>
              <nav>
                  <div class=" header-right">
                     <ul class="">
                        <li class="active">
                            <a class="menu-btn" href="#myModal" data-toggle="modal">Login </a>
                        </li>
                        <li class="">
                           <a href="<?php echo base_url().'home/register';?>" class="menu-btn">Register</a>
                        </li>
                     </ul>
                 
                  </div>
               </nav>
            <div class="menu-toggle">
                  <i class="fa fa-bars menubar"></i>
            </div>
            </div>
           </header>
         </div>