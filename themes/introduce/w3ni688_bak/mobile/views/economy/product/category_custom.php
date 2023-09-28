<?php if (count($products)) { ?>
    <?php if ($category['cat_description'] != ''): ?>
        <div class="desc-category">
            <?= $category['cat_description']?>
        </div>
    <?php endif ?>
    <div class="row">
        <?php
        foreach ($products as $product) {
            ?>
            <div class="col-xs-6 col-sm-4">
                <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>" class="item-product">
                    <div class="img-product">
                          <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                    </div>
                    <h3 class="title-sp"><?php echo $product['name']; ?></h3>
                    <div class="clearfix">
                         <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>
                     
                    </div>
                </a>
            </div>
           
            <?php
        }
        ?>
    </div>
    <div class='box-product-page clearfix'>
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
    <?php
}
?>