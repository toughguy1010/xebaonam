<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml" lang="vi">
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- ===================== MASTER CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
        <!-- ===================== ICONS CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css" />
        <!-- fonts -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace-fonts.css" />
        <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace-skins.min.css" />
        <!-- CUSTOMER CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet" />   
        <!-- ===================== MAIN JS =====================-->
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ace-extra.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
        <script>
            var baseUrl = "<?php echo Yii::app()->getBaseUrl(true); ?>";
        </script>
        <base href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>"/>
    </head>
    <body class="login-layout">
        <?php $this->widget('Flashes'); ?>
        <div id="main-container" class="main-container">
            <?php
                echo $content;
            ?>
        </div><!-- /.main-container -->
        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>

        <script type="text/javascript">
            function show_box(id) {
                jQuery('.widget-box.visible').removeClass('visible');
                jQuery('#' + id).addClass('visible');
            }
        </script>
    </body>
</html>