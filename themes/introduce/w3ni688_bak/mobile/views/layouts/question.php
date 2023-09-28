<?php $this->beginContent('//layouts/main'); ?>
<?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
<div class="page-in page-question">
    <div class="clearfix">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK6));
        echo $content;
        ?>
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_RIGHT_OUT));
        ?>
        <?php
//        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_LEFT_OUT));
//        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK5));
        ?>
    </div>
    <div class="menu-bottom-main">
        <ul class="clearfix">
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK6)); ?>
        </ul>
    </div>
    <?php
//    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK3));
    ?>
    <?php
//    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK5));
    ?>
</div>
<?php $this->endContent(); ?>
  