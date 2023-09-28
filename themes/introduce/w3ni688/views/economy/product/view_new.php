<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<?php $url = Yii::app()->baseUrl . Yii::app()->createAbsoluteUrl('economy/product/category', array('id' => $category['cat_id'], 'alias' => $category['alias']));
$child_category = new ClaCategory();
$child_category->type = ClaCategory::CATEGORY_PRODUCT;
$child_category->generateCategory();
$category_child = $child_category->createArrayCategory($category['cat_id']);
$get_cat = $_GET['cat_multi'];
$cat_multi = [];
if (isset($get_cat)) {
    $cat_multi = explode(',',$get_cat);
}
?>

<div class="left_conten left_conten_tkiem">
    <h2>Tìm kiếm nhanh</h2>
    <div class="box_left">
        <div class="check_id">
            <h3>Xe ga 50cc</h3>
            <ul>
                <?php foreach ($category_child as $child) {
                    ?>
                    <label class="container"><?=$child['cat_name']?>
                        <input type="checkbox" class="tnn_pri_dm" value="<?=$child['cat_id']?>" <?=(in_array($child['cat_id'],$cat_multi)) ? 'checked' : ''?>>
                        <span class="checkmark"></span>
                    </label>
                <?php } ?>

            </ul>
        </div>
        <input class="category-multi-select" type="hidden" value="">
        <div class="check_id">
            <h3>Giá tiền</h3>
            <ul>
                <label class="container">Dưới 8 triệu <input type="checkbox" class="tnn_pri" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Dưới 10 triệu <input type="checkbox" class="tnn_pri" value="2">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Dưới 12 triệu <input type="checkbox" class="tnn_pri" value="3">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Trên 12 triệu <input type="checkbox" class="tnn_pri" value="4">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Trên 14 triệu <input type="checkbox" class="tnn_pri" value="5">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Trên 16 triệu <input type="checkbox" class="tnn_pri" value="6">
                    <span class="checkmark"></span>
                </label>
            </ul>
        </div>
    </div>
</div>
<script>
    $('..box_left .container').click(function () {
        var manuId = [];
        $('..box_left .container').each(function () {
            if ($(this).children('input').is(':checked')) {
                manuId.push($(this).children('input').val());
            }
        });
        if (manuId.length >= 1) {
            insertParam('manu_id', manuId.join());
        } else {
            var url = location.href;
            url = removeParam('manu_id', url);
            location.href = url;
        }
    });
