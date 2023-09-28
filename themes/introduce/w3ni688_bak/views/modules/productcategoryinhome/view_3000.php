<?php 
$t = Yii::app()->request->getParam('t', 0);

?>
<style type="text/css" media="screen">
    
</style>
<div class="cateinhome">
    <?php
    foreach ($cateinhome as $cat) {
        if (!isset($data[$cat['cat_id']]['products']) || !count($data[$cat['cat_id']]['products']))
            continue;
        ?>
        <div class="item-cat-in-home"> 
            <div class="header-cat-in-home">
                <h2><a href="<?php echo $cat['link']; ?>"><?php echo $cat['cat_name']; ?></a></h2>
            </div>
            <div class="list-product-in-cat">
                <?php $i = 0;?>
                <?php foreach ($data[$cat['cat_id']]['products'] as $product) { ?>
                    <?php 
                        $product_infos = array();
                        if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                            $product_infos = explode("\n", $product['product_info']['product_sortdesc']);
                        }
                        $i++;
                        if ($i == 1) {
                        ?>
                            <div class="item-product-big">
                                <div class="img-product box-img">
                                    <a href="<?= $product['link']?>">
                                        <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's900_0/' . $product['avatar_name'] ?>">
                                    </a>
                                </div>
                                <div class="caption-product">
                                    <?php if ($product['isnews'] || $product['price_market']): ?>
                                        <div class="header-caption">
                                            <?php if ($product['price_market']): ?>
                                                <p class="price">- <?= number_format(($product['price_market'] - $product['price']), '0',',','.')?></p>
                                            <?php endif ?>
                                            <?php if ($product['isnew']): ?>
                                                <p class="new">Mới về</p>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                    <h4><a href="<?= $product['link']?>"><?= $product['name']?></a></h4>
                                    <div class="price-product">
                                        <?php if ($product['price_market'] > 0): ?>
                                            <span class="old-price"><?= number_format($product['price_market'],'0',',','.')?>đ</span>
                                        <?php endif ?>
                                        <span class="current-price"><?= number_format($product['price'],'0',',','.')?>đ</span>
                                    </div>
                                    <div class="state-product">
                                        <p><i class="fa fa-star"></i> Trạng thái: <span><?= $product['state'] == 1 ? 'Còn hàng' : 'Hết hàng'?></span></p>
                                        <p><i class="fa fa-eye"></i> <?= $product['viewed'].' lượt xem';?></p>
                                    </div>
                                    <div class="product-action">
                                        <a href="<?= $product['link']?>" title="Mua trả góp" class="buy-installment">Mua trả góp</a>
                                        <a href="<?= Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>" title="Mua hàng" class="add-cart-product">Mua hàng</a>
                                    </div>
                                    <div class="gift-product">
                                        <?php foreach ($product_infos as $key => $value): ?>
                                            <p>- <?= strip_tags($value)?></p>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }else{
                        ?>
                            <div class="item-product-small">
                                <div class="img-product box-img">
                                    <a href="<?= $product['link']?>">
                                        <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's500_0/' . $product['avatar_name'] ?>">
                                    </a>
                                </div>
                                <div class="caption-product">
                                    <h4><a href="<?= $product['link']?>"><?= $product['name']?></a></h4>
                                    <div class="price-product">
                                        <?php if ($product['price_market']): ?>
                                        	<a href="<?= $product['link']?>" title="Mua trả góp" class="buy-installment">Mua trả góp</a>
                                            <span class="old-price"><?= number_format($product['price_market'],'0',',','.')?>đ</span>
                                        <?php endif ?>
                                        <span class="current-price"><?= number_format($product['price'],'0',',','.')?>đ</span>
                                    </div>
                                    <?php if ($product_infos): ?>
                                        <div class="product-gift">
                                            <p class="gift-1">
                                                <?php foreach ($product_infos as $key => $gift): ?>
                                                    <?php echo strip_tags($gift).', '; ?>
                                                <?php endforeach ?>
                                            </p>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php
                        }
                    ?>
                <?php } ?>
            </div><!--end-list-gird-->
        </div>
    <?php } ?>
</div>
