<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    //    jQuery(document).ready(function () {
    //        //
    //        CKEDITOR.replace("Manufacturer_description", {
    //            height: 200,
    //            language: '<?php //echo Yii::app()->language ?>//'
    //        });
    //    });
    //    jQuery(function ($) {
    //    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'news-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'shortdes', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'shortdes', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'shortdes'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'order', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'order'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'temp', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-3">
                <?php echo $form->labelEx($model, 'min_temp', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <?php echo $form->textField($model, 'min_temp', array('class' => 'span12 col-sm-10')); ?>
                <?php echo $form->error($model, 'min_temp'); ?>
            </div>
            <div class="controls col-sm-3">
                <?php echo $form->labelEx($model, 'max_temp', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <?php echo $form->textField($model, 'max_temp', array('class' => 'span12 col-sm-10')); ?>
                <?php echo $form->error($model, 'max_temp'); ?>
            </div>
        </div>
        <div class="control-group form-group buttons">
            <div class="col-sm-offset-2 col-sm-10">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('product', 'season_create') : Yii::t('product', 'manufacturer_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddManu')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#manufacturer_upload').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/manufacturer/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Manufacturer_avatar').val(obj.data.avatar);
                        if (jQuery('#manufactureravatar_img img').attr('src')) {
                            jQuery('#manufactureravatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#manufactureravatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#manufactureravatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>