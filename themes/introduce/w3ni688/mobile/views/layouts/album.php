<?php $this->beginContent('//layouts/main'); ?>
<div class="page-in page-album">
    <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    <div class="clearfix">
        <?php
        echo $content;
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
        ?>
    </div>
</div>
<?php $this->endContent(); ?>
