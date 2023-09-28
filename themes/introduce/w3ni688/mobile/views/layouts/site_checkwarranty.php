<?php $this->beginContent('//layouts/main'); ?>
    <div class="container clearfix">
        <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
        <?php
        echo $content;
        ?>
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
        ?>
    </div>
<?php $this->endContent(); ?>