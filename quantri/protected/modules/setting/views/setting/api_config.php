<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
?>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'site-settings-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'facebook_app_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'facebook_app_id', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'facebook_app_id'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'facebook_app_secret', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'facebook_app_secret', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'facebook_app_secret'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'google_client_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'google_client_id', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'google_client_id'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'google_client_secret', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'google_client_secret', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'google_client_secret'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'google_developer_key', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'google_developer_key', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'google_developer_key'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>