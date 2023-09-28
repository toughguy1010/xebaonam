<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<?php if (count($products)) {
    $mucs = Manufacturer::getAllManufacturerArr();
    $manufacturers = [];
    foreach ($products as $product) {
        if (isset($mucs[$product['manufacturer_id']])) {
            $manufacturers[$product['manufacturer_id']] = $mucs[$product['manufacturer_id']];
        }
        // else {
        //     $manufacturers[0] = 'Hãng khác';
        //     $product['manufacturer_id'] = 0;
        // }
    }
?>
    <style>
        .manufacturers-ix li {
            list-style: none;
            float: left;
            padding: 5px 10px;
            background: #fff;
            margin-left: 10px;
            color: #ed2024;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .manufacturers-ix {
            overflow: hidden;
            float: left;
            width: 100%;
        }

        .csshow-br.active {
            background: #ed2024;
            color: #fff;
        }
    </style>
    <div class="list_car_mobile">
    </div>
    <div class="title_list_car">
        <h2><a href="<?php echo Yii::app()->createUrl('/economy/product/hotproduct'); ?>" title="<?php echo Yii::t('common', 'viewmore') ?>"><span>Sản phẩm hot</span></a></h2>

    </div>
    <ul class="manufacturers-ix">
        <li class="show-br" data="">Tất cả</li>
        <?php if ($manufacturers) foreach ($manufacturers as $key => $value) { ?>
            <li class="csshow-br show-br" data="<?= $key ?>"><?= $value ?></li>
        <?php } ?>
    </ul>
    <div class="list_product_mobile">
        <?php foreach ($products as $product) { ?>
            <div class="item ">
                <?php if (!$product['state']) { ?>
                    <a href="<?php echo Yii::app()->createUrl('/site/site/contact'); ?>"><span class="hethang"> Liên Hệ Cửa Hàng</span></a>
                <?php } ?>
                <div class="img_update">
                    <?php if ($product['price_market'] && $product['price_market'] > 0 && $product['price'] && $product['price'] > 0) { ?>
                        <div class="discount" style="background-image: url('<?= $themUrl ?>/images/discount.png');">
                            <span class="pin_sale">-<?php echo ClaProduct::getDiscount($product['price_market'], $product['price']) ?>%</span>
                        </div>
                    <?php } ?>
                    <a href="<?php echo $product['link'] ?>">
                        <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's250_250/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                    </a>
                    <?php if (isset($product['product_sortdesc']) && $product['product_sortdesc'] != "") { ?>
                        <!-- <div class="sales">
                            <span class="img_sale" style="background-image: url('<?= $themUrl ?>/images/qua.png');"></span>
                            <span class="text_sale">Quà tặng hấp dẫn</span>
                        </div> -->
                    <?php } ?>
                </div>
                <?php
                $product_id = $product['id'];
                $list_rel_products = ProductRelation::getProductIdInRel($product_id);
                if (!empty($list_rel_products)) {
                ?>
                    <div class="gift-list">
                        <?php
                        foreach ($list_rel_products as $product_rel) :
                            $productModel = Product::model()->findByPk($product_rel);
                            $category_id = $productModel->product_category_id;
                            if ($productModel && $category_id == 39181) :

                                $productName = $productModel->name;
                                $icon = ClaHost::getImageHost() . $productModel['avatar_path'] . 's400_400/' . $productModel['avatar_name'];
                        ?>
                                <div class="gift-item">
                                    <img src="<?= $icon ?>" alt="">
                                    <span class="text_gift"><?= $productName; ?></span>
                                </div>
                        <?php
                            endif;
                        endforeach; ?>
                    </div>
                <?php
                } else {
                ?>
                    <div class="gift-space">

                    </div>
                <?php
                }
                ?>
                <div class="content_update">
                    <h3 class="title_update"><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>">
                            <span><?= HtmlFormat::sub_string(strip_tags($product['name']), 50) ?></span>
                        </a></h3>
                    <div class="box_price">
                        <?php if ($product['price'] > 0) { ?>
                            <p class="price_new"><?php echo number_format($product['price'], 0, '', '.'); ?> VNĐ</p>
                        <?php } else { ?>
                            <a class="price_new" href="<?php echo Yii::app()->createUrl('/site/site/contact'); ?>">Liên Hệ Cửa Hàng</a>
                        <?php } ?>
                        <?php if ($product['price_market'] > 0) { ?>
                            <p class="price_all"><?php echo number_format($product['price_market'], 0, '', '.'); ?>
                                VNĐ</p>
                        <?php } ?>

                    </div>

                    <div class="link_product listbtn_update">
                        <a class="btn btn_tragop" href="<?= Yii::app()->createUrl('installment/installment/index', ['id' => $product['id']]) ?>">Mua
                            trả góp</a>
                        <a class="btn btn_mua" href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua
                            ngay</a>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>

    <!--  -->
    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_BANNER_MAIN)); ?>

    <script>
        $('.show-br').click(function() {
            id = $(this).attr('data');
            $('.manufacturers-show').css('display', 'none');
            $('.manufacturers-show' + id).css('display', 'block');
            $('.show-br').removeClass('active');
            $(this).addClass('active');
        });
    </script>
<?php } ?>