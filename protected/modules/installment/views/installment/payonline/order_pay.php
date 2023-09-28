<link href="<?php echo Yii::app()->request->baseUrl; ?>/installment/css/order.css" rel="stylesheet"/>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/installment/css/tragop.css" rel="stylesheet"/>
<div class="container">
    <div class="installment_index pay">

        <div class="installment">
            <div class="infoproduct">
                <a class="linksp">
                    <img width="40" height="40"
                         src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's80_80/' . $product['avatar_name'] ?>"
                         alt="<?= $product['name'] ?>">
                </a>
                <div>Mua trả góp <a
                            href="<?= Yii::app()->createUrl('economy/product/detail', ['id' => $product->id, 'alias' => $product->alias]) ?>"
                            title="<?= $product['name'] ?> target=" _blank"><?= $product['name'] ?></a></div>
                <div id="price-Product">
                    <?php if ($product->price_market) {
                        $discount = 'Giảm ' . ClaInstallment::getDiscount($product->price_market, $product->price) . '%';
                        ?>
                        <i>-<?= $discount ?></i> Giá sản phẩm
                        <span class="line-price"><?= number_format($product->price_market, 0, '', '.') . '₫' ?></span>
                    <?php } ?>
                    <strong><?= number_format($product->price, 0, '', '.') . '₫' ?> </strong>
                    <div class="km">Chi tiết khuyến mãi</div>
                    <!-- Khuyến mãi -->
                    <div class="boxShowKM" style="display: none;">
                        <div class="boxkm zero">
                            <?= $product->product_info->product_sortdesc ?>
                            <label>* Khuyến mãi không áp dụng đồng thời cho trả góp 0%</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tim">
                <input type="search" id="txtsuggest" name="txtsuggest" placeholder="Tìm sản phẩm trả góp khác"
                       maxlength="50">
                <button id="btnsuggestinstall"><i class="icontg-tim"></i></button>
            </div>
            <div class="tabslink">
                <a href="<?= Yii::app()->createUrl('installment/installment/index', ['id' => $product->id]) ?>"
                   rel="cttc">
                    <div>
                        <i class="icontg-taichinh"></i>
                        Công ty tài chính<span>Duyệt online trong 4 giờ</span>
                    </div>
                </a>
                <a href="<?= Yii::app()->createUrl('installment/installment/checkoutPay', ['id' => $product->id]) ?>"
                   class="current"
                   rel="alepay">
                    <div>
                        <i class="icontg-thetd"></i>
                        Qua thẻ tín dụng<span>Không cần xét duyệt</span>
                    </div>
                </a>
            </div>
            <div class="datatable">
                <div class="boxbank">
                    <a href="javascript:void(0)" onclick="ViewAlepayInfo()" class="prdetail">Xem chi tiết chương
                        trình</a>
                    <div class="step">Bước 1: Chọn ngân hàng trả góp</div>
                    <div id="listbank" class="listbank">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'payinstall',
