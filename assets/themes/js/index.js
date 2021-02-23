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

	//Fancybox script
	$('.fancybox').fancybox({
		title   : null,
		padding : 0,
		autoCenter:true,
		closeClick  : false, // preven  ts closing when clicking INSIDE fancybox
		helpers     : { 
			overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		},
		//afterLoad: function() {			
				//$('.scroll-cont').jScrollPane({
				//mousewheel:100,
				//autoReinitialise:true
				//});
    	//}
	});	
		//Scrollpane script
	//$('.fancy-cont ').livequery(function(){
		//$('.fancy-cont').jScrollPane({
		//	mousewheel:100,
		//	autoReinitialise:true
	//	});
	//});

	if ($("#dropdown-surprise").find(".subactive").length != 0){
    	$("#dropdown-surprise").addClass('in');
	}
	if ($("#dropdown-table").find(".subactive").length != 0){
    	$("#dropdown-table").addClass('in');
	}
	if ($("#dropdown-cms").find(".subactive").length != 0){
    	$("#dropdown-cms").addClass('in');
	}
	if ($("#dropdown-reports").find(".subactive").length != 0){
    	$("#dropdown-reports").addClass('in');
	}
	if ($("#dropdown-questions").find(".subactive").length != 0){
    	$("#dropdown-questions").addClass('in');
	}
	// $('#choice_count').on('change',function(){
	//         	$('.choices-options').html('');
	// 			$(".answer_type-options").html("");
	// 			$('#correct_answer').html("");
	// 			$('#explanation').val("");


	// 		if($(this).val() != '') {
	// 			$('#correct_answer').val("");
	// 			$('#explanation').val("");
	// 			$(".answer_type-options").html("");
	// 			for(var i=1; i<=$('#choice_count').val(); i++){
	// 				$('.answer_type-options').append('<div class="form-group answer_type'+i+'" style="display: block;"><label class="col-sm-2 control-label">Answer Type '+String.fromCharCode(64+i)+' <span class="required">*</span></label><div class="col-sm-4"><select name="answer_type'+i+'" id="answer_type'+i+'" data-option_number="'+i+'" class="form-control class_answer_type" placeholder="Option '+String.fromCharCode(64+i)+'" ><option value=" ">Select</option><option value="1">Text</option><option value="2">Image</option></select></div></div>');
	// 			}
	// 		}else{
	// 			$('.choices-options').html('');
	// 			$(".answer_type-options").html("");
	// 			$('#correct_answer').html("");
	// 			$('#explanation').val("");
	// 		}
				

	// });

	$(document).on('change','.class_answer_type',function(){
		var id = $(this).attr("id");
		var option_number = $(this).data("option_number");
				var qtype = $('#'+id).val();
				if(qtype != ""){
					$(".choices"+option_number).html('');
					var i=1;
					if(qtype == 1){
						$('.choices-options').append('<div class="form-group choices'+option_number+'" style="display: block;"><label class="col-sm-2 control-label">Option '+String.fromCharCode(64+option_number)+' <span class="required">*</span></label><div class="col-sm-4"><input type="text" id="choices'+option_number+'" class="form-control" placeholder="Option '+String.fromCharCode(64+option_number)+'" value="" name="choices'+option_number+'"></div></div>');
					}
					else if(qtype == 2){
						$('.choices-options').append('<div class="form-group choices'+option_number+'" style="display: block;"><label class="col-sm-2 control-label">Option '+String.fromCharCode(64+option_number)+' <span class="required">*</span></label><div class="col-sm-4"><input type="file" id="choices'+option_number+'" class="form-control" placeholder="Option '+String.fromCharCode(64+option_number)+'" value="" name="choices'+option_number+'"><small>Allowed Types: gif,jpg,jpeg,png. Allowed Size: </small> </div></div>');
					}else{
						$(".choices"+option_number).html('');
					}
				}
	});




	
	$('#question_type').on('change',function(){
		$('.question-textimg-div').remove();
		var type = $('#question_type').val();
		if(type==1){
			$field = '<div class="form-group question-textimg-div"><label class="col-sm-2 control-label" for="question">Question <span class="required">*</span></label><div class="col-sm-4"><textarea id="question" class="form-control" placeholder="Question" rows="10" cols="40" name="question"></textarea></div></div>';
			$('#question_type').parents('.form-group').after($field);
		}else{
			$field = '<div class="form-group question-textimg-div"><label class="col-sm-2 control-label" for="question">Question <span class="required">*</span></label><div class="col-sm-4"><input type="file" name="question" value="" placeholder="" class="form-control" id="question"><small>Allowed Types: gif,jpg,jpeg,png |</small></div></div>';
			$('#question_type').parents('.form-group').after($field);
		}
	});
	
	// $('#answer_type').on('change',function(){		
	// 	if($(this).val() != '') {
	// 		$('#correct_answer').val("");
	// 		$('#explanation').val("");
	// 		if($(this).val() == 1){
	// 			$('#choice_count').val("");
	// 			$('.choices-options').html('');
	// 			$('#choice_count').on('change',function(){ 
	// 				if($(this).val() != ''){ 
	// 					$('.choices-options').html('');
	// 					for(var i=1; i<=$(this).val(); i++){
	// 						$('.choices-options').append('<div class="form-group choices'+i+'" style="display: block;"><label class="col-sm-2 control-label" for="choices'+i+'">Option '+String.fromCharCode(64+i)+' <span class="required">*</span></label><div class="col-sm-4"><input type="text" id="choices'+i+'" class="form-control" placeholder="Option '+String.fromCharCode(64+i)+'" value="" name="choices[]"></div></div>');
	// 					}
	// 				}else{
	// 					$('#explanation').val("");
	// 				}
	// 			});
	// 		}else{
	// 			$('#choice_count').val("");
	// 			$('.choices-options').html('');
	// 			$('#choice_count').on('change',function(){ 
	// 				if($(this).val() != ''){ 
	// 					$('.choices-options').html('');
	// 					for(var i=1; i<=$(this).val(); i++){
	// 						$('.choices-options').append('<div class="form-group choices'+i+'" style="display: block;"><label class="col-sm-2 control-label" for="choices'+i+'">Option '+String.fromCharCode(64+i)+' <span class="required">*</span></label><div class="col-sm-4"><input type="file" id="choices'+i+'" class="form-control" placeholder="Option '+String.fromCharCode(64+i)+'" value="" name="choices[]"><small>Allowed Types: gif,jpg,jpeg,png | min 300*300 px</small> </div></div>');
	// 					}
	// 				}else{
	// 					$('#explanation').val("");
	// 				}
	// 			});
	// 		}
	// 	}else{
	// 		$('#choice_count').val("");
	// 		$('.choices-options').html('');
	// 		$('#correct_answer').val("");
	// 		$('#explanation').val("");
	// 	}
		
	// });
	
	
	$('#explanation_type').on('change',function(){
		$('.explanation-textimg-div').remove();
		$('.note_t').remove();
		var type = $('#explanation_type').val();
		if(type==1 || type==0){
			$field = '<div class="form-group explanation-textimg-div"><label class="col-sm-2 control-label" for="explanation">Explanation</label><div class="col-sm-4"><textarea id="explanation" class="form-control" placeholder="Explanation" rows="10" cols="40" name="explanation"></textarea></div></div><div class="form-group note_t"><div class="col-sm-2"></div><div class="col-sm-4"><small></small></div></div>';
			$('#explanation_type').parents('.form-group').after($field);
			$('small').html('Note: use html tags (&lt;ul&gt;&lt;li&gt;Text&lt;/li&gt;&lt;/ul&gt;) for bullet points.').text();
		}else if(type==2){
			$field = '<div class="form-group explanation-textimg-div"><label class="col-sm-2 control-label" for="explanation">Explanation</label><div class="col-sm-4"><input type="file" name="explanation" value="" placeholder="" class="form-control" id="explanation"><small>Allowed Types: gif,jpg,jpeg,png | </small></div></div>';
			$('#explanation_type').parents('.form-group').after($field);
		}
	});
	
	
	$('#user_list option[value=""]').attr("disabled", "disabled");
	$('.relevant_subjects option:first-child').attr("disabled", "disabled");
	$('.relevant_classes option:first-child').attr("disabled", "disabled");
	$('#expiry-date').datetimepicker({
		lang:'en',
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
		minDate:0, 
	});
	
		
	$('.search_ques').submit(function(e){
		if($('#search_name').val() == '' && $('#course_list').val() == '' && $('#class_list').val() == '' && $('#subject_list').val() == '' && $('#chapter_list').val() == '' && $('#level_list').val() == '' && $('#set_list').val() == ''){
			alert('Please enter valid keyword');
			return false;
		}
		else{
			return true;
		}
	});
	$('.search_surprise_test').submit(function(e){
		if($('#search_name').val() == '' && $('#search_from_date').val() == '' && $('#search_to_date').val() == '' && $('#search_course').val() == ''){
			alert('Please enter valid keyword');
			return false;
		}
		else{
			return true;
		}
	});
	
	$('#search_date').datetimepicker({
		lang:'en',
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
	});
	
	$('#search_from_date').datetimepicker({
		lang:'en',
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
	});
	$('#search_to_date').datetimepicker({
		lang:'en',
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
	});
	$('#search_from_date').change(function(){
		if($(this).val()!=""){
			$('#search_to_date').datetimepicker({
			lang:'en',
			timepicker:false,
			format:'Y-m-d',
			formatDate:'Y-m-d',
			minDate:$(this).val()			
			});
		}		
	});
	$('#search_to_date').change(function(){
		if($(this).val()!=""){
			$('#search_from_date').datetimepicker({
			lang:'en',
			timepicker:false,
			format:'Y-m-d',
			formatDate:'Y-m-d',
			maxDate:$(this).val()			
			});
		}		
	});
	
	$('#from_date').datetimepicker({
		lang:'en',
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
		minDate:0,
	});
	$('#from_date').change(function(){
		$('#to_date').datetimepicker({
			lang:'en',
			timepicker:false,
			format:'Y-m-d',
			formatDate:'Y-m-d',
			minDate:$(this).val(),
		});
	});
	
	$('#to_date').datetimepicker({
			lang:'en',
			timepicker:false,
			format:'Y-m-d',
			formatDate:'Y-m-d',
			minDate:$('#from_date').val(),
		});
	/* orders page */
	$('#from_date_list').datetimepicker({
		lang:'en',
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
		maxDate:new Date()
	});
	
	$('#from_date_list').change(function(){
		$('#to_date_list').val("");
		$('#to_date_list').datetimepicker({
			lang:'en',
			timepicker:false,
			format:'Y-m-d',
			formatDate:'Y-m-d',
			minDate:$(this).val(),
		});
	});
	$('#to_date_list').datetimepicker({
			lang:'en',
			timepicker:false,
			format:'Y-m-d',
			formatDate:'Y-m-d',
			minDate:$('#from_date_list').val(),
			maxDate:new Date()
		});

	$('#meeting_date').datetimepicker({
		lang:'en',
		timepicker:false,
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
    	var url = base_url + "admin/questions_master/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + $('#course_list').val() +"&class_id=" + $('#class_list').val() + "&subject_id=" + $('#subject_list').val() + "&chapter_id=" + $('#chapter_list').val() + "&level_id=" +$('#level_list').val(),
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#set_list").html("");
                	 $("#set_list").append("<option value=''>Select Set</option>");
                	$.each( obj.set_list, function( key, value ) {
                			if(key != ''){
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
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#level_list").html("");
                	$("#level_list").append("<option value=''>Select Level</option>");
                	$.each( obj.level_list, function( key, value ) {
                			if(key != 'Select'){
								$("#level_list").append("<option value="+value+">"+key+"</option>");
							}
										
					});
                }
            }
        });
	});
	
     $('#subject_list').on('change', function() {
    	var url = base_url + "admin/levels/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + $('#course_list').val() +"&class_id=" + $('#class_list').val() + "&subject_id=" + this.value,
            success: function (result) { 
                if(result != ''){
                 
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#chapter_list").html("");
                	$("#chapter_list").append("<option value=''>Select Chapter</option>");
                	$.each( obj.chapter_list, function( key, value ) {
                			if(key != 'Select'){
								$("#chapter_list").append("<option value="+value+">"+key+"</option>");
							}
										
					});
                }
            }
        });
	});
	
	
    $('#course_list').on('change', function() {
		
    	var url = base_url + "admin/chapters/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#class_list").html("");
                	$("#subject_list").html("");
                	$("#class_list").append("<option value=''>Select Class</option>");
                	$.each( obj.class_list, function( key, value ) {
							$("#class_list").append("<option value="+value+">"+key+"</option>");
					});
					$("#subject_list").append("<option value=''>Select Subject</option>");
                }				
            }
        });
	});	
	$('#class_list').on('change', function() {
		
    	var url = base_url + "admin/chapters/request1";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" +$('#course_list').val()+"&class_id="+ this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#subject_list").html("");
					$("#subject_list").append("<option value=''>Select Subject</option>");
					$.each( obj.subject_list, function( key, value ) {
							$("#subject_list").append("<option value="+value+">"+key+"</option>");
										
					});
                }				
            }
        });
	});	

	$('input[name="show_options"]').on('click', function() {
	   if($(this).val() == 1){
		$("#correct_answer").removeAttr("multiple");   
	   }else{
		$("#correct_answer").attr("multiple",true);   
	   }
	});
	
	//correct answer 
	$('#choice_count').on('change', function() {
		// alert(this.value);
    	var url = base_url + "admin/questions_master/correct_answer";
     	$.ajax({
            type: "POST",
            url: url,
            data: "count=" + this.value,
            success: function (result) {
				$("#correct_answer").html(" ");
				//$("#correct_answer").append("<option value='' 'disabled'>Select</option>");
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	console.log(obj);
				
					$.each( obj.correct_answer, function( key, value ) {
						
						$("#correct_answer").append("<option value="+key+">"+value+"</option>");
					});
                }
            }
        });
	});
	//surprise questions correct answer
	// $('#choice_count').on('change', function() {
 //    	var url = base_url + "admin/surprise_questions/correct_answer";
 //     	$.ajax({
 //            type: "POST",
 //            url: url,
 //            data: "count=" + this.value,
 //            success: function (result) {
	// 			$("#correct_answer").html("");
	// 				//$("#correct_answer").append("<option value=''>Select</option>");
 //                if(result != ''){
 //                	var obj = jQuery.parseJSON($.trim(result));
 //                	console.log(obj);
				
	// 				$.each( obj.correct_answer, function( key, value ) {
	// 					$("#correct_answer").append("<option value="+key+">"+value+"</option>");
	// 				});
 //                }
 //            }
 //        });
	// });
	//subjective question
	$('.subjective_course').on('change', function() {
		$(".subjective_cat option[value='']").text("Select Sub Category");
	});
	
	// get tests
	$('#course_list').on('change', function() {
    	var url = base_url + "admin/surprise_test/get_tests";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course=" + this.value,
            success: function (result) {
				$("#test_name").html("");
					$("#test_name").append("<option value=''>Select</option>");
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
						$.each( obj.test_list, function( key, value ) {
							$("#test_name").append("<option value="+key+">"+value+"</option>");
						});
                }
            }
        });
	});
	

	



	$('.add-more').on('click',function(event){
		event.preventDefault();
 		var template=$.parseHTML($(".template0").html()); 
		var tot=parseInt($(".extra-name").length)+1;
		
		$(template).find("input").val("");
		$(template).find("textarea").val("");
		$(template).find(".error").remove();		
		var id=$(template).find("input[id='name']").attr("id");
		var id_order=$(template).find("input[id='order']").attr("id");
		var id_text=$(template).find("textarea").attr("id");
		$(template).find("input[id='name']").attr("id",id+tot);
		$(template).find("label[for='"+id+"']").attr("for",id+tot);  		 
		$(template).find("input[id='order']").attr("id",id_order+tot);
		$(template).find("label[for='"+id_order+"']").attr("for",id_order+tot); 	
		if($('#course_list').val() !="" && $('#class_list').val() !="" && $('#subject_list').val() !=""){
			var last_order = $(".check_order").last().val();		
			if((!isNaN(last_order)) && last_order!=""){					
				$(template).find("input[id='"+id_order+tot+"']").val(parseInt(last_order)+1);
			}
		}		 
		$(template).find("textarea").attr("id",id_text+tot);
		$(template).find("label[for='"+id_text+"']").attr("for",id_text+tot);		 
		$(template).find("div").each(function(){
			 $(this).parent().addClass("template"+tot);
		});
		$(template).find("textarea").after('<a style="color:red;margin-top:5px" href="javascript:delete_row('+tot+');" row='+tot+' class="delete-name pull-right delete'+tot+'"><span class="icon glyphicon glyphicon-trash" ></span>Remove </a>');
	
		$('.add-more-name').append(template);
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
	
	
	$('input[type="radio"]').click(function() {
       if($(this).attr('id') == 'enable') {
            $('#time').show();           
       }
       else {
            $('#time').hide();   
       }
   });
	
	$('.add-more-course').on('click',function(event){
		event.preventDefault();
		var tot=parseInt($(".add-more-controllers").length)+1;
		var html = $.parseHTML($('.extra-class-subjects').html());
		var num=parseInt($("#class_counts").val())+1;
		$("#class_counts").val(parseInt($("#class_counts").val())+1);
		$(html).find('.relevant_classes').attr('name','relevant_classes_'+$("#class_counts").val());
		$(html).find('.relevant_classes').attr('id','relevant_classes_'+$("#class_counts").val());
		$(html).find('.relevant_classes').val('');
		$(html).find('.relevant_subjects').val('');
		$(html).find('.error').remove();		
		$(html).find('.relevant_subjects').parent().parent().closest('div').addClass('remove_class'+num);
		$(html).find('.relevant_classes').parent().parent().closest('div').addClass('remove_class'+num);
		var str = 'remove_class'+num;
		$(html).find('.relevant_subjects').after("<a style='color:#F90202;' class='delete_relevant_class delete_relevant_class1' href='javascript:delete_relevant_class(\""+str+"\",this);'><span class='icon glyphicon glyphicon-trash'></span>Remove</a>");
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

	$('#page_id_classes').on('change', function() {
		if($(this).val() == ""){
			return false;
		}
		var url = base_url + "admin/advertisements/request";
		$.ajax({
			type: "POST",
            url: url,
            data: "page_id=" +  $(this).val(),
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#position_id_classes").html("");
                	$("#position_id_classes").append("<option value=''>Select</option>");
                	$.each( obj.position_list, function( key, value ) {
						if(value != 'Select'){
						$("#position_id_classes").append("<option value="+key+">"+value+"</option>");
						}
					});
                }
            }
		
		});
	});
	
 });
 function delete_relevant_class(str,t){
	 $("."+str).remove();
	 
	 $(t).remove();
	
 	  	var j=1;
 		$('.add-more-controllers .relevant_classes').each(function () { 
		 	$(this).attr('name','relevant_classes_'+j);
		 	$(this).attr('id','relevant_classes_'+j);
		 	j++;
	 	});
	 	var k=1;
	 	$('.add-more-controllers .delete_relevant_class1').each(function () { 
	 		var str1 = 'remove_class'+k;
	 		$(this).attr('href','javascript:delete_relevant_class("'+str1+'",this);'); 
			$(this).parent().parent().closest('div').removeAttr('class');
			$(this).parent().parent().closest('div').addClass('form-group relevent_subject remove_class'+k);
			$(this).parent().parent().closest('div').prev("div").removeAttr('class');
			$(this).parent().parent().closest('div').prev("div").addClass('form-group  relevent_class remove_class'+k);
	 		k++;
	 	});
 	  $("#class_counts").val(j-1);
	
 }
 
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
 			$(".template"+r).remove();
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
			extraPlugins: 'justify'
					});
				}
	if($("#contact_address").size() > 0) {
				  CKEDITOR.replace( 'contact_address',{ 
            		height: 300,
			resize_dir: 'both',
			resize_minWidth: 200,
			resize_minHeight: 400,  
			extraPlugins: 'justify'
					});
			
				}
	CKEDITOR.on("instanceReady", function(event) {   // to set source as default in editor
		event.editor.commands.source.exec();
	});
