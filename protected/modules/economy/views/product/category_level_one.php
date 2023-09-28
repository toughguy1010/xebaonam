<?php if (count($products)) { ?>
    <div class="cateinhome">
        <?php if (count($child_category)) { ?>
            <?php foreach ($child_category as $cat) { ?>
                <div class="box-main-one"> 
                    <div class="main-list">
                        <h3><?php echo $widget_title; ?></h3>
                        <!--<a href="<?php echo $cat['link']; ?>"><?php echo Yii::t('common', 'viewall'); ?></a>-->
                    </div><!--end-main-list-->
                    <?php if (isset($products[$cat['cat_id']]['products'])) { ?>
                        <div class="list grid clearfix">
                            <?php foreach ($products[$cat['cat_id']]['products'] as $product) { ?>
                                <div class="list-item">
                                    <div class="list-content">
                                        <div class="list-content-box">
                                            <div class="list-content-img">
                                                <a href="<?php echo $product['link']; ?>">
                                                    <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's150_150/' . $product['avatar_name'] ?>">
                                                </a>
                                            </div>
                                            <div class="list-content-body">
                                                <span class="list-content-title">
                                                    <a href="<?php echo $product['link']; ?>">
                                                        <?php echo $product['name']; ?>
                                                    </a>
                                                </span>
                                                <?php if (isset($product['price']) && $product['price'] > 0) { ?>
                                                    <div class="product-price">
                                                        <label><?php echo Yii::t('product', 'price'); ?>: </label>
                                                        <span><?php echo $product['price_text']; ?></span>
                                                    </div> 
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div><!--end-list-gird-->
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php } else { ?>
    <p class="text-info">
        <?php Yii::t('product', 'product_no_result'); ?>
    </p>
<?php } ?>
