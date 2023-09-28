<?php if (count($products)) { ?>
    <div class="box-product">
        <div class="cont-box-product">
            <?php if ($category['cat_description'] != ''): ?>
                <div class="desc-category">
                    <?= $category['cat_description']?>
                </div>
            <?php endif ?>
            <div class="row">
                <?php foreach ($products as $product) {
                    $rating = $product['product_info']['total_rating'];
                    $total_votes= $product['product_info']['total_votes'];
                    ?>
                    <div class="col-xs-6 col-sm-4">
                        <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>" class="item-product">
                            <?php
                            $status = '';
                            if ($product['ishot']) {
                                $status = 'stt-hot';
                            } else if ($product['isnew']) {
                                $status = 'stt-new';
                            } else if ($product['state']) {
                                $status = 'stt-het';
                            }
                            ?>
                            <?php
                            $sale_vnd = (($product['price_market'] - $product['price']) / 1000000)
                            ?>

                            <!-- <i class="stt <?php echo $status ?>"></i> -->
                            <!--                            <i class="sale-vnd"> <span> --><?php //echo $sale_vnd ?><!--</span></i>-->
                            <div class="img-product">     
                                <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                                <span class="tragop">Hỗ trợ trả góp</span>
                            </div>
                            <h3 class="title-sp"><?php echo $product['name']; ?></h3>
                            <div class="clearfix fix-price">
                                <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>
                                <p class="old-price"><?php echo number_format($product['price_market'], 0, '', '.'); ?> đ</p>

                                <!-- <div class="sale-of"> <span>-<?php echo ClaProduct::getDiscount($product['price_market'], $product['price']) ?>%</span> </div>
                                <button class="btn btn-default buy-product" type="button">Mua</button>  -->
                                <div class="star">
                                    <span>
                                        <?php
                                           for ($i=1; $i <=5 ; $i++) { 
                                            ?>
                                            <i class="fa fa-star <?= ($i<=$rating)? 'active':'' ?>" aria-hidden="true"  ></i>
                                            <?php
                                        }?>
                                    </span>
                                    <span class="total-star">(<?=$total_votes?> đánh giá)</span>
                                </div>
                            </div>
                            <div class="description">
                                <?php
                                $product_infos = array();
                                if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                                    $ps = array();
                                    $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $product['product_info']['product_sortdesc'], $matches);
                                    for ($i = 0; $i < $count; ++$i) {
                                        $ps[] = preg_replace('/<a[^>]*>(.*?)<\/a>/is', '', $matches[0][$i]);
                                    }
                                }
                                ?>
                                <?php echo ($ps[0]) ? ('<p class="item-info">' . strip_tags($ps[0]) . '</p>') : '' ?>
                                <?php echo ($ps[1]) ? ('<p class="item-info">' . strip_tags($ps[1]) . '</p>') : '' ?>
                                <?php echo ($ps[2]) ? ('<p class="item-info">' . strip_tags($ps[2]) . '</p>') : '' ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>
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
        </div>
    </div>
<?php } ?>



<style>
    .star {
        float: left;
        width: 100%;
        font-size: 11px;
        color: #7d7d7d;
        padding-left: 5px;
        margin-bottom: 6px;
    }
    .star i.active{
        color: #FFD12E;
    }
    .tragop{
        position: absolute;
        bottom: 0px;
        right: 5px;
        background: #ed2024;
        color: #fff;
        font-size: 12px;
        padding: 0px 10px 3px 10px;
        border-radius: 5px;
    }
    .fix-price .old-price {
        float: right;
        margin-right: 5px;
    }
    .box-product .cont-box-product .clearfix {
        padding-top: 10px;
    }
</style>