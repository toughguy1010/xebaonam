<?php $this->beginContent('//layouts/main'); ?>
<div class="page-in page-list-news">
    <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    <!--<div class="page-repairs">-->
    <div class="banner-repairs">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK2));
        ?>
    </div>
    <div class="cont-main">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_BEGIN_CONTENT));
        ?>
        <?php echo $content; ?>
    </div>
    <?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK1));
    ?>
    <div class="question clearfix">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK2));
        ?>
        <?php
//                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK7));
        ?>
    </div>
</div>
<?php $this->endContent(); ?>