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
                <div class="form-group no-margin-left">
                    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left ')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'name'); ?>
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
                    <?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                    <div class="controls col-sm-10">
                        <?php echo $form->dropDownList($model, 'type', ExpertransService::getType(), array('class' => 'span12 col-sm-12')); ?>
                        <?php echo $form->error($model, 'type'); ?>
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
    function update(e, item_id) {
        $(".loading-shoppingcart").show();
        var item_id = item_id;
        var order_num = e.value;
        var url = "<?php echo Yii::app()->createUrl("/economy/productgroups/updateOrder", array("id" => $model->id));?>";
        $.ajax({
            url: url,
            dataType: "json",
            data: {item_id: item_id, order_num: order_num},
            success: function (msg) {
                $(".loading-shoppingcart").hide();
                if (msg.code != 200){
                    location.reload();
                }
            }
        });
    }
</script>