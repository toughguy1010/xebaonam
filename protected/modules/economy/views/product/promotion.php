<div class="product-promotion">
    <div class="product-promotion-desc">
        <?php echo $promotion['description']; ?>
    </div>
    <div class="product-promotion-time">
        <?php
        $this->widget('common.extensions.flipClock.flipClock', array(
            'element' => '.product-promotion-time',
            'time' => $promotion['enddate'] - time(),
            'language' => Yii::app()->language,
        ));
        ?>
    </div>
    <div class="promotion-products">
        <div class="promotion-title">
            <h3><?php echo Yii::t('product', 'promotion_product') ?></h3>
        </div>
        <div class="list grid">
            <?php
            foreach ($products as $product) {
                ?>
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
        </div>
        <div class='product-page'>
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
                'itemCount' => $totalitem,
                'pageSize' => $limit,
                'header' => '',
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    </div>
</div>