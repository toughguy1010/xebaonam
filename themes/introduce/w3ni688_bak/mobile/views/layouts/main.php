<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width" name="viewport"/>
    <title><?= $this->pageTitle; ?></title>
    <?php
    $themUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
    $vs = '1.6.1';
    ?>
    <!-- The Stylesheet -->

    <!--<link href='<?php echo $themUrl ?>/css/threesixty.css?v=18.04.16' rel='stylesheet' type='text/css' />-->
    <!-- javaScript -->
    <!--<link rel="stylesheet" type="text/css" href="css/main.css"/>-->
    <link href="<?php echo $themUrl ?>/css/owl.carousel.css" rel="stylesheet"/>
    <!--     <link rel="stylesheet" type="text/css" href="--><?php //echo $themUrl ?><!--/css/style.css?v=0.0.1"/>-->
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/style.css?v=<?= $vs ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/fix.css?v=<?= $vs ?>"/>
    <script type="text/javascript" src="<?= $themUrl ?>/js/owl.carousel.min.js"></script>
    <link href='<?php echo $themUrl ?>/css/style1.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>
    <script type="text/javascript" src="<?= $themUrl ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion_async.js"> </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="<?= $themUrl?>/css/mobile/css/vendors/font-awesome.css" rel="stylesheet" />
   <link rel="stylesheet" href="<?= $themUrl?>/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $themUrl?>/owlcarousel/owl.theme.default.min.css">
    <link href="<?= $themUrl?>/css/mobile/css/vendors/slick.css" rel="stylesheet" />
    <link href="<?= $themUrl?>/css/mobile/css/style.css" rel="stylesheet" />
    <link href="<?= $themUrl?>/css/mobile/css/sonfix.css?v=<?= $vs ?>" rel="stylesheet" />   
    <!-- Modernizr -->
</head>
<body>
    <div class="mobile">
<!--header-->
<?php $this->renderPartial('//layouts/partial/header'); ?>
<!--End header -->


<div id="main">
    <?php echo $content; ?>
</div>
<!--<div id="collection">-->
<!--<div class="container">-->
<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK3)); ?>
<!--</div>-->
<!--</div>-->

<?php $this->renderPartial('//layouts/partial/footer'); ?>
</div>
<div class="loading-shoppingcart"
     style="height: 40px;width: 40px;position: fixed;top: 0;left: 0;right: 0;bottom: 0;margin: auto">
    <img src="<?= $themUrl, '/css/img/loading.gif'; ?>">
</div>
<div class="scroll-top-btn" id="bttop">
    <a title="Về đầu trang">
            <span>
            </span>
    </a>
</div>
<script src="<?= $themUrl?>/owlcarousel/owl.carousel.min.js"> </script>
<script src="<?= $themUrl?>/css/mobile/js/slick.js"></script>
    <script type="text/javascript">
        $('.slider_m').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            arrows:false,
            infinite: true,
            speed: 1500,
            autoplay:true,
                autoplaySpeed:3000,
            // fade: true,
            cssEase: 'linear'
        });
        $('.menu_car').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            dots:false,
            infinite: false,
            responsive: [
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1920,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }
            ]
        });

    </script>
    <script type="text/javascript" src="<?= $themUrl?>/css/mobile/js/script.js?v=1.1.0"></script>
