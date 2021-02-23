<?php 
	if($this->session->has_userdata('admin_is_logged_in')){ ?>
		 <div class="row content-container">
  	<?php $this->load->view('layout/admin/top_menu');
			$this->load->view('layout/admin/side_menu');  }  ?>
								<?php /*** Main Content Here **/
								if( $main_content ) { 
									$this->load->view($main_content); 
								}
								/*** Main Content end here **/ ?>
				
	<?php if($this->session->has_userdata('admin_is_logged_in')){ ?>
			</div>
	<?php } ?>

