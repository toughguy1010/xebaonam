<?php
$count_cf = count($attributes_cf);
$count_cf = ($count_cf <= 2) ? $count_cf : 2;
$att_cf_value = ProductConfigurableValue::model()->findAll('product_id=:product_id', array(':product_id' => $model->id));
?>
<?php $this->renderPartial('script/configurablescript', array('attributes_cf' => $attributes_cf, 'count_cf' => $count_cf)); ?>
<div id="product-attributes-cf">
    <div class="control-group form-group group-header">        
        <?php for ($i = 0; $i < $count_cf; $i++) { ?>
            <input type="hidden" name="attribute_cf[att][attribute<?php echo $attributes_cf[$i]->field_configurable; ?>_id]" value="<?php echo $attributes_cf[$i]->id; ?>"/>
            <span class="col-sm-2 control-label"><strong><?php echo $attributes_cf[$i]->name; ?></strong></span>        
        <?php } ?>
        <span class="col-sm-2 control-label"><strong>Giá (VNĐ)</strong></span>
        <span class="col-sm-4 control-label"><strong>Ảnh</strong></span>        
    </div>
    <?php if (empty($att_cf_value)) { ?>
        <div class="control-group form-group cf-row">        
            <?php for ($i = 0; $i < $count_cf; $i++) { ?>        
                <div class="col-sm-2">
                    <?php echo CHtml::dropDownList('attribute_cf[new][0][' . $attributes_cf[$i]->field_configurable . ']', '', CHtml::listData($attributes_cf[$i]->getAttributeOption(), 'index_key', 'value'), array('empty' => '-- Lựa chọn --', 'class' => '', 'style' => 'width:90%;')); ?>
                </div>
            <?php } ?>
            <div class="col-sm-2 att-pro-price">
                <?php echo CHtml::textField('attribute_cf[new][0][4]', '', array('maxlength' => 15, 'style' => 'width:90%;')); ?>
            </div>
            <div class="col-sm-4 att-pro-images">
                <?php
                $this->widget('common.widgets.upload.Upload', array(
                    'type' => 'images',
                    'id' => 'imageupload0',
                    'buttonheight' => 25,
                    'path' => array('pconfig', $this->site_id, Yii::app()->user->id),
                    'limit' => 100,
                    'multi' => true,
                    'imageoptions' => array(
                        'resizes' => array(array(200, 200))
                    ),
                    'buttontext' => 'Thêm ảnh',
                    'displayvaluebox' => false,
                    'oncecomplete' => "var firstitem   = jQuery('#algalley_configurable_0 .alimglist').find('.alimgitem:first');var alimgitem   = '<div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"attribute_cf[new][0][1111][]\" class=\"newimage\" /></div></div>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_configurable_0 .alimglist').append(alimgitem);}; updateImgBox();",
                    'onUploadStart' => 'ta=false;',
                    'queuecomplete' => 'ta=true;',
                ));
                ?>
            </div>
            <span class="col-sm-1 help-inline action">
                <i class="addattri icon-plus"></i>
                <i class="removeattri icon-minus"></i>
            </span>
            <div style="clear: both"></div>
            <div id="algalley_configurable_0" class="algalley">
                <div class="alimgbox">
                    <div class="alimglist">
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <?php foreach ($att_cf_value as $key => $value) { ?>
            <div id="<?php echo $value->id; ?>" class="control-group form-group cf-row cfupdate">        
                <?php foreach ($attributes_cf as $att) { ?>        
                    <div class="col-sm-2">
                        <?php $key_v = ($att->field_configurable > 0) ? 'attribute' . $att->field_configurable . '_value' : ''; ?>
                        <?php echo CHtml::dropDownList('attribute_cf[update][' . $value->id . '][' . $att->field_configurable . ']', ($key_v) ? $value->$key_v : '', CHtml::listData($att->getAttributeOption(), 'index_key', 'value'), array('empty' => '-- Lựa chọn --', 'class' => '', 'style' => 'width:90%;')); ?>
                    </div>
                <?php } ?>
                <div class="col-sm-2 att-pro-price">
                    <?php echo CHtml::textField('attribute_cf[update][' . $value->id . '][4]', (int) $value->price, array('maxlength' => 15, 'style' => 'width:90%;')); ?>
                </div>
                <div class="col-sm-4 att-pro-images">
                    <?php
                    $this->widget('common.widgets.upload.Upload', array(
                        'type' => 'images',
                        'id' => 'imageupload' . $value->id,
                        'buttonheight' => 25,
                        'path' => array('pconfig', $this->site_id, Yii::app()->user->id),
                        'limit' => 100,
                        'multi' => true,
                        'imageoptions' => array(
                            'resizes' => array(array(200, 200))
                        ),
                        'buttontext' => 'Thêm ảnh',
                        'displayvaluebox' => false,
                        'oncecomplete' => "var firstitem   = jQuery('#algalley_configurable_" . $value->id . " .alimglist').find('.alimgitem:first');var alimgitem   = '<div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimageconfig[" . $value->id . "][]\" class=\"newimage\" /></div></div>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_configurable_" . $value->id . " .alimglist').append(alimgitem);}; updateImgBox();",
                        'onUploadStart' => 'ta=false;',
                        'queuecomplete' => 'ta=true;',
                    ));
                    ?>

                </div>
                <span class="col-sm-1 help-inline action">
                    <i class="addattri icon-plus"></i>
                    <i class="removeattri icon-minus"></i>
                </span>
                <div style="clear: both"></div>
                <div id="algalley_configurable_<?php echo $value->id ?>" class="algalley">
                    <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
                    <div class="alimgbox">
                        <div class="alimglist">
                            <?php
                            if (!$model->isNewRecord) {
                                $imagesconfig = $model->getImagesConfig($value->id);
                                foreach ($imagesconfig as $image) {
                                    $this->renderPartial('imageitemconfig', array('image' => $image));
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>