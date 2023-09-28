<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/selectize/dist/css/selectize.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/selectize/dist/js/standalone/selectize.js"></script>
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
                <hr>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'country', array('class' => 'col-sm-2 control-label no-padding-left ')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'country', ['' => 'Chọn quốc gia'] + ClaLanguage::getCountries(), array('class' => '  select-beast')); ?>
                        <?php echo $form->error($model, 'country'); ?>
                    </div>
                </div>
                <hr>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'from_lang', array('class' => 'col-sm-2 control-label no-padding-left ')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'from_lang', ['' => 'Chọn ngôn ngữ gốc'] + ClaLanguage::getCountries(), array('class' => '  select-beast')); ?>
                        <?php echo $form->error($model, 'from_lang'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'to_lang', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'to_lang', ['' => 'Chọn ngôn ngữ đích'] + ClaLanguage::getCountries(), array('class' => ' select-beast')); ?>
                        <?php echo $form->error($model, 'to_lang'); ?>
                    </div>
                </div>
                <hr>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'escort_negotiation_inter_price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->textField($model, 'escort_negotiation_inter_price', array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'escort_negotiation_inter_price'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'consecutive_inter_price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->textField($model, 'consecutive_inter_price', array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'consecutive_inter_price'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'simultaneous_inter_price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->textField($model, 'simultaneous_inter_price', array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'simultaneous_inter_price'); ?>
                    </div>
                </div>
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'aff_percent', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->textField($model, 'aff_percent', array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'aff_percent'); ?>
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
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('translate', 'translate_create') : Yii::t('translate', 'translate_edit'), array('class' => 'btn btn-info', 'id' => 'savetranslate')); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div><!-- form -->
<style>

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