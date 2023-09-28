<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/colorbox/jquery.colorbox-min.js');
$videos = Product::getVideoByProductid($product['id']);
?>
<?php $themUrl = Yii::app()->theme->baseUrl; ?>

<link href='<?php echo $themUrl ?>/css/threesixty.css?v=18.04.16' rel='stylesheet' type='text/css' />
<link href='<?php echo $themUrl ?>/css/slick.css?v=18.04.16' rel='stylesheet' type='text/css' />
<script type="text/javascript" src="<?= $themUrl ?>/js/slick.min.js"></script>
<script type="text/javascript" src="<?= $themUrl ?>/js/threesixty.js"></script>
<script>
    var myScrollFuncs = function() {
        var y = window.scrollY;
        if (y > $('#product-detail-info').offset().top) {
            $("body").addClass("fixed");
        } else {
            $("body").removeClass("fixed");
        };
    };
    window.addEventListener("scroll", myScrollFuncs);
</script>

<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_QUESTION_MOBILE)); ?>

<?php
$class_temp = null;
if ($attributesShow && count($attributesShow)) {
    $template = null;
    foreach ($attributesShow as $key => $val) {
        if ($val['code'] == 'mau-nen-template') {
            $template = $val;
            break;
        }
    }
    $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($model, $attributesShow);
    if ($template) {
        $class_temp = $attributesDynamic[$template['id']]['ext'];
    }
}
?>
<div class="page-product-detail">
    <h1 class="title-product-detail"><?php echo $product['name']; ?></h1>
    <div class="images-detail">
        <?php
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
        $configurableFilter = AttributeHelper::helper()->getConfiguableFilter($category['attribute_set_id'], $product);
        if ($configurableFilter && count($configurableFilter)) {
        ?>
        <?php
            foreach ($configurableFilter as $config) {
                if (isset($config['configuable']) && $config['configuable']) {
                    $config = array_column($config['configuable'], 'id');
                } else {
                    $config = array();
                }
            }
        } ?>
    </div>
    <script>
        $(document).ready(function() {
            var owl2 = $(".owl-demo1");
            owl2.owlCarousel({
                itemsCustom: [
                    [0, 1]
                ],
                navigation: false,
                autoPlay: false
            });
            $(".select-cl").click(function(e) {
                e.preventDefault();
                //                            alert(1);
                var a = $(this).attr('goto');
                owl2.trigger('owl.goTo', a);
            });
        });
    </script>
    <?php
    $images = $model->getImages();
    $num_images = count($model->getImages());
    foreach ($images as $key => $image) {
        if ($product['avatar_id'] == $image['img_id']) {
            unset($images[$key]);
        }
    }
    //     $first = reset($images);
    $first = /*reset($images) ? reset($images) :*/
        ['path' => $product['avatar_path'], 'name' => $product['avatar_name']];
    if (isset($images) && count($images)) {
    ?>
        <div class="hot-album">
            <!--     <h2 class="title-block-detail">Hình ảnh nổi bật -<?php echo $product['code']; ?>
                :</h2> -->
            <div class="detail-product-image">
                <div class="images_html">
                    <div class="list-img-detail">
                        <ul class="main-img-detail">
                            <?php
                            if ($product['url_to']) {
                                $src1 = ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'];
                            ?>
                                <li>
                                    <?php Yii::app()->controller->renderPartial('//layouts/img_youtube', array('height' => '400', 'src' => $src1, 'link_vd' => $product['url_to'], 'title' => $product['name'])); ?>
                                </li>
                            <?php
                            }
                            ?>
                            <li>
                                <img src="<?php echo ClaHost::getImageHost(), $first['path'], 's500_500/', $first['name'] ?>" class="img-responsive" alt="<?= $product['product'] ?>">
                            </li>
                            <?php foreach ($images as $key => $image) : ?>
                                <li>
                                    <img src="<?php echo ClaHost::getImageHost(), $image['path'], 's500_500/', $image['name'] ?>" class="img-responsive" alt="<?= $product['product'] ?>">
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <div class="list-img-thumbs">
                        <ul class="thumbs-img-detail">

                            <?php if ($product['url_to']) {
                                $src_v = ClaHost::getImageHost() . $product['avatar_path'] . 's100_100/' . $product['avatar_name'];
                            ?>
                                <li>
                                    <p class="open-video" data="<?= $product['url_to'] ?>">
                                        <img src="<?= $src_v ?>" atl="<?= $product['name'] ?>">
                                        <img src="<?= $themUrl ?>/images/youtube.png" atl="<?= $product['name'] ?>" class="img_ytb">
                                    </p>
                                </li>
                            <?php
                            } ?>
                            <li>
                                <p>
                                    <img src="<?php echo ClaHost::getImageHost(), $first['path'], 's150_150/', $first['name'] ?>" class="img-responsive" alt="<?= $product['product'] ?>">
                                </p>
                            </li>
                            <?php foreach ($images as $key => $image) : ?>
                                <li>
                                    <p>
                                        <img src="<?php echo ClaHost::getImageHost(), $image['path'], 's150_150/', $image['name'] ?>" class="img-responsive" alt="<?= $product['product'] ?>">
                                    </p>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <style>
                    .list-img-detail {
                        position: relative;
                    }

                    .open-video {
                        float: left;
                        width: 100%;
                        background: #33333352;
                        cursor: pointer;
                        border-left: 1px solid #fff;
                        position: relative;
                    }

                    .open-video img {
                        max-width: 100%;
                        margin: 0 auto !important;
                        height: 100%;
                    }

                    .open-video img.img_ytb {
                        position: absolute;
                        top: 30px;
                        width: 44px;
                        height: auto;
                        bottom: 0;
                        left: 0;
                        right: 0;
                    }
                </style>

                <div class="icon_pro_view">
                    <ul>
                        <?php if (count($options_360)) {
                        ?>
                            <li><a class="cur" id="ping_360"><img src="<?= $themUrl ?>/../images/5.png" width="37" height="32">
                                    <span>Ảnh 360 độ</span></a></li>
                        <?php } ?>
                        <?php if (count($videos)) { ?>
                            <li><a class="cur scroll" href="#video_sp"><img src="<?= $themUrl ?>/../images/6.png" width="37" height="32">
                                    <span>Video</span></a></li>
                        <?php } ?>
                        <li><a class="cur scroll" href="#hinhanh_sp"><img src="<?= $themUrl ?>/../images/7.png" width="37" height="32">
                                <span>Xem thêm ảnh</span></a></li>
                    </ul>
                </div>
                <?php if (count($options_360)) {
                ?>
                    <div class="modal fade" id="modal_360" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal">&times;
                                </button>
                                <div class="widget-product-detail">
                                    <div class="image-360">
                                        <div class="cont image-360-product">
                                            <?php
                                            $n = 0;
                                            foreach ($options_360 as $option_exterior) {
                                                if ($n++ > 0) {
                                                    continue;
                                                }

                                                $count = $option_exterior['count'];
                                                $url = $option_exterior['default']['path'];
                                                $imagePath = substr($url, 0, strrpos($url, '/') + 1);
                                                $prd_name = substr($url, strrpos($url, '/') + 1);
                                                $filePrefix = substr($prd_name, 0, strrpos($prd_name, '_') + 1);
                                                $ext = substr($prd_name, strrpos($prd_name, '.'));
                                            ?>
                                                <div class="cont-360">
                                                    <div class="threesixty car">
                                                        <div class="spinner">
                                                            <span>0%</span>
                                                        </div>
                                                        <ol class="threesixty_images">
                                                        </ol>
                                                    </div>
                                                    <div style="text-align: center">
                                                        <a class="btn btn-danger custom_previous"><i class='icon' data-icon="k"></i></a>
                                                        <a class="btn btn-inverse custom_play"><i class='icon' data-icon="m"></i>
                                                            Play</a>
                                                        <a class="btn btn-inverse custom_stop"><i class='icon' data-icon="l"></i>
                                                            Pause</a>
                                                        <a class="btn btn-danger custom_next"><i class='icon' data-icon="j"></i></a>
                                                    </div>
                                                </div>
                                                <script type="text/javascript">
                                                    function hatv_360(count, imagePath, filePrefix, ext) {
                                                        $('.threesixty_images').html('');
                                                        var car = $('.car').ThreeSixty({
                                                            totalFrames: count, // Total no. of image you have for 360 slider
                                                            endFrame: count, // end frame for the auto spin animation
                                                            currentFrame: 1, // This the start frame for auto spin
                                                            imgList: '.threesixty_images', // selector for image list
                                                            progress: '.spinner', // selector to show the loading progress
                                                            imagePath: imagePath + '/s500_500/', // path of the image assets
                                                            filePrefix: filePrefix, // file prefix if any
                                                            ext: ext, // extention for the assets
                                                            height: <?php echo (!ClaSite::isMobile()) ? 570 : 570; ?>,
                                                            width: <?php echo (!ClaSite::isMobile()) ? 790 : 790; ?>,
                                                            navigation: true,
                                                            playSpeed: (6000 / count),
                                                            responsive: true,
                                                        });
                                                        $('.custom_previous').bind('click', function(e) {
                                                            car.previous();
                                                        });
                                                        $('.custom_next').bind('click', function(e) {
                                                            car.next();
                                                        });
                                                        $('.custom_play').bind('click', function(e) {
                                                            car.play();
                                                        });
                                                        $('.custom_stop').bind('click', function(e) {
                                                            car.stop();
                                                        });
                                                        car.play();
                                                    }

                                                    $(document).ready(function() {
                                                        car = $('.car').ThreeSixty({
                                                            totalFrames: <?php echo $count ?>, // Total no. of image you have for 360 slider
                                                            endFrame: <?php echo $count ?>, // end frame for the auto spin animation
                                                            currentFrame: 1, // This the start frame for auto spin
                                                            imgList: '.threesixty_images', // selector for image list
                                                            progress: '.spinner', // selector to show the loading progress
                                                            imagePath: '<?php echo $imagePath ?>' + 's500_500/', // path of the image assets
                                                            filePrefix: '<?php echo $filePrefix ?>', // file prefix if any
                                                            ext: '<?php echo $ext; ?>', // extention for the assets
                                                            height: <?php echo (!ClaSite::isMobile()) ? 570 : 570; ?>,
                                                            width: <?php echo (!ClaSite::isMobile()) ? 790 : 790; ?>,
                                                            navigation: true,
                                                            playSpeed: (6000 / <?php echo $count ?>),
                                                            responsive: true,
                                                            onReady: function() {
                                                                car.play();
                                                            }
                                                        });
                                                        $('.custom_previous').bind('click', function(e) {
                                                            car.previous();
                                                        });
                                                        $('.custom_next').bind('click', function(e) {
                                                            car.next();
                                                        });
                                                        $('.custom_play').bind('click', function(e) {
                                                            car.play();
                                                        });
                                                        $('.custom_stop').bind('click', function(e) {
                                                            car.stop();
                                                        });
                                                    })
                                                </script>
                                            <?php }
                                            ?>
                                            <style>
                                                .cont-page-product-detail .active {
                                                    color: #000
                                                }
                                            </style>
                                        </div>
                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>
                <?php } ?>
            </div>
            <style>
                .list-img-thumbs {}

                .thumbs-img-detail {}

                .thumbs-img-detail li {
                    padding: 3px;
                    outline: 0;
                }

                .thumbs-img-detail li p {
                    border: 1px solid #ebebeb;
                    padding: 2px;
                    margin: 0;
                }

                .thumbs-img-detail .slick-current p {
                    border-color: #000;
                }

                .thumbs-img-detail .slick-track {
                    float: left;
                }

                .thumbs-img-detail .slick-list {
                    padding: 0 !important;
                }
            </style>
            <script>
                $(document).ready(function() {
                    $('.main-img-detail').slick({
                        dots: false,
                        infinite: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        adaptiveHeight: true,
                        asNavFor: '.thumbs-img-detail',
                        fade: true,
                        arrows: false,
                        autoplay: false,

                    });
                    $('.thumbs-img-detail').slick({
                        dots: false,
                        infinite: true,
                        adaptiveHeight: true,
                        centerMode: true,
                        slidesToShow: 3,
                        asNavFor: '.main-img-detail',
                        arrows: false,
                        focusOnSelect: true,
                        autoplay: false,
                    })
                })
            </script>

        </div>
    <?php
    }
    ?>

    <div class="info-m" style="overflow: hidden">
        <?php if ($product['state'] != 0) { ?>
            <div class="price-products-detail">
                <span>Giá </span>
                <span class="pricetext pricetext_p">
                    <?= ($product['price'] > 0) ? number_format($product['price']) : "Liên hệ"; ?>
                </span>
                <sub class="sub_"><?= ($product['price'] > 0) ? 'đ' : ""; ?></sub>
            </div>
            <div class="price-products-detail market-price">
                <?php if ($product['price_market'] > 0) { ?>
                    <span class="market_">Giá thị trường: <span class="pricetext"><?php echo number_format($product['price_market'], 0, '', '.'); ?></span><span class="currencytext">đ</span> </span>
                <?php } ?>
            </div>
            <div class="economical">
                <?php
                $priceMarket = $product['price_market'];
                $price = $product['price'];
                $difference = $priceMarket - $price;
                $percentage = ($difference / $priceMarket) * 100;
                $formattedPercentage = number_format($percentage, 1);
                ?>
                <?php if ($difference > 0) { ?>
                    <p><span>Tiết kiệm: </span><?php echo number_format($difference); ?>đ <span>(<?php echo $formattedPercentage . '%' ?>)</span></p>
                <?php } ?>
            </div>
            <div class="price-products-state " style="">
                <?php if ($product['price_market'] > 0) { ?>
                    <span>Mã sản phẩm: </span><span><?php echo $product['code'] ?></span><br>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="price-products-detail">
                <span class="pricetext"><?php echo 'Liên hệ'; ?></span>
            </div>
        <?php } ?>
        <div id="product-detail-info" class="product-detail-info">
            <div class="top-detail-center">
                <div class="box-info-detail-in">
                    <?php Yii::app()->controller->renderPartial('//module_custom/product_option', array('products' => $product_rel_track, 'id' => $product['id'])); ?>

                    <?php
                    // Lấy và hiển thị các attribute có  thuộc tính tùy chọn
                    $configurableFilter = AttributeHelper::helper()->getConfiguableFilter($category['attribute_set_id'], $product);
                    if ($configurableFilter && count($configurableFilter)) {
                        foreach ($configurableFilter

                            as $config) {
                            $countCf = count($config['configuable']);
                            $cfValue = '';
                            if (isset($config['configuable']) && $countCf) {
                    ?>
                                <div class="box-option">
                                    <div class="option-color">
                                        <div class="product-info-conf product-attr product-option version" attr-title="<?php echo $config['name']; ?>">
                                            <strong class="label"><?php echo $config['name']; ?></strong>
                                            <div class="product-info-conf-list options">
                                                <?php
                                                foreach ($config['configuable'] as $k => $cf) {
                                                ?>
                                                    <div data-id="<?= $product['id'] ?>" data-key="<?= $k ?>" class="product-info-conf-item product-attr-item product-attr-item item" data-input="<?php echo $cf['value']; ?>" class="<?php if ($countCf == 1) echo 'selected'; ?>" data-price="<?php echo number_format(str_replace('.', '', $cf['price'])); ?>">
                                                        <a href="javascript:void(0)" title="<?php echo $cf['name']; ?>">
                                                            <span><label><strong><?php echo $cf['name']; ?></strong></label></span>
                                                            <div>
                                                                <?php
                                                                $images_color = ProductImagesColor::getImagesProductColor($product['id']);
                                                                // print_r('<pre>');
                                                                // print_r($images_color);
                                                                foreach ($images_color as $key => $image) {
                                                                    if ($k == $image['color_code']) {
                                                                ?>
                                                                        <div class="thumb-img">
                                                                            <img src="<?php echo ClaHost::getImageHost(), $image['path'], 's100_100/', $image['name']; ?>" alt="<?php echo $product['name']; ?>" />
                                                                        </div>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                            <!-- <?php if ($cf['price'] > 0) { ?>
                                                                <strong><?php echo number_format(str_replace('.', '', $cf['price'])); ?>
                                                                    ₫</strong>
                                                            <?php } else { ?>
                                                                <strong>Liên hệ</strong>
                                                            <?php } ?> -->
                                                        </a>
                                                    </div>
                                                <?php
                                                }
                                                if ($countCf == 1)
                                                    $cfValue = $cf['value'];
                                                ?>
                                            </div>
                                            <?php
                                            echo CHtml::hiddenField(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY . '[' . $config['id'] . ']', $cfValue, array('class' => 'attrConfig-input'));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-attr-error text-danger">
                                    <span>Vui lòng chọn </span><b></b>
                                </div>
                                <script type="text/javascript">
                                    $(document).ready(function() {

                                        jQuery(document).on('click', '.product-info-conf-list .product-info-conf-item', function() {
                                            $('.product-info-conf-list .product-info-conf-item').removeClass('selected');
                                            $(this).addClass('selected');
                                            var dataInput = $(this).data('input');
                                            if (dataInput) {
                                                $('.attrConfig-input').val(dataInput);
                                            };
                                            var dataprice = $(this).data('price');
                                            $('.market_').show();
                                            $('.sub_').html('');
                                            if (dataprice) {
                                                $('.pricetext.pricetext_p').html(dataprice);
                                                $('.sub_').html('đ');
                                            } else {
                                                $('.pricetext.pricetext_p').html('Liên hệ');
                                                $('.market_').hide();
                                            }
                                            var id = $(this).data('id');
                                            var key = $(this).data('key');
                                            if (id && key) {
                                                $.ajax({
                                                    url: "<?= Yii::app()->createUrl('economy/product/ajaxLoadImageAttrColor') ?>",
                                                    dataType: "json",
                                                    data: {
                                                        id: id,
                                                        key: key
                                                    },
                                                    success: function(data) {
                                                        if (data.html) {
                                                            $('.images_html').html(data.html);
                                                        }
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="price-products-state">
            <p>Tình trạng: <strong class="<?= $product['state'] ? 'green' : 'red' ?>"><?= $product['state'] ? 'Còn hàng' : 'Tạm hết hàng' ?></strong></p>
        </div>
        <?php
        $product_id = $product['id'];
        $list_rel_products = ProductRelation::getProductIdInRel($product_id);
        if (!empty($list_rel_products)) {
        ?>
            <div class="box-item-detail promotion">
                <div class="title">
                    <h3>Khuyến mãi</h3>
                </div>
                <?php

                echo '<div class="cont mCustomScrollbar"><ul>';
                foreach ($list_rel_products as $product_rel) :
                    $productModel = Product::model()->findByPk($product_rel);
                    $category_id = $productModel->product_category_id;
                    if ($productModel && $category_id == 39181) :

                        $productName = $productModel->name;
                        echo "<li> <p> $productName </p> </li>";
                    endif;
                endforeach;
                echo ' </ul></div>';
                ?>
            </div>
        <?php
        }
        ?>

        <?php
        if (count($products_rel)) { ?>
            <!-- <div class="box-item-detail accessories">
                <div class="title">
                    <h3>Phụ kiện chính hãng</h3>
                </div>
                <?php
                //               $subject = $product['product_sortdesc'];
                //               $khuyenmai = explode("\n", $subject);
                echo '<div class="cont mCustomScrollbar"><ul>'; 
                foreach ($products_rel as $each) { ?>
                    <li>
                        <p>
                            <?php echo $each['name']; ?>
                            <a href="<?php echo $each['link']; ?>" title="Chi tiết">(<span style="color: rgb(0, 0, 255);">Chi tiết</span>)</a>
                        </p>
                    </li>
                <?php }
                echo ' </ul></div>';
                ?>
            </div> -->
        <?php 
        } 
        ?>
        <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_RIGHT_OUT)); ?>
    </div>
    <div class="box-item-detail commitment">
        <div class="title">
            <h3>Chính sách ưu đãi</h3>
        </div>
        <div class="cont mCustomScrollbar">
            <?php
            $promotion = $model->getPromotion();
            if ($promotion && count($promotion)) {
                $ps = array();
                $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $promotion['description'], $matches);
            ?>
                <?php foreach ($matches[0] as $camket) { ?>
                    <li class="check-icon">
                        <p><?php echo $camket ?></p>
                    </li>
                <?php } ?>
            <?php }
            ?>
        </div>
        <div class="box-item-detail promotion">
            <div class="title">
                <h3>Ghi chú</h3>
            </div>
            <?php
            $product_note = $model->product_note;
            $khuyenmai_note = explode("\n", $product_note);
            echo '<div class="cont mCustomScrollbar"><ul>';
            foreach ($khuyenmai_note as $each) {
                if (trim(strip_tags($each)) == null) {
                    continue;
                }
                echo '<li><p>', $each, '</p></li>';
            }
            echo ' </ul></div>';
            ?>
        </div>
        <div class="group-link-detail">
            <?php switch ($product["state"]) {
                case false: ?>
                    <a href="<?php echo Yii::app()->createUrl('/site/site/contact'); ?>" title="Liên hệ" class="box-action buy-now ">
                        Liên hệ
                        <span> (Liên hệ ngay để nhận thông tin chi tiết) </span>
                    </a>
                <?php break;

                default: ?>
                    <a data-params="#product-detail-info" href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>" title="Mua ngay" class="box-action buy-now addtocart">
                        Mua ngay
                        <span> (Giao trong 1h hoặc nhận ngay tại showroom) </span>
                    </a>
            <?php break;
            } ?>
            <a data-params="#product-detail-info" href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>" title="Mua ngay" class="box-action addtocart ">
                Đặt hàng
                <span> (Đặt để nhận ưu đãi) </span>
            </a>
            <a href="<?= Yii::app()->createUrl('installment/installment/index', ['id' => $product['id']]) ?>" title="Mua trả góp ngay" class="box-action buy-installment ex1">
                Mua trả góp 0%
                <span> (Thủ tục đơn giản) </span>
            </a>
        </div>
    </div>

    <div class="parameters">
        <h2 class="title-block-detail open">THÔNG SỐ KĨ THUẬT - <?php echo $product['code']; ?>
        </h2>
        <div class="cont">
            <div class="thongso">
                <?php
                if ($attributesShow && count($attributesShow)) {
                ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="img-product-large">
                                <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . $product['avatar_name'] ?>" alt="<?php $product['name'] ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <ul class="parametdesc">
                                <?php
                                $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($model, $attributesShow);
                                foreach ($attributesDynamic as $key => $item) {
                                    if ($key == $template['id']) {
                                        continue;
                                    }
                                    if (is_array($item['value']) && count($item['value'])) {
                                        $item['value'] = implode(", ", $item['value']);
                                    }
                                    if ($item['value'])
                                        echo '<li><span>' . $item['name'] . '</span><strong>' . $item["value"] . '</strong></li>';
                                }
                                ?>
                            </ul>
                        </div>

                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
    <?php
    if (isset($videos) && count($videos)) {
    ?>
        <div class="video-product" id="video_sp">
            <h2 class="title-block-detail">Video -
                <strong><?php echo $product['code']; ?></strong>:
            </h2>
            <div class="cont video-product-product">
                <?php
                $videos = Product::getVideoByProductid($product['id']);
                if (isset($videos) && count($videos)) {
                ?>
                    <div class="box-videos">
                        <iframe width="100%" height="100%" frameborder="0" src="<?php echo $videos[0]['video_embed']; ?>?autoplay=1" allowfullscreen="1" autoplay="1" allowtransparency="true">
                        </iframe>
                    </div>

                    <div class="list-videos" style="background: #f1f1f1">
                        <!--                              <h2>video liên quan - -->
                        <?php //echo $product['code'];
                        ?>
                        <!--</h2>-->
                        <div class="cont frame" id="basic">
                            <ul class="clearfix">
                                <?php
                                $i = 0;
                                foreach ($videos as $video) {
                                    ++$i;
                                ?>
                                    <li class="<?php echo ($i == 1) ? 'active' : ''; ?>" style="margin-bottom: 5px;">
                                        <a onclick="changeVideo(this)" name="<?php echo $video['video_embed']; ?>" href="javascript:void(0)" title="<?php echo $video['video_title']; ?>" class="box-item-videos clearfix">
                                            <div class="box-info" style="overflow: hidden;padding:5px 10px">
                                                <h5><?php echo $video['video_title']; ?></h5>
                                            </div>
                                            <div class="box-img img-box-item-videos" style="float:left;width: 100%;">
                                                <img src="<?php echo ClaHost::getImageHost(), $video['avatar_path'], 's280_280/', $video['avatar_name']; ?>">
                                            </div>

                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="scrollbar">
                        <div class="handle">
                            <div class="mousearea"></div>
                        </div>
                    </div>

                    <style>
                        .videoWrapper {
                            position: relative;
                            padding-bottom: 56.25%;
                            /* 16:9 */
                            padding-top: 25px;
                            height: 0;
                        }

                        .videoWrapper iframe {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                        }
                    </style>
                    <script type="text/javascript">
                        function changeVideo(thistag) {
                            $('.list-videos ul li').removeClass('active');
                            $(thistag).parent().addClass('active');
                            var embed = $(thistag).attr('name') + '?autoplay=1';
                            $('.box-videos iframe').attr('src', embed)
                        }

                        // Slider video

                        $(document).ready(function() {
                            'use strict';
                            (function() {
                                var $frame = $('#basic');
                                var $slidee = $frame.children('ul').eq(0);
                                var $wrap = $frame.parent();

                                // Call Sly on frame
                                $frame.sly({
                                    horizontal: 1,
                                    itemNav: 'basic',
                                    smart: 1,
                                    activateOn: 'click',
                                    mouseDragging: 1,
                                    touchDragging: 1,
                                    releaseSwing: 1,
                                    startAt: 3,
                                    scrollBar: $wrap.find('.scrollbar'),
                                    scrollBy: 1,
                                    pagesBar: $wrap.find('.pages'),
                                    activatePageOn: 'click',
                                    speed: 300,
                                    elasticBounds: 1,
                                    easing: 'easeOutExpo',
                                    dragHandle: 1,
                                    dynamicHandle: 1,
                                    clickBar: 1,
                                });
                            }());
                        });
                    </script>
                <?php } ?>
                <script src='https://cdnjs.cloudflare.com/ajax/libs/Sly/1.6.1/sly.min.js'></script>
            </div>
        </div>
    <?php
    }
    ?>


    <div class="description-detail" id="hinhanh_sp">
        <h2 class="title-block-detail ">mô tả chi tiết</h2>
        <div class="cont cont-description-detail" style="position: relative; max-height: 450px;overflow: hidden;">
            <?php echo $product['product_desc']; ?>
            <span class="seemore-detail" style="">Đọc thêm <i class="fa fa-caret-down"></i></span>
        </div>
        <?php
        /**
         * Comment Ratings
         */
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_COMMENT1));
        ?>

        <div id="comment-panel">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_COMMENT_MOBILE));
            ?>
        </div>
    </div>
    <script>
        $('#ping_360').click(function() {
            $('#modal_360').addClass('open');
        })
        $('#modal_360 .close').click(function() {
            $('#modal_360').removeClass('open');
        })
        var hei_box_menu = $(".header_top_mobile").height();
        $(".scroll").click(function(event) {
            event.preventDefault();
            $('html,body').animate({
                scrollTop: $(this.hash).offset().top - hei_box_menu + 100
            }, 1000);
        });
        $(function() {
            $('.seemore-detail').on('click', function(e) {
                e.preventDefault();
                $('.cont-description-detail').css('max-height', 'unset');
                $(this).fadeOut();
            })
        })
        $(function() {
            $('.addtocart').on('click', function(e) {
                var val_attr = $('.attrConfig-input').val();
                if (val_attr === "") {
                    alert('Vui lòng chọn màu sắc');
                }
                var contact = $('.pricetext.pricetext_p').html();
                if (contact == 'Liên hệ') {
                    window.location.href = "<?php echo Yii::app()->createUrl('/site/site/contact') ?>";
                }
            })
        })
    </script>
    <div class="rel-product">
        <h2 class="title-block-detail "> các xe tương tự </h2>
        <div class="cont cont-compare">
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_SOCIAL)); ?>
        </div>
    </div>

    <?php
    /*Ắc quy chính hãng*/
    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK6)); ?>
    <?php
    if (count($news_rel)) {

    ?>
        <div class="cmt-product">
            <h2 class="title-block-detail">Tin tức liên quan -
                <strong><?php echo $product['code'];
                        ?>
                </strong>:
            </h2>
            <div class="cont cont-cmt-product">

                <div class="evaluate">
                    <h2></h2>
                    <div class="cont">
                        <ul>
                            <?php foreach ($news_rel as $each_news_rel) {
                            ?>
                                <li>
                                    <a href="
     <?php echo $each_news_rel['link']
        ?>
     ">
                                        <?php echo $each_news_rel['news_title']
                                        ?>
                                    </a>
                                </li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    <?php
    }
    ?>

    <div class="numberphone">
        <div class="row">
            <div class="comment-product">

                <div class="tab">
                    <div id="home">

                        <div class="cont cont-compare">
                            <?php
                            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FACEBOOK_COMMENT));
                            ?>
                        </div>
                    </div>

                    <!--                         </div>-->
                </div>
            </div>
            <script>
                jssor_slider1_starter = function(containerId) {

                    var _SlideshowTransitions = [
                        //Fade in L
                        {
                            $Duration: 1200,
                            x: 0.3,
                            $During: {
                                $Left: [0.3, 0.7]
                            },
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                        //Fade out R
                        , {
                            $Duration: 1200,
                            x: -0.3,
                            $SlideOut: true,
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                        //Fade in R
                        , {
                            $Duration: 1200,
                            x: -0.3,
                            $During: {
                                $Left: [0.3, 0.7]
                            },
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                        //Fade out L
                        , {
                            $Duration: 1200,
                            x: 0.3,
                            $SlideOut: true,
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }

                        //Fade in T
                        , {
                            $Duration: 1200,
                            y: 0.3,
                            $During: {
                                $Top: [0.3, 0.7]
                            },
                            $Easing: {
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2,
                            $Outside: true
                        }
                        //Fade out B
                        , {
                            $Duration: 1200,
                            y: -0.3,
                            $SlideOut: true,
                            $Easing: {
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2,
                            $Outside: true
                        }
                        //Fade in B
                        , {
                            $Duration: 1200,
                            y: -0.3,
                            $During: {
                                $Top: [0.3, 0.7]
                            },
                            $Easing: {
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                        //Fade out T
                        , {
                            $Duration: 1200,
                            y: 0.3,
                            $SlideOut: true,
                            $Easing: {
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }

                        //Fade in LR
                        , {
                            $Duration: 1200,
                            x: 0.3,
                            $Cols: 2,
                            $During: {
                                $Left: [0.3, 0.7]
                            },
                            $ChessMode: {
                                $Column: 3
                            },
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2,
                            $Outside: true
                        }
                        //Fade out LR
                        , {
                            $Duration: 1200,
                            x: 0.3,
                            $Cols: 2,
                            $SlideOut: true,
                            $ChessMode: {
                                $Column: 3
                            },
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2,
                            $Outside: true
                        }
                        //Fade in TB
                        , {
                            $Duration: 1200,
                            y: 0.3,
                            $Rows: 2,
                            $During: {
                                $Top: [0.3, 0.7]
                            },
                            $ChessMode: {
                                $Row: 12
                            },
                            $Easing: {
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                        //Fade out TB
                        , {
                            $Duration: 1200,
                            y: 0.3,
                            $Rows: 2,
                            $SlideOut: true,
                            $ChessMode: {
                                $Row: 12
                            },
                            $Easing: {
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }

                        //Fade in LR Chess
                        , {
                            $Duration: 1200,
                            y: 0.3,
                            $Cols: 2,
                            $During: {
                                $Top: [0.3, 0.7]
                            },
                            $ChessMode: {
                                $Column: 12
                            },
                            $Easing: {
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2,
                            $Outside: true
                        }
                        //Fade out LR Chess
                        , {
                            $Duration: 1200,
                            y: -0.3,
                            $Cols: 2,
                            $SlideOut: true,
                            $ChessMode: {
                                $Column: 12
                            },
                            $Easing: {
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                        //Fade in TB Chess
                        , {
                            $Duration: 1200,
                            x: 0.3,
                            $Rows: 2,
                            $During: {
                                $Left: [0.3, 0.7]
                            },
                            $ChessMode: {
                                $Row: 3
                            },
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2,
                            $Outside: true
                        }
                        //Fade out TB Chess
                        , {
                            $Duration: 1200,
                            x: -0.3,
                            $Rows: 2,
                            $SlideOut: true,
                            $ChessMode: {
                                $Row: 3
                            },
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }

                        //Fade in Corners
                        , {
                            $Duration: 1200,
                            x: 0.3,
                            y: 0.3,
                            $Cols: 2,
                            $Rows: 2,
                            $During: {
                                $Left: [0.3, 0.7],
                                $Top: [0.3, 0.7]
                            },
                            $ChessMode: {
                                $Column: 3,
                                $Row: 12
                            },
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2,
                            $Outside: true
                        }
                        //Fade out Corners
                        , {
                            $Duration: 1200,
                            x: 0.3,
                            y: 0.3,
                            $Cols: 2,
                            $Rows: 2,
                            $During: {
                                $Left: [0.3, 0.7],
                                $Top: [0.3, 0.7]
                            },
                            $SlideOut: true,
                            $ChessMode: {
                                $Column: 3,
                                $Row: 12
                            },
                            $Easing: {
                                $Left: $JssorEasing$.$EaseInCubic,
                                $Top: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2,
                            $Outside: true
                        }

                        //Fade Clip in H
                        , {
                            $Duration: 1200,
                            $Delay: 20,
                            $Clip: 3,
                            $Assembly: 260,
                            $Easing: {
                                $Clip: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                        //Fade Clip out H
                        , {
                            $Duration: 1200,
                            $Delay: 20,
                            $Clip: 3,
                            $SlideOut: true,
                            $Assembly: 260,
                            $Easing: {
                                $Clip: $JssorEasing$.$EaseOutCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                        //Fade Clip in V
                        , {
                            $Duration: 1200,
                            $Delay: 20,
                            $Clip: 12,
                            $Assembly: 260,
                            $Easing: {
                                $Clip: $JssorEasing$.$EaseInCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                        //Fade Clip out V
                        , {
                            $Duration: 1200,
                            $Delay: 20,
                            $Clip: 12,
                            $SlideOut: true,
                            $Assembly: 260,
                            $Easing: {
                                $Clip: $JssorEasing$.$EaseOutCubic,
                                $Opacity: $JssorEasing$.$EaseLinear
                            },
                            $Opacity: 2
                        }
                    ];

                    var options = {
                        $AutoPlay: true, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                        $AutoPlayInterval: 1500, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                        $PauseOnHover: 1, //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                        $DragOrientation: 3, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                        $ArrowKeyNavigation: false, //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                        $SlideDuration: 800, //Specifies default duration (swipe) for slide in milliseconds

                        $SlideshowOptions: { //[Optional] Options to specify and enable slideshow or not
                            $Class: $JssorSlideshowRunner$, //[Required] Class to create instance of slideshow
                            $Transitions: _SlideshowTransitions, //[Required] An array of slideshow transitions to play slideshow
                            $TransitionsOrder: 1, //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                            $ShowLink: true //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                        },
                        $ArrowNavigatorOptions: { //[Optional] Options to specify and enable arrow navigator or not
                            $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                            $ChanceToShow: 1 //[Required] 0 Never, 1 Mouse Over, 2 Always
                        },
                        $ThumbnailNavigatorOptions: { //[Optional] Options to specify and enable thumbnail navigator or not
                            $Class: $JssorThumbnailNavigator$, //[Required] Class to create thumbnail navigator instance
                            $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                            $ActionMode: 1, //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                            $SpacingX: 8, //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                            $DisplayPieces: 8, //[Optional] Number of pieces to display, default value is 1
                            $ParkingPosition: 360 //[Optional] The offset position to park thumbnail
                        }
                    };

                    var jssor_slider1 = new $JssorSlider$(containerId, options);
                    //responsive code begin
                    //you can remove responsive code if you don't want the slider scales while window resizes
                    function ScaleSlider() {
                        var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                        if (parentWidth)
                            jssor_slider1.$ScaleWidth(Math.max(Math.min(parentWidth, 500), 333));
                        else
                            $Jssor$.$Delay(ScaleSlider, 30);
                    }

                    ScaleSlider();
                    $Jssor$.$AddEvent(window, "load", ScaleSlider);

                    $Jssor$.$AddEvent(window, "resize", $Jssor$.$WindowResizeFilter(window, ScaleSlider));
                    $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
                    //responsive code end
                };
            </script>
            <script>
                jssor_slider1_starter('slider1_container');
            </script>

        </div>
        <style>
            .product-detail-info .product-info-conf .product-info-conf-list .product-info-conf-item a {
                border: none;
            }

            #modal_360 {
                padding: 0;
                margin: 0;
                position: fixed;
                top: 0;
                z-index: 99999;
                background: #fff;
                width: 100%;
                opacity: 0;
                visibility: hidden;
                z-index: -1;
            }

            #modal_360.open {
                transition: all .5s;
                opacity: 1;
                visibility: inherit;
                z-index: 9999;
            }

            #modal_360 .close {
                outline: none;
                width: 30px;
                height: 30px;
                right: 8px;
                top: 0px;
                line-height: 0;
                background: #000;
                color: #fff;
                padding: 0;
                font-size: 22px;
                border-radius: 100%;
                padding-bottom: 8px;
                z-index: 9999;
                position: absolute;
            }

            #modal_360 .image-360 {
                padding-top: 40px;
            }

            #modal_360 .widget-product-detail .cont-360 .threesixty {}

            #modal_360 .modal-dialog {
                width: 100%;
                height: 100vh;
                margin: 0;
            }

            #modal_360 .modal-open .modal {
                padding: 0;
            }

            #modal_360 .modal-content {
                position: relative;
                height: 100%;
            }

            .icon_pro_view ul {
                margin: 0;
                padding: 0;
            }

            .icon_pro_view ul {
                text-align: center;
                padding-top: 0;
                margin-top: 30px;
                float: left;
                width: 100%;
            }

            .icon_pro_view ul li {
                list-style: none;
                display: inline-table;
                margin: 0 4px;
                border-radius: 4px;
                border: solid #CCC 1px;
                padding: 5px 0;
                line-height: 0;
                width: 30%;
                padding-top: 10px;
            }

            .icon_pro_view ul li a {
                float: left;
                width: 100%;
            }

            .cur {
                cursor: pointer;
            }

            .icon_pro_view ul li img {
                width: auto;
                height: 30px;
                margin: 0;
            }

            .icon_pro_view ul li span {
                display: block;
                font-size: 14px;
                padding-top: 3px;
                color: #666;
                line-height: 25px;
            }

            .icon_pro_view ul li:hover span {
                color: #337ab7;
            }

            #comment-panel,
            .cmt-product {
                float: left;
                width: 100%;
            }

            .product-info-conf.product-attr {
                display: block;
            }

            .product-detail-info .product-info-conf .product-info-conf-list .product-info-conf-item a {
                padding: 0;
                margin: 0;
            }

            .product-detail-info .product-info-conf .product-info-conf-list,
            .product-detail-info .product-info-conf .product-info-conf-list .product-info-conf-item {
                display: inline-flex;
            }

            .thumbs-img-detail img {
                max-height: 85px;
                margin: 0 auto;
            }

            .box-item-detail.promotion {
                float: left;
                width: 100%;
            }

            .sub_ {
                color: #ff0000;
                font-size: 19px;
                top: -10px;
            }

            .info-m .economical {
                font-size: 14px;
            }

            .info-m .economical p {
                color: #ff0000;
                font-weight: 700;
            }

            .info-m .economical span {
                color: #333;
            }

            .product-detail-info .product-info-conf .product-info-conf-list .product-info-conf-item a {
                display: grid;
                align-content: space-between;
            }
        </style>