<!--<link rel="stylesheet" href="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/selectize/dist/css/selectize.css"></link>-->
<!--<script src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/selectize/dist/js/standalone/selectize.js"></script>-->
<?php
/* @var $this TranslateLanguageController */
/* @var $model TranslateLanguage */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'tour-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        $from_create = Yii::app()->request->getParam('create');
        ?>
        <div class="tabbable">
            <div class="tab-content">
                <p class="note">Fields with <span class="required">*</span> are required.</p>
                <?php echo $form->errorSummary($model); ?>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'lang_id', array('class' => 'col-sm-2 control-label no-padding-left ')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'lang_id', TranslateLanguage::getAllLanguageId(), array('class' => '  select-beast')); ?>
                        <?php echo $form->error($model, 'lang_id'); ?>
                    </div>
                </div>

                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'option_id', array('class' => 'col-sm-2 control-label no-padding-left ')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'option_id', TranslateOption::getAllOptionId(), array('class' => '  select-beast')); ?>
                        <?php echo $form->error($model, 'option_id'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->textField($model, 'price', array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'price'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'currency', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'currency', TranslateLanguage::$_dataCurrency, array('class' => 'span9 col-sm-12')); ?>
                        <?php echo $form->error($model, 'currency'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left buttons">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('translate', 'translate_language_option_create') : Yii::t('translate', 'translate_language_option_edit'), array('class' => 'btn btn-info', 'id' => 'savetranslate')); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div><!-- form -->
<style>
    .required {
        color: red;
    }
</style>
<script>
    $(document).ready(function () {
        $('.select-beast').selectize({
            create: false,
            sortField: 'text'
        });

        $('#percent_discount').keyup(function () {
            var percent = $(this).val();
            var price_market = $('#TranslateLanguage_price').val();
            price_market = w3n.ToNumber(price_market);
            add_price(price_market, percent);
        });
    })
    function add_price(price_market, percent) {
        if (percent > 0) {
            var price = price_market * ((100 - percent) / 100);
            var price_temp = w3n.ToNumber(price);
            var formatNumber = w3n.FormatNumber(price_temp);
            console.log(formatNumber)
            $('#TranslateLanguage_price').val(formatNumber);
        }
    }
</script>