<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<div class="page-taodonhang">
    <div class="container">
        <div class="wizard small row">
            <a href="<?= Yii::app()->createUrl('/economy/rentcart/order') ?>">
                Tạo Đơn Hàng
            </a>
            <a href="<?= Yii::app()->createUrl('/economy/rentcart/billingInfo') ?>">
                Thông Tin Cá Nhân
            </a>
            <a href="<?= Yii::app()->createUrl('/economy/rentcart/order') ?>" class="current">
                Thanh Toán
            </a>
        </div>
        <div class="info-section">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl(''),
                'method' => 'POST',
                'id' => 'search_wifi',
                'htmlOptions' => array('class' => 'form-horizontal'),
            ));
            $option_product = RentProduct::getAllProductNotlimit('id, name');
            ?>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                    <div class="border-payment">
                        <div class=".title-wifi ">
                            <h2>Hình thức thanh toán</h2>
                        </div>
                        <hr>
                        <div class="payment-method">
                            <div class="col-xs-12 payment">
                                <ul class="list-content">
                                    <li>
                                        <label>
                                            <input type="radio" value="1" name="OrderRent[payment_method]"
                                                   checked="">Thanh toán tiền mặt khi nhận hàng
                                        </label>
                                    </li>
                                    <li class="active">
                                        <label>
                                            <input type="radio" value="2" name="OrderRent[payment_method]"
                                                   checked="">Chuyển khoản qua ngân hàng
                                        </label>
                                        <div class="boxContent">
                                            <div class="clearfix">
                                                <?php
                                                //                                                die();
                                                if ($shoppingCart->getVatStatus()) { ?>
                                                    <?php if (($shoppingCart->receive_type == 4 && $shoppingCart->province_id == '01') | $shoppingCart->receive_type == 1 | $shoppingCart->receive_type == 3) { ?>
                                                        <p><b style="color: blue">Công Ty TNHH Dịch Vụ Và Thương Mại
                                                                VJC-
                                                                Chi Nhánh
                                                                Hà Nội</b></p>
                                                        <p><b>Số tài khoản: 12210001427770 </b></p>
                                                        <p><b>Ngân hàng BIDV - Chi nhánh Hà Nội</b></p>
                                                        <br>
                                                    <?php } ?>

                                                    <?php if (($shoppingCart->receive_type == 4 && $shoppingCart->province_id == '79') | $shoppingCart->receive_type == 2) { ?>
                                                        <p><b style="color: blue">CÔNG TY TNHH DỊCH VỤ VÀ THƯƠNG MẠI
                                                                VJC</b>
                                                        </p>
                                                        <p><b>Số tài khoản: 0441000693080</b></p>
                                                        <p><b>Ngân hàng Vietcombank – Chi nhánh Kỳ Đồng</b></p>
                                                        <br>
                                                    <?php } ?>
                                                    <p style="font-size: 12px;color: blue">
                                                        (*) Khi chuyển tiền từ tên tài khoản khác tên người đăng ký, vui
                                                        lòng ghi chú tên người đăng ký khi chuyển khoản.
                                                    </p>

                                                <?php } else { ?>
                                                    <?php if (($shoppingCart->receive_type == 4 && $shoppingCart->province_id == '01') | $shoppingCart->receive_type == 1 | $shoppingCart->receive_type == 3) { ?>
                                                        <p><b style="color: blue">CÔNG TY TNHH DỊCH VỤ VÀ THƯƠNG MẠI VJC
                                                                miền Bắc</b>
                                                        </p>
                                                        <p><b>Chủ thẻ: Nguyễn Thị Hương Giang</b></p>
                                                        <p><b>Số tài khoản: 12210001436758</b></p>
                                                        <p><b>Ngân hàng BIDV - Chi nhánh Hà Thành</b></p>
                                                        <br>
                                                    <?php } ?>

                                                    <?php if (($shoppingCart->receive_type == 4 && $shoppingCart->province_id == '79') | $shoppingCart->receive_type == 2) { ?>
                                                        <p><b style="color: blue">Công Ty TNHH Dịch Vụ Và Thương Mại
                                                                VJC-
                                                                Chi Nhánh miền nam</b></p>
                                                        <p><b>Chủ thẻ: Nguyễn Quốc Bảo</b></p>
                                                        <p><b>Số tài khoản: 0441000730390</b></p>
                                                        <p><b>Vietcombank - Chi nhánh Kỳ Đồng</b></p>
                                                        <br>
                                                    <?php } ?>

                                                    <p style="font-size: 12px;color: blue">
                                                        (*) Khi chuyển tiền từ tên tài khoản khác tên người đăng ký, vui
                                                        lòng ghi chú tên người đăng ký khi chuyển khoản.
                                                    </p>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <hr>
                                <div class="item-phuphi">
                                    <input id="agree_policy" type="checkbox" value="1" name="agree_policy">
                                    <label class="" for="agree_policy">Tôi đồng ý với <a target="_blank"
                                                                                         href="chinh-sach-va-dieu-khoan-su-dung-pde9333.html">Điều
                                            khoản & Điều
                                            kiện.</a></label>
                                </div>
                                <div class="item-phuphi" style="display: flex">
                                    <input id="agree_rule" type="checkbox" value="1" name="agree_rule">
                                    <label class="" for="agree_rule">Tôi nhận thức rằng thiết bị này
                                        sẽ có thể không kết nối được ở những địa điểm ở vùng núi, dưới lòng đất và
                                        vùng biển.</label>
                                </div>
                                <script language="javascript">
                                    $(document).ready(function () {
                                        $('input[name="OrderRent[payment_method]"]').bind('click', function () {
                                            $('.list-content li').removeClass('active');
                                            $(this).parent().parent('li').addClass('active');
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                    <?= $rentCart ?>
                </div>
            </div>
            <div class="line-bot-order">
                <div class="back-cart">
                    <a href="<?= Yii::app()->createUrl('/economy/rentcart/billingInfo') ?>"><i
                                class="fa fa-arrow-left"></i>Quay
                        lại đặt hàng</a>
                </div>
                <div class="skip-process">
                    <button type="submit">
                        <a>Tiếp tục <i class="fa fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery('#search_wifi').on('submit', function () {
            if (!(jQuery('#agree_policy').is(':checked'))) {
                alert("Bạn cần đồng ý các điều khoản của chúng tôi");
                return false;
            }
            ;
            if (!(jQuery('#agree_rule').is(':checked'))) {
                alert("Bạn cần đồng ý các điều khoản của chúng tôi");
                return false;
            }
        });
    })
</script>
<style>
    /*payment bank*/
    ul.bankList {
        clear: both;
        height: 202px;
        width: 636px;
    }

    ul.bankList li {
        list-style-position: outside;
        list-style-type: none;
        cursor: pointer;
        float: left;
        margin-right: 0;
        padding: 5px 2px;
        text-align: center;
        width: 90px;
    }

    .list-content li {
        list-style: none outside none;
        margin: 0 0 10px;
    }

    .list-content li .boxContent {
        display: none;
        width: 100%;
        border: 1px solid #cccccc;
        padding: 10px;
    }

    .list-content li label {
        margin-bottom: 5px;
    }

    .list-content li label input {
        margin-right: 5px;
        margin-left: 5px;
        margin-top: 0px;
    }

    .list-content li.active .boxContent {
        display: block;
    }

    .list-content {
        margin: 0px;
        padding: 0px;
    }

    .list-content li .boxContent ul {
        margin: 0px;
        padding: 0px;
    }

    i.VISA, i.MASTE, i.AMREX, i.JCB, i.VCB, i.TCB, i.MB, i.VIB, i.ICB, i.EXB, i.ACB, i.HDB, i.MSB, i.NVB, i.DAB, i.SHB, i.OJB, i.SEA, i.TPB, i.PGB, i.BIDV, i.AGB, i.SCB, i.VPB, i.VAB, i.GPB, i.SGB, i.NAB, i.BAB, i.visacard, i.mastercard {
        width: 80px;
        height: 30px;
        display: block;
        background: url(https://www.nganluong.vn/webskins/skins/nganluong/checkout/version3/images/bank_logo.png) no-repeat;
    }

    i.MASTE {
        background-position: 0px -31px
    }

    i.AMREX {
        background-position: 0px -62px
    }

    i.JCB {
        background-position: 0px -93px;
    }

    i.VCB {
        background-position: 0px -124px;
    }

    i.TCB {
        background-position: 0px -155px;
    }

    i.MB {
        background-position: 0px -186px;
    }

    i.VIB {
        background-position: 0px -217px;
    }

    i.ICB {
        background-position: 0px -248px;
    }

    i.EXB {
        background-position: 0px -279px;
    }

    i.ACB {
        background-position: 0px -310px;
    }

    i.HDB {
        background-position: 0px -341px;
    }

    i.MSB {
        background-position: 0px -372px;
    }

    i.NVB {
        background-position: 0px -403px;
    }

    i.DAB {
        background-position: 0px -434px;
    }

    i.SHB {
        background-position: 0px -465px;
    }

    i.OJB {
        background-position: 0px -496px;
    }

    i.SEA {
        background-position: 0px -527px;
    }

    i.TPB {
        background-position: 0px -558px;
    }

    i.PGB {
        background-position: 0px -589px;
    }

    i.BIDV {
        background-position: 0px -620px;
    }

    i.AGB {
        background-position: 0px -651px;
    }

    i.SCB {
        background-position: 0px -682px;
    }

    i.VPB {
        background-position: 0px -713px;
    }

    i.VAB {
        background-position: 0px -744px;
    }

    i.GPB {
        background-position: 0px -775px;
    }

    i.SGB {
        background-position: 0px -806px;
    }

    i.NAB {
        background-position: 0px -837px;
    }

    i.BAB {
        background-position: 0px -868px;
    }

    i.visacard {
        background-position: 0px -1px;
    }

    i.mastercard {
        background-position: 0px -32px;
    }

    ul.cardList li {
        cursor: pointer;
        float: left;
        margin-right: 0;
        padding: 5px 4px;
        text-align: center;
        width: 100px;
    }

    /*end payment bank*/
</style>