<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="vi">
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
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace.min.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace-skins.min.css" />
    <!-- CUSTOMER CSS -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bookly.css" />
    <!-- ===================== MAIN JS =====================-->
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ace-extra.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js?ver=<?php echo VERSION; ?>"></script>
    <script>
        var baseUrl = "<?php echo Yii::app()->getBaseUrl(true); ?>";
    </script>
    <base href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>" />
</head>

<body>
    <?php $this->widget('Flashes'); ?>
    <?php
    $this->renderPartial('application.views.layouts.partial.header');
    ?>
    <div id="main-container" class="main-container">
        <div class="main-container-inner">
            <?php
            if (!Yii::app()->user->isGuest) {
                $this->widget('LeftLayout');
            }
            ?>
            <div class="main-content">
                <?php
                if (!Yii::app()->user->isGuest) {
                    $this->widget('application.widgets.adminbreadcrumb.adminbreadcrumb');
                }
                ?>
                <div class="page-content">
                    <?php
                    echo $content;
                    ?>
                </div>
            </div>
        </div>
    </div><!-- /.main-container -->
    <div id="mainModal" class="modal hide fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header clearfix">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4></h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        if ("ontouchend" in document) {
            document.write("<script src='<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        }
        jQuery(document).ready(function() {
            jQuery('form').areYouSure();
        });
    </script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.slimscroll.min.js"></script>
    <!-- ace scripts -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ace-elements.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ace.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootbox.min.js"></script>
</body>

</html>