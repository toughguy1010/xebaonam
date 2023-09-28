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
<?php if (!$model->isNewRecord) { ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
            <?php echo $form->error($model, 'alias'); ?>
        </div>
    </div>
<?php } ?>
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
        <?php echo $form->dropDownList($model, 'lecturer_id', $option_lecturer, array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'lecturer_id'); ?>
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

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="courseavatar" style="display: block; margin-top: 0px;">
            <div id="courseavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->image_path && $model->image_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
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
    <div class="controls col-sm-12">
        <div class="row">
            <div class="controls col-sm-6">
                <?php echo $form->labelEx($model, 'course_open', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="input-group input-group-sm">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Course[course_open]', //attribute name
                        'mode' => 'date',
                        'value' => ((int) $model->course_open > 0 ) ? date('d-m-Y', (int) $model->course_open) : '',
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
            <div class="controls col-sm-6">
                <?php echo $form->labelEx($model, 'course_finish', array('class' => 'col-sm-3 control-label no-padding-left', 'style' => 'text-align:right;')); ?>
                <div class="input-group input-group-sm">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Course[course_finish]', //attribute name
                        'mode' => 'date',
                        'value' => ((int) $model->course_finish > 0 ) ? date('d-m-Y', (int) $model->course_finish) : '',
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
</script>