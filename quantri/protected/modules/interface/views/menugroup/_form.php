<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'menu-groups-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_group_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <?php echo $form->textField($model, 'menu_group_name', array('class' => 'span12 col-sm-12')); ?>
            <div class="col-sm-12 help-block no-padding">
                <?php echo $form->error($model, 'menu_group_name'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_group_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <?php echo $form->textArea($model, 'menu_group_description', array('class' => 'span12 col-sm-12')); ?>
            <div class="col-sm-12 help-block no-padding">
                <?php echo $form->error($model, 'menu_group_description'); ?>
            </div>
        </div>



        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->