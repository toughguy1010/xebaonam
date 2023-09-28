<div id="footer">

    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK5)); ?>
    <?php Yii::app()->controller->renderPartial('//layouts/shops_store_footer') ?>
    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BOTTOM)); ?>

    <footer style="margin-bottom: 90px;">
        <div class="hot_line_mobile">
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK20)); ?>

        </div>
        <div class="hot_line_mobile_center">
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK19)); ?>

        </div>
        <div class="address_mobile">
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK17)); ?>

        </div>
    </footer>
</div>
<div class="callus echbay-alo-phone phonering-alo-phone phonering-alo-green style-for-position-bl"
     style=" bottom: 165px;">
    <a class="hotline_text1" href="tel:<?= Yii::app()->siteinfo['admin_phone'] ?>"
       onclick="gtag_report_conversion('tel:<?= Yii::app()->siteinfo["admin_phone"] ?>')">
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>
        <div class="phonering-alo-ph-img-circle">
        </div>

    </a>
</div>
<style type="text/css">
    #fb-root iframe {
        bottom: 81px !important;
        right: 0 !important;
        top: auto !important;
    }
</style>
<?php $phone = explode(',', Yii::app()->siteinfo['phone']); ?>
<?php
$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK6));
?>
<!-- Cắm popup  -->
<?php
$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_QUESTION));
?>

<div class="chat">
    <div class="phone_call">
        <a href="tel:<?= $phone[0]; ?>" target='_blank'
           onclick="gtag_report_conversion('tel:<?= $phone[0]; ?>')"><span></span></a>
        <span>Gọi nữa</span>
    </div>
    <div class="fb_f">
        <a href="https://www.facebook.com/xebaonam/" target='_blank'><span></span></a>
        <span>Messenger</span>
    </div>
    <div class="zalo_f">
        <a href="https://zalo.me/0979662288" target='_blank'><span></span></a>
        <span>Zalo</span>
    </div>
</div>
<style>
    .bct_ {
        display: flex;
        float: left;
        width: 100%;
    }
    .bct_ a {
        width: 100%;
    }
    .bct_ a img {
        width: 90% !important;
        margin: 0;
    }
    .dv-foot-3 ul img {
        margin: 0;
        width: calc(25% - 10px);
        margin-right: 10px;
        float: left;
        margin-bottom: 10px;
    }

    .dv-foot-bottom ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .dv-foot-bottom .ul-phuongthuc-thanhtoan {
        margin-top: 0;
        float: left;
        width: 100%;
    }

    .dv-foot-bottom h3 {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 15px;
        color: #221e1f;
    }

    .clr {
        clear: both;
        display: none;
    }

    .dv-foot-bottom ul a {
        display: block;
        color: #fff;
        margin-bottom: 5px;
    }

    ul.ul-phuongthuc-thanhtoan > a > img {
        height: 45px;
        width: auto;
        max-width: 100%;
        float: left;
        margin: 5px 0 0;
    }
    footer .icon-fl {
        float: none;
        display: inline-block;
        padding-top: 3px;
    }
    .follow-us {
        text-align: center;
        width: 100%;
    }
</style>

<style>
    .title_you {
        position: absolute;
        top: 10px;
        left: 15px;
        color: #fff;
        font-size: 20px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        overflow: hidden;
        text-shadow: 0 0 9px black;
    }
    .img_youtube {
        position: relative;
    }
    .img_youtube img {
        width: 100%;
        margin: 0;
    }

    .img_youtube:hover .ytp-large-play-button-bg {
        -moz-transition: fill .1s cubic-bezier(0.0, 0.0, 0.2, 1), fill-opacity .1s cubic-bezier(0.0, 0.0, 0.2, 1);
        -webkit-transition: fill .1s cubic-bezier(0.0, 0.0, 0.2, 1), fill-opacity .1s cubic-bezier(0.0, 0.0, 0.2, 1);
        transition: fill .1s cubic-bezier(0.0, 0.0, 0.2, 1), fill-opacity .1s cubic-bezier(0.0, 0.0, 0.2, 1);
        fill: #f00;
        fill-opacity: 1;
    }

    .img_youtube svg {
        position: absolute;
        width: 65px;
        left: 0;
        z-index: 9999;
        height: 48px;
        top: 40%;
        right: 0;
        margin: 0 auto;
        cursor: pointer;
    }
</style>


<script>
    $('.img_youtube').click(function () {
        var link_vd = $(this).attr('data-link');
        var height = $(this).attr('data-height');
        if (link_vd) {
            $(this).html('<iframe src="' + link_vd + '?&autoplay=1" width="100%" height="' + height + '" frameborder="0" style="border:0" allowfullscreen></iframe>');
            return false;
        }
    });
    $(function () {
        $('.img-lazyy').lazy();
    });
</script>