<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed');
        } catch (e) {
        }
    </script>
    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="<?php echo Yii::app()->homeUrl; ?>" class="navbar-brand">
                <small>
                    <?php
                    echo Yii::t('common', 'adminpanel');
                    if(ClaUser::isSupperAdmin()){
                        echo ' ('.Yii::app()->controller->site_id.')';
                    }
                    ?>
                </small>
            </a><!-- /.brand -->
            <div class="pull-left">
                <?php
                $this->widget('application.widgets.languages.languages');
                ?>
            </div>
        </div><!-- /.navbar-header -->
        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <?php
                $current = time();
                $siteAdmin = ClaSite::getSiteAdminInfo();
                $expiryDate = (int) $siteAdmin['expiration_date'];
                $compare = $current + (Yii::app()->params['trial_date'] - 1) * 86400*4; // 2 thang thi hien thi ra
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
                <?php
                $num_rating = ProductRating::countRatingNewInSite();
                $num_rating_new = CommentRating::countRatingNewInSite();
                if ($num_rating > 0) {
                    ?>
                    <li class="gray">
                        <a href="<?php echo Yii::app()->createUrl('economy/commentrating') ?>">
                            <i class="icon-star"></i>
                            <span>
                                <?php
                                echo Yii::t('site', 'rating'), ' (', $num_rating, ')';
                                ?>
                            </span>
                        </a>
                    </li>
                <?php }
                if ($num_rating_new > 0) {
                ?>
                <li class="gray">
                    <a href="<?php echo Yii::app()->createUrl('economy/commentratingNew') ?>">
                        <i class="icon-star"></i>
                        <span>
                                <?php
                                echo Yii::t('site', 'rating'), ' (', $num_rating_new, ')';
                                ?>
                            </span>
                    </a>
                </li>
                <?php } ?>

                <?php
                $num_comment = Comment::countCommentNewInSite(Comment::COMMENT_PRODUCT);
                if ($num_comment > 0) {
                    ?>
                    <li class="gray">
                        <a href="<?php echo Yii::app()->createUrl('economy/comment') ?>">
                            <i class="icon-comments"></i>
                            <span>
                                <?php
                                echo Yii::t('site', 'new_comment'), ' (', $num_comment, ')';
                                ?>
                            </span>
                        </a>
                    </li>
                <?php } ?>
                <?php
                $num_installment = InstallmentOrder::getCountOrder();
                if ($num_installment > 0) {
                    ?>
                    <li class="gray">
                        <a href="<?php echo Yii::app()->createUrl('installment/order') ?>">
                            <i class="icon-credit-card"></i>
                            <span>
                                <?php
                                echo Yii::t('installment', 'order_installment'), ' (', $num_installment, ')';
                                ?>
                            </span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $num_order = Orders::getCountOrder();
                if ($num_order > 0) {
                    ?>
                    <li class="gray">
                        <a href="<?php echo Yii::app()->createUrl('economy/order') ?>">
                            <i class="icon-shopping-cart"></i>
                            <span>
                                <?php
                                echo Yii::t('site', 'order_process'), ' (', $num_order, ')';
                                ?>
                            </span>
                        </a>
                    </li>
                <?php } ?>
                <li class="green">
                    <a href="<?php echo 'http://' . Yii::app()->siteinfo['domain_default']; ?>" target="_blank">
                        <i class="icon-globe"></i>
                        <span>
                            <?php
                            echo Yii::t('common', 'fontend');
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
                            <a href="<?php echo Yii::app()->createUrl('/useradmin/useradmin/changepass'); ?>">
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