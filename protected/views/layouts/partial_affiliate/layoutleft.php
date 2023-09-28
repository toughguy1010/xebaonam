<style type="text/css">
    .nav-list li.active>a:after{
        border-width: 0px;
    }
</style>
<div id="sidebar" class="sidebar">
    <div id="sidebar-shortcuts" class="sidebar-shortcuts">
        &nbsp;
    </div><!-- #sidebar-shortcuts -->
    
    <ul class="nav nav-list">
        
        <li class="<?php if (Yii::app()->controller->id == 'affiliate' && Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/affiliate/affiliate/index') ?>">
                <i class="icon-double-angle-right"></i>
                Tổng quát
            </a>
        </li>

        <li class="<?php if (Yii::app()->controller->id == 'affiliateLink' && Yii::app()->controller->action->id == 'create') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/affiliate/affiliateLink/listProduct') ?>">
                <i class="icon-double-angle-right"></i>
                <?php echo Yii::t('affiliate', 'create_link') ?>
            </a>
        </li>

        <li class="<?php if (Yii::app()->controller->id == 'affiliateLink' && Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/affiliate/affiliateLink/index') ?>">
                <i class="icon-double-angle-right"></i>
                <?php echo Yii::t('affiliate', 'link_created') ?>
            </a>
        </li>

        <li class="<?php if (Yii::app()->controller->id == 'affiliateLink' && Yii::app()->controller->action->id == 'createBanner') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/affiliate/affiliateLink/createBanner') ?>">
                <i class="icon-double-angle-right"></i>
                <?php echo Yii::t('affiliate', 'create_banner') ?>
            </a>
        </li>

        <li class="<?php if (Yii::app()->controller->id == 'affiliate' && Yii::app()->controller->action->id == 'reportOrder') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/affiliate/affiliate/reportOrder') ?>">
                <i class="icon-double-angle-right"></i>
                Báo cáo đơn hàng
            </a>
        </li>
        
        <li class="<?php if (Yii::app()->controller->id == 'affiliate' && Yii::app()->controller->action->id == 'overview') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/affiliate/affiliate/overview') ?>">
                <i class="icon-double-angle-right"></i>
                Báo cáo hiệu quả
            </a>
        </li>

        <li class="<?php if (Yii::app()->controller->id == 'affiliate' && Yii::app()->controller->action->id == 'paymentInfo') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/affiliate/affiliate/paymentInfo') ?>">
                <i class="icon-double-angle-right"></i>
                Thông tin thanh toán
            </a>
        </li>
        
        <li class="<?php if (Yii::app()->controller->id == 'affiliate' && Yii::app()->controller->action->id == 'orderTransferMoney') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/affiliate/affiliate/orderTransferMoney') ?>">
                <i class="icon-double-angle-right"></i>
                Yêu cầu chuyển tiền
            </a>
        </li>
        
        <li class="<?php if (Yii::app()->controller->id == 'affiliate' && Yii::app()->controller->action->id == 'listTransferMoney') echo 'active'; ?>">
            <a href="<?php echo Yii::app()->createUrl('/affiliate/affiliate/listTransferMoney') ?>">
                <i class="icon-double-angle-right"></i>
                Danh sách yêu cầu chuyển tiền
            </a>
        </li>

    </ul><!-- /.nav-list -->

    <div id="sidebar-collapse" class="sidebar-collapse">
        <i data-icon2="icon-double-angle-right" data-icon1="icon-double-angle-left" class="icon-double-angle-left"></i>
    </div>
</div>