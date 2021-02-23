<div class="ans_desc_popup downloads-popup">
	<div class="downloadpopup-tabsection">
		<h2>Downloads</h2>
		<ul>
			<?php
$i=1;
			 foreach($data_course as $key=>$data_course){
			?>
	<li><a course="<?php echo ($key==""?0:$key); ?>"; uploadurl="<?php echo base_url()."tests/upload_course/".($key==""?0:$key)."/".$subject."/".$class."/"; ?>" href="<?php echo base_url()."tests/materials_list/".($key==""?0:$key)."/$class/$subject"; ?>" title="<?php echo ($key==""?"Free Course":$data_course);
			?>" class="<?php echo ($i==1?"active ":""); ?>down-tabs-click trigger-me<?php echo ($key==""?0:$key); ?>"><?php echo ($key==""?"Free Course":$data_course);
			?></a></li>
			<?php
$i++;
			}
			 ?>
		
			 
		</ul>
	</div>
	<div class="download-content-main">
		<div class="coursedownload-list clearfix">
			<div class="ajaxupload-download">
				<div class="coursedownload-inner scroll-pane">
					<ul>
					<?php 
					if(count($attachments)>0)
					{
						$icon = "";
						foreach($attachments as $att_data):
							$file_extension = explode(".", $att_data["attachment"]);
							if($file_extension[1] == "pdf") $icon = "pdf-icon";
							if($file_extension[1] == "doc" || $file_extension[1] == "docx") $icon = "docx-icon";
							if($file_extension[1] == "mp4" || $file_extension[1] == "swf") $icon = "video-icon";
							if($file_extension[1] == "mp3") $icon = "audio-icon";
							if($file_extension[1] == "rar" || $file_extension[1] == "zip") $icon = "rar-icon";
							?>
							
						<li> 
							<span class="<?php echo $icon; ?> dashboard-sprite"></span>
							<p><?php if(strlen($att_data["download_name"]) > 40) { 
										echo ucfirst(substr($att_data["download_name"],0,40)).".."; 
									}else{  
										echo ucfirst($att_data["download_name"]);
									} ?></p>
							<a target="_blank" href="<?php echo base_url();?>home/download_file/<?php echo $att_data['attachment'] ?>" title="Download">Download</a>
						</li>
						 
					<?php	
					endforeach;					
						}else{
					?>
						<li style="" id="nodownloads" class="nodownloads-found">
							<p>No files found</p>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
