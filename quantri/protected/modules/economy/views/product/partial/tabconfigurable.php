<?php
    $count_cf = count($attributes_cf);
    $count_cf = ($count_cf<=2)?$count_cf:2;
    $att_cf_value = ProductConfigurableValue::model()->findAll('product_id=:product_id',array(':product_id'=>$model->id));    
?>
<?php $this->renderPartial('script/configurablescript',array('attributes_cf'=>$attributes_cf,'count_cf'=>$count_cf));?>
<div id="product-attributes-cf">
    <div class="control-group form-group group-header">        
    <?php for($i=0;$i<$count_cf;$i++){?>
        <input type="hidden" name="attribute_cf[att][attribute<?php echo $attributes_cf[$i]->field_configurable;?>_id]" value="<?php echo $attributes_cf[$i]->id;?>"/>
        <span class="col-sm-2 control-label"><?php echo $attributes_cf[$i]->name;?></span>        
    <?php }?>
        <span class="col-sm-2 control-label">Giá (VNĐ)</span>
        <span class="col-sm-4 control-label">Ảnh</span>        
    </div>
    <?php if(empty($att_cf_value)){?>
        <div class="control-group form-group cf-row">        
            <?php for($i=0;$i<$count_cf;$i++){?>        
            <div class="col-sm-2">
                <?php echo CHtml::dropDownList('attribute_cf[new][0]['.$attributes_cf[$i]->field_configurable.']', '', CHtml::listData($attributes_cf[$i]->getAttributeOption(),'index_key','value'), array('empty'=>'-- Lựa chọn --','class'=>'','style'=>'width:90%;'));?>
            </div>
            <?php }?>
            <div class="col-sm-2 att-pro-price">
                <?php echo CHtml::textField('attribute_cf[new][0][4]', '', array('maxlength'=>15,'style'=>'width:90%;'));?>
            </div>
            <div class="col-sm-4 att-pro-images"></div>
            <span class="col-sm-1 help-inline action">
                <i class="addattri icon-plus"></i>
                <i class="removeattri icon-minus"></i>
            </span>
        </div>
    <?php }else{?>
        <?php foreach ($att_cf_value as $key=>$value){?>
            <div id="<?php echo $value->id;?>" class="control-group form-group cf-row cfupdate">        
                <?php foreach($attributes_cf as $att){?>        
                    <div class="col-sm-2">
                        <?php $key_v = ($att->field_configurable>0)?'attribute'.$att->field_configurable.'_value':'';?>
                        <?php echo CHtml::dropDownList('attribute_cf[update]['.$value->id.']['.$att->field_configurable.']',($key_v)?$value->$key_v:'', CHtml::listData($att->getAttributeOption(),'index_key','value'), array('empty'=>'-- Lựa chọn --','class'=>'','style'=>'width:90%;'));?>
                    </div>
                <?php }?>
                <div class="col-sm-2 att-pro-price">
                    <?php echo CHtml::textField('attribute_cf[update]['.$value->id.'][4]', (int)$value->price, array('maxlength'=>15,'style'=>'width:90%;'));?>
                </div>
                <div class="col-sm-4 att-pro-images"></div>
                <span class="col-sm-1 help-inline action">
                    <i class="addattri icon-plus"></i>
                    <i class="removeattri icon-minus"></i>
                </span>
            </div>
        <?php }?>
    <?php }?>
</div>