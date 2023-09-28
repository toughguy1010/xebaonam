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
<div class="cont-main sonfix">
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
                        <div class="box-product item-search">
                            <div class="box-img img-product">
                                <?php if ($product['avatar_path'] && $product['avatar_name']) { ?>
                                    <a href="<?php echo $product['link'] ?>"
                                       title="<?php echo $product['name'] ?>">
                                       <img alt="<?php echo $product['name']; ?>"
                                       src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>"
                                       alt="<?php echo $product['name'] ?>">
                                   </a>
                               <?php } else { ?>
                                <a href="<?php echo $product['link']; ?>"
                                   title="<?php echo $product['name']; ?>">
                                   <img src="<?= $themUrl ?>/css/img/no_images.png"
                                   alt="<?php echo $product['name'] ?>">
                               </a>
                           <?php } ?>
                       </div>
                       <div class="box-info">
                        <h4><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"><?php echo $product['name']; ?></a></h4>
                        <?php if ($product['price'] && $product['price'] > 0 && $product['state'] != 0) { ?>
                            <?php // if ($product['price_market'] && $product['price_market'] > 0) {  ?>
                                <p class="old-price"><?php echo ($product['price_market'] != 0) ? $product['price_market_text'] : ''; ?></p>
                                <?php // }  ?>
                                <p class="price_new_search"><?php echo $product['price_text']; ?></p>
                            <?php } else { ?>
                             <?php 

                             $site_info = Yii::app()->siteinfo;
                             $phone = explode(',',  $site_info['phone']);
                             $phone0 = isset($phone[0]) ? $phone[0] : '';
                             $phone1 = isset($phone[1]) ? $phone[1] : '';
                             ?>
                             <p class="price-detail">Liên hệ : <a href="tel:<?= $phone0 ?>"> 
                                <?php 
                                $pos=1;
                                while($pos){
                                   $pos = strrpos($phone0, "."); 
                                   if($pos){
                                     $phone0=substr_replace($phone0,'',$pos,1);
                                 }
                             }
                             echo($phone0);
                             ?>
                         </p>
                                   <!--  <p class="old-price"><?php echo ''; ?></p>
                                    <div class="price">Liên hệ</div> -->
                                <?php } ?>
                                <?php
                                $product_infos = array();
                                if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                                    $product_infos = explode("\n", $product['product_info']['product_sortdesc']);
                                }
                                ?>
                                <!-- <?php echo ($product_infos[0]) ? ('<p class="gift">' . $product_infos[0] . '</p>') : '' ?> -->
                            </div>                   

                            <!-- <div class="item-search">
                                <div class="img">
                                    <a href="<?php echo $product['link'] ?>">
                                        <img alt="<?php echo $product['name'] ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'] ?>"> 
                                    </a>
                                </div>
                                <div class="content">
                                    <h4><?php echo $product['name'] ?></h4>
                                        <span class="price"><?php echo number_format($product['price'], 0, '', '.'); ?>đ</span>
                                </div>
                            </div> -->
                            
                            <!-- <a class="order-product" href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> Còn hàng </a> -->
                            <?php if (isset($product['slogan']) && $product['slogan']) { ?>
                                <span class="
                                <?php
                                if ($product['slogan'] == 'Bán Chạy' || $product['slogan'] == 'Bán chạy') {
                                    echo 'kind-product';
                                    } else if ($product['slogan'] == 'Mới') {
                                        echo 'kind-product3';
                                        } else if ($product['slogan'] == 'Phá Giá' || $product['slogan'] == 'Phá giá') {
                                            echo 'kind-product2';
                                            } else {
                                                echo 'kind-product1';
                                            }
                                            ?>"><?php echo $product['slogan'] ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="link_product_search">
                                        <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua ngay</a>
                                        <a href="/cach-tinh-tra-gop-pde,11188?price=<?= $product['price'];?>">Mua trả góp</a>
                                    </div>
                                    <div class="box-km-detail clearfix">
                                        <?php if (isset($product['product_sortdesc']) && $product['product_sortdesc'] != "") { ?>
                                            <div class="cont boder">
                                                <div class="title-km-detail">
                                                    <span class="gift-icon"></span>
                                                    <h2>Quà tặng</h2>
                                                </div>
                                            <?php } else{?>
                                                <div class="cont">
                                                <?php } ?>
                                                <ul>
                                                    <?php
                                                    $subject = $product['product_sortdesc'];
                                                    $khuyenmai = explode("\n", $subject);
                                                    foreach ($khuyenmai as $each) {
                                                        if (trim(strip_tags($each)) == null) {
                                                            continue;
                                                        }
                                                        echo '<li>', $each, '</li>';
                                                    }
                                                    ?>
                                                </ul>
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

                <style type="text/css">
                    .box-km-detail{
                        border:none!important;
                    }
                </style>