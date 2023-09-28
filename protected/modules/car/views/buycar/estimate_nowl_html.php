<div class="col-md-12">
    <div class="row">
        <div class="col-sm-8">Giá xe</div>
        <div class="col-sm-4"><?php echo number_format($price, 0, '', '.'); ?></div>
    </div>
    <div class="row">
        <div class="col-sm-8">Mức phí trước bạ</div>
        <div class="col-sm-4"><?php echo $regional->registration_fee; ?> %</div>
    </div>
    <div class="row">
        <div class="col-sm-8">Phí trước bạ</div>
        <div class="col-sm-4"><?php echo number_format(($regional->registration_fee * $price) / 100); ?></div>
    </div>
    <div class="row">
        <div class="col-sm-8">Phí đăng ký</div>
        <div class="col-sm-4"><?php echo number_format($regional->number_plate_fee, 0, '', '.'); ?></div>
    </div>
    <div class="row">
        <div class="col-sm-8"><?php echo yii::t('car', 'inspection_fee') ?></div>
        <div class="col-sm-4"><?php echo number_format($regional->inspection_fee, 0, '', '.'); ?></div>
    </div>
    <div class="row">
        <div class="col-sm-8"><?php echo yii::t('car', 'road_toll') ?></div>
        <div class="col-sm-4"><?php echo number_format($regional->road_toll, 0, '', '.'); ?></div>
    </div>
    <div class="row">
        <div class="col-sm-8"><?php echo yii::t('car', 'insurance_fee') ?></div>
        <div class="col-sm-4"><?php echo number_format($regional->insurance_fee, 0, '', '.'); ?></div>
    </div>

    <div class="row linebottom"></div>
    <div class="row">
        <div class="col-sm-12" style="text-align:center">
            TỔNG CỘNG : <?php echo number_format($total_price, 0, '', '.'); ?> VNĐ
        </div>
    </div>
</div>
<div class="col-lg-7">
    <div>
        <img class="img-responsive"
             src="<?php echo ClaHost::getImageHost() . $car->avatar_path . $car->avatar_name ?>"/>
    </div>

</div>