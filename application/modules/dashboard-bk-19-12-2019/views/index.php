<!---dashboard section--->
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
								<?php if(count($standard_tests) >0) { 
									foreach($standard_tests as $standard_test) { 
									$current_date = date('Y-m-d');
									$expiry_date = date('Y-m-d', strtotime($standard_test['to_date']));
									$datetime1 = date_create($current_date); 
									$datetime2 = date_create($expiry_date); 
									$interval = date_diff($datetime1, $datetime2); 
									$days =$interval->format('%a');
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
													<p><?php echo $standard_test['test_description'];?></p>
												</div>
											</div>
											<div class="std-inner-second">
												<a href="<?php echo base_url().'tests/start_standard_test/'.$standard_test['course_id'].'/'.$standard_test['id'];?>" alt="Take Test">Take Test</a>
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
											$js = 'id="subjects" class="form-control"';
											echo form_dropdown('subjects',$subjects, set_value('subjects'), $js);
										?>
										</div>
									</div>
									<div class="form-group col-md-3">
										<div class="select-courses ">
										<?php 
											$js = 'id="chapters" class="form-control"';
											echo form_dropdown('chapters',$chapters, set_value('chapters'), $js);
										?>
										</div>
									</div>
									<div class="form-group col-md-3">
										<div class="select-courses">
										<?php 
											$js = 'id="severity" class="form-control"';
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


					</div>
				<!-- </div> -->
			</section>
					<section class="notice-board">
						<div class="container">
							<h2>Notice Board</h2>
							<?php if(count($notices)>0) { ?>
							<div class="notice-Sec">
								<div class="row">
									<?php foreach($notices as $notice){ ?>
									<div class="col-md-3  col-sm-12 notice-cont">
										<h4><?php echo $notice['title'];?></h4>
										<p><?php echo $notice['short_description'];?></p>
									</div>
									<?php } ?>
										
								</div>
							</div>
							<?php }else{
								echo "No Messages Found";
							} ?>
					</div>
					</section>
			<!---end of dashboard-->
	<!-- footer -->
	<?php $this->load->view('dashboard/modal');?>
<script>
	$(document).ready(function(){
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

$('.view_attachment').click(function(){
	var url = base_url + "dashboard/get_attachment";
	var id = $(this).data('attachment_id');
	var file_type = $(this).data('file_type');
	$.ajax({
            type: "POST",
            url: url,
            data: "id=" + id,
            success: function (result) { 
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	var file_name = obj.attachment_name;
                	var file = "<?php echo base_url().'appdata/attachments/';?>"+obj.attachment;
                	if(file_type == 1){
                		$('.modal-body').html(" ");
                		view_pdf(file);
                		// var body = '<canvas id="canvas" width="467" height="315"></canvas>';
                	}else if(file_type == 2){
                		var body = '<video width="467" height="315" controls controlslist="nodownload"><source src='+file+' type="video/mp4"></video>';
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
			var currPage = 1;
			var numPages = 0;
			var thePDF = null;
	function view_pdf(file_location){
			PDFJS.getDocument(file_location).then(function(pdf) {
				        thePDF = pdf;
				        numPages = pdf.numPages;
				        pdf.getPage( 1 ).then( handlePages );
			});
	}
	function handlePages(page)
	{
	    var viewport = page.getViewport( 1 );
	    var canvas = document.createElement( "canvas" );
	    canvas.style.display = "block";
	    var context = canvas.getContext('2d');
	    // canvas.height = viewport.height;
	    // canvas.width = viewport.width;
	    canvas.height = 315;
	    canvas.width = 467;
	    page.render({canvasContext: context, viewport: viewport});
	    document.body.appendChild( canvas );
		document.getElementById('modal-body').appendChild(canvas);
	   // document.body.appendChild( canvas );
	    currPage++;
	    if ( thePDF !== null && currPage <= numPages )
	    {
	        thePDF.getPage( currPage ).then( handlePages );
	    }
	}
	$('#practice_test').click(function(){
		var subject_id = $("#subjects").val();
		var chapter_id = $("#chapters").val();
		var severity = $("#severity").val();
		// alert(subject_id);alert(chapter_id);alert(severity);
		location.href = base_url+"tests/start_test/"+subject_id+"/"+chapter_id+"/"+severity;
	});
</script>
	
