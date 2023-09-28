<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<div class="title-box-product clearfix">
    <h2>
        <?php echo $category['cat_name']; ?>
    </h2>
</div>
<?php if ($category['cat_description'] != '') { ?>
    <div class="desc-category">
        <?= $category['cat_description']; ?>
    </div>
<?php } ?>
<div class="banner-category-in">
    <?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK18));
    ?>
</div>
<div class="filter-product filter-product-1 clearfix">
    <div class="box-filter">
        <div class="price-in">
            <form method="post" action="/site/form/submit/id/6" id="w3n-submit-form" role="form"
                  class="form-horizontal w3f-form" enctype="multipart/form-data">
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK1));
                ?>
            </form>
        </div>
    </div>
    <div class="search-much">
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK2));
        ?>
    </div>
</div>
<div class="cont-main">
    <?php if (count($products)) { ?>
        <div class="bike-product">
            <div class="row">
                <?php
                foreach ($products as $product) {
                    $product_configurable_images = ProductConfigurableImages::model()->findAll('site_id=:site_id AND product_id=:product_id', array(
                        ':site_id' => $product['site_id'],
                        ':product_id' => $product['id']
                    ));
                    $images_config_arr = array();
                    if (count($product_configurable_images)) {
                        foreach ($product_configurable_images as $img_config) {
                            $images_config_arr[$img_config->pcv_id][] = $img_config->attributes;
                        }
                    }
                    ?>
                    <div class="col-xs-4">
                        <div class="item-bike">
                            <div class="box-img-bike clearfix">
                                <div class="box-img img-bike">
                                    <?php if ($product['avatar_path'] && $product['avatar_name']) { ?>
                                        <a href="<?php echo $product['link'] ?>"
                                           title="<?php echo $product['name'] ?>">
                                            <img alt="<?php echo $product['name'] ?>"
                                                 src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'] ?>">
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $product['link']; ?>"
                                           title="<?php echo $product['name']; ?>">
                                            <img src="<?= $themUrl ?>/css/img/no_images.png"
                                                 alt="<?php echo $product['name'] ?>">
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="box-info">
                                <h4 class="title-bike">
                                    <a href="<?php echo $product['link'] ?>"
                                       title="<?php echo $product['name'] ?>">
                                        <?php echo $product['name'] ?></a>
                                </h4>
                                <div class="clearfix">
                                    <div class="info-l">
                                        <?php
                                        $subject = $product['product_info']['product_sortdesc'];
                                        if ($subject) {
                                            ?>
                                            <div class="khuyenmai">
                                                <p class="gift">Quà tặng</p>
                                                <div class="cont">
                                                    <ul>
                                                        <?php
                                                        $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $subject, $matches);
                                                        $n = 0;
                                                        foreach ($matches[0] as $each) {
                                                            if (++$n > 3) {
                                                                continue;
                                                            }
                                                            echo '<li>', strip_tags($each), '</li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="info-r">
                                         <?php if($product['price_market'] > $product['price'] && $product['price'] > 0) { ?>
                                            <p style="margin: 0 10px;padding: 0"
                                               class="old-price"><?php echo number_format($product['price_market'], 0, '', '.'); ?>
                                                đ
                                            </p>
                                            <p style="margin: 0 10px;padding: 0"
                                               class="price"><?php echo number_format($product['price'], 0, '', '.'); ?>
                                                đ
                                            </p>
                                             <?php }else{ ?>
                                          <?php 

                                          $site_info = Yii::app()->siteinfo;
                                          $phone = explode(',',  $site_info['phone']);
                                          $phone0 = isset($phone[0]) ? $phone[0] : '';
                                          $phone1 = isset($phone[1]) ? $phone[1] : '';
                                          ?>
                                          <p class="price">Liên hệ : <a href="tel:<?= $phone0 ?>"><?= $phone0 ?></p>
                                          <?php }?>
                                        <?php

                                        if ($product['state'] == 1) { ?>
                                            <a style="margin: 0 10px;padding: 0" class="order-product"
                                               href="<?php echo $product['link'] ?>"
                                               title="<?php echo $product['name'] ?>"> Còn
                                                hàng </a>
                                            <a style="margin: 0 10px;padding: 0 10px;background: #ff0000; color: #fff "
                                               class="order-product"
                                               href="<?php echo $product['link'] ?>"
                                               title="<?php echo $product['name'] ?>"> Mua trả góp</a>
                                        <?php } else { ?>
                                            <a class="order-product"
                                               href="<?php echo $product['link'] ?>"
                                               title="<?php echo $product['name'] ?>"> Hết
                                                hàng </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
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
    <?php } else { ?>
        <div class="bike-product">
            <p style="text-align: center;"> Thông tin đang cập nhật </p>
        </div>
    <?php } ?>
</div>