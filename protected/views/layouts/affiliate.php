<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml" lang="vi">
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- ===================== MASTER CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace/bootstrap.min.css" />
        <!-- ===================== ICONS CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace/font-awesome.min.css" />
        <!-- fonts -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace/ace-fonts.css" />
        <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace/ace.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace/ace-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace/ace-skins.min.css" />
        <!-- CUSTOMER CSS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace/main.css" rel="stylesheet" />   
        <!-- ===================== MAIN JS =====================-->
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ace/ace-extra.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
        <script>
            var baseUrl = "<?php echo Yii::app()->getBaseUrl(true); ?>";
        </script>
        <base href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>"/>
    </head>
    <body>
        <?php $this->widget('Flashes'); ?>
        <?php
        $this->renderPartial('application.views.layouts.partial_affiliate.header');
        ?>
        <div id="main-container" class="main-container">
            <div class="main-container-inner">
                <?php
                $this->renderPartial('application.views.layouts.partial_affiliate.layoutleft');
                ?>
                <div class="main-content">
                    <?php
                    $this->widget('application.widgets.adminbreadcrumb.adminbreadcrumb');
                    ?>
                    <div class="page-content">
                        <?php
                        echo $content;
                        ?>
                    </div>
                </div>
            </div>
        </div><!-- /.main-container -->
        <script type="text/javascript">
            if ("ontouchend" in document) {
                document.write("<script src='<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
            }
        </script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ace/jquery.slimscroll.min.js"></script>
        <!-- ace scripts -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ace/ace-elements.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ace/ace.min.js"></script>
    </body>
</html>