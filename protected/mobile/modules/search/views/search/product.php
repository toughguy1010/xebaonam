<div class="product-search"> 
    <div class="search-result">
        <p class="textreport"><?php echo Yii::t('common', 'search_result', array('{results}' => $totalitem, '{keyword}' => '<span class="bold">' . $keyword . '</span>')); ?></p>
    </div>
    <?php if (count($data)) { ?>
        <div class="list grid">
            <?php
            foreach ($data as $pro) {
                $price = number_format(floatval($pro['price']));
                $price_market = number_format(floatval($pro['price_market']));
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
                                <?php if ($price_market) { ?>
                                    <div class="product-price-market">
                                        <span><?php echo $price_market . Product::getProductUnit($pro) ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($price) { ?>
                                    <div class="product-price">
                                        <span><?php echo $price . Product::getProductUnit($pro) ?></span>
                                    </div> 
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="wpager">
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
                'itemCount' => $totalitem,
                'pageSize' => $limit,
                'header' => '',
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    <?php } ?>
</div>