<?php
Yii::app()->clientScript->registerScript('formhtml', "
             CKEDITOR.replace('config_html_html');
        ", CClientScript::POS_READY);
?>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'widgets-form',
        'action' => Yii::app()->createUrl('widget/widget/saveconfig', array('pwid' => $model->page_widget_id)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal'),
    ));
    ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'widget_title', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->textField($model, 'widget_title', array('class' => 'form-control ckeditor', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'widget_title'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'html', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->textArea($model, 'html', array('class' => 'form-control ckeditor', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'html'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'show_wiget_title', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->checkBox($model, 'show_wiget_title'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'showallpage', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-9">
            <?php echo $form->checkBox($model, 'showallpage'); ?>
        </div>
    </div>

    <div class="form-group buttons">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary', 'id' => 'savewidget')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->