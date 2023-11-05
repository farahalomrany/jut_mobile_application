

jQuery(function ($) {
  
  if (!window.location.hash||window.location.hash) {
    $('.bg_custom').removeClass('main_menu');
    $('header').removeClass('back_white_header');
    $('header').removeClass('back_black_header');
    $('html, body').animate({
      scrollTop: 0
    }, 10, "linear");
    window.location.hash = "";
  }
 
  var didScroll;
  var lastScrollTop = 0;
  var delta = 5;
  var navbarHeight = $('header').outerHeight();
  var progressbarinner=document.querySelector(".progress-bar-inner");
  var progressbarinner2=document.querySelector(".progress-bar-inner2");

  $(window).on("scroll", function () {
    // Hide Header on on scroll down
 
    let hash = this.hash;

    if ($(window).scrollTop()==0) {
        $('header').removeClass('back_white_header');
        $('header').removeClass('back_black_header');
        $('.main_menu').removeClass("opacitywhite");
        $('.main_menu').removeClass("opacityblack"); 
        $('.logo_white').show();
        $('.logo_black').hide();
        $(".progress-bar").hide();
        $(".progress-bar2").hide();
        $('.bg_custom').removeClass('main_menu');
     } 
     else if($(window).scrollTop() >=500)  {
      let h=document.documentElement;
      let st=h.scrollTop||document.body.scrollHeight;
      let sh=h.scrollHeight||document.body.scrollHeight;
      let persent=st/(sh-h.clientHeight)*100;
      let rounded=Math.round(persent);
      progressbarinner.style.width=rounded + "%";
      progressbarinner2.style.width=rounded + "%";
       $('.menu_custom a.nav-link').each(function () {
        let currLink = $(this);
        let refElement = $(currLink.attr("data-href"));
        let scrollPos = $(window).scrollTop();
        let top = ($(refElement).offset() || {
          "top": NaN
        }).top;

        if (!(isNaN(top))) {
          if (top <= scrollPos && refElement.position().top + refElement.height() >= scrollPos) {
             $('.menu_custom a.nav-link').removeClass("active");
              currLink.addClass("active");
              $(".progress-bar").show();
              $(".progress-bar2").show();
              if ($(currLink).attr("data-href") == "#link_first_section") {
              $('.bg_custom').addClass('main_menu');
              $('header').removeClass('back_white_header');
              $('header').addClass('back_black_header');
              $('.logo_white').show();
              $('.logo_black').hide();
              $(".progress-bar").show();
              $(".progress-bar2").show();
              if(scrollPos>800){
                didScroll = true;
              }else{
                didScroll=false;
              }  
            } else if ($(currLink).attr("data-href") == "#capabilities") {
              $('.logo_white').hide();
              $('.logo_black').show();
              $('.bg_custom').addClass('main_menu');
              $('header').addClass('back_white_header');
              $('header').removeClass('back_black_header');
              $(".progress-bar").show();
              $(".progress-bar2").show();
              didScroll = true;
            } else if ($(currLink).attr("data-href") == "#revolve") {
              $('.logo_white').show();
              $('.logo_black').hide();
              $('.bg_custom').addClass('main_menu');
              $('header').removeClass('back_white_header');
              $('header').addClass('back_black_header');
              didScroll = true;
              $(".progress-bar").show();
              $(".progress-bar2").show();
            } else if ($(currLink).attr("data-href") == "#retraine") {
              $('.logo_white').hide();
              $('.logo_black').show();
              $('.bg_custom').addClass('main_menu');
              $('header').addClass('back_white_header');
              $('header').removeClass('back_black_header');
              didScroll = true;
              $(".progress-bar").show();
              $(".progress-bar2").show();
            } else if ($(currLink).attr("data-href") == "#blend") {
              $('.logo_white').show();
              $('.logo_black').hide();
              $('.bg_custom').addClass('main_menu');
              $('header').removeClass('back_white_header');
              $('header').addClass('back_black_header');
              didScroll = true;
              $(".progress-bar").show();
              $(".progress-bar2").show();

            } else if ($(currLink).attr("data-href")=="#contact2") {
              $('.logo_white').hide();
              $('.logo_black').show();
              $('.bg_custom').addClass('main_menu');
              $('header').addClass('back_white_header');
              $('header').removeClass('back_black_header');
              didScroll = true;
              $(".progress-bar").show();
              $(".progress-bar2").show();
            } else {
              currLink.removeClass("active");
            }
          }
        }
      });
    }

  });

  setInterval(function () {
    if (didScroll) {
      hasScrolled();
      didScroll = false;
    }
  }, 250);

  function hasScrolled() {
    var st = $(this).scrollTop();

    // Make sure they scroll more than delta
    if (Math.abs(lastScrollTop - st) <= delta) {
      
     return;
    }

    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight) {
      // Scroll Down
      $('header').removeClass('nav-down').addClass('nav-up');
   
      if( $("header").hasClass("back_white_header")){
        $(".main_menu").addClass("opacitywhite");
        $(".main_menu").removeClass("opacityblack");
      }
      else if($("header").hasClass("back_black_header")){
        $(".main_menu").addClass("opacityblack");
        $(".main_menu").removeClass("opacitywhite");
      }
       
    } else {
      // Scroll Up
      if (st + $(window).height() < $(document).height()) {
        $('header').removeClass('nav-up').addClass('nav-down');
         if( $("header").hasClass("back_white_header")){
            $(".main_menu").removeClass("opacitywhite");
        }
        else if($("header").hasClass("back_black_header")){
            $(".main_menu").removeClass("opacityblack");
        }
        
      }
    }

    lastScrollTop = st;
  }

  
  $(".logo_footer").on("click", function (e) {
 
    $('header').removeClass('back_white_header');
    $('header').removeClass('back_black_header');
    $('html, body').animate({
      scrollTop: 0
    }, 10);
  });

  $(".link_down").on("click" ,function(e){
    let href=$(this).attr('href');
    $('html, body').animate({ scrollTop: $(href).offset().top},5,"linear");   
    $('.bg_custom').addClass('main_menu');
    $('header').removeClass('back_white_header');
    $('header').addClass('back_black_header');     
 });


  


  $(".title_card").on("click", function () {
    let id = $(this).attr('id');
    if (id == "branding_link") {
      window.location.href = 'work.html#branding-tab';
    } else if (id = "digital_link") {
      window.location.href = 'work.html#digital-tab';
    } else if (id = "websities_link") {
      window.location.href = 'work.html#websities-tab';

    } else if (id = "video_link") {
      window.location.href = 'work.html#video-tab';
    }

  });


  $(".link_explore").on("click",function(){
    $('html, body').animate({ scrollTop: $("#tool").offset().top+30}, 100);
    $(".close_pos").fadeIn(10);
    $(".arrow_pos").fadeIn(10);
    $(".overlay_home").fadeIn(10);
    $('#tool').addClass('draw');
  })

  $(" .overlay_home, .close_pos").on("click",function(){
    $(".arrow_pos").fadeOut(10);
    $(".overlay_home").fadeOut(10);
    $('#tool').removeClass('draw');
    $(".close_pos").fadeOut(10);
  })

 
  $('.menu').hover(function () {
   
     $(".menu-" + this.id).css("opacity", "1");
    },
    function () {
 
    $(".menu-" + this.id + ":not(:first-child)").css("opacity", "0");
  });
  
  $(".navbar-toggler").on("click",function(e){
    e.preventDefault();
    $(".header2").hide();
    $("html").addClass("open_menu");
    $(".side_menu").addClass("show_menu").fadeIn();
  });

  $(".close_menu").on("click",function(e){
     e.preventDefault();
     $("html").removeClass("open_menu");
    $(".side_menu").removeClass("show_menu");
    $(".header2").show();
  });


  $("#owl-demo").owlCarousel({
    autoplay: true, //Set AutoPlay to 3 seconds
    loop: true,
    margin:8,
    dots: false,
    items: 4,
    slideTransition: 'linear',
    autoplayTimeout : 2000,
    autoplayHoverPause : true,
    autoplaySpeed : 2000,
    center:true,
    nav:false,
     responsive : {
      // breakpoint from 0 up
        0 : {
          items:2,
          center:true
        },
        // breakpoint from 480 up
        480 : {
          items:2,
          center:true
        },
        // breakpoint from 768 up
        768 : {
          items:4,
         
        }
    }
  });

  var owl=$("#owl-demo2");
  $("#owl-demo2").owlCarousel({
    nav: true, // Show next and prev buttons
    loop: false,
    navText: ["<div id='prev-slide' class='prev-slide'><img src='assets/img/path 75.png'/></div>", "<div id='next-slide' class='next-slide'><img src='assets/img/path 74.png'/</div>"],
    dots: false,
    slideSpeed: 100,
    items: 1,
    responsiveClass: true,
    singleItem: true,
   
    responsiveClass: true,
    responsive : {
      // breakpoint from 0 up
        0 : {
          items:1,
          nav:true,
        },
        // breakpoint from 480 up
        480 : {
          items:1,
          nav:true
        },
        // breakpoint from 768 up
        768 : {
          items:1,
          nav:true
        }
      }
  });

 
  
  
  $("#owl-demo3").owlCarousel({
    items:3,
    autoPlay: false,
    margin: 20,
    loop: false,
    nav: true,
   
    navText: ["<div class='prev-slide'><img src='assets/img/path 75.png'/></div>", "<div class='next-slide'><img src='assets/img/path 74.png'/</div>"],
    dots: false,
    responsive : {
      // breakpoint from 0 up
        0 : {
          items:1,
          nav:true
        },
        // breakpoint from 480 up
        480 : {
          items:1,
          nav:true
        },
        // breakpoint from 768 up
        768 : {
          items:3,
          nav:true
        }
      } 
    });

  

});