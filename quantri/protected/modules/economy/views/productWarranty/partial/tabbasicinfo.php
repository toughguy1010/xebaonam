<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'product_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <!--asort($option_hotel);-->
        <select data-placeholder="Chọn sản phẩm" name="ProductWarranty[product_id]" id="ProductWarranty_product_id"
                class="chosen-product span12 col-sm-6" tabindex="2">
            <?php foreach ($option_product as $option_product_id => $option_product_name) { ?>
                <option <?php echo $model->product_id == $option_product_id ? 'selected' : '' ?>
                    value="<?php echo $option_product_id ?>"><?php echo $option_product_name ?></option>
            <?php } ?>
        </select>
        <?php echo $form->hiddenField($model, 'product_name',
            array('class' => 'span12 col-sm-6'));
        ?>
        <?php echo $form->error($model, 'product_id'); ?>
    </div>
    <div class="controls col-sx-2">
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'imei', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'imei', array('class' => 'span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'imei'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'start_date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-4">
        <div class="input-group input-group-sm">
            <?php
            $date = DateTime::createFromFormat('Y-m-d', $model->start_date);

            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                'model' => $model, //Model object
                'name' => 'ProductWarranty[start_date]', //attribute name
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
        <?php echo $form->error($model, 'start_date'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'end_date', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-4">
        <div class="input-group input-group-sm">
            <?php
            $date = DateTime::createFromFormat('Y-m-d', $model->end_date);
            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                'model' => $model, //Model object
                'name' => 'ProductWarranty[end_date]', //attribute name
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
        <?php echo $form->error($model, 'end_date'); ?>
    </div>
</div>
<hr>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone', array('class' => 'span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left',)); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ProductWarranty::statusArray(), array('class' => 'span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>