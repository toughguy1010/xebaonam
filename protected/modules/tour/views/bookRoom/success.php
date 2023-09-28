<div class="w3n-order" style="margin-top: 50px;">
    <h2>Thông tin đặt phòng số #<?php echo $model['booking_id']; ?></h2>
    <table width="100%" cellpadding="5" cellspacing="5" style=" border-collapse: inherit;border-spacing: 5px;">
        <tbody>
            <tr>
                <td colspan="2">
                    <table width="100%" border="0" cellspacing="5" style=" border-collapse: inherit;border-spacing: 5px;">
                        <tr>
                            <td width="50%">
                                <h3><?php echo Yii::t('shoppingcart', 'billing-text') ?></h3>
                                <div><?php echo $model['name'] ?></div>
                                <div><?php echo $model['address'] ?></div>
                                <div><?php
                                    $province = LibProvinces::getProvinceDetail($model['province_id']);
                                    echo $province['name'];
                                    ?></div>
                                <div><?php echo $model['phone'] ?></div>
                                <div><?php echo $model['email'] ?></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Thời gian: </b><?php echo date('d-m-Y H:i:s', $model['created_time']); ?>
                    <br/>
                    <b>Hình thức thanh toán: </b>
                    <?php
                    $payment_arr = TourBooking::getPaymentMethodName();
                    echo $payment_arr[$model['payment_method']];
                    ?>
                    <br/>
                    <b>Trạng thái thanh toán</b>
                    <?php
                    if ($model->status_payment == TourBooking::STATUS_WAITING_PAYMENT) {
                        echo 'Chưa thanh toán';
                    } else if ($model->status_payment == TourBooking::STATUS_SUCCESS_PAYMENT) {
                        echo 'Đã thanh toán';
                    }
                    ?>
                </td>
            </tr>
            <tr style="border-top: 1px solid #DDD;">
                <td colspan="2">
                    <?php
                    $this->renderPartial('_room', array(
                        'model' => $model,
                        'room' => $room
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <b><?php echo Yii::t('common', 'note'); ?></b>
                    <p class="bg-success" style="padding:0px 10px;">
                        <?php echo $model['note']; ?>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-xs-12">
        <br />
        <button class="btn btn-info pull-right" id="printorder"><?php echo Yii::t('shoppingcart', 'order_print'); ?></button>
    </div>
</div>
<script>
    jQuery('#printorder').on('click', function () {
        w = window.open();
        w.document.write($('.w3n-order').html());
        w.print();
        w.close();
    });
</script>