<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<p id="bttop" class="scroll-top-btn" style="display: block;">
    <a style="cursor: pointer;" title="Về đầu trang">
        <span>
        </span>
    </a>
</p>
<?php
$themUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
Yii::app()->clientScript->registerCoreScript('jquery');
$vs = '1.1.8';
?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK1)); ?>

            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK3)); ?>

            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK2)); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="item">
                    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK7)); ?>


                </div>
            </div>
        </div>
    </div>
</footer>
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
        margin-top: 15px;
    }

    .dv-foot-bottom h3 {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 15px;
        color: #fff;
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

</style>
<style type="text/css">
    .addres_shop .item_address:first-child {
        overflow-y: scroll;
        height: 580px;
    }
</style>
<!-- Cắm popup  -->
<?php
$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_QUESTION));
?>
<?php $phone = explode(',', Yii::app()->siteinfo['phone']); ?>
<div class="callus_fix"><i class="i_phone"><span style="display:none;">.</span></i><a href="tel:<?= $phone[0]; ?>"
                                                                                      onclick="gtag_report_conversion('tel:<?= $phone[0]; ?>')">HOTLINE
        : <?= $phone[0]; ?></a></div>

<style>
    .img-lazyy {
        min-width: inherit;
        min-height: inherit;
        margin: 0;
        /*float: left;*/
        width: 100%;
    }

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
        float: left;
        width: 100%;
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
    $(document).ready(function () {
        $('.img-lazyy').lazy();
    });
</script>