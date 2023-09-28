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
                                    Tên: <b><?php
                                    echo $order->username ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Số điện thoại: <b class="blue"><?php echo $order->phone ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Giới tính: <b class="blue"><?php echo ClaInstallment::getSex($order->sex) ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Địa chỉ: <b><?php echo $order->address ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Tỉnh / TP: <b><?php
                                    $province = LibProvinces::getProvinceDetail($order->province_id);
                                    echo $province['name'];
                                    ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Quận / Huyện: <b><?php
                                    $district = LibDistricts::getDistrictDetailFollowProvince($order->province_id, $order->district_id);
                                    echo $district['name'];
                                    ?></b>
                                </li>
                            </ul>
                        </div><!-- /span -->
                        <div class="col-sm-6">
                            <div class="col-xs-12 label label-lg label-success arrowed-in arrowed-right">
                                <b>Thông tin trả góp</b>
                            </div>

                            <?php
                            $installment = Installment::model()->findByPk($order->installment_id);
                            $number_month = $order->month;
                            $count_pre = $order->prepay;
                            $count_insurrance = $order->insurrance;
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
                                    Mã đơn hàng: <b class="red">#<?= $order->id ?></b>
                                </li>
                                <?php if ($order->shop_id != 'N/A') { ?>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Cửa hàng duyệt hồ
                                        sơ: <?php $shop = ShopStore::model()->findByPk($order->shop_id); ?><b
                                                class="red"><?= $shop['name']; ?></b>
                                    </li>
                                <?php } ?>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Ngân hàng: <b class="red"><?= $order->bankCode; ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Loại thẻ: <b class="red"><?= $order->paymentMethod; ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Số tháng trả góp: <b class="red"><?= $order->month; ?> tháng</b>
                                </li>
                                <li>
                                    <i class="icon-caret-right blue"></i>
                                    Trả trước: <b
                                            class="red"><?= ($order->prepay * 100) . '% - ' . number_format($order->prepay * $product->price, 0, '', '.') . '₫'; ?></b>
                                </li>


                                <li>
                                    <i class="icon-caret-right"></i>
                                    Trả hàng tháng: <b
                                            class="green"><?= number_format($order->every_month, 0, '', '.') . '₫' ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right"></i>
                                    Lãi suất: <b class="green"><?= (double)$order->interest_rate ?>%</b>
                                </li>
                                <li>
                                    <i class="icon-caret-right"></i>
                                    Phí merchant: <b
                                            class="green"><?=number_format($order->merchantFee, 0, '', '.'). '₫' ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right"></i>
                                    Tổng tiền: <b
                                            class="green"><?= number_format($order->total, 0, '', '.') . '₫' ?></b>
                                </li>
                                <li>
                                    <i class="icon-caret-right"></i>
                                    Chênh lệch so với mua thẳng: <b
                                            class="green"><?= number_format($order->difference, 0, '', '.') . '₫' ?></b>
                                </li>

                                <li>
                                    <i class="icon-caret-right"></i>
                                    Trạng thái: <b
                                            class="green"><?= InstallmentOrder::getStatusPayment()[$order->status] ?></b>
                                </li>
                            </ul>
                        </div><!-- /span -->
                    </div><!-- row -->

                    <div class="space"></div>
                    <div class="blue" style="color: blue">*Lưu ý: Nếu bạn đã chọn chi nhánh thì phải đến đúng địa chỉ để nhận hàng.</div>
                    <div>
                        <?php
                        $this->renderPartial('_products_bill_admin', array(
                                'product' => $product,
                                'model' => $order)
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>