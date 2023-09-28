<?php 
    $methodGroup = 1;
    $methods = BaokimHelper::helper()->getListMethod();
    
?>
                      
<?php if(isset($methods[$methodGroup]) && count($methods[$methodGroup])){?>
    <div class="list_method list_method_<?php echo $methodGroup;?>">
        <p class="l_b_title">Thanh toán qua thẻ ATM có Internet Banking </p>
        <?php foreach($methods[$methodGroup] as $med){?>
            <a class="item_bank" idata="<?php echo $med['id'];?>" naction="<?php echo $med['next_action'];?>" href="javascript:;">                            
                <img width="52" height="40" src="<?php echo $med['logo_url'];?>" alt=""/>
            </a>
        <?php }?>
    </div>
<?php }?>
<input type="hidden" name="SmsOrder[payment_method_child]" value="<?php echo $model->payment_method_child;?>" id="order_pm_child"/></div>
<script type="text/javascript">
    var payment = {method:3,method_child:0};
    jQuery(document).ready(function() {     
        if(jQuery('#order_pm_child').val()){
            payment.method_child = jQuery('#order_pm_child').val();                        
            jQuery('.item_bank').filter("[idata='"+payment.method_child+"']").addClass('active');
        }
        jQuery('.item_bank').on('click',function(){
            payment.method_child = jQuery(this).attr('idata');
            jQuery('#order_pm_child').val(jQuery(this).attr('idata'));
            jQuery('.item_bank.active').removeClass('active');
            jQuery(this).addClass('active');
        });        
    });    
</script>