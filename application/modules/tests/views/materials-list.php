<div class="coursedownload-inner scroll-pane">
	<ul>
		 <?php 
					if(count($attachments)>0)
					{
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
							<a target="_blank" href="<?php echo base_url();?>tests/download_file/<?php echo $att_data['attachment'] ?>" title="Download">Download</a>
						</li>
						 
					<?php	
					endforeach;					
						}else{
					?>
						<li style="" id="nofoundations" class="nodownloads-found">
							<p>No files found</p>
						</li>
						<?php } ?>
		 
	</ul>
</div>
