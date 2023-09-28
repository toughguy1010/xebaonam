<div class="row">
    <div class="col-xs-12 no-padding">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'banner-groups-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'banner_group_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'banner_group_name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'banner_group_name'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'banner_group_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'banner_group_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'banner_group_description'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'group_size', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="col-sm-6" style="padding-right: 20px; padding-left: 0px;">
                    <?php echo $form->textField($model, 'width', array('placeholder' => $model->getAttributeLabel('width'), 'class' => 'col-sm-12')); ?>
                </div>
                <?php echo $form->textField($model, 'height', array('placeholder' => $model->getAttributeLabel('height'), 'class' => 'span12 col-sm-6')); ?>
                <?php echo $form->error($model, 'groupsize'); ?>
            </div>
        </div>
        <?php if (ClaSite::isSupperAdminSession()) { ?>
            <div class="control-group form-group">

                <div class="form-group no-margin-left">
                    <div class="col-sm-2"></div>
                    <div class="controls col-sm-10" id="choselecturer">
                        <div>
                            <div class="form-group col-xs-12">
                                <?php echo $form->textArea($model, "banner_group_style", array('class' => 'span10 col-xs-12')); ?>
                                <?php echo $form->error($model, 'banner_group_style'); ?>
                            </div>
                            <div class="form-group col-xs-12">
                                <p style="font-size: 11px;color: blue">Lưu ý: Nhập theo cú pháp json <span style="color: red">{"key":"value","key1":"value1",..}</span> VD:</p>
                                <p style="font-size: 11px;color: blue">{"fade":"fade","boxfade":"boxfade"}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="control-group form-group buttons" style="border-bottom: none;">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('banner', 'banner_group_create') : Yii::t('banner', 'banner_group_edit'), array('class' => 'btn btn-info', 'id' => 'savebanner')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->