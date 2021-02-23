//Class for Desktop all resolution function
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
	//Profile Dropdown
	$('a.head_profile').click(function(){
		$(this).toggleClass('opened');
		$('.head_profile_list').slideToggle();
	});
	
	//Countdown
	var count_down_time = $('#count_down').attr('current_time');
	if(count_down_time){
		var count_down = count_down_time.split(':');
		if($(".status").val()==1){
		var time = '00m';
		}else{
		var time = count_down[1]+'m';
		}
		$('#count_down').countdown({
		until: time,
		onExpiry: liftOff,
		/*until: count_down[1]+'m'+','+count_down[2]+'s',*/
		compact: true
		});
	}
	function liftOff() { 
        $("#progress-test").trigger('submit');
	}
	
	$('.mobi_menu').click(function(){
		$('.nav-menu').slideToggle();
	});
	
	var ismobile = (/android|webos|iphone|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
	var isiPad = navigator.userAgent.match(/iPad/i) != null;
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
		$('.select-box select').selectric({
			disableOnMobile:false,
			maxHeight: 250
		});
	});

	//Location list image slider
	$('.testimonial-slider').bxSlider({
		auto: false, 
		pager: true,
		moveSlides: 1
	});

	//Fancybox script
	$('.fancybox').fancybox({
		title   : null,
		padding : 0,
		autoCenter:true
	});	
	$('.login-btn').fancybox({
		title   : null,
		padding : 0,
		wrapCSS : 'login-fbox',
		autoCenter:true
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
		$('#pre-loader1').show();
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
									window.open(base_url+"home/index/login","_self");
							} catch (e) {
								// not json
									$('.ajaxtab-content').fadeOut(500,function() {
									$('.ajaxtab-content').html(html).fadeIn(500);
									});	
								} 
					
				},
				error: function(){
				},
				complete: function(){				
					$('#pre-loader1').hide();
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
		$(".subject-dropdown-list").slideToggle();
	});
	$('.subject-dropdown-list li a').livequery('click',function(){
		$(".subject-dropdown-list").slideToggle();
		return false;
	});
	$('.edit-link').livequery('click',function(){
		$(".profile-details-wrapper .input input").removeAttr('disabled');
		$(".profile-details-wrapper .input textarea").removeAttr('disabled');
		$(".profile-details-wrapper .input select").removeAttr("disabled").selectric('refresh');
		$("#fname").focus();
		$("#email").attr('disabled','disabled');
		$(".after-edit").show();
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

	$('.dashboard-course-list h2').livequery('click',function(){		
		$(this).toggleClass("active");
		if ($(this).find('.menu-icon').hasClass('expand')) {			
			setTimeout(function () {
				$('.menu-icon').removeClass('expand');
				$('.menu-icon').addClass('collapse');
			}, 100);
		}
		if ($(this).find('.menu-icon').hasClass('collapse')) {			  
			setTimeout(function () {
				$('.menu-icon').removeClass('collapse');
				$('.menu-icon').addClass('expand');
			}, 100);
		}
		$(this).parents('.dashboard-course-list').find('ul').slideToggle();
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
					$('.overall-performance-content').fadeOut(500,function() {
						$('.overall-performance-content').html(html).fadeIn(500);
					});					
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
			}, 100);
		}
		if ($(this).hasClass('showmore')) {
			$(this).parents('li').find('.paymentcourse-description').animate({'height':descriptionheight},500);			
			setTimeout(function () {
				$(thiselement).removeClass('showmore');
				$(thiselement).addClass('showless');
				$(thiselement).html("Show Less");
			}, 100);
		}
		return false;
	});
	
	$('.success-error-msg span.close-btn').livequery('click',function(){
		$(this).parents('.success-error-msg').removeClass('open');
	});

});