// for radio button
$(".col-sm-4 label").click(function(){
 $(this).prev("input").trigger("click")
 return false
});

$("#url").click(function(e){
	var vals=$(this).val();
	if(vals==""){
		$(this).val("http://");
	}	
});
$(".pagination li a").each(function(){
var titles=$(this).text();
  $(this).attr("title",titles);
});

$(".select-all").livequery('click',function(){
	if($(this).text()=="Select All"){
		if(($(this).next().find("option").length)>1){
			var htmls=$(this).next().find("option");
			$(htmls).each(function(){
				if($(this).val()!=""){
				 $(this).prop("selected", true);
				}
			});
			$(this).text("Unselect All");
		}
	}else{
		var htmls=$(this).next().find("option");
		$(htmls).each(function(){
		 $(this).prop("selected", false);
		});		
	$(this).text("Select All");
	}
});
 
 $(".today-test").click(function(){
	$(".sub-exam").fadeToggle("fast"); 
 }); 
 	$('#course_list').on('change', function() {			
    	var url = base_url + "admin/alerts/getusers";
    	if(this.value==""){
    		$("#user_list").select2("val", "");
    		$("#user_list").empty();
    	}else{    	    		
    		$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + this.value,
            success: function (result) {
                if(result != ''){       		           				
					   var obj = jQuery.parseJSON($.trim(result)); 
					   $("#user_list").empty(); 					   	 
         			$.each(obj, function( key, value ) {           				       				
         				$("#user_list").append("<option value="+value.id+">"+value.name+"</option>");         				
						});
                }
            }
        });
    	}     	
	});
 $(function(){ 	
 var elm=document.forms[0].elements[0];
  if($(elm).attr("name")!="search_from_date"&& $(elm).attr("name")!="search_date"){
	  document.forms[0].elements[0].focus();
  }
	
	$("#user_list").select2();
	if($("input[name='users']:checked").val()==2){	
		$("#user_list").addClass("element-hide");
		$(".select2").addClass("element-hide");			
	}else{
		$("#user_list").removeClass("element-hide");
		$(".select2").removeClass("element-hide");
	}	
	$("[name='users']").on("click", function(){		
		if($(this).val()==2){
			$("#user_list").addClass("element-hide");
			$(".select2").addClass("element-hide");			
			if($("#user_list > option").is(":selected")){
				$("#user_list > option").removeAttr("selected");
				$("#user_list").trigger("change");}
		}else{
			$("#user_list").removeClass("element-hide");
			$(".select2").removeClass("element-hide");
			if($("#user_list > option").is(":selected")){
				$("#user_list > option").removeAttr("selected");
				$("#user_list").trigger("change");
			}
		}
	});
	
 });
 $("#free").click(function(){ 	
 	$("#price-div").addClass("element-hide");
 	$("#price-div1").addClass("element-hide");
 	$("#short_desc").addClass("element-hide"); 	
 });
 $("#paid").click(function(){ 
 	$("#price-div").removeClass("element-hide");
 	$("#price-div1").removeClass("element-hide");
 	$("#short_desc").removeClass("element-hide");
 });
 if($(".banner_description").size() > 0) {
	 CKEDITOR.replace('banner_description',{ 
		height: 300,
		resize_dir: 'both',
		resize_minWidth: 200,
		extraPlugins: 'justify',
		resize_minHeight: 400});
	}
	// if($(".meeting_description").size() > 0) {
	// 	CKEDITOR.replace('meeting_description',{ 
	// 	   height: 300,
	// 	   resize_dir: 'both',
	// 	   resize_minWidth: 200,
	// 	   extraPlugins: 'justify',
	// 	   resize_minHeight: 400});
	//    }
 $('#search_course').on('change', function() { 		
    	var url = base_url + "admin/certificates/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#search_class").html("");
                	$("#search_subject").html("");
                	$("#search_chapter").html("");
                	$("#search_level").html("");
                	$("#search_set").html("");
                	$("#search_class").append("<option value=''>Select Class</option>");
                	$("#search_subject").append("<option value=''>Select Subject</option>");
                	$("#search_chapter").append("<option value=''>Select Chapter</option>");
                	$("#search_level").append("<option value=''>Select Level</option>");
                	$("#search_set").append("<option value=''>Select Set</option>");
                	$.each( obj.class_list, function( key, value ) {
							$("#search_class").append("<option value="+value+">"+key+"</option>");
						});					
                }			
            }
        });
	});
	
	$('.search_course_class').on('change', function() { 		
    	var url = base_url + "admin/certificates/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#search_class").html("");
                	$("#search_class").append("<option value=''>Select Class</option>");
                	$.each( obj.class_list, function( key, value ) {
							$("#search_class").append("<option value="+value+">"+key+"</option>");
						});					
                }			
            }
        });
	});


	$('#search_class').on('change', function() { 		
    	var url = base_url + "admin/certificates/request1";
    	var course_id = $('#search_course').val();
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id="+course_id+"&class_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result)); 	
                	$("#search_subject").html("");
                	$("#search_chapter").html("");
                	$("#search_level").html("");
                	$("#search_set").html("");
                	$("#search_chapter").append("<option value=''>Select Chapter</option>");                	
						$("#search_subject").append("<option value=''>Select Subject</option>");
						$("#search_level").append("<option value=''>Select Level</option>");
						$("#search_set").append("<option value=''>Select Set</option>");
						$.each( obj.subject_list, function( key, value ) {
								$("#search_subject").append("<option value="+value+">"+key+"</option>");										
						});
                }				
            }
        });
	});
	
	$('#search_subject').on('change', function() { 		
    	var url = base_url + "admin/certificates/request2";
    	var course_id = $('#search_course').val();
    	var class_id = $('#search_class').val();
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id="+course_id+"&class_id="+class_id+"&subject_id="+this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result)); 
                	console.log(obj);
                	$("#search_chapter").html("");
                	$("#search_level").html("");
                	$("#search_set").html("");
                	$("#search_chapter").append("<option value=''>Select Chapter</option>");  
						$.each( obj.chapter_list, function( key, value ) {	
							$("#search_chapter").append("<option value="+value+">"+key+"</option>");										
						});
                }				
            }
        });
	});
	
	$('#search_chapter').on('change', function() { 		
    	var url = base_url + "admin/certificates/request3";
    	var course_id = $('#search_course').val();
    	var class_id = $('#search_class').val();
    	var subject_id = $('#search_subject').val()
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id="+course_id+"&class_id="+class_id+"&subject_id="+subject_id+"&chapter_id="+this.value,
            success: function (result) {
		      	if(result != ''){
		      		var obj = jQuery.parseJSON($.trim(result)); 		          	
		          	$('.questions_search').html('');
		          	$("#search_level").append("<option value=''>Select Level</option>");
		          	$("#search_set").append("<option value=''>Select Set</option>");
						$.each( obj.level_list, function( key, value ) {	
							$("#search_level").append("<option value="+value+">"+key+"</option>");										
						});
		          }				
		      }
        });
	});
	
	$('#search_level').on('change', function() { 		
    	var url = base_url + "admin/certificates/request4";
    	var course_id = $('#search_course').val();
    	var class_id = $('#search_class').val();
    	var subject_id = $('#search_subject').val()
    	var chapter_id = $('#search_chapter').val()
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id="+course_id+"&class_id="+class_id+"&subject_id="+subject_id+"&chapter_id="+chapter_id+"&level_id="+this.value,
            success: function (result) {
		      	if(result != ''){
		      		var obj = jQuery.parseJSON($.trim(result)); 		          	
		          	$("#search_set").html("");
		          	$("#search_set").append("<option value=''>Select Set</option>");
						$.each( obj.set_list, function( key, value ) {	
							$("#search_set").append("<option value="+value+">"+key+"</option>");										
						});
		          }				
		      }
        });
	});
	
	$('#test_type').on('change', function(){
		$('#search_course').val("");
		$("#search_class").html("");
    	$("#search_subject").html("");
    	$("#search_chapter").html("");
    	$("#search_class").append("<option value=''>Select Class</option>");
    	$("#search_subject").append("<option value=''>Select Subject</option>");
    	$("#search_chapter").append("<option value=''>Select Chapter</option>");
		if($(this).val()=="2"){
			$('#search_class').addClass('element-hide');
			$('#search_subject').addClass('element-hide');
			$('#search_chapter').addClass('element-hide');
		}else{			
			$('#search_class').removeClass('element-hide');
			$('#search_subject').removeClass('element-hide');
			$('#search_chapter').removeClass('element-hide');
		}
	});
	
	$('.search_surprise_ques #search_course').on('change', function(){		
		var url = base_url + 'admin/surprise_questions/request';
		$.ajax({
			type: 'POST',
			url: url,
			data: 'course_id='+this.value,
			success: function(result){
				if(result != ''){
            	var obj = jQuery.parseJSON($.trim(result));              	
             	$("#search_test").html("");
             	$("#search_test").append("<option value=''>Select Test</option>");  
					$.each( obj.test_list, function( key, value ) {	
							$("#search_test").append("<option value="+value+">"+key+"</option>");										
					});
          	}	
			}
		});
	});
	//material page
	$('#courselist').on('change', function() {
    	var url = base_url + "admin/downloads/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#classlist").html("");
                	$("#subjectlist").html("");
                	$("#classlist").append("<option value=''>Select Class</option>");
                	$.each( obj.class_list, function( key, value ) {
							$("#classlist").append("<option value="+key+">"+value+"</option>");
					});
					$("#subjectlist").append("<option value=''>Select Subject</option>");
                }				
            }
        });
	});	
	
	$('#classlist').on('change', function() {
    	var url = base_url + "admin/downloads/request1";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + $('#courselist').val() + "&class_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#subjectlist").html("");
					$("#subjectlist").append("<option value=''>Select Subject</option>");
					$.each( obj.subject_list, function( key, value ) {
						$("#subjectlist").append("<option value="+key+">"+value+"</option>");
										
					});
                }				
            }
        });
	});

	$('#subjectlist').on('change', function() {
    	var url = base_url + "admin/certificates/request2";
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + $('#courselist').val() + "&class_id=" + $('#classlist').val()+ "&subject_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#chapterlist").html("");
					$("#chapterlist").append("<option value=''>Select Chapter</option>");
					$.each( obj.chapter_list, function( key, value ) {
						$("#chapterlist").append("<option value="+value+">"+key+"</option>");
										
					});
				 }				
            }
        });
	});


	


	//all privileges
	$('#privil_all').click(function(event) {  //on click
		$('.js-privil-all').attr('checked',false);
        if(this.checked) { // check select status
            $('.js-privil-all').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "js-checkbox" 
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').addClass('selectrow');
				$('#rowclick1 tr').filter(':has(:checkbox:unchecked)').removeClass('selectrow');
            });
        }else{
            $('.js-privil-all').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "js-checkbox"
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').addClass('selectrow');
				$('#rowclick1 tr').filter(':has(:checkbox:unchecked)').removeClass('selectrow');
            });        
        }
    });
    //sub modules
    $('.parent').click(function(event) {  //on click
    	var parent_id = $(this).val();
		$('.js_sub_all_'+parent_id).attr('checked',false);
        if(this.checked) { // check select status
            $('.js_sub_all_'+parent_id).each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "js-checkbox" 
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').addClass('selectrow');
				$('#rowclick1 tr').filter(':has(:checkbox:unchecked)').removeClass('selectrow');
            });
        }else{
            $('.js_sub_all_'+parent_id).each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "js-checkbox"
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').addClass('selectrow');
				$('#rowclick1 tr').filter(':has(:checkbox:unchecked)').removeClass('selectrow');
            });        
        }
    });
    
    //offline subscription
    $('offline_subscription #course_cat').on('change', function() {
		$('#course_detail').css('display','none');
		$('#price').css('display','none');
    	var url = base_url + "admin/offline_subscription/request";
     	$.ajax({
            type: "POST",
            url: url,
            data: "user_id=" + $('#user_name').val()+"&cate_id="+this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#course").html("");
                	$("#course").append("<option value=''>Select</option>");
                	$.each( obj.course, function( key, value ) {
							$("#course").append("<option value="+value+">"+key+"</option>");
					});
                }				
            }
        });
	});	
	$('#offline_subscription #course').on('change', function() {
	 	if(this.value == "")
	 	{
	 		$('#course_detail').css('display','none');
	 		$('#price').css('display','none');
	 	}
    	var url = base_url + "admin/offline_subscription/request2";
    	if(this.value != ""){
     	$.ajax({
            type: "POST",
            url: url,
            data: "course_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$('#course_detail').css('display','block');
                	$('#price').css('display','block');                	
                	var price =Math.round( obj.price);
                	var price_d =Math.round( obj.price_d);
                	var duration = obj.duration;
                	var expiry = obj.expiry_date;
                	if(obj.currency_type==1){
                		$("#active").show();
                		$("#active").next().show();
                		$("#active").prop("checked", true);
                		$("#active").next().html("<i class='fa fa-rupee'></i> "+price);
                		$("#inactive").hide();
                		$("#inactive").next().hide();
                	}else if(obj.currency_type==2){
                		$("#inactive").show();
                		$("#inactive").next().show();
                		$("#inactive").prop("checked", true);
                		$("#inactive").next().html("<i class='fa fa-dollar'></i> "+price_d);
                		$("#active").hide();
                		$("#active").next().hide();
                	}else if(obj.currency_type==3){
                		$("#active").show();
                		$("#active").next().show();
                		$("#inactive").show();
                		$("#inactive").next().show();
                		$("#active").prop("checked", true);
                		$("#active").next().html("<i class='fa fa-rupee'></i> "+price);
                		$("#inactive").next().html("<i class='fa fa-dollar'></i> "+price_d);
                	}
                	$('#cprice span').html(Math.round(price));
                	$('#cduration span').html(duration);
                	$('#cexpiry span').html(expiry);
                }
            }
        });
        }
	});	
	$('.cancel-btn').on('click',function() { 		
		if (window.confirm("Are you sure want to cancel this order?")) {
			return true;
		} else {
			return false;
		}
	});
	 $('#user_name').on('change', function() {
		$('#course_detail').css('display','none');
		$('#price').css('display','none');
    	var url = base_url + "admin/offline_subscription/request3";
     	$.ajax({
            type: "POST",
            url: url,
            data: "user_id=" + this.value,
            success: function (result) {
                if(result != ''){
                	var obj = jQuery.parseJSON($.trim(result));
                	$("#course").html("");
                	$("#course_cat").html("");
                	$("#course").append("<option value=''>Select</option>");
                	$("#course_cat").append("<option value=''>Select</option>");
                	$.each( obj.course, function( key, value ) {
							$("#course").append("<option value="+value+">"+key+"</option>");
					});
					$.each( obj.course_category, function( key, value ) {
							$("#course_cat").append("<option value="+value+">"+key+"</option>");
					});
                }				
            }
        });
	});
   
    // checkbox check


