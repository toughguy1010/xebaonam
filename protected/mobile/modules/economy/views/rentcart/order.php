<?php
$themUrl = Yii::app()->theme->baseUrl;
$address = BillingRentCart::aryAddress();
?>
<div class="hidden-sm hidden-xs">
    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK20)); ?>
</div>
<!---->
<div class="page-taodonhang">
    <div class="container">
        <div class="wizard small row">
            <a href="javascript:;" class="current">
                <b><?php echo Yii::t('rent', 'create_order') ?></b>
            </a>
            <a href="javascript:;">
                <b><?php echo Yii::t('rent', 'user_infomation') ?></b>
            </a>
            <a href="javascript:;">
                <b><?php echo Yii::t('rent', 'payment') ?></b>
            </a>
        </div>
        <div class="info-section">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl(''),
                'method' => 'POST',
                'id' => 'search_wifi',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'htmlOptions' => array('class' => 'form-horizontal'),
            ));
            $option_destination = Destinations::getOptionsDestinations();
            //
            if ($model->rent_product_id && !$model->destination_id) {
                $model->destination_id = RentProduct::model()->findByPk($model->rent_product_id)->destination_id;
            }
            //
            if ($model->destination_id) {
                $option_product = RentProduct::getAllProductNotlimit('id, name', array('destination_id' => $model->destination_id));
            } else {
                $option_product = RentProduct::getAllProductNotlimit('id, name');
            }
            ?>
            <div class=" rent-cart-stl">
                <div class="left-content">
                    <div class="item-choice-infor">
                        <label for="BillingRentCart_rent_product_id"><?= Yii::t('rent', 'where_do_we_go') ?></label>
                        <?php echo $form->dropDownList($model, 'destination_id', $option_destination, array()); ?>
                        <?php echo $form->error($model, 'destination_id'); ?>
                    </div>
                    <div class="item-choice-infor">
                        <label for="BillingRentCart_rent_product_id"><?= Yii::t('rent', 'country_you_want_to_go') ?></label>
                        <?php echo $form->dropDownList($model, 'rent_product_id', $option_product, array('onchange' => 'rentCart.updateCart.updateRentCart()')); ?>
                        <?php echo $form->error($model, 'rent_product_id'); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="item-choice-infor">
                                <?php echo $form->labelEx($model, 'from_date', array('class' => '')); ?>
                                <div class="calendar">
                                    <?php echo $form->textField($model, 'from_date', array('class' => '', 'autocomplete' => 'off')); ?>
                                    <!--                                    --><?php //echo $form->error($model, 'from_date'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="item-choice-infor">
                                <?php echo $form->labelEx($model, 'to_date', array('class' => '')); ?>
                                <div class="calendar">
                                    <?php echo $form->textField($model, 'to_date', array('class' => '', 'autocomplete' => 'off')); ?>
                                    <!--                                    --><?php //echo $form->error($model, 'to_date'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="error-box"
                         style="background: #efdf50; padding: 15px; border-radius: 20px; <?= ($shoppingCart->getDateRange() <= 3) ? 'display:block' : 'display:none' ?>">
                        <p> Rất tiếc đối với đơn hàng sát giờ hoặc số ngày thuê nhỏ hơn 3 ngày, bạn không thể đặt
                            online. Nhưng bạn có thể gọi cho
                            hotline chúng tôi để được hỗ trợ.
                            <i aria-hidden="true" class="fa fa-phone"></i>
                            <spam><a href="tel:02873035888">Hotline HN: 0931.203.838</a></spam>
                            <b>/</b>
                            <spam><a href="tel:02471077333">Hotline HCM:&nbsp; 0931.293.838</a></spam>
                        </p>
                    </div>
                    <div class="option-select"
                         style="<?= (!$model->hasErrors() && $shoppingCart->getDateRange() > 3) ? 'display:block' : 'display:none' ?>">
                        <div class="title-wifi">
                            <h2><?php echo Yii::t('rent', 'wifi_jetfi_package') ?></h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 0px;">
                                <div class="item-choice-infor" style="margin-bottom: 0px;">
                                    <?php echo $form->labelEx($model, 'quantity', array('class' => '')); ?>
                                    <?php echo $form->dropDownList($model, 'quantity', [1 => 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], array('class' => '', 'style' => 'width:400px', 'onchange' => 'rentCart.updateCart.updateRentCart()')); ?>
                                    <?php echo $form->error($model, 'quantity'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="title-wifi">
                            <h2><?php echo Yii::t('rent', 'transport_method') ?></h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                                <div class="item-choice-infor" style="margin-bottom: 0px;">
                                    <select name="BillingRentCart[receive_address_id]" id="type-select"
                                            onchange="rentCart.updateCart.updateRentCart()" style="width: 400px">
                                        <?php
                                        foreach ($address as $key => $item) {
                                            ?>
                                            <option value="<?= $key ?>" <?= ($model->receive_address_id == $key) ? 'selected="selected"' : '' ?>> <?= $item ?></option>
                                            <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="show-infor-choice"
                                     id="show1ctn"
                                     style="<?= ($model->receive_address_id == '' || $model->receive_address_id == '1') ? 'display: block' : 'display: none' ?>">
                                    <h3>Nhận thiết bị trực tiếp tại sân bay Nội Bài</h3>
                                    <p>
                                        <b>Tầng 2, cánh Đông, T2 Nội Bài – Hà Nội</b>
                                    </p>
                                    <p>
                                        Cần hỗ trợ vui lòng liên hệ số điện thoại <a
                                                style="color:red; font-weight: 600;"
                                                href="tel:0931243838">093 124 3838</a>
                                    </p>
                                </div>
                                <div class="show-infor-choice " id="show2ctn"
                                     style="<?= ($model->receive_address_id == '2') ? 'display: block' : 'display: none' ?>">
                                    <h3>Nhận thiết bị trực tiếp tại Hồ chí minh</h3>
                                    <p>
                                        <b>Tầng Trệt, tòa SCIC, 16 Trương Định, P.6, Q3</b>
                                    </p>
                                    <p>
                                        Cần hỗ trợ vui lòng liên hệ số điện thoại <a
                                                style="color:red; font-weight: 600;"
                                                href="tel:0931203838">093 120 3838</a>
                                        – <a style="color:red; font-weight: 600;" href="tel:02873035888">0287 3035
                                            888</a>
                                    </p>
                                </div>
                                <div class="show-infor-choice" id="show3ctn"
                                     style="<?= ($model->receive_address_id == '3') ? 'display: block' : 'display: none' ?>">
                                    <h3>Nhận thiết bị trực tiếp tại Hà Nội</h3>
                                    <p>
                                        <b>Tầng 9, tòa Gelex, 52 Lê Đại Hành</b>
                                    </p>
                                    <p>
                                        Cần hỗ trợ vui lòng liên hệ số điện thoại <a
                                                style="color:red; font-weight: 600;"
                                                href="tel:0931203838">093 120 3838</a>
                                        – <a style="color:red; font-weight: 600;" href="tel:02471077333">0247 1077
                                            333</a>
                                    </p>
                                </div>
                                <div class="show-infor-choice clearfix" id="show4ctn"
                                     style="<?= ($model->receive_address_id == '4') ? 'display: block' : 'display: none' ?>">
                                    <?php
                                    $listprivince = array('' => Yii::t('common', 'choose_province')) + array('01' => 'Hà Nội') + array('79' => 'Hồ Chí Minh');
                                    ?>
                                    <div class="item-choice-infor">
                                        <?php echo $form->labelEx($model, 'province_id', array('class' => '')); ?>
                                        <?php
                                        echo $form->dropDownList($model, 'province_id', $listprivince, array('class' => '', 'style' => 'width:400px; background:#fff', 'onchange' => 'rentCart.updateCart.getReceiveDistrict()'));
                                        ?>
                                        <?php echo $form->error($model, 'province_id'); ?>
                                    </div>
                                    <div class="item-choice-infor">
                                        <?php echo $form->labelEx($model, 'district_id', array('class' => '')); ?>
                                        <?php
                                        echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => '', 'style' => 'width:400px; background:#fff', 'onchange' => 'rentCart.updateCart.updateRentCart()'));
                                        ?>
                                        <?php echo $form->error($model, 'district_id'); ?>
                                    </div>
                                    <div class="item-choice-infor">
                                        <?php echo $form->labelEx($model, 'receive_address_name', array('class' => '')); ?>
                                        <?php echo $form->textField($model, 'receive_address_name'); ?>
                                        <?php echo $form->error($model, 'receive_address_name'); ?>
                                    </div>
                                    <p>Lưu ý: Với những khu vực nằm ngoài HN và HCM, Quý khách vui lòng liên hệ hotline
                                        để gặp nhân viên tư vấn hỗ trợ trực tiếp</p>
                                </div>
                            </div>
                        </div>
                        <div class="title-wifi">
                            <h2><?= Yii::t('rent', 'return_type') ?></h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                                <div class="item-choice-infor" style="margin-bottom: 0px;">
                                    <select name="BillingRentCart[return_address_id]" id="type-select2"
                                            onchange="rentCart.updateCart.updateRentCart()" style="width: 400px">
                                        <?php
                                        foreach ($address as $key => $item) {
                                            ?>
                                            <option value="<?= $key ?>" <?= ($model->return_address_id == $key) ? 'selected="selected"' : '' ?>> <?= $item ?></option>
                                            <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="show-infor-choice2" id="show1ctn2"
                                     style="<?= ($model->return_address_id == '1' || $model->return_address_id == '') ? 'display: block' : 'display: none' ?>">
                                    <h3>Trả thiết bị trực tiếp tại sân bay Nội Bài</h3>
                                    <p>
                                        <b>Tầng 2, cánh Đông, T2 Nội Bài – Hà Nội</b>
                                    </p>
                                    <p>
                                        Cần hỗ trợ vui lòng liên hệ số điện thoại
                                        <a style="color:red; font-weight: 600;" href="tel:0931243838">093 124 3838</a>
                                    </p>
                                </div>
                                <div class="show-infor-choice2" id="show2ctn2"
                                     style="<?= ($model->return_address_id == '2') ? 'display: block' : 'display: none' ?>">
                                    <h3>Trả thiết bị trực tiếp tại Hồ Chí Minh</h3>
                                    <p>
                                        <b>Tầng Trệt, tòa SCIC, 16 Trương Định, P.6, Q3</b>
                                    </p>
                                    <p>
                                        Cần hỗ trợ vui lòng liên hệ số điện thoại <a
                                                style="color:red; font-weight: 600;"
                                                href="tel:0931203838">093 120 3838</a>
                                        – <a style="color:red; font-weight: 600;" href="tel:02873035888">0287 3035
                                            888</a>
                                    </p>
                                </div>
                                <div class="show-infor-choice2"
                                     id="show3ctn2"
                                     style="<?= ($model->return_address_id == '3') ? 'display: block' : 'display: none' ?>">
                                    <h3>Trả thiết bị trực tiếp tại Hà Nội</h3>
                                    <p>
                                        <b>Tầng 9, tòa Gelex, 52 Lê Đại Hành</b>
                                    </p>
                                    <p>
                                        Cần hỗ trợ vui lòng liên hệ số điện thoại <a
                                                style="color:red; font-weight: 600;"
                                                href="tel:0931203838">093 120 3838</a>
                                        – <a style="color:red; font-weight: 600;" href="tel:02471077333">0247 1077
                                            333</a>
                                    </p>
                                </div>
                                <div class="show-infor-choice2 clearfix" id="show4ctn2"
                                     style="<?= ($model->return_address_id == '4') ? 'display: block' : 'display: none' ?>">
                                    <?php
                                    $listprivince = array('' => Yii::t('common', 'choose_province')) + array('01' => 'Hà Nội') + array('79' => 'Hồ Chí Minh');
                                    ?>
                                    <div class="item-choice-infor">
                                        <?php echo $form->labelEx($model, 'return_province_id', array('class' => '')); ?>
                                        <?php
                                        echo $form->dropDownList($model, 'return_province_id', $listprivince, array('class' => '', 'style' => 'width:400px; background:#fff', 'onchange' => 'rentCart.updateCart.getReturnDistrict()'));
                                        ?>
                                        <?php echo $form->error($model, 'return_province_id'); ?>
                                    </div>
                                    <div class="item-choice-infor">
                                        <?php echo $form->labelEx($model, 'return_district_id', array('class' => '')); ?>
                                        <?php
                                        echo $form->dropDownList($model, 'return_district_id', $listdistrict_return, array('class' => '', 'style' => 'width:400px; background:#fff', 'onchange' => 'rentCart.updateCart.updateRentCart()'));
                                        ?>
                                        <?php echo $form->error($model, 'return_district_id'); ?>
                                    </div>
                                    <div class="item-choice-infor">
                                        <?php echo $form->labelEx($model, 'return_address_name', array('class' => '')); ?>
                                        <?php echo $form->textField($model, 'return_address_name'); ?>
                                        <?php echo $form->error($model, 'return_address_name'); ?>
                                    </div>
                                    <p>Lưu ý: Với những khu vực nằm ngoài HN và HCM, Quý khách vui lòng liên hệ hotline
                                        để gặp nhân viên tư vấn hỗ trợ trực tiếp</p>
                                </div>
                            </div>
                        </div>
                        <div class="title-phuphi">
                            <h2>Phụ phí</h2>
                        </div>
                        <div class="item-phuphi">
                            <?php echo $form->checkbox($model, 'vat', array('class' => '', 'onchange' => 'rentCart.updateCart.updateRentCart()')); ?>
                            <?php echo $form->labelEx($model, 'vat', array('class' => '', 'label' => Yii::t('rent', 'print_vat_bill'))); ?>
                            <?php echo $form->error($model, 'vat'); ?>
                            <span></span>
                            <div class="taxbox clearfix"
                                 style="<?= ($model->vat) ? 'display: block' : 'display: none' ?>; background: #ebebeb; border-radius: 20px; padding: 15px;">
                                <div class="item-choice-infor">
                                    <?php echo $form->labelEx($model, 'tax_company_name', array('class' => '')); ?>
                                    <?php echo $form->textField($model, 'tax_company_name', array('class' => '', 'placeholder' => Yii::t('rent', 'Vui lòng nhập tên công ty'))); ?>
                                    <?php echo $form->error($model, 'tax_company_name'); ?>
                                </div>
                                <div class="item-choice-infor">
                                    <?php echo $form->labelEx($model, 'tax_company_code', array('class' => '')); ?>
                                    <?php echo $form->textField($model, 'tax_company_code', array('class' => '', 'placeholder' => Yii::t('rent', 'Chỉ chấp nhận ký tự - và  ký tự số'))); ?>
                                    <?php echo $form->error($model, 'tax_company_code'); ?>
                                </div>
                                <div class="item-choice-infor">
                                    <?php echo $form->labelEx($model, 'tax_company_address', array('class' => '')); ?>
                                    <?php echo $form->textField($model, 'tax_company_address', array('class' => '', 'placeholder' => Yii::t('rent', 'Nhập địa chỉ công ty (bao gồm Phường/Xã, Quận/Huyện, Tỉnh/Thành phố nếu có)'))); ?>
                                    <?php echo $form->error($model, 'tax_company_address'); ?>
                                </div>

                            </div>
                        </div>

                        <div class="item-phuphi">
                            <?php echo $form->checkbox($model, 'insurance', array('class' => '', 'onchange' => 'rentCart.updateCart.updateRentCart()')); ?>
                            <?php echo $form->labelEx($model, 'insurance', array('class' => '')); ?>
                            <?php echo $form->error($model, 'insurance'); ?>
                            <span style="color:#444;font-size: 11px"><?= Yii::t('rent', 'insurance_note',array('{url}'=>'/chinh-sach-bao-hiem-pde9371.html')) ?></span>

                        </div>
                    </div>
                </div>
                <div class="side-bar-content rightSidebar">
                    <div id="giohang">
                        <?= $rentCart ?>
                    </div>
                </div>
            </div>
            <div class="option-select"
                 style="<?= (!$model->hasErrors() && $shoppingCart->getDateRange() > 3) ? 'display:block' : 'display:none' ?>">
                <div class="line-bot-order">
                    <div class="back-cart">
                        <!--                    <a href=""><i class="fa fa-arrow-left"></i>Quay lại đặt hàng</a>-->
                    </div>
                    <div class="skip-process">
                        <button type="submit">
                            <a><?= Yii::t('rent', 'next') ?> <i class="fa fa-arrow-right"></i></a>
                        </button>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script>

    var rentCart = {
        updateCart: {
            updateRentCart: function (ev) {
                var info = $('form#search_wifi').serialize();
                var href = $('form#search_wifi').attr('action');
                if (href) {
                    jQuery.ajax({
                        url: href,
                        type: 'POST',
                        dataType: 'JSON',
                        data: info,
                        success: function (res) {
                            switch (res.code) {
                                case 200: {
                                    $('#giohang').html(res.rentCart);
                                    $('.option-select').show();
                                    $('.error-box').hide();
                                }
                                    break;
                                case 400: {
                                    $('#giohang').html(res.rentCart);
                                    $('.option-select').hide();
                                    $('.error-box').show();
                                }
                                    break;
                                default: {
                                    console.log('default');
                                }
                            }
                        },
                        error: function () {
                            // thi.removeClass('disable');
                        }
                    });
                }
            },
            getReturnDistrict: function (ev) {
                var info = $('form#search_wifi').serialize();
                jQuery.ajax({
                    url: '<?php echo Yii::app()->createUrl('/economy/rentcart/getReturnDistrict') ?>',
                    data: info,
                    dataType: 'JSON',
                    beforeSend: function () {
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            jQuery('#BillingRentCart_return_district_id').html(res.html).select2();
                            jQuery('#giohang').html(res.rentCart);
                        }
                    },
                    error: function () {
                    }
                });
            },
            getReceiveDistrict: function (ev) {
                var info = $('form#search_wifi').serialize();
                jQuery.ajax({
                    url: '<?php echo Yii::app()->createUrl('/economy/rentcart/getReceiveDistrict') ?>',
                    data: info,
                    dataType: 'JSON',
                    beforeSend: function () {
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            jQuery('#BillingRentCart_district_id').html(res.html).select2();
                            jQuery('#giohang').html(res.rentCart);
                        }
                    },
                    error: function () {
                    }
                });
            },
        }
    }

    $(document).ready(function () {

        // Type
        $('#type-select').change(function () {
            $('.show-infor-choice').hide();
            $('#show' + $(this).val() + 'ctn').show();
        });
        $('#type-select2').change(function () {
            $('.show-infor-choice2').hide();
            $('#show' + $(this).val() + 'ctn2').show();
        });

        // Show/ Hide Vat box
        jQuery(document).on('change', '#BillingRentCart_vat', function () {
            if (jQuery(this).is(':checked')) {
                jQuery('.taxbox').show();
            } else {
                jQuery('.taxbox').hide();
            }
        });

        //
        $('#BillingRentCart_destination_id').on('select2:select', function (e) {
            var data = e.params.data;
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('economy/rentcart/getProductInDestination'); ?>',
                type: 'GET',
                dataType: 'json',
                data: {"id": data.id},
                beforeSend: function (xhr) {
                },
                success: function (data) {
                    $("#BillingRentCart_rent_product_id").html(data.html).select2();
                    rentCart.updateCart.updateRentCart();
                }
            })
        });

        // Datepicker
        var myDate = new Date()
        myDate.setDate(myDate.getDate() + 4);
        //
        moment.locale('vi');
        $('input[name="BillingRentCart[from_date]"]').daterangepicker({
            minDate: myDate,
            disabledDates: [myDate],
            autoUpdateInput: true,
            singleDatePicker: true,
            locale: {
                format: 'DD/MM/YYYY'
            },
        });

        myDate.setDate(myDate.getDate() + 1);
        $('input[name="BillingRentCart[to_date]"]').daterangepicker({
            minDate: myDate,
            disabledDates: [myDate],
            autoUpdateInput: true,
            singleDatePicker: true,
            locale: {
                format: 'DD/MM/YYYY'
            },
        });

        jQuery('input[name="BillingRentCart[from_date]"],input[name="BillingRentCart[to_date]"]').on('apply.daterangepicker', function (ev, picker) {
            rentCart.updateCart.updateRentCart();
        });
    });
</script>
<style>
    .item-choice-infor input, .item-choice-infor select, .item-choice-infor .select2-container {
        background: #fff;
    }
</style>