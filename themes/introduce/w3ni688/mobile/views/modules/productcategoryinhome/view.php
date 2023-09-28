<?php
foreach ($cateinhome as $cat) {
    if (!isset($data[$cat['cat_id']]['products']) || !count($data[$cat['cat_id']]['products'])) {
        continue;
    }
    ?>
    <div class="setnew-product">
        <div class="title">
            <h2>
                <a href="<?php echo $cat['link'] ?>"><?php echo $cat['cat_name']; ?></a>
                <!--                 <a href="-->
                <?php //echo $cat['link'] ?><!--" class="view-more">Xem thêm</a>-->
            </h2>
        </div>
        <div class="owl-demo-product owl-carousel owl-theme cont">
            <?php
            $n = 0;
            foreach ($data[$cat['cat_id']]['products'] as $product) {
                ++$n;
                ?>
                <?php if ($n == 1) { ?>
                    <div class="cont-1">
                    <?php } ?>
                    <?php if ($n >= 1 && $n <= 4) { ?>
                        <div class="col-xs-6 col-sm-4 col-sm-3 product-small" style="padding: 0">
                            <div class="item-product">
                                <?php if (!$product['state']) { ?>
                                    <span class="hethang"> Tạm hết hàng</span>
                                <?php } ?>
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
                                <i class="stt stt-new"></i>
<!--                                <i class="sale-vnd"> <span> --><?php //echo $sale_vnd ?><!--</span></i>-->
                                <div class="img-product">
                                    <a href="<?php echo $product['link'] ?>"
                                       title="<?php echo $product['name']; ?>">
                                        <img alt="<?php echo $product['name']; ?>"
                                             src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'] ?>"
                                             alt="<?php echo $product['name'] ?>">
                                    </a>
                                </div>
                                <h3 class="title-sp"><a
                                        href="<?php echo $product['link'] ?>"><?php echo $product['name']; ?></a>
                                </h3>
                                <div class="clearfix">
                                    <p class="old-price"><?php echo number_format($product['price_market'], 0, '', '.'); ?> đ</p>
                                    <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>
                                    <div class="sale-of"> <span>-<?php echo ClaProduct::getDiscount($product['price_market'], $product['price']) ?>%</span> </div>
                                    <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                                       title="Mua" class="buy-product btn btn-default">
                                        Mua </a>
                                    <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                                       title="Trả góp"
                                       class="installment-promotion"> Trả góp 0% </a>
                                       <?php if ($product['state'] == 1) { ?>
                                        <a href="<?php echo $product['link']; ?>"
                                           title="còn hàng"
                                           class="order-product order-promotion"> còn hàng </a>
                                       <?php } ?>
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
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($n == 4) { ?>
                    </div>
                <?php } ?>
                <?php if ($n == 5) { ?>
                    <div class="cont-2">
                    <?php } ?>
                    <?php if ($n >= 5 && $n <= 8) { ?>
                        <div class="col-xs-6 col-sm-4 col-sm-3 product-small" style="padding: 0">
                            <div class="item-product">
                                <?php if (!$product['state']) { ?>
                                    <span class="hethang"> Tạm hết hàng</span>
                                <?php } ?>
                                <i class="stt stt-new"></i>
                                <div class="img-product">
                                    <a href="<?php echo $product['link'] ?>"
                                       title="<?php echo $product['name']; ?>">
                                        <img alt="<?php echo $product['name']; ?>"
                                             src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'] ?>"
                                             alt="<?php echo $product['name'] ?>">
                                    </a>
                                </div>
                                <h3 class="title-sp"><a
                                        href="<?php echo $product['link'] ?>"><?php echo $product['name']; ?></a>
                                </h3>
                                <div class="clearfix">
                                    <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>
                                    <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                                       title="Mua" class="buy-product btn btn-default">
                                        Mua </a>
                                    <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                                       title="Trả góp"
                                       class="installment-promotion"> Trả góp 0% </a>
                                       <?php if ($product['state'] == 1) { ?>
                                        <a href="<?php echo $product['link']; ?>"
                                           title="còn hàng"
                                           class="order-product order-promotion"> còn hàng </a>
                                       <?php } ?>
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
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($n == 8) { ?>
                    </div>
                <?php } ?>
            <?php }
            ?>
        </div>
        <script>
            $(document).ready(function () {
                var owl = $(".owl-demo-product");
                owl.owlCarousel({
                    itemsCustom: [
                        [0, 1],
                    ],
                    pagination: false,
                    navigation: false,
                    autoPlay: true,
                });
            });
        </script>
        <style type="text/css">
            #owl-demo-product{
                overflow: hidden;
                float: left;
                width: 100%;
            }
            .setnew-product {
                margin-top: -10px;
                display: inline-block;
                float: left;
                width: 100%;
            }
        </style>
    </div>
    <?php
}
?>
