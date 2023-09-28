<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'province_id'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'district_id'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'ward_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'ward_id', $listward, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'ward_id'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="categoryavatar" style="display: block; margin-top: 0px;">
            <div id="categoryavatar_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                    <img
                        src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>"
                        style="width: 100%;"/>
                <?php } ?>
            </div>
            <div id="categoryavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'hotline', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'hotline', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'hotline'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'order', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'order'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'email', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'iframe_map', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'iframe_map', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'iframe_map'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'hours', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'hours', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'hours'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'level', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'level', ShopStore::listLevel(), array('class' => 'span10 col-sm-12', 'prompt' => '----')); ?>
        <?php echo $form->error($model, 'level'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'group', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
    </div>
    <div class="controls col-sm-10">
        <!--        --><?php //echo $form->textField($model, 'group'); ?>
        <!--        --><?php //echo $form->error($model, 'group'); ?>
        <!--    </div>-->
        <!--    <div class="control-group form-group">-->
        <!--        --><?php //echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <!--        <div class="controls col-sm-10">-->
        <?php echo $form->dropDownList($model, 'group', Shopstore::listGroup(), array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'group'); ?>
    </div>
</div>
