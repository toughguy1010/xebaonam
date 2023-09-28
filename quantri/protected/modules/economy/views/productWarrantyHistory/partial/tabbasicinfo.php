<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'product_warranty_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div id="product_id">
            <!--asort($option_hotel);-->
            <select data-placeholder="Chọn sản phẩm" name="ProductWarrantyHistory[product_warranty_id]"
                    id="ProductWarranty_product_warranty_id"
                    class="chosen-product span12 col-sm-6" tabindex="2">
                <?php foreach ($option_product as $option_product_id => $option_product_name) { ?>
                    <option <?php echo $model->product_warranty_id == $option_product_id ? 'selected' : '' ?>
                        value="<?php echo $option_product_id ?>"><?php echo $option_product_name ?></option>
                <?php } ?>
            </select>
            <?php echo $form->hiddenField($model, 'product_name',
                array('class' => 'span12 col-sm-6'));
            ?>
        </div>
        <div class="controls col-sm-6">
            <input type="checkbox" id="another_product" <?php echo ($model->product_warranty_id) ? '' : 'checked' ?>>
            <span>Sản phẩm bán ra</span>
        </div>
        <?php echo $form->error($model, 'product_warranty_id'); ?>
    </div>
</div>
<div id="info">
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'imei', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'imei', array('class' => 'span12 col-sm-6')); ?>
            <?php echo $form->error($model, 'imei'); ?>
        </div>
    </div>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'product_name', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'product_name', array('class' => 'span12 col-sm-6')); ?>
            <?php echo $form->error($model, 'product_name'); ?>
        </div>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'receipt_date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-4">
        <div class="input-group input-group-sm">
            <?php
            $date = DateTime::createFromFormat('Y-m-d', $model->receipt_date);

            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                'model' => $model, //Model object
                'name' => 'ProductWarrantyHistory[receipt_date]', //attribute name
                'mode' => 'date',
                'value' => ($date) ? ($date->format('d/m/Y')) : '',
                'language' => Yii::app()->language,
                'options' => array(
                    'showSecond' => true,
                    'dateFormat' => 'dd/mm/yy',
                    'timeFormat' => '',
                    'controlType' => 'select',
                    //'showOn' => 'button',
                    'tabularLevel' => null,
                    'addSliderAccess' => true,
                    'sliderAccessArgs' => array('touchonly' => false),
                ), // jquery plugin options
                'htmlOptions' => array(
                    'class' => 'form-control',
                )
            ));
            ?>
            <span class="input-group-addon">
                        <i class="icon-calendar"></i>
                    </span>
        </div>
        <?php echo $form->error($model, 'receipt_date'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'expected_date', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-4">
        <div class="input-group input-group-sm">
            <?php
            $date = DateTime::createFromFormat('Y-m-d', $model->returns_date);
            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                'model' => $model, //Model object
                'name' => 'ProductWarrantyHistory[expected_date]', //attribute name
                'mode' => 'date',
                'value' => ($date) ? ($date->format('d/m/Y')) : '',
                'language' => Yii::app()->language,
                'options' => array(
                    'showSecond' => true,
                    'dateFormat' => 'dd/mm/yy',
                    'timeFormat' => '',
                    'controlType' => 'select',
                    //'showOn' => 'button',
                    'tabularLevel' => null,
                    'addSliderAccess' => true,
                    'sliderAccessArgs' => array('touchonly' => false),
                ), // jquery plugin options
                'htmlOptions' => array(
                    'class' => 'form-control',
                )
            ));
            ?>
            <span class="input-group-addon">
                        <i class="icon-calendar"></i>
                    </span>
        </div>
        <?php echo $form->error($model, 'expected_date'); ?>
    </div>
</div>
<!--<div class="form-group no-margin-left">-->
<!--    --><?php //echo $form->labelEx($model, 'returns_date', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
<!--    <div class="controls col-sm-4">-->
<!--        <div class="input-group input-group-sm">-->
<!--            --><?php
//            $date = DateTime::createFromFormat('Y-m-d', $model->returns_date);
//            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
//                'model' => $model, //Model object
//                'name' => 'ProductWarrantyHistory[returns_date]', //attribute name
//                'mode' => 'date',
//                'value' => ($date) ? ($date->format('d/m/Y')) : '',
//                'language' => Yii::app()->language,
//                'options' => array(
//                    'showSecond' => true,
//                    'dateFormat' => 'dd/mm/yy',
//                    'timeFormat' => '',
//                    'controlType' => 'select',
//                    //'showOn' => 'button',
//                    'tabularLevel' => null,
//                    'addSliderAccess' => true,
//                    'sliderAccessArgs' => array('touchonly' => false),
//                ), // jquery plugin options
//                'htmlOptions' => array(
//                    'class' => 'form-control',
//                )
//            ));
//            ?>
<!--            <span class="input-group-addon">-->
<!--                        <i class="icon-calendar"></i>-->
<!--                    </span>-->
<!--        </div>-->
<!--        --><?php //echo $form->error($model, 'returns_date'); ?>
<!--    </div>-->
<!--</div>-->
<hr>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'sender', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'sender', array('class' => 'span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'sender'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'email', array('class' => 'span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone', array('class' => 'span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'note', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'note', array('class' => 'span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'note'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'receive', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'receive', array('class' => 'span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'receive'); ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        var warranty_product_id = $('#another_product').is(':checked');
        if (!warranty_product_id) {
            $('#info').css('display', 'block');
        } else {
            $('#product_id').css('display', 'block');
            $('#info').css('display', 'none');
        }

        $('#another_product').click(function () {
            if ($(this).is(':checked')) {
                $('#info').css('display', 'none');
                $('#product_id').css('display', 'block');
            } else {
                $('#info').css('display', 'block');
                $('#product_id').css('display', 'none');
            }
        });
    })
</script>
