<?php
$themUrl = Yii::app()->theme->baseUrl;

?>
<link rel="stylesheet" href="<?php echo $themUrl ?>/css/fix.css">
<?php if (count($products)) { ?>
    <div class="product-much">
        <div class="product-cml clearfix">
            <div class="title-product">
                <h2>
                    <!--                    <a href="--><?php //echo $link;
                                                        ?>
                    <!--" title="#">--><?php //echo $widget_title
                                        ?>
                    <!--</a>-->
                    <a href="<?php echo $link; ?>" title="<?php echo $group['name'] ?>"><?php echo $group['name'] ?></a>
                </h2>
                <a href="<?php echo $link; ?>" title="#" class="view-all">Xem thêm</a>
            </div>
            <div class="cont clearfix">
                <?php $i = 0;
                foreach ($products as $product) {
                    $src = ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'];
                ?>
                    <div class="col-xs-4">
                        <div class="item">
                            <?php if (!$product['state']) { ?>
                                <span class="hethang"> Tạm hết hàng</span>
                            <?php } ?>
                            <div class="img_update">
                                <div class="discount" style="background-image: url('<?= $themUrl ?>/images/discount.png');">
                                    <?php if ($product['price_market'] && $product['price_market'] > 0 && $product['price'] && $product['price'] > 0) { ?>
                                        <span class="pin_sale">-<?php echo ClaProduct::getDiscount($product['price_market'], $product['price']) ?>%</span>
                                    <?php } ?>
                                </div>
                                <a href="<?php echo $product['link'] ?>">
                                    <?php Yii::app()->controller->renderPartial('//layouts/img_lazy_owl', array('src' => $src, 'class' => '', 'title' => $product['name'])); ?>
                                </a>
                                <?php if (isset($product['product_sortdesc']) && $product['product_sortdesc'] != "") { ?>
                                    <div class="sales">
                                        <span class="img_sale" style="background-image: url('<?= $themUrl ?>/images/qua.png');"></span><span class="text_sale">Quà tặng hấp dẫn</span>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="content_update">
                                <h3 class="title_update"><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>">
                                        <span><?= HtmlFormat::sub_string(strip_tags($product['name']), 50) ?></span>
                                    </a></h3>
                                <div class="box_price">
                                    <p class="price_new"><?php echo number_format($product['price'], 0, '', '.'); ?> VNĐ</p>
                                    <?php if ($product['price_market'] > 0) { ?>
                                        <p class="price_all"><?php echo number_format($product['price_market'], 0, '', '.'); ?> VNĐ</p>
                                    <?php } ?>

                                </div>

                                <div class="link_product listbtn_update">
                                    <a class="btn btn_tragop" href="<?= Yii::app()->createUrl('installment/installment/index', ['id' => $product['id']]) ?>">Mua trả góp</a>
                                    <a class="btn btn_mua" href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua ngay</a>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
            <div class='box-product-page clearfix'>
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

    </div>
<?php
} ?>

<?php
$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK5));
?>

<script src="<?php echo $themUrl ?>/js/home/js/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.big_albums').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav',
            // autoplay:true,
            // autoplaySpeed:5000,
        });
        $('.small_albums').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: false,
            arrow: false,
            focusOnSelect: true,
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,

                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,

                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }

            ]
        });
        $('#owl-demo2').owlCarousel({
            items: 4,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplaySpeed: 2000,
            loop: true,
            margin: 20,
            nav: false,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                },
                1200: {
                    items: 4
                },
                1600: {
                    items: 4
                }
            }
        });
    });
</script>