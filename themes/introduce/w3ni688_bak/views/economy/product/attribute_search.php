<?php
if (isset($products) && count($products)) {
    $class480 = array(4, 5, 9, 11, 15);
    ?>
    <div class="top-product-in clearfix">
        <?php
        $i = 0;
        foreach ($products as $key => $product) {
            $i++;
            if (in_array($i, $class480)) {
                ?>
                <div class="class480">
                    <div class="box-img">
                        <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                            <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's200_200/' . $product['avatar_name'] ?>" />
                        </a>
                    </div>
                    <div class="box-cont-in">
                        <div class="style">
                            <?php
                            $product_infos = array();
                            if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                                $product_infos = explode("\n", $product['product_info']['product_sortdesc']);
                            }
                            if (count($product_infos)) {
                                ?>
                                <ul>
                                    <?php foreach ($product_infos as $info) { ?>
                                        <li class=""> <span><?php echo $info; ?></span> </li>
                                    <?php } ?>
                                </ul>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="checkbox-product-in">
                            <a class="a-btn-4" title="<?php echo Yii::t('shoppingcart', 'order'); ?>" href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"> <?php echo Yii::t('shoppingcart', 'order'); ?> </a>
                        </div>
                    </div>
                    <div class="box-more-in">
                        <div class="title-products-in">
                            <h3><a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a></h3> 
                        </div>
                        <div class="sl-title-in" >
                            <?php if (isset($product['slogan']) && $product['slogan']) { ?>
                                <span><?php echo $product['slogan'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="price-products-in">
                            <span>Giá:</span> 
                            <?php
                            if ($product['price'] && $product['price'] > 0) {
                                echo $product['price_text'];
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } else {
                ?>
                <div class="class240">
                    <div class="box-img">
                        <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                            <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's200_200/' . $product['avatar_name'] ?>" />
                        </a>
                    </div>
                    <div class="box-more-in">
                        <div class="title-products-in">
                            <h3><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a></h3> </div>                                      
                        <div class="sl-title-in" >
                            <?php if (isset($product['slogan']) && $product['slogan']) { ?>
                                <span><?php echo $product['slogan'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="price-products-in">
                            <span>Giá:</span> 
                            <?php
                            if ($product['price'] && $product['price'] > 0) {
                                echo $product['price_text'];
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    $product_infos = array();
                    if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                        $product_infos = explode("\n", $product['product_info']['product_sortdesc']);
                    }
                    ?>

                    <div class="bginfo">
                        <a class="info_hover" title="<?php echo $product['name'] ?>" href="<?php echo $product['link'] ?>">
                            <h3><?php echo $product['name']; ?></h3>
                            <strong><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</strong>
                            <?php
                            if (count($product_infos)) {
                                foreach ($product_infos as $info) {
                                    ?>
                                    <span><?php echo $info; ?></span>
                                    <?php
                                }
                            }
                            ?>
                        </a>
                        <a class="a-btn-4" title="<?php echo Yii::t('shoppingcart', 'order'); ?>" href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>"> 
                            <?php echo Yii::t('shoppingcart', 'order'); ?> 
                        </a>
                    </div>

                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php
}    