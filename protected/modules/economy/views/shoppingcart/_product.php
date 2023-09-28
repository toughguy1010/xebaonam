<?php
$productModel = new Product();
?>
<div class="bg-scroll" style="margin-top: 0px;">
    <div class="cart-thead">
        <div style="width: 18%"><?php echo Yii::t('common', 'picture'); ?></div>
        <div style="width: 31%"><span class="nobr"><?php echo $productModel->getAttributeLabel('name'); ?></span></div>
        <div style="width: 15%" class="a-right"><span class="nobr"><?php echo $productModel->getAttributeLabel('price'); ?></span></div>
        <div style="width: 14%" class="a-center"><?php echo Yii::t('common', 'quantity'); ?></div>
        <div style="width: 15%" class="a-center"><?php echo Yii::t('common', 'total'); ?></div>
    </div>
    <div class="cart-tbody">
        <?php foreach ($products as $product) { ?>
            <div class="item-cart productid-11088257">
                <div style="width: 18%" class="image">
                    <a class="product-image" title="<?= $product["name"]; ?>" href="<?= $product["link"]; ?>">
                        <img width="75" height="auto" alt="<?= $product["name"]; ?>" src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's80_80/', $product['avatar_name']; ?>" />
                    </a>
                </div>
                <div style="width: 31%" class="a-left">
                    <h2 class="product-name">
                        <a href="<?= $product["link"]; ?>" title="<?= $product["name"]; ?>"><?= $product["name"]; ?></a> 
                    </h2>
                    <?php
                    $attributes = json_decode($product['product_attributes'], true);
                    if ($attributes && count($attributes)) {
                        $shoppingCart = new ClaShoppingCart();
                        ?>
                        <div class="attr">
                            <?php foreach ($attributes as $attr) { ?>
                                <dl class="clearfix">
                                    <dt><?php echo $attr['name']; ?> : </dt>
                                    <dd><?php echo $shoppingCart->getAttributeText($attr); ?></dd>
                                </dl>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div style="width: 15%" class="a-right">
                    <span class="item-price"> 
                        <span class="price"><?=$product['product_price_text']?></span>
                    </span>
                </div>
                <div style="width: 14%" class="a-center">
                    <span><?= $product["product_qty"]; ?></span>
                </div>
                <div style="width: 15%" class="a-center">
                    <span class="cart-price"> 
                        <span class="price"><?=Product::getTotalPrice(array('price' => $product['product_price'],'currency'=>$product['currency']), $product["product_qty"], true)?></span> 
                    </span>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
