<?php $this->beginContent('//layouts/main'); ?>
<style type="text/css">
    #main{
        background: #ffffff;
    }
</style>
<div class="container">
    <div class="banner-in clearfix">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_BEGIN_CONTENT));
        ?>
    </div>
    <div class="filter-product clearfix">
        <div class="box-filter">
            <div class="price-in">
                <form method="post" action="/site/form/submit/id/6" id="w3n-submit-form" role="form" class="form-horizontal w3f-form" enctype="multipart/form-data">
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK1));
                    ?>
                </form>
            </div>
        </div>
        <div class="search-much">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK2));
            ?>
        </div>
    </div>
    <div class="cont-main">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
        ?>
        <?php echo $content; ?>
    </div>

</div>
<?php $this->endContent(); ?>