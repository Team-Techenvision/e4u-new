<section class="alert-wrapper">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12 col-md-12">
                     <div class="alert-box">
                        <ul class="nav nav-tabs" role="tablist">
                           <li class="nav-item">
                              <a class="nav-link <?php if($this->uri->segment(1)=='dashboard')  echo 'active'; ?>" href="<?php echo base_url().'dashboard/'; ?>" data-val="Dashboard" > 
                                  <span class="tab-icon">                          
                              </span> <label> Dashboard </label></a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link <?php if($this->uri->segment(1)=='my-alerts')  echo 'active'; ?>" href="<?php echo base_url().'alerts'; ?>"  data-val="Alerts" >
                              <span class="tab-icon">
                              
                              </span> <label> Alerts</label></a>
                           </li>
                           <li class="nav-item">
                             <!--  <a class="nav-link" href="#Profile" role="tab" data-val="Profile" data-toggle="tab"><span class="tab-icon"> -->
                              <a class="nav-link <?php if($this->uri->segment(1)=='profile')  echo 'active'; ?>" href="<?php echo base_url().'profile'; ?>" >
                              <span class="tab-icon">
                            
                              </span> <label> My Profile </label></a>
                           </li>
                           <li class="nav-item <?php if($this->uri->segment(1)=='leaderboard')  echo 'active'; ?>">
                              <a class="nav-link" href="<?php echo base_url().'leaderboard'; ?>" data-val="leader">
                              <span class="tab-icon"></span> <label> Leaderboard </label></a>
                           </li>
                           <li class="nav-item <?php if($this->uri->segment(1)=='create_tests')  echo 'active'; ?>">
                              <a class="nav-link" href="<?php echo base_url().'create_tests'; ?>"  data-val="ctest">
                              <span class="tab-icon"></span> <label> Create Test </label></a>
                           </li>
                           <li class="nav-item <?php if($this->uri->segment(1)=='meeting')  echo 'active'; ?>">
                              <a class="nav-link" href="<?php echo base_url().'meeting'; ?>"  data-val="ctest"><span class="tab-icon">
                                 </span> <label> Meeting</label></a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
         </section>