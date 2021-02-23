$(document).ready(function(){	
//form action
$("#start_test").click(function(){
	var course=$("#course_arr").val();
	var classes=$("#class_arr").val();
	if(course==""||classes==""){
		$('.success-error-msg').html("<p>Please select course and class details.</p><span class='close-btn'></span>");
		$('.success-error-msg').addClass('open');
		$('.success-error-msg').addClass('erroronly');
		return false;
	//alert("Please Select Course and Class details");
	//return false;	
	} else{	
		$.ajax({
		url:base_url+"subjective/popup/",
		DataType:"JSON", 
		data:{course_id:course,class_id:classes},
		success:function(result){
			var result_js=$.parseJSON(result);
			var subjective = result_js.type.is_subjective;
			var category = result_js.category_list;
			if(subjective == 1 && category != "")
			{
				$("#start_test_a").attr("href",base_url+"subjective/popup_content/"+course+"/"+classes);
				$("#start_test_a").trigger('click');
			}
			else
			{
				location.href = base_url+"tests/chapters/"+course+"/"+classes;
			}
		}
	});
	}
});
//sub category dropdown
$("#subjective").livequery("change", function() {		
	var course_id = $('#course_arr').val();
	var class_id = $('#class_arr').val();
	var category_id = $(this).val();
	if(category_id != ""){
		location.href = base_url+"subjective/chapters/"+course_id+"/"+class_id+"/"+category_id;
	}
});

$(".down-tabs-click").livequery('click',function(){
 var upload_url=$(this).attr("uploadurl");
 var course=$(this).attr("course");
$("#target_course").val(course);
 
$(".popup-uploadnow a").attr("href",upload_url);
});
$("#reset-form").livequery('click',	function(){
 var course=$(this).attr("course");
	//$(".ajaxupload-download").html("");	
	//$('.download-content-main').fadeOut(500);
	//$(".trigger-me"+course).trigger("click");
	//$('.ajaxupload-download').fadeIn(500);	
});
$("#course_arr").change(function(){
 	var vals=$(this).val();
	//if(vals==""){
	//return false;
	//}
	$.ajax({
		url:base_url+"dashboard/ax_get_class/",
		type:"post", 
		data:{course_id:vals},
		success:function(data){
		var result_js=$.parseJSON(data);
		$("#class_arr").html("");
		$.each(result_js,function(key, value){
	 	
		 $("#class_arr").append("<option value='"+value+"'>"+key+"</option>");
		});
		$("#class_arr").selectric("refresh");
	}
	});
});

$("#class").livequery("change", function() {		
	var course_id = $("#course li a.active").parent('li').attr("id");		
	var class_id = $("#class").val();
	var url = base_url+"dashboard/overall_status/"+course_id+"/"+class_id;			
	$.ajax({
		type:"GET",
		url : url,
		//dataType: 'html',	 
		success: function(html){
			/*$('.overall-performance-content').fadeOut(500,function() {
						$('.overall-performance-content').html(html).fadeIn(500);
					});*/
						 var test=html.split("<!--[start]-->"); 
					 var remover= test[1].split("</div>");
					 var scripts_data= remover[1];
			$('.overall').fadeOut(500,function() {
				$('.overall').html(html).fadeIn(500);
			});					
			$("head").append(scripts_data);
		},
		error: function(){
		},
		complete: function(){				
		}
	});
});
// test type
$('.test-type-section ul.test-list li a').livequery('click',function(){
	var course_id = $("#course li a.active").parent('li').attr("id");	
	var class_id = $("#class").val();		
	var type = $('ul.test-list li a.active').parent('li').attr("id");
	if(type=="pt"){		
		type = 0;
	}else{		
		type = 1;
	}		
	var subject_id = $(".subject-dropdown-list .active").attr('href');
	var level_id = $("#level_completed").val();	
	var chapter_id = $("#chapter").val();		
	var url = base_url+"dashboard/performance_graph/"+course_id+"/"+class_id+"/"+subject_id+"/0/0/"+type;
	$.ajax({
		type:"GET",
		url : url,
		//dataType: 'html',	 
		success: function(html){
					 var test=html.split("<!--[start]-->"); 
					 var remover= test[1].split("</div>");
					 var scripts_data= remover[1];
					 
			$('.result-graph-content').fadeOut(500, function() {
			$('.result-graph-content').html(html).fadeIn(500);
			});					
			$("head").append(scripts_data);		
		},
		error: function(){
		},
		complete: function(){				
		}
	});
	return false; 
});

//subject
$(".subject-selectbox ul li a").livequery("click", function(){
	var content = $(this).text();
	if(!($(this).hasClass('active'))){
		$(".subject-selectbox ul li a").removeClass("active");
		$(this).addClass("active");
		var content = $(this).find('span').html();
		$(".subject-selectbox .subject-dropdown span").html(content);		
		var course_id = $("#course li a.active").parent('li').attr("id");	
		var class_id = $("#class").val();
		var subject_id = $(this).attr('href');
		var type = $('ul.test-list li a.active').parent('li').attr("id");
		if(type=="pt"){		
		type = 0;
	}else{		
		type = 1;
	}	
		var url = base_url+"dashboard/performance_graph/"+course_id+"/"+class_id+"/"+subject_id+"/0/0/"+type;		
		$.ajax({
			type:"GET",
			url : url,
			//dataType: 'html',	 
			success: function(html){		
					var test=html.split("<!--[start]-->"); 
					 var remover= test[1].split("</div>");
					 var scripts_data= remover[1];
				$('.result-graph-content').fadeOut(500, function() {
					$('.result-graph-content').html(html).fadeIn(500);			
				});
				$(".subject-dropdown-list").slideToggle();
				$("head").append(scripts_data);	
			},
			error: function(){
			},
			complete: function(){				
			}
		});
	}	
	return false;
});

//level
$("#level_completed").livequery("change", function() {			
	var course_id = $("#course li a.active").parent('li').attr("id");		
	var class_id = $("#class").val();	
	var type = $('ul.test-list li a.active').parent('li').attr("id");
	if(type=="pt"){		
		type = 0;
	}else{		
		type = 1;
	}		
	var subject_id = $(".subject-dropdown-list .active").attr('href');
	var level_id = $("#level_completed").val();		
	var url = base_url+"dashboard/performance_graph/"+course_id+"/"+class_id+"/"+subject_id+"/0/"+level_id+"/"+type;	
	
	$.ajax({
		type:"GET",
		url : url, 		
		//type : 'html', 	
		success: function(html){
			var test=html.split("<!--[start]-->"); 
					 var remover= test[1].split("</div>");
					 var scripts_data= remover[1];
					 
			$('.result-graph-content').fadeOut(500, function() {
				$('.result-graph-content').html(html).fadeIn(500);								
			});
			$("head").append(scripts_data);	
		},
		error: function(){
		},
		complete: function(){				
		}
	});
}); 
//chapter
$("#chapter").livequery("change", function() {			
	var course_id = $("#course li a.active").parent('li').attr("id");		
	var class_id = $("#class").val();	
	var type = $('ul.test-list li a.active').parent('li').attr("id");
	if(type=="pt"){		
		type = 0;
	}else{		
		type = 1;
	}		
	var subject_id = $(".subject-dropdown-list .active").attr('href');
	var chapter_id = $("#chapter").val();		
	var url = base_url+"dashboard/performance_graph/"+course_id+"/"+class_id+"/"+subject_id+"/"+chapter_id+"/0/"+type;	
	
	$.ajax({
		type:"GET",
		url : url, 		
		//type : 'html', 	
		success: function(html){
			var test=html.split("<!--[start]-->"); 
					 var remover= test[1].split("</div>");
					 var scripts_data= remover[1];
					 
			$('.result-graph-content').fadeOut(500, function() {
				$('.result-graph-content').html(html).fadeIn(500);								
			});
			$("head").append(scripts_data);	
		},
		error: function(){
		},
		complete: function(){				
		}
	});
}); 

$("ul.normal a").livequery("click", function(){	
	var url = $(this).attr('href');		
	if(typeof url == "undefined"){
		return false;
	}	
	$.ajax({
      type: "GET",
      url: url,
      //dataType: 'html',
      success: function(html) {
        try {
          json = $.parseJSON(html);
          location.href = base_url + "home/index/login";
        } catch (e) {
          // not json
          $('.ajaxtab-content').fadeOut(500, function() {
            $('.ajaxtab-content').html(html).fadeIn(500);
          });
        }

      },
      error: function() {},
      complete: function() {
        $('#pre-loader1').hide();
      }
    });
    return false;
});

$(".pagination li a").livequery(function(){
	
	var titles=$(this).text();
	  $(this).attr("title",titles);
	});
	
	
});



