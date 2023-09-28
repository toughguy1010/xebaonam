<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed');
        } catch (e) {
        }
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left" style="height: 45px;">
            <a href="<?php echo Yii::app()->homeUrl; ?>" class="navbar-brand">
                <small>Trang quản lý tiếp thị liên kết</small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->
        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <?php
                $current = time();
                $expiryDate = (int) Yii::app()->siteinfo['expiration_date'];
                $compare = $current + (Yii::app()->params['trial_date'] - 1) * 86400;
                if ($expiryDate && $expiryDate < $compare && $expiryDate > $current) {
                    $dateCount = ceil(($expiryDate - $current) / 86400);
                    ?>
                    <li class="red">
                        <a href="javascript:void(0)">
                            <i class="icon-lock"></i>
                            <span>
                                <?php
                                echo Yii::t('site', 'note_expiry_date', array('{dateCount}' => $dateCount));
                                ?>
                            </span>
                        </a>
                    </li>
                <?php } ?>
                <li class="green">
                    <a href="<?php echo 'http://' . Yii::app()->siteinfo['domain_default']; ?>">
                        <i class="icon-globe"></i>
                        <span>
                            <?php
                            echo Yii::t('shop', 'back') . ' trang chủ';
                            ?>
                        </span>
                    </a>
                </li>
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
                            <a href="<?php echo Yii::app()->createUrl('/profile/profile/changepassword'); ?>">
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.dropdown-toggle').click(function () {
            if ($(this).parent('.light-blue').hasClass('open')) {
                $(this).parent('.light-blue').removeClass('open');
            } else {
                $(this).parent('.light-blue').addClass('open');
            }
        });
    });
</script>