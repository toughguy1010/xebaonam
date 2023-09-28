<?php $this->beginContent('//layouts/main'); ?>
<div class="container clearfix">
    <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    <div class="page-news">	
        <div class="row">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
            ?>
            <div class="col-xs-9">
                <?php
                echo $content;
                ?>

            </div>
            <div class="col-xs-3">
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK5));
                ?>
            </div>
        </div>
    </div>
    <!--    <div class="page-list-news clearfix">
            <div class="col-left">
    
            </div>
            <div class="col-right">
    
            </div>
        </div>-->
    <?php
//            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_RIGHT));
    ?>
</div>
<?php $this->endContent(); ?>