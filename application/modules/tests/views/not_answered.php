<div class="ans_desc_popup">
	<h2>Unanswered Questions</h2>
	<div class="content_wrapper">
		<ul class="ans_info">
		<?php foreach($not_answered as $data_in){?>
			<li class="questions" style="width:auto">
				<?php if($type == 2){
					$href= base_url().'tests/surprise_detail/'.$test_random_id.'/'.$course_id.'/'.($data_in["serial_number"]-1);
				}else{
					$href = base_url().'tests/progress_detail/'.$test_random_id.'/'.($data_in["serial_number"]-1);
				}?>
				
				<a href="<?php echo $href; ?>"><span> <?php  echo $data_in["serial_number"]; ?></span></a>
			</li>
		<?php }
		if(count($not_answered)==0){ ?>
			<li><h3>No Question found.</h3></li>
		<?php } ?>
		</ul>
	</div>	
</div>
<script>
	$('.questions').on('click',function(){
		window.onbeforeunload = null;
	});
</script>
