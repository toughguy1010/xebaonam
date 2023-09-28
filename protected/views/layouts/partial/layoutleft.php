<style type="text/css">
    .nav-list li.active>a:after{
        border-width: 0px;
    }
</style>
<div id="sidebar" class="sidebar">
    <div id="sidebar-shortcuts" class="sidebar-shortcuts">
        &nbsp;
    </div><!-- #sidebar-shortcuts -->
    <?php
    $current_shop = Shop::getCurrentShop();
    ?>
    <ul class="nav nav-list">
        <?php if ($current_shop && $current_shop['status'] == ActiveRecord::STATUS_ACTIVED) { ?>
            <li class="<?php if (Yii::app()->controller->id == 'productManager' && Yii::app()->controller->action->id == 'create') echo 'active'; ?>">
                <a href="<?php echo Yii::app()->createUrl('/economy/productManager/create') ?>">
                    <i class="icon-double-angle-right"></i>
                    <?php echo Yii::t('product', 'product_create') ?>
                </a>
            </li>
            <li class="<?php if (Yii::app()->controller->id == 'productManager' && Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
                <a href="<?php echo Yii::app()->createUrl('/economy/productManager/') ?>">
                    <i class="icon-double-angle-right"></i>
                    <?php echo Yii::t('product', 'product_manager') ?>
                </a>
            </li>
        <?php } ?>
        <?php
        if (!$current_shop) {
            ?>
            <li class="<?php if (Yii::app()->controller->id == 'shop' && Yii::app()->controller->action->id == 'create') echo 'active'; ?>">
                <a href="<?php echo Yii::app()->createUrl('/economy/shop/create') ?>">
                    <i class="icon-double-angle-right"></i>
                    <?php echo Yii::t('shop', 'create'); ?>
                </a>
            </li>
        <?php } else { ?>
            <li class="<?php if (Yii::app()->controller->id == 'shop' && Yii::app()->controller->action->id == 'customerLike') echo 'active'; ?>">
                <a href="<?php echo Yii::app()->createUrl('/economy/shop/customerLike', array('id' => $current_shop['id'])) ?>">
                    <i class="icon-double-angle-right"></i>
                    <?php echo Yii::t('shop', 'manager_customer_like'); ?>
                </a>
            </li>
            <li class="<?php if (Yii::app()->controller->id == 'shop' && Yii::app()->controller->action->id == 'update') echo 'active'; ?>">
                <a href="<?php echo Yii::app()->createUrl('/economy/shop/update', array('id' => $current_shop['id'])) ?>">
                    <i class="icon-double-angle-right"></i>
                    <?php echo Yii::t('shop', 'shop_info'); ?>
                </a>
            </li>
        <?php } ?>
        <li class="<?php if (Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/profile/profile/') ?>">
                <i class="icon-double-angle-right"></i>
                <?php echo Yii::t('user', 'user_profile') ?>
            </a>
        </li>
        <li class="<?php if (Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'likedShop') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/profile/profile/likedShop') ?>">
                <i class="icon-double-angle-right"></i>
                <?php echo Yii::t('shop', 'liked_shop') ?>
            </a>
        </li>
        <li class="<?php if (Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'likedProduct') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/profile/profile/likedProduct') ?>">
                <i class="icon-double-angle-right"></i>
                <?php echo Yii::t('product', 'liked_product') ?>
            </a>
        </li>
        <li class="<?php if (Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'changepassword') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('profile/profile/changepassword') ?>">
                <i class="icon-double-angle-right"></i>
                <?php echo Yii::t('common', 'user_changepassword'); ?>
            </a>
        </li>

    </ul><!-- /.nav-list -->

    <div id="sidebar-collapse" class="sidebar-collapse">
        <i data-icon2="icon-double-angle-right" data-icon1="icon-double-angle-left" class="icon-double-angle-left"></i>
    </div>
</div>