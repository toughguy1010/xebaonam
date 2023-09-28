<?php $this->beginContent('//layouts/main'); ?>
<div class="container clearfix">
    <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    
    <div class="page-list-news clearfix">
        <div class="col-left">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK5));
            ?>
        </div>
        <div class="col-right">
            <?php
            echo $content;
            ?>
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
            ?>
        </div>
    </div>
    <?php
//            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_RIGHT));
    ?>
</div>
<?php $this->endContent(); ?>