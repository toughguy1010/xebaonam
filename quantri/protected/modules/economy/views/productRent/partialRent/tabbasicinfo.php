<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'product_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <!--asort($option_hotel);-->
        <select data-placeholder="Chọn sản phẩm" name="ProductToRent[product_id]" id="ProductToRent_product_id"
                class="chosen-product span12 col-sm-6" tabindex="2">
            <?php foreach ($option_product as $option_product_id => $option_product_name) { ?>
                <option <?php echo $model->product_id == $option_product_id ? 'selected' : '' ?>
                    value="<?php echo $option_product_id ?>"><?php echo $option_product_name ?></option>
            <?php } ?>
        </select>
        <?php echo $form->hiddenField($model, 'display_name',
            array('class' => 'span12 col-sm-6'));
        ?>
        <?php echo $form->error($model, 'display_name'); ?>
    </div>
    <div class="controls col-sx-2">
    </div>
</div>
<hr>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price_day_1', array('class' => ' col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price_day_1', array('class' => 'numberFormat span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'price_day_1'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price_day_2', array('class' => ' col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price_day_2', array('class' => 'numberFormat span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'price_day_2'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price_day_3', array('class' => ' col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price_day_3', array('class' => 'numberFormat span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'price_day_3'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'order', array('class' => ' col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'order', array('class' => 'numberFormat span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'order'); ?>
    </div>
</div>
