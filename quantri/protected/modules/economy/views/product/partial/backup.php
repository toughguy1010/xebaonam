
<?php
$att_color = array();
if (isset($attributes_cf) && count($attributes_cf)) {
    foreach ($attributes_cf as $cf) {
        if ($cf->type_option == ProductAttribute::TYPE_OPTION_COLOR) {
            $att_color = CHtml::listData($cf->getAttributeOption(), 'index_key', 'value');
        }
    }
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
                <?php if (empty($att_cf_value)) { ?>
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
                                <input style="width:90%;" type="text" value="" name="attribute_cf[new][<?php echo $j ?>][5]" />
                            </div>
                            <div class="col-sm-2 att-pro-price">
                                <input style="width:90%;" type="text" value="" name="attribute_cf[new][<?php echo $j ?>][6]" />
                            </div>
                            <span class="col-sm-1 help-inline action">
                                <!--<i class="addattri-new icon-plus" style="margin: 0px;"></i>-->
                                <i class="removeattri-new icon-minus" style="margin: 0px 10px;"></i>
                            </span>
                        </div>
                    <?php } ?>
                <?php } ?>
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
                                <!--<i class="addattri icon-plus"></i>-->
                                <i class="removeattri icon-minus"></i>
                            </span>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div> 
    </div>
</div>