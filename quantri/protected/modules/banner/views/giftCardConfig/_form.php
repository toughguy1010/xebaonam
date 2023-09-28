<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'gift-card-config-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'business', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'business', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'business'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'name'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'min_value', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'min_value', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'min_value'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'max_value', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'max_value', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'max_value'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'expire_days', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'expire_days', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'expire_days'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'note', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'note', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'note'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'term', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'term', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'term'); ?>
                </span>
            </div>
        </div>
        
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
