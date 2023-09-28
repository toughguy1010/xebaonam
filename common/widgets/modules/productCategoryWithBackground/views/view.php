<?php
foreach ($cateinhome as $cat) {
    if (!isset($data[$cat['cat_id']]['products']) || !count($data[$cat['cat_id']]['products'])) {
        continue;
    }
    ?>
    <div class="product">
        <div id="maincontent">
            <div class="clearfix layout layout-2">
                <div id="leftCol">
                    <div class="title-tab"></div>
                    <div class="cont-tab">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active lever1">
                                <a href="<?php echo $cat['link'] ?>"><?php echo $cat['cat_name']; ?></a>
                            </li>
                            <?php
                            if (isset($data[$cat['cat_id']]['children_category']) && count($data[$cat['cat_id']]['children_category'])) {
                                foreach ($data[$cat['cat_id']]['children_category'] as $child_cat) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $child_cat['link'] ?>"><?php echo $child_cat['cat_name'] ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="banner-product">
                        <?php
                        $manufacturers = Manufacturer::getManufacturersInCate($cat['cat_id']);
                        if (isset($manufacturers) && count($manufacturers)) {
                            foreach ($manufacturers as $manufacturer) {
                                ?>
                                <a href="<?php echo $cat['link'].'?fi_mnf='.$manufacturer['id'] ?>" title="<?php echo $manufacturer['name'] ?>">
                                    <img src="<?php echo ClaHost::getImageHost().$manufacturer['image_path'].'s100_100/'.$manufacturer['image_name'] ?>" alt="<?php echo $manufacturer['name'] ?>" />
                                </a>
                            <?php }
                        } ?>
                    </div>
                </div>
                <div id="contentCol" class="clearfix">
                    <div class="search-logo"></div>
                    <div class="product-content">
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in clearfix" id="cho-be-an" aria-labelledby="cho-be-an-tab">
                                <div class="list grid">
                                    <?php
                                    $i = 0;
                                    foreach ($data[$cat['cat_id']]['products'] as $product) {
                                        $i++;
                                        ?>
                                        <div class="list-item">
                                            <div class="list-content clearfix">
                                                <div class="list-content-box">
                                                    <div class="hover-sp">
                                                        <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>" title="Thêm vào giỏ hàng" class="addcart"></a>
                                                        <a href="<?php echo $product['link'] ?>" title="Xem chi tiết" class="a-btn-2 black">
                                                            <span class="a-btn-2-text">xem chi tiết</span> 
                                                        </a>
                                                        <a href="<?php echo $product['link'] ?>" class="bg-sp"></a>
                                                    </div>
                                                    <div class="list-content-img">
                                                        <a href="<?php echo $product['link'] ?>"> 
                                                            <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's150_150/' . $product['avatar_name'] ?>">
                                                        </a>
                                                    </div>
                                                    <div class="list-content-body"> 
                                                        <h3 class="list-content-title"> 
                                                            <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"><?php echo $product['name'] ?></a> 
                                                        </h3>
                                                        <div class="product-price-all clearfix">
                                                                <?php if ($product['price'] && $product['price'] > 0) { ?>
                                                                <div class="product-price">
                                                                    <?php echo Yii::t('product', 'price'); ?>:
                                                                <?php echo $product['price_text']; ?>
                                                                </div>
        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        <?php if ($i == 1) { ?>
                                            <div class="slider-product">
                                                <a href="<?php echo $cat['link'] ?>">
                                                    <img src="<?php echo ClaHost::getImageHost() . $cat['image_path'] . $cat['image_name'] ?>" alt="<?php echo $cat['cat_name'] ?>">
                                                </a>
                                            </div>
                                        <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>