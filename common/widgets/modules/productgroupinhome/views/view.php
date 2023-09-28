<div class="promotioninhome">
    <?php
    foreach ($productGroupInHome as $promotion) {

        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><?php echo $promotion['name']; ?></h3>
                <a href="<?php echo $promotion['link']; ?>"><?php echo Yii::t('common', 'viewall'); ?></a>
            </div><!--end-main-list-->
            <?php if (isset($data[$promotion['promotion_id']]['products'])) { ?>
                <div class="panel-body">
                    <div class="list grid clearfix">
                        <?php foreach ($data[$promotion['promotion_id']]['products'] as $product) { ?>
                            <div class="list-item">
                                <div class="list-content">
                                    <div class="list-content-box">
                                        <div class="list-content-img">
                                            <?php if ($product['avatar_path'] && $product['avatar_name']) { ?>
                                                <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                                                    <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's220_220/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="bg-body-box">
                                            <div class="list-content-body">
                                                <span class="list-content-title">
                                                    <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                                                        <?php echo $product['name']; ?>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="product-all">
                                                <div class="product-price-all">
                                                    <?php if ($product['price_market'] && $product['price_market'] > 0) { ?>
                                                        <div class="product-price-market">
                                                            <?php echo Yii::t('product', 'oldprice'); ?>:
                                                            <?php echo $product['price_market_text']; ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($product['price'] && $product['price']) { ?>
                                                        <div class="product-price">
                                                            <?php echo Yii::t('product', 'price'); ?>:
                                                            <?php echo $product['price_text']; ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>  <!--end-product-all-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div><!--end-list-gird-->
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>