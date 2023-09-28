<?php
$config = SitePayment::model()->getConfigPayment('baokim');
$methodGroup = TourBooking::getPaymentMethodOnline();
$methods = ($config) ? BaokimHelper::helper()->mergeConfig($config)->getListMethod() : BaokimHelper::helper()->getListMethod();
?>
<?php if (!empty($methodGroup) && $methods) { ?>
    <div class="payment">
        <div class="bk_payment_online" id="bk_payment_ol" style="padding-left: 20px;">
            <?php foreach ($methodGroup as $key => $val) { ?>
                <div class="group_method">                          
                    <?php if (isset($methods[$key]) && count($methods[$key])) { ?>
                        <div class="list_method list_method_<?php echo $key; ?>">
                            <?php foreach ($methods[$key] as $med) { ?>
                                <a class="item_bank" idata="<?php echo $med['id']; ?>" naction="<?php echo $med['next_action']; ?>" href="javascript:;">                            
                                    <img width="52" height="40" src="<?php echo $med['logo_url']; ?>" alt=""/>
                                </a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <input type="hidden" name="TourBooking[payment_method_child]" value="<?php echo $model->payment_method_child; ?>" id="tourbooking_pm_child"/>
        </div>
    </div>
    <script type="text/javascript">
        var payment = {is_payment_online: true<?php //echo (int)SitePayment::model()->checkPaymentOnline(); ?>, method: 0, method_child: 0};
        jQuery(document).ready(function() {
            if (jQuery('#tourbooking_pm_child').val() || jQuery("#TourBooking_payment_method").val()) {
                payment.method_child = jQuery('#tourbooking_pm_child').val();
                payment.method = jQuery("#TourBooking_payment_method").val();
                if (payment.method_child) {
                    jQuery('.item_bank').filter("[idata='" + payment.method_child + "']").addClass('active').parents('.list_method').addClass('active').show();
                } else {
                    jQuery('.list_method_' + payment.method).addClass('active').slideDown();
                }
            }
            jQuery('#TourBooking_payment_method').on('change', function() {
                if (jQuery(this).val() == 'baokim') {
                    jQuery('#tourbooking_pm_child').val(jQuery(this).val());
                    payment.method_child = jQuery(this).val();
                } else {
                    if (typeof jQuery('.list_method_' + jQuery(this).val()).children('.item_bank.active').attr('idata') != 'undefined') {
                        payment.method_child = jQuery('.item_bank.active').attr('idata');
                    } else {
                        payment.method_child = 0;
                    }
                }
                if (!jQuery('.list_method_' + jQuery(this).val()).hasClass('active')) {
                    jQuery('.list_method.active').removeClass('active').slideUp();
                    jQuery('.list_method_' + jQuery(this).val()).addClass('active').slideDown();
                }
            });
            jQuery('.item_bank').on('click', function() {
                payment.method_child = jQuery(this).attr('idata');
                jQuery('#tourbooking_pm_child').val(jQuery(this).attr('idata'));
                jQuery('.item_bank.active').removeClass('active');
                jQuery(this).addClass('active');
            });
        });
    </script>

    <?php
}?>