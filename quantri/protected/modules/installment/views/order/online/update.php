<style type="text/css">
    .widget-header-large {
        height: 260px;
        padding: 15px !important;
        border: none !important;
        margin-bottom: 30px;
    }

    .invoice-box .col-xs-8 label {
        width: 150px;
    }

    .invoice-box .col-xs-8 select {
        width: 145px;
    }

    .widget-body {
        border-top: 1px solid #CCC;
    }

    .widget-box.transparent {
        float: left;
        width: 100%;
        margin-bottom: 30px;
        margin-top: 0;
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
                        <div class="col-xs-12">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'orders-form',
                                'enableAjaxValidation' => false,
                                'htmlOptions' => array('class' => 'form-inline'),
                            ));
                            ?>
                            <label><?php echo $model->getAttributeLabel('status_confirm'); ?> : </label>
                            <?php if (in_array($model->status_confirm,[5,6])) { ?>
                                <?php echo $form->dropDownList($model, 'status_confirm', Orders::getStatusArr(), array("disabled" => "disabled")); ?>
                            <?php } else { ?>
                                <?php echo $form->dropDownList($model, 'status_confirm', Orders::getStatusArr()); ?>
                            <?php } ?>
                            <p style="font-size: 12px;color: red;"><?php echo isset($error) ? $error : '' ?></p>
                            <p style="font-size: 10px;color: blue;line-height: 16px">(Lưu ý: - Trạng thái đơn hàng chỉ
                                "hoàn thành" khi vận chuyển và thanh toán thành công. <br>- Đơn hàng đã "Hoàn thành" và
                                "Hủy" sẽ không thể sửa lại.)</p>
                            <label><?php echo $model->getAttributeLabel('note'); ?> : </label>
                            <?php echo $form->textArea($model, 'note', array('class' => 'form-control')); ?>
                            <br/>
                            <?php if ($model->status != 6 && $model->status != 5) { ?>
                                <?php echo CHtml::submitButton(Yii::t('common', 'update'), array('class' => 'btn btn-sm btn-primary')); ?>
                            <?php } ?>

                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>

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
                                            echo $model->username ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Số điện thoại: <b class="blue"><?php echo $model->phone ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Giới tính: <b class="blue"><?php echo ClaInstallment::getSex($model->sex) ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Địa chỉ: <b><?php echo $model->address ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Tỉnh / TP: <b><?php
                                            $province = LibProvinces::getProvinceDetail($model->province_id);
                                            echo $province['name'];
                                            ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Quận / Huyện: <b><?php
                                            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
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
                                        Mã đơn hàng: <b class="red">#<?= $model->id ?></b>
                                    </li>
                                    <?php if ($model->shop_id != 'N/A') { ?>
                                        <li>
                                            <i class="icon-caret-right blue"></i>
                                            Cửa hàng duyệt hồ
                                            sơ: <?php $shop = ShopStore::model()->findByPk($model->shop_id); ?><b
                                                    class="red"><?= $shop['name']; ?></b>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Ngân hàng: <b class="red"><?= $model->bankCode; ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Loại thẻ: <b class="red"><?= $model->paymentMethod; ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Số tháng trả góp: <b class="red"><?= $model->month; ?> tháng</b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right"></i>
                                        Giá mua trả góp: <b
                                                class="green"><?= number_format($product->price - $model->prepay * $product->price, 0, '', '.') . '₫' ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right blue"></i>
                                        Trả trước: <b
                                                class="red"><?= ($model->prepay * 100) . '% - ' . number_format($model->prepay * $product->price, 0, '', '.') . '₫'; ?></b>
                                    </li>


                                    <li>
                                        <i class="icon-caret-right"></i>
                                        Trả hàng tháng: <b
                                                class="green"><?= number_format($model->every_month, 0, '', '.') . '₫' ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right"></i>
                                        Lãi suất: <b class="green"><?= (double)$model->interest_rate ?>%</b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right"></i>
                                        Phí merchant: <b
                                                class="green"><?= number_format($model->merchantFee, 0, '', '.') . '₫' ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right"></i>
                                        Tổng tiền: <b
                                                class="green"><?= number_format($model->total, 0, '', '.') . '₫' ?></b>
                                    </li>
                                    <li>
                                        <i class="icon-caret-right"></i>
                                        Chênh lệch so với mua thẳng: <b
                                                class="green"><?= number_format($model->difference, 0, '', '.') . '₫' ?></b>
                                    </li>

                                    <li>
                                        <i class="icon-caret-right"></i>
                                        Trạng thái: <b
                                                class="green"><?= InstallmentOrder::getStatusPayment()[$model->status] ?></b>
                                    </li>
                                </ul>
                            </div><!-- /span -->
                        </div><!-- row -->

                        <div class="space"></div>
                        <div class="blue" style="color: blue">*Lưu ý: Nếu bạn đã chọn chi nhánh thì phải đến đúng địa
                            chỉ để nhận hàng.
                        </div>
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
    <!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
</div>