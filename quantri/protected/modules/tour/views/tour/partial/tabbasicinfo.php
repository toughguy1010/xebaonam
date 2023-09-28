<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
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
<?php //if ($model->isNewRecord) { ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'file_src', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->hiddenField($model, 'file_src', array('class' => 'span12 col-sm-12')); ?>
            <div class="row" style="margin: 10px 0px;">
                <?php echo CHtml::fileField('file_src', ''); ?>
            </div>
            <?php echo $form->error($model, 'file_src'); ?>
        </div>
    </div>
<?php //} ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'tour_category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div class="input-group">
            <?php echo $form->dropDownList($model, 'tour_category_id', $option, array('class' => 'form-control')); ?>
            <div class="input-group-btn" style="padding-left: 10px;">  
<!--                <a href="--><?php //echo Yii::app()->createUrl('tour/tourcategories/addcat', array('pa' => ClaCategory::CATEGORY_ROOT) + $_GET) ?><!--" id="addCate" class="btn btn-primary btn-sm" style="line-height: 14px;">-->
<!--                    --><?php //echo Yii::t('category', 'category_add'); ?>
<!--                </a>-->
            </div>
        </div>
        <?php echo $form->error($model, 'tour_category_id'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'trip_map', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'trip_map', array('class' => 'span9 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="tripmap" style="display: block; margin-top: 10px;">
            <div id="tripmap_img" style="display: inline-block; max-width: 100px; overflow: hidden; vertical-align: top; <?php if ($model->trip_map) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->trip_map) { ?>
                    <img src="<?php echo $model->trip_map; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="tripmap_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('tour', 'btn_trip_map'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'trip_map'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'destination_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'destination_id', $options_destinations, array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'destination_id'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'partner_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'partner_id', $options_partners, array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'partner_id'); ?>
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
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'isnew', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">                            
        <?php echo $form->checkBox($model, 'isnew'); ?>
        <?php echo $form->error($model, 'isnew'); ?>
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
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <label class="col-sm-2 control-label no-padding-left required" for="Product_manufacturer_id">Chọn kiểu tour <br/>
        (Giữ nút CTRL + Nhấp chuột để chọn nhiều)</label>
    <div class="controls col-sm-10">
        <div class="input-group">
            <?php
            $tourstyle = TourStyle::getStyles();
            ?>
            <?php
            $tourstyleTrack = trim($model->tour_style_id);
            $tourstyleTrackArray = [];
            if (isset($tourstyleTrack) && $tourstyleTrack) {
                $tourstyleTrackArray = explode(' ', $tourstyleTrack);
            }
            ?>
            <div class="wrapper-brand">
                <div class="fl div-menunhieu-0" currentid="0">
                    <select class="menunhieu" multiple="multiple">
                        <?php foreach ($tourstyle as $manu) { ?>
                            <option <?= in_array($manu['id'], $tourstyleTrackArray) ? 'selected' : '' ?>
                                    value="<?= $manu['id'] ?>"><?= $manu['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <input type="hidden" id="tourstyle_ids" name="Tour[tour_style_id]"
                   value="<?= $model->tour_style_id ?>"/>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $(".wrapper-brand").on("click", ".menunhieu option", function () {
            var idsExist = [];
            $('.menunhieu').each(function () {
                var id = $(this).val();
                idsExist.push(id);
            });
            if (idsExist.length) {
                var valueString = '';
                for (var i in idsExist) {
                    for (var j in idsExist[i]) {
                        if (valueString != '') {
                            valueString += ' ';
                        }
                        valueString += idsExist[i][j];
                    }
                }
            }
            $('#tourstyle_ids').val(valueString);
        });

    });
</script>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'position', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'position', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'position'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'departure_date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'departure_date', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'departure_date'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'time', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'time'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'departure_at', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'departure_at', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'departure_at'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'destination', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'destination', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'destination'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'transport', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'transport', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'transport'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'contact_phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'contact_phone', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'contact_phone'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'starting_date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
            'model' => $model, //Model object
            'name' => 'Tour[starting_date]', //attribute name
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
            'value' => ((int) $model->starting_date > 0) ? date('d-m-Y H:i:s', (int) $model->starting_date) : date('d-m-Y H:i:s'),
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
        <?php echo $form->error($model, 'starting_date'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'code', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'code', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'number', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'number', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'number'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'hotel_star', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'hotel_star', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'hotel_star'); ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#tripmap_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/tour/tour/uploadtripmap"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Tour_trip_map').val(obj.data.realurl);
                        if (jQuery('#tripmap_img img').attr('src')) {
                            jQuery('#tripmap_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#tripmap_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#tripmap_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });
</script>