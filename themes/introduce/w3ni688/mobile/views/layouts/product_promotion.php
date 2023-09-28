<?php $this->beginContent('//layouts/main'); ?>
<?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
<div class="page-promotion">
    <?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK7));
    ?>
    <div class="cont-main cont-promotion">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK4));
        echo $content;
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK6));
        ?>
    </div>
</div>
<?php $this->endContent(); ?>
