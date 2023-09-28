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
            <?php echo $form->labelEx($model, 'key', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'key', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'key'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'app_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'app_id', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'app_id'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'subDomainName', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'subDomainName', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'subDomainName'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'actionMessage', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'actionMessage', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'actionMessage'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'acceptButtonText', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'acceptButtonText', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'acceptButtonText'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'cancelButtonText', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'cancelButtonText', array('class' => 'span9 col-sm-10')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'cancelButtonText'); ?>
                </span>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>