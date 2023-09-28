<?php if (count($products)) { ?>
    <div class="product-cml clearfix">
        <div class="crow">
            <?php foreach ($products as $product) { ?>
                <div class="col-sm-6 box-product-cml">
                    <div class="box-product clearfix">
                        <div class="box-img">
                            <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> 
                                <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's380_380/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                            </a> 
                            <?php if (isset($product['slogan']) && $product['slogan']) { ?>
                                <span class="sl-title"><?php echo $product['slogan'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="box-cont">
                            <h3><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"><?php echo $product['name']; ?></a></h3>

                            <?php if ($product['price'] && $product['price'] > 0) { ?>
                                <div class="price"><?php echo $product['price_text']; ?></div>
                            <?php } ?>
                            <?php if ($product['price_market'] && $product['price_market'] > 0) { ?>
                                <div class="price_old" style="text-decoration: line-through"><?php echo $product['price_market_text']; ?></div>
                            <?php } ?>
                            <div class="checkbox-product">
                                <?php Yii::app()->controller->renderPartial('//partial/product_acction', array('pid' => $product['id'])); ?>
                            </div>
                        </div>
                    </div>
                    <div class="box-view-product-cml">
                        <a title="<?php echo $product['name'] ?>" href="<?php echo $product['link'] ?>">
                            <div>
                                <h3 class="title-hover"><?php echo $product['name'] ?></h3>
                                <?php if ($product['price'] && $product['price'] > 0) { ?>
                                    <strong class="price"><?php echo number_format($product['price'], 0, '', '.'); ?>đ</strong>
                                <?php } ?>
                            </div>
                            <div class="line-cml"></div>
                            <?php
                            $product_infos = array();
                            if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                                $product_infos = explode("\n", $product['product_info']['product_sortdesc']);
                            }
                            if (count($product_infos)) {
                                ?>
                                <div class="wrap_attribute_home">
                                    <?php
                                    foreach ($product_infos as $info) {
                                        ?>
                                        <span><?php echo $info; ?></span>
                                        <?php
                                    }
                                    ?>
                                </div>   
                                <?php
                            }
                            ?>
                        </a>                               
                    </div>
                    <div class="checkbox-product">
                        <?php Yii::app()->controller->renderPartial('//partial/product_acction', array('pid' => $product['id'])); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
