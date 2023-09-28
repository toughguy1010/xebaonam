<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'footer-settings-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>

        <?php
        Yii::app()->clientScript->registerScript('footersettings', "
             CKEDITOR.replace('SiteSettings_footercontent');
        ");
        ?>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'footercontent', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'footercontent', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'footercontent'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>