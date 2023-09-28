<?php
$js = 'function updateQuantity(key, quantity) { if(quantity==0) {$(this).val(0);} document.location = "' . $this->createUrl('/economy/shoppingcart/update') . '?key=" + key + "&qty=" + quantity; }';
Yii::app()->clientScript->registerScript('updateQuantity', $js, CClientScript::POS_END);
?>
<div class="sc shoppingcart">
    <?php if($shoppingCart->getProducts()){ ?>
    <div class="span12">
        <h2 class="sc-title"><?php echo Yii::t('shoppingcart', 'shoppingcart'); ?></h2>
        <?php
        $this->renderPartial('pack', array(
            'shoppingCart' => $shoppingCart,
        ));
        ?>
        <div class="row">	  
            <div class="col-xs-6">
                <a class="btn btn-sm btn-primary" href="<?php echo Yii::app()->homeUrl; ?>"><?php echo Yii::t('shoppingcart', 'continueshopping'); ?></a>
            </div>		  
            <div class="col-xs-6">
                <a class="btn btn-sm btn-primary pull-right" href="<?php echo $this->createUrl('/economy/shoppingcart/checkout'); ?>"><?php echo Yii::t('shoppingcart', 'checkout'); ?></a>
            </div>
        </div>
    </div>
    <?php }else{ ?>
    <p class="text-warning">
        <?php echo Yii::t('shoppingcart','havanoproduct'); ?>
    </p>
    <?php } ?>
</div>