$(".sub_modules input[type='checkbox']").click(function(){
  var test=0;
var parent=$(this).parent().parent("ul");
  $(parent).find("li input").each(function(){
    if(!$(this).is(":checked")){
    test=1;
    }
  
  });
  if(test=="0"){
 var input= $(this).parent().parent().prev("label").prev("input[type='checkbox']");
   $(input).trigger("click");
    console.log(test);
  }else{
    var input= $(this).parent().parent().prev("label").prev("input[type='checkbox']");
  
   $(input). prop("checked",false);
  }
  

});	

$( "#user_key" ).click(function(){
	var inp_val = $('#user_key').val();
	if(inp_val == "Select"){
	$('#user_key').val("");}
	$("#user_name").css("display","block");
	$("option:selected").removeAttr("selected");
	
});
$( "#user_key" ).keyup(function(){
	$("#user_name").css("display","block");
	var keyword = $("#user_key").val();
	var url = base_url + "admin/offline_subscription/search";
 	$.ajax({
	    type: "POST",
	    url: url,
	    data: "keyword=" + keyword,
	    success: function (result) {
	        if(result != ''){
	        	var obj = jQuery.parseJSON($.trim(result));
	        	$("#user_name").html("");
	        	if(obj.suggest != ""){
			    	$.each( obj.suggest, function( key, value ) {
						$("#user_name").append("<option value="+key+">"+value+"</option>");
					});
				} else {
					$("#user_name").append("<option value='' disabled='disabled'>No Records Found</option>");
				}
			
	        }				
	    }
	});
});


