<?php if (count($products)) { ?>
<div class="list-promotion list-promotion clearfix">

    <div class="content-list-promotion content-list-promotion">
        <div class="row">
            <?php
            foreach ($products as $product) {
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
                                        đ</p>
                                <?php } ?>
                                <?php if ($product['price'] && $product['price'] > 0) { ?>
                                    <p class="price"> <?php echo $product['price_text']; ?>
                                        đ</p>
                                <?php } ?>
                                <?php if (isset($product['product_sortdesc']) && $product['product_sortdesc'] != "") { ?>
                                    <div class="gift gift-promotion">
                                        Quà
                                        tặng
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
                            <?php } ?>
                            <?php if ($product['price'] < $product['price_market']) { ?>
                                <span class="sale-promotion"></span>
                            <?php } ?>
                        </div>
                    </div>
                <?php }
             ?>
            <div class='product-page' style="float:right; max-width: 500px; text-align: right; ">
                <?php
                $this->widget('common.extensions.LinkPager.LinkPager', array(
                     'itemCount' => $totalitem,
                     'pageSize' => $limit,
                     'header' => '',
                     'selectedPageCssClass' => 'active',
                ));
                ?>
            </div>
            <div style="clear:both;"></div>
        </div>

    </div>
</div>
<?php }