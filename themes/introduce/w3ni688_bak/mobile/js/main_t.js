$(document).ready(function() {

    // creat menu sidebar
    $(".menu-bar-lv-1").each(function() {
        $(this).find(".span-lv-1").click(function() {
            $(this).toggleClass('rotate-menu');
            $(this).parent().find(".menu-bar-lv-2").toggle(500);
        });
    });
    $(".menu-bar-lv-2").each(function() {
        $(this).find(".span-lv-2").click(function() {
            $(this).toggleClass('rotate-menu');
            $(this).parent().find(".menu-bar-lv-3").toggle(500);
        });
    });
    $(".shadow-open-menu").click(function() {
        $('.menu-bar-mobile').fadeOut();
        $(".shadow-open-menu").fadeOut();
        $(".menu-btn-show").toggleClass("active");
    });
    $(".menu-btn-show").click(function() {
        $(this).toggleClass("active");
        $('.menu-bar-mobile').fadeToggle(500);
        $(".shadow-open-menu").fadeToggle(500);
    });
    $(".categories-menu").each(function() {
        $(this).find(".fa-minus").click(function() {
            $(this).toggleClass("fa-plus");
            $(this).parent().parent().find(".group-check-box").toggleClass("active");
        });
    });



    // const button = document.querySelector('.effects_button')
    // function materializeEffect(event){
    //  const circle = document.createElement('div')
    //  const x = event.layerX
    //  const y = event.layerY
    //  circle.classList.add('circle')
    //  circle.style.left = `${x}px`
    //  circle.style.top = `${y}px`
    //  this.appendChild(circle)
    // }

    // button.addEventListener('click', materializeEffect)


    // $('.go-back').click(function() {
    //     // window.animate({scrollTop: '-='+window.scrollY+'px'}, 800);
    //     animateScrollTop(0, 400);
    // });
    $('.go-back').click(function () {
            // window.animate({scrollTop: '-='+window.scrollY+'px'}, 800);
            animateScrollTop1(0, 400);
        });

        function animateScrollTop1(target, duration) {
            duration = duration || 16;

            var $window = $(window);
            var scrollTopProxy = {value: $window.scrollTop()};
            var expectedScrollTop = scrollTopProxy.value;

            if (scrollTopProxy.value != target) {
                $(scrollTopProxy).animate(
                    {value: target},
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
                                    animateScrollTop1(target);
                                }, 16);
                            }
                        }
                    }
                );
            }
        }

});
