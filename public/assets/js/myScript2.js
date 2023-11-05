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
     
    if(window.location.hash=="#business_section"){
        $(".contact_hidden").hide();
        $(".business_section").show();
        $('html, body').animate({ scrollTop: $("#business_section").offset().top}, 100);
     }

    if (window.location.hash == "#branding") {
        $('html, body').animate({ scrollTop: $("#branding").offset().top - 30 }, 100);
    } else if (window.location.hash == "#digital") {
        $('html, body').animate({ scrollTop: $("#digital").offset().top - 30 }, 100);
    }
    else if (window.location.hash == "#website") {
        $('html, body').animate({ scrollTop: $("#website").offset().top - 30 }, 100);
    }

    if (window.location.hash == "#team") {
        $('html, body').animate({ scrollTop: $("#team").offset().top }, 10);
       
        window.location.hash = "";
    }

    if (window.location.hash == "#branding-tab") {
        $(".nav_tab_custom").find(".nav-link").removeClass("active");
        $(".nav_tab_custom").find("#branding-tab").addClass("active");
        $(".tab-content").find(".tab-pane").removeClass("active");
        $(".tab-content").find(".tab-pane[id='branding']").addClass("active");
        $(".tab-content").find(".tab-pane[id='branding']").addClass("show");
        $('.nav_tab_custom li a[href="#branding-tab"]').trigger('click');
        $('html, body').animate({ scrollTop: $("#link_first_section").offset().top - 30 }, 100);
       
        $('.sticky_header').removeClass('back_white_header');
        $('.sticky_header').addClass('back_black_header');
        window.location.hash = "";
    } else if (window.location.hash == "#digital-tab") {
        $(".nav_tab_custom").find(".nav-link").removeClass("active");
        $(".nav_tab_custom").find("#digital-tab").addClass("active");
        $(".tab-content").find(".tab-pane").removeClass("active");
        $(".tab-content").find(".tab-pane[id='digital']").addClass("active");
        $(".tab-content").find(".tab-pane[id='digital']").addClass("show");
        $('.nav_tab_custom li a[href="#digital-tab"]').trigger('click');
        $('html, body').animate({ scrollTop: $("#link_first_section").offset().top - 30 }, 100);
       
        $('.sticky_header').removeClass('back_white_header');
        $('.sticky_header').addClass('back_black_header');
        window.location.hash = "";
    } else if (window.location.hash == "#websities-tab") {
        $(".nav_tab_custom").find(".nav-link").removeClass("active");
        $(".nav_tab_custom").find("#websities-tab").addClass("active");
        $(".tab-content").find(".tab-pane").removeClass("active");
        $(".tab-content").find(".tab-pane[id='websities']").addClass("active");
        $(".tab-content").find(".tab-pane[id='websities']").addClass("show");
        $('.nav_tab_custom li a[href="#websities-tab"]').trigger('click');
        $('html, body').animate({ scrollTop: $("#link_first_section").offset().top - 30 }, 100);
       
        $('.sticky_header').removeClass('back_white_header');
        $('.sticky_header').addClass('back_black_header');
        window.location.hash = "";
    } else if (window.location.hash == "#video-tab") {
        $(".nav_tab_custom").find(".nav-link").removeClass("active");
        $(".nav_tab_custom").find("#video-tab").addClass("active");
        $(".tab-content").find(".tab-pane").removeClass("active");
        $(".tab-content").find(".tab-pane[id='video_production']").addClass("active");
        $(".tab-content").find(".tab-pane[id='video_production']").addClass("show");
        $('.nav_tab_custom li a[href="#video-tab"]').trigger('click');
        $('html, body').animate({ scrollTop: $("#link_first_section").offset().top - 30 }, 100);
       
        $('.sticky_header').removeClass('back_white_header');
        $('.sticky_header').addClass('back_black_header');
        window.location.hash = "";
    }

    $(".link_business_project").on("click", function () {
        $(".contact_hidden").hide();
        $(".business_section").show();
        $('html, body').animate({ scrollTop: $("#business_section").offset().top}, 100);
    });

    var progressbarinner = document.querySelector(".progress-bar-inner");
    $(window).on("scroll", function () {
         let hash = this.hash;


        if ($(window).scrollTop() == 0) {
            $('header').removeClass('back_white_header');
            $('header').removeClass('back_black_header');
            $(".main_menu").removeClass("opacity");
            $(".progress-bar").hide();
            $('.bg_custom').removeClass('main_menu');

        } else {


            let h = document.documentElement;
            let st = h.scrollTop || document.body.scrollHeight;
            let sh = h.scrollHeight || document.body.scrollHeight;
            let persent = st / (sh - h.clientHeight) * 100;
            let rounded = Math.round(persent);
            progressbarinner.style.width = rounded + "%";
            $(".progress-bar").show();
            $(".progress-bar2").show();
            $('.bg_custom').addClass('main_menu');
            $('header').removeClass('back_white_header');
            $('header').addClass('back_black_header');
            $(".main_menu").addClass("opacity");

        }
    });
});


