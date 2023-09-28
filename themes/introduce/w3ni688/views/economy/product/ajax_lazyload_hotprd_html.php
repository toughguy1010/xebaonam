<?php if (count($products)) { ?>

    <?php $n = 0; ?>
    <?php foreach ($products as $product) { ?>
        <div class="col-xs-4 bike-item">
            <div class="item-bike">
                <div class="box-img-bike clearfix">
<!--                    <div class="img-thumb-bike" style="height: 280px;overflow: hidden">-->
<!--                        --><?php
//                        if (count($images_config_arr)) {
//                            foreach ($images_config_arr as $key => $image) {
//                                ?>
<!---->
<!--                                <a -->
<!--                                    onclick="change_image_hatv(this)" img-link="--><?php //echo ClaHost::getImageHost() . $image[0]['path'] . '/s300_300/' . $image[0]['name'] ?><!--" href="javascript:void(0)"  class="item-thumb">-->
<!--                                    <img alt="--><?php //echo $product['name'] ?><!--" src="--><?php //echo ClaHost::getImageHost() . $image[0]['path'] . '/s100_100/' . $image[0]['name'] ?><!--" title="--><?php //echo $image[0]['name'] ?><!--" />-->
<!--                                </a>-->
<!--                                --><?php
//                            }
//                        }
//                        ?>
<!--                    </div>-->
                    <!--                                  Doan commet ẩn bớt chọn này sản phẩm ngày 31-7-2017-->

                    <div class="box-img img-bike">
                        <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> 
                            <img alt="<?php echo $product['name'] ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'] ?>"> 
                        </a> 
                    </div>
                </div>
                <div class="box-info">
                    <h4 class="title-bike">
                        <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> 
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
                            <p  style="margin: 0 10px;padding: 0" class="old-price"><?php echo number_format($product['price_market'], 0, '', '.'); ?>
                                đ</p>
                            <p style="margin: 0 10px;padding: 0" class="price"><?php echo ($product['price'] != 0) ? (number_format($product['price'], 0, '', '.'). 'đ') : 'Liên hệ';  ?>
                            </p>

                            <!--                                             <p  style="margin: 0 10px;padding: 0" class="price">--><?php //echo number_format($product['price'], 0, '', '.'); ?>
                            <!--                                                  đ</p>-->
                            <?php

                            if ($product['state'] == 1) { ?>
                                <a style="margin: 0 10px;padding: 0" class="order-product"
                                   href="<?php echo $product['link'] ?>"
                                   title="<?php echo $product['name'] ?>"> Còn
                                    hàng </a>
                                <a  style="margin: 0 10px;padding: 0 10px;background: #ff0000; color: #fff " class="order-product"
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
        <?php
    }
    ?>
    <?php
}