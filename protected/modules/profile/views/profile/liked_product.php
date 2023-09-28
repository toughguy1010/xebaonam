<?php if (count($products)) { ?>
    <div class="stand">
        <div class="cont">
            <div class="row">
                <?php
                foreach ($products as $product) {
                    ?>
                    <div class="col-sm-3">
                        <div class="box-stand">
                            <div class="box-stand-img">
                                <a href="<?php echo $product['link']; ?>">
                                    <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's330_330/' . $product['avatar_name'] ?>">
                                </a>
                            </div>
                            <div class="box-stand-info clearfix">
                                <div class="box-stand-info-left">
                                    <div class="name-stand">
                                        <h4>
                                            <a href="<?php echo $product['link']; ?>">
                                                <?php echo $product['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                    <?php if (isset($product['price']) && $product['price'] > 0) { ?>
                                        <div class="price-in">
                                            <p><span><?php echo $product['price_text']; ?></span></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="box-product-page clearfix">
            <div class="product-page" style="float:right; max-width: 500px; text-align: right; ">
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
<?php }