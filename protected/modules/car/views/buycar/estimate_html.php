<div class="col-lg-5" style="padding:0">
    <div class="col-lg-12" style="padding:0">
        <div style="font-weight:bold;font-size:15px">CHI PHÍ DỰ TÍNH</div>
        <div style="color:#337ab7;font-size:25px"> <?php echo number_format($total_price, 0, '', '.'); ?> VNĐ</div>
        <a href="#" data-toggle="modal" data-target=".detail" class="btn btn-primary" style="margin-top: 41px; width: 97px;">Chi tiết</a>
        <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('car/buycar/supportBuycar', array('cid' => $car->id, 'vid' => $version->id)); ?>" style="margin-top: 41px;width: 120px; ">
            Hỗ trợ trả góp
        </a>
    </div>
    <div class="modal fade detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index:1000000">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header alert-info fade in">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myLargeModalLabel">CHI PHÍ DỰ TÍNH<a class="anchorjs-link" href="#myLargeModalLabel"><span class="anchorjs-icon"></span></a></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img class="img-responsive" src="<?php echo ClaHost::getImageHost() . $car->avatar_path . $car->avatar_name ?>" />
                            <div style="text-align:center"><?php echo $version->name; ?></div>
                        </div>
                        <div class="col-md-6">
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
                                <div class="col-sm-4"><?php echo number_format(($regional->registration_fee * $price)/100 ); ?></div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-7">
    <div>
        <img class="img-responsive" src="<?php echo ClaHost::getImageHost() . $car->avatar_path . $car->avatar_name ?>" />
    </div>

</div>