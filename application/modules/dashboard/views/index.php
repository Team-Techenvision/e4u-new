<!---dashboard section--->
<style>
	.text
	{
		height:40px;
		overflow:hidden;
	}
	.text.active
	{
		height:auto;
	}
	  .courses .courses-details span {
    font-size: 16px !important;
	  }
	  a.morelink {
	  text-decoration:none;
	  outline: none;
	}
	.morecontent span {
	  display: none;
	}
	a.banner-course {
 background-color: #fd6500;
 color: #fff;
 padding: 16px 60px 18px 60px;
 border-radius: 15px;
 font: 14px/normal Gotham-Medium;
 position: relative;

}
.height-auto{
	min-height: 230px;
	height: auto!important;
}
.std-inner-first {
border: 3px solid #fd6500;
padding: 30px 0px 40px 0px;
position: relative;
border-radius: 25px;
min-height: 230px;
}
	</style>
			<?php 
		 		$course_id = $course_arr['id'];
		 		$class_id = $class_id;
			?>
			 <?php if($this->session->flashdata('already_completed')){?>
            <div class="success-msg">
              <?php echo $this->session->flashdata('already_completed');?>
            </div>
            <?php } ?>
				<section class="dashboard-part">
					<div class="container">
						<div class="row">
							<h2>Standard Test</h2>
							<div class="owl-carousel owl-theme" id="standard-carousel">
								<?php 								
								if(count($standard_tests) >0) { 
									foreach($standard_tests as $standard_test) { 
									$current_date = date('Y-m-d');
									$expiry_date = date('Y-m-d', strtotime($standard_test['to_date']));
									$datetime1 = date_create($current_date); 
									$datetime2 = date_create($expiry_date); 
									$interval = date_diff($datetime1, $datetime2); 
									$days =$interval->format('%a');
									$status = $this->tests_model->get_standard_is_complete_status($standard_test['id']);

								?>

								<div class="item standared-item">
									<div class="std-inner-Sec">
										<div class="std-inner-first">
											<div class="std-term">
												<p class="std-sub"><?php echo $standard_test['test_name'];?></p>
												<p class="std-date">Expiry date <span><?php echo $days; 
												if($days>1){echo " days";}else{echo " day";}
												?> , 
												<?php echo $hrs = $standard_test['hours'];
												if($hrs>1){echo " hours";}else{echo " hour";}
												?> <?php $mins = $standard_test['mins'];
												if($mins>0){ echo $mins." mins"; }
												 ?>
												</span></p>
												<div class="std-descri">
													<p  class="comment more"><?php echo $standard_test['test_description'];?></p>
													
												</div>
											</div>
											<div class="std-inner-second">
											    <?php if($status == 0) { ?>
												<a href="<?php echo base_url().'tests/start_standard_test/'.$standard_test['course_id'].'/'.$standard_test['id'];?>" alt="Take Test">Take Test</a>
												<?php } else {?>
												<a href="#" alt="Test Completed">Test Completed</a>
												<?php }?>
											</div>
										</div>                 
									</div> 
								</div>
								<?php } }else{
								echo "No Tests Available";
							} ?>
							</div>
						</div>
					</div>
				</section>
				<section class="sub-courses">
					<div class="container">
							<h2>Courses -<b> <?php echo $course_arr['name'];?></b></h2>
						<div class="form-section">
							<div class="row">
									<div class="form-group col-md-3">
										<div class="select-courses">
										<?php 
											$js = 'id="subjects" class="form-control" required';
											echo form_dropdown('subjects',$subjects, set_value('subjects'), $js);
										?>
										</div>
									</div>
									<div class="form-group col-md-3">
										<div class="select-courses ">
										<?php 
											$js = 'id="chapters" class="form-control" required';
											echo form_dropdown('chapters',$chapters, set_value('chapters'), $js);
										?>
										</div>
									</div>
									<div class="form-group col-md-3">
										<div class="select-courses">
										<?php 
											$js = 'id="severity" class="form-control" required';
											echo form_dropdown('severity', $this->config->item('severity_front_end'), set_value('severity'), $js);
										?>
										</div>
									</div>
									<div class="form-group col-md-3">
										<div class="select-courses">
											<button type="submit" class="btn btn-primary btn-block" id="practice_test">Practice Test</button>
										</div>
									</div>
							</div>
						</div>

						<div class="topic-section">
							<div class="jumbotron page  study_materials" id="page1">
									<?php $this->load->view('dashboard/study_materials');?>
							</div>
								<ul id="pagination-demo" class="pagination-lg topic-pagi"></ul>	

						</div>

						<style>
						#pagination-demo li{display:none!important;}
						</style>


					</div>
				<!-- </div> -->
			</section>
			<?php if(count($notices)>0) { ?>
					<section class="notice-board">
						<div class="container">
							<h2>Notice Board</h2>
							
							<div class="owl-carousel dashboard-notice owl-theme">
							<?php foreach($notices as $notice){ ?>
                        <div class="slider-wrapper">
                            <div class="item">
                               <div class="notice-cont">
							 <div class="text-center pb-2" style="height: 65px;">	<h4><?php echo $notice['title'];?></h4></div>
								
								<p class="comment more"><?php echo $notice['short_description'];?></p>
								</div>
                            </div>
                        </div>
						<?php } ?>
                        
                        
                    </div>
					</div>
					</section>
					<?php } ?>
			<!---end of dashboard-->
	<!-- footer -->
	<?php $this->load->view('dashboard/modal');?>
