<?php
$js = 'function updateQuantity(key, quantity) { if(quantity==0) {$(this).val(0);} document.location = "' . $this->createUrl('/economy/shoppingcart/update') . '?key=" + key + "&qty=" + quantity; }';
Yii::app()->clientScript->registerScript('updateQuantity', $js, CClientScript::POS_END);
?>

<div class="content-wrap">
    <div class="shopping-cart-page">
        <section id="cart" class="cart">
            <?php if ($shoppingCart->getProducts()) { ?>
                <div class="container">
                    <div class="process-payment">
                        <ul>
                            <li class="active">
                                <a href=""><?= Yii::t('shoppingcart', 'shoppingcart'); ?></a>
                            </li>
                            <li>
                                <a href=""><?= Yii::t('shoppingcart', 'checkout'); ?></a>
                            </li>
                            <li>
                                <a href=""><?= Yii::t('shoppingcart', 'receipt'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-cart-page hidden-xs">
                        <div class="row">
                            <div class=" col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <?php
                                $this->renderPartial('pack', array(
                                    'shoppingCart' => $shoppingCart,
                                ));
                                ?>
                            </div>
                            <div class="cart-collaterals col-lg-4 col-md-4 col-sm-12 col-xs-12" style="position: static;">
                                <div class="totals">
                                    <h3>Tổng cộng</h3>
                                    <div class="inner">
                                        <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                            <colgroup>
                                                <col>
                                                <col>
                                            </colgroup>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="1" class="a-left"><strong><?= Yii::t('shoppingcart', 'total'); ?></strong></td>
                                                    <td><strong><span><?php echo $shoppingCart->getTotalPrice(); ?></span></strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <ul class="checkout">
                                            <li>
                                                <button class="button btn-proceed-checkout" aria-label="<?= Yii::t('shoppingcart', 'order-now-2') ?>" title="<?= Yii::t('shoppingcart', 'order-now-2') ?>" type="button" onclick="window.location.href = '<?php echo $this->createUrl('/economy/shoppingcart/checkout'); ?>'">
                                                    <span><?= Yii::t('shoppingcart', 'order-now-2') ?></span>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="button btn-continue" aria-label="<?= Yii::t('shoppingcart', 'continueshopping') ?>" title="<?= Yii::t('shoppingcart', 'continueshopping') ?>" type="button" onclick="window.location.href = '<?php echo Yii::app()->homeUrl; ?>'">
                                                    <span><span><?= Yii::t('shoppingcart', 'continueshopping') ?></span></span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-cart-page-mobile cart-droplist visible-xs">
                        <div class="cart-droplist__content arrow_box">
                            <div class="cart-droplist__status">
                                <i class="fa fa-check" aria-hidden="true"></i> 
                                <span class="cart-counter-list">1</span> <?= Yii::t('shoppingcart', 'product_in_your_cart') ?>
                            </div>
                            <div class="mini-list">
                                <?php
                                $this->renderPartial('pack_mobile', array(
                                    'shoppingCart' => $shoppingCart,
                                ));
                                ?>
                                <div class="top-subtotal"><?= Yii::t('shoppingcart', 'total_all') ?>: <span class="price total-price"><?php echo $shoppingCart->getTotalPrice(); ?></span></div>
                                <div class="actions">
                                    <button class="btn-checkout" type="button" aria-label="Tiến hành đặt hàng" onclick="window.location.href = '<?php echo $this->createUrl('/economy/shoppingcart/checkout'); ?>'"><span><i class="fa fa-money" aria-hidden="true"></i> <?= Yii::t('shoppingcart','order')?></span></button>
                                    <button class="btn-checkout btn-return" type="button" aria-label="Tiếp tục mua hàng" onclick="window.location.href = '<?php echo Yii::app()->homeUrl; ?>'"><span><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> <?= Yii::t('shoppingcart','continueshopping')?></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <p class="text-warning">
                    <?php echo Yii::t('shoppingcart', 'havanoproduct'); ?>
                </p>
            <?php } ?>
        </section>
    </div>
</div>