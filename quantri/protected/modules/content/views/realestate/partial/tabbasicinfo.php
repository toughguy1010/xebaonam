<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12',)); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div> 


<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'span10 col-sm-12',)); ?>
        <?php echo $form->error($model, 'province_id'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span10 col-sm-12',)); ?>
        <?php echo $form->error($model, 'district_id'); ?>
    </div>
</div> 
<div class="control-group form-group">
    <?php echo $form->label($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'span10 col-sm-12', 'placeholder' => Yii::t('common', 'address'))); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>  
</div>
<div class="control-group form-group">
    <?php echo $form->label($model, 'investor', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'investor', array('class' => 'span10 col-sm-12', 'placeholder' => Yii::t('common', 'investor'))); ?>
        <?php echo $form->error($model, 'investor'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->label($model, 'time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'time', array('class' => 'span10 col-sm-12', 'placeholder' => Yii::t('common', 'investor'))); ?>
        <?php echo $form->error($model, 'time'); ?>
    </div>
</div>

<div class="control-group form-group">

    <?php echo $form->labelEx($model, 'price_range', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price_range', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'price_range'); ?>
    </div>
</div>
<div class="control-group form-group">

    <?php echo $form->labelEx($model, 'area', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'area', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'area'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'news_category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'news_category_id', $news_category, array('class' => 'span10 col-sm-12',)); ?>
        <?php echo $form->error($model, 'news_category_id'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'ishot'); ?>
        <?php echo $form->error($model, 'ishot'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'real_estate_cat_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'real_estate_cat_id', $realestateCategory, array('class' => 'span10 col-sm-12',)); ?>
        <?php echo $form->error($model, 'real_estate_cat_id'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="RealEstateravatar" style="display: block; margin-top: 0px;">
            <div id="RealEstateavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->image_path && $model->image_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="RealEstateavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'sort_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'sort_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'sort_description'); ?>
    </div>
</div>