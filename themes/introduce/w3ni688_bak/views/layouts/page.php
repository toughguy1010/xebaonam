<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="top-cont clearfix">
        <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="left">
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
    <div class="content clearfix">
        <div class="page-sale">
            <div class="colleft">
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK6));
                ?>
            </div>
            <div class="colright">
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK7));
                ?>
            </div>
        </div>
        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK2)); ?>

    </div>
    <div class="bottom-main">
        <div class="row">
            <div class="col-sm-4">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK4)); ?>
            </div>
            <div class="col-sm-4">

            </div>
            <div class="col-sm-4">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK6)); ?>
            </div>
           
        </div>
    </div>
</div>
<?php $this->endContent(); ?>