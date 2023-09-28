<div class="modal-content ">
    <div class="header-popup clearfix"> <i class="icon-popup"></i>
        <div class="title-popup">Chi tiết sản phẩm</div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="cont">
        <div class="product-detail">
            <div class="product-detail-box">
                <div class="product-detail-img">
                    <?php
                    $images = $model->getImages();
                    $first = reset($images);
                    ?>
                    <div class="product-img-main">
                        <a class="product-img-small product-img-large cboxElement" href="<?php echo ClaHost::getImageHost() . $first['path'] . 's800_600/' . $first['name'] ?>">
                            <img style="max-height: 100%;max-width: 100%;" src="<?php echo ClaHost::getImageHost() . $first['path'] . 's330_330/' . $first['name'] ?>">
                        </a>
                    </div>
                </div>
                <div class="product-detail-info" id="product-detail-info">
                    <h2 class="product-info-title"><?php echo $product['name'] ?></h2>
                    <div class="product-info-col1">
                        <?php if ($product['price'] && $product['price'] > 0) { ?>
                            <p class="product-price"> 
                                <span class="product-detail-price">
                                    <?php echo $product['price_text']; ?>
                                </span>
                            </p>
                        <?php } ?>
                        <?php if ($product['price_market'] && $product['price_market'] > 0) { ?>
                            <p class="product-info-price-market">
                                <label><?php echo Yii::t('product', 'oldprice'); ?>:</label>
                                <span class="product-detail-price-market"> 
                                    <?php echo $product['price_market_text']; ?>
                                </span>
                            </p>
                        <?php } ?>
                        <?php if ($product['price_market'] && $product['price'] && $product['price'] < $product['price_market']) { ?>
                            <p class="product-info-price-save">
                                <label><?php echo Yii::t('product', 'saveprice'); ?>:</label>
                                <span class="product-detail-price-save">
                                    <?php echo $product['price_save_text']; ?>
                                </span>
                            </p>
                        <?php } ?>
                        <p class="product-detail-sortdesc"><?php echo $product['product_sortdesc'] ?></p>
                        <div class="ViewDetail"> 
                            <a href="<?php echo $link ?>" data-params="#product-detail-info"> 
                                <span>Xem chi tiết</span> 
                            </a>
                        </div>
                        <div class="CartActionAdd ProductActionAdd"> 
                            <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>" class="addtocart noredirect a-btn-2" data-params="#product-detail-info"> 
                                <span class="a-btn-2-text">Đặt hàng</span> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-detail-more"> </div>
        </div>
    </div>
</div>