<?php $this->beginContent('//layouts/main'); ?>
<?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    <div class="row">
        <div class="col-sm-8">
            <div class="left">
                <?php
                echo $content;
                //        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
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