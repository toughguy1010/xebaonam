<div class="sc shoppingcart">
    <?php
    $this->renderPartial('pack', array(
        'shoppingCart' => $shoppingCart,
        'update' => false,
    ));
    ?>
    <div class="row">	  		  
        <div class="col-xs-6 pull-right" style="margin-bottom: 10px;margin-right:10px;">
            <a class="btn btn-sm btn-primary pull-right" href="<?php echo $this->createUrl('/economy/shoppingcart'); ?>"><?php echo Yii::t('shoppingcart', 'go_to_cart'); ?></a>
        </div>
    </div>
</div>