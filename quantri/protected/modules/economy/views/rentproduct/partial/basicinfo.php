<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<?php // if (!$model->isNewRecord) {  ?>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'alias', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'alias'); ?>
    </div>
</div>
<?php // }  ?>


<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'destination_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div class="input-group">
            <?php echo $form->dropDownList($model, 'destination_id', Destinations::getOptionsDestinations(), array('class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'destination_id'); ?>
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
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="rentproductavatar" style="display: block; margin-top: 10px;">
            <div id="rentproductavatar_img"
                 style="position: relative; display: inline-block; max-width: 150px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                     <?php if ($model->image_path && $model->image_name) { ?>
                    <img
                        src="<?php echo ClaHost::getImageHost() . $model->image_path . 's150_150/' . $model->image_name; ?>"
                        style="width: 100%;"/>
                    <?php } ?>
            </div>
            <div id="rentproductavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
            <?php if ($model->image_path && $model->image_name) { ?>
                <div style="margin-top: 15px;">
                    <button type="button" onclick="removeAvatar(<?= $model->id ?>)"
                            class="btn btn-danger btn-xs">Delete avatar
                    </button>
                </div>
            <?php } ?>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'language', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'language', array('class' => 'span12 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="rentproductlanguage" style="display: block; margin-top: 10px;">
            <div id="rentproductlanguage_img"
                 style="position: relative; display: inline-block; max-width: 150px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->language) echo 'margin-right: 10px;'; ?>">
                     <?php if ($model->language_path && $model->language_name) { ?>
                    <img
                        src="<?php echo ClaHost::getImageHost() . $model->language_path . 's150_150/' . $model->language_name; ?>"
                        style="width: 100%;"/>
                    <?php } ?>
            </div>
            <div id="rentproductlanguage_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('rent', 'btn_select_language'), array('class' => 'btn  btn-sm')); ?>
            </div>
            <?php if ($model->language_path && $model->language_name) { ?>
                <div style="margin-top: 15px;">
                    <button type="button" onclick="removeLanguage(<?= $model->id ?>)"
                            class="btn btn-danger btn-xs">Delete language
                    </button>
                </div>
            <?php } ?>
        </div>
        <?php echo $form->error($model, 'language'); ?>
    </div>
</div>
<!--                        <div class="control-group form-group">-->
<!--                            --><?php //echo $form->labelEx($model, 'poster', array('class' => 'col-sm-2 control-label no-padding-left'));   ?>
<!--                            <div class="controls col-sm-10">-->
<!--                                --><?php //echo $form->textField($model, 'poster', array('class' => 'span12 col-sm-12'));   ?>
<!--                                --><?php //echo $form->error($model, 'poster');   ?>
<!--                            </div>-->
<!--                        </div>-->
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'publicdate', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
            'model' => $model, //Model object
            'name' => 'News[publicdate]', //attribute name
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
            'value' => ((int) $model->publicdate > 0) ? date('d-m-Y H:i:s', (int) $model->publicdate) : date('d-m-Y H:i:s'),
            'language' => 'vi',
            'options' => array(
                'showSecond' => true,
                'dateFormat' => 'dd-mm-yy',
                'timeFormat' => 'HH:mm:ss',
                'controlType' => 'select',
                'stepHour' => 1,
                'stepMinute' => 1,
                'stepSecond' => 1,
                //'showOn' => 'button',
                'showSecond' => true,
                'changeMonth' => true,
                'changeYear' => false,
                'tabularLevel' => null,
            //'addSliderAccess' => true,
            //'sliderAccessArgs' => array('touchonly' => false),
            ), // jquery plugin options
            'htmlOptions' => array(
                'class' => 'span12 col-sm-12',
            )
        ));
        ?>
        <?php echo $form->error($model, 'publicdate'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArrayNews(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<?php
$shop_store = ShopStore::getAllShopstore();
if (count($shop_store)) {
    ?>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'store_ids', array('class' => 'col-sm-2 control-label no-padding-left')) ?>
        <?php
        $stores = explode(' ', $model->store_ids);
        ?>
        <div class="controls col-sm-10">
            <?php foreach ($shop_store as $s) { ?>
                <div class="checkbox">
                    <label>
                        <input <?php echo in_array($s['id'], $stores) ? 'checked' : '' ?>
                            type="checkbox"
                            name="RentProduct[store_ids][]"
                            value="<?php echo $s['id'] ?>"> <?php echo $s['name'] ?>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}
?>
<!--                        <div class="control-group form-group">-->
<!--                            --><?php //echo $form->labelEx($model, 'video_links', array('class' => 'col-sm-2 control-label no-padding-left'));   ?>
<!--                            <div class="controls col-sm-9" id="add_video">-->
<!--                                <span style="color: blue;font-size: 12px">Link nhúng video của youtube. Chỉ chấp nhận link "https://www.youtube.com/embed/..."</span>-->
<!--                                --><?php //if (isset($model->video_links) && count($model->video_links) > 0 && $model->video_links) {   ?>
<!--                                    --><?php //foreach ($model->video_links as $key => $video_link) {   ?>
<!--                                        <div class="row -->
<?php //echo 'link' . $key ?><!--">-->
<!--                                            <div class="col-sm-10">-->
<!--                                                <input class="span12 col-sm-12 " value="-->
<?php //echo $video_link ?><!--"-->
<!--                                                       style="padding-top: 4px; margin-bottom: 4px;"-->
<!--                                                       name="RentProduct[video_links][]"-->
<!--                                                       id="RentProduct_video_links"-->
<!--                                                       type="text">-->
<!--                                            </div>-->
<!--                                            <div class="col-sm-2">-->
<!--                                                <a href="javascript:void(0)" class="new_video"-->
<!--                                                   style="padding-top: 4px; margin-bottom: 4px;color: blue"-->
<!--                                                   onclick="remove_video(this)"-->
<!--                                                   data-id="-->
<?php //echo 'link' . $key ?><!--">Xóa</a>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    --><?php //}   ?>
<!--                                --><?php //}   ?>
<!--                            </div>-->
<!--                            <div class="controls col-sm-1">-->
<!--                                <a href="javascript:void(0)" class="new_video"-->
<!--                                   style="padding-top: 4px; margin-bottom: 4px;color: blue"-->
<!--                                   onclick="add_video(this)"> Thêm </a>-->
<!--                            </div>-->
<!--                        </div>-->
<script>
    function add_video() {
        $('#add_video').append('<input class="span12 col-sm-12" style="margin-top: 10px" name="RentProduct[video_links][]" id="RentProduct_video_links" type="text">')
    }
    function remove_video(ev) {
        var key = $(ev).attr('data-id');
        $('.' + key).remove();
        $(ev).remove();
    }
</script>