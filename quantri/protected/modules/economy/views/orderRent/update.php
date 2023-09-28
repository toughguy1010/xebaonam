<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box transparent invoice-box">
                    <div class="widget-body">
                        <div class="widget-main padding-24">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                            <b><?php echo Yii::t('shoppingcart', '') ?></b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <ul class="list-unstyled spaced">
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Tên khách hàng: </span>
                                                <?php echo $model['name'] ?>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Số điện thoại: </span>
                                                <b class="blue"><?php echo $model['phone'] ?></b>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Địa chỉ email: </span>
                                                <?php echo $model['email'] ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Địa điểm nhận hàng: </span>
                                                <i class="icon-caret-right blue"></i>
                                                <?php
                                                $province = LibProvinces::getProvinceDetail($model['province_id']);
                                                $district = LibDistricts::getDistrictDetail($model['district_id']);
                                                echo $province['name'].' - '.$district['name'].' - ';
                                                ?>
                                                <?php echo $model['receive_address_name'] ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Địa điểm trả hàng: </span>
                                                <?php
                                                $return_province = LibProvinces::getProvinceDetail($model['return_province_id']);
                                                $return_district = LibDistricts::getDistrictDetail($model['return_district_id']);
                                                echo $return_province['name'].' - '.$return_district['name'].' - ';
                                                ?>
                                                <?php echo $model['return_address_name'] ?>
                                            </li>

                                            <li class="divider"></li>
                                        </ul>
                                    </div>
                                </div><!-- /span -->
                            </div><!-- row -->

                            <div class="space"></div>
                            <div>
                                <?php $this->renderPartial('_products_bill_admin', array('items' => $items)); ?>
                            </div>
                            <div class="space-6"></div>
                            <div>
                                <ul>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        <span>Giá thuê đồ (1) : </span>
                                        <?php echo HtmlFormat::money_format($model->total_product_price) .' '. $model->currency?>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        <span>Vat (0%) (2) : </span>
                                        <?php echo HtmlFormat::money_format($model->vat) .' '. $model->currency?>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        <span>Tiền đặt cọc (3) : </span>
                                        <?php echo HtmlFormat::money_format($model->deposits) .' '. $model->currency?>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        <span>Phí bảo hiểm(4) : </span>
                                        <?php echo HtmlFormat::money_format($model->insurance) .' '. $model->currency?>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        <span>Phí ship (5) : </span>
                                        <?php echo HtmlFormat::money_format($model->ship_fee) .' '. $model->currency?>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        <span>Phí trả thiết bị (6) : </span>
                                        <?php echo HtmlFormat::money_format($model->return_fee) .' '. $model->currency?>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        <span>Số tiền thanh toán (1+2+3+4+5+6) : </span>
                                        <?php echo ($model->total_price != '0.00') ? HtmlFormat::money_format($model->total_price) . ' ' . $model->currency : 'Liên hệ' ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="hr hr8 hr-double hr-dotted"></div>

                            <?php if ($model['note']) { ?>
                                <div class="well">
                                    <?php echo $model['note'] ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div>