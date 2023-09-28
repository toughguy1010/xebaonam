<?php
$js = 'function updateQuantity(key, quantity, set) { if(quantity==0) {$(this).val(0);} document.location = "' . $this->createUrl('/economy/shoppingcart/update') . '?key=" + key + "&qty=" + quantity  + "&set=" + set; }';
Yii::app()->clientScript->registerScript('updateQuantity', $js, CClientScript::POS_END);
$set = $_GET['sid'];
?>
<div class="sc shoppingcart">
    <?php if ($shoppingCart->getSetProducts($set)) { ?>
        <div class="span12">
            <h2 class="sc-title"><?php echo Yii::t('shoppingcart', 'shoppingcart'); ?></h2>
            <?php
            $this->renderPartial('partial_set/set_pack_detail', array(
                'shoppingCart' => $shoppingCart,
                'set' => $set,
            ));
            ?>
            <div class="row">
                <div class="col-xs-6">
                    <a class="btn btn-sm btn-primary"
                       href="<?php echo Yii::app()->homeUrl; ?>"><?php echo Yii::t('shoppingcart', 'continueshopping'); ?></a>
                </div>
                <div class="col-xs-6">
                    <a class="btn btn-sm btn-primary pull-right"
                       href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/checkout', array('step' => 's2', 'user' => 'guest','sid'=>$set)); ?>"><?php echo Yii::t('shoppingcart', 'checkout'); ?></a>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <p class="text-warning">
            <?php echo Yii::t('shoppingcart', 'havanoproduct'); ?>
        </p>
    <?php } ?>
</div>