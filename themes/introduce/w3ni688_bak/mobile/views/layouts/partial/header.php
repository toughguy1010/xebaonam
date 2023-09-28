
<?php
$themUrl = Yii::app()->theme->baseUrl;

?>


<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_MENU_MAIN)); ?>

<header>
    <div class="container">
        <div class="header_top_mobile">
            <div class="logo_mobile">
                <!-- <h1><a href="/"><img src="<?= $themUrl?>/css/mobile/images/logo_mobile.png"></a></h1> -->
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
        <div class="search_box_mobile">
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_SEARCH_BOX)); ?>
            
        </div>
    </div>
</header>
<!-- Slider mobile -->
<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK11)); ?>
