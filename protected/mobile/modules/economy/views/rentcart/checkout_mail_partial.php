<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<p><b><?= Yii::t('rent', 'name') ?>: </b><span><?= $modelOrderRent->name ?></span></p>
<p><b><?= Yii::t('rent', 'email') ?>: </b><span><?= $modelOrderRent->email ?></span></p>
<p><b><?= Yii::t('rent', 'phone') ?>: </b><span><?= $modelOrderRent->phone ?></span></p>
<p><b><?= Yii::t('rent', 'receive_type') ?>
        : </b><span><?= BillingRentCart::aryAddress()[$modelOrderRent->receive_address_id]; ?></span>
</p>
<p>
    <?php
    if ($modelOrderRent->receive_address_id == 4) {
        $province = LibProvinces::getProvinceDetail($modelOrderRent['province_id']);
        echo $province['name'];
    }
    ?>
</p>
<p><b><?= Yii::t('rent', 'return_type') ?>
        : </b><span><?= BillingRentCart::aryAddress()[$modelOrderRent->return_address_id]; ?> </span>
</p>
<p>
    <?php
    if ($modelOrderRent->return_address_id == 4) {
        $return_province = LibProvinces::getProvinceDetail($modelOrderRent['return_province_id']);
        echo $return_province['name'];
    }
    ?>
</p>
<p>
    <b><?= Yii::t('rent', 'payment_method') ?>
        : </b><span><?= OrderRent::statusPaymentMethod()[$modelOrderRent->payment_method]; ?></span>
</p>
<?php if (count($items)) { ?>
    <?php foreach ($items as $key => $val) { ?>
        <div class="ctn-infor-order-thuedo">
            <div class="item-info">
                <p>
                    <label for="">
                        <b>- Thời gian thuê</b>
                        <spam>
                            Từ <?= date('d/m/Y', $val['rent_from']); ?>
                            tới <?= date('d/m/Y', $val['rent_to']); ?>
                            <br>
                            <?= $val['day'] . ' ' . Yii::t('rent', 'day'); ?>
                        </spam>
                    </label>
                    <span> <?= HtmlFormat::money_format($val['price'] * $val['day'] * $val['quantity']) . 'VND' ?></span>
                </p>
            </div>
            <div class="item-info">
                <p>
                    <label for="">
                        <b>- <?= Yii::t('rent', 'deposits_fee') ?></b>
                        <spam>
                            <?= $val['quantity'] ?> Wifi
                        </spam>
                    </label>
                    <span>    <?= HtmlFormat::money_format($modelOrderRent->deposits) . ' VND' ?> </span>
                </p>
            </div>
            <?php if ($modelOrderRent->use_insurance) { ?>
                <div class="item-info"><?= Yii::t('rent', 'deposit_notice') ?>
                    <p>
                        <label for="">
                            <b>- <?= Yii::t('rent', 'insurance_fee') ?></b>
                            <spam>
                                <?= $val['quantity'] ?> Wifi
                            </spam>
                        </label>
                        <span> <?= HtmlFormat::money_format($modelOrderRent->insurance) . ' VND' ?></span>
                    </p>
                </div>
            <?php } ?>
            <?php if ($modelOrderRent->use_vat) { ?>
                <div class="item-info">
                    <p>
                        <label for="">
                            <b>- Hóa đơn đỏ (VAT 10%):</b>
                        </label>
                        <span> <?= HtmlFormat::money_format($modelOrderRent->vat) . ' VND' ?></span>
                    </p>
                </div>
            <?php } ?>
            <div class="item-info">
                <p>
                    <label for="">
                        <b>- Chi phí giao hàng:</b>
                    </label>
                    <span> <?= HtmlFormat::money_format($modelOrderRent->ship_fee) . ' VND' ?></span>
                </p>
            </div>
            <div class="item-info">
                <p>
                    <label for="">
                        <b>- Phí trả hàng:</b>
                    </label>
                    <span> <?= HtmlFormat::money_format($modelOrderRent->return_fee) . ' VND' ?></span>
                </p>
            </div>
            ------
            <div class="total-price-info">
                <p>
                    <b>Tổng tiền: </b><?= HtmlFormat::money_format($modelOrderRent->total_price) . ' VND' ?>
                </p>
            </div>
        </div>
    <?php } ?>
<?php } ?>
