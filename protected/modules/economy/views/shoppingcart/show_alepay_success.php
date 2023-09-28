<style type="text/css">
    .statistic-order{
        float: right;
    }
    .statistic-order strong{
        width: 130px;
        display: inline-block;
    }
    .statistic-order span.price{
        color: #ff5c01;
    }
</style>
<div class="content-wrap">
    <div class="payment-step1-page">
        <div class="container">
            <div class="process-payment">
                <ul>
                    <li>
                        <a href="javascript:void(0)">GIỎ HÀNG</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">THANH TOÁN</a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0)">BIÊN NHẬN</a>
                    </li>
                </ul>
            </div>
            <div>
                <a href="<?= Yii::app()->homeUrl ?>" style="font-size: 20px; margin-bottom: 20px; display: block">
                    <i class="fa fa-arrow-circle-left"></i>
                    Quay về trang chủ
                </a>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-10">
                    <div class="border-payment w3n-order">
                        <div class="check-orderpaper">
                            <div class="title-payment" style="background: #f3eded;">
                                <h2 class="center">Hóa đơn biên nhận</h2>
                            </div>
                            <div class="col-xs-12">
                                <div class="ctn-check-orderpaper">
                                    <h3>Thông tin đơn hàng số #<?= $order['order_id']; ?></h3>
                                    <div class="check-info-order">
                                        <h4><?php echo Yii::t('shoppingcart', 'billing-text') ?></h4>
                                        <ul>
                                            <li><?= $order['billing_name'] ?></li>
                                            <li><?= $order['billing_phone'] ?></li>
                                            <li><?= $order['billing_email'] ?></li>
                                            <li><?= $order['billing_address'] ?></li>
                                        </ul>
                                    </div>
                                    <div class="check-info-order">
                                        <h4><?php echo Yii::t('shoppingcart', 'shipping-text') ?></h4>
                                        <ul>
                                            <li><?= $order['shipping_name'] ?></li>
                                            <li><?= $order['shipping_phone'] ?></li>
                                            <li><?= $order['billing_email'] ?></li>
                                            <li><?= $order['billing_address'] ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="time-order">
                                    <p><strong><?= Yii::t('shoppingcart', 'order-time'); ?>: </strong><?php echo date('d-m-Y H:i:s', $order['created_time']); ?> </p>
                                    <p><strong><?= Yii::t('shoppingcart', 'payment_method'); ?>: <?= $paymentmethod; ?> </strong></p>
                                    <p><strong>Ngân hàng: <?= $info->method . ' - ' . $info->bankCode . ' (' . $info->bankName . ')'; ?> </strong></p>
                                    <p><strong><?= Yii::t('shoppingcart', 'payment_status'); ?>: <?= $info->message ?> </strong></p>
                                </div>
                            </div>
                            <section id="cart" class="cart">
                                <div class="bg-cart-page hidden-xs">
                                    <div class="a">
                                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                            $this->renderPartial('_product', array(
                                                'products' => $products,
                                            ));
                                            ?>
                                            <br />
                                            <div class="statistic-order">
                                                <p>
                                                    <strong>Tổng tiền: </strong>
                                                    <span class="price"><?= Product::getPriceText(array('price' => $order['old_order_total'], 'currency' => $order['currency'])) ?></span>
                                                </p>
                                                <?php
                                                if ($order['coupon_code']) {
                                                    $discount = CouponCode::getDiscountByCode($order['coupon_code'], $order['old_order_total']);
                                                    ?>
                                                    <p>
                                                        <strong>Coupon giảm giá: </strong>
                                                        <span class="price"><?= number_format($discount, 0, ',', '.') ?> đ</span>
                                                    </p>
                                                    <?php
                                                }
                                                ?>
                                                <?php if ($order['transport_freight']) { ?>
                                                    <p>
                                                        <strong>Phí vận chuyển: </strong>
                                                        <span class="price"><?= number_format($order['transport_freight'], 0, ',', '.') ?> đ</span>
                                                    </p>
                                                <?php } ?>
                                                <p>
                                                    <strong>Còn lại: </strong>
                                                    <span class="price"><?= Product::getPriceText(array('price' => $order['order_total'], 'currency' => $order['currency'])) ?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $this->renderPartial('_product_mobile', array(
                                    'products' => $products,
                                ));
                                ?>
                            </section>

                            <div class="foot-check-orderpaper">
                                <a href="javascript:void(0)" id="printorder">
                                    <i class="fa fa-print"></i>
                                    <?= Yii::t('shoppingcart', 'order_print'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /content-wrap -->

<script>
    jQuery('#printorder').on('click', function () {
        w = window.open();
        w.document.write($('.w3n-order').html());
        w.print();
        w.close();
    });
</script>