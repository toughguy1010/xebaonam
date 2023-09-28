<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'code', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'code', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'slogan', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'slogan', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'slogan'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'product_category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div class="input-group">
            <?php echo $form->dropDownList($model, 'product_category_id', $option, array('class' => 'form-control')); ?>
            <div class="input-group-btn" style="padding-left: 10px;">
                <a href="<?php echo Yii::app()->createUrl('economy/productcategory/addcat', array('pa' => ClaCategory::CATEGORY_ROOT) + $_GET) ?>"
                   id="addCate" class="btn btn-primary btn-sm" style="line-height: 14px;">
                    <?php echo Yii::t('category', 'category_add'); ?>
                </a>
            </div>
        </div>
        <?php echo $form->error($model, 'product_category_id'); ?>
    </div>
</div>
<style type="text/css">
    .fl {
        float: left;
    }
    .menunhieu {
        width: 205px;
        height: 200px !important;
    }
</style>
<?php
$siteinfo = Yii::app()->siteinfo;
if ($siteinfo['site_skin'] == 'w3ni700') {
    ?>
    <div class="form-group no-margin-left">
        <label class="col-sm-2 control-label no-padding-left required" for="Product_manufacturer_id">Thương hiệu <br/>
            (Giữ nút CTRL + Nhấp chuột để chọn nhiều)</label>
        <div class="controls col-sm-10">
            <div class="input-group">
                <?php
                $manufacturers = ManufacturerCategories::getCategoryByParent(0);
                ?>
                <?php
                $manufacturersTrack = trim($model->manufacturer_category_track);
                $manufacturersTrackArray = [];
                if (isset($manufacturersTrack) && $manufacturersTrack) {
                    $manufacturersTrackArray = explode(' ', $manufacturersTrack);
                }
                ?>
                <div class="wrapper-brand">
                    <div class="fl div-menunhieu-0" currentid="0">
                        <h6>&nbsp;Cha&nbsp;</h6>
                        <select class="menunhieu" multiple="multiple">
                            <?php foreach ($manufacturers as $manu) { ?>
                                <option <?= in_array($manu['cat_id'], $manufacturersTrackArray) ? 'selected' : '' ?>
                                    value="<?= $manu['cat_id'] ?>"><?= $manu['cat_name'] ?>⇒
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php
                    if (isset($manufacturersTrackArray) && $manufacturersTrackArray) {
                        foreach ($manufacturersTrackArray as $manu_id) {
                            $dataChildren = ManufacturerCategories::getCategoryByParent($manu_id);
                            if (isset($dataChildren) && $dataChildren) {
                                $modelManu = ManufacturerCategories::model()->findByPk($manu_id);
                                ?>
                                <div class="fl div-menunhieu-<?= $manu_id ?> parent-id-<?= $modelManu['cat_parent'] ?>"
                                     currentid="<?= $manu_id ?>">
                                    <h6>&nbsp;<?= $modelManu['cat_name'] ?>&nbsp;</h6>
                                    <select class="menunhieu" multiple="multiple">
                                        <?php foreach ($dataChildren as $manu) { ?>
                                            <option <?= in_array($manu['cat_id'], $manufacturersTrackArray) ? 'selected="selected"' : '' ?>
                                                value="<?= $manu['cat_id'] ?>"><?= $manu['cat_name'] ?>⇒
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <input type="hidden" id="manufacturer_ids" name="Product[manufacturer_category_track]"
                       value="<?= $model->manufacturer_category_track ?>"/>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            $(".wrapper-brand").on("click", ".menunhieu option", function () {
                var cat_id = $(this).val();
                var cat_selected = $(this).parent().val();
                var ids = [];
                $(this).parent().children('option').each(function () {
                    ids.push($(this).val());
                });
                var diff = $(ids).not(cat_selected).get();
                for (var i in diff) {
                    $('.div-menunhieu-' + diff[i]).remove();
                    $('.parent-id-' + diff[i]).remove();
                }
                if ($(this).is(':selected')) {
                    if (!$('.div-menunhieu-' + cat_id).length) {
                        $.getJSON(
                            '<?= Yii::app()->createUrl("/economy/product/getManufacturerChildren") ?>',
                            {cat_id: cat_id},
                            function (data) {
                                $('.wrapper-brand').append(data.html);
                            }
                        );
                    }
                } else {
                    $('.div-menunhieu-' + cat_id).remove();
                    $('.parent-id-' + cat_id).remove();
                }
                var idsExist = [];
                $('.menunhieu').each(function () {
                    var id = $(this).val();
                    idsExist.push(id);
                });
                if (idsExist.length) {
                    var valueString = '';
                    for (var i in idsExist) {
                        for (var j in idsExist[i]) {
                            if (valueString != '') {
                                valueString += ' ';
                            }
                            valueString += idsExist[i][j];
                        }
                    }
                }
                $('#manufacturer_ids').val(valueString);
            });

        });
    </script>
<?php } ?>
<div class="clearfix"></div>
<br/>
<br/>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'manufacturer_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <!--        --><?php
        //echo $form->dropDownList($model, 'manufacturer_id', array('' => Yii::t('product', 'manufacturer_choice')) + Manufacturer::getAllManufacturerArr(), array('class' => 'span12 col-sm-12 chosen-product"'));
        $option_menufacturer = array('' => Yii::t('product', 'manufacturer_choice')) + Manufacturer::getAllManufacturerArr();
        ?>
        <select data-placeholder="Chọn sản nhà sản xuất" name="Product[manufacturer_id]" id="select-beast"
                style="width:100%;">
            <?php foreach ($option_menufacturer as $option_manufacturer_id => $option_manufacturer_name) { ?>
                <option <?php echo $model->manufacturer_id == $option_manufacturer_id ? 'selected' : '' ?>
                    value="<?php echo $option_manufacturer_id ?>">
                    <?php echo $option_manufacturer_name ?>
                </option>
            <?php } ?>
        </select>
        <?php echo $form->error($model, 'manufacturer_id'); ?>
    </div>
</div>
<!--<div class="form-group no-margin-left">-->
<!--    --><?php //echo $form->labelEx($model, 'product_brand_id', array('class' => 'col-sm-2 control-label no-padding-left'));    ?>
<!--    <div class="controls col-sm-10">-->
<!--        --><?php //echo $form->dropDownList($model, 'product_brand_id', array('' => Yii::t('product', 'product_brand_choice')) + ProductBrand::getAllProductBrandArr(), array('class' => 'span12 col-sm-12'));    ?>
<!--        --><?php //echo $form->error($model, 'product_brand_id');    ?>
<!--    </div>-->
<!--</div>-->
<!--<div class="form-group no-margin-left">-->
<!--    --><?php //echo $form->labelEx($model, 'season_id', array('class' => 'col-sm-2 control-label no-padding-left'));    ?>
<!--    <div class="controls col-sm-10">-->
<!--        --><?php //echo $form->dropDownList($model, 'season_id', array('' => Yii::t('product', 'season_choice')) + Season::getAllSeasonArr(), array('class' => 'span12 col-sm-12'));    ?>
<!--        --><?php //echo $form->error($model, 'season_id');    ?>
<!--    </div>-->
<!--</div>-->
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'price_market', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'price_market', array('class' => 'numberFormat col-sm-2')); ?>
        <?php if (SiteApivoucher::checkConfigVoucher()) { ?>
            <label class="col-sm-2 align-right"><?php echo Yii::t('product', 'percent_discount') ?></label>
            <?php
            $discount = 0;
            if ($model->price_market && $model->price) {
                $discount = ClaProduct::getDiscount($model->price_market, $model->price);
            }
            ?>
            <input type="number" min="0" max="99" value="<?php echo $discount; ?>" id="percent_discount"
                   class="col-sm-2"/>
        <?php } ?>
        <?php echo $form->error($model, 'price', array(), true, false); ?>
        <?php echo $form->error($model, 'price_market', array(), true, false); ?>
    </div>
    <?php if (SiteApivoucher::checkConfigVoucher()) { ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#percent_discount').keyup(function () {
                    var percent = $(this).val();
                    var price_market = $('#Product_price_market').val();
                    price_market = w3n.ToNumber(price_market);
                    add_price(price_market, percent);
                });
                $('#Product_price_market').keyup(function () {
                    var price_market = $(this).val();
                    price_market = w3n.ToNumber(price_market);
                    var percent = $('#percent_discount').val();
                    add_price(price_market, percent);
                });
            });

            function add_price(price_market, percent) {
                if (percent > 0) {
                    var price = price_market * ((100 - percent) / 100);
                    var price_temp = w3n.ToNumber(price);
                    var formatNumber = w3n.FormatNumber(price_temp);
                    console.log(formatNumber)
                    $('#Product_price').val(formatNumber);
                }
            }
        </script>
    <?php } ?>
