<div class="contactus-success-page clearfix">
	<div class="wrapper">
		<h2>Thank You</h2>
		<p>You have successfully submitted your query</p>
		<a style="display:none" href="javascript:void(0);" class="back_link">Go Back</a>
	</div>
</div>
<script>
$( document ).ready(function() {
	<?php if($this->uri->segment(2)=="enquiry_success"){?>
	var user_id = '<?php echo $user_id;?>';
	setTimeout(function(){
		location.href = base_url+"contact_us<?php echo ($_GET['view_mode']=='app'?'?view_mode=app&id="+user_id+"':''); ?>";
	},5000);
	<?php } ?>
});
</script>


	