//                                'action' => Yii::app()->createUrl('installment/installment/checkout'),
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => false,
                            'htmlOptions' => array(
                                'class' => 'formorder',
                            ),
                        ));
                        ?>
                        <div class="listbank list_bank_ inside" id="listbank">
                            <?php foreach ($listbank as $key => $bank) {
                                $method = $bank->paymentMethods;
                                ?>
                                <a href="javascript:void(0)" data-card="<?php foreach ($method as $m) {
                                    echo $m->paymentMethod . ',';
                                } ?>" data-code="<?= $bank->bankCode ?>"
                                   data-name="<?= $bank->bankName ?>"
                                   onclick="ChooseBankSetCardType(this)">
                                    <i class="icontg-<?= strtolower($bank->bankCode) ?>"></i>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="step_2" style="display: none">
                            <div class="step" id="step2">Bước 2: Chọn loại thẻ</div>
                            <div class="listbank listcard" id="cardtype">
                                <a href="javascript:void(0)" id="VISA" data-code="VISA" data-name="Thẻ Visa"
                                   data-card="VISA" class="acti"><i
                                            class="icontg-visa"></i></a>
                                <a href="javascript:void(0)" id="MASTERCARD" data-code="MASTERCARD"
                                   data-name="Thẻ Master card" data-card="MASTERCARD"><i
                                            class="icontg-master"></i></a>
                                <a href="javascript:void(0)" id="JCB" data-code="JCB" data-name="JCB"
                                   data-card="JCB">
                                    <i class="icontg-jcb"></i>
                                </a>
                            </div>
                        </div>
                        <div id="boxresult-bank" style="display: none;">

                        </div>
                        <div id="div-info" class="areainfo" style="display: none;">
                            <label class="small-text width-100"><b>Bước 3: Chọn số tiền muốn trả góp và nhập thông tin
                                    của bạn</b></label>
                            <div class="width-100" id="city">
                                <div class="left">
                                    <?php
                                    echo $form->dropDownList($model, 'prepay', ClaInstallment::getPrePrice($product->price), array('class' => 'span9 form-control', 'data-check' => 1));
                                    ?>
                                    <?php echo $form->error($model, 'prepay'); ?>
                                </div>
                                <div class="left">
                                </div>
                            </div>
                            <label class="small-text width-100"><b>Thông tin người mua</b></label>
                            <div class="malefemale">
                                <label for="male">
                                    <input id="male" type="radio" value="0" name="InstallmentOrder[sex]" checked="">
                                    Anh
                                </label>
                                <label for="female">
                                    <input id="female" type="radio" value="1" name="InstallmentOrder[sex]">
                                    Chị
                                </label>
                                <?php echo $form->error($model, 'sex'); ?>
                            </div>
                            <div class="left">
                                <?php echo $form->textField($model, 'username', array('class' => 'saveinfo', 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('username'))); ?>
                                <?php echo $form->error($model, 'username'); ?>
                            </div>
                            <div class="right">
                                <?php echo $form->textField($model, 'phone', array('class' => 'saveinfo', 'maxlength' => 11, 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                                <?php echo $form->error($model, 'phone'); ?>
                            </div>
                            <label class="small-text width-100"><b>Để được phục vụ nhanh hơn:</b> hãy chọn
                                thêm</label>
                            <div class="citydis">
                                <div class="malefemale supermarket">
                                    <label for="type0" data-show="0">
                                        <input id="type0" type="radio" value="0" name="InstallmentOrder[type_ship]"
                                               checked="">
                                        Địa chỉ giao hàng
                                    </label>
                                    <label for="type1" data-show="1">
                                        <input id="type1" type="radio" value="1" name="InstallmentOrder[type_ship]">
                                        Nhận tại siêu thị
                                    </label>
                                    <?php echo $form->error($model, 'sex'); ?>
                                </div>
                                <div class="area_address">
                                    <div class="citydis">
                                        <div class="left" id="city">
                                            <?php
                                            echo $form->dropDownList($model, 'province_id', $listprivince, array('class' => 'span9 form-control', 'data-check' => 1));
                                            ?>
                                            <?php echo $form->error($model, 'province_id'); ?>
                                        </div>
                                        <div class="right" id="dist">
                                            <?php
                                            echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span9 form-control', 'data-check' => 0, 'prompt' => 'Chọn quận/huyện'));
                                            ?>
                                            <?php echo $form->error($model, 'district_id'); ?>
                                        </div>
                                    </div>
                                    <div class="citydis inshop">
                                        <?php echo $form->textField($model, 'address', array('class' => 'saveinfo address', 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('address'))); ?>
                                        <?php echo $form->error($model, 'address'); ?>
                                    </div>
                                    <div class="citydis">
                                        <?php echo $form->textArea($model, 'note', array('class' => 'saveinfo', 'maxlength' => 500, 'placeholder' => $model->getAttributeLabel('note'))); ?>
                                        <?php echo $form->error($model, 'note'); ?>
                                    </div>
                                    <div class="sieuthi">
                                        <div class="shop">
                                            <input type="hidden" value="N/A" name="InstallmentOrder[shop_id]">
                                        </div>
                                        <?php echo $form->error($model, 'shop_id'); ?>
                                    </div>
                                </div>
                            </div>
                            <span id="alepay-err" style="display: none"></span>
                            <a onclick="addCardInstallment()" class="add_card cart-btt full-width" href="javascript:void(0)">Thanh toán ngay</a>
                        </div>
                        <input type="hidden" class="bankCode_" value="" name="InstallmentOrder[bankCode]">
                        <input type="hidden" class="paymentMethod_" value="" name="InstallmentOrder[paymentMethod]">
                        <input type="hidden" class="month_" value="" name="InstallmentOrder[month]">
                        <input type="hidden" class= "info_fee total"name="InstallmentOrder[total]" value=""> <!--Tổng tiền-->
                        <input type="hidden" class= "info_fee every_month"name="InstallmentOrder[every_month]" value=""><!--Trả hàng tháng-->
                        <input type="hidden" class= "info_fee difference"name="InstallmentOrder[difference]" value=""><!--Chênh lệch-->
                        <input type="hidden" class= "info_fee fee"name="InstallmentOrder[interest_rate]" value=""><!--Lãi suất-->
                        <input type="hidden" class="price_" value="<?= $product->price ?>">
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="loading-cart">
                <span class="cswrap">
                    <span class="csdot"></span>
                    <span class="csdot"></span>
                    <span class="csdot"></span>
                </span>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/installment/js/main.js"></script>
<script>
    $(document).ready(function () {
        $('.step_2 a').on('click', function () {
            var bank = $('#listbank a.acti').attr('data-code');
            var card = $(this).attr('data-code');
            var price = $('.price_').val();
            $('.paymentMethod_').val($(this).data('code'));
            $('.step_2 a').removeClass('acti');
            $(this).addClass('acti');
            $('.loading-cart').show();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "<?=Yii::app()->createUrl('installment/installment/getFee')?>",
                data: {bank: bank, card: card, price: price},
                success: function (data) {
                    if (data.html) {
                        $('#boxresult-bank').show();
                        $('#boxresult-bank').html(data.html);
                        $('#div-info').show();
                        $('.loading-cart').hide();
                    }
                },
                error: function () {
                }
            });
        });
        $('#div-info #InstallmentOrder_prepay').on('change', function () {
            var bank = $('#listbank a.acti').attr('data-code');
            var card = $('.step_2 a.acti').attr('data-code');
            var price = <?=$product->price?> - ('<?=$product->price?>'*$(this).val());//Giá mua trả góp
            if (price <3000000) {
                alert('Số tiền mua trả góp phải nhiều hơn 3.000.000đ. Hiện tại '+ price+'đ');
                return false;
            }
            var price_old = '<?=$product->price?>';
            $('.price_').val(price);
            $('.loading-cart').show();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "<?=Yii::app()->createUrl('installment/installment/getFee')?>",
                data: {bank: bank, card: card, price: price,price_old:price_old},
                success: function (data) {
                    if (data.html) {
                        $('#boxresult-bank').show();
                        $('#boxresult-bank').html(data.html);
                        $('.loading-cart').hide();
                    }
                },
                error: function () {
                }
            });
        });
        $('.table li .mua').click(function () {
            var id = $(this).attr('data-id');
            var month = $('.listmonths li.actived').attr('data-month');
            var pre = $('.infolist li.actived').attr('data-value');
            var bhkv = $('.bhkv').attr('data-bh');
            var object = '<?=$product->id?>';
            window.location.href = "<?=Yii::app()->createUrl('installment/installment/orderInstallment')?>?id=" + object + ',' + id + ',' + month + ',' + pre + ',' + bhkv;
        })
    });

    jQuery(document).on('change', '#InstallmentOrder_province_id,#InstallmentOrder_district_id', function () {
        var province = jQuery('#InstallmentOrder_province_id').val();
        var district = jQuery('#InstallmentOrder_district_id').val();
        var viewshop = $('.malefemale.supermarket input:checked').val();
        var check = jQuery(this).attr('data-check');
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/installment/installment/getdistrict') ?>',
            data: {pid: province, district: district, allownull: 1, viewshop: viewshop},
            dataType: 'JSON',
            beforeSend: function () {
                $('.loading-cart').show();
            },
            success: function (res) {
                if (res.code == 200) {
                    if (res.html && check == 1) {
                        jQuery('#InstallmentOrder_district_id').html(res.html);
                    }
                    if (res.viewshop) {
                        jQuery('.sieuthi .shop').html(res.viewshop);
                    }
                }
                $('.loading-cart').hide();
            },
            error: function () {
                $('.loading-cart').hide();
            }
        });
    });
</script>
