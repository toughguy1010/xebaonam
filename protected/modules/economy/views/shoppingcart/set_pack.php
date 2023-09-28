<?php
$productModel = new Product();
?>
<?php foreach ($shoppingCart->findAllProducts() as $ary_key => $ary_products) { ?>
    <div class="panel panel-default actives" id="set_<?php echo $ary_key?>">
        <div class="panel-heading" role="tab" id="heading<?php echo $ary_key ?>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $ary_key ?>"
                   aria-expanded="true" aria-controls="collapse<?php echo $ary_key ?>" class="<?php echo ($ary_key == $set && !is_null($set)) ? '' :'collapsed' ?>">
                    Giỏ hàng <?php echo ($ary_key == 0) ? '' : $ary_key ?>
                </a>
            </h4>
            <div class="toggle-down">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $ary_key ?>"
                   aria-expanded="true" aria-controls="collapse<?php echo $ary_key ?> "><span
                        class="fa fa-angle-down"></span></a>
            </div>
            <div class="btn-add-product">
                <a href="javascript:void(0)" onclick="addToSetCart(this)" data-set="<?php echo $ary_key ?>">Thêm vào giỏ hàng</a>
            </div>
        </div>
        <div id="collapse<?php echo $ary_key ?>" class="panel-collapse collapse <?php echo ($ary_key == $set && !is_null($set)) ? ' in' :'' ?>" role="tabpanel"
             aria-labelledby="heading<?php echo $ary_key ?>"
             style="<?php echo ($ary_key == $set && !is_null($set)) ? '' :'height: 0px' ?>;">
            <div class="panel-body">
                <div class="wishlist-table">
                    <?php foreach ($ary_products as $key => $product) {

                        ?>
                        <div class="product-popup">
                            <div class="img-product-popup">
                                <a href="<?php echo $product['link']; ?>">
                                    <img
                                        src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's100_100/' . $product['avatar_name']; ?>"></a>
                            </div>
                            <div class="ctn-product-popup">
                                <!--                                <a href="-->
                                <?php //echo $product['link']; ?><!--" class="product-name">-->
                                <h2><?php echo $product["name"]; ?></h2>
                                <!--                                </a>-->
                                <span>SL: <?php echo $shoppingCart->getQuantity($key, $ary_key); ?></span>
                                <span>
<!--                                    --><?php //echo HtmlFormat::money_format($shoppingCart->getSetTotalPrice($ary_key, false)).' VNĐ'; ?>
                                    <?php echo HtmlFormat::money_format2($shoppingCart->getTotalPriceForProduct($key,
                                            false, $ary_key['is_configurable'], $ary_key)) . ' VND'; ?></span>
                                <a href="<?php echo $this->createUrl('/economy/shoppingcart/delete',
                                    array('key' => $key, 'set' => $ary_key)); ?>">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="total-price">
                        <h2>Tổng tiền:
                            <span><?php echo HtmlFormat::money_format2($shoppingCart->getSetTotalPrice($ary_key, false)).' VNĐ'; ?></span>
                        </h2>
                        <a style="float: left" href="javascript:void(0)"  onclick="deleteSet(this)" data-set="<?php echo $ary_key ?>">
                            Xóa giỏ hàng</a>
                        <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/',
                            array('sid' =>  $ary_key))?>">Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="btn-new-cart">
    <a href="javascript:void(0)" onclick="addNewSet()"><i class="fa fa-plus"></i>Thêm giỏ hàng mới</a>
</div>