$(".link_gallary").on("click", function (e) {
    e.preventDefault();
    $("html").addClass("show_box");
    $(".overlay_box").show();
    $(".gallary").show();
});


$(".close_box").on("click", function (e) {
    e.preventDefault();
    $("html").removeClass("show_box");
    $(".overlay_box").hide();
    $(".gallary").hide();
});


$(".logo_footer").on("click", function (e) {
 
    $('header').removeClass('back_white_header');
    $('header').removeClass('back_black_header');
    $('html, body').animate({ scrollTop: 0 }, 10);
});

$(".link_down").on("click" ,function(e){
    let href=$(this).attr('href');
    $('html, body').animate({ scrollTop: $(href).offset().top},5,"linear");   
    $('.bg_custom').addClass('main_menu');
    $('header').removeClass('back_white_header');
    $('header').addClass('back_black_header');     
 });


$('.video').click(function (e) {
     e.preventDefault();
    $(this).addClass("active_video");
    $('.video').popVideo({
        playOnOpen: true,
        title: "jQueryScript.net Demo Page",
        closeOnEnd: true,
        pauseOnClose: true,
    }).open();

});


$(".owl_gallary").owlCarousel({
    autoPlay: false,
    nav: true, // Show next and prev buttons
    loop: false,
    navText: ["<div class='prev-slide'><img class='img_prev' src='assets/img/path 75.png'/></div>", "<div class='next-slide'><img class='img_next' src='assets/img/path 74.png'></div>"],
    dots: false,
    slideSpeed: 5,
    items: 1,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    lazyLoad: true,
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

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

var randomOrder = function (element) {

    // Viewport Dimensions
    var vpHeight = window.innerHeight;
    var vpWidth = window.innerWidth;
    // Image Position
    var xPos = getRandomInt(0, 1000 - element.offsetWidth);
    var yPos = getRandomInt(0, 400 - element.offsetHeight);
    var zIndex = getRandomInt(0, 13);
    element.style.cssText += '--x-position:' + xPos + 'px; --y-position:' + yPos + 'px; z-index:' + zIndex;
};

//Setup
var imgs = document.querySelectorAll('.content_boxes img');

imgs.forEach((the_img) => {
    window.addEventListener('load', function () {
        randomOrder(the_img);
    });
}); //end foreach

$(".navbar-toggler").on("click", function (e) {
    e.preventDefault();
    $(".header2").hide();
    $(".side_menu").addClass("show_menu").fadeIn();
});

$(".close_menu").on("click", function (e) {
    e.preventDefault();
    $(".side_menu").removeClass("show_menu");
    $(".header2").show();
});









$('#form-data').submit(function (e) {
    var route = $('#form-data').data('route');
    var interistedin = " ";
    var text = " ";
    var form_data = new FormData(this);
    var boxes = $("input[name='test']:checked");


    boxes.each(function (i, obj) {
        // console.log($(obj).data("box"));
        text += $(obj).data("box") + ",";
    });
    interistedin = text.replace(" ", "");
    //userip
    // $.getJSON("http://localhost:8000/storedata", function (e) {
    //     console.log(e.ip);
    // });
    document.getElementById('UserAgent').value = navigator.userAgent;
    const element = document.getElementById('name');
    if (element == null)
        alert(" name require");
    console.log(element.required);


    form_data.append('interistedin', interistedin);
    form_data.append('user_agent', document.getElementById('UserAgent').value);

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "The message will be sent",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, send it!",
        closeOnConfirm: false
    })
    $.ajax({
        type: 'POST',
        url: route,
        data: form_data,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function (Response) {
            // console.log("the email is send");
            swal("Done!", "It was succesfully sended!", "success");
            console.log(Response);
        }
    });
});


$(".link_send").on("click", function () {
    console.log("enter");
    $("#form-data").submit();

})