</script>
<div class="right_conten right_conten_ajax">
    <div class="filter-product filter-product-1 clearfix">
        <div class="box-filter">
            <div class="price-in">
                <?php
                $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK1));
                ?>
            </div>
        </div>
        <div class="search-much">
            <div class="title-box-product clearfix">
                <h2>
                    <?php echo $category['cat_name']; ?><span>(<?= $totalitem ?> sản phẩm)</span>
                </h2>
            </div>
        </div>
    </div>
    <div class="cont-main sonfix">
        <?php if (count($products)) { ?>
        <div class="bike-product">
            <div class="">
                <?php
                foreach ($products

                as $product) {
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
                $src = ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'];
                ?>
                <div class="col-xs-4">
                    <div class="box-product item-search">
                        <?php if (!$product['state']) { ?>
                            <span class="hethang"> Tạm hết hàng</span>
                        <?php } ?>
                        <div class="box-img img-product">
                            <?php if ($product['avatar_path'] && $product['avatar_name']) { ?>
                                <a href="<?php echo $product['link'] ?>"
                                   title="<?php echo $product['name'] ?>">
                                    <?php Yii::app()->controller->renderPartial('//layouts/img_lazy', array('src' => $src, 'class' => '', 'title' => $product['name'])); ?>
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
                            <h4><a href="<?php echo $product['link'] ?>"
                                   title="<?php echo $product['name'] ?>"><?php echo $product['name']; ?></a></h4>
                            <?php if ($product['price'] && $product['price'] > 0 && $product['state'] != 0) { ?>
                                <?php // if ($product['price_market'] && $product['price_market'] > 0) {  ?>
                                <p class="old-price"><?php echo ($product['price_market'] != 0) ? $product['price_market_text'] : ''; ?></p>
                                <?php // }  ?>
                                <p class="price_new_search"><?php echo $product['price_text']; ?></p>
                            <?php } else { ?>
                                <?php

                                $site_info = Yii::app()->siteinfo;
                                $phone = explode(',', $site_info['phone']);
                                $phone0 = isset($phone[0]) ? $phone[0] : '';
                                $phone1 = isset($phone[1]) ? $phone[1] : '';
                                ?>
                                <p class="price-detail">Liên hệ : <a href="tel:<?= $phone0 ?>">
                                        <?php
                                        $pos = 1;
                                        while ($pos) {
                                            $pos = strrpos($phone0, ".");
                                            if ($pos) {
                                                $phone0 = substr_replace($phone0, '', $pos, 1);
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
                        <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua
                            ngay</a>
                        <a href="<?= Yii::app()->createUrl('installment/installment/index', ['id' => $product['id']]) ?>">Mua
                            trả góp</a>
                    </div>
                    <div class="box-km-detail clearfix">
                        <?php if (isset($product['product_sortdesc']) && $product['product_sortdesc'] != "") { ?>
                        <div class="cont boder">
                            <div class="title-km-detail">
                                <span class="gift-icon"></span>
                                <h2>Quà tặng</h2>
                            </div>
                            <?php } else{ ?>
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
            .box-km-detail {
                border: none !important;
            }

            .left_conten h2 {
                color: #d0011b;
                font-weight: 500;
                font-size: 25px;
                line-height: 30px;
                text-transform: capitalize;
                padding-bottom: 5px;
            }

            .box_right_pro_view.box_right_pro_view_sp {
                margin-bottom: 0;
                box-shadow: none;
            }

            .box_right_pro_view.box_right_pro_view_sp .title_right_pro_view {
                padding: 10px 0;
                line-height: 30px;
            }

            .box_right_pro_view.box_right_pro_view_sp ul {
                margin: 10px 0;
            }

            .box_right_pro_view.box_right_pro_view_sp ul:last-child {
                border: none
            }

            .dv-xrm-tatca a {
                display: inline-block;
                margin-top: 15px;
                height: 30px;
                text-transform: uppercase;
                color: #fff;
                padding: 3px 15px;
                font-size: 15px;
                background: #00af51;
                float: right
            }

            .right_conten {
                float: right;
                width: calc(75% - 15px);
                box-shadow: 0px 1px 1px rgb(0 0 0 / 20%);
                background: #fff;
                padding: 15px;
            }

            .left_conten {
                float: left;
                width: 25%;
                box-shadow: 0px 1px 1px rgb(0 0 0 / 20%);
                background: #fff;
                padding: 15px;
            }

            .check_id {
                border-bottom: solid #CCC 1px;
                margin-bottom: 20px;
            }

            .check_id h3 {
                color: #333333;
                font-weight: normal;
                font-size: 21px;
                text-transform: uppercase;
                position: relative;
                border-bottom: solid #CCC 1px;
                padding-bottom: 10px;
                margin-bottom: 20px;
                margin-top: 10px;
            }

            .box_left .container {
                display: block;
                position: relative;
                margin-bottom: 17px;
                cursor: pointer;
                font-size: 16px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                line-height: 17px;
                text-transform: capitalize;
                color: #666;
                padding-left: 30px;
                font-weight: 500;
            }

            .box_left .container input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
            }

            .checkmark {
                position: absolute;
                top: 0;
                left: 0;
                height: 19px;
                width: 19px;
                background-color: #f9f9f9;
                border: 1px #ccc solid;
            }

            .box_left .container span {
                color: #999;
                padding-left: 5px;
            }

            .box_left .container input:checked ~ .checkmark {
                background-color: #333333;
                border: 1px #333333 solid;
            }

            .checkmark:after {
                content: "";
                position: absolute;
                display: none;
            }

            .box_left .container .checkmark:after {
                left: 6px;
                top: 2px;
                width: 5px;
                height: 10px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(
                        45deg
                );
                -ms-transform: rotate(45deg);
                transform: rotate(
                        45deg
                );
            }

            .box_left .container input:checked ~ .checkmark:after {
                display: block;
            }

            .product-category-v2 {
                background: #f3f3f3;
            }

            .cont-main .box-product.item-search {
                height: 315px;
            }

            ul.W3NPager {
                float: left;
                width: 100%;
            }

            .filter-product {
                margin-bottom: 0;
                border-bottom: solid #CCC 1px;
            }

            .price-in select {
                display: block;
                width: 100%;
                height: 40px;
                padding: 5px 12px;
                font-size: 15px;
                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
                box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
                -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                resize: vertical;
                box-sizing: border-box;
                margin-bottom: 10px;
                outline: none;
            }

            .title-box-product h2 {
                padding-top: 0;
                margin-bottom: 0;
                margin-top: 6px;
                font-size: 25px;
                color: #444;
            }

            .title-box-product h2 span {
                font-size: 16px;
                font-weight: 500;
                text-transform: initial;
            }

            #main {
                background: #f3f3f3;
            }
        </style>
    </div>

    <script>
        var tnn_pri_dm = "";
        $(".check_id input.tnn_pri_dm").each(function () {
            if ($(this).is(":checked")) {
                tnn_pri_dm += tnn_pri_dm == "" ? $(this).val() : "," + $(this).val();
            }
            console.log(tnn_pri_dm);
        });
        var url = "<?=$url?>";
        $(document).ready(function () {
            $checks = $(".check_id input.tnn_pri_dm");
            $checks.on('change', function () {
                var string = $checks.filter(":checked").map(function (i, v) {
                    return this.value;
                }).get().join(",");
                $('.category-multi-select').val(string);
                window.location.href = url + "?cat_multi=" + $('.category-multi-select').val();
            });
        });

    </script>