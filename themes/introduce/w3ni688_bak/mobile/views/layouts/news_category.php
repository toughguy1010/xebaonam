<?php $this->beginContent('//layouts/main'); ?>
<div class="page-in page-list-news">
    <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    <div class="clearfix">
        <?php
        echo $content;
        ?>
        <?php
//        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK5));
        ?>
    </div>
</div>
<?php $this->endContent(); ?>