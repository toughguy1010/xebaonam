<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="vi">
<head>
    <?php 
        $site_info = Yii::app()->siteinfo;
    ?>
    <meta charset="utf-8"/>
    <meta content="width=device-width" name="viewport"/>
    
    <title><?= $this->pageTitle; ?></title>
    <?php
    $themUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
    $vs = '1.5.3';
    ?>
    <meta property="og:image" content="<?= $site_info['site_watermark'] ?>" />
    <!-- The Stylesheet -->
    <link rel="stylesheet" href="<?= $themUrl ?>/css/font-awesome.css"/>
    <link href="<?= $themUrl ?>/css/owl.theme.default.min.css" rel="stylesheet">
    <link href='<?= $themUrl ?>/css/owl.carousel.min.css?v=1.0.0' rel='stylesheet'  type='text/css'/>
    
    <link href='<?= $themUrl ?>/css/xedien.css?v=<?= $vs ?>' rel="stylesheet" />
    <!-- <script src="<?= $themUrl ?>/js/jquery-1.10.2.js" type="text/javascript"></script> -->
    <link href='<?php echo $themUrl ?>/css/style1.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>
    <script src="<?= $themUrl ?>/js/owl.carousel.min.js" type="text/javascript"></script>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/ow/owl.theme.default.min.css">

    <script src="<?php echo $themUrl ?>/css/home/css/ow/owl.carousel.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/style.css?v=<?=$vs?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/fix.css?v=<?=$vs?>">
    <link href='<?= $themUrl ?>/css/fix.css?v=<?= $vs ?>' rel='stylesheet'  type='text/css'/>
</head>
<body>
    <!--header-->
    <?php $this->renderPartial('//layouts/partial/header'); ?>
    <!--End header -->
    <?= $content; ?>

    <?php $this->renderPartial('//layouts/partial/footer'); ?>
    <script src='<?= $themUrl ?>/js/fix.js?v=<?= $vs ?>' type="text/javascript"></script>
    <script type="text/javascript" src="<?= $themUrl ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $themUrl ?>/js/home/js/wow.min.js"></script>    
    <script type="text/javascript">
        new WOW().init();
    </script> 
    <script src="<?php echo $themUrl ?>/js/home/js/slick.min.js"></script>
    <?php
    $t = Yii::app()->request->getParam('t', 0);
    if($t == 0) {
        ?>
        <script type="text/javascript">
            $(document).ready(function(){           

                var code="";
                $i=0;
                if (!$('.mwtitle').length){
                    $(".main_v .list_product_category").each(function(index){
                        if((index)%2){

                            code+="<div class='list_product_category'>"+$(this).html()+"</div>";
                        }else{

                         $(".main_v .banner_qc").each(function(indexs){
                            if(indexs==$i){
                             code+="<div class='banner_qc'>"+$(this).html()+"</div>";
                         }

                     });
                         code+="<div class='list_product_category'>"+$(this).html()+"</div>";
                         $i++;
                     }
                 });
                    $(".main_v .content_p").html(code);
                }
                
                

                $('.slider_product').owlCarousel({
                    items: 4,
                    margin:0,
                    nav:true,
                    dots:false,
                    autoplay:true,
                    autoplayTimeout:4000,
                    smartSpeed:1000,
                    navText: ["<i class='fa fa-caret-left' aria-hidden='true'></i>","<i class='fa fa-caret-right' aria-hidden='true'></i>"],
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
                        }
                    }
                });
                $('.big_albums').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '.slider-nav',
                // autoplay:true,
                // autoplaySpeed:5000,
                });
                
                $('.small_albums').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '.slider-for',
                    dots: false,
                    arrow:false,
                    focusOnSelect: true,
                    responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }

                    ]
                });

            });
            $('#owl-demo2').owlCarousel({
                items:4,
                autoplay:true,
                autoplayTimeout:6000,
                autoplaySpeed:2000,
                loop:true,
                margin:20,
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
        </script>
    <?php } ?>
    <script>
        $("#newstablink").click(function(){
            $( "#newstablink" ).attr( "class", "show1" );
            $( "#newstab" ).attr( "class", "show" );
            $( "#pageface" ).attr( "class", "hide" );
            $( "#pagefacelink" ).attr( "class", "hide1" );
            $( "#galalink" ).attr( "class", "hide1" );
            $( "#gala" ).attr( "class", "hide" );
        })
        $("#pagefacelink").click(function(){
            $( "#newstablink" ).attr( "class", "hide1" );
            $( "#newstab" ).attr( "class", "hide" );
            $( "#galalink" ).attr( "class", "hide1" );
            $( "#gala" ).attr( "class", "hide" );
            $( "#pagefacelink" ).attr( "class", "show1" );
            $( "#pageface" ).attr( "class", "show" );
        })
        $("#galalink").click(function(){
            $( "#galalink" ).attr( "class", "show1" );
            $( "#gala" ).attr( "class", "show1" );
            $( "#newstablink" ).attr( "class", "hide1" );
            $( "#newstab" ).attr( "class", "hide" );
            $( "#pagefacelink" ).attr( "class", "hide1" );
            $( "#pageface" ).attr( "class", "hide" );
        })
    </script>
    <script type="text/javascript">
        $('.slider_product').owlCarousel({
            items: 4,
            margin:0,
            nav:true,
            dots:false,
            autoplay:true,
            autoplayTimeout:4000,
            smartSpeed:1000,
            navText: ["<i class='fa fa-caret-left' aria-hidden='true'></i>","<i class='fa fa-caret-right' aria-hidden='true'></i>"],
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
                }
            }
        });
        $(document).ready(function() {

            var sync1 = $("#sync11");
            var sync2 = $("#sync21");
  var slidesPerPage = 4; //globaly define number of elements per page
  var syncedSecondary = true;

  sync1.owlCarousel({
    items : 1,
    slideSpeed : 2000,
    nav: false,
    autoplay: true,
    dots: false,
    loop: true,
    responsiveRefreshRate : 200,
    
}).on('changed.owl.carousel', syncPosition);

  sync2
  .on('initialized.owl.carousel', function () {
    sync2.find(".owl-item").eq(0).addClass("current");
})
  .owlCarousel({
    items : slidesPerPage,
    dots: true,
    nav: true,
    smartSpeed: 200,
    slideSpeed : 500,
    slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
    responsiveRefreshRate : 100
}).on('changed.owl.carousel', syncPosition2);

  function syncPosition(el) {
    //if you set loop to false, you have to restore this next line
    //var current = el.item.index;
    
    //if you disable loop you have to comment this block
    var count = el.item.count-1;
    var current = Math.round(el.item.index - (el.item.count/2) - .5);
    
    if(current < 0) {
        current = count;
    }
    if(current > count) {
        current = 0;
    }
    
    //end block

    sync2
    .find(".owl-item")
    .removeClass("current")
    .eq(current)
    .addClass("current");
    var onscreen = sync2.find('.owl-item.active').length - 1;
    var start = sync2.find('.owl-item.active').first().index();
    var end = sync2.find('.owl-item.active').last().index();
    
    if (current > end) {
        sync2.data('owl.carousel').to(current, 100, true);
    }
    if (current < start) {
        sync2.data('owl.carousel').to(current - onscreen, 100, true);
    }
}

function syncPosition2(el) {
    if(syncedSecondary) {
        var number = el.item.index;
        sync1.data('owl.carousel').to(number, 100, true);
    }
}

sync2.on("click", ".owl-item", function(e){
    e.preventDefault();
    var number = $(this).index();
    sync1.data('owl.carousel').to(number, 300, true);
});
});
</script>
</body>
</html>
