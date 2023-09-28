<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>

<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('module', 'module_update') . ':' . $model->id; ?></h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'module-settings-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal'),
            ));
            ?>
            <table class="table">
                <tr>
                    <td width="60%" style="border-right: 1px solid #CCC; padding-right: 0px; padding-bottom: 0px;">
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                            <div class="controls col-sm-9">
                                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'name'); ?>
                            </div>
                        </div>
                    </td>
                    <td width="40%" style="padding-bottom: 0px;">
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                            <div class="controls col-sm-12 no-padding-left">
                                <?php echo $form->textArea($model, 'description', array('class' => 'col-sm-12', 'style' => 'min-height: 300px;')); ?>
                                <?php echo $form->error($model, 'description'); ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'src', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->hiddenField($model, 'src', array('class' => 'span12 col-sm-12')); ?>
                                <div style="clear: both;"></div>
                                <div id="modulesrc" style="display: block; margin-top: 10px;">
                                    <div id="moduleavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top;">
                                        <img src="<?= ClaHost::getImageHost() . $model->src ?>" />
                                    </div>
                                    <div id="modulesrc_form" style="display: inline-block;">
                                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                    </div>
                                </div>
                                <?php echo $form->error($model, 'src'); ?>
                            </div>
                            <script>
                                jQuery(function($) {
                                    jQuery('#modulesrc_form').ajaxUpload({
                                        url: '/quantri/upload/uploadfile',
                                        name: 'file',
                                        onSubmit: function() {},
                                        onComplete: function(result) {
                                            var obj = $.parseJSON(result);
                                            if (obj.status == '200') {
                                                if (obj.data.realurl) {
                                                    jQuery('#V3Modules_src').val(obj.data.avatar);
                                                    if (jQuery('#moduleavatar_img img').attr('src')) {
                                                        jQuery('#moduleavatar_img img').attr('src', obj.data.realurl);
                                                    } else {
                                                        jQuery('#moduleavatar_img').append('<img src="' + obj.data.realurl + '" />');
                                                    }
                                                    jQuery('#moduleavatar_img').css({
                                                        "margin-right": "10px"
                                                    });
                                                }
                                            } else {
                                                if (obj.message)
                                                    alert(obj.message);
                                            }
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="control-group form-group buttons" style="border-bottom: none;">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('module', 'module_create') : Yii::t('module', 'module_update'), array('class' => 'btn btn-info')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>