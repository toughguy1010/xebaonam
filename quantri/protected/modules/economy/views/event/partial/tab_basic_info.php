<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/bootstrap-timepicker.css");

$arr = array('' => Yii::t('category', 'category_parent_0'));
$option_category = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/date-time/bootstrap-timepicker.min.js"></script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<?php // if (!$model->isNewRecord) { ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'alias'); ?>
    </div>
</div>
<?php // } ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'category_id', $option_category, array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'category_id'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <div class="controls col-sm-12">
        <div class="row">
            <?php echo $form->labelEx($model, 'event_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>

            <div class="controls col-sm-3">
                <div class="input-group input-group-sm bootstrap-timepicker">
                    <?php echo $form->textField($model, 'event_time', array('class' => 'span10 col-sm-12', 'id' => 'event_time')); ?>
                    <span class="input-group-addon">
                        <i class="icon-time bigger-110"></i>
                    </span>
                </div>
                <?php echo $form->error($model, 'event_time'); ?>
                <script>
                    $(document).ready(function () {
                        $('#event_time').timepicker({
                            minuteStep: 1,
                            showSeconds: false,
                            showMeridian: false
                        }).next().on(ace.click_event, function () {
                            $(this).prev().focus();
                        });
                    })
                </script>
            </div>
            <?php echo $form->labelEx($model, 'start_date', array('class' => 'col-sm-2 control-label no-padding-left', 'style' => 'text-align:right;')); ?>
            <div class="controls col-sm-3">
                <div class="input-group input-group-sm">
                    <?php
                    $date = DateTime::createFromFormat('Y-m-d', $model->start_date);

                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Event[start_date]', //attribute name
                        'mode' => 'date',
                        'value' => ($date) ? ($date->format('d/m/Y')) : '',
                        'language' => Yii::app()->language,
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd/mm/yy',
                            'timeFormat' => '',
                            'controlType' => 'select',
                            //'showOn' => 'button',
                            'tabularLevel' => null,
                            'addSliderAccess' => true,
                            'sliderAccessArgs' => array('touchonly' => false),
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'form-control',
                        )
                    ));
                    ?>
                    <span class="input-group-addon">
                        <i class="icon-calendar"></i>
                    </span>
                </div>
                <?php echo $form->error($model, 'start_date'); ?>
            </div>
        </div>
    </div>

</div>
<div class="form-group no-margin-left">
    <div class="controls col-sm-12">
        <div class="row">
            <?php echo $form->labelEx($model, 'event_stop_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-3">
                <div class="input-group input-group-sm bootstrap-timepicker">
                    <?php echo $form->textField($model, 'event_stop_time', array('class' => 'span10 col-sm-12', 'id' => 'event_stop_time')); ?>
                    <span class="input-group-addon">
                                            <i class="icon-time bigger-110"></i>
                                        </span>
                </div>
                <?php echo $form->error($model, 'event_stop_time'); ?>
                <script>
                    $(document).ready(function () {
                        $('#event_stop_time').timepicker({
                            minuteStep: 1,
                            showSeconds: false,
                            showMeridian: false
                        }).next().on(ace.click_event, function () {
                            $(this).prev().focus();
                        });
                    })
                </script>
            </div>
            <?php echo $form->labelEx($model, 'end_date', array('class' => 'col-sm-2 control-label no-padding-left', 'style' => 'text-align:right;')); ?>
            <div class="controls col-sm-3">
                <div class="input-group input-group-sm">
                    <?php
                    $date = DateTime::createFromFormat('Y-m-d', $model->end_date);
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Event[end_date]', //attribute name
                        'mode' => 'date',
                        'value' => ($date) ? ($date->format('d/m/Y')) : '',
                        'language' => Yii::app()->language,
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd/mm/yy',
                            'timeFormat' => '',
                            'controlType' => 'select',
                            //'showOn' => 'button',
                            'tabularLevel' => null,
                            'addSliderAccess' => true,
                            'sliderAccessArgs' => array('touchonly' => false),
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'form-control',
                        )
                    ));
                    ?>
                    <span class="input-group-addon">
                        <i class="icon-calendar"></i>
                    </span>
                </div>
                <?php echo $form->error($model, 'end_date'); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'price_market', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'price_market', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'price', array(), true, false); ?>
        <?php echo $form->error($model, 'price_market', array(), true, false); ?>
    </div>
</div>


<div class=" form-group no-margin-left">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="eventavatar" style="display: block; margin-top: 0px;">
            <div id="eventavatar_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->image_path && $model->image_name) { ?>
                    <img
                        src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>"
                        style="width: 100%;"/>
                <?php } ?>
            </div>
            <div id="eventavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>
<div class=" form-group no-margin-left">
    <?php echo $form->labelEx($model, 'cover_image', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'cover_image', array('class' => 'span12 col-sm-12')); ?>
        <div id="eventcover" style="display: block; margin-top: 0px;">
            <div id="eventcover_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->cover_image) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->cover_path && $model->cover_name) { ?>
                    <img
                        src="<?php echo ClaHost::getImageHost() . $model->cover_path . 's100_100/' . $model->cover_name; ?>"
                        style="width: 100%;"/>
                <?php } ?>
            </div>
            <div id="eventcover_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'cover_image'); ?>
    </div>
</div>


<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'ishot'); ?>
        <?php echo $form->error($model, 'ishot'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'isprivate', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'isprivate'); ?>
        <?php echo $form->error($model, 'isprivate'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'order', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'order'); ?>
    </div>
</div>

<?php if (isset($model->location) && count($locations) > 0) { ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'location', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->hiddenField($model, 'location', array('class' => 'span12 col-sm-12')); ?>
            <?php
            $shop_store_arr = array();
            if (isset($model->location) && $model->location) {
                $shop_store_arr = explode(',', $model->location);
            }

            if (isset($locations) && $locations != null) {
                foreach ($locations as $key=> $location) {
                    ?>
                    <input class="checkStore" type="checkbox"
                           name="checkStore[]" <?php echo (in_array($key, $shop_store_arr)) ? (' checked="checked" ') : '' ?>
                           value="<?php echo $key; ?>"><span class="lbl" style="padding:0px 5px 4px 5px; color: #333; font-size: 12px;"><?php echo $location; ?></span>
                    <br>
                    <?php
                }
            }
            ?>
        </div>
        <script>
            $(document).ready(function () {
                $('input.checkStore').on('click', function () {
                    var checkedValues = $('input.checkStore:checkbox:checked').map(function () {
                        return this.value;
                    }).get().join(',');
                    $('input#Event_location').val(checkedValues);
                });
            })

        </script>
    </div>
<?php } ?>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'address', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#eventavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/event/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Event_avatar').val(obj.data.avatar);
                        if (jQuery('#eventavatar_img img').attr('src')) {
                            jQuery('#eventavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#eventavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#eventavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        jQuery('#eventcover_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/event/uploadCoverImgfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Event_cover_image').val(obj.data.cover_image);
                        if (jQuery('#eventcover_img img').attr('src')) {
                            jQuery('#eventcover_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#eventcover_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#eventcover_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>