$('#user_name').on('click',function(){
	$('#user_key_hidden').val($(this).val());
	$('#user_key').val($('#user_name option:selected').html());
	$("#user_name").css("display","none");
	$('#user_name option:selected').prop('false');
});
$('#course_plan_form #course_cat').on('change', function(){
	var hidden1 = $("#hidden1").val();
	var hidden2 = $("#hidden2").val();
	if(this.value==""){
		$('#order').val('');
	}else if(this.value!=hidden1){			
		var url = base_url + "admin/course_plan/get_count";
		$.ajax({
			type: 'POST',
			url: url,
			data: "course_id="+this.value,
			success: function(result){
				$('#order').val(result);									
			}
		});
	}else{
		$('#order').val(hidden2);
	}			
});

$('#chapters_form select').on('change', function(){			
	var hidden1 = $("#hidden1").val();
	var hidden2 = $("#hidden2").val();
	var hidden3 = $("#hidden3").val();
	var hidden4 = $("#hidden4").val();		
	if(this.id=="subject_list"){
		if($('#course_list').val() =="" || $('#class_list').val() =="" || $('#subject_list').val() ==""){
			$('.check_order').val('');
		}else if($('#course_list').val() !="" && $('#class_list').val() !="" && $('#subject_list').val() !=""){
			var url = base_url + "admin/chapters/get_Count";				
			if($('#course_list').val()==hidden1 && $('#class_list').val()==hidden2 && $('#subject_list').val()==hidden3){
				$('.check_order').val(hidden4);
			}else{
				$.ajax({
					type: 'POST',
					url: url,
					data: "course_id="+$('#course_list').val()+"&class_id="+$('#class_list').val()+"&subject_id="+$('#subject_list').val(),
					success: function(result){							
						var v = parseInt(result);
						var length = $('.check_order').length;						
						$('.check_order').each(function(){
							this.value = v;
							v += 1;
						});						
					}
				});	
			}									
		}					
	}else{
		$('.check_order').val('');
	}	
});

