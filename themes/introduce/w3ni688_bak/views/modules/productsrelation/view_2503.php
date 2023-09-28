<!--<div class="list-compare">-->
    <?php if ($show_widget_title) { ?>
        <!--<h2><?php echo $widget_title; ?></h2>-->
    <?php } ?>
    <?php $product_id = Yii::app()->request->getParam('id'); ?>
    <?php $alias = Yii::app()->request->getParam('alias'); ?>
    <?php
    if (isset($products) && count($products)) {
        foreach ($products as $key => $product) {
            ?>
            <div class="item-compare clearfix">
                <div class="box-img img-item-compare">
                    <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                        <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>" />
                    </a>
                </div>
                <div class="box-info">
                    <div class="top-info clearfix">
                        <h3 class="title-product">
                            <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                        </h3>
                        <p class="price-main"><?php echo number_format($product['price'], 0, '', '.'); ?><sup>đ</sup></p>

                    </div>
                    <!-- <a class="buttom-ss" title="<?php echo Yii::t('product', 'compare'); ?>" href="<?php echo Yii::app()->createUrl('/economy/product/compare', array('id' => $product_id, 'id1' => $product['id'], 'alias' => $alias, 'alias1' => $product['alias'])); ?>"> 
                        <?php echo Yii::t('shoppingcart', 'compare'); ?> 
                    </a> -->
                </div>
            </div>
            <?php
        }
    }
    ?>
<!--</div>-->