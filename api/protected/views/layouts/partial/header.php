<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed');
        } catch (e) {}
    </script>
    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="<?php echo Yii::app()->homeUrl; ?>" class="navbar-brand">
                <small>Quản lý affilliate</small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->
        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <i class="icon-user"></i>
                        <span class="user-info">
                            <?php
                            echo Yii::app()->user->name;
                            ?>
                        </span>

                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate/changepass'); ?>">
                                <i class="icon-key"></i>
                                <?php echo Yii::t('common', 'change_paswd'); ?>
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo Yii::app()->createUrl('/login/login/logout'); ?>">
                                <i class="icon-off"></i>
                                <?php
                                echo Yii::t('common', 'logout');
                                ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul><!-- /.ace-nav -->
        </div><!-- /.navbar-header -->
    </div><!-- /.container -->
</div>