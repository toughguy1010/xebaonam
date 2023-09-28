<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<?php
if (isset($data) && count($data)) {
    ?>
    <div class="row">
        <?php foreach ($data as $product) {
            ?>
            <div class="col-xs-4">
                <div class="box-product">
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
                            <p class="price"><?php echo $product['price_text']; ?></p>
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
                        <?php echo ($product_infos[0]) ? ('<p class="gift">' . $product_infos[0] . '</p>') : '' ?>
                    </div>

                    
                    <a class="description" href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>" >
                        <div class="clearfix">
                            <h4><?php echo $product['name'] ?></h4>
                            <span class="price"><?php echo number_format($product['price'], 0, '', '.'); ?>đ</span>
                        </div>
                        <?php
                        $product_infos = array();
                        if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                            $product_infos = explode("\n", $product['product_info']['product_sortdesc']);
                        }
                        ?>
                       
                    </a>


                    <a class="order-product" href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> Còn hàng </a>
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
<?php } ?>