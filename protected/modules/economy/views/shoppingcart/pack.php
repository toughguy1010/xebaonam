<?php
$productModel = new Product();
?>
<div class="bg-scroll">
    <div class="cart-thead">
        <div style="width: 18%"><?php echo Yii::t('product', 'product_image'); ?></div>
        <div style="width: 31%"><span class="nobr"><?php echo $productModel->getAttributeLabel('name'); ?></span></div>
        <div style="width: 15%" class="a-right"><span class="nobr"><?php echo $productModel->getAttributeLabel('price'); ?></span></div>
        <div style="width: 14%" class="a-center"><?php echo Yii::t('common', 'quantity'); ?></div>
        <div style="width: 15%" class="a-center"><?php echo Yii::t('product', 'provisional_sums') ?></div>
        <div style="width: 7%"><?php echo Yii::t('common', 'delete'); ?></div>
    </div>
    <div class="cart-tbody">
        <?php foreach ($shoppingCart->findAllProducts() as $key => $product) { ?>
            <div class="item-cart productid-11088257">
                <div style="width: 18%" class="image">
                    <a class="product-image" title="<?= $product['name'] ?>" href="<?= $product['link'] ?>">
                        <img width="75" height="auto" src="<?php echo ClaHost::getImageHost(), $product['avatar_path'], 's80_80/', $product['avatar_name']; ?>">
                    </a>
                </div>
                <div style="width: 31%" class="a-left">
                    <h2 class="product-name">
                        <a href="<?= $product['link'] ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a> 
                    </h2>
                    <?php if (isset($product["code"]) && $product["code"]) { ?>
                        <p class="product_code"><span class="product_code_title"><?php echo$productModel->getAttributeLabel('code') ?> : <?php echo $product["code"]; ?></p>
                    <?php } ?>
                    <?php
                    $attributes = $shoppingCart->getAttributesByKey($key);
                    if ($attributes && count($attributes)) {
                        ?>
                        <div class="attr">
                            <?php foreach ($attributes as $attr) { ?>
                                <dl class="clearfix">
                                    <dt><?php echo $attr['name']; ?> : </dt>
                                    <dd><span class="variant-title"><?php echo $shoppingCart->getAttributeText($attr); ?></span></dd>
                                </dl>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div style="width: 15%" class="a-right">
                    <span class="item-price"> 
                        <span class="price"><?php echo Product::getPriceText($product); ?></span>
                    </span>
                </div>
                <div style="width: 14%;display: flex;" class="a-center">
                    <button onclick="decreaseQty('#quantity-<?php echo $key; ?>', '<?= $key ?>')" class="reduced items-count btn-minus" type="button">–</button>
                    <input onblur="updateQuantity('<?php echo $key; ?>', $('#quantity-<?php echo $key; ?>').val());" type="text" maxlength="3" min="1" step="1" class="input-text number-sidebar qtyItem" id="quantity-<?php echo $key; ?>" name="qty" value="<?php echo $shoppingCart->getQuantity($key); ?>" />
                    <button onclick="increaseQty('#quantity-<?php echo $key; ?>', '<?= $key ?>')" class="increase items-count btn-plus" type="button">+</button>
                </div>
                <div style="width: 15%" class="a-center">
                    <span class="cart-price">
                        <span class="price"><?php echo $shoppingCart->getTotalPriceForProduct($key); ?></span>
                    </span>
                </div>
                <div style="width: 7%">
                    <a onclick="return confirm('<?php echo Yii::t('notice', 'delete_product_from_cart_confirm'); ?>')" class="button remove-item remove-item-cart" title="<?php echo Yii::t('common', 'delete'); ?>" href="<?php echo $this->createUrl('/economy/shoppingcart/delete', array('key' => $key)); ?>"></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">

    function increaseQty(id, key) {
        var current = $(id).val();
        current++;
        $(id).val(current);
        var quantity = $(id).val();
        document.location = "<?php echo $this->createUrl('/economy/shoppingcart/update') ?>" + "?key=" + key + "&qty=" + quantity;
    }

    function decreaseQty(id, key) {
        var current = $(id).val();
        if (current > 1) {
            current--;
        }
        $(id).val(current);
        var quantity = $(id).val();
        document.location = "<?php echo $this->createUrl('/economy/shoppingcart/update') ?>" + "?key=" + key + "&qty=" + quantity;
    }

</script>

