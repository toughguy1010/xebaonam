<?php $this->beginContent('//layouts/main'); ?>
<?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
<div class="page-video">
    <div class="box-banner-video">
        <div class="container clearfix">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_LEFT_OUT));
            ?>
        </div>
        <div class="box-content-video clearfix">
            <div class="container">
                <div class="cont-main video-content">
                    <?php
                    echo  $content;
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
