$(document).ready(function(){
    $('.thumimg2').hover(function() {
        var title = $(this).attr('data-title');
        var img_maps = $(this).attr('data-img');
        $('#view-img2').attr('src', img_maps);
        $('#textId').html(title);
        $('#view-map').addClass('active');
    });
	$('#owl-demo-index').owlCarousel({
        items:1,
        autoplay:true,
        autoplayTimeout:6000,
        autoplaySpeed:2000,
        loop:true,
        margin:0,
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
	$('#owl-demo2').owlCarousel({
        items:4,
        autoplay:true,
        autoplayTimeout:6000,
        autoplaySpeed:2000,
        loop:true,
        margin:0,
        nav:false,
        dots:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:3
            },
            1200:{
                items:4
            },
            1600:{
                items:4
            }
        }
    });
    $('#owl-details').owlCarousel({
        items:8,
        autoplay:false,
        autoplayTimeout:6000,
        autoplaySpeed:2000,
        loop:false,
        margin:0,
        nav:false,
        dots:false,
        responsive:{
            0:{
                items:3
            },
            600:{
                items:7
            },
            1000:{
                items:7
            },
            1200:{
                items:7
            },
            1600:{
                items:8
            },
        },
    });
   
});

$('.scroll-top-btn').click(function(){
    // window.animate({scrollTop: '-='+window.scrollY+'px'}, 800);
    animateScrollTop(0,400);
});

function animateScrollTop(target, duration) {
    duration = duration || 16;

    var $window = $(window);
    var scrollTopProxy = { value: $window.scrollTop() };
    var expectedScrollTop = scrollTopProxy.value;

    if (scrollTopProxy.value != target) {
        $(scrollTopProxy).animate(
            { value: target },
            {
                duration: duration,

                step: function (stepValue) {
                    var roundedValue = Math.round(stepValue);
                    if ($window.scrollTop() !== expectedScrollTop) {
                        // The user has tried to scroll the page
                        $(scrollTopProxy).stop();
                    }
                    $window.scrollTop(roundedValue);
                    expectedScrollTop = roundedValue;
                },

                complete: function () {
                    if ($window.scrollTop() != target) {
                        setTimeout(function () {
                            animateScrollTop(target);
                        }, 16);
                    }
                }
            }
        );
    }
}
