<?php $this->beginContent('//layouts/main'); ?>
<div class="page-repairs">
    <div class="banner-repairs">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK2));
        ?>
    </div>
    <div class="container clearfix">
        <div class="cont-main">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_BEGIN_CONTENT));
            ?>
            <?php echo $content; ?>
        </div>
    </div>
    <?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK1));
    ?>
    <div class="question clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK2));
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK7));
                    ?>
                </div>
                <div>
                </div>
            </div>
        </div>
        <?php $this->endContent(); ?>