 <!-- Main Content -->
 
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('viewperformancereports'); ?></div>
							</div>
							<div class="back pull-right">
								<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/performance_reports">Back</a>
							</div>
						</div>
						<div class="col-sm-12">
							<h3 class="text-center text-muted">Questions Performance</h3>
		                	<div class="col-sm-12" id="questions" style="height: 400px;"></div>
                    	</div>
                    	<div class="col-sm-12">
		                	<h3 class="text-center text-muted">Accuracy Performance</h3>
		                	<div class="col-sm-12"  id="accuracy" style=" height: 400px;"></div>
                    	</div>
                    	<div class="col-sm-12">
                    		<h3 class="text-center text-muted">Progress Performance</h3>
                    		<div class="col-sm-12" id="progress" style="height: 400px;"></div>
                    	</div>
                    	<!--<div id="speed" style="width: 50%; height: 400px;"></div>-->
                	</div>
            	</div>
       		 </div>
    	</div>
	</div>
</div>
<script>
    var questions = [{
        questions: "Total Questions",
        count: "<?php echo $total_questions;?>"
    }, {
        questions: "Attended Questions",
        count: "<?php echo $performance_reports['questions'];?>"
    }];
    
    var accuracy = [{
        accuracy: "Attended Questions",
        count: "<?php echo $performance_reports['questions'];?>"
    }, {
        accuracy: "Correct Questions",
        count: "<?php echo $performance_reports['accuracy'];?>"
    }];
    var progress = [{
        progress: "Total Progress",
        count: "<?php echo $total_progress;?>"
    }, {
        progress: "Completed Progress",
        count: "<?php echo $performance_reports['progress_count'];?>"
    }];
   /* var speed = [
                {
                    "Hours": "Speed",
                    "speed": "<?php echo $speed;?>",
                }];*/
    

    AmCharts.ready(function () {
        // PIE CHART
        chart = new AmCharts.AmPieChart();
        chart.dataProvider = questions;
        chart.titleField = "questions";
        chart.valueField = "count";
        chart.outlineColor = "#FFFFFF";
		chart.colors =["#2F425E", "#FDB416"]; 
        chart.outlineAlpha = 0.8;
        chart.outlineThickness = 2;
        
        chart2 = new AmCharts.AmPieChart();
        chart2.dataProvider = accuracy;
        chart2.titleField = "accuracy";
        chart2.valueField = "count";
        chart2.outlineColor = "#FFFFFF";
		chart2.colors =["#2F425E", "#FDB416"]; 
        chart2.outlineAlpha = 0.8;
        chart2.outlineThickness = 2;
        
        chart3 = new AmCharts.AmPieChart();
        chart3.dataProvider = progress;
        chart3.titleField = "progress";
        chart3.valueField = "count";
        chart3.outlineColor = "#FFFFFF";
		chart3.colors =["#2F425E", "#FDB416"]; 
        chart3.outlineAlpha = 0.8;
        chart3.outlineThickness = 2;
        
        /*chart4 = new AmCharts.AmSerialChart();
        chart4.dataProvider = speed;
        chart4.categoryField = "Hours";
        chart4.startDuration = 1;
        chart4.plotAreaBorderColor = "#DADADA";
		chart4.colors =["#2F425E", "#FDB416"]; 
        chart4.plotAreaBorderAlpha = 1;
        // this single line makes the chart a bar chart
        chart.rotate = true;
        
        // AXES
        // Category
        var categoryAxis = chart4.categoryAxis;
        categoryAxis.gridPosition = "start";
        categoryAxis.gridAlpha = 0.1;
        categoryAxis.axisAlpha = 0;

        // Value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisAlpha = 0;
        valueAxis.gridAlpha = 0.1;
        valueAxis.position = "top";
        chart4.addValueAxis(valueAxis);

        // GRAPHS
        // first graph
        var graph1 = new AmCharts.AmGraph();
        graph1.type = "column";
        graph1.title = "Hours";
        graph1.valueField = "speed";
        graph1.balloonText = "Questions:[[value]]";
        graph1.lineAlpha = 0;
        graph1.fillColors = "#ADD981";
        graph1.fillAlphas = 1;
        chart4.addGraph(graph1);*/
        

        // WRITE
        chart.write("questions");
        chart2.write("accuracy");
        chart3.write("progress");
        //chart4.write("speed");
    });
            
</script>



