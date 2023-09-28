    <link href="<?php echo Yii::app()->request->baseUrl; ?>/installment/css/order.css" rel="stylesheet"/>
    <style>
        .infoproduct {
            width: 100%;
        }
        .fw-100 {
            font-weight: 100;
        }
    </style>
    <section id="wrap_cart">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'sc-checkout-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array('class' => 'form-horizontal widget-form'),
        ));
        ?>
        <!--#region Thông tin sản phẩm-->
        <?php
        $this->renderPartial('pack', array(
            'shoppingCart' => $shoppingCart,
            'update' => false,
        ));
        ?>
        <div class="infouser">
            <div class="areainfo">
                <div class="left">
                    <?php echo $form->textField($billing, 'name', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Họ và tên')); ?>
                    <?php echo $form->error($billing, 'name'); ?>
                </div>
                <div class="right">
                    <?php echo $form->textField($billing, 'phone', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Số điện thoại')); ?>
                    <?php echo $form->error($billing, 'phone'); ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="areainfo">
                <div class="left">
                    <?php echo $form->dropDownList($billing, 'city', LibProvinces::getListProvinceArr(), array('class' => 'span9 form-control', 'style' => 'width: 100%;', 'prompt' => 'Chọn tỉnh/thành phố')); ?>
                    <?php echo $form->error($billing, 'city'); ?>
                </div>
                <div class="right">
                    <?php echo $form->dropDownList($billing, 'district', array(), array('class' => 'span9 form-control', 'style' => 'width: 100%;', 'style' => '', 'prompt' => 'Chọn quận/huyện')); ?>
                    <?php echo $form->error($billing, 'district'); ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="areainfo">
                <div class="left">
                    <?php echo $form->textField($billing, 'email', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Email')); ?>
                    <?php echo $form->error($billing, 'email'); ?>
                </div>
                <div class="right">
                    <?php echo $form->textField($billing, 'address', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Địa chỉ')); ?>
                    <?php echo $form->error($billing, 'address'); ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="citydis">
                <?php echo $form->textField($order, 'note', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Yêu cầu khác (Không bắt buộc)')); ?>
                <?php echo $form->error($order, 'note'); ?>
            </div>
        </div>

        <div class="infouser">
            <div class="areainfo">
                <div class="left">
                    <label for="">Hình thức thanh toán</label>
                    <?php
                    $paymentmethod = Orders::getPaymentMethod();
                    if ($paymentmethod) {
                        foreach ($paymentmethod as $pk => $plabel) {
                            ?>
                            <label class="fw-100" for="female_<?=$pk?>">
                                <input id="female_<?=$pk?>" type="radio" name="Orders[payment_method]"
                                       value="<?php echo $pk; ?>" <?php if ($order->payment_method == $pk) echo 'checked="checked"' ?> />
                                <?php echo $plabel; ?>
                            </label>
                            <?php
                            if ($pk == Orders::PAYMENT_METHOD_ONLINE) {
                                $this->renderPartial('partial/payment_baokim', array('order' => $order));
                            }
                            ?>
                            <?php
                        }
                    }
                    ?>
                    <?php echo $form->error($order, 'payment_method'); ?>
                </div>
                <div class="right">
                    <label for="">Hình thức vận chuyển</label>
                    <?php
                    $transportmethod = Orders::getTranportMethod();
                    if ($transportmethod) {
                        foreach ($transportmethod as $tk => $tinfo) {
                            ?>
                                <label class="fw-100" for="female1_<?=$tk?>">
                                    <input id="female1_<?=$tk?>" type="radio" name="Orders[transport_method]" value="<?php echo $tk; ?>" <?php if ($order->transport_method == $tk) echo 'checked="checked"' ?>/>
                                    <?php
                                    $time = (($tinfo['time']) ? $tinfo['time'] : '');
                                    echo $tinfo['name'] . $time . ' - ' . $tinfo['price'];
                                    ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php echo $form->error($order, 'transport_method'); ?>
                </div>
                <div class="clear"></div>
            </div>
        <div class="area-total">
            <div class="total-price"><strong>Tổng tiền:</strong><strong><?php echo $shoppingCart->getTotalPrice(); ?>
                    ₫</strong>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <div class="checkbox" style="float: right; margin-right: 15px;">
                <label>
                    <input name="agree" id="agree" type="checkbox" class="ace">
                    <span class="lbl" style="font-weight: bold;"> Đồng Ý Các Điều Khoản Thanh Toán</span>
                </label>
            </div>
        </div>
        <button class="cart-btt " id="submitcheckout" type="submit" onclick="validorder(event);">
            <b>Đặt mua</b>
        </button>
        <?php $this->endWidget();
        ?>

    </section>
    <div class="loading-cart">
    <span class="cswrap">
        <span class="csdot"></span>
        <span class="csdot"></span>
        <span class="csdot"></span>
    </span>
    </div>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/installment/js/main.js"></script>
    <script type="text/javascript">
        jQuery(document).on('change', '#Billing_city', function () {
            var province = jQuery(this).val();
            jQuery.ajax({
                url: '<?php echo Yii::app()->createUrl('/installment/installment/getdistrict') ?>',
                data: {pid: province, allownull: 1},
                dataType: 'JSON',
                beforeSend: function () {
                    $('.loading-cart').show();
                },
                success: function (res) {
                    if (res.code == 200) {
                        jQuery('#Billing_district').html(res.html);
                    }
                    $('.loading-cart').hide();
                },
                error: function () {
                    $('.loading-cart').hide();
                }
            });
        });
    </script>

<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<link href='<?php echo $themUrl ?>/css/jquery.alert.css' rel='stylesheet' type='text/css'/>
<script type="text/javascript" src="<?= $themUrl ?>/js/jquery.alert.js"></script>
<script>
    var payment = {
        is_payment_online:<?php echo (int)SitePayment::model()->checkPaymentOnline();?>,
        payment_method_online:<?php echo Orders::PAYMENT_METHOD_ONLINE;?>,
        method: 0,
        method_child: 0
    };
    jQuery(document).ready(function () {
        $("#popup_ok").click(function () {
            $("#popup_container").css("display", "none");
        });
        jQuery('#billtoship').on('click', function () {
            if (jQuery(this).prop("checked"))
                jQuery('#shipping').addClass('hidden');
            else
                jQuery('#shipping').removeClass('hidden');
        });
        //payment online
        if (payment.is_payment_online) {
            jQuery('.pm_parent > label > input[type=radio]').on('click', function () {
                payment.method = jQuery(this).val();
                if (payment.method == payment.payment_method_online) {
                    jQuery('#submitcheckout').val('Thanh toán');
                } else {
                    jQuery('#submitcheckout').val('Xác nhận và gửi đơn hàng');
                    payment.method_child = 0;
                }
                jQuery('.pm_list_children.active').removeClass('active').slideUp('fast');
                jQuery(this).parents('.pm_parent').children('.pm_list_children').addClass('active').slideDown('fast');
            });
            jQuery('#sc-checkout-form').on('submit', function () {
                if (payment.method == payment.payment_method_online && payment.method_child == 0) {
                    alert("Bạn chưa chọn Ngân hàng bạn muốn sử dụng thanh toán");
                    return false;
                }
            });
        }
    });

    function validorder(event) {

        var checkBox = document.getElementById("agree");
        if (checkBox.checked == false) {
            $("#popup_container").css("display", "block");

        } else {
            return true;
        }
        event.preventDefault();


        // if (agree.checked == false) {
        //     error_flg = true;
        //     error_message.push("Bạn Cần Đồng Ý Các Điều Khoản Thanh Toán");

        // }
        // if (error_flg == false) {
        //     document.forms['sc-checkout-form'].submit();
        //     return true;
        // } else {
        //     var error_str = error_message.join("\n");
        //     jAlert(error_str, "21 Six");
        // }


    }
</script>

<div id="popup_container" class="ui-draggable"
     style="position: fixed; z-index: 99999; padding: 0px; margin: 0px; min-width: 348px; max-width: 348px; top: 149px; left: 617.5px; display: none">
    <h1 id="popup_title" class="ui-draggable-handle" style="cursor: move;">XE BẢO NAM</h1>
    <div id="popup_content" class="alert">
        <div id="popup_message">Bạn Cần Đồng Ý Các Điều Khoản Thanh Toán</div>
        <div id="popup_panel"><input type="button" value="&nbsp;OK&nbsp;" id="popup_ok"></div>
    </div>
</div>