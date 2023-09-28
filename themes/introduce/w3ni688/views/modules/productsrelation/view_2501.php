<div class="list-compare">
    <?php if ($show_widget_title) { ?>
        <h2><?php echo $widget_title; ?></h2>
    <?php } ?>
    <?php $product_id = Yii::app()->request->getParam('id'); ?>
    <?php $alias = Yii::app()->request->getParam('alias'); ?>
    <?php
    if (isset($products) && count($products)) {
        foreach ($products as $key => $product) {
            ?>
            <div class="item-product">
                <div class="box-img img-item-product">
                    <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                        <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>" />
                    </a>
                </div>
                <div class="box-info">
                    <h4><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a></h4>
                    <p class="status-product"><?php echo $product['slogan'] ?></p>
                    <p class="price"><?php echo number_format($product['price'], 0, '', '.') . 'đ'; ?></p>
                </div>

                <a class="order-product" title="<?php echo Yii::t('product', 'compare'); ?>" href="<?php echo Yii::app()->createUrl('/economy/product/compare', array('id' => $product_id, 'id1' => $product['id'], 'alias' => $alias, 'alias1' => $product['alias'])); ?>"> 
                    <?php echo Yii::t('shoppingcart', 'compare'); ?> 
                </a>
            </div>
            <?php
        }
    }
    ?>
</div>