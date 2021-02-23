<div class="dashboard-result-graph">
	<div id="preloader2" class="pre-loader"></div>
	<div class="result-graph-content">
		<div class="graph-section">
			<img src="<?php echo base_url();?>assets/site/images/graph.png" alt="Graph" />
		</div>
		<div class="level-dropdown">
			<div class="levelcomplete-list select-box">
				<?php $option = array(); 
					foreach($levels as $level){ 
						$option[$level["id"]] = $level["name"];
					} ?>
				<?php echo form_dropdown("level_completed",$option,$filter_level,"id='level_completed'");?>
			</div>
		</div>
	</div>
</div>	
