$(function() {   
  if($('body').find('#jumbotron-line-chart').length > 0 ) {
  var ctx, data, myLineChart, options;
  Chart.defaults.global.responsive = true;
  ctx = $('#jumbotron-line-chart').get(0).getContext('2d');
  options = {
    showScale: false,
    scaleShowGridLines: false,
    scaleGridLineColor: "rgba(0,0,0,.05)",
    scaleGridLineWidth: 0,
    scaleShowHorizontalLines: false,
    scaleShowVerticalLines: false,
    bezierCurve: false,
    bezierCurveTension: 0.4,
    pointDot: false,
    pointDotRadius: 0,
    pointDotStrokeWidth: 2,
    pointHitDetectionRadius: 20,
    datasetStroke: true,
    datasetStrokeWidth: 4,
    datasetFill: true,
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
  };
  data = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    datasets: [
      {
        label: "My Second dataset",
        fillColor: "rgba(34, 167, 240,0.2)",
        strokeColor: "#22A7F0",
        pointColor: "#22A7F0",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "#22A7F0",
        data: [28, 48, 40, 45, 76, 65, 90]
      }
    ]
  };
  myLineChart = new Chart(ctx).Line(data, options);
  }
});

$(function() {
 if($('body').find('#jumbotron-bar-chart').length > 0 ) {
  var ctx, data, myBarChart, option_bars;
  Chart.defaults.global.responsive = true;
  ctx = $('#jumbotron-bar-chart').get(0).getContext('2d');
  option_bars = {
    showScale: false,
    scaleShowGridLines: false,
    scaleBeginAtZero: true,
    scaleShowGridLines: true,
    scaleGridLineColor: "rgba(0,0,0,.05)",
    scaleGridLineWidth: 1,
    scaleShowHorizontalLines: false,
    scaleShowVerticalLines: false,
    barShowStroke: true,
    barStrokeWidth: 1,
    barValueSpacing: 7,
    barDatasetSpacing: 3,
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
  };
  data = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    datasets: [
      {
        label: "My First dataset",
        fillColor: "rgba(26, 188, 156,0.6)",
        strokeColor: "#1ABC9C",
        pointColor: "#1ABC9C",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "#1ABC9C",
        data: [65, 59, 80, 81, 56, 55, 40]
      }, {
        label: "My Second dataset",
        fillColor: "rgba(34, 167, 240,0.6)",
        strokeColor: "#22A7F0",
        pointColor: "#22A7F0",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "#22A7F0",
        data: [28, 48, 40, 19, 86, 27, 90]
      }
    ]
  };
  myBarChart = new Chart(ctx).Bar(data, option_bars);
  }
});

$(function() {
	 if($('body').find('#jumbotron-line-2-chart').length > 0 ) {
  var ctx, data, myLineChart, options;
  Chart.defaults.global.responsive = true;
  ctx = $('#jumbotron-line-2-chart').get(0).getContext('2d');
  options = {
    showScale: false,
    scaleShowGridLines: false,
    scaleGridLineColor: "rgba(0,0,0,.05)",
    scaleGridLineWidth: 0,
    scaleShowHorizontalLines: false,
    scaleShowVerticalLines: false,
    bezierCurve: false,
    bezierCurveTension: 0.4,
    pointDot: false,
    pointDotRadius: 0,
    pointDotStrokeWidth: 2,
    pointHitDetectionRadius: 20,
    datasetStroke: true,
    datasetStrokeWidth: 3,
    datasetFill: true,
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
  };
  data = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    datasets: [
      {
        label: "My First dataset",
        fillColor: "rgba(26, 188, 156,0.2)",
        strokeColor: "#1ABC9C",
        pointColor: "#1ABC9C",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "#1ABC9C",
        data: [65, 59, 80, 81, 56, 55, 40]
      }, {
        label: "My Second dataset",
        fillColor: "rgba(34, 167, 240,0.2)",
        strokeColor: "#22A7F0",
        pointColor: "#22A7F0",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "#22A7F0",
        data: [28, 48, 40, 19, 86, 27, 90]
      }
    ]
  };
  myLineChart = new Chart(ctx).Line(data, options);
  }
});

