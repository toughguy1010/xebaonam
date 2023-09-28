<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        CKEDITOR.replace("GiftCard_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'banners-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
        ));
        ?>


        <div class="control-group form-group">
            <?php echo $form->label($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo CHtml::label(Yii::t('banner', 'src'), '', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'src', array('class' => 'span12 col-sm-12')); ?>
                <div class="row" style="margin: 10px 0px;">
                    <?php if ($model->id && $model->src) { ?>
                        <div style="max-height: 200px; overflow: hidden; display: block; margin-bottom: 15px;">
                            <?php $this->renderPartial('banner_view', array('model' => $model)); ?>
                        </div>
                    <?php } ?>
                    <?php echo CHtml::fileField('src', ''); ?>
                </div>
                <?php echo $form->error($model, 'src'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->label($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'order', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'order'); ?>
            </div>
        </div>
        
        <div class="control-group form-group">
            <?php echo $form->label($model, 'campaign_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'campaign_id', GiftCardCampaign::optionsCampaign(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'campaign_id'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->label($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label>
                    <?php echo $form->checkBox($model, 'status', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </div>
        </div>

        <div class="control-group form-group buttons" style="border-bottom: none;">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('banner', 'banner_create') : Yii::t('banner', 'banner_edit'), array('class' => 'btn btn-info', 'id' => 'savebanner')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>