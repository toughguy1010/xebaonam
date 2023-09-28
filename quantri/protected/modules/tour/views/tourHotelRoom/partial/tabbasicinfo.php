<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<?php if (!$model->isNewRecord) { ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
            <?php echo $form->error($model, 'alias'); ?>
        </div>
    </div>
<?php } ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'hotel_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php asort($option_hotel); ?>
        <?php echo $form->dropDownList($model, 'hotel_id', $option_hotel, array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'hotel_id'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'area', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'area', array('class' => 'span12 col-sm-2')); ?>
        <?php echo $form->error($model, 'area'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">                            
        <?php echo $form->checkBox($model, 'ishot'); ?>
        <?php echo $form->error($model, 'ishot'); ?>
    </div>
</div>
<?php
$range_bed = array_combine(range(0, 10), range(0, 10));
?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'single_bed', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'single_bed', $range_bed, array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'single_bed_bonus', array('class' => 'col-sm-4 align-right')); ?>
        <?php echo $form->dropDownList($model, 'single_bed_bonus', $range_bed, array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'single_bed', array(), true, false); ?>
        <?php echo $form->error($model, 'single_bed_bonus', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'double_bed', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'double_bed', $range_bed, array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'double_bed_bonus', array('class' => 'col-sm-4 align-right')); ?>
        <?php echo $form->dropDownList($model, 'double_bed_bonus', $range_bed, array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'double_bed', array(), true, false); ?>
        <?php echo $form->error($model, 'double_bed_bonus', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'person_limit', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'person_limit', array('class' => 'span12 col-sm-2')); ?>
        <?php echo $form->error($model, 'person_limit'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'price_market', array('class' => 'col-sm-4 align-right')); ?>
        <?php echo $form->textField($model, 'price_market', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'price', array(), true, false); ?>
        <?php echo $form->error($model, 'price_market', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price_three_bed', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price_three_bed', array('class' => 'numberFormat span12 col-sm-2')); ?>
        <?php echo $form->error($model, 'price_three_bed'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'apply_price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
            'model' => $model, //Model object
            'name' => 'TourHotelRoom[apply_price]', //attribute name
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
            'value' => ((int) $model->apply_price > 0 ) ? date('d-m-Y H:i:s', (int) $model->apply_price) : date('d-m-Y H:i:s'),
            'language' => 'vi',
            'options' => array(
                'showSecond' => true,
                'dateFormat' => 'dd-mm-yy',
                'timeFormat' => 'HH:mm:ss',
                'controlType' => 'select',
                'stepHour' => 1,
                'stepMinute' => 1,
                'stepSecond' => 1,
                //'showOn' => 'button',
                'showSecond' => true,
                'changeMonth' => true,
                'changeYear' => false,
                'tabularLevel' => null,
            //'addSliderAccess' => true,
            //'sliderAccessArgs' => array('touchonly' => false),
            ), // jquery plugin options
            'htmlOptions' => array(
                'class' => 'span12 col-sm-4',
            )
        ));
        ?>
        <?php echo $form->error($model, 'apply_price'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'apply_price_end', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
            'model' => $model, //Model object
            'name' => 'TourHotelRoom[apply_price_end]', //attribute name
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
            'value' => ((int) $model->apply_price_end > 0 ) ? date('d-m-Y H:i:s', (int) $model->apply_price_end) : date('d-m-Y H:i:s'),
            'language' => 'vi',
            'options' => array(
                'showSecond' => true,
                'dateFormat' => 'dd-mm-yy',
                'timeFormat' => 'HH:mm:ss',
                'controlType' => 'select',
                'stepHour' => 1,
                'stepMinute' => 1,
                'stepSecond' => 1,
                //'showOn' => 'button',
                'showSecond' => true,
                'changeMonth' => true,
                'changeYear' => false,
                'tabularLevel' => null,
            //'addSliderAccess' => true,
            //'sliderAccessArgs' => array('touchonly' => false),
            ), // jquery plugin options
            'htmlOptions' => array(
                'class' => 'span12 col-sm-4',
            )
        ));
        ?>
        <?php echo $form->error($model, 'apply_price_end'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'show_apply_price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php asort($option_hotel); ?>
        <?php echo $form->dropDownList($model, 'show_apply_price', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'show_apply_price'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'position', array('class' => 'col-sm-4 align-right')); ?>
        <?php echo $form->textField($model, 'position', array('class' => 'col-sm-2')); ?>
        <?php echo $form->error($model, 'status', array(), true, false); ?>
        <?php echo $form->error($model, 'position', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'percent_discount', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'percent_discount', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'percent_discount', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'state', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'state', array(1 => 'Còn phòng', 0 => 'Hết phòng'), array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'display_state', array('class' => 'col-sm-4 align-right')); ?>
        <?php echo $form->checkBox($model, 'display_state'); ?>
        <?php echo $form->error($model, 'state', array(), true, false); ?>
        <?php echo $form->error($model, 'display_state', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'surcharge_weekend', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'surcharge_weekend', array(1 => 'Có', 0 => 'Không'), array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'surcharge_holiday', array('class' => 'col-sm-4 align-right')); ?>
        <?php echo $form->dropDownList($model, 'surcharge_holiday', array(1 => 'Có', 0 => 'Không'), array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->error($model, 'surcharge_weekend', array(), true, false); ?>
        <?php echo $form->error($model, 'surcharge_holiday', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'surcharge_weekend_price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'surcharge_weekend_price', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'surcharge_holiday_price', array('class' => 'col-sm-4 align-right')); ?>
        <?php echo $form->textField($model, 'surcharge_holiday_price', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'surcharge_weekend_price', array(), true, false); ?>
        <?php echo $form->error($model, 'surcharge_holiday_price', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'sort_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'sort_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'sort_description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>
<input type="hidden" name="url_back" value="<?php echo Yii::app()->request->urlReferrer; ?>" />