</div>

<?php if (isset(Yii::app()->siteinfo['wholesale']) && Yii::app()->siteinfo['wholesale']) { ?>
    <hr/>
    <style type="text/css">
        .wrap-item-wholesale .item {
            margin-bottom: 15px;
        }
    </style>
    <?php
    $prices = ProductWholesalePrice::getWholesalePriceByProductid($model->id);
    ?>
    <div class="wrap-whole-price row">
        <label class="col-sm-2"><?php echo Yii::t('static', 'whole_sales_price') ?></label>
        <div class="col-sm-10">
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="col-sm-3">
                        <label><?php echo Yii::t('static', 'from') ?></label>
                    </div>
                    <div class="col-sm-3">
                        <label><?php echo Yii::t('static', 'to') ?></label>
                    </div>
                    <div class="col-sm-3">
                        <label><?php echo Yii::t('static', 'price_discount_on_product') ?></label>
                    </div>
                </div>
                <div class="wrap-item-wholesale">
                    <?php if (isset($prices) && $prices) { ?>
                        <?php
                        $i = 0;
                        foreach ($prices as $price) {
                            $i++;
                            ?>
                            <div class="item clearfix">
                                <div class="col-sm-3">
                                    <input att-stt="<?php echo $i ?>" class="quantity-from-<?php echo $i; ?>"
                                           type="number"
                                           name="ProductWholesalePriceUpdate[<?php echo $price['id'] ?>][quantity_from]"
                                           placeholder="<?php echo Yii::t('static', 'from') ?>"
                                           value="<?php echo $price['quantity_from'] ?>"/>
                                </div>
                                <div class="col-sm-3">
                                    <input onkeyup="reQuantityto(this)" att-stt="<?php echo $i ?>"
                                           class="quantity-to quantity-to-<?php echo $i; ?>" type="number"
                                           name="ProductWholesalePriceUpdate[<?php echo $price['id'] ?>][quantity_to]"
                                           placeholder="<?php echo Yii::t('static', 'to') ?>"
                                           value="<?php echo $price['quantity_to'] ?>"/>
                                </div>
                                <div class="col-sm-3">
                                    <input class="numberFormat" type="text"
                                           name="ProductWholesalePriceUpdate[<?php echo $price['id'] ?>][price]"
                                           placeholder="<?php echo Yii::t('static', 'price_discount_on_product') ?>"
                                           value="<?php echo number_format($price['price'], 0, ',', '.') ?>"/>
                                </div>
                                <div class="col-sm-3">
                                    <i data-id="<?php echo $price['id'] ?>" onclick="removeWholeSalePrice(this)"
                                       class="icon-minus" style="margin: 0px 10px; cursor: pointer;"></i>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    <?php } else { ?>
                        <div class="item clearfix">
                            <div class="col-sm-3">
                                <input att-stt="1" class="quantity-from-1" type="number"
                                       name="ProductWholesalePrice[1][quantity_from]"
                                       placeholder="<?php echo Yii::t('static', 'from') ?>" value=""/>
                            </div>
                            <div class="col-sm-3">
                                <input onkeyup="reQuantityto(this)" att-stt="1" class="quantity-to quantity-to-1"
                                       type="number" name="ProductWholesalePrice[1][quantity_to]"
                                       placeholder="<?php echo Yii::t('static', 'to') ?>" value=""/>
                            </div>
                            <div class="col-sm-3">
                                <input class="numberFormat" type="text" name="ProductWholesalePrice[1][price]"
                                       placeholder="<?php echo Yii::t('static', 'price_discount_on_product') ?>"
                                       value=""/>
                            </div>
                            <div class="col-sm-3">
                                <i class="removeattri icon-minus" style="margin: 0px 10px; cursor: pointer;"></i>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-sm-12">
                    <button type="button" id="add-wholesale-price"
                            class="btn btn-default"><?php echo Yii::t('static', 'add') ?></button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function reQuantityto(_this) {
            var stt = $(_this).attr('att-stt');
            stt++;
            var value = $(_this).val();
            value++;
            $('.quantity-from-' + stt).val(value);
        }

        //

        function removeWholeSalePrice(_this) {
            if (confirm('Are you sure want to delete?')) {
                var id = $(_this).attr('data-id');
                $.getJSON(
                    '<?php echo Yii::app()->createUrl('/economy/productManager/deleteWholeSalePrice') ?>',
                    {id: id},
                    function (data) {
                        if (data.code == 200) {
                            jQuery(_this).closest('.item').remove();
                        }
                    }
                );
            }
            return;
        }

        //
        jQuery(document).on('click', '.removeattri', function () {
            jQuery(this).closest('.item').remove();
        });
        //
        $(document).ready(function () {
            $('#add-wholesale-price').click(function () {
                var stt = $('.wrap-item-wholesale .item').length;
                var quantity_to = $('.quantity-to-' + stt).val();
                quantity_to++;
                stt++;
                var html = '';
                html += '<div class="item clearfix">';

                html += '<div class="col-sm-3">';
                html += '<input att-stt="' + stt + '" class="quantity-from-' + stt + '" type="number" name="ProductWholesalePrice[' + stt + '][quantity_from]" placeholder="<?php echo Yii::t('static', 'from') ?>" value="' + quantity_to + '" />';
                html += '</div>';

                html += '<div class="col-sm-3">';
                html += '<input onkeyup="reQuantityto(this)" att-stt="' + stt + '" class="quantity-to quantity-to-' + stt + '" type="number" name="ProductWholesalePrice[' + stt + '][quantity_to]" placeholder="<?php echo Yii::t('static', 'to') ?>" value="" />';
                html += '</div>';

                html += '<div class="col-sm-3">';
                html += '<input class="numberFormat" type="text" name="ProductWholesalePrice[' + stt + '][price]" placeholder="<?php echo Yii::t('static', 'price_discount_on_product') ?>" value="" />';
                html += '</div>';

                html += '<div class="col-sm-3">';
                html += '<i class="removeattri icon-minus" style="margin: 0px 10px; cursor: pointer;"></i>';
                html += '</div>';

                html += '</div>';
                $('.wrap-item-wholesale').append(html);
                jQuery(".numberFormat").keypress(function (e) {
                    return numberOnly(e);
                }).keyup(function (e) {
                    var value = $(this).val();
                    if (value != '') {
                        var valueTemp = ToNumber(value);
                        var formatNumber = FormatNumber(valueTemp);
                        if (value != formatNumber)
                            $(this).val(formatNumber);
                    }
                });
            });

        });
    </script>

    <hr/>
<?php } ?>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'weight', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'weight', array('class' => 'span2 col-sm-2', 'placeholder' => Yii::t('product', 'weight'))); ?>
        <span style="display: inline-block; margin-top: 5px;"> &nbsp; Kg</span>
        <?php echo $form->error($model, 'weight'); ?>
    </div>
</div>
<!--Điểm tích lũy-->
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'bonus_point', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'bonus_point', array('class' => 'span2 col-sm-2', 'placeholder' => Yii::t('product', 'weight'))); ?>
        <span style="display: inline-block; margin-top: 5px;"> &nbsp; (Điểm sẽ nhận được khi mua 1 sản phẩm)</span>
        <?php echo $form->error($model, 'bonus_point'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'donate', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'donate', array('class' => 'span2 col-sm-2', 'placeholder' => Yii::t('product', 'donate'))); ?>
        <?php echo $form->error($model, 'donate'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'include_vat', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'include_vat'); ?>
        <span class="lbl"
              style="padding:0px 5px 4px 5px; color: #999; font-size: 12px; font-style: italic;"><?php echo Yii::t('product', 'product_include_vat_help') ?></span>
        <?php echo $form->error($model, 'include_vat'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'isnew', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'isnew'); ?>
        <?php echo $form->error($model, 'isnew'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'ishot'); ?>
        <?php echo $form->error($model, 'ishot'); ?>
    </div>
