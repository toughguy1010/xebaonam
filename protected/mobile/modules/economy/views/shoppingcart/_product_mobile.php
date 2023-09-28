<div class="bg-cart-page-mobile cart-droplist visible-xs">
    <div class="cart-droplist__content arrow_box">
        <div class="cart-droplist__status">
            <i class="fa fa-check" aria-hidden="true"></i> 
            Sản phẩm đã mua
        </div>
        <div class="mini-list">
            <ul class="list-item-cart">
                <?php foreach ($products as $product) { ?>
                    <li class="item productid-1108">
                        <a class="product-image" title="<?= $product["name"]; ?>" href="<?= $product["link"]; ?>">
                            <img width="75" height="auto" alt="<?= $product["name"]; ?>" src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's80_80/', $product['avatar_name']; ?>" />
                        </a>
                        <div class="detail-item">
                            <div class="product-details">
                                <p class="product-name">
                                    <a href="<?= $product["link"]; ?>" title="<?= $product["name"]; ?>"><?= $product["name"]; ?></a>
                                </p>
                            </div>
                            <div class="product-details-bottom">
                                <span class="price"><?= number_format($product['product_price'], 0, ',', '.') ?>₫</span>
                                <div class="quantity-select">
                                    <span><?= $product["product_qty"]; ?></span>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>