<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/colorbox/jquery.colorbox-min.js');
?>
<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<?php
$images = $model->getImages();
$videos = Product::getVideoByProductid($product['id']);
?>
<link href='<?php echo $themUrl ?>/css/jquery.mCustomScrollbar.css?v=18.04.16' rel='stylesheet' type='text/css' />
<script type="text/javascript" src="<?= $themUrl ?>/js/jssor.js"></script>
<script type="text/javascript" src="<?= $themUrl ?>/js/jssor.slider.js"></script>
<script type="text/javascript" src="<?= $themUrl ?>/js/threesixty.js"></script>

<script type="text/javascript" src="<?php echo $themUrl ?>/js/magiczoomplus.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $themUrl ?>/css/magiczoomplus.css">

<script type="text/javascript">
    $(document).ready(function() {
        MagicZoom.options = {
            'fps': 40,
            'hint': false,
            'zoom-fade-in-speed': 600,
            'zoom-fade-out-speed': 600,
            'right-click': true,
            'selectors-mouseover-delay': 200,
            'zoom-distance': 5,
            'zoom-position': 'right',
            'zoom-height': 400,
            'zoom-width': 400
        };
    });
</script>


<div class="page-in page-detail-product">
    <div class="container" style="position: relative">
        <div class="menu-active-product-detail" style="">
            <ul>
                <li class="mn-mt active">
                    <a class="searchbychar" href="javascript:void(0)" data-toggle="tab" role="tab" data-target="cont-detail-product" title="#">Mô tả</a>
                </li>
                <li class="mn-pic ">
                    <a class="searchbychar" href="javascript:void(0)" data-toggle="tab" role="tab" data-target="image360" title="#">Hình ảnh</a>
                </li>
                <li class="mn-cmt">
                    <a class="searchbychar" href="javascript:void(0)" data-toggle="tab" role="tab" data-target="comment-box" title="#">Bình luận</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container">
        <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
        <div class="top-detail-product ">
            <div class="header-product-detail clearfix">
                <h1 class="name-product-detail"><?php echo $product['name']; ?></h1>
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK1));
                ?>
            </div>
            <div class="cont-top-product-detail clearfix">
                <div class="col-left-detail col-lg-6 col-md-12">
                    <div class="avt-product">
                        <!--Image-->
                        <?php
                        $product_configurable_images = ProductConfigurableImages::model()->findAll('site_id=:site_id AND product_id=:product_id', array(
                            ':site_id' => $product['site_id'],
                            ':product_id' => $product['id'],
                        ));
                        $images_config_arr = array();
                        if (count($product_configurable_images)) {
                            foreach ($product_configurable_images as $img_config) {
                                $images_config_arr[$img_config->pcv_id][] = $img_config->attributes;
                            }
                        }
                        $configurableFilter = AttributeHelper::helper()->getConfiguableFilter($category['attribute_set_id'], $product);
                        $config = array();
                        if ($configurableFilter && count($configurableFilter)) {
                        ?>
                        <?php
                            foreach ($configurableFilter as $config) {
                                if (isset($config['configuable']) && $config['configuable']) {
                                    $config = array_column($config['configuable'], 'id');
                                }
                            }
                        } ?>

                        <div class="widget-product-detail">
                            <!--Hình ảnh-->
                            <div class="image360 widget-product-detail picture-detail">
                                <div class=" widget-product-detail picture-detail-content">
                                    <?php
                                    $images = $model->getImages();

                                    $num_images = count($model->getImages());
                                    $first = reset($images);
                                    ?>
                                    <div class="widget-product-detail image-hot">
                                        <div class="show-img-product" id="show-img-product-main">
                                            <div class="preview col">
                                                <div class="app-figure" id="zoom-fig">
                                                    <div class="images_html">
                                                        <?php
                                                        $images = $model->getImages();
                                                        foreach ($images as $key => $image) {
                                                            if ($product['avatar_id'] == $image['img_id']) {
                                                                unset($images[$key]);
                                                            }
                                                        }
                                                        $first = /*reset($images) ? reset($images) :*/
                                                            ['path' => $product['avatar_path'], 'name' => $product['avatar_name']];

                                                        ?>
                                                        <div class="big-img" style="margin-bottom:10px;">
                                                            <a id="magiczoommain" class="MagicZoom" title="<?php echo $product['name'] ?>" href="<?php echo ClaHost::getImageHost(), $first['path'], $first['name'] ?>">
                                                                <img src="<?php echo ClaHost::getImageHost(), $first['path'], 's800_600/', $first['name'] ?>" alt="<?php echo $product['name'] ?>" />
                                                            </a>
                                                            <?php if ($product['url_to']) { ?>
                                                                <div class="box-video">
                                                                    <iframe width="100%" style="height: 100%; max-height:500px" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <?php if ($images && count($images)) { ?>
                                                            <div class="thumb-img">
                                                                <div id="owl-details" class="owl-carousel owl-theme">
                                                                    <?php if ($product['url_to']) {
                                                                        $src_v = ClaHost::getImageHost() . $product['avatar_path'] . 's100_100/' . $product['avatar_name'];
                                                                    ?>
                                                                        <a class="open-video" data="<?= $product['url_to'] ?>">
                                                                            <img src="<?= $src_v ?>" atl="<?= $product['name'] ?>">
                                                                            <img src="<?= $themUrl ?>/images/youtube.png" atl="<?= $product['name'] ?>" class="img_ytb">
                                                                        </a>
                                                                    <?php } ?>
                                                                    <a class="open-image" data-zoom-id="magiczoommain<?php echo $color_code ?>" href="<?php echo ClaHost::getImageHost(), $first['path'], $first['name'] ?>" data-image="<?php echo ClaHost::getImageHost(), $first['path'], 's500_500/', $first['name'] ?>"><img src="<?php echo ClaHost::getImageHost(), $first['path'], 's50_50/', $first['name'] ?>" alt="<?php echo $product['name'] ?>" /></a>
                                                                    <?php foreach ($images as $img) { ?>
                                                                        <a class="open-image" data-zoom-id="magiczoommain<?php echo $color_code ?>" href="<?php echo ClaHost::getImageHost(), $img['path'], $img['name'] ?>" data-image="<?php echo ClaHost::getImageHost(), $img['path'], 's500_500/', $img['name'] ?>"><img src="<?php echo ClaHost::getImageHost(), $img['path'], 's50_50/', $img['name'] ?>" alt="<?php echo $product['name'] ?>" /></a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <style>
                                                        .big-img {
                                                            position: relative;
                                                        }

                                                        .box-video {
                                                            position: absolute;
                                                            width: 100%;
                                                            height: 100%;
                                                            left: 0px;
                                                            top: 0px;
                                                            max-height: 533px;
                                                            z-index: -1;
                                                        }

                                                        .open-video {
                                                            float: left;
                                                            width: 100%;
                                                            background: #33333352;
                                                            cursor: pointer;
                                                            border-left: 1px solid #fff;
                                                        }

                                                        .open-video img {
                                                            max-width: 100%;
                                                            margin: 0 auto !important;
                                                            height: 100%;
                                                        }

                                                        .open-video img.img_ytb {
                                                            position: absolute;
                                                            top: 15px;
                                                            width: 30px;
                                                            height: auto;
                                                            bottom: 0;
                                                            left: 0;
                                                            right: 0;
                                                        }
                                                    </style>
                                                    <script>
                                                        $('.open-video').click(function() {
                                                            $('.MagicZoom').css('z-index', '-1');
                                                            $('.box-video').css('z-index', '1');
                                                            if ($('.box-video').find('iframe').attr('src') != $(this).attr('data')) {
                                                                $('.box-video').find('iframe').attr('src', $(this).attr('data'));
                                                            }
                                                        });
                                                        $('.open-image').click(function() {
                                                            $('.MagicZoom').css('z-index', '1');
                                                            $('.box-video').css('z-index', '-1');
                                                            $('.box-video').find('iframe').attr('src', '');
                                                        })
                                                    </script>
                                                    <div class="icon_pro_view">
                                                        <ul>
                                                            <?php if (count($options_360)) {
                                                            ?>
                                                                <li><a class="cur" data-toggle="modal" data-target="#modal_360"><img src="<?= $themUrl ?>/images/5.png" width="37" height="32">
                                                                        <span>Ảnh 360 độ</span></a></li>
                                                            <?php } ?>
                                                            <?php if (count($videos)) { ?>
                                                                <li><a class="cur scroll" href="#video_sp"><img src="<?= $themUrl ?>/images/6.png" width="37" height="32">
                                                                        <span>Video</span></a></li>
                                                            <?php } ?>
                                                            <li><a class="cur scroll" href="#hinhanh_sp"><img src="<?= $themUrl ?>/images/7.png" width="37" height="32">
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
                                                                        <div class="image360">
                                                                            <div class="cont">

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
                                                                                                imagePath: imagePath + 's800_800/', // path of the image assets
                                                                                                filePrefix: filePrefix, // file prefix if any
                                                                                                ext: ext, // extention for the assets
                                                                                                height: 570,
                                                                                                // width: 790,
                                                                                                navigation: true,
                                                                                                playSpeed: (6000 / count),
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
                                                                                                imagePath: '<?php echo $imagePath ?>' + '/s800_800/', // path of the image assets
                                                                                                filePrefix: '<?php echo $filePrefix ?>', // file prefix if any
                                                                                                ext: '<?php echo $ext; ?>', // extention for the assets
                                                                                                height: 570,
                                                                                                // width: 790,
                                                                                                navigation: true,
                                                                                                playSpeed: (6000 / <?php echo $count ?>),
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End - Hình ảnh-->
                        </div>
                        <!-- doãn sửa ngày 1_8_2017 theo yêu cầu khách -->
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 box-info-detail clearfix">
                    <div class="general-information product-detail-info" id="product-detail-info">

                        <div class="price-detail" style="padding: 10px 0;border-top: 1px solid rgba(195, 195, 195, .5);border-bottom: 1px solid rgba(195, 195, 195, .5);">
                            <!-- giá -->
                            <label class="price-attr"><?= ($product['price'] > 0) ?  number_format($product['price']) : "Liên hệ"; ?></label>
                            <sup class="sub_"><?= ($product['price'] > 0) ?  'đ' : ""; ?></sup>
                            <?php if ($product['price_market'] > 0) { ?>
                                <span class="market_" style="text-decoration: line-through;"><?php echo number_format($product['price_market']); ?>đ</span>
                            <?php } ?>
                            <span style="    padding: 3px 10px;background: #f68706;color: #fff;border-radius: 20px;line-height: 7px;">trả góp 0%</span>
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
                        </div>

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
                                                    $('.price-detail .price-attr').html(dataprice);
                                                    $('.sub_').html('đ');
                                                } else {
                                                    $('.price-detail .price-attr').html('Liên hệ');
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


                        <p class="rate-star">
                            <span class="star">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </span>
                            <span class="rate">

                                <?= $product['total_votes'] ?>
                                <span>
                                    lượt đánh giá
                                </span>
                            </span>
                        </p>
                        <?php if ($product['color']) {
                        ?>
                            <p class="color-product">
                                <span class="title">
                                    Màu sắc
                                </span>
                                <span class="group-color">
                                    <?php

                                    $color_str = explode(",", $product['color']);
                                    foreach ($color_str as $color) { ?>
                                        <a href="javascript:void(0)">
                                            <?= $color ?>
                                        </a>
                                    <?php } ?>

                                </span>
                            </p>
                        <?php } ?>
                        <?php switch ($product["state"]) {
                            case true:
                        ?>
                                <p class="amount-product">
                                    <span class="title">
                                        Số lượng
                                    </span>
                                    <td data-th="Quantity">
                                        <input id="qty" name="quantity" type="number" class="form-control text-center" value="1">
                                    </td>
                                </p>

                        <?php
                                break;
                        } ?>

                        <?php if ($product['price_market'] && $product['price_market'] > 0) { ?>
                            <!-- <p class="old-price-detail">Giá chưa khuyến mại:
                                <span> <?php echo number_format($product['price_market'], 0, '', '.'); ?>
                                <sup>đ</sup></span></p> -->
                        <?php } ?>


                        <div class="box-option">
                            <div class="option-color">
                                <!-- doãn sửa ngày 1_8_2017 theo yêu cầu khách -->


                            </div>
                        </div>
                        <!--End-->
                        <!-- Khuyến mãi start -->
                        <?php
                        $product_id = $product['id'];
                        $list_rel_products = ProductRelation::getProductIdInRel($product_id);
                        if (!empty($list_rel_products)) {
                        ?>
                            <div class="box-km-detail">
                                <div class="title-km-detail">
                                    <h2>Khuyến mại</h2>
                                </div>
                                <div class="cont">
                                    <ul>
                                        <?php
                                        foreach ($list_rel_products as $product_rel) :
                                            $productModel = Product::model()->findByPk($product_rel);
                                            $category_id = $productModel->product_category_id;
                                            if ($productModel && $category_id == 39181) :

                                                $productName = $productModel->name;
                                                echo "<li> $productName </li>";
                                            endif;
                                        endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                        <?php
                        }
                        //  Khuyến mãi end
                        
                        $promotion = $model->getPromotion();
                        if ($promotion && count($promotion)) {
                        ?>
                            <div class="description-detail">
                                <div class="title-km-support">
                                    <h2>Chính sách Hỗ Trợ</h2>
                                </div>
                                <ul>
                                    <?php
                                    $ps = array();
                                    $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $promotion['description'], $matches);
                                    ?>
                                    <?php foreach ($matches[0] as $camket) { ?>
                                        <li class="check-icon">
                                            <span><?php echo $camket ?></span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php }
                        ?>
                        <div class="description-detail">
                            <p>Tình trạng: <strong class="<?= $product['state'] ? 'green' : 'red' ?>"><?= $product['state'] ? 'Còn hàng' : 'Tạm hết hàng' ?></strong></p>
                        </div>
                        <div class="group-link-detail">
                            <?php switch ($product["state"]) {
                                case false: ?>
                                    <a href="<?php echo Yii::app()->createUrl('/site/site/contact'); ?>" title="Liên hệ" class="box-action buy-now ">
                                        Liên hệ
                                        <span> (Liên hệ ngay để nhận thông tin mới nhất về mặt hàng) </span>
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

                </div>
            </div>
        </div>
        <div class="cont-detail-product clearfix">

            <!-- End - Thông số kỹ thuật-->

            <!-- Hình ảnh 360-->
            <div class="box-widget2 noscroll">
                <div class="col-right 22">
                    <div class="parameter">
                        <?php if ($attributesShow && count($attributesShow)) {
                        ?>
                            <h2 class="title-ts in">Thông số kỹ thuật</h2>
                            <div class="cont cont-ts">
                                <div class="thongso">
                                    <ul class="parametdesc">
                                        <?php
                                        $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($model, $attributesShow);
                                        $dem1 = 0;
                                        $dem2 = 0;
                                        foreach ($attributesDynamic as $key => $item) {
                                            if ($dem1 < 13) {
                                                if (is_array($item['value']) && count($item['value'])) {
                                                    $item['value'] = implode(", ", $item['value']);
                                                }
                                                if ($item['value']) {
                                                    echo '<li><span>' . $item['name'] . '</span><strong>' . $item["value"] . '</strong></li>';
                                                    $dem1++;
                                                }
                                            } else {
                                                if (is_array($item['value']) && count($item['value'])) {
                                                    $item['value'] = implode(", ", $item['value']);
                                                }
                                                if ($item['value']) {
                                                    echo '<li class="thongso-item hidden"><span>' . $item['name'] . '</span><strong>' . $item["value"] . '</strong></li>';
                                                    $dem2++;
                                                }
                                            }
                                        }
                                        if ($dem2 > 0) { ?>
                                            <div class="showall"><a href="javascript:void"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                                            </div>
                                        <?php
                                            $dem1 = 0;
                                            $dem2 = 0;
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (isset($news_rel) && count($news_rel)) {
                    ?>
                        <div class="news-manual">
                            <h2 class="title-ss">Tin liên quan</h2>
                            <div class="cont cont-ss">
                                <?php
                                $i = 0;
                                foreach ($news_rel as $rel) {
                                    ++$i;
                                    if ($i >= 1 && $i <= 5) {
                                ?>
                                        <div class="item-compare clearfix">
                                            <div class="box-img img-item-compare">
                                                <a href="<?php echo $rel['link']; ?>" title="<?php echo $rel['news_title']; ?>">
                                                    <img alt="<?php echo $rel['news_title']; ?>" src="<?php echo ClaHost::getImageHost() . $rel['image_path'] . 's300_300/' . $rel['image_name'] ?>" />
                                                </a>
                                            </div>
                                            <div class="box-info">
                                                <div class="top-info clearfix">
                                                    <h3 class="title-product">
                                                        <a href="<?php echo $rel['link']; ?>" title="<?php echo $rel['news_title']; ?>"><?php echo $rel['news_title']; ?></a>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                                <a class="view-more-manual" title="" href="<?php echo Yii::app()->createUrl('/news/news/groupnewsrelation', array('id' => $product['id'])); ?>">
                                    Xem thêm tất cả tin liên quan
                                </a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (isset($news_manual) && count($news_manual)) {
                    ?>
                        <div class="news-manual">
                            <h2 class="title-ss">Hướng dẫn sử dụng</h2>
                            <div class="cont cont-ss">
                                <?php
                                $i = 0;
                                foreach ($news_manual as $rel) {
                                    ++$i;
                                    if ($i >= 1 && $i <= 5) {
                                ?>
                                        <div class="item-compare clearfix">
                                            <div class="box-img img-item-compare">
                                                <a href="<?php echo $rel['link']; ?>" title="<?php echo $rel['news_title']; ?>">
                                                    <img alt="<?php echo $rel['news_title']; ?>" src="<?php echo ClaHost::getImageHost() . $rel['image_path'] . 's300_300/' . $rel['image_name'] ?>" />
                                                </a>
                                            </div>
                                            <div class="box-info">
                                                <div class="top-info clearfix">
                                                    <h3 class="title-product">
                                                        <a href="<?php echo $rel['link']; ?>" title="<?php echo $rel['news_title']; ?>"><?php echo $rel['news_title']; ?></a>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                                <a class="view-more-manual" title="" href="<?php echo Yii::app()->createUrl('/news/news/groupnewsrelation', array('id' => $product['id'])); ?>">
                                    Xem thêm tất cả tin liên quan
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($products_rel && $news_manual) { ?>
                        <div class="modules_sanpham">
                            <div class="">
                                <h2>Phụ kiện mua cùng</h2>
                                <div class="slider_modules">
                                    <?php foreach ($products_rel as $products_r) { ?>
                                        <div class="item_products">
                                            <div class="img">
                                                <a href="<?= $products_r['link'] ?>" title="<?= $products_r['name'] ?>">
                                                    <img src="<?php echo ClaHost::getImageHost() . $products_r['avatar_path'] . 's100_100/' . $products_r['avatar_name'] ?>">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h3><a href="<?= $products_r['link'] ?>" title="<?= $products_r['name'] ?>"><?= $products_r['name'] ?></a>
                                                </h3>
                                                <p class="price">
                                                    <?php if ($products_r['price'] > 0) { ?>
                                                        <?= number_format($products_r['price']) ?> đ
                                                    <?php } else { ?>
                                                        Liên hệ
                                                    <?php } ?>
                                                </p>
                                                <p><?= $products_r['product_sortdesc'] ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-left">

                    <?php

                    if (isset($videos) && count($videos)) {
                    ?>
                        <div class="widget-product-detail">
                            <div class="video-detail" id="video_sp">
                                <div class="cont clearfix">
                                    <h2 class="title-box-2">Video xe
                                        - <?php echo $product['code']; ?></h2>
                                    <div class="box-videos">
                                        <div class="slider_video owl-carousel owl-theme owl-loaded owl-drag">
                                            <?php
                                            $i = 0;
                                            foreach ($videos as $video) {
                                                ++$i;
                                                $src1 = ClaHost::getImageHost() . $video['avatar_path'] . 's800_800/' . $video['avatar_name'];
                                            ?>

                                                <?php Yii::app()->controller->renderPartial('//layouts/img_youtube', array('height' => '525', 'src' => $src1, 'link_vd' => $video['video_embed'], 'title' => $video['video_title'])); ?>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $('.slider_video').owlCarousel({
                                    items: 1,
                                    margin: 0,
                                    nav: true,
                                    dots: true,
                                    autoplay: false,
                                    lazyLoad: true,
                                    autoplayTimeout: 4000,
                                    smartSpeed: 1000,
                                    loop: true,
                                });
                                var hei_box_menu = $(".header_v2").height();
                                $(".scroll").click(function(event) {
                                    event.preventDefault();
                                    $('html,body').animate({
                                        scrollTop: $(this.hash).offset().top - hei_box_menu + 100
                                    }, 1000);
                                });

                                function changeVideo(thistag) {
                                    $('.list-videos ul li').removeClass('active');
                                    $(thistag).parent().addClass('active');
                                    var embed = $(thistag).attr('name') + '?autohide=1';
                                    $('.box-videos iframe').attr('src', embed)
                                }
                            </script>

                        </div>
                    <?php } ?>
                    <div class="left-height" id="hinhanh_sp">
                        <div class="widget-product-detail abcfix" style="position: relative; max-height: 560px;overflow: hidden;float: left;width: 100%;">
                            <h2>Mô tả chi tiết</h2>
                            <?php echo $product['product_desc']; ?>
                            <span class="seemore-detail" style="">Đọc thêm <i class="fa fa-caret-down"></i></span>
                        </div>
                        <script>
                            $(function() {
                                $('.seemore-detail').on('click', function(e) {
                                    e.preventDefault();
                                    $('.widget-product-detail').css('max-height', 'unset');
                                    $(this).fadeOut();
                                })
                            })
                        </script>
                    </div>

                    <div class="while_buy actions_article clearfix">
                        <div class="ginfo">
                            <img src="<?php echo ClaHost::getImageHost(), $first['path'], 's80_80/', $first['name'] ?>" alt="<?php echo $product['name'] ?>" />
                            <h3><?= $product['name'] ?></h3>
                            <strong><span class="amount-custom">Giá: <a href="<?= Yii::app()->createUrl('site/site/contact') ?>" id="contact-product"><?= ($product['price'] > 0) ? number_format($product['price']) : 'Liên hệ'; ?></a></span></strong>
                        </div>
                        <div class="gbutton">
                            <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>" class="woocommerce_buy_now woocommerce_buy_now_style btn-tragop">
                                <strong>Mua ngay</strong>
                            </a>
                            <a href="<?= Yii::app()->createUrl('installment/installment/index', ['id' => $product['id']]) ?>" class="woocommerce_buy_now woocommerce_buy_now_style">
                                <strong>Mua trả góp 0%</strong>
                            </a>
                            <a href="<?= Yii::app()->createUrl('installment/installment/checkoutPay', ['id' => $product['id']]) ?>" class="woocommerce_buy_now woocommerce_buy_now_style">
                                <strong>Trả góp qua thẻ</strong>
                            </a>
                        </div>
                    </div>
                    <div class="product-compare">
                        <div class="">
                            <div class="compare">
                                <h2 class="title-ss"> Các xe tương tự </h2>
                                <div class="cont cont-ss">
                                    <?php
                                    /**
                                     * Sản phẩm so sánh
                                     */
                                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK3));
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>


                    <?php
                    /**
                     * Comment Ratings
                     */
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_COMMENT1));
                    ?>

                    <div id="comment-panel">
                        <?php
                        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK1));
                        ?>
                    </div>

                </div>
            </div>
            <!--end-->
            <div class="box-widget6 ">
                <div class="col-left left-height">
                    <div class="widget-product-detail">
                        <?php
                        /*Ắc quy chính hãng*/
                        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK6));
                        ?>


                        <div id="shop_store_location">
                            <?php
                            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK5));
                            ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--js-->


<script>
    jQuery(document).ready(function() {
        $('.menu-active-product-detail').css("top", 160 + 'px');
        var pos_head = $('#header').height();
        var pos_top = $('.page-detail-product .top-detail-product').height() + 50;
        var pos_mid = $('.center-page-product-detail .description-detail').height();
        var pos_bot = $('.video-detail').height();
        var evaluate_height = $('.center-page-product-detail .evaluate').height();
        var image_height = $('.widget-product-detail').height();
        var banner_bottom = $('#owl-demo-banner').height();

        $(window).scroll(function(event) {
            var scroll = $(window).scrollTop();
            if (scroll < (pos_head + pos_top)) {
                $('.menu-active-product-detail ul li').removeClass('active');
                $('.menu-active-product-detail ul li.mn-mt').addClass('active');
            } else if (scroll < (pos_head + pos_top + pos_mid + pos_bot)) {
                $('.menu-active-product-detail ul li').removeClass('active');
                $('.menu-active-product-detail ul li.mn-pic').addClass('active');
            } else {
                $('.menu-active-product-detail ul li').removeClass('active');
                $('.menu-active-product-detail ul li.mn-cmt').addClass('active');
            }
            if (scroll <= (pos_head + pos_top + pos_bot + evaluate_height + image_height + 200) || scroll >= (pos_head + pos_top + pos_mid + image_height - banner_bottom)) {
                $('#fixed_pos_info').removeClass('fixed');
            } else {
                $('#fixed_pos_info').addClass('fixed');
            }
            $('.menu-active-product-detail').css("top", (scroll + 130) + 'px');
        });
        $(document).on('click', '.searchbychar', function(event) {
            event.preventDefault();
            var target = "." + this.getAttribute('data-target');
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 800);
        });
        //        var content = $('.center-page-product-detail').offset().top
        //        );
    });
</script>


<script src="<?php echo $themUrl ?>/js/home/js/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
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
            arrow: false,
            focusOnSelect: true,
            responsive: [{
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
        $("#accessories-panel .content").slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 8,
            slidesToScroll: 8,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 6,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                }
            ]
        });
    });
