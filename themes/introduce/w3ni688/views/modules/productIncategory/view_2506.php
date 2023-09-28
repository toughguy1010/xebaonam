<div class="rel-product pk_rel">
    <?php if ($show_widget_title) { ?>
        <h2 class="title-block-detail "> <?php echo $widget_title; ?> </h2>
    <?php } ?>
    <div class="cont cont-compare">
        <div id="owl-demo-rel-prd1" class="owl-carousel owl-demo-rel-prd1">
            <?php
            if (isset($products) && count($products)) {
                foreach ($products as $key => $product) {
                    ?>
                    <div class="item-product">
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

                        <div class="item-inner">
                            <div class="img">
                                <a href="<?php echo $product['link']; ?>"
                                   title="<?php echo $product['name']; ?>">
                                    <img alt="<?php echo $product['name']; ?>"
                                         src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's200_200/' . $product['avatar_name'] ?>">
                                </a>
                            </div>
                            <div class="item-info">
                                <h5 class="item-title text-uppercase">
                                    <a href="<?php echo $product['link']; ?>"
                                       title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                                </h5>
                                <?php if ($product['price'] > 0) { ?>
                                    <div class="item-price">
                                            <span class="old-price"><span
                                                        class="price"><?= number_format($product['price_market'], 0, '', '.') . '₫' ?></span></span>
                                        <span class="regular-price">
                                                    <span class="price">
                                                        <?php echo number_format($product['price'], 0, '', '.') . '₫'; ?>
                                                    </span>
                                                </span>
                                    </div>
                                <?php } else { ?>
                                    <div class="item-price">
                                                <span class="regular-price">
                                                    <span class="price">
                                                        Liên hệ
                                                    </span>
                                                </span>
                                    </div>
                                <?php } ?>
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
            items: 6,
            itemsCustom: [
                [0, 1],
                [360, 2],
                [640, 6],
                [992, 6],

            ],
            margin: 10,
            navigation: false,
            autoPlay: false,
        });
    });
</script>