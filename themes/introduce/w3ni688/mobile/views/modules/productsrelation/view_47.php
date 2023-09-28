<?php if (count($products)) { ?>
    <div class="featured-products box-right products-lq clearfix">
        <?php if ($show_widget_title) { ?>
            <div class="title">
                <h2><?php echo $widget_title ?></h2>
            </div>
        <?php } ?>
        <div id="product-relation-detail-right">
            <?php foreach ($products as $product) { ?>
                <div class="item ">
                    <div class="box-cont">
                        <div class="box-img"> 
                            <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> 
                                <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's100_100/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                            </a> 
                        </div>
                        <div class="product-information clearfix">
                            <div class="title-products">
                                <h3><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a></h3>
                            </div>
                            <div class="products-left">
                                <?php if ($product['price'] && $product['price'] > 0) { ?>
                                    <div class="price-products"><?php echo $product['price_text']; ?></div>
                                <?php } ?>
                                <?php if ($product['state']) { ?>
                                    <div class="status"><?php echo Yii::t('product', 'in_stock') ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

<?php } ?>