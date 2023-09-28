<?php
$themUrl = Yii::app()->theme->baseUrl;

?>


<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_MENU_MAIN)); ?>
<style>
    .add-info {
        color: red;
        text-transform: uppercase;
        text-align: center;
        padding: 0px 10px;
        display: block;
        margin: -10px 0px 5px;
        font-size: 13px;
    }

    .add-info-r {
        float: right;
    }

    .add-infb {
        padding: 0px 15px;
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .add-infb .lt {
        color: #000;
    }

    .add-infb .ls a {
        color: red;
    }
</style>
<header>
    <div class="container">
        <div class="header_top_mobile">
            <div class="logo_mobile">
                <!-- <h1><a href="/"><img src="<?= $themUrl ?>/css/mobile/images/logo_mobile.png"></a></h1> -->
                <h1><a href="<?= Yii::app()->homeUrl; ?>"><img src="<?php echo ClaHost::getImageHost() . Yii::app()->siteinfo['avatar_path']  . Yii::app()->siteinfo['avatar_name']; ?>"></a></h1>
            </div>

            <div class="menu-btn-show">
                <span class="border-style"></span>
                <span class="border-style"></span>
                <span class="border-style"></span>
            </div>
        </div>
    </div>
    <div class="container">
        <span class="add-info"><?= Yii::app()->siteinfo['title_call'] ?></span>
        <div class="search_box_mobile">
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_SEARCH_BOX)); ?>
        </div>
        <div class="add-infb">
            <span class="add-info-f"><span class="lt">Gọi mua:</span><span class="ls"> <a href="tel:<?= Yii::app()->siteinfo['phone_sell'] ?>"><?= Yii::app()->siteinfo['phone_sell'] ?></a></span></span>
            <span class="add-info-r"><span class="lt">Phản ánh:</span><span class="ls"> <a href="tel:<?= Yii::app()->siteinfo['phone_sell'] ?>"><?= Yii::app()->siteinfo['phone_callback'] ?></a></span></span>
            <span class="add-info-c"><span class="lt">Bảo hành:</span><span class="ls"> <a href="tel:<?= Yii::app()->siteinfo['phone_safe'] ?>"><?= Yii::app()->siteinfo['phone_safe'] ?></a></span></span>
        </div>
    </div>
</header>
<!-- Slider mobile -->
<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK11)); ?>