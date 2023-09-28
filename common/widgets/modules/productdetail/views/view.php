<?php
if (isset($product) && $product) {
    // get configurable 
    $configurableFilter = AttributeHelper::helper()->getConfiguableValuesActive($category['attribute_set_id'], $product);
    ?>
    <div class="order-product-index">
        <h2 class="title-standard">Đặt hàng</h2>
        <div class="container">
            <div class="box-order-product">
                <div class="img-product-order">
                    <div class="big-img-order">
                        <div class="preview col">
                            <?php
                            $images_color = ProductImagesColor::getImagesProductColor($product['id']);
                            $data_images_color = array();
                            if (isset($images_color) && count($images_color)) {
                                foreach ($images_color as $img_cl) {
                                    $data_images_color[$img_cl['color_code']][] = $img_cl;
                                }
                            }
                            ?>
                            <?php
                            if (count($data_images_color)) {
                                foreach ($data_images_color as $color_code => $imgcolors) {
                                    ?>
                                    <div class="app-figure" id="zoom-fig-<?php echo $color_code ?>" style="display: none">
                                        <?php
                                        $first = reset($imgcolors);
                                        ?>
                                        <div class="big-box-img">
                                            <a id="Zoom-<?php echo $color_code ?>" class="MagicZoom" title="<?= $product['name'] ?>" href="<?= ClaHost::getImageHost(), $first['path'], $first['name'] ?>">
                                                <img src="<?= ClaHost::getImageHost(), $first['path'], 's450_450/', $first['name'] ?>" />
                                            </a>
                                        </div>
                                        <div class="selectors thumb-img-order">
                                            <?php foreach ($imgcolors as $img) { ?>
                                                <a data-zoom-id="Zoom-<?php echo $color_code ?>" href="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>" data-image="<?= ClaHost::getImageHost(), $img['path'], 's450_450/', $img['name'] ?>">
                                                    <img srcset="<?= ClaHost::getImageHost(), $img['path'], 's450_450/', $img['name'] ?>" src="<?= ClaHost::getImageHost(), $img['path'], 's100_100/', $img['name'] ?>"/>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="app-figure" id="zoom-fig">
                                <?php
                                // get images
                                $images = $product->getImages();
                                $first = reset($images);
                                ?>
                                <div class="big-box-img">
                                    <a id="Zoom-1" class="MagicZoom" title="<?= $product['name'] ?>" href="<?= ClaHost::getImageHost(), $first['path'], $first['name'] ?>">
                                        <img src="<?= ClaHost::getImageHost(), $first['path'], 's450_450/', $first['name'] ?>" />
                                    </a>
                                </div>
                                <div class="selectors thumb-img-order">
                                    <?php foreach ($images as $img) { ?>
                                        <a data-zoom-id="Zoom-1" href="<?= ClaHost::getImageHost(), $img['path'], $img['name'] ?>" data-image="<?= ClaHost::getImageHost(), $img['path'], 's450_450/', $img['name'] ?>">
                                            <img srcset="<?= ClaHost::getImageHost(), $img['path'], 's450_450/', $img['name'] ?>" src="<?= ClaHost::getImageHost(), $img['path'], 's100_100/', $img['name'] ?>"/>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="infor-product-order">
                    <div class="title-product-order">
                        <h2>
                            <a href="javascript:void(0)" title="<?= $product['name'] ?>">
                                <?= $product['name'] ?>
                            </a>
                        </h2>
                    </div>
                    <!--                    <div class="rating-star">
                                            <a href=""><i class="fa fa-star"></i></a>
                                            <a href=""><i class="fa fa-star"></i></a>
                                            <a href=""><i class="fa fa-star"></i></a>
                                            <a href=""><i class="fa fa-star"></i></a>
                                            <a href=""><i class="fa fa-star-o"></i></a>
                                            <span> 7 đánh giá</span>
                                        </div>-->
                    <?php
                    $product_prices = ProductWholesalePrice::getWholesalePriceByProductid($product['id']);
                    $minQuantity = 1;
                    if ($product_prices) {
                        $firstPriceRange = reset($product_prices);
                        if ($firstPriceRange && isset($firstPriceRange['quantity_to'])) {
                            $minQuantity = $firstPriceRange['quantity_from'];
                        }
                    }
                    if (isset($product_prices) && $product_prices) {
                        ?>
                        <div class="sell-with-amount">
                            <?php
                            $i = 0;
                            foreach ($product_prices as $pr) {
                                $i++;
                                ?>
                                <div class="step-<?= $product['price'] - $pr['price'] ?> item-sell-amount <?= $i == 1 ? 'active' : '' ?>">
                                    <?php if ($pr['quantity_to'] > 0) { ?>
                                        <div class="quantity-range" title="<?php echo $pr['quantity_from'], ' - ', $pr['quantity_to'] ?> Thỏi">
                                            <?php echo $pr['quantity_from'], ' - ', $pr['quantity_to'] ?> Thỏi
                                        </div>
                                    <?php } else { ?>
                                        <div class="quantity-range" title="≥ <?php echo $pr['quantity_from'] ?> Thỏi">
                                            ≥ <?php echo $pr['quantity_from'] ?> Thỏi
                                        </div>
                                    <?php } ?>
                                    <div class="spec-price">
                                        <span class="priceVal" title="<?php echo number_format(($product['price'] - $pr['price']), 0, ',', '.') ?>đ"><?php echo number_format(($product['price'] - $pr['price']), 0, ',', '.') ?>đ</span>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="choice-option-order" id="boxBuy">
                        <div class="choice-color">
                            <label>Chọn màu sắc và số lượng</label>
                        </div>
                        <?php
                        if (isset($configurableFilter) && count($configurableFilter)) {
                            $configuables = isset($configurableFilter['configuables']) ? $configurableFilter['configuables'] : array();
                            $options = isset($attribute['options']) ? $attribute['options'] : array();
                            ?>
                            <div class="choice-size">
                                <?php
                                foreach ($configuables as $cfoptionValue => $configuableVal) {
                                    foreach ($configuableVal as $cf) {
                                        ?>
                                        <div class="input-amount-product">
                                            <a 
                                                class="img-amount change-images" 
                                                data-input="<?= $cfoptionValue ?>"
                                                style="background:<?php echo $cf['attribute1_value_ext'] ?>;"
                                                title="<?= $cf['attribute1_value_name'] ?>"
                                                >
                                            </a>
                                            <div class="pull-left change-quantity">
                                                <div class="btn_count">
                                                    <button class="reduced items-count" type="button"><i class="fa fa-minus"></i></button>
                                                </div>
                                                <input type="text" value="0" maxlength="12" id="qty" name="<?php echo ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY . '[' . $cf['id'] . '][' . ClaShoppingCart::PRODUCT_QUANTITY_KEY . ']'; ?>" class="input-text quantity" />
                                                <div class="btn_count">
                                                    <button class="increase items-count" type="button"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="selected-quantity">
                            <span>Đã chọn <b id="sumQuantity">0</b> Thỏi </span><br />
                            <span>Tổng tiền <b id="sumMoney" class="sumMoney">0</b> VNĐ </span>
                        </div>
                        <div class="shipping">
                            <label>Vận chuyển:</label>
                            <div class="address-ship">
                                <a href="javascript:void(0)">Toàn quốc</a>
                            </div>
                        </div>
                        <!--                        <div class="ship-cost">
                                                    <label>Giá vận chuyển:</label>
                                                    <span>Miễn phí</span>
                                                </div>-->
                        <div class="buy-now-btn">
                            <a data-params="#boxBuy" class="addtocart-destiny" href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/addWholesale', array('pid' => $product->id)); ?>">Mua ngay</a>
                        </div>
                    </div>
                    <div class="support-order">
                        <div class="sell-support">
                            <label for="">Hỗ trợ trực tuyến:</label>
                            <div class="list-sell-support">
                                <span>
                                    Mr.Dũng - 0948 854 888
                                </span>
                                <div class="list-social-sell">
                                    <a href=""><i class="fa fa-facebook"></i></a>
                                    <a href=""><i class="fa fa-google-plus"></i></a>
                                    <a href=""><i class="fa fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        var priceRange = {
            ranges: <?php echo json_encode($product_prices); ?>,
            min: <?php echo json_encode(reset($product_prices)); ?>,
            price: <?php echo $product['price']; ?>, // gia san pham ban dau
            realPrice: <?php echo $product['price']; ?>,
            timeOutObject: {},
            sum: 0,
            getDiscountPrice: function (quantity) {
                var discount = 0;
                quantity = parseInt(quantity);
                if (this.ranges) {
                    jQuery.each(this.ranges, function (index, item) {
                        if (item.quantity_from <= quantity && quantity <= item.quantity_to) {
                            discount = item.price;
                        } else if (item.quantity_from <= quantity && item.quantity_to == 0) {
                            discount = item.price;
                        }
                    });
                }
                return discount;
            }
        };

        function moneyFormat(money) {
            var nStr = money + '';
            if (nStr) {
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + '.' + '$2');
                }
                return x1 + x2;
            }
            return '';
        }

        jQuery(document).on('change', '.quantity', function () {
            var _this = jQuery(this);
            clearTimeout(priceRange.timeOutObject);
            priceRange.timeOutObject = setTimeout(function () {
                if (isNaN(_this.val())) {
                    _this.val(0);
                }
                var sum = 0;
                jQuery('.quantity').each(function (index, item) {
                    sum = sum + parseInt(jQuery(item).val());
                });
                priceRange.sum = sum;
                // Tong so luong
                jQuery('#sumQuantity').text(priceRange.sum);
                // Tong tien
                var sumMoney = 0;
                var discount = 0;
                if (priceRange.sum) {
                    var discount = priceRange.getDiscountPrice(priceRange.sum);
                }
                priceRange.realPrice = (priceRange.price - discount);
                $('.item-sell-amount').removeClass('active');
                $('.step-' + priceRange.realPrice).addClass('active');
                sumMoney = priceRange.realPrice * priceRange.sum;
                jQuery('.realPrice').text(moneyFormat(priceRange.realPrice));
                jQuery('#sumMoney').text(moneyFormat(sumMoney));
            }, 300);
        });

        $(document).ready(function () {
            jQuery(document).on('click', '.increase', function () {
                var quantity = jQuery(this).closest('.change-quantity').find('.quantity');
                if (quantity.length) {
                    quantity.val(parseInt(quantity.val()) + 1);
                    quantity.trigger('change');
                }
            });
            jQuery(document).on('click', '.reduced', function () {
                var quantity = jQuery(this).closest('.change-quantity').find('.quantity');
                if (quantity.length) {
                    var val = parseInt(quantity.val());
                    if (val > 0) {
                        quantity.val(val - 1);
                        quantity.trigger('change');
                    }
                }
            });

            $('.change-images').click(function () {
                var color_code = $(this).attr('data-input');
                $('.app-figure').hide();
                if ($('#zoom-fig-' + color_code).length) {
                    $('#zoom-fig-' + color_code).show();
                } else {
                    $('#zoom-fig').show();
                }

            });


            jQuery('.addtocart-destiny').on('click', function () {
                var thi = jQuery(this);
                var url = thi.attr('href');
                if (!url)
                    url = thi.attr('src');
                if (!url)
                    return false;
                var data_params = thi.attr('data-params');
                var data = '';
                /**
                 * get all data input
                 */
                if (data_params) {
                    var data_params_object = jQuery(data_params);
                    //
                    if (data_params_object.find('.product-attr').length) {
                        var check = true;
                        var text = '';
                        data_params_object.find('.product-attr').each(function () {
                            if (!$(this).find('.attrConfig-input').val()) {
                                check = false;
                                if (!text)
                                    text = $(this).attr('attr-title');
                                else
                                    text += ', ' + $(this).attr('attr-title');
                            }
                        });
                        if (!check) {
                            var attrError = data_params_object.find('.product-attr-error');
                            attrError.show();
                            attrError.find('b').html(text);
                            return false;
                        } else
                            data_params_object.find('.product-attr-error').hide();
                    }
                    //
                    if (data_params_object.length) {
                        data = data_params_object.find('input,select,textarea').serialize();
                    }
                }
                jQuery.ajax({
                    type: 'post',
                    url: url,
                    data: data,
                    dataType: "JSON",
                    beforeSend: function () {
                        //w3ShowLoading(thi, 'right', 15, 0);
                    },
                    success: function (res) {
                        if (res.code == '200') {
                            //return false;
                            //updateCountCart(res.total, res.products);
                            if (thi.hasClass('refreshcart')) {
                                //$('.cart').append(res.cart);
                            } else if (!thi.hasClass('noredirect') && res.redirect) {
                                window.location.href = res.redirect;
                            } else {
                                if (res.cart && res.cartTitle) {
                                    $(document).LoPopUp({
                                        title: res.cartTitle,
                                        clearBefore: true,
                                        clearAfter: true,
                                        maxwidth: '800px',
                                        minwidth: '800px',
                                        maxheight: '600px',
                                        top: '100px',
                                        contentHtml: res.cart
                                    });
                                    $(".LOpopup").show();
                                }
                            }
                        }
                        //w3HideLoading();
                    },
                    error: function () {
                        //w3HideLoading();
                        return false;
                    }
                });
                return false;
            });


        });
    </script>
    <?php
}
?>