$('#course_category_list').on('change', function() {		
 	var url = base_url + "admin/chapters/request_course";
  	$.ajax({
         type: "POST",
         url: url,
         data: "category_id=" + this.value,
         success: function (result) {
             if(result != ''){
             	var obj = jQuery.parseJSON($.trim(result));
             	$("#course_list").html("");
             	$("#course_list").append("<option value=''>Select Course</option>");
             	$.each( obj.course_list, function( key, value ) {
						$("#course_list").append("<option value="+value+">"+key+"</option>");
				});   }				
         }
     });
});

$('#type').on('change', function(){						
	if(this.value==1){
		$("#type_date").val("");
		$("#type_date").attr("placeholder", "Enter the months");	
		$('#type_date').datetimepicker('destroy');	
	}else if(this.value==2){
		$("#type_date").val("");
		$("#type_date").attr("placeholder", "Enter the days");		
		$('#type_date').datetimepicker('destroy');	
	}else if(this.value==3){
		$("#type_date").val("");
		$("#type_date").attr("placeholder", "Choose the date");
		$("#type_date").keypress(function(event) {event.preventDefault();});			
		$('#type_date').datetimepicker({				
			lang:'en',
			timepicker:false,
			format:'Y-m-d',
			formatDate:'Y-m-d',
			minDate:new Date()
		});
	}else{
		$("#type_date").val("");
		$("#type_date").attr("placeholder", "");
		$('#type_date').datetimepicker('destroy');
	}
});
$('#apply').on('click', function(e){	
	if($('#hidden').val()==0){
		alert('There is no records to update');
		return false;		
	}else{
		if($('#type').val() == ''){
			alert('Please select the type');
			$('#type').focus();
			return false;
		}else if($('#type_date').val() == ''){
			alert('Please enter valid keyword');
			$('#type_date').focus();
			return false;
		}else{		
			var type = $('#type').val();
			var type_date = $('#type_date').val();
			if(type=='1' || type=='2'){
				if(isNaN(type_date)){
					$('#type_date').val('');
					alert('Please enter only numbers');
					$('#type_date').focus();
					return false;
				}else{					
					if(type_date.indexOf('.') !== -1)
					{
						$('#type_date').val('');
						alert("Decimal numbers are not allowed");
						return false;
					}			
				}							
			}
			/*var flag = 0;
			var job=document.getElementsByName('checkall_box[]');
			for(var i=0;i<job.length;i++) {
	 			if(job[i].checked == true){
				flag++;
				}
			}			
			if (flag == 0) {
				alert('Please select atleast one record!');
				$('#MoreActionId').val('');	
				return false;
		  	}else{
		  		return true;
		  	}*/
	  		var flag = 0;
			var job=document.getElementsByName('checkall_box[]');
			for(var i=0;i<job.length;i++) {
	 			if(job[i].checked == true){
				flag++;
				}
			}
			if (flag == 0) {
				if (window.confirm('Are you sure want to apply to all records?')) {
			 		return true;
			 	}else{
			 		return false;
			 	}
		  	}else{
		  		return true;
		  	}
		}
	}	
});

// modified for copy content

$('#search_course_from, #search_course_to').on('change', function() {		
	var m_id = "_from";	 		
	if(this.id=="search_course_to"){ 			
		m_id = "_to"; 			 			
	}else{
		$('#questions').addClass('element-hide');
	}		 			
 	var url = base_url + "admin/copy_content/request";
  	$.ajax({
         type: "POST",
         url: url,
         data: "course_id=" + this.value,
         success: function (result) {         	
             if(result != ''){             
             	var obj = jQuery.parseJSON($.trim(result)); 					
             	$("#search_class"+m_id).html("");
             	$("#search_subject"+m_id).html("");
             	$("#search_chapter"+m_id).html("");
             	$("#search_level"+m_id).html("");
             	$("#search_set"+m_id).html("");
             	$("#materials"+m_id).html("");
             	$("#search_class"+m_id).append("<option value=''>Select Class</option>");
             	$("#search_subject"+m_id).append("<option value=''>Select Subject</option>");
             	$("#search_chapter"+m_id).append("<option value=''>Select Chapter</option>");
             	$("#search_level"+m_id).append("<option value=''>Select Level</option>");
             	$("#search_set"+m_id).append("<option value=''>Select Set</option>");
             	$("#materials"+m_id).append("<option value=''>Select Material</option>");
             	var a = 0;
             	$.each( obj.class_list, function( key, value ) {   
             		if(m_id=="_from" && a==0){
             			$("#search_class"+m_id).append("<option value='all'>All classes</option>");                			
             		}             		
						$("#search_class"+m_id).append("<option value="+value+">"+key+"</option>");
						a = a + 1;
					});	
					/* modified */
					var b = 0;
					$.each( obj.subject_list, function( key, value ) {							
						if(m_id=="_from" && b==0){
							$("#search_subject"+m_id).append("<option value='all'>All subjects</option>");                			
						} 						
						$("#search_subject"+m_id).append("<option value="+key+">"+value+"</option>");		
						b = b + 1;								
					});

					var c = 0;
					$.each( obj.chapter_list, function( key, value ) {	
						if(m_id=="_from" && c==0){
							$("#search_chapter"+m_id).append("<option value='all'>All chapters</option>");                			
						}						
						$("#search_chapter"+m_id).append("<option value="+key+">"+value+"</option>");			
						c = c + 1;							
					});

					var d = 0;
					$.each( obj.level_list, function( key, value ) {
						if(m_id=="_from" && d==0){
							$("#search_level"+m_id).append("<option value='all'>All levels</option>");                			
						}	
						$("#search_level"+m_id).append("<option value="+value+">"+key+"</option>");	
						d = d + 1;									
					});

					var e = 0;
					$.each( obj.set_list, function( key, value ) {	
						if(m_id=="_from" && e==0){
							$("#search_set"+m_id).append("<option value='all'>All sets</option>");                			
						}						
						$("#search_set"+m_id).append("<option value="+key+">"+value+"</option>");
						e = e + 1;									
					});					
					if(m_id=="_from"){												
						if(obj.result=="failure"){		   			
		   				$('#questions').addClass('element-hide');
						}else{
							$('#questions').removeClass('element-hide');		
							if(obj.objective_question_count!="0"){
								$('#objective_question').removeClass('element-hide');
								$('#objective_question_label').removeClass('element-hide');	
								$('#obq').prop('checked', true);	   				
							}else{
								$('#objective_question').addClass('element-hide');
								$('#objective_question_label').addClass('element-hide');
								$('#obq').prop('checked', false);
							}
							if(obj.subjective_question_count!="0"){
								$('#subjective_question').removeClass('element-hide');
								$('#subjective_question_label').removeClass('element-hide'); 
								$('#sbq').prop('checked', true);				
							}else{
								$('#subjective_question').addClass('element-hide');
								$('#subjective_question_label').addClass('element-hide');
								$('#sbq').prop('checked', false);
							}		      			   		
						}
						
						var temp = 0;
						$.each( obj.material_list, function( key, value ) {	
							if(temp==0){
								$("#materials"+m_id).append("<option value='all'>All Materials</option>");
							}
							$("#materials"+m_id).append("<option value="+key+">"+value+"</option>");																
							temp = temp + 1;
						});	
					}
					
										
					
					/* modified */
             }			
         }
     });
});

