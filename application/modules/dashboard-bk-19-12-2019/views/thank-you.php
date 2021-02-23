	<section class="thankyou-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						
						<div class="thankyou-content">
						    <img src="<?php echo base_url().'assets/site/images/success.jpg';?>" alt="success"/>
						    <h1>Thank You </h1>
							<p> 
              <?php if($this->session->flashdata('already_purchased')){?>
            <!-- <div class="failure-msg"> -->
              <?php echo $this->session->flashdata('already_purchased');?>
            <!-- </div> -->
            <?php } else if($this->session->flashdata('payment_message')){?>
            <!-- <div class="success-msg"> -->
              <?php echo $this->session->flashdata('payment_message');?>
            <!-- </div> -->
            <?php }else{
                ?>
                 <script>
                $(document).ready(function(){
                   window.location.href = "<?php echo base_url('dashboard');?>";
                });
                </script>

                <?php
            } ?>
             </p>
        					
						</div>
					</div>
				</div>
			</div>
	</section>
