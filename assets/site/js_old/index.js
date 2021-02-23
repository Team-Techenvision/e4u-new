	$('#forgot_form').livequery('submit',function(){
		valid_forgot();
		return false;
	});
	function valid_forgot(){
	 var email = $("#email").val();
	 $(".login-error").remove();
	 $(".green").remove();
		if(email=='')
		{
			$(".email").append("<span class='login-error'>Please enter the Email ID.</span>");
		}
		else
		{
		var url = base_url + "home/action_forgot_password";
		 
		$.ajax({
			type: "POST",
			url: url + "?email=" +  email,
			cache: false,
			DataType:"JSON",
			success: function(result){
				if(result != ''){
                	 var obj=$.parseJSON(result);
                	 var valid_email = obj.valid_email;
                	 var email_sent = obj.email_sent;
                	 if(valid_email == 0){
                	 	$(".email").append("<span class='login-error'>Email ID not registered with us. Please enter valid Email ID.</span>");
                	 }
                	 else{
            	  		if(email_sent == 1){
									$(".login-btn").attr("href",base_url+"home/success_forgot/");
									$(".login-btn").trigger("click");
									$(".user-login").attr("href",base_url+"home/login");
									$(".register").attr("href",base_url+"home/register");
		            	 }
		            	 else{
		            	 	$(".email").before("<span class='login-error' style='position: relative;top:-19px;left: 82px;'>Email not successfully sent.</span>");
		            	 }
                	 }
                }
			}
		});
		}
		return false;
	}
	function valid_reset(){
		var new_pass = $("#new_password").val();
		var confirm_pass = $("#confirm_password").val();
	 	$(".login-error").remove();
	 	$(".green").remove();
	 	if(new_pass=='' && confirm_pass==''){
	 		$(".new_pass").append("<span class='login-error'>Please enter the New Password.</span>");
			$(".confirm_pass").append("<span class='login-error'>Please enter the Confirm Password.</span>");
	 	}
		else if(new_pass=='')
		{
			$(".new_pass").append("<span class='login-error'>Please enter the New Password.</span>");
			
		}
		else if(confirm_pass=='')
			{
				$(".confirm_pass").append("<span class='login-error'>Please enter the Confirm Password.</span>");
			}
		else if(new_pass != confirm_pass){
	 		$(".confirm_pass").append("<span class='login-error'>New Password does not match with Confirm Password.</span>");
	 	}
	 	else if(new_pass.length < 6){
	 		$(".new_pass").append("<span class='login-error'>Password should be greater than or equal to 6 characters.</span>");
	 	}
	 	
		else
		{
		var url = base_url + "home/action_reset_password";
		$.ajax({
			type: "POST",
			url: url + "?new_pass="+new_pass+"&confirm_pass="+confirm_pass+"&id="+ ref_id,
			cache: false,
			DataType:"JSON",
			success: function(result){
				if(result != ''){
                	 var obj=$.parseJSON(result);
                	 var valid_user = obj.valid_user;
                	 var reset_pass = obj.reset;
                	 if(valid_user == 0){
                	 	$(".new_pass").before("<span class='login-error'>Unknown user.</span>");
                	 }
                	 else{
            	  		if(reset_pass == 1){
            	  			if(!$(".green").is(":visible")){
		            	 		$(".new_pass").before("<span class='green'>Password changed successfully.</span>");					}
							$(".green").css("color", "green");
								setTimeout(function(){
									$(".login-btn").attr("href",base_url+"home/login");
									$(".login-btn").trigger("click");
								},2000);
		            	 }
		            	 else{
		            	 	$(".new_pass").before("<span class='login-error'>Password reset not successfull.</span>");
		            	 }
                	 }
                }
			}
		});
		}
		return false;
	}
	 
	$(document).ready(function() {
	
		$(document).bind("contextmenu",function(e){		// disable right click
         	return false;
   		});
   		document.onkeypress = function (event) {		// disable f12
	   	 	event = (event || window.event);
	    	if (event.keyCode == 123) {
	       	  return false;
	        }
	  	}
		document.onmousedown = function (event) {
			event = (event || window.event);
			if (event.keyCode == 123) {
			    return false;
			}
		}
		document.onkeydown = function (event) {			
			event = (event || window.event);
			if (event.keyCode == 123) {
			    return false;
			}
			if(event.ctrlKey){							// disable ctrl+s
				if (event.keyCode == 83) {
	       	  		return false;
	        	}
	        	if (event.keyCode == 80) {				// disable ctrl+p
	       	  		return false;
	        	}
	        	if (event.keyCode == 85) {				// disable ctrl+u
	       	  		return false;
	        	}
	        }
		}
		
		$(document).on('dragstart', function () {		//disable mouse drag and drop
            return false;
        });
		
		$('.surprise_test_in').on('click',function(){
			var url = $("#ad_url").val();
			window.open(url,"_blank");
		});
		$(".nav-menu li a").on("click", function() {
		    $(".nav-menu li a.active").removeClass("active");
		    $(this).addClass("active");
		});
		 
		$('.edit-link').click(function() {
            $('.after-edit').show();
   		});
   		$('.alert_visit').click(function() {
   			$(".alert_count").remove();
   		});
   		 
	 	$(".plan-buttons").click(function(){
			 var vals=$(this).val();
			 $(".course-list-page").removeClass("selected");
			 $(".dyn-course"+vals).addClass("selected");
			 $(".label_course").text("Choose Course");
			 $(".label").text("Purchased");
			 $(".choose_label"+vals).text("Selected Course");
			 if(!$(".showless").hasClass('show'+vals)){
			 	$(".showless").trigger("click");
			 }
	 	});
		$('#level_list').on('change', function() {
		
			var test_random_id = $('#test_random_id').val();
			var course_id = $('#course_id').val();
			var class_id = $('#class_id').val();
			var chap_id = $('#chapter_list').val();
			var sub_id = $('#subject_list').val();
			var level_id = $(this).val();
			if(level_id==""){
			$("#set_list").html(""); 
        	$("#set_list").append("<option value=''>Select Set</option>");
        	$("#set_list").selectric("refresh");
        	return false;
			}
			var url = base_url + "tests/request";
		 	$.ajax({
		        type: "POST",
		        url: url,
		        data: "course_id="+course_id+"&class_id="+class_id+"&subject_id="+sub_id+"&chapter_id="+chap_id+"&level_id="+level_id,
		        success: function (result) {
		            if(result != ''){
		            	var obj = jQuery.parseJSON(result);
		            	$("#set_list").html(""); 
		            	$("#set_list").append("<option value=''>Select Set</option>");
		            	$.each( obj.set_list, function( key, value ) {
	            			if(key != 'Select'){
								$("#set_list").append("<option value="+key+">"+value+"</option>");
								$("#set_list").selectric("refresh");
							}
						});
							
	            	}
	       	 	}
	   	 	});
		}); 
		$('#filter-dropdown').livequery('change', function() {
			if($(this).val() != ""){
				var option_val = $(this).val();
				var custom_url = $(".leaderboard_url").attr("custom-url");
				$(".leaderboard_url").attr("href",custom_url+option_val);
				$(".ajaxtab-menu ul li a").removeClass("active");
				setTimeout(function(){
					$('.leaderboard_url').trigger("click");
				},800);
			}
		});
		$('#set_list').on('change', function() {
			var chap_id = $('#chapter_list').val();
			var sub_id = $('#subject_list').val();
			var level_id = $('#level_list').val();
			if($(this).val() != ""){
				var set_id = $(this).val();
				location.href = base_url+"tests/start_test/"+sub_id+"/"+chap_id+"/"+level_id+"/"+set_id;
				return false;
			} 
			});
		$(".practice_options").click(function(){
			$('.ans_description').css('display','inline-block');
		});
	
		$(".options").click(function(){
			if($('#progress').val()=='progress'){
				$('.progress_li').removeClass('ans_select');
			}
			if($('#surprise').val()=='surprise'){
				$('.surprise_li').removeClass('ans_select');
			}
			var ques_id = $('#ques_id').val();
			var option_selected = $(this).val();
			var test_id = $('#test_id').val();
			if($('#surprise').val()=='surprise'){
				var url = base_url + "tests/answer_details/"+$('#surprise').val();
			}else{
				var url = base_url + "tests/answer_details/";
			}
			$.ajax({
		        type: "POST",
		        url: url,
		        data: "ques_id="+ques_id+"&test_id="+test_id+"&option_selected="+option_selected,
		        success: function (result) {
		            if(result != ''){
		            	if($('#progress').val()=='progress'){
							if($("#progress_test_submit").is(":visible")){
								$(".not_answered").remove();
							}
		            		var obj = jQuery.parseJSON(result);
		            		$('.list_'+option_selected).addClass('ans_select');
		            		$('.ans_description').css('display','none');
		            		if($(".questions span").text()==parseInt($(".answers span").text())+1){
								if(!$("#progress_test_submit").is(":visible")){
									$(".ans_next").parent('li').after('<li><input type="submit" title="Finish" id="progress_test_submit" value="Finish" name="submit"></li>');
									$(".not_answered").remove();
								}
		            			
		            		}	
		            	}else if($('#surprise').val()=='surprise'){
		            		if($("#surprise_test_submit").is(":visible")){
								$(".not_answered").remove();
							}
		            		var obj = jQuery.parseJSON(result);
		            		$('.list_'+option_selected).addClass('ans_select');
		            		$('.ans_description').css('display','none');
		            		
		            		if($(".questions span").text()==parseInt($(".answers span").text())+1){
								if(!$("#surprise_test_submit").is(":visible")){
		            			$(".ans_next").parent('li').after('<li><input type="submit" title="Finish" id="surprise_test_submit" value="Finish" name="submit"></li>');
									$(".not_answered").remove();
								}
		            		}	
		            	}else{
				        	var obj = jQuery.parseJSON(result);
				        	var correct_ans = obj.answer.correct_answer;
				        	$(".ans_description").click(function(){
				        		$(".ans_description").attr("href",base_url+"tests/answer_description/"+ques_id+"/"+option_selected);
				        	});
				        	if($(".questions span").text()==parseInt($(".answers span").text())+1){
				        		$('#test_submit').val("Finish");
		            		}	
				        	if(option_selected == correct_ans){
				        		$('.list_'+option_selected).addClass('ans_correct');
				        		$('.practice_options').attr('disabled', 'true');
				        		
				        	}else{
				        		$('.list_'+correct_ans).addClass('ans_correct');
				        		$('.list_'+option_selected).addClass('ans_wrong');
				        		$('.practice_options').attr('disabled', 'true');
				        	}
		            	}
	            	}
	       	 	}
	       	 	
	 		});
	 	});
	});
	var image_selected="";
 function submit_forms(){
 	  $(".file-upload").next("span").remove();
 	  $(".after-upload-inner").next("span").remove();
	  $(".after-edit").next("span").remove();
	  $(".custom-upload").next('.login-error').remove();
	  $(".format_error .login-error").remove();
	  var image_name=$("#upload_image_name").val();
	  $('#upload_name').val($('#upload_image_name').val());
	  	
 	 var url = base_url + "profile/update_profile/";
	 var data_arr=$(".profileform").serialize();
		$.ajax({
			type: "POST",
			url: url,
			data:data_arr,
			cache: false,
			DataType:"JSON",
			success: function(data)
			{ 
				var data=jQuery.parseJSON($.trim(data));
		        	$(".profileform input").each(function() {
						$(this).next('.form-error-msg').remove();
					});		        	
					$(".profileform textarea").each(function() {
						$(this).next('.form-error-msg').remove();
					});
					$(".selectricWrapper").each(function() {
						$(this).next('.form-error-msg').remove();
					});
		         
		        	if(data.status=="error") {
		        		$.each(data.errorfields,function(key, value){
		        			var error="<span style='color:red;' class='form-error-msg' >"+value.error+"</span>";
							if(value.field=="gender"){
								var replace_radio = error.replace('enter','choose');
								$("#gender_radio").after(replace_radio);
							}else{
								$(".profileform").find("[name='"+value.field+"']").after(error);
							}
						
		        			if(value.field == 'class' || value.field == 'medium' || value.field == 'board')
		        			{
		        				var replace_string = error.replace('enter','select');
		        			}
		        			$(".selectric-"+value.field).after(replace_string);
		        		});
		        	}else{
						console.log("rand="+image_selected);
						if(image_selected!=""){
								$("#image_name").val(image_selected);
						}
					
						if(image_name!=""){
							$("#exist_profile").val(1);
						} 
						var is_image_updated=$("#exist_profile").val();
						$(".after-edit").hide();
						$("input[type='text']").each(function(){
							var saved_val=$(this).val();
						  	$(this).attr('act-val',saved_val);
						});
						var fname = $('#fname').val();
						var lname = $('#lname').val();
						$('#user_name_bold').html(fname+" "+lname);
							if((fname+" "+lname).length>16)
						{
							var prof_name = (fname+" "+lname).substring(0,16);
						}
						else
						{
							var prof_name = fname+" "+lname;
						}
						$('#profile_user_name').html(prof_name);
						$("textarea").each(function(){
							var saved_val=$(this).val();
						  	$(this).attr('act-val',saved_val);
						});
						if($("input[name='gender']:checked",".profileform").val() != ""){
							var saved_val = $("input[name='gender']:checked",".profileform").val();
							if(saved_val == 'Male')
							{
								$('#male').prop('checked',true);
								$('#gender_radio').val(1);
								if(!$('.file-upload .custom-upload').hasClass('prof_img')){
							 
									$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image-men.png)');
									 if($('.head_profile').find('img').hasClass('no_img')){
									 $(".head_profile").find('img').attr('src',base_url+'assets/site/images/no-image-men.png');
									}
									
								}else if(is_image_updated==0){
									$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image-men.png)');
									 $(".head_profile").find('img').attr('src',base_url+'assets/site/images/no-image-men.png');
									//if user have priofile image
									
								} 
								 
							}
							else if(saved_val == 'Female')
							{
								$('#female').prop('checked',true);
								$('#gender_radio').val(2);
								if(!$('.file-upload .custom-upload').hasClass('prof_img')){
									$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image.png)');
									 if($('.head_profile img').hasClass('no_img')){
									$(".head_profile img").attr('src',base_url+'assets/site/images/no-image.png');
								}
								}else if(is_image_updated==0){
									$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image.png)');
									$(".head_profile img").attr('src',base_url+'assets/site/images/no-image.png');
								} 
								 
							}
							else
							{
								$('#male').prop('checked',false);
								$('#female').prop('checked',false);
								$('#gender_radio').val("");
								if(!$('.file-upload .custom-upload').hasClass('prof_img')&&is_image_updated==0){
									$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image-men.png)');
								}
								else if($('.head_profile').find('img').hasClass('no_img')&&is_image_updated==0){
									$(".head_profile").find('img').attr('src',base_url+'assets/site/images/no-image-men.png');
								}
							}
						}
						$("select").each(function(){
						var saved_val=$(this).val();
						  $(this).attr('act-val',saved_val);
						});
						
						$(".profile").attr("disabled","disabled") 
						$(".profile-details-wrapper .input input").attr('disabled','disabled');
						$(".profile-details-wrapper .input textarea").attr('disabled','disabled');
						$(".edit-link").show();
						$('.after-upload-inner').hide();
						$(".file-upload .custom-upload input[type='file']").attr('disabled','true');
	 					$(".file-upload .custom-upload input[type='file']").css('cursor','default');
						$(".after-edit").hide();
						if(!$(".after-edit").next("span").is(":visible")){
							$(".after-edit").after("<span  style='margin-top: 11px; display: block;color:green' >"+data.msg+"</span>");
						}
		        		$(".profile").selectric('refresh'); 
					 setTimeout(function(){
						 $(".after-edit").next("span").remove();
					 },800);
		        	}
			}
		});
 }
  
	function submit_image(t){
	 	var image = base_url + "assets/site/images/ajax-loader.gif";
	 	$(t).each(function() {
			$(".custom-upload").next('span').remove();
			$(".after-upload-inner").next("span").remove();
			$(".file-upload").next("span").remove();
			$(".format_error .login-error").remove();
		});
		 var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
		 if ($.inArray($(t).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
		 	var error="<span style='color:red;position:initial' class='login-error'>Only formats are allowed : "+fileExtension.join(', ')+".</span>";
		 	$(".file-upload").next("span").remove();
		 	$(".after-upload-inner").next("span").remove();
		 	$(".format_error").append(error);
		 }else{
			 var formdata = new FormData();
			 var file = $(t)[0].files[0];
			 formdata.append('profile_image', file);
			 
			 if($(t).val()!=""){
			  $.ajax({
						type: "POST",
						url: base_url  + "profile/imgupload",
						data: formdata,
						async: false,
					    processData: false,
					    contentType: false,
					    cache: false,
						success: function(result){
							var data=jQuery.parseJSON(result);
							if(data.status == "error"){
							var error="<span style='color:red;position:initial' class='login-error'>Minimum dimension is 178*178 px.</span>";
									if(!$(".file-upload").next("span").is(":visible")){
										$(".file-upload").after(error);
	 								}
		 						if(!$(".after-upload-inner").next("span").is(":visible")){
								$(".after-upload-inner").after(error);
								}

							}else{
							$(".after-upload-inner").next("span").remove();
							$(".file-upload").next("span").remove();
							if(!$(".after-upload-image img").is(":visible")){							 
 									$(".custom-upload").css('background-image','url('+data.img+')');
								}
								if($(".after-upload-inner").next('.login-error').is(":visible"))
								{
									var profile_img = $('#profile_image_name').val();
									$("#upload_image_name").val(profile_img);
								}
								else
								{
									$("#upload_image_name").val(data.img_name);
								}
								$(".head_profile").find('img').attr('src',data.img);
								$(".file-upload .custom-upload").addClass('prof_img');
								$(".head_profile").find('img').removeClass('no_img');
								$(".after-upload-image img").attr('src',data.img);
								image_selected=data.img;
							}
						},
			  });
			 }
		 	}
	}
	
function reset_forms(){
	image_selected="";
	$(".file-upload").next("span").remove();
	$(".format_error .login-error").remove();
	$(".after-upload-inner").next("span").remove();
	var img_name = $('#upload_name').val(); //img name only
	var saved_img = $('#image_name').val(); //img src
	console.log(saved_img);
	var profile_img = $('#profile_image_name').val();
	var is_image_updated=$("#exist_profile").val();
	$("#upload_image_name").val("");
	if(img_name == "" && $('#gender_radio').val() == 1&&is_image_updated==0)
	{
		$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image-men.png)');
		$(".head_profile").find('img').attr('src',base_url + 'assets/site/images/no-image-men.png');
	}
	else if(img_name == "" && $('#gender_radio').val() == 2&&is_image_updated==0)
	{
		$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image.png)');
		$(".head_profile").find('img').attr('src',base_url + 'assets/site/images/no-image.png');
	}
	else if(img_name == "" && $('#gender_radio').val() == 0)
	{
		$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image-men.png)');
		$(".head_profile").find('img').attr('src',base_url + 'assets/site/images/no-image-men.png');
	}
	else if(is_image_updated==1)
	{
		 
		$(".after-upload-image img").attr('src',saved_img);
		$("#upload_image_name").val(profile_img);
		if(saved_img!=""){
			$('.file-upload .custom-upload').css('background-image','url(' + saved_img + ')');
			$(".head_profile").find('img').attr('src',saved_img);
		}
		 
	}
	 $(".file-upload .custom-upload input[type='file']").attr('disabled','true');
	 $(".file-upload .custom-upload input[type='file']").css('cursor','default');
	 $('.after-upload-inner').hide();
	 $('.form-error-msg').remove();
     $("input[type='text']").each(function(){
		var act_val=$(this).attr("act-val");
	  	$(this).val(act_val);
	});
	$("textarea").each(function(){
		var act_val=$(this).attr("act-val");
	 	$(this).val(act_val);
	});
	$("input[type='radio']").each(function(){
		var act_val = $('#gender_radio').val();
		if(act_val == 1)
		{
			$('#male').prop('checked',true);
			if(!$('.file-upload .custom-upload').hasClass('prof_img'))
			{
				$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image-men.png)');
			}
		}
		else if(act_val == 2)
		{
			$('#female').prop('checked',true);
			if(!$('.file-upload .custom-upload').hasClass('prof_img')){
				$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image.png)');
			}
		}
		else
		{
			$('#male').prop('checked',false);
			$('#female').prop('checked',false);
			if(!$('.file-upload .custom-upload').hasClass('prof_img')){
				$('.file-upload .custom-upload').css('background-image','url(' + base_url + 'assets/site/images/no-image-men.png)');
			}
		}
	});
	 $("select").each(function(){
		var act_val=$(this).attr("act-val");
	  	$(this).val(act_val);
	 });
	 $(".profile").attr('disabled','disabled'); 
	 $(".profile").selectric('refresh'); 
	 $(".profile-details-wrapper .input input").attr('disabled','disabled');
 	 $(".profile-details-wrapper .input textarea").attr('disabled','disabled');
 	 $(".edit-link").show();
 	 $(".after-edit").hide();
}

 //for level prevention
 $(".level-list-ul > li > a").livequery("click",function(e){
	 $(this).addClass("clicked");console.log( $(this).addClass("clicked"));
	 var current_status=$(this).attr("status");
	 var go_ahead="";
	 var loop_var="";
	 
	 if(current_status==2&&$(this).hasClass("clicked")){
		 $(this).parents("ul").find("li a").each(function(){ 
			 if($(this).hasClass("clicked")){
			 loop_var="true";
			 }
			 if(loop_var==""){
				 var previous_stat=$(this).attr("status");
				 if(previous_stat=="1"||previous_stat=="2"){
					go_ahead="1";
				 }
			 }
		 });
	 }
	  $(this).removeClass("clicked");
	 if(go_ahead!=""){ 
	 $(".success-error-msg p").text("Please complete previous levels.");
	 $(".success-error-msg").addClass("open erroronly");
		 return false; 
	 }
	  
 });
 
  $(document).ready(function(){
	if($(".practice_detail_title").is(":visible")){

$('html, body').animate({
        scrollTop: $('.ques_ans').offset().top
    }, 'fast');
} 
	$("input[name='status']").livequery('click',function(){
	  var payment_type = $(this).val();
	  var url = $("#pn").attr("href");	  
	  var n = url.substring(0,url.length - 1)+payment_type;
	  $("#pn").attr("href", n);
	});


 });
