<?php if (count($products_hot) || count($products_new)) { ?>
    <div class="centerContent">
        <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">

            <ul id="myTab" class="nav nav-tabs" role="tablist">
                <?php if (count($products_new)) { ?>
                    <li role="presentation" class="active">
                        <a href="#san-pham-moi" id="san-pham-moi-tab" role="tab" data-toggle="tab" aria-controls="san-pham-moi" aria-expanded="true">Sản phẩm mới</a>
                    </li>
                <?php } ?>
                <?php if (count($products_hot)) { ?>
                    <li role="presentation" class="">
                        <?php if ($show_widget_title) { ?>
                            <a href="#san-pham-ban-chay" role="tab" id="san-pham-ban-chay-tab" data-toggle="tab" aria-controls="san-pham-ban-chay" aria-expanded="false"><?php echo $widget_title ?></a>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>

            <div id="myTabContent" class="tab-content">
                <?php if (count($products_new)) { ?>
                    <div role="tabpanel" class="tab-pane fade active in" id="san-pham-moi" aria-labelledby="san-pham-moi-tab">
                        <div class="list grid">
                            <?php foreach ($products_new as $product_new) { ?>
                                <div class="list-item">
                                    <div class="list-content clearfix">
                                        <div class="list-content-box">
                                            <div class="hover-sp">
                                                <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product_new['id'])); ?>" title="Thêm vào giỏ hàng" class="addcart"></a>
                                                <a href="<?php echo $product_new['link'] ?>" title="<?php echo $product_new['name'] ?>" class="a-btn-2 black">
                                                    <span class="a-btn-2-text">xem chi tiết</span> 
                                                </a>
                                                <a href="<?php echo $product_new['link'] ?>" class="bg-sp"></a>
                                            </div>
                                            <div class="list-content-img">
                                                <a href="<?php echo $product_new['link'] ?>" title="<?php echo $product_new['name'] ?>"> 
                                                    <img src="<?php echo ClaHost::getImageHost() . $product_new['avatar_path'] . 's150_150/' . $product_new['avatar_name'] ?>" alt="<?php echo $product_new['name']; ?>">
                                                </a>
                                            </div>
                                            <div class="list-content-body"> 
                                                <h3 class="list-content-title"> 
                                                    <a href="<?php echo $product_new['link'] ?>" title="<?php echo $product_new['name'] ?>"><?php echo $product_new['name'] ?></a> 
                                                </h3>
                                                <div class="product-price-all clearfix">
                                                    <?php if ($product_new['price'] && $product_new['price'] > 0) { ?>
                                                        <div class="product-price">
                                                            <?php echo Yii::t('product', 'price'); ?>:
                                                            <?php echo $product_new['price_text']; ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if (count($products_hot)) { ?>
                    <div role="tabpanel" class="tab-pane fade" id="san-pham-ban-chay" aria-labelledby="san-pham-ban-chay-tab">
                        <div class="list grid">
                            <?php foreach ($products_hot as $product_hot) { ?>
                                <div class="list-item">
                                    <div class="list-content clearfix">
                                        <div class="list-content-box">
                                            <div class="hover-sp">
                                                <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product_hot['id'])); ?>" title="Thêm vào giỏ hàng" class="addcart"></a>
                                                <a href="<?php echo $product_hot['link'] ?>" title="<?php echo $product_hot['name'] ?>" class="a-btn-2 black">
                                                    <span class="a-btn-2-text">xem chi tiết</span> 
                                                </a>
                                                <a href="<?php echo $product_hot['link'] ?>" class="bg-sp"></a>
                                            </div>
                                            <div class="list-content-img">
                                                <a href="<?php echo $product_hot['link'] ?>" title="<?php echo $product_hot['name'] ?>"> 
                                                    <img src="<?php echo ClaHost::getImageHost() . $product_hot['avatar_path'] . 's150_150/' . $product_hot['avatar_name'] ?>" alt="<?php echo $product_hot['name']; ?>">
                                                </a>
                                            </div>
                                            <div class="list-content-body"> 
                                                <h3 class="list-content-title"> 
                                                    <a href="<?php echo $product_hot['link'] ?>" title="<?php echo $product_hot['name'] ?>"><?php echo $product_hot['name'] ?></a> 
                                                </h3>
                                                <div class="product-price-all clearfix">
                                                    <?php if ($product_hot['price'] && $product_hot['price'] > 0) { ?>
                                                        <div class="product-price">
                                                            <?php echo Yii::t('product', 'price'); ?>:
                                                            <?php echo $product_hot['price_text']; ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
