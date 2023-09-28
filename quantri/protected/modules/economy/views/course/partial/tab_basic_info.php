<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
$arr = array('' => Yii::t('category', 'category_parent_0'));
$option_category = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
$option_lecturer = Lecturer::getOptionLecturer();
?>
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
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'cat_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'cat_id', $option_category, array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'cat_id'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'lecturer_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <a href="javascript:void(0)" class="btn btn-xs" onclick="add_lecturer(this)" style="margin-bottom: 10px">Thêm
            giáo viên</a>
    </div>
</div>
<div class="form-group no-margin-left">
    <div class="col-sm-2"></div>
    <div class="controls col-sm-10" id="choselecturer">
        <div>
            <?php if (isset($model->lecturer_id) && count($model->lecturer_id)) { ?>
                <?php foreach ($model->lecturer_id as $key => $lecturer_id) { ?>
                    <div>
                        <div class="form-group col-xs-9">
                            <?php echo $form->dropDownList($model, "lecturer_id[$key]", $option_lecturer, array('class' => 'span10 col-xs-12')); ?>
                            <?php echo $form->error($model, 'lecturer_id'); ?>
                        </div>
                        <div class="form-group col-xs-3">
                            <a href="javascript:void(0)" class="btn btn-xs btn-danger"
                               onclick="removeFrom(this)">Xóa</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else {
                ?>
                <div>
                    <div class="form-group col-xs-9">
                        <?php echo $form->dropDownList($model, "lecturer_id[]", $option_lecturer, array('class' => 'span10 col-xs-12')); ?>
                        <?php echo $form->error($model, 'lecturer_id'); ?>
                    </div>
                    <div class="form-group col-xs-3">
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="removeFrom(this)">Xóa</a>
                    </div>
                </div>

                <?php
            } ?>
        </div>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'price_market', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'price_market', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'discount_percent', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'discount_percent', array('class' => 'col-sm-2')); ?>

        <?php echo $form->error($model, 'price', array(), true, false); ?>
        <?php echo $form->error($model, 'price_market', array(), true, false); ?>
        <?php echo $form->error($model, 'discount_percent', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price_member', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price_member', array('class' => 'numberFormat span2 col-sm-2')); ?>
        <?php echo $form->error($model, 'price_member', array(), true, false); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="courseavatar" style="display: block; margin-top: 0px;">
            <div id="courseavatar_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->image_path && $model->image_name) { ?>
                    <img
                            src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>"
                            style="width: 100%;"/>
                <?php } ?>
            </div>
            <div id="courseavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
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
    <?php echo $form->labelEx($model, 'time_for_study', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'time_for_study', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'time_for_study'); ?>
    </div>
</div>
<!--<div class="form-group no-margin-left">-->
<!--    --><?php //echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
<!--    <div class="controls col-sm-10">-->
<!--        --><?php //echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12')); ?>
<!--        --><?php //echo $form->error($model, 'address'); ?>
<!--    </div>-->
<!--</div>-->
<?php
$shopstores = ShopStore::getShopstoreLocation();
if (isset($shopstores) && count($shopstores)) {
    ?>
    <div class="form-group no-margin-left">
        <label class="col-sm-2 control-label no-padding-left required" for="Product_manufacturer_id">Địa điểm <br/>
            (Giữ nút CTRL + Nhấp chuột để chọn nhiều)</label>
        <div class="controls col-sm-10">
            <div class="input-group">

                <?php
                $storesTrack = trim($model->address);
                $storeTrackArray = [];
                if (isset($storesTrack) && $storesTrack) {
                    $storeTrackArray = explode(' ', $storesTrack);
                }
                ?>
                <div class="wrapper-brand">
                    <div class="fl div-menunhieu-0" currentid="0">
                        <h6>&nbsp;Chọn địa điểm&nbsp;</h6>
                        <select class="menunhieu" multiple="multiple">
                            <?php foreach ($shopstores as $store) { ?>
                                <option <?= in_array($store['id'], $storeTrackArray) ? 'selected' : '' ?>
                                        value="<?= $store['id'] ?>"><?= $store['name'] . ' - ' . $store['district_name'] . ' - ' . $store['province_name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
                <input type="hidden" id="store_ids" name="Course[address]"
                       value="<?= $model->address ?>"/>
            </div>
        </div>
    </div>
<?php } ?>
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
            $('#store_ids').val(valueString);
        });
    });
</script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'ishot', array('class' => 'span10 col-sm-1')); ?>
        <label class="col-sm-2 control-label no-padding-left"><i></i></label>
        <?php echo $form->error($model, 'number_of_students'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'allow_try', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'allow_try', array('class' => 'span10 col-sm-1')); ?>
        <label class="col-sm-2 control-label no-padding-left"><i></i></label>
        <?php echo $form->error($model, 'number_of_students'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'number_of_students', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'number_of_students', array(range(0, 200)), array('class' => 'span10 col-sm-1')); ?>
        <label class="col-sm-2 control-label no-padding-left"><i>&nbsp; (Học viên)</i></label>
        <?php echo $form->error($model, 'number_of_students'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'school_schedule', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'school_schedule', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'school_schedule'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'number_lession', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'number_lession', array(range(0, 200)), array('class' => 'span10 col-sm-1')); ?>
        <label class="col-sm-2 control-label no-padding-left"><i>&nbsp; (Buổi)</i></label>
        <?php echo $form->error($model, 'number_lession'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'preferred', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'preferred', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'preferred'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'act_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php
        echo $form->checkBoxList(
            $model, 'act_id', CHtml::listData(CourseActivities::model()->findAll('site_id=' . '(' .
            Yii::app()->controller->site_id . ')'), 'id', 'name')
        );
        ?>
        <?php echo $form->error($model, 'act_id'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <div class="controls col-sm-12">
        <div class="row">
            <?php echo $form->labelEx($model, 'course_open', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-4">
                <div class="input-group input-group-sm">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Course[course_open]', //attribute name
                        'mode' => 'date',
                        'value' => ((int)$model->course_open > 0) ? date('d-m-Y', (int)$model->course_open) : '',
                        'language' => Yii::app()->language,
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => 'HH:mm:ss',
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
                <?php echo $form->error($model, 'course_open'); ?>
            </div>
            <?php echo $form->labelEx($model, 'course_finish', array('class' => 'col-sm-2 control-label no-padding-left', 'style' => 'text-align:right;')); ?>
            <div class="controls col-sm-4">
                <div class="input-group input-group-sm">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Course[course_finish]', //attribute name</div>
                        'mode' => 'date',
                        'value' => ((int)$model->course_finish > 0) ? date('d-m-Y', (int)$model->course_finish) : '',
                        'language' => Yii::app()->language,
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => 'HH:mm:ss',
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
                <?php echo $form->error($model, 'course_finish'); ?>
            </div>
        </div>

    </div>

</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'order', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'order'); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#courseavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/course/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Course_avatar').val(obj.data.avatar);
                        if (jQuery('#courseavatar_img img').attr('src')) {
                            jQuery('#courseavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#courseavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#courseavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });

    function add_lecturer(ev) {
        var form_ltr = <?php echo json_encode('<div class=""><div class="form-group col-xs-9">' . $form->dropDownList($model, "lecturer_id[]", $option_lecturer, array("class" => "span10 col-xs-12")) . '</div><div class="form-group col-xs-3"><a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="removeFrom(this)">Xóa</a></div></div>'); ?>;

        $('#choselecturer > div').append(form_ltr);
    }

    function removeFrom(ev) {
        $(ev).parent().parent().remove();
    }

</script>