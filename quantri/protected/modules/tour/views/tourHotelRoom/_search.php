<div class="form-search">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $option_hotel = TourHotel::getArrayOptionHotel();
    asort($option_hotel);
    ?>

    <?php echo $form->textField($model, 'name', array('class' => '', 'placeholder' => $model->getAttributeLabel('name'))); ?>
    <select data-placeholder="Chọn khách sạn..." name="TourHotelRoom[hotel_id]" id="TourHotelRoom_hotel_id" class="chosen-select-hotel" style="width:350px;" tabindex="2">
        <?php foreach ($option_hotel as $hotel_id => $hotel_name) { ?>
            <option <?php echo $model->hotel_id == $hotel_id ? 'selected' : '' ?> value="<?php echo $hotel_id ?>"><?php echo $hotel_name ?></option>
        <?php } ?>
    </select>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->