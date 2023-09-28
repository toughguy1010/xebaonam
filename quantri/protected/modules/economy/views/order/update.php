<style type="text/css">
    .widget-header-large {
        height: 260px;
    }

    .invoice-box .col-xs-8 label {
        width: 150px;
    }

    .invoice-box .col-xs-8 select {
        width: 145px;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="space-6">
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box transparent invoice-box">
                    <div class="widget-header widget-header-large clearfix">
                        <div class="col-xs-8">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'orders-form',
                                'enableAjaxValidation' => false,
                                'htmlOptions' => array('class' => 'form-inline'),
                            ));
                            ?>
                            <label><?php echo $model->getAttributeLabel('order_status'); ?> : </label>
                            <?php if ($model->order_status == 6 || $model->order_status == 5) { ?>
                                <?php echo $form->dropDownList($model, 'order_status', Orders::getStatusArr(), array("disabled" => "disabled")); ?>
                            <?php } else { ?>
                                <?php echo $form->dropDownList($model, 'order_status', Orders::getStatusArr()); ?>
                            <?php } ?>
                            <span style="font-size: 12px;color: red;"><?php echo isset($error) ? $error : '' ?></span>
                            <br/>
                            <span style="font-size: 10px;color: blue;line-height: 10px">(Lưu ý: - Trạng thái đơn hàng chỉ "hoàn thành" khi vận chuyển và thanh toán thành công.
                                <br/>- Đơn hàng đã "Hoàn thành" và "Hủy" sẽ không thể sửa lại.)</span>
                            <br/>
                            <label><?php echo $model->getAttributeLabel('transport_status'); ?> : </label>
                            <?php echo $form->dropDownList($model, 'transport_status', Orders::getTransportStatusArr()); ?>
                            <br/>
                            <label><?php echo $model->getAttributeLabel('payment_status'); ?> : </label>
                            <?php echo $form->dropDownList($model, 'payment_status', Orders::getPaymentStatusArr()); ?>
                            <br/>
                            <label><?php echo $model->getAttributeLabel('note'); ?> : </label>
                            <?php echo $form->textArea($model, 'note', array('class' => 'form-control')); ?>
                            <br/>
                            <?php if ($model->order_status != 6 && $model->order_status != 5) { ?>
                                <?php echo CHtml::submitButton(Yii::t('common', 'update'), array('class' => 'btn btn-sm btn-primary', 'style' => 'margin-left:20px;')); ?>
                            <?php } ?>

                            <?php $this->endWidget(); ?>
                        </div>
                        <div class="col-xs-4">
                            <div class="row">
                                <div class="widget-toolbar no-border invoice-info">
                                    <span class="invoice-info-label"><?php echo Yii::t('shoppingcart', 'invoice') ?>
                                        :</span>
                                    <span class="red">#<?php echo $model->order_id; ?></span>

                                    <br>
                                    <span class="invoice-info-label"><?php echo Yii::t('common', 'date') ?>:</span>
                                    <span class="blue"><?php echo date('m-d-Y H:i:s', $model->created_time); ?></span>
                                </div>

                                <div class="widget-toolbar hidden-480">

                                    <a title="In hóa đơn lớn" target="_blank"
                                       href="<?php echo Yii::app()->createUrl('/economy/order/exportDetailCSV', array('id' => $model->order_id)) ?>">
                                        Xuất ra excel
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <hr>
                                <div class="widget-toolbar no-border invoice-info">
                                    <?php
                                    if ($model->user_id != 0) {
                                        ?>
                                        <p>Khách hàng <strong><?php echo $model->billing_name ?></strong> đã đăng ký
                                            Bạn có muốn xem
                                            <a style="color: red"
                                               href='<?php echo Yii::app()->createUrl("economy/order/userShoppingCart", array("id" => $model->user_id)) ?>'>
                                                lịch sử mua hàng
                                            </a> của thành viên này
                                        </p>

                                    <?php } else {
                                        ?>
                                        <p>Đơn hàng khách vãng lai - <a class="update_user" href='javascript:void(0)'>Liên
                                                kết với User</a></p>
                                        <div class="update_user_form" style="display: none">
                                            <?php
                                            $form = $this->beginWidget('CActiveForm', array(
                                                'id' => 'orders-update-user-form',
                                                'action' => Yii::app()->createUrl('economy/order/updateUser', array('id' => $model->order_id)),
                                                'enableAjaxValidation' => false,
                                                'htmlOptions' => array('class' => 'form-inline'),
                                            ));
                                            ?>
                                            <?php echo $form->dropDownList($model, 'user_id', Users::getUsersBySiteId($model->site_id)); ?>
                                            <?php echo CHtml::submitButton(Yii::t('common', 'update'), array('class' => 'btn btn-sm btn-primary', 'style' => 'margin-left:20px;')); ?>
                                            <br/>
                                            <span style="font-size: 12px;color: red;">(Lưu ý: Nếu đã cập nhập bạn sẽ không thể sủa lại)</span>

                                            <?php $this->endWidget(); ?>
                                        </div>
                                        <script>
                                            $(document).ready(function () {
                                                $('.update_user').on('click', function () {
                                                    $('.update_user_form').toggle();
                                                })
                                            })
                                        </script>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-24">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                            <b><?php echo Yii::t('shoppingcart', 'billing-text') ?></b>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <ul class="list-unstyled spaced">
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                Tên: <?php echo $model->billing_name ?>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                Địa chỉ: <?php echo $model->billing_address ?>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                Tỉnh / TP: <?php
                                                $province = LibProvinces::getProvinceDetail($model->billing_city);
                                                echo $province['name'];
                                                ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                Quận / Huyện: <?php
                                                $district = LibDistricts::getDistrictDetailFollowProvince($model->billing_city, $model->billing_district);
                                                echo $district['name'];
                                                ?>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                Số điện thoại: <b class="blue"><?php echo $model->billing_phone ?></b>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                Mã bưu điện: <b class="blue"><?php echo $model->billing_zipcode ?></b>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                Email: <?php echo $model->billing_email ?>
                                            </li>

                                            <li class="divider"></li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo Yii::t('shoppingcart', 'payment_method'); ?>
                                                    : </b><?php echo $paymentmethod; ?>
                                            </li>
                                            <?php
                                            if ($model->payment_method == Orders::PAYMENT_METHOD_ATM_OFFLINE) {
                                                $bank = Bank::model()->findByPk($model->bank_id);
                                                if (isset($bank) && $bank) {
                                                    ?>
                                                    <li>
                                                        <ul>
                                                            <p>
                                                                <i class="icon-caret-right blue"></i>
                                                                <b>Chủ tài khoản: </b><?=$bank->name?>
                                                            </p>
                                                            <p>
                                                                <i class="icon-caret-right blue"></i>
                                                                <b>Tên ngân hàng: </b><?=$bank->bank_name?>
                                                            </p>
                                                            <p>
                                                                <i class="icon-caret-right blue"></i>
                                                                <b>Số tài khoản: </b><?=$bank->number?>
                                                            </p>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($model->payment_method == Orders::PAYMENT_METHOD_ATM_ONLINE) {
                                                ?>
                                                <li>
                                                    <i class="icon-caret-right blue"></i>
                                                    <b>Ngân
                                                        hàng: </b><?php echo $model->payment_method_child . ' (' . NganluongBankHelper::getNameBank($model->payment_method_child) . ')'; ?>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo Yii::t('shoppingcart', 'transport_method'); ?>
                                                    : </b><?php echo $transportmethod['name']; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- /span -->

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                            <b><?php echo Yii::t('shoppingcart', 'shipping-text') ?></b>
                                        </div>
                                    </div>

                                    <div>
                                        <ul class="list-unstyled  spaced">
                                            <li>
                                                <i class="icon-caret-right green"></i>
                                                Tên: <?php echo $model->shipping_name ?>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right green"></i>
                                                Địa chỉ: <?php echo $model->shipping_address ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right green"></i>
                                                Tỉnh / TP: <?php
                                                $province = LibProvinces::getProvinceDetail($model->shipping_city);
                                                echo $province['name'];
                                                ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right green"></i>
                                                Số điện thoại: <b class="blue"><?php echo $model->shipping_phone ?></b>
                                            </li>

                                        </ul>
                                    </div>
                                </div><!-- /span -->
                            </div><!-- row -->

                            <div class="space"></div>
                            <div>
                                <?php
                                $this->renderPartial('_products_bill_admin', array(
                                    'products' => $products,
                                    'model' => $model)
                                );
                                ?>
                            </div>

                            <div class="hr hr8 hr-double hr-dotted"></div>

                            <div class="row">
                                <?php
                                $discount = CouponCode::getDiscountByCode($model->coupon_code, $model->old_order_total);
                                ?>
                                <div class="col-sm-5 pull-right">
                                    <?php
                                    if ($model->old_order_total) {
                                        ?>
                                        <p style="text-align: right">
                                            <label>Giá sản phẩm :</label>
                                            <span
                                                class="red"><?php echo number_format($model->old_order_total, 0, '', '.') . 'đ'; ?></span>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (isset($discount) && $discount) {
                                        ?>
                                        <p style="text-align: right">
                                            <label><?php echo Yii::t('coupon', 'code') ?> :</label>
                                            <span class="red"><?php echo $model->coupon_code ?></span>
                                        </p>
                                        <p style="text-align: right">
                                            <label><?php echo Yii::t('common', 'discount') ?> :</label>
                                            <span class="red">
                                                <?php
                                                if (is_integer($discount)) {
                                                    echo number_format($discount, 0, '', '.') . 'đ';
                                                } else {
                                                    echo $discount;
                                                }
                                                ?>
                                            </span>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($model->transport_freight) {
                                        ?>
                                        <p style="text-align: right">
                                            <label><?php echo Yii::t('shoppingcart', 'shipfee') ?> :</label>
                                            <span
                                                class="red"><?php echo number_format($model->transport_freight, 0, '', '.') . 'đ'; ?></span>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($model->vat) {
                                        ?>
                                        <p style="text-align: right">
                                            <label>VAT :</label>
                                            <span
                                                class="red"><?php echo number_format($model->vat, 0, '', '.') . 'đ'; ?></span>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($model->discount_for_dealers) {
                                        ?>
                                        <p style="text-align: right">
                                            <label>Triết khấu (<?= $model->discount_percent . '%' ?>) :</label>
                                            <span
                                                class="red"><?php echo number_format($model->discount_for_dealers, 0, '', '.') . 'đ'; ?></span>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <h4 class="pull-right">
                                        <?php if (isset($model->bonus_point_used) && $model->bonus_point_used != 0) { ?>
                                            <?php echo Yii::t('shoppingcart', 'bonus_point_used') ?> :
                                            <span
                                                class="red"><?php echo Product::getPriceText(array('price' => $model->bonus_point_used)); ?></span>
                                            <br/>
                                        <?php } ?>
                                        <?php echo Yii::t('common', 'total') ?> :
                                        <span
                                            class="red"><?php echo Product::getPriceText(array('price' => $model->order_total)); ?></span><br/>
                                    </h4>
                                </div>
                            </div>

                            <div class="space-6"></div>
                            <?php if ($model->note) { ?>
                                <div class="well">
                                    <?php echo $model->note ?>
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