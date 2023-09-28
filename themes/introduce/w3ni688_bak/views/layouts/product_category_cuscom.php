<?php $this->beginContent('//layouts/main'); ?>
<style>
    body {
        background: #f5f5f5;
    }
</style>
<div class="container">
    <div class="banner-in clearfix">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_BEGIN_CONTENT));
        ?>
    </div>
    <div class="fiter fiter-1 clearfix">
        <form method="post" action="/site/form/submit/id/6" id="w3n-submit-form" role="form" class="form-horizontal w3f-form" enctype="multipart/form-data">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK1));
            ?>
        </form>
    </div>
    <div class="quick-search-in clearfix">
        <div class="container">
            <div class="colleft">
                <?php
//                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK4));
                ?>
            </div>
            <div class="colright">
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
                ?>
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>