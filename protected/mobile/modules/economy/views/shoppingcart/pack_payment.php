<div class="infor-order">
    <?php foreach ($shoppingCart->findAllProducts() as $key => $product) { ?>
        <div class="item-order">
            <p>
                <a href="<?= $product['link'] ?>" title="<?= $product['name'] ?>">
                    <img src="<?php echo ClaHost::getImageHost(), $product['avatar_path'], 's80_80/', $product['avatar_name']; ?>" alt="<?= $product['name'] ?>" />
                    <b><?= $product['name'] ?></b>
                </a>
            </p>
            <span>
                <?php echo number_format($product['price'], 0, ',', '.') ?>
                x
                <?php echo $shoppingCart->getQuantity($key); ?>
            </span>
        </div>
    <?php } ?>
</div>