<!doctype html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Trang chủ</title>
        <!-- Style CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/shoppingcart/product.css" media="screen, projection" />
        <!-- Javascript -->
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    </head>
    <body class="home">
        <?= $content ?>
    </body>
</html>