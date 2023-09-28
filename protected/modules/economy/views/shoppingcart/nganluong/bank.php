<?php
$config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
$configAlepay = SitePayment::model()->getConfigPayment(SitePayment::TYPE_ALEPAY);
?>
<div class="payment-method">
    <div class="col-xs-12 payment">
        <ul class="list-content">
            <li class="active">
                <label><input type="radio" value="2" name="Orders[payment_method]" checked="">Thanh toán tiền mặt khi nhận hàng</label>
            </li>
            <?php if ($config) { ?>
                <li>
                    <label>
                        <input type="radio" value="ATM_ONLINE" name="Orders[payment_method]">Thanh toán online bằng thẻ ngân hàng nội địa
                    </label>
                    <div class="boxContent">
                        <p>
                            <i>
                                <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>: Bạn cần đăng ký Internet-Banking hoặc dịch vụ thanh toán trực tuyến tại ngân hàng trước khi thực hiện.
                            </i>
                        </p>
                        <ul class="cardList clearfix">
                            <li class="bank-online-methods">
                                <label for="vcb_ck_on">
                                    <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                    <input type="radio" value="BIDV" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="vcb_ck_on">
                                    <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                    <input type="radio" value="VCB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="vnbc_ck_on">
                                    <i class="DAB" title="Ngân hàng Đông Á"></i>
                                    <input type="radio" value="DAB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="tcb_ck_on">
                                    <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                    <input type="radio" value="TCB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_mb_ck_on">
                                    <i class="MB" title="Ngân hàng Quân Đội"></i>
                                    <input type="radio" value="MB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_vib_ck_on">
                                    <i class="VIB" title="Ngân hàng Quốc tế"></i>
                                    <input type="radio" value="VIB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_vtb_ck_on">
                                    <i class="ICB" title="Ngân hàng Công Thương Việt Nam"></i>
                                    <input type="radio" value="ICB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_exb_ck_on">
                                    <i class="EXB" title="Ngân hàng Xuất Nhập Khẩu"></i>
                                    <input type="radio" value="EXB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_acb_ck_on">
                                    <i class="ACB" title="Ngân hàng Á Châu"></i>
                                    <input type="radio" value="ACB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_hdb_ck_on">
                                    <i class="HDB" title="Ngân hàng Phát triển Nhà TPHCM"></i>
                                    <input type="radio" value="HDB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_msb_ck_on">
                                    <i class="MSB" title="Ngân hàng Hàng Hải"></i>
                                    <input type="radio" value="MSB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_nvb_ck_on">
                                    <i class="NVB" title="Ngân hàng Nam Việt"></i>
                                    <input type="radio" value="NVB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_vab_ck_on">
                                    <i class="VAB" title="Ngân hàng Việt Á"></i>
                                    <input type="radio" value="VAB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_vpb_ck_on">
                                    <i class="VPB" title="Ngân Hàng Việt Nam Thịnh Vượng"></i>
                                    <input type="radio" value="VPB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_scb_ck_on">
                                    <i class="SCB" title="Ngân hàng Sài Gòn Thương tín"></i>
                                    <input type="radio" value="SCB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="bnt_atm_pgb_ck_on">
                                    <i class="PGB" title="Ngân hàng Xăng dầu Petrolimex"></i>
                                    <input type="radio" value="PGB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="bnt_atm_gpb_ck_on">
                                    <i class="GPB" title="Ngân hàng TMCP Dầu khí Toàn Cầu"></i>
                                    <input type="radio" value="GPB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="bnt_atm_agb_ck_on">
                                    <i class="AGB" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"></i>
                                    <input type="radio" value="AGB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="bnt_atm_sgb_ck_on">
                                    <i class="SGB" title="Ngân hàng Sài Gòn Công Thương"></i>
                                    <input type="radio" value="SGB" name="Orders[payment_method_child]">
                                </label>
                            </li>   
                            <li class="bank-online-methods">
                                <label for="sml_atm_bab_ck_on">
                                    <i class="BAB" title="Ngân hàng Bắc Á"></i>
                                    <input type="radio" value="BAB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_bab_ck_on">
                                    <i class="TPB" title="Tền phong bank"></i>
                                    <input type="radio" value="TPB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_bab_ck_on">
                                    <i class="NAB" title="Ngân hàng Nam Á"></i>
                                    <input type="radio" value="NAB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_bab_ck_on">
                                    <i class="SHB" title="Ngân hàng TMCP Sài Gòn - Hà Nội (SHB)"></i>
                                    <input type="radio" value="SHB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="sml_atm_bab_ck_on">
                                    <i class="OJB" title="Ngân hàng TMCP Đại Dương (OceanBank)"></i>
                                    <input type="radio" value="OJB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="">
                    <label><input type="radio" value="IB_ONLINE" name="Orders[payment_method]">Thanh toán bằng Internet Banking</label>
                    <div class="boxContent">
                        <p>
                            <i>
                                <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>: Bạn cần đăng ký Internet-Banking hoặc dịch vụ thanh toán trực tuyến tại ngân hàng trước khi thực hiện.
                            </i>
                        </p>
                        <ul class="cardList clearfix">
                            <li class="bank-online-methods">
                                <label for="vcb_ck_on">
                                    <i class="BIDV" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"></i>
                                    <input type="radio" value="BIDV" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="vcb_ck_on">
                                    <i class="VCB" title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                    <input type="radio" value="VCB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="vnbc_ck_on">
                                    <i class="DAB" title="Ngân hàng Đông Á"></i>
                                    <input type="radio" value="DAB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="tcb_ck_on">
                                    <i class="TCB" title="Ngân hàng Kỹ Thương"></i>
                                    <input type="radio" value="TCB" name="Orders[payment_method_child]">
                                </label>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="">
                    <label><input type="radio" value="VISA" name="Orders[payment_method]" selected="true">Thanh toán bằng thẻ Visa hoặc MasterCard</label>
                    <div class="boxContent">
                        <p><span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>:Visa hoặc MasterCard.</p>
                        <ul class="cardList clearfix">
                            <li class="bank-online-methods">
                                <label for="vcb_ck_on">
                                    <i class="visacard" title="Thẻ Visa"></i>
                                    <input type="radio" value="VISA" name="Orders[payment_method_child]">
                                </label>
                            </li>
                            <li class="bank-online-methods">
                                <label for="vnbc_ck_on">
                                    <i class="mastercard" title="Thẻ MasterCard"></i>
                                    <input type="radio" value="MASTER" name="Orders[payment_method_child]">
                                </label>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php } ?>
            <?php if ($configAlepay) { ?>
                <li>
                    <label><input type="radio" value="AMORTIZATION" name="Orders[payment_method]" />Mua trả góp qua Alepay</label>
                    <div class="boxContent">
                        <p>
                            <i>
                                <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>: Bạn phải có thẻ tín dụng trước khi thực hiện.
                            </i>
                        </p>
                    </div>
                </li>
            <?php } ?>
        </ul>

        <script language="javascript">
            $('input[name="Orders[payment_method]"]').bind('click', function () {
                $('.list-content li').removeClass('active');
                $(this).parent().parent('li').addClass('active');
            });
        </script>                             
    </div>
</div>