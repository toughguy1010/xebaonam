<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'customform',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'form_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'form_name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'form_name'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'sendmail', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->checkBox($model, 'sendmail'); ?>
                <?php echo $form->error($model, 'sendmail'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'mail_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                 <?php echo $form->dropDownList($model, 'mail_id', MailSettings::getMailOptions(), array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'mail_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'sendsms', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->checkBox($model, 'sendsms'); ?>
                <?php echo $form->error($model, 'sendsms'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'form_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'form_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'form_description'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo CHtml::label('Fields', '', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php $this->renderPartial('_item', array('listfields' => (isset($listfields) ? $listfields : array()), 'form' => $model)); ?>
            </div> 
        </div>

        <div class="control-group buttons">
            <?php
            $datahref = Yii::app()->createUrl('/custom/customform/createajax');
            echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn', 'id' => 'savestep', 'data-href' => $datahref));
            ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>