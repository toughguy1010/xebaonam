<div class="infor-order-thuedo">
    <div class="title">
        <h2>Thông tin đơn hàng</h2>
    </div>
    <div class="ctn-infor-order-thuedo">
        <div class="item-info">
            <p>
                <?php
                $product = $shoppingCart->getProductInfo();
                ?>
                <label for="">
                    <b><?= $product['name'] ?></b>
                    <spam>
                        Từ <?= $shoppingCart->getDateFrom(); ?> tới <?= $shoppingCart->getDateTo(); ?>
                        <br>
                        <?= $shoppingCart->getDateRange() . ' ' . Yii::t('rent', 'day'); ?>
                    </spam>
                </label>
                <span> <?= HtmlFormat::money_format($shoppingCart->getProductPrice()) . 'VND' ?></span>

            </p>
        </div>
        <div class="item-info">
            <p>
                <label for="">
                    <b><?= Yii::t('rent', 'deposits_fee'); ?></b>
                    <spam>
                        <?= $shoppingCart->getQuantity() ?> Wifi
                    </spam>
                </label>
                <span>  <?= HtmlFormat::money_format($shoppingCart->getDepositsFee()) . ' VND' ?> </span>
            </p>

        </div>
        <?php if ($shoppingCart->getInsuranceStatus()) { ?>
            <div class="item-info">
                <p>
                    <label for="">
                        <b><?= Yii::t('rent', 'insurance_fee'); ?></b>
                        <spam>
                            <?= $shoppingCart->getQuantity() ?> Wifi
                        </spam>
                    </label>
                    <span><?= HtmlFormat::money_format($shoppingCart->getInsuranceFee()) . ' VND' ?></span>
                </p>
            </div>
        <?php } ?>
        <?php if ($shoppingCart->getVatStatus()) { ?>
        <div class="item-info">
            <p>
                <label for="">
                    <b><?= Yii::t('rent', 'vat_fee') ?></b>
                    <spam>
                        VAT 10%
                    </spam>
                </label>
                <span><?= HtmlFormat::money_format($shoppingCart->getVatFee()) . ' VND' ?></span>
            </p>
        </div>
        <?php } ?>
        <!---->
        <?php if ($shoppingCart->getShipfee() && $shoppingCart->getShipfee() > 0) { ?>
            <div class="item-info">
                <p>
                    <label for="">
                        <b><?= Yii::t('rent', 'ship_fee'); ?></b>
                    </label>
                    <span><?= HtmlFormat::money_format($shoppingCart->getShipfee()) . ' VND' ?></span>
                </p>
            </div>
        <?php } ?>
        <!---->
        <?php if ($shoppingCart->getReturnfee() && $shoppingCart->getReturnfee() > 0) { ?>
            <div class="item-info">
                <p>
                    <label for="">
                        <b><?= Yii::t('rent', 'return_fee'); ?></b>
                    </label>
                    <span><?= HtmlFormat::money_format($shoppingCart->getReturnfee()) . ' VND' ?></span>
                </p>
            </div>
        <?php } ?>
        <div class="total-price-info">
            <p>
                <?= Yii::t('rent', 'total_price') ?>
                : <?= HtmlFormat::money_format($shoppingCart->getTotalPrice()) . ' VND' ?>
            </p>
        </div>
        <hr>
        <p style="font-size: 11px;color: blue">(*) Ghi chú: Số tiền đặt cọc thiết bị
            <span>  <?= HtmlFormat::money_format($shoppingCart->getDepositsFee()) . ' VND' ?> </span> sẽ được hoàn trả
            cho bạn ngay khi bạn trả
            thiết bị. Chi phí bạn thực trả để thuê thiết bị là
            <span>  <?= HtmlFormat::money_format($shoppingCart->getProductPrice()) . ' VND' ?> </span>.
        </p>
    </div>
</div>