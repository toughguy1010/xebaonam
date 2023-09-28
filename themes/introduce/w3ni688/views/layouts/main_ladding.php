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
        $vs = '1.2.0';
    ?>
    <!-- The Stylesheet -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=latin-ext,vietnamese" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= $themUrl ?>/css/plugin.css">
	<link rel="stylesheet" type="text/css" href="<?= $themUrl ?>/css/ow/owl.theme.default.min.css">
<script type="text/javascript" src="<?php echo $themUrl ?>/js/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/js/jquery.fancybox.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?= $themUrl ?>/css/one.css?v=<?= $vs?>">

</head>
<body>
<!--header-->
<?php $this->renderPartial('//layouts/partial/header_ladding'); ?>
<!--End header -->
<div id="main">
    <?php echo $content; ?>
</div>


<?php $this->renderPartial('//layouts/partial/footer_ladding'); ?>


<script src="<?= $themUrl ?>/js/wow.min.js"></script>    
	<script src="<?= $themUrl ?>/js/main_t.js"></script>
	<script type="text/javascript">
		new WOW().init();
	</script> 


</body>
</html>


