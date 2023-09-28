<?php $this->beginContent('//layouts/main'); ?>
<div class="clearfix layout layout-2">
    <div id="leftCol">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_LEFT));
        ?>
    </div>
    <div id="contentCol" class="lh">
        <div id="centerCol">
            <div class="centerContent">
                <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
                <?php
                echo $content;
                ?>
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>