<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<div class="cateinhome">
    <?php if (count($category)) { ?>
        <?php foreach ($category as $cat) { ?>
            <div class="box-main-one"> 
                <div class="main-list">
                    <h3><?php echo $cat['cat_name']; ?>  <a href="<?php echo $cat['link']; ?>"><?php echo Yii::t('common', 'viewall'); ?></a></h3>
                </div><!--end-main-list-->
                <?php if (isset($products[$cat['cat_id']]['products'])) { ?>
                    <div class="row">
                        <?php foreach ($products[$cat['cat_id']]['products'] as $product) { ?>
                            <div class="col-xs-6 col-sm-4">
                                <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>" class="item-product">
                                    <div class="img-product">
                                        <?php if ($product['avatar_path'] && $product['avatar_name']) { ?>
                                            <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's220_220/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                                        <?php } else { ?>
                                            <img src="<?= $themUrl ?>/css/img/anh-nen-suzika.jpg" alt="<?php echo $product['name'] ?>">
                                        <?php } ?>
                                    </div>
                                    <h3 class="title-sp"><?php echo $product['name']; ?></h3>
                                    <div class="clearfix">
                                        <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>

                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div><!--end-list-gird-->
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>