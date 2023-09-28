<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'redirects-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'from_url', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'from_url', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'from_url'); ?>
                <p class="text-warning">
                    <?php echo $model->getAttributeLabel('from_url'); ?> là link tương đối không chứa tên miền và bắt đầu bằng ký tự '/'. Ví dụ link: "http://nanoweb.vn/gioi-thieu" chỉ cần điền là "/gioi-thieu"
                </p>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'to_url', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'to_url', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'to_url'); ?>
                 <p class="text-warning">
                    <?php echo $model->getAttributeLabel('to_url'); ?> là link đầy đủ chứa tên miền. Ví dụ: http://nanoweb.vn/lien-he 
                </p>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'save'), array('class' => 'btn btn-info', 'id' => 'saveRedirect')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>