<script>
	$(document).ready(function(){

		$("#subjects").prepend("<option value='' selected>Select Chapter</option>");
  
		$(document).on('click','#open_material', function(){
		  if($(this).hasClass( "show" ) == false){
			$("#youTubeLink").attr('src', '');
		  }
		});

		$('#subjects').on('change', function() {
	    	var url = base_url + "dashboard/request";
			$('.study_materials').html("Please select chapter");	
	     	$.ajax({
	            type: "POST",
	            url: url,
	            data: "course_id=" + "<?php echo $course_id;?>" +"&class_id=" + "<?php echo $class_id;?>" + "&subject_id=" + this.value,
	            success: function (result) { 
	                if(result != ''){
	                	var obj = jQuery.parseJSON($.trim(result));
	                	$("#chapters").html("");
	                	$("#chapters").append("<option value=''>Select Chapter</option>");
	                	$.each(obj.chapter_list, function( key, value ) {
	                			if(key != 'Select'){
									$("#chapters").append("<option value="+value+">"+key+"</option>");
								}
						});
	                }
	            }
	        });
		});
		$('#chapters').change(function(){
			 loadPagination(1);
		});
	 // Detect pagination click
     $(document).on('click','.pagination_dashboard a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       
       loadPagination(pageno);
     });
     // Load pagination
	});
	function loadPagination(pagno){
     		var url = base_url + "dashboard/get_ajax_materials/" + pagno;
			var subject_id = $("#subjects").val();
			var chapter_id = $("#chapters").val();
			if(chapter_id ==""){
				$('.study_materials').html("Please select chapter");
				return false;
			}	
	     	$.ajax({
	            type: "POST",
	            url: url,
	            data: "course_id=" + "<?php echo $course_id;?>" +"&class_id=" + "<?php echo $class_id;?>" + "&subject_id=" + subject_id + "&chapter_id=" + chapter_id,
	            success: function (result) { 
	                if(result != ''){
	                	$('.study_materials').html($.trim(result));	
						
	                }
					
	            }
	        });
     }




