<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        CKEDITOR.replace("Popups_popup_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="control-group form-group">
    <?php echo $form->label($model, 'popup_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'popup_name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'popup_name'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'popup_size', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div class="col-sm-6" style="padding-right: 20px; padding-left: 0px;">
            <?php echo $form->textField($model, 'popup_width', array('placeholder' => $model->getAttributeLabel('popup_width'), 'class' => 'col-sm-12')); ?>
        </div>
        <?php echo $form->textField($model, 'popup_height', array('placeholder' => $model->getAttributeLabel('popup_height'), 'class' => 'span12 col-sm-6')); ?>
        <?php echo $form->error($model, 'popup_width'); ?>
        <?php echo $form->error($model, 'popup_height'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->label($model, 'popup_order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'popup_order', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'popup_order'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->label($model, 'popup_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'popup_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'popup_description'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'popup_config', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownlist($model, 'popup_config', Popups::getConfigArr(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'popup_config'); ?>
    </div>
</div>
<!--<div class="control-group form-group">-->
<!--    --><?php //echo $form->labelEx($model, 'store_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
<!--    <div class="controls col-sm-6">-->
<!--        --><?php //echo $form->textField($model, 'store_time', array('placeholder' => $model->getAttributeLabel('store_time'),'class' => 'span12 col-sm-12')); ?>
<!--        --><?php //echo $form->error($model, 'store_time'); ?>
<!--    </div>-->
<!--</div>-->
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'store_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div class="col-sm-3" style="padding-right: 20px; padding-left: 0px;">
            <?php echo $form->textField($model, 'store_time', array('placeholder' => $model->getAttributeLabel('store_time'), 'class' => 'col-sm-12')); ?>
        </div>
        <div class="col-sm-3" style="padding-right: 20px; padding-left: 0px;">
        <?php echo $form->dropDownlist($model, 'store_time_type', Popups::getTimeType(), array('class' => 'span12 col-sm-3')); ?>
        </div>
        <?php echo $form->error($model, 'store_time'); ?>
        <?php echo $form->error($model, 'store_time_type'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'delay_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div class="col-sm-3" style="padding-right: 20px; padding-left: 0px;">
            <?php echo $form->textField($model, 'delay_time', array('class' => 'span12 col-sm-12')); ?>
            <?php echo $form->error($model, 'delay_time'); ?>
        </div>
        <div class="col-sm-3">
            <p class="col-sm-1 control-label no-padding-left" style="text-align:left;" for="Popups_end_time">Giây</p>
        </div>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'show', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <label>
            <?php echo $form->checkBox($model, 'actived', array('class' => 'ace ace-switch ace-switch-6')); ?>
            <span class="lbl"></span>
        </label>
    </div>
</div>
<div class="control-group form-group ">
    <?php echo $form->labelEx($model, 'start_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-4">
        <?php
        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
            'model' => $model, //Model object
            'name' => 'Popups[start_time]', //attribute name
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
            'value' => ((int)$model->start_time > 0) ? date('d-m-Y H:i:s', (int)$model->start_time) : '',
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
        <?php echo $form->error($model, 'start_time'); ?>
    </div>

    <?php echo $form->labelEx($model, 'end_time', array('class' => 'col-sm-2 control-label no-padding-left', 'style' => 'text-align:right;')); ?>
    <div class="controls col-sm-4">
        <?php
        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
            'model' => $model, //Model object
            'name' => 'Popups[end_time]', //attribute name
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
            'value' => ((int)$model->end_time > 0) ? date('d-m-Y H:i:s', (int)$model->end_time) : '',
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
        <?php echo $form->error($model, 'end_time'); ?>
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
                <div class="checkbox col-md-3 col-sm-6 col-xs-12" style="padding-top: 0">
                    <label>
                        <input <?php echo in_array($s['id'], $stores) ? 'checked' : '' ?> type="checkbox"
                                                                                          name="Banners[store_ids][]"
                                                                                          value="<?php echo $s['id'] ?>"> <?php echo $s['name'] ?>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}
?>

<div class="control-group form-group">
    <?php echo CHtml::label('Trang hiển thị', '', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <p>Bạn muốn hiện thị popup này tại trang nào thì check box vào trang đó. Mặc định là tất cả trang</p>
        <div class="listcheck">
            <?php
            $checkall = ($model->isNewRecord && !$model->popup_rules || $model->popup_showall) ? true : false;
            if (!$checkall) {
                $rules = explode(',', $model->popup_rules);
            }
            //
            $pages = Banners::getPageKeyArr();
            $pages = array(Banners::BANNER_SHOWALL_KEY . '' => Yii::t('common', 'all')) + $pages;

            foreach ($pages as $key => $label) {
                $checked = false;
                if (!$checkall) {
                    if (in_array(Banners::getRealPageKey($key), $rules)) {
                        $checked = true;
                    }
                }
                ?>
                <label class="labelcheckpage">
                    <input <?php echo ($checkall || $checked) ? 'checked="checked"' : '' ?> type="checkbox"
                                                                                            value="<?php echo $key; ?>"
                                                                                            class="checkpage"
                                                                                            name="checkpage[]"> <?php echo $label; ?>
                </label>
            <?php } ?>
        </div>
    </div>
</div>
<!--Popup_popup_config-->
<script>
    //    jQuery('#Popup_popup_config').on('change', function() {
    //        var size = $(this).find('option:selected').attr('value');
    //        if (size) {
    //            var sizer = size.split('_');
    //            if (sizer[0])
    //                jQuery('#Banners_banner_width').val(sizer[0]);
    //            if (sizer[1])
    //                jQuery('#Banners_banner_height').val(sizer[1]);
    //        }
    //    });
</script>