<?php
if (count($promotionInHome) > 0) {
    $i = 0;
    foreach ($promotionInHome as $promotion) {
        ++$i;
        $banners = ProductCategoriesBanner::getBannerInPosition(ProductCategoriesBanner::POS_MODULE);
        $data_banners = array();
        if (isset($banners) && $banners) {
            foreach ($banners as $banner) {
                $data_banners[$banner['category_id']][] = $banner;
            }
        }
        $date = new DateTime();
        $utime = $date->format('U');
        $date->setTimestamp($promotion['enddate']);
        $time_end = $date->format('j F Y H:i:s');
        if ($promotion['enddate'] > $utime) {
            ?>

            <div class="list-promotion list-promotion<?php echo $i; ?> clearfix">
                <div class="title-list-promotion title-list-promotion<?php echo $i; ?>">
                    <h3>
                        <a href="<?php echo Yii::app()->createUrl('/economy/product/promotion', array('id' => $promotion['promotion_id'], 'alias' => $promotion['alias'])) ?>"
                           title="<?php echo $promotion['name'] ?>"><?php echo $promotion['name'] ?>
                            100% quà tặng - trả góp 0%</a></h3>
                </div>
                <div class="content-list-promotion content-list-promotion<?php echo $i; ?>">
                    <div class="row">
                        <?php if (isset($data[$promotion['promotion_id']]['products'])) { ?>
                            <?php foreach ($data[$promotion['promotion_id']]['products'] as $product) {
                                ?>
                                <div class="col-xs-6">
                                    <div class="box-product box-promotion">
                                        <div class="box-img img-product img-promotion">
                                            <a href="<?php echo $product['link']; ?>"
                                               title="<?php echo $product['name'] ?>">
                                                <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's600_600/' . $product['avatar_name'] ?>"
                                                     alt="<?php echo $product['name'] ?>"
                                                     />
                                            </a>
                                        </div>
                                        <div class="box-info box-info-promotion">
                                            <h4><a href="<?php echo $product['link'] ?>"
                                                   title="<?php echo $product['name'] ?>"><?php echo $product['name'] ?></a>
                                            </h4>
                                            <?php if ($product['price_market'] && $product['price_market'] > 0) { ?>
                                                <p class="old-price"><?php echo $product['price_market_text']; ?>
                                                </p>
                                            <?php } ?>
                                            <?php if ($product['price'] && $product['price'] > 0) { ?>
                                                <p class="price"><?php echo $product['price_text']; ?>
                                                </p>
                                            <?php } ?>
                                            <?php if (isset($product['product_sortdesc']) && $product['product_sortdesc'] != "") { ?>
                                                <div class="gift gift-promotion">
                                                    <span class="gift-text"> Quà tặng</span>

                                                    <div class="box-gift">
                                                        <ul>
                                                            <?php echo $product['product_sortdesc']; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                                           title="Mua" class="buy-promotion">
                                            Mua </a>
                                        <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"
                                           title="Trả góp"
                                           class="installment-promotion"> Trả góp 0% </a>

                                        <?php if ($product['state'] == 1) { ?>
                                            <a href="<?php echo $product['link']; ?>" title="còn hàng"
                                               class="order-product order-promotion"> còn hàng </a>
                                           <?php }else { ?>
                                            <a href="javascript:void(0)" class="order-product order-promotion"> Hết hàng </a>
                         <?php } ?>
                                           <?php if ($product['price'] < $product['price_market']) { ?>
                                            <span class="sale-promotion"></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div style="clear:both;"></div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
} else {
    ?>

<?php }
?>

