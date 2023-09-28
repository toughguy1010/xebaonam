<?php if (count($products)) { ?>
    <div class="list-product-relation">
        <?php if ($show_widget_title) { ?>
            <div class="product-relation-title">
                <h3><?php echo $widget_title; ?></h3>
            </div>
        <?php } ?>
        <ul class="list grid">
            <?php
            foreach ($products as $product) {
                ?>
                <div class="list-item">
                    <div class="list-content">
                        <div class="list-content-box">
                            <div class="list-content-img">
                                <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                                    <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's150_150/' . $product['avatar_name'] ?>" alt="<?php echo $product['name']; ?>">
                                </a>
                            </div>
                            <div class="list-content-body">
                                <span class="list-content-title">
                                    <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                                        <?php echo $product['name']; ?>
                                    </a>
                                </span>
                                <?php if ($product['price'] && $product['price'] > 0) { ?>
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
        </ul>
    </div>
<?php } ?>