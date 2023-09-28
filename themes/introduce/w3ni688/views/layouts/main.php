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
    $vs = '1.6.9';
    ?>
    <!-- The Stylesheet -->

    <link href='<?php echo $themUrl ?>/css/threesixty.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>

    <link href='<?php echo $themUrl ?>/css/font-awesome.min.css' rel='stylesheet' type='text/css'/>
    <link href='<?php echo $themUrl ?>/css/multi-row-grid.css' rel='stylesheet' type='text/css'/>
    <link href='<?php echo $themUrl ?>/css/jquery.mCustomScrollbar.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>
    <link href='<?php echo $themUrl ?>/css/owl.carousel.min.css?v=1.0.0' rel='stylesheet' type='text/css'/>
    <link href='<?php echo $themUrl ?>/css/xedien.css?v=<?= $vs ?>' rel="stylesheet"/>
    <link href='<?php echo $themUrl ?>/css/style.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>
    <link href='<?php echo $themUrl ?>/css/style1.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>

    <link href='<?php echo $themUrl ?>/css/customer.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>
    <link href='<?php echo $themUrl ?>/css/customers.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=latin-ext,vietnamese"
          rel="stylesheet">

    <!-- plugin -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,700" rel="stylesheet">

    <script src="<?php echo $themUrl ?>/css/home/css/ow/owl.carousel.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/style.css?v=<?= $vs ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/home/css/fix.css?v=<?= $vs ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/fix-21-12.css?v=<?= $vs ?>">
</head>
<body>
<!--header-->
<?php $this->renderPartial('//layouts/partial/header'); ?>
<!--End header -->
<div id="main">
    <?php echo $content; ?>
</div>

<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK3)); ?>
<script type="text/javascript" src="<?= $themUrl ?>/js/jquery.lazy.min.js"></script>
<?php $this->renderPartial('//layouts/partial/footer'); ?>
<script type="text/javascript" src="<?= $themUrl ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $themUrl ?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
<!--<script type="text/javascript" src="<?= $themUrl ?>/js/threesixty.js"></script>-->
<script src="<?php echo $themUrl ?>/js/owl.carousel.min.js" type="text/javascript"></script>
<script src="<?php echo $themUrl ?>/js/b71b0b5300.js" type="text/javascript"></script>
<script src="<?php echo $themUrl ?>/js/fix.js?v=<?= $vs ?>" type="text/javascript"></script>
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
</script>
<script>
    function change_image_hatv(thisTag) {
        var a = $(thisTag);
        var img_link = a.attr('img-link');
        a.parent().parent().parent().parent().find('.box-img.img-bike img').attr('src', img_link);
    }
    ;
</script>


</body>
</html>