$(document).ready(function() { 
	
	/*$('#choice_count').on('change',function(){
		if($(this).val() != '') {
			$('.choices-options').html('');
			for(var i=1; i<=$(this).val(); i++){
				$('.choices-options').append('<div class="form-group choices'+i+'" style="display: block;"><label class="col-sm-2 control-label">Option '+String.fromCharCode(64+i)+' <span class="required">*</span></label><div class="col-sm-4"><input type="text" id="choices'+i+'" class="form-control" placeholder="Option '+String.fromCharCode(64+i)+'" value="" name="choices[]"></div></div>');
			}
		}
		
	});*/
	
	$('#question_type').on('change',function(){
		if($(this).val() != '') {
			if($(this).val() == 1){
				$('#choice_count').val("");
				$('.choices-options').html('');
				$('#choice_count').on('change',function(){ 
					if($(this).val() != ''){ 
						$('.choices-options').html('');
						for(var i=1; i<=$(this).val(); i++){
							$('.choices-options').append('<div class="form-group choices'+i+'" style="display: block;"><label class="col-sm-2 control-label">Option '+String.fromCharCode(64+i)+' <span class="required">*</span></label><div class="col-sm-4"><input type="text" id="choices'+i+'" class="form-control" placeholder="Option '+String.fromCharCode(64+i)+'" value="" name="choices[]"></div></div>');
						}
					}
				});
			}else{
				$('#choice_count').val("");
				$('.choices-options').html('');
				$('#choice_count').on('change',function(){ 
					if($(this).val() != ''){ 
						$('.choices-options').html('');
						for(var i=1; i<=$(this).val(); i++){
							$('.choices-options').append('<div class="form-group choices'+i+'" style="display: block;"><label class="col-sm-2 control-label">Option '+String.fromCharCode(64+i)+' <span class="required">*</span></label><div class="col-sm-4"><input type="file" id="choices'+i+'" class="form-control" placeholder="Option '+String.fromCharCode(64+i)+'" value="" name="choices[]"></div></div>');
						}
					}
				});
			}
		}
		
	});
	
	$('.relevant_subjects option:first-child').attr("disabled", "disabled");
	$('.relevant_classes option:first-child').attr("disabled", "disabled");
	$('#expiry-date').datetimepicker({
		lang:'en',
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
		minDate:0, 
	});
	
	$('#search_date').datetimepicker({
		lang:'en',
		timepicker:true,
		format:'Y-m-d',
		formatDate:'Y-m-d',
	});

 	tinymce.init({
         selector: ".editor",
         plugins: [
             "advlist autolink lists link image charmap print preview anchor",
             "searchreplace visualblocks code",
             "insertdatetime media table contextmenu paste"
         ],
         toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontselect fontsizeselect",
         fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt"
     });
      $('#level_list').on('change', function() {
    	var url = base_url + "admin/questions/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + $('#course_list').val() +"&class_id=" + $('#class_list').val() + "&subject_id=" + $('#subject_list').val() + "&chapter_id=" + $('#chapter_list').val() + "&level_id=" +$('#level_list').val(),
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON(result);
                	$("#set_list").html("");
                	$("#set_list").append("<option value=''>Select</option>");
                	$.each( obj.set_list, function( key, value ) {
                			if(value != 'Select'){
								$("#set_list").append("<option value="+key+">"+value+"</option>");
							}
										
					});
                }
            }
        });
	});
     $('#chapter_list').on('change', function() {
    	var url = base_url + "admin/sets/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + $('#course_list').val() +"&class_id=" + $('#class_list').val() + "&subject_id=" + $('#subject_list').val() + "&chapter_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON(result);
                	$("#level_list").html("");
                	$("#level_list").append("<option value=''>Select</option>");
                	$.each( obj.level_list, function( key, value ) {
                			if(value != 'Select'){
								$("#level_list").append("<option value="+key+">"+value+"</option>");
							}
										
					});
                }
            }
        });
	});
	/*$(window).on('load', function() {

		if($('#chapter_list').val() == ''){
			return false;
		}
    	var url = base_url + "admin/sets/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + $('#course_list').val() +"&class_id=" + $('#class_list').val() + "&subject_id=" + $('#subject_list').val() + "&chapter_id=" + $('#chapter_list').val(),
            success: function (result) {
            	
                if(result != ''){
                	var obj = jQuery.parseJSON(result);
                	$("#level_list").html("");
                	$.each( obj.level_list, function( key, value ) {
                			if(value != 'Select'){
								$("#level_list").append("<option value="+key+">"+value+"</option>");
							}
										
					});
                }
            }
        });
	});*/
     $('#subject_list').on('change', function() {
    	var url = base_url + "admin/levels/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + $('#course_list').val() +"&class_id=" + $('#class_list').val() + "&subject_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON(result);
                	$("#chapter_list").html("");
                	$("#chapter_list").append("<option value=''>Select</option>");
                	$.each( obj.chapter_list, function( key, value ) {
                			if(value != 'Select'){
								$("#chapter_list").append("<option value="+key+">"+value+"</option>");
							}
										
					});
                }
            }
        });
	});
	
	/*$(window).on('load', function() {

		if($('#subject_list').val() == ''){
			return false;
		}
    	var url = base_url + "admin/levels/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + $('#course_list').val() +"&class_id=" + $('#class_list').val() + "&subject_id=" + $('#subject_list').val(),
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON(result);
                	$("#chapter_list").html("");
                	$.each( obj.chapter_list, function( key, value ) {
                			if(value != 'Select'){
								$("#chapter_list").append("<option value="+key+">"+value+"</option>");
							}
										
					});
                }
            }
        });
	});*/
    $('#course_list').on('change', function() {
    	var url = base_url + "admin/chapters/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON(result);
                	$("#class_list").html("");
                	$("#subject_list").html("");
                	$("#class_list").append("<option value=''>Select</option>");
                	$.each( obj.class_list, function( key, value ) {
							$("#class_list").append("<option value="+key+">"+value+"</option>");
										
					});
					$("#subject_list").append("<option value=''>Select</option>");
					$.each( obj.subject_list, function( key, value ) {
							$("#subject_list").append("<option value="+key+">"+value+"</option>");
										
					});
                }
            }
        });
	});
	$('#course_list').on('change', function() {
    	var url = base_url + "admin/alerts/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON(result);
                	$("#user_list").html("");
					$("#user_list").append("<option value=''>Select</option>");
					$.each( obj.user_list, function( key, value ) {
						$("#user_list").append("<option value="+key+">"+value+"</option>");
					});
                }
            }
        });
	});
	/*$(window).on('load', function() {
		if($('#course_list').val() == ''){
			return false;
		}
    	var url = base_url + "admin/chapters/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" +  $('#course_list').val(),
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON(result);
                	$("#class_list").html("");
                	$("#subject_list").html("");
                	 
                	$.each( obj.class_list, function( key, value ) {
							$("#class_list").append("<option value="+key+">"+value+"</option>");
										
					});
				 
					$.each( obj.subject_list, function( key, value ) {
							$("#subject_list").append("<option value="+key+">"+value+"</option>");
										
					});
                }
            }
        });
	});*/
	$('.add-more').on('click',function(event){
		event.preventDefault();
		var tot=parseInt($(".extra-name").length)+1;
		$('.add-more-name').append('<input style="margin-top:10px;" type="text" id="name" class="form-control check_name extra-name extra-name'+tot+'" placeholder="Name" value="" name="name[]"><a href="javascript:delete_row('+tot+');" row='+tot+' class="delete-name pull-right delete'+tot+'"> Delete </a>');
		
		$('.check_name').blur(function(){
		 
			var extra = $(this).val(); 
			if(extra==""){
				return false;
			}
			$(this).next("span").remove();
			var yes=0;
			$('.check_name').each(function(){
				var all = $(this).val(); 
			 	if(all==extra)
				{
					yes=parseInt(yes)+1;
				} 
			});
		 	if(parseInt(yes)>1)
		 	{
			 	$(this).val("");
			   	$(this).next("span").remove();
			  	$(this).after("<span class='red'>Name must be unique</span>");
			  	$(".red").css("color", "red");
		 	} 
		  
		});
		
	});
	$('.check_name').blur(function(){
			 
			var extra = $(this).val(); 
			if(extra==""){
				return false;
			}
			$(this).next("span").remove();
			var yes=0;
			$('.check_name').each(function(){
				var all = $(this).val(); 
			 	if(all==extra)
				{
					yes=parseInt(yes)+1;
				} 
			});
		 	if(parseInt(yes)>1)
		 	{
			 	$(this).val("");
			   	$(this).next("span").remove();
			  	$(this).after("<span class='red'>Name must be unique</span>");
			  	$(".red").css("color", "red");
		 	} 
	});
	$('.add-more-course').on('click',function(event){
		event.preventDefault();
		var tot=parseInt($(".add-more-controllers").length)+1;
		var html = $.parseHTML($('.extra-class-subjects').html());
		
		$("#class_counts").val(parseInt($("#class_counts").val())+1);
		$(html).find('.relevant_classes').attr('name','relevant_classes_'+$("#class_counts").val());
		$(html).find('.relevant_classes').attr('id','relevant_classes_'+$("#class_counts").val());
		$(html).find('.relevant_classes').val('');
		$(html).find('.relevant_subjects').val('');
		$('.add-more-controllers').append(html);
		
		$('.relevant_classes').change(function(event){
			var change_value = $(this).val();
			var error = 0;
			$(this).next("span").remove();
	 		$('.relevant_classes').each(function(i, selected){ 
					if(change_value == $(selected).val()){
						error = parseInt(error)+1;
					}
			});
			if(parseInt(error)>1){
				$(this).val("");
			   	$(this).next("span").remove();
			  	$(this).after("<span class='red'>Name must be unique</span>");
			  	$(".red").css("color", "red");
				return false;
			}
			$(this).closest('div .relevent_class').next().find('#relevant_subjects').attr('name','relevant_subjects'+$(this).val()+'[]')
		});
		
	});

	
	
 });

 if($('#edit-hidden').val() == 'edit'){ 
 $('.relevant_classes').change(function(event){
 			
			$(this).closest('div .relevent_class').next().find('#relevant_subjects').attr('name','relevant_subjects'+$(this).val()+'[]')
		});
 }
 $('.relevant_classes').change(function(event){ 
		var change_value = $(this).val();
		var error = 0;
		$(this).next("span").remove();
 		$('.relevant_classes').each(function(i, selected){ 
				if(change_value == $(selected).val()){
					error = parseInt(error)+1;
				}
		});
		if(parseInt(error)>1){
			$(this).val("");
		   	$(this).next("span").remove();
		  	$(this).after("<span class='red'>Name must be unique</span>");
		  	$(".red").css("color", "red");
			return false;
		}
		$(this).closest('div .extra-class-subjects').find('#relevant_subjects').attr('name','relevant_subjects'+$(this).val()+'[]')
	});
 function delete_row(r){
 
		 $(".extra-name"+r).remove();
		 $(".delete"+r).remove();
		 $("#name-error"+r).remove(); 
	}
  if($(".email_content").size() > 0) {
				  CKEDITOR.replace( 'email_content',{ 
            		height: 300,
			resize_dir: 'both',
			resize_minWidth: 200,
			resize_minHeight: 400,  
					});
				}
