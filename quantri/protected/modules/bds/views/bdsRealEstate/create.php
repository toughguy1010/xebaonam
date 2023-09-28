<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('bds_real_estate', 'real_estate_create'); ?></h4>
        <div class="widget-toolbar no-border">
            <a style="" class="btn btn-xs btn-primary" id="savereal_estate" href="#" validate="<?php echo Yii::app()->createUrl('bds/bdsRealEstate/validate'); ?>">
                <i class="icon-ok"></i>
                <?php echo Yii::t('bds_common', 'save') ?>
            </a>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model, 'real_estateInfo' => $real_estateInfo, 'real_estate_map' => $real_estate_map)); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var width_window = $(window).width();
        var width_left = $('#sidebar').width();
        var width_element = width_window - width_left - 20 * 2 - 15;
        $(window).scroll(function () {
            var scroll_top = $(document).scrollTop();
            if (scroll_top > 100) {
                $('.main-content .page-content .widget-header').css('position', 'fixed');
                $('.main-content .page-content .widget-header').css('top', '0px');
                $('.main-content .page-content .widget-header').css('z-index', '99');
                $('.main-content .page-content .widget-header').css('width', width_element);
            } else {
                $('.main-content .page-content .widget-header').css('position', 'static');
            }
        });
    });
</script>