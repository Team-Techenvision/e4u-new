//Class for Desktop all resolution function
var ismobile = (/android|webos|iphone|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
	var isiPad = navigator.userAgent.match(/iPad/i) != null;
function checkWindowSize() {
    var width = $(window).width(),
    new_class = width > 1680 ? 'wlarge':
                width > 1600 ? 'w1680' :
                width > 1440 ? 'w1600' :
                width > 1400 ? 'w1440' :
                width > 1366 ? 'w1400' :
                width > 1280 ? 'w1366' :
                width > 1152 ? 'w1280' :
                width > 1024 ? 'w1152' :
				width <= 1024 ? 'wsmall' : '';
    $(document.body).removeClass('wlarge w1680 w1600 w1440 w1400 w1366 w1280 w1152 wsmall').addClass(new_class);	
}
function scrollToTop() {
	$('html, body').animate({scrollTop: 0}, 1000);
}
$(document).ready(function(){
 
	$(window).scroll(function(){
		if ($(this).scrollTop() > 400) {
			$('.scrolltotop').fadeIn();
		} else {
			$('.scrolltotop').fadeOut();
		}
	});
	$('.scrolltotop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});
	
	//Profile Dropdown
	$('a.head_profile').click(function(){
		$(this).toggleClass('opened');
		$('.head_profile_list').slideToggle();
		//var ismobile = (/android|webos|iphone|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
		if(ismobile){
			$('.nav-menu').slideUp();
		}
	});

	var datae=new Date() ;
	var date_sers=current_date.split("-");
	var datae_server=new Date(date_sers[0],date_sers[1] - 1, date_sers[2],date_sers[3],date_sers[4],date_sers[5]) ;
	var dif = datae.getTime() - datae_server.getTime(); 
	var Seconds_from_T1_to_T2 = dif / 1000;
	var Seconds_Between_Dates = Math.abs(Seconds_from_T1_to_T2);
	Seconds_Between_Dates=Seconds_Between_Dates+1;
	// console.log("JS date:"+datae);
	// console.log("current:"+ datae_server);
	// console.log("diffDays:"+ Seconds_Between_Dates);
	
	//Countdown
	var duration;
	var count_down_time = $('#count_down').attr('current_time');
	if(count_down_time){
		var count_down = count_down_time.split(':'); 
		if($(".status").val()==1){
			duration = false;
		}
		else{
			duration = new Date(count_down[0],count_down[1] - 1, count_down[2],count_down[3],count_down[4],count_down[5]-Seconds_Between_Dates); 
		}
	}
	if(duration){
	$('#count_down').countdown({
		until: duration,
		onExpiry: liftOff,
		/*until: count_down[1]+'m'+','+count_down[2]+'s',*/
		compact: true,
		onTick:warnUser
		});
	}
	
	
	function liftOff() { 
        $("#progress-test").trigger('submit');
        $("#surprise-test").trigger('submit');
        $("input[type='radio']").attr("disabled","disabled");
        window.onbeforeunload = null;
	}
	function warnUser(periods) { 
   if ($.countdown.periodsToSeconds(periods) <= 10) { 
      $(".time_count").addClass("red"); 
	 
   } 
}
	
	var s_count_down_time = $('#surprise_count_down11').attr('current_time');
	 
	if(s_count_down_time){
		var s_count_down = s_count_down_time.split(':');
		if($(".status").val()==1){
			var time = 'false';
		}else{
			var time = s_count_down[0]+'h'+','+s_count_down[1]+'m'+','+s_count_down[2]+'s';
		}
		$('#surprise_count_down').countdown({
		until: time,
		onExpiry: liftOff,
		/*until: count_down[1]+'m'+','+count_down[2]+'s',*/
		compact: true
		});
	}
	
	$('.mobi_menu').click(function(){
		$('.nav-menu').slideToggle();
		$('.head_profile_list').slideUp();
		$('.head_profile').removeClass('opened');
	});
	
	
	if(!ismobile && !isiPad){
		checkWindowSize();
	}
	$(window).resize(function(){
		if(!ismobile && !isiPad){
			checkWindowSize();
		}
	});
	
	//Wrapper div 
	setTimeout(function(){
		$('.home-slider ul.rslides').next('.callbacks_tabs').wrap('<div class="wrapper"></div>');
	},0);
	
	//Slider script function
	$('.home-slider .rslides').responsiveSlides({
		auto: true,
		pager: true,
		nav: false,
		speed: 1500,
		timeout: 3000,
		namespace: "callbacks"
	});	

	//Select box script
	$('.select-box select').livequery(function(){
		 if(!$(this).hasClass("profile")){
			 $('.select-box select').selectric({
			disableOnMobile:false,
			maxHeight: 250
			});
		 } 
	});

	//Location list image slider
	$('.testimonial-slider').bxSlider({
		auto: true, 
		pager: true,
		moveSlides: 1
	});

	//Fancybox script
	$('.fancybox').fancybox({
		title   : null,
		padding : 0,
		autoCenter:true,
		closeClick  : false, // preven  ts closing when clicking INSIDE fancybox
		helpers     : { 
			overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		}
	});		
	//Fancybox script
	$('.new_fancybox').fancybox({
		title   : null,
		padding : 0,
		autoCenter:true,
		closeClick  : false,		
		helpers     : { 
			overlay : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox
			
		}		
	});	
	$('.login-btn').fancybox({
		title   : null,
		padding : 0,
		wrapCSS : 'login-fbox',
		autoCenter:true,
		closeClick  : false, // prevents closing when clicking INSIDE fancybox
		helpers     : { 
        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		}
		
	});
	$('.subjective-btn').fancybox({
		title   : null,
		padding : 0,
		wrapCSS : 'subjective-fbox',
		autoCenter:true,
		closeClick  : false, // prevents closing when clicking INSIDE fancybox
		helpers     : { 
        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		}
		
	});
	
	$('.study-slider').bxSlider({
		pager:false,
		controls:true,
		minSlides:1,
		maxSlides:3,
		moveSlides:1,
		slideWidth:232,
		slideMargin:142
	 });
	
	$('.ajaxtab-menu ul li a').livequery('click',function(){
		$('.head_profile_list').slideUp();
		//$('#preloader1').show();
		var url = $(this).attr('href');		
		if(!($(this).hasClass('active'))){
			$(".ajaxtab-menu ul li a").removeClass("active");
			$(this).addClass("active");
			$.ajax({
				type:"GET",
				url : url,				
				dataType: 'html',	 
				success: function(html){
				 
								try {
									json = $.parseJSON(html);		
									if(json.status=="session_mismatch"){
									createCookie('myCookie', 'Unauthorized Access Multiple connections to a server by the same user, using more than one user name, are not allowed. Disconnect all previous connections to the server or shared resource and try again.', 1);
									window.open(base_url+"home/logout","_self");
									}else{
									window.open(base_url+"home/index/login","_self");
									}	
							} catch (e) {
								// not json
									$('.ajaxtab-content').fadeOut(500,function() {
									$('.ajaxtab-content').html(html).fadeIn(500); 
									$(".profile").selectric("refresh");
								 
									});	
									//$('#preloader1').hide();
								}
								 
												
					
				},
				error: function(){
				},
				complete: function(){				
						
				}
			});
		}
		return false;
	});

	$('.test-type-section ul.test-list li a').livequery('click',function(){
		$('#pre-loader2').show();
		var url = $(this).attr('href');
		if(!($(this).hasClass('active'))){
			$(".test-type-section ul.test-list li a").removeClass("active");
			$(this).addClass("active");
			$.ajax({
				type:"GET",
				url : url,
				dataType: 'html',	 
				success: function(html){

					$('.result-graph-content').fadeOut(500,function() {
						$('.result-graph-content').html(html).fadeIn(500);
					});		
 			
				},
				error: function(){
				},
				complete: function(){				
					$('#pre-loader2').hide();
				}
			});
		}
		return false;
	});

	$('.subject-dropdown').livequery('click',function(){
		if($(this).hasClass('slide-open')){
			$(".subject-dropdown-list").slideUp();
			$(this).removeClass('slide-open');
		}else{
			$(".subject-dropdown-list").slideDown();
			$(this).addClass('slide-open');
		}
	});
	$('.subject-dropdown-list li a').livequery('click',function(){
		//$(".subject-dropdown-list").slideToggle();
		//return false;
	});
	$('.edit-link').livequery('click',function(){
		image_selected="";
		$(".file-upload .custom-upload input[type='file']").removeAttr('disabled');
		$(".file-upload .custom-upload input[type='file']").css('cursor','pointer');
		$(".profile-details-wrapper .input input").removeAttr('disabled');
		$(".profile-details-wrapper .input textarea").removeAttr('disabled');
		$(".profile").removeAttr("disabled").selectric('refresh'); 
		$("#fname").focus();
		$("#email").attr('disabled','disabled');
		$(".after-edit").show();
		$('.after-upload-inner').show();
		$(this).hide();
		return false;
	});

	//Scrollpane script
	$('.scroll-pane').livequery(function(){
		$('.scroll-pane').jScrollPane({
			mousewheel:100,
			autoReinitialise:true
		});
	});

	$('.downloadpopup-tabsection ul li a').livequery('click',function(){		
		var url = $(this).attr('href');
		if(!($(this).hasClass('active'))){
			$(".downloadpopup-tabsection ul li a").removeClass("active");
			$(this).addClass("active");
			$.ajax({
				type:"GET",
				url : url,
				dataType: 'html',	 
				success: function(html){
					$('.ajaxupload-download').fadeOut(500,function() {
						$('.ajaxupload-download').html(html).fadeIn(500);
					});					
				},
				error: function(){
				},
				complete: function(){				
				}
			});
		}
		return false;
	});
	$('.popup-uploadnow a').livequery('click',function(){		
		var url = $(this).attr('href');		
		$.ajax({
			type:"GET",
			url : url,
			dataType: 'html',	 
			success: function(html){
				$('.download-content-main').fadeOut(500,function() {
					$('.download-content-main').html(html).fadeIn(500);
				});					
			},
			error: function(){
			},
			complete: function(){				
			}
		});
		return false;
	});

	$('.dashboard-course-list h2 .dashboard-course-menu').livequery('click',function(){		
		$('.dashboard-course-list h2').toggleClass("active");
		if ($('.dashboard-course-list h2').find('.menu-icon').hasClass('expand')) {			
			setTimeout(function () {
				$('.menu-icon').removeClass('expand');
				$('.menu-icon').addClass('collapse');
			}, 100);
		}
		if ($('.dashboard-course-list h2').find('.menu-icon').hasClass('collapse')) {			  
			setTimeout(function () {
				$('.menu-icon').removeClass('collapse');
				$('.menu-icon').addClass('expand');
			}, 100);
		}
		$('.dashboard-course-list h2').parents('.dashboard-course-list').find('ul').slideToggle();
	});

	$('.dashboard-course-list ul li a').livequery('click',function(){
		var content = $(this).text();
		if(!($(this).hasClass('active'))){
			$(".dashboard-course-list ul li a").removeClass("active");
			$(this).addClass("active");
			$(this).parents('.dashboard-course-list').find('h2 label').html(content);
			var url = $(this).attr('href');
			$.ajax({
				type:"GET",
				url : url,
				dataType: 'html',	 
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
			$(this).parents('ul').slideUp();
			if ($('.menu-icon').hasClass('expand')) {			
				setTimeout(function () {
					$('.menu-icon').removeClass('expand');
					$('.menu-icon').addClass('collapse');
				}, 100);
			}
			if ($('.menu-icon').hasClass('collapse')) {			  
				setTimeout(function () {
					$('.menu-icon').removeClass('collapse');
					$('.menu-icon').addClass('expand');
				}, 100);
			}
			$('.dashboard-course-list h2').removeClass('active');
		}
		return false;		
	});

	$('a.paymentshowmore').click(function(){			
		var descriptionheight = $(this).parents('li').find('.description-inner').innerHeight();
		var thiselement = $(this);
		if ($(this).hasClass('showless')) {
			$(this).parents('li').find('.paymentcourse-description').animate({'height':'115px'},500);		
			setTimeout(function () {
				$(thiselement).removeClass('showless');
				$(thiselement).addClass('showmore');
				$(thiselement).html("Show More");
				$(thiselement).attr('title', 'Show More');
			}, 100);
		}
		if ($(this).hasClass('showmore')) {
			$(this).parents('li').find('.paymentcourse-description').animate({'height':descriptionheight},500);			
			setTimeout(function () {
				$(thiselement).removeClass('showmore');
				$(thiselement).addClass('showless');
				$(thiselement).html("Show Less");
				$(thiselement).attr('title', 'Show Less');
			}, 100);
		}
		return false;
	});
	
	$('.success-error-msg span.close-btn').livequery('click',function(){
		$(this).parents('.success-error-msg').removeClass('open');
	});

	$('.ourteam-list-main ul').bxSlider({
		pager:false,
		controls:true,
		minSlides:1,
		maxSlides:4,
		moveSlides:1,
		slideWidth:263,
		slideMargin:30,
		infiniteLoop:false,
		hideControlOnEnd:true
	 });
	$('.faq-accord h3').click(function(){
		if($(this).hasClass('active')){
			$('.faq-accord h3').removeClass('active');
			$('.faq-accord').removeClass('opencontent');
		} else{
			$('.faq-accord h3').removeClass('active');
			$('.faq-accord').removeClass('opencontent');
			$(this).parent('.faq-accord').addClass('opencontent');
			$(this).addClass('active');
		}
		var $slidediv = $('.faq-accordion-content');
			$slide = $(this).next('.faq-accordion-content').stop(true).slideToggle();
			$slidediv.not($slide).filter(':visible').stop(true).slideUp();			
		return false;
	});
	$('.dashboard-container .pagination a').livequery('click',function(){
		setTimeout(function() {
			$('html, body').animate({
				scrollTop: jQuery('.dashboard-container').offset().top
			}, 1000);
		}, 500);
		
	});

});
if(ismobile){
	if($('.practice_detail').hasClass('.timerscroll')){
		$(window).scroll(function(){
			var scroll_div = $('.practice_detail .practice_detail_title').offset().top;
			if ($(this).scrollTop() > scroll_div){ 
				$('.practice_detail .practice_detail_title.progress_timer').addClass('fixed'); 
			}
			else{
				$('.practice_detail .practice_detail_title.progress_timer').removeClass('fixed');
			}
		});
	}
}
$(window).on('beforeunload', function(){
	 
	if($(".total_time").is(":visible")){
	 
		 var second = $(".countdown-amount").text().split(':');
				document.cookie = "seconds="+second[2]+"; path=/";  
	}
                
           });
$('.alert-list a.readmore').livequery('click',function(){			
		var alertdescriptionheight = $(this).parents('.alert-list').find('.alert-description p').innerHeight();
		var thiselement = $(this);
		if ($(this).hasClass('alertreadless')) {
			$(this).parents('.alert-list').find('.alert-description').animate({'height':'46px'},500);		
			setTimeout(function () {
				$(thiselement).removeClass('alertreadless');
				$(thiselement).addClass('alertreadmore');
				$(thiselement).html("Read More");
				$(thiselement).attr("title","Read More");
			}, 100);
		}
		if ($(this).hasClass('alertreadmore')) {
			$(this).parents('.alert-list').find('.alert-description').animate({'height':alertdescriptionheight},500);			
			setTimeout(function () {
				$(thiselement).removeClass('alertreadmore');
				$(thiselement).addClass('alertreadless');
				$(thiselement).html("Read Less");
				$(thiselement).attr("title","Read Less");
			}, 100);
		}
		return false;
	});
// bajb_backdetect.OnBack = function()
	// {
		// var conff=confirm("Are you sure to quite the exam..?");
		// return conff;
	// }
	// window.onbeforeunload = function (e) {
		 // HandleBackFunctionality(e);
		 	// return false;

	// };
	 
	function HandleBackFunctionality(event)
{
    if(window.event)
   {
        if(window.event.clientX < 40 && window.event.clientY < 0)
        {
            alert("Browser back button is clicked...");
		
        }
        else
        {
            alert("Browser refresh button is clicked...");
        }
    }
    else
    {
        if(event.currentTarget.performance.navigation.type == 1)
        {
             alert("Browser refresh button is clicked...");
        }
        if(event.currentTarget.performance.navigation.type == 2)
        {
             alert("Browser back button is clicked...");
        }
    }
		return false;
}
