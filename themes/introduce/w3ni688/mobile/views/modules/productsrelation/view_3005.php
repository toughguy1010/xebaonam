<?php if ($show_widget_title) { ?>
    <h2><?php echo $widget_title; ?></h2>
<?php } ?>
<div id="owl-demo-rel-prd" class="owl-carousel">
    <?php $product_id = Yii::app()->request->getParam('id'); ?>
    <?php $alias = Yii::app()->request->getParam('alias'); ?>
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
                    <!--<i class="stt <?php echo $status ?>"></i>-->
                    <div class="img-product">
                        <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                            <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>">
                        </a>
                    </div>
                    <h3 class="title-sp">
                        <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name'] ?></a></h3>
                    <div class="clearfix">
                        <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>
                        <!-- <a class="sosanh" title="compare" href="#"> So sánh </a> -->
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<script>
    $(document).ready(function() {
        var owl = $("#owl-demo-rel-prd");
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
