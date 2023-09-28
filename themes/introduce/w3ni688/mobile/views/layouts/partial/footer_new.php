<footer class="footer">
    <div id="footer">

        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK5)); ?>
        <?php Yii::app()->controller->renderPartial('//layouts/shops_store_footer') ?>
    </div>
    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BOTTOM)); ?>
</footer>
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
        align-items: center;
        justify-content: left;
    }
    .bct_ a {
        width: 100%;
    }
    .bct_ a img {
        margin: 0;
        max-width: 125px;
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
    footer {
        margin-bottom: 150px;
        width: 100%;
        float: left;
    }
    .footer__top {
        border-bottom: 1px solid #ebebeb;
        padding: 0 10px;
        border-top: 1px solid #ebebeb;
    }
    .footer .bdr {
        border-bottom: 1px solid #ebebeb;
        padding: 10px 0;
    }
    .footer .bdr--hd p {
        font-weight: bold;
    }
    .footer .bdr p {
        line-height: 16px;
        margin: 0;
    }
    .footer .bdr.bdr--hd p {
        font-size: 15px;
    }
    .footer .bdr--hd span {
        color: #666;
        font-weight: normal;
    }
    .footer .bdr p>b {
        display: inline-block;
        width: 115px;
        font-weight: 300;
    }
    .footer .txt-bold {
        font-weight: bold;
    }
    .footer a {
        color: #4a90e2;
        width: auto;
    }
    .footer .txt-open {
        display: inline-block;
        position: relative;
        padding-right: 15px;
    }
    .footer .txt-open::before {
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #333;
        content: '';
        height: 0;
        position: absolute;
        top: 7px;
        right: 0;
        width: 0;
        transition: .3s;
    }
    .f-list__show {
        background-color: #f1f1f1;
        border-radius: 4px;
        display: none;
        margin-top: 5px;
        padding: 15px 10px;
    }
    .f-list__show ul {
        float: left;
        width: calc(50% - 10px);
    }
    .f-list__show ul li {
        margin-bottom: 10px;
    }
    .f-list__show a {
        color: #333;
    }
    .f-list__show ul:last-child {
        margin-left: 20px;
    }
    .footer .bdr:last-child {
        border: none;
    }
    .f-social a {
        margin: 0;
        color: #fff;
    }
    .icon-facebook {
        background-position: -140px 0;
        height: 18px;
        width: 18px;
    }
    .icon-youtb {
        background-position: -165px 0;
        height: 18px;
        width: 18px;
    }
    .footer__logo {
        padding: 15px 10px;
    }
    .footer__logo__txt {
        margin-bottom: 10px;
    }
    .footer__certify {
        border-top: 1px solid #ebebeb;
        padding: 12px 10px;
    }
    .footer__certify a {
        margin-right: 20px;
    }
    .icon-congthuong {
        background-position: 0 -70px;
        height: 24px;
        width: 79px;
    }
    .icon-khieunai {
        background-position: -195px -40px;
        height: 25px;
        width: 25px;
    }
    .icon-protected {
        background-position: -85px -70px;
        height: 24px;
        width: 121px;
    }
    .copy-right {
        background-color: #f1f1f1;
        color: #666;
        font-size: 10px;
        line-height: 18px;
        padding: 10px;
        float: left;
        width: 100%;
    }
    .footer .bdr.active .txt-open:before {
        transform: rotate(
            -180deg
        );
    }
</style>
<script>
    $('.footer .bdr.f-list').click(function () {
        $(this).toggleClass('active');
        $('.f-list__show').toggle();
    });
</script>
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