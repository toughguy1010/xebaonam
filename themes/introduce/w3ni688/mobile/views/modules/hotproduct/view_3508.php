<?php if (count($products)) { ?>
    <div class="cont-news-technology cont-products-technology clearfix ">
        <div class="row">
            <div class="title-hot-cate title">
                <?php if ($show_widget_title) { ?>
                    <h2><?php echo $widget_title ?></h2>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <?php foreach ($products as $product) {
                ?>
                <div class="col-xs-6 col-sm-4 col-hot-store">
                    <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>"
                       class="item-product">
                        <?php if (!$product['state']) { ?>
                            <span class="hethang"> Tạm hết hàng</span>
                        <?php } ?>
                        <?php
                        $sale_vnd = (($product['price_market'] - $product['price']) / 1000000)
                        ?>
                        <div class="img-product">
                            <img alt="<?php echo $product['name']; ?>"
                                 src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>"
                                 alt="<?php echo $product['name'] ?>">
                        </div>
                        <h3 class="title-sp"><?php echo $product['name']; ?></h3>
                        <div class="clearfix">
                            <p class="old-price"><?php echo number_format($product['price_market'], 0, '', '.'); ?>
                                đ</p>
                            <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>

                            <div class="sale-of">
                                <span>-<?php echo ClaProduct::getDiscount($product['price_market'], $product['price']) ?>
                                    %</span></div>
                            <button class="btn btn-default buy-product" type="button">Mua</button>
                        </div>
                        <div class="description">
                            <?php
                            $product_infos = array();
                            if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                                $ps = array();
                                $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $product['product_info']['product_sortdesc'], $matches);
                                for ($i = 0; $i < $count; ++$i) {
                                    $ps[] = preg_replace('/<a[^>]*>(.*?)<\/a>/is', '', $matches[0][$i]);
                                }
                            }
                            ?>
                            <?php echo ($ps[0]) ? ('<p class="item-info">' . strip_tags($ps[0]) . '</p>') : '' ?>
                            <?php echo ($ps[1]) ? ('<p class="item-info">' . strip_tags($ps[1]) . '</p>') : '' ?>
                            <?php echo ($ps[2]) ? ('<p class="item-info">' . strip_tags($ps[2]) . '</p>') : '' ?>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
} ?>
