<?php
//
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/colorbox/jquery.colorbox-min.js');
//
?>
<div class="product-detail">
    <div class="product-detail-box">
        <div class="product-detail-img">
            <?php
            $images = $model->getImages();
            $first = reset($images);
            ?>
            <div class="product-img-main"> 
                <a class="product-img-small product-img-large" href="<?php echo ClaHost::getImageHost() . $first['path'] . 's800_600/' . $first['name'] ?>">
                    <img src="<?php echo ClaHost::getImageHost() . $first['path'] . 's330_330/' . $first['name'] ?>">
                </a>
            </div>
            <div class="product-img-item">
                <ul>
                    <?php foreach ($images as $img) { ?>
                        <li>
                            <a class="product-img-small" href="<?php echo ClaHost::getImageHost() . $img['path'] . 's800_600/' . $img['name']; ?>">
                                <img src="<?php echo ClaHost::getImageHost() . $img['path'] . 's50_50/' . $img['name']; ?>">
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="product-detail-info" id="product-detail-info">
            <h2 class="product-info-title"> <?php echo $product['name'] ?> </h2>

            <?php if ($product['price_market'] && $product['price_market'] > 0) { ?>
                <p>
                    <label><?php echo Yii::t('product', 'oldprice'); ?>:</label>
                    <span class="product-detail-price-market">
                        <?php echo $product['price_market_text']; ?>
                    </span>
                </p>
            <?php } ?>
            <?php if ($product['price'] && $product['price'] > 0) { ?>
                <p>
                    <label><?php echo Yii::t('product', 'price'); ?>:</label>
                    <span class="product-detail-price">
                        <?php echo $product['price_text']; ?>
                    </span>
                </p>
            <?php } else { ?>
                <p>
                    <label><?php echo Yii::t('product', 'price'); ?>:</label>
                    <span class="product-detail-price">
                        <?php echo Product::getProductPriceNullLabel(); ?>
                    </span>
                </p>
            <?php } ?>
            <?php if ($product['product_sortdesc']) { ?>
                <p class="product-detail-sortdesc">
                    <?php echo $product['product_sortdesc']; ?>
                </p>
            <?php } ?>
            <?php if ($attributesShow && count($attributesShow)) { ?>
                <table class="table table-bordered">
                    <tbody>
                        <?php
                        $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($model, $attributesShow);
                        foreach ($attributesDynamic as $key => $item) {
                            if (is_array($item['value']) && count($item['value'])) {
                                $item['value'] = implode(", ", $item['value']);
                            }
                            if ($item['value'])
                                echo '<tr><td>' . $item['name'] . '</td><td>' . $item["value"] . '</td>';
                        }
                        ?>      
                    </tbody>
                </table>
            <?php } ?>
            <?php if ($product['price'] && $product['price'] > 0) { ?>
                <p>
                    <label><?php echo Yii::t('common', 'quantity'); ?>:</label>
                    <span class="product-detail-quantity">
                        <input type="number" name="qty" value="1" max-lenght="3" class="product_quantity" id="product_quantity" style="width: 40px;" min="1" step="1"/>
                    </span>
                </p>
                <p>
                    <div class="ProductActionAdd"><a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $model->id)); ?>" class="a-btn-2"><span class="a-btn-2-text"><?php echo Yii::t('shoppingcart', 'order'); ?></span></a></div>
                </p>
            <?php } ?>
        </div>
    </div>
    <div class="product-detail-more">
        <?php if ($product['product_desc']) { ?>
            <div class="tab">
                <ul role="tablist" class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" role="tab" href="#home">Chi Tiết Sản Phẩm</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade active">
                        <?php
                        echo $product['product_desc'];
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>