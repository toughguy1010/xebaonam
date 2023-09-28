<?php
$this->beginContent('//layouts/main_index');
?>
<!-- menu slider news -->
<h1 style="text-indent:-9999999px; position:absolute;"><?php echo Yii::app()->siteinfo['site_title']; ?></h1>
<div class="menu_slider_news">
    <div class="container">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK1));
        ?>
    </div>
</div>
<div class="main_v">
    <div class="container">
        <div class="content_p">
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK2)); ?>
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK4)); ?>
        </div>
        <div>
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK5)); ?>
        </div>
    </div>
</div>
<?php
echo $content;
?>
<?php $this->endContent(); ?>