$(document).on('click','.view_attachment', function(){
	var url = base_url + "dashboard/get_attachment";
	var id = $(this).data('attachment_id');
	var file_type = $(this).data('file_type');
	$.ajax({
            type: "POST",
            url: url,
            data: "id=" + id,
			beforeSend: function() {   
				$('.modal-content').hide(); 
				$('.modal-body').html(" ");
				if(file_type == 1){
					$('.modal-content').attr("style", "width:675px;height:500px");   
					$('.modal-body').attr("style", "max-height: 450px;overflow: scroll;");    
				}else {
					$('.modal-content').attr("style", "width:600px;height:425px");   
					$('.modal-body').removeAttr("style");   
				} 
			},
            success: function (result) { 
				$('.modal-content').show(); 
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	var file_name = obj.attachment_name;
                	var file = "<?php echo base_url().'appdata/attachments/';?>"+obj.attachment;
					console.log("file_type",file_type);
                	if(file_type == 1){
                		view_pdf(file);
                		// var body = '<canvas id="canvas" width="467" height="315"></canvas>';
                	}else if(file_type == 2){
						var file =  "//www.youtube.com/embed/"+obj.attachment;
                		//var body = '<video width="467" height="auto" controls controlslist="nodownload"><source src='+file+' type="video/mp4"></video>';
						var body = '<iframe id="youTubeLink" width="100%" height="315" src='+file+' frameborder="0" allowfullscreen></iframe>';
                		$('.modal-body').html(body);     	
                	}    
                	$('.header-content').html(file_name);      	
                	
                }
            }
	});
	$("#open_material").modal("toggle");
});
</script>
 

<script type="text/javascript">
			var currPage = 0;
			var numPages = 0;
			var thePDF = null;
	function view_pdf(file_location){
		PDFJS.getDocument(file_location).then(function(pdf) {    
				thePDF = pdf;
				numPages = pdf.numPages;
				currPage = 1;
				pdf.getPage( 1 ).then( handlePages );
		});
	}
	function handlePages(page)
	{
	    var viewport = page.getViewport( 1 );
	    var canvas = document.createElement( "canvas" );
	    canvas.style.display = "block";
	    var context = canvas.getContext('2d');
	    canvas.height = viewport.height;
	    canvas.width = viewport.width;
	    //canvas.height = 315;
	    //canvas.width = 467;
	    page.render({canvasContext: context, viewport: viewport});
	    document.body.appendChild( canvas );
		document.getElementById('modal-body').appendChild(canvas);
	   // document.body.appendChild( canvas style="max-height: 422px;overflow: scroll;");
	    //console.log("numPages", numPages);
	    currPage++;
	    if ( thePDF !== null && currPage <= numPages )
	    {
	        thePDF.getPage( currPage ).then( handlePages );
	    }
	}
	$('#practice_test').click(function(){
		var subject_id = $("#subjects").val();
		var severity = $("#severity").val();
		var chapter_id = $("#chapters").val();
		// alert(chapter_id);
		if(chapter_id != "0" &&  chapter_id !=""){
			location.href = base_url+"tests/start_test/"+subject_id+"/"+chapter_id+"/"+severity;
		}
		else{
			alert("Please Select Chapter");
		}
		// 
		// var chapter_id = $("#chapters").val();		
		// alert(subject_id);alert(chapter_id);alert(severity);
		// 
	});
</script>



<!-- read more script  start-->

<script type="text/javascript">
 $(document).ready(function() {
  var showChar = 70;
  var ellipsestext = "";
  var moretext = "View More";
  var lesstext = "Less";
  $('.more').each(function() {
    var content = $(this).html();

    if(content.length > showChar) {

      var c = content.substr(0, showChar);
      var h = content.substr(showChar-0, content.length - showChar);

      var html = c + '<span class="moreelipses"></span>&nbsp;<span class="morecontent "><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">'+moretext+'</a></span>';

      $(this).html(html);
    }

  });

  $(".morelink").click(function(){
  	
    if($(this).hasClass("less")) {
    $(".std-inner-first").removeClass("height-auto");
      $(this).removeClass("less");
      $(this).html(moretext);
    } else {
      $(this).addClass("less");
      $(this).html(lesstext);
      $(".std-inner-first").addClass("height-auto");
    }
    $(this).parent().prev().toggle();
    $(this).prev().toggle();
    return false;
  });
});
</script> 




	
