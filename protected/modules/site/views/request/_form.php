<div class="form row">
    <div class="col-sm-12">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'request-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array('class' => 'form-horizontal'),
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'address', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'trade', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'trade', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'trade'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'website_reference', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'website_reference', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'website_reference'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'color', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                $this->widget('common.extensions.spectrum.MSpectrum', array(
                    'model' => $model,
                    'attribute' => 'color',
                    'options' => array(
                        'clickoutFiresChange' => true,
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-control',
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'color'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'description', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'captcha', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="input-group">

                    <?php echo $form->textField($model, 'captcha', array('class' => 'form-control')); ?>
                    <span class="input-group-addon" style="padding: 0px 5px; min-width: 110px;">
                        <?php
                        $this->widget('CCaptcha', array(
                            'buttonLabel' => '<i class="ico ico-refrest"></i>',
                            'imageOptions' => array(
                                'height' => '34px',
                            ),
                        ));
                        ?>
                    </span>
                </div>
                <div>
                    <?php echo $form->error($model, 'captcha'); ?>
                </div>
            </div>
        </div>
        <div class="control-group form-group">
            <div class="col-sm-offset-2 col-sm-10 w3-form-button">
                <?php echo CHtml::submitButton(Yii::t('common', 'sendrequest'), array('class' => 'btn btn-primary', 'id' => 'sendrequest')); ?> 
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>