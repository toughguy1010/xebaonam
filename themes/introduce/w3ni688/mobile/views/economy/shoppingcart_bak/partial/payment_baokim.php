<?php
$config = SitePayment::model()->getConfigPayment('baokim');
$methodGroup = Orders::getPaymentMethodOnline();
$methods = ($config) ? BaokimHelper::helper()->mergeConfig($config)->getListMethod() : array();
?>
<?php if (!empty($methodGroup)) { ?>
    <div class="bk_payment_online pm_list_children" id="bk_payment_ol" style="padding-left: 20px;">
        <?php foreach ($methodGroup as $key => $val) { ?>
            <div class="group_method">
                <label>
                    <input type="radio" name="g_method" value="<?php echo $key; ?>" />
                    <?php echo $val; ?>
                </label>            
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
        <input type="hidden" name="Orders[payment_method_child]" value="<?php echo $order->payment_method_child; ?>" id="order_pm_child"/>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            if (jQuery('#order_pm_child').val()) {
                payment.method_child = jQuery('#order_pm_child').val();
                payment.method = jQuery(".pm_parent > label > input[checked='checked']").val();
                if (payment.method_child == 'baokim') {
                    jQuery('input[name=g_method]').filter("[value='" + payment.method_child + "']").attr('checked', 'checked').parents('.pm_list_children').show();
                } else {
                    jQuery('.item_bank').filter("[idata='" + payment.method_child + "']").addClass('active').parents('.list_method').addClass('active').show();
                    jQuery('.item_bank').filter("[idata='" + payment.method_child + "']").parents('.group_method').children('label').children('input[type=radio]').attr('checked', 'checked');
                    jQuery('.item_bank').filter("[idata='" + payment.method_child + "']").parents('.pm_list_children').show();
                }
            }
            jQuery('.group_method input[type=radio]').on('click', function () {
                if (jQuery(this).val() == 'baokim') {
                    jQuery('#order_pm_child').val(jQuery(this).val());
                    payment.method_child = jQuery(this).val();
                } else {
                    if (typeof jQuery(this).parents('.group_method').children('.list_method').children('.item_bank.active').attr('idata') != 'undefined') {
                        payment.method_child = jQuery('.item_bank.active').attr('idata');
                    } else {
                        payment.method_child = 0;
                    }
                }
                if (!jQuery(this).parents('.group_method').children('.list_method').hasClass('active')) {
                    jQuery('.list_method.active').removeClass('active').slideUp();
                    jQuery(this).parents('.group_method').children('.list_method').addClass('active').slideDown();
                }
            });
            jQuery('.item_bank').on('click', function () {
                payment.method_child = jQuery(this).attr('idata');
                jQuery('#order_pm_child').val(jQuery(this).attr('idata'));
                jQuery('.item_bank.active').removeClass('active');
                jQuery(this).addClass('active');
            });
        });
    </script>

<?php
}?>