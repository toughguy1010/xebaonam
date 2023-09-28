<div class="row-fluid">
    <div class="span3">
        <div class="widget">
            <div class="widget-head"><span class="title"><?php echo Yii::t('widget', 'widget_left_layout'); ?></span></div>
            <div class="widget-content">
                <div class="widget-content-inner">
                    <div class="widgetitem widgetaction">
                        <div class="widitemsub">
                            <a class="addwidget" href="<?php echo Yii::app()->createUrl('/widget/widget/add', array('po' => 'left')); ?>"><i class="iconfa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="widget">
            <div class="widget-head"><span class="title"><?php echo Yii::t('widget', 'widget_header_layout'); ?></span></div>
            <div class="widget-content">
                <div class="widget-content-inner">
                    <div class="widgetitem widgetaction">
                        <div class="widitemsub">
                            <a class="addwidget" href="<?php echo Yii::app()->createUrl('/widget/widget/add', array('po' => 'header')); ?>"><i class="iconfa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget">
            <div class="widget-head"><span class="title"><?php echo Yii::t('widget', 'widget_footer_layout'); ?></span></div>
            <div class="widget-content">
                <div class="widget-content-inner">
                    <div class="widgetitem widgetaction">
                        <div class="widitemsub">
                            <a class="addwidget" href="<?php echo Yii::app()->createUrl('/widget/widget/add', array('po' => 'footer')); ?>"><i class="iconfa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="span3">
        <div class="widget">
            <div class="widget-head"><span class="title"><?php echo Yii::t('widget', 'widget_right_layout'); ?></span></div>
            <div class="widget-content">
                <div class="widget-content-inner">
                    <div class="widgetitem widgetaction">
                        <div class="widitemsub">
                            <a class="addwidget" href="<?php echo Yii::app()->createUrl('/widget/widget/add', array('po' => 'right')); ?>"><i class="iconfa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready({
    jQuery('.addwidget').on('click', function() {
        var thi = $(this);
        var href = thi.attr('href');
        if (href) {

            }
            return false;
        }
        );
    });
            function getFormWidget(href) {
                if (href) {
                    jQuery.ajax({
                        url: href,
                        type: 'POST',
                        dataType: 'JSON',
                        beforeSend: function() {

                        },
                        success: function(data) {

                        },
                        error: function() {

                        }
                    });
                }
                return true;
            }
</script>