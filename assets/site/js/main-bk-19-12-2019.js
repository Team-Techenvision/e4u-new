 //menubar
 $('.menu-toggle').click(function(){	
	 $('nav').toggleClass('active');
	  $('body').toggleClass('mobile-overlay');
	});
 
//close icon toggle
 $('.menu-toggle').on('click', function(e) {
      $('.fa').toggleClass("fa-bars fa-times");
      e.preventDefault();
 });
   
// AOS Animation         
 //AOS.init({
//disable: 'mobile'
//});
AOS.init({
  disable: function () {
    var maxWidth = 1024;
    return window.innerWidth < maxWidth;
  }
});
 //login form
  $('.forget').click(function() {
  $(".close").addClass("frgt-close");
  $('#login_tab').hide();
  $('#forget_tab').show();
 });
 $('#myModal').on('hidden.bs.modal', function() {
  location.reload();
 });
  $('.login-form').on('submit', function(e) {
  $('#myModal').modal('show');
  e.preventDefault();
 });

 //home-slider
 $(document).ready(function() {
  $('.home-slider').owlCarousel({
   loop: true,
   margin: 10,
   nav: true,
   center: true,
   autoplay: false,
   pagination: false,
   dots: false,
   navText: ["<img src="+base_url+"assets/site/images/left-arrow.jpg alt='arrow'>",
    "<img src="+base_url+"assets/site/images/right-arrow.jpg alt='arrow'>"
   ],
   autoplay: true,
   autoplayHoverPause: true,
   responsive: {
    0: {
     items: 1
    },
    600: {
     items: 1
    },
    1000: {
     items: 3,

    }
   }
  })
 });

 // dashboard pagination
 $('#pagination-demo').twbsPagination({
  totalPages: 5,
  // the current page that show on start
  startPage: 1,

  // maximum visible pages
  visiblePages: 3,

  initiateStartPageClick: true,

  // template for pagination links
  href: false,

  // variable name in href template for page number
  hrefVariable: '{{number}}',

  // Text labels
  prev: 'Previous',
  next: 'Next',


  // carousel-style pagination
  loop: false,

  // callback function
  onPageClick: function(event, page) {
   $('.page-active').removeClass('page-active');
   $('#page' + page).addClass('page-active');
  },

  // pagination Classes
  paginationClass: 'pagination',
  nextClass: 'next',
  prevClass: 'prev',
  pageClass: 'page',
  activeClass: 'active',
  disabledClass: 'disabled'

 });

 //dashboard slider

 $('#standard-carousel').owlCarousel({
  loop: false,
  margin: 30,
  nav: true,

  navText: ["<div class='nav-btn prev-slide'><img src="+base_url+"assets/site/images/left-arrow.jpg></div>", "<div class='nav-btn next-slide'><img src="+base_url+"assets/site/images/right-arrow.jpg></div>"],
  responsive: {
   0: {
    items: 1
   },
   480: {
    items: 2
   },
   600: {
    items: 3
   },
   1000: {
    items: 4
   }
  }
 });
 
 // Menubar 
 $(document).ready(function(){
 console.log('menu clicked');
});