<div class="cont">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'rma-form',
        'action' => Yii::app()->createUrl('economy/rma'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal newsletter-form'),
    ));
    ?>
    <div class="fieldset">
        <h2 class="legend">Company Information</h2>
        <ul class="form-list">
            <li>
                <div class="field">
                    <?= CHtml::activeLabelEx($model, 'company_name'); ?>
                    <div class="input-box">
                        <?php echo CHtml::activeTextField($model, 'company_name'); ?>
                    </div>
                </div>
                <div class="field">
                    <?= CHtml::activeLabelEx($model, 'email'); ?>
                    <div class="input-box">
                        <?php echo CHtml::activeTextField($model, 'email'); ?>
                    </div>
                </div>
                <div class="field">
                    <?= CHtml::activeLabelEx($model, 'contact_person'); ?>
                    <div class="input-box">
                        <?php echo CHtml::activeTextField($model, 'contact_person'); ?>
                    </div>
                </div>
                <div class="field">
                    <?= CHtml::activeLabelEx($model, 'telephone'); ?>
                    <div class="input-box">
                        <?php echo CHtml::activeTextField($model, 'telephone'); ?>
                    </div>
                </div>
                <div class="field">
                    <?= CHtml::activeLabelEx($model, 'purchase_order'); ?>
                    <div class="input-box">
                        <?php echo CHtml::activeTextField($model, 'purchase_order'); ?>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="fieldset fieldset-items ">
        <h2 class="legend">Items</h2>
        <?php if (count($modelItems)) {
            foreach ($modelItems as $key => $modelItem) {
                ?>
                <ul class="form-list  form-list<?= $key ?>">
                    <li>
                        <div class="field">
                            <?= CHtml::activeLabelEx($modelItem, '[' . $key . ']product_description'); ?>
                            <div class="input-box">
                                <?php echo CHtml::activeTextField($modelItem, '[' . $key . ']product_description'); ?>
                            </div>
                        </div>
                        <div class="field">
                            <?= CHtml::activeLabelEx($modelItem, '[' . $key . ']serial'); ?>
                            <div class="input-box">
                                <?php echo CHtml::activeTextField($modelItem, '[' . $key . ']serial'); ?>
                            </div>
                        </div>
                        <div class="field">
                            <?= CHtml::activeLabelEx($modelItem, '[' . $key . ']part'); ?>
                            <div class="input-box">
                                <?php echo CHtml::activeTextField($modelItem, '[' . $key . ']part'); ?>
                            </div>
                        </div>
                        <div class="field">
                            <?= CHtml::activeLabelEx($modelItem, '[' . $key . ']condition'); ?>
                            <div class="input-box">
                                <?php echo CHtml::activeDropDownList($modelItem, '[' . $key . ']condition', RmaItems::getCondition()); ?>
                            </div>
                        </div>
                        <div class="field">
                            <?= CHtml::activeLabelEx($modelItem, '[' . $key . ']reasion'); ?>
                            <div class="input-box">
                                <?php echo CHtml::activeDropDownList($modelItem, '[' . $key . ']reasion', RmaItems::getReason()); ?>
                            </div>
                        </div>
                        <div class="field">
                            <?= CHtml::activeLabelEx($modelItem, '[' . $key . ']rma_type'); ?>
                            <div class="input-box">
                                <?php echo CHtml::activeDropDownList($modelItem, '[' . $key . ']rma_type', RmaItems::getRmaType()); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            <?php } ?>
        <?php } ?>
    </div>
    <button class="btn" type="button">Add Item</button>
    <div class="fieldset">
        <h2 class="legend">Additional Information</h2>
        <ul class="form-list">
            <li>
                <div class="field">
                    <?= CHtml::activeLabelEx($model, 'shipping_issue'); ?>
                    <div class="input-box">
                        <?php echo CHtml::activeRadioButtonList($model, 'shipping_issue', ['No', 'Yes']); ?>
                    </div>
                </div>
                <div class="field">
                    <?= CHtml::activeLabelEx($model, 'package_damage'); ?>
                    <div class="input-box">
                        <?php echo CHtml::activeRadioButtonList($model, 'package_damage', ['No', 'Yes']); ?>
                    </div>
                </div>
                <div class="field">
                    <?= CHtml::activeLabelEx($model, 'carrier_notified'); ?>
                    <div class="input-box">
                        <?php echo CHtml::activeRadioButtonList($model, 'carrier_notified', ['No', 'Yes']); ?>
                    </div>
                </div>
                <div class="field">
                    <?= CHtml::activeLabelEx($model, 'quote'); ?>
                    <div class="input-box">
                        <?php echo CHtml::activeTextArea($model, 'quote'); ?>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <button>Submit</button>
    <script>
        var html = '';

        function renderHtml($options) {
            return html = "<ul class=\"form-list  form-list" + $options + " \">\n" +
                "            <li>\n" +
                "                <div class=\"field\">\n" +
                "                    <label for=\"RmaItems_" + $options + "_product_description\">Product Description</label>                    <div class=\"input-box\">\n" +
                "                        <input name=\"RmaItems[" + $options + "][product_description]\" id=\"RmaItems_" + $options + "_product_description\" maxlength=\"255\" type=\"text\">                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"field\">\n" +
                "                    <label for=\"RmaItems_" + $options + "_serial\">Serial</label>                    <div class=\"input-box\">\n" +
                "                        <input name=\"RmaItems[" + $options + "][serial]\" id=\"RmaItems_" + $options + "_serial\" maxlength=\"255\" type=\"text\">                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"field\">\n" +
                "                    <label for=\"RmaItems_" + $options + "_part\">Part</label>                    <div class=\"input-box\">\n" +
                "                        <input name=\"RmaItems[" + $options + "][part]\" id=\"RmaItems_" + $options + "_part\" maxlength=\"255\" type=\"text\">                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"field\">\n" +
                "                    <label for=\"RmaItems_" + $options + "_condition\">Condition</label>                    <div class=\"input-box\">\n" +
                "                        <select name=\"RmaItems[" + $options + "][condition]\" id=\"RmaItems_" + $options + "_condition\">\n" +
                "<option value=\"Factory Sealed\">Factory Sealed</option>\n" +
                "<option value=\"Opened\">Opened</option>\n" +
                "</select>                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"field\">\n" +
                "                    <label for=\"RmaItems_" + $options + "_reasion\">Reasion</label>                    <div class=\"input-box\">\n" +
                "                        <select name=\"RmaItems[" + $options + "][reasion]\" id=\"RmaItems_" + $options + "_reasion\">\n" +
                "<option value=\"Dead on Arrival\">Dead on Arrival</option>\n" +
                "<option value=\"Failed in Silence\">Failed in Silence</option>\n" +
                "<option value=\"Damaged\">Damaged</option>\n" +
                "<option value=\"Missing Components\">Missing Components</option>\n" +
                "<option value=\"Wrong Product Shipped\">Wrong Product Shipped</option>\n" +
                "<option value=\"Wrong Product Ordered\">Wrong Product Ordered</option>\n" +
                "</select>                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"field\">\n" +
                "                    <label for=\"RmaItems_" + $options + "_rma_type\">Rma Type</label>                    <div class=\"input-box\">\n" +
                "                        <select name=\"RmaItems[" + $options + "][rma_type]\" id=\"RmaItems_" + $options + "_rma_type\">\n" +
                "<option value=\"Credit \">Credit</option>\n" +
                "<option value=\"Replacement\">Replacement</option>\n" +
                "</select>                    </div>\n" +
                "                </div>\n" +
                "                <button type=\"button\" data-form-id=\"form-list" + $options + "\" onclick=\" removeThis(this)  \"> - </button>\n" +
                "            </li>\n" +
                "        </ul>";
        }

        function removeThis(ev) {
            var dataFormId = '.' + $(ev).attr('data-form-id');
            $(dataFormId).html('');
        }

        $(document).ready(function () {
            var number = <?=$key?>;

            $('.btn').on('click', function () {
                $('.fieldset-items').append(renderHtml(++number));
            })
        })
    </script>
    <?php $this->endWidget(); ?>
</div>