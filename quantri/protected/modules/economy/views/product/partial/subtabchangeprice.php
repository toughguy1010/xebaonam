<?php
$count_changeprice = count($attributes_changeprice);
$att_changeprice_value = ProductAttributeOptionPrice::model()->getByProduct($model->id);
?>
<?php $this->renderPartial('script/changepricescript', array('attributes_changeprice' => $attributes_changeprice, 'count_changeprice' => $count_changeprice)); ?>
<div class="control-group form-group">
    <label class="col-sm-2 control-label no-padding-left">Thuộc tính tăng giảm giá sản phẩm</label>
    <div class="controls col-sm-10">
        <div id="attributes-changeprice" class="tab-pane">
            <div id="product-attributes-changeprice">
                <?php for ($i = 0; $i < $count_changeprice; $i++) { ?>
                    <div class="control-group form-group group-header">                                                    
                        <span class="col-sm-2 control-label"><strong><?php echo $attributes_changeprice[$i]->name; ?></strong></span>                            
                        <span class="col-sm-2 control-label"><strong>Giá +/- (VNĐ)</strong></span>                         
                    </div>
                    <?php if (empty($att_changeprice_value[$attributes_changeprice[$i]->id])) { ?>
                        <div class="control-group form-group changeprice-row">        
                            <div class="col-sm-2">
                                <?php echo CHtml::dropDownList('attribute_changeprice[new][0][' . $attributes_changeprice[$i]->id . '][option]', '', CHtml::listData($attributes_changeprice[$i]->getAttributeOption(), 'index_key', 'value'), array('empty' => '-- Lựa chọn --', 'class' => '', 'style' => 'width:90%;')); ?>
                            </div>                            
                            <div class="col-sm-2 att-pro-price-plus">
                                <?php echo CHtml::textField('attribute_changeprice[new][0][' . $attributes_changeprice[$i]->id . '][price]', '', array('maxlength' => 15, 'style' => 'width:90%;')); ?>
                            </div>                            
                            <span class="col-sm-1 help-inline action">
                                <i class="addattri icon-plus"></i>   
                                <i class="removeattri icon-minus"></i>
                            </span>                        
                        </div>
                    <?php } else { ?>
                        <?php foreach ($att_changeprice_value[$attributes_changeprice[$i]->id] as $key => $value) { ?>
                            <div id="<?php echo $value->id; ?>" class="control-group form-group changeprice-row changepriceupdate">        
                                <div class="col-sm-2">
                                    <?php echo CHtml::dropDownList('attribute_changeprice[update]['.$key.'][' . $attributes_changeprice[$i]->id . '][option]', $value->option_id, CHtml::listData($attributes_changeprice[$i]->getAttributeOption(), 'index_key', 'value'), array('empty' => '-- Lựa chọn --', 'class' => '', 'style' => 'width:90%;')); ?>
                                </div>                            
                                <div class="col-sm-2 att-pro-price-plus">
                                    <?php echo CHtml::textField('attribute_changeprice[update]['.$key.'][' . $attributes_changeprice[$i]->id . '][price]', $value->change_price, array('maxlength' => 15, 'style' => 'width:90%;')); ?>
                                </div>                            
                                <span class="col-sm-1 help-inline action">
                                    <i class="addattri icon-plus"></i>   
                                    <i class="removeattri icon-minus"></i>
                                </span>                             
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div> 
    </div>
</div>