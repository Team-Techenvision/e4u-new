
							<!-- <h2><?php //echo $chapter_name;?></h2> -->
									  <h2><?php echo $chapter_name;?></h2> 
							
								<?php if(count($study_material)>0) { 
									foreach($study_material as $material){ 
									 ?>
								<div class="carousel clearfix">
								<div class="carousel-view clearfix">
								<div class="inner-topic-Sec">
									<h4><?php echo ucfirst($material['download_name']);?> </h4>
									<p>
										<?php echo nl2br(ucfirst($material['comments']));?> 
									</p>
									<div class="row">
										
									<?php foreach($material['files'] as $key => $value) { 
											$file_name = explode('.',$value['attachment']);
											$extension = end($file_name);
											if(strtolower($extension)=="pdf"){
												$file_type = 1;
											}
											else{
												$file_type = 2;
											}
									?>
										<div class="pdf-sec">
											<?php if($file_type==1){?>
												<div class="view_attachment" id="" data-file_type="<?php echo $file_type;?>" data-attachment_id="<?php echo $value['id'];?>">
													<img src="<?php echo base_url().'assets/site/images/pdf.png';?>">
												</div>												
											<?php } else if($file_type==2){?>
												<div class="topic-img view_attachment" id="" data-file_type="<?php echo $file_type;?>" data-attachment_id="<?php echo $value['id'];?>">
													<img src="<?php echo base_url().'assets/site/images/video.png';?>">
												</div>
												
											<?php } ?>

											<p><?php echo ucfirst($value['attachment_name']);?></p>
										</div>
										<?php } ?>
									</div>
								</div>

								</div><!-- carosel-view End -->
								</div><!-- carosel End -->
							<?php }}else{
								echo "No Materials Found";
							} ?>
							<?php echo $links;?>
