<div class="col-xs-4">
    <div class="item-product">
        <div class="box-product">
            <div class="box-img-product">
                <?php
                if ($product['status'] == ActiveRecord::STATUS_PRODUCT_NEW) {
                    ?>
                    <img class="comming_soon" src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/comming_soon.png" alt="<?php echo $product['name']; ?>">
                    <?php
                }
                ?>
                <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                    <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's400_0/' . $product['avatar_name'] ?>" alt="<?php echo $product['name']; ?>">
                </a>
            </div>
            <div class="box-info-product">
                <h4>
                    <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                </h4>
                <?php if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) { ?>
                    <p class="description"><?php echo $product['product_info']['product_sortdesc']; ?></p>
                <?php } ?>
                <?php if (isset($product['price']) && $product['price']) { ?>
                    <p class="price"><?php echo number_format($product['price'], 0, '', '.'); ?> VND</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>