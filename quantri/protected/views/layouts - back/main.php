<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- ===================== MASTER CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet">
        <!-- ===================== ICONS CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css">
        <!-- fonts -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace-fonts.css" />
        <!-- ===================== JQUERY UI CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jui/jquery.ui.min.css">
        <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ace-skins.min.css" />

        <!-- ===================== MAIN JS ===================== -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ace-extra.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
        <base href="<?php echo Yii::app()->getBaseUrl(true) . '/'; ?>"/>
    </head>

    <body class="body5">
        <div id="wrapper" class="boxed">
            <div id="wrapper-inner" class="pattern7">
                <div id="main-header">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="title">
                                    <h1>Admin</h1>
                                </div>
                                <!-- Start Header Panel -->
                                <div class="header-panel">
                                    <div title="" data-placement="left" rel="tooltip" class="dropdown" id="dropdown-patterns" data-original-title="Theme Setting">
                                        <a data-toggle="dropdown" class="menu dropdown-toggle" href="#"><i class="icon iconfa-cog"></i></a>
                                        <div role="menu" class="dropdown-menu pull-right">
                                            <div class="title">Inner Content Pattern</div>
                                            <ul class="patterns">
                                                <li data-menu="wrapperpattern" class="pattern1"></li>
                                                <li data-menu="wrapperpattern" class="pattern2"></li>
                                                <li data-menu="wrapperpattern" class="pattern3"></li>
                                                <li data-menu="wrapperpattern" class="pattern4"></li>
                                                <li data-menu="wrapperpattern" class="pattern5"></li>
                                                <li data-menu="wrapperpattern" class="pattern6"></li>
                                                <li data-menu="wrapperpattern" class="pattern7"></li>
                                                <li data-menu="wrapperpattern" class="pattern8"></li>
                                            </ul>
                                            <hr>
                                            <div class="title">UtopiaAdmin Layout</div>
                                            <div data-toggle="buttons-radio" class="btn-group">
                                                <button data-layout="default" class="btn btn-small">Default</button>
                                                <button data-layout="boxed" class="btn btn-small active">Boxed</button>
                                                <button data-layout="fixed" class="btn btn-small">Fixed</button>
                                            </div>
                                            <ul style="margin-top:10px" class="patterns">
                                                <li data-menu="bodypattern" class="body1"></li>
                                                <li data-menu="bodypattern" class="body2"></li>
                                                <li data-menu="bodypattern" class="body3"></li>
                                                <li data-menu="bodypattern" class="body4"></li>
                                                <li data-menu="bodypattern" class="body5"></li>
                                                <li data-menu="bodypattern" class="body6"></li>
                                            </ul>
                                            <hr>
                                            <div class="title">UtopiaAdmin Menu Type</div>
                                            <div data-toggle="buttons-radio" class="btn-group">
                                                <button data-menustyle="fancy" class="btn btn-small active">Fancy</button>
                                                <button data-menustyle="simple" class="btn btn-small">Simple</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown" id="dropdown-search">
                                        <a data-toggle="dropdown" class="menu dropdown-toggle" href="#"><i class="icon iconfa-search"></i></a>
                                        <div role="menu" class="dropdown-menu pull-right">
                                            <form>
                                                <input type="text" placeholder="Enter keyword..." class="span12" name="search">
                                            </form>
                                        </div>
                                    </div>
                                    <a data-menu="mobile" id="menu-phone" class="menu" href="#"><i class="icon iconfa-tasks"></i></a>
                                </div>
                                <!-- End Header Panel -->
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $this->widget('LeftLayout');
                ?>
                <div id="main-content">
                    <div class="row-fluid">
                        <span class="span12">
                            <?php echo $content; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/typeahead-bs2.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.touch-punch.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.slimscroll.min.js"></script>

        <!--[if lte IE 8]>
          <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excanvas.min.js"></script>
        <![endif]-->

<!--        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.dashboard.js"></script>-->
    </body>
</html>