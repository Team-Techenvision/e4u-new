 <section class="tabcontent-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Tab panes -->
                <div class="tab-content">
                    
                    <div role="tabpanel" class="tab-pane  in active" id="Alerts">
                        <div class="alert-innerbox">
                            <div class="top-content	frequently">
                                <span> FAQ</span>
                            </div>
                            <div class="alert-content faq-page">
                                <div id="accordion" class="myaccordion">
								<?php $i=1; 
								foreach($faq as $key=>$value){  
									 if($i==1){ 
									 	$active = "active";$show="show";$expanded="true";
									 }else{ 
									 	$active="";$show="";$expanded="false";
									 }
									 ?>
								  <div class="card collapse<?php echo $i;?> <?php echo $active;?>">
									<div class="card-header" id="headingOne">
									  <h2 class="mb-0">
										<button class="d-flex align-items-center btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $i;?>" aria-expanded="<?php echo $expanded;?>" aria-controls="collapse<?php echo $i;?>">
										  <span class="fa-stack fa-sm">

											<i class="fa <?php if($i==1){ ?>fa-minus <?php } else { ?>fa-plus<?php } ?>" aria-hidden="true"></i>
										  </span>
										 <?php echo $value['question'];?>
										</button>
									  </h2>
									</div>
									<div id="collapse<?php echo $i;?>" class="collapse <?php echo $show;?>" aria-labelledby="headingOne" data-parent="#accordion">
									  <div class="card-body">
										<?php echo $value['answer'];?>
									  </div>
									</div>
								  </div>
									<?php $i=$i+1; } ?>
								</div>
                            </div>
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

 <script>
         /* Tab active class*/
         /*active icon change on tab */
         $( ".alert-wrapper .nav-item a" ).click(function() {	
          var currtab = $(this).attr('data-val');
          //alert(currtab); 
          if( currtab == "Dashboard")
          {
            $(".nav-link.active").find('img').attr('src', 'images/alert/alert-active.png');
          }
          else
          {
        	 $(".nav-link").find('img').attr('src', 'images/alert/dashboard-icon.png');
          }
         });
		 $("#accordion").on("hide.bs.collapse show.bs.collapse", e => {
		  $(e.target).
		  prev().
		  find("i:last-child").
		  toggleClass("fa-minus fa-plus");
		  
		});
		$(document).ready(function(){  
		  $(document).on('click','.card-header button',function(){
		    var currtab = $(this).attr('aria-controls');
			$('.card').removeClass("active");
			$('.'+currtab).addClass("active");
		  });
		}); 

      </script>


	
<?php
	$this->load->view('home/login');
?>