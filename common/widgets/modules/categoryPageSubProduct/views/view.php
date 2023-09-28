<?php if (isset($data['children_category']) && $data['children_category']) { ?>
    <div class="main-page-list-product">
        <?php
        foreach ($data['children_category'] as $category) {
            if (isset($category['products']) && $category['products']) {
                ?>
                <div class="box-list-product">
                    <div class="header-main-page-list-product clearfix">
                        <div class="pull-left">
                            <h3 class="title-box-list-product">
                                <a href="<?php echo $category['link'] ?>" title="<?php echo $category['cat_name'] ?>">
                                    <?php echo $category['cat_name'] ?>
                                </a>
                            </h3>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo $category['link'] ?>" title="Xem tất cả" class="view-list-product">Xem tất cả</a>
                        </div>
                    </div>
                    <div class="cont">
                        <div class="row">
                            <?php foreach ($category['products'] as $product) { ?>
                                <div class="col-xs-3">
                                    <div class="item-product">
                                        <div class="box-img img-product-hot">
                                            <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>">
                                                <img src="<?php echo ClaHost::getImageHost(), $product['avatar_path'], 's250_250/', $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                                            </a>
                                        </div>
                                        <div class="box-info">
                                            <h4><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"><?php echo $product['name'] ?></a></h4>
                                            <?php if ($product['price'] > 0) { ?>
                                                <p class="price"><?php echo $product['price_text']; ?></p>
                                            <?php } ?>
                                            <div class="addtopcart">
                                                <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>" title="Mua hàng">Mua hàng</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php
}
?>