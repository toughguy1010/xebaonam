<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'footer-settings-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'stylecustom', array('class' => 'col-sm-1 control-label no-padding-left')); ?>
            <div class="controls col-sm-11">
                <?php echo $form->textArea($model, 'stylecustom', array('class' => 'span9 col-sm-12','style'=>'height:200px;')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'stylecustom'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <div class="col-sm-offset-1 col-sm-11">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>