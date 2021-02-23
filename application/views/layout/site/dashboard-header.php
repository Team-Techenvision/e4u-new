          <header id="header-inner" class="header-inner home-header">
            <div class="container">    
            <div class="flex-header">          
             <div class="logo">
                 <a href="<?php echo base_url();?>"><img src="<?php echo base_url().'assets/site/images/logo-inner.png';?>" alt="Logo" class="img-fluid"></a>
              </div>

              <nav>
                  <div class=" header-right">
                     <ul class="">
                        <li class="<?php if($this->uri->segment(1)=='home' || $this->uri->segment(1)=='')  echo 'active'; ?>">
                          <a href="<?php echo base_url().'home';?>" class="menu-btn <?php if($this->uri->segment(1)=='home' || $this->uri->segment(1)=='')  echo 'active'; ?>">Home </a>
                        </li>
                        <li class="<?php if($this->uri->segment(1)=='about_us')  echo 'active'; ?>">
                            <a href="<?php echo base_url().'about_us';?>" class="menu-btn <?php if($this->uri->segment(1)=='about_us')  echo 'active'; ?>" >About us </a>
                        </li>
                        <li class=" <?php if($this->uri->segment(1)=='subscribe')  echo 'active'; ?>">
                           <a href="<?php echo base_url().'subscribe';?>" class="menu-btn <?php if($this->uri->segment(1)=='subscribe')  echo 'active'; ?>">Subscribe </a>
                        </li>
                        <li class="<?php if($this->uri->segment(1)=='contact_us')  echo 'active'; ?>">
                          <a href="<?php echo base_url().'contact_us';?>" class="menu-btn">Contact Us</a>
                        </li>
                        <li class="nav-item dropdown">
                          <!--  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <img src="images/profile-image.png" width="40" height="40" class="rounded-circle"> <span>Zhenya Rynzhuk </span>
                           </a> -->
                           <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php  
                                 if($this->session->has_userdata('user_is_logged_in')){ 
                                     $this->load->helper('profile_helper');
                                     $user = user_data();
                                      $class_added="rounded-circle";
                                     if($user[0]->profile_image!=""){
                                        $img_src = thumb($this->config->item('profile_image_url') .$user[0]->profile_image ,'40', '40', 'thumb_profile_img',$maintain_ratio = TRUE);
                                          $img_prp = array('src' => base_url() . 'appdata/profile/thumb_profile_img/'.$img_src, 'alt' => 'Profile', 'title' =>strlen($user[0]->first_name." ".$user[0]->last_name)>16?substr(($user[0]->first_name." ".$user[0]->last_name),0,16):$user[0]->first_name." ".$user[0]->last_name , 'class'=>$class_added, 'width' => '40','height' => '40');
                                     }else{ 
                                        if($user[0]->gender == 1) {
                                          $img_src = 'assets/site/images/no-image-men.png';
                                        }
                                        else{
                                          $img_src = 'assets/site/images/no-image.png'; 
                                        }
                                        
                                       $img_prp=array('src' => base_url() .$img_src,'40', '40', 'alt' => 'Profile', 'title'=>strlen($user[0]->first_name." ".$user[0]->last_name)>16?substr(($user[0]->first_name." ".$user[0]->last_name),0,16):$user[0]->first_name." ".$user[0]->last_name, 'class'=>$class_added, 'width' => '40','height' => '40');
                                     }
                                     ?>
                                    <?php echo img($img_prp);?>
                                    <span><?php echo (strlen($user[0]->first_name." ".$user[0]->last_name)>16?substr(($user[0]->first_name." ".$user[0]->last_name),0,16):$user[0]->first_name." ".$user[0]->last_name);?></span>
                                 <?php }?>
                              </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 <a class="dropdown-item" href="<?php echo base_url().'dashboard/'; ?>">Dashboard</a>
                                 <a class="dropdown-item" href="<?php echo base_url().'profile'; ?>">Edit Profile</a>
                                 <a class="dropdown-item" href="#changemodal" data-toggle="modal">Change Password</a>
                                 <a class="dropdown-item" href="<?php echo base_url().'home/logout'; ?>">Log Out</a>
                           </div>
                        </li>
                     
                     </ul>
            
                  </div>
               </nav>
         <div class="menu-toggle">
            <i class="fa fa-bars menubar"></i>
         </div>
         </div>
            </div>
         </header>


         
        <script>

       $(window). scroll(function(){
         if ($(this). scrollTop() > 50) {
         $('.home-header'). addClass('newClass');
         } else {
         $('.home-header'). removeClass('newClass');
         }
       });
       </script>