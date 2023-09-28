<?php
$products = $model->getProduct(array(ClaSite::PAGE_VAR => $page, 'limit' => $limit));
$totalitem = $model->getProduct(array(), true);
$manufacturerInfo = $model->ManufacturerInfo();
$manufacturer = $model->getAttributes();

?>
<div class="page-doitac page-doitac-detail">
    <div class="container">
        <div class="row multi-columns-row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="item-inpage-doitac">
                    <div class="img-item-inpage-doitac item-show">
                        <?php if ($manufacturer['image_path'] && $manufacturer['image_name']) { ?>
                            <a href="<?php echo $manufacturer['link']; ?>" title="<?php echo $manufacturer['name']; ?>">
                                <img src="<?php echo ClaHost::getImageHost() . $manufacturer['image_path'] . 's200_200/' . $manufacturer['image_name'] ?>"
                                     alt="<?php echo $manufacturer['name'] ?>">
                            </a>
                        <?php } ?>
                    </div>
                    <div class="title-item-inpage-doitac">
                        <h2 style="display: block"><a><?= $manufacturer['name'] ?></a></h2>
                        <span>Website: <?= $manufacturerInfo['address'] ?></span>
                        <p>
                            <?= $manufacturerInfo['description'] ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-list-product-inpage">
            <h2 class="style-h2 uppercase">SẢN PHẨM <?= $manufacturer['name'] ?></h2>
            <div class="row  multi-columns-row">
                <?php
                if (count($products)) {
                    $claCategory = new ClaCategory(array('create' => true, 'type' => ClaCategory::CATEGORY_PRODUCT));
                    foreach ($products as $product) { ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                            <div class="item-product-inpage">
                                <div class="img-item-product-inpage item-show">
                                    <?php if ($product['avatar_path'] && $product['avatar_name']) { ?>
                                        <a href="<?php echo $product['link']; ?>"
                                           title="<?php echo $product['name']; ?>">
                                            <img alt="<?php echo $product['name']; ?>"
                                                 src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's350_350/' . $product['avatar_name'] ?>"
                                                 alt="<?php echo $product['name'] ?>">
                                            <span class="bg-hover-img"><i class="fa fa-link"></i></span>
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="title-item-product-inpage">
                                    <h2>
                                        <a href="<?php echo $product['link']; ?>"
                                           title="<?php echo $product['name']; ?>">
                                            <?php echo $product['name']; ?>
                                        </a>
                                    </h2>
                                    <?php
                                    if ($claCategory->getItem($product['product_category_id'])) {
                                    } ?>
                                    <p>MS: <?php echo $product['code'] ?></p>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                <?php } else { ?>
                    <div class="col-xs-12">
                        <?= 'Chưa có sản phẩm' ?>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="paginate">
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
                'itemCount' => $totalitem,
                'pageSize' => $limit,
                'header' => '',
                'htmlOptions' => array('class' => 'W3NPager',), // Class for ul
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    </div>
</div>