$('#search_class_from, #search_class_to').on('change', function() { 		// modified for copy content
	
	var m_id = "_from";	 	
	var course_id;	
	if(this.id=="search_class_to"){ 			
		m_id = "_to"; 			 		
		course_id = $('#search_course'+m_id).val();	
	}else{
		$('#questions').addClass('element-hide');
		course_id = $('#search_course'+m_id).val();
	}
 	var url = base_url + "admin/copy_content/request1";    	
  	$.ajax({
         type: "POST",
         url: url,
         data: "course_id="+course_id+"&class_id=" + this.value,
         success: function (result) {
             if(result != ''){
             	var obj = jQuery.parseJSON($.trim(result));              	
             	$("#search_subject"+m_id).html("");
             	$("#search_chapter"+m_id).html("");
             	$("#search_level"+m_id).html("");
             	$("#search_set"+m_id).html("");
             	$("#materials"+m_id).html("");
             	$("#search_chapter"+m_id).append("<option value=''>Select Chapter</option>");                	
					$("#search_subject"+m_id).append("<option value=''>Select Subject</option>");
					$("#search_level"+m_id).append("<option value=''>Select Level</option>");
					$("#search_set"+m_id).append("<option value=''>Select Set</option>");
					$("#materials"+m_id).append("<option value=''>Select Material</option>");
					var a = 0;
					$.each( obj.subject_list, function( key, value ) {							
						if(m_id=="_from" && a==0){
             			$("#search_subject"+m_id).append("<option value='all'>All subjects</option>");                			
             		} 
						//$("#search_subject"+m_id).append("<option value="+value+">"+key+"</option>");
						$("#search_subject"+m_id).append("<option value="+key+">"+value+"</option>");		
						a = a + 1;								
					});
					
					/* modified */					

					var c = 0;
					$.each( obj.chapter_list, function( key, value ) {	
						if(m_id=="_from" && c==0){
							$("#search_chapter"+m_id).append("<option value='all'>All chapters</option>");                			
						}						
						$("#search_chapter"+m_id).append("<option value="+key+">"+value+"</option>");			
						c = c + 1;							
					});

					var d = 0;
					$.each( obj.level_list, function( key, value ) {
						if(m_id=="_from" && d==0){
							$("#search_level"+m_id).append("<option value='all'>All levels</option>");                			
						}	
						$("#search_level"+m_id).append("<option value="+value+">"+key+"</option>");	
						d = d + 1;									
					});

					var e = 0;
					$.each( obj.set_list, function( key, value ) {	
						if(m_id=="_from" && e==0){
							$("#search_set"+m_id).append("<option value='all'>All sets</option>");                			
						}						
						$("#search_set"+m_id).append("<option value="+key+">"+value+"</option>");
						e = e + 1;									
					});
					if(m_id=="_from"){
						if(obj.result=="failure"){		   			
		   				$('#questions').addClass('element-hide');
						}else{
							$('#questions').removeClass('element-hide');		
							if(obj.objective_question_count!="0"){
								$('#objective_question').removeClass('element-hide');
								$('#objective_question_label').removeClass('element-hide');	
								$('#obq').prop('checked', true);	   				
							}else{
								$('#objective_question').addClass('element-hide');
								$('#objective_question_label').addClass('element-hide');
								$('#obq').prop('checked', false);
							}
							if(obj.subjective_question_count!="0"){
								$('#subjective_question').removeClass('element-hide');
								$('#subjective_question_label').removeClass('element-hide'); 
								$('#sbq').prop('checked', true);				
							}else{
								$('#subjective_question').addClass('element-hide');
								$('#subjective_question_label').addClass('element-hide');
								$('#sbq').prop('checked', false);
							}		      			   		
						}							
						
						var temp = 0;
						$.each( obj.material_list, function( key, value ) {	
							if(temp==0){
								$("#materials"+m_id).append("<option value='all'>All Materials</option>");
							}
							$("#materials"+m_id).append("<option value="+key+">"+value+"</option>");																
							temp = temp + 1;
						});
					}
					
					
					/* modified */
					
					
					
             }				
         }
     });
});
	
$('#search_subject_from, #search_subject_to').on('change', function() { 		// modified for copy content	
	var m_id = "_from";	 	
	var course_id;	
	var class_id;
	if(this.id=="search_subject_to"){ 			
		m_id = "_to"; 			 		
		course_id = $('#search_course'+m_id).val();	
		class_id = $('#search_class'+m_id).val();
	}else{
		$('#questions').addClass('element-hide');
		course_id = $('#search_course'+m_id).val();
		class_id = $('#search_class'+m_id).val();
	}
 	var url = base_url + "admin/copy_content/request2";
  	$.ajax({
         type: "POST",
         url: url,
         data: "course_id="+course_id+"&class_id="+class_id+"&subject_id="+this.value,
         success: function (result) {
             if(result != ''){
             	var obj = jQuery.parseJSON($.trim(result)); 
             	$("#search_chapter"+m_id).html("");
             	$("#search_level"+m_id).html("");
             	$("#search_set"+m_id).html("");
             	$("#materials"+m_id).html("");
             	$("#search_chapter"+m_id).append("<option value=''>Select Chapter</option>");  
             	$("#search_level"+m_id).append("<option value=''>Select Level</option>");
             	$("#search_set"+m_id).append("<option value=''>Select Set</option>");
             	$("#materials"+m_id).append("<option value=''>Select Material</option>");
             	var a = 0;
					$.each( obj.chapter_list, function( key, value ) {	
						if(m_id=="_from" && a==0){
             			$("#search_chapter"+m_id).append("<option value='all'>All chapters</option>");                			
             		}
						//$("#search_chapter"+m_id).append("<option value="+key+">"+value+"</option>");
						$("#search_chapter"+m_id).append("<option value="+key+">"+value+"</option>");			
						a = a + 1;							
					});
					
					/* modified */			
				
					var d = 0;
					$.each( obj.level_list, function( key, value ) {
						if(m_id=="_from" && d==0){
							$("#search_level"+m_id).append("<option value='all'>All levels</option>");                			
						}	
						$("#search_level"+m_id).append("<option value="+value+">"+key+"</option>");	
						d = d + 1;									
					});

					var e = 0;
					$.each( obj.set_list, function( key, value ) {	
						if(m_id=="_from" && e==0){
							$("#search_set"+m_id).append("<option value='all'>All sets</option>");                			
						}						
						$("#search_set"+m_id).append("<option value="+key+">"+value+"</option>");
						e = e + 1;									
					});
					if(m_id=="_from"){
						if(obj.result=="failure"){		   			
		   				$('#questions').addClass('element-hide');
						}else{
							$('#questions').removeClass('element-hide');		
							if(obj.objective_question_count!="0"){
								$('#objective_question').removeClass('element-hide');
								$('#objective_question_label').removeClass('element-hide');	
								$('#obq').prop('checked', true);	   				
							}else{
								$('#objective_question').addClass('element-hide');
								$('#objective_question_label').addClass('element-hide');
								$('#obq').prop('checked', false);
							}
							if(obj.subjective_question_count!="0"){
								$('#subjective_question').removeClass('element-hide');
								$('#subjective_question_label').removeClass('element-hide'); 	
								$('#sbq').prop('checked', true);			
							}else{
								$('#subjective_question').addClass('element-hide');
								$('#subjective_question_label').addClass('element-hide');
								$('#sbq').prop('checked', false);
							}		      			   		
						}						
						var temp = 0;
						$.each( obj.material_list, function( key, value ) {	
							if(temp==0){
								$("#materials"+m_id).append("<option value='all'>All Materials</option>");
							}
							$("#materials"+m_id).append("<option value="+key+">"+value+"</option>");																
							temp = temp + 1;
						});
					}	
					
					
					/* modified */
             }				
         }
     });
});

$('#search_chapter_from, #search_chapter_to').on('change', function() { 			// modified for copy content	
	var m_id = "_from";	 	
	var course_id;	
	var class_id;
	var subject_id;
	if(this.id=="search_chapter_to"){ 			
		m_id = "_to"; 			 		
		course_id = $('#search_course'+m_id).val();	
		class_id = $('#search_class'+m_id).val();
		subject_id = $('#search_subject'+m_id).val();
	}else{
		$('#questions').addClass('element-hide');
		course_id = $('#search_course'+m_id).val();
		class_id = $('#search_class'+m_id).val();
		subject_id = $('#search_subject'+m_id).val()
	}
 	var url = base_url + "admin/copy_content/request3";   	
  	$.ajax({
         type: "POST",
         url: url,
         data: "course_id="+course_id+"&class_id="+class_id+"&subject_id="+subject_id+"&chapter_id="+this.value,
         success: function (result) {
	      	if(result != ''){
	      		var obj = jQuery.parseJSON($.trim(result)); 		          	
	          	$("#search_level"+m_id).html("");
	          	$("#search_set"+m_id).html("");
	          	$("#search_level"+m_id).append("<option value=''>Select Level</option>");
	          	$("#search_set"+m_id).append("<option value=''>Select Set</option>");
	          	var a = 0;
					$.each( obj.level_list, function( key, value ) {
						if(m_id=="_from" && a==0){
             			$("#search_level"+m_id).append("<option value='all'>All levels</option>");                			
             		}	
						$("#search_level"+m_id).append("<option value="+value+">"+key+"</option>");	
						a = a + 1;									
					});
					
					/* modified */						
					

					var e = 0;
					$.each( obj.set_list, function( key, value ) {	
						if(m_id=="_from" && e==0){
							$("#search_set"+m_id).append("<option value='all'>All sets</option>");                			
						}						
						$("#search_set"+m_id).append("<option value="+key+">"+value+"</option>");
						e = e + 1;									
					});
					if(m_id=="_from"){
						if(obj.result=="failure"){		   			
							$('#questions').addClass('element-hide');
						}else{
							$('#questions').removeClass('element-hide');		
							if(obj.objective_question_count!="0"){
								$('#objective_question').removeClass('element-hide');
								$('#objective_question_label').removeClass('element-hide');		
								$('#obq').prop('checked', true);	   				
							}else{
								$('#objective_question').addClass('element-hide');
								$('#objective_question_label').addClass('element-hide');
								$('#obq').prop('checked', false);	
							}
							if(obj.subjective_question_count!="0"){
								$('#subjective_question').removeClass('element-hide');
								$('#subjective_question_label').removeClass('element-hide'); 	
								$('#sbq').prop('checked', true);			
							}else{
								$('#subjective_question').addClass('element-hide');
								$('#subjective_question_label').addClass('element-hide');
								$('#sbq').prop('checked', false);
							}		      			   		
						}
					}				
					
					/* modified */
					
	          }				
	      }
     });
});
	
