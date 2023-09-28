
<?php
$count_cf = count($attributes_cf);
$count_cf = ($count_cf <= 3) ? $count_cf : 3;
?>
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
                $i = 0;
                $order = array();
                foreach ($attributes_cf as $cf) {
                    $order[] = $cf->id;
                    $i++;
                    if ($i <= $count_cf) {
                        $temp = CHtml::listData($cf->getAttributeOption(), 'index_key', 'value');
                        $data_combinations[] = array_keys($temp);
                        $data_full[] = $temp;
                    }
                }

                $properOrderedArray = array_replace(array_flip($order), $data);
                $data_real = array_values($properOrderedArray);
                $combinations_key = combinations($data_real);
                $data_real_name = array();
                foreach ($data_real as $kn => $item) {
                    foreach ($item as $key => $code) {
                        $data_real_name[$kn][$code] = $data_full[$kn][$code];
                    }
                }
                $combinations_name = combinations($data_real_name);
                $count_combinations = count($combinations_key);
                ?>

                <?php if (empty($att_cf_value)) { ?>
                    <?php if ($count_cf > 1) { ?>
                        <div class="control-group form-group group-header">        
                            <?php for ($i = 0; $i < $count_cf; $i++) { ?>
                                <input type="hidden" name="attribute_cf[att][attribute<?php echo $attributes_cf[$i]->field_configurable; ?>_id]" value="<?php echo $attributes_cf[$i]->id; ?>"/>
                                <span class="col-sm-2 control-label"><strong><?php echo $attributes_cf[$i]->name; ?></strong></span>        
                            <?php } ?>
                            <span class="col-sm-2 control-label"><strong>Giá (VNĐ)</strong></span>
                            <span class="col-sm-2 control-label"><strong>Giá thị trường</strong></span>
                            <span class="col-sm-2 control-label"><strong>Code</strong></span>        
                        </div>

                        <?php for ($j = 0; $j < $count_combinations; $j++) { ?>
                            <div class="control-group form-group cf-row">
                                <?php for ($i = 0; $i < $count_cf; $i++) { ?>
                                    <div class="col-sm-2">
                                        <span><?php echo $combinations_name[$j][$i] ?></span>
                                        <input name="attribute_cf[new][<?php echo $j ?>][<?php echo $attributes_cf[$i]->field_configurable ?>]" type="hidden" value="<?php echo $combinations_key[$j][$i] ?>" />
                                    </div>
                                <?php } ?>
                                <div class="col-sm-2 att-pro-price">
                                    <input class="numberFormat" maxlength="15" style="width:90%;" type="text" value="" name="attribute_cf[new][<?php echo $j ?>][4]" />
                                </div>
                                <div class="col-sm-2 att-pro-price">
                                    <input class="numberFormat" style="width:90%;" type="text" value="" name="attribute_cf[new][<?php echo $j ?>][5]" />
                                </div>
                                <div class="col-sm-2 att-pro-price">
                                    <input style="width:90%;" type="text" value="" name="attribute_cf[new][<?php echo $j ?>][6]" />
                                </div>
                                <span class="col-sm-1 help-inline action">
                                    <!--<i class="addattri-new icon-plus" style="margin: 0px;"></i>-->
                                    <i class="removeattri icon-minus" style="margin: 0px 10px;"></i>
                                </span>
                            </div>
                        <?php } ?>
                    <?php } elseif ($count_cf == 1) { ?>
                        <div class="control-group form-group group-header">        
                            <?php for ($i = 0; $i < $count_cf; $i++) { ?>
                                <input type="hidden" name="attribute_cf[att][attribute<?php echo $attributes_cf[$i]->field_configurable; ?>_id]" value="<?php echo $attributes_cf[$i]->id; ?>"/>
                                <span class="col-sm-2 control-label"><strong><?php echo $attributes_cf[$i]->name; ?></strong></span>        
                            <?php } ?>
                            <span class="col-sm-2 control-label"><strong>Giá (VNĐ)</strong></span>
                            <span class="col-sm-2 control-label"><strong>Giá thị trường</strong></span>
                            <span class="col-sm-2 control-label"><strong>Code</strong></span>        
                        </div>

                        <?php for ($j = 0; $j < $count_combinations; $j++) { ?>
                            <div class="control-group form-group cf-row">
                                <?php for ($i = 0; $i < $count_cf; $i++) { ?>
                                    <div class="col-sm-2">
                                        <span><?php echo $combinations_name[$combinations_key[$j]] ?></span>
                                        <input name="attribute_cf[new][<?php echo $j ?>][<?php echo $attributes_cf[$i]->field_configurable ?>]" type="hidden" value="<?php echo $combinations_key[$j] ?>" />
                                    </div>
                                <?php } ?>
                                <div class="col-sm-2 att-pro-price">
                                    <input class="numberFormat" maxlength="15" style="width:90%;" type="text" value="" name="attribute_cf[new][<?php echo $j ?>][4]" />
                                </div>
                                <div class="col-sm-2 att-pro-price">
                                    <input class="numberFormat" style="width:90%;" type="text" value="" name="attribute_cf[new][<?php echo $j ?>][5]" />
                                </div>
                                <div class="col-sm-2 att-pro-price">
                                    <input style="width:90%;" type="text" value="" name="attribute_cf[new][<?php echo $j ?>][6]" />
                                </div>
                                <span class="col-sm-1 help-inline action">
                                    <!--<i class="addattri-new icon-plus" style="margin: 0px;"></i>-->
                                    <i class="removeattri icon-minus" style="margin: 0px 10px;"></i>
                                </span>
                            </div>
                        <?php } ?>
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
    if(isset($att_color) && $att_color) {
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
            $images_color = ProductImagesColor::getImagesProductColor($model->id);
            ?>
            <?php
            foreach ($att_color as $color_code => $color_name) {
                if (in_array($color_code, $data[$attribute_color])) {
                    ?>
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
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
}
}
?>
<script type="text/javascript">
    jQuery(".numberFormat").keypress(function (e) {
        return w3n.numberOnly(e);
    }).keyup(function (e) {
        var value = $(this).val();
        if (value != '') {
            var valueTemp = w3n.ToNumber(value);
            var formatNumber = w3n.FormatNumber(valueTemp);
            if (value != formatNumber)
                $(this).val(formatNumber);
        }
    });
</script>