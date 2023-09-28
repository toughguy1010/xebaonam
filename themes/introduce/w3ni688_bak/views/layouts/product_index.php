<?php $this->beginContent('//layouts/main'); ?>
<style type="text/css">
    #main{
        background: #ffffff;
    }
</style>
<div id="main">
    <div class="search-main-in clearfix">
        <div class="container-in clearfix">
            <div class="fiter clearfix">
                <form method="post" action="/site/form/submit/id/6" id="w3n-submit-form" role="form" class="form-horizontal w3f-form" enctype="multipart/form-data">
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_BEGIN_CONTENT));
                    ?>
                </form>
            </div>
            <div class="quick-search-in clearfix">
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK2));
                ?>
                <div class="price-in">
                    <form method="post" action="/site/form/submit/id/6" id="w3n-submit-form" role="form" class="form-horizontal w3f-form" enctype="multipart/form-data">
                        <?php
                        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK1));
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="banner-in clearfix">
        <div class="container-in">
            <div class="row">
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK4));
                ?>
            </div>
        </div>
    </div>

    <div class="product-in clearfix">
        <div class="container-in">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
            ?>
            <?php echo $content; ?>
        </div>
    </div>

    <!--<div class="search-main clearfix">-->
        <!--<div class="container">-->
            <?php // $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK5)); ?>
        <!--</div>-->
    <!--</div>-->
</div>
<?php $this->endContent(); ?>