</div>
<?php
$siteinfo = Yii::app()->siteinfo;
if ($siteinfo['site_skin'] == 'w3ni700') {
    ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'issale', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkBox($model, 'issale'); ?>
            <?php echo $form->error($model, 'issale'); ?>
        </div>
    </div>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'ispriceday', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkBox($model, 'ispriceday'); ?>
            <?php echo $form->error($model, 'ispriceday'); ?>
        </div>
    </div>
<?php } ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'iswaitting', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'iswaitting'); ?>
        <?php echo $form->error($model, 'iswaitting'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'members_only', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'members_only'); ?>
        <?php echo $form->error($model, 'members_only'); ?>
    </div>
</div>
<div class="form-group no-margin-left" style="display: none;">
    <?php
    if (!$model->currency || $model->isNewRecord) {
        $model->currency = Yii::app()->siteinfo['currency'];
    }
    ?>
    <?php echo $form->label($model, 'currency', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'currency', Product::$_dataCurrency, array('class' => 'span12 col-sm-2')); ?>
        <?php echo $form->error($model, 'currency'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'quantity', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'quantity', array('class' => 'span12 col-sm-12', 'placeholder' => Yii::t('product', 'product_quantity_placeholder'))); ?>
        <?php echo $form->error($model, 'quantity'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArrayProduct(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<?php if (SiteApivoucher::checkConfigVoucher()) { ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'type_product', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'type_product', ActiveRecord::typeProductArray(), array('class' => 'span12 col-sm-12')); ?>
            <?php echo $form->error($model, 'type_product'); ?>
        </div>
    </div>
<?php } ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'province_id', Province::getAllProductProvinceArr(true), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'province_id'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'state', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'state'); ?>
        <span class="lbl"
              style="padding:0px 5px 4px 5px; color: #999; font-size: 12px; font-style: italic;"><?php echo Yii::t('product', 'product_state_help') ?></span>
        <?php echo $form->error($model, 'state'); ?>
    </div>
