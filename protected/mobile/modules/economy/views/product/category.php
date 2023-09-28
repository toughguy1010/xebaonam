<?php if (count($products)) { ?>
    <div class="product-category"> 
        <div class="list grid">
            <?php
            foreach ($products as $pro) {
                $price = number_format(floatval($pro['price']));
                if ($price == 0)
                    $price_label = Product::getProductPriceNullLabel();
                else
                    $price_label = $price . Product::getProductUnit($product);
                ?>
                <div class="list-item">
                    <div class="list-content">
                        <div class="list-content-box">
                            <div class="list-content-img">
                                <a href="<?php echo $pro['link']; ?>">
                                    <img src="<?php echo ClaHost::getImageHost() . $pro['avatar_path'] . 's150_150/' . $pro['avatar_name'] ?>">
                                </a>
                            </div>
                            <div class="list-content-body">
                                <span class="list-content-title">
                                    <a href="<?php echo $pro['link']; ?>">
                                        <?php echo $pro['name']; ?>
                                    </a>
                                </span>
                                <?php if ($price) { ?>
                                    <div class="product-price">
                                        <label>Giá: </label><span><?php echo $price; ?></span>
                                    </div> 
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class='product-page'>
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
<?php } ?>