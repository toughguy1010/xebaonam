<?php
$themUrl = Yii::app()->theme->baseUrl;

?>
<div class="item">
 <?php if ($show_widget_title) { ?>
    <h3> <?= $widget_title ?></h3>
<?php } ?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'newsletter-form',
    'action' => Yii::app()->createUrl('site/site/receivenewsletter'),
    'enableAjaxValidation' => true,
            // 'enableClientValidation' => true,
    'htmlOptions' => array('class' => 'form-inline newsletter-form'),
));
?>
<?php echo $form->textField($model, 'email', array('class' => '', 'placeholder' => $model->getAttributeLabel('email'), 'title' => $model->getAttributeLabel('email'), 'id' => 'txtFMailAddress')); ?>
<?php echo $form->error($model, 'email'); ?>
<button type="submit">Đăng ký</button>
<?php $this->endWidget(); ?>

<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK8)); ?>

</div>