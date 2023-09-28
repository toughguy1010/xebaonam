<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'translate_option-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        $from_create = Yii::app()->request->getParam('create');
        ?>
        <div class="tabbable">
            <div class="tab-content">
                <p class="note">Fields with <span class="required">*</span> are required.</p>
                <?php echo $form->errorSummary($model); ?>


                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12', 'style' => 'width: 100%;')); ?>
                        <?php echo $form->error($model, 'description'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left buttons">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('translate', 'translate_create') : Yii::t('translate', 'translate_edit'), array('class' => 'btn btn-info', 'id' => 'savetranslate')); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div><!-- form -->
<style>
    .required {
    }
</style>
