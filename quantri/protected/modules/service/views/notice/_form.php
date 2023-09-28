<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        CKEDITOR.replace("Notice_content", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
        $(".chosen-select").chosen();
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'notices-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
        ));
        ?>

        <div class="tabbable">
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    CKEDITOR.replace("Banners_notice_description", {
                        height: 400,
                        language: '<?php echo Yii::app()->language ?>'
                    });
                });
            </script>
            <div class="control-group form-group">
                <?php echo $form->label($model, 'title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'title', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
            </div>
            <div class="control-group form-group">
                <?php echo $form->label($model, 'content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textArea($model, 'content', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'content'); ?>
                </div>
            </div>
            <?php if ($model->isNewRecord): ?>
                <div class="control-group form-group">
                    <?php echo $form->labelEx($model, 'showall', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <label>
                            <?php echo $form->checkBox($model, 'showall', array('class' => 'ace ace-switch ace-switch-6')); ?>
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
                <div class="control-group form-group">
                    <?php echo CHtml::label('Thành viên nhận tin', '', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'user_ids', $users, array('multiple' => 'multiple', 'class' => 'form-control chosen-select', 'style' => 'width: 100%;')); ?>
                        <?php echo $form->error($model, 'user_ids'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="control-group form-group buttons" style="border-bottom: none;">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('notice', 'notice_create') : Yii::t('notice', 'notice_edit'), array('class' => 'btn btn-info', 'id' => 'savenotice')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>