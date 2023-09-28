<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>

<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('site', 'site_update') . ':' . $model->id; ?></h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php
            $form = $this->beginWidget('ActiveFormC', array(
                'id' => 'site-settings-form',
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

                        <?= $form->imagesKeySessionB($model, 'avatar', ($model->avatar_path && $model->avatar_name ? ClaUrl::getImageUrl($model->avatar_path, $model->avatar_name, ['width' => 100, 'height' => 100]) : '')) ?>
                    </td>
                </tr>
            </table>
            <div class="control-group form-group buttons" style="border-bottom: none;">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('site', 'site_create') : Yii::t('site', 'site_update'), array('class' => 'btn btn-info')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>