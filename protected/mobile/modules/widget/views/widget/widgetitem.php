<?php
$widget = Widgets::getWidgetInfo($widget);
?>
<div class="widgetitem center">
    <div class="wgetclick">
        <a class="editwget" href="<?php echo Yii::app()->createUrl('/widget/widget/update', array('po' => $po, 'wid' => $widget['widget_id'])) ?>"><i class="icon-edit"></i></a>
        <a class="deletewget" href="<?php echo Yii::app()->createUrl('/widget/widget/delete', array('po' => $po, 'wid' => $widget['widget_id'])) ?>"><i class="icon-remove"></i></a>
    </div>
    <div class="wgetmove">
        <a class="wgetm" href="<?php echo Yii::app()->createUrl('/widget/widget/move', array('po' => $po, 'wid' => $widget['widget_id'], 'action' => 'up')) ?>"><i class="icon-caret-up"></i></a>
        <a class="wgetm" href="<?php echo Yii::app()->createUrl('/widget/widget/move', array('po' => $po, 'wid' => $widget['widget_id'], 'action' => 'down')) ?>"><i class="icon-caret-down"></i></a>
    </div>
    <div class="widitemsub">
        <p><?php echo $widget['widget_name']; ?></p>
    </div>
</div>