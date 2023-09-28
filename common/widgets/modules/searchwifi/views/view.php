<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('economy/rentcart/order'),
    'method' => 'GET',
    'id' => 'search_wifi',
    'htmlOptions' => array('class' => 'form-horizontal'),
));
$model = new BillingRentCart();
?>
<div class="search-engine">
    <div class="title center">
        <h2>Tìm kiếm</h2>
    </div>
    <div class="flex-row">

        <div class="flex-col item-search-engine">
            <label for="">Điểm đến</label>
            <div class="location">
                <?php echo $form->dropDownList($model, 'rent_product_id', $option_product, array('class' => '')); ?>
            </div>
        </div>
        <div class="flex-col item-search-engine">
            <label for="">Ngày đi</label>
            <div class="calendar">
                <input class="input-date " type="text" name="date_from" value="01/01/2015">
            </div>
        </div>
        <div class="flex-col item-search-engine">
            <label for="">Ngày về</label>
            <div class="calendar">
                <input class="input-date " type="text" name="daterange" value="01/01/2015">
            </div>
        </div>
        <button class="btn-style-2 btn-show-search" type="submit"><span>Đặt ngay</span></button>
        <div class="close-btn"></div>
    </div>
</div>
<?php $this->endWidget(); ?>
