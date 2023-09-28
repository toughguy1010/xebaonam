<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
// Lấy key for mỗi widget ở vị trí tương ứng, tạm thời là lấy ở home tương ứng default controller
$widgetkey = ClaSite::getDefaultController(Yii::app()->siteinfo);
//
?>
<div class="row">
    <div class="span3 col-sm-12">
        <div class="row">
            <div class="span3 col-sm-12">
                <div class="widget widget-box">
                    <div class="widget-header"><h4><?php echo Yii::t('widget', 'widget_header_layout'); ?></h4></div>
                    <div class="widget-body no-padding">
                        <div class="widget-main">
                            <?php
                            if (isset($widgets[Widgets::POS_HEADER][$widgetkey])) {
                                foreach ($widgets[Widgets::POS_HEADER][$widgetkey] as $widget) {
                                    $this->renderPartial('widgetitem', array('widget' => $widget, 'po' => Widgets::POS_HEADER));
                                }
                            }
                            ?>
                            <div class="widgetitem widgetaction">
                                <div class="widitemsub">
                                    <a class="addwidget" href="<?php echo Yii::app()->createUrl('/widget/widget/create', array('po' => Widgets::POS_HEADER)); ?>"><i class="icon-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span3 col-sm-3">
                <div class="widget widget-box">
                    <div class="widget-header"><h4><?php echo Yii::t('widget', 'widget_left_layout'); ?></h4></div>
                    <div class="widget-body no-padding">
                        <div class="widget-main">
                            <?php
                            if (isset($widgets[Widgets::POS_LEFT][$widgetkey])) {
                                foreach ($widgets[Widgets::POS_LEFT][$widgetkey] as $widget) {
                                    $this->renderPartial('widgetitem', array('widget' => $widget, 'po' => Widgets::POS_LEFT));
                                }
                            }
                            ?>
                            <div class="widgetitem widgetaction">
                                <div class="widitemsub">
                                    <a class="addwidget" href="<?php echo Yii::app()->createUrl('/widget/widget/create', array('po' => Widgets::POS_LEFT)); ?>"><i class="icon-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span6 col-sm-6">
                <div class="widget widget-box">
                    <div class="widget-header"><h4><?php echo Yii::t('widget', 'widget_center_layout'); ?></h4></div>
                    <div class="widget-body no-padding">
                        <div class="widget-main">
                            <?php
                            if (isset($widgets[Widgets::POS_CENTER][$widgetkey])) {
                                foreach ($widgets[Widgets::POS_CENTER][$widgetkey] as $widget) {
                                    $this->renderPartial('widgetitem', array('widget' => $widget, 'po' => Widgets::POS_CENTER));
                                }
                            }
                            ?>
                            <div class="widgetitem widgetaction">
                                <div class="widitemsub">
                                    <a class="addwidget" href="<?php echo Yii::app()->createUrl('/widget/widget/create', array('po' => Widgets::POS_CENTER)); ?>"><i class="icon-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span3 col-sm-3">
                <div class="widget widget-box">
                    <div class="widget-header"><h4><?php echo Yii::t('widget', 'widget_right_layout'); ?></h4></div>
                    <div class="widget-body no-padding">
                        <div class="widget-main">
                            <?php
                            if (isset($widgets[Widgets::POS_RIGHT][$widgetkey])) {
                                foreach ($widgets[Widgets::POS_RIGHT][$widgetkey] as $widget) {
                                    $this->renderPartial('widgetitem', array('widget' => $widget, 'po' => Widgets::POS_RIGHT));
                                }
                            }
                            ?>
                            <div class="widgetitem widgetaction">
                                <div class="widitemsub">
                                    <a class="addwidget" href="<?php echo Yii::app()->createUrl('/widget/widget/create', array('po' => Widgets::POS_RIGHT)); ?>"><i class="icon-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 col-sm-12">
                <div class="widget widget-box">
                    <div class="widget-header"><h4><?php echo Yii::t('widget', 'widget_footer_layout'); ?></h4></div>
                    <div class="widget-body no-padding">
                        <div class="widget-main">
                            <?php
                            if (isset($widgets[Widgets::POS_FOOTER][$widgetkey])) {
                                foreach ($widgets[Widgets::POS_FOOTER][$widgetkey] as $widget) {
                                    $this->renderPartial('widgetitem', array('widget' => $widget, 'po' => Widgets::POS_FOOTER));
                                }
                            }
                            ?>
                            <div class="widgetitem widgetaction">
                                <div class="widitemsub">
                                    <a class="addwidget" href="<?php echo Yii::app()->createUrl('/widget/widget/create', array('po' => Widgets::POS_FOOTER)); ?>"><i class="icon-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->renderPartial('script/mainscript');
?>