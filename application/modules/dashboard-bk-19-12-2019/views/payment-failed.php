<section class="payment-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						
						<div class="payment-content">
						    <img src="<?php echo base_url().'assets/site/images/paymeny-failed.jpg';?>" alt="Failure"/>
						    <h1>Payment Failed</h1>
							<p>
              <!-- Sorry. We were unable to process your payment  -->
             <?php if($this->session->flashdata('database_error')){?>
            <!-- <div class="failure-msg"> -->
              <?php echo $this->session->flashdata('database_error');?>
            <!-- </div> -->
            <?php } ?>
            </p>
						</div>
					</div>
				</div>
			</div>
</section>
 