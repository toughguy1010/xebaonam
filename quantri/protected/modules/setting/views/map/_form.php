<div style="width: 400px; max-width: 100%; display:inline-block; padding-top: 25px;">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'maps-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'action' => ($model->isNewRecord && !$model->id) ? Yii::app()->createUrl('/setting/map/create') : Yii::app()->createUrl('/setting/map/update', $_GET),
            'htmlOptions' => array(
                'class' => 'form-horizontal',
                'enctype' => 'multipart/form-data',
            ),
        ));
        ?>

        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>

        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>

        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->textField($model, 'email', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>

        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->textField($model, 'phone', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>

        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'website', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->textField($model, 'website', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'website'); ?>
            </div>
        </div>

        <div class="  control-group form-group">
            <?php echo $form->labelEx($model, 'headoffice', array('class' => 'col-sm-4 control-label no-padding-left')); ?>
            <div class="controls col-sm-8">
                <?php echo $form->checkBox($model, 'headoffice'); ?>
                <?php echo $form->error($model, 'headoffice'); ?>
                <?php echo $form->hiddenField($model, 'latlng'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons" style="border-bottom: none;">
            <?php echo CHtml::submitButton(($model->isNewRecord && !$model->id) ? Yii::t('common', 'create') : Yii::t('common', 'update'), array('class' => 'btn btn-sm btn-info', 'id' => 'savemap')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->