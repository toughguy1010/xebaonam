<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- ===================== MASTER CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jasny-bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet">   
        <!-- ===================== ICONS CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/icon/fugue.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/icon/elusive.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/icon/font-awesome.min.css">
        <!-- ===================== SITE CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/default.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/default.responsive.min.css">

        <!-- ===================== PLUGINS CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/uniform.default.css">

        <!-- ===================== JQUERY UI CSS ===================== -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jui/jquery.ui.min.css">

        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"></script>
    </head>

    <body class="body5">
        <?php
        $this->widget('Flashes', array(
        ));
        ?>
        <div id="overlay"></div>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="<?php echo Yii::app()->createUrl('/site/index'); ?>">Home</a></li>
                            <?php if (!Yii::app()->user->isGuest): ?>
                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle" data-toggle="dropdown">Oppotunities Details<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?= Yii::app()->createUrl('/opportunity/details/'); ?>">List Oppotunities</a></li>
                                        <li><a href="<?= Yii::app()->createUrl('//opportunity/details/create'); ?>">Add new Oppotunitie</a></li>
                                    </ul>
                                </li>

                            <?php else: ?>
                                <li><a href="<?php echo Yii::app()->createUrl('login/reset/reset'); ?>">Forget password</a></li>
                            <?php endif; ?> 
                        </ul>
                        <div style="float: right;">
                            <?php if (Yii::app()->user->isGuest) {
                                ?>
                                <!-- Button to trigger modal -->
                                <a class="btn" href="<?php echo Yii::app()->createUrl('login/login/login'); ?>">Login</a>

                                <?php
                            } else {

                                echo CHtml::link('Logout', Yii::app()->createUrl('login/login/logout'), array(
                                    'class' => 'btn btn-primary'
                                ));
                            }
                            ?>
                        </div>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">

            <div class='wrapper'>

                <div class='wrapper-content '>
                    <?php echo $content; ?>
                    <div style="clear:both"></div>
                </div>

            </div>

        </div> <!-- /container -->

        <script src="js/vendors/modernizr-2.6.2.min.js"></script>
        <!--         Flot Plugins 
            <script src="js/plugins/flot/jquery.flot.js"></script>
            <script src="js/plugins/flot/jquery.flot.pie.js"></script>
            <script src="js/plugins/flot/jquery.flot.categories.js"></script>
            <script src="js/plugins/flot/jquery.flot.stack.js"></script>
            <script src="js/plugins/flot/jquery.flot.tooltip.js"></script>
            <script src="js/plugins/flot/jquery.flot.resize.js"></script>-->

        <!-- Plugins -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jasny-bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/jquery.sparkline.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/jquery.responsivetables.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/jquery.datatables.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/jquery.datatables.extend.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/jquery.uniform.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/jquery.placeholder.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.dashboard.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/application.js"></script>
    </body>
</html>