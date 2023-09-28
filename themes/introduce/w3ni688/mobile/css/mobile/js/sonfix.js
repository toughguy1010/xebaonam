
$(document).ready(function(){
    // $('.slider_m').owlCarousel({
    //     loop: true,
    //     margin: 0 ,
    //     dots: false,
    //     smartSpeed: 800,
    //     nav: true,
    //     items: 1,
    // });
    // $('.menu_car').owlCarousel({
    //     loop: true,
    //     dots: false,
    //     smartSpeed: 800,
    //     nav: false,
    //     items: 3,
    // });
     $('.customer-img').owlCarousel({
        loop: true,
        dots: true,
        smartSpeed: 800,
        nav: false,
        items: 2,
    });



    $( ".owl-prev").html('<i class="fa fa-angle-left"></i>');
 	$( ".owl-next").html('<i class="fa fa-angle-right"></i>');
});