</script>

<style type="text/css">
    .price-detail a {
        font-size: 24px;
        color: #fe0000;
        font-weight: bold;
        margin-bottom: 5px;
    }

    #accessories-panel {
        position: relative;
        border-left: solid 1px;
        border-color: #e6e5e5;
    }

    .bottom-title {
        width: 100%;
        height: 78px;
        padding-top: 25px;
        background-color: #e6e5e5;
    }

    #accessories-panel .title::before {
        content: "";
        position: absolute;
        left: 0;
        width: 100%;
        height: 2px;
        background: #e6e5e5;
        display: block;
        color: #e6e5e5;

    }

    #accessories-panel .title {

        margin: 0px;
        border: 0px;
        font-size: 35px;
    }

    #accessories-panel .accessories-item .name {
        padding-left: 20px;
        height: 75px;
    }

    #accessories-panel .accessories-item .price {
        padding-left: 20px;
        font-size: 12px;
        margin-top: 20px;
    }

    #accessories-panel .accessories-item {
        margin-bottom: 15px
    }

    .accessories-item {
        float: left;
        width: 20%;
    }

    div#shop_store_location {
        clear: both;
    }

    #accessories-panel .content .slick-slide img {
        height: 95px;
        margin-top: 10px;
    }

    @media (min-width: 1200px) {
        .page-detail-product .top-detail-product .cont-top-product-detail {
            position: relative;
        }

        .page-detail-product .cont-top-product-detail .col-left-detail {
            margin-bottom: 110px;
        }

        .col-lg-6.col-md-12.box-info-detail.clearfix {
            position: absolute;
            top: 0;
            right: -140px;
        }

        #owl-details {
            margin: 0 -15px;
            width: calc(100% + 30px);
        }
    }

    .showall {
        text-align: center;
        margin-top: 25px;
    }

    .hidden {
        display: none;
    }

    .showall a {
        color: #09090a;
        font-size: 20px;
        font-weight: 900;
    }

    .price-detail::before,
    .price-detail::after {
        content: "";
        position: absolute;
        left: 0px;
        width: 100%;
        top: 0px;
        background: #afadad;
        height: 1px;

    }

    .price-detail::after {
        content: "";
        position: absolute;
        left: 0px;
        top: auto;
        bottom: 0;
        width: 100%;
        height: 1px;
        background: #afadad;
    }

    .price-detail {
        border: 0 !important;
        position: relative;
    }

    body {
        overflow-x: hidden;
    }

    a.category_item {
        border-radius: 30%;
        padding: 12px 7px;
        margin-left: 8px;
        background: white;
        color: black;
    }

    .addres_shop .item_address:first-child {
        overflow-y: scroll;
        height: 659px;
    }

    .avatar-name-fword img,
    .user-cmt-avat img {
        margin: 0 !important;
    }

    #modal_360 {
        padding: 0;
        margin: 0;
    }

    #modal_360 .close {
        outline: none;
        width: 30px;
        height: 30px;
        right: 30px;
        top: 30px;
        line-height: 0;
        background: #000;
        color: #fff;
        padding: 0;
        font-size: 22px;
        border-radius: 100%;
        padding-bottom: 8px;
        z-index: 9999;
    }

    #modal_360 .image360 {
        max-width: 950px;
        margin: 0 auto;
    }

    #modal_360 .widget-product-detail .cont-360 .threesixty {
        height: 80vh !important;
    }

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
        margin: 0 10px;
        border-radius: 4px;
        border: solid #CCC 1px;
        padding: 5px 0;
        line-height: 0;
        width: 23%;
        padding-top: 10px;
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

    .price-detail .economical {
        font-size: 15px;
    }

    .price-detail .economical span {
        color: #333;
    }

    .product-detail-info .product-info-conf .product-info-conf-list .product-info-conf-item a {
        display: grid;
        align-content: space-between;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        if (screen.width > 992) {
            // console.log($(".box-widget5 .col-right").height());
            $(".box-widget5 .widget-product-detail").css("max-height", $(".box-widget5 .col-right").height());
        }

        $('.addtocart').click(function() {
            var contact = $('.price-detail .price-attr').html();
            if (contact == 'Liên hệ') {
                window.location.href = "<?php echo Yii::app()->createUrl('/site/site/contact') ?>";
            }
            qty = parseInt($('#qty').val());
            if (qty > 0) {
                $(this).attr('href', '<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'], 'qty' => '')); ?>/' + qty);
            }
        });
        $(".showall").click(function() {
            $(this).addClass("hidden");
            $("li.hidden").each(function() {
                $(this).removeClass("hidden");
            })
        })
    });
</script>