<?php $this->beginContent('//layouts/main'); ?>
<?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
<div class="page-in page-list-product">
    <div class="cont-main">
        <?php
//        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
        ?>
        <?php echo $content; ?>
    </div>
</div>
<div class="menu-bottom-main">
    <ul class="clearfix">
        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK6)); ?>
    </ul>
</div>

<?php $this->endContent(); ?>