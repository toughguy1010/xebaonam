<?php
$count_cf = count($attributes_cf);
$count_cf = ($count_cf <= 3) ? $count_cf : 3;
$att_cf_value = ProductConfigurableValue::model()
        ->findAll('product_id=:product_id ORDER BY `order` ASC, id ASC', array(':product_id' => $model->id));

?>
<?php $this->renderPartial('script/configurablescript', array('attributes_cf' => $attributes_cf, 'count_cf' => $count_cf)); ?>

<?php if (empty($att_cf_value)) { ?>
    <div class="control-group form-group" id="data-attributes-generate">
        <label class="col-sm-12 control-label no-padding-left" style="margin-bottom: 20px; font-weight: bold; font-size: 15px">Chọn thuộc tính để sinh sản phẩm liên kết tự động</label>
        <?php foreach ($attributes_cf as $cf) { ?>
            <div class="col-sm-4 wrap-attribute-input" id="wrap-attribute-<?php echo $cf->id ?>">
                <div class="col-sm-3">
                    <label style="font-weight: bold;"><?php echo $cf->name ?></label>
                </div>
                <div class="col-sm-9">
                    <table class="table table-bordered">
                        <tbody>
                            <?php foreach ($cf->attributeOption as $item) { ?>
                                <tr>
                                    <?php if ($cf->type_option != 2) { ?>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="<?php echo $cf->id ?>" type="checkbox" value="<?php echo $item->index_key ?>"> <?php echo $item->value ?>
                                                </label>
                                            </div>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="<?php echo $cf->id ?>" type="checkbox" value="<?php echo $item->index_key ?>"> <?php echo $item->value ?>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="background-color: <?php echo $item->ext ?>; height: 28px;width: 28px;"></div>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <input class="attrConfig-input" title="<?php echo $cf->name ?>" type="hidden" value="" name="attrConfig[<?php echo $cf->id ?>]" id="attrConfig_<?php echo $cf->id ?>">
            </div>
        <?php } ?>
        <div class="clearfix"></div>
        <div class="product-attr-error text-danger" style="display: none; margin-bottom: 10px;">
            <span><?php echo Yii::t('product', 'please_choice') ?> </span><b></b>
        </div>
        <button type="button" class="btn btn-primary" id="generate-configurable">Sinh sản phẩm liên kết</button> <span style="color: blue; font-size: 15px; margin-left: 10px; display: none" id="loading-attribute">Loading...</span>
        <script type="text/javascript">
            $(document).ready(function () {
                var data = {};
                $('#data-attributes-generate :checkbox').click(function () {
                    var attribute_id = $(this).attr('name');
                    var val = [];
                    $('#wrap-attribute-' + attribute_id + ' :checkbox:checked').each(function (i) {
                        val[i] = $(this).val();
                    });
                    if (val.length > 0) {
                        $(this).closest('.wrap-attribute-input').find('.attrConfig-input').val(1);
                    } else {
                        $(this).closest('.wrap-attribute-input').find('.attrConfig-input').val('');
                    }
                    data[attribute_id] = val;

                });
                $('#generate-configurable').click(function () {
                    var check = true;
                    var text = '';
                    jQuery('#data-attributes-generate').find('.attrConfig-input').each(function () {
                        if (!jQuery(this).val()) {
                            check = false;
                            if (!text)
                                text = $(this).attr('title');
                            else
                                text += ', ' + $(this).attr('title');
                        }
                    });
                    if (!check) {
                        var attrError = $('.product-attr-error');
                        attrError.show();
                        attrError.find('b').html(text);
                        return false;
                    } else {
                        $('.product-attr-error').hide();
                    }

                    $('#loading-attribute').show();
                    var product_id = '<?php echo $model->id; ?>';
                    var category_id = jQuery('#Product_product_category_id').val();
                    $.getJSON(
                            '<?php echo Yii::app()->createUrl('economy/product/ajaxCombinations') ?>',
                            {data: data, product_id: product_id, category_id: category_id},
                            function (result) {
                                setTimeout(function () {
                                    $('#loading-attribute').fadeOut('slow');
                                    $('.wrap-images-color-configurable').html(result.html);
                                }, 500);

                            }
                    );
                });
            });
        </script>
    </div>
    <div class="wrap-images-color-configurable">

    </div>
<?php } ?>
<?php if ($att_cf_value) { ?>
    <div class="control-group form-group">
        <label class="col-sm-2 control-label no-padding-left">Đăng sản phẩm liên kết</label>
        <div class="controls col-sm-12">
            <div id="attributes-cf" class="tab-pane">
                <div id="product-attributes-cf">
                    <?php

                    function combinations($arrays, $i = 0) {
                        if (!isset($arrays[$i])) {
                            return array();
                        }
                        if ($i == count($arrays) - 1) {
                            return $arrays[$i];
                        }
                        // get combinations from subsequent arrays
                        $tmp = combinations($arrays, $i + 1);
                        $result = array();
                        // concat each array from tmp with each element from $arrays[$i]
                        foreach ($arrays[$i] as $v) {
                            foreach ($tmp as $t) {
                                $result[] = is_array($t) ? array_merge(array($v), $t) : array($v, $t);
                            }
                        }
                        return $result;
                    }

                    $data_combinations = array();
                    $data_full = array();
                    //$attributes_cf[$i]->id
                    $i = 0;
                    foreach ($attributes_cf as $cf) {
                        $i++;
                        if ($i <= $count_cf) {
                            $temp = CHtml::listData($cf->getAttributeOption(), 'index_key', 'value');
                            $data_combinations[] = array_keys($temp);
                            $data_full[] = $temp;
                        }
                    }
                    $combinations_key = combinations($data_combinations);
                    $combinations_name = combinations($data_full);
                    $count_combinations = count($combinations_key);
                    ?>
                    <?php if ($att_cf_value) { ?>
                        <div class="control-group form-group group-header">
                            <?php for ($i = 0; $i < $count_cf; $i++) { ?>
                                <input type="hidden" name="attribute_cf[att][attribute<?php echo $attributes_cf[$i]->field_configurable; ?>_id]" value="<?php echo $attributes_cf[$i]->id; ?>"/>
                                <span class="col-sm-2 control-label"><strong><?php echo $attributes_cf[$i]->name; ?></strong></span>
                            <?php } ?>
                            <span class="col-sm-2 control-label"><strong>Giá (VNĐ)</strong></span>
                            <span class="col-sm-2 control-label"><strong>Giá thị trường</strong></span>
                            <span class="col-sm-2 control-label"><strong>Code</strong></span>
                        </div>
                        <?php foreach ($att_cf_value as $key => $value) { ?>
                            <div id="<?php echo $value->id; ?>" class="control-group form-group cf-row cfupdate">
                                <?php foreach ($attributes_cf as $att) { ?>
                                    <div class="col-sm-2">
                                        <?php $key_v = ($att->field_configurable > 0) ? 'attribute' . $att->field_configurable . '_value' : ''; ?>
                                        <?php echo CHtml::dropDownList('attribute_cf[update][' . $value->id . '][' . $att->field_configurable . ']', ($key_v) ? $value->$key_v : '', CHtml::listData($att->getAttributeOption(), 'index_key', 'value'), array('empty' => '-- Lựa chọn --', 'class' => '', 'style' => 'width:100%;', 'disabled' => 'true')); ?>
                                    </div>
                                <?php } ?>
                                <div class="col-sm-2 att-pro-price">
                                    <?php echo CHtml::textField('attribute_cf[update][' . $value->id . '][4]', number_format($value->price, 0, ',', '.'), array('maxlength' => 15, 'style' => 'width:100%;', 'class' => 'numberFormat')); ?>
                                </div>
                                <div class="col-sm-2 att-pro-price">
                                    <?php echo CHtml::textField('attribute_cf[update][' . $value->id . '][5]', number_format($value->price_market, 0, ',', '.'), array('maxlength' => 15, 'style' => 'width:100%;', 'class' => 'numberFormat')); ?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo CHtml::textField('attribute_cf[update][' . $value->id . '][6]', $value->code, array('maxlength' => 15, 'style' => 'width:100%;')); ?>
                                </div>
                                <span class="col-sm-2 help-inline action">
                                    <i class="addattri-new icon-plus"></i>
                                    <i class="removeattri icon-minus"></i>
                                </span>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $att_color = array();
    if (isset($attributes_cf) && count($attributes_cf)) {
        foreach ($attributes_cf as $cf) {
            if ($cf->type_option == ProductAttribute::TYPE_OPTION_COLOR) {
                $att_color = CHtml::listData($cf->getAttributeOption(), 'index_key', 'value');
            }
        }
        if (isset($att_color) && $att_color) {
            ?>
            <div class="control-group form-group">
                <label class="col-sm-2 control-label no-padding-left">Đăng ảnh theo màu sắc</label>
                <div class="controls col-sm-12">
                    <div class="control-group form-group group-header">
                        <span class="col-sm-2 control-label"><strong>Màu sắc</strong></span>
                        <!--<span class="col-sm-2 control-label"><strong>Barcode</strong></span>-->
                        <span class="col-sm-2 control-label"><strong>Upload</strong></span>
                        <!--<span class="col-sm-8 control-label"><strong>Ảnh</strong></span>-->
                    </div>
                    <?php
                    $t = Yii::app()->request->getParam('t', 0);
                    $images_color = ProductImagesColor::getImagesProductColor($model->id);
                    if ($t == 1) {
                        echo "<pre>";
                        print_r($att_color);
                        echo "</pre>";
                        die();
                    }
                    ?>
                    <?php foreach ($att_color as $color_code => $color_name) { ?>
                        <div class="control-group form-group cf-row">
                            <div class="col-sm-2">
                                <?php echo CHtml::dropDownList('att_color', $color_code, $att_color, array('empty' => '-- Lựa chọn --', 'class' => '', 'style' => 'width:90%;', 'disabled' => true)); ?>
                            </div>
                            <div class="col-sm-2">
                                <?php
                                $this->widget('common.widgets.upload.Upload', array(
                                    'type' => 'images',
                                    'id' => 'imageupload' . $color_code,
                                    'buttonheight' => 25,
                                    'path' => array('products', $this->site_id, Yii::app()->user->id),
                                    'limit' => 100,
                                    'multi' => true,
                                    'imageoptions' => array(
                                        'resizes' => array(array(200, 200))
                                    ),
                                    'buttontext' => 'Thêm ảnh',
                                    'displayvaluebox' => false,
                                    'oncecomplete' => "callbackComplete(da, " . $color_code . ");",
                                    'onUploadStart' => 'ta=false;',
                                    'queuecomplete' => 'ta=true;',
                                ));
                                ?>
                            </div>
                            <div class="col-sm-12">
                                <div id="algalley<?php echo $color_code ?>" class="algalley">
                                    <div class="alimgbox">
                                        <div class="alimglist">
                                            <ul class="sortable" id="sortable<?php echo $color_code ?>">
                                                <?php
                                                foreach ($images_color as $img_color) {
                                                    if ($img_color['color_code'] == $color_code) {
                                                        $this->renderPartial('imageitemcolor', array(
                                                            'img_color' => $img_color,
                                                            'color_code' => $color_code
                                                        ));
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        }
    }
}
?>
