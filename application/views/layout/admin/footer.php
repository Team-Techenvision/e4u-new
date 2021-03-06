<?php if($this->session->has_userdata('admin_is_logged_in')) { ?>
<!-- FOOTER -->
<footer class="app-footer">
	<div class="container">
  		<p class="text-muted">Copyrights &copy; <?php echo date("Y")."."."E4U. All Rights Reserved"; ?></p>
	</div>
</footer> 
<?php } ?>
<div>
	<!-- Javascript Libs -->
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery-ui.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.ui.timepicker.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/bootstrap.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.livequery.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/Chart.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/bootstrap-switch.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.matchHeight-min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.dataTables.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/dataTables.bootstrap.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/site/js/jquery.livequery.js"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/select2.full.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/bootstrap-select.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/ace/ace.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/ace/mode-html.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/ace/theme-github.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/tinymce/tinymce.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.datetimepicker.full.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/ckeditor.js'; ?>"></script>
	<!-- /.container -->
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/app.js'; ?>"></script>
	
	
<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.fancybox.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.jscrollpane.min.js';?>"></script>
	
	
	
	<?php if($this->session->has_userdata('admin_is_logged_in')) { ?>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/index.js?'. time(); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/custom_validation.js'; ?>"></script>
	<?php } ?>
</div>
