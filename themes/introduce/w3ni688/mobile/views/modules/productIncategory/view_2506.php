<div class="rel-product">
    <?php if ($show_widget_title) { ?>
        <h2 class="title-block-detail "> <?php echo $widget_title; ?> </h2>
    <?php } ?>
    <div class="cont cont-compare">
        <div id="owl-demo-rel-prd1" class="owl-carousel owl-demo-rel-prd1">
            <?php
            if (isset($products) && count($products)) {
                foreach ($products as $key => $product) {
                    ?>
                    <div class="item-ss">
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
                            <div class="img-product">
                                <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                                    <img alt="<?php echo $product['name']; ?>"
                                         src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>">
                                </a>
                            </div>
                            <h3 class="title-sp">
                                <a href="<?php echo $product['link']; ?>"
                                   title="<?php echo $product['name']; ?>"><?php echo $product['name'] ?></a></h3>
                            <div class="clearfix">
                                <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
    <script>
        $(document).ready(function () {
            var owl = $(".owl-demo-rel-prd1");
            owl.owlCarousel({
                itemsCustom: [
                    [0, 1],
                    [360, 2],
                    [640, 3],
                    [992, 4],

                ],
                navigation: false,
                autoPlay: false,
            });
        });
    </script>
