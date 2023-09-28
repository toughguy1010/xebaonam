<div class="content-wrap">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'sc-checkout-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => ''),
    ));
    ?>
    <div class="payment-step1-page">
        <div class="container">
            <div class="process-payment">
                <ul>
                    <li>
                        <a href="javascript:void(0)"><?= Yii::t('shoppingcart', 'shoppingcart') ?></a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0)"><?= Yii::t('shoppingcart', 'checkout') ?></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><?= Yii::t('shoppingcart', 'receipt') ?></a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 pad-10">
                    <div class="border-payment">
                        <div class="title-payment">
                            <h2><?= Yii::t('shoppingcart', 'delivery_address') ?></h2>
                        </div>
                        <div class="check-address">
                            <div class="check-address-border">
                                <b><?= Yii::t('shoppingcart', 'payment_and_receipt_at') ?> :</b>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-infor-user">
                                            <div class="panel-body" >
                                                <div class="form-group required">
                                                    <?php echo $form->label($billing, 'name', array('class' => 'control-label')); ?>
                                                    <div class="controls"> 
                                                        <?php echo $form->textField($billing, 'name', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Vui lòng nhập họ tên')); ?>
                                                        <?php echo $form->error($billing, 'name'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group required">
                                                    <?php echo $form->label($billing, 'phone', array('class' => 'control-label')); ?>
                                                    <div class="controls"> 
                                                        <?php echo $form->textField($billing, 'phone', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Vui lòng nhập số điện thoại')); ?>
                                                        <?php echo $form->error($billing, 'phone'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group required">
                                                    <?php echo $form->label($billing, 'email', array('class' => 'control-label')); ?>
                                                    <div class="controls"> 
                                                        <?php echo $form->textField($billing, 'email', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Vui lòng nhập email')); ?>
                                                        <?php echo $form->error($billing, 'email'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-infor-user">
                                            <div class="panel-body">
                                                <div class="form-group required">
                                                    <?php echo $form->label($billing, 'address', array('class' => 'control-label')); ?>
                                                    <div class="controls"> 
                                                        <?php echo $form->textField($billing, 'address', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Vui lòng nhập địa chỉ')); ?>
                                                        <?php echo $form->error($billing, 'address'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group required">
                                                    <?php echo $form->label($billing, 'city', array('class' => 'control-label')); ?>
                                                    <div class="controls">
                                                        <?php echo $form->dropDownList($billing, 'city', LibProvinces::getListProvinceArr(), array('class' => '', 'prompt' => 'Chọn tỉnh/thành phố')); ?>
                                                        <?php echo $form->error($billing, 'city'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group required">
                                                    <?php echo $form->label($billing, 'district', array('class' => 'control-label')); ?>
                                                    <div class="controls ">
                                                        <?php echo $form->dropDownList($billing, 'district', LibDistricts::getOptionDistrictFromProvince($billing->city), array('class' => '', 'style' => '')); ?>
                                                        <?php echo $form->error($billing, 'district'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="panel-body">
                                            <div class="form-group required">
                                                <?php echo $form->label($order, 'note', array('class' => 'control-label')); ?>
                                                <div class="controls">
                                                    <?php echo $form->textArea($order, 'note', array('class' => '', 'rows' => '6')); ?>
                                                    <?php echo $form->error($order, 'note'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12" id="txtInformation">
                                    <input id="ytbilltoship" type="hidden" name="Billing[billtoship]" value="0" />
                                    <label>
                                        <input type="checkbox" name="Billing[billtoship]" id="billtoship" <?php if ($billing->billtoship) echo 'checked="checked"'; ?> value="1" /> <?= Yii::t('shoppingcart', 'shippingaddress') ?> 
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="steps-hoso  <?= ($billing->billtoship) ? '' : 'show'; ?>">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-infor-user">
                                        <div class="panel-body" >
                                            <div class="form-group required">
                                                <?php echo $form->label($shipping, 'name', array('class' => 'control-label')); ?>
                                                <div class="controls"> 
                                                    <?php echo $form->textField($shipping, 'name', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Vui lòng nhập họ tên')); ?>
                                                    <?php echo $form->error($shipping, 'name'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <?php echo $form->label($shipping, 'phone', array('class' => 'control-label')); ?>
                                                <div class="controls"> 
                                                    <?php echo $form->textField($shipping, 'phone', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Vui lòng nhập số điện thoại')); ?>
                                                    <?php echo $form->error($shipping, 'phone'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <?php echo $form->label($shipping, 'email', array('class' => 'control-label')); ?>
                                                <div class="controls"> 
                                                    <?php echo $form->textField($shipping, 'email', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'Vui lòng nhập email')); ?>
                                                    <?php echo $form->error($shipping, 'email'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-infor-user">
                                        <div class="panel-body">
                                            <div class="form-group required">
                                                <?php echo $form->label($shipping, 'address', array('class' => 'control-label')); ?>
                                                <div class="controls"> 
                                                    <?php echo $form->textField($shipping, 'address', array('class' => 'form-control', 'style' => 'width: 100%;', 'placeholder' => 'VD: 365 Cộng Hòa, Phường 12, Quận Tân Bình')); ?>
                                                    <?php echo $form->error($shipping, 'address'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <?php echo $form->label($shipping, 'city', array('class' => 'control-label')); ?>
                                                <div class="controls">
                                                    <?php echo $form->dropDownList($shipping, 'city', LibProvinces::getListProvinceArr(), array('class' => '')); ?>
                                                    <?php echo $form->error($shipping, 'city'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <?php echo $form->label($shipping, 'district', array('class' => 'control-label')); ?>
                                                <div class="controls ">
                                                    <?php echo $form->dropDownList($shipping, 'district', LibDistricts::getOptionDistrictFromProvince($shipping->city), array('class' => '', 'style' => '')); ?>
                                                    <?php echo $form->error($shipping, 'district'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="next-step">
                            <a href="<?php echo Yii::app()->homeUrl; ?>" title="Tiếp tục mua hàng" class="btn-back-step">
                                <i class="fa fa-long-arrow-left" aria-hidden="true"></i><?= Yii::t('shoppingcart', 'continueshopping') ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 pad-10">
                    <div class="border-payment">
                        <div class="title-payment">
                            <h2>Thông tin mua hàng</h2>
                        </div>
                        <?php
                        $this->renderPartial('pack_payment', array(
                            'shoppingCart' => $shoppingCart,
                            'update' => false,
                        ));
                        ?>
                        <div class="voucher">
                            <label for=""><?= Yii::t('shoppingcart', 'discount') ?></label>
                            <input class="form-control coupon_code" value="<?php echo $shoppingCart->getCouponCode(); ?>"
                                   title="Coupon code" name="coupon_code" type="text"
                                   placeholder="Nhập mã khuyến mãi" maxlength="30" />
                            <input onclick="getdiscount();" type="button" class="btn-submit-voucher" value="Gửi">
                        </div>
                        <div class="total-order">
                            <p id="money_sub_total"><?= Yii::t('shoppingcart', 'bill_product_total') ?> 
                                <span>
                                    <?php echo number_format($shoppingCart->getTotalPrice(false), 0, ',', '.'); ?> đ
                                </span>
                                <input type="hidden" id="money_sub_total_input" value="<?= $shoppingCart->getTotalPrice(false) ?>" />
                            </p>
                            <p id="money_discount"><?= Yii::t('shoppingcart', 'discount') ?> 
                                <span>
                                    <?php
                                    $discount = $shoppingCart->getDiscountCoupon();
                                    $t = Yii::app()->request->getParam('t');
                                    if(isset($t) && $t) {
                                        echo '<pre>';
                                        print_r($discount);
                                        echo '</pre>';
                                        die();
                                    }
                                    if ($discount === CouponCampaign::TYPE_SHIPPING) {
                                        echo 'Miễn phí vận chuyển';
                                    } else {
                                        echo number_format($discount, 0, '', '.');
                                    }
                                    ?>
                                    <?php
                                    echo 'đ';
                                    ?>
                                </span>
                                <input type="hidden" id="money_discount_input" value="<?= $discount ?>" />
                            </p>
                            <p id="money_ship"><?= Yii::t('shoppingcart', 'money_ship') ?>
                                <?php
                                $shipfee = SiteConfigShipfee::getShipfeeByAddress($billing->city, $billing->district);
                                ?>
                                <?php if($shipfee == 0) { ?>
                                    <span>Thông báo sau</span>
                                <?php } else { ?>
                                <span><?= number_format($shipfee, 0, ',', '.') ?> đ</span>
                                <?php } ?>
                                <input type="hidden" id="money_ship_input" value="<?= $shipfee ?>" />
                            </p>
                            <h3>
                                <p id="money_total"><?= Yii::t('shoppingcart', 'total') ?>
                                    <?php
                                    $moneyTotal = $shoppingCart->getTotalPriceDiscount() + $shipfee;
                                    ?>
                                    <span><?php echo number_format($moneyTotal, 0, '', '.'); ?> đ</span>
                                    <input type="hidden" id="money_total_input" value="<?= $moneyTotal ?>" />
                                </p>
                            </h3>
                        </div>
                    </div>
                    <div class="border-payment">
                        <div class="title-payment">
                            <h2><?= Yii::t('shoppingcart', 'payment_method') ?> </h2>
                        </div>
                        <?php
                        $this->renderPartial('nganluong/bank', array(
                        ));
                        ?>
                    </div>
                    <div class="btn-end-step1">
                        <a href="javascript:void(0)" id="btn-payment-submit" class="btn-next-step"><?= Yii::t('shoppingcart', 'checkout') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- /content-wrap -->
<!-- Main -->   
<script type="text/javascript">

    Number.prototype.formatMoney = function (c, d, t) {
        var n = this,
                c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
                j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
    function getdistrictAndshipfee() {
        var payment_method = $('#Orders_payment_method').val();
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/economy/shoppingcart/getdistrictAndshipfee') ?>',
            data: 'pid=' + jQuery('#Billing_city').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#Billing_city'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#Billing_district').html(res.html);
                    if (payment_method != 1) {
                        var ship = res.shipfee + res.shipfeeweight;
                        var discount_coupon = $('#money_discount_input').val();
                        var total_price = $('#money_sub_total_input').val();
                        var total_andship = parseInt(total_price) - parseInt(discount_coupon) + parseInt(ship);
                        jQuery('#money_ship span').text(parseInt(ship).formatMoney(0, ',', '.') + ' đ');
                        jQuery('#money_total span').html(total_andship.formatMoney(0, ',', '.') + ' đ');
                        jQuery('#money_total_input').val(total_andship);
                        jQuery('#money_ship_input').val(ship);
                    }
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    }

    function getshipfee() {
        var payment_method = $('#Orders_payment_method').val();
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/economy/shoppingcart/getshipfee'); ?>',
            data: 'pid=' + jQuery('#Billing_city').val() + '&did=' + jQuery('#Billing_district').val(),
            dataType: 'JSON',
            success: function (res) {
                if (res.code == 200 && payment_method != 1) {
                    var ship = res.shipfee + res.shipfeeweight;
                    var discount_coupon = $('#money_discount_input').val();
                    var total_price = $('#money_sub_total_input').val();
                    var total_andship = parseInt(total_price) - parseInt(discount_coupon) + parseInt(ship);
                    jQuery('#money_ship span').text(parseInt(ship).formatMoney(0, ',', '.') + ' đ');
                    jQuery('#money_total span').html(total_andship.formatMoney(0, ',', '.') + ' đ');
                    jQuery('#money_total_input').val(total_andship);
                    jQuery('#money_ship_input').val(ship);
                }
            },
        });
    }

    jQuery(document).on('change', '#Billing_city', function () {
        getdistrictAndshipfee();
    });

    jQuery(document).on('change', '#Billing_district', function () {
        getshipfee();
    });

    $(document).ready(function () {
        $("#billtoship").click(function () {
            if ($(this).is(':checked')) {
                $('.steps-hoso').removeClass('show');
            } else {
                $('.steps-hoso').addClass('show');
            }
        });
        //
        $('#btn-payment-submit').click(function () {
            $('#sc-checkout-form').submit();
        });

    });

    //Get discount
    function getdiscount() {
        var code = $('input.coupon_code').val();
        if (code == '') {
            alert('Bạn phải nhập mã giảm giá.');
            return false;
        }
        $.getJSON(
                '<?php echo Yii::app()->createUrl('economy/shoppingcart/getdiscount'); ?>',
                {code: code},
        function (data) {
            if (data.code == 200) {
                var total_price = $('#money_sub_total_input').val();
                var ship = $('#money_ship_input').val();
                var total_andship = parseInt(total_price) - parseInt(data.discountNotFormat) + parseInt(ship);
                var discount_value = 0;
                var couponvalue = 0;
                $('#money_discount_input').val(data.discountNotFormat);
                $('#money_discount span').html(data.totalDiscount);
                $('#money_total span').html(total_andship.formatMoney(0, ',', '.') + ' đ');
            } else {
                alert(data.msg);
            }
        }
        );
    }
</script>
