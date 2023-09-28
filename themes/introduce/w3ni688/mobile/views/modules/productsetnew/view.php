<?php
if (count($products)) {
    ?>
    <div class="setnew-product" id="myList" style="background: #fff;">
        <div class="crow">
            <?php
            $n = 0;
            foreach ($products as $product) {
                ++$n;
                ?>
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
                        <!-- <i class="stt stt-new"></i> -->
                        <!--                                <i class="sale-vnd"> <span> -->
                        <?php //echo $sale_vnd ?><!--</span></i>-->
                        <div class="ranking"></div>
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
                            <p class="old-price"><?php echo number_format($product['price_market'], 0, '', '.'); ?>
                                đ</p>
                            <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>
                            <div class="sale-of">
                              <span>-<?php echo ClaProduct::getDiscount($product['price_market'], $product['price']) ?>
                                  %</span></div>
                            <!--                                   <a href="-->
                            <?php //echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?><!--"-->
                            <!--                                      title="Mua" class="buy-product btn btn-default">-->
                            <!--                                        Mua </a>-->
                            <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                               title="Mua" class="buy-product btn btn-default">
                              Mua trả góp
                            </a>
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
            <?php }
            ?>
        </div>
        <div class="col-xs-6 col-sm-4 col-sm-3 views-more" style="padding: 0">
            <p class="see-more"><a title="Xem thêm sản phẩm" href="javascript:void(0)"
                                   class="btn-showmore"> CLICK XEM THÊM SẢN PHẨM <br> XEBAONAM.COM <br> <i
                            class="fa fa-caret-down" aria-hidden="true"></i></a></p>
        </div>
        <style type="text/css">
            #owl-demo-product {
                overflow: hidden;
                float: left;
                width: 100%;
            }

            .setnew-product {
                /*margin-top: -10px;*/
                display: inline-block;
                float: left;
                width: 100%;
            }
        </style>
        <script type="text/javascript">
            var offset = 3;
            jQuery('.btn-showmore').click(function () {
                $('.loading-shoppingcart').show();
                var url = ' <?php echo Yii::app()->createUrl('economy/product/ajaxLoaderHotProduct') ?>';
                var limit = '<?php echo count($products) ?>';
                $.ajax({
                    url: url,
                    dataType: "json",
                    data: {limit: 6, offset: offset},
                    success: function (msg) {
                        console.log(msg.items);
                        $('.loading-shoppingcart').hide();
                        $("#myList .crow").append(msg.items);
                        offset = offset + 1;
                        if (offset > 7 || msg.items == null) {
                            $(".views-more").hide();
                        }
                    }
                });
            });
        </script>
    </div>
    <?php
}
?>