</div>
<?php if (isset($shop_store) && count($shop_store) > 0) { ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($productInfo, 'shop_store', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->hiddenField($productInfo, 'shop_store', array('class' => 'span12 col-sm-12')); ?>
            <?php
            $shop_store_arr = array();
            if (isset($productInfo->shop_store) && $productInfo->shop_store) {
                $shop_store_arr = explode(',', $productInfo->shop_store);
            }
            if (isset($shop_store) && $shop_store != null) {
                foreach ($shop_store as $each_shop) {
                    ?>
                    <input class="checkStore" type="checkbox"
                           name="checkStore[]" <?php echo (in_array($each_shop['id'], $shop_store_arr)) ? (' checked="checked" ') : '' ?>
                           value="<?php echo $each_shop['id']; ?>"><span class="lbl"
                                                                         style="padding:0px 5px 4px 5px; color: #333; font-size: 12px;"><?php echo $each_shop['name']; ?></span>
                    <br>
                    <?php
                }
            }
            ?>
        </div>
        <script>
            $(document).ready(function () {
                $('input.checkStore').on('click', function () {
                    var checkedValues = $('input.checkStore:checkbox:checked').map(function () {
                        return this.value;
                    }).get().join(',');
                    $('input#ProductInfo_shop_store').val(checkedValues);
                });
            })

        </script>
    </div>
<?php } ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'position', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'position', array('class' => 'span12 col-sm-2')); ?>
        <?php echo $form->error($model, 'position'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'url_to', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'url_to', array('class' => 'span12 col-sm-10')); ?>
        <?php echo $form->error($model, 'url_to'); ?>
    </div>
</div>