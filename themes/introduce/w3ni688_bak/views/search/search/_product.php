<?php
if (isset($data) && count($data)) {
    $class480 = array(4, 5, 9, 11, 15);
    ?>
    <div class="product-in clearfix">
        <?php
        $i = 0;
        foreach ($data as $key => $product) {
            $i++;
            if (in_array($i, $class480)) {
                ?>
                <div class="item-product style2">
                    <div class="box-img img-item-product">
                        <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                            <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's250_0/' . $product['avatar_name'] ?>" />
                        </a>
                    </div>
                    <div class="box-info">
                        <h4><a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a></h4>
                        <p class="old-price"><?php echo number_format($product['market_price'], 0, '', '.'), 'đ'; ?></p>
                        <p class="price"><?php echo number_format($product['price'], 0, '', '.'), 'đ'; ?></p>
                    </div>
                    <a class="order-product" title="<?php echo Yii::t('shoppingcart', 'order'); ?>" href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Đặt hàng</a>
                </div>

            <?php } else {
                ?>
                <div class="item-product style1">
                    <div class="box-img img-item-product">
                        <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                            <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's250_0/' . $product['avatar_name'] ?>" />
                        </a>
                    </div>
                    <div class="box-info">
                        <h4><a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a></h4>
                        <p class="old-price"><?php echo number_format($product['market_price'], 0, '', '.'), 'đ'; ?></p>
                        <p class="price"><?php echo number_format($product['price'], 0, '', '.'), 'đ'; ?></p>
                    </div>
                    <?php
                    $product_infos = array();
                    if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                        $product_infos = explode("\n", $product['product_info']['product_sortdesc']);
                    }
                    ?>
                    <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>" class="description">
                        <div class="clearfix"><h4><?php echo $product['name']; ?></h4> <span class="price"><?php echo number_format($product['price'], 0, '', '.'), 'đ'; ?></span></div>
                        <div>
                            <?php
                            if (count($product_infos)) {
                                foreach ($product_infos as $info) {
                                    ?>
                                    <span><?php echo $info; ?></span>
                                    <?php
                                }
                            }
                            ?>  
                        </div>
                    </a>
                </div>
                <?php
            }
        }
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
<?php }
?> 