<div class="script">
    <script type="text/javascript">
        (function ($) {
            $.fn.clickToggle = function (func1, func2) {
                var funcs = [func1, func2];
                this.data('toggleclicked', 0);
                this.click(function () {
                    var data = $(this).data();
                    var tc = data.toggleclicked;
                    $.proxy(funcs[tc], this)();
                    data.toggleclicked = (tc + 1) % 2;
                });
                return this;
            };
        }(jQuery));
        $(document).ready(function () {
            $('.loading-shoppingcart').hide();
            $('.dropdown-toggle').clickToggle(function () {
                $(this).next().css('display', 'block');
            }, function () {
                $(this).next().css('display', 'none');
            });
        });
        goog_snippet_vars = function () {
            var w = window;
            w.google_conversion_id = 12345678;
            w.google_conversion_label = "abcDeFGHIJklmN0PQ";
            w.google_conversion_value = 13.00;
            w.google_conversion_currency = "USD";
            w.google_remarketing_only = false;
        }
        goog_report_conversion = function (url) {
            goog_snippet_vars();
            window.google_conversion_format = "3";
            var opt = new Object();
            opt.onload_callback = function () {
                if (typeof(url) != 'undefined') {
                    window.location = url;
                }
            }
            var conv_handler = window['google_trackConversion'];
            if (typeof(conv_handler) == 'function') {
                conv_handler(opt);
            }
        }
    </script>
    <script>
        $(function () {
            $(".button-nav").click(function () {
                if ($(".button-nav").hasClass("open") == false) {
                    $(".button-nav").addClass("open")
                } else {
                    $(".button-nav").removeClass("open")
                }

            })
            $(".button-nav").click(function () {
                if ($(".black-drop").hasClass("open") == false) {
                    $(".black-drop").addClass("open")
                } else {
                    $(".black-drop").removeClass("open")
                }

            })
            $(".black-drop").click(function () {
                if ($(".button-nav").hasClass("open") == false) {
                    $(".button-nav").addClass("open")
                } else {
                    $(".button-nav").removeClass("open")
                }

            })
            $(".black-drop").click(function () {
                if ($(".black-drop").hasClass("open") == false) {
                    $(".black-drop").addClass("open")
                } else {
                    $(".black-drop").removeClass("open")
                }

            })
            $(".button-nav").click(function () {
                $(this).parent().find(".box-nav").slideToggle('slow')
            })
            $(".black-drop").click(function () {
                $(this).parent().find(".box-nav").slideToggle('slow')
            })
            $(".infoother").click(function () {
                $(this).parent().find(".subother").slideToggle('slow')
            })

        });
    </script>
    <script>
        $(document).ready(function () {
            var owl = $("#owl-demo,#owl-demo-album");
            owl.owlCarousel({
                itemsCustom: [
                    [0, 1],
                    [320, 2],
                    [768, 4],
                ],
                navigation: true,
                autoPlay: true,
            });
        });
    </script>
    <script>
        $('.scroll-top-btn').click(function () {
            // window.animate({scrollTop: '-='+window.scrollY+'px'}, 800);
            animateScrollTop(0, 400);
        });

        function animateScrollTop(target, duration) {
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
                                    animateScrollTop(target);
                                }, 16);
                            }
                        }
                    }
                );
            }
        }
    </script>
        <script>
            $(document).ready(function () {
                "use strict";
                // creat menu sidebar
                $(".menu-bar-lv-1").each(function () {
                    $(this).find(".span-lv-1").click(function () {
                        $(this).toggleClass('rotate-menu');
                        $(this).parent().find(".menu-bar-lv-2").toggle(500);
                    });
                });
                $(".menu-bar-lv-2").each(function () {
                    $(this).find(".span-lv-2").click(function () {
                        $(this).toggleClass('rotate-menu');
                        $(this).parent().find(".menu-bar-lv-3").toggle(500);
                    });
                });
                              // end
            });
        </script>
<script type="text/javascript">
        $(document).ready(function(){
            $(".show_mobile").click(function(){
                $(this).toggleClass("open");
            });
            if($('.menu_mb').height()>$(window).height()){
                $(".menu_mb").height($('.menu_mb').height());
            }
            $(".menu_mb .img .fa-sort-desc").each(function(){
                $(this).click(function(){
                    $(this).toggleClass('active');
                    $(this).siblings("ul").slideToggle();
                });
            });
            $(".show_mobile").click(function(){
                $(".menu_mb").slideToggle();
            })
        });
    </script>
    <script type="text/javascript" src="<?= $themUrl?>/css/mobile/js/sonfix.js"></script>
</div>
</body>
</html>


