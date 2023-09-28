<?php if (count($products)) { ?>
    <div class="list_car_mobile">
        <div class="title_list_car">
            <h2><a href="<?php echo Yii::app()->createUrl('/economy/product/hotproduct'); ?>" title="<?php echo Yii::t('common', 'viewmore') ?>"><span>Sản phẩm hot</span></a></h2>
        </div>
        <?php foreach ($products as $product) { ?>
            <div class="item_car_mobile">
                <div class="img">
                    <div class="cover">
                        <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> 
                            <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's380_380/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                        </a>
                    </div>
                </div>
                <div class="text">
                    <a href="<?php echo $product['link'] ?>"><h2><?php echo $product['name']; ?></h2></a>
                    <?php if ($product['price'] && $product['price'] > 0) { ?>
                        <p class="price_news"><?php echo number_format($product['price'], 0, '', '.'); ?> VNĐ</p>
                    <?php }?>
                    <?php if ($product['price_market'] && $product['price_market'] > 0) { ?>
                        <p class="price_old"><?php echo number_format($product['price_market'], 0, '', '.'); ?> VNĐ</p>
                    <?php }?>
                    <div class="link_product">
                        <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua ngay</a>
                        <a href="/cach-tinh-tra-gop-pde,11188?price=<?= $product['price'];?>">Mua trả góp</a>
                    </div>
                    <div class="box-km-detail clearfix">
                        <?php if (isset($product['product_sortdesc']) && $product['product_sortdesc'] != "") { ?>
                            <div class="cont boder">
                                <div class="title-km-detail">
                                    <span class="gift-icon"></span>
                                    <h2>Quà tặng</h2>
                                </div>
                            <?php } else{?>
                                <div class="cont">
                                <?php } ?>
                                <ul>
                                    <?php
                                    $subject = $product['product_sortdesc'];
                                    $khuyenmai = explode("\n", $subject);
                                    foreach ($khuyenmai as $each) {
                                        if (trim(strip_tags($each)) == null) {
                                            continue;
                                        }
                                        echo '<li>', $each, '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
            <!--  -->
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_BANNER_MAIN)); ?>
            
        </div>
        <?php }?>