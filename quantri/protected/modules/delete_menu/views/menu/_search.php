<?php
/* @var $this MenuController */
/* @var $model Menus */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="controls form-group">
        <?php echo $form->label($model, 'menu_title'); ?>
        <?php echo $form->textField($model, 'menu_title', array('class' => 'form-control')); ?>
    </div>

    <div class="controls form-group">
        <?php echo $form->label($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statisStatusArray(true, array('class' => 'form-control')), array('class' => 'form-control')); ?>
    </div>

    <div class="controls form-group buttons">
        <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-info')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->