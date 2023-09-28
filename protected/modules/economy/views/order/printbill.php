<div class="container" style="margin: 20px 0">
    <div class="col-sm-12">
        <div style="text-align: center;margin-bottom: 20px">
            <b style="font-weight: bold;text-transform: uppercase;font-size: 20px"><?php echo $site["site_title"], ' xin cám ơn!' ?></b>
        </div>
        <div style="text-align: center;margin-bottom: 20px;">
            <b style="font-weight: bold;text-transform: uppercase"><?php echo Yii::t('shoppingcart', 'bill') ?></b>
        </div>
        <div class="space"></div>
        <div><span style="font-weight: bold">Số hóa đơn: </span><?php echo $model->order_id ?> <br/> <span style="font-weight: bold;font-size: 12px;margin-top: 10px;">Ngày: </span><span style="font-size: 12px;"><?php echo date('m-d-Y H:i:s', $model->created_time); ?></span></div>
        <div>
            <?php $this->renderPartial('_products_bill', array('products' => $products)); ?>
        </div>
        <div style="width: 100%;border-top: dotted 1px black;margin-top: 10px;">
            <?php
            $discount = CouponCode::getDiscountByCode($model->coupon_code, $model['order_total']);
            ?>
            <div class="pull-right">
                <?php
                if (isset($discount) && $discount) {
                    ?>
                    <p style="text-align: right">
                        <label><?php echo Yii::t('coupon', 'code') ?> :</label>
                        <span class="red"><?php echo $model->coupon_code ?></span>
                    </p>
                    <p style="text-align: right">
                        <label><?php echo Yii::t('common', 'discount') ?> :</label>
                        <span class="red"><?php echo number_format($discount, 0, '', '.'); ?></span>
                    </p>
                    <?php
                }
                ?>
                <?php
                if ($model->transport_freight) {
                    ?>
                    <p style="text-align: right">
                        <label><?php echo Yii::t('shoppingcart', 'shipfee') ?> :</label>
                        <span class="red"><?php echo number_format($model->transport_freight, 0, '', '.'); ?></span>
                    </p>
                    <?php
                }
                ?>
                <?php
                if ($model->vat) {
                    ?>
                    <p style="text-align: right">
                        <label>VAT :</label>
                        <span class="red"><?php echo number_format($model->vat, 0, '', '.'); ?></span>
                    </p>
                    <?php
                }
                ?>
                <h4 style="text-align: right;margin: 10px 0">
                    <?php echo Yii::t('common', 'total') ?> :
                    <span class="red"><?php echo Product::getPriceText(array('price' => $model['order_total'])); ?></span>
                </h4>
            </div>
        </div>
    </div>
    <div style="text-align: left;font-weight: bold;font-size: 14px;margin-bottom: 20px">
        Ghi chú:
        <?php echo $model['note'] ?>
    </div>
    <div style="text-align: center;font-weight: bold;font-size: 16px;">
        <i>Chúc quý khách vui vẻ, Hẹn gặp lại.</i>
        <?php echo $model['note'] ?>
    </div>
</div>