<?php
/* @var $this WidgetController */
/* @var $model Widgets */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerScript('moduleform', "
             CKEDITOR.replace('Widgets_widget_template');
        ");
?>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'widgets-form',
        //'action' => ($model->isNewRecord ? Yii::app()->createUrl('/widget/widget/create') : Yii::app()->createUrl('/widget/widget/update')),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal'),
    ));
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'widget_name', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'widget_name', array('class' => 'span12', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'widget_name'); ?>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'showallpage', array('class' => 'col-sm-3 control-label no-padding')); ?>
        <div class="controls col-sm-9">
            <?php echo $form->checkBox($model, 'showallpage'); ?>
            <?php echo $form->error($model, 'showallpage'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'widget_template', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'widget_template', array('class' => 'span12', 'style' => 'width: 100%;')); ?>
            <?php echo $form->error($model, 'widget_template'); ?>
        </div>
    </div>

    <div class="control-group buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn', 'id' => 'savewidget')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    jQuery('#savewidget').on('click', function() {
        var _this = $(this);
        var action = $('#widgets-form').attr('action');
        if (action) {
            for (instance in CKEDITOR.instances)
                CKEDITOR.instances[instance].updateElement();
            jQuery.ajax({
                url: action,
                type: 'POST',
                data: $('#widgets-form').serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    w3ShowLoading(_this, 'right', 40, -4);
                },
                success: function(data) {
                    if (data.code == 200) {
                        if (data.redirect)
                            window.location.href = data.redirect;
                    } else {
                        if (data.errors) {
                            parseJsonErrors(data.errors);
                        }
                    }
                    w3HideLoading();
                },
                error: function() {
                    w3HideLoading();
                }
            });
        }
        return false;
    });
</script>