$('#search_level_from, #search_level_to').on('change', function() { 		// modified for copy content	
	var m_id = "_from";	 	
	var course_id;	
	var class_id;
	var subject_id;
	var chapter_id;
	if(this.id=="search_level_to"){ 			
		m_id = "_to"; 			 		
		course_id = $('#search_course'+m_id).val();	
		class_id = $('#search_class'+m_id).val();
		subject_id = $('#search_subject'+m_id).val();
		chapter_id = $('#search_chapter'+m_id).val();
	}else{
		$('#questions').addClass('element-hide');
		course_id = $('#search_course'+m_id).val();
		class_id = $('#search_class'+m_id).val();
		subject_id = $('#search_subject'+m_id).val();
		chapter_id = $('#search_chapter'+m_id).val();
	}
 	var url = base_url + "admin/copy_content/request4";       	
  	$.ajax({
         type: "POST",
         url: url,
         data: "course_id="+course_id+"&class_id="+class_id+"&subject_id="+subject_id+"&chapter_id="+chapter_id+"&level_id="+this.value,
         success: function (result) {
	      	if(result != ''){
	      		var obj = jQuery.parseJSON($.trim(result)); 		          	
	          	$("#search_set"+m_id).html("");
	          	$("#search_set"+m_id).append("<option value=''>Select Set</option>");
	          	var a = 0;
					$.each( obj.set_list, function( key, value ) {	
						if(m_id=="_from" && a==0){
             			$("#search_set"+m_id).append("<option value='all'>All sets</option>");                			
             		}
						//$("#search_set"+m_id).append("<option value="+value+">"+key+"</option>");	
						$("#search_set"+m_id).append("<option value="+key+">"+value+"</option>");
						a = a + 1;									
					});
					
					if(m_id=="_from"){
						if(obj.result=="failure"){		   			
							$('#questions').addClass('element-hide');
						}else{
							$('#questions').removeClass('element-hide');		
							if(obj.objective_question_count!="0"){
								$('#objective_question').removeClass('element-hide');
								$('#objective_question_label').removeClass('element-hide');		
								$('#obq').prop('checked', true);   				
							}else{
								$('#objective_question').addClass('element-hide');
								$('#objective_question_label').addClass('element-hide');
								$('#obq').prop('checked', false);
							}
							if(obj.subjective_question_count!="0"){
								$('#subjective_question').removeClass('element-hide');
								$('#subjective_question_label').removeClass('element-hide'); 
								$('#sbq').prop('checked', true);				
							}else{
								$('#subjective_question').addClass('element-hide');
								$('#subjective_question_label').addClass('element-hide');
								$('#sbq').prop('checked', false);
							}		      			   		
						}
					}					
	          }				
	      }
     });
});
	
$('#search_set_from').on('change', function() { 		// modified for copy content		
	$('#questions').addClass('element-hide');	
	var course_id = $('#search_course_from').val();
	var class_id = $('#search_class_from').val();
	var subject_id = $('#search_subject_from').val();
	var chapter_id = $('#search_chapter_from').val(); 
	var level_id = $('#search_level_from').val(); 		
 	var url = base_url + "admin/copy_content/request5";   
 	if(this.value==""){
 		$('#questions').addClass('element-hide');
 	}else{
	  	$.ajax({
	         type: "POST",
	         url: url,
	         data: "course_id="+course_id+"&class_id="+class_id+"&subject_id="+subject_id+"&chapter_id="+chapter_id+"&level_id="+level_id+"&set_id="+this.value,
	         success: function (result) {
			   	if(result != ''){		      		
			   		var obj = jQuery.parseJSON($.trim(result)); 		          			      		
			   		if(obj.result=="failure"){
			   			//console.log(obj.result);
			   			$('#questions').addClass('element-hide');
			   		}else{
			   			//console.log('success');
			   			$('#questions').removeClass('element-hide');		
			   			if(obj.objective_question_count!="0"){
			   				$('#objective_question').removeClass('element-hide');
			   				$('#objective_question_label').removeClass('element-hide');
			   				$('#obq').prop('checked', true);
			   				//console.log(obj.objective_question_count);
			   			}else{
			   				$('#objective_question').addClass('element-hide');
			   				$('#objective_question_label').addClass('element-hide');
			   				$('#obq').prop('checked', false);
			   				//console.log(obj.objective_question_count);
			   			}
			   			if(obj.subjective_question_count!="0"){
			   				$('#subjective_question').removeClass('element-hide');
			   				$('#subjective_question_label').removeClass('element-hide');
			   				$('#sbq').prop('checked', true);
			   				//console.log(obj.subjective_question_count);		      				
			   			}else{
			   				$('#subjective_question').addClass('element-hide');
			   				$('#subjective_question_label').addClass('element-hide');
			   				$('#sbq').prop('checked', false);
			   				//console.log(obj.subjective_question_count);
			   			}		      			   		
			   		}		          	
			       }				
			   }
	     });
		}
});

$('#copy_content_form').submit(function(e){
	if($("#search_course_from").val()=="" || $("#search_course_to").val()==""){
		alert("Please select course on both side");
		return false;
	}	
	if($("#search_course_from").val()==$("#search_course_to").val()){
		alert("Please select different course on both side");
		return false;
	}
	if($("input[name='status']:checked").val()==1){
		if(window.confirm('This action will delete your existing records. Are you sure want to continue?')){
			return true;
		}else{
			return false;
		}
	}else{
		if(window.confirm('This action will create a duplicate copy. Are you sure want to continue?')){
			return true;
		}else{
			return false;
		}	
	}
});
/* modified */ 
$('#levels_form select').on('change', function(){			
	var hidden1 = $("#hidden1").val();
	var hidden2 = $("#hidden2").val();
	var hidden3 = $("#hidden3").val();
	var hidden4 = $("#hidden4").val();
	var hidden5 = $("#hidden5").val();		
	if(this.id=="chapter_list"){		
		if($('#course_list').val() !="" && $('#class_list').val() !="" && $('#subject_list').val() !="" && $('#chapter_list').val() !=""){			
			var url = base_url + "admin/levels/get_Count";			
			if($('#course_list').val()==hidden1 && $('#class_list').val()==hidden2 && $('#subject_list').val()==hidden3 && $('#chapter_list').val()==hidden4){
				$('.check_order').val(hidden5);
			}else{				
				$.ajax({
					type: 'POST',
					url: url,
					data: "course_id="+$('#course_list').val()+"&class_id="+$('#class_list').val()+"&subject_id="+$('#subject_list').val()+"&chapter_id="+$('#chapter_list').val(),
					success: function(result){												
						var v = parseInt(result);
						var length = $('.check_order').length;						
						$('.check_order').each(function(){
							this.value = v;
							v += 1;
						});						
					}
				});	
			}									
		}					
	}else{
		$('.check_order').val('');
	}	
});	

//$('.dataTables_filter').addClass('pull-left');
$('#sets_form select').on('change', function(){			
	var hidden1 = $("#hidden1").val();
	var hidden2 = $("#hidden2").val();
	var hidden3 = $("#hidden3").val();
	var hidden4 = $("#hidden4").val();
	var hidden5 = $("#hidden5").val();
	var hidden6 = $("#hidden6").val();		
	if(this.id=="level_list"){		
		if($('#course_list').val() !="" && $('#class_list').val() !="" && $('#subject_list').val() !="" && $('#chapter_list').val() !="" && $('#level_list').val() !=""){			
			var url = base_url + "admin/sets/get_Count";			
			if($('#course_list').val()==hidden1 && $('#class_list').val()==hidden2 && $('#subject_list').val()==hidden3 && $('#chapter_list').val()==hidden4 && $('#level_list').val()==hidden5){
				$('.check_order').val(hidden6);
			}else{				
				$.ajax({
					type: 'POST',
					url: url,
					data: "course_id="+$('#course_list').val()+"&class_id="+$('#class_list').val()+"&subject_id="+$('#subject_list').val()+"&chapter_id="+$('#chapter_list').val()+"&level_id="+$('#level_list').val(),
					success: function(result){												
						var v = parseInt(result);
						var length = $('.check_order').length;						
						$('.check_order').each(function(){
							this.value = v;
							v += 1;
						});						
					}
				});	
			}									
		}					
	}else{
		$('.check_order').val('');
	}	
}); 

//customization start for tag based questions search 
 $('#questions_search_table').DataTable();

 $('#search_tags').on('change', function() { 	
    	if($('#search_course').val()=="" || $('#search_class').val()=="" || $('#search_subject').val()=="" || $('#search_chapter').val()==""){
			alert('Please choose above options');
			return false;
		}
		var  getVariable = "course_id=" + $('#search_course').val() +"&class_id=" + $('#search_class').val()+"&subject_id="+$('#search_subject').val()+"&chapter_id="+$('#search_chapter').val()+"&tags=" + $('#search_tags').val();
		questionsSearchData(getVariable, "get_questions");
		setTimeout(function(){ 
			var oTable = $('#questions_search_table').dataTable();
			var allPages = oTable.fnGetNodes();
			var getCheckedLen = $('input[type="checkbox"]:checked', allPages).length;
			var getCheckBoxLength = $('input[type="checkbox"]', allPages).length;
			if(getCheckedLen == getCheckBoxLength){
				$('#questions-select-all').prop('checked', true);
			}else{
				$('#questions-select-all').prop('checked', false);
			}
		}, 100);
		return false;
	});
  
	if($("#uri_segment").val() == "questions" && $("#uri_segment_edit_question").val() == "edit"){
	    var getVariable = "course_id=" + $('#search_course').val() +"&class_id=" + $('#search_class').val()+"&subject_id="+$('#search_subject').val()+"&chapter_id="+$('#search_chapter').val()+"&tags=" + $('#search_tags').val()+"&uri_segment_edit_question=" + $('#uri_segment_edit_question').val();;
		setTimeout(function(){ 
			questionsSearchData(getVariable, 'get_questions'); 
		}, 100);

		setTimeout(function(){ 
			var oTable = $('#questions_search_table').dataTable();
			var allPages = oTable.fnGetNodes();
			var getCheckedLen = $('input[type="checkbox"]:checked', allPages).length;
			var getCheckBoxLength = $('input[type="checkbox"]', allPages).length;
			if(getCheckedLen == getCheckBoxLength){
				$('#questions-select-all').prop('checked', true);
			}else{
				$('#questions-select-all').prop('checked', false);
			}
		}, 200);
	}

    if($("#uri_segment").val() == "questions"){
		$(document).on('submit','#questions_form, #map_questions_form',function(){
			var form = this;
			var oTable = $('#questions_search_table').dataTable();
			var rowcollection =  oTable.$(".childCheckbox:checked", {"page": "all"});
			var oSettings = oTable.fnSettings();
			if(rowcollection.length != 0 ) {
				oSettings._iDisplayLength = -1;
				oTable.fnDraw();
				$.each(rowcollection, function(index, rowId){
					var checkboxVal = $(rowId).val();
					$(form).append(
						$('<input>')
						.attr('type', 'hidden')
						.attr('name', "selected_qn[]")
						.val(checkboxVal)
					);
				});
				return true;
			}else{
				alert('Please choose the questions');
				return false;
			}
		});
  }

   //***************************************** End Question

	$('#search_tags_standard').on('change', function() { 	
		var getVariable = "course_id=" + $('#course_list').val() +"&test_id=" + $('#test_name').val()+"&tags=" + $('#search_tags_standard').val();
		if($('#course_list').val()=="" || $('#test_name').val()==""){
			alert('Please choose Course and Test name');
			return false;
		}
		questionsSearchData(getVariable, "get_questions_std");
		setTimeout(function(){ 
			var oTable = $('#questions_search_table').dataTable();
			var allPages = oTable.fnGetNodes();
			var getCheckedLen = $('input[type="checkbox"]:checked', allPages).length;
			var getCheckBoxLength = $('input[type="checkbox"]', allPages).length;
			if(getCheckedLen == getCheckBoxLength){
				$('#questions-select-all').prop('checked', true);
			}else{
				$('#questions-select-all').prop('checked', false);
			}
		}, 100);
	});


	if($("#uri_segment").val() == "surprise_questions" && $("#uri_segment_edit_standard").val() == "edit"){
		// var getVariable = "course_id=" + $('#course_list').val() +"&test_id=" + $('#test_name').val()+"&tags=" + $('#search_tags_standard').val()+"&uri_segment_edit_standard=" + $('#uri_segment_edit_standard').val();
		// setTimeout(function(){ 
		// 	questionsSearchData(getVariable, 'get_questions_std'); 
		// }, 100);

		// setTimeout(function(){ 
		// 	var oTable = $('#questions_search_table').dataTable();
		// 	var allPages = oTable.fnGetNodes();
		// 	var getCheckedLen = $('input[type="checkbox"]:checked', allPages).length;
		// 	var getCheckBoxLength = $('input[type="checkbox"]', allPages).length;
		// 	if(getCheckedLen == getCheckBoxLength){
		// 		$('#questions-select-all').prop('checked', true);
		// 	}else{
		// 		$('#questions-select-all').prop('checked', false);
		// 	}
		// }, 200);
	}

	if($("#uri_segment").val() == "surprise_questions"){
		$(document).on('submit','#questions_form, #map_surprise_questions_form',function(){
			var form = this;
			var getCheckboxLen = $(".questionSubject").length;
		    for(var i=0; i<getCheckboxLen;i++){
				if($(".questionSubject").eq(i).val().length != 0 ){
					$(".std-subject").eq(i).attr("disabled", false);
				}
			}
			return true;
		});
  }
  
    
	$('#questions-select-all').on('click', function(){
		var oTable = $('#questions_search_table').dataTable();
		var allPages = oTable.fnGetNodes();
		if ($(this).is(":checked") == true) {
			$('input[type="checkbox"]', allPages).prop('checked', true);
		}else{
			$('input[type="checkbox"]', allPages).prop('checked', false);
		}
		getStandedQuestionSelectedValue()
	 });
	 // Handle click on checkbox to set state of "Select all" control
	 $(document).on('click', '.childCheckbox', function(){
	    var oTable = $('#questions_search_table').dataTable();
		var allPages = oTable.fnGetNodes();
		var getCheckedLen = $('input[type="checkbox"]:checked', allPages).length;
		var getCheckBoxLength = $('input[type="checkbox"]', allPages).length;
		if(getCheckedLen == getCheckBoxLength){
			$('#questions-select-all').prop('checked', true);
		}else{
			$('#questions-select-all').prop('checked', false);
		}
		getStandedQuestionSelectedValue()
	 });

	 $(".add-more").click(function(){ 
		var html = $(".copy").html();
		$(".after-add-more").after(html);
	});


	$(document).on("click",".remove",function(){ 
		$(this).parents(".control-group").remove();
	});

	$(document).on("click",".std-edit",function(){ 
		var index = $(".std-edit").index(this);
		$('#questions_search_table').DataTable({data: [], destroy: true});
		$(".std-subject").attr("disabled", true);
		$("#currentIndex").val(index);
		$("#currentIndex").val(index);
		$(".std-subject").eq(index).attr("disabled", false);
		if($("#uri_segment_edit_standard").val() == "edit"){
			var getVariable = "course_id=" + $('#course_list').val() + 
							  "&test_id=" + $('#test_name').val()+
							  "&tags=" + $('#search_tags_standard').val()+
							  "&uri_segment_edit_standard=" + $('#uri_segment_edit_standard').val() +
							  "&subject_id=" + $(".std-subject").eq(index).val();
							  console.log(getVariable);
			questionsSearchData(getVariable, 'get_questions_std', index); 
				var oTable = $('#questions_search_table').dataTable();
				var allPages = oTable.fnGetNodes();
				var getCheckedLen = $('input[type="checkbox"]:checked', allPages).length;
				var getCheckBoxLength = $('input[type="checkbox"]', allPages).length;
				if(getCheckedLen == getCheckBoxLength){
					$('#questions-select-all').prop('checked', true);
				}else{
					$('#questions-select-all').prop('checked', false);
				}
		}
	});

	function questionsSearchData(dataVar,action, index = null){
		var url = base_url + "admin/certificates/" + action;
		if($('#course_list').val()=="" || $('#test_name').val()==""){
			alert('Please choose Course and Test name');
			return false;
		}
    	$.ajax({
            type: "POST",
            url: url,
            data: dataVar,
            success: function (result) {
				var obj = jQuery.parseJSON($.trim(result)); 
                if(obj.length != 0){
					if($("#uri_segment").val() == "surprise_questions" && $("#uri_segment_edit_standard").val() == "edit")	{
						var curIndex = $("#currentIndex").val();
						$(".show_qn_count").eq(curIndex).html("Question:" + obj.length);
					}
					var rows_selected = [];
					$('#questions_search_table').DataTable({
						data: obj,
						//'ajax': 'https://gyrocode.github.io/files/jquery-datatables/arrays_id.json',
						"paging":   false,
						"ordering": false,
						//"info":     false,
						destroy: true,
						"scrollY": "700px",
						'columnDefs': [{
							'targets': 0,
							'searchable': false,
							'orderable': false,
							'className': 'dt-body-center',
							'render': function (data, type, full, meta){
								return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '" class="childCheckbox">';
							}
						 }],
						"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
						'select': {                
						   'style': 'multi'
						},
						'order': [[1, 'asc']],
						'rowCallback': function(row, data, dataIndex){
     					   var rowId = data[0];
						    if(data[6] == 1){
								$('td:eq(0)', row).find('input[type="checkbox"]').prop('checked', true);

							}
							//$('td:eq(0)', row).html( '<input type="checkbox" name="id[]" value="' + rowId + '" class="childCheckboxText">' );
							$('td:eq(2)', row).html( '<img width="300px"  src="'+ data[2] +'">' );
							$('td:eq(4)', row).html( '<img width="200px"  src="'+ data[4] +'">' );
						 }
					 });
                }			
            }
		});	
	}


	function getStandedQuestionSelectedValue(){
		var oTable = $('#questions_search_table').dataTable();
		var rowcollection =  oTable.$(".childCheckbox:checked", {"page": "all"});
		var currentIndex = $("#currentIndex").val();  
		var questionID = [];
		$(".show_qn_count").eq(currentIndex).html("Question:" + rowcollection.length);
		if(rowcollection.length != 0 ) {
			$.each(rowcollection, function(index, rowId){
				var checkboxVal = $(rowId).val();
			    questionID.push(checkboxVal);
			});
			var questionIds = questionID.join(",");
			$(".questionSubject").eq(currentIndex).val(questionIds);
		}else{
			$(".questionSubject").eq(currentIndex).val("");
		}
	}