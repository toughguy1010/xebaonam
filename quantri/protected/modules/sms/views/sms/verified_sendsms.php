<h3 class="bg-info">Xác nhận gửi tin</h3>
<button style="position: absolute;top: 10px;right: 15px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
<div class="info-send-message">
    <table class="table">
        <tr>
            <td style="width: 30%;">Đầu số</td>
            <td>Ngẫu nhiên</td>
        </tr>
        <tr>
            <td>Thời gian gửi</td>
            <td><?php echo date('d-m-Y', time()); ?></td>
        </tr>
        <tr>
            <td>Nội dung</td>
            <td><?php echo htmlspecialchars($message); ?></td>
        </tr>
        <tr>
            <td>Tổng số người nhận</td>
            <td>
                <?php
                $detail_contact = '';
                if (count($ary_provider)) {
                    foreach ($ary_provider as $key => $ary_customer) {
                        if ($detail_contact != '') {
                            $detail_contact .= ', ';
                        }
                        $detail_contact .= $key . ': ' . count($ary_customer);
                    }
                }
                ?>
                <?php echo $total_contact; ?>
                <?php if ($detail_contact) { ?>
                    <i>(<?php echo $detail_contact; ?>)</i>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Số tin gửi</td>
            <td><?php echo $count_message; ?></td>
        </tr>
        <?php if (count($ary_price) && $count_message) { ?>
            <?php foreach ($ary_price as $key => $price) { ?>
                <tr>
                    <td>Chi phí <?php echo $key ?></td>
                    <td style="color: red;"><?php echo number_format($price, 0, '', '.') . ' ' . Yii::t('sms', 'unit_price') ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td><b>Tổng chi phí</b></td>
                <td style="color: red;"><?php echo number_format($total_price, 0, '', '.') . ' ' . Yii::t('sms', 'unit_price'); ?></td>
            </tr>
            <tr>
                <td><b>Số tiền hiện có</b></td>
                <td style="color: red;"><?php echo number_format($user_money, 0, '', '.') . ' ' . Yii::t('sms', 'unit_price'); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="2">
                <?php if (($user_money >= $total_price) && ($total_price != 0)) { ?>
                    <span style="color: blue">Bạn có thể click đồng ý gửi để gửi tin nhắn ngay bây giờ.</span>
                <?php } else if ($message == '' && $total_price == 0) { ?>
                    <span style="color: red;">Bạn phải nhập ít nhất một tin nhắn</span>
                <?php } else if ($message != '' && $total_price == 0) { ?>
                    <span style="color: red;">Bạn phải nhập đúng ít nhất một số điện thoại</span>
                <?php } else { ?>
                    <span style="color: red">Bạn không có đủ tiền để gửi tin nhắn này, vui lòng nhấn <a href="<?php echo Yii::app()->createUrl('sms/smsPayment') ?>">đây</a> để nạp thêm tiền vào tài khoản.</span>
                <?php } ?>
            </td>
        </tr>
    </table>
</div>
<?php if ($user_money >= $total_price && $total_price != 0) { ?>
    <button type="button" id="start_sendsms" data-loading-text="Đang gửi..." class="btn btn-primary" autocomplete="off">Đồng ý gửi</button>
<?php } ?>
    <button style="margin-left: 10px;" data-dismiss="modal" type="button" id="start_sendsms" class="btn btn-default" autocomplete="off">Hủy</button>

<script type="text/javascript">
    $('#start_sendsms').click(function () {
        var $btn = $(this).button('loading');
        $.post(
                "<?php echo Yii::app()->createUrl('sms/sms/executeSendsms'); ?>",
                {
                    group_id: "<?php echo $group_id ?>",
                    message: "<?php echo $message ?>",
                    type: "<?php echo $type ?>",
                    list_number: "<?php echo $list_number ?>",
                },
                function (data) {
                    console.log(data);
                    if (data.code == 200) {
                        alert('Đã gửi xong');
                        location.href = '<?php echo Yii::app()->createUrl('sms/sms'); ?>';
//                        $btn.button('reset');
                    } else if (data.code == 402) {
                        alert('Bạn không đủ tiền để gửi tin nhắn này');
                        location.href = '<?php echo Yii::app()->createUrl('sms/smsPayment'); ?>';
                    }
                },
                "json"
                );
    });
</script>