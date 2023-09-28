<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('site', 'site_create'); ?></h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
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
                        <div class="control-group form-group no-border">
                            <?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                            <div class="controls col-sm-9">
                                <?php echo $form->dropDownList($model, 'type', ['' => 'Chọn loại'] + V3SiteManagers::getTypes(true), array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'type'); ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'domain', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                            <div class="controls col-sm-9">
                                <?php echo $form->textField($model, 'domain', array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'domain'); ?>
                            </div>
                        </div>
                        <div class="control-group form-group no-border">
                            <?php echo $form->labelEx($model, 'site_id_demo', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                            <div class="controls col-sm-9">
                                <?php echo $form->dropDownList($model, 'site_id_demo', ['' => 'Chọn site demo'] + V3SiteManagers::getSiteDemos(true), array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'site_id_demo'); ?>
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