<?php $this->beginContent('//layouts/main'); ?>
<div class="container clearfix">
    <div class="top-cont clearfix">
        <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    </div>
    <div class="col-sm-8">
        <div class="left">
            <?php
            echo $content;
            ?>
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="right">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_RIGHT));
            ?>
        </div>
    </div>

</div>
<?php $this->endContent(); ?>