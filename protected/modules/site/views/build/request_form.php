<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'w3ncreate-form',
    'action' => Yii::app()->createUrl('/site/request/create'),
    'enableClientValidation' => true,
    'clientOptions' => array(
    //'validateOnSubmit' => true,
    ),
        ));
?>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'control-label no-padding-left')); ?>
    <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'name'); ?>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'control-label no-padding-left')); ?>
    <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'phone'); ?>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'email', array('class' => 'control-label no-padding-left')); ?>
    <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'email'); ?>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'address', array('class' => 'control-label no-padding-left')); ?>
    <?php echo $form->textField($model, 'address', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'address'); ?>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'trade', array('class' => 'control-label no-padding-left')); ?>
    <?php echo $form->textField($model, 'trade', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'trade'); ?>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'website_reference', array('class' => 'control-label no-padding-left')); ?>
    <?php echo $form->textArea($model, 'website_reference', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'website_reference'); ?>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'color', array('class' => 'control-label no-padding-left')); ?>
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
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'description', array('class' => 'control-label no-padding-left')); ?>
    <?php echo $form->textArea($model, 'description', array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'description'); ?>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'captcha'); ?>
    <div class="input-group">

        <?php echo $form->textField($model, 'captcha', array('class' => 'form-control')); ?>
        <span class="input-group-addon" style="padding: 0px 5px; min-width: 110px;">
            <?php
            $this->widget('CCaptcha', array(
                'buttonLabel' => '<i class="ico ico-refrest"></i>',
                'captchaAction' => Yii::app()->createUrl('/site/request/captcha'),
                'imageOptions' => array(
                    'height' => '34px',
                ),
            ));
            ?>
        </span>
    </div>
    <div>
        <?php echo $form->error($model, 'captcha', array('hideErrorMessage' => true)); ?>
    </div>
</div>
<?php echo $form->hiddenField($model, 'theme_id'); ?>
<div class="control-group form-group">
    <?php echo CHtml::submitButton(Yii::t('common', 'sendrequest'), array('class' => 'btn btn-primary', 'id' => 'sendrequest')); ?> 
</div>

<?php $this->endWidget(); ?>
<!-- Google Code for V&agrave;o trang b&aacute;o gi&aacute; Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 930801583;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "RGrfCLi7x2QQr8_ruwM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/930801583/?label=RGrfCLi7x2QQr8_ruwM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>