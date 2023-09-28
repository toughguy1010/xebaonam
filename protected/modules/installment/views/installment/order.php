<link href="<?php echo Yii::app()->request->baseUrl; ?>/installment/css/order.css" rel="stylesheet"/>
<div class="installment-order">
    <div class="container">
        <div class="order">
            <div class="widget-body">
                <div class="widget-main padding-24">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-xs-12 label label-lg label-info arrowed-in arrowed-right">
                                <b>Thông tin người mua</b>
                            </div>

                            <ul class="list-unstyled spaced">
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Tên: <?php echo $model->username ?>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Số điện thoại: <b class="blue"><?php echo $model->phone ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Email: <?php echo $model->email ?>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Thẻ căn cước, CMND: <b class="blue"><?php echo $model->identity_code ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Ngày sinh: <b class="blue"><?php echo date('d/m/Y', $model->birthday) ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Giới tính: <b class="blue"><?php echo ClaInstallment::getSex($model->sex) ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Địa chỉ: <?php echo $model->address ?>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Tỉnh / TP: <?php
                                    $province = LibProvinces::getProvinceDetail($model->province_id);
                                    echo $province['name'];
                                    ?>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Quận / Huyện: <?php
                                    $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
                                    echo $district['name'];
                                    ?>
                                </li>
                            </ul>
                        </div><!-- /span -->
                        <div class="col-sm-6">
                            <div class="col-xs-12 label label-lg label-success arrowed-in arrowed-right">
                                <b>Thông tin trả góp</b>
                            </div>

                            <?php
                            $installment = Installment::model()->findByPk($model->installment_id);
                            $number_month = $model->month;
                            $count_pre = $model->prepay;
                            $count_insurrance = $model->insurrance;
                            $count_price = $product->price;
                            $array_interes_home = [
                                'number_month' => $number_month,
                                'count_price' => $product->price,
                                'count_pre' => $count_pre,
                            ];
                            $every_month = ClaInstallment::getEveryMonth($number_month, $count_pre, $count_price); // Góp mỗi tháng
                            $count_insurrance_price = ClaInstallment::getInsurrance($every_month, $count_insurrance);
                            $interes_home_cre = ClaInstallment::getInteresBank($every_month, $count_insurrance, $installment->interes / 100, $installment->collection_fee, $array_interes_home);
                            ?>
                            <ul class="list-unstyled spaced">
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Cửa hàng duyệt hồ
                                    sơ: <?php $shop = ShopStore::model()->findByPk($model->shop_id); ?><b
                                            class="red"><?= $shop['name']; ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Công ty tài chính:<b class="red"><?= $installment['name']; ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Loại giấy tờ: <b class="red"><?= ClaInstallment::getPapers($product->price); ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Số tháng trả góp: <b class="red"><?= $model->month; ?> tháng</b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Trả trước: <b
                                            class="red"><?= ($model->prepay * 100) . '% - ' . number_format($model->prepay * $product->price, 0, '', '.') . '₫'; ?></b>
                                </li>


                                <li>
                                    <i class="icon-caret-right"></i>
                                    Trả hàng tháng: <b
                                            class="green"><?= number_format($interes_home_cre['every_month'], 0, '', '.') . '₫' ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right"></i>
                                    Lãi suất: <b class="green"><?= $installment->interes ?>%</b>
                                </li>
                                <li>
                                    <i class="icon-caret-right"></i>
                                    Bảo hiểm khoản vay: <b
                                            class="green"><?= ($count_insurrance > 0) ? ($count_insurrance * 100) . '% - ' . number_format($count_insurrance_price, 0, '', '.') . '₫/tháng' : 'Không có' ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right"></i>
                                    Tổng tiền: <b
                                            class="green"><?= number_format($interes_home_cre['total'], 0, '', '.') . '₫' ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right"></i>
                                    Chênh lệch so với mua thẳng: <b
                                            class="green"><?= number_format(ClaInstallment::getDifference($interes_home_cre['total'], $product['price'], $model->prepay), 0, '', '.') . '₫' ?></b>
                                </li>
                            </ul>
                        </div><!-- /span -->
                    </div><!-- row -->

                    <div class="space"></div>
                    <div>
                        <?php
                        $this->renderPartial('_products_bill_admin', array(
                                'product' => $product,
                                'model' => $model)
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>