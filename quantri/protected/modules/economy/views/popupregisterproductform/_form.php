<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("PopupRegisterProducts_desc", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>
<style type="text/css">
    body .chosen-single {
        height: 32px !important;
        padding-top: 3px !important;
    }
    body .chosen-single div b:before {
        top: 3px !important;
    }
    .chosen-container-single .chosen-search:after {
        content:  unset !important;
    }
</style>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">

<!-- JS -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>
<div class="row">
    <div class="col-xs-12 no-padding">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'PopupRegisterProducts-form',
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
            <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'phone', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'email', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'province_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'district_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'ward_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'ward_id', $listward, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'ward_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', $model->getArrStatus(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="control-group form-group buttons">
            <div class="col-sm-offset-2 col-sm-10">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('product', 'PopupRegisterProducts_create') : Yii::t('product', 'PopupRegisterProducts_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddManu')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->
<script type="text/javascript">
    jQuery(document).on('change', '#PopupRegisterProductForm_province_id', function() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#PopupRegisterProductForm_province_id').val(),
            dataType: 'JSON',
            beforeSend: function() {
                w3ShowLoading(jQuery('#PopupRegisterProductForm_province_id'), 'right', 20, 0);
            },
            success: function(res) {
                if (res.code == 200) {
                    jQuery('#PopupRegisterProductForm_district_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function() {
                w3HideLoading();
            }
        });
    });
    jQuery(document).on('change', '#PopupRegisterProductForm_district_id', function() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#PopupRegisterProductForm_district_id').val(),
            dataType: 'JSON',
            beforeSend: function() {
                w3ShowLoading(jQuery('#PopupRegisterProductForm_district_id'), 'right', 20, 0);
            },
            success: function(res) {
                if (res.code == 200) {
                    jQuery('#PopupRegisterProductForm_ward_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function() {
                w3HideLoading();
            }
        });
    });
</script>

