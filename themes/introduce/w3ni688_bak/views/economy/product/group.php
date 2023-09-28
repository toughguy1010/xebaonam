<?php if (count($products)) { ?>
    <div class="product-much">
        <div class="product-cml clearfix">
            <div class="title-product">
                <h2>
                    <!--                    <a href="--><?php //echo $link;?><!--" title="#">--><?php //echo $widget_title?><!--</a>-->
                    <a href="<?php echo $link;?>" title="<?php echo $group['name'] ?>"><?php echo $group['name'] ?></a>
                </h2>
                <a href="<?php echo $link;?>" title="#" class="view-all">Xem thêm</a>
            </div>
            <div class="cont clearfix">
                <?php $i=0; foreach ($products as $product) { ?>
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
                                   </a>
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
                    </div>
                <?php }
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
        </div>   
    </div>


    <?php
} ?>

<?php
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK5));
?>
<?php
    $themUrl = Yii::app()->theme->baseUrl;

    ?>
<script src="<?php echo $themUrl ?>/js/home/js/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.big_albums').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav',
        // autoplay:true,
        // autoplaySpeed:5000,
        });
        $('.small_albums').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '.slider-for',
                    dots: false,
                    arrow:false,
                    focusOnSelect: true,
                    responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }

                    ]
                });
        $('#owl-demo2').owlCarousel({
                items:4,
                autoplay:true,
                autoplayTimeout:6000,
                autoplaySpeed:2000,
                loop:true,
                margin:20,
                nav:false,
                dots:false,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    1000:{
                        items:3
                    },
                    1200:{
                        items:4
                    },
                    1600:{
                        items:4
                    }
                }
            });
    });
</script>

