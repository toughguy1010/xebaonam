

<?php 
$site_info = Yii::app()->siteinfo;
?>
<!--  --POS_TOP-- --POS_BANNER_MAIN_MOBILE-- --POS_RATING_MOBILE-- --POS_SEARCH_BOX_MOBILE_V1-- --POS_MENU_MAIN_MOBILE-- -->
<!-- header -->
<header style="float: none;">
    <div class="container container_header">
        <div class="header_top">
            <div class="logo">
                <!-- Cắm html -->
                <h1><a href="<?= Yii::app()->homeUrl; ?>" title="<?= $site_info['site_title'] ?>">
                    <img src="<?= $site_info['site_logo'] ?>" atl="logo" style="margin-top:0px;">
                </a>
            </h1>


            </div>
            <div class="search_box">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_SEARCH_BOX_MOBILE)); ?>

            </div>
            <div class="menu_pc menu_main">
               <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_MENU_MAIN_MOBILE)); ?>

            </div>
        </div>
    </div>
</header>
<style type="text/css">
    .logo img {
        width: auto !important;
    }
</style>
