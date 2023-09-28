<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width" name="viewport"/>
	<title><?= $this->pageTitle; ?></title>
	<?php
	$themUrl = Yii::app()->theme->baseUrl;
	$cs = Yii::app()->getClientScript();
	Yii::app()->clientScript->registerCoreScript('jquery');
	$vs = '1.3.3';
	?>
	<!-- Font chu -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=latin-ext,vietnamese" rel="stylesheet">
	<meta charset="utf-8" >
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- plugin -->

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/plugin.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/ow/owl.theme.default.min.css">

	<script src="<?php echo $themUrl ?>/css/home/css/ow/owl.carousel.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/slick-theme.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/slick.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/style.css?v=<?=$vs?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/fix.css?v=<?=$vs?>">
</head>
<body>

	<?php $this->renderPartial('//layouts/partial/header_new'); ?>
	
<div id="main">		
    <?php echo $content; ?>
</div>

	<?php $this->renderPartial('//layouts/partial/footer_new'); ?>
	<script src="<?php echo $themUrl ?>/js/home/js/wow.min.js"></script>    
	<script type="text/javascript">
		new WOW().init();
	</script> 
	<script src="<?php echo $themUrl ?>/js/home/js/slick.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){			
			$('.big_album').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				fade: true,
				asNavFor: '.slider-nav',
				autoplay:true,
				autoplaySpeed:5000,
			});
			$('.small_album').slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				asNavFor: '.slider-for',
				dots: false,
				arrow:false,
				focusOnSelect: true,
				responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 4,
						slidesToScroll: 4,
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
			$('.big_albums').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				fade: true,
				asNavFor: '.slider-nav',
				autoplay:true,
				autoplaySpeed:5000,
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
	</script>
</body>	
</html>
