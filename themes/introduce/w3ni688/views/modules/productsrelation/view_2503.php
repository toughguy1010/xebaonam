<?php if (count($products)) { ?>
    <div class="box-product">
        <div class="cont-box-product">
            <?php if ($category['cat_description'] != ''): ?>
                <div class="desc-category">
                    <?= $category['cat_description'] ?>
                </div>
            <?php endif ?>
            <div class="row">
                <?php foreach ($products as $product) {
                    $rating = $product['product_info']['total_rating'];
                    $total_votes = $product['product_info']['total_votes'];
                    ?>
                    <div class="col-xs-3 col-sm-3">
                        <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>"
                           class="item-product">
                            <?php
                            $status = '';
                            if ($product['ishot']) {
                                $status = 'stt-hot';
                            } else if ($product['isnew']) {
                                $status = 'stt-new';
                            } else if ($product['state']) {
                                $status = 'stt-het';
                            }
                            ?>
                            <?php
                            $sale_vnd = (($product['price_market'] - $product['price']) / 1000000)
                            ?>
                            <div class="img-product">
                                <img alt="<?php echo $product['name']; ?>"
                                     src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>"
                                     alt="<?php echo $product['name'] ?>">
                                <span class="tragop">Hỗ trợ trả góp</span>
                            </div>
                            <h3 class="title-sp"><?php echo $product['name']; ?></h3>
                            <div class="clearfix fix-price">
                                <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>
                                <p class="old-price"><?php echo number_format($product['price_market'], 0, '', '.'); ?>
                                    đ</p>

                                <div class="star">
                                    <span>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            ?>
                                            <i class="fa fa-star <?= ($i <= $rating) ? 'active' : '' ?>"
                                               aria-hidden="true"></i>
                                            <?php
                                        } ?>
                                    </span>
                                    <span class="total-star">(<?= $total_votes ?> đánh giá)</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>

