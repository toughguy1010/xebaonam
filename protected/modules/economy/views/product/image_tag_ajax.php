<?php if (count($products)) { ?>
    <div class="title-btt-cate">
        <span>Sản phẩm tương tự</span>
        <a href="<?php echo Yii::app()->createUrl('economy/product/imagetag', array('id' => $tag['id'])); ?>" role="button" class="btn btn-link  " target="_blank" data-compid="similar_more"><?php echo Yii::t('common', 'viewall'); ?></a>
    </div>
    <div class="content-btt-cate">
        <?php
        foreach ($products as $product) {
            ?>
            <div class="item-product-cate">
                <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                    <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's150_150/' . $product['avatar_name'] ?>" alt="<?php echo $product['name']; ?>">
                </a>
                <div class="price-cate">
                    <span><?php echo $product['price_text']; ?></span>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <p class="text-info">
        <?php Yii::t('product', 'product_no_result'); ?>
    </p>
<?php } ?>
