<ul class="list-item-cart">
    <?php foreach ($shoppingCart->findAllProducts() as $key => $product) { ?>
        <li class="item productid-1108">
            <a class="product-image" title="<?= $product['name'] ?>" href="<?= $product['link'] ?>">
                <img width="75" height="auto" alt="<?= $product['name'] ?>" src="<?php echo ClaHost::getImageHost(), $product['avatar_path'], 's80_80/', $product['avatar_name']; ?>" />
            </a>
            <div class="detail-item">
                <div class="product-details">
                    <a onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng')" href="<?php echo $this->createUrl('/economy/shoppingcart/delete', array('key' => $key)); ?>" title="Xóa" class="remove-item-cart fa fa-trash-o"></a>
                    <p class="product-name"> 
                        <a href="<?= $product['link'] ?>" title="<?= $product['name'] ?>"><?= $product['name'] ?></a>
                    </p>
                </div>
                <div class="product-details-bottom">
                    <span class="price"><?php echo Product::getPriceText($product); ?></span>
                    <div class="quantity-select">
                        <button onclick="var result = document.getElementById('qtyMobile'); var qtyMobile = result.value; if (!isNaN(qtyMobile) & amp; & amp; qtyMobile > 1) result.value--; return false;" class="reduced items-count btn-minus" type="button">–</button>
                        <input onclick="updateQuantity('<?php echo $key; ?>', $('#quantity-<?php echo $key; ?>').val());" type="text" maxlength="3" min="1" class="input-text number-sidebar qtyMobile" id="qtyMobile" name="qty" value="<?php echo $shoppingCart->getQuantity($key); ?>">
                        <button onclick="var result = document.getElementById('qtyMobile');
                                    var qtyMobile = result.value;
                                    if (!isNaN(qtyMobile))
                                        result.value++;
                                    return false;" class="increase items-count btn-plus" type="button">+</button>
                    </div>
                </div>
            </div>
        </li>
    <?php } ?>
</ul>