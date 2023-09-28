<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'footer-settings-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>


        <?php echo $form->errorSummary($model); ?>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'callus', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'callus', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'callus'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'email', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'email'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'fax', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'fax', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'fax'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'location', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'location', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'location'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'footercontent', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'footercontent', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'footercontent'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Update' : 'Update', array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>