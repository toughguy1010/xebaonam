<?php if (count($products)) { ?>
    <div id="demo">
        <div id="owl-demo" class="owl-carousel">
            <?php foreach ($products as $product) { ?>
                <div class="item ">
                    <div class="box-cont">
                        <div class="box-img">
                            <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> 
                                <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's330_330/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                            </a> 
                        </div>
                        <div class="product-information clearfix">
                            <div class="title-products">
                                <h3>
                                    <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"><?php echo $product['name'] ?></a>
                                </h3>
                            </div>
                            <div class="products-left">
                                <?php if ($product['price'] && $product['price'] > 0) { ?>
                                    <div class="price-products"><?php echo $product['price_text']; ?></div>
                                <?php } ?>
                                <?php if ($product['state']) { ?>
                                    <div class="status"><?php echo Yii::t('product', 'in_stock'); ?></div>
                                <?php } ?>
                            </div>
                            <div class="products-right">
                                <?php Yii::app()->controller->renderPartial('//partial/product_acction', array('pid' => $product['id'])); ?>
                            </div>
                        </div>
                        <div class="gift-products">
                            <p>Giá xe đang trong thời gian khuyến mãi 
                                (22/8/2015 - 22/09/2015)</p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php $themUrl = Yii::app()->theme->baseUrl; ?>
    <script type="text/javascript" src="<?= $themUrl ?>/js/owl.carousel.min.js"></script> 
    <script>
        $(document).ready(function () {
            var owl = $("#owl-demo");
            owl.owlCarousel({
                itemsCustom: [
                    [0, 1],
                    [450, 1],
                    [600, 2],
                    [700, 2],
                    [1000, 3],
                    [1200, 3],
                    [1400, 3],
                    [1600, 4]
                ],
                navigation: true,
                autoPlay: true,
            });
        });
    </